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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Class RedirectURLService
 * @package Sugarcrm\IdentityProvider\App\Authentication
 */
class RedirectURLService
{
    /**
     * @var UrlGenerator
     */
    private $generator;

    const ALLOWED_DOMAINS_DELIMITER = ',';

    /**
     * @var array
     */
    private $additionalAllowedDomains;

    /**
     * RedirectURLService constructor.
     * @param UrlGenerator $urlGenerator
     * @param string $additionalAllowedDomains
     */
    public function __construct(UrlGenerator $urlGenerator, string $additionalAllowedDomains = '')
    {
        $this->generator = $urlGenerator;
        $this->additionalAllowedDomains =
            array_filter(
                array_map(
                    'trim',
                    explode(self::ALLOWED_DOMAINS_DELIMITER, $additionalAllowedDomains)
                ),
                function ($domain): bool {
                    return !('' === $domain);
                }
            );
    }

    /**
     * Gets url for redirect
     *
     * @param Request $request
     * @return string
     */
    public function getRedirectUrl(Request $request): string
    {
        $redirect = $this->getRedirectFromRequest($request);

        return $this->isValidRedirect($redirect, $request)
            ? $redirect
            : $this->generator->generate('loginRender', [], UrlGenerator::ABSOLUTE_URL);
    }

    /**
     * Retrieves redirect URL from request
     *
     * @param Request $request
     *
     * @return string
     */
    private function getRedirectFromRequest(Request $request): string
    {
        $redirect = '';
        if ($request->query->has('redirect_uri')) {
            $redirect = $request->query->get('redirect_uri');
        } elseif ($request->headers->has('referer')) {
            $redirect = $request->headers->get('referer');
        }
        return $redirect;
    }

    /**
     * Validates redirect URL
     * Allowed redirects:
     *   - URL should be localhost
     *   - or URL should be in the same domain path
     *   - if URL is for Login service we consider it invalid to force redirect to login page
     *
     * @param string  $redirect
     * @param Request $request
     *
     * @return bool
     */
    private function isValidRedirect(string $redirect, Request $request): bool
    {
        $redirectDomain = parse_url($redirect, PHP_URL_HOST);
        $doesDomainMatch = strpos($redirectDomain, $this->getCookiesPath($request));
        $isLoginService = ($redirectDomain === $request->getHost());
        $isLocalhost = ($redirectDomain === 'localhost');
        $isInAllowedDomains = !empty(
            array_filter(
                $this->additionalAllowedDomains,
                function ($ad) use ($redirectDomain) {
                    return substr($redirectDomain, -strlen($ad)) === $ad;
                }
            )
        );
        return $doesDomainMatch && !$isLoginService || $isLocalhost || $isInAllowedDomains;
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getCookiesPath(Request $request): string
    {
        $host = $request->getHost();
        if (substr_count($host, '.') > 1) {
            return preg_replace('/^.*\./U', '.', $request->getHost());
        }

        return '.' . $host;
    }
}
