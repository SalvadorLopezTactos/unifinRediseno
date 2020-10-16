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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Authentication;

use Sugarcrm\IdentityProvider\App\Authentication\RedirectURLService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;

class RedirectURLServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UrlGenerator | \PHPUnit_Framework_MockObject_MockObject
     */
    private $urlGenerator;

    protected function setUp()
    {
        $this->urlGenerator = $this->createMock(UrlGenerator::class);

        $this->urlGenerator
            ->method('generate')
            ->willReturnMap(
                [
                    ['loginRender', [], UrlGenerator::ABSOLUTE_URL, '/login'],
                ]
            );

        parent::setUp();
    }

    /**
     * Provides data for testGetRedirectUrl
     *
     * @return array
     */
    public function getRedirectUrlProvider(): array
    {
        return [
            'requestWithoutRedirectUriAndReferer' => [
                'query' => [],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'allowedDomains' => '',
                'expectedRedirectUrl' => '/login',
            ],
            'requestWithoutRedirectUriAndRefererTwoComponentsDomain' => [
                'query' => [],
                'server' => [
                    'HTTP_HOST' => 'sugarcrm.io',
                ],
                'allowedDomains' => '',
                'expectedRedirectUrl' => '/login',
            ],
            'requestWithRedirectUriOnLoginService' => [
                'query' => [
                    'redirect_uri' => 'http://login.staging.sugarcrm.io/logout',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'allowedDomains' => '',
                'expectedRedirectUrl' => '/login',
            ],
            'requestWithRedirectUri' => [
                'query' => [
                    'redirect_uri' => 'http://console.staging.sugarcrm.io/',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'allowedDomains' => '',
                'expectedRedirectUrl' => 'http://console.staging.sugarcrm.io/',
            ],
            'requestWithLocalhostRedirectUri' => [
                'query' => [
                    'redirect_uri' => 'http://localhost:8080/callback',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'allowedDomains' => '',
                'expectedRedirectUrl' => 'http://localhost:8080/callback',
            ],
            'requestWithLocalhostRedirectUri2' => [
                'query' => [
                    'redirect_uri' => 'https://localhost/callback',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'allowedDomains' => '',
                'expectedRedirectUrl' => 'https://localhost/callback',
            ],
            'requestWithNotAllowedRedirectUri' => [
                'query' => [
                    'redirect_uri' => 'http://google.com/',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'allowedDomains' => '',
                'expectedRedirectUrl' => '/login',
            ],
            'requestWithoutRedirectUriButWithReferer' => [
                'query' => [],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                    'HTTP_REFERER' => 'http://api.staging.sugarcrm.io/',
                ],
                'allowedDomains' => '',
                'expectedRedirectUrl' => 'http://api.staging.sugarcrm.io/',
            ],
            'requestWithoutRedirectUriButWithRefererOnLoginService' => [
                'query' => [],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                    'HTTP_REFERER' => 'http://login.staging.sugarcrm.io/logout',
                ],
                'allowedDomains' => '',
                'expectedRedirectUrl' => '/login',
            ],
            'requestToAllowedDomains' => [
                'query' => [
                    'redirect_uri' => 'http://allowed.domains.com:8080/callback',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'allowedDomains' => 'allowed.domains.com',
                'expectedRedirectUrl' => 'http://allowed.domains.com:8080/callback',
            ],
            'requestToOneOfAllowedDomains' => [
                'query' => [
                    'redirect_uri' => 'http://allowed2.domain.com:8080/callback',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'allowedDomains' => 'allowed.domain.com,allowed2.domain.com',
                'expectedRedirectUrl' => 'http://allowed2.domain.com:8080/callback',
            ],
            'requestToAllowedSubDomains' => [
                'query' => [
                    'redirect_uri' => 'http://sub.allowed.domains.com:8080/callback',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'allowedDomains' => 'allowed.domains.com',
                'expectedRedirectUrl' => 'http://sub.allowed.domains.com:8080/callback',
            ],
            'requestToOneOfAllowedSubDomains' => [
                'query' => [
                    'redirect_uri' => 'http://sub.allowed2.domain.com:8080/callback',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'allowedDomains' => 'allowed.domain.com,allowed2.domain.com',
                'expectedRedirectUrl' => 'http://sub.allowed2.domain.com:8080/callback',
            ],
        ];
    }

    /**
     * @param array $query
     * @param array $server
     * @param string $allowedDomains
     * @param string $expectedRedirectUrl
     *
     * @dataProvider getRedirectUrlProvider
     *
     * @return void
     */
    public function testGetRedirectUrl(
        array $query,
        array $server,
        string $allowedDomains,
        string $expectedRedirectUrl
    ): void {
        $redirectURLService = new RedirectURLService($this->urlGenerator, $allowedDomains);

        $request = new Request($query, [], [], [], [], $server);

        $redirect = $redirectURLService->getRedirectUrl($request);
        $this->assertEquals($expectedRedirectUrl, $redirect);
    }
}
