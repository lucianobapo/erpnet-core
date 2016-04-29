<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 02/03/16
 * Time: 01:27
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use Doctrine\Common\Annotations\AnnotationReader;
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

    public function collectionProductsDelivery($categ = null)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb
            ->select('p')
            ->from(\ErpNET\App\Models\Doctrine\Entities\Product::class, 'p')
//            ->leftJoin('p.productProductGroups', 'ppg')
            ->join('p.productSharedStats', 'pst', 'WITH', 'p.id = pst.product_id')
            ->join('pst.sharedStat', 'st', 'WITH', 'pst.shared_stat_id = st.id')
            ->where('st.status = ?1')
            ->andWhere('p.valorUnitVenda>0')
            ->setParameter(1, 'ativado')

            ->orderBy('p.nome', 'ASC')
        ;

        if (!is_null($categ) && ((int)$categ)>0) {
            $qb->join('p.productProductGroups', 'pg', 'WITH', 'p.id = pg.product_id')
                ->andWhere('pg.product_group_id = ?2')
                ->setParameter(2, $categ);
        }

        $query = $qb->getQuery();
        $queryResult = $query->getArrayResult();
//        var_dump($queryResult);

        $fractal = new Manager();
        $resource = new Collection($queryResult, function(array $item) {
            return [
                'id'   => $item['id'],
                'nome'   => $item['nome'],
                'imagem'   => $item['imagem'],
                'max' => 3,
                'valor'   => $item['promocao']?$item['valorUnitVendaPromocao']:$item['valorUnitVenda'],
            ];
        });
        return $fractal->createData($resource)->toJson();
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
}