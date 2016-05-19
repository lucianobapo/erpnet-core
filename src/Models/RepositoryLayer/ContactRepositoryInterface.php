<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 05/05/16
 * Time: 04:16
 */

namespace ErpNET\App\Models\RepositoryLayer;

/**
 * Interface ContactRepositoryInterface
 * @package namespace ErpNET\App\Models\RepositoryLayer;
 */
interface ContactRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     * @param \ErpNET\App\Models\Eloquent\Contact | \ErpNET\App\Models\Doctrine\Entities\Contact $contact
     */
    public function addPartnerToContact($partner, $contact);
}