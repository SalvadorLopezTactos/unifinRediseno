<?php
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
 * Class ForecastSchedule
 * @deprecated
 */
class ForecastSchedule extends SugarBean {

	var $id;
	var $timeperiod_id;
	var $user_id;
	var $cascade_hierarchy;
	var $forecast_start_date;
	var $status;
	var $timeperiod_name;
	var $user_name;
	var $cascade_hierarchy_checked;
	var $created_by;
	var $date_entered;
	var $date_modified;
    var $currency_id;
    var $base_rate;
    var $expected_commit_stage;
    var $expected_best_case;
    var $expected_likely_case;
    var $expected_worst_case;

	var $module_dir = 'ForecastSchedule';
    var $module_name = 'ForecastSchedule';
	var $object_name = 'ForecastSchedule';
	var $current_user;
	var $table_name = "forecast_schedule";

	var $encodeFields = Array();

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array();

	

	var $new_schema = true;

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function ForecastSchedule()
    {
        self::__construct();
    }

    /**
     * ForecastSchedule is going to be removed in an upcoming release
     * @deprecated
     */
    public function __construct() {
		parent::__construct();
        $GLOBALS['log']->deprecated('The ForecastSchedule Module has been deprecated.  ForecastSchedule should not be used as it will be removed in an upcoming version');
		$this->setupCustomFields('ForecastSchedule');  //parameter is module name
		$this->disable_row_level_security =true;
	}

	function save($check_notify = false){
        if(empty($this->currency_id)) {
            // use user preferences for currency
            $currency = SugarCurrency::getUserLocaleCurrency();
            $this->currency_id = $currency->id;
        } else {
            $currency = SugarCurrency::getCurrencyByID($this->currency_id);
        }
        $this->base_rate = $currency->conversion_rate;
        parent::save($check_notify);
	}


	function get_summary_text()
	{
		return "$this->timeperiod_name";
	}

	
	function retrieve($id, $encode=false,$deleted=true){
		$ret = parent::retrieve($id, $encode,$deleted);	
		return $ret;
	}

	function is_authenticated()
	{
		return $this->authenticated;
	}

	function fill_in_additional_list_fields() {
		$this->fill_in_additional_detail_fields();
	}

	function fill_in_additional_detail_fields()
	{
		global $locale;
		//get user name;
		$query = "SELECT first_name, last_name from users where id = '$this->user_id'";
		$result = $this->db->query($query,true,"Error fetching user name:");
		
		$row = $this->db->fetchByAssoc($result);
        if ($row != null) {
            $this->user_name = $locale->formatName('Users', $row);
		}
		
		//get timeperiod name.=
		$query = "SELECT name,start_date,end_date from timeperiods where id = '$this->timeperiod_id'";
		$result = $this->db->query($query,true,"Error fetching timeperiod name:");
		
		$row = $this->db->fetchByAssoc($result);
		if ($row != null) {	
			$this->timeperiod_name = $row['name'];
		}
	}

	function get_list_view_data(){
		$schedule_fields = $this->get_list_view_array();
	
		$schedule_fields['USER_NAME'] = $this->user_name;		
		
		if ($schedule_fields['CASCADE_HIERARCHY']== 1 )
			$schedule_fields['CASCADE_HIERARCHY_CHECKED'] = "checked";
			  
		return $schedule_fields;
	}

	function list_view_parse_additional_sections(&$list_form, $xTemplateSection){
		return $list_form;
	}

	/**
	* This function returns a full (ie non-paged) list of the current object type.
	* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	* All Rights Reserved..
	* Contributor(s): ______________________________________..
	*/
	function get_full_list($order_by = "", $where = "", $check_dates=false) {
		$GLOBALS['log']->debug("get_full_list:  order_by = '$order_by' and where = '$where'");
		$query = $this->create_new_list_query($order_by, $where);
		return $this->process_full_list_query($query, $check_dates);
	}

	function bean_implements($interface){
		switch($interface){
			case 'ACL':return true;
		}
		return false;
	}

}
?>
