<?php

namespace ErpNET\App\Models\Doctrine\Repositories;

use Doctrine\ORM\Query;
use ErpNET\App\Models\RepositoryLayer\SharedOrderPaymentRepositoryInterface;

/**
 * Class SharedOrderPaymentRepositoryDoctrine
 * @package namespace ErpNET\App\Models\Doctrine\Repositories;
 */
class SharedOrderPaymentRepositoryDoctrine extends BaseEntityRepository implements SharedOrderPaymentRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
//        'mandante',
        'pagamento',
        'descricao',
    ];
}
