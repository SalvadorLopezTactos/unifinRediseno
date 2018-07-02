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
  'DATE_FORMAT' => '(jjjj-mm-tt)',
  'ERR_DELETE_RECORD' => 'Die Nummer eines Eintrages muss angegeben werden um einen Kontakt zu löschen!',
  'ERR_INVALID_HOUR' => 'Bitte geben Sie eine Stunde zwischen 0 Uhr und 24 Uhr ein',
  'LBL_ACTIVITIES_REPORTS' => 'Aktivitäten Reports',
  'LBL_ASSIGNED_TO_NAME' => 'Zugewiesen an:',
  'LBL_ASSIGNED_USER' => 'Zugewiesen an',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Kontakt:',
  'LBL_CONTACT_FIRST_NAME' => 'Kontakt Vorname',
  'LBL_CONTACT_ID' => 'Kontakt ID:',
  'LBL_CONTACT_LAST_NAME' => 'Kontakt Nachname',
  'LBL_CONTACT_NAME' => 'Kontakt:',
  'LBL_CONTACT_PHONE' => 'Telefon Kontaktperson:',
  'LBL_DATE_DUE' => 'Fällig am:',
  'LBL_DATE_DUE_FLAG' => 'Kein Fälligkeitsdatum',
  'LBL_DATE_START_FLAG' => 'Kein Startdatum',
  'LBL_DEFAULT_PRIORITY' => 'Mittel',
  'LBL_DESCRIPTION' => 'Beschreibung:',
  'LBL_DESCRIPTION_INFORMATION' => 'Beschreibungsinformation',
  'LBL_DUE_DATE' => 'Fällig am:',
  'LBL_DUE_DATE_AND_TIME' => 'Erledigen bis:',
  'LBL_DUE_TIME' => 'Fällig um:',
  'LBL_EDITLAYOUT' => 'Layout bearbeiten',
  'LBL_EMAIL' => 'E-Mail:',
  'LBL_EMAIL_ADDRESS' => 'E-Mail Adresse:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Zugewiesen an',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Zugewiesen Benutzer',
  'LBL_EXPORT_CREATED_BY' => 'Ersteller',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Verändert von:',
  'LBL_EXPORT_PARENT_ID' => 'Eltern-ID:',
  'LBL_EXPORT_PARENT_TYPE' => 'Verknüpft mit Modul',
  'LBL_HELP_CREATE' => 'Das {{plural_module_name}} Modul beeinhaltet Aktionen/Aufgaben und To-Do&#39;s, oder andere Typen von Aktivitäten die erledigt werden sollen. 
