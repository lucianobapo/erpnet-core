<?php

namespace ErpNET\App\Models\Doctrine\Repositories;

use Doctrine\ORM\Query;
use ErpNET\App\Models\RepositoryLayer\SharedOrderTypeRepositoryInterface;

/**
 * Class SharedOrderTypeRepositoryDoctrine
 * @package namespace ErpNET\App\Models\Doctrine\Repositories;
 */
class SharedOrderTypeRepositoryDoctrine extends BaseEntityRepository implements SharedOrderTypeRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'tipo',
        'descricao',
    ];
}
