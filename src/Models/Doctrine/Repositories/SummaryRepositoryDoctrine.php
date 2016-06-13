<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 23:37
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use Carbon\Carbon;
use ErpNET\App\Models\Doctrine\Entities\Order;
use ErpNET\App\Models\Doctrine\Entities\Summary;
use ErpNET\App\Models\RepositoryLayer\SummaryRepositoryInterface;

class SummaryRepositoryDoctrine extends BaseEntityRepository implements SummaryRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'mandante',
        'start_date',
        'start_date',
    ];

    /**
     * @return \Carbon\Carbon
     */
    public function lastSummaryEnd()
    {
//        $lastEnd = $this->findOneBy([],['end_date'=>'desc']);
//        var_dump($lastEnd->end_date);

        $qb = $this->getEntityManager()->createQueryBuilder();
        $isNull = $qb->expr()->isNull('summaries.deletedAt');
        $qb
            ->select('MAX(summaries.end_date)')
            ->from(Summary::class, 'summaries')
            ->where($isNull)
        ;
        $query = $qb->getQuery();
//        $queryResult = $query->getResult();
        $queryResult = $query->getOneOrNullResult();
//        $queryResult = $query->getSingleResult();

        if (is_null($queryResult[1])) return null;
        else return Carbon::parse($queryResult[1]);
//            return ($queryResult[0][1]);
//            return ($queryResult[1]);
    }
}