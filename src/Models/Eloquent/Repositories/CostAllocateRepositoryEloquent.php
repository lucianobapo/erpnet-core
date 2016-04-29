<?php

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\CostAllocate;
use ErpNET\App\Models\RepositoryLayer\CostAllocateRepositoryInterface;

/**
 * Class OrderRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class CostAllocateRepositoryEloquent extends AbstractRepository implements CostAllocateRepositoryInterface
{
    public function __construct(CostAllocate $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

    public function collectionCostAllocate(){
        return $this->model
            ->orderBy('numero')
            ->get();
    }
}
