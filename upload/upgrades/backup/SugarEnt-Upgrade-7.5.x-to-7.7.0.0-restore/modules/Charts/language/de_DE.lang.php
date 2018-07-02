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
  'ERR_NO_OPPS' => 'Sie müssen Verkaufschancen erstellt haben, um eine entsprechende Grafik anzeigen zu können.',
  'LBL_ALL_OPPORTUNITIES' => 'Die Summe aller Verkaufschancen ist',
  'LBL_CAMPAIGN_ROI_TITLE_DESC' => 'Zeigt Kampagnen Resonanz nach Return On Investment.',
  'LBL_CHART_ACTION' => 'Aktion',
  'LBL_CHART_DCE_ACTIONS_MONTH' => 'DCE Aktionen nach Typen (dieses Monat)',
  'LBL_CHART_LEAD_SOURCE_BY_OUTCOME' => 'Quelle nach Ergebnis',
  'LBL_CHART_MODULES_USED_DIRECT_REPORTS_30_DAYS' => 'Module von meinen dirketen Reports genutzt (letzten 30 Tage)',
  'LBL_CHART_MY_MODULES_USED_30_DAYS' => 'Module von mir genutzt (letzten 30 Tage)',
  'LBL_CHART_MY_PIPELINE_BY_SALES_STAGE' => 'Meine Pipeline nach Verkaufsphasen',
  'LBL_CHART_OPPORTUNITIES_THIS_QUARTER' => 'Verkaufschancen dieses Quartal',
  'LBL_CHART_OUTCOME_BY_MONTH' => 'Resultat nach Monat',
  'LBL_CHART_PIPELINE_BY_LEAD_SOURCE' => 'Pipeline nach Quelle',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE' => 'Pipeline nach Verkaufsphasen',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE_FUNNEL' => 'Pipeline nach Verkaufsphasen Funnel',
  'LBL_CHART_TYPE' => 'Diagrammtyp:',
  'LBL_CLOSE_DATE_END' => 'Abschluss erwartet bis',
  'LBL_CLOSE_DATE_START' => 'Abschluss erwartet ab',
  'LBL_CREATED_ON' => 'Zum letzten Mal durchgeführt am',
  'LBL_DATE_END' => 'Enddatum:',
  'LBL_DATE_RANGE' => 'Datumsbereich ist',
  'LBL_DATE_RANGE_TO' => 'an',
  'LBL_DATE_START' => 'Anfangsdatum:',
  'LBL_EDIT' => 'Bearbeiten',
  'LBL_LEAD_SOURCES' => 'Quellen:',
  'LBL_LEAD_SOURCE_BY_OUTCOME' => 'Alle Verkaufschancen nach Quelle und Ergebnis',
  'LBL_LEAD_SOURCE_BY_OUTCOME_DESC' => 'Zeigt die aufsummierten Beträge der Verkaufschancen nach Ergebnis für bestimmte Benutzer an. Das Ergebnis hängt davon ab, ob die Verkaufsphase "geschlossen gewonnen", "geschlossen verloren" oder irgendein anderer Wert ist.',
  'LBL_LEAD_SOURCE_FORM_DESC' => 'Zeigt die aufsummierten Beträge der Verkaufschancen nach selektierter Quelle für bestimmte Benutzer an.',
  'LBL_LEAD_SOURCE_FORM_TITLE' => 'Alle Verkaufschancen nach Quelle',
  'LBL_LEAD_SOURCE_OTHER' => 'Andere',
  'LBL_MODULE_NAME' => 'Übersicht',
  'LBL_MODULE_NAME_SINGULAR' => 'Dashboard',
  'LBL_MODULE_TITLE' => 'Übersicht: Home',
  'LBL_MONTH_BY_OUTCOME_DESC' => 'Zeigt die aufsummierten Beträge der Verkaufschancen nach Monat und Ergebnis für bestimmte Benutzer an. Das erwartete Enddatum der Verkaufschancen ist innerhalb des angegebenen Datumbereichs. Die Ergebnisse basieren auf den Verkaufsphasen.',
  'LBL_MY_MODULES_USED_SIZE' => 'Zugriffszähler',
  'LBL_NUMBER_OF_OPPS' => 'Anzahl der Verkaufschancen',
  'LBL_OPPS_IN_LEAD_SOURCE' => 'Verkaufschancen mit Quelle',
  'LBL_OPPS_IN_STAGE' => 'wo Verkaufsphase ist',
  'LBL_OPPS_OUTCOME' => 'wo das Ergebnis ist',
  'LBL_OPPS_WORTH' => 'Verkaufschancen Wert',
  'LBL_OPP_SIZE' => 'Verkaufschance Größe in',
  'LBL_OPP_THOUSANDS' => 'K',
  'LBL_PIPELINE_FORM_TITLE_DESC' => 'Zeigt die aufsummierten Beträge der Verkaufschancen, deren erwartetes Enddatum innerhalb des angegebenen Datumbereichs liegt, nach ausgewählten Verkaufsphasen an.',
  'LBL_REFRESH' => 'Aktualisieren',
  'LBL_ROLLOVER_DETAILS' => 'Für Details gehen Sie auf den Balken.',
  'LBL_ROLLOVER_WEDGE_DETAILS' => 'Für Details gehen Sie auf einen Ausschnitt.',
  'LBL_SALES_STAGES' => 'Verkaufsphasen:',
  'LBL_SALES_STAGE_FORM_DESC' => 'Zeigt die aufsummierten Beträge der Verkaufschancen, deren erwartetes Enddatum innerhalb des angegebenen Datumbereichs liegt, an.Guppiert nach ausgewählten Verkaufsphasen für bestimmte Benutzer.',
  'LBL_SALES_STAGE_FORM_TITLE' => 'Pipeline nach Verkaufsphasen',
  'LBL_TITLE' => 'Titel:',
  'LBL_TOTAL_PIPELINE' => 'Pipeline gesamt ist',
  'LBL_USERS' => 'Benutzer:',
  'LBL_YEAR' => 'Jahr:',
  'LBL_YEAR_BY_OUTCOME' => 'Pipeline nach Monat und Ergebnis',
  'LNK_NEW_ACCOUNT' => 'Neue Firma',
  'LNK_NEW_CALL' => 'Neuer Anruf',
  'LNK_NEW_CASE' => 'Neuer Fall',
  'LNK_NEW_CONTACT' => 'Neuer Kontakt',
  'LNK_NEW_ISSUE' => 'Neuer Fehler',
  'LNK_NEW_LEAD' => 'Neuer Interessent',
  'LNK_NEW_MEETING' => 'Neues Meeting',
  'LNK_NEW_NOTE' => 'Neue Notiz oder Anlage',
  'LNK_NEW_OPPORTUNITY' => 'Neue Verkaufschance',
  'LNK_NEW_QUOTE' => 'Neues Angebot',
  'LNK_NEW_TASK' => 'Neue Aufgabe',
  'NTC_NO_LEGENDS' => 'Kein(e)',
);

