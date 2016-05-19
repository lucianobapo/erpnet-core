<?php

namespace ErpNET\App\Interfaces;

/**
 * Interface OrderServiceInterface
 * @package namespace ErpNET\App\Interfaces;
 */
interface OrderServiceInterface
{
    /**
     * @param string $data
     * @return string
     */
    public function createDeliverySalesOrderWithJson($data);
}
