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

$mod_strings = array(
    'ERR_DELETE_RECORD' => 'K odstráneniu verzie musíte zadať číslo záznamu.',
    'LBL_ACCOUNT_ID' => 'Číslo účtu:',
    'LBL_CASE_ID' => 'Číslo udalosti:',
    'LBL_CLOSE' => 'Zavrieť',
    'LBL_COLON' => ':',
    'LBL_CONTACT_ID' => 'Číslo kontaktu:',
    'LBL_CONTACT_NAME' => 'Kontakt:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Poznámky',
    'LBL_DESCRIPTION' => 'Poznámka',
    'LBL_EMAIL_ADDRESS' => 'Email adresa:',
    'LBL_EMAIL_ATTACHMENT' => 'Email príloha',
    'LBL_FILE_MIME_TYPE' => 'Typ MIME',
    'LBL_FILE_URL' => 'Súbor URL',
    'LBL_FILENAME' => 'Príloha:',
    'LBL_LEAD_ID' => 'Číslo vedeného:',
    'LBL_LIST_CONTACT_NAME' => 'Kontakt',
    'LBL_LIST_DATE_MODIFIED' => 'Naposledy zmenené',
    'LBL_LIST_FILENAME' => 'Príloha',
    'LBL_LIST_FORM_TITLE' => 'Zoznam poznámok',
    'LBL_LIST_RELATED_TO' => 'Vzťahujúce sa na',
    'LBL_LIST_SUBJECT' => 'Predmet',
    'LBL_LIST_STATUS' => 'Stav',
    'LBL_LIST_CONTACT' => 'Kontakt',
    'LBL_MODULE_NAME' => 'Poznámky',
    'LBL_MODULE_NAME_SINGULAR' => 'Poznámka',
    'LBL_MODULE_TITLE' => 'Poznámky: Hlavná stránka',
    'LBL_NEW_FORM_TITLE' => 'Vytvoriť poznámku alebo pridať prílohu',
    'LBL_NEW_FORM_BTN' => 'Pridaj poznámku',
    'LBL_NOTE_STATUS' => 'Poznámka',
    'LBL_NOTE_SUBJECT' => 'Predmet:',
    'LBL_NOTES_SUBPANEL_TITLE' => 'Prílohy',
    'LBL_NOTE' => 'Poznámka:',
    'LBL_OPPORTUNITY_ID' => 'Číslo príležitosti:',
    'LBL_PARENT_ID' => 'Číslo rodiča:',
    'LBL_PARENT_TYPE' => 'Typ rodiča',
    'LBL_PHONE' => 'Telefón:',
    'LBL_PORTAL_FLAG' => 'Zobraziť na portáli?',
    'LBL_EMBED_FLAG' => 'Vložiť do emailu?',
    'LBL_PRODUCT_ID' => 'Číslo produktu:',
    'LBL_QUOTE_ID' => 'Číslo citátu',
    'LBL_RELATED_TO' => 'Vzťahuje sa na:',
    'LBL_SEARCH_FORM_TITLE' => 'Vyhľadať poznámku',
    'LBL_STATUS' => 'Stav',
    'LBL_SUBJECT' => 'Predmet:',
    'LNK_IMPORT_NOTES' => 'Import poznámok',
    'LNK_NEW_NOTE' => 'Vytvoriť poznámku alebo prílohu',
    'LNK_NOTE_LIST' => 'Zobrazenie poznámok',
    'LBL_MEMBER_OF' => 'Člen v:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Pridelený uživateľ',
    'LBL_OC_FILE_NOTICE' => 'K zobrazeniu súboru sa prihláste na serveri, prosím',
    'LBL_REMOVING_ATTACHMENT' => 'Odobratie prílohy',
    'ERR_REMOVING_ATTACHMENT' => 'Odobratie prílohy zlyhalo ...',
    'LBL_CREATED_BY' => 'Vytvoril',
    'LBL_MODIFIED_BY' => 'Upravil',
    'LBL_SEND_ANYWAYS' => 'Tomuto emailu chýba predmet. Odoslať/uložiť aj tak?',
    'LBL_LIST_EDIT_BUTTON' => 'Upraviť',
    'LBL_ACTIVITIES_REPORTS' => 'Výkaz o ativitách',
    'LBL_PANEL_DETAILS' => 'Detaily',
    'LBL_NOTE_INFORMATION' => 'Prehľad poznámok',
    'LBL_MY_NOTES_DASHLETNAME' => 'Moje poznámky',
    'LBL_EDITLAYOUT' => 'Upraviť rozloženie' /*for 508 compliance fix*/,
    //For export labels
    'LBL_FIRST_NAME' => 'Meno',
    'LBL_LAST_NAME' => 'Priezvisko',
    'LBL_EXPORT_PARENT_TYPE' => 'Viazané na modul',
    'LBL_EXPORT_PARENT_ID' => 'Viazané na ID',
    'LBL_DATE_ENTERED' => 'Dátum vytvorenia',
    'LBL_DATE_MODIFIED' => 'Dátum úpravy',
    'LBL_DELETED' => 'Vymazaný',
    'LBL_REVENUELINEITEMS' => 'Revenue Line Items',

    // Help Text
    // List View Help Text
    'LBL_HELP_RECORDS' => 'The {{plural_module_name}} module consists of individual {{plural_module_name}} that contain text or an attachment pertinent to the related record. {{module_name}} records can be related to one record in most modules via the flex relate field and can also be related to a single {{contacts_singular_module}}. {{plural_module_name}} can hold generic text about a record or even an attachment related to the record. There are various ways you can create {{plural_module_name}} in Sugar such as via the {{plural_module_name}} module, importing {{plural_module_name}}, via History subpanels, etc. Once the {{module_name}} record is created, you can view and edit information pertaining to the {{module_name}} via the {{plural_module_name}} record view. Each {{module_name}} record may then relate to other Sugar records such as {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, and many others.',

    // Record View Help Text
    'LBL_HELP_RECORD' => 'The {{plural_module_name}} module consists of individual {{plural_module_name}} that contain text or an attachment pertinent to the related record.

- Edit this record&#39;s fields by clicking an individual field or the Edit button.
- View or modify links to other records in the subpanels by toggling the bottom left pane to "Data View".
- Make and view user comments and record change history in the {{activitystream_singular_module}} by toggling the bottom left pane to "Activity Stream".
- Follow or favorite this record using the icons to the right of the record name.
- Additional actions are available in the dropdown Actions menu to the right of the Edit button.',

    // Create View Help Text
    'LBL_HELP_CREATE' => 'To create a {{module_name}}:
1. Provide values for the fields as desired.
 - Fields marked "Required" must be completed prior to saving.
 - Click "Show More" to expose additional fields if necessary.
2. Click "Save" to finalize the new record and return to the previous page.',
);
