<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 02/03/16
 * Time: 01:31
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\ProductProductGroup;
use ErpNET\App\Models\RepositoryLayer\ProductProductGroupRepositoryInterface;

/**
 * Class ProductProductGroupRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class ProductProductGroupRepositoryEloquent extends AbstractRepository implements ProductProductGroupRepositoryInterface
{
    public function __construct(ProductProductGroup $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

}