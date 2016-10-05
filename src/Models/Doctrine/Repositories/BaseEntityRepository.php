<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 13/01/16
 * Time: 23:28
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use Carbon\Carbon;
use Doctrine\Common\Annotations\AnnotationReader;
use ErpNET\App\Models\Doctrine\Entities\EntityBase;
use ErpNET\App\Models\RepositoryLayer\BaseRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use ReflectionClass;

class BaseEntityRepository extends EntityRepository implements BaseRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable;

    public $model;
    public $table;
    public $em;
    protected $entity;

    public function __construct($em, $class)
    {
        parent::__construct($em, $class);
//        dd($class);
//        dd($em);
//        dd($this);
//        dd($this->getEntityName());
//        dd($em->getRepository($this->getEntityName()));
//        dd($this->getEntityName());
//        $this->model = get_class($this);
        $this->em = $this->getEntityManager();
        $this->model = $this->getEntityName();
        $this->table = $this->getEntityManager()->getClassMetadata($this->getEntityName())->getTableName();

    }

    public function between($field, Carbon $start, Carbon $end, $otherSelect=null){
        function toAlias($str){
            return str_replace('.','',$str);
        }
        function toField($str){
            if (strpos($str,'.')===false) return 'table.'.$str;
            else return $str;
        }

        $formatedStart = $start->format('Y-m-d H:i:s');
        $formatedEnd = $end->format('Y-m-d H:i:s');

        $qb = $this->em->createQueryBuilder();

        if ($this->_em->getFilters()->isEnabled('soft-deleteable')) {
            $isNull = $qb->expr()->isNull('table.deletedAt');
            $qb->where($isNull);
        }

//        $between = $qb->expr()->between('table.'.$field, $formatedStart,$formatedEnd);
        $between = $qb->expr()->between('table.'.$field, '?1', '?2');
//        var_dump($between);
//        $gt = $qb->expr()->gt('table.'.$field, '?1');
//        dd($gt);

//        $queryResult = $this->findBy([$field=>$start]);
//        dd($queryResult);

        $selects = ['table'];
        if (!is_null($otherSelect)) {
            if (is_array($otherSelect))
                foreach ($otherSelect as $item)
                    array_push($selects, toAlias($item));
            else
                array_push($selects, toAlias($otherSelect));
        }

        $qb
            ->select($selects)
            ->from($this->getEntityName(), 'table');

        if (!is_null($otherSelect)) {
            if (is_array($otherSelect))
                foreach ($otherSelect as $item)
                    $qb->leftJoin(toField($item), toAlias($item));
            else
                $qb->leftJoin(toField($otherSelect), toAlias($otherSelect));
        }

        $qb
            ->where($between)
            ->setParameter(1, $formatedStart)
            ->setParameter(2, $formatedEnd)
//            ->orderBy('p.nome', 'ASC')
        ;
        $query = $qb->getQuery();
//        dd($query);
//        $parameters = $qb->getParameters();
//        var_dump($parameters);
//        $dql = $qb->getDQL();
//        dd($dql);
//        $queryResult = $query->getArrayResult();
        $queryResult = $query->getResult();
//        dd($queryResult);

        if (count($queryResult)==0){
            $model = is_string($this->model)?$this->model:get_class($this->model);
            $message = 'Model: ' . $model .
                "\nRepository ".get_class($this).' returned 0 in count($queryResult):'.
                "\nMethod ".__METHOD__." : " .
                "\nCriteria: " .
                "\n - field: " . ($field).
                "\n - start: " . serialize($start).
                "\n - end: " . serialize($end);
//            var_dump($message);
//            throw new \Exception($message);
        }else return $queryResult;
//        return $queryResult;
//        return null;
    }

    protected function mapFillable($data){
        if (count($this->fillable)==0) {
            $message = 'Error mapFillable(): '.get_class($this);
            throw new \Doctrine\ORM\Mapping\MappingException($message);
        }

        foreach ($this->fillable as $item) {
            if (array_has($data, $item)){
                $functionName = camel_case("set-".$item);
                if (method_exists($this->entity, $functionName)
                    && is_callable([$this->entity, $functionName]))
                    call_user_func([$this->entity, $functionName], $data[$item]);
                else {
                    dd(get_class($this->entity).' dont have '.camel_case("set-".$item));
                }
            }


        }
        if (count($this->fillable)>0)
            foreach ($data as $dataKey => $dataItem) {
                $found=false;
                foreach ($this->fillable as $fillableItem) {
                    if ($dataKey==$fillableItem){
                        $found=true;
                    }
                }
                if (!$found){
                    $message = "Error $dataKey not fillable: ".get_class($this);
                    throw new \Exception($message);
                }
            }
    }

    /**
     * create EntityBase
     * @return EntityBase
     */
    public function prepareData($data)
    {
        return new $this->_class($data);
    }


    public function findAll(){
        return new ArrayCollection(parent::findAll());
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $found = parent::find($id, $lockMode, $lockVersion);
        if (!is_null($found) && $this->_em->getFilters()->isEnabled('soft-deleteable')){
            if (try_call('isDeleted', $found)===true) return null;
            else return $found;
        } else return $found;
    }

    public function findOrFail($id)
    {
        $result = $this->find($id);

        if (is_array($id)) {
            if (count($result) == count(array_unique($id))) {
                return $result;
            }
        } elseif (! is_null($result)) {
            return $result;
        }

        throw new \Exception('Falha no findOrFail');
    }

    public function findOneOrFail($id)
    {
        $result = $this->findOneBy($id);

        if (is_array($id)) {
            if (count($result) == count(array_unique($id))) {
                return $result;
            }
        } elseif (! is_null($result)) {
            return $result;
        }

        throw new \Exception('Falha no findOneOrFail');
    }

    public function create(array $data)
    {
        $data = $this->mapMandanteData($data);
        $this->entity = new $this->model;
        $this->mapFillable($data);
        $this->_em->persist($this->entity);
        $this->_em->flush();
        return $this->entity;
    }

