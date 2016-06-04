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
use ErpNET\App\Models\RepositoryLayer\ItemOrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\AddressRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ContactRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedOrderPaymentRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedOrderTypeRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedCurrencyRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\UserRepositoryInterface;

class OrderService implements OrderServiceInterface
{
    protected $userRepository;
    protected $partnerRepository;
    protected $productRepository;
    protected $orderRepository;
    protected $itemOrderRepository;
    protected $sharedOrderPaymentRepository;
    protected $sharedOrderTypeRepository;
    protected $sharedCurrencyRepository;
    protected $sharedStatRepository;
    protected $addressRepository;
    protected $contactRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PartnerRepositoryInterface $partnerRepository,
        ProductRepositoryInterface $productRepository,
        OrderRepositoryInterface $orderRepository,
        ItemOrderRepositoryInterface $itemOrderRepository,
        SharedOrderPaymentRepositoryInterface $sharedOrderPaymentRepository,
        SharedOrderTypeRepositoryInterface $sharedOrderTypeRepository,
        SharedCurrencyRepositoryInterface $sharedCurrencyRepository,
        SharedStatRepositoryInterface $sharedStatRepository,
        AddressRepositoryInterface $addressRepository,
        ContactRepositoryInterface $contactRepository
//        CostAllocateRepositoryInterface $costAllocateRepository,
//        Carbon $carbon
    )
    {
        $this->userRepository = $userRepository;
        $this->partnerRepository = $partnerRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->itemOrderRepository = $itemOrderRepository;
        $this->sharedOrderPaymentRepository = $sharedOrderPaymentRepository;
        $this->sharedOrderTypeRepository = $sharedOrderTypeRepository;
        $this->sharedCurrencyRepository = $sharedCurrencyRepository;
        $this->sharedStatRepository = $sharedStatRepository;
        $this->addressRepository = $addressRepository;
        $this->contactRepository = $contactRepository;
//        $this->costAllocateRepository = $costAllocateRepository;
//        $this->carbon = $carbon;
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
                    'nome' => $objectData->nome,
                ];
                if (property_exists($objectData, 'data_nascimento')) $fields['data_nascimento'] = Carbon::createFromFormat('d/m/Y',$objectData->data_nascimento);
                $partnerRecord = $this->partnerRepository->create($fields);
            }
            $this->orderRepository->addPartnerToOrder($partnerRecord, $orderRecord);

            if (property_exists($objectData, 'user_provider_id')) {
                $userRecord = null;
                $userRecord = $this->userRepository->findOneBy(['provider_id'=>$objectData->user_provider_id]);
                if (is_null($userRecord)){

                    $fields = [
                        'mandante' => $objectData->mandante,
                        'name' => $objectData->nome,
                        'avatar' => $objectData->picture,
                        'email' => $objectData->email,
                        'provider' => 'facebook',
                        'provider_id' => $objectData->user_id,
                    ];
                    logger('Criar Usuário: ');
                    logger($fields);
                    $userRecord = $this->userRepository->create($fields);
                    $this->partnerRepository->addUserToPartner($userRecord, $partnerRecord);
                } else {
                    logger('Usuário user: ');
                    logger($userRecord);
                    logger('Usuário partner: ');
                    logger($partnerRecord->user);
//                    if ($userRecord->id == $partnerRecord->user->id) {
//
//                    }
                }
            }


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
                    $addressRecord = $this->addressRepository->create([
                        'mandante' => $objectData->mandante,
                        'cep' => $objectData->cep,
                        'logradouro' => $objectData->endereco,
                        'bairro' => $objectData->bairro,
                        'numero' => $objectData->numero,
                    ]);
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
}