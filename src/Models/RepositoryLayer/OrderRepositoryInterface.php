<?php

namespace ErpNET\App\Models\RepositoryLayer;

/**
 * Interface OrderRepositoryInterface
 * @package namespace App\ModelLayer\Repositories;
 */
interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function collectionOrdersItemsCosts();
}
