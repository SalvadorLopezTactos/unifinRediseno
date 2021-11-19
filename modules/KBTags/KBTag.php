<?php
if(!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
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


require_once ('include/upload_file.php');
// User is used to store Forecast information.
class KBTag extends SugarBean {

	var $id;
	var $created_by;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $tag_name;
	var $parent_tag_id;
	var $team_id;
	var $active_date;
	
	//additional fields.
	

	var $table_name = "kbtags";
	var $object_name = "KBTag";
	var $user_preferences;

	var $encodeFields = Array ();

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array ('revision');

	

	var $new_schema = true;
	var $module_dir = 'KBTags';
	
//todo remove leads relationship.
	var $relationship_fields = Array('contract_id'=>'contracts',
	 
		'lead_id' => 'leads'
	 );
	  

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function KBTag()
    {
        self::__construct();
    }

	public function __construct() {
		parent::__construct();
		$this->setupCustomFields('KBTags'); //parameter is module name
		$this->disable_row_level_security = false;
	}

	function save($check_notify = false) {
        //Default the tag id to 1 which will make it global
        $this->team_id = '1';
		return parent::save($check_notify);
	}
	function get_summary_text() {
		return "$this->tag_name";
	}
	function is_authenticated() {
		return $this->authenticated;
	}
    function get_Tag_id($tag_name){
    	//nothing
    }
    

    /**
     * Changes the select expression of the given query to be 'count(*)' so you
     * can get the number of items the query will return.  This is used to
     * populate the upper limit on ListViews.
     * 
     * @param string $query Select query string
     * @return string count query
     * 
     * Internal function, do not override.
     */
    function create_list_count_query($query)
    {
        // change the select expression to 'count(*)'
        $pattern = '/SELECT(.*?)(\s){1}FROM(\s){1}/is';  // ignores the case
        $replacement = 'SELECT count(*) c FROM ';
        $modified_select_query = preg_replace($pattern, $replacement, $query,1);

        // remove the 'order by' clause which is expected to be at the end of the query
        $pattern = '/\sORDER BY.*/is';  // ignores the case
        $replacement = '';
        $modified_order_by_query = preg_replace($pattern, $replacement, $modified_select_query);

        return $modified_order_by_query;
    }
    
    /* function used by the installer to create default tags */
    function default_install_data() {
        $query="INSERT INTO kbtags (id,tag_name) values('FAQs','FAQs')";          
		$GLOBALS['db']->query($query);   	
    }
}
?>