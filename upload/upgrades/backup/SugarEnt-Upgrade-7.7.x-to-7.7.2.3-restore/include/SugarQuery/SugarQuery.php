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

require_once 'include/SugarQuery/SugarQueryException.php';
require_once 'include/SugarQuery/Compiler.php';
require_once 'include/SugarQuery/Builder/Orderby.php';
require_once 'include/SugarQuery/Builder/Having.php';
require_once 'include/SugarQuery/Builder/Groupby.php';
require_once 'include/SugarQuery/Builder/Where.php';
require_once 'include/SugarQuery/Builder/Andwhere.php';
require_once 'include/SugarQuery/Builder/Orwhere.php';
require_once 'include/SugarQuery/Builder/Join.php';
require_once 'include/SugarQuery/Builder/Select.php';
require_once 'include/SugarQuery/Builder/Union.php';
require_once 'include/SugarQuery/Builder/Condition.php';
require_once 'include/SugarQuery/Builder/Literal.php';
require_once 'include/SugarQuery/Builder/Field.php';

class SugarQuery
{

    /**
     * This is the Select Object
     * @var null|SugarQuery_Builder_Select
     */
    public $select = null;

    /**
     * This is the Union Object
     * @var null|SugarQuery_Builder_Union
     */
    public $union = null;

    /**
     * @var null|array
     */
    public $group_by = null;

    /**
     * @var null|array
     */
    public $having = null;

    /**
     * @var null|array
     */
    public $order_by = array();

    /**
     * @var null|integer
     */
    public $limit = null;

    /**
     * @var null|integer
     */
    public $offset = null;

    /**
     * @var bool
     */
    public $distinct = false;

    /**
     * @var null|SugarBean
     */
    public $from = false;

    /**
     * @var SugarQuery_Builder_Where[]
     */
    public $where = array();

    /**
     * @var SugarQuery_Builder_Join[]
     */
    public $join = array();

    protected $joined_tables = array();

    protected $jt_index = 0;
    /**
     * @var DBManager
     */
    protected $db;

    /**
     * Stores joins corresponding to links
     * @var array
     */
    protected $links = array();

    /**
     * Stores parent field for this query
     * @var array
     */
    protected $has_parent;

    /**
     * Bean templates for used tables
     * @var array
     */
    protected $table_beans = array();

    /**
     * If an rname_link field is used, this is the join alias
     * @var bool|string
     */
    public $rname_link = false;

    public $joinTableToKey = array();

    public $joinLinkToKey = array();

    public $fields = array();

    /**
     * @var bool True when the custom table for the current bean has already been added to the query
     */
    public $customJoined = false;

    /**
     * Should we use prepared statements?
     * @var bool
     * @deprecated("Will be deprecated in 7.8 version and above")
     */
    public $usePreparedStatements = false;

    /**
     * Prepared statement data
     * @var array
     */
    public $data = array();

    protected $dataItems = array();
    protected $dataSegment;

    /**
     * @param DBManager $db
     */
    public function __construct(DBManager $db = null)
    {
        $this->select = new SugarQuery_Builder_Select($this, array());
        $this->setDBManager($db ?: DBManagerFactory::getInstance());
    }

    /**
     * Set DBManager
     * @param DBManager $db
     */
    public function setDBManager(DBManager $db)
    {
        $this->db = $db;
        // usePreparedStatements will be deprecated in 7.8 version and above
        if (!$this->db->usePreparedStatements) {
            $this->usePreparedStatements = false;
        }
    }

    /**
     * Get DBManager
     * @return DBManager
     */
    public function getDBManager()
    {
        return $this->db;
    }

    /**
     * Build the select object
     *
     * @param array $fields
     *
     * @return null|SugarQuery_Builder_Select
     */
    public function select($fields = array())
    {
        if (!is_array($fields)) {
            $fields = func_get_args();
        }
        if (!is_object($this->select)) {
            $this->select = new SugarQuery_Builder_Select($this, array());
        }
        $this->select->field($fields);
        return $this->select;
    }

