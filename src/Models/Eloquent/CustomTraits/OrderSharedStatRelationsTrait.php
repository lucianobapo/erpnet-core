<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\Order;
use ErpNET\App\Models\Eloquent\SharedStat;

trait OrderSharedStatRelationsTrait
{
    /**
     * Get the products associated with the given SharedStat.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function sharedStat() {
        return $this->belongsTo(SharedStat::class);
    }

}
