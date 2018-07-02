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

require_once ('include/SugarObjects/templates/basic/Basic.php');

class Person extends Basic
{
    var $picture;
    /**
     *
     * @var bool controls whether or not to invoke the getLocalFormatttedName
     *      method with title and salutation
     */
    var $createLocaleFormattedName = true;

    /**
     *
     * @var Link2
     */
    public $email_addresses;

    /**
     * This is a deprecated method, please start using __construct() as this
     * method will be removed in a future version.
     *
     * @deprecated since 7.0.0. Use __construct() instead.
     */
    public function Person()
    {
        $GLOBALS['log']->deprecated('Calls to Person::Person() are deprecated.');
        self::__construct();
    }

    public function __construct()
    {
        parent::__construct();
        $this->emailAddress = BeanFactory::getBean('EmailAddresses');
    }

    /**
     * need to override to have a name field created for this class
     *
     * @see parent::retrieve()
     */
    public function retrieve($id = -1, $encode = true, $deleted = true)
    {
        $ret_val = parent::retrieve($id, $encode, $deleted);
        $this->_create_proper_name_field();
        return $ret_val;
    }

    /**
     * Populate email address fields here instead of retrieve() so that they are
     * properly available for logic hooks
     *
     * @see parent::fill_in_relationship_fields()
     */
    public function fill_in_relationship_fields()
    {
        parent::fill_in_relationship_fields();
        $this->emailAddress->handleLegacyRetrieve($this);
    }

	/**
     * This function helps generate the name and full_name member field variables from the salutation, title, first_name and last_name fields.
     * It takes into account the locale format settings as well as ACL settings if supported.
	 */
	public function _create_proper_name_field()
	{
        global $locale;
        $this->name = $this->full_name = $locale->formatName($this);
	}

    /**
     *
     * @see parent::save()
     */
    public function save($check_notify = false)
    {
        // If we are saving due to relationship changes, don't bother trying to
        // update the emails
        if (static::inOperation('saving_related')) {
            parent::save($check_notify);
            return $this->id;
        }
        $this->add_address_streets('primary_address_street');
        $this->add_address_streets('alt_address_street');
        $ori_in_workflow = empty($this->in_workflow) ? false : true;
        $this->emailAddress->handleLegacySave($this, $this->module_dir);
        // bug #39188 - store emails state before workflow make any changes
        $this->emailAddress->stash($this->id, $this->module_dir);
        parent::save($check_notify);
        // $this->emailAddress->evaluateWorkflowChanges($this->id,
        // $this->module_dir);
        $override_email = array();
        if (!empty($this->email1_set_in_workflow)) {
            $override_email['emailAddress0'] = $this->email1_set_in_workflow;
        }
        if (!empty($this->email2_set_in_workflow)) {
            $override_email['emailAddress1'] = $this->email2_set_in_workflow;
        }
        if (!isset($this->in_workflow)) {
            $this->in_workflow = false;
        }
        if ($ori_in_workflow === false || !empty($override_email)) {
            $this->emailAddress->save($this->id, $this->module_dir, $override_email, '', '', '', '', $this->in_workflow);
            // $this->emailAddress->applyWorkflowChanges($this->id, $this->module_dir);
        }
        return $this->id;
    }

    /**
     *
     * @see parent::get_summary_text()
     */
    public function get_summary_text()
    {
        $this->_create_proper_name_field();
        return $this->name;
	}

	/**
 	 * @see parent::get_list_view_data()
 	 */
	public function get_list_view_data()
	{
		global $system_config;
		global $current_user;

		$this->_create_proper_name_field();
		$temp_array = $this->get_list_view_array();

        $temp_array['NAME'] = $this->name;
        $temp_array["ENCODED_NAME"] = $this->full_name;
        $temp_array["FULL_NAME"] = $this->full_name;

        $temp_array['EMAIL'] = $this->emailAddress->getPrimaryAddress($this);

        // Fill in the email1 field only if the user has access to it
        // This is a special case, because getEmailLink() uses email1 field for making the link
        // Otherwise get_list_view_data() shouldn't set any fields except fill the template data
        if ($this->ACLFieldAccess('email1', 'read')) {
            $this->email1 = $temp_array['EMAIL'];
        }
        $temp_array['EMAIL_LINK'] = $current_user->getEmailLink('email1', $this, '', '', 'ListView');

		return $temp_array;
	}

    /**
     *
     * @see SugarBean::populateRelatedBean()
     */
    public function populateRelatedBean(SugarBean $newbean)
    {
        parent::populateRelatedBean($newbean);

        if ($newbean instanceof Company) {
            $newbean->phone_fax = $this->phone_fax;
            $newbean->phone_office = $this->phone_work;
            $newbean->phone_alternate = $this->phone_other;
            $newbean->email1 = $this->email1;
            $this->add_address_streets('primary_address_street');
            $newbean->billing_address_street = $this->primary_address_street;
            $newbean->billing_address_city = $this->primary_address_city;
            $newbean->billing_address_state = $this->primary_address_state;
            $newbean->billing_address_postalcode = $this->primary_address_postalcode;
            $newbean->billing_address_country = $this->primary_address_country;
            $this->add_address_streets('alt_address_street');
            $newbean->shipping_address_street = $this->alt_address_street;
            $newbean->shipping_address_city = $this->alt_address_city;
            $newbean->shipping_address_state = $this->alt_address_state;
            $newbean->shipping_address_postalcode = $this->alt_address_postalcode;
            $newbean->shipping_address_country = $this->alt_address_country;
        }
    }
}
