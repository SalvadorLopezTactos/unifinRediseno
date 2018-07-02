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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Indexer;

use Sugarcrm\Sugarcrm\Elasticsearch\Container;
use Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Client;

/**
 *
 * The bulk handler orchestrates all write actions to Elasticsearch. This
 * class should not be called directly by any business logic but rather
 * receives its data from the Indexer itself.
 *
 */
class BulkHandler
{
    const EXPLICIT_INDEX_KEY = '_explicit_';

    /**
     * @var \Sugarcrm\Sugarcrm\Elasticsearch\Container
     */
    protected $container;

    /**
     * List of documents being handled keyed by index name
     * @var array
     */
    protected $documents = array();

    /**
     * Maximum documents being sent in one bulk request as defined in
     * `$sugar_config['search_engine']['max_bulk_threshold']`.
     * @var integer
     */
    protected $maxBulkThreshold = 100;

    /**
     * When enabled all documents are send with an explicit index parameter
     * in the document itself rather then splitting up the different documents
     * on a per index base. This will make the size of the request bigger, but
     * fewer bulk requests are potentially made. For more details see the
     * rest.action.multi.allow_explicit_index setting on the URL based access
     * control topic in the Elasticsearch documentation.
     *
     * @var boolean
     * TODO: make configurable
     */
    protected $allowExplicitIndex = false;

    /**
     * Make use of UDP transport. This needs to be explicilty configured on the
     * Elasticsearch node(s) to be able to make use of this functionality. UDP
     * has less overhead. It's recommended to only use this only for localhost
     * traffic. See Elasticsearch documentation on the bulk UDP api. Note that
     * explicit index usage is implied when using the bulk UDP api.
     *
     * @var boolean
     * TODO: make configurable + udp settings in $sugar_config
     */
    protected $useUdp = false;

    /**
     * Ctor
     * @param array $config
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Make sure no stragglers are left behind when this object is destroyed.
     * Its advised for the caller to gracefully finish the batch itself when
     * able as batch handlers are not supposed to be shared which implies that
     * the bulk sending should be nicely contained within the caller.
     */
    public function __destruct()
    {
        $documents = array_filter($this->documents);
        if (!empty($documents)) {

            /*
             * DBManager relies on $GLOBALS['log'] in certain cases instead of
             * making use of $this->log. Make sure we have it still available
             * in case we need to use DBManager from here.
             */
            if (empty($GLOBALS['log'])) {
                $GLOBALS['log'] = $this->container->logger->getSugarLogger();
            }

            $this->finishBatch();

            $msg = sprintf(
                "BulkHandler::__destruct used to flush out %s document(s)",
                count($documents)
            );
            $this->container->logger->debug($msg);
        }
    }

    /**
     * Unset documents in case this object gets unserialized trying
     * to abuse our dtor.
     */
    public function __wakeup()
    {
        $this->documents = array();
    }

    /**
     * Batch documents
     * @param \Elastica\Document[] $documents
     */
    public function batchDocuments(array $documents)
    {
        foreach ($documents as $document) {
            $this->batchDocument($document);
        }
    }

    /**
     * Batch document
     * @param \Elastica\Document $documents
     */
    public function batchDocument(\Elastica\Document $document)
    {
        $index = $document->getIndex();

        /*
         * When using explicit document index, we only use one queue instead
         * of splitting the document up per index.
         */
        if ($this->allowExplicitIndex || $this->useUdp) {
            $index = self::EXPLICIT_INDEX_KEY;
        } else {
            $document = $this->removeIndexFromDocument($document);
        }

        // Add document to queue
        if (empty($this->documents[$index])) {
            $this->documents[$index] = array($document);
        } else {
            $this->documents[$index][] = $document;
        }

        // When reaching the maximum, send out the request
        if (count($this->documents[$index]) >= $this->maxBulkThreshold) {
            $this->sendBulk($index, $this->documents[$index]);
            $this->documents[$index] = array();
        }
    }

    /**
     * Gracefully finish the batch operation flushing out every document which
     * is still left in the queues.
     */
    public function finishBatch()
    {
        foreach ($this->documents as $index => $documents) {
            if (!empty($documents)) {
                $this->sendBulk($index, $documents);
            }
        }
    }

    /**
     * Set maxBulkThreshold
     * @param integer $threshold
     */
    public function setMaxBulkThreshold($threshold)
    {
        $this->maxBulkThreshold = $threshold;
    }

    /**
     * Remove index settings from document. This is necessary when explicit
     * index on the document itself is not allowed.
     * @param \Elastica\Document $document
     * @return \Elastica\Document
     */
    protected function removeIndexFromDocument(\Elastica\Document $document)
    {
        $params = $document->getParams();
        if (isset($params['_index'])) {
            unset($params['_index']);
            $document->setParams($params);
        }
        return $document;
    }

    /**
     * Send list of documents to given index
     * @param string $index
     * @param \Elastica\Document[] $documents
     */
    protected function sendBulk($index, array $documents)
    {
        $bulk = $this->newBulkObject();
        $bulk->addDocuments($documents);

        /*
         * Make sure we index against a specific index when explicit index is
         * not allowed on the documents. This does not apply when UDP indexing
         * is enabled as there is no request url available in this mode.
         */
        if (!$this->allowExplicitIndex && !$this->useUdp) {
            $bulk->setIndex($index);
        }

        try {
            if ($this->useUdp) {
                // TODO: fix Elastica logging, nothing implemented for UDP
                $bulk->sendUdp();
            } else {
                $bulk->send();
            }
        } catch (\Exception $e) {

            // TODO: add handling which records failed instead of sending
            // them all to the queue
            $this->container->queueManager->queueDocuments($documents);
        }
    }

    /**
     * Get bulk object
     * @param Client $client Optional client
     * @return \Elastica\Bulk
     */
    protected function newBulkObject(Client $client = null)
    {
        $client = $client ?: $this->container->client;
        return new \Elastica\Bulk($client);
    }
}
