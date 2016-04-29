<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 04:25
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\Partner;
use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;

class PartnerRepositoryEloquent extends AbstractRepository implements PartnerRepositoryInterface
{
    public function __construct(Partner $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

}