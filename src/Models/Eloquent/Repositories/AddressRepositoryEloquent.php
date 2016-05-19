<?php

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\Address;
use ErpNET\App\Models\RepositoryLayer\AddressRepositoryInterface;

/**
 * Class AddressRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class AddressRepositoryEloquent extends AbstractRepository implements AddressRepositoryInterface
{
    public function __construct(Address $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     * @param \ErpNET\App\Models\Eloquent\Address | \ErpNET\App\Models\Doctrine\Entities\Address $address
     */
    public function addPartnerToAddress($partner, $address)
    {
        $address->partner()->associate($partner);
        $address->save();
    }
}
