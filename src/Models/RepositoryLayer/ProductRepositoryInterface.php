<?php

namespace ErpNET\App\Models\RepositoryLayer;

/**
 * Interface ProductRepositoryInterface
 * @package namespace ErpNET\App\Models\RepositoryLayer;
 */
interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function addProductToStat($product, $stat);

    public function addProductToGroup($product, $group);

    /**
     * @param \ErpNET\App\Models\Eloquent\CostAllocate | \ErpNET\App\Models\Doctrine\Entities\CostAllocate $costAllocate
     * @param \ErpNET\App\Models\Eloquent\Product | \ErpNET\App\Models\Doctrine\Entities\Product $product
     */
    public function addCostAllocateToProduct($costAllocate, $product);

    public function collectionProducts();

    public function collectionProductsDelivery($categ = null);
}
