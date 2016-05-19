<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\Address;
use ErpNET\App\Models\Eloquent\ItemOrder;
use ErpNET\App\Models\Eloquent\Partner;
use ErpNET\App\Models\Eloquent\SharedCurrency;
use ErpNET\App\Models\Eloquent\SharedOrderPayment;
use ErpNET\App\Models\Eloquent\SharedOrderType;
use ErpNET\App\Models\Eloquent\SharedStat;

trait OrderRelationsTrait
{
    /**
     * An Order belongs to a Partner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner() {
        return $this->belongsTo(Partner::class);
    }

    /**
     * An Order belongs to a Address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address() {
        return $this->belongsTo(Address::class);
    }

    /**
     * An Order belongs to a SharedCurrency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency() {
        return $this->belongsTo(SharedCurrency::class);
    }

    /**
     * An Order belongs to an Order Type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type() {
        return $this->belongsTo(SharedOrderType::class,'type_id');
    }

    /**
     * An Order belongs to an Order Type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sharedOrderType() {
        return $this->type();
    }

    /**
     * An Order belongs to an Order Payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment() {
        return $this->belongsTo(SharedOrderPayment::class,'payment_id');
    }

    /**
     * An Order belongs to an Order Payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sharedOrderPayment() {
        return $this->payment();
    }


    /**
     * Get the status associated with the given order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function status() {
        return $this->belongsToMany(SharedStat::class)->withTimestamps();
    }

    /**
     * Order can have many items.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems(){
        return $this->hasMany(ItemOrder::class);
    }

    /**
     * Order can have many items.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemOrders(){
        return $this->hasMany(ItemOrder::class);
    }

    /**
     * Order can have many confirmations.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function confirmations(){
//        return $this->hasMany(ErpNET\App\Models\OrderConfirmation::class);
    }

    /**
     * Order can have many attachments.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments(){
//        return $this->hasMany(ErpNET\App\Models\Attachment::class);
    }

}
