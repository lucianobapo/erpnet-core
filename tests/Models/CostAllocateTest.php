<?php

namespace ErpNET\Tests\Models;

use ErpNET\App\Models\RepositoryLayer\CostAllocateRepositoryInterface;

class CostAllocateTest extends ModelsTestCase
{
    protected $testClass = CostAllocateRepositoryInterface::class;
//    protected $testCarbonFields = ['created_at','updated_at'];

    public function loadSignatures(){
        $this->testFieldsSignature = [
            'mandante' => 'teste',
            'nome' => 'cost 1',
            'numero' => '01-01',
            'descricao' => 'descricao 1',
        ];
    }
}
