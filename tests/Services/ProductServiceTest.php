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

        // Assertions for Status
        $repoSharedStat = $this->app->make(SharedStatRepositoryInterface::class);
        $recordSharedStat = $repoSharedStat->firstOrCreate(['status' => 'ativado']);
        $this->assertNotNull($recordSharedStat);

        //addProductGroupToStat
        $repoProduct = $this->app->make(ProductRepositoryInterface::class);
        $repoProduct->addProductToStat($recordProduct, $recordSharedStat);


        $this->criarGrupo($recordProduct, ['grupo'=>'Delivery']);

        $return = json_decode($this->service->collectionProductsDelivery());
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

    public function testIfCollectionProductsDeliveryFilterCategory(){
        //Create Product
        $this->testClass = ProductRepositoryInterface::class;
        $recordProduct = $this->factoryTestClass();

        // Assertions for Status
        $repoSharedStat = $this->app->make(SharedStatRepositoryInterface::class);
        $recordSharedStat = $repoSharedStat->firstOrCreate(['status' => 'ativado']);
        $this->assertNotNull($recordSharedStat);

        //addProductGroupToStat
        $repoProduct = $this->app->make(ProductRepositoryInterface::class);
        $repoProduct->addProductToStat($recordProduct, $recordSharedStat);

        $this->criarGrupo($recordProduct, ['grupo'=>'Delivery']);
        $recordCategory = $this->criarGrupo($recordProduct, ['grupo'=>'Categoria: teste']);

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

    /**
     * @param $recordProduct
     * @param array $grupo
     */
    protected function criarGrupo(&$recordProduct, array $grupo=[])
    {
        //Create Category
        $this->testClass = ProductGroupRepositoryInterface::class;
        $recordCategory = $this->factoryTestClass($grupo);

        $repoProductGroup = $this->app->make(ProductGroupRepositoryInterface::class);
        $recordProductGroup = $repoProductGroup->findBy($grupo);
        $this->assertNotNull($recordProductGroup);

        //addProductToGroup
        $repoProduct = $this->app->make(ProductRepositoryInterface::class);
        $repoProduct->addProductToGroup($recordProduct, $recordCategory);

        // Assertions for Status
        $repoSharedStat = $this->app->make(SharedStatRepositoryInterface::class);
        $recordSharedStat = $repoSharedStat->firstOrCreate(['status' => 'ativado']);
        $this->assertNotNull($recordSharedStat);

        //addProductGroupToStat
        $repoProductGroup = $this->app->make(ProductGroupRepositoryInterface::class);
        $repoProductGroup->addProductGroupToStat($recordCategory, $recordSharedStat);

        return $recordCategory;
    }
}
