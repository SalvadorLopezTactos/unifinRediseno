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

use Doctrine\DBAL\Driver\IBMDB2\DB2Connection as BaseConnection;
use Sugarcrm\Sugarcrm\Dbal\SetConnectionTrait;

/**
 * IBM DB2 connection
 */
class Connection extends BaseConnection
{
    use SetConnectionTrait;

    /**
     * @param resource $connection
     */
    public function __construct($connection)
    {
        $this->setConnection($connection);
    }

    /**
     * {@inheritdoc}
     *
     * Reuse existing statements
     */
    public function prepare($sql)
    {
        $db2Stmt = @db2_prepare($this->conn, $sql);

        if (!$db2Stmt) {
            throw new DB2Exception(db2_stmt_errormsg());
        }
        return new Statement($db2Stmt);
    }
}
