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

namespace Sugarcrm\IdentityProvider\App\Provider;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Authentication\CookieService;
use Sugarcrm\IdentityProvider\App\Repository\Exception\TenantInDifferentRegionException;
use Sugarcrm\IdentityProvider\Srn;
use Symfony\Component\HttpFoundation\Request;

/**
 * Init config for tenant.
 */
class TenantConfigInitializer
{
    /**
     * The key request key value is hardcoded in Mango. Check Mango side before changing this value.
     */
    public const REQUEST_KEY = 'tenant_hint';

    public const SESSION_KEY = 'tenant';

    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Config initializer.
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $this->initConfig($request);
    }

    /**
     * Initializes config
     *
     * @param Request $request
     * @throws \RuntimeException
     */
    public function initConfig(Request $request)
    {
        $tenant = $this->getTenant($request);
        if (empty($tenant)) {
            $this->app->getLogger()->critical('Cant build configs without tenant id', [
                'request' => [
                    'request' => sprintf('%s %s', $request->getMethod(), $request->getRequestUri()),
                    'headers' => $request->headers->all(),
                    'queryString' => $request->getQueryString(),
                    'post' => $request->request->all(),
                ],
                'tags' => ['IdM.config'],
            ]);
            throw new \RuntimeException('Cant build configs without tenant id');
        }
        $this->app['config'] = $this->app->getTenantConfiguration()->merge($tenant, $this->app['config']);
        $request->getSession()->set(self::SESSION_KEY, Srn\Converter::toString($tenant));
    }

    /**
     * Do we have tenant set
     *
     * @param Request $request
     * @return boolean
     */
    public function hasTenant(Request $request)
    {
        return $request->get(self::REQUEST_KEY)
            || $request->get('tid')
            || $request->getSession()->has(self::SESSION_KEY)
            || $this->getTenantFromAuthorizedUser()
            || $request->cookies->has(CookieService::SAML_TENANT_COOKIE_NAME);
    }

    /**
     * Get tenant id from request, session or the user
     *
     * @param Request $request
     *
     * @return string|null
     */
    protected function getTenantId(Request $request): ?string
    {
        if (!empty($request->get('tid'))) {
            $tenantString = $request->get('tid');
        } elseif (!empty($request->get('tenant_hint'))) {
            $tenantString = $request->get('tenant_hint');
        } elseif (!empty($request->get(self::REQUEST_KEY))) {
            $tenantString = $request->get(self::REQUEST_KEY);
        } elseif ($request->getSession()->has(self::SESSION_KEY)) {
            $tenantString = $request->getSession()->get(self::SESSION_KEY);
        } elseif (!empty($this->getTenantFromAuthorizedUser())) {
            $tenantString = $this->getTenantFromAuthorizedUser();
        } elseif ($request->cookies->has(CookieService::SAML_TENANT_COOKIE_NAME)) {
            $tenantString = $request->cookies->get(CookieService::SAML_TENANT_COOKIE_NAME);
        } else {
            return null;
        }
        return $tenantString;
    }

    /**
     * Looks in all the various nooks and crannies and attempts to find an tenant srn
     *
     * @param Request $request
     * @return \Sugarcrm\IdentityProvider\Srn\Srn
     * @throws TenantInDifferentRegionException
     */
    protected function getTenant(Request $request)
    {
        $tenantString = $this->getTenantId($request);
        if (is_null($tenantString)) {
            return null;
        }
        try {
            $tenantSrn =  Srn\Converter::fromString($tenantString);
            $this->checkTenantRegion($tenantSrn->getTenantId());
            return $tenantSrn;
        } catch (\InvalidArgumentException $e) {
            $this->checkTenantRegion($tenantString);
            $storedTenant = $this->app->getTenantRepository()->findTenantById($tenantString);
            //make double convertion to validate generated SRN
            return Srn\Converter::fromString(
                Srn\Converter::toString(
                    $this->app->getSrnManager($storedTenant->getRegion())->createTenantSrn($storedTenant->getId())
                )
            );
        }
    }

    private function checkTenantRegion(string $tenantId)
    {
        $tenantRegion = $this->app->getTenantRegion()->getRegion($tenantId);
        if (!empty($tenantRegion) && $tenantRegion !== $this->app->getConfig()['idm']['region']) {
            throw new TenantInDifferentRegionException($tenantRegion, $tenantId);
        }
    }

    /**
     * @return string|null
     */
    private function getTenantFromAuthorizedUser(): ?string
    {
        $token = $this->app->getRememberMeService()->retrieve();
        if ($token && $token->hasAttribute('tenantSrn')) {
            return $token->getAttribute('tenantSrn');
        } else {
            return null;
        }
    }
}
