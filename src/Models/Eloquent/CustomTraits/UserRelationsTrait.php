<?php

namespace ErpNET\App\Models\Eloquent\CustomTraits;

use ErpNET\App\Models\Eloquent\Contact;
use ErpNET\App\Models\Eloquent\Order;
use ErpNET\App\Models\Eloquent\Partner;

trait UserRelationsTrait
{
    /**
     * User can have one partner.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function partner(){
        return $this->hasOne(Partner::class);
    }
}
