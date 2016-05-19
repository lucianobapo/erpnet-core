<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\Order;
use ErpNET\App\Models\Eloquent\Partner;

trait ContactRelationsTrait
{
    /**
     * Contact can have many Orders.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return $this->hasMany(Order::class, 'address_id');
    }

    public function getOrders(){
        return $this->orders();
    }

    /**
     * A Contact belongs to a Partner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner() {
        return $this->belongsTo(Partner::class);
    }
}
