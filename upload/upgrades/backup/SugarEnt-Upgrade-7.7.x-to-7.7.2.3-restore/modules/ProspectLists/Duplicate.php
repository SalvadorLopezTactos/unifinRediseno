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
/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/




global $mod_strings;


$focus = BeanFactory::getBean('ProspectLists', $_POST['record']);
if (isset($_POST['isDuplicate']) && $_POST['isDuplicate'] == true) {

	$focus->id='';
	$focus->name=$mod_strings['LBL_COPY_PREFIX'].' '.$focus->name;
	
	$focus->save();
	$return_id=$focus->id; 
	//duplicate the linked items.
	$query  = "select * from prospect_lists_prospects where prospect_list_id = '".$_POST['record']."'";
	$result = $focus->db->query($query);
	if ($result != null) {
	
		while(($row = $focus->db->fetchByAssoc($result)) != null) {
			$iquery ="INSERT INTO prospect_lists_prospects (id,prospect_list_id, related_id, related_type,date_modified) ";
			$iquery .= "VALUES ("."'".create_guid()."',"."'".$focus->id."',"."'".$row['related_id']."',"."'".$row['related_type']."',"."'".TimeDate::getInstance()->nowDb()."')";
			$focus->db->query($iquery); //save the record.	
		}	
	}
}
header("Location: index.php?action=DetailView&module=ProspectLists&record=$return_id");
?>