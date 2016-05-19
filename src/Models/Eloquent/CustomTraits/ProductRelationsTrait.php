<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\CostAllocate;
use ErpNET\App\Models\Eloquent\ItemOrder;
use ErpNET\App\Models\Eloquent\ProductGroup;
use ErpNET\App\Models\Eloquent\SharedStat;

trait ProductRelationsTrait
{
    /**
     * A Product belongs to a CostAllocate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cost() {
        return $this->belongsTo(CostAllocate::class);
    }
    public function costAllocate() {
        return $this->cost();
    }

    /**
     * Partner can have many orders.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemOrders(){
        return $this->hasMany(ItemOrder::class);
    }

    /**
     * Get the groups associated with the given product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups() {
        return $this->belongsToMany(ProductGroup::class)->withTimestamps();
    }

    /**
     * Get the groups associated with the given product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getProductProductGroups() {
        return $this->groups();
    }

    /**
     * Get the status associated with the given Product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function status() {
        return $this->belongsToMany(SharedStat::class)->withTimestamps();
    }

    /**
     * Get the status associated with the given Product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getProductSharedStats() {
        return $this->status();
    }

}
