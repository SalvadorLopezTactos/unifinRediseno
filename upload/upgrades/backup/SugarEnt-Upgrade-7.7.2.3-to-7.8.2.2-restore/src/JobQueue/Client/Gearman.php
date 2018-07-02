<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

namespace Sugarcrm\Sugarcrm\JobQueue\Client;

use Sugarcrm\Sugarcrm\JobQueue\Exception\RuntimeException;
use Sugarcrm\Sugarcrm\JobQueue\Workload\WorkloadInterface;
use Sugarcrm\Sugarcrm\JobQueue\Serializer\SerializerInterface;

/**
 * Class Gearman
 * @package JobQueue
 */
class Gearman implements ClientInterface
{
    /**
     * @var \GearmanClient
     */
    protected $client;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param array $config Configuration parameters:
     * servers - A comma separated list of job servers in the format host:port. Empty string is 127.0.0.1:4730.
     * @param SerializerInterface $serializer
     * @throws RuntimeException
     */
    public function __construct(array $config, SerializerInterface $serializer)
    {
        if (!extension_loaded('gearman')) {
            throw new RuntimeException('The gearman PHP extension is not loaded.');
        }
        $this->client = new \GearmanClient();

        if (!empty($config['servers'])) {
            $result = $this->client->addServers($config['servers']);
        } else {
            $result = $this->client->addServer();
        }
        if (!$result) {
            throw new RuntimeException('Cannot add gearman server.');
        }
        $this->serializer = $serializer;
    }

    /**
     * Adds a background task to Gearman job server.
     * {@inheritdoc}
     */
    public function addJob(WorkloadInterface $workload)
    {
        $this->client->addTaskBackground(
            $workload->getRoute(),
            $this->serializer->serialize($workload)
        );
        $this->client->runTasks();
    }
}
