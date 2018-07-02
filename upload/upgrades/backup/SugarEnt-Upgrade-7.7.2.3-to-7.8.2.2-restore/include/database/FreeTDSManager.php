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

include_once('include/database/MssqlManager.php');

/**
 * SQL Server driver for FreeTDS
 */
class FreeTDSManager extends MssqlManager
{
    public $dbName = 'FreeTDS SQL Server';
    public $variant = 'freetds';
    public $label = 'LBL_MSSQL2';

    public $priority = 10;

    protected $capabilities = array(
        "affected_rows" => true,
        'fulltext' => true,
    );

    protected $type_map = array(
            'int'      => 'int',
            'double'   => 'float',
            'float'    => 'float',
            'uint'     => 'int',
            'ulong'    => 'int',
            'long'     => 'bigint',
            'short'    => 'smallint',
            'varchar'  => 'nvarchar',
            'text'     => 'nvarchar(max)',
            'longtext' => 'nvarchar(max)',
            'date'     => 'datetime',
            'enum'     => 'nvarchar',
            'relate'   => 'nvarchar',
            'multienum'=> 'nvarchar(max)',
            'html'     => 'nvarchar(max)',
			'longhtml' => 'text',
    		'datetime' => 'datetime',
            'datetimecombo' => 'datetime',
            'time'     => 'datetime',
            'bool'     => 'bit',
            'tinyint'  => 'tinyint',
            'char'     => 'char',
            'blob'     => 'nvarchar(max)',
            'longblob' => 'nvarchar(max)',
            'currency' => 'decimal(26,6)',
            'decimal'  => 'decimal',
            'decimal2' => 'decimal',
            'id'       => 'varchar(36)',
            'url'      => 'nvarchar',
            'encrypt'  => 'nvarchar',
            'file'     => 'nvarchar',
	        'decimal_tpl' => 'decimal(%d, %d)',
    );

    public function query($sql, $dieOnError = false, $msg = '', $suppress = true, $keepResult = false)
    {
		global $app_strings;
        if(is_array($sql)) {
            return $this->queryArray($sql, $dieOnError, $msg, $suppress);
        }

		$sql = $this->_appendN($sql);
		return parent::query($sql, $dieOnError, $msg, $suppress, $keepResult);
    }

    /**
     * Check if this driver can be used
     * @return bool
     */
    public function valid()
    {
        return function_exists("mssql_connect") && DBManagerFactory::isFreeTDS();
    }

    public function appendN($sql)
    {
        return $this->_appendN($sql);
    }

    /**
     * @inheritdoc
     */
    public function checkConnection()
    {
        $this->last_error = '';
        if (!isset($this->database) || !is_resource($this->database)) {
            $this->database = null;
            $this->connect();
        }
    }

    /**
     * @inheritdoc
     */
    public function checkError($msg = '', $dieOnError = false)
    {
        $result = parent::checkError($msg, $dieOnError);
        if ($result) {
            $this->disconnect();
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getGuidSQL()
    {
        return 'convert(varchar(36), NEWID())';
    }
}
