<?php

namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\SummaryProductContentRelationsTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\GridSortingTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\MandanteTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\SyncItemsTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SummaryProductContent extends Model
{
    use SoftDeletes;
    use MandanteTrait;
//    use GridSortingTrait;
//    use SyncItemsTrait;
//    use SummaryProductContentRelationsTrait;

    /**
     * Fillable fields for a Model.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'stock_quantity',
    ];

    /**
     * Additional fields to treat as Carbon instances.
     *
     * @var array
     */
//    protected $dates = ['start_date','end_date'];


}
