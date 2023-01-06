<?php
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


/**
 *  Lead is used to store profile information for people who may become customers.
 */
class Lead extends Person {
	// Stored fields
	var $id;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $assigned_user_id;
	var $created_by;
	var $created_by_name;
	var $modified_by_name;
	var $team_id;
	var $description;
	var $salutation;
	var $first_name;
	var $last_name;
	var $title;
	var $department;
	var $reports_to_id;
	var $do_not_call;
	var $phone_home;
	var $phone_mobile;
	var $phone_work;
	var $phone_other;
	var $phone_fax;
	var $refered_by;
	var $email1;
	var $email2;
	var $primary_address_street;
	var $primary_address_city;
	var $primary_address_state;
	var $primary_address_postalcode;
	var $primary_address_country;
	var $alt_address_street;
	var $alt_address_city;
	var $alt_address_state;
	var $alt_address_postalcode;
	var $alt_address_country;
	var $name;
	var $full_name;
	var $portal_name;
	var $portal_app;
	var $contact_id;
	var $contact_name;
	var $account_id;
	var $opportunity_id;
	var $opportunity_name;
	var $opportunity_amount;
	//used for vcard export only
	var $birthdate;
	var $status;
	var $status_description;

	var $lead_source;
	var $lead_source_description;
	// These are for related fields
	var $account_name;
	var $acc_name_from_accounts;
	var $account_site;
	var $account_description;
	var $case_role;
	var $case_rel_id;
	var $case_id;
	var $task_id;
	var $note_id;
	var $meeting_id;
	var $call_id;
	var $email_id;
	var $assigned_user_name;
	var $campaign_id;
	var $campaign_name;
    var $alt_address_street_2;
    var $alt_address_street_3;
    var $primary_address_street_2;
    var $primary_address_street_3;

	var $team_name;

    public $business_center_name;
    public $business_center_id;

    //Marketo
    var $mkto_sync;
    var $mkto_id;
    var $mkto_lead_score;

    var $table_name = "leads";
	var $object_name = "Lead";
	var $object_names = "Leads";
	var $module_dir = "Leads";
	var $new_schema = true;
	var $emailAddress;

	var $importable = true;

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array('assigned_user_name', 'task_id', 'note_id', 'meeting_id', 'call_id', 'email_id');
    public $relationship_fields = array(
        'business_center_id'=>'business_centers',
        'email_id'=>'emails',
        'call_id'=>'calls',
        'meeting_id'=>'meetings',
        'task_id'=>'tasks',
    );

	function create_list_query($order_by, $where, $show_deleted=0)
	{
        $custom_join = $this->getCustomJoin();
                $query = "SELECT ";


			$query .= "$this->table_name.*, users.user_name assigned_user_name";
			$query .= ", teams.name team_name";
            $query .= $custom_join['select'];
            $query .= " FROM leads ";

		// We need to confirm that the user is a member of the team of the item.
		$this->add_team_security_where_clause($query);
			$query .= "			LEFT JOIN users
                                ON leads.assigned_user_id=users.id ";
			$query .= "LEFT JOIN email_addr_bean_rel eabl  ON eabl.bean_id = leads.id AND eabl.bean_module = 'Leads' and eabl.primary_address = 1 and eabl.deleted=0 ";
        	$query .= "LEFT JOIN email_addresses ea ON (ea.id = eabl.email_address_id) ";
            $query .= getTeamSetNameJoin('leads');
        $query .= $custom_join['join'];
			$where_auto = '1=1';
			if($show_deleted == 0){
				$where_auto = " leads.deleted=0 ";
			}else if($show_deleted == 1){
				$where_auto = " leads.deleted=1 ";
			}

		if($where != "")
			$query .= "where ($where) AND ".$where_auto;
		else
			$query .= "where ".$where_auto; //."and (leads.converted='0')";

		if(!empty($order_by))
			$query .= " ORDER BY $order_by";

		return $query;
	}

