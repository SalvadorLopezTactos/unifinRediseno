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

namespace Sugarcrm\IdentityProvider\App\Authentication;

use Pimple\Container;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\Authentication\RememberMe\Service;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class LogoutService
 * @package Sugarcrm\IdentityProvider\App\Authentication
 */
class LogoutService
{
    /**
     * @var RedirectURLService
     */
    private $redirectURLService;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Service
     */
    private $rememberMe;

    /**
     * @var CookieService
     */
    private $cookieService;

    /**
     * LogoutService constructor.
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->redirectURLService = $app['redirectURLService'];
        $this->session = $app['session'];
        $this->rememberMe = $app['RememberMe'];
        $this->cookieService = $app['cookies'];
    }

    /**
     * Set logout cookies and redirect to specific resource
     *
     * @param Request $request
     * @param string $forceRedirectUrl
     *
     * @return RedirectResponse
     */
    public function logout(Request $request, $forceRedirectUrl = ''): RedirectResponse
    {
        $this->rememberMe->clear();
        $response = new RedirectResponse($forceRedirectUrl ?: $this->redirectURLService->getRedirectUrl($request));
        $this->cookieService->setLogoutCookie($response);

        if ($this->session->has(TenantConfigInitializer::SESSION_KEY)) {
            $this->session->remove(TenantConfigInitializer::SESSION_KEY);
        }

        return $response;
    }
}
