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





// Contact is used to store customer information.
class ContactQuoteRelationship extends SugarBean {
	// Stored fields
	var $id;
	var $contact_id;
	var $contact_role;
	var $quote_id;

	// Related fields
	var $contact_name;
	var $quote_name;

	var $table_name = "quotes_contacts";
	var $object_name = "ContactQuoteRelationship";
    var $module_name = "ContactQuoteRelationship";
	var $column_fields = Array("id"
		,"contact_id"
		,"quote_id"
		,"contact_role"
		);

	var $new_schema = true;

	var $additional_column_fields = Array();

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function ContactQuoteRelationship()
    {
        self::__construct();
    }

	public function __construct() {
		parent::__construct();
		$this->disable_row_level_security =true;
	}

	function fill_in_additional_detail_fields()
	{
	    global $locale;
	    
		if(isset($this->contact_id) && $this->contact_id != "")
		{
			$query = "SELECT first_name, last_name from contacts where id='$this->contact_id' AND deleted=0";
			$result =$this->db->query($query,true," Error filling in additional detail fields: ");
			// Get the id and the name.
			$row = $this->db->fetchByAssoc($result);

			if($row != null)
			{
                $this->contact_name = $locale->formatName('Contacts', $row);
			}
		}

		if(isset($this->quote_id) && $this->quote_id != "")
		{
			$query = "SELECT name from quotes where id='$this->quote_id' AND deleted=0";
			$result =$this->db->query($query,true," Error filling in additional detail fields: ");
			// Get the id and the name.
			$row = $this->db->fetchByAssoc($result);

			if($row != null)
			{
				$this->quote_name = $row['name'];
			}
		}

	}
}



?>
