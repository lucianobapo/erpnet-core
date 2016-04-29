<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 02/03/16
 * Time: 01:37
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\RepositoryLayer\ProductSharedStatRepositoryInterface;

/**
 * Class ProductSharedStatRepositoryDoctrine
 * @package namespace ErpNET\App\Models\Doctrine\Repositories;
 */
class ProductSharedStatRepositoryDoctrine extends BaseEntityRepository implements ProductSharedStatRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
//        'mandante',
//        'grupo',
//        'created_at',
//        'updated_at',
    ];

}