<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 02/03/16
 * Time: 01:31
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\ProductSharedStat;
use ErpNET\App\Models\RepositoryLayer\ProductSharedStatRepositoryInterface;

/**
 * Class ProductSharedStatRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class ProductSharedStatRepositoryEloquent extends AbstractRepository implements ProductSharedStatRepositoryInterface
{
    public function __construct(ProductSharedStat $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

}