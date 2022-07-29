<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
/**
 * The file used to manage actions for Automizer actions
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/bc_automizer_actions/bc_automizer_actions.php');

class bc_automizer_actionsDashlet extends DashletGeneric {

    public function __construct($id, $def = null) {
        global $current_user, $app_strings;
        require('modules/bc_automizer_actions/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if (empty($def['title']))
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'bc_automizer_actions');

        $this->searchFields = $dashletData['bc_automizer_actionsDashlet']['searchFields'];
        $this->columns = $dashletData['bc_automizer_actionsDashlet']['columns'];

        $this->seedBean = new bc_automizer_actions();
    }

}