    /**
     * Build the union object.
     *
     * @param SugarQuery $select Query object.
     * @param bool $all (optional) Indicates if 'UNION ALL' should be used or not. Default is `true`.
     * @return SugarQuery_Builder_Union instance of union object.
     */
    public function union(SugarQuery $select, $all = true)
    {
        if (!is_object($this->union)) {
            $this->union = new SugarQuery_Builder_Union($this);
        }

        if (!empty($select)) {
            $this->union->addQuery($select, $all);
        }

        return $this->union;
    }

    /**
     * Set the from bean
     *
     * @param SugarBean $bean
     * @param bool $alias
     *
     * @return SugarQuery
     */
    public function from(SugarBean $bean, $options = array())
    {
        if (is_string($options)){
            $options = array('alias' => $options);
        }

        $alias = (isset($options['alias'])) ? $options['alias'] : false;

        if (!empty($alias)) {
            $newAlias = $this->db->getValidDBName($alias, false, 'alias');
            if (strtolower($alias) != $newAlias) {
                throw new SugarQueryException("From alias is more than the max allowed length for an alias");
            }
        }

        $team_security = (isset($options['team_security'])) ? $options['team_security'] : true;
        $add_deleted = (isset($options['add_deleted'])) ? $options['add_deleted'] : true;
        $this->from = $bean;
        if (!empty($alias)) {
            $this->from = array($bean, $alias);
        }

        if ($team_security === true) {
            if (!empty($alias)) {
                $options['table_alias'] = $alias;
            }
            if (!isset($options['action'])) {
                $options['action'] = 'list';
            }
            $bean->addVisibilityQuery($this, $options);
        }

        if ($add_deleted === true) {
            $this->where()->equals('deleted', 0);
        }
        $this->rebuildFields();

        return $this;
    }

    /**
     * Add an AND Where Object to this query
     *
     * @param array $conditions
     *
     * @return SugarQuery_Builder_Where
     */
    public function where($conditions = array())
    {
        if (!isset($this->where['and'])) {
            $this->where['and'] = new SugarQuery_Builder_Andwhere($this);
        }
        if (!empty($conditions)) {
            $this->where['and']->add($conditions);
        }
        return $this->where['and'];
    }

    /**
     * Build a raw where statement
     *
     * @param $sql
     *
     * @return SugarQuery_Builder_Andwhere
     */
    public function whereRaw($sql)
    {
        $where = new SugarQuery_Builder_Andwhere($this);
        $where->addRaw($sql);
        if (!isset($this->where['and'])) {
            $this->where['and'] = new SugarQuery_Builder_Andwhere($this);
        }
        $this->where['and']->add($where);
        return $this->where['and'];
    }


    /**
     * Add an Or Where Object to this query
     *
     * @param array $conditions
     *
     * @return SugarQuery_Builder_Orwhere
     */
    public function orWhere($conditions = array())
    {
        if (!isset($this->where['or'])) {
            $this->where['or'] = new SugarQuery_Builder_Orwhere($this);
        }

        if (!empty($conditions)) {
            $this->where['or']->add($conditions);
        }

        return $this->where['or'];
    }


    /**
     * Add a traditional query builder join object to this query
     *
     * @param string $table
     * @param array $options
     *
     * @return SugarQuery_Builder_Join
     */
    public function joinTable($table, $options = array())
    {
        if (!isset($options['linkingTable']) && !isset($options['bean'])) {
            $options['linkingTable'] = true;
        }
        $join = new SugarQuery_Builder_Join($table, $options);
        $join->query = $this;
        if (isset($options['alias'])) {
            $key = $options['alias'];
        } else {
            $key = $table;
        }

        $this->join[$key] = $join;
        $this->joinTableToKey[$table] = $key;
        return $join;
    }

    /**
     * Add a raw [straight SQL] join object to this query
     *
     * @param string $sql
     * @param array $options
     *
     * @return SugarQuery_Builder_Join
     */
    public function joinRaw($sql, $options = array())
    {
        $join = new SugarQuery_Builder_Join();
        $join->query = $this;
        $join->addRaw($sql);
        if (isset($options['alias']) && !empty($options['alias'])) {
            $this->join[$options['alias']] = $join;
        } else {
            $this->join[md5($sql)] = $join;
        }


        return $join;
    }

