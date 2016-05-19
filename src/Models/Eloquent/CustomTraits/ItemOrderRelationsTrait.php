<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\CostAllocate;
use ErpNET\App\Models\Eloquent\Order;
use ErpNET\App\Models\Eloquent\Product;
use ErpNET\App\Models\Eloquent\SharedCurrency;

trait ItemOrderRelationsTrait
{
    /**
     * An Item Order belongs to an Order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order() {
        return $this->belongsTo(Order::class);
    }

    /**
     * An Item Order belongs to an CostAllocate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cost() {
        return $this->belongsTo(CostAllocate::class);
    }

    /**
     * An Item Order belongs to an CostAllocate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function costAllocate() {
        return $this->belongsTo(CostAllocate::class);
    }

    /**
     * An Item Order belongs to a Product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product() {
        return $this->belongsTo(Product::class);
    }

    /**
     * An Item Order belongs to an SharedCurrency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency() {
        return $this->belongsTo(SharedCurrency::class);
    }

}
