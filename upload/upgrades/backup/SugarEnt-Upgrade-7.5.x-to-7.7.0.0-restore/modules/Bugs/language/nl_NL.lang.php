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
  'ERR_DELETE_RECORD' => 'U dient een recordnummer op te geven om de bug te verwijderen.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Organisaties',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activiteiten',
  'LBL_ASSIGNED_TO_NAME' => 'Toegewezen aan',
  'LBL_BUG' => 'Bug:',
  'LBL_BUG_INFORMATION' => 'Bug Overzicht',
  'LBL_BUG_NUMBER' => 'Bug nummer:',
  'LBL_BUG_SUBJECT' => 'Bug onderwerp:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Cases',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Personen',
  'LBL_CONTACT_BUG_TITLE' => 'Contact voor Bug:',
  'LBL_CONTACT_NAME' => 'Contactpersoon:',
  'LBL_CONTACT_ROLE' => 'Rol:',
  'LBL_CREATED_BY' => 'Aangemaakt door:',
  'LBL_DATE_CREATED' => 'Aangemaakt op:',
  'LBL_DATE_LAST_MODIFIED' => 'Datum gewijzigd:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Naspeuring',
  'LBL_DESCRIPTION' => 'Beschrijving:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documenten',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Toegewezen aan ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Toegewezen aan',
  'LBL_EXPORT_CREATED_BY' => 'Gemaakt door ID',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Gerepareerd in Release',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Gewijzigd door ID',
  'LBL_FIXED_IN_RELEASE' => 'Opgelost in Release',
  'LBL_FOUND_IN_RELEASE' => 'Gevonden in Release',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Gevonden In Release',
  'LBL_HELP_CREATE' => 'De {{plural_module_name}} module wordt gebruikt om product gerelateerde problemen te volgen en te beheren. Deze zogenaamde {{plural_module_name}} of defecten, kunnen ofwel door de intern organisatie gevonden zijn of door klanten gemeld zijn.

Om een {{module_name}} aan te maken:
1. Voer de gewenste gegevens in.
- Velden die "verplicht" zijn, moeten ingevuld zijn voordat het record opgeslagen kan worden.
- Klik op "Toon meer" om extra velden te tonen.
2. Klik op "Opslaan" om het record op te slaan en terug te keren naar de voorgaande pagina.
- Kies "Sla op en bekijk" om de nieuwe {{module_name}} in record view te bekijken.
- Kies "Sla op en maak nieuwe aan" om direct een nieuwe {{module_name}} aan te maken.',
  'LBL_HELP_RECORD' => 'De {{plural_module_name}} module wordt gebruikt om product gerelateerde problemen te volgen en te beheren. Deze zogenaamde {{plural_module_name}} of defecten, kunnen ofwel door de intern organisatie gevonden zijn of door klanten gemeld zijn.

