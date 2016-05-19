<?php

namespace ErpNET\App\Models\Doctrine\Repositories;

use Doctrine\ORM\Query;
use ErpNET\App\Models\RepositoryLayer\ContactRepositoryInterface;

/**
 * Class ContactRepositoryDoctrine
 * @package namespace ErpNET\App\Models\Doctrine\Repositories;
 */
class ContactRepositoryDoctrine extends BaseEntityRepository implements ContactRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'mandante',
        'contact_type',
        'contact_data',
    ];

    /**
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     * @param \ErpNET\App\Models\Eloquent\Contact | \ErpNET\App\Models\Doctrine\Entities\Contact $contact
     */
    public function addPartnerToContact($partner, $contact)
    {
        $contact->setPartner($partner);

        $this->_em->persist($contact);
        $this->_em->flush();
    }
}
