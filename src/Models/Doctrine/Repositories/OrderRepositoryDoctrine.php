<?php

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;

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
        'obsevacao'
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

    public function addOrderToItem($order, $itemOrder)
    {
        $itemOrder->setOrder($order);
        $this->_em->persist($itemOrder);
        $this->_em->flush();
        $toAdded = $itemOrder->quantidade * $itemOrder->valor_unitario;
        $order->setValorTotal($order->valor_total+$toAdded);
        $this->_em->persist($order);
        $this->_em->flush();

//        return $itemOrder;
    }

    /**
     * @param \ErpNET\App\Models\Doctrine\Entities\Address|\ErpNET\App\Models\Eloquent\Address $address
     * @param \ErpNET\App\Models\Doctrine\Entities\Order|\ErpNET\App\Models\Eloquent\Order $order
     */
    public function addAddressToOrder($address, $order)
    {
        $order->setAddress($address);

        $this->_em->persist($order);
        $this->_em->flush();

//        return $order;
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addPartnerToOrder($partner, $order)
    {
        $order->setPartner($partner);

        $this->_em->persist($order);
        $this->_em->flush();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\SharedOrderPayment | \ErpNET\App\Models\Doctrine\Entities\SharedOrderPayment $sharedOrderPayment
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addSharedOrderPaymentToOrder($sharedOrderPayment, $order)
    {
        $order->setSharedOrderPayment($sharedOrderPayment);

        $this->_em->persist($order);
        $this->_em->flush();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\SharedOrderType | \ErpNET\App\Models\Doctrine\Entities\SharedOrderType $sharedOrderType
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addSharedOrderTypeToOrder($sharedOrderType, $order)
    {
        $order->setSharedOrderType($sharedOrderType);

        $this->_em->persist($order);
        $this->_em->flush();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     * @param \ErpNET\App\Models\Eloquent\SharedStat | \ErpNET\App\Models\Doctrine\Entities\SharedStat $sharedStat
     */
    public function addOrderToStat($order, $sharedStat)
    {
        $ownerEntity = $this->resolveEntityManyToMany($sharedStat, 'orderSharedStats');
        $ownerEntity->setSharedStat($sharedStat);
        $ownerEntity->setOrder($order);
        $this->_em->persist($ownerEntity);
        $this->_em->flush();

//        return $ownerEntity;
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\SharedCurrency | \ErpNET\App\Models\Doctrine\Entities\SharedCurrency $sharedCurrency
     * @param \ErpNET\App\Models\Eloquent\Order | \ErpNET\App\Models\Doctrine\Entities\Order $order
     */
    public function addSharedCurrencyToOrder($sharedCurrency, $order)
    {
        $order->setSharedCurrency($sharedCurrency);

        $this->_em->persist($order);
        $this->_em->flush();
    }
}
