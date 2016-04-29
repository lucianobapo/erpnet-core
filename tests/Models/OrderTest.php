<?php

namespace ErpNET\Tests\Models;

use Carbon\Carbon;
use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;

class OrderTest extends ModelsTestCase
{
    protected $testClass = OrderRepositoryInterface::class;

//    protected $testDateFields = ['posted_at'];
    protected $testCarbonFields = ['posted_at'];

    public function loadSignatures(){
        $this->testFieldsSignature = [
            'mandante' => 'teste',
            'posted_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
            'valor_total' => 10,
        ];
    }



//    public function test_relation_with_partner()
//    {
//        $class = $this->app->make($this->testClass);
////        dd($class);
////        dd($class->getEm());
//
////        $partnerClass = $this->app->make(\ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface::class);
////        dd(($class->model));
//
//        $partnerId = factory_orm_create(\ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface::class)->id;
//        $fields = [
//            'partner_id' => $partnerId
//        ];
//
//        // Instantiate, fill with values, save and return
//        $record = factory_orm_create($this->testClass, $fields);
////        $record = factory_orm_make($this->testClass, $fields);
////        dd($fields);
////        dd($record);
//        dd($class->find($record->id));
//        dd($record->getPartner());
////        $this->assertEquals( $record->partner_id, $record->partner->id );
//    }
}
