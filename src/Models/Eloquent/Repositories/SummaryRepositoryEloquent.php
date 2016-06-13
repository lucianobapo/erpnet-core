<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 04:25
 */

namespace ErpNET\App\Models\Eloquent\Repositories;

use Carbon\Carbon;
use ErpNET\App\Models\Eloquent\Summary;
use ErpNET\App\Models\RepositoryLayer\SummaryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SummaryRepositoryEloquent extends AbstractRepository implements SummaryRepositoryInterface
{
    public function __construct(Summary $model)
    {
        $this->model = $model;
        $this->table = $model->getTable();
    }

    /**
     * @return \Carbon\Carbon
     */
    public function lastSummaryEnd()
    {
//        DB::enableQueryLog();
        $model = $this->model->select(DB::raw('MAX(summaries.end_date) as end_date'));
        $return = $model->get()->first();
//        var_dump(DB::getQueryLog()[0]['bindings']);
//        var_dump(DB::getQueryLog());
//        if (!$return->end_date instanceof Carbon) {
////            DB::table('orders')
////                ->select(['users.id', 'users.username', DB::raw('MAX(ur.rank) AS rank')])
////                ->leftJoin('users_ranks AS ur', 'ur.uid', '=', 'users.id')
////                ->where('users.id', '=', 7)
////                ->groupBy('users.id')
////                ->first();
//            var_dump($return->end_date);
//        } else
            return $return->end_date;
    }
}