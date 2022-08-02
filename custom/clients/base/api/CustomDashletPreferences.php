<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 6/2/2017
 * Time: 9:36 PM
 */

 if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class CustomDashletPreferences extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_CustomDashletHeight' => array(
                'reqType' => 'POST',
                'path' => array('CustomSetDashletHeight'),
                'pathVars' => array(''),
                'method' => 'setDashletHeight',
                'shortHelp' => 'set Dashlet Height',
            ),

            'POST_CustomGetDashletHeight' => array(
                'reqType' => 'POST',
                'path' => array('CustomGetDashletHeight'),
                'pathVars' => array(''),
                'method' => 'getDashletHeight',
                'shortHelp' => 'get Dashlet Height',
            ),
        );

    }

    public function setDashletHeight($api, $args){
        global $current_user;
        $custom_height = $args['data']['custom_height'];
        $current_user->setPreference('height', $custom_height,'','CstmDashletPreferences');
    }

    public function getDashletHeight($api, $args){
        global $current_user;
        $custom_height = $current_user->getPreference('height','CstmDashletPreferences');
        return $custom_height;
    }

}