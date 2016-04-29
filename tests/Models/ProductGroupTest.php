<?php
namespace ErpNET\Tests\Models;

use Carbon\Carbon;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use ErpNET\App\Models\RepositoryLayer\ProductGroupRepositoryInterface;

class ProductGroupTest extends ModelsTestCase
{
    protected $testClass = ProductGroupRepositoryInterface::class;

//    protected $testDateFields = ['data_nascimento'];
//    protected $testCarbonFields = ['created_at','updated_at'];

    public function loadSignatures(){
        $this->testFieldsSignature = [
            'mandante' => 'teste',
            'grupo' => 'xxx',
        ];
    }


}
