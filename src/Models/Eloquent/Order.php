<?php

namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\OrderEloquentTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\OrderRelationsTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\MandanteTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    use MandanteTrait;
    use OrderEloquentTrait;
    use OrderRelationsTrait;

    /**
     * Fillable fields for a Model.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
//        'partner_id',
//        'address_id',
//        'currency_id',
//        'type_id',
//        'payment_id',
        'posted_at',
        'valor_total',
//        'desconto_total',
//        'troco',
//        'descricao',
//        'referencia',
        'observacao'
    ];

    /**
     * Additional fields to treat as Carbon instances.
     *
     * @var array
     */
    public $dates = ['posted_at'];

    /**
     * Set the posted_at attribute.
     *
     * @param $date
     */
    public function setPostedAtAttribute($date) {
        $this->attributes['posted_at'] = Carbon::parse($date);
    }

    /**
     * Get the posted_at attribute.
     *
     * @return string
     */
    public function getPostedAtAttribute() {
//        dd(Carbon::parse($this->attributes['posted_at'])->format('d/m/Y H:i'));
//        return Carbon::parse($this->attributes['posted_at'])->format('d/m/Y H:i');
        return Carbon::parse($this->attributes['posted_at']);
    }

    /**
     * Get the posted_at attribute.
     *
     * @return string
     */
    public function getPostedAtCarbonAttribute() {
        return Carbon::parse($this->attributes['posted_at']);
    }

}
