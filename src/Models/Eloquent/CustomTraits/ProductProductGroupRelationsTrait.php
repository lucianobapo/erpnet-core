<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\Product;
use ErpNET\App\Models\Eloquent\ProductGroup;

trait ProductProductGroupRelationsTrait
{
    /**
     * Get the products associated with the given ProductGroup.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function productGroup() {
        return $this->belongsTo(ProductGroup::class);
    }

}
