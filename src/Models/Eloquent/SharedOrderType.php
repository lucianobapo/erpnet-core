<?php namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\SharedOrderTypeRelationsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SharedOrderType extends Model
{
    use SoftDeletes;
//    use MandanteTrait;
//    use GridSortingTrait;
//    use SharedOrderTypeEloquentTrait;
    use SharedOrderTypeRelationsTrait;

    protected $fillable = [
        'tipo',
        'descricao',
    ];
}
