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



 /* to summarize what we are trying to do in Oracle:

    $stmt = oci_parse($conn,"INSERT INTO testPreparedStatement (id, col1, col2) VALUES(:p1, :p2, :p3)");
    $bound = array();
    oci_bind_by_name($stmt, ":p1", $bound[1], -1, $dataTypes[1]);
    oci_bind_by_name($stmt, ":p2", $bound[2], -1, $dataTypes[2]);
    oci_bind_by_name($stmt, ":p3", $bound[3], -1, $dataTypes[3]);
    oci_execute($stmt);

  The stages it goes through are:

    DBManager.insertParams
        Table:      testPreparedStatement
        Field_defs: { ['id']   => { ['name'] => 'id',   ['type'] => 'id',      ['required']=>true },
                    { ['col1'] => { ['name'] => 'col1', ['type'] => 'varchar', ['len'] => '100' },
                    { ['col2'] => { ['name'] => 'col2', ['type'] => 'varchar', ['len'] => '100' },
        Data:       { ['id'] => 3, ['col1'] => "col1 data for id 3", ['col2'] => "col2 data for id 3" }
        Field_map:  null

    PreparedStatement.__construct
	SQL:   INSERT INTO testPreparedStatement (id,col1,col2) VALUES (?id,?varchar,?varchar)
        Data:  { ["id"]=> "'3'", ["col1"]=> "'col1 data for id 3'", ["col2"]=> "'col2 data for id 3'" }

    OraclePreparedStatement.preparePreparedStatement
	SQL:   INSERT INTO testPreparedStatement (id,col1,col2) VALUES (?,?,?)
        Data:  { ["id"]=> "'3'", ["col1"]=> "'col1 data for id 3'", ["col2"]=> "'col2 data for id 3'" }
	Types: { [0]=> {["type"]=>"id"}, [1]=>{["type"]=>"varchar"}, [2]=>{["type"]=>"varchar"}

        $stmt = oci_parse($conn,"INSERT INTO testPreparedStatement (id, col1, col2) VALUES(:p1, :p2, :p3)");
        $bound = array();
        oci_bind_by_name($stmt, ":p1", $bound[1], -1, $dataTypes[1]);
        oci_bind_by_name($stmt, ":p2", $bound[2], -1, $dataTypes[2]);
        oci_bind_by_name($stmt, ":p3", $bound[3], -1, $dataTypes[3]);

        Data: $bound = { [1]=> "3", [2]=> "col1 data for id 3", [3]=> "col2 data for id 3" }
        oci_execute($stmt);
 */

require_once 'include/database/PreparedStatement.php';

class OraclePreparedStatement extends PreparedStatement
{
    /**
     * Oracle statement resource
     * @var resource
     */
    protected $stmt;

    /*
     * Maps column datatypes to OCI bind variable types
     *
     * Possible types are:
     *
     *     SQLT_BFILEE or OCI_B_BFILE    - for BFILEs;
     *     SQLT_CFILEE or OCI_B_CFILEE   - for CFILEs;
     *     SQLT_CLOB   or OCI_B_CLOB     - for CLOBs;
     *     SQLT_BLOB   or OCI_B_BLOB     - for BLOBs;
     *     SQLT_RDD    or OCI_B_ROWID    - for ROWIDs;
     *     SQLT_NTY    or OCI_B_NTY      - for named datatypes;
     *     SQLT_INT    or OCI_B_INT      - for integers;
     *     SQLT_CHR                      - for VARCHARs, Converts the PHP parameter to a string type and binds as a string.;
     *     SQLT_LVC                      - Used with oci_bind_array_by_name() to bind arrays of LONG VARCHAR.
     *     SQLT_STR                      - Used with oci_bind_array_by_name() to bind arrays of STRING.
     *     SQLT_BIN    or OCI_B_BIN      - for RAW columns;
     *     SQLT_LNG                      - for LONG columns;
     *     SQLT_ODT                      - for LONG columns;
     *     SQLT_LBI                      - for LONG RAW columns;
     *     SQLT_RSET   or OCI_B_CURSOR   - for cursors created with oci_new_cursor(). Used with oci_bind_by_name() when binding cursors,
     *                                     previously allocated with oci_new_descriptor().
     *     SQLT_NUM    or OCI_B_NUM      - Converts the PHP parameter to a 'C' long type, and binds to that value.
     *                                     Used with oci_bind_array_by_name() to bind arrays of NUMBER.
     *     SQLT_FLT                      - Used with oci_bind_array_by_name() to bind arrays of FLOAT.
     *                    OCI_B_CURSOR   -
     *     SQLT_AFC                      - Used with oci_bind_array_by_name() to bind arrays of CHAR.
     *     SQLT_AVC                      - Used with oci_bind_array_by_name() to bind arrays of VARCHAR2.
     *     SQLT_VCS                      - Used with oci_bind_array_by_name() to bind arrays of VARCHAR.
     */
    protected $typeMap = array(
            // Sugar DataType      PHP Bind Variable data type
            'string'           => SQLT_CHR,
            'date'             => SQLT_CHR,
            'time'             => SQLT_CHR,
            'float'            => SQLT_CHR,
            'bigint'           => SQLT_CHR,
            'int'              => SQLT_INT,
            'bool'             => SQLT_INT,
    );

