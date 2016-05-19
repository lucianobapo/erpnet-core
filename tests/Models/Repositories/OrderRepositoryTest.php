<?php
namespace ErpNET\Tests\Models\Repositories;

use Carbon\Carbon;
use ErpNET\App\Models\Doctrine\Repositories\PartnerRepositoryDoctrine;
use ErpNET\App\Models\RepositoryLayer\AddressRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ItemOrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductGroupRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductProductGroupRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductSharedStatRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;
use ReflectionClass;

class OrderRepositoryTest extends RepositoryTestCase
{
    protected $testClass = OrderRepositoryInterface::class;

    public function loadSignatures(){
        $this->testFieldsSignature = [
//            'mandante' => 'teste',
            'posted_at' => Carbon::now(),
        ];
    }

//    public function testIfCollectionProductsDeliveryIsJson(){
//        $this->assertJson($this->repo->collectionProductsDelivery());
//    }

//    public function testIfCollectionProductsDeliveryHaveRightFields(){
//        $this->createProductCategoryStatus();
//
//        $return = json_decode($this->repo->collectionProductsDelivery());
//        $this->assertAttributeInternalType('array','data',$return);
//        $this->assertAttributeNotCount(0,'data',$return);
//        foreach ($return->data as $item) {
//            $this->assertAttributeInternalType('int','id',$item);
//            $this->assertAttributeInternalType('string','nome',$item);
//            $this->assertAttributeInternalType('string','imagem',$item);
//            $this->assertAttributeInternalType('int','max',$item);
//            $this->assertAttributeNotEmpty('valor',$item);
//        }
//    }
//
//    public function testIfCollectionProductsDeliveryFilterCategory(){
//        if (!is_null($this->testFieldsSignature)){
//            $this->createProductCategoryStatus($recordProduct, $recordCategory);
//
//            $collection = $this->repo->collectionProductsDelivery($recordCategory->id);
//            $this->assertJson($collection);
//
//            $return = json_decode($collection);
//            $this->assertAttributeInternalType('array','data',$return);
//            $this->assertAttributeNotCount(0,'data',$return);
//            foreach ($return->data as $item) {
//                $this->assertAttributeInternalType('int','id',$item);
//                $this->assertAttributeInternalType('string','nome',$item);
//                $this->assertAttributeInternalType('string','imagem',$item);
//                $this->assertAttributeInternalType('int','max',$item);
//                $this->assertAttributeNotEmpty('valor',$item);
//            }
//        }
//    }
//
    public function testRepositoryAddOrderToItem(){
        if (!is_null($this->testFieldsSignature)){
            //Create Order
            $recordOrder = $this->repo->create($this->testFieldsSignature);

            //Create itemOrder
            $repoItemOrder = $this->app->make(ItemOrderRepositoryInterface::class);
            $recordItemOrder = $repoItemOrder->create([
                'quantidade' => 1,
                'valor_unitario' => 10,
            ]);
            $this->repo->addOrderToItem($recordOrder, $recordItemOrder);

            $foundOrder = $this->repo->find($recordOrder->id);
            $this->assertNotNull($foundOrder);
            $instance = $this->repo->model;
            if (!is_string($this->repo->model)) $instance = get_class($this->repo->model);
            $this->assertInstanceOf($instance, $foundOrder);
            $this->assertEquals($recordItemOrder->order->id, $foundOrder->id);

            $foundItemOrder = $repoItemOrder->findOneBy(['order_id'=>$foundOrder->id]);
            $this->assertNotNull($foundItemOrder);
            $instance = $repoItemOrder->model;
            if (!is_string($repoItemOrder->model)) $instance = get_class($repoItemOrder->model);
            $this->assertInstanceOf($instance, $foundItemOrder);
            $this->assertEquals($foundItemOrder->order->id, $foundOrder->id);

            $this->assertNotEmpty($foundOrder->valor_total);
        }
    }
    public function testRepositoryAddAddressToOrder(){
        if (!is_null($this->testFieldsSignature)){
            //Create Order
            $recordOrder = $this->repo->create($this->testFieldsSignature);

            //Create itemOrder
            $repoAddress = $this->app->make(AddressRepositoryInterface::class);
            $recordAddress = $repoAddress->create([
                'cep' => '2889000',
                'logradouro' => 'rua a',
                'numero' => '123',
            ]);
            $this->repo->addAddressToOrder($recordAddress, $recordOrder);

            $foundOrder = $this->repo->find($recordOrder->id);
            $this->assertNotNull($foundOrder);
            $instance = $this->repo->model;
            if (!is_string($this->repo->model)) $instance = get_class($this->repo->model);
            $this->assertInstanceOf($instance, $foundOrder);

            $foundAddress = $repoAddress->find($recordAddress->id);
            $this->assertNotNull($foundAddress);
            $instance = $repoAddress->model;
            if (!is_string($repoAddress->model)) $instance = get_class($repoAddress->model);
            $this->assertInstanceOf($instance, $foundAddress);

            $this->assertEquals($foundOrder->address->id, $foundAddress->id);
        }
    }
    public function testRepositoryAddPartnerToOrder(){
        if (!is_null($this->testFieldsSignature)){
            //Create Order
            $recordOrder = $this->repo->create($this->testFieldsSignature);

            //Create itemOrder
            $repoPartner = $this->app->make(PartnerRepositoryInterface::class);
            $recordPartner = $repoPartner->create([
                'nome' => 'fulano',
            ]);
            $this->repo->addPartnerToOrder($recordPartner, $recordOrder);

            $foundOrder = $this->repo->find($recordOrder->id);
            $this->assertNotNull($foundOrder);
            $instance = $this->repo->model;
            if (!is_string($this->repo->model)) $instance = get_class($this->repo->model);
            $this->assertInstanceOf($instance, $foundOrder);

            $foundPartner = $repoPartner->find($recordPartner->id);
            $this->assertNotNull($foundPartner);
            $instance = $repoPartner->model;
            if (!is_string($repoPartner->model)) $instance = get_class($repoPartner->model);
            $this->assertInstanceOf($instance, $foundPartner);

            $this->assertEquals($foundOrder->partner->id, $foundPartner->id);
        }
    }
//
//    public function testRepositoryAddProductToStat(){
//        if (!is_null($this->testFieldsSignature)){
//            //Create Product and Stat
//            $this->createProductStatus($recordProduct, $recordCategory, $recordStat, $stat);
//
//            $repoProductSharedStat = $this->app->make(ProductSharedStatRepositoryInterface::class);
//            $recordProductSharedStat = $repoProductSharedStat->findOneBy(['product_id'=>$recordProduct->id]);
//
//            $this->assertNotNull($recordProductSharedStat);
//
//            $instance = $repoProductSharedStat->model;
//            if (!is_string($repoProductSharedStat->model)) $instance = get_class($repoProductSharedStat->model);
//            $this->assertInstanceOf($instance, $recordProductSharedStat);
//
//            $this->assertEquals($recordProductSharedStat->product->id, $recordProduct->id);
//            $this->assertEquals($recordProductSharedStat->sharedStat->id, $recordStat->id);
//            $this->assertEquals($recordProductSharedStat->sharedStat->status, $stat);
//        }
//    }
//
//    protected function createProductCategoryStatus(&$recordProduct = null, &$recordCategory = null, &$recordStat = null)
//    {
//        //Create Product and Category
//        $this->createProductCategory($recordProduct, $recordCategory);
//        //Create Status
//        $stat = 'ativado';
//        $this->createStat($recordProduct, $recordStat, $stat);
//    }
//
//    protected function createProductCategory(&$recordProduct = null, &$recordCategory = null, &$category = null)
//    {
//        //Create Product
//        $recordProduct = $this->repo->create($this->testFieldsSignature);
//        //Create Category
//        $repoCategory = $this->app->make(ProductGroupRepositoryInterface::class);
//        $category = str_random();
//        $recordCategory = $repoCategory->create([
//            'mandante' => 'teste',
//            'grupo' => 'Categoria: ' . $category,
//        ]);
//        $this->repo->addProductToGroup($recordProduct, $recordCategory);
//    }
//
//    protected function createProductStatus(&$recordProduct = null, &$recordCategory = null, &$recordStat = null, &$stat = null)
//    {
//        //Create Product
//        $recordProduct = $this->repo->create($this->testFieldsSignature);
//        //Create Stat
//        $this->createStat($recordProduct, $recordStat, $stat);
//    }
//
//    protected function createStat($recordProduct, &$recordStat = null, &$stat = null)
//    {
//        //Create Stat
//        $repoStat = $this->app->make(SharedStatRepositoryInterface::class);
//        if ($stat==null) $stat = str_random();
//        $recordStat = $repoStat->create([
//            'status' => $stat,
//            'descricao' => 'desc 1',
//        ]);
//        $this->repo->addProductToStat($recordProduct, $recordStat);
//    }

}
