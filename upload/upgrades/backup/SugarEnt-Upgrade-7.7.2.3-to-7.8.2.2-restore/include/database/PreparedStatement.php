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

/**
 * Base prepared statement database implementation
 * @api
 */

abstract class PreparedStatement
{
    /**
     * DBManager parent
     * @var DBManager
     */
    protected $DBM = null;

    /**
     * Actual concrete DB resource link, will be used by child classes
     * @var mixed
     */
    protected $dblink;

    /**
     * Text of the last query
     * @var string
     */
    protected $sqlText = null;

    /**
     * Parsed SQL text
     * @var string
     */
    protected $parsedSQL = null;

    /**
     * Prepared field definitions
     * @var array
     */
    protected $fieldDefs = array();

    /**
     * Array where key is position of lob field in query and value is name of field
     * @var array
     */
    protected $lobFields = array();

    /**
     * Place to bind query vars to
     * @var array
     */
    protected $bound_vars = array();

    /**
     * Data that is currently bound to the prepared statement
     *
     * @var array|null
     */
    protected $bound_data = null;

    /**
     * Time when query was started
     * @var int
     */
    protected $query_time;

    /**
     * Generic statement resource
     * @var mixed
     */
    protected $stmt;

    /**
     * Log reference
     * @var LoggerManager
     */
    public $log;

    /**
     * Prepare the statement for concrete database
     * @param string $sqlText SQL text of the query
     * @param array $fieldDefs Definitions for variables
     * @param string $msg Error message
     * @return PreparedStatement
     */
    abstract protected function preparePreparedStatement($msg = '');

    /**
     * Execute prepared statement
     * @param array $data Data for placeholders
     * @param string $msg Error message
     * @return PreparedStatement
     */
    abstract public function executePreparedStatement(array $data,  $msg = '');

    /**
     * Finalize & close prepared statement
     */
    public function preparedStatementClose()
    {
        $this->stmt = null;
    }

    /**
     * Create Prepared Statement object
     */
    public function __construct(DBManager $DBM)
    {
        $this->log = $GLOBALS['log'];
        $this->DBM = $DBM;
        $this->dblink = $DBM->getDatabase();
    }

    /**
     * Parse SQL with types from sql in the form of "INSERT INTO testPreparedStatement(id, name) VALUES(?int, ?varchar)"
     * @param string $sql
     * @param array $lobs names of clob and blob fields from query
     * @return boolean
     */
    protected function parseSQL($sql, array $lobs = array())
    {
        if (empty($this->DBM)) {
            $this->log->error("Prepare failed: Database object missing");
            return false;
        }

        if (empty($sql)) {
            $this->log->error("Prepare failed: empty SQL statement");
            return false;
        }
        $this->sqlText = $sql;
        $this->log->info("Parse Query: $sql");
        // Build fieldDefs array and replace ?SugarDataType placeholders with a single ?placeholder
        $cleanedSql = "";
        $nextParam = strpos($sql, "?");
        if ($nextParam == 0) {
            $cleanedSql = $sql;
        } else { // parse the sql string looking for params
            $row = 0;
            while ($nextParam > 0) {
                $cleanedSql .= substr($sql, 0, $nextParam + 1); // we want the ?
                $sql = substr($sql, $nextParam + 1); // strip leading chars

                // scan for termination of SugarDataType
                $sugarDataType = "";
                for ($i = 0; ($i < strlen($sql)) and (strpos(",) ", substr($sql, $i, 1)) === false); $i++) {
                    if (strpos(",) ", substr($sql, $i, 1)) == false) {
                        $sugarDataType .= substr($sql, $i, 1);
                    }
                }
                if ($sugarDataType === "") {
                    // no type, default to varchar
                    $sugarDataType = 'varchar';
                }
                // insert the fieldDef
                $this->fieldDefs[$row]['type'] = $sugarDataType;
                if ($this->DBM->isTextType($sugarDataType)) {
                    if (empty($lobs)) {
                        $this->log->fatal('Name of lob field is not specified: ' . $this->sqlText);
                        return false;
                    }
                    $this->lobFields[$row] = array_shift($lobs);
                }
                $sql = substr($sql, $i); // strip off the SugarDataType
                $nextParam = strpos($sql, "?"); // look for another param
                $row++;
            }
            // add the remaining sql
            $cleanedSql .= $sql;
        }

        $this->parsedSQL = $cleanedSql;
        return true;
    }

    /**
     * Prepare statement for execution
     * @param string $sql SQL string to prepare
     * @param array $lobs names of clob and blob fields from query
     * @param string $msg Error message
     * @return false|PreparedStatement
     */
    public function prepareStatement($sql, array $lobs = array(), $msg = '')
    {
        if(!$this->parseSQL($sql, $lobs)) {
            $this->log->error("$msg: SQL parse failed: {$this->sqlText}");
            return false;
        }
        // Prepare the statement in the concrete database
        $preparedStatementHndl = $this->preparePreparedStatement();
        if (empty($preparedStatementHndl)) {
            return false;
        }
        return $this;
    }

    /**
     * Fill in data for prepated statement
     * @param array $data
     * @param string $msg Error message
     * @return boolean
     */
    protected function prepareStatementData(array $data, $param_count, $msg)
    {
        if(!$this->stmt) {
            $this->DBM->registerError($msg, "No prepared statement to execute");
            return false;
        }
        $this->DBM->countQuery($this->parsedSQL);
        $GLOBALS['log']->info("Executing Query: {$this->parsedSQL} with ".var_export($data, true));
        $this->bound_data = $data;

        $this->DBM->query_time = microtime(true);

        if ($param_count > count($data) )  {
            $this->DBM->registerError($msg, "Incorrect number of elements. Expected $param_count but got " . count($data));
            return false;
        }

        if (!empty($data)) {
            reset($data);
            // bind the variables
            for($i=0; $i<$param_count;$i++) {
                $this->bound_vars[$i] = current($data);
                next($data);
            }
        }

        return true;
    }

    /**
     * Finalize after statement execution
     * @param mixed $res Result. If false, it failed
     * @param string $msg Error message
     * @return false|PreparedStatement
     */
    protected function finishStatement($res, $msg)
    {
        $this->DBM->query_time = microtime(true) - $this->DBM->query_time;
        $GLOBALS['log']->info('Query Execution Time:'.$this->DBM->query_time);

        if($this->DBM->checkError("$msg: Query Failed")) {
            $this->stmt = false;
            return false;
        }

        if (!$res) {
            $this->DBM->registerError($msg, "Query Failed");
            $this->stmt = false; // Making sure we don't use the statement resource for error reporting
        } else {
            $this->DBM->dump_slow_queries($this->parsedSQL, $this->bound_data);
        }

        return $this;
    }

    /**
     * Fetch data for prepared statement
     * Default implementation just reuses the fetchRow
     * @param string $msg Error message
     */
    public function preparedStatementFetch($msg = '')
    {
        if(!$this->stmt) {
            return false;
        }
        // Just go to regular fetch
        return $this->DBM->fetchRow($this->stmt);
    }

}
