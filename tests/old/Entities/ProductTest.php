<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 16:49
 */

namespace ErpNET\Tests\Entities;


use ErpNET\App\Entities\Product;
use ErpNET\App\Entities\ProductInterface;
use ErpNET\Tests\TestCase;

class ProductTest extends TestCase
{
    public function testProductType()
    {
        $product = new Product();
        $this->assertInstanceOf(ProductInterface::class, $product);
    }

    public function testProductName()
    {
        $product = new Product();
        $product->setName('Product 1');
        $name = $product->getName();
        $this->assertEquals('Product 1', $name);
    }

    public function testDescriptionValue()
    {
        $product = new Product();
        $product->setDescription('Desc 1');
        $this->assertEquals('Desc 1',  $product->getDescription());
    }
    public function testPriceValue()
    {
        $product = new Product();
        $product->setPrice(10);
        $this->assertEquals(10,  $product->getPrice());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPriceValueWhenNotNumericGiven()
    {
        $product = new Product();
        $product->setPrice('invalid');
//        $this->assertEquals(10,  $product->getPrice());
    }
}