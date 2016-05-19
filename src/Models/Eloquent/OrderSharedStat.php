<?php namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\OrderSharedStatRelationsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderSharedStat extends Model {

    use SoftDeletes;
    use OrderSharedStatRelationsTrait;

    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [];

    protected $table = 'order_shared_stat';

}
