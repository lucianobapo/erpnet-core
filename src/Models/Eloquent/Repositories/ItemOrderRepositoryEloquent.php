<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 24/04/16
 * Time: 04:20
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\ItemOrder;
use ErpNET\App\Models\RepositoryLayer\ItemOrderRepositoryInterface;

/**
 * Class ItemOrderRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class ItemOrderRepositoryEloquent extends AbstractRepository implements ItemOrderRepositoryInterface
{
    public function __construct(ItemOrder $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }
}