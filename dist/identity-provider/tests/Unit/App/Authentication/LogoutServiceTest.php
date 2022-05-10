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
use Sugarcrm\IdentityProvider\App\Authentication\LogoutService;
use Sugarcrm\IdentityProvider\App\Authentication\RedirectURLService;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\Authentication\RememberMe\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class LogoutServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogoutService
     */
    private $logoutService;

    /**
     * @var Service | \PHPUnit_Framework_MockObject_MockObject
     */
    private $rememberMe;

    /**
     * @var CookieService | \PHPUnit_Framework_MockObject_MockObject
     */
    private $cookieService;

    /**
     * @var Session | \PHPUnit_Framework_MockObject_MockObject
     */
    private $session;

    /**
     * @var RedirectURLService \PHPUnit_Framework_MockObject_MockObject
     */
    private $redirectURLService;

    protected function setUp()
    {
        $config = [
            'logout.options' => [
                'cookie_secure' => false,
                'cookie_name' => 'logout',
            ],
            'cookie.options' => [
                'domain' => 'staging.sugarcrm.io',
            ]
        ];

        $this->cookieService = $this->createMock(CookieService::class);
        $this->redirectURLService = $this->createMock(RedirectURLService::class);

        $this->redirectURLService
            ->method('getRedirectURL')
            ->willReturn('/login');

        $this->rememberMe = $this->createMock(Service::class);
        $this->session = $this->createMock(Session::class);

        $app = $this->createMock(Container::class);
        $app->method('offsetGet')->willReturnMap([
            ['redirectURLService', $this->redirectURLService],
            ['RememberMe', $this->rememberMe],
            ['config', $config],
            ['session', $this->session],
            ['cookies', $this->cookieService],
        ]);

        $this->logoutService = new LogoutService($app);

        parent::setUp();
    }

    /**
     * @covers ::logout
     * @return void
     */
    public function testLogout(): void
    {
        $request = new Request();
        $this->cookieService
            ->expects($this->once())
            ->method('setLogoutCookie')
            ->with($this->isInstanceOf(Response::class));
        $this->rememberMe
            ->expects($this->once())
            ->method('clear');

        $this->session
            ->expects($this->once())
            ->method('has')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn(true);
        $this->session
            ->expects($this->once())
            ->method('remove')
            ->with(TenantConfigInitializer::SESSION_KEY);

        $response = $this->logoutService->logout($request);

        $this->assertEquals('/login', $response->getTargetUrl());
    }
}
