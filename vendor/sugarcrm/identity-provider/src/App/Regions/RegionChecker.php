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

use Sugarcrm\IdentityProvider\App\Authentication\CookieService;
use Sugarcrm\IdentityProvider\App\ServiceDiscovery;
use Sugarcrm\IdentityProvider\Srn;
use Sugarcrm\IdentityProvider\STS\EndpointInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use Psr\Log\LoggerInterface;

/**
 * Class RegionChecker
 * @package Sugarcrm\IdentityProvider\App\Regions
 */
class RegionChecker
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var CookieService
     */
    private $cookieService;

    /**
     * @var Session
     */
    private $sessionService;

    /**
     * @var ServiceDiscovery
     */
    private $discoveryService;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        array $config,
        CookieService $cookieService,
        Session $sessionService,
        ServiceDiscovery $discoveryService,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->cookieService = $cookieService;
        $this->sessionService = $sessionService;
        $this->discoveryService = $discoveryService;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @return RedirectResponse|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __invoke(Request $request): ?RedirectResponse
    {
        return $this->check($request);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function check(Request $request): ?RedirectResponse
    {
        $region = $this->cookieService->getRegionCookie($request);
        if (!empty($region) && $region !== $this->config['idm']['region']) {
            $tenant = $this->cookieService->getTenantCookie($request);
            if (!empty($tenant)) {
                $tenantSRN = Srn\Converter::fromString($tenant);
                $tenantId = $tenantSRN->getTenantId();
                return $this->redirectToRegion($request, $region, $tenantId);
            } else {
                return $this->redirectToRegion($request, $region);
            }
        }
        return null;
    }

    protected function getRedirectUriToLoginService(Request $request, string $region, string $tenant = null): ?string
    {
        $loginUrl = $this->discoveryService->getServiceURL('login', $region, 'web');
        if (!empty($loginUrl)) {
            $uri = $loginUrl . $request->getRequestUri();
            $this->logger->info('Redirect to login service in region:{region} url:{url}', [
                'region' => $region,
                'url' => $uri,
                'tags' => ['IdM.main'],
            ]);
            return $uri;
        }

        return null;
    }

    public function redirectToSamlRegion(Request $request, string $region, string $tenant = null): ?RedirectResponse
    {
        if ($uri = $this->getRedirectUriToLoginService($request, $region, $tenant)) {
            return new RedirectResponse($uri);
        }
        return null;
    }

    public function redirectToRegion(Request $request, string $region, string $tenant = null): ?RedirectResponse
    {
        $consentToken = $this->getConsent();
        if (!is_null($consentToken)) {
            $stsUrl = $this->discoveryService->getServiceURL('sts-issuer', $region, 'rest');
            if (!empty($stsUrl)) {
                parse_str(parse_url($consentToken->getRedirectUrl(), PHP_URL_QUERY), $stsRedirectUrlParams);
                $params = [
                    'client_id' => $consentToken->getClientId(),
                    'nonce' => $stsRedirectUrlParams['nonce'] ?? '',
                    'redirect_uri' => $stsRedirectUrlParams['redirect_uri'],
                    'response_type' => 'code',
                    'scope' => $stsRedirectUrlParams['scope'] ?? '',
                    'state' => $stsRedirectUrlParams['state'] ?? '',
                    'tenant_hint' => $tenant,
                ];
                $uri = $stsUrl . '/oauth2/' . EndpointInterface::AUTH_ENDPOINT . '?' . http_build_query($params);
                $this->logger->info('Requesting code on STS service in region:{region} url:{url}', [
                    'region' => $region,
                    'url' => $uri,
                    'tags' => ['IdM.main'],
                ]);
            }
        } else {
            $uri = $this->getRedirectUriToLoginService($request, $region, $tenant);
        }
        if (isset($uri)) {
            return new RedirectResponse($uri);
        }
        return null;
    }

    /**
     * Return session consent token and clear session
     * @return ConsentToken|null
     */
    protected function getConsent()
    {
        /** @var ConsentToken $consentToken */
        $consentToken = $this->sessionService->get('consent');
        $this->sessionService->remove('consent');
        return $consentToken;
    }
}
