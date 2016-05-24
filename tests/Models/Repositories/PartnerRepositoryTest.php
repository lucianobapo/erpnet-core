<?php
namespace ErpNET\Tests\Models\Repositories;

use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\UserRepositoryInterface;

class PartnerRepositoryTest extends RepositoryTestCase
{
    protected $testClass = PartnerRepositoryInterface::class;

    public function loadSignatures(){
        $this->testFieldsSignature = [
//            'mandante' => 'teste',
//            'grupo' => 'xxx',
        ];
    }

    public function testRepositoryAddUserToPartner(){
        //Create User
        $this->testClass = UserRepositoryInterface::class;
        $recordUser = $this->factoryTestClass();

        //Create Partner
        $this->testClass = PartnerRepositoryInterface::class;
        $recordPartner = $this->factoryTestClass();

        $repoPartner = $this->app->make(PartnerRepositoryInterface::class);
        $repoPartner->addUserToPartner($recordUser, $recordPartner);

        $foundPartner = $repoPartner->find($recordPartner->id);
        $this->assertNotNull($foundPartner);

        $instance = $repoPartner->model;
        if (!is_string($instance)) $instance = get_class($instance);
        $this->assertInstanceOf($instance, $foundPartner);

        $this->assertEquals($foundPartner->user->id, $recordUser->id);

//        $repoUser = $this->app->make(UserRepositoryInterface::class);
//        $foundUser = $repoUser->find($recordUser->id);
//        $this->assertNotNull($foundUser);
//        $instance = $repoUser->model;
//        if (!is_string($instance)) $instance = get_class($instance);
//
//        $this->assertInstanceOf($instance, $foundUser);
//        $this->assertNotNull($foundUser->partner);
//        $this->assertEquals($foundUser->partner->id, $recordPartner->id);

    }
}
