<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 24/02/16
 * Time: 16:39
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use Carbon\Carbon;
use ErpNET\App\Models\RepositoryLayer\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

abstract class AbstractRepository implements BaseRepositoryInterface
{

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    public function find($id)
    {
        return $this->model->find($id);

    }

    /**
     * @inheritdoc
     */
    public function findAll()
    {
        return $this->model->all();
    }

    /**
     * @inheritdoc
     */
    public function findAllPaginate($count = 15)
    {
        return $this->model->paginate($count);
    }

    public function create(array $data)
    {
        if (count($this->model->getFillable())>0)
            foreach ($data as $dataKey => $dataItem) {
                $found=false;
                foreach ($this->model->getFillable() as $fillableItem) {
                    if ($dataKey==$fillableItem){
                        $found=true;
                    }
                }
                if (!$found){
                    $message = "Error $dataKey not fillable: ".serialize($this->model->getFillable()).' --- Class:'.get_class($this);
                    throw new \RuntimeException($message);
                }
            }
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->find($id)->update($data);
    }

    public function firstOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    public function restore($id)
    {
        return $this->model->withTrashed()->find($id)->restore();
    }

    public function between($field, Carbon $start, Carbon $end, $otherSelect=null){
//        DB::enableQueryLog();
        $model = $this->model;
        if (!is_null($otherSelect)) {
            $model = $model->with($otherSelect);
        }
        $model = $model->whereBetween($field, array($start, $end));
        $return = $model->get();
//        var_dump(DB::getQueryLog()[0]['bindings']);
        if (count($return)==0){
            $message = 'Model: ' . get_class($this->model) .
                "\nRepository ".get_class($this)." error: " .
                "\nMethod ".__METHOD__." error: " .
                "\nCriteria: " .
                "\n - field: " . ($field).
                "\n - start: " . serialize($start).
                "\n - end: " . serialize($end);
//            var_dump($message);
//            throw new \Exception($message);
        }else return $return;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $model = $this->model;

//        if (count($criteria) == 1) {
//            foreach ($criteria as $c) {
//                $model = $model->where($c[0], $c[1], $c[2]);
//            }
//        } elseif (count($criteria > 1)) {
//            $model = $model->where($criteria[0], $criteria[1], $criteria[2]);
//        }

        $model = $model->where($criteria);

        if (is_array($orderBy)) {
            foreach ($orderBy as $campo=>$ordem) {
                $model = $model->orderBy($campo, $ordem);
            }
        } elseif (is_string($orderBy)) {
            $model = $model->orderBy($orderBy, 'asc');
        }

        if (count($limit)) {
            $model = $model->take((int)$limit);
        }

        if (count($offset)) {
            $model = $model->skip((int)$offset);
        }

        $return = $model->get();

        if (count($return)==0){
            $message = 'Model: ' . get_class($this->model) .
                "\nRepository ".get_class($this)." error: " .
                "\nMethod ".__METHOD__." error: " .
                "\nCriteria: " . serialize($criteria).
                "\n - orderBy: " . serialize($orderBy).
                "\n - limit: " . serialize($limit).
                "\n - offset: " . serialize($offset);
            var_dump($message);
//            throw new \Exception($message);
        }else return $return;
    }

    public function findOneBy(array $criteria)
    {
        $findBy = $this->findBy($criteria);
        if (is_null($findBy)){
            $message = 'Model: ' . get_class($this->model)
                . "\nRepository findOneBy() return null: " . get_class($this)
                . "\nCriteria: " . serialize($criteria);
            throw new ModelNotFoundException($message);
        }
        $first = $findBy->first();
        if (is_null($first)){
            $message = 'Model: ' . get_class($this->model) . "\nRepository findOneBy()->first() return null: " . get_class($this) . "\nCriteria: " . serialize($criteria);
            throw new ModelNotFoundException($message);
        }else return $first;
    }

    public function findOneOrFail($id)
    {
        $result = $this->findBy($id)->first();

        if (is_array($id)) {
            if (count($result) == count(array_unique($id))) {
                return $result;
            }
        } elseif (! is_null($result)) {
            return $result;
        }

        throw new \Exception('Falha no findOneOrFail');
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

    // from Doctrine
    public function __call($method, $arguments)
    {
        if (substr($method, 0, 6) == 'findBy') {
            $by = substr($method, 6, strlen($method));
            $method = 'findBy';
        } else {
            if (substr($method, 0, 9) == 'findOneBy') {
                $by = substr($method, 9, strlen($method));
                $method = 'findOneBy';
            } else {
                throw new \Exception(
                    "Undefined method '$method'. The method name must start with " .
                    "either findBy or findOneBy!"
                );
            }
        }
        if (!isset($arguments[0])) {
            // we dont even want to allow null at this point, because we cannot (yet) transform it into IS NULL.
            throw new \Exception('You must have one argument');
        }

        $fieldName = lcfirst($by);

        return $this->$method([$fieldName, '=', $arguments[0]]);
    }

    public function paginate($pages)
    {
        return $this->model->paginate($pages);
    }
}