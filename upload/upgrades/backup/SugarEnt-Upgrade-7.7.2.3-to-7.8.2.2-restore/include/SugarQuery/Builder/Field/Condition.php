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


/**
 * SugarQuery_Builder_Field_Condition
 * @api
 */

class SugarQuery_Builder_Field_Condition extends SugarQuery_Builder_Field
{
    protected $rNameExists = false;
    protected $fieldCompare;

    public function __construct($field, SugarQuery $query)
    {
        parent::__construct($field, $query);
    }


    public function expandField()
    {
        if(!isset($this->def['source']) || $this->def['source'] == 'db') {
            return;
        }
        // Exists only checks
        if (!empty($this->def['rname_exists'])) {
            $this->markNonDb();
            $this->rNameExists = true;
            return;
        }
        if(!empty($this->def['rname']) && !empty($this->def['link'])) {
            $this->table = $this->query->getJoinAlias($this->def['link']);
            $this->field = $this->def['rname'];
        } elseif (!empty($this->def['rname']) && !empty($this->def['table'])) {
            $this->table = $this->query->getJoinAlias($this->def['table'], false);
            $this->field = $this->def['rname'];
        }  elseif(!empty($this->def['rname_link']) && !empty($this->def['link'])) {
            $this->field = $this->def['rname_link'];
        }

        if (!empty($this->def['module'])) {
            $this->moduleName = $this->def['module'];
            $bean = BeanFactory::newBean($this->moduleName);
            if (isset($bean->field_defs[$this->field])) {
                $this->def = $bean->field_defs[$this->field];
            }
        }
        $this->checkCustomField();
    }

    public function verifyCondition($value, $query)
    {
        if ($this->rNameExists) {
            if (isTruthy($value)) {
                $query->whereRaw("{$this->jta}.{$this->def['rname']} IS NOT NULL");
            } else {
                $query->whereRaw("{$this->jta}.{$this->def['rname']} IS NULL");
            }
        }
    }


    public function shouldMarkNonDb()
    {
        // if its a linking table let it slide
        if(!empty($this->query->join[$this->table]->options['linkingTable'])) {
            $this->nonDb = 0;
            return;
        }
        if (empty($this->moduleName)) {
            $this->nonDb = 1;
            return;
        }
        if (isset($this->def['source']) && $this->def['source'] == 'non-db' && !isset($this->def['dbType'])) {
            $this->nonDb = 1;
            return;
        } elseif (empty($this->def)) {
            $this->nonDb = 1;
            return;
        }

        $this->nonDb = 0;
        return;
    }

    /**
     * @param $field
     * @param $value
     * @param bool $bean
     * @param bool $operator
     *
     * @return string
     */
    public function quoteValue($value, $operator = false, $forPrepared = false)
    {
        global $db;
        if ($value instanceof SugarQuery_Builder_Literal) {
            return (string)$value;
        }

        if ($this->field == 'deleted' && empty($this->def)) {
            return (int) isTruthy($value);
        }

        if (!empty($this->def)) {
            $dbtype = $db->getFieldType($this->def);

            if (is_null($value) || $value === false || $value === '') {
                return $db->emptyValue($dbtype, $forPrepared);
            }

            switch ($dbtype) {
                case 'date':
                case 'datetime':
                case 'time':
                    if (strtoupper($value) == 'NOW()') {
                        return $forPrepared ? TimeDate::getInstance()->nowDb() : $db->now();
                    }
                    break;
                case 'bool':
                    return (int)isTruthy($value);
            }

            if ($db->getTypeClass($dbtype) == 'string') {
                if ($operator == 'STARTS') {
                    $value = $value . '%';
                }
                if ($operator == 'CONTAINS' || $operator == 'DOES NOT CONTAIN') {
                    $value = '%' . $value . '%';
                }
                if ($operator == 'ENDS') {
                    $value = '%' . $value;
                }
            }
            return $forPrepared ? $value : $db->quoteType($dbtype, $value);
        }
        return $forPrepared ? $value : $db->quoted($value);
    }

    /**
     * Set compare field.
     * @param $value
     */
    public function setFieldCompare($value)
    {
        $this->fieldCompare = $value;
    }

    /**
     * Get compare field.
     * @return mixed|bool
     */
    public function getFieldCompare()
    {
        return $this->fieldCompare;
    }

    /**
     * Check if field is comparable.
     * @return bool
     */
    public function isFieldCompare()
    {
        return (bool)$this->fieldCompare;
    }
}
