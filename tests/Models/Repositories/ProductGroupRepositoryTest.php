<?php
namespace ErpNET\Tests\Models\Repositories;

use ErpNET\App\Models\RepositoryLayer\ProductGroupRepositoryInterface;

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
//        var_dump($this->repo->collectionCategorias());
        if (!is_null($this->testFieldsSignature)){
            $category = str_random();
            $this->testFieldsSignature['grupo'] = 'Categoria: '.$category;
            $record = $this->repo->create($this->testFieldsSignature);

            $return = json_decode($this->repo->collectionCategorias());
            $this->assertAttributeInternalType('array','data',$return);
            $this->assertAttributeNotCount(0,'data',$return);

            $findBy = $this->repo->findOneBy(['grupo' => 'Categoria: ' . $category]);
            $instance = $this->repo->model;
            if (!is_string($this->repo->model)) $instance = get_class($this->repo->model);
            $this->assertInstanceOf($instance, $record);
            $this->assertInstanceOf($instance, $findBy);
            $this->assertEquals($findBy->id, $record->id);
        }
    }
}
