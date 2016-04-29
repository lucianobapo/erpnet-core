<?php
namespace ErpNET\Tests\Models;

use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;

class PartnerTest extends ModelsTestCase
{
    protected $testClass = PartnerRepositoryInterface::class;

//    protected $testDateFields = ['data_nascimento'];
    protected $testCarbonFields = ['created_at','updated_at','data_nascimento'];

//    public function test_relation_with_user()
//    {
//        // Instantiate, fill with values, save and return
//        $record = factory($this->testClass)->create();
//        $this->assertEquals( $record->user_id, $record->user->id );
//    }
}
