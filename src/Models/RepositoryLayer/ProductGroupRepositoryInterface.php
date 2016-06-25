<?php

namespace ErpNET\App\Models\RepositoryLayer;

/**
 * Interface ProductGroupRepositoryInterface
 * @package namespace ErpNET\App\Models\RepositoryLayer;
 */
interface ProductGroupRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param \ErpNET\App\Models\Eloquent\ProductGroup | \ErpNET\App\Models\Doctrine\Entities\ProductGroup $productGroup
     * @param \ErpNET\App\Models\Eloquent\SharedStat | \ErpNET\App\Models\Doctrine\Entities\SharedStat $stat
     */
    public function addProductGroupToStat($productGroup, $stat);

    public function collectionProductGroups();

    public function collectionCategorias();
}
