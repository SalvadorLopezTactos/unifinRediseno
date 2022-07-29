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

use Sugarcrm\IdentityProvider\App\Authentication\CookieService;
use Sugarcrm\IdentityProvider\App\ServiceDiscovery;
use Sugarcrm\IdentityProvider\App\Regions\RegionChecker;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use Psr\Log\LoggerInterface;
use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentToken;

/**
 * Class RegionCheckerTest
 * @package Sugarcrm\IdentityProvider\Tests\Unit\App\Regions
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Regions\RegionChecker
 */
class RegionCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $config = [
        'idm' => [
            'region' => 'na',
        ],
    ];

    /**
     * @var CookieService | \PHPUnit_Framework_MockObject_MockObject
     */
    private $cookieService;

    /**
     * @var Session | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sessionService;

    /**
     * @var ServiceDiscovery | \PHPUnit_Framework_MockObject_MockObject
     */
    private $discoveryService;

    /**
     * @var LoggerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $logger;

    /**
     * @var RegionChecker | \PHPUnit_Framework_MockObject_MockObject
     */
    private $regionChecker;

    /**
     * @var Request | \PHPUnit_Framework_MockObject_MockObject
     */
    private $request;

    /**
     * @return array
     * @see testNotRedirectToDifferentRegion
     */
    public function sameRegionCases(): array
    {
        return [
            ['region' => '', 'loginUrl' => ''],
            ['region' => 'na', 'loginUrl' => ''],
        ];
    }

    /**
     * @covers ::check
     * @covers ::__invoke
     * @dataProvider sameRegionCases
     *
     * @param string $region
     * @param string $loginUrl
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testNotRedirectToDifferentRegion(string $region, string $loginUrl)
    {
        $this->logger
            ->expects($this->never())
            ->method('info');

        $this->cookieService
            ->expects($this->once())
            ->method('getRegionCookie')
            ->with($this->request)
            ->willReturn($region);

        $this->regionChecker->expects($this->never())
            ->method('getConsent');

        $this->discoveryService
            ->method('getServiceURL')
            ->will($this->returnValueMap([
                ['login', $region, 'web', $loginUrl]
            ]));

        $this->assertNull(
            $this->regionChecker->check($this->request)
        );
    }

    /**
     * @return array
     */
    public function redirectToDifferentRegionDataProvider()
    {
        return [
            [
                'requestURI' => '',
                'consent' => null,
                'redirect' => 'https://eu.login.sugar.multiverse',
            ],
            [
                'requestURI' => '',
                'consent' => 'some-consent-id',
                'redirect' => 'http://sts/oauth2/auth?nonce=some-nonce&redirect_uri=some-redirect-uri&response_type=code&scope=some+scope&state=some-state',
            ],
            [
                'requestURI' => '/logout?tid=1000000001',
                'consent' => null,
                'redirect' => 'https://eu.login.sugar.multiverse/logout?tid=1000000001',
            ],
            [
                'requestURI' => '/logout?tid=1000000001',
                'consent' => 'some-consent-id',
                'redirect' => 'http://sts/oauth2/auth?nonce=some-nonce&redirect_uri=some-redirect-uri&response_type=code&scope=some+scope&state=some-state',
            ],
        ];
    }

    /**
     * @covers ::check
     * @covers ::__invoke
     * @dataProvider redirectToDifferentRegionDataProvider
     */
    public function testRedirectToDifferentRegion($requestURI, $consent, $redirect)
    {
        $region = 'eu';

        $this->cookieService
            ->expects($this->once())
            ->method('getRegionCookie')
            ->with($this->request)
            ->willReturn($region);

        $this->request
            ->method('getRequestUri')
            ->willReturn($requestURI);

        $this->discoveryService
            ->expects($this->once())
            ->method('getServiceURL')
            ->will($this->returnValueMap([
                ['login', $region, 'web', 'https://eu.login.sugar.multiverse'],
                ['sts-issuer', $region, 'rest', 'http://sts'],
            ]));

        if ($consent) {
            $consentToken = $this->createMock(ConsentToken::class);
            $consentToken->expects($this->any())
                ->method('getRequestId')
                ->willReturn($consent);
            $consentToken->expects($this->any())
                ->method('getRedirectUrl')
                ->willReturn('http://sts/oauth2/auth?code=some-code&redirect_uri=some-redirect-uri&nonce=some-nonce&state=some-state&scope=some+scope');
        } else {
            $consentToken = null;
        }

        $this->regionChecker->expects($this->once())
            ->method('getConsent')
            ->willReturn($consentToken);

        $response = $this->regionChecker->check($this->request, $region);
        $this->assertEquals(
            $redirect,
            $response->getTargetUrl()
        );
    }

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->request = $this->createMock(Request::class);
        $this->cookieService = $this->createMock(CookieService::class);
        $this->sessionService = $this->createMock(Session::class);
        $this->discoveryService = $this->createMock(ServiceDiscovery::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->regionChecker = $this->getMockBuilder(RegionChecker::class)
            ->setMethods(['getConsent'])
            ->setConstructorArgs([$this->config,
                $this->cookieService,
                $this->sessionService,
                $this->discoveryService,
                $this->logger,
            ])
            ->getMock();
    }
}
