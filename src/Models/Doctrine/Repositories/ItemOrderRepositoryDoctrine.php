<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 24/04/16
 * Time: 04:14
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\RepositoryLayer\ItemOrderRepositoryInterface;

class ItemOrderRepositoryDoctrine extends BaseEntityRepository implements ItemOrderRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [];
}