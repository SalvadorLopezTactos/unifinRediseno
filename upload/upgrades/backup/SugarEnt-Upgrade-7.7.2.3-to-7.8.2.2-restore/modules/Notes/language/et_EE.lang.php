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
    'ERR_DELETE_RECORD' => 'Ettevõtte kustutamiseks täpsusta kirje numbrit.',
    'LBL_ACCOUNT_ID' => 'Ettevõtte ID:',
    'LBL_CASE_ID' => 'Juhtumi ID:',
    'LBL_CLOSE' => 'Sulge:',
    'LBL_COLON' => ':',
    'LBL_CONTACT_ID' => 'Kontakti ID:',
    'LBL_CONTACT_NAME' => 'Kontakt:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Märkused:',
    'LBL_DESCRIPTION' => 'Märkus',
    'LBL_EMAIL_ADDRESS' => 'E-post:',
    'LBL_EMAIL_ATTACHMENT' => 'E-kirja manus',
    'LBL_FILE_MIME_TYPE' => 'Mime Type',
    'LBL_FILE_URL' => 'Faili URL',
    'LBL_FILENAME' => 'Manus:',
    'LBL_LEAD_ID' => 'Müügivihje ID:',
    'LBL_LIST_CONTACT_NAME' => 'Kontakt',
    'LBL_LIST_DATE_MODIFIED' => 'Viimati muudetud:',
    'LBL_LIST_FILENAME' => 'Manus',
    'LBL_LIST_FORM_TITLE' => 'Märkuste loend',
    'LBL_LIST_RELATED_TO' => 'Seotud',
    'LBL_LIST_SUBJECT' => 'Teema',
    'LBL_LIST_STATUS' => 'Olek',
    'LBL_LIST_CONTACT' => 'Kontakt',
    'LBL_MODULE_NAME' => 'Märkused',
    'LBL_MODULE_NAME_SINGULAR' => 'Note',
    'LBL_MODULE_TITLE' => 'Märkused: Avaleht',
    'LBL_NEW_FORM_TITLE' => 'Loo märkus või lisa manus',
    'LBL_NEW_FORM_BTN' => 'Add a Note',
    'LBL_NOTE_STATUS' => 'Märkus',
    'LBL_NOTE_SUBJECT' => 'Märkuse teema:',
    'LBL_NOTES_SUBPANEL_TITLE' => 'Manused',
    'LBL_NOTE' => 'Märkus:',
    'LBL_OPPORTUNITY_ID' => 'Müügivõimaluse ID:',
    'LBL_PARENT_ID' => 'Seotud ID:',
    'LBL_PARENT_TYPE' => 'Parent Type',
    'LBL_PHONE' => 'Tlf number:',
    'LBL_PORTAL_FLAG' => 'Kuvada portaalis?',
    'LBL_EMBED_FLAG' => 'Lubada e-kirjas?',
    'LBL_PRODUCT_ID' => 'Artikli ID:',
    'LBL_QUOTE_ID' => 'Pakkumise ID:',
    'LBL_RELATED_TO' => 'Seotud:',
    'LBL_SEARCH_FORM_TITLE' => 'Märkuse otsing',
    'LBL_STATUS' => 'Olek',
    'LBL_SUBJECT' => 'Teema:',
    'LNK_IMPORT_NOTES' => 'Impordi märkused',
    'LNK_NEW_NOTE' => 'Loo märkus või manus',
    'LNK_NOTE_LIST' => 'Vaata märkuseid',
    'LBL_MEMBER_OF' => 'Liige',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Määratud kasutaja',
    'LBL_OC_FILE_NOTICE' => 'Palun logi serverisse faili vaatamiseks',
    'LBL_REMOVING_ATTACHMENT' => 'Manuse eemaldamine...',
    'ERR_REMOVING_ATTACHMENT' => 'Manuse eemaldamine ebaõnnestus...',
    'LBL_CREATED_BY' => 'Loodud',
    'LBL_MODIFIED_BY' => 'Muutja',
    'LBL_SEND_ANYWAYS' => 'See e-kiri ei sisalda teemat. Saata/salvestada ikkagi?',
    'LBL_LIST_EDIT_BUTTON' => 'Redigeeri',
    'LBL_ACTIVITIES_REPORTS' => 'Tegevuste aruanne',
    'LBL_PANEL_DETAILS' => 'Lisainfo',
    'LBL_NOTE_INFORMATION' => 'Märkuste ülevaade',
    'LBL_MY_NOTES_DASHLETNAME' => 'Minu märkused',
    'LBL_EDITLAYOUT' => 'Edit Layout' /*for 508 compliance fix*/,
    //For export labels
    'LBL_FIRST_NAME' => 'Eesnimi:',
    'LBL_LAST_NAME' => 'Perekonnanimi',
    'LBL_EXPORT_PARENT_TYPE' => 'Related To Module',
    'LBL_EXPORT_PARENT_ID' => 'Related To ID',
    'LBL_DATE_ENTERED' => 'Sisestamiskuupäev',
    'LBL_DATE_MODIFIED' => 'Date Modified',
    'LBL_DELETED' => 'Deleted',
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
