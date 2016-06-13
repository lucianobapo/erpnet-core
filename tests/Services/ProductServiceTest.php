<?php
namespace ErpNET\Tests\Services;

use ErpNET\App\Interfaces\OrderServiceInterface;
use ErpNET\App\Interfaces\ProductServiceInterface;
use ErpNET\App\Models\RepositoryLayer\ContactRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\CostAllocateRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductGroupRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductSharedStatRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderSharedStatRepositoryInterface;

class ProductServiceTest extends ServiceTestCase
{
    protected $testServiceClass = ProductServiceInterface::class;
    protected $testClass = ProductRepositoryInterface::class;

    public function loadSignatures(){
        $this->testFieldsSignature = [];
    }

    public function testIfCollectionProductsDeliveryIsJson(){
        $this->assertJson($this->service->collectionProductsDelivery());
    }

    public function testIfCollectionProductsDeliveryHaveRightFields(){
        //Create Product
        $this->testClass = ProductRepositoryInterface::class;
        $recordProduct = $this->factoryTestClass();

        //Create Category
        $this->testClass = ProductGroupRepositoryInterface::class;
        $recordCategory = $this->factoryTestClass();

        //addProductToGroup
        $repoProduct = $this->app->make(ProductRepositoryInterface::class);
        $repoProduct->addProductToGroup($recordProduct, $recordCategory);

        $return = json_decode($this->service->collectionProductsDelivery());
        $this->assertAttributeInternalType('array','data',$return);
        $this->assertAttributeNotCount(0,'data',$return);
        foreach ($return->data as $item) {
            $this->assertAttributeInternalType('int','id',$item);
            $this->assertAttributeInternalType('string','nome',$item);
            $this->assertAttributeInternalType('string','imagem',$item);
            $this->assertAttributeGreaterThanOrEqual(0,'max',$item);
            $this->assertAttributeGreaterThanOrEqual(0,'valor',$item);
        }
    }

    public function testIfCollectionProductsDeliveryFilterCategory(){
        //Create Product
        $this->testClass = ProductRepositoryInterface::class;
        $recordProduct = $this->factoryTestClass();

        //Create Category
        $this->testClass = ProductGroupRepositoryInterface::class;
        $recordCategory = $this->factoryTestClass(['grupo'=>'Categoria: teste']);
        //addProductToGroup
        $repoProduct = $this->app->make(ProductRepositoryInterface::class);
        $repoProduct->addProductToGroup($recordProduct, $recordCategory);

        //Create Category
        $this->testClass = ProductGroupRepositoryInterface::class;
        $repoProductGroup = $this->app->make($this->testClass);
        if (is_null($recordDelivery = $repoProductGroup->findOneBy(['grupo'=>'Delivery'])))
            $recordDelivery = $this->factoryTestClass(['grupo'=>'Delivery']);
        //addProductToGroup
        $repoProduct = $this->app->make(ProductRepositoryInterface::class);
        $repoProduct->addProductToGroup($recordProduct, $recordDelivery);

        //Create Category
        $this->testClass = SharedStatRepositoryInterface::class;
        $repoSharedStat = $this->app->make($this->testClass);
        if (is_null($recordSharedStat = $repoSharedStat->findOneBy(['status'=>'ativado'])))
            $recordSharedStat = $this->factoryTestClass(['status'=>'ativado']);
        //addProductToStat
        $repoProduct = $this->app->make(ProductRepositoryInterface::class);
        $repoProduct->addProductToStat($recordProduct, $recordSharedStat);

        $collection = $this->service->collectionProductsDelivery($recordCategory->id);
        $this->assertJson($collection);

        $return = json_decode($collection);
//        var_dump($return);
        $this->assertAttributeInternalType('array','data',$return);
        $this->assertAttributeNotCount(0,'data',$return);
        foreach ($return->data as $item) {
            $this->assertAttributeInternalType('int','id',$item);
            $this->assertAttributeInternalType('string','nome',$item);
//            $this->assertAttributeInternalType('string','imagem',$item);
            $this->assertAttributeGreaterThanOrEqual(0,'max',$item);
            $this->assertAttributeGreaterThanOrEqual(0,'valor',$item);
        }
    }
}
