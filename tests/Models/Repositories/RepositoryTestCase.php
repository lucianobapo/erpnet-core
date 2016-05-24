<?php
namespace ErpNET\Tests\Models\Repositories;

use ErpNET\Tests\TestCase;
use League\FactoryMuffin\Facade as FactoryMuffin;

class RepositoryTestCase extends TestCase
{
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

    protected function factoryTestClass()
    {
        $record = factory_orm_create($this->testClass);
        $repo = $this->app->make($this->testClass);
        if (!isset($repo->table)) {
            $this->markTestSkipped(
                "No table - ".get_class($repo)
            );
        }
        $instance = $repo->model;
        if (!is_string($instance)) $instance = get_class($instance);
        $this->assertInstanceOf($instance, $record);
        $this->assertEquals($repo->find($record->id)->id,$record->id);

        return $record;
    }
}