1. Erfassen Sie alle relevanten Informationen. - Felder die als Pflichtfeld markiert sind müssen ausgefüllt werden um den Datensatz speichern zu können. - Klicken Sie auf "mehr zeigen" um weitere Felder zu erfassen. 2. Drücken Sie auf "Speichern" um den Datensatz verfügbar zu machen und um auf die letzte Seite zurück zu kommen. - Wählen Sie "Speichern und Öffnen" um den neuen {{module_name}} in der Datensatzansicht zu öffnen. - Wählen Sie "Speichern und neuen Datensatz erstellen" um sofort einen weiteren {{module_name}} Datensatz anzulegen.',
  'LBL_HELP_RECORD' => 'Das {{plural_module_name}} Modul beeinhaltet Aktionen/Aufgaben und To-Do&#39;s, oder andere Typen von Aktivitäten die erledigt werden sollen. Editieren Sie den Datensatz in dem Sie ein einzelnes Feld anklicken oder indem Sie auf die Bearbeiten Schaltfläche drücken. Sehen Sie sich in der Vorschau Verknüpfungen zu anderen Datensätzen an. Klicken Sie im Subpanel entsprechend auf das Vorschausymbol klicken. Erstellen oder sehen Sie sich Benutzerkommentare und die Änderungshistorie verschiedener Datensätze im  {{activitystream_singular_module}} an indem Sie die Sicht auf "Activity Stream" im unteren linken Bereich stellen. Folgen Sie favorisierten Einträgen indem Sie das Sternsymbol neben dem Namen oben anklicken. Weitere Aktionen finden Sie im Ausklappmenü auf der rechten Seite der Bearbeiten Schaltfläche.',
  'LBL_HELP_RECORDS' => 'Das {{plural_module_name}} Modul beeinhaltet Aktionen/Aufgaben und To-Do&#39;s, oder andere Typen von Aktivitäten die erledigt werden sollen. Eine {{module_name}} kann mit einem anderen Datensatz verknüpft werden, kann aber auch nur zu einem {{contacts_singular_module}} angelegt werden. Es gibt verschiedene Möglichkeiten wie Sie {{plural_module_name}} in Sugar erstellen, über das {{plural_module_name}} selbst oder über Duplizieren oder importieren von {{plural_module_name}}, etc. Sobald der {{module_name}} erstellt ist, können Informationen in der Datenansicht eingesehen und editiert werden. Abhängig wie mit einer {{module_name}} gearbeitet wird, können die Details einer {{module_name}} auch über das Kalender Module bearbeitet und eingesehen werden. Jeder {{module_name}} kann mit einem anderen Sugar Datensatz wie {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, und viele andere verknüpft werden.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Notizen',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Zugew. Benutzer',
  'LBL_LIST_CLOSE' => 'Schließen',
  'LBL_LIST_COMPLETE' => 'Abgeschlossen:',
  'LBL_LIST_CONTACT' => 'Kontakt',
  'LBL_LIST_DATE_MODIFIED' => 'Geändert am',
  'LBL_LIST_DUE_DATE' => 'Fällig am',
  'LBL_LIST_DUE_TIME' => 'Fällig um:',
  'LBL_LIST_FORM_TITLE' => 'Aufgaben Liste',
  'LBL_LIST_MY_TASKS' => 'Meine offenen Aufgaben',
  'LBL_LIST_PRIORITY' => 'Priorität',
  'LBL_LIST_RELATED_TO' => 'Gehört zu',
  'LBL_LIST_START_DATE' => 'Startdatum',
  'LBL_LIST_START_TIME' => 'Startzeit',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Betreff',
  'LBL_MODULE_NAME' => 'Aufgaben',
  'LBL_MODULE_NAME_SINGULAR' => 'Aufgabe',
  'LBL_MODULE_TITLE' => 'Aufgaben: Home',
  'LBL_NAME' => 'Name:',
  'LBL_NEW_FORM_DUE_DATE' => 'Fällig am:',
  'LBL_NEW_FORM_DUE_TIME' => 'Fällig um:',
  'LBL_NEW_FORM_SUBJECT' => 'Betreff:',
  'LBL_NEW_FORM_TITLE' => 'Neue Aufgabe',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Kein(e)',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notizen',
  'LBL_PARENT_ID' => 'Eltern ID:',
  'LBL_PARENT_NAME' => 'Eltern-Typ:',
  'LBL_PHONE' => 'Telefon:',
  'LBL_PRIORITY' => 'Priorität:',
  'LBL_REVENUELINEITEMS' => 'Umsatzposten',
  'LBL_SEARCH_FORM_TITLE' => 'Aufgaben Suche',
  'LBL_START_DATE' => 'Startdatum:',
  'LBL_START_DATE_AND_TIME' => 'Startdatum und -zeit:',
  'LBL_START_TIME' => 'Beginn:',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Betreff:',
  'LBL_TASK' => 'Aufgaben:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Aufgabe erfolgreich abgeschlossen.',
  'LBL_TASK_INFORMATION' => 'Überblick Aufgaben',
  'LNK_IMPORT_TASKS' => 'Aufgaben importieren',
  'LNK_NEW_TASK' => 'Neue Aufgabe',
  'LNK_TASK_LIST' => 'Aufgaben',
);

