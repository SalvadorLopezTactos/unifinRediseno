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

namespace Sugarcrm\Sugarcrm\JobQueue\Adapter\MessageQueue;

use Sugarcrm\Sugarcrm\JobQueue\Exception\RuntimeException;

/**
 * Class AMQP
 * @package JobQueue
 */
class AMQP implements AdapterInterface
{
    /**
     * @var \AMQPQueue
     */
    protected $queue;

    /**
     * @var \AMQPExchange
     */
    protected $exchange;

    /**
     * Initialize connection, exchange and queue.
     *
     * @param array $config
     * @throws RuntimeException
     */
    public function __construct($config)
    {
        if (!extension_loaded('amqp')) {
            throw new RuntimeException('The amqp PHP extension is not loaded.');
        }

        $connection = new \AMQPConnection();
        if (!empty($config['servers'])) {
            $connection->setHost($config['servers']);
        } else {
            $connection->setHost('localhost');
        }
        if (!empty($config['login'])) {
            $connection->setLogin($config['login']);
        }
        if (!empty($config['password'])) {
            $connection->setPassword($config['password']);
        }

        if (!$connection->connect()) {
            throw new RuntimeException('Cannot connect to amqp server.');
        }
        $channel = new \AMQPChannel($connection);
        $channel->setPrefetchCount(1);

        $uniqueKey = (!empty($config['unique_key'])) ? '_' . $config['unique_key'] : '';

        $this->exchange = new \AMQPExchange($channel);
        $this->exchange->setName('Exchange' . $uniqueKey);
        $this->exchange->setFlags(AMQP_DURABLE);
        $this->exchange->setType(AMQP_EX_TYPE_FANOUT);
        $this->exchange->declareExchange();

        $this->queue = new \AMQPQueue($channel);
        $this->queue->setName('Queue' . $uniqueKey);
        $this->queue->setFlags(AMQP_DURABLE);
        $this->queue->declareQueue();
    }

    /**
     * Add a job to AMQP queue.
     * {@inheritdoc}
     * @throws RuntimeException
     */
    public function addJob($route, $data)
    {
        try {
            $this->exchange->publish($data, $route);
        } catch (\AMQPExchangeException $ex) {
            throw new RuntimeException('Adapter failed to publish at AMQP server.', 0, $ex);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function bind($route)
    {
        $this->queue->bind($this->exchange->getName(), $route);
    }

    /**
     * {@inheritdoc}
     */
    public function unbind($route)
    {
        $this->queue->unbind($this->exchange->getName(), $route);
    }

    /**
     * Get a job based on AMQP specific message format.
     * {@inheritdoc}
     */
    public function getJob($message)
    {
        return $message->getBody();
    }

    /**
     * Get an AMQP message.
     * {@inheritdoc}
     */
    public function getMessage()
    {
        $message = $this->queue->get();

        return $message ? $message : null;
    }

    /**
     * Delete job from AMQP queue depending on resolution.
     * {@inheritdoc}
     */
    public function resolve($message)
    {
        $this->queue->ack($message->getDeliveryTag());
    }
}
