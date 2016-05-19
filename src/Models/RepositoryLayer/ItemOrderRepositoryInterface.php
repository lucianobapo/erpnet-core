<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 24/04/16
 * Time: 04:06
 */

namespace ErpNET\App\Models\RepositoryLayer;

/**
 * Interface OrderRepositoryInterface
 * @package namespace App\ModelLayer\Repositories;
 */
interface ItemOrderRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param \ErpNET\App\Models\Eloquent\Product | \ErpNET\App\Models\Doctrine\Entities\Product $product
     * @param \ErpNET\App\Models\Eloquent\ItemOrder | \ErpNET\App\Models\Doctrine\Entities\ItemOrder $itemOrder
     */
    public function addProductToItem($product, $itemOrder);

    /**
     * @param \ErpNET\App\Models\Eloquent\CostAllocate | \ErpNET\App\Models\Doctrine\Entities\CostAllocate $costAllocate
     * @param \ErpNET\App\Models\Eloquent\ItemOrder | \ErpNET\App\Models\Doctrine\Entities\ItemOrder $itemOrder
     */
    public function addCostAllocateToItem($costAllocate, $itemOrder);


    /**
     * @param \ErpNET\App\Models\Eloquent\SharedCurrency | \ErpNET\App\Models\Doctrine\Entities\SharedCurrency $sharedCurrency
     * @param \ErpNET\App\Models\Eloquent\ItemOrder | \ErpNET\App\Models\Doctrine\Entities\ItemOrder $itemOrder
     */
    public function addSharedCurrencyToItem($sharedCurrency, $itemOrder);
}