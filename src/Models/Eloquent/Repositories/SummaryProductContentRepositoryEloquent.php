<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 04:25
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\SummaryProductContent;
use ErpNET\App\Models\RepositoryLayer\SummaryProductContentRepositoryInterface;

class SummaryProductContentRepositoryEloquent extends AbstractRepository implements SummaryProductContentRepositoryInterface
{
    public function __construct(SummaryProductContent $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

}