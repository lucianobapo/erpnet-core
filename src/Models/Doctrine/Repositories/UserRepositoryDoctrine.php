<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 23:37
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\RepositoryLayer\UserRepositoryInterface;

class UserRepositoryDoctrine extends BaseEntityRepository implements UserRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'mandante',
        'name',
        'email',
        'provider',
        'provider_id',
    ];
}