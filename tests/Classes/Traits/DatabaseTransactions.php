<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 26/04/16
 * Time: 16:54
 */

namespace ErpNET\Tests\Classes\Traits;

use Illuminate\Foundation\Testing\DatabaseTransactions as IlluminateDatabaseTransactions;

trait DatabaseTransactions
{
    use IlluminateDatabaseTransactions;
    /**
     * Handle database transactions on the specified connections.
     *
     * @return void
     */
    public function beginDatabaseTransaction()
    {
//        try_call('loadRepo', $this);
        if (!is_null($this->app)){
//            if ($this->repo instanceof \Doctrine\ORM\EntityRepository) {
            if (config('erpnet.orm')=='doctrine') {
                foreach ($this->connectionsToTransact() as $name) {
                    $this->app->em->getConnection($name)->beginTransaction(); // suspend auto-commit
                }

                $this->beforeApplicationDestroyed(function () {
                    foreach ($this->connectionsToTransact() as $name) {
                        $this->app->em->getConnection($name)->rollBack();
                    }
                });
//            }elseif ($this->repo->model instanceof \Illuminate\Database\Eloquent\Model) {
            }elseif (config('erpnet.orm')=='eloquent') {
                $database = $this->app->make('db');

                foreach ($this->connectionsToTransact() as $name) {
                    $database->connection($name)->beginTransaction();
                }

                $this->beforeApplicationDestroyed(function () use ($database) {
                    foreach ($this->connectionsToTransact() as $name) {
                        $database->connection($name)->rollBack();
                    }
                });
            }
        } else {
            throw new \RuntimeException('Not Loaded app');
        }
    }
}