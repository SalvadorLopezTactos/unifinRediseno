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

class SugarQuery_Builder_Select
{

    /**
     * Array of Select fields/statements
     * @var array
     */
    public $select = array();

    protected $query;

    protected $countQuery = false;

    protected $selectedFields = array();

    /**
     * Create Select Object
     * @param $columns
     */
    public function __construct(SugarQuery $query, $columns)
    {
        if (!is_array($columns)) {
            $columns = array_slice(func_get_args(), 1);
        }
        $this->query = $query;
        $this->field($columns);
    }

    /**
     * Select method
     * Add select elements
     * @param string $columns
     * @return object this
     */
    public function field($columns)
    {
        if (!is_array($columns)) {
            $columns = func_get_args();
        }
        foreach ($columns as $column) {
            $field = new SugarQuery_Builder_Field_Select($column, $this->query);
            $key = empty($field->alias) ? $field->field : $field->alias;
            if(!$field->isNonDb()) {
                $this->select[$key] = $field;
                if (!isset($this->selectedFields[$field->table])) {
                    $this->selectedFields[$field->table] = array();
                }
                $this->selectedFields[$field->table][] = $field->field;
            }
        }
        return $this;
    }

    /**
     * Adds a raw piece of SQL to the select
     * @param string $columns The raw SQL to execute
     * @param string $alias What to alias the sql as (optional)
     * @return object this
     */
    public function fieldRaw($columns, $alias = '')
    {
        $field = new SugarQuery_Builder_Field_Raw($columns, $this->query);
        if (!empty($alias)) {
            $field->alias = $alias;
        } else {
            $alias = md5($columns);
        }
        $this->select[$alias] = $field;
        return $this;
    }

    public function addField($column, $options = array())
    {
        if (!empty($options['alias'])) {
            $column = array(array($column, $options['alias']));
        }
        $this->field($column);
    }

    /**
     * Check if a field is already being selected
     * @param string $field
     * @param string $table
     * @return bool
     */
    public function checkField($field, $table)
    {
        if (!isset($this->selectedFields[$table])) {
            return false;
        }

        if (!in_array($field, $this->selectedFields[$table])) {
            return false;
        }

        return true;
    }

    /**
     * SelectReset method
     * clear out the objects select array
     * @return object this
     */
    public function selectReset()
    {
        $this->select = array();
        return $this;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    public function setCountQuery()
    {
        $this->countQuery = true;
        return $this;
    }

    public function getCountQuery()
    {
        return $this->countQuery;
    }
}
