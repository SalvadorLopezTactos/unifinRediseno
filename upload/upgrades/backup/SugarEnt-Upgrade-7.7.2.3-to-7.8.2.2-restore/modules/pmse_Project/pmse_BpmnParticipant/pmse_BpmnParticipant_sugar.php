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

/**
 * THIS CLASS IS GENERATED BY MODULE BUILDER
 * PLEASE DO NOT CHANGE THIS CLASS
 * PLACE ANY CUSTOMIZATIONS IN pmse_BpmnParticipant
 */
class pmse_BpmnParticipant_sugar extends Basic {
	var $new_schema = true;
	var $module_dir = 'pmse_Project/pmse_BpmnParticipant';
	var $object_name = 'pmse_BpmnParticipant';
	var $table_name = 'pmse_bpmn_participant';
	var $importable = false;
    var $id;
    var $name;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $modified_by_name;
    var $created_by;
    var $created_by_name;
    var $description;
    var $deleted;
    var $created_by_link;
    var $modified_user_link;
    var $activities;
    var $assigned_user_id;
    var $assigned_user_name;
    var $assigned_user_link;
    var $par_uid;
    var $prj_id;
    var $pro_id;
    var $lns_id;
    var $par_minimum;
    var $par_maximum;
    var $par_num_participants;
    var $par_is_horizontal;

    /**
     * @deprecated Use __construct() instead
     */
    public function pmse_BpmnParticipant_sugar()
    {
        self::__construct();
    }

	public function __construct(){
		parent::__construct();
	}
}
