<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 02/03/16
 * Time: 01:27
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use Doctrine\Common\Annotations\AnnotationReader;
use ErpNET\App\Models\Doctrine\Entities\Product;
use ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use ReflectionClass;

/**
 * Class ProductRepositoryDoctrine
 * @package namespace ErpNET\App\Models\Doctrine\Repositories;
 */
class ProductRepositoryDoctrine extends BaseEntityRepository implements ProductRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'mandante',
//        'cost_id',
        'nome',
        'imagem',
        'icone',
//        'cod_fiscal',
//        'cod_barra',
        'promocao',
        'estoque',
//        'estoque_minimo',
        'valorUnitVenda',
//        'valorUnitVendaPromocao',
//        'valorUnitCompra',
    ];

    public function collectionProducts()
    {
        // TODO: Implement collectionProductGroups() method.
//        $em = $this->getEntityManager();
//        $qb = $em->createQueryBuilder();
//        $qb
//            ->select('p')
//            ->from('App\Models\Doctrine\Entities\Product', 'p')
////            ->orderBy('c.numero', 'ASC')
//        ;
//        $query = $qb->getQuery();
//        $return = $query->getResult();
//        return new ArrayCollection($return);
    }

    public function activatedProducts()
    {
        $qb = $this->_em->createQueryBuilder();
        $isEq = $qb->expr()->eq('st.status', '?1');
        if ($this->_em->getFilters()->isEnabled('soft-deleteable')) {
            $isNull = $qb->expr()->isNull('p.deletedAt');
            $qb->where($isNull);
        }
        $qb
            ->select('p')
            ->from(Product::class, 'p')
            ->join('p.productSharedStats', 'pst', 'WITH', 'p.id = pst.product_id')
            ->join('pst.sharedStat', 'st', 'WITH', 'pst.shared_stat_id = st.id')
            ->where($isEq)
            ->andWhere('p.valorUnitVenda>0')
            ->setParameter(1, 'ativado')

            ->orderBy('p.nome', 'ASC')
        ;
        $query = $qb->getQuery();
        $queryResult = $query->getResult();
        return $queryResult;
    }

    public function addProductToGroup($product, $group)
    {
//        $fields = ['mandante','grupo','productProductGroups'];
        $fields = 'productProductGroups';
        $annInfo = $this->getAnnotations($group, $fields);

        $array = explode("\\", $this->model);
        array_pop($array);
        array_push($array, $annInfo[0]->targetEntity);
        implode("\\",$array);
        $class = implode("\\",$array);

        $ownerEntity = new $class;
        $ownerEntity->setProductGroup($group);
        $ownerEntity->setProduct($product);
        $this->_em->persist($ownerEntity);
        $this->_em->flush();

        return $ownerEntity;
    }

    public function addProductToStat($product, $stat)
    {

        $fields = 'productSharedStats';
        $annInfo = $this->getAnnotations($stat, $fields);

        $array = explode("\\", $this->model);
        array_pop($array);
        array_push($array, $annInfo[0]->targetEntity);
        implode("\\",$array);
        $class = implode("\\",$array);

        $ownerEntity = new $class;
        $ownerEntity->setSharedStat($stat);
        $ownerEntity->setProduct($product);
        $this->_em->persist($ownerEntity);
        $this->_em->flush();

        return $ownerEntity;
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\CostAllocate | \ErpNET\App\Models\Doctrine\Entities\CostAllocate $costAllocate
     * @param \ErpNET\App\Models\Eloquent\Product | \ErpNET\App\Models\Doctrine\Entities\Product $product
     */
    public function addCostAllocateToProduct($costAllocate, $product)
    {
        $product->setCostAllocate($costAllocate);

        $this->_em->persist($product);
        $this->_em->flush();
    }
}