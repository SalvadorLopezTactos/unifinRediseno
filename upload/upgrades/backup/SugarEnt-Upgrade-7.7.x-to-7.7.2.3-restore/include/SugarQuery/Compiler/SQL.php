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

require_once 'include/SugarQuery/SugarQuery.php';

class SugarQuery_Compiler_SQL
{
    /**
     * @var SugarBean
     */
    protected $from_bean;
    /**
     * @var SugarQuery
     */
    protected $sugar_query;
    /**
     * @var null|string
     */
    protected $from_alias = null;
    /**
     * @var string
     */
    protected $primary_table;
    /**
     * @var string
     */
    protected $primary_custom_table;

    /**
     * @var dbManager
     */
    protected $db;

    protected $jtcount = 0;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Build out the Query in SQL
     *
     * @param SugarQuery $sugar_query
     *
     * @return string
     */
    public function compile(SugarQuery $sugar_query)
    {
        $this->sugar_query = $sugar_query;

        if (!empty($this->sugar_query->union) &&
            $this->sugar_query->union instanceof SugarQuery_Builder_Union
        ) {
            return $this->compileUnionQuery();
        }

        if (empty($this->sugar_query->select)) {
            $this->sugar_query->select = new SugarQuery_Builder_Select($this->sugar_query, array('*'));
        }
        return $this->compileSelectQuery();
    }

    /**
     * Convert a Union SugarQuery Object into a string.
     *
     * @return string
     */
    protected function compileUnionQuery()
    {
        $sql = '';
        $unions = $this->sugar_query->union->getQueries();

        if (empty($unions)) {
            throw new SugarQueryException("Incorrect union query.");
        }

        $this->sugar_query->startData('union');
        foreach ($unions as $union) {
            if (isset($union['query'])) {
                $sql .= (!empty($sql)) ? ' UNION ' . ($union['all'] ? 'ALL ' : '') : '';
                $sql .= '(' . $union['query']->compileSql($this->sugar_query) . ')';
            }
        }
        $this->sugar_query->endData();

        if (!empty($this->sugar_query->order_by)) {
            $sql .= " ORDER BY " . $this->compileOrderBy($this->sugar_query->order_by, false) . " ";
        }

        if (!empty($this->sugar_query->limit)) {
            $sql = $this->db->limitQuery(
                $sql,
                $this->sugar_query->offset ? $this->sugar_query->offset : 0,
                $this->sugar_query->limit,
                false,
                '',
                false
            );
        }
        $this->sugar_query->data = $this->sugar_query->getData('union');

        return $sql;
    }

    /**
     * Convert a Select SugarQuery Object into a string
     *
     * @return string
     */
    protected function compileSelectQuery()
    {
        $select_part = '*';
        $from_part = '';
        $where_part = '';
        $join_part = '';
        $distinct = '';
        $group_by_part = '';
        $order_by_part = '';
        $having_part = '';

        // if there aren't any selected fields, add them all
        if (empty($this->sugar_query->select->select) && $this->sugar_query->select->getCountQuery() === false) {
            $this->sugar_query->select('*');
        }

        if (!empty($this->sugar_query->from)) {
            $from_part = trim($this->compileFrom($this->sugar_query->from));
        }

        if (!empty($this->sugar_query->select)) {
            $select_part = trim(
                $this->compileSelect($this->sugar_query->select)
            );
        }
        if (!empty($this->sugar_query->where)) {
            $this->sugar_query->startData('where');
            $where_part = trim($this->compileWhere($this->sugar_query->where));
            $this->sugar_query->endData();
        }

        if ($this->sugar_query->distinct) {
            $distinct = 'DISTINCT';
        }

        if (!empty($this->sugar_query->group_by)) {
            $group_by_part = $this->compileGroupBy($this->sugar_query->group_by);
        }

        if (!empty($this->sugar_query->having)) {
            $this->sugar_query->startData('having');
            $having_part = $this->compileHaving($this->sugar_query->having);
            $this->sugar_query->endData();
        }

        if (!empty($this->sugar_query->order_by)) {
            $order_by_part = $this->compileOrderBy($this->sugar_query->order_by);
        }

        if (!empty($this->sugar_query->join)) {
            $this->sugar_query->startData('join');
            $join_part = trim($this->compileJoin($this->sugar_query->join));
            $this->sugar_query->endData();
        }

        $data = array();
        $sql = "SELECT {$distinct} {$select_part} FROM {$from_part}";
        if (!empty($join_part)) {
            $sql .= " {$join_part} ";
            $data = array_merge($data, $this->sugar_query->getData('join'));
        }
        if (!empty($where_part)) {
            $sql .= " WHERE {$where_part} ";
            $data = array_merge($data, $this->sugar_query->getData('where'));
        }
        if (!empty($group_by_part)) {
            $sql .= " GROUP BY {$group_by_part} ";
        }
        if (!empty($having_part)) {
            $sql .= " HAVING {$having_part} ";
            $data = array_merge($data, $this->sugar_query->getData('having'));
        }
        if (!empty($order_by_part)) {
            $sql .= " ORDER BY {$order_by_part} ";
        }
        if (!empty($this->sugar_query->limit) && $this->sugar_query->select->getCountQuery() === false) {
            $sql = $this->db->limitQuery($sql, $this->sugar_query->offset, $this->sugar_query->limit, false, '', false);
        }
        $this->sugar_query->data = $data;

        return trim($sql);
    }

