<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 01:56
 */

namespace ErpNET\App\Services;

use Carbon\Carbon;
use ErpNET\App\Interfaces\SummaryServiceInterface;
use ErpNET\App\Models\RepositoryLayer\SummaryRepositoryInterface;
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

class SummaryService implements SummaryServiceInterface
{

    protected $summaryRepository;
//    protected $partnerRepository;
//    protected $userRepository;
    protected $orderRepository;
//    protected $itemOrderRepository;
//    protected $sharedOrderPaymentRepository;
//    protected $sharedOrderTypeRepository;
//    protected $sharedCurrencyRepository;
//    protected $sharedStatRepository;
//    protected $addressRepository;
//    protected $contactRepository;

    public function __construct(
        SummaryRepositoryInterface $summaryRepository,
//        PartnerRepositoryInterface $partnerRepository,
//        UserRepositoryInterface $userRepository,
        OrderRepositoryInterface $orderRepository
//        ItemOrderRepositoryInterface $itemOrderRepository,
//        SharedOrderPaymentRepositoryInterface $sharedOrderPaymentRepository,
//        SharedOrderTypeRepositoryInterface $sharedOrderTypeRepository,
//        SharedCurrencyRepositoryInterface $sharedCurrencyRepository,
//        SharedStatRepositoryInterface $sharedStatRepository,
//        AddressRepositoryInterface $addressRepository,
//        ContactRepositoryInterface $contactRepository
//        CostAllocateRepositoryInterface $costAllocateRepository,
//        Carbon $carbon
    )
    {
        $this->summaryRepository = $summaryRepository;
//        $this->partnerRepository = $partnerRepository;
//        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
//        $this->itemOrderRepository = $itemOrderRepository;
//        $this->sharedOrderPaymentRepository = $sharedOrderPaymentRepository;
//        $this->sharedOrderTypeRepository = $sharedOrderTypeRepository;
//        $this->sharedCurrencyRepository = $sharedCurrencyRepository;
//        $this->sharedStatRepository = $sharedStatRepository;
//        $this->addressRepository = $addressRepository;
//        $this->contactRepository = $contactRepository;
//        $this->costAllocateRepository = $costAllocateRepository;
//        $this->carbon = $carbon;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function lastEnd()
    {
        $lastEnd = $this->summaryRepository->lastSummaryEnd();
        if (is_null($lastEnd))
            $lastEnd = $this->orderRepository->firstOrderPosted();
//        var_dump($lastEnd);
        return $lastEnd;
    }
}