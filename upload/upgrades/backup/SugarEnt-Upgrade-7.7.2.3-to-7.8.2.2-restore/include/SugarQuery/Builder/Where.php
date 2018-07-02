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

abstract class SugarQuery_Builder_Where
{
    /**
     * @var null|string
     */
    public $raw = null;

    /**
     * @var array
     */
    public $conditions = array();

    /**
     * @var SugarQuery
     */
    public $query = false;

    public function __construct(SugarQuery $query)
    {
        $this->query = $query;
    }

    /**
     * @param $field
     * @param $value
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function equals($field, $value, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('=')->setField($field)->setValues($value);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * Creates a condition for two fields to check equality
     *
     * @param string $field1
     * @param string $field2
     * @param bool|object $bean
     *
     * @return object
     */
    public function equalsField($field1, $field2, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('EQUALFIELD')->setField($field1)->setValues($field2);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * Creates a condition to check not equals
     *
     * @param string $field
     * @param string $value
     * @param bool|object $bean
     *
     * @return object
     */
    public function notEquals($field, $value, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('!=')->setField($field)->setValues($value);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * Creates a condition for two fields to check non-equality
     *
     * @param string $field1
     * @param string $field2
     * @param bool|object $bean
     *
     * @return object
     */
    public function notEqualsField($field1, $field2, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('NOTEQUALFIELD')->setField($field1)->setValues($field2);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * Sets an empty where query portion onto the where object. Delegates this
     * to the DBManagers since Oracle has to handle empty differently than all
     * other DBs.
     * @param mixed $field The field
     * @param SugarBean $bean SugarBean
     * @return SugarQuery_Builder_Where
     */
    public function isEmpty($field, $bean = false)
    {
        $this->query->getDBManager()->setEmptyWhere($this, $field, $bean);
        return $this;
    }

    /**
     * Sets a not empty where query portion onto the where object. Delegates this
     * to the DBManagers since Oracle has to handle empty differently than all
     * other DBs.
     * @param mixed $field The field
     * @param SugarBean $bean SugarBean
     * @return SugarQuery_Builder_Where
     */
    public function isNotEmpty($field, $bean = false)
    {
        $this->query->getDBManager()->setNotEmptyWhere($this, $field, $bean);
        return $this;
    }

    /**
     * @param $field
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function isNull($field, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setField($field)->isNull();
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * @param $field
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function notNull($field, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setField($field)->notNull();
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function contains($field, $value, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('CONTAINS')->setField($field)->setValues($value);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function notContains($field, $value, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('DOES NOT CONTAIN')->setField($field)->setValues($value);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function starts($field, $value, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('STARTS')->setField($field)->setValues($value);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * Creates a condition like field LIKE '%value';
     *
     * @param string $field
     * @param string $value
     * @param bool|object $bean
     *
     * @return object
     */
    public function ends($field, $value, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('ENDS')->setField($field)->setValues($value);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * @param $field
     * @param array|SugarQuery $vals
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function in($field, $vals, $bean = false)
    {
        $isNull = false;
        if (is_array($vals)) {
            $isNull = in_array('', $vals);
        }

        if ($isNull) {
            $vals = array_filter($vals, 'strlen');
            if (count($vals) > 0) {
                $where = $this->queryOr();
                $where->isNull($field, $bean);
                $where->in($field, $vals, $bean = false);
            } else {
                $this->isNull($field, $bean);
            }
        } else {
            $condition = new SugarQuery_Builder_Condition($this->query);
            $condition->setOperator('IN')->setField($field)->setValues($vals);
            if ($bean instanceof SugarBean) {
                $condition->setBean($bean);
            }
            $this->conditions[] = $condition;
        }
        return $this;
    }

    /**
     * @param $field
     * @param array|SugarQuery $vals
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function notIn($field, $vals, $bean = false)
    {
        $isNull = in_array('', $vals);
        if ($isNull) {
            $vals = array_filter($vals, 'strlen');
            if (count($vals) > 0) {
                $where = $this->queryAnd();
                $where->notNull($field, $bean);
                $where->notIn($field, $vals, $bean = false);
            } else {
                $this->notNull($field, $bean);
            }
        } else {
            $condition = new SugarQuery_Builder_Condition($this->query);
            $condition->setOperator('NOT IN')->setField($field)->setValues($vals);
            if ($bean instanceof SugarBean) {
                $condition->setBean($bean);
            }
            $this->conditions[] = $condition;
        }
        return $this;
    }

    /**
     * @param $field
     * @param $min
     * @param $max
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function between($field, $min, $max, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('BETWEEN')->setField($field)->setValues(array('min' => $min, 'max' => $max));
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function lt($field, $value, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('<')->setField($field)->setValues($value);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function lte($field, $value, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('<=')->setField($field)->setValues($value);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function gt($field, $value, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('>')->setField($field)->setValues($value);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @param bool $bean
     *
     * @return SugarQuery_Builder_Where
     */
    public function gte($field, $value, $bean = false)
    {
        $condition = new SugarQuery_Builder_Condition($this->query);
        $condition->setOperator('>=')->setField($field)->setValues($value);
        if ($bean instanceof SugarBean) {
            $condition->setBean($bean);
        }
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * Given a date range expression it builds greater and lower than conditions
     *
     * @param string $field
     * @param string $value
     * @param $bean
     *
     * @return SugarQuery_Builder_Andwhere
     */
    public function dateRange($field, $value, $bean = false)
    {
        //Gets us an array with "from/to" dates, each set to very beginning or end of day as appropriate
        $timeDate = $this->timeDateInstance();
        $dates = $timeDate->parseDateRange($value, null, true);
        if (is_array($dates)) {
            $where = $this->queryAnd();
            $type = '';
            if ($bean && $bean instanceof SugarBean) {
                $type = $bean->getFieldDefinition($field);
                $type = !empty($type['type']) ? $type['type'] : '';
            }
            if (!$type) {
                $where->lte($field, $timeDate->asDb($dates[1]), $bean);
                $where->gte($field, $timeDate->asDb($dates[0]), $bean);
            } else {
                $where->lte($field, $timeDate->asDbType($dates[1], $type), $bean);
                $where->gte($field, $timeDate->asDbType($dates[0], $type), $bean);
            }
        }
        return $this;
    }

    /**
     * We need to mock TimeDate object for tests
     *
     * @return TimeDate
     */
    protected function timeDateInstance()
    {
        return TimeDate::getInstance();
    }

    /**
     * Between filter for Date fields. We can't use $between because we need to convert the right bound date
     *
     * @param string $field
     * @param array $value
     * @param $bean
     *
     * @return SugarQuery_Builder_Where
     * @throws SugarApiExceptionInvalidParameter If invalid dates
     */
    public function dateBetween($field, $value, $bean = false)
    {
        //Skip filter if a value is empty
        if (empty($value[0]) || empty($value[1])) {
            return $this;
        }
        //The empty value can be a string `null`
        if ($value[0] === 'null' || $value[1] === 'null') {
            return $this;
        }
        $leftDate = date_parse($value[0]);
        $rightDate = date_parse($value[1]);
        if (!empty($leftDate['errors']) || !empty($rightDate['errors'])) {
            throw new SugarQueryException('$dateBetween requires two valid dates');
        }
        //The right date must cover the full day
        $rightDate = date(
            "Y-m-d H:i:s",
            mktime(23, 59, 59, $rightDate['month'], $rightDate['day'], $rightDate['year'])
        );
        $leftDate = date(
            "Y-m-d H:i:s",
            mktime(0, 0, 0, $leftDate['month'], $leftDate['day'], $leftDate['year'])
        );
        $this->gte($field, $leftDate);
        $this->lte($field, $rightDate);
        return $this;
    }

    /**
     * @param $sql
     */
    public function addRaw($sql)
    {
        $this->raw = new SugarQuery_Builder_Field_Raw($sql, $this->query);
    }

    /**
     * @param $condition
     */
    public function add($condition)
    {
        $this->conditions[] = $condition;
    }

    /**
     * @return SugarQuery_Builder_Andwhere
     */
    public function queryAnd()
    {
        $where = new SugarQuery_Builder_Andwhere($this->query);
        $this->conditions[] = $where;
        return $where;
    }

    /**
     * @return SugarQuery_Builder_Orwhere
     */
    public function queryOr()
    {
        $where = new SugarQuery_Builder_Orwhere($this->query);
        $this->conditions[] = $where;
        return $where;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

}
