<?php
namespace ErpNET\Tests\Models;

use ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface;

class ProductTest extends ModelsTestCase
{
    protected $testClass = ProductRepositoryInterface::class;

//    protected $testDateFields = ['data_nascimento'];
//    protected $testCarbonFields = ['created_at','updated_at'];

    public function loadSignatures(){
        $this->testFieldsSignature = [
            'mandante' => 'teste',
            'nome' => 'produto 1',
            'promocao' => false,
            'estoque' => false,
            'valorUnitVenda' => 10,
        ];
    }


}
