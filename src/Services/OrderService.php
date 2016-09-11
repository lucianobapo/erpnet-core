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
    protected $objectData;

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
            $this->objectData = json_decode($data);

            $orderRecord = $this->processOrder();

            $sharedStatRecord = $this->prcessStatus($orderRecord);

            $this->processSharedOrder($orderRecord);

            $sharedCurrencyRecord = $this->processSharedCurrency($orderRecord);

            $this->processSharedOrderPayment($orderRecord);

            $partnerRecord = $this->processPartner($orderRecord, $sharedStatRecord);

            $this->processUser($partnerRecord);

            $this->processContact('email', $partnerRecord);
            $this->processContact('telefone', $partnerRecord);
            $this->processContact('whatsapp', $partnerRecord);

            $this->processAddress($partnerRecord, $orderRecord);

            $this->processItems($sharedCurrencyRecord, $orderRecord);

            $addedOrder = $this->orderRepository->find($orderRecord->id);

            $jsonFields = [
                'error' => false,
                'message' => 'Ordem nº ' . $addedOrder->id . ' criada.',
                'id' => $addedOrder->id,
                'posted_at' => $addedOrder->posted_at,
                'valor_total' => $addedOrder->valor_total,
            ];

            $return = json_encode($jsonFields);

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

    /**
     * @param $partnerRecord
     * @param $orderRecord
     * @throws \Exception
     */
    private function processAddress($partnerRecord, $orderRecord)
    {
        $addressRecord = null;
        if (property_exists($this->objectData, 'address_id')) {
            $addressRecord = $this->addressRepository->find($this->objectData->address_id);
            if (is_null($addressRecord)) {
                $addressFields = [];

                $this->tryAssignOrThrow('mandante', $addressFields);
                $this->tryAssign('cep', $addressFields);
                $this->tryAssign(['endereco','logradouro'], $addressFields);
                $this->tryAssign('bairro', $addressFields);
                $this->tryAssign('numero', $addressFields);
//                if (property_exists($this->objectData, 'cep')) $data1['cep'] = $this->objectData->cep;
//                if (property_exists($this->objectData, 'endereco')) $data1['logradouro'] = $this->objectData->endereco;
//                    else throw new \Exception('Error address is blank');
//                if (property_exists($this->objectData, 'bairro')) $data1['bairro'] = $this->objectData->bairro;
//                if (property_exists($this->objectData, 'numero')) $data1['numero'] = $this->objectData->numero;
                $addressRecord = $this->addressRepository->create($addressFields);
            }
            if (is_null($addressRecord)) throw new \Exception('Error with address_id: ' . $this->objectData->address_id);
        }

        $this->addressRepository->addPartnerToAddress($partnerRecord, $addressRecord);
        $this->orderRepository->addAddressToOrder($addressRecord, $orderRecord);
    }

    /**
     * @param $orderRecord
     * @param $sharedStatRecord
     * @return null
     */
    private function processPartner($orderRecord, $sharedStatRecord)
    {
        $partnerRecord = null;
        if (property_exists($this->objectData, 'partner_id'))
            $partnerRecord = $this->partnerRepository->find($this->objectData->partner_id);

        if (is_null($partnerRecord)) {
            $partnerFields = [];

            $this->tryAssignOrThrow('mandante', $partnerFields);
            $this->tryAssign('nome', $partnerFields);
            $this->tryAssign(['name', 'nome'], $partnerFields);

            if (property_exists($this->objectData, 'data_nascimento')) {
                if (is_string($this->objectData->data_nascimento))
                    $partnerFields['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $this->objectData->data_nascimento);
                if ($this->objectData->data_nascimento instanceof \DateTime)
                    $partnerFields['data_nascimento'] = Carbon::instance($this->objectData->data_nascimento);
            }

            $partnerRecord = $this->partnerRepository->create($partnerFields);
        }

        $this->orderRepository->addPartnerToOrder($partnerRecord, $orderRecord);

        $this->partnerRepository->addPartnerToStat($partnerRecord, $sharedStatRecord);

        $partnerGroupRecord = $this->partnerGroupRepository->firstOrCreate([
            'grupo' => 'Cliente',
        ]);

        $this->partnerRepository->addPartnerToGroup($partnerRecord, $partnerGroupRecord);

        return $partnerRecord;
    }

    /**
     * @param $field
     * @param $fields
     * @throws \Exception
     */
    private function tryAssignOrThrow($field, &$fields)
    {
        if (is_string($field)){
            if (property_exists($this->objectData, $field)) $fields[$field] = $this->objectData->$field;
            else throw new \Exception('Error '.$field.' missing on tryAssign()');
        }
        elseif (is_array($field) && count($field)==2){

            if (property_exists($this->objectData, $field[0])) {
                $objectField = $field[0];
                $fields[$field[1]] = $this->objectData->$objectField;
            }
            else throw new \Exception('Error '.$field[0].' missing on tryAssign()');

        }
        else throw new \Exception('Error tryAssign()');
    }

    /**
     * @param $field
     * @param $fields
     * @throws \Exception
     */
    private function tryAssign($field, &$fields)
    {
        if (is_string($field)){
            if (property_exists($this->objectData, $field)) $fields[$field] = $this->objectData->$field;
        }elseif (is_array($field) && count($field)==2){
            if (property_exists($this->objectData, $field[0])) {
                $objectField = $field[0];
                $fields[$field[1]] = $this->objectData->$objectField;
            }
        }else throw new \Exception('Error tryAssign()');
    }

    /**
     * @return mixed
     */
    private function processOrder()
    {
        $orderFields = [
            'posted_at' => Carbon::now(),
        ];

        $this->tryAssignOrThrow('mandante', $orderFields);

        $this->tryAssign('observacao', $orderFields);

        $orderRecord = $this->orderRepository->create($orderFields);

        return $orderRecord;
    }

    /**
     * @param $orderRecord
     */
    private function prcessStatus($orderRecord)
    {
        $sharedStatRecord = $this->sharedStatRepository->firstOrCreate([
            'status' => 'aberto',
        ]);
        $this->orderRepository->addOrderToStat($orderRecord, $sharedStatRecord);

        if (property_exists($this->objectData, 'origem')) {
            $sharedStatRecordOrigem = $this->sharedStatRepository->firstOrCreate([
                'status' => $this->objectData->origem,
            ]);
            $this->orderRepository->addOrderToStat($orderRecord, $sharedStatRecordOrigem);
        }

        return $sharedStatRecord;
    }

    /**
     * @param $orderRecord
     */
    private function processSharedOrder($orderRecord)
    {
        $sharedOrderTypeRecord = $this->sharedOrderTypeRepository->firstOrCreate([
            'tipo' => 'ordemVenda',
        ]);
        $this->orderRepository->addSharedOrderTypeToOrder($sharedOrderTypeRecord, $orderRecord);
    }

    /**
     * @param $orderRecord
     */
    private function processSharedCurrency($orderRecord)
    {
        $sharedCurrencyRecord = $this->sharedCurrencyRepository->firstOrCreate([
            'nome_universal' => 'BRL',
        ]);
        $this->orderRepository->addSharedCurrencyToOrder($sharedCurrencyRecord, $orderRecord);

        return $sharedCurrencyRecord;
    }

    /**
     * @param $orderRecord
     */
    private function processSharedOrderPayment($orderRecord)
    {
        $sharedOrderPaymentRecord = $this->sharedOrderPaymentRepository->firstOrCreate([
            'pagamento' => $this->objectData->pagamento,
        ]);
        $this->orderRepository->addSharedOrderPaymentToOrder($sharedOrderPaymentRecord, $orderRecord);
    }

    /**
     * @param $partnerRecord
     */
    private function processUser($partnerRecord)
    {
        $userRecord = null;
        // Encontra usuário já criado
        if (property_exists($this->objectData, 'user_id'))
            $userRecord = $this->userRepository->find($this->objectData->user_id);

        // Cria usuário com dados do Facebook
        if (property_exists($this->objectData, 'user_provider_id') && is_null($userRecord)) {
            $userFields = [
//                'mandante' => $this->objectData->mandante,
//                'name' => $this->objectData->name,
//                'avatar' => $this->objectData->picture,
//                'email' => $this->objectData->userEmail,
                'provider' => 'facebook',
//                'provider_id' => $this->objectData->user_provider_id,
            ];

            $this->tryAssignOrThrow('mandante', $userFields);
            $this->tryAssign('name', $userFields);
            $this->tryAssign(['picture', 'avatar'], $userFields);
            $this->tryAssign(['userEmail', 'email'], $userFields);
            $this->tryAssign(['user_provider_id', 'provider_id'], $userFields);

            $userRecord = $this->userRepository->create($userFields);
        }

        // Associa o usuário ao partner caso nao sejam associados
        if (!is_null($userRecord) && ($userRecord != $partnerRecord->user))
            $this->partnerRepository->addUserToPartner($userRecord, $partnerRecord);
    }

    /**
     * @param string $field
     * @param $partnerRecord
     */
    private function processContact($field, $partnerRecord)
    {

        if (property_exists($this->objectData, $field)) {
            $contactFields = [
                'contact_type' => $field,
            ];

            $this->tryAssignOrThrow('mandante', $contactFields);
            $this->tryAssignOrThrow([$field, 'contact_data'], $contactFields);

            $contactRecord = $this->contactRepository->create($contactFields);

            $this->contactRepository->addPartnerToContact($partnerRecord, $contactRecord);
        }

    }

    /**
     * @param $sharedCurrencyRecord
     * @param $orderRecord
     */
    private function processItems($sharedCurrencyRecord, $orderRecord)
    {
        if (property_exists($this->objectData, 'itens') && is_array($this->objectData->itens) && count($this->objectData->itens)>0){
            foreach ($this->objectData->itens as $item) {
                if (!is_object($item)) throw new \Exception('Error item not object on processItems()');

                $itemOrderFields = [
                    'quantidade' => $item->quantidade,
                    'valor_unitario' => $item->valor,
                ];

                $this->tryAssignOrThrow('mandante', $itemOrderFields);

                $itemOrderRecord = $this->itemOrderRepository->create($itemOrderFields);

                $productRecord = $this->productRepository->findOneOrFail([
                    'id' => $item->id,
                ]);

                $this->itemOrderRepository->addProductToItem($productRecord, $itemOrderRecord);
                $this->itemOrderRepository->addCostAllocateToItem($productRecord->costAllocate, $itemOrderRecord);
                $this->itemOrderRepository->addSharedCurrencyToItem($sharedCurrencyRecord, $itemOrderRecord);

                $this->orderRepository->addOrderToItem($orderRecord, $itemOrderRecord);
            }
        }
        else throw new \Exception('Error items invalid on processItems()');
    }
}