    /**
     * Create a GroupBy statement
     *
     * @param array $groupBy
     *
     * @return string
     */
    protected function compileGroupBy($groupBy)
    {
        $return = array();
        foreach ($groupBy AS $groupBy) {
            if ($groupBy->column->isNonDb()) {
                continue;
            }
            $return[] = $this->compileField($groupBy->column);
        }

        return implode(', ', $return);
    }

    /**
     * Create a Having statement
     *
     * @param string $having
     *
     * @return string
     */
    protected function compileHaving($having)
    {
        return $this->compileWhere($having);
    }

    /**
     * Create an Order By Statement
     *
     * @param SugarQuery_Builder_Orderby[] $orderBy
     * @param boolean $orderStability Apply order stability if not supported by db
     * @return string
     */
    protected function compileOrderBy($orderBy, $orderStability = true)
    {
        $return = array();

        // Apply order stability if not implied by the db backend
        if ($orderStability && !$this->db->supports('order_stability')) {
            $orderBy = $this->applyOrderByStability($orderBy);
        }

        foreach ($orderBy as $order) {
            if ($order->column->isNonDb()) {
                continue;
            }
            $field = trim($this->compileField($order->column));
            if (empty($field)) {
                continue;
            }

            $direction = trim($order->direction);

            if (!isset($return[$field])) {
                $return[$field] = "{$field} {$direction}";
            }
        }

        return implode(',', $return);
    }

    /**
     * Add additional column to `ORDER BY` clause for order stability, defaults
     * to using the `id` column.
     *
     * @param SugarQuery_Builder_Orderby[] $orderBy List of already existing `ORDER BY` defs
     * @param string $column Unique column to add, defaults to `id`
     * @return SugarQuery_Builder_Orderby[]
     */
    protected function applyOrderByStability(array $orderBy, $column = 'id')
    {
        $uniqueCol = new SugarQuery_Builder_Orderby($this->sugar_query);
        $uniqueCol->addField($column);
        $orderBy[] = $uniqueCol;
        return $orderBy;
    }

    /**
     * Create a select statement
     *
     * @param SugarQuery_Builder_Select $selectObj
     *
     * @return string
     */
    protected function compileSelect(SugarQuery_Builder_Select $selectObj)
    {
        $return = array();
        $addedFields = array();

        if ($selectObj->getCountQuery() === true) {
            $return['count(0) AS record_count'] = 'count(0) AS record_count';
        }

        foreach ($selectObj->select as $field) {
            if ($field->isNonDb()) {
                continue;
            }
            $compiledField = $this->compileField($field);
            $return[$compiledField] = $compiledField;

            if ($selectObj->getCountQuery() === true) {
                $this->sugar_query->groupBy("{$field->table}.{$field->field}");
            }
        }

        return implode(", ", $return);

    }