    public function __destruct() {
        if(is_resource($this->stmt)){
            oci_free_statement($this->stmt);
        }
    }

    public function preparePreparedStatement( $msg = '' )
    {
        if(empty($this->parsedSQL)) {
            $this->DBM->registerError($msg, "Empty SQL query");
            return false;
        }

        $GLOBALS['log']->info('QueryPrepare: ' . $this->parsedSQL);

        $i = -1;
        $db = $this->DBM;
        $defs = $this->fieldDefs;
        $lobFields = $this->lobFields;
        $oSQL = preg_replace_callback('#\?#',
            function () use (&$i, $db, $defs, $lobFields) {
                ++$i;
                if ($db->isTextType($defs[$i]["type"]) || !empty($lobFields[$i])) {
                    // BLOBS should have empty(...) in the query
                    return $db->emptyValue($defs[$i]["type"], true);
                }
                return ":p$i";
            },
            $this->parsedSQL
        );
        if(!empty($this->lobFields)) {
            $aliases = array();
            foreach ($this->lobFields as $key => $_) {
                array_push($aliases, ":p{$key}");
            }
            $oSQL .= ' RETURNING ' . implode(",", array_values($this->lobFields)).
                ' INTO ' . implode(",", $aliases);
        }

        // do the prepare
        $this->stmt = oci_parse($this->dblink, $oSQL);
        if($this->DBM->checkError(" QueryPrepare Failed: $msg for sql: $oSQL ::")) {
            return false;
        }

        // bind the array elements
        $num_args = count($this->fieldDefs);
        $this->bound_vars = array_fill(0, $num_args, null);

        foreach ($this->lobFields as $idx => $name) {
            $this->bound_vars[$idx] = oci_new_descriptor($this->dblink, OCI_D_LOB);
        }
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see PreparedStatement::executePreparedStatement()
     */
    public function executePreparedStatement(array $data,  $msg = '')
    {
        if (!$this->prepareStatementData($data, count($this->fieldDefs), $msg)) {
            return false;
        }
        $res = oci_execute($this->stmt, OCI_NO_AUTO_COMMIT);

        foreach ($this->lobFields as $ind => $field) {
            if (isset($data[$ind])) {
                if (!$this->bound_vars[$ind]->save($data[$ind])) {
                    $this->DBM->checkError("$msg: Saving BLOB for {$field}");
                    oci_rollback($this->dblink);
                    return false;
                }
            }
        }
        oci_commit($this->dblink);

        return $this->finishStatement($res, $msg);
    }

    /**
     * @inheritdoc
     */
    protected function prepareStatementData(array $data, $param_count, $msg)
    {
        if (!$this->stmt) {
            $this->DBM->registerError($msg, "No prepared statement to execute");
            return false;
        }
        $this->DBM->countQuery($this->parsedSQL);
        $GLOBALS['log']->info("Executing Query: {$this->parsedSQL} with ".var_export($data, true));
        $this->bound_data = $data;

        $this->DBM->query_time = microtime(true);

        if ($param_count != count($data)) {
            $this->DBM->registerError(
                $msg,
                "Incorrect number of elements. Expected $param_count but got " . count($data)
            );
            return false;
        }
        if (!empty($data)) {
            reset($data);
            for ($i = 0; $i < $param_count; $i++) {
                if (empty($this->fieldDefs[$i]["type"])) {
                    $this->DBM->registerError($msg, "No defs entry for parameter $i");
                    return false;
                }
                $type = $this->fieldDefs[$i]["type"];
                if (empty($this->lobFields[$i])) {

                    if (empty($this->fieldDefs[$i]["type"])) {
                        $this->DBM->registerError($msg, "No defs entry for parameter $i");
                        return false;
                    }

                    $mappedType = $this->DBM->getTypeClass($type);
                    if (!empty($this->typeMap[$mappedType])) {
                        $mappedType = $this->typeMap[$mappedType];
                    } else {
                        $mappedType = SQLT_CHR;
                    }

                    $this->bound_vars[$i] = current($data);
                } else {
                    if ($this->DBM->getColumnType($type) == 'clob') {
                        $mappedType = OCI_B_CLOB;
                    } else {
                        $mappedType = OCI_B_BLOB;
                    }
                }
                oci_bind_by_name($this->stmt, ":p$i", $this->bound_vars[$i], -1, $mappedType);
                if ($this->DBM->checkError("$msg: QueryPrepare Failed for parameter $i")) {
                    oci_free_statement($this->stmt);
                    $this->stmt = null;
                    return false;
                }
                next($data);
            }
        }

        return true;
    }

    /**
     * (non-PHPdoc)
     * @see PreparedStatement::preparedStatementClose()
     */
    public function preparedStatementClose()
    {
        foreach($this->lobFields as $idx => $name) {
            if(!empty($this->bound_vars[$idx])) {
                $this->bound_vars[$idx]->free();
            }
        }

        $this->stmt = null;
    }
}
