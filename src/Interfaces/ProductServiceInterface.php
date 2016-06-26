<?php

namespace ErpNET\App\Interfaces;

/**
 * Interface ProductServiceInterface
 * @package namespace ErpNET\App\Interfaces;
 */
interface ProductServiceInterface
{
    /**
     * @return string
     */
    public function collectionProductsDelivery($categ = null, $begin=null, $end=null);
}
