<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 04:25
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\User;
use ErpNET\App\Models\RepositoryLayer\UserRepositoryInterface;

class UserRepositoryEloquent extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

}