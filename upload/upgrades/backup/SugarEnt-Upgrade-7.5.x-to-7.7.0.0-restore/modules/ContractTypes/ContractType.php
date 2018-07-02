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
/*********************************************************************************

 * Description: The primary Function of this file is to manage all the data
 * used by other files in this nodule. It should extend the SugarBean which implements
 * all the basic database operations. Any custom behaviors can be implemented here by
 * implementing functions available in the SugarBean.
 ********************************************************************************/






class ContractType extends SugarBean {

	var $id;
	var $date_entered;
	var $created_by;
	var $date_modified;
	var $modified_by;
	var $deleted;
	var $modified_user_id;

	var $name;
	var $list_order;
	/* End field definitions*/

	/* variable $table_name is used by SugarBean and methods in this file to constructs queries
	 * set this variables value to the table associated with this bean.
	 */
	var $table_name = 'contract_types';

	/*This  variable overrides the object_name variable in SugarBean, wher it has a value of null.*/
	var $object_name = 'ContractType';

	/**/
	var $module_dir = 'ContractTypes';

	/* This is a legacy variable, set its value to true for new modules*/
	var $new_schema = true;

	// This is used to retrieve related fields from form posts.
	var $relationship_fields = array();

	var $required_fields =  array();

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function ContractType()
    {
        self::__construct();
    }

	/*This bean's constructor*/
	public function __construct() {
		parent::__construct();
		$this->disable_row_level_security=true;
	}

	/* This method should return the summary text which is used to build the bread crumb navigation*/
	/* Generally from this method you would return value of a field that is required and is of type string*/
	function get_summary_text()
	{
		return "$this->name";
	}

	function get_next_list_order() {

		$retval=1;
		$query="select max(list_order) as max_list_order from contract_types where list_order is not null";
		$result = $this->db->query($query, false);
		$row = $this->db->fetchByAssoc($result);
		if (!empty($row) && !empty($row['max_list_order'])) {
			$retval=$row['max_list_order']+1;
		}
		return $retval;
	}


	function get_contractTypes($add_blank=false){
		$query="select id,name,list_order from contract_types where deleted = 0 order by list_order ";
		$result = $this->db->query($query, false);
		$list = array();
		if ($add_blank) {
			$list['']='';
		}
		while (($row = $this->db->fetchByAssoc($result)) != null) {
			$list[$row['id']] = $row['name'];
		}
	    return $list;
	}
}
?>
