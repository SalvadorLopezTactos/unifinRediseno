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

use Pimple\Container;
use Sugarcrm\IdentityProvider\App\Authentication\CookieService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Authentication\CookieService
 */
class CookieServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var CookieService
     */
    private $cookieService;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->request = new Request();
        $this->response = new Response();
        $config = [
            'cookie.options' => [
                'secure' => true,
                'domain' => 'domain.test',
            ],
            'logout.options' => ['cookie_name' => 'logout'],
        ];

        /** @var Container | \PHPUnit_Framework_MockObject_MockObject $app */
        $app = $this->createMock(Container::class);
        $app->method('offsetGet')->willReturnMap([
            ['config', $config],
        ]);

        $this->cookieService = new CookieService($app, 'localeName');

        parent::setUp();
    }

    /**
     * @return array
     */
    public function providerCookie(): array
    {
        $cookieOptions = ['secure' => true, 'domain' => '.domain.test'];
        $logoutOptions = ['cookie_name' => 'logout'];

        return [
            'cookie domain with dot' => [
                'in' => [
                    'config' =>
                        [
                            'cookie.options' => $cookieOptions,
                            'logout.options' => $logoutOptions,
                        ],
                    'value' => 'testValue',
                    'localeCookieName' => 'locale',
                    'samlTidCookieName' => 'samlTid',
                ],
                'expected' => [
                    'domain' => '.domain.test'
                ],
            ],
            'cookie domain without dot' => [
                'in' => [
                    'config' =>
                        [
                            'cookie.options' => ['domain' => 'domain.test'] + $cookieOptions,
                            'logout.options' => $logoutOptions,
                        ],
                    'value' => 'testValue',
                    'localeCookieName' => 'locale',
                    'samlTidCookieName' => 'samlTid',
                ],
                'expected' => [
                    'domain' => '.domain.test'
                ],
            ],
            'cookie domain empty' => [
                'in' => [
                    'config' =>
                        [
                            'cookie.options' => ['domain' => ''] + $cookieOptions,
                            'logout.options' => $logoutOptions,
                        ],
                    'value' => 'testValue',
                    'localeCookieName' => 'locale',
                    'samlTidCookieName' => 'samlTid',
                ],
                'expected' => [
                    'domain' => null,
                ],
            ],
            'not secure cookie' => [
                'in' => [
                    'config' =>
                        [
                            'cookie.options' => ['secure' => false] + $cookieOptions,
                            'logout.options' => $logoutOptions,
                        ],
                    'value' => 'testValue',
                    'localeCookieName' => 'locale',
                    'samlTidCookieName' => 'samlTid',
                ],
                'expected' => [
                    'domain' => '.domain.test',
                ],
            ],
        ];
    }

    /**
    * @return void
    * @dataProvider providerCookie
    * @covers ::__construct
    * @covers ::setTenantCookie
    * @covers ::setCookie
    * @covers ::getCookieDomain
    * @param array $in
    * @param array $expected
    */
    public function testSetTenantCookie(array $in, array $expected): void
    {
        $cookieService = $this->createCookieService($in['config'], $in['localeCookieName']);
        $cookieService->setTenantCookie($this->response, $in['value']);

        $cookies = $this->response->headers->getCookies();
        $this->assertCount(1, $cookies);

        $tidCookie = $cookies[0];
        $this->assertEquals(CookieService::TENANT_COOKIE_NAME, $tidCookie->getName());
        $this->assertEquals($in['value'], $tidCookie->getValue());
        $this->assertEquals($in['config']['cookie.options']['secure'], $tidCookie->isSecure());
        $this->assertEquals($expected['domain'], $tidCookie->getDomain());
    }

    /**
     * @covers ::getTenantCookie
     */
    public function testGetTenantCookie(): void
    {
        $this->request->cookies->add([CookieService::TENANT_COOKIE_NAME => 'testValue']);
        $this->assertEquals('testValue', $this->cookieService->getTenantCookie($this->request));
    }

    /**
     * @return void
     * @dataProvider providerCookie
     * @covers ::__construct
     * @covers ::setRegionCookie
     * @covers ::setCookie
     * @covers ::getCookieDomain
     * @param array $in
     * @param array $expected
     */
    public function testSetRegionCookie(array $in, array $expected): void
    {
        $cookieService = $this->createCookieService($in['config'], $in['localeCookieName']);
        $cookieService->setRegionCookie($this->response, $in['value']);

        $cookies = $this->response->headers->getCookies();
        $this->assertCount(1, $cookies);

        $regionCookie = $cookies[0];
        $this->assertEquals(CookieService::REGION_COOKIE_NAME, $regionCookie->getName());
        $this->assertEquals($in['value'], $regionCookie->getValue());
        $this->assertEquals($in['config']['cookie.options']['secure'], $regionCookie->isSecure());
        $this->assertEquals($expected['domain'], $regionCookie->getDomain());
    }

    /**
     * @covers ::getRegionCookie
     */
    public function testGetRegionCookie(): void
    {
        $this->request->cookies->add([CookieService::REGION_COOKIE_NAME => 'testValueRegion']);
        $this->assertEquals('testValueRegion', $this->cookieService->getRegionCookie($this->request));
    }

    /**
     * Region cookie delete logic test
     *
     * @return void
     * @dataProvider providerCookie
     * @covers ::__construct
     * @covers ::clearRegionCookie
     * @covers ::clearCookie
     * @covers ::getCookieDomain
     *
     * @param array $in
     * @param array $expected
     */
    public function testClearRegionCookie(array $in, array $expected): void
    {
        $cookieService = $this->createCookieService($in['config'], $in['localeCookieName']);
        $cookieService->clearRegionCookie($this->response);

        $cookies = $this->response->headers->getCookies();
        $this->assertCount(1, $cookies);

        $logoutCookie = $cookies[0];
        $this->assertEquals(CookieService::REGION_COOKIE_NAME, $logoutCookie->getName());
        $this->assertEquals($in['config']['cookie.options']['secure'], $logoutCookie->isSecure());
        $this->assertEquals($expected['domain'], $logoutCookie->getDomain());
        $this->assertLessThan(time(), $logoutCookie->getExpiresTime());
    }

    /**
     * @return void
     * @dataProvider providerCookie
     * @covers ::__construct
     * @covers ::setLogoutCookie
     * @covers ::setCookie
     * @covers ::getCookieDomain
     * @param array $in
     * @param array $expected
     */
    public function testSetLogoutCookie(array $in, array $expected): void
    {
        $cookieService = $this->createCookieService($in['config'], $in['localeCookieName']);
        $cookieService->setLogoutCookie($this->response);

        $cookies = $this->response->headers->getCookies();
        $this->assertCount(1, $cookies);

        $logoutCookie = $cookies[0];
        $this->assertEquals($in['config']['logout.options']['cookie_name'], $logoutCookie->getName());
        $this->assertNotEmpty($logoutCookie->getValue());
        $this->assertEquals($in['config']['cookie.options']['secure'], $logoutCookie->isSecure());
        $this->assertEquals($expected['domain'], $logoutCookie->getDomain());
    }

    /**
     * Logout cookie delete logic test
     *
     * @return void
     * @dataProvider providerCookie
     * @covers ::__construct
     * @covers ::clearLogoutCookies
     * @covers ::clearCookie
     * @covers ::getCookieDomain
     *
     * @param array $in
     * @param array $expected
     */
    public function testClearLogoutCookie(array $in, array $expected): void
    {
        $cookieService = $this->createCookieService($in['config'], $in['localeCookieName']);
        $cookieService->clearLogoutCookies($this->response);

        $cookies = $this->response->headers->getCookies();
        $this->assertCount(1, $cookies);

        $logoutCookie = $cookies[0];
        $this->assertEquals($in['config']['logout.options']['cookie_name'], $logoutCookie->getName());
        $this->assertEquals($in['config']['cookie.options']['secure'], $logoutCookie->isSecure());
        $this->assertEquals($expected['domain'], $logoutCookie->getDomain());
        $this->assertLessThan(time(), $logoutCookie->getExpiresTime());
    }

    /**
     * @return void
     * @dataProvider providerCookie
     * @covers ::__construct
     * @covers ::setLocaleCookie
     * @covers ::setCookie
     * @covers ::getCookieDomain
     * @param array $in
     * @param array $expected
     */
    public function testSetLocaleCookie(array $in, array $expected): void
    {
        $cookieService = $this->createCookieService($in['config'], $in['localeCookieName']);
        $cookieService->setLocaleCookie($this->response, $in['value']);

        $cookies = $this->response->headers->getCookies();
        $this->assertCount(1, $cookies);

        $localeCookie = $cookies[0];
        $this->assertEquals($in['localeCookieName'], $localeCookie->getName());
        $this->assertNotEmpty($localeCookie->getValue());
        $this->assertEquals($in['config']['cookie.options']['secure'], $localeCookie->isSecure());
        $this->assertEquals($expected['domain'], $localeCookie->getDomain());
    }

    /**
     * @return void
     * @dataProvider providerCookie
     * @covers ::__construct
     * @covers ::setSamlTenantCookie
     * @covers ::setCookie
     * @covers ::getCookieDomain
     * @param array $in
     * @param array $expected
     */
    public function testSetSamlTenantCookie(array $in, array $expected): void
    {
        $cookieService = $this->createCookieService($in['config'], $in['localeCookieName']);
        $cookieService->setSamlTenantCookie($this->response, $in['value']);

        $cookies = $this->response->headers->getCookies();
        $this->assertCount(1, $cookies);

        $samlCookie = $cookies[0];
        $this->assertEquals($in['samlTidCookieName'], $samlCookie->getName());
        $this->assertNotEmpty($samlCookie->getValue());
        $this->assertEquals($in['config']['cookie.options']['secure'], $samlCookie->isSecure());
        $this->assertEquals($expected['domain'], $samlCookie->getDomain());
        $this->assertEquals(0, $samlCookie->getExpiresTime());
    }

    /**
     * @covers ::getLocaleCookie
     * @covers ::__construct
     */
    public function testGetLocaleCookie(): void
    {
        $this->request->cookies->add(['localeName' => 'testValueLocale']);
        $this->assertEquals('testValueLocale', $this->cookieService->getLocaleCookie($this->request));
    }

    private function createCookieService(array $config, string $localeCookieName): CookieService
    {
        /** @var Container | \PHPUnit_Framework_MockObject_MockObject $app */
        $app = $this->createMock(Container::class);
        $app->method('offsetGet')->willReturnMap([
            ['config', $config],
        ]);

        $cookieService = new CookieService($app, $localeCookieName);
        return $cookieService;
    }
}