    /**
     * Add a join based on a link with the from bean
     *
     * @param string $link_name
     * @param array $options
     *
     * @return SugarQuery_Builder_Join
     */
    public function join($link_name, $options = array())
    {
        $relatedJoin = empty($options['relatedJoin']) ? false : $options['relatedJoin'];
        if (!isset($options['alias'])) {
            $options['alias'] = $this->getJoinTableAlias($link_name, $relatedJoin);
        }

        if (!isset($options['action'])) {
            $options['action'] = 'list';
        }

        if (!empty($this->links[$options['alias']])) {
            return $this->links[$options['alias']];
        }

        // FIXME: it's really not good we have a special case here
        if (!empty($options['favorites']) || $link_name == 'favorites') {
            $sfOptions = $options;
            $sf = new SugarFavorites();
            $options['alias'] = $sf->addToSugarQuery($this, $sfOptions);
        } else {
            $this->loadBeans($link_name, $options);
        }
        $this->join[$options['alias']]->addLinkName($link_name);
        $this->links[$link_name] = $this->join[$options['alias']];
        $link_name_key = $relatedJoin ? $relatedJoin . '_' . $link_name : $link_name;
        $this->joinLinkToKey[$link_name_key] = $options['alias'];

        return $this->join[$options['alias']];
    }

    /**
     *
     * Used to get a unique join table alias to prevent conflicts when joining the same table multiple times
     * or joining a table against itself
     *
     * @param string $table_name (optional)
     * @param bool $relatedJoin (optional)
     * @param bool isLink (optional)
     *
     * @return string
     */
    public function getJoinTableAlias($table_name = "", $relatedJoin = false, $isLink = true)
    {
        $table_name = $relatedJoin ? $relatedJoin . '_' . $table_name : $table_name;
        if ($alias = $this->getJoinAlias($table_name, $isLink)) {
            return $alias;
        }

        $alias = "jt" . $this->jt_index++;
        if (!empty($table_name)) {
            $alias .= "_" . $table_name;
        }

        return $this->db->getValidDBName($alias, 'alias');
    }

    /**
     * Add a join based on a link from the target bean
     *
     * @param SugarBean $bean
     * @param string $link_name
     * @param array $options
     *
     * @return SugarQuery
     */
    public function joinSubpanel($bean, $link_name, $options = array())
    {
        //Force a unique join table alias for self referencing relationships and multiple joins against the same table
        $alias = !empty($options['joinTableAlias']) ? $options['joinTableAlias'] : $this->getJoinTableAlias(
            $link_name
        );
        $joinType = (!empty($options['joinType'])) ? $options['joinType'] : 'INNER';
        $ignoreRole = (!empty($options['ignoreRole'])) ? $options['ignoreRole'] : false;

        if (!$bean->load_relationship($link_name)) {
            throw new SugarApiExceptionInvalidParameter("Unable to load link $link_name");
        }

        $joinParams = array(
            'joinTableAlias' => $alias,
            'joinType' => $joinType,
            'ignoreRole' => $ignoreRole,
            'reverse' => true,
            'includeCustom' => true,
        );
        if (!empty($options['myAlias'])) {
            $joinParams['myAlias'] = $options['myAlias'];
        }

        $bean->$link_name->buildJoinSugarQuery($this, $joinParams);

        $this->join[$alias]->addLinkName($link_name);
        $this->join[$alias]->on()->equals($alias . '.id', $bean->id);
        $this->links[$link_name] = $this->join[$alias];

        return $this->join[$alias];
    }


    /**
     * Add a join-on if there is an rname_link in use
     *
     * @param array $options
     *
     */
    public function setJoinOn($options = array())
    {
        if ($this->rname_link !== false && !empty($options['baseBean']) && !empty($options['baseBeanId'])) {
            $this->join[$this->rname_link]->on()->addRaw("{$options['baseBean']}_id = '{$options['baseBeanId']}'");
        }        
    }

