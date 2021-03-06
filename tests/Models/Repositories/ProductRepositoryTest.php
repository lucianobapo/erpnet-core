<?php
namespace ErpNET\Tests\Models\Repositories;

use ErpNET\App\Models\RepositoryLayer\ProductGroupRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductProductGroupRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductSharedStatRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;
use ReflectionClass;

class ProductRepositoryTest extends RepositoryTestCase
{
    protected $testClass = ProductRepositoryInterface::class;

    public function loadSignatures(){
        $this->testFieldsSignature = [
            'mandante' => 'teste',
            'nome' => 'produto 1',
            'icone' => 'icon',
            'imagem' => 'produto.jpg',
            'promocao' => false,
            'estoque' => false,
            'valorUnitVenda' => 11,
        ];
    }


    public function testRepositoryAddProductToGroup(){
        //Create Product
        $this->testClass = ProductRepositoryInterface::class;
        $recordProduct = $this->factoryTestClass();
        //Create Category
        $this->testClass = ProductGroupRepositoryInterface::class;
        $recordCategory = $this->factoryTestClass(['grupo'=>'Categoria: teste']);
        //addProductToGroup
        $repoProduct = $this->app->make(ProductRepositoryInterface::class);
        $repoProduct->addProductToGroup($recordProduct, $recordCategory);

        $repoProductProductGroup = $this->app->make(ProductProductGroupRepositoryInterface::class);
        $recordProductProductGroup = $repoProductProductGroup->findOneBy(['product_id'=>$recordProduct->id]);

        $this->assertNotNull($recordProductProductGroup);
        $instance = $repoProductProductGroup->model;
        if (!is_string($repoProductProductGroup->model)) $instance = get_class($repoProductProductGroup->model);
        $this->assertInstanceOf($instance, $recordProductProductGroup);

        $this->assertEquals($recordProductProductGroup->product->id, $recordProduct->id);
        $this->assertEquals($recordProductProductGroup->productGroup->id,$recordCategory->id);
        $this->assertEquals($recordProductProductGroup->productGroup->grupo,'Categoria: teste');

//        if (!is_null($this->testFieldsSignature)){
//            //Create Product and Category
//            $this->createProductCategory($recordProduct, $recordCategory, $category);
//
//            $repoProductProductGroup = $this->app->make(ProductProductGroupRepositoryInterface::class);
//            $recordProductProductGroup = $repoProductProductGroup->findOneBy(['product_id'=>$recordProduct->id]);
//
//            $this->assertNotNull($recordProductProductGroup);
//
//            $instance = $repoProductProductGroup->model;
//            if (!is_string($repoProductProductGroup->model)) $instance = get_class($repoProductProductGroup->model);
//            $this->assertInstanceOf($instance, $recordProductProductGroup);
//
//            $this->assertEquals($recordProductProductGroup->product->id, $recordProduct->id);
//            $this->assertEquals($recordProductProductGroup->productGroup->id,$recordCategory->id);
//            $this->assertEquals($recordProductProductGroup->productGroup->grupo,'Categoria: '.$category);
//        }
    }

    public function testRepositoryAddProductToStat(){
        if (!is_null($this->testFieldsSignature)){
            //Create Product and Stat
            $this->createProductStatus($recordProduct, $recordCategory, $recordStat, $stat);

            $repoProductSharedStat = $this->app->make(ProductSharedStatRepositoryInterface::class);
            $recordProductSharedStat = $repoProductSharedStat->findOneBy(['product_id'=>$recordProduct->id]);

            $this->assertNotNull($recordProductSharedStat);

            $instance = $repoProductSharedStat->model;
            if (!is_string($repoProductSharedStat->model)) $instance = get_class($repoProductSharedStat->model);
            $this->assertInstanceOf($instance, $recordProductSharedStat);

            $this->assertEquals($recordProductSharedStat->product->id, $recordProduct->id);
            $this->assertEquals($recordProductSharedStat->sharedStat->id, $recordStat->id);
            $this->assertEquals($recordProductSharedStat->sharedStat->status, $stat);
        }
    }

    protected function createProductCategoryStatus(&$recordProduct = null, &$recordCategory = null, &$recordStat = null)
    {
        //Create Product and Category
        $this->createProductCategory($recordProduct, $recordCategory);
        //Create Status
        $stat = 'ativado';
        $this->createStat($recordProduct, $recordStat, $stat);
    }

    protected function createProductCategory(&$recordProduct = null, &$recordCategory = null, &$category = null)
    {
        //Create Product
        $recordProduct = $this->repo->create($this->testFieldsSignature);
        //Create Category
        $repoCategory = $this->app->make(ProductGroupRepositoryInterface::class);
        $category = str_random();
        $recordCategory = $repoCategory->create([
            'mandante' => 'teste',
            'grupo' => 'Categoria: ' . $category,
        ]);
    }

    protected function createProductStatus(&$recordProduct = null, &$recordCategory = null, &$recordStat = null, &$stat = null)
    {
        //Create Product
        $recordProduct = $this->repo->create($this->testFieldsSignature);
        //Create Stat
        $this->createStat($recordProduct, $recordStat, $stat);
    }

    protected function createStat($recordProduct, &$recordStat = null, &$stat = null)
    {
        //Create Stat
        $repoStat = $this->app->make(SharedStatRepositoryInterface::class);
        if ($stat==null) $stat = str_random();
        $recordStat = $repoStat->create([
            'status' => $stat,
            'descricao' => 'desc 1',
        ]);
        $this->repo->addProductToStat($recordProduct, $recordStat);
    }

}
