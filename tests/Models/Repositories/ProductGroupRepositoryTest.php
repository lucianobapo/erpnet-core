<?php
namespace ErpNET\Tests\Models\Repositories;

use ErpNET\App\Models\RepositoryLayer\ProductGroupRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;

class ProductGroupRepositoryTest extends RepositoryTestCase
{
    protected $testClass = ProductGroupRepositoryInterface::class;

    public function loadSignatures(){
        $this->testFieldsSignature = [
            'mandante' => 'teste',
            'grupo' => 'xxx',
        ];
    }

    public function testIfCollectionCategoriasIsJson(){
        $this->assertJson($this->repo->collectionCategorias());
    }

    public function testIfCollectionCategoriasIsNotEmptyJson(){
        $category = str_random();

        //Create Group
        $this->testClass = ProductGroupRepositoryInterface::class;
        $recordProductGroup = $this->factoryTestClass(['grupo'=>'Categoria: '.$category]);

        // Assertions for Status
        $repoSharedStat = $this->app->make(SharedStatRepositoryInterface::class);
        $recordSharedStat = $repoSharedStat->firstOrCreate(['status'=>'ativado']);
        $this->assertNotNull($recordSharedStat);

        //addProductGroupToStat
        $repoProductGroup = $this->app->make(ProductGroupRepositoryInterface::class);
        $repoProductGroup->addProductGroupToStat($recordProductGroup, $recordSharedStat);

        $return = json_decode($this->repo->collectionCategorias());
        $this->assertAttributeInternalType('array','data',$return);
        $this->assertAttributeNotCount(0,'data',$return);
        $findBy = $this->repo->findOneBy(['grupo' => 'Categoria: ' . $category]);
        $instance = $this->repo->model;
        if (!is_string($this->repo->model)) $instance = get_class($this->repo->model);
        $this->assertInstanceOf($instance, $recordProductGroup);
        $this->assertInstanceOf($instance, $findBy);
        $this->assertEquals($findBy->id, $recordProductGroup->id);
    }
}