    /**
     * If group by is not empty, then add rest of fields in select statement
     */
    protected function addGroupByFields()
    {
        //make sure 'group by' is not empty, if 'group by' is empty then we don't need to modify 'group by'
        if (!empty($this->group_by)) {
            $groupByCols = array();
            //grab the defined cols so we don't add them twice
            foreach ($this->group_by AS $groupBy) {
                $groupByCols[$groupBy->column->table . '.' . $groupBy->column->field] = $groupBy->column->field;
            }
            //make sure all the fields in the select statement are in the group by
            foreach ($this->select->select as $selectFieldKey => $selectField) {
                //add cols not already defined
                if (empty($groupByCols[$selectField->table . '.' . $selectField->field])) {
                    //if field class is raw, then we need to do some special processing
                    if (get_class($selectField) == 'SugarQuery_Builder_Field_Raw') {
                        //check to see if this is a concatenated field:
                        if (!empty($selectField->alias) && !empty($this->from->field_name_map[$selectField->alias]['db_concat_fields'])) {
                            //we need to get the concatenated fields
                            $concatFields = $this->from->field_name_map[$selectField->alias]['db_concat_fields'];
                            //check to see if join exists, otherwise use table name
                            $table = $this->from->field_name_map[$selectField->alias]['table'];
                            $linkName = $this->from->field_name_map[$selectField->alias]['link'];
                            //check for join name only if we have a table and link name
                            if (!empty($table) && !empty($linkName)) {
                                foreach ($this->join as $joinName => $joinDef) {
                                    if ($joinDef->table == $table && $joinDef->linkName == $linkName) {
                                        //table and link match this join, use the join name in the 'group by'
                                        $table = $joinName;
                                        break;
                                    }
                                }
                            }
                            //add each concat field to the group by
                            foreach ($concatFields as $fieldToAdd) {
                                if (empty($fieldToAdd) || !is_string($fieldToAdd)) {
                                    //skip empty or array fields (should never happen unless metadata is bad)
                                    continue;
                                }
                                $this->groupBy($table . '.' . $fieldToAdd);
                            }
                        } else {
                            //not a concatenated field, so let's parse the string and attempt to grab the table and field name
                            $fieldToAdd = $selectField->field;
                            $fieldStringArray = explode(' ', $fieldToAdd);

                            foreach ($fieldStringArray as $fieldStr) {
                                if (strpos($fieldStr, '.' ) !== false) {
                                    $fieldToAdd = $fieldStr;
                                    break;
                                }
                            }

                            //add either the newly saved table and field name or the entire string
                            $this->groupBy($fieldToAdd);
                        }
                    } else {
                        $type = $this->db->getFieldType($selectField->def);
                        if ($type && $this->db->isTextType($type)) {
                            $castedField = $this->db->convert(
                                $selectField->table . '.' . $selectField->field,
                                'text2char'
                            );
                            $this->groupByRaw($castedField);
                            $selectField->addToSelectRaw($castedField, $selectFieldKey);
                            continue;
                        }
                        //Field class is not of type raw, add the table and field name from the selectField array
                        $this->groupBy($selectField->table . '.' . $selectField->field);
                    }
                } //end if (empty($groupByCols[$selectField->field]))
            } //end foreach ($this->select->select as $selectField)
        }//end if(!empty($this->group_by)){
    }


    /**
     * Compile this SugarQuery into a standard SQL-92 Query string
     * @return string
     */
    public function compileSql(SugarQuery $parent = null)
    {
        $compiler = new SugarQuery_Compiler();
        $this->data = $this->dataItems = array();

        //check if short list of fields in 'group by' is supported, if not add all fields in select
        if (empty($this->db->capabilities['short_group_by'])) {
            //add fields to group by
            $this->addGroupByFields();
        }

        $sql = $compiler->compile($this, $this->db);
        if($parent) {
            $parent->addData($this->data);
        }
        return $sql;
    }

    /**
     * Execute this query and return it as a raw string, db object json, or array
     *
     * @param string $type
     *
     * @return array|dbObject|string
     */
    public function execute($type = "array", $encode = true)
    {
        switch ($type) {
            case 'raw':
                return $this->compileSql($this);
                break;
            case 'db':
                return $this->runQuery($this);
                break;
            case 'json':
            case 'array':
            default:
                $results = $this->runQuery($this);
                $return = array();
                while ($row = $this->db->fetchByAssoc($results, $encode)) {
                    //Apply any post data cleanup/db abstraction
                    $row = $this->formatRow($row);
                    $return[] = $row;
                }
                if ($type == 'json') {
                    return json_encode($return);
                }
                return $return;
                break;
        }
    }

