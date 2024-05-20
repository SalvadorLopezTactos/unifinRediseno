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

namespace Sugarcrm\Sugarcrm\Security\HttpClient;

use Administration;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Sugarcrm\Sugarcrm\Security\ValueObjects\ExternalResource;

class ExternalResourceClient implements ClientInterface
{
    /**
     * @var float Timeout in seconds
     */
    private $timeout;
    /**
     * @var int
     */
    private $maxRedirects;

    /**
     * @var int
     */
    private $redirectsCount;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;
    /**
     * @param float $timeout Read timeout in seconds, specified by a float (e.g. 10.5)
     * @param int $maxRedirects The max number of redirects to follow. Value 0 means that no redirects are followed
     */
    public function __construct(float $timeout = 10, int $maxRedirects = 3)
    {
        $this->timeout = $timeout;
        $this->setMaxRedirects($maxRedirects);
        $this->redirectsCount = 0;
    }

    /**
     * Read timeout in seconds, specified by a float (e.g. 10.5)
     * @param float $timeout
     * @return $this
     */
    public function setTimeout(float $timeout): ExternalResourceClient
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * The max number of redirects to follow. Value 0 means that no redirects are followed
     * @param int $maxRedirects
     * @return $this
     */
    public function setMaxRedirects(int $maxRedirects): ExternalResourceClient
    {
        if ($maxRedirects < 0) {
            throw new \InvalidArgumentException('The max number of redirects can not be less than zero');
        }
        $this->maxRedirects = $maxRedirects;
        return $this;
    }

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @return $this
     */
    public function setResponseFactory(ResponseFactoryInterface $responseFactory): self
    {
        $this->responseFactory = $responseFactory;
        return $this;
    }

    public function getResponseFactory(): ResponseFactoryInterface
    {
        if (!isset($this->responseFactory)) {
            $this->responseFactory = new ResponseFactory();
        }
        return $this->responseFactory;
    }

    /**
     * Sends GET request to provided $url
     * @param string $url URL
     * @param array $headers Request headers list in a form of key + value pairs, e.g.
     *  ['Content-type' => 'application/x-www-form-urlencoded']
     * @return ResponseInterface
     */
    public function get(string $url, array $headers = []): ResponseInterface
    {
        return $this->request('GET', $url, null, $headers);
    }

    /**
     * Sends POST data ($body) to provided $url
     * @param string $url URL
     * @param string|array $body Request body
     * @param array $headers Request headers list in a form of key + value pairs, e.g.
     *  ['Content-Type' => 'application/x-www-form-urlencoded']
     * @return ResponseInterface
     */
    public function post(string $url, $body, array $headers = []): ResponseInterface
    {
        return $this->request('POST', $url, is_string($body)? $body : http_build_query((array) $body), array_merge(['Content-type' => 'application/x-www-form-urlencoded'], $headers));
    }

    /**
     * Sends PUT data ($body) to provided $url
     * @param string $url URL
     * @param string|array $body Request body
     * @param array $headers Request headers list in a form of key + value pairs, e.g.
     *  ['Content-Type' => 'application/x-www-form-urlencoded']
     * @return ResponseInterface
     */
    public function put(string $url, $body, array $headers = []): ResponseInterface
    {
        return $this->request('PUT', $url, is_string($body)? $body : http_build_query((array) $body), array_merge(['Content-type' => 'application/x-www-form-urlencoded'], $headers));
    }

    /**
     * Sends PATCH data ($body) to provided $url
     * @param string $url URL
     * @param string|array $body Request body
     * @param array $headers Request headers list in a form of key + value pairs, e.g.
     *  ['Content-Type' => 'application/x-www-form-urlencoded']
     * @return ResponseInterface
     */
    public function patch(string $url, $body, array $headers = []): ResponseInterface
    {
        return $this->request('PATCH', $url, is_string($body)? $body : http_build_query((array) $body), array_merge(['Content-type' => 'application/x-www-form-urlencoded'], $headers));
    }

    /**
     * Sends DELETE request to provided $url
     * @param string $url
     * @param array $headers
     * @return ResponseInterface
     */
    public function delete(string $url, array $headers = []): ResponseInterface
    {
        return $this->request('DELETE', $url, null, $headers);
    }

