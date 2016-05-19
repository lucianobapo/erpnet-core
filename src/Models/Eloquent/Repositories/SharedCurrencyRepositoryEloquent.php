<?php

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\SharedCurrency;
use ErpNET\App\Models\RepositoryLayer\SharedCurrencyRepositoryInterface;

/**
 * Class SharedCurrencyRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class SharedCurrencyRepositoryEloquent extends AbstractRepository implements SharedCurrencyRepositoryInterface
{
    public function __construct(SharedCurrency $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }
}
