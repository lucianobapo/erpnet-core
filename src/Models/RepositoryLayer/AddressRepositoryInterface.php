<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 05/05/16
 * Time: 04:16
 */

namespace ErpNET\App\Models\RepositoryLayer;

/**
 * Interface AddressRepositoryInterface
 * @package namespace ErpNET\App\Models\RepositoryLayer;
 */
interface AddressRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     * @param \ErpNET\App\Models\Eloquent\Address | \ErpNET\App\Models\Doctrine\Entities\Address $address
     */
    public function addPartnerToAddress($partner, $address);
}