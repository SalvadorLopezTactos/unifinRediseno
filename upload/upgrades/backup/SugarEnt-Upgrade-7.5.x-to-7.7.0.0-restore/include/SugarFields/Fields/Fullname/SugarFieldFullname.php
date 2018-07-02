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

class SugarFieldFullname extends SugarFieldBase
{
    public function apiFormatField(&$data, $bean, $args, $fieldName, $properties)
    {
        global $locale;
        $data[$fieldName] = $locale->formatName($bean);
    }

    function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
	{
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch($this->findTemplate('DetailView'));
    }

    public function getNormalizedDefs($vardef, $defs)
    {
         $vardef = parent::getNormalizedDefs($vardef, $defs);
         if(!empty($defs['name_format_map'])) {
             $vardef['fields'] = array_unique(array_values($defs['name_format_map']));
         }
         return $vardef;
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
        // TODO: figure out how we can parse arbitrary imports
        if(empty($focus->name_format_map)) {
            $fn = 'first_name';
            $ln = 'last_name';
        } else {
            $fn = $focus->name_format_map['f'];
            $ln = $focus->name_format_map['l'];
        }
        if ( property_exists($focus, $fn) && property_exists($focus, $ln) ) {
            $name_arr = preg_split('/\s+/',$value);
            if ( count($name_arr) == 1) {
                $focus->$ln = $value;
            }
            else {
                // figure out what comes first, the last name or first name
                if ( strpos($settings->default_locale_name_format,'l') > strpos($settings->default_locale_name_format,'f') ) {
                    $focus->$fn = array_shift($name_arr);
                    $focus->$ln = join(' ',$name_arr);
                }
                else {
                    $focus->$ln = array_shift($name_arr);
                    $focus->$fn = join(' ',$name_arr);
                }
            }
        }
    }
}