    public function create_new_list_query(
        $order_by,
        $where,
        $filter = array(),
        $params = array(),
        $show_deleted = 0,
        $join_type = '',
        $return_array = false,
        $parentbean = null,
        $singleSelect = false,
        $ifListForExport = false
    ) {

        $ret_array = parent::create_new_list_query(
            $order_by,
            $where,
            $filter,
            $params,
            $show_deleted,
            $join_type,
            true,
            $parentbean,
            $singleSelect,
            $ifListForExport
        );
		if(strpos($ret_array['select'],"leads.account_name") == false && strpos($ret_array['select'],"leads.*") == false)
			$ret_array['select'] .= " ,leads.account_name";
    	if ( !$return_array )
            return  $ret_array['select'] . $ret_array['from'] . $ret_array['where']. $ret_array['order_by'];
        return $ret_array;
	}

    function converted_lead($leadid, $contactid, $accountid, $opportunityid){
    	$query = "UPDATE leads set converted='1', contact_id=$contactid, account_id=$accountid, opportunity_id=$opportunityid where  id=$leadid and deleted=0";
		$this->db->query($query,true,"Error converting lead: ");

		//we must move the status out here in order to be able to capture workflow conditions
		$leadid = str_replace("'","", $leadid);
		$lead = BeanFactory::getBean('Leads', $leadid);
		$lead->status='Converted';
		$lead->save();
    }

	function get_list_view_data()
	{
		$temp_array = parent::get_list_view_data();
		if(!empty($temp_array['ACC_NAME_FROM_ACCOUNTS'])) {
		    $temp_array['ACC_NAME_FROM_ACCOUNTS'] = $temp_array['ACC_NAME_FROM_ACCOUNTS'];
		} elseif(!empty($temp_array['ACCOUNT_NAME'])) {
		    $temp_array['ACC_NAME_FROM_ACCOUNTS'] = $temp_array['ACCOUNT_NAME'];
		} else {
		    $temp_array['ACC_NAME_FROM_ACCOUNTS'] = '';
		}
		return $temp_array;
	}

	/**
		builds a generic search based on the query string using or
		do not include any $this-> because this is called on without having the class instantiated
	*/
	function build_generic_where_clause ($the_query_string) {
	$where_clauses = Array();
	$the_query_string = $GLOBALS['db']->quote($the_query_string);

	array_push($where_clauses, "leads.last_name like '$the_query_string%'");
	array_push($where_clauses, "leads.account_name like '$the_query_string%'");
	array_push($where_clauses, "leads.first_name like '$the_query_string%'");
	array_push($where_clauses, "ea.email_address like '$the_query_string%'");

	if (is_numeric($the_query_string)) {
		array_push($where_clauses, "leads.phone_home like '%$the_query_string%'");
		array_push($where_clauses, "leads.phone_mobile like '%$the_query_string%'");
		array_push($where_clauses, "leads.phone_work like '%$the_query_string%'");
		array_push($where_clauses, "leads.phone_other like '%$the_query_string%'");
		array_push($where_clauses, "leads.phone_fax like '%$the_query_string%'");

	}

	$the_where = "";
	foreach($where_clauses as $clause)
	{
		if($the_where != "") $the_where .= " or ";
		$the_where .= $clause;
	}


	return $the_where;
	}

	function set_notification_body($xtpl, $lead)
	{
		global $app_list_strings;
        global $locale;

        $xtpl->assign("LEAD_NAME", $locale->formatName($lead));
		$xtpl->assign("LEAD_SOURCE", (isset($lead->lead_source) && isset($app_list_strings['lead_source_dom'][$lead->lead_source]) ? $app_list_strings['lead_source_dom'][$lead->lead_source] : ""));
		$xtpl->assign("LEAD_STATUS", (isset($lead->status)? $app_list_strings['lead_status_dom'][$lead->status]:""));
		$xtpl->assign("LEAD_DESCRIPTION", $lead->description);

		return $xtpl;
	}

