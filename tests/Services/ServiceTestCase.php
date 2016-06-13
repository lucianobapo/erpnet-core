<?php
namespace ErpNET\Tests\Services;

use ErpNET\Tests\TestCase;
use League\FactoryMuffin\Facade as FactoryMuffin;

class ServiceTestCase extends TestCase
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
}
