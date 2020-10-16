<?php declare(strict_types=1);
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

namespace Sugarcrm\Sugarcrm\Cache\Backend;

use Redis as Client;
use RedisException;
use Sugarcrm\Sugarcrm\Cache\Exception;
use Symfony\Component\Cache\Simple\RedisCache;

/**
 * Redis implementation of the cache backend
 *
 * @link http://pecl.php.net/package/redis
 */
final class Redis extends RedisCache
{
    /**
     * @param string $host
     * @param int $port
     * @param bool $persistent
     * @param float $timeout
     * @param string $persistentId
     *
     * @throws Exception
     * @codeCoverageIgnore
     */
    public function __construct(string $host = '127.0.0.1', int $port = 6379, bool $persistent = false, float $timeout = 0, string $persistentId = '')
    {
        if (!extension_loaded('redis')) {
            throw new Exception('Redis extension is not loaded');
        }

        $client = new Client();

        if (version_compare(phpversion('redis'), '4.0.0') >= 0) {
            try {
                $this->connect($client, $host, $port, $timeout, $persistentId, $persistent);
            } catch (RedisException $e) {
                throw new Exception($e->getMessage(), 0, $e);
            }
        } elseif (!@$this->connect($client, $host, $port, $timeout, '', false)) {
            throw new Exception(error_get_last()['message']);
        }

        parent::__construct($client);
    }

    private function connect(Client $client, string $host, int $port, float $timeout, string $persistentId, bool $persistent) : bool
    {
        if ($persistent) {
            return $client->pconnect($host, $port, $timeout, $persistentId);
        } else {
            return $client->connect($host, $port, $timeout);
        }
    }
}
