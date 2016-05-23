<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 03:58
 */

namespace ErpNET\App\Models\RepositoryLayer;

/**
 * Interface PartnerRepositoryInterface
 * @package namespace ErpNET\App\Models\RepositoryLayer;
 */
interface PartnerRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param int $id
     * @return \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner
     */
    public function userFindProviderId($id);

    /**
     * @param \ErpNET\App\Models\Eloquent\User | \ErpNET\App\Models\Doctrine\Entities\User $user
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     */
    public function addUserToPartner($user, $partner);
}