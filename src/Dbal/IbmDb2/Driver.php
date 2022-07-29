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

namespace Sugarcrm\Sugarcrm\Dbal\IbmDb2;

use Doctrine\DBAL\Driver\DriverException;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Driver\ExceptionConverterDriver;
use Doctrine\DBAL\Driver\IBMDB2\DB2Driver as BaseDriver;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * IBM DB2 driver
 */
class Driver extends BaseDriver implements ExceptionConverterDriver
{
    /**
     * {@inheritdoc}
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = array())
    {
        return new Connection($params['connection']);
    }

    /**
     * {@inheritdoc}
     */
    public function convertException($message, DriverException $exception)
    {
        switch ($exception->getSQLState()) {
            case '23505':
                return new UniqueConstraintViolationException($message, $exception);
        }

        throw new Exception\DriverException($message, $exception);
    }
}
