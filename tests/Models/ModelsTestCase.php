<?php
namespace ErpNET\Tests\Models;

use ErpNET\Tests\TestCase;
use League\FactoryMuffin\Facade as FactoryMuffin;

class ModelsTestCase extends TestCase
{

    protected $testDateFields = [];
    protected $testCarbonFields = [];

    public static function setupBeforeClass()
    {
        // note that method chaining is supported
        FactoryMuffin::setCustomSetter(function ($object, $name, $value) {
            $functionName = camel_case("set-".$name);
            if (method_exists($object, $functionName) && is_callable([$object, $functionName]))
                call_user_func([$object, $functionName], $value);
            else {
                dd(get_class($object).' dont have '.camel_case("set-".$name));
            }
        });
    }

    protected function prepareForTests()
    {
        parent::prepareForTests();
        if (!is_null($this->app) && !is_null($this->testClass)){
            $class = $this->app->make($this->testClass);
            if ($class instanceof \Doctrine\ORM\EntityRepository){
                $em = $class->em;
                FactoryMuffin::setCustomSaver(function ($entity) use ($em) {
                    $em->persist($entity);
                    $em->flush();
                    return true;
                });
            }
        }
    }

    public function test_sample_factory()
    {
        if (!is_null($this->repo)) {
            $record = factory_orm_create($this->testClass);
            if (!isset($this->repo->table)) {
                $this->markTestSkipped(
                    "No table - ".get_class($this->repo)
                );
            }
            $instance = $this->repo->model;
            if (!is_string($this->repo->model)) $instance = get_class($this->repo->model);
            $this->assertInstanceOf($instance, $record);
            $this->assertEquals($this->repo->find($record->id)->id,$record->id);
//            $this->seeInDatabase($class->table, ['id'=>$record->id]);
        }
    }

    public function test_date_fields()
    {
        if (count($this->testDateFields)>0) {
            foreach($this->testDateFields as $field){
                // Instantiate, fill with values, save and return
                $record = factory_orm_create($this->testClass);

                // Regular expression that represents d/m/Y pattern
                $expected = '/\d{2}\/\d{2}\/\d{4}/';

                // True if preg_match finds the pattern
                $matches = ( preg_match($expected, $record->$field) ) ? true : false;

                $this->assertTrue( $matches );
            }
        }
    }

    public function test_carbon_fields()
    {
        if (count($this->testCarbonFields)>0) {
            foreach($this->testCarbonFields as $field){
                // Instantiate, fill with values, save and return
                $record = factory_orm_create($this->testClass);

                // True if preg_match finds the pattern
                $matches = ( $record->$field instanceof \Carbon\Carbon ) ? true : false;
                if (!$matches){
                    var_dump($this->testClass);
                    var_dump(get_class($record));
                    var_dump ($field);
                    var_dump ($record->$field);
                    $this->markTestSkipped(
                        "Field is not carbon."
                    );
                }
                $this->assertTrue( $matches );
            }
        }
    }

    public function testSoftDelete(){
        if (!is_null($this->testFieldsSignature)){
            $record = $this->repo->create($this->testFieldsSignature);
            $this->repo->delete($record->id);
            $this->assertNull($this->repo->find($record->id));
            $this->repo->restore($record->id);
            $instance = $this->repo->model;
            if (!is_string($this->repo->model)) $instance = get_class($this->repo->model);
            $restored = $this->repo->find($record->id);
            $this->assertInstanceOf($instance, $restored);
            $this->assertEquals($record->id, $restored->id);
        }
    }

    public function testCreate(){
        if (!is_null($this->testFieldsSignature)){
            $record = $this->repo->create($this->testFieldsSignature);
            $found = $this->repo->find($record->id);
            $instance = $this->repo->model;
            if (!is_string($this->repo->model)) $instance = get_class($this->repo->model);
            $this->assertInstanceOf($instance, $record);
            $this->assertInstanceOf($instance, $found);
            $this->assertEquals($found->id, $record->id);
        }
    }
}
