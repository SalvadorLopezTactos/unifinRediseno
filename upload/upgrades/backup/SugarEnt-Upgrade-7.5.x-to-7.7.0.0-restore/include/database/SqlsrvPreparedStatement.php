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

class SqlsrvPreparedStatement extends PreparedStatement
{

    /**
     * Place to bind query vars to
     * @var array
     *
     * Special handling is required for the following types which are functions not constants
     *     binary(byte count)
     *     char(char count)
     *     decimal (precision,scale)
     *     nchar(char count)
     *     numeric(precision, scale)
     *     nvarchar(char count)
     *     varbinary(byte count)
     */
    protected $bound_vars = array();

    /**
     * SQL server type map
     * @var unknown
     */
    public $typeMap = array(
        'int'           =>  SQLSRV_SQLTYPE_INT,
        'double'        =>  SQLSRV_SQLTYPE_FLOAT,
        'float'         =>  SQLSRV_SQLTYPE_FLOAT,
        'uint'          =>  SQLSRV_SQLTYPE_INT,
        'ulong'         =>  SQLSRV_SQLTYPE_BIGINT,
        'long'          =>  SQLSRV_SQLTYPE_BIGINT,
        'short'         =>  SQLSRV_SQLTYPE_INT,
        'varchar'       =>  SQLSRV_SQLTYPE_CHAR,
        'text'          =>  SQLSRV_SQLTYPE_TEXT,
        'longtext'      =>  SQLSRV_SQLTYPE_TEXT,
        'date'          =>  SQLSRV_SQLTYPE_DATE,
        'enum'          =>  SQLSRV_SQLTYPE_CHAR,
        'relate'        =>  SQLSRV_SQLTYPE_CHAR,
        'multienum'     =>  SQLSRV_SQLTYPE_CHAR,
        'html'          =>  SQLSRV_SQLTYPE_TEXT,
        'longhtml'      =>  SQLSRV_SQLTYPE_TEXT,
        'datetime'      =>  SQLSRV_SQLTYPE_CHAR,
        'datetimecombo' =>  SQLSRV_SQLTYPE_CHAR,
        'time'          =>  SQLSRV_SQLTYPE_CHAR,
        'bool'          =>  SQLSRV_SQLTYPE_BIT,
        'tinyint'       =>  SQLSRV_SQLTYPE_TINYINT,
        'char'          =>  SQLSRV_SQLTYPE_CHAR,
        'blob'          =>  SQLSRV_SQLTYPE_BINARY,
        'longblob'      =>  SQLSRV_SQLTYPE_BINARY,
        'currency'      =>  SQLSRV_SQLTYPE_MONEY,
        'decimal'       =>  SQLSRV_SQLTYPE_DECIMAL,
        'decimal2'      =>  SQLSRV_SQLTYPE_DECIMAL,
        'id'            =>  SQLSRV_SQLTYPE_CHAR,
        'url'           =>  SQLSRV_SQLTYPE_CHAR,
        'encrypt'       =>  SQLSRV_SQLTYPE_CHAR,
        'file'          =>  SQLSRV_SQLTYPE_CHAR,
        'decimal_tpl'   =>  SQLSRV_SQLTYPE_DECIMAL,
    );

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

        $num_args = count($this->fieldDefs);
        $params = $this->bound_vars = array_fill(0, $num_args, null);
        for($i=0; $i<$num_args;$i++) {
            $dbType = $this->fieldDefs[$i]["type"];
            $params[] = array(&$this->bound_vars[$i], SQLSRV_PARAM_IN, null, $dbType);
        }
        $this->stmt = sqlsrv_prepare($this->dblink, $this->parsedSQL, $params);
        if($this->DBM->checkError(" QueryPrepare Failed: $msg for sql: $this->parsedSQL ::") || !$this->stmt) {
            return false;
        }

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see PreparedStatement::executePreparedStatement()
     */
    public function executePreparedStatement(array $data, $msg = '')
    {
        if(!$this->prepareStatementData($data, count($this->fieldDefs), $msg)) {
            return false;
        }
        $res = sqlsrv_execute($this->stmt);

        return $this->finishStatement($res, $msg);
    }
}