    /**
     * Get one value result from the query
     * @return false|string
     */
    public function getOne()
    {
       if(empty($this->limit)) {
           $this->offset(0)->limit(1);
       }
       $result = $this->runQuery();
       if(empty($result)) {
           return false;
       }
       $row = $this->db->fetchByAssoc($result, true, true);
       if(!empty($row)) {
           return array_shift($row);
       }
       return false;
    }

    /**
     * Run the query and return the db result object
     * @return db result object
     */
    protected function runQuery()
    {
        $sql = $this->compileSql();
        // usePreparedStatements will be deprecated in 7.8 version and above
        if($this->usePreparedStatements) {
            return $this->db->preparedQuery($sql, $this->data);
        } else {
            return $this->db->query($sql);
        }
    }

    /**
     * Applies any cleanup or formatting required on the raw DB data result.
     *
     * @param array $row
     *
     * @return array updated $row
     */
    protected function formatRow(array $row)
    {
        //remap long aliases to thier correct output key
        if (!empty($this->select)) {
            foreach ($this->select->select as $field) {
                if (!empty($field->original_alias) && isset($row[$field->alias])) {
                    $row[$field->original_alias] = $row[$field->alias];
                    unset($row[$field->alias]);
                }
            }
        }
        return $row;
    }


    /**
     * This will eventually determine the type of query [select, update, delete, insert] and return the specific type
     * @return string
     */
    public static function getType()
    {
        return 'select';
    }

    /**
     * Set this Query as Distinct
     *
     * @param bool $value
     *
     * @return SugarQuery
     */
    public function distinct($value)
    {
        $this->distinct = (bool)$value;
        return $this;
    }


    /**
     * Set the offset of this query
     *
     * @param int $number
     *
     * @return SugarQuery
     */
    public function offset($number)
    {
        $this->offset = $number;

        return $this;
    }

    /**
     * Add a group by statement to this query
     *
     * @param array $array
     *
     * @return SugarQuery
     */
    public function groupBy($column)
    {
        $groupBy = new SugarQuery_Builder_Groupby($this);
        $groupBy->addField($column);
        $this->group_by[] = $groupBy;
        return $this;
    }

    public function groupByRaw($expression)
    {
        $groupBy = new SugarQuery_Builder_Groupby($this);
        $groupBy->addRaw($expression);
        $this->group_by[] = $groupBy;
        return $this;
    }

    /**
     * Add a having statement to this query
     *
     * @param array $array
     *
     * @return SugarQuery
     */
    public function having($conditions)
    {
        $having = new SugarQuery_Builder_Andwhere($this);
        if (!empty($conditions)) {
            $having->add($conditions);
        }
        $this->having[] = $having;
        return end($this->having);
    }

    public function havingRaw($expression)
    {
        $having = new SugarQuery_Builder_Andwhere($this);
        $having->addRaw($expression);
        $this->having[] = $having;
        return end($this->having);
    }


    /**
     * Add an order by statement for this query
     *
     * @param string $column
     * @param string $direction
     *
     * @return SugarQuery
     */
    public function orderBy($column, $direction = 'DESC')
    {
        $orderBy = new SugarQuery_Builder_Orderby($this, $direction);
        $orderBy->addField($column);
        $this->order_by[] = $orderBy;

        return $this;
    }


    /**
     * Add an order by raw expression for this query
     *
     * @param string $expression Raw expression to sort.
     * @param string $direction Values ASC or DESC.
     *
     * @return SugarQuery
     */
    public function orderByRaw($expression, $direction = 'DESC')
    {
        $orderBy = new SugarQuery_Builder_Orderby($this, $direction);
        $orderBy->addRaw($expression);
        $this->order_by[] = $orderBy;
        return $this;
    }

    /**
     * Reset ORDER BY of query
     *
     * @return SugarQuery
     */
    public function orderByReset()
    {
        $this->order_by = array();
        return $this;
    }

    /**
     * Set the limit of this query
     *
     * @param int $number
     *
     * @return SugarQuery
     */
    public function limit($number)
    {
        $this->limit = $number;

        return $this;
    }