    /**
     * Sends HEAD request to provided $url
     * @param string $url
     * @param array $headers
     * @return ResponseInterface
     */
    public function head(string $url, array $headers = []): ResponseInterface
    {
        return $this->request('HEAD', $url, null, $headers);
    }

    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface If an error happens while processing the request.
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->request(
            $request->getMethod(),
            (string) $request->getUri(),
            (string) $request->getBody(),
            array_map(static function (array $headerValues): string {
                return implode(',', $headerValues);
            }, $request->getHeaders())
        );
    }

    /**
     * Sends request to provided $url using $method method
     * @param string $method HTTP Method
     * @param string $url URL
     * @param string|null $body Request body
     * @param array $headers Request headers list in a form of key + value pairs, e.g.
     *  ['Content-type' => 'application/x-www-form-urlencoded']
     * @return ResponseInterface
     */
    public function request(string $method, string $url, ?string $body = null, array $headers = []): ResponseInterface
    {
        global $sugar_config;
        // Prevent SSRF against internal resources
        $privateIps = $sugar_config['security']['private_ips'] ?? [];
        $externalResource = ExternalResource::fromString($url, $privateIps);
        $proxy_config = Administration::getSettings('proxy');
        if (!empty($proxy_config->settings['proxy_auth'])) {
            $auth = base64_encode($proxy_config->settings['proxy_username'] . ':' . $proxy_config->settings['proxy_password']);
            $headers['Proxy-Authorization'] = "Basic $auth";
        }
        $headerParam = $this->buildHeaders($headers, $externalResource);

        $options = [
            'http' => [
                'method' => $method,
                'header' => $headerParam,
                'follow_location' => 0, // mitigate SSRF via redirect
                'content' => $body?? null,
                'timeout' => $this->timeout,
                'protocol_version' => 1.1,
                'ignore_errors' => true,
            ],
            'ssl' => [
                'peer_name' => $externalResource->getHost(),
            ],
        ];

        if (!empty($proxy_config->settings['proxy_on'])) {
            $parts = parse_url($externalResource->getConvertedUrl());
            $proxyHost = $proxy_config->settings['proxy_host'];
            $proxyPort = $proxy_config->settings['proxy_port'];
            $options['http']['proxy'] = 'tcp://' . $proxyHost . ':' . $proxyPort;
            $options['https']['proxy'] = 'tcp://' . $proxyHost . ':' . $proxyPort;
            $options[$parts['scheme'] ?? 'http']['request_fulluri'] = true;
        }
        $context = stream_context_create(
            $options
        );

        $level = error_reporting(0);
        // Using URL with the host name replaced by IP address to prevent DNS rebinding
        $content = file_get_contents($externalResource->getConvertedUrl(), false, $context);
        error_reporting($level);
        if ($content === false) {
            if ($error = error_get_last()) {
                throw new RequestException($error['message']);
            }
            throw new RequestException('Failed to get response from ' . $externalResource->getConvertedUrl());
        }

        if ($this->maxRedirects > 0 && $this->redirectsCount < $this->maxRedirects) {
            foreach ($http_response_header as $header) {
                $canonicalHeader = strtolower(trim($header));
                if (substr($canonicalHeader, 0, 10) === 'location: ') {
                    $this->redirectsCount++;
                    /* update $url with where we were redirected to */
                    $url = substr($canonicalHeader, 10);
                    try {
                        return $this->get($url);
                    } catch (RequestException $exception) {
                        $this->redirectsCount = 0;
                        throw $exception;
                    }
                }
            }
        }
        $this->redirectsCount = 0;

        return $this->createResponse($http_response_header, $content);
    }

    /**
     * @param array $responseHeaders
     * @param string $content
     * @return ResponseInterface
     */
    private function createResponse(array $responseHeaders, string $content): ResponseInterface
    {
        $headers = [];
        foreach ($responseHeaders as $header) {
            $trimmed = trim($header);
            if (0 === stripos($trimmed, 'http/')) {
                $headers = [];
                $headers[] = $trimmed;
                continue;
            }

            if (false === strpos($trimmed, ':')) {
                continue;
            }
            $headers[] = $trimmed;
        }
        $statusLine = array_shift($headers);
        $parts = explode(' ', $statusLine, 3);
        if (count($parts) < 2 || 0 !== stripos($parts[0], 'http/')) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid HTTP status line', $statusLine));
        }
        $code = $parts[1];
        $reasonPhrase = $parts[2];
        $response = $this->getResponseFactory()->createResponse();
        $response = $response->withStatus($code, $reasonPhrase);
        foreach ($headers as $header) {
            [$headerName, $headerValue] = explode(':', $header, 2);
            $response = $response->withAddedHeader($headerName, $headerValue);
        }

        $response->getBody()->write($content);
        $response->getBody()->rewind();
        return $response;
    }

    /**
     * @param \UploadFile $file
     * @param string $url
     * @param string $method
     * @param array $body
     * @param array $headers
     * @return ResponseInterface
     */
    public function upload(\UploadFile $file, string $url, string $method = 'POST', array $body = [], array $headers = []): ResponseInterface
    {
        $boundary = '--------------------------' . microtime(true);
        $requestHeaders = array_merge(['Content-type' => 'multipart/form-data; boundary=' . $boundary], $headers);
        $fileContents = $file->get_file_contents();
        $content = "--" . $boundary . "\r\n" .
            "Content-Disposition: form-data; name=\"" . $file->field_name . "\"; filename=\"" . basename($file->get_temp_file_location()) . "\"\r\n" .
            "Content-Type: application/zip\r\n\r\n" .
            $fileContents . "\r\n";
        foreach ($body as $name => $value) {
            $content .= "--" . $boundary . "\r\n" .
                "Content-Disposition: form-data; name=\"{$name}\"\r\n\r\n" .
                "{$value}\r\n";
        }
        $content .= "--" . $boundary . "--\r\n";
        return $this->request($method, $url, $content, $requestHeaders);
    }

    /**
     * @param array $headers array $headers Request headers list in a form of key + value pairs, e.g.
     *  ['Content-type' => 'application/x-www-form-urlencoded']
     * @param ExternalResource $externalResource
     * @return string[]
     */
    protected function buildHeaders(array $headers, ExternalResource $externalResource): array
    {
        $requestHeaders = [];
        foreach ($headers as $name => $value) {
            $canonicalName = strtolower(trim($name));
            $requestHeaders[$canonicalName] = $value;
        }
        // force correct Host header, override if it was provided in $headers
        $requestHeaders['host'] = $externalResource->getHost();
        return array_map(function ($k, $v) {
            return "$k: $v";
        }, array_keys($requestHeaders), array_values($requestHeaders));
    }
}
