<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\Order;
use ErpNET\App\Models\Eloquent\Partner;

trait AddressRelationsTrait
{
    /**
     * Address can have many Orders.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return $this->hasMany(Order::class, 'address_id');
    }

    public function getOrders(){
        return $this->orders();
    }

    /**
     * An Address belongs to a Partner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner() {
        return $this->belongsTo(Partner::class);
    }
}
