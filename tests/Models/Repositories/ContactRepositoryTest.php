<?php
namespace ErpNET\Tests\Models\Repositories;

use Carbon\Carbon;
use ErpNET\App\Models\Doctrine\Repositories\PartnerRepositoryDoctrine;
use ErpNET\App\Models\RepositoryLayer\AddressRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ContactRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ItemOrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductGroupRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductProductGroupRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductSharedStatRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;
use ReflectionClass;

class ContactRepositoryTest extends RepositoryTestCase
{
    protected $testClass = ContactRepositoryInterface::class;

    public function loadSignatures(){
        $this->testFieldsSignature = [
//            'mandante' => 'teste',
//            'posted_at' => Carbon::now(),
        ];
    }

    public function testRepositoryAddPartnerToContact(){
        //Create Contact
        $this->testClass = ContactRepositoryInterface::class;
        $recordContact = $this->factoryTestClass();

        //Create Partner
        $this->testClass = PartnerRepositoryInterface::class;
        $recordPartner = $this->factoryTestClass();

        $repoContact = $this->app->make(ContactRepositoryInterface::class);
        $repoContact->addPartnerToContact($recordPartner, $recordContact);

        $foundContact = $repoContact->find($recordContact->id);
        $this->assertNotNull($foundContact);

        $instance = $repoContact->model;
        if (!is_string($instance)) $instance = get_class($instance);
        $this->assertInstanceOf($instance, $foundContact);

        $this->assertEquals($foundContact->partner->id, $recordPartner->id);

    }
}
