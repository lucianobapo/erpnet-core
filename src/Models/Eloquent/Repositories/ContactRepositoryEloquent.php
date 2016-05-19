<?php

namespace ErpNET\App\Models\Eloquent\Repositories;

use ErpNET\App\Models\Eloquent\Contact;
use ErpNET\App\Models\RepositoryLayer\ContactRepositoryInterface;

/**
 * Class ContactRepositoryEloquent
 * @package namespace ErpNET\App\Models\Eloquent\Repositories;
 */
class ContactRepositoryEloquent extends AbstractRepository implements ContactRepositoryInterface
{
    public function __construct(Contact $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     * @param \ErpNET\App\Models\Eloquent\Contact | \ErpNET\App\Models\Doctrine\Entities\Contact $contact
     */
    public function addPartnerToContact($partner, $contact)
    {
        $contact->partner()->associate($partner);
        $contact->save();
    }
}
