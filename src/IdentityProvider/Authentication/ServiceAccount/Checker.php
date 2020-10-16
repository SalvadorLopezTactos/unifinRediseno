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

namespace Sugarcrm\Sugarcrm\IdentityProvider\Authentication\ServiceAccount;

use Sugarcrm\IdentityProvider\Srn\Converter;

class Checker
{
    protected $allowedSAs = [];
    protected $ownTenantSRN = '';

    public function __construct(array $idmModeConfig)
    {
        // @deprecated: allowedSAs and check against it will be removed in the future versions.
        $this->allowedSAs = $idmModeConfig['allowedSAs'] ?? [];
        $this->ownTenantSRN = $idmModeConfig['tid'] ?? '';
    }

    /**
     * @param array $accessTokenInfo
     * @return bool
     */
    public function isAllowed(array $accessTokenInfo): bool
    {
        $subjectSRN = $accessTokenInfo['sub'] ?? '';

        $tenantID = Converter::fromString($this->ownTenantSRN)->getTenantId();
        $saTokenSubjectTenantID = Converter::fromString($subjectSRN)->getTenantId();

        $isTokenForThisTenant = $tenantID == $saTokenSubjectTenantID;
        return in_array($subjectSRN, $this->allowedSAs) || $isTokenForThisTenant;
    }
}
