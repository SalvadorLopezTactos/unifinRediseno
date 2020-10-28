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
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CookieService
 * @package Sugarcrm\IdentityProvider\App\Authentication
 */
class CookieService
{
    public const DEFAULT_CLEAR_TIME = 3600 * 24;

    public const DEFAULT_LIFETIME = 3600 * 24 * 365;

    public const TENANT_COOKIE_NAME = 'tid';

    public const REGION_COOKIE_NAME = 'region';

    public const SAML_TENANT_COOKIE_NAME = 'samlTid';

    /**
     * @var string
     */
    private $localeCookieName;

    /**
     * @var string
     */
    private $logoutCookieName;

    /**
     * @var bool
     */
    private $cookieSecure;

    /**
     * @var string
     */
    private $cookieDomain;

    /**
     * CookieService constructor.
     * @param Container $app
     * @param string $localeCookieName
     */
    public function __construct(Container $app, string $localeCookieName)
    {
        $cookieConfig = $app['config']['cookie.options'];
        $this->cookieSecure = !empty($cookieConfig['secure']);
        $this->cookieDomain = $cookieConfig['domain'];

        $logoutConfig = $app['config']['logout.options'];
        $this->logoutCookieName = !empty($logoutConfig['cookie_name']) ? $logoutConfig['cookie_name'] : 'cloud-log';
        $this->localeCookieName = $localeCookieName;
    }

    /**
     * Set temporary cookie for SAML tenant
     * @param Response $response
     * @param string $value
     */
    public function setSamlTenantCookie(Response $response, string $value): void
    {
        $this->setCookie($response, self::SAML_TENANT_COOKIE_NAME, $value, 0);
    }

    /**
     * @param Response $response
     */
    public function clearSamlTenantCookie(Response $response): void
    {
        $this->clearCookie($response, self::SAML_TENANT_COOKIE_NAME);
    }

    /**
     * Set tenant cookies
     *
     * @param Response $response
     * @param string $value
     */
    public function setTenantCookie(Response $response, string $value): void
    {
        $this->setCookie($response, self::TENANT_COOKIE_NAME, $value, time() + static::DEFAULT_LIFETIME);
    }

    /**
     * Return tenant cookies
     *
     * @param Request $request
     * @return string
     */
    public function getTenantCookie(Request $request): string
    {
        return $request->cookies->get(self::TENANT_COOKIE_NAME, '');
    }

    /**
     * Set region cookies
     *
     * @param Response $response
     * @param string $value
     */
    public function setRegionCookie(Response $response, string $value): void
    {
        $this->setCookie($response, self::REGION_COOKIE_NAME, $value, time() + static::DEFAULT_LIFETIME);
    }

    /**
     * Return region cookies
     *
     * @param Request $request
     * @return string
     */
    public function getRegionCookie(Request $request): string
    {
        return $request->cookies->get(self::REGION_COOKIE_NAME, '');
    }

    /**
     * Delete region cookies
     * @todo test
     * @param Response $response
     * @return void
     */
    public function clearRegionCookie(Response $response): void
    {
        $this->clearCookie($response, self::REGION_COOKIE_NAME);
    }

    /**
     * Set logout cookies
     *
     * @param Response $response
     */
    public function setLogoutCookie(Response $response): void
    {
        $this->setCookie($response, $this->logoutCookieName, '1', time() + static::DEFAULT_LIFETIME);
    }

    /**
     * Delete logout cookies
     *
     * @param Response $response
     */
    public function clearLogoutCookies(Response $response): void
    {
        $this->clearCookie($response, $this->logoutCookieName);
    }

    /**
     * Set locale cookies
     *
     * @param Response $response
     * @param string $value
     */
    public function setLocaleCookie(Response $response, string $value): void
    {
        $this->setCookie($response, $this->localeCookieName, $value, time() + static::DEFAULT_LIFETIME);
    }

    /**
     * Return locale cookies
     *
     * @param Request $request
     * @return string
     */
    public function getLocaleCookie(Request $request): string
    {
        return $request->cookies->get($this->localeCookieName, '');
    }

    /**
     * @param Response $response
     * @param string $name
     * @param string $value
     * @param int $expire
     */
    protected function setCookie(
        Response $response,
        string $name,
        string $value,
        int $expire
    ): void {
        $cookie = new Cookie(
            $name,
            $value,
            $expire,
            '/',
            $this->getCookieDomain(),
            $this->cookieSecure,
            false
        );
        $response->headers->setCookie($cookie);
    }

    /**
     * @param Response $response
     * @param string $name
     */
    protected function clearCookie(Response $response, string $name): void
    {
        $cookie = new Cookie(
            $name,
            null,
            time() - static::DEFAULT_CLEAR_TIME,
            '/',
            $this->getCookieDomain(),
            $this->cookieSecure,
            false
        );
        $response->headers->setCookie($cookie);
    }

    /**
     * @return string|null
     */
    protected function getCookieDomain(): ?string
    {
        if (empty($this->cookieDomain)) {
            return null;
        }
        return '.' . ltrim($this->cookieDomain, '.');
    }
}
