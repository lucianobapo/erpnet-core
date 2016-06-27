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
use ErpNET\App\Interfaces\ProductServiceInterface;
use ErpNET\App\Models\RepositoryLayer\ProductProductGroupRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductSharedStatRepositoryInterface;
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
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class ProductService implements ProductServiceInterface
{

    protected $orderService;
//    protected $summaryRepository;
//    protected $productSharedStatRepository;
    protected $productProductGroupRepository;
    protected $productRepository;
//    protected $partnerRepository;
//    protected $userRepository;
//    protected $orderRepository;
//    protected $itemOrderRepository;
//    protected $sharedOrderPaymentRepository;
//    protected $sharedOrderTypeRepository;
//    protected $sharedCurrencyRepository;
//    protected $sharedStatRepository;
//    protected $addressRepository;
//    protected $contactRepository;

    public function __construct(
        OrderServiceInterface $orderService,
//        SummaryRepositoryInterface $summaryRepository,
//        ProductSharedStatRepositoryInterface $productSharedStatRepository,
        ProductProductGroupRepositoryInterface $productProductGroupRepository,
        ProductRepositoryInterface $productRepository
//        PartnerRepositoryInterface $partnerRepository,
//        UserRepositoryInterface $userRepository,
//        OrderRepositoryInterface $orderRepository
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
        $this->orderService = $orderService;
//        $this->summaryRepository = $summaryRepository;
//        $this->productSharedStatRepository = $productSharedStatRepository;
        $this->productProductGroupRepository = $productProductGroupRepository;
        $this->productRepository = $productRepository;
//        $this->partnerRepository = $partnerRepository;
//        $this->userRepository = $userRepository;
//        $this->orderRepository = $orderRepository;
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
     * @return string
     */
    public function collectionProductsDelivery($categ = null, $begin=null, $end=null)
    {
        $activatedProducts = $this->productRepository->activatedProducts($begin, $end);
        $filtredActivatedProducts = [];

        foreach ($activatedProducts as $product) {
            $isDelivery = false;
            $isCategory = false;
            foreach ($product->productProductGroups as $productProductGroup) {
                if (is_null($productProductGroup->productGroup)) $productGroup = $productProductGroup;
                else $productGroup = $productProductGroup->productGroup;
                if ($productGroup->grupo=="Delivery") $isDelivery = true;
                if (!is_null($categ) && ((int)$categ)>0 && $productGroup->id==$categ) $isCategory = true;
            }
            if (!is_null($categ) && ((int)$categ)>0){
                if ($isDelivery && $isCategory)
                    $filtredActivatedProducts[] = $product;
            }elseif ($isDelivery)
                $filtredActivatedProducts[] = $product;
        }

        $fractal = new Manager();
        $resource = new Collection($filtredActivatedProducts, function($item) {
            if (isset($this->orderService->itemStock[$item->id]))
                $stock = $this->orderService->itemStock[$item->id];
            else
                $stock = 0;
            $valor = (($item->promocao && $item->valorUnitVendaPromocao > 0) ? $item->valorUnitVendaPromocao : $item->valorUnitVenda);

            return [
                'id'   => $item->id,
                'nome'   => $item->nome,
                'imagem'   => $item->imagem,
                'max' => $stock>=0?$stock:0,
                'valor'   => $valor,
            ];
        });
        return $fractal->createData($resource)->toJson();
    }
}