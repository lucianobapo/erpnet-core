<?php
namespace ErpNET\App\Repositories;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Closure;

abstract class BaseMigration extends Migration
{
    protected $table;
    protected $connection;

    abstract protected function upMigration();
    abstract protected function downMigration();

    protected function createTable(Closure $callback)
    {
        Schema::create($this->table, $callback);
    }

    protected function dropTable()
    {
        if (DB::connection()->getDriverName()=='mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

        Schema::drop($this->table);

        if (DB::connection()->getDriverName()=='mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
    }

    protected function createIndex($field){
        $this->connection->table($this->table, function(Blueprint $table) use ($field)
        {
            $table->index($field, $this->table.'_'.$field.'_index');
        });
    }
    protected function dropIndex($field){
        $this->connection->table($this->table, function(Blueprint $table) use ($field)
        {
            $table->dropIndex($this->table.'_'.$field.'_index');
        });
    }

    protected function createForeign($onTable, $foreignField, $references='id', $onDelete='restrict', $onUpdate='restrict'){
        if ($this->connection->hasTable($onTable)) {
            $this->connection->table($this->table, function(Blueprint $table) use ($onTable, $foreignField, $references, $onDelete, $onUpdate)
            {
                $table->foreign($foreignField, $this->table.'_'.$foreignField.'_foreign')
                    ->references($references)
                    ->on($onTable)
                    ->onDelete($onDelete)
                    ->onUpdate($onUpdate);
            });
        }
    }
    protected function dropForeign($onTable, $foreignField){
        if ($this->connection->hasTable($onTable)) {
            $this->connection->table($this->table, function(Blueprint $table) use ($onTable, $foreignField)
            {
                $table->dropForeign($this->table.'_'.$foreignField.'_foreign');
            });
        }
    }

    public function up()
    {
        if(is_null($this->connection)) $this->connection = Schema::connection(config('database.default'));
        $this->upMigration();
        if (config('app.env')!='testing') echo get_class($this)." is up\n";
    }

    public function down()
    {
        if(is_null($this->connection)) $this->connection = Schema::connection(config('database.default'));
        $this->downMigration();
        if (config('app.env')!='testing') echo get_class($this)." is down\n";
    }
}