	function bean_implements($interface){
		switch($interface){
			case 'ACL':return true;
		}
		return false;
	}
	function listviewACLHelper(){
		$array_assign = parent::listviewACLHelper();
		$is_owner = false;
		if(!empty($this->account_name)){

			if(!empty($this->account_name_owner)){
				global $current_user;
				$is_owner = $current_user->id == $this->account_name_owner;
			}
		}
			if( ACLController::checkAccess('Accounts', 'view', $is_owner)){
				$array_assign['ACCOUNT'] = 'a';
			}else{
				$array_assign['ACCOUNT'] = 'span';
			}
		$is_owner = false;
		if(!empty($this->opportunity_name)){

			if(!empty($this->opportunity_name_owner)){
				global $current_user;
				$is_owner = $current_user->id == $this->opportunity_name_owner;
			}
		}
			if( ACLController::checkAccess('Opportunities', 'view', $is_owner)){
				$array_assign['OPPORTUNITY'] = 'a';
			}else{
				$array_assign['OPPORTUNITY'] = 'span';
			}


		$is_owner = false;
		if(!empty($this->contact_name)){

			if(!empty($this->contact_name_owner)){
				global $current_user;
				$is_owner = $current_user->id == $this->contact_name_owner;
			}
		}
			if( ACLController::checkAccess('Contacts', 'view', $is_owner)){
				$array_assign['CONTACT'] = 'a';
			}else{
				$array_assign['CONTACT'] = 'span';
			}

		return $array_assign;
	}

	function save($check_notify = false) {
        //Set business_center_id to the same as related account when not provided
        if (empty($this->business_center_id)) {
            $related_account = BeanFactory::retrieveBean('Accounts', $this->account_id);
            if (!empty($related_account) && !empty($related_account->business_center_id)) {
                $this->business_center_id = $related_account->business_center_id;
            }
        }

        // call save first so that $this->id will be set
		$value = parent::save($check_notify);
		return $value;
	}
	function get_unlinked_email_query($type=array()) {

		return get_unlinked_email_query($type, $this);
	}

    /**
     * Returns query to find the related calls created pre-5.1
     *
     * @return string SQL statement
     */
    public function get_old_related_calls()
    {
        $return_array['select']='SELECT calls.id ';
        $return_array['from']='FROM calls ';
        $return_array['where']=" WHERE calls.parent_id = '$this->id'
            AND calls.parent_type = 'Leads' AND calls.id NOT IN ( SELECT call_id FROM calls_leads ) ";
        $return_array['join'] = "";
        $return_array['join_tables'][0] = '';

        return $return_array;
    }

    /**
     * Returns array of lead conversion activity options
     *
     * @return string SQL statement
     */
    public static function getActivitiesOptions() {

        if (isset($GLOBALS['app_list_strings']['lead_conv_activity_opt'])) {
            return $GLOBALS['app_list_strings']['lead_conv_activity_opt'];
        }
        else {
            return array();
        }
    }

    /**
     * Returns query to find the related meetings created pre-5.1
     *
     * @return string SQL statement
     */
    public function get_old_related_meetings()
    {
        $return_array['select']='SELECT meetings.id ';
        $return_array['from']='FROM meetings ';
        $return_array['where']=" WHERE meetings.parent_id = '$this->id'
            AND meetings.parent_type = 'Leads' AND meetings.id NOT IN ( SELECT meeting_id FROM meetings_leads ) ";
        $return_array['join'] = "";
        $return_array['join_tables'][0] = '';

        return $return_array;
    }

    /**
     * Overriden to filter legacy calls and meetings
     * @see SugarBean::call_vardef_handler()
     */
    public function call_vardef_handler($meta_array_type=null)
    {
        $this->vardef_handler = new LeadsVarDefHandler($this, $meta_array_type);
    }
}

