<?php

namespace ErpNET\Tests\Models;

use ErpNET\App\Models\RepositoryLayer\AddressRepositoryInterface;

class AddressTest extends ModelsTestCase
{
    protected $testClass = AddressRepositoryInterface::class;
//    protected $testCarbonFields = ['created_at','updated_at'];

    public function loadSignatures(){
        $this->testFieldsSignature = [
            'mandante' => 'teste',
            'cep' => '28890000',
            'logradouro' => 'rua a',
            'numero' => '123',
            'bairro' => 'bairro b',
        ];
    }
}
