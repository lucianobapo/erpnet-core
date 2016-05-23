<?php
namespace ErpNET\Tests\Services;

use ErpNET\App\Interfaces\PartnerServiceInterface;
use ErpNET\App\Models\RepositoryLayer\ContactRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\CostAllocateRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderSharedStatRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\UserRepositoryInterface;

class PartnerServiceTest extends ServiceTestCase
{
    protected $testServiceClass = PartnerServiceInterface::class;
    protected $testClass = PartnerRepositoryInterface::class;

    public function loadSignatures(){
        $this->testFieldsSignature = [
        ];
    }

    public function testPartnerProviderId(){
        //Create Partner
        $this->testClass = PartnerRepositoryInterface::class;
        $recordPartner = $this->factoryTestClass();


        //Create User
        $this->testClass = UserRepositoryInterface::class;
        $recordUser = $this->factoryTestClass();


        $repoPartner = $this->app->make(PartnerRepositoryInterface::class);
        $repoPartner->addUserToPartner($recordUser, $recordPartner);

        $foundPartner = $this->service->jsonPartnerProviderId($recordUser->provider_id);
        $this->assertJson($foundPartner);
    }
}
