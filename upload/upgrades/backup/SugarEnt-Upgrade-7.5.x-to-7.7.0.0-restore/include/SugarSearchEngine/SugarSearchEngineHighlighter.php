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


/**
 * Highlighter
 * @api
 */
class SugarSearchEngineHighlighter
{
    protected $_module;

    public static $preTag = '<strong>';
    public static $postTag = '</strong>';
    public static $fragmentSize = 20;
    public static $fragmentNumber = 2;

    public function __construct()
    {
    }

    /**
     * Setter for module name.
     *
     * @param $module
     */
    public function setModule($module)
    {
        $this->_module = $module;
    }

    public function processHighlightText(array $resultArray)
    {
        $ret = array();
        foreach ($resultArray as $field => $fragments) {
            $ret[$field] = array('text' => '', 'module' => $this->_module, 'label' => $this->getLabel($field));
            $first = true;
            foreach ($fragments as $fragment) {
                if (!$first) {
                    $ret[$field]['text'] .= '...' . $fragment;
                } else {
                    $ret[$field]['text'] = $fragment;
                }
                $first = false;
            }
        }

        return $ret;
    }

    public function getLabel($field)
    {
        if (empty($this->_module)) {
            return $field;
        } else {
            $tmpBean = BeanFactory::getBean($this->_module);
            $field_defs = $tmpBean->field_defs;
            $field_def = isset($field_defs[$field]) ? $field_defs[$field] : false;
            if ($field_def === false || (!isset($field_def['vname']) && !isset($field_def['label']))) {
                return $field;
            }

            return (isset($field_def['label'])) ? $field_def['label'] : $field_def['vname'];
        }
    }
}
