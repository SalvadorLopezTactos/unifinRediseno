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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Authentication\OpenId;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Authentication\OpenId\StandardClaimsService;
use Sugarcrm\IdentityProvider\Authentication\User;

class StandardClaimsServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $app;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->app = $this->createMock(Application::class);
    }

    public function getUserClaimsDataProvider(): array
    {
        return [
            'all scopes' => [
                'expected claims' => [
                    'preferred_username' => 'openid_identity',
                    'created_at' => 1514678400,
                    'given_name' => 'user_first_name',
                    'family_name' => 'user_family_name',
                    'middle_name' => 'user_middle_name',
                    'nickname' => 'user_nickname',
                    'email' => 'user@email.com',
                    'phone_number' => '+1234567890',
                    'address' => [
                        'country' => 'US',
                    ],
                    'status' => 0,
                ],
                'user attributes' => [
                    'given_name' => 'user_first_name',
                    'family_name' => 'user_family_name',
                    'middle_name' => 'user_middle_name',
                    'nickname' => 'user_nickname',
                    'email' => 'user@email.com',
                    'phone_number' => '+1234567890',
                    'address' => [
                        'country' => 'US',
                    ],
                ],
                'requested scopes' => ['profile', 'email', 'address', 'phone'],
            ],
            'no scopes' => [
                'expected claims' => [
                    'created_at' => 1514678400,
                    'status' => 0,
                ],
                'user attributes' => [
                    'given_name' => 'user_first_name',
                    'family_name' => 'user_family_name',
                    'middle_name' => 'user_middle_name',
                    'nickname' => 'user_nickname',
                    'email' => 'user@email.com',
                    'phone_number' => '+1234567890',
                    'address' => [
                        'country' => 'US',
                    ],
                ],
                'requested scopes' => [],
            ],
            'some claims' => [
                'expected claims' => [
                    'preferred_username' => 'openid_identity',
                    'created_at' => 1514678400,
                    'given_name' => 'user_first_name',
                    'family_name' => 'user_family_name',
                    'middle_name' => 'user_middle_name',
                    'nickname' => 'user_nickname',
                    'email' => 'user@email.com',
                    'status' => 0,
                ],
                'user attributes' => [
                    'given_name' => 'user_first_name',
                    'family_name' => 'user_family_name',
                    'middle_name' => 'user_middle_name',
                    'nickname' => 'user_nickname',
                    'email' => 'user@email.com',
                    'phone_number' => '+1234567890',
                    'address' => [
                        'country' => 'US',
                    ],
                ],
                'requested scopes' => ['profile', 'email'],
            ],
        ];
    }

    /**
     * @dataProvider getUserClaimsDataProvider
     */
    public function testGetUserClaims($expectedClaims, $userAttributes, $requestedScopes)
    {
        $user = new User(null, 'password', [
            'id' => 'user_id',
            'identity_value' => 'openid_identity',
            'status' => 0,
            'create_time' => '2017-12-31',
            'attributes' => $userAttributes,
        ]);

        $claims = (new StandardClaimsService($this->app))->getUserClaims($user, $requestedScopes);
        $this->assertEquals($expectedClaims, $claims);
    }

    public function testGetUserClaimsUsernameSets()
    {
        $user = new User('user_name', null, [
            'id' => 'user_id',
        ]);
        $claims = (new StandardClaimsService($this->app))->getUserClaims($user, ['profile', 'email', 'address', 'phone']);
        $this->assertEquals('user_name', $claims['preferred_username']);
    }

    public function testGetUserClaimsInvalidDateFormat()
    {
        $user = new User('user_name', null, [
            'id' => 'user_id',
            'create_time' => 'invalid date',
        ]);
        $claims = (new StandardClaimsService($this->app))->getUserClaims($user, ['profile', 'email', 'address', 'phone']);
        $this->assertArrayNotHasKey('created_at', $claims);
    }

    public function testGetUserClaimsLocale()
    {
        $application = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->setMethods(['getEnv'])->getMock();

        $user = new User('Max', null, ['id' => 'user_id']);
        $claimsService = new StandardClaimsService($application);

        $application['locale'] = 'en-US';
        $claims = $claimsService->getUserClaims($user, ['profile', 'email', 'address', 'phone']);
        $this->assertArrayHasKey('locale', $claims);
        $this->assertEquals('en-US', $claims['locale']);

        $application['locale'] = 'de-DE';
        $claims = $claimsService->getUserClaims($user, ['profile', 'email', 'address', 'phone']);
        $this->assertEquals('de-DE', $claims['locale']);
    }

    public function testGetUserClaimsNoLocale()
    {
        $user = new User('Max', null, ['id' => 'user_id']);
        $claims = (new StandardClaimsService($this->app))->getUserClaims($user, ['profile', 'email', 'address', 'phone']);
        $this->assertArrayNotHasKey('locale', $claims);
    }
}
