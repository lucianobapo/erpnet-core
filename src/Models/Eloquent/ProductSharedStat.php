<?php namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\ProductSharedStatRelationsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSharedStat extends Model {

    use SoftDeletes;
    use ProductSharedStatRelationsTrait;

    /**
     * Fillable fields for a ProductGroup.
     *
     * @var array
     */
    protected $fillable = [
//        'mandante',
//        'grupo',
    ];

    protected $table = 'product_shared_stat';

}
