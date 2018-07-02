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
  'ERR_DELETE_RECORD' => 'Zum Löschen der Firma muss eine Datensatznummer angegeben werden.',
  'ERR_REMOVING_ATTACHMENT' => 'Anhang konnte nicht entfernt werden...',
  'LBL_ACCOUNT_ID' => 'Firma ID',
  'LBL_ACTIVITIES_REPORTS' => 'Aktivitäten Report',
  'LBL_CASE_ID' => 'Ticket ID:',
  'LBL_CLOSE' => 'Beenden:',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'Kontakt ID:',
  'LBL_CONTACT_NAME' => 'Kontakt:',
  'LBL_CREATED_BY' => 'Erstellt von:',
  'LBL_DATE_ENTERED' => 'Erstellt am:',
  'LBL_DATE_MODIFIED' => 'Geändert am:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Notizen',
  'LBL_DELETED' => 'Gelöscht',
  'LBL_DESCRIPTION' => 'Beschreibung',
  'LBL_EDITLAYOUT' => 'Layout bearbeiten',
  'LBL_EMAIL_ADDRESS' => 'E-Mail Adresse:',
  'LBL_EMAIL_ATTACHMENT' => 'E-Mail Anhang',
  'LBL_EMBED_FLAG' => 'In E-Mail einfügen?',
  'LBL_EXPORT_PARENT_ID' => 'Verknüpft mit ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Verknüpft mit Modul',
  'LBL_FILENAME' => 'Anlage:',
  'LBL_FILE_MIME_TYPE' => 'Mime-Typ',
  'LBL_FILE_URL' => 'Datei URL',
  'LBL_FIRST_NAME' => 'Vorname',
  'LBL_HELP_CREATE' => 'Das {{plural_module_name}} Modul werden individuelle {{plural_module_name}} die Text oder auch eine Anlage beeinhalten zu einem verknüpften Datensatz gespeichert. Um einen {{module_name}} zu erstellen: 1. Erfassen Sie alle relevanten Informationen. - Felder die als Pflichtfeld markiert sind müssen ausgefüllt werden um den Datensatz speichern zu können. - Klicken Sie auf "mehr zeigen" um weitere Felder zu erfassen. 2. Drücken Sie auf "Speichern" um den Datensatz verfügbar zu machen und um auf die letzte Seite zurück zu kommen. - Wählen Sie "Speichern und Öffnen" um den neuen {{module_name}} in der Datensatzansicht zu öffnen. - Wählen Sie "Speichern und neuen Datensatz erstellen" um sofort einen weiteren {{module_name}} Datensatz anzulegen.',
  'LBL_HELP_RECORD' => 'Das {{plural_module_name}} Modul werden individuelle {{plural_module_name}} die Text oder auch eine Anlage beeinhalten zu einem verknüpften Datensatz gespeichert.
- Bearbeiten Sie den Datensatz indem Sie auf ein Feld oder auf die Schaltfläche Bearbeiten klicken.
- Erstellen oder sehen Sie sich Benutzerkommentare und die Änderungshistorie verschiedener Datensätze im  {{activitystream_singular_module}} an indem Sie die Sicht auf "Activity Stream" im unteren linken Bereich stellen. 
- Folgen Sie favorisierten Einträgen indem Sie das Sternsymbol neben dem Namen oben anklicken. 
- Weitere Aktionen finden Sie im Ausklappmenü auf der rechten Seite der Bearbeiten Schaltfläche.',
  'LBL_HELP_RECORDS' => 'Das {{plural_module_name}} Modul werden individuelle {{plural_module_name}} die Text oder auch eine Anlage beeinhalten zu einem verknüpften Datensatz gespeichert. Eine {{module_name}} kann mit einem anderen Datensatz verknüpft werden, kann aber auch nur zu einem {{contacts_singular_module}} angelegt werden. Es gibt verschiedene Möglichkeiten wie Sie {{plural_module_name}} in Sugar erstellen, über das {{plural_module_name}} selbst oder über Duplizieren oder importieren von {{plural_module_name}}, etc. Sobald der {{module_name}} erstellt ist, können Informationen in der Datenansicht eingesehen und editiert werden. Abhängig wie mit einer {{module_name}} gearbeitet wird, können die Details einer {{module_name}} auch über das Kalender Module bearbeitet und eingesehen werden. Jeder {{module_name}} kann mit einem anderen Sugar Datensatz wie {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, und viele andere verknüpft werden.',
  'LBL_LAST_NAME' => 'Nachname',
  'LBL_LEAD_ID' => 'Anfrage ID:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Zugew. Benutzer',
  'LBL_LIST_CONTACT' => 'Kontakt',
  'LBL_LIST_CONTACT_NAME' => 'Kontakt',
  'LBL_LIST_DATE_MODIFIED' => 'Geändert am:',
  'LBL_LIST_EDIT_BUTTON' => 'Bearbeiten',
  'LBL_LIST_FILENAME' => 'Anlage',
  'LBL_LIST_FORM_TITLE' => 'Notizen Liste',
  'LBL_LIST_RELATED_TO' => 'Bezieht sich auf',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Betreff',
  'LBL_MEMBER_OF' => 'Mitglied von:',
  'LBL_MODIFIED_BY' => 'Geändert von',
  'LBL_MODULE_NAME' => 'Notizen',
  'LBL_MODULE_NAME_SINGULAR' => 'Notiz',
  'LBL_MODULE_TITLE' => 'Notizen: Home',
  'LBL_MY_NOTES_DASHLETNAME' => 'Meine Notizen',
  'LBL_NEW_FORM_BTN' => 'Notiz erstellen',
  'LBL_NEW_FORM_TITLE' => 'Neue Notiz oder Anlage',
  'LBL_NOTE' => 'Hinweis:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Anhänge',
  'LBL_NOTE_INFORMATION' => 'Überblick Notizen',
  'LBL_NOTE_STATUS' => 'Notiz',
  'LBL_NOTE_SUBJECT' => 'Betreff:',
  'LBL_OC_FILE_NOTICE' => 'Bitte loggen Sie sich in dem Server ein um die Datei zu betrachten',
  'LBL_OPPORTUNITY_ID' => 'Verkaufschance ID:',
  'LBL_PANEL_DETAILS' => 'Details',
  'LBL_PARENT_ID' => 'Eltern ID:',
  'LBL_PARENT_TYPE' => 'Eltern-Typ',
  'LBL_PHONE' => 'Telefon:',
  'LBL_PORTAL_FLAG' => 'Im Portal anzeigen?',
  'LBL_PRODUCT_ID' => 'Produkt ID:',
  'LBL_QUOTE_ID' => 'Angebot ID:',
  'LBL_RELATED_TO' => 'Bezieht sich auf:',
  'LBL_REMOVING_ATTACHMENT' => 'Anhang wird entfernt...',
  'LBL_REVENUELINEITEMS' => 'Umsatzposten',
  'LBL_SEARCH_FORM_TITLE' => 'Notizen Suche',
  'LBL_SEND_ANYWAYS' => 'Diese E-Mail hat kein Betreff. Trotzdem senden/speichern?',
  'LBL_STATUS' => 'Status',
  'LBL_SUBJECT' => 'Betreff:',
  'LNK_IMPORT_NOTES' => 'Notizen importieren',
  'LNK_NEW_NOTE' => 'Neue Notiz oder Anlage',
  'LNK_NOTE_LIST' => 'Notizen',
);

