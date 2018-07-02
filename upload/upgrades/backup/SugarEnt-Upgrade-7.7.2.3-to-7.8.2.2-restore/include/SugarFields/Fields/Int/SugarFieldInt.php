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

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');
require_once('modules/Currencies/Currency.php');

class SugarFieldInt extends SugarFieldBase
{
    public function formatField($rawField, $vardef){
        if ( !empty($vardef['disable_num_format']) ) {
            return $rawField;
        }
        if ( $rawField === '' || $rawField === NULL ) {
            return '';
        }

        return format_number($rawField,0,0);
    }

    /**
     * {@inheritDoc}
     */
    public function apiFormatField(
        array &$data,
        SugarBean $bean,
        array $args,
        $fieldName,
        $properties,
        array $fieldList = null,
        ServiceBase $service = null
    ) {
        $this->ensureApiFormatFieldArguments($fieldList, $service);

        $data[$fieldName] = isset($bean->$fieldName) && is_numeric($bean->$fieldName)
                            ? (int)$bean->$fieldName : null;
    }

    public function unformatField($formattedField, $vardef){
        if ( $formattedField === '' || $formattedField === NULL ) {
            return '';
        }
        return (int)unformat_number($formattedField);
    }

    /**
     * getSearchWhereValue
     *
     * Checks and returns a sane value based on the field type that can be used when building the where clause in a
     * search form.
     *
     * @param $value Mixed value being searched on
     * @return Int the value for the where clause used in search
     */
    function getSearchWhereValue($value) {
        $newVal = parent::getSearchWhereValue($value);
        if (!is_numeric($newVal)){
            if(strpos($newVal, ',') > 0) {
                $multiVals = explode(',', $newVal);
                 $newVal = '';
                 foreach($multiVals as $key => $val) {
                     if (!empty($newVal))
                         $newVal .= ',';
                     if(!empty($val) && !(is_numeric($val)))
                         $newVal .= -1;
                     else
                         $newVal .= $val;
                 }
                 return $newVal;
            } else {
                return -1;
            }
        }
        return $newVal;
    }

    public function unformatSearchRequest(&$inputData, &$field) {
        $field['value'] = $this->unformatField($field['value'],$field);
    }

    function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
        // Use the basic field type for searches, no need to format/unformat everything... for now
    	$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        if($this->isRangeSearchView($vardef)) {
           $id = isset($displayParams['idName']) ? $displayParams['idName'] : $vardef['name'];
 		   $this->ss->assign('original_id', "{$id}");
           $this->ss->assign('id_range', "range_{$id}");
           $this->ss->assign('id_range_start', "start_range_{$id}");
           $this->ss->assign('id_range_end', "end_range_{$id}");
           $this->ss->assign('id_range_choice', "{$id}_range_choice");
           return $this->fetch('include/SugarFields/Fields/Int/RangeSearchForm.tpl');
        }

    	return $this->fetch($this->findTemplate('SearchForm'));
    }

    /**
     * @see SugarFieldBase::importSanitize()
     */
    public function importSanitize(
        $value,
        $vardef,
        $focus,
        ImportFieldSanitize $settings
        )
    {
        $value = str_replace($settings->num_grp_sep,"",$value);
        if (!is_numeric($value) || strstr($value,".")) {
            return false;
        }

        // check range
        $fieldRange = $this->getFieldRange($vardef);

        if (!empty($fieldRange) && ($value > $fieldRange['max_value'] || $value < $fieldRange['min_value'])) {
            return false;
        }

        return $value;
    }

    /**
     * Validates submitted data
     * @param SugarBean $bean
     * @param array $params
     * @param string $field
     * @param array $properties
     * @return boolean
     */
    public function apiValidate(SugarBean $bean, array $params, $field, $properties)
    {
        // check range
        $fieldRange = $this->getFieldRange($properties);

        if (!empty($fieldRange) && isset($params[$field])) {
            return $params[$field] <= $fieldRange['max_value'] && $params[$field] >= $fieldRange['min_value'];
        }

        return parent::apiValidate($bean, $params, $field, $properties);
    }

    /**
     * Gets field range based on both db and php limits.
     * @param array $vardef
     * @return array | boolean
     */
    protected function getFieldRange($vardef)
    {
        $fieldRange = $GLOBALS['db']->getFieldRange($vardef);

        if (!empty($fieldRange)) {
            return array('min_value' => max(-PHP_INT_MAX,  $fieldRange['min_value']), 'max_value' => min(PHP_INT_MAX, $fieldRange['max_value']));
        }

        return false;
    }
}
