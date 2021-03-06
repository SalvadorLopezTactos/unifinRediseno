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
  'DEF_CREATE_LOG' => 'Dokument oprettet',
  'ERR_DELETE_CONFIRM' => 'Vil du slette denne dokumentrevision?',
  'ERR_DELETE_LATEST_VERSION' => 'Du har ikke tilladelse til at slette den seneste revision af et dokument.',
  'ERR_DOC_ACTIVE_DATE' => 'Udgivelsesdato',
  'ERR_DOC_EXP_DATE' => 'Udløbsdato',
  'ERR_DOC_NAME' => 'Dokumentnavn',
  'ERR_DOC_VERSION' => 'Dokumentversion',
  'ERR_FILENAME' => 'Filnavn',
  'ERR_INVALID_EXTERNAL_API_ACCESS' => 'Brugeren forsøgte at tilgå et ugyldigt eksternt API ({0})',
  'ERR_INVALID_EXTERNAL_API_LOGIN' => 'Login tjek for det eksterne API ({0}) fejlede',
  'ERR_MISSING_FILE' => 'Dokumentet mangler en fil. Dette skyldes sandsynligvis en fejl under upload. Venligst forsøg at uploade filen igen eller kontakt system administratoren.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Virksomheder',
  'LBL_ACTIVE_DATE' => 'Udgivelsesdato',
  'LBL_ASSIGNED_TO_NAME' => 'Tildelt til:',
  'LBL_BUGS_SUBPANEL_TITLE' => 'Fejl',
  'LBL_CASES_SUBPANEL_TITLE' => 'Sager',
  'LBL_CATEGORY' => 'Kategori',
  'LBL_CATEGORY_VALUE' => 'Kategori:',
  'LBL_CAT_OR_SUBCAT_UNSPEC' => 'Uspecificeret',
  'LBL_CHANGE_LOG' => 'Ændringslog',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakter',
  'LBL_CONTRACTS' => 'Kontrakter',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Relaterede kontrakter',
  'LBL_CONTRACT_NAME' => 'Kontraktnavn:',
  'LBL_CONTRACT_STATUS' => 'Kontrakt status:',
  'LBL_CREATED' => 'Oprettet af',
  'LBL_CREATED_BY' => 'Oprettet af',
  'LBL_CREATED_USER' => 'Oprettet bruger',
  'LBL_DATE_ENTERED' => 'Oprettet den',
  'LBL_DATE_MODIFIED' => 'Ændret den',
  'LBL_DELETED' => 'Slettet',
  'LBL_DESCRIPTION' => 'Beskrivelse',
  'LBL_DET_IS_TEMPLATE' => 'Skabelon? :',
  'LBL_DET_RELATED_DOCUMENT' => 'Relateret dokument:',
  'LBL_DET_RELATED_DOCUMENT_VERSION' => 'Relateret dokumentrevision:',
  'LBL_DET_TEMPLATE_TYPE' => 'Dokumenttype:',
  'LBL_DOCUMENT' => 'Relateret dokument',
  'LBL_DOCUMENT_ID' => 'Dokument-id',
  'LBL_DOCUMENT_INFORMATION' => 'Dokument oversigt',
  'LBL_DOCUMENT_NAME' => 'Dokumentnavn',
  'LBL_DOCUMENT_REVISION_ID' => 'Dokument revisions-id',
  'LBL_DOC_ACTIVE_DATE' => 'Udgivelsesdato:',
  'LBL_DOC_DESCRIPTION' => 'Beskrivelse:',
  'LBL_DOC_EXP_DATE' => 'Udløbsdato:',
  'LBL_DOC_ID' => 'Dokument kilde id',
  'LBL_DOC_NAME' => 'Dokumentnavn:',
  'LBL_DOC_REV_HEADER' => 'Dokumentrevisioner',
  'LBL_DOC_STATUS' => 'Status:',
  'LBL_DOC_STATUS_ID' => 'Status Id:',
  'LBL_DOC_TYPE' => 'Kilde',
  'LBL_DOC_TYPE_POPUP' => 'Vælg en kilde, som dette dokument vil blive uploadet fra,<br />og hvorfra det vil være til rådighed.',
  'LBL_DOC_URL' => 'Dokument kilde URL',
  'LBL_DOC_VERSION' => 'Revision:',
  'LBL_DOWNNLOAD_FILE' => 'Download fil:',
  'LBL_EXPIRATION_DATE' => 'Udløbsdato',
  'LBL_EXTERNAL_DOCUMENT_NOTE' => 'De 20 sidst modificeret filer i aftagende orden i listen nedenfor. Brug Søg for at finde andre filer.',
  'LBL_FILENAME' => 'Filnavn:',
  'LBL_FILE_EXTENSION' => 'Filtype',
  'LBL_FILE_UPLOAD' => 'Fil:',
  'LBL_FILE_URL' => 'Fil-URL',
  'LBL_HOMEPAGE_TITLE' => 'Mine dokumenter',
  'LBL_IS_TEMPLATE' => 'Er en skabelon',
  'LBL_LASTEST_REVISION_NAME' => 'Sidste revisionsnavn:',
  'LBL_LAST_REV_CREATE_DATE' => 'Seneste revisions oprettelsesdato',
  'LBL_LAST_REV_CREATOR' => 'Revision oprettet af:',
  'LBL_LAST_REV_DATE' => 'Revisionsdato:',
  'LBL_LAST_REV_MIME_TYPE' => 'Sidste reviderede MIME type',
  'LBL_LATEST_REVISION' => 'Seneste revision',
  'LBL_LATEST_REVISION_ID' => 'Sidste revision id',
  'LBL_LINKED_ID' => 'Linket id',
  'LBL_LIST_ACTIVE_DATE' => 'Udgivelsesdato',
  'LBL_LIST_CATEGORY' => 'Kategori',
  'LBL_LIST_DOCUMENT' => 'Dokument',
  'LBL_LIST_DOCUMENT_NAME' => 'Dokumentnavn',
  'LBL_LIST_DOC_TYPE' => 'Kilde',
  'LBL_LIST_DOWNLOAD' => 'Download',
  'LBL_LIST_EXP_DATE' => 'Udløbsdato',
  'LBL_LIST_EXT_DOCUMENT_NAME' => 'Filnavn',
  'LBL_LIST_FILENAME' => 'Filnavn',
  'LBL_LIST_FORM_TITLE' => 'Dokumentliste',
  'LBL_LIST_IS_TEMPLATE' => 'Skabelon?',
  'LBL_LIST_LAST_REV_CREATOR' => 'Udgivet af',
  'LBL_LIST_LAST_REV_DATE' => 'Revisionsdato',
  'LBL_LIST_LATEST_REVISION' => 'Seneste revision',
  'LBL_LIST_REVISION' => 'Revision',
  'LBL_LIST_SELECTED_REVISION' => 'Valgt revision',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBCATEGORY' => 'Underkategori',
  'LBL_LIST_TEMPLATE_TYPE' => 'Dokumenttype',
  'LBL_LIST_VIEW_DOCUMENT' => 'Vis',
  'LBL_MAIL_MERGE_DOCUMENT' => 'Brevfletningsskabelon:',
  'LBL_MIME' => 'Mime-type',
  'LBL_MODIFIED' => 'Ændret af id',
  'LBL_MODIFIED_USER' => 'Ændret af',
  'LBL_MODULE_NAME' => 'Dokumenter',
  'LBL_MODULE_NAME_SINGULAR' => 'Dokument',
  'LBL_MODULE_TITLE' => 'Dokumenter: Startside',
  'LBL_NAME' => 'Dokumentnavn',
  'LBL_NEW_FORM_TITLE' => 'Nyt dokument',
  'LBL_OPPORTUNITIES_SUBPANEL_TITLE' => 'Salgsmuligheder',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Tilbud',
  'LBL_RELATED_DOCUMENT_ID' => 'Relateret dokument-id',
  'LBL_RELATED_DOCUMENT_REVISION_ID' => 'Relateret dokumentrevisions-id',
  'LBL_REVISION' => 'Revision',
  'LBL_REVISIONS' => 'Revisioner',
  'LBL_REVISIONS_PANEL' => 'Revision detaljer',
  'LBL_REVISIONS_SUBPANEL' => 'Revisioner',
  'LBL_REVISION_NAME' => 'Revisionsnummer',
  'LBL_RLI_SUBPANEL_TITLE' => 'Revenue Line Items',
  'LBL_SEARCH_EXTERNAL_DOCUMENT' => 'Dokumentnavn',
  'LBL_SEARCH_FORM_TITLE' => 'Søg efter dokument',
  'LBL_SELECTED_REVISION_FILENAME' => 'Valgt revision filnavn',
  'LBL_SELECTED_REVISION_ID' => 'Vælg revision id',
  'LBL_SELECTED_REVISION_NAME' => 'Navn på valgt revision',
  'LBL_SF_ACTIVE_DATE' => 'Udgivelsesdato:',
  'LBL_SF_CATEGORY' => 'Kategori:',
  'LBL_SF_DOCUMENT' => 'Dokumentnavn:',
  'LBL_SF_EXP_DATE' => 'Udløbsdato:',
  'LBL_SF_SUBCATEGORY' => 'Underkategori:',
  'LBL_STATUS' => 'Status',
  'LBL_SUBCATEGORY' => 'Underkategori',
  'LBL_SUBCATEGORY_VALUE' => 'Underkategori:',
  'LBL_TEAM' => 'Team:',
  'LBL_TEMPLATE_TYPE' => 'Dokumenttype',
  'LBL_THEREVISIONS_SUBPANEL_TITLE' => 'Genindlæsninger',
  'LBL_TREE_TITLE' => 'Dokumenter',
  'LNK_DOCUMENT_LIST' => 'Dokumentliste',
  'LNK_NEW_DOCUMENT' => 'Opret dokument',
  'LNK_NEW_MAIL_MERGE' => 'Brevfletning',
);

