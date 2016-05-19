<?php namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\SharedOrderTypeRelationsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SharedCurrency extends Model
{
    use SoftDeletes;
//    use MandanteTrait;
//    use GridSortingTrait;
//    use SharedOrderTypeEloquentTrait;
//    use SharedCurrencyRelationsTrait;

    protected $fillable = [
        'nome_universal',
        'descricao',
    ];
}
