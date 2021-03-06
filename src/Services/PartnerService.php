<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 01:56
 */

namespace ErpNET\App\Services;

use Carbon\Carbon;
use ErpNET\App\Interfaces\PartnerServiceInterface;
use ErpNET\App\Models\RepositoryLayer\UserRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\AddressRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ContactRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedOrderPaymentRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedOrderTypeRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedCurrencyRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;

class PartnerService implements PartnerServiceInterface
{

    protected $partnerRepository;
    protected $userRepository;
//    protected $orderRepository;
//    protected $itemOrderRepository;
//    protected $sharedOrderPaymentRepository;
//    protected $sharedOrderTypeRepository;
//    protected $sharedCurrencyRepository;
//    protected $sharedStatRepository;
    protected $addressRepository;
    protected $contactRepository;

    public function __construct(
        PartnerRepositoryInterface $partnerRepository,
        UserRepositoryInterface $userRepository,
//        OrderRepositoryInterface $orderRepository,
//        ItemOrderRepositoryInterface $itemOrderRepository,
//        SharedOrderPaymentRepositoryInterface $sharedOrderPaymentRepository,
//        SharedOrderTypeRepositoryInterface $sharedOrderTypeRepository,
//        SharedCurrencyRepositoryInterface $sharedCurrencyRepository,
//        SharedStatRepositoryInterface $sharedStatRepository,
        AddressRepositoryInterface $addressRepository,
        ContactRepositoryInterface $contactRepository
//        CostAllocateRepositoryInterface $costAllocateRepository,
//        Carbon $carbon
    )
    {
        $this->partnerRepository = $partnerRepository;
        $this->userRepository = $userRepository;
//        $this->orderRepository = $orderRepository;
//        $this->itemOrderRepository = $itemOrderRepository;
//        $this->sharedOrderPaymentRepository = $sharedOrderPaymentRepository;
//        $this->sharedOrderTypeRepository = $sharedOrderTypeRepository;
//        $this->sharedCurrencyRepository = $sharedCurrencyRepository;
//        $this->sharedStatRepository = $sharedStatRepository;
        $this->addressRepository = $addressRepository;
        $this->contactRepository = $contactRepository;
//        $this->costAllocateRepository = $costAllocateRepository;
//        $this->carbon = $carbon;
    }


    /**
     * @param int $id
     * @return \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner
     */
    public function jsonPartnerProviderId($id)
    {
        $userRecord = $this->userRepository->findOneBy(['provider_id'=>$id]);
        $partnerRecord = is_null($userRecord)?null:$this->partnerRepository->findOneBy(['user_id'=>$userRecord->id]);
        $contacts = is_null($partnerRecord)?null:$this->contactRepository->findBy(['partner_id'=>$partnerRecord->id],['id'=>'desc']);
        $addresses = is_null($partnerRecord)?null:$this->addressRepository->findBy(['partner_id'=>$partnerRecord->id],['id'=>'desc']);

        if (is_null($userRecord) || is_null($partnerRecord)) {
            return json_encode([
                'error' => true,
                'message' => 'Partner with provider_id '.$id.' not found.',
            ]);
        }else{
            $fields = [
                'error' => false,
                'mandante' => $partnerRecord->mandante,
                'user_id' => $userRecord->id,
                'partner_id' => $partnerRecord->id,
                'partner_nome' => $partnerRecord->nome,
//                'partner_data_nascimento' => Carbon::createFromTimestamp($partnerRecord->data_nascimento->timestamp)->format('d/m/Y'),
                'partner_data_nascimento' => $partnerRecord->getFormattedDataNascimento(),
                'message' => 'Partner with provider_id ' . $id . ' found.',
            ];
            foreach ($contacts as $contact) {
                $fields['partner_'.str_plural($contact->contact_type)][] = $contact->contact_data;
            }
            foreach ($addresses as $address) {
                $fields['partner_addresses'][] = [
                    'id' => $address->id,
                    'cep' => $address->cep,
                    'logradouro' => $address->logradouro,
                    'numero' => $address->numero,
                    'bairro' => $address->bairro,
                    'complemento' => $address->complemento,
                ];
            }
            return json_encode($fields);
        }
    }
}