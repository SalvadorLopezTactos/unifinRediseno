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

namespace Sugarcrm\Sugarcrm\PushNotification\SugarPush;

use GuzzleHttp;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Sugarcrm\Sugarcrm\PushNotification\Service as NotificationService;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Config as IdmConfig;
use Sugarcrm\IdentityProvider\Srn\Converter as SrnConverter;

class SugarPush implements NotificationService
{
    /**
     * Send requests through this HTTP client.
     *
     * @var GuzzleClient
     */
    protected $client;

    /**
     * Creates a http client for SugarPush service.
     *
     * @throws \Exception Throws if the instance cannot be created.
     */
    public function __construct()
    {
        $url = $this->getServiceURL();

        if ($url) {
            $this->client = $this->getHTTPClient($url);
        } else {
            throw new \Exception('SugarPush is not available');
        }
    }

    /**
     * Returns a guzzle client.
     *
     * @param string $baseURI The url for SugarPush service
     * @return GuzzleClient
     */
    protected function getHTTPClient(string $baseURI) : GuzzleClient
    {
        $proxy = new ProxyMiddleware();
        $auth = new AuthMiddleware();
        $retry = new RetryMiddleware();
        $debug = new DebugMiddleware();

        $stack = HandlerStack::create(GuzzleHttp\choose_handler());
        $stack->push($proxy, 'proxy');
        $stack->push($auth, 'auth');
        $stack->push($retry, 'retry');
        $stack->push($debug, 'debug');

        return new GuzzleClient(['base_uri' => $baseURI, 'handler' => $stack]);
    }

    /**
     * Returns the URL to SugarPush service for the given region.
     *
     * @return string
     */
    protected function getServiceURL() : string
    {
        $sugarConfig = \SugarConfig::getInstance();
        $pushConfig = $sugarConfig->get('sugar_push');
        $region = $this->getRegion($sugarConfig);

        if ($region && !empty($pushConfig['service_urls'][$region])) {
            return $pushConfig['service_urls'][$region];
        } else {
            return $pushConfig['service_urls']['default'] ?? '';
        }
    }

    /**
     * Gets aws region from idm config.
     *
     * @param \SugarConfig $sugarConfig
     * @return string
     */
    protected function getRegion(\SugarConfig $sugarConfig) : string
    {
        $region = '';
        $idmConfig = new IdmConfig($sugarConfig);
        $config = $idmConfig->getIDMModeConfig();

        if (!empty($config['tid'])) {
            $tenantSrn = SrnConverter::fromString($config['tid']);

            if ($tenantSrn) {
                $region = $tenantSrn->getRegion();
            }
        }

        return $region;
    }

    /**
     * Checks server response.
     *
     * @param Response $respone Server response.
     * @return bool
     */
    protected function isSuccess(Response $response) : bool
    {
        $success = false;

        if ($response->getStatusCode() == 200) {
            $body = json_decode($response->getBody(), true);
            $success = $body && empty($body['error']);
        }

        if (!$success) {
            $log = \LoggerManager::getLogger();
            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();
            $log->error('sugar push: statusCode: ' . $statusCode . ' body: ' . $body);
        }

        return $success;
    }

    /**
     * Registers a user's device.
     *
     * @param string $platform The device's platform.
     * @param string $deviceId The device's ID.
     * @return bool
     */
    public function register(string $platform, string $deviceId) : bool
    {
        $response = $this->client->request(
            'PUT',
            '/device',
            [
                GuzzleHttp\RequestOptions::JSON => [
                    'platform' => $platform,
                    'device_id' => $deviceId,
                ],
            ]
        );

        return $this->isSuccess($response);
    }

    /**
     * Updates a user's device.
     *
     * @param string $platform The device's platform.
     * @param string $oldDeviceId The device's old ID.
     * @param string $newDeviceId The device's new ID.
     * @return bool
     */
    public function update(string $platform, string $oldDeviceId, string $newDeviceId) : bool
    {
        $response = $this->client->request(
            'POST',
            '/device',
            [
                GuzzleHttp\RequestOptions::JSON => [
                    'platform' => $platform,
                    'device_id' => $oldDeviceId,
                    'new_device_id' => $newDeviceId,
                ],
            ]
        );

        return $this->isSuccess($response);
    }

    /**
     * Removes a user's device.
     *
     * @param string $platform The device's platform.
     * @param string $deviceId The device's ID.
     * @return bool
     */
    public function delete(string $platform, string $deviceId) : bool
    {
        $response = $this->client->request(
            'DELETE',
            '/device',
            [
                GuzzleHttp\RequestOptions::JSON => [
                    'platform' => $platform,
                    'device_id' => $deviceId,
                ],
            ]
        );

        return $this->isSuccess($response);
    }

    /**
     * Sends a message to users.
     *
     * @param array $userIds The user ids.
     * @param array $message The message to send. Options are:
     *
     * $message['title'] string The message title (required)
     * $message['body'] string The message body (required)
     * $message['data'] array Extra data to send (optional)
     * $message['android'] array Android specific attributes (optional)
     * $message['ios'] array IOS specific attributes (optional)
     *
     * @return bool
     */
    public function send(array $userIds, array $message) : bool
    {
        $data = array_merge(['target_user_id' => implode(',', $userIds)], $message);

        $response = $this->client->request(
            'PUT',
            '/notification',
            [
                GuzzleHttp\RequestOptions::JSON => $data,
            ]
        );

        return $this->isSuccess($response);
    }
}
