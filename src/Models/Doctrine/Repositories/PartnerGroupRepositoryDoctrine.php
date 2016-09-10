<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 23:37
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\RepositoryLayer\PartnerGroupRepositoryInterface;

class PartnerGroupRepositoryDoctrine extends BaseEntityRepository implements PartnerGroupRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'mandante',
        'grupo',
    ];
}