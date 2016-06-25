<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 02/03/16
 * Time: 01:37
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\RepositoryLayer\ProductGroupRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

/**
 * Class ProductGroupRepositoryDoctrine
 * @package namespace ErpNET\App\Models\Doctrine\Repositories;
 */
class ProductGroupRepositoryDoctrine extends BaseEntityRepository implements ProductGroupRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'mandante',
        'grupo',
//        'created_at',
//        'updated_at',
    ];

    public function collectionProductGroups()
    {
        // TODO: Implement collectionProductGroups() method.
//        $em = $this->getEntityManager();
//        $qb = $em->createQueryBuilder();
//        $qb
//            ->select('p')
//            ->from('App\Models\Doctrine\Entities\ProductGroup', 'p')
////            ->orderBy('c.numero', 'ASC')
//        ;
//        $query = $qb->getQuery();
//        $return = $query->getResult();
//        return new ArrayCollection($return);
    }

    public function collectionCategorias()
    {
        $qb = $this->_em->createQueryBuilder();

        $isEq = $qb->expr()->eq('st.status', '?1');
        $isLike = $qb->expr()->like('p.grupo', '?2');
        if ($this->_em->getFilters()->isEnabled('soft-deleteable')) {
            $isNull = $qb->expr()->isNull('p.deletedAt');
            $qb->where($isNull);
        }
        $qb
            ->select('p')
            ->from(\ErpNET\App\Models\Doctrine\Entities\ProductGroup::class, 'p')
            ->join('p.productGroupSharedStats', 'pgst', 'WITH', 'p.id = pgst.product_group_id')
            ->join('pgst.sharedStat', 'st', 'WITH', 'pgst.shared_stat_id = st.id')
            ->where($isEq)
            ->andWhere($isLike)
            ->orderBy('p.grupo', 'ASC')
            ->setParameter(1, 'ativado')
            ->setParameter(2, 'Categoria:%')
        ;
        $query = $qb->getQuery();
        $queryResult = $query->getArrayResult();

        $fractal = new Manager();
        $resource = new Collection($queryResult, function(array $item) {
            $icon = '';
            $nome = substr($item['grupo'], 11);
            switch (str_slug($nome)){
                case 'cervejas':
                    $icon = 'icon ion-beer';
                    break;
                case 'outros':
                    $icon = 'icon fa fa-globe';
                    break;
                case 'porcoes':
                    $icon = 'icon fa fa-cutlery';
                    break;
                case 'tabacaria':
                    $icon = 'icon ion-no-smoking';
                    break;
                case 'destilados':
                    $icon = 'icon ion-android-bar';
                    break;
                case 'sucos':
                    $icon = 'icon ion-ios-pint';
                    break;
                case 'energeticos':
                    $icon = 'icon ion-ios-pint';
                    break;
                case 'refrigerantes':
                    $icon = 'icon ion-ios-pint';
                    break;
                case 'vinhos':
                    $icon = 'icon ion-wineglass';
                    break;
                case 'lanches':
                    $icon = 'icon ion-pizza';
                    break;
                default:
                    break;
            }

            return [
                'id'   => $item['id'],
                'icon'   => $icon,
                'nome'   => $nome
            ];
        });
        return $fractal->createData($resource)->toJson();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\ProductGroup | \ErpNET\App\Models\Doctrine\Entities\ProductGroup $productGroup
     * @param \ErpNET\App\Models\Eloquent\SharedStat | \ErpNET\App\Models\Doctrine\Entities\SharedStat $stat
     */
    public function addProductGroupToStat($productGroup, $stat)
    {
        $fields = 'productGroupSharedStats';
        $annInfo = $this->getAnnotations($stat, $fields);

        $array = explode("\\", $this->model);
        array_pop($array);
        array_push($array, $annInfo[0]->targetEntity);
        implode("\\",$array);
        $class = implode("\\",$array);

        $ownerEntity = new $class;
        $ownerEntity->setSharedStat($stat);
        $ownerEntity->setProductGroup($productGroup);
        $this->_em->persist($ownerEntity);
        $this->_em->flush();

        return $ownerEntity;
    }
}