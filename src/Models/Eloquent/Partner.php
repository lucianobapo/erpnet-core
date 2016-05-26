<?php

namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\PartnerRelationsTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\GridSortingTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\MandanteTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\SyncItemsTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;
    use MandanteTrait;
//    use GridSortingTrait;
//    use SyncItemsTrait;
    use PartnerRelationsTrait;

    /**
     * Fillable fields for a Model.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
//        'user_id',
        'nome',
//        'data_nascimento',
//        'observacao',
    ];

    /**
     * Additional fields to treat as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['data_nascimento'];

    /**
     * Set the data_nascimento attribute.
     *
     * @param $date
     */
    public function setDataNascimentoAttribute($date) {
        $this->attributes['data_nascimento'] = Carbon::parse($date);
    }

    /**
     * Get the data_nascimento attribute.
     *
     * @return string
     */
    public function getDataNascimentoAttribute() {
        return Carbon::parse($this->attributes['data_nascimento']);
    }

    public function getFormattedDataNascimento() {
        return Carbon::parse($this->attributes['data_nascimento'])->format('d/m/Y');
    }

}
