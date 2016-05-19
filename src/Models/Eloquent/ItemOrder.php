<?php

namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\ItemOrderEloquentTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\ItemOrderRelationsTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\MandanteTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemOrder extends Model
{
    use SoftDeletes;
    use MandanteTrait;
    use ItemOrderEloquentTrait;
    use ItemOrderRelationsTrait;

    /**
     * Fillable fields for a Model.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
//        'order_id',
//        'cost_id',
//        'product_id',
//        'currency_id',
        'quantidade',
        'valor_unitario',
//        'desconto_unitario',
//        'descricao',
    ];

}
