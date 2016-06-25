<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\Product;
use ErpNET\App\Models\Eloquent\SharedStat;

trait ProductGroupRelationsTrait
{
    /**
     * Get the products associated with the given ProductGroup.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products() {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    /**
     * Get the status associated with the given ProductGroup.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function status() {
        return $this->belongsToMany(SharedStat::class)->withTimestamps();
    }

    /**
     * Get the status associated with the given ProductGroup.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getProductGroupSharedStats() {
        return $this->status();
    }

}
