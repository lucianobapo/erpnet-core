<?php
namespace ErpNET\Tests\Models\Repositories;

use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;

class PartnerRepositoryTest extends RepositoryTestCase
{
    protected $testClass = PartnerRepositoryInterface::class;

    public function loadSignatures(){
        $this->testFieldsSignature = [
//            'mandante' => 'teste',
//            'grupo' => 'xxx',
        ];
    }

//    public function testIfCollectionCategoriasIsJson(){
////        $this->assertJson($this->repo->partnerProfileId(1));
//    }
}
