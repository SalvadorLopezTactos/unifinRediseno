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
  'DATE_FORMAT' => '(åååå-mm-dd)',
  'ERR_DELETE_RECORD' => 'Ett objektnummer måste specificeras för att kunna radera kontakten.',
  'ERR_INVALID_HOUR' => 'Var god fyll i en timme mellan 0 och 24.',
  'LBL_ACTIVITIES_REPORTS' => 'Aktivitetsrapport',
  'LBL_ASSIGNED_TO_NAME' => 'Tilldelad till:',
  'LBL_ASSIGNED_USER' => 'Tilldelad till',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Kontakt:',
  'LBL_CONTACT_FIRST_NAME' => 'Kontaktens förnamn',
  'LBL_CONTACT_ID' => 'Kontakt ID:',
  'LBL_CONTACT_LAST_NAME' => 'Kontaktens efternamn',
  'LBL_CONTACT_NAME' => 'Kontaktnamn:',
  'LBL_CONTACT_PHONE' => 'Kontakt Telefon:',
  'LBL_DATE_DUE' => 'Genomförandedatum',
  'LBL_DATE_DUE_FLAG' => 'Inget genomförandedatum',
  'LBL_DATE_START_FLAG' => 'Inget startdatum',
  'LBL_DEFAULT_PRIORITY' => 'Medium',
  'LBL_DESCRIPTION' => 'Beskrivning:',
  'LBL_DESCRIPTION_INFORMATION' => 'Beskrivande information',
  'LBL_DUE_DATE' => 'Genomförandedatum:',
  'LBL_DUE_DATE_AND_TIME' => 'Genomförandedatum & tid:',
  'LBL_DUE_TIME' => 'Genomförandetid:',
  'LBL_EDITLAYOUT' => 'Redigera layout',
  'LBL_EMAIL' => 'Epost:',
  'LBL_EMAIL_ADDRESS' => 'Epostadress:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Tilldelad Användar ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Tilldelat Användarnamn',
  'LBL_EXPORT_CREATED_BY' => 'Skapad av ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Ändrad av ID',
  'LBL_EXPORT_PARENT_ID' => 'Relaterad Till ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Relaterad Till Modul',
  'LBL_HELP_CREATE' => '{{plural_module_name}} modul består av flexibla åtgärder, att göra-poster, eller annan typ av verksamhet som kräver slutförande. För att skapa en {{module}}: 1 För in värden för fälten som önskat. 
- Fält markerade "Required" måste fyllas i innan du sparar. - Klicka på "Visa mer" för att visa ytterligare fält vid behov. 2 Klicka på "Spara" för att spara och återgå till föregående sidan. - Välj "Spara och visa" för att öppna den nya {{module}}. - Välj "Spara och skapa ny" för att omedelbart skapa en annan ny {{module}}.',
  'LBL_HELP_RECORD' => '{{plural_module_name}}-modul består av flexibla åtgärder, att göra-poster, eller annan typ av verksamhet som kräver slutförande.  Redigera denna postens fält genom att klicka ett enskilt fält eller på knappen Redigera.  - Visa eller ändra länkar till andra poster i underpaneler, även {{campaigns_singular_module}} mottagare, genom att växla den nedre vänstra rutan till "Data View". 
- Utför och se användarkommentarer och eller se förändringar i {{activitystream_singular_module}} genom att växla den nedre vänstra rutan på "Activity Stream". - Följ som favorit med hjälp av ikonerna till höger om namnet. - Ytterligare åtgärder finns i dropdown menyn Åtgärder till höger om knappen Redigera.',
  'LBL_HELP_RECORDS' => '{{plural_module_name}} modul består av flexibla åtgärder, att göra-poster, eller annan typ av verksamhet som kräver slutförande. {{module}}poster kan relateras till en post i de flesta moduler via flex rör området och kan också vara relaterade till en enda {{contacts_singular_module}}. Det finns olika sätt som du kan skapa {{plural_module_name}} i Sugar exempel via {{plural_module_name}} modul, dubbelarbete, importera {{plural_module_name}}, etc. När en {{module}}post skapas, kan du visa och redigera information som hänför sig till {{module}} via {{plural_module_name}}vyn. Beroende på detaljer om {{module}}, du kan också ha möjlighet att visa och redigera {{module}} information via kalendermodulen. Varje {{module}}post kan då avse andra Sugar dokument såsom {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, och många andra.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Anteckningar:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Tilldelad användare',
  'LBL_LIST_CLOSE' => 'Stäng',
  'LBL_LIST_COMPLETE' => 'Färdig:',
  'LBL_LIST_CONTACT' => 'Kontakt',
  'LBL_LIST_DATE_MODIFIED' => 'Datum ändrat',
  'LBL_LIST_DUE_DATE' => 'Genomförandedatum',
  'LBL_LIST_DUE_TIME' => 'Genomförandetid',
  'LBL_LIST_FORM_TITLE' => 'Lista uppgifter',
  'LBL_LIST_MY_TASKS' => 'Mina öppna uppgifter',
  'LBL_LIST_PRIORITY' => 'Prioritet',
  'LBL_LIST_RELATED_TO' => 'Relaterad till',
  'LBL_LIST_START_DATE' => 'Startdatum',
  'LBL_LIST_START_TIME' => 'Starttid',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Ämne',
  'LBL_MODULE_NAME' => 'Uppgifter',
  'LBL_MODULE_NAME_SINGULAR' => 'Uppgift',
  'LBL_MODULE_TITLE' => 'Uppgifter: Hem',
  'LBL_NAME' => 'Namn:',
  'LBL_NEW_FORM_DUE_DATE' => 'Genomförandedatum:',
  'LBL_NEW_FORM_DUE_TIME' => 'Genomförandetid:',
  'LBL_NEW_FORM_SUBJECT' => 'Ämne:',
  'LBL_NEW_FORM_TITLE' => 'Skapa uppgift',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Ingen',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Anteckningar',
  'LBL_PARENT_ID' => 'Förälder ID:',
  'LBL_PARENT_NAME' => 'Föräldertyp:',
  'LBL_PHONE' => 'Telefon:',
  'LBL_PRIORITY' => 'Prioritet:',
  'LBL_REVENUELINEITEMS' => 'Intäktsposter',
  'LBL_SEARCH_FORM_TITLE' => 'Sök uppgift',
  'LBL_START_DATE' => 'Startdatum:',
  'LBL_START_DATE_AND_TIME' => 'Startdatum & tid:',
  'LBL_START_TIME' => 'Starttid:',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Ämne:',
  'LBL_TASK' => 'Uppgifter:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Uppgift stängde med framgång.',
  'LBL_TASK_INFORMATION' => 'Uppgifter översikt',
  'LNK_IMPORT_TASKS' => 'Importera uppgifter',
  'LNK_NEW_TASK' => 'Skapa uppgift',
  'LNK_TASK_LIST' => 'Uppgifter',
);

