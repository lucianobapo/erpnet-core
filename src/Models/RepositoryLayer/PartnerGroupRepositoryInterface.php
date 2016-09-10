<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 03:58
 */

namespace ErpNET\App\Models\RepositoryLayer;

/**
 * Interface PartnerGroupRepositoryInterface
 * @package namespace ErpNET\App\Models\RepositoryLayer;
 */
interface PartnerGroupRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param int $id
     * @return \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner
     */
//    public function userFindProviderId($id);

    /**
     * @param \ErpNET\App\Models\Eloquent\User | \ErpNET\App\Models\Doctrine\Entities\User $user
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     */
//    public function addUserToPartner($user, $partner);

    /**
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     * @param \ErpNET\App\Models\Eloquent\SharedStat | \ErpNET\App\Models\Doctrine\Entities\SharedStat $sharedStat
     */
//    public function addPartnerToStat($partner, $sharedStat);
}