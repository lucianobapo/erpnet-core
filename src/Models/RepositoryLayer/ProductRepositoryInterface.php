<?php

namespace ErpNET\App\Models\RepositoryLayer;

/**
 * Interface ProductRepositoryInterface
 * @package namespace App\ModelLayer\Repositories;
 */
interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function addProductToStat($product, $stat);

    public function addProductToGroup($product, $group);

    public function collectionProducts();

    public function collectionProductsDelivery($categ = null);
}