    /**
     * @param $field
     * @param bool $compare Points that field is compared with another field.
     * @return string
     */
    protected function compileField($field, $compare = false)
    {
        if ($compare) {
            $field->field = $field->getFieldCompare();
        }

        if ($field instanceof SugarQuery_Builder_Field_Raw) {
            if (!empty($field->alias)) {
                return "{$field->field} {$field->alias}";
            } else {
                return $field->field;
            }
        }

        if ($field->isNonDb()) {
            return '';
        }
        $sql = "{$field->table}.{$field->field}";
        $sql .= !empty($field->alias) ? " {$field->alias}" : "";
        return  $sql;
    }

    /**
     * Create a from statement
     *
     * @param SugarBean|array $bean
     * @return string
     */
    protected function compileFrom($bean)
    {
        $alias = "";
        $return = array();
        if (is_array($bean)) {
            list($bean, $alias) = $bean;
            $this->from_alias = $alias;
        }
        $this->from_bean = $bean;
        $table = $bean->getTableName();
        $table_cstm = '';
        $from_clause = "{$table}";

        if (!empty($alias)) {
            $from_clause .= " {$alias}";
        }

        //SugarQuery will determine if we actually need to add the table or not.
        $this->sugar_query->joinCustomTable($bean, $alias);

        if (!empty($this->from_alias)) {
            $this->primary_table = $this->from_alias;
            $this->primary_custom_table = $this->from_alias . '_c';
        } else {
            $this->primary_table = $this->from_bean->getTableName();
            $this->primary_custom_table = $this->from_bean->get_custom_table_name();
        }

        $return = $from_clause;

        return $return;
    }
    /**
     * Create a where statement
     *
     * @param array $where SugarQuery_Builder_Where
     *
     * @return string
     */
    protected function compileWhere(array $where)
    {
        $sql = array();
        foreach ($where as $whereObj) {
            if ($whereObj instanceof SugarQuery_Builder_Andwhere) {
                $operator = "AND";
            } else {
                $operator = "OR";
            }
            $sql[] = $this->buildWhereSql($operator, $whereObj);
        }

        $compiledSql = '';
        foreach ($sql as $conditionals) {
            foreach($conditionals as $operator => $statement) {
                if(count($statement) > 1) {
                    $compiledSql .= implode(" {$operator} ", $statement);
                } else {
                    $compiledSql .= reset($statement);
                }
            }
        }

        return $compiledSql;
    }

    /**
     * Build the Where Statement using arrays, to keep it nice and clean
     *
     * @param string $operator [AND/OR]
     * @param object SugarQuery_Builder_AndWhere/SugarQuery_Builder_OrWhere
     *
     * @return array
     */
    protected function buildWhereSql($operator, $whereObj)
    {
        $sql[$operator] = array();
        if (!empty($whereObj->raw)) {
            $compiledField = $this->compileField($whereObj->raw);
            if (!empty($compiledField)) {
                $sql[$operator][] = $compiledField;
            }
        }
        foreach ($whereObj->conditions as $condition) {
            $compiledField = false;
            if ($condition instanceof SugarQuery_Builder_Where) {
                $compiledField = $this->compileWhere(array($condition));
                if (!empty($compiledField)) {
                    $sql[$operator][] = "({$compiledField})";
                }
                continue;
            } elseif ($condition instanceof SugarQuery_Builder_Condition) {
                $compiledField = $this->compileCondition($condition);
                if (!empty($compiledField)) {
                    $sql[$operator][] = $compiledField;
                }
            } else {
                if (is_array($condition) && !empty($condition)) {
                    $sql[$operator][] = join(' ', $condition);
                }
            }
        }
        return $sql;
    }


