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
  'ERR_DELETE_RECORD' => 'Die Datensatznummer muss angegeben werden um diesen Datensatz löschen zu können.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Firmen',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivitäten',
  'LBL_ASSIGNED_TO_NAME' => 'Zugewiesen an',
  'LBL_BUG' => 'Fehler:',
  'LBL_BUG_INFORMATION' => 'Übersicht Fehler',
  'LBL_BUG_NUMBER' => 'Fehlernummer:',
  'LBL_BUG_SUBJECT' => 'Betreff:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Tickets',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakte',
  'LBL_CONTACT_BUG_TITLE' => 'Kontakt-Fehler:',
  'LBL_CONTACT_NAME' => 'Name:',
  'LBL_CONTACT_ROLE' => 'Beruf:',
  'LBL_CREATED_BY' => 'Erstellt von:',
  'LBL_DATE_CREATED' => 'Erstelldatum:',
  'LBL_DATE_LAST_MODIFIED' => 'Geändert am:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Fehlerverfolgung',
  'LBL_DESCRIPTION' => 'Beschreibung:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumente',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Zugewiesen an',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Zugewiesen Benutzer',
  'LBL_EXPORT_CREATED_BY' => 'Ersteller',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'In der folgender Release gefixt',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Bearbeiter',
  'LBL_FIXED_IN_RELEASE' => 'Behoben in Release',
  'LBL_FOUND_IN_RELEASE' => 'Gefunden in Release',
  'LBL_FOUND_IN_RELEASE_NAME' => 'in der folgende Release gefunden',
  'LBL_HELP_CREATE' => 'Das {{plural_module_name}} Modul wird verwendet um Produktrelevante Probleme zu erfassen, die häufig auch als {{plural_module_name}} oder Defekte bezeichnet werden.
1. Erfassen Sie alle relevanten Informationen. - Felder die als Pflichtfeld markiert sind müssen ausgefüllt werden um den Datensatz speichern zu können. - Klicken Sie auf "mehr zeigen" um weitere Felder zu erfassen. 2. Drücken Sie auf "Speichern" um den Datensatz verfügbar zu machen und um auf die letzte Seite zurück zu kommen. - Wählen Sie "Speichern und Öffnen" um den neuen {{module_name}} in der Datensatzansicht zu öffnen. - Wählen Sie "Speichern und neuen Datensatz erstellen" um sofort einen weiteren {{module_name}} Datensatz anzulegen.',
  'LBL_HELP_RECORD' => 'Das {{plural_module_name}} Modul wird verwendet um Produktrelevante Probleme zu erfassen, die häufig auch als {{plural_module_name}} oder Defekte bezeichnet werden
