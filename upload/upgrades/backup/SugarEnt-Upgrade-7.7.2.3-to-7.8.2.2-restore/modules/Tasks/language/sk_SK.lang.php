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

$mod_strings = array (
  'LBL_MODULE_NAME' => 'Úlohy',
  'LBL_MODULE_NAME_SINGULAR' => 'Úloha',
  'LBL_TASK' => 'úlohy',
  'LBL_MODULE_TITLE' => 'Úlohy: Domov',
  'LBL_SEARCH_FORM_TITLE' => 'Vyhľadávanie úloh',
  'LBL_LIST_FORM_TITLE' => 'Zoznam úloh',
  'LBL_NEW_FORM_TITLE' => 'Vytvoriť plohu',
  'LBL_NEW_FORM_SUBJECT' => 'Predmet:',
  'LBL_NEW_FORM_DUE_DATE' => 'do dátumu',
  'LBL_NEW_FORM_DUE_TIME' => 'do času',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_LIST_CLOSE' => 'Zavrieť',
  'LBL_LIST_SUBJECT' => 'Predmet',
  'LBL_LIST_CONTACT' => 'Kontakt:',
  'LBL_LIST_PRIORITY' => 'Priorita',
  'LBL_LIST_RELATED_TO' => 'Nadriadený',
  'LBL_LIST_DUE_DATE' => 'do dátumu',
  'LBL_LIST_DUE_TIME' => 'do času',
  'LBL_SUBJECT' => 'Predmet:',
  'LBL_STATUS' => 'Stav:',
  'LBL_DUE_DATE' => 'do dátumu',
  'LBL_DUE_TIME' => 'do času',
  'LBL_PRIORITY' => 'Priorita:',
  'LBL_COLON' => ':',
  'LBL_DUE_DATE_AND_TIME' => 'do dátumu a času',
  'LBL_START_DATE_AND_TIME' => 'dátum a čas začiatku',
  'LBL_START_DATE' => 'Dátum začiatku:',
  'LBL_LIST_START_DATE' => 'Dátum začiatku:',
  'LBL_START_TIME' => 'čas začiatku',
  'LBL_LIST_START_TIME' => 'Čas zahájenia',
  'DATE_FORMAT' => '(yyyy-mm-dd)',
  'LBL_NONE' => 'Nič',
  'LBL_CONTACT' => 'Kontakt:',
  'LBL_EMAIL_ADDRESS' => 'Email adresa:',
  'LBL_PHONE' => 'Telefón:',
  'LBL_EMAIL' => 'Emailová adresa:',
  'LBL_DESCRIPTION_INFORMATION' => 'Popis informácie',
  'LBL_DESCRIPTION' => 'Popis',
  'LBL_NAME' => 'Názov',
  'LBL_CONTACT_NAME' => 'Meno kontaktu:',
  'LBL_LIST_COMPLETE' => 'kompletný',
  'LBL_LIST_STATUS' => 'Stav',
  'LBL_DATE_DUE_FLAG' => 'nie do dátumu',
  'LBL_DATE_START_FLAG' => 'nie do času',
  'ERR_DELETE_RECORD' => 'K odstráneniu kontaktu musíte zadať číslo záznamu.',
  'ERR_INVALID_HOUR' => 'Prosím vložte platnú hodinu.',
  'LBL_DEFAULT_PRIORITY' => 'Stredne',
  'LBL_LIST_MY_TASKS' => 'Moje otvorené úlohy',
  'LNK_NEW_TASK' => 'Vytvoriť úlohu',
  'LNK_TASK_LIST' => 'Zobrazenie úloh',
  'LNK_IMPORT_TASKS' => 'Import úloh',
  'LBL_CONTACT_FIRST_NAME'=>'Meno kontaktu',
  'LBL_CONTACT_LAST_NAME'=>'Priezvisko kontaktu',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Pridelený uživateľ',
  'LBL_ASSIGNED_TO_NAME'=>'Pridelený k:',
  'LBL_LIST_DATE_MODIFIED' => 'Dátum úpravy',
  'LBL_CONTACT_ID' => 'ID kontaktu:',
  'LBL_PARENT_ID' => 'ID rodiča:',
  'LBL_CONTACT_PHONE' => 'číslo kontaktu',
  'LBL_PARENT_NAME' => 'Materská kategória:',
  'LBL_ACTIVITIES_REPORTS' => 'Výkaz o ativitách',
  'LBL_EDITLAYOUT' => 'Upraviť rozloženie' /*for 508 compliance fix*/,
  'LBL_TASK_INFORMATION' => 'Prehľad',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Poznámky',
  'LBL_REVENUELINEITEMS' => 'Revenue Line Items',
  //For export labels
  'LBL_DATE_DUE' => 'Priamy dátum',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Pridelené meno užívateľa',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Pridelené užívateľské ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Upravené podľa ID',
  'LBL_EXPORT_CREATED_BY' => 'Vytvorené podľa ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Viazané na modul',
  'LBL_EXPORT_PARENT_ID' => 'Viazané na ID',
  'LBL_TASK_CLOSE_SUCCESS' => 'Úloha úspešne uzavretá.',
  'LBL_ASSIGNED_USER' => 'Pridelený k',

    'LBL_NOTES_SUBPANEL_TITLE' => 'Poznámky',

    // Help Text
    // List View Help Text
    'LBL_HELP_RECORDS' => 'The {{plural_module_name}} module consists of flexible actions, to-do items, or other type of activity which requires completion. {{module_name}} records can be related to one record in most modules via the flex relate field and can also be related to a single {{contacts_singular_module}}. There are various ways you can create {{plural_module_name}} in Sugar such as via the {{plural_module_name}} module, duplication, importing {{plural_module_name}}, etc. Once the {{module_name}} record is created, you can view and edit information pertaining to the {{module_name}} via the {{plural_module_name}} record view. Depending on the details on the {{module_name}}, you may also be able to view and edit the {{module_name}} information via the Calendar module. Each {{module_name}} record may then relate to other Sugar records such as {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, and many others.',

    // Record View Help Text
    'LBL_HELP_RECORD' => 'The {{plural_module_name}} module consists of flexible actions, to-do items, or other type of activity which requires completion.

- Edit this record&#39;s fields by clicking an individual field or the Edit button.
- View or modify links to other records in the subpanels by toggling the bottom left pane to "Data View".
- Make and view user comments and record change history in the {{activitystream_singular_module}} by toggling the bottom left pane to "Activity Stream".
- Follow or favorite this record using the icons to the right of the record name.
- Additional actions are available in the dropdown Actions menu to the right of the Edit button.',

    // Create View Help Text
    'LBL_HELP_CREATE' => 'The {{plural_module_name}} module consists of flexible actions, to-do items, or other type of activity which requires completion.

To create a {{module_name}}:
1. Provide values for the fields as desired.
 - Fields marked "Required" must be completed prior to saving.
 - Click "Show More" to expose additional fields if necessary.
2. Click "Save" to finalize the new record and return to the previous page.',

);
