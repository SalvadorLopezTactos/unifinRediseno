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

namespace Sugarcrm\Sugarcrm\Maps;

use BeanFactory;
use Configurator;
use LoggerManager;
use GuzzleHttp;
use GuzzleHttp\Client as GuzzleClient;
use SugarQuery;

class GCSClient
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var GuzzleClient
     */
    protected $guzzle;

    public function __construct()
    {
        $this->guzzle = new GuzzleClient();
        $this->logger = new Logger(LoggerManager::getLogger());
    }

    /**
     * Create a sugar batch of addresses
     * @param array $data
     * @return void
     */
    public function createBatch(array $data)
    {
        $url = $this->getGCSConfig()['createBatch'];

        $this->guzzle->post(
            $url,
            [
                GuzzleHttp\RequestOptions::JSON => $data,
            ],
        );
    }

    /**
     * Get coods from gcs
     *
     * @param string $zipCode
     * @param string $country
     * @return array
     */
    public function getCoordsByZip(string $zipCode, string $country): array
    {
        $url = $this->getGCSConfig()['getGeocodeByZipcode'];

        $data = [
            'zipCode' => $zipCode,
            'country' => $country,
        ];

        $response = $this->guzzle->post(
            $url,
            [
                GuzzleHttp\RequestOptions::JSON => $data,
            ]
        );

        $response = GuzzleHttp\json_decode($response->getBody(), true);

        if (!$response || !is_array($response)) {
            return [];
        }

        return $response;
    }

    /**
     * Get addresses from external client
     *
     * @return array
     */
    public function getData(): array
    {
        $batchId = $this->getBatchId();

        if (!$batchId) {
            return [];
        }

        $url = $this->getGCSConfig()['checkStatus'];

        $options = [
            'query' => [
                'sugar_batch_id' => $batchId,
            ],
        ];

        $response = $this->guzzle->get($url, $options);

        $responseBody = GuzzleHttp\json_decode($response->getBody(), true);

        $response = [
            'batchId' => $batchId,
            'response' => $responseBody,
        ];

        return $response;
    }

    /**
     * Get the first sugar batch available for processing
     *
     * @return void
     */
    private function getBatchId()
    {
        $externalSchedulerJob = BeanFactory::newBean(Constants::GEOCODE_SCHEDULER_MODULE);

        $sq = new SugarQuery();
        $sq->select('id');
        $sq->from($externalSchedulerJob)
            ->where()
            ->equals('status', Constants::GEOCODE_SCHEDULER_STATUS_QUEUED);
        $sq->limit(1);

        $result = $externalSchedulerJob->fetchFromQuery($sq, ['id']);

        if (empty($result)) {
            $this->logger->info('No external batch records queued');
            return;
        }

        $batchId = array_keys($result)[0];

        return $batchId;
    }

    /**
     * Get gcs service config
     *
     * @return array
     */
    protected function getGCSConfig(): array
    {
        $configurator = new Configurator();
        $configurator->loadConfig();

        $ip = $configurator->config['gcs_client']['service_url'];

        if (strlen($ip) > 0) {
            $lastChar = substr($ip, -1);

            if ($lastChar !== '/') {
                $ip .= '/';
            }
        }

        $version = 'v1/';
        $geocodeEndpoint = 'geocode';
        $geocodeByZipcodeEndpoint = 'geocode/zipcode';
        $statusEndpoint = 'checkStatus';

        $urls = [
            'createBatch' => "${ip}${version}${geocodeEndpoint}",
            'getGeocodeByZipcode' => "${ip}${version}${geocodeByZipcodeEndpoint}",
            'checkStatus' => "${ip}${version}${statusEndpoint}",
        ];

        return $urls;
    }
}
