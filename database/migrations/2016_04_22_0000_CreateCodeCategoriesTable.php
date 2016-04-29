<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 18:28
 */
class CreateCodeCategoriesTable
{
    public function up()
    {
        Schema::create('code_categories', function(Blueprint $table){
            $table->increments('id');
            $table->integer('parent_id')->nullable(true)->unsigned();
            $table->foreign('parent_id')->references('id')->on('code_categories');
            $table->string('name');
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('code_categories');
    }
}