    /**
     * Prepares value for insertion into SQL
     * @param string $value
     * @param SugarQuery_Builder_Condition $condition
     * @return string
     */
    protected function prepareValue($value, SugarQuery_Builder_Condition $condition)
    {
        if($this->sugar_query->usePreparedStatements && !empty($condition->field->def)
            && !($value instanceof SugarQuery_Builder_Literal)
        ) {
            $type = $this->db->getFieldType($condition->field->def);
            $this->sugar_query->addData($condition->field->quoteValue($value, $condition->operator, true));
            return "?$type";
        } else {
            return $condition->field->quoteValue($value, $condition->operator);
        }
    }

    /**
     * Compile a condition into SQL
     *
     * @param SugarQuery_Builder_Condition $condition
     * @param string $sql Current SQL string
     * @param string $operator Preceding logical operator - AND/OR
     *
     * @return string
     */
    public function compileCondition(SugarQuery_Builder_Condition $condition)
    {
        global $current_user;

        $sql = '';
        $field = $this->compileField($condition->field);

        if (empty($field)) {
            return false;
        }
        if (!empty($condition->field->def['type']) && $this->db->isTextType($condition->field->def['type'])) {
            $castedField = $this->db->convert($field, 'text2char');
        } else {
            $castedField = $field;
        }

        if ($condition->isNull) {
            $sql .= "{$field} IS NULL";
        } elseif ($condition->notNull) {
            $sql .= "{$field} IS NOT NULL";
        } else {
            switch ($condition->operator) {
                case 'IN':
                    $valArray = array();
                    $sql .= $castedField . ' IN ';
                    if ($condition->values instanceof SugarQuery) {
                        $sql .= "(" . $condition->values->compileSql($this->sugar_query) . ")";
                    } else {
                        if (empty($condition->values)) {
                            $sql .= "(NULL)";
                        } else {
                            foreach ($condition->values as $val) {
                                $valArray[] = $this->prepareValue($val, $condition);
                            }
                            $sql .= "(" . implode(',', $valArray) . ")";
                        }
                    }
                    break;
                case 'NOT IN':
                    $valArray = array();
                    $sql .= "({$field} IS NULL OR {$castedField} NOT IN ";
                    if ($condition->values instanceof SugarQuery) {
                        $sql .= '(' . $condition->values->compileSql($this->sugar_query) . ')';
                    } else {
                        if (empty($condition->values)) {
                            $sql .= "(NULL)";
                        } else {
                            foreach ($condition->values as $val) {
                                $valArray[] = $this->prepareValue($val, $condition);
                            }
                            $sql .= '(' . implode(',', $valArray) . ')';
                        }
                    }
                    $sql .= ')';
                    break;
                case 'BETWEEN':
                    $value['min'] = $this->prepareValue($condition->values['min'], $condition);
                    $value['max'] = $this->prepareValue($condition->values['max'], $condition);
                    $sql .= "{$field} BETWEEN {$value['min']} AND {$value['max']}";
                    break;
                case 'STARTS':
                case 'CONTAINS':
                case 'DOES NOT CONTAIN':
                case 'ENDS':
                    //Handling for not contains
                    $comparitor = 'LIKE';
                    $chainWith = 'OR';
                    if ($condition->operator === 'DOES NOT CONTAIN') {
                        $comparitor = 'NOT LIKE';
                        $chainWith = 'AND';
                    }

                    if ($this->db->supports('case_insensitive')) {
                        $field = "UPPER($field)";
                    }

                    if (is_array($condition->values)) {
                        $conditions = array();
                        foreach ($condition->values as $value) {
                            if ($this->db->supports('case_insensitive')) {
                                $value = strtoupper($value);
                            }
                            $val = $this->prepareValue($value, $condition);
                            $conditions[] = "{$field} {$comparitor} {$val}";
                        }
                        $sql .= '(' . implode(' ' . $chainWith . ' ', $conditions);
                        if ($condition->operator === 'DOES NOT CONTAIN') {
                            $sql .= " OR {$field} IS NULL";
                        }
                        $sql .= ') ';
                    } else {
                        $value = $this->db->supports('case_insensitive') ? strtoupper($condition->values) : $condition->values;
                        $value = $this->prepareValue($value, $condition);
                        $sql .= "{$field} {$comparitor} {$value}";
                    }
                    break;
                case 'EQUALFIELD':
                    $sql .= "{$castedField} = " . $this->compileField($this->getFieldCondition($condition->values));
                    break;
                case 'NOTEQUALFIELD':
                    $sql .= "{$castedField} != " . $this->compileField($this->getFieldCondition($condition->values));
                    break;
                case '=':
                case '!=':
                case '>':
                case '<':
                case '>=':
                case '<=':
                default:
                    $sql .= $castedField . ' ' . $condition->operator . ' ';
                    if ($condition->values instanceof SugarQuery) {
                        $sql .= "(" . $condition->values->compileSql($this->sugar_query) . ")";
                    } elseif ($condition->field->isFieldCompare()) {
                        $sql .= $this->compileField($condition->field, true);
                    } else {
                        $sql .= $this->prepareValue($condition->values, $condition);
                    }
                    break;
            }
        }

        if (!$condition->isAclIgnored()) {
            $isFieldAccessible = ACLField::generateAclCondition($condition, $current_user);
            if ($isFieldAccessible) {
                $sql = '(' . $sql . ' AND (' . $this->compileWhere(array($isFieldAccessible)) . '))';
            }
        }

        return $sql;
    }

