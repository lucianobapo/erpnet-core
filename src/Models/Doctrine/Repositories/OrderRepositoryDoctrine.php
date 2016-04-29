<?php

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;
use DebugBar\DataCollector\PDO\PDOCollector;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use DebugBar\DataCollector\PDO\TraceablePDO;

/**
 * Class OrderRepositoryDoctrine
 * @package namespace ErpNET\App\Models\Doctrine\Repositories;
 */
class OrderRepositoryDoctrine extends BaseEntityRepository implements OrderRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'mandante',
//        'partner_id',
//        'address_id',
//        'currency_id',
//        'type_id',
//        'payment_id',
        'posted_at',
        'valor_total',
//        'desconto_total',
//        'troco',
//        'descricao',
//        'referencia',
//        'obsevacao'
    ];

    public function collectionOrdersItemsCosts()
    {
        $em = $this->getEntityManager();
        //$em is the entity manager
        $qb = $em->createQueryBuilder();
        $qb
//            ->select('Article', 'Comment')
//            ->from('Entity\Article', 'Article')
//            ->leftJoin('Article.comment', 'Comment')

            ->select('o', 'ost', 'st', 'io', 'ca')
            ->from('App\Models\Doctrine\Entities\Order', 'o')
            ->leftJoin('o.itemOrders', 'io')
            ->leftJoin('io.costAllocate', 'ca')
            ->join('o.orderSharedStats', 'ost', 'WITH', 'o.id = ost.order_id')
            ->join('ost.sharedStat', 'st', 'WITH', 'ost.shared_stat_id = st.id')
            ->where('st.status = ?1')
            ->setParameter(1, 'finalizado')
        ;
        $query = $qb->getQuery();
//        dd($query);
        $return = $query->getResult();
//        return $query->getResult(Query::HYDRATE_ARRAY);
//        return $query->getResult(Query::HYDRATE_OBJECT);
//        dd($return);
        return new ArrayCollection($return);

    }

}
