<?php

namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\AddressRelationsTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\GridSortingTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\MandanteTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;
    use MandanteTrait;
//    use GridSortingTrait;
//    use AddressEloquentTrait;
    use AddressRelationsTrait;

    /**
     * Fillable fields for a Model.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'cep',
        'logradouro',
        'numero',
        'bairro',
    ];
}
