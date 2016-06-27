<?php

namespace ErpNET\App\Models\RepositoryLayer;
use Carbon\Carbon;

/**
 * Interface BaseRepositoryInterface
 * @package namespace ErpNET\App\ModelLayer\Repositories;
 */
interface BaseRepositoryInterface
{

    public function find($id);

    public function findAll();

    public function create(array $data);

    public function update(array $data, $id);

    public function firstOrCreate(array $data);

    public function delete($id);

    public function restore($id);

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    public function findOneBy(array $criteria);

    /**
     * @param string $field
     * @param Carbon $start
     * @param Carbon $end
     * @return array
     */
    public function between($field, Carbon $start, Carbon $end, $otherSelect=null);

    public function findOneOrFail($id);

    public function findOrFail($id);

    public function __call($method, $arguments);

    public function paginate($pages);

}
