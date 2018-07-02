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

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$mod_strings = array (
    //module
    'LBL_MODULE_NAME' => 'Dokumendid',
    'LBL_MODULE_NAME_SINGULAR' => 'Document',
    'LBL_MODULE_TITLE' => 'Dokumendid: Avaleht',
    'LNK_NEW_DOCUMENT' => 'Loo dokument',
    'LNK_DOCUMENT_LIST'=> 'Vaata dokumente',
    'LBL_DOC_REV_HEADER' => 'Dokumendi revisjonid',
    'LBL_SEARCH_FORM_TITLE'=> 'Dokumendi otsing',
    //vardef labels
    'LBL_DOCUMENT_ID' => 'Dokumendi ID',
    'LBL_NAME' => 'Dokumendi nimi',
    'LBL_DOCUMENT_NAME' => 'Document Name',
    'LBL_DESCRIPTION' => 'Kirjeldus',
    'LBL_CATEGORY' => 'Kategooria',
    'LBL_SUBCATEGORY' => 'Alamkategooria',
    'LBL_STATUS' => 'Olek',
    'LBL_CREATED_BY'=> 'Looja:',
    'LBL_DATE_ENTERED'=> 'Sisestamiskuupäev',
    'LBL_DATE_MODIFIED'=> 'Muutmiskuupäev',
    'LBL_DELETED' => 'Kustutatud',
    'LBL_MODIFIED'=> 'Muutja ID',
    'LBL_MODIFIED_USER' => 'Muutja',
    'LBL_CREATED'=> 'Looja',
    'LBL_REVISIONS'=>'Revisjonid',
    'LBL_RELATED_DOCUMENT_ID'=>'Seotud dokumendi ID',
    'LBL_RELATED_DOCUMENT_REVISION_ID'=>'Seotud dokumendi revisjoni ID',
    'LBL_IS_TEMPLATE'=>'On mall',
    'LBL_TEMPLATE_TYPE'=>'Dokumendi tüüp',
    'LBL_ASSIGNED_TO_NAME'=>'Vastutaja:',
    'LBL_REVISION_NAME' => 'Revisjoni number',
    'LBL_MIME' => 'Mime Type',
    'LBL_REVISION' => 'Revisjon',
    'LBL_DOCUMENT' => 'Seotud dokument',
    'LBL_LATEST_REVISION' => 'Viimane revisjon',
    'LBL_DOCUMENT_REVISION_ID' => 'Document Revision Id',
    'LBL_CHANGE_LOG'=> 'Muuda logi',
    'LBL_ACTIVE_DATE'=> 'Avaldamiskuupäev',
    'LBL_EXPIRATION_DATE' => 'Aegumiskuupäev',
    'LBL_FILE_EXTENSION'  => 'Faili laiendus',
    'LBL_LAST_REV_MIME_TYPE' => 'Viimase revsjoni MIME tüüp',
    'LBL_CAT_OR_SUBCAT_UNSPEC'=>'Määramata',
    'LBL_HOMEPAGE_TITLE' => 'Minu dokumendid',
    //quick search
    'LBL_NEW_FORM_TITLE' => 'Uus dokument',
    //document edit and detail view
    'LBL_DOC_NAME' => 'Dokumendi nimi:',
    'LBL_FILENAME' => 'Faili nimi:',
    'LBL_LIST_FILENAME' => 'Faili nimi',
    'LBL_DOC_VERSION' => 'Revisjon:',
    'LBL_FILE_UPLOAD' => 'Faili nimi',

    'LBL_CATEGORY_VALUE' => 'Kategooria:',
    'LBL_SUBCATEGORY_VALUE'=> 'Alamkategooria:',
    'LBL_DOC_STATUS'=> 'Olek:',
    'LBL_DOC_STATUS_ID'=> 'Status Id:',
    'LBL_LAST_REV_CREATOR' => 'Loodud läbivaatus:',
    'LBL_LASTEST_REVISION_NAME' => 'Viimase revisjoni nimi:',
    'LBL_SELECTED_REVISION_NAME' => 'Vali revisjoni nimi',
    'LBL_CONTRACT_STATUS' => 'Lepingu olek:',
    'LBL_CONTRACT_NAME' => 'Lepingu nimi:',
    'LBL_LAST_REV_DATE' => 'Revisjoni kuupäev:',
    'LBL_DOWNNLOAD_FILE'=> 'Allalaetud fail:',
    'LBL_DET_RELATED_DOCUMENT'=>'Seotud dokument:',
    'LBL_DET_RELATED_DOCUMENT_VERSION'=>"Seotud dokumendi revision:",
    'LBL_DET_IS_TEMPLATE'=>'Mall?:',
    'LBL_DET_TEMPLATE_TYPE'=>'Dokumendi tüüp:',
    'LBL_TEAM'=> 'Meeskond:',
    'LBL_DOC_DESCRIPTION'=>'Kirjeldus:',
    'LBL_DOC_ACTIVE_DATE'=> 'Avaldamiskuupäev:',
    'LBL_DOC_EXP_DATE'=> 'Aegumiskuupäev:',

    //document list view.
    'LBL_LIST_FORM_TITLE' => 'Dokumendi loend',
    'LBL_LIST_DOCUMENT' => 'Dokument',
    'LBL_LIST_CATEGORY' => 'Kategooria',
    'LBL_LIST_SUBCATEGORY' => 'Alamkategooria',
    'LBL_LIST_REVISION' => 'Revisjon',
    'LBL_LIST_LAST_REV_CREATOR' => 'Avaldatud',
    'LBL_LIST_LAST_REV_DATE' => 'Revisjoni kuupäev',
    'LBL_LIST_VIEW_DOCUMENT'=>'Vaade',
    'LBL_LIST_DOWNLOAD'=> 'Lae alla',
    'LBL_LIST_ACTIVE_DATE' => 'Avaldamiskuupäev',
    'LBL_LIST_EXP_DATE' => 'Aegumiskuupäev',
    'LBL_LIST_STATUS'=>'Olek',
    'LBL_LINKED_ID' => 'Lingitud Is',
    'LBL_SELECTED_REVISION_ID' => 'Valitud revisjoni id',
    'LBL_LATEST_REVISION_ID' => 'Viimase revisjon id',
    'LBL_SELECTED_REVISION_FILENAME' => 'Valitud revisjoni failinimi',
    'LBL_FILE_URL' => 'Faili url',
    'LBL_REVISIONS_PANEL' => 'Revisjoni detailid',
    'LBL_REVISIONS_SUBPANEL' => 'Revisjonid',

    //document search form.
    'LBL_SF_DOCUMENT' => 'Dokumendi nimi:',
    'LBL_SF_CATEGORY' => 'Kategooria:',
    'LBL_SF_SUBCATEGORY'=> 'Alamkategooria:',
    'LBL_SF_ACTIVE_DATE' => 'Avaldamiskuupäev:',
    'LBL_SF_EXP_DATE'=> 'Aegumiskuupäev:',

    'DEF_CREATE_LOG' => 'Dokument on loodud',

    //error messages
    'ERR_DOC_NAME'=>'Dokumendi nimi:',
    'ERR_DOC_ACTIVE_DATE'=>'Avaldamiskuupäev',
    'ERR_DOC_EXP_DATE'=> 'Aegumiskuupäev',
    'ERR_FILENAME'=> 'Faili nimi:',
    'ERR_DOC_VERSION'=> 'Dokumendi versioon',
    'ERR_DELETE_CONFIRM'=> 'Kas soovid selle dokumendi revisjoni kustutada?',
    'ERR_DELETE_LATEST_VERSION'=> 'Sul pole lubatud kustutada viimast dokumendi versiooni.',
    'LNK_NEW_MAIL_MERGE' => 'Kirja mestimine',
    'LBL_MAIL_MERGE_DOCUMENT' => 'Kirja mestimise mall:',
    'ERR_MISSING_FILE' => 'This Document is missing a file, most likely due to an error during upload.  Please retry uploading the file or contact your administrator.',

    'LBL_TREE_TITLE' => 'Dokumendid',
    //sub-panel vardefs.
    'LBL_LIST_DOCUMENT_NAME'=>'Dokumendi nimi:',
    'LBL_LIST_IS_TEMPLATE'=>'Mall?',
    'LBL_LIST_TEMPLATE_TYPE'=>'Dokumendi tüüp',
    'LBL_LIST_SELECTED_REVISION'=>'Valitud revisjon',
    'LBL_LIST_LATEST_REVISION'=>'Viimane revisjon',
    'LBL_CONTRACTS_SUBPANEL_TITLE'=>'Seotud lepingud',
    'LBL_LAST_REV_CREATE_DATE'=>'Viimase revisjoni loomiskuupäev',
    //'LNK_DOCUMENT_CAT'=>'Document Categories',
    'LBL_CONTRACTS' => 'Lepingud',
    'LBL_CREATED_USER' => 'Loodud kasutaja',
    'LBL_THEREVISIONS_SUBPANEL_TITLE' => 'Revisjonid',
    'LBL_DOCUMENT_INFORMATION' => 'Dokumendi ülevaade',
    'LBL_DOC_ID' => 'Dokumendi allika ID',
    'LBL_DOC_TYPE' => 'Allikas',
    'LBL_LIST_DOC_TYPE' => 'Allikas',
    'LBL_DOC_TYPE_POPUP' => 'Select a source to which this document will be uploaded<br />and from which it will be available.',
    'LBL_DOC_URL' => 'Dokumendi allika URL',
    'LBL_SEARCH_EXTERNAL_DOCUMENT' => 'Dokumendi nimi',
    'LBL_EXTERNAL_DOCUMENT_NOTE' => 'The first 20 most recently modified files are displayed in descending order in the list below. Use the Search to find other files.',
    'LBL_LIST_EXT_DOCUMENT_NAME' => 'Faili nimi:',
    'ERR_INVALID_EXTERNAL_API_ACCESS' => 'The user attempted to access an invalid external API ({0})',
    'ERR_INVALID_EXTERNAL_API_LOGIN' => 'The login check failed for external API ({0})',

    // Links around the world
    'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Ettevõtted',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontaktid',
    'LBL_OPPORTUNITIES_SUBPANEL_TITLE' => 'Müügivõimalused',
    'LBL_CASES_SUBPANEL_TITLE' => 'Juhtumid',
    'LBL_BUGS_SUBPANEL_TITLE' => 'Bugid',
    'LBL_QUOTES_SUBPANEL_TITLE' => 'Pakkumised',
    'LBL_RLI_SUBPANEL_TITLE' => 'Revenue Line Items',
);
