<?php

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;
use ErpNET\App\Models\Eloquent\Order;

/**
 * Class OrderRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class OrderRepositoryEloquent extends AbstractRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

    public function collectionOrdersItemsCosts()
    {
        return $this->model
            ->select('orders.*')
            ->join('order_shared_stat', 'orders.id', '=', 'order_shared_stat.order_id')
            ->join('shared_stats', 'order_shared_stat.shared_stat_id', '=', 'shared_stats.id')
            ->where('shared_stats.status', '=', 'finalizado')
            ->with('orderItems','orderItems.cost')
//            ->toSql();
            ->get();
//        dd($return);
    }

    public function addOrderToItem($order, $itemOrder)
    {
        $itemOrder->order()->associate($order);
        $itemOrder->save();

        if (empty($order->valor_total))
            $order->valor_total = $itemOrder->quantidade * $itemOrder->valor_unitario;
        else
            $order->valor_total = $order->valor_total + ($itemOrder->quantidade * $itemOrder->valor_unitario);
        $order->save();
    }

    /**
     * @param \ErpNET\App\Models\Doctrine\Entities\Address|\ErpNET\App\Models\Eloquent\Address $address
     * @param \ErpNET\App\Models\Doctrine\Entities\Order|Order $order
     */
    public function addAddressToOrder($address, $order)
    {
        $order->address()->associate($address);
        $order->save();
    }

    /**
     * @param \ErpNET\App\Models\Doctrine\Entities\Partner|\ErpNET\App\Models\Eloquent\Partner $partner
     * @param \ErpNET\App\Models\Doctrine\Entities\Order|Order $order
     */
    public function addPartnerToOrder($partner, $order)
    {
        $order->partner()->associate($partner);
        $order->save();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\SharedOrderPayment | \ErpNET\App\Models\Doctrine\Entities\SharedOrderPayment $sharedOrderPayment
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addSharedOrderPaymentToOrder($sharedOrderPayment, $order)
    {
        $order->sharedOrderPayment()->associate($sharedOrderPayment);
        $order->save();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\SharedOrderType | \ErpNET\App\Models\Doctrine\Entities\SharedOrderType $sharedOrderType
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addSharedOrderTypeToOrder($sharedOrderType, $order)
    {
        $order->sharedOrderType()->associate($sharedOrderType);
        $order->save();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     * @param \ErpNET\App\Models\Eloquent\SharedStat | \ErpNET\App\Models\Doctrine\Entities\SharedStat $sharedStat
     */
    public function addOrderToStat($order, $sharedStat)
    {
        $this->model->status()->attach($sharedStat->id, ['order_id'=>$order->id]);
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\SharedCurrency | \ErpNET\App\Models\Doctrine\Entities\SharedCurrency $sharedCurrency
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addSharedCurrencyToOrder($sharedCurrency, $order)
    {
        $order->currency()->associate($sharedCurrency);
        $order->save();
    }
}
