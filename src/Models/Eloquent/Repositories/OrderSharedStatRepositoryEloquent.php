<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 02/03/16
 * Time: 01:31
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\OrderSharedStat;
use ErpNET\App\Models\RepositoryLayer\OrderSharedStatRepositoryInterface;

/**
 * Class OrderSharedStatRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class OrderSharedStatRepositoryEloquent extends AbstractRepository implements OrderSharedStatRepositoryInterface
{
    public function __construct(OrderSharedStat $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

}