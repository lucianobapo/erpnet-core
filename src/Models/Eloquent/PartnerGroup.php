<?php

namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\PartnerGroupRelationsTrait;
//use ErpNET\App\Models\Eloquent\CustomTraits\GridSortingTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\MandanteTrait;
//use ErpNET\App\Models\Eloquent\CustomTraits\SyncItemsTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerGroup extends Model
{
    use SoftDeletes;
    use MandanteTrait;
//    use GridSortingTrait;
//    use SyncItemsTrait;
    use PartnerGroupRelationsTrait;

    /**
     * Fillable fields for a Model.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'grupo',
    ];
}
