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
  'ERR_DELETE_RECORD' => 'Du skal angive et postnummer for at slette virksomheden.',
  'ERR_REMOVING_ATTACHMENT' => 'Det lykkedes ikke at fjerne den vedhæftede fil...',
  'LBL_ACCOUNT_ID' => 'Virksomheds-id:',
  'LBL_ACTIVITIES_REPORTS' => 'Aktivitetsrapport',
  'LBL_CASE_ID' => 'Sags-id:',
  'LBL_CLOSE' => 'Luk:',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'Kontakt-id:',
  'LBL_CONTACT_NAME' => 'Kontakt:',
  'LBL_CREATED_BY' => 'Oprettet af',
  'LBL_DATE_ENTERED' => 'Oprettet den',
  'LBL_DATE_MODIFIED' => 'Ændret den',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Noter',
  'LBL_DELETED' => 'Slettet',
  'LBL_DESCRIPTION' => 'Note',
  'LBL_EDITLAYOUT' => 'Rediger layout',
  'LBL_EMAIL_ADDRESS' => 'E-mail-adresse:',
  'LBL_EMAIL_ATTACHMENT' => 'Vedhæftet fil',
  'LBL_EMBED_FLAG' => 'Indsæt i e-mail?',
  'LBL_EXPORT_PARENT_ID' => 'Relateret til id',
  'LBL_EXPORT_PARENT_TYPE' => 'Relateret til modul',
  'LBL_FILENAME' => 'Vedhæftet fil:',
  'LBL_FILE_MIME_TYPE' => 'Mime-type',
  'LBL_FILE_URL' => 'Fil-URL',
  'LBL_FIRST_NAME' => 'Fornavn',
  'LBL_HELP_CREATE' => 'For at oprette en {{MODULE_NAME}}:. 1. Give værdier for felterne som ønsket. - Felter mærket "Required" skal være afsluttet, før du gemmer. - Klik på "Vis mere" for at eksponere yderligere felter, hvis det er nødvendigt. 2.. Klik på "Gem" for at færdiggøre den nye post og vende tilbage til den forrige side. - Vælg "Gem og se" for at åbne den nye {{MODULE_NAME}} i liste visning. - Vælg "Gem og skabe nye" til straks at oprette et nyt {{MODULE_NAME}}.',
  'LBL_HELP_RECORD' => 'Den {{plural_module_name}} modul består af individuel {{plural_module_name}}, der indeholder tekst eller en vedhæftet fil relevant til den relaterede post. - Rediger denne posts felter ved at klikke på et enkelt felt eller på knappen Rediger. - Se eller ændre links til andre poster i underpaneler ved at skifte det nederste venstre rude til "Data View". - Foretag og vis brugernes kommentarer og post ændring historie i {{activitystream_singular_module}} ved at skifte det nederste venstre rude til "Activity Stream". - Følg eller favorisere denne post med ikonerne til højre for posten navn. - Yderligere handlinger er tilgængelige i dropdown menuen Handlinger til højre for knappen Rediger.',
  'LBL_HELP_RECORDS' => 'Den {{plural_module_name}} modul består af individuel {{plural_module_name}}, der indeholder tekst eller en vedhæftet fil relevant til den relaterede post. {{MODULE_NAME}} poster kan relateres til én post i de fleste moduler via flex relatere område og kan også være relateret til et enkelt {{contacts_singular_module}}. {{plural_module_name}} kan holde generisk tekst om en post eller endda en vedhæftet fil relateret til posten. Der er forskellige måder, du kan oprette {{plural_module_name}} i Sugar såsom via {{plural_module_name}} modul, importerer {{plural_module_name}} via Historik underpaneler osv. Når den {{MODULE_NAME}} post er oprettet, du kan se og redigere oplysninger om den {{MODULE_NAME}} via {{plural_module_name}} post liste. Hver {{MODULE_NAME}} post kan så forholde sig til andre Sugar poster, såsom {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, og mange andre.',
  'LBL_LAST_NAME' => 'Efternavn',
  'LBL_LEAD_ID' => 'Kundeemne-id:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Tildelt bruger',
  'LBL_LIST_CONTACT' => 'Kontakt',
  'LBL_LIST_CONTACT_NAME' => 'Kontakt',
  'LBL_LIST_DATE_MODIFIED' => 'Sidst ændret:',
  'LBL_LIST_EDIT_BUTTON' => 'Rediger',
  'LBL_LIST_FILENAME' => 'Vedhæftet fil',
  'LBL_LIST_FORM_TITLE' => 'Noteliste',
  'LBL_LIST_RELATED_TO' => 'Relateret til',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Emne',
  'LBL_MEMBER_OF' => 'Medlem af:',
  'LBL_MODIFIED_BY' => 'Ændret af',
  'LBL_MODULE_NAME' => 'Noter',
  'LBL_MODULE_NAME_SINGULAR' => 'Note',
  'LBL_MODULE_TITLE' => 'Noter: Startside',
  'LBL_MY_NOTES_DASHLETNAME' => 'Mine noter',
  'LBL_NEW_FORM_BTN' => 'Tilføj en note',
  'LBL_NEW_FORM_TITLE' => 'Opret note eller vedhæftet fil',
  'LBL_NOTE' => 'Note:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Vedhæftede filer',
  'LBL_NOTE_INFORMATION' => 'Note oversigt',
  'LBL_NOTE_STATUS' => 'Note',
  'LBL_NOTE_SUBJECT' => 'Noteemne:',
  'LBL_OC_FILE_NOTICE' => 'Log på serveren for at få vist filen',
  'LBL_OPPORTUNITY_ID' => 'Salgsmuligheds-id:',
  'LBL_PANEL_DETAILS' => 'Detaljer',
  'LBL_PARENT_ID' => 'Overordnet id:',
  'LBL_PARENT_TYPE' => 'Overordnet type',
  'LBL_PHONE' => 'Telefon:',
  'LBL_PORTAL_FLAG' => 'Vis i portal?',
  'LBL_PRODUCT_ID' => 'Produkt-id:',
  'LBL_QUOTE_ID' => 'Tilbuds-id:',
  'LBL_RELATED_TO' => 'Relateret til:',
  'LBL_REMOVING_ATTACHMENT' => 'Fjerner vedhæftet fil...',
  'LBL_REVENUELINEITEMS' => 'Omsætningsposter',
  'LBL_SEARCH_FORM_TITLE' => 'Søg efter note',
  'LBL_SEND_ANYWAYS' => 'Denne e-mail har intet emne. Vil du sende/gemme alligevel?',
  'LBL_STATUS' => 'Status',
  'LBL_SUBJECT' => 'Emne:',
  'LNK_IMPORT_NOTES' => 'Importér noter',
  'LNK_NEW_NOTE' => 'Opret note eller vedhæftet fil',
  'LNK_NOTE_LIST' => 'Noter',
);

