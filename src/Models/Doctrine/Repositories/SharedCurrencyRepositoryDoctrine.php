<?php

namespace ErpNET\App\Models\Doctrine\Repositories;

use Doctrine\ORM\Query;
use ErpNET\App\Models\RepositoryLayer\SharedCurrencyRepositoryInterface;

/**
 * Class SharedCurrencyRepositoryDoctrine
 * @package namespace ErpNET\App\Models\Doctrine\Repositories;
 */
class SharedCurrencyRepositoryDoctrine extends BaseEntityRepository implements SharedCurrencyRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'nome_universal',
        'descricao',
    ];
}
