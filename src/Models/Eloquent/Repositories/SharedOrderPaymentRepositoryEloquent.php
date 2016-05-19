<?php

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\SharedOrderPayment;
use ErpNET\App\Models\RepositoryLayer\SharedOrderPaymentRepositoryInterface;

/**
 * Class SharedOrderPaymentRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class SharedOrderPaymentRepositoryEloquent extends AbstractRepository implements SharedOrderPaymentRepositoryInterface
{
    public function __construct(SharedOrderPayment $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }
}
