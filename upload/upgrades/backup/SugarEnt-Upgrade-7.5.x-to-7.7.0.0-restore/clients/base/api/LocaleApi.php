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

class LocaleApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                'reqType' => 'GET',
                'path' => array('locale'),
                'pathVars' => array(),
                'method' => 'localeOptions',
                'shortHelp' => 'Gets locale options so UI can populate the corresponding dropdowns',
                'longHelp' => 'include/api/help/locale_options_get_help.html',
                'ignoreMetaHash' => true,
                'keepSession' => true,
            ),
        );
    }

    public function localeOptions($api, $args)
    {
        global $locale, $sugar_config, $current_user;
        $data = array();
        $dformat = $locale->getPrecedentPreference($current_user->id?'datef':'default_date_format', $current_user);
        $tformat = $locale->getPrecedentPreference($current_user->id?'timef':'default_time_format', $current_user);
        $nformat = $locale->getPrecedentPreference('default_locale_name_format', $current_user);
        if (!array_key_exists($nformat, $sugar_config['name_formats'])) {
            $nformat = $sugar_config['default_locale_name_format'];
        }
        $data['timepref'] = $sugar_config['time_formats'];
        $data['datepref'] = $sugar_config['date_formats'];
        $data['default_locale_name_format'] = $locale->getUsableLocaleNameOptions($sugar_config['name_formats']);
        $data['timezone'] = $timezoneList = TimeDate::getTimezoneList();
        $data['_hash'] = $current_user->getUserMDHash();
        return $data;
    }

}

