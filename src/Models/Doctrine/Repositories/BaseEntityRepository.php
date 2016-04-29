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
        if ($this->_em->getFilters()->isEnabled('soft-deleteable')){
            if (try_call('isDeleted', $found)===true) return null;
            else return $found;
        } else return $found;
    }

    public function create(array $data)
    {
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
//        return $this->model->firstOrCreate($data);
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
}