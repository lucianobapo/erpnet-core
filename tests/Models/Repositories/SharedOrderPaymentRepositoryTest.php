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
use ErpNET\App\Models\RepositoryLayer\SharedOrderPaymentRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;
use ReflectionClass;

class SharedOrderPaymentRepositoryTest extends RepositoryTestCase
{
    protected $testClass = SharedOrderPaymentRepositoryInterface::class;

    public function loadSignatures(){
        $this->testFieldsSignature = [
//            'mandante' => 'teste',
            'pagamento' => 'pag 1',
            'descricao' => 'desc 1',
        ];
    }

    public function testFirstOrCreate(){
//        if (!is_null($this->testFieldsSignature)){
//            $record = $this->repo->create($this->testFieldsSignature);
//            $found = $this->repo->find($record->id);
//            $instance = $this->repo->model;
//            if (!is_string($this->repo->model)) $instance = get_class($this->repo->model);
//            $this->assertInstanceOf($instance, $record);
//            $this->assertInstanceOf($instance, $found);
//            $this->assertEquals($found->id, $record->id);
//        }
    }
}
