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

namespace Sugarcrm\IdentityProvider\App\Regions;

class TenantRegion
{
    /**
     * @var string
     */
    private $file;

    private $regions = ['regions' => []];

    public function __construct(string $file)
    {
        $this->file = $file;

        $this->regions = yaml_parse_file($file);
    }

    /**
     * Return region of tenant
     *
     * @param string $tenantId
     * @return string|null
     */
    public function getRegion(string $tenantId): ?string
    {
        $tid = intval($tenantId);
        foreach ($this->regions['regions'] as $region) {
            foreach ($region['boundaries'] as $border) {
                if ($border['lower'] <= $tid && $border['upper'] >= $tid) {
                    return $region['id'];
                }
            }
        }
        return null;
    }
}
