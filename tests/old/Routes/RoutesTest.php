<?php
namespace ErpNET\Tests\Routes;

use ErpNET\Tests\TestCase;
//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoutesTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->assertTrue(true);
//        dd(route('relatorios.teste1'));
//        $this->visit(route('relatorios.teste1'))
        $this->visit('/')
//             ->isJson();
             ->see('welcome');
    }
}
