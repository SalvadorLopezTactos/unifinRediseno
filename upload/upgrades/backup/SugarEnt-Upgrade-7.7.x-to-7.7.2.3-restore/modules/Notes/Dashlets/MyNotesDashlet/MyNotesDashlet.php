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

require_once('include/Dashlets/DashletGeneric.php');


class MyNotesDashlet extends DashletGeneric { 
    function MyNotesDashlet($id, $def = null) {
        global $current_user, $app_strings, $dashletData;
		require('modules/Notes/Dashlets/MyNotesDashlet/MyNotesDashlet.data.php');
        
        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_MY_NOTES_DASHLETNAME', 'Notes');
         
        $this->searchFields = $dashletData['MyNotesDashlet']['searchFields'];
        $this->columns = $dashletData['MyNotesDashlet']['columns'];
        
        $this->seedBean = BeanFactory::getBean('Notes');        
    }    
}
?>
