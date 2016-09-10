<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 01:56
 */

namespace ErpNET\App\Services;

use Carbon\Carbon;
use ErpNET\App\Interfaces\OrderServiceInterface;
use ErpNET\App\Interfaces\SummaryServiceInterface;
use ErpNET\App\Models\Doctrine\Entities\EntityBase;
use ErpNET\App\Models\RepositoryLayer\ItemOrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderSharedStatRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\PartnerGroupRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\AddressRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ContactRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedOrderPaymentRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedOrderTypeRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedCurrencyRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SummaryRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OrderService implements OrderServiceInterface
{
    protected $summaryService;
    protected $userRepository;
    protected $partnerRepository;
    protected $partnerGroupRepository;
    protected $productRepository;
    protected $orderRepository;
    protected $itemOrderRepository;
    protected $sharedOrderPaymentRepository;
    protected $sharedOrderTypeRepository;
    protected $sharedCurrencyRepository;
    protected $sharedStatRepository;
    protected $addressRepository;
    protected $contactRepository;
    protected $summaryRepository;

    public $itemStock;

    public function __construct(
        SummaryServiceInterface $summaryService,
        UserRepositoryInterface $userRepository,
        PartnerRepositoryInterface $partnerRepository,
        PartnerGroupRepositoryInterface $partnerGroupRepository,
        ProductRepositoryInterface $productRepository,
        OrderRepositoryInterface $orderRepository,
        ItemOrderRepositoryInterface $itemOrderRepository,
        SharedOrderPaymentRepositoryInterface $sharedOrderPaymentRepository,
        SharedOrderTypeRepositoryInterface $sharedOrderTypeRepository,
        SharedCurrencyRepositoryInterface $sharedCurrencyRepository,
        SharedStatRepositoryInterface $sharedStatRepository,
        AddressRepositoryInterface $addressRepository,
        ContactRepositoryInterface $contactRepository,
        SummaryRepositoryInterface $summaryRepository
//        CostAllocateRepositoryInterface $costAllocateRepository,
//        Carbon $carbon
    )
    {
        $this->summaryService = $summaryService;
        $this->userRepository = $userRepository;
        $this->partnerRepository = $partnerRepository;
        $this->partnerGroupRepository = $partnerGroupRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->itemOrderRepository = $itemOrderRepository;
        $this->sharedOrderPaymentRepository = $sharedOrderPaymentRepository;
        $this->sharedOrderTypeRepository = $sharedOrderTypeRepository;
        $this->sharedCurrencyRepository = $sharedCurrencyRepository;
        $this->sharedStatRepository = $sharedStatRepository;
        $this->addressRepository = $addressRepository;
        $this->contactRepository = $contactRepository;
        $this->summaryRepository = $summaryRepository;
//        $this->costAllocateRepository = $costAllocateRepository;
//        $this->carbon = $carbon;

        $this->itemStock = $this->resumoDasOrdens();
    }

    /**
     * @param string $data
     * @return string
     */
    public function createDeliverySalesOrderWithJson($data)
    {
        try{
            $objectData = json_decode($data);

            $orderFields = [
                'mandante' => $objectData->mandante,
                'posted_at' => Carbon::now(),
            ];
            if (property_exists($objectData, 'observacao')) $orderFields['observacao'] = $objectData->observacao;
            $orderRecord = $this->orderRepository->create($orderFields);

            $sharedStatRecord = $this->sharedStatRepository->firstOrCreate([
                'status' => 'aberto',
            ]);
            $this->orderRepository->addOrderToStat($orderRecord, $sharedStatRecord);

            if (property_exists($objectData, 'origem')) {
                $sharedStatRecordOrigem = $this->sharedStatRepository->firstOrCreate([
                    'status' => $objectData->origem,
                ]);
                $this->orderRepository->addOrderToStat($orderRecord, $sharedStatRecordOrigem);
            }

            $sharedOrderTypeRecord = $this->sharedOrderTypeRepository->firstOrCreate([
                'tipo' => 'ordemVenda',
            ]);
            $this->orderRepository->addSharedOrderTypeToOrder($sharedOrderTypeRecord, $orderRecord);

            $sharedCurrencyRecord = $this->sharedCurrencyRepository->firstOrCreate([
                'nome_universal' => 'BRL',
            ]);
            $this->orderRepository->addSharedCurrencyToOrder($sharedCurrencyRecord, $orderRecord);

            $sharedOrderPaymentRecord = $this->sharedOrderPaymentRepository->firstOrCreate([
                'pagamento' => $objectData->pagamento,
            ]);
            $this->orderRepository->addSharedOrderPaymentToOrder($sharedOrderPaymentRecord, $orderRecord);

            $partnerRecord = null;
            if (property_exists($objectData, 'partner_id')) $partnerRecord = $this->partnerRepository->find($objectData->partner_id);
            if (is_null($partnerRecord)){
                $fields = [
                    'mandante' => $objectData->mandante,
//                    'nome' => $objectData->nome,
                ];

                if (property_exists($objectData, 'nome')) $fields['nome'] = $objectData->nome;
                if (property_exists($objectData, 'name')) $fields['nome'] = $objectData->name;

                if (property_exists($objectData, 'data_nascimento')){
                    if (is_string($objectData->data_nascimento))
                        $fields['data_nascimento'] = Carbon::createFromFormat('d/m/Y',$objectData->data_nascimento);
                    if ($objectData->data_nascimento instanceof \DateTime)
                        $fields['data_nascimento'] = Carbon::instance($objectData->data_nascimento);
                }

                $partnerRecord = $this->partnerRepository->create($fields);
            }
            $this->orderRepository->addPartnerToOrder($partnerRecord, $orderRecord);

            $this->partnerRepository->addPartnerToStat($partnerRecord, $sharedStatRecord);

//            $partnerGroupRecord = $this->partnerGroupRepository->firstOrCreate([
//                'grupo' => 'Cliente',
//            ]);


            $userRecord = null;
            // Encontra usuário já criado
            if (property_exists($objectData, 'user_id'))
                $userRecord = $this->userRepository->find($objectData->user_id);

            // Cria usuário com dados do Facebook
            if (property_exists($objectData, 'user_provider_id') && is_null($userRecord)) {
                $fields = [
                    'mandante' => $objectData->mandante,
                    'name' => $objectData->name,
                    'avatar' => $objectData->picture,
                    'email' => $objectData->userEmail,
                    'provider' => 'facebook',
                    'provider_id' => $objectData->user_provider_id,
                ];
                $userRecord = $this->userRepository->create($fields);
            }

            // Associa o usuário ao partner caso nao sejam associados
            if (!is_null($userRecord) && ($userRecord!=$partnerRecord->user))
                $this->partnerRepository->addUserToPartner($userRecord, $partnerRecord);


            if (property_exists($objectData, 'email')){
                $contactRecord = $this->contactRepository->create([
                    'mandante' => $objectData->mandante,
                    'contact_type' => 'email',
                    'contact_data' => $objectData->email,
                ]);
                $this->contactRepository->addPartnerToContact($partnerRecord, $contactRecord);
            }
            if (property_exists($objectData, 'telefone')){
                $contactRecord = $this->contactRepository->create([
                    'mandante' => $objectData->mandante,
                    'contact_type' => 'telefone',
                    'contact_data' => $objectData->telefone,
                ]);
                $this->contactRepository->addPartnerToContact($partnerRecord, $contactRecord);
            }
            if (property_exists($objectData, 'whatsapp')){
                $contactRecord = $this->contactRepository->create([
                    'mandante' => $objectData->mandante,
                    'contact_type' => 'whatsapp',
                    'contact_data' => $objectData->whatsapp,
                ]);
                $this->contactRepository->addPartnerToContact($partnerRecord, $contactRecord);
            }

            if (property_exists($objectData, 'address_id')){
                $addressRecord = $this->addressRepository->find($objectData->address_id);
                if (is_null($addressRecord)){
                    $data1 = [
                        'mandante' => $objectData->mandante,
                        'cep' => $objectData->cep,
//                        'logradouro' => $objectData->endereco,
//                        'bairro' => $objectData->bairro,
//                        'numero' => $objectData->numero,
                    ];
                    if (property_exists($objectData, 'endereco'))
                        $fields['logradouro'] = $objectData->endereco;
//                    else throw new \Exception('Error address is blank');
                    if (property_exists($objectData, 'bairro')) $fields['bairro'] = $objectData->bairro;
                    if (property_exists($objectData, 'numero')) $fields['numero'] = $objectData->numero;
                    $addressRecord = $this->addressRepository->create($data1);
                }
                if (is_null($addressRecord)) throw new \Exception('Error with address_id: '.$objectData->address_id);
            }

            $this->addressRepository->addPartnerToAddress($partnerRecord, $addressRecord);
            $this->orderRepository->addAddressToOrder($addressRecord, $orderRecord);

            foreach ($objectData->itens as $item) {
                $itemOrderRecord = $this->itemOrderRepository->create([
                    'mandante' => $objectData->mandante,
                    'quantidade' => $item->quantidade,
                    'valor_unitario' => $item->valor,
                ]);

                $productRecord = $this->productRepository->findOneOrFail([
//                    'mandante' => $objectData->mandante,
                    'id' => $item->id,
                ]);

                $this->itemOrderRepository->addProductToItem($productRecord, $itemOrderRecord);
                $this->itemOrderRepository->addCostAllocateToItem($productRecord->costAllocate, $itemOrderRecord);
                $this->itemOrderRepository->addSharedCurrencyToItem($sharedCurrencyRecord, $itemOrderRecord);

                $this->orderRepository->addOrderToItem($orderRecord, $itemOrderRecord);
            }
//
            $addedOrder = $this->orderRepository->find($orderRecord->id);
            $return = json_encode([
                'error' => false,
                'message' => 'Ordem nº '.$addedOrder->id.' criada.',
                'id' => $addedOrder->id,
                'posted_at' => $addedOrder->posted_at,
                'valor_total' => $addedOrder->valor_total,
            ]);

            return $return;
        }
        catch (\Exception $e){
            $return = json_encode([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
            return $return;
        }

    }

    protected function resumoDasOrdens(){
//        $ultimoFechamento = $this->periodRepository->getLastPeriodEndDate();
        $ultimoFechamento = $this->summaryService->lastEnd();
//        $ultimoFechamento = Carbon::now()->subMonth(1);
//        $ultimoFechamento = Carbon::now()->subWeek(3);
//        $ultimoFechamento = Carbon::now()->subDay(21);
//        $ultimasOrdens = $this->orderRepository->findBy(['posted_at'=>$ultimoFechamento]);
        $agora = Carbon::now();
//        $agora = Carbon::now()->subWeek(2);
//        $agora = Carbon::now()->subDay(20);
        $joins = [
            'itemOrders',
            'itemOrders.product',
            'orderSharedStats',
//            'orderSharedStats.sharedStat',
            'sharedOrderType',
        ];
        $ultimasOrdens = $this->orderRepository->between('posted_at', $ultimoFechamento, $agora, $joins);
//        var_dump(count($ultimasOrdens));
        $arrayOrderSummary = $this->itemStockOfOrders($ultimasOrdens);
//        var_dump(count($arrayOrderSummary));
        return $arrayOrderSummary;
//        $resumoDosPeriodos = $this->periodRepository->getPeriodSummary();
    }

    private function arrayOrderSummary($orders){

    }
    private function itemStockOfOrders($orders)
    {
        $itemStock = [];
        if (count($orders)>0)
            foreach ($orders as $order) {
    //            var_dump($order->sharedOrderType->tipo);
                $calculaOrdem = false;
                foreach ($order->orderSharedStats as $status) {
                    if (($status instanceof EntityBase) && ($status->sharedStat->status=='finalizado'))
                        $calculaOrdem = true;

                    if (($status instanceof Model) && ($status->status=='finalizado'))
                        $calculaOrdem = true;
                }
                if ($calculaOrdem)
                    foreach ($order->itemOrders as $item) {
                        if ($order->sharedOrderType->tipo=='ordemVenda'){
                            if (isset($itemStock[$item->product->id])){
                                $itemStock[$item->product->id] = $itemStock[$item->product->id] - $item->quantidade;
                            }else{
                                $itemStock[$item->product->id] = -$item->quantidade;
                            }
                        }elseif ($order->sharedOrderType->tipo=='ordemCompra'){
                            if (isset($itemStock[$item->product->id])){
                                $itemStock[$item->product->id] = $itemStock[$item->product->id] + $item->quantidade;
                            }else{
                                $itemStock[$item->product->id] = $item->quantidade;
                            }
                        }
            //                var_dump(($item->valor_unitario));
                    }
    //            var_dump(count($order->itemOrders));
            }
//        var_dump(count($orders));
//        var_dump($itemStock);
//        return [];
        ksort($itemStock);
        return $itemStock;
    }
}