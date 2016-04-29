<?php

namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\CostAllocateEloquentTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\CostAllocateRelationsTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\GridSortingTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\MandanteTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostAllocate extends Model
{
    use SoftDeletes;
    use MandanteTrait;
//    use GridSortingTrait;
    use CostAllocateEloquentTrait;
    use CostAllocateRelationsTrait;

    /**
     * Fillable fields for a Model.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'nome',
        'numero',
        'descricao',
    ];


}
