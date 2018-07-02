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

namespace Sugarcrm\Sugarcrm\Console\Command\Api;

use Sugarcrm\Sugarcrm\Console\CommandRegistry\Mode\InstanceModeInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

require_once 'modules/Administration/clients/base/api/AdministrationApi.php';

/**
 *
 * Elasticsearch index status
 *
 */
class ElasticsearchIndicesCommand extends Command implements InstanceModeInterface
{
    // Not using trait until we have PHP 5.4 minimum support
    //use ApiEndpointTrait;

    // START TRAIT
    /**
     * @var \SugarApi
     */
    protected $api;

    /**
     * @var \RestService
     */
    protected $service;

    /**
     * Initialize API
     * @param \SugarApi $api
     * @return ApiEndpointTrait
     * @codeCoverageIgnore
     */
    protected function initApi(\SugarApi $api)
    {
        $this->api = $api;
        $this->service = $this->getService();
        return $this;
    }

    /**
     * Wrapper to call a method with arguments on given SugarApi object
     * @param string $method Method to be invoked on the public API
     * @param array $args Arguments to be passed to the public API
     * @codeCoverageIgnore
     */
    protected function callApi($method, array $args = array())
    {
        $args = array($this->service, $args);
        return call_user_func_array(array($this->api, $method), $args);
    }

    /**
     * Get REST service backend
     * @return \RestService
     * @codeCoverageIgnore
     */
    protected function getService()
    {
        return new \RestService();
    }
    // END TRAIT

    /**
     * {inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('elastic:indices')
            ->setDescription('Show Elasticsearch index statistics')
        ;
    }

    /**
     * {inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this
            ->initApi($this->getApi())
            ->callApi('elasticSearchIndices', array())
        ;

        $table = new Table($output);
        $table->setHeaders(array('Index', 'Docs', 'Size', 'Shards'));

        if ($result) {
            foreach ($result as $index => $status) {
                $docs = $status['indices'][$index]['docs']['num_docs'];
                $size = $status['indices'][$index]['index']['size_in_bytes'];
                $shards = $status['_shards']['total'];
                $table->addRow(array($index, $docs, $size, $shards));
            }
        }

        $table->render();
    }

    /**
     * @return \AdministrationApi
     */
    protected function getApi()
    {
        return new \AdministrationApi();
    }
}
