<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 24/04/16
 * Time: 04:20
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\ItemOrder;
use ErpNET\App\Models\RepositoryLayer\ItemOrderRepositoryInterface;

/**
 * Class ItemOrderRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class ItemOrderRepositoryEloquent extends AbstractRepository implements ItemOrderRepositoryInterface
{
    public function __construct(ItemOrder $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\Product | \ErpNET\App\Models\Doctrine\Entities\Product $product
     * @param \ErpNET\App\Models\Eloquent\ItemOrder | \ErpNET\App\Models\Doctrine\Entities\ItemOrder $itemOrder
     */
    public function addProductToItem($product, $itemOrder)
    {
        $itemOrder->product()->associate($product);
        $itemOrder->save();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\CostAllocate | \ErpNET\App\Models\Doctrine\Entities\CostAllocate $costAllocate
     * @param \ErpNET\App\Models\Eloquent\ItemOrder | \ErpNET\App\Models\Doctrine\Entities\ItemOrder $itemOrder
     */
    public function addCostAllocateToItem($costAllocate, $itemOrder)
    {
        $itemOrder->cost()->associate($costAllocate);
        $itemOrder->save();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\SharedCurrency | \ErpNET\App\Models\Doctrine\Entities\SharedCurrency $sharedCurrency
     * @param \ErpNET\App\Models\Eloquent\ItemOrder | \ErpNET\App\Models\Doctrine\Entities\ItemOrder $itemOrder
     */
    public function addSharedCurrencyToItem($sharedCurrency, $itemOrder)
    {
        $itemOrder->currency()->associate($sharedCurrency);
        $itemOrder->save();
    }
}