<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 02/03/16
 * Time: 01:31
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\SharedStat;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;

/**
 * Class SharedStatRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class SharedStatRepositoryEloquent extends AbstractRepository implements SharedStatRepositoryInterface
{
    public function __construct(SharedStat $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }
}