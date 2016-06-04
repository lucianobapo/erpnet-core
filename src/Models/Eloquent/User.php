<?php

namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\UserRelationsTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\GridSortingTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\MandanteTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\SyncItemsTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    use MandanteTrait;
//    use GridSortingTrait;
//    use SyncItemsTrait;
    use UserRelationsTrait;

    /**
     * Fillable fields for a Model.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'name',
        'email',
        'provider',
        'avatar',
        'provider_id',
    ];

    /**
     * Additional fields to treat as Carbon instances.
     *
     * @var array
     */
//    protected $dates = ['data_nascimento'];


}