- Bearbeiten Sie den Datensatz indem sie auf ein Feld klicken oder auf die Bearbeiten Schaltfläche.
- Sehen Sie sich in der Vorschau Verknüpfungen zu anderen Datensätzen an. Klicken Sie im Subpanel entsprechend auf das Vorschausymbol klicken.
- Erstellen oder sehen Sie sich Benutzerkommentare und die Änderungshistorie verschiedener Datensätze im  {{activitystream_singular_module}} an indem Sie die Sicht auf "Activity Stream" im unteren linken Bereich stellen. 
- Folgen Sie favorisierten Einträgen indem Sie das Sternsymbol neben dem Namen oben anklicken. 
- Weitere Aktionen finden Sie im Ausklappmenü auf der rechten Seite der Bearbeiten Schaltfläche.',
  'LBL_HELP_RECORDS' => 'Das {{plural_module_name}} Modul wird verwendet um Produktrelevante Probleme zu erfassen, die häufig auch als {{plural_module_name}} oder Defekte bezeichnet werden. Diese können sowohl intern als auch von Kunden gemeldet werden. Das {{plural_module_name}} kann auch verwendet werden um das Auftreten und das Beheben des Problems in einem bestimmten Release zu verwalten. Das {{plural_module_name}} gibt Benutzern die Möglichkeit schnell alle Detailinformationen zu erfassen und den weiterführenden Prozess zu verfolgen wann das Problem behoben ist. Sobald der {{module_name}} erstellt ist, können Informationen in der Datenansicht eingesehen und editiert werden. Jeder {{module_name}} kann mit einem anderen Sugar Datensatz wie {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, und viele andere verknüpft werden.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Verlauf',
  'LBL_INVITEE' => 'Kontakte',
  'LBL_LIST_ACCOUNT_NAME' => 'Firmenname',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Zugew. Benutzer',
  'LBL_LIST_CONTACT_NAME' => 'Kontakt:',
  'LBL_LIST_EMAIL_ADDRESS' => 'E-Mail Adresse',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Behoben in Release',
  'LBL_LIST_FORM_TITLE' => 'Fehler Liste',
  'LBL_LIST_LAST_MODIFIED' => 'Geändert am:',
  'LBL_LIST_MY_BUGS' => 'Meine offenen Fehler',
  'LBL_LIST_NUMBER' => 'Num.',
  'LBL_LIST_PHONE' => 'Telefon',
  'LBL_LIST_PRIORITY' => 'Priorität',
  'LBL_LIST_RELEASE' => 'Release',
  'LBL_LIST_RESOLUTION' => 'Lösung:',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Betreff',
  'LBL_LIST_TYPE' => 'Typ:',
  'LBL_MODIFIED_BY' => 'Geändert von:',
  'LBL_MODULE_ID' => 'Fehler',
  'LBL_MODULE_NAME' => 'Fehler',
  'LBL_MODULE_NAME_SINGULAR' => 'Fehler:',
  'LBL_MODULE_TITLE' => 'Fehlerverfolgung: Home',
  'LBL_NEW_FORM_TITLE' => 'Neuer Fehler',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notizen',
  'LBL_NUMBER' => 'Nummer:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Haben Sie einen neuen Bug gefunden den Sie berichten wollen? Klicken Sie einfach hier um einen neuen Bug zu erstellen.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Sie können ein Filter setzen wen Sie einen Suchbegriff eingeben.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Zum Beispiel können Sie hiermit einen Bug finden die vor zurzem erstellt wurde',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'Das Bugs Modul dient zum Verwalten und Reporten von Bugs. Verwenden Sie die Pfeiltasten um an einer kurzen Tour teil zu nehmen.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Diese Seite zeigt eine Liste von veröffentlichten Bugs.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Hier Klicken führt Sie jederzeit zurück zu dieser Ansicht.',
  'LBL_PORTAL_VIEWABLE' => 'Im Portal sichtbar',
  'LBL_PRIORITY' => 'Priorität:',
  'LBL_PRODUCT_CATEGORY' => 'Kategorie',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekte',
  'LBL_RELEASE' => 'Release:',
  'LBL_RESOLUTION' => 'Lösung:',
  'LBL_SEARCH_FORM_TITLE' => 'Fehler Suche',
  'LBL_SHOW_IN_PORTAL' => 'Im Portal anzeigen',
  'LBL_SHOW_MORE' => 'Mehrere Bugs anzeigen',
  'LBL_SOURCE' => 'Quelle',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Betreff:',
  'LBL_SYSTEM_ID' => 'System ID',
  'LBL_TYPE' => 'Typ:',
  'LBL_WORK_LOG' => 'Arbeitslog:',
  'LNK_BUG_LIST' => 'Fehler',
  'LNK_BUG_REPORTS' => 'Bug Reports',
  'LNK_CREATE' => 'Neuer Fehler',
  'LNK_CREATE_WHEN_EMPTY' => 'Berichten Sie jetzt einen Fehler.',
  'LNK_IMPORT_BUGS' => 'Fehlermeldungen importieren',
  'LNK_NEW_BUG' => 'Neuer Fehler',
  'NTC_DELETE_CONFIRMATION' => 'Möchten Sie diesen Kontakt wirklich von diesem Fehler entfernen?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Möchten Sie diesen Fehler wirklich aus dieser Firma entfernen?',
  'NTC_REMOVE_INVITEE' => 'Möchten Sie diesen Kontakt wirklich aus dem Fehler entfernen?',
);

