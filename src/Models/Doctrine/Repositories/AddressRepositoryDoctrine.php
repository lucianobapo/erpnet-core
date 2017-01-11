<?php

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\RepositoryLayer\AddressRepositoryInterface;
use Doctrine\ORM\Query;

/**
 * Class AddressRepositoryDoctrine
 * @package namespace ErpNET\App\Models\Doctrine\Repositories;
 */
class AddressRepositoryDoctrine extends BaseEntityRepository implements AddressRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'mandante',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'complemento',
    ];

    /**
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     * @param \ErpNET\App\Models\Eloquent\Address | \ErpNET\App\Models\Doctrine\Entities\Address $address
     */
    public function addPartnerToAddress($partner, $address)
    {
        $address->setPartner($partner);

        $this->_em->persist($address);
        $this->_em->flush();
    }
}
