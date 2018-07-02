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
  'ERR_DELETE_EMPTY' => 'Posten är redan raderad eller obefintlig.',
  'ERR_DELETE_RECORD' => 'Ett post nummer måste specificeras för att kunna radera posten.',
  'LBL_ALERT_TEMPLATES' => 'Meddelandemallar',
  'LBL_APOSTROPHE_S' => 's',
  'LBL_COMPARE_ANY_TIME_PART2' => 'ändras inte för',
  'LBL_COMPARE_ANY_TIME_PART3' => 'specifierad tid',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'Fält ändras inte under specificerad tidsperiod',
  'LBL_COMPARE_CHANGE_PART' => 'ändras',
  'LBL_COMPARE_CHANGE_TITLE' => 'När ett fält i målmodulen ändras',
  'LBL_COMPARE_COUNT_TITLE' => 'Trigga enligt specifikt nummer:',
  'LBL_COMPARE_SPECIFIC_PART' => 'ändras till eller från specifikt värde',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => 'Jämför deltid',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'När ett fält i målmodulen ändras till eller från ett specifikt värde',
  'LBL_COUNT_TRIGGER1' => 'Totalt',
  'LBL_COUNT_TRIGGER1_2' => 'jämför mot denna summa',
  'LBL_COUNT_TRIGGER2' => 'filtrera efter relaterad',
  'LBL_COUNT_TRIGGER2_2' => 'endast',
  'LBL_COUNT_TRIGGER3' => 'filtrera specifikt efter',
  'LBL_COUNT_TRIGGER4' => 'filtrera efter en sekund',
  'LBL_EVAL' => 'Trigger Utvärdering:',
  'LBL_FIELD' => 'fält',
  'LBL_FILTER_FIELD_PART1' => 'Filtrera efter',
  'LBL_FILTER_FIELD_TITLE' => 'När ett fält i målmodulen innehåller ett specificerat värde',
  'LBL_FILTER_FORM_TITLE' => 'Definiera ett krav för Arbetsflöde',
  'LBL_FILTER_LIST_STATEMEMT' => 'Filtrera objekt basserat på följande:',
  'LBL_FILTER_REL_FIELD_PART1' => 'Specificera relaterad',
  'LBL_FILTER_REL_FIELD_TITLE' => 'När målmodulen ändras och ett fält i en relaterad modul innehåller ett specificerat värde',
  'LBL_FUTURE_TRIGGER' => 'Specificera ny',
  'LBL_LIST_EVAL' => 'Ut v:',
  'LBL_LIST_FIELD' => 'Fält:',
  'LBL_LIST_FORM_TITLE' => 'Lista Triggers',
  'LBL_LIST_FRAME_PRI' => 'Trigger:',
  'LBL_LIST_FRAME_SEC' => 'Filter:',
  'LBL_LIST_NAME' => 'Beskrivning:',
  'LBL_LIST_STATEMEMT' => 'Trigga en händelse basserat på följande:',
  'LBL_LIST_TYPE' => 'Typ:',
  'LBL_LIST_VALUE' => 'Värde:',
  'LBL_MODULE' => 'modul',
  'LBL_MODULE_NAME' => 'Villkor',
  'LBL_MODULE_NAME_SINGULAR' => 'Tillstånd',
  'LBL_MODULE_SECTION_TITLE' => 'När följande villkor är uppfyllda',
  'LBL_MODULE_TITLE' => 'Arbetsflöde Triggers: Home',
  'LBL_MUST_SELECT_VALUE' => 'Du måste välja ett värde för det här fältet',
  'LBL_NAME' => 'Trigger Namn:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Skapa filter',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Skapa filter [Alt+F]',
  'LBL_NEW_FORM_TITLE' => 'Skapa Trigger',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Skapa Trigger',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Skapa Trigger [Alt + T]',
  'LBL_PAST_TRIGGER' => 'Specificera gammal',
  'LBL_RECORD' => 'moduler',
  'LBL_SEARCH_FORM_TITLE' => 'Arbetsflöden Trigger Sök',
  'LBL_SELECT_1ST_FILTER' => 'Du måste välja ett giltigt första filtrerings fält',
  'LBL_SELECT_2ND_FILTER' => 'Du måste välja ett giltigt andra filter fält',
  'LBL_SELECT_AMOUNT' => 'Du måste välja belopp',
  'LBL_SELECT_OPTION' => 'Vänligen välj ett alternativ.',
  'LBL_SELECT_TARGET_FIELD' => 'Vänligen välj ett  målfält.',
  'LBL_SELECT_TARGET_MOD' => 'Vänligen välj en målrelaterad modul.',
  'LBL_SHOW' => 'Visa',
  'LBL_SHOW_PAST' => 'Redigera senaste värde:',
  'LBL_SPECIFIC_FIELD' => 's specificerat fält',
  'LBL_SPECIFIC_FIELD_LNK' => 'specifikt fält',
  'LBL_TRIGGER' => 'När',
  'LBL_TRIGGER_FILTER_TITLE' => 'Trigga Filter',
  'LBL_TRIGGER_FORM_TITLE' => 'Definiera Omständigheter för Arbetsflödesexekvering',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'När målmodulen ändras',
  'LBL_TYPE' => 'Typ:',
  'LBL_VALUE' => 'värde',
  'LBL_WHEN_VALUE1' => 'När fältets värde är',
  'LBL_WHEN_VALUE2' => 'När värdet av',
  'LNK_NEW_TRIGGER' => 'Skapa Trigger',
  'LNK_NEW_WORKFLOW' => 'Skapa Arbetsflöde',
  'LNK_TRIGGER' => 'Arbetsflöden Triggers',
  'LNK_WORKFLOW' => 'Arbetsflödesobjekt',
  'NTC_REMOVE_TRIGGER' => 'Är du säker på att du vill ta bort den här Triggern?',
  'NTC_REMOVE_TRIGGER_PRIMARY' => 'Ta bort en primär trigger tar bort alla triggers.',
);

