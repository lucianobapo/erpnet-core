<?php

namespace ErpNET\App\Interfaces;

/**
 * Interface SummaryServiceInterface
 * @package namespace ErpNET\App\Interfaces;
 */
interface SummaryServiceInterface
{
    /**
     * @return \Carbon\Carbon
     */
    public function lastEnd();
}
