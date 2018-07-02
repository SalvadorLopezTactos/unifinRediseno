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
 * SugarQuery_Builder_Field_Select
 * @api
 */

class SugarQuery_Builder_Field_Select extends SugarQuery_Builder_Field
{
    public function __construct($field, SugarQuery $query)
    {
        parent::__construct($field, $query);
    }

    public function expandField()
    {
        $this->checkCustomField();

        if (isset($this->def['type']) && $this->def['type'] == 'function') {
            if(!empty($this->def['function_params'])) {
                foreach($this->def['function_params'] as $param) {
                    $this->addToSelect("{$this->table}.{$param}");
                }
            }
            $this->markNonDb();
            return;
        }

        if (empty($this->alias) && !empty($this->def['name'])) {
            $this->alias = $this->def['name'];
        }

        if (!empty($this->alias)) {
            $newAlias = $GLOBALS['db']->getValidDBName($this->alias, false, 'alias');
            if (strtolower($this->alias) != $newAlias) {
                throw new SugarQueryException("Alias is more than the max allowed length for an alias");
            }
        }

        if ($this->field == '*') {
            // remove *
            $this->moduleName = empty($this->moduleName) ? $this->query->getFromBean()->module_name : $this->moduleName;
            $bean = BeanFactory::getBean($this->moduleName);
            foreach ($bean->field_defs AS $field => $def) {
                if (!isset($def['source']) || $def['source'] == 'db' || ($def['source'] == 'custom_fields' && $def['type'] != 'relate')) {
                    $this->addToSelect("{$this->table}.{$field}");
                }
            }
            $this->markNonDb();
            return;
        }

        if ($this->def['type'] == 'fullname') {
            $nameFields = Localization::getObject()->getNameFormatFields($this->moduleName);
            foreach ($nameFields as $partOfName) {
                $alias = !empty($this->alias) ? "{$this->alias}__{$partOfName}" : "{$this->def['name']}__{$partOfName}";
                $alias = DBManagerFactory::getInstance()->getValidDBName($alias, false, 'alias');
                $this->addToSelect(array(array("{$this->table}.{$partOfName}", $alias)));
            }
            $this->markNonDb();
            return;
        }

        if (!isset($this->def['source']) || $this->def['source'] == 'db') {
            return;
        }
        if (!empty($this->def['fields'])) {
            // this is a compound field
            foreach ($this->def['fields'] as $field) {
                $this->addToSelect("{$this->table}.{$field}");
            }
        }
        if ($this->def['type'] == 'parent') {
            $this->query->hasParent($this->field);
            $this->addToSelect('parent_type');
            $this->addToSelect('parent_id');
            $this->markNonDb();
        }
        if (isset($this->def['custom_type']) && $this->def['custom_type'] == 'teamset') {
            $this->addToSelect('team_set_id');
        }

        // Exists only checks
        if (!empty($this->def['rname_exists'])) {
            $this->markNonDb();
            $this->addToSelectRaw("case when {$this->jta}.{$this->def['rname']} IS NOT NULL then 1 else 0 end",$this->field);
            return;
        }

        if (!empty($this->def['rname']) && !empty($this->jta)) {
            $field = array("{$this->jta}.{$this->def['rname']}", $this->def['name']);
            $this->addToSelect(array($field));
            $this->markNonDb();
        }
        if (!empty($this->def['rname_link']) && !empty($this->jta)) {
            $this->field = $this->def['rname_link'];
            $this->alias = $this->def['name'];
        }
        if (!empty($this->def['source']) && $this->def['source'] == 'custom_fields') {
            $this->table = strstr($this->table, '_cstm') ? $this->table : $this->table . '_cstm';
        }
    }

    public function addToSelect($field)
    {
        if (!is_object($this->query->select)) {
            $this->query->select($field);
        } else {
            $this->query->select->field($field);
        }
        return true;
    }

    public function addToSelectRaw($field, $alias = '')
    {
        $this->query->select->fieldRaw($field, $alias);
    }
}