    /**
     * Creates join syntax for the query
     *
     * @param array $join
     *
     * @return string
     */
    protected function compileJoin(array $join)
    {
        // get the related beans for everything
        $return = array();

        // check if any elements are relationships
        foreach ($join as $name => $j) {
            // Take raw as is and move on
            if (!empty($j->raw)) {
                $return[] = $j->raw;
                $built[$name] = true;
                continue;
            }

            // If this join has already been compiled, skip it. This happens in
            // cases of join table aliases that need to be declared before they
            // are referenced in a query. See BR-1057
            if (isset($built[$name])) {
                continue;
            }

            // If there is a relationship table alias, we need to build the join
            // part before the join alias is referenced or there will be sadness
            // in SQLland
            $buildAlias = isset($j->relationshipTableAlias) && isset($join[$j->relationshipTableAlias]);
            if ($buildAlias && !isset($built[$j->relationshipTableAlias])) {
                $return[] = $this->getJoinSQLString($join[$j->relationshipTableAlias]);
                $built[$j->relationshipTableAlias] = true;
            }

            $return[] = $this->getJoinSQLString($j);
            $built[$name] = true;
        }

        return implode("\n ", $return);
    }

    /**
     * Gets a join SQL string
     *
     * @param  SugarQuery_Builder_Join $join A join object
     * @return string A join SQL part
     */
    protected function getJoinSQLString(SugarQuery_Builder_Join $join)
    {
        // Raw sql can just be returned
        if (!empty($join->raw)) {
            return $join->raw;
        }

        // Build out the return SQL now
        if (isset($join->options['joinType'])) {
            $sql = strtoupper($join->options['joinType']) . ' JOIN';
        } else {
            $sql = 'JOIN';
        }

        $table = $join->table;

        if ($table instanceof SugarQuery) {
            $table = "(" . $table->compileSql($this->sugar_query) . ")";
        }
        // Quote the table name that is being joined
        $sql .= ' ' . $table;

        if (isset($join->options['alias']) && strtolower(
                $join->options['alias']
            ) != strtolower($table)
        ) {
            $sql .= ' ' . $join->options['alias'];
        }

        $sql .= ' ON ';
        $sql .= '(' . $this->compileWhere($join->on) . ')';

        return $sql;
    }

    /**
     * Method allows us to mock creation of SugarQuery_Builder_Field_Condition
     *
     * @param string $field
     * @return SugarQuery_Builder_Field_Condition
     */
    protected function getFieldCondition($field)
    {
        return new SugarQuery_Builder_Field_Condition($field, $this->sugar_query);
    }
}
