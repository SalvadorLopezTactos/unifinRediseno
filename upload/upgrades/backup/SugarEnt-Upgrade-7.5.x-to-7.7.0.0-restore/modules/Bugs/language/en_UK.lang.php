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


$mod_strings = array (
  'ERR_DELETE_RECORD' => 'You must specify a record number in order to delete the bug.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Accounts',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activities',
  'LBL_ASSIGNED_TO_NAME' => 'Assigned to',
  'LBL_BUG' => 'Bug:',
  'LBL_BUG_INFORMATION' => 'Bug Overview',
  'LBL_BUG_NUMBER' => 'Bug Number:',
  'LBL_BUG_SUBJECT' => 'Bug Subject:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Cases',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contacts',
  'LBL_CONTACT_BUG_TITLE' => 'Contact-Bug:',
  'LBL_CONTACT_NAME' => 'Contact Name:',
  'LBL_CONTACT_ROLE' => 'Role:',
  'LBL_CREATED_BY' => 'Created by:',
  'LBL_DATE_CREATED' => 'Create Date:',
  'LBL_DATE_LAST_MODIFIED' => 'Modify Date:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Bug Tracker',
  'LBL_DESCRIPTION' => 'Description:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documents',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Assigned User ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Assigned User Name',
  'LBL_EXPORT_CREATED_BY' => 'Created By ID',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Fixed in Release Name',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modified By ID',
  'LBL_FIXED_IN_RELEASE' => 'Fixed in Release:',
  'LBL_FOUND_IN_RELEASE' => 'Found in Release:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Found In Release Name',
  'LBL_HELP_CREATE' => 'The {{plural_module_name}} module is used to track and manage product related problems, commonly referred to as {{plural_module_name}} or defects, either found internally or reported by customers.

To create a {{module_name}}:
1. Provide values for the fields as desired.
 - Fields marked "Required" must be completed prior to saving.
 - Click "Show More" to expose additional fields if necessary.
2. Click "Save" to finalise the new record and return to the previous page.
 - Choose "Save and view" to open the new {{module_name}} in record view.
 - Choose "Save and create new" to immediately create another new {{module_name}}.',
  'LBL_HELP_RECORD' => 'The {{plural_module_name}} module is used to track and manage product related problems, commonly referred to as {{plural_module_name}} or defects, either found internally or reported by customers.

- Edit this record&#39;s fields by clicking an individual field or the Edit button.
- View or modify links to other records in the subpanels by toggling the bottom left pane to "Data View".
- Make and view user comments and record change history in the {{activitystream_singular_module}} by toggling the bottom left pane to "Activity Stream".
- Follow or favorite this record using the icons to the right of the record name.
- Additional actions are available in the dropdown Actions menu to the right of the Edit button.',
  'LBL_HELP_RECORDS' => 'The {{plural_module_name}} module is used to track and manage product related problems, commonly referred to as {{plural_module_name}} or defects, either found internally or reported by customers. The {{plural_module_name}} can be further triaged by tracking the found and fixed in release. The {{plural_module_name}} module gives users a way to quickly review all details of the {{module_name}} and the process being used to rectify it. Once a {{module_name}} is created or submitted, you can view and edit information pertaining to the {{module_name}} via the {{module_name}}&#39;s record view. Each {{module_name}} record may then relate to other Sugar records such as {{calls_module}}, {{contacts_module}}, {{cases_module}}, and many others.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'History',
  'LBL_INVITEE' => 'Contacts',
  'LBL_LIST_ACCOUNT_NAME' => 'Account Name',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Assigned User',
  'LBL_LIST_CONTACT_NAME' => 'Contact Name',
  'LBL_LIST_EMAIL_ADDRESS' => 'Email Address',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Fixed in Release',
  'LBL_LIST_FORM_TITLE' => 'Bug List',
  'LBL_LIST_LAST_MODIFIED' => 'Last Modified',
  'LBL_LIST_MY_BUGS' => 'My Assigned Bugs',
  'LBL_LIST_NUMBER' => 'Num.',
  'LBL_LIST_PHONE' => 'Phone',
  'LBL_LIST_PRIORITY' => 'Priority',
  'LBL_LIST_RELEASE' => 'Release',
  'LBL_LIST_RESOLUTION' => 'Resolution',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Subject',
  'LBL_LIST_TYPE' => 'Type',
  'LBL_MODIFIED_BY' => 'Last Modified by:',
  'LBL_MODULE_ID' => 'Bugs',
  'LBL_MODULE_NAME' => 'Bugs',
  'LBL_MODULE_NAME_SINGULAR' => 'Bug',
  'LBL_MODULE_TITLE' => 'Bug Tracker: Home',
  'LBL_NEW_FORM_TITLE' => 'New Bug',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notes',
  'LBL_NUMBER' => 'Number:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'If you have found a new Bug you would like to report, you can click here to report a new Bug.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'You can filter down the list of Bugs by providing a search term.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'For example, you might use this to find a bug that has been previously reported.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'The Bugs module is for viewing and reporting bugs.  Use the arrows below to go through a quick tour.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'This page shows the list of existing published Bugs.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Clicking here will return you to this view at any time.',
  'LBL_PORTAL_VIEWABLE' => 'Portal Viewable',
  'LBL_PRIORITY' => 'Priority:',
  'LBL_PRODUCT_CATEGORY' => 'Category:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projects',
  'LBL_RELEASE' => 'Release:',
  'LBL_RESOLUTION' => 'Resolution:',
  'LBL_SEARCH_FORM_TITLE' => 'Bug Search',
  'LBL_SHOW_IN_PORTAL' => 'Show in Portal',
  'LBL_SHOW_MORE' => 'Show More Bugs',
  'LBL_SOURCE' => 'Source:',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Subject:',
  'LBL_SYSTEM_ID' => 'System ID',
  'LBL_TYPE' => 'Type:',
  'LBL_WORK_LOG' => 'Work Log:',
  'LNK_BUG_LIST' => 'View Bugs',
  'LNK_BUG_REPORTS' => 'View Bug Reports',
  'LNK_CREATE' => 'Report Bug',
  'LNK_CREATE_WHEN_EMPTY' => 'Report a Bug now.',
  'LNK_IMPORT_BUGS' => 'Import Bugs',
  'LNK_NEW_BUG' => 'Report Bug',
  'NTC_DELETE_CONFIRMATION' => 'Are you sure you want to remove this contact from this bug?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Are you sure you want to remove this bug from this account?',
  'NTC_REMOVE_INVITEE' => 'Are you sure you want to remove this contact from the bug?',
);

