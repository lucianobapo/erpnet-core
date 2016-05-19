<?php

namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\ContactRelationsTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\GridSortingTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\MandanteTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;
    use MandanteTrait;
//    use GridSortingTrait;
//    use AddressEloquentTrait;
    use ContactRelationsTrait;

    /**
     * Fillable fields for a Model.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'contact_type',
        'contact_data',
    ];
}
