<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 24/04/16
 * Time: 04:14
 */

namespace ErpNET\App\Models\Doctrine\Repositories;

use ErpNET\App\Models\RepositoryLayer\ItemOrderRepositoryInterface;

class ItemOrderRepositoryDoctrine extends BaseEntityRepository implements ItemOrderRepositoryInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'mandante',
//        'order_id',
//        'cost_id',
//        'product_id',
//        'currency_id',
        'quantidade',
        'valor_unitario',
//        'desconto_unitario',
//        'descricao',
    ];

    /**
     * @param \ErpNET\App\Models\Eloquent\Product | \ErpNET\App\Models\Doctrine\Entities\Product $product
     * @param \ErpNET\App\Models\Eloquent\ItemOrder | \ErpNET\App\Models\Doctrine\Entities\ItemOrder $itemOrder
     */
    public function addProductToItem($product, $itemOrder)
    {
        $itemOrder->setProduct($product);

        $this->_em->persist($itemOrder);
        $this->_em->flush();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\CostAllocate | \ErpNET\App\Models\Doctrine\Entities\CostAllocate $costAllocate
     * @param \ErpNET\App\Models\Eloquent\ItemOrder | \ErpNET\App\Models\Doctrine\Entities\ItemOrder $itemOrder
     */
    public function addCostAllocateToItem($costAllocate, $itemOrder)
    {
        $itemOrder->setCostAllocate($costAllocate);

        $this->_em->persist($itemOrder);
        $this->_em->flush();
    }

    /**
     * @param \ErpNET\App\Models\Eloquent\SharedCurrency | \ErpNET\App\Models\Doctrine\Entities\SharedCurrency $sharedCurrency
     * @param \ErpNET\App\Models\Eloquent\ItemOrder | \ErpNET\App\Models\Doctrine\Entities\ItemOrder $itemOrder
     */
    public function addSharedCurrencyToItem($sharedCurrency, $itemOrder)
    {
        $itemOrder->setSharedCurrency($sharedCurrency);

        $this->_em->persist($itemOrder);
        $this->_em->flush();
    }
}