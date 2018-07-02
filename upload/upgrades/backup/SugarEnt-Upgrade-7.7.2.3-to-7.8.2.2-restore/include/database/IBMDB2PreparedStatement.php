<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


/*********************************************************************************

 * Description: This file handles the Data base functionality for prepared Statements
 * It acts as the prepared statement abstraction layer for the application.
 *
 * All the functions in this class will work with any bean which implements the meta interface.
 * The passed bean is passed to helper class which uses these functions to generate correct sql.
 *
 * The meta interface has the following functions:
 */
require_once 'include/database/PreparedStatement.php';

class IBMDB2PreparedStatement extends PreparedStatement
{
    /**
     * DB2 statement resource
     * @var resource
     */
    protected $stmt;

    /**
     * (non-PHPdoc)
     * @see PreparedStatement::preparePreparedStatement()
     */
    public function preparePreparedStatement($msg = '' )
    {
        if(empty($this->parsedSQL)) {
            $this->DBM->registerError($msg, "Empty SQL query");
            return false;
        }

        $GLOBALS['log']->info('QueryPrepare: ' . $this->parsedSQL);
        if (!($this->stmt = db2_prepare($this->dblink,$this->parsedSQL))) {
            $this->DBM->checkError($msg);
            return false;
        }

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see PreparedStatement::executePreparedStatement()
     */
    public function executePreparedStatement(array $data,  $msg = '')
    {
        if(!$this->stmt) {
            $this->DBM->registerError($msg, "No prepared statement to execute");
            return false;
        }
        $this->DBM->countQuery($this->parsedSQL);
        $GLOBALS['log']->info("Executing Query: {$this->parsedSQL} with ".var_export($data, true));
        $this->bound_data = $data;

        $i = 0;
        foreach ($data as $v) {
            $i ++;
            $k = 'bind_' . $i;
            $$k = $v;
            db2_bind_param($this->stmt, $i, $k, DB2_PARAM_IN);
        }

        $this->query_time = microtime(true);
        $res = db2_execute($this->stmt);

        return $this->finishStatement($res, $msg);
    }
}