//    public function EntityOfId($id)
//    {
//        return $this->_em->find($this->_class, [
//            'id' => $id
//        ]);
//    }

//    public function update(EntityBase $entity, $data)
//    {
//        $this->mapFillable($entity,$data);
//        $this->em->persist($entity);
//        $this->em->flush();
//    }
//
//    public function delete(EntityBase $entity)
//    {
//        $this->em->remove($entity);
//        $this->em->flush();
//    }

    public function update(array $data, $id)
    {
//        return $this->model->find($id)->update($data);
    }

    public function firstOrCreate(array $data)
    {
        if (! is_null($instance = $this->findOneBy($data))) {
            return $instance;
        }

        return $this->create($data);
    }

    public function delete($id)
    {
        $entity = $this->find($id);
        $this->_em->remove($entity);
        $this->_em->flush();
        return $entity;
    }

    public function restore($id)
    {
        $this->_em->getFilters()->disable('soft-deleteable');
        $entity = $this->find($id);
        $entity->restore();
        $this->_em->persist($entity);
        $this->_em->flush();
        $this->_em->getFilters()->enable('soft-deleteable');
        return $entity;
    }

    public function paginate($pages)
    {
//        return $this->model->paginate($pages);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model | \ErpNET\App\Models\Doctrine\Entities\EntityBase $entity
     * @param string | array $fields
     * @return \Illuminate\Database\Eloquent\Model | \ErpNET\App\Models\Doctrine\Entities\EntityBase
     */
    protected function resolveEntityManyToMany($entity, $fields) {
        $annInfo = $this->getAnnotations($entity, $fields);
        $array = explode("\\", $this->model);
        array_pop($array);
        array_push($array, $annInfo[0]->targetEntity);
        implode("\\",$array);
        $class = implode("\\",$array);

        return new $class;
    }

    public function getAnnotations($entity, $fields){
        if (is_array($fields)){
            $return = [];
            foreach ($fields as $field) {
                if (($docInfos = $this->getAnnotation($entity, $field))===false) {
                    continue;
                } else $return[] = $docInfos;
            }
            return count($return)>0?$return:false;
        }elseif(is_string($fields)){
            return $this->getAnnotation($entity, $fields);
        }
    }
    protected function getAnnotation($entity, $field){
        $docReader = new AnnotationReader();
        $reflect = new ReflectionClass($entity);
        if (!$reflect->hasProperty($field)) {
            var_dump('the entity '.get_class($entity).' does not have a such property: '.$field);
            return false;
        }
        return $docReader->getPropertyAnnotations($reflect->getProperty($field));
    }

    protected function mapMandanteData($data)
    {
        $object = new $this->model;
        if (!isset($data['mandante']) && method_exists($object, 'setMandante') && is_callable([$object, 'setMandante'])){
            $data['mandante']='guest';
        }
        return $data;
    }


    /**
     * @inheritdoc
     */
    public function findAllPaginate($count)
    {
        return new ArrayCollection(parent::findAll());
    }
}