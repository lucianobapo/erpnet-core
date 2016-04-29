<?php namespace ErpNET\App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SharedStat extends Model {

    use SoftDeletes;
//    use SharedStatRelationsTrait;

    /**
     * Fillable fields for a ProductGroup.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'descricao',
    ];

//    protected $table = 'product_product_group';

}
