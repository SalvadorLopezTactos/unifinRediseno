<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
/**
 * The file used to handle layout of dashlet view for survey questions
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/bc_survey_questions/bc_survey_questions.php');

class bc_survey_questionsDashlet extends DashletGeneric {

    public function __construct($id, $def = null) {
        global $current_user, $app_strings;
        require('modules/bc_survey_questions/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if (empty($def['title']))
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'bc_survey_questions');

        $this->searchFields = $dashletData['bc_survey_questionsDashlet']['searchFields'];
        $this->columns = $dashletData['bc_survey_questionsDashlet']['columns'];

        $this->seedBean = new bc_survey_questions();
    }

}
