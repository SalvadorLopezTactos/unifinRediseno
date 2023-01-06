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

declare(strict_types=1);

namespace Sugarcrm\Sugarcrm\Security\ValueObjects;

final class ExternalResource
{
    /** @var string */
    private $ip;

    /** @var string */
    private $host;

    /** @var string */
    private $convertedUrl;

    private function __construct()
    {
    }

    /**
     * @param string $url
     * @param array $privateIps
     * @return static
     */
    public static function fromString(string $url, array $privateIps = []): self
    {
        if (false === filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid url was provided.');
        }

        $parts = parse_url($url);
        $host = $parts['host'] ?? null;
        $scheme = $parts['scheme'] ?? null;
        $canonicalUrl = self::buildUrl($parts);

        if (!self::isUrlValid($url, $canonicalUrl, $host, $scheme)) {
            throw new \InvalidArgumentException('Invalid url was provided.');
        }

        $ip = gethostbyname($host);

        if (!$host || $host === $ip || self::isIpPrivate($ip, $privateIps)) {
            throw new \InvalidArgumentException('Invalid url was provided.');
        }

        $urlValueObject = new self();
        $urlValueObject->ip = $ip;
        $urlValueObject->host = $host;
        $urlValueObject->convertedUrl = self::buildUrl($parts, $ip);

        return $urlValueObject;
    }

    /**
     * @param string $url
     * @param string $canonicalUrl
     * @param string|null $host
     * @param string|null $scheme
     * @return bool
     */
    private static function isUrlValid(string $url, string $canonicalUrl, ?string $host, ?string $scheme): bool
    {
        return false === strpos($url, chr(0))
            && $url === $canonicalUrl
            && !empty($host)
            && in_array($scheme, ['http', 'https'], true);
    }

    /**
     * @param string $ip
     * @param array $privateIps
     * @return bool
     */
    private static function isIpPrivate(string $ip, array $privateIps): bool
    {
        if (empty($privateIps)) {
            return false;
        }

        $longIp = ip2long($ip);

        if ($longIp !== -1) {
            foreach ($privateIps as $privateIp) {
                list ($start, $end) = explode('|', $privateIp);

                if ($longIp >= ip2long($start) && $longIp <= ip2long($end)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param array $parts
     * @param string|null $ip
     * @return string
     */
    private static function buildUrl(array $parts, string $ip = null): string
    {
        $scheme  = isset($parts['scheme']) ? $parts['scheme'] . '://' : '';

        if ($ip === null) {
            $host = isset($parts['host']) ? $parts['host'] : '';
        } else {
            $host = $ip;
        }

        $port = isset($parts['port']) ? ':' . $parts['port'] : '';
        $user = isset($parts['user']) ? $parts['user'] : '';
        $pass = isset($parts['pass']) ? ':' . $parts['pass']  : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($parts['path']) ? $parts['path'] : '';
        $query    = isset($parts['query']) ? '?' . $parts['query'] : '';
        $fragment = isset($parts['fragment']) ? '#' . $parts['fragment'] : '';

        return $scheme.$user.$pass.$host.$port.$path.$query.$fragment;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getConvertedUrl(): string
    {
        return $this->convertedUrl;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }
}
