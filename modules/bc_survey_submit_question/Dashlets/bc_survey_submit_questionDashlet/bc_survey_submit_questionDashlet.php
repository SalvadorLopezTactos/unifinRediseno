<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/*********************************************************************************
 * $Id$
 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/bc_survey_submit_question/bc_survey_submit_question.php');

class bc_survey_submit_questionDashlet extends DashletGeneric { 
    public function __construct($id, $def = null)
    {
		global $current_user, $app_strings;
		require('modules/bc_survey_submit_question/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'bc_survey_submit_question');

        $this->searchFields = $dashletData['bc_survey_submit_questionDashlet']['searchFields'];
        $this->columns = $dashletData['bc_survey_submit_questionDashlet']['columns'];

        $this->seedBean = new bc_survey_submit_question();        
    }
}