<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 02/03/16
 * Time: 01:37
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\RepositoryLayer\OrderSharedStatRepositoryInterface;

/**
 * Class OrderSharedStatRepositoryDoctrine
 * @package namespace ErpNET\App\Models\Doctrine\Repositories;
 */
class OrderSharedStatRepositoryDoctrine extends BaseEntityRepository implements OrderSharedStatRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [];

}