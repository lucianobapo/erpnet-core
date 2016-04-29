<?php
namespace ErpNET\Tests\Models;

use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;

class SharedStatTest extends ModelsTestCase
{
    protected $testClass = SharedStatRepositoryInterface::class;

//    protected $testDateFields = ['data_nascimento'];
//    protected $testCarbonFields = ['created_at','updated_at'];

    public function loadSignatures(){
        $this->testFieldsSignature = [
            'status' => 'status 1',
            'descricao' => 'desc 1',
        ];
    }


}
