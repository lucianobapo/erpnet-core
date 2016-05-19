<?php

namespace ErpNET\App\Models\RepositoryLayer;

/**
 * Interface OrderRepositoryInterface
 * @package namespace App\ModelLayer\Repositories;
 */
interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param $order
     * @param $itemOrder
     * @return void
     */
    public function addOrderToItem($order, $itemOrder);

    /**
     * @param \ErpNET\App\Models\Eloquent\SharedOrderPayment | \ErpNET\App\Models\Doctrine\Entities\SharedOrderPayment $sharedOrderPayment
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addSharedOrderPaymentToOrder($sharedOrderPayment, $order);

    /**
     * @param \ErpNET\App\Models\Eloquent\SharedOrderType | \ErpNET\App\Models\Doctrine\Entities\SharedOrderType $sharedOrderType
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addSharedOrderTypeToOrder($sharedOrderType, $order);

    /**
     * @param \ErpNET\App\Models\Eloquent\SharedCurrency | \ErpNET\App\Models\Doctrine\Entities\SharedCurrency $sharedCurrency
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addSharedCurrencyToOrder($sharedCurrency, $order);

    /**
     * @param \ErpNET\App\Models\Eloquent\Address | \ErpNET\App\Models\Doctrine\Entities\Address $address
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addAddressToOrder($address, $order);

    /**
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addPartnerToOrder($partner, $order);

    /**
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     * @param \ErpNET\App\Models\Eloquent\SharedStat | \ErpNET\App\Models\Doctrine\Entities\SharedStat $sharedStat
     */
    public function addOrderToStat($order, $sharedStat);

    /**
     * @return mixed
     */
    public function collectionOrdersItemsCosts();
}
