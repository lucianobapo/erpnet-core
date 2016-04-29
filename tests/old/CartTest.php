<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 17:14
 */

namespace ErpNET\Tests;

use ErpNET\App\Cart;
use ErpNET\App\Entities\Product;

class CartTest extends TestCase
{
    public function testGetProductList()
    {
        $product = new Product();
        $product->setName('Product 1');
        $product->setDescription('Desc 1');
        $product->setPrice(10);

        $product2 = new Product();
        $product2->setName('Product 2');
        $product2->setDescription('Desc 2');
        $product2->setPrice(20);

        $cart = new Cart();
        $cart->addProduct($product);
        $cart->addProduct($product2);

        $products = new \ArrayObject([$product, $product2]);

        $this->assertEquals($products, $cart->getProducts());
    }

    public function testGetTotal()
    {
        $product = new Product();
        $product->setName('Product 1');
        $product->setDescription('Desc 1');
        $product->setPrice(10);

        $product2 = new Product();
        $product2->setName('Product 2');
        $product2->setDescription('Desc 2');
        $product2->setPrice(20);

        $cart = new Cart();
        $cart->addProduct($product);
        $cart->addProduct($product2);

        $total = 30;

        $this->assertEquals($total, $cart->getTotal());
    }
}