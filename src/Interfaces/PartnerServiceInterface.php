<?php

namespace ErpNET\App\Interfaces;

/**
 * Interface PartnerServiceInterface
 * @package namespace ErpNET\App\Interfaces;
 */
interface PartnerServiceInterface
{
    /**
     * @param int $id
     * @return \ErpNET\App\Models\Eloquent\Partner | \ErpNET\App\Models\Doctrine\Entities\Partner
     */
    public function jsonPartnerProviderId($id);
}
