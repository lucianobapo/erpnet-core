<?php
namespace ErpNET\Tests\Services;

use ErpNET\App\Interfaces\PartnerServiceInterface;
use ErpNET\App\Models\RepositoryLayer\AddressRepositoryInterface;
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
        //addUserToPartner
        $repoPartner = $this->app->make(PartnerRepositoryInterface::class);
        $repoPartner->addUserToPartner($recordUser, $recordPartner);

        //Create Contact
        $this->testClass = ContactRepositoryInterface::class;
        $recordContact = $this->factoryTestClass();
        //addPartnerToContact
        $repoContact = $this->app->make(ContactRepositoryInterface::class);
        $repoContact->addPartnerToContact($recordPartner, $recordContact);

        //Create Contact
        $this->testClass = ContactRepositoryInterface::class;
        $recordContact = $this->factoryTestClass();
        //addPartnerToContact
        $repoContact = $this->app->make(ContactRepositoryInterface::class);
        $repoContact->addPartnerToContact($recordPartner, $recordContact);

        //Create Address
        $this->testClass = AddressRepositoryInterface::class;
        $recordAddress = $this->factoryTestClass();
        //addPartnerToAddress
        $repoAddress = $this->app->make(AddressRepositoryInterface::class);
        $repoAddress->addPartnerToAddress($recordPartner, $recordAddress);

        //Create Address
        $this->testClass = AddressRepositoryInterface::class;
        $recordAddress = $this->factoryTestClass();
        //addPartnerToAddress
        $repoAddress = $this->app->make(AddressRepositoryInterface::class);
        $repoAddress->addPartnerToAddress($recordPartner, $recordAddress);

        $foundPartner = $this->service->jsonPartnerProviderId($recordUser->provider_id);

        $this->assertJson($foundPartner);
    }
}
