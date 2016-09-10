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

    /**
     * @param int $id
     * @return \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner
     */
    public function userFindProviderId($id)
    {
        // TODO: Implement userFindProviderId() method.
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\User | \ErpNET\App\Models\Doctrine\Entities\User $user
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     */
    public function addUserToPartner($user, $partner)
    {
        $partner->user()->associate($user);
        $partner->save();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     * @param \ErpNET\App\Models\Eloquent\SharedStat | \ErpNET\App\Models\Doctrine\Entities\SharedStat $sharedStat
     */
    public function addPartnerToStat($partner, $sharedStat)
    {
        $this->model
            ->status()
            ->attach($sharedStat->id, ['partner_id'=>$partner->id]);
    }
}