<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 04:25
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\PartnerGroup;
use ErpNET\App\Models\RepositoryLayer\PartnerGroupRepositoryInterface;

class PartnerGroupRepositoryEloquent extends AbstractRepository implements PartnerGroupRepositoryInterface
{
    public function __construct(PartnerGroup $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }
}