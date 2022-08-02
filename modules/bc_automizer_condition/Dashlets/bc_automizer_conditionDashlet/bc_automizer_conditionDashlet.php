<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
/**
 * The file used to manage dashlet for Automizer conditions
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/bc_automizer_condition/bc_automizer_condition.php');

class bc_automizer_conditionDashlet extends DashletGeneric {

    public function __construct($id, $def = null) {
        global $current_user, $app_strings;
        require('modules/bc_automizer_condition/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if (empty($def['title']))
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'bc_automizer_condition');

        $this->searchFields = $dashletData['bc_automizer_conditionDashlet']['searchFields'];
        $this->columns = $dashletData['bc_automizer_conditionDashlet']['columns'];

        $this->seedBean = new bc_automizer_condition();
    }

}