- Pas de gegevens aan door op een individueel veld of op de Wijzigen knop te klikken.
- Bekijk of pas koppelingen met andere records aan in de subpanels door de "Data View" in te schakelen in het paneel linksonder..
- Maak en bekijk opmerkingen van gebruikers en de wijzigingshistorie in de {{activitystream_singular_module}} door "Activity Stream" in te schakelen in het paneel linksonder.
- Volg of maak het record favoriet door gebruik te maken van de icoontjes rechts naast de naam van het record.
- Extra acties zijn beschikbaar via het dropdown actie menu rechts naast de Wijzigen knop.',
  'LBL_HELP_RECORDS' => 'De {{plural_module_name}} module wordt gebruikt om product gerelateerde problemen te volgen en te beheren. Deze zogenaamde {{plural_module_name}} of defecten, kunnen ofwel door de intern organisatie gevonden zijn of door klanten gemeld zijn. De {{plural_module_name}} kan benut worden door "gevonden in release" en "opgelost in release" bij te houden. De {{plural_module_name}} module stelt gebruikers in staat om snel de details van de {{module_name}} en het proces om deze te herstellen te analyseren. Als een {{module_name}} record is aangemaakt, kunt u deze bekijken en de gegevens behorende bij deze {{module_name}} aanpassen via de {{plural_module_name}} record view. Elk {{module_name}} record kan gekoppeld zijn aan andere Sugar records zoals {{calls_module}}, {{contacts_module}}, {{cases_module}}, en vele andere.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historie',
  'LBL_INVITEE' => 'Personen',
  'LBL_LIST_ACCOUNT_NAME' => 'Organisatienaam',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Toegewezen aan',
  'LBL_LIST_CONTACT_NAME' => 'Contactpersoon',
  'LBL_LIST_EMAIL_ADDRESS' => 'E-mailadres',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Opgelost in Release',
  'LBL_LIST_FORM_TITLE' => 'Bug lijst',
  'LBL_LIST_LAST_MODIFIED' => 'Datum gewijzigd',
  'LBL_LIST_MY_BUGS' => 'Mijn Openstaande Bugs',
  'LBL_LIST_NUMBER' => 'Nr.',
  'LBL_LIST_PHONE' => 'Telefoon',
  'LBL_LIST_PRIORITY' => 'Prioriteit',
  'LBL_LIST_RELEASE' => 'Release',
  'LBL_LIST_RESOLUTION' => 'Oplossing',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Onderwerp',
  'LBL_LIST_TYPE' => 'Type',
  'LBL_MODIFIED_BY' => 'Laatste wijziging door:',
  'LBL_MODULE_ID' => 'Bugs',
  'LBL_MODULE_NAME' => 'Bugs',
  'LBL_MODULE_NAME_SINGULAR' => 'Bug',
  'LBL_MODULE_TITLE' => 'Bug Tracker: Start',
  'LBL_NEW_FORM_TITLE' => 'Nieuwe Bug',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notities',
  'LBL_NUMBER' => 'Nummer:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Als u een nieuwe bug heeft gevonden, kunt u hier klikken om deze te melden.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'U kunt de lijst met bugs filteren door een zoekterm op te geven.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Bijvoorbeeld, u kunt dit gebruiken om een eerder gemelde bug terug te vinden.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'In de Bugs module kunt u bugs bekijken en opvoeren. Gebruik de pijltjes om te navigeren door de snelle rondleiding.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Deze pagina toont een momentopname van de bestaande gepubliceerde bugs.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Door hier te klikken kunt u altijd terugkeren naar deze weergave.',
  'LBL_PORTAL_VIEWABLE' => 'Portal Zichtbaar',
  'LBL_PRIORITY' => 'Prioriteit:',
  'LBL_PRODUCT_CATEGORY' => 'Productcategorie',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projecten',
  'LBL_RELEASE' => 'Release:',
  'LBL_RESOLUTION' => 'Oplossing:',
  'LBL_SEARCH_FORM_TITLE' => 'Bug zoeken',
  'LBL_SHOW_IN_PORTAL' => 'Toon in portal',
  'LBL_SHOW_MORE' => 'Toon meer Bugs',
  'LBL_SOURCE' => 'Bron',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Onderwerp:',
  'LBL_SYSTEM_ID' => 'Systeem ID',
  'LBL_TYPE' => 'Type:',
  'LBL_WORK_LOG' => 'Logbestand',
  'LNK_BUG_LIST' => 'Bekijk Bugs',
  'LNK_BUG_REPORTS' => 'Bekijk Bug Rapporten',
  'LNK_CREATE' => 'Meld Bug',
  'LNK_CREATE_WHEN_EMPTY' => 'Meld een nieuwe Bug',
  'LNK_IMPORT_BUGS' => 'Importeer Bugs',
  'LNK_NEW_BUG' => 'Bug melden',
  'NTC_DELETE_CONFIRMATION' => 'Weet u zeker dat u deze persoon wilt verwijderen bij deze Bug?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Weet u zeker dat u deze bug wilt verwijderen bij deze organisatie?',
  'NTC_REMOVE_INVITEE' => 'Weet u zeker dat u deze persoon wilt verwijderen bij deze Bug?',
);

