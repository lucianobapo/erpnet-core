<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\Order;

trait SharedOrderTypeRelationsTrait
{
    /**
     * SharedOrderType can have many orders.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return $this->hasMany(Order::class,'type_id');
    }
}
