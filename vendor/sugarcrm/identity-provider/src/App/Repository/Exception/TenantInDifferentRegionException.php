<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

namespace Sugarcrm\IdentityProvider\App\Repository\Exception;

/**
 * Class TenantInDifferentRegionException
 * @package Sugarcrm\IdentityProvider\App\Repository\Exception
 */
class TenantInDifferentRegionException extends \RuntimeException
{
    /**
     * Tenant Id
     * @var string
     */
    private $tenantId;

    /**
     * Tenant Region
     * @var string
     */
    private $tenantRegion;

    public function __construct(string $tenantRegion, string $tenantId)
    {
        $this->tenantRegion = $tenantRegion;
        $this->tenantId = $tenantId;
    }

    public function getTenantRegion(): string
    {
        return $this->tenantRegion;
    }

    public function getTenantId(): string
    {
        return $this->tenantId;
    }
}
