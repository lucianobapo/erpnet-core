<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 23:37
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\Doctrine\Entities\Partner;
use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;

class PartnerRepositoryDoctrine extends BaseEntityRepository implements PartnerRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'mandante',
//        'user_id',
        'nome',
//        'data_nascimento',
//        'observacao',
    ];

    /**
     * @param int $id
     * @return \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner
     */
    public function userFindProviderId($id)
    {
        $em = $this->getEntityManager();
        //$em is the entity manager
        $qb = $em->createQueryBuilder();
        $qb
            ->select('partner', 'user')
            ->from(Partner::class, 'partner')
            ->leftJoin('partner.user', 'user')
            ->where('user.provider_id = ?1')
            ->setParameter(1, $id)
        ;
        $query = $qb->getQuery();
//        dd($query);
        $return = $query->getResult();
//        return $query->getResult(Query::HYDRATE_ARRAY);
//        return $query->getResult(Query::HYDRATE_OBJECT);
        dd($return);
//        return new ArrayCollection($return);
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\User | \ErpNET\App\Models\Doctrine\Entities\User $user
     * @param \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     */
    public function addUserToPartner($user, $partner)
    {
        $partner->setUser($user);

        $this->_em->persist($partner);
        $this->_em->flush();
    }
}