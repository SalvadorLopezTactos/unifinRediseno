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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Regions;

use Sugarcrm\IdentityProvider\App\Regions\TenantRegion;

/**
 * Class TenantRegionTest
 * @package Sugarcrm\IdentityProvider\Tests\Unit\App\Regions
 * @coversDefaultClass Sugarcrm\IdentityProvider\App\Regions\TenantRegion
 */
class TenantRegionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var TenantRegion
     */
    private $tenantRegion;

    /**
     * @see testGetRegion
     * @return array
     */
    public function getTenantRegions(): array
    {
        return [
            ['tid' => '1269321776', 'region' => 'na'],
            ['tid' => '1000000000', 'region' => 'na'],
            ['tid' => '1999999999', 'region' => 'na'],
            ['tid' => '3269321776', 'region' => 'na'],
            ['tid' => '3000000000', 'region' => 'na'],
            ['tid' => '3999999999', 'region' => 'na'],

            ['tid' => '2269321776', 'region' => 'eu'],
            ['tid' => '2000000000', 'region' => 'eu'],
            ['tid' => '2999999999', 'region' => 'eu'],
            ['tid' => '4269321776', 'region' => 'eu'],
            ['tid' => '4000000000', 'region' => 'eu'],
            ['tid' => '4999999999', 'region' => 'eu'],

            ['tid' => '0000000001', 'region' => null],
            ['tid' => '9990000001', 'region' => null],
        ];
    }

    /**
     * @covers ::getRegion
     * @dataProvider getTenantRegions
     * @param string $tid
     * @param string|null $region
     */
    public function testGetRegion(string $tid, ?string $region)
    {
        $this->assertEquals($region, $this->tenantRegion->getRegion($tid));
    }

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->tenantRegion = new TenantRegion(__DIR__ . '/../../fixtures/regions.yaml');
    }
}
