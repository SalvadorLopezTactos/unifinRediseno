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
  'DATE_FORMAT' => '(jjjj-mm-dd)',
  'ERR_DELETE_RECORD' => 'U dient een recordnummer op te geven om dit record te kunnen verwijderen',
  'ERR_INVALID_HOUR' => 'Voer hier a.u.b een uur in tussen 0 en 24',
  'LBL_ACTIVITIES_REPORTS' => 'Activiteitenrapport',
  'LBL_ASSIGNED_TO_NAME' => 'Toegewezen aan:',
  'LBL_ASSIGNED_USER' => 'Toegewezen aan',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Persoon:',
  'LBL_CONTACT_FIRST_NAME' => 'Voornaam persoon',
  'LBL_CONTACT_ID' => 'ID Persoon',
  'LBL_CONTACT_LAST_NAME' => 'Achternaam persoon',
  'LBL_CONTACT_NAME' => 'Naam Persoon:',
  'LBL_CONTACT_PHONE' => 'Telefoonnummer persoon',
  'LBL_DATE_DUE' => 'Vervaldatum',
  'LBL_DATE_DUE_FLAG' => 'Geen einddatum',
  'LBL_DATE_START_FLAG' => 'Geen aanvangsdatum',
  'LBL_DEFAULT_PRIORITY' => 'Middel',
  'LBL_DESCRIPTION' => 'Omschrijving:',
  'LBL_DESCRIPTION_INFORMATION' => 'Omschrijving',
  'LBL_DUE_DATE' => 'Einddatum:',
  'LBL_DUE_DATE_AND_TIME' => 'Einddatum & tijd:',
  'LBL_DUE_TIME' => 'Eindtijd:',
  'LBL_EDITLAYOUT' => 'Wijzig weergave',
  'LBL_EMAIL' => 'E-mailadres:',
  'LBL_EMAIL_ADDRESS' => 'E-mailadres',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Toegewezen aan ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Toegewezen aan',
  'LBL_EXPORT_CREATED_BY' => 'Aangemaakt door ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Gewijzigd door ID',
  'LBL_EXPORT_PARENT_ID' => 'Gerelateerd aan ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Gerelateerd aan module',
  'LBL_HELP_CREATE' => 'The {{plural_module_name}} module bestaat uit flexibele acties, to-do items, of andere activiteiten die uitgevoerd moeten worden.

Om een {{module_name}} aan te maken:
1. Voer de gewenste gegevens in.
 - Velden die "verplicht" zijn, moeten ingevuld zijn voordat het record opgeslagen kan worden.
 - Klik op "Toon meer" om extra velden te tonen.
2. Klik op "Opslaan" om het record op te slaan en terug te keren naar de voorgaande pagina.
 - Kies "Sla op en bekijk" om de nieuwe {{module_name}} in record view te bekijken.
 - Kies "Sla op en maak nieuwe aan" om direct een nieuwe {{module_name}} aan te maken.',
  'LBL_HELP_RECORD' => 'De {{plural_module_name}} module bestaat uit flexibele acties, to-do items, of andere activiteiten die uitgevoerd moeten worden.

- Pas de gegevens aan door op een individueel veld of op de Wijzigen knop te klikken.
- Bekijk of pas koppelingen met andere records aan in de subpanels door de "Data View" in te schakelen in het paneel linksonder..
- Maak en bekijk opmerkingen van gebruikers en de wijzigingshistorie door "Activity Stream" in te schakelen in het paneel linksonder.
- Volg of maak het record favoriet door gebruik te maken van de icoontjes rechts naast de naam van het record.
- Extra acties zijn beschikbaar via het dropdown actie menu rechts naast de Wijzigen knop.',
  'LBL_HELP_RECORDS' => 'De {{plural_module_name}} module bestaat uit flexibele acties, to-do items, of andere activiteiten die uitgevoerd moeten worden. {{module_name}} records kunnen gekoppeld worden aan een record in de meeste modules door middel van het flex relate veld en kan ook gekoppeld worden aan een enkel {{contacts_singular_module}}. Er zijn meerdere manieren waarop u een {{plural_module_name}} in Sugar kunt aanmaken, zoals bijvoorbeeld via de {{plural_module_name}} module, door te kopiëren, importeren van {{plural_module_name}}, etc. Zo een {{module_name}} is aangemaakt, kunt u deze bekijken en de gegevens behorende bij de {{module_name}} aanpassen via de {{plural_module_name}} record view. Afhankelijk van de gegevens van de {{module_name}}, kunt u de gegevens van de {{module_name}} ook aanpassen via de Calendar module. Elk {{module_name}} record kan gekoppeld worden aan andere Sugar records zoals bijvoorbeeld {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, en vele anderen.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Notities',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Toegewezen aan',
  'LBL_LIST_CLOSE' => 'Sluiten',
  'LBL_LIST_COMPLETE' => 'Afgerond:',
  'LBL_LIST_CONTACT' => 'Persoon',
  'LBL_LIST_DATE_MODIFIED' => 'Datum gewijzigd',
  'LBL_LIST_DUE_DATE' => 'Einddatum',
  'LBL_LIST_DUE_TIME' => 'Eindtijd',
  'LBL_LIST_FORM_TITLE' => 'Takenlijst',
  'LBL_LIST_MY_TASKS' => 'Mijn Openstaande Taken',
  'LBL_LIST_PRIORITY' => 'Prioriteit',
  'LBL_LIST_RELATED_TO' => 'Gerelateerd aan',
  'LBL_LIST_START_DATE' => 'Aanvangsdatum:',
  'LBL_LIST_START_TIME' => 'Aanvangstijd:',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Onderwerp',
  'LBL_MODULE_NAME' => 'Taken',
  'LBL_MODULE_NAME_SINGULAR' => 'Taak',
  'LBL_MODULE_TITLE' => 'Taken: Home',
  'LBL_NAME' => 'Naam:',
  'LBL_NEW_FORM_DUE_DATE' => 'Einddatum:',
  'LBL_NEW_FORM_DUE_TIME' => 'Eindtijd:',
  'LBL_NEW_FORM_SUBJECT' => 'Onderwerp:',
  'LBL_NEW_FORM_TITLE' => 'Nieuwe Taak',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Geen',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notities',
  'LBL_PARENT_ID' => 'Bovenliggende ID',
  'LBL_PARENT_NAME' => 'Bovenliggend Type:',
  'LBL_PHONE' => 'Telefoon:',
  'LBL_PRIORITY' => 'Prioriteit:',
  'LBL_REVENUELINEITEMS' => 'Opportunityregels',
  'LBL_SEARCH_FORM_TITLE' => 'Taken Zoeken',
  'LBL_START_DATE' => 'Aanvangsdatum:',
  'LBL_START_DATE_AND_TIME' => 'Aanvangsdatum & tijd:',
  'LBL_START_TIME' => 'Aanvangstijd:',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Onderwerp:',
  'LBL_TASK' => 'Taken:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Taak succesvol afgesloten.',
  'LBL_TASK_INFORMATION' => 'Overzicht',
  'LNK_IMPORT_TASKS' => 'Importeer taken',
  'LNK_NEW_TASK' => 'Nieuwe Taak',
  'LNK_TASK_LIST' => 'Bekijk Taken',
);

