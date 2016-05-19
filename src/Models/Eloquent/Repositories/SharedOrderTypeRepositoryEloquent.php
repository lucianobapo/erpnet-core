<?php

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\SharedOrderType;
use ErpNET\App\Models\RepositoryLayer\SharedOrderTypeRepositoryInterface;

/**
 * Class SharedOrderTypeRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class SharedOrderTypeRepositoryEloquent extends AbstractRepository implements SharedOrderTypeRepositoryInterface
{
    public function __construct(SharedOrderType $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }
}
