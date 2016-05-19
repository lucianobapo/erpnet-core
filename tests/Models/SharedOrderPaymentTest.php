<?php

namespace ErpNET\Tests\Models;

use ErpNET\App\Models\RepositoryLayer\SharedOrderPaymentRepositoryInterface;

class SharedOrderPaymentTest extends ModelsTestCase
{
    protected $testClass = SharedOrderPaymentRepositoryInterface::class;
//    protected $testCarbonFields = ['created_at','updated_at'];

    public function loadSignatures(){
        $this->testFieldsSignature = [
//            'mandante' => 'teste',
            'pagamento' => 'pag 1',
            'descricao' => 'desc 1',
        ];
    }
}
