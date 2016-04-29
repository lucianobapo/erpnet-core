<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\Product;
use ErpNET\App\Models\Eloquent\SharedStat;

trait ProductSharedStatRelationsTrait
{
    /**
     * Get the products associated with the given SharedStat.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function sharedStat() {
        return $this->belongsTo(SharedStat::class);
    }

}