    /**
     * After a from is changed rebuild all the fields to check the vardefs
     */
    protected function rebuildFields()
    {
        if (!empty($this->select)) {
            foreach ($this->select->select as $field) {
                if ($field instanceof SugarQuery_Builder_Field) {
                    $field->setupField($this);
                }
            }
        }

        if (!empty($this->join)) {
            foreach ($this->join as $joinObj) {
                if (!empty($joinObj->on['and'])) {
                    foreach ($joinObj->on['and'] as $whereObj) {
                        if (empty($whereObj->conditions)) {
                            continue;
                        }
                        foreach ($whereObj->conditions as $conditionObj) {
                            if ($conditionObj->field instanceof SugarQuery_Builder_Field) {
                                $conditionObj->field->setupField($this);
                            }
                        }
                    }
                }
                if (!empty($joinObj->on['or'])) {
                    foreach ($joinObj->on['or'] as $whereObj) {
                        if (empty($whereObj->conditions)) {
                            continue;
                        }
                        foreach ($whereObj->conditions as $conditionObj) {
                            if ($conditionObj->field instanceof SugarQuery_Builder_Field) {
                                $conditionObj->field->setupField($this);
                            }
                        }
                    }
                }
            }
        }

        if (!empty($this->where['and'])) {
            foreach ($this->where['and'] as $whereObj) {
                if (empty($whereObj->conditions)) {
                    continue;
                }
                foreach ($whereObj->conditions as $conditionObj) {
                    if ($conditionObj->field instanceof SugarQuery_Builder_Field) {
                        $conditionObj->field->setupField($this);
                    }
                }
            }
        }

        if (!empty($this->where['or'])) {
            foreach ($this->where['or'] as $whereObj) {
                if (empty($whereObj->conditions)) {
                    continue;
                }
                foreach ($whereObj->conditions as $conditionObj) {
                    if ($conditionObj->field instanceof SugarQuery_Builder_Field) {
                        $conditionObj->field->setupField($this);
                    }
                }
            }
        }

        if (!empty($this->order_by)) {
            foreach ($this->order_by as $orderObj) {
                if ($orderObj->column instanceof SugarQuery_Builder_Field) {
                    $orderObj->column->setupField($this);
                }
            }
        }

        if (!empty($this->group_by)) {
            foreach ($this->group_by as $groupByObj) {
                if ($groupByObj->column instanceof SugarQuery_Builder_Field) {
                    $groupByObj->column->setupField($this);
                }
            }
        }

        if (!empty($this->having)) {
            foreach ($this->having as $whereObj) {
                if (empty($whereObj->conditions)) {
                    continue;
                }
                foreach ($whereObj->conditions as $conditionObj) {
                    if ($conditionObj->field instanceof SugarQuery_Builder_Field) {
                        $conditionObj->field->setupField($this);
                    }
                }
            }
        }
    }
    /**
     * Load Beans uses Link2 to take a SugarQuery object and add the joins needed to take a link and make the connection
     *
     * @param Linkname $join
     * @param $alias
     */
    protected function loadBeans($join, $options)
    {
        $alias = (!empty($options['alias'])) ? $options['alias'] : $this->getJoinTableAlias($join);
        $joinType = (!empty($options['joinType'])) ? $options['joinType'] : 'INNER';
        $team_security = (isset($options['team_security'])) ? $options['team_security'] : true;
        $ignoreRole = (!empty($options['ignoreRole'])) ? $options['ignoreRole'] : false;

        $bean = !empty($options['relatedJoin']) ? $this->join[$options['relatedJoin']]->bean : $this->from;

        if (is_array($bean)) {
            // the bean is the first element of the array
            $bean = reset($bean);
        }

        $bean->load_relationship($join);
        if (empty($bean->$join)) {
            throw new SugarApiExceptionInvalidParameter("Invalid link $join");
        }

        $bean->$join->buildJoinSugarQuery(
            $this,
            array(
                'joinTableAlias' => $alias,
                'joinType' => $joinType,
                'ignoreRole' => $ignoreRole,
            )
        );
        $joined = BeanFactory::newBean($bean->$join->getRelatedModuleName());
        if ($team_security === true) {
            $options['table_alias'] = $alias;
            $options['as_condition'] = true;
            $joined->addVisibilityQuery($this, $options);
        }

        if ($joined->hasCustomFields()) {
            $table_cstm = $joined->get_custom_table_name();
            $alias_cstm = $this->db->getValidDBName($alias . '_cstm', false, 'alias');
            $this->joinTable($table_cstm, array('alias' => $alias_cstm, 'joinType' => "LEFT", "linkingTable" => true))
                ->on()->equalsField("$alias_cstm.id_c", "{$alias}.id");
        }

    }

