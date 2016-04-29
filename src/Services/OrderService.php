<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 01:56
 */

namespace ErpNET\App\Services;


use ErpNET\App\Interfaces\OrderServiceInterface;
use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;

class OrderService implements OrderServiceInterface
{
    protected $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
//        CostAllocateRepositoryInterface $costAllocateRepository,
//        Carbon $carbon
    )
    {
        $this->orderRepository = $orderRepository;
//        $this->costAllocateRepository = $costAllocateRepository;
//        $this->carbon = $carbon;
    }

    public function createOrderWithJson($data)
    {
        return $this->orderRepository;

        // TODO: Implement createOrderWithJson() method.
    }
}