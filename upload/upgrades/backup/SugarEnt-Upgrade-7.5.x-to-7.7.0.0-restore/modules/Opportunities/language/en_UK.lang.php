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
  'ERR_DELETE_RECORD' => 'A record number must be specified to delete the opportunity.',
  'LABEL_PANEL_ASSIGNMENT' => 'Assignment',
  'LBL_ACCOUNT_ID' => 'Account ID',
  'LBL_ACCOUNT_NAME' => 'Account Name:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activities',
  'LBL_ASSIGNED_TO_ID' => 'Assigned User:',
  'LBL_ASSIGNED_TO_NAME' => 'Assigned to:',
  'LBL_CAMPAIGN' => 'Campaign:',
  'LBL_CAMPAIGN_LINK' => 'Campaign Link',
  'LBL_CAMPAIGN_OPPORTUNITY' => 'Campaigns',
  'LBL_CLOSED_RLIS' => '# of Closed Revenue Line Items',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'Closed Won Opportunities',
  'LBL_COMMITTED' => 'Committed',
  'LBL_COMMIT_STAGE' => 'Commit Stage',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contacts',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Related Contacts&#39; Emails',
  'LBL_CONTRACTS' => 'Contracts',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Contracts',
  'LBL_CREATED_ID' => 'Created by ID',
  'LBL_CREATED_USER' => 'Created User',
  'LBL_CURRENCIES' => 'Currencies',
  'LBL_CURRENCY' => 'Currency:',
  'LBL_CURRENCY_ID' => 'Currency ID',
  'LBL_CURRENCY_NAME' => 'Currency Name',
  'LBL_CURRENCY_RATE' => 'Currency Rate',
  'LBL_CURRENCY_SYMBOL' => 'Currency Symbol',
  'LBL_DATE_CLOSED' => 'Expected Close Date:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Expected Close Date Timestamp',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Opportunities',
  'LBL_DESCRIPTION' => 'Description:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documents',
  'LBL_DUPLICATE' => 'Possible Duplicate Opportunity',
  'LBL_EDITLAYOUT' => 'Edit Layout',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Assigned User ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Assigned User Name',
  'LBL_EXPORT_CAMPAIGN_ID' => 'Campaign ID',
  'LBL_EXPORT_CREATED_BY' => 'Created By ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modified By ID',
  'LBL_EXPORT_NAME' => 'Name',
  'LBL_FILENAME' => 'Attachment',
  'LBL_FORECAST' => 'Include in Forecast',
  'LBL_HELP_CREATE' => 'The {{plural_module_name}} module allows you to track individual sales and the line items belonging to those sales from start to finish. Each {{module_name}} record represents a header for a group of {{revenuelineitems_module}} as well as relating to other important records such as {{quotes_module}}, {{contacts_module}}, etc.

To create an {{module_name}}:
1. Provide values for the fields as desired.
 - Fields marked "Required" must be completed prior to saving.
 - Click "Show More" to expose additional fields if necessary.
2. Click "Save" to finalise the new record and return to the previous page.
 - Choose "Save and view" to open the new {{module_name}} in record view.
 - Choose "Save and create new" to immediately create another new {{module_name}}.
3. After saving, use the {{revenuelineitems_module}} subpanel to add line items to the {{module_name}}.',
  'LBL_HELP_RECORD' => 'The {{plural_module_name}} module allows you to track individual sales and the line items belonging to those sales from start to finish. Each {{module_name}} record represents a header for a group of {{revenuelineitems_module}} as well as relating to other important records such as {{quotes_module}}, {{contacts_module}}, etc.

- Edit this record&#39;s fields by clicking an individual field or the Edit button.
- View or modify links to other records in the subpanels, including {{revenuelineitems_module}}, by toggling the bottom left pane to "Data View".
- Make and view user comments and record change history in the {{activitystream_singular_module}} by toggling the bottom left pane to "Activity Stream".
- Follow or favorite this record using the icons to the right of the record name.
- Additional actions are available in the dropdown Actions menu to the right of the Edit button.',
  'LBL_HELP_RECORDS' => 'The {{plural_module_name}} module allows you to track individual sales and the line items belonging to those sales from start to finish. Each {{module_name}} record represents a header for a group of {{revenuelineitems_module}} as well as relating to other important records such as {{quotes_module}}, {{contacts_module}}, etc. Each {{revenuelineitems_singular_module}} is the prospective sale of a particular product and includes relevant sale data. Each {{revenuelineitems_singular_module}} will typically progress through several Sales Stages until it is marked either "Closed Won" or "Closed Lost". The {{module_name}} record reflects the amount and expected close date of its {{revenuelineitems_module}}. {{plural_module_name}} and {{revenuelineitems_module}} can be leveraged even further by using Sugar&#39;s {{forecasts_singular_module}}ing module to understand and predict sales trends as well as focus work to achieve sales quotas.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'History',
  'LBL_INVITEE' => 'Contacts',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Leads',
  'LBL_LEAD_SOURCE' => 'Lead Source:',
  'LBL_LIST_ACCOUNT_NAME' => 'Account Name',
  'LBL_LIST_AMOUNT' => 'Likely',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'Amount',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Assigned User',
  'LBL_LIST_DATE_CLOSED' => 'Close',
  'LBL_LIST_FORM_TITLE' => 'Opportunity List',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Name',
  'LBL_LIST_SALES_STAGE' => 'Sales Stage',
  'LBL_MKTO_ID' => 'Marketo Lead ID',
  'LBL_MKTO_SYNC' => 'Sync to Marketo&reg;',
  'LBL_MODIFIED_ID' => 'Modified by ID',
  'LBL_MODIFIED_NAME' => 'Modified by User Name',
  'LBL_MODIFIED_USER' => 'Modified User',
  'LBL_MODULE_NAME' => 'Opportunities',
  'LBL_MODULE_NAME_SINGULAR' => 'Opportunity',
  'LBL_MODULE_TITLE' => 'Opportunities: Home',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'My Closed Opportunities',
  'LBL_NAME' => 'Opportunity Name',
  'LBL_NEW_FORM_TITLE' => 'Create Opportunity',
  'LBL_NEXT_STEP' => 'Next Step:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notes',
  'LBL_OPPORTUNITY' => 'Opportunity:',
  'LBL_OPPORTUNITY_NAME' => 'Opportunity Name:',
  'LBL_OPPORTUNITY_ROLE' => 'Opportunity Role',
  'LBL_OPPORTUNITY_TYPE' => 'Opportunity Type',
  'LBL_PIPELINE_TOTAL_IS' => 'Pipeline Total is',
  'LBL_PRIMARY_QUOTE_ID' => 'Primary Quote',
  'LBL_PROBABILITY' => 'Probability (%):',
  'LBL_PRODUCTS' => 'Quoted Line Items',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => '',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projects',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projects',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Quotes',
  'LBL_QUOTE_SUBPANEL_TITLE' => 'Quotes',
  'LBL_RAW_AMOUNT' => 'Raw Amount',
  'LBL_RLI' => 'Revenue Line Items',
  'LBL_RLI_SUBPANEL_TITLE' => 'Revenue Line Items',
  'LBL_SALES_STAGE' => 'Sales Stage:',
  'LBL_SALES_STATUS' => 'Status',
  'LBL_SEARCH_FORM_TITLE' => 'Opportunity Search',
  'LBL_TEAM_ID' => 'Team ID',
  'LBL_TIMEPERIODS' => 'TimePeriods',
  'LBL_TIMEPERIOD_ID' => 'TimePeriod ID',
  'LBL_TOP_OPPORTUNITIES' => 'My Top Open Opportunities',
  'LBL_TOTAL_OPPORTUNITIES' => 'Total Opportunities',
  'LBL_TOTAL_RLIS' => '# of Total Revenue Line Items',
  'LBL_TYPE' => 'Type:',
  'LBL_VIEW_FORM_TITLE' => 'Opportunity View',
  'LBL_WORKSHEET' => 'Worksheet',
  'LNK_CREATE' => 'Create Deal',
  'LNK_IMPORT_OPPORTUNITIES' => 'Import Opportunities',
  'LNK_NEW_OPPORTUNITY' => 'Create Opportunity',
  'LNK_OPPORTUNITY_LIST' => 'View Opportunities',
  'LNK_OPPORTUNITY_REPORTS' => 'View Opportunity Reports',
  'MSG_DUPLICATE' => 'The opportunity record you are about to create might be a duplicate of a opportunity record that already exists. Opportunity records containing similar names are listed below.<br>Click Save to continue creating this new opportunity, or click Cancel to return to the module without creating the opportunity.',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => 'You cannot delete Opportunities that contain closed Revenue Line Items',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Are you sure you want to remove this contact from the opportunity?',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'Are you sure you want to remove this opportunity from the project?',
  'TPL_RLI_CREATE' => 'An opportunity must have an associated Revenue Line Item. <a href="javascript:void(0);" id="createRLI">Create a Revenue Line Item</a>.',
  'TPL_RLI_CREATE_LINK_TEXT' => 'Create a Revenue Line Item.',
  'UPDATE' => 'Opportunity - Currency Update',
  'UPDATE_BUGFOUND_COUNT' => 'Bugs Found:',
  'UPDATE_BUG_COUNT' => 'Bugs Found and Attempted to Resolve:',
  'UPDATE_COUNT' => 'Records Updated:',
  'UPDATE_CREATE_CURRENCY' => 'Creating New Currency:',
  'UPDATE_DOLLARAMOUNTS' => 'Update GB Pound Amounts',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Update the GB Pound amounts for opportunities based on the current set currency rates. This value is used to calculate Graphs and List View Currency Amounts.',
  'UPDATE_DONE' => 'Done',
  'UPDATE_FAIL' => 'Could not update -',
  'UPDATE_FIX' => 'Fix Amounts',
  'UPDATE_FIX_TXT' => 'Attempts to fix any invalid amounts by creating a valid decimal from the current amount. Any modified amount is backed up in the amount_backup database field. If you run this and notice bugs, do not rerun it without restoring from the backup as it may overwrite the backup with new invalid data.',
  'UPDATE_INCLUDE_CLOSE' => 'Include Closed Records',
  'UPDATE_MERGE' => 'Merge Currencies',
  'UPDATE_MERGE_TXT' => 'Merge multiple currencies into a single currency. If there are multiple currency records for the same currency, you merge them together. This will also merge the currencies for all other modules.',
  'UPDATE_NULL_VALUE' => 'Amount is NULL setting it to 0 -',
  'UPDATE_RESTORE' => 'Restore Amounts',
  'UPDATE_RESTORE_COUNT' => 'Record Amounts Restored:',
  'UPDATE_RESTORE_TXT' => 'Restores amount values from the backups created during fix.',
  'UPDATE_VERIFY' => 'Verify Amounts',
  'UPDATE_VERIFY_CURAMOUNT' => 'Current Amount:',
  'UPDATE_VERIFY_FAIL' => 'Record Failed Verification:',
  'UPDATE_VERIFY_FIX' => 'Running Fix would give',
  'UPDATE_VERIFY_NEWAMOUNT' => 'New Amount:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'New Currency:',
  'UPDATE_VERIFY_TXT' => 'Verifies that the amount values in opportunities are valid decimal numbers with only numeric characters(0-9) and decimals(.)',
  'WARNING_NO_DELETE_CLOSED_SELECTED' => 'One or more of the selected records contains closed Revenue Line Items and cannot be deleted.',
);