    /**
     * Set/get parent field for the query
     * @param array|null $has
     * @return array
     */
    public function hasParent($has = null)
    {
        if ($has !== null) {
            $this->has_parent = $has;
        }
        return $this->has_parent;
    }

    /**
     * Get bean that corresponds to this table name
     *
     * @param string $table_name
     *
     * @return SugarBean
     */
    public function getTableBean($table_name)
    {
        if (substr($table_name, -5) == '_cstm') {
            // if we've got _cstm name, it's the same bean as non-custom one
            $table_name = substr($table_name, 0, -5);
        }
        if (!isset($this->table_beans[$table_name])) {
            if (empty($this->join[$table_name])) {
                return null;
            }
            $link_name = $this->join[$table_name]->linkName;
            if ($link_name == 'favorites') {
                // FIXME: special case, should eliminate it
                $bean = BeanFactory::getBean('SugarFavorites');
            } elseif ($link_name == 'tracker') {
                $bean = BeanFactory::getBean('Trackers');
            } else {
                $bean = $this->join[$table_name]->bean;
            }

            $this->table_beans[$table_name] = $bean;
        }
        return $this->table_beans[$table_name];
    }

    public function getJoinAlias($name, $isLink = true)
    {
        if ($isLink) {
            return isset($this->joinLinkToKey[$name]) ? $this->joinLinkToKey[$name] : false;
        }
        if (isset($this->joinLinkToKey[$name])) {
            return $this->joinLinkToKey[$name];
        } elseif (isset($this->joinTableToKey[$name])) {
            return $this->joinTableToKey[$name];
        }
        return false;
    }

    /**
     * Returns the SugarBean Object that is the subject of this query.
     * @return null|SugarBean
     */
    public function getFromBean()
    {
        if (is_array($this->from)) {
            return $this->from[0];
        }

        return $this->from;
    }

    /**
     * Returns the alias of the from bean, or the bean table if no alias exists
     * @return String
     */
    public function getFromAlias()
    {
        if (is_array($this->from)) {
            return $this->from[1];
        }
        return $this->from->getTableName();
    }

    /**
     * @param $link_name name of link field to check for an existing join against.
     *
     * @return null|SugarQuery_Builder_Join
     */
    public function getJoinForLink($link_name)
    {
        if (!empty($this->links[$link_name])) {
            return $this->links[$link_name];
        }

        return null;
    }

    /**
     * Joins the custom table to the current query (if possible)
     * @param SugarBean $bean
     * @param string $alias
     */
    public function joinCustomTable($bean, $alias = "") {
        if ($bean->hasCustomFields() && !$this->customJoined) {
            $table = $bean->getTableName();
            $table_cstm = $bean->get_custom_table_name();
            if (!empty($table_cstm)) {
                // TODO: CLEAN THIS UP
                if (!empty($alias)) {
                    $sql = "LEFT JOIN {$table_cstm} {$alias}_c ON {$alias}_c.id_c = {$alias}.id";
                } else {
                    $sql = "LEFT JOIN {$table_cstm} ON {$table_cstm}.id_c = {$table}.id";
                }
                // can do a join here because we haven't got to the joins yet in the compile sequence.
                $this->joinRaw($sql);
            }
        }
    }

    public function startData($segment)
    {
        $this->dataSegment = $segment;
    }

    public function endData()
    {
        $this->dataSegment = '';
    }

    public function addData($item)
    {
        if(is_array($item)) {
            if(isset($this->dataItems[$this->dataSegment])) {
                $this->dataItems[$this->dataSegment] = array_merge($this->dataItems[$this->dataSegment], $item);
            } else {
                $this->dataItems[$this->dataSegment] = $item;
            }
        } else {
            if(isset($this->dataItems[$this->dataSegment])) {
                $this->dataItems[$this->dataSegment][] = $item;
            } else {
                $this->dataItems[$this->dataSegment] = array($item);
            }
        }
    }

    public function getData($segment)
    {
        if(!isset($this->dataItems[$segment])) {
            return array();
        }
        return $this->dataItems[$segment];
    }

}
