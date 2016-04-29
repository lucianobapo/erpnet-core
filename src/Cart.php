<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 17:14
 */

namespace ErpNET\App;

use ErpNET\App\Entities\ProductInterface;

class Cart
{
    protected $products;

    public function __construct()
    {
        $this->products = new \ArrayObject();
    }

    /**
     * @return \ArrayObject
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param ProductInterface $products
     */
    public function addProduct(ProductInterface $products)
    {
        $this->products->append($products);
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }

        return $total;
    }
}