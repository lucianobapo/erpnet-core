<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\ItemOrder;

trait CostAllocateRelationsTrait
{
    /**
     * CostAllocate can have many itemOrders.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemOrders(){
        return $this->hasMany(ItemOrder::class, 'cost_id');
    }
}
