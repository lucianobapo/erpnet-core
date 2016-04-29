<?php namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\ProductProductGroupRelationsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductProductGroup extends Model {

    use SoftDeletes;
    use ProductProductGroupRelationsTrait;

    /**
     * Fillable fields for a ProductGroup.
     *
     * @var array
     */
    protected $fillable = [
//        'mandante',
//        'grupo',
    ];

    protected $table = 'product_product_group';

}
