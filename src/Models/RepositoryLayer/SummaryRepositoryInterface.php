<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 03:58
 */

namespace ErpNET\App\Models\RepositoryLayer;

/**
 * Interface SummaryRepositoryInterface
 * @package namespace ErpNET\App\Models\RepositoryLayer;
 */
interface SummaryRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @return \Carbon\Carbon
     */
    public function lastSummaryEnd();
}