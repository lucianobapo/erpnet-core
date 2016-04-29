<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 02/03/16
 * Time: 01:37
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;

/**
 * Class SharedStatRepositoryDoctrine
 * @package namespace ErpNET\App\Models\Doctrine\Repositories;
 */
class SharedStatRepositoryDoctrine extends BaseEntityRepository implements SharedStatRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'status',
        'descricao',
    ];

}