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
  'ERR_DELETE_EMPTY' => 'Záznam již byl smazaný nebo neexistuje',
  'ERR_DELETE_RECORD' => 'Musíte zadat číslo záznamu pro smazání daného produktu.',
  'LBL_ALERT_TEMPLATES' => 'Šablony upozornění',
  'LBL_APOSTROPHE_S' => '&#39;s',
  'LBL_COMPARE_ANY_TIME_PART2' => 'nezmění se po',
  'LBL_COMPARE_ANY_TIME_PART3' => 'určitý délka času',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'Pole se po určitou dobu nezmění',
  'LBL_COMPARE_CHANGE_PART' => 'změny',
  'LBL_COMPARE_CHANGE_TITLE' => 'Když se pole v cílovém modulu změní',
  'LBL_COMPARE_COUNT_TITLE' => 'Spouštěč na základě konkrétního počtu',
  'LBL_COMPARE_SPECIFIC_PART' => 'změny nebo od zadané hodnoty',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => 'Porovnat specifický časový úsek',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'Když se pole v cílovém modulu změní na, nebo ze stanovené hodnoty',
  'LBL_COUNT_TRIGGER1' => 'Celkem',
  'LBL_COUNT_TRIGGER1_2' => 'porovná s touto hodnotou',
  'LBL_COUNT_TRIGGER2' => 'filtruj podle vztahu',
  'LBL_COUNT_TRIGGER2_2' => 'pouze',
  'LBL_COUNT_TRIGGER3' => 'filtr podle spec.nastaveni',
  'LBL_COUNT_TRIGGER4' => 'filter po vteřině',
  'LBL_EVAL' => 'Hodnocení spouštěče:',
  'LBL_FIELD' => 'pole',
  'LBL_FILTER_FIELD_PART1' => 'Filtruj podle',
  'LBL_FILTER_FIELD_TITLE' => 'Když pole v cílovém modulu obsahuje specifickou hodnotu',
  'LBL_FILTER_FORM_TITLE' => 'Definuj podmínky workflow',
  'LBL_FILTER_LIST_STATEMEMT' => 'Filtruj události vázané na následující proces:',
  'LBL_FILTER_REL_FIELD_PART1' => 'Specifikujte související',
  'LBL_FILTER_REL_FIELD_TITLE' => 'Když se změní cílový modul a pole v souvisejícím modulu obsahuje určitou hodnotu',
  'LBL_FUTURE_TRIGGER' => 'Specifikujte novou',
  'LBL_LIST_EVAL' => 'Vyhodnocení:',
  'LBL_LIST_FIELD' => 'Pole:',
  'LBL_LIST_FORM_TITLE' => 'Přehled spouštěčů',
  'LBL_LIST_FRAME_PRI' => 'Spouštěč:',
  'LBL_LIST_FRAME_SEC' => 'Filtr:',
  'LBL_LIST_NAME' => 'Popis:',
  'LBL_LIST_STATEMEMT' => 'Spustit událost v návaznosti na následujícím:',
  'LBL_LIST_TYPE' => 'Typ:',
  'LBL_LIST_VALUE' => 'Hodnota:',
  'LBL_MODULE' => 'modul',
  'LBL_MODULE_NAME' => 'Podmínky',
  'LBL_MODULE_NAME_SINGULAR' => 'Podmínka',
  'LBL_MODULE_SECTION_TITLE' => 'Jsou-li tyto podmínky splněny',
  'LBL_MODULE_TITLE' => 'Spoušťěče workflow: Domů',
  'LBL_MUST_SELECT_VALUE' => 'Musíte vybrat hodnotu tohoto pole',
  'LBL_NAME' => 'Název spouštěče:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Vytvoř filtr',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Vytvoř filtr [Alt+F]',
  'LBL_NEW_FORM_TITLE' => 'Vytvořit spouštěč',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Vytvoř spouštěč',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Vytvoř spouštěč [Alt+T]',
  'LBL_PAST_TRIGGER' => 'Specifikujte starou',
  'LBL_RECORD' => 'moduly',
  'LBL_SEARCH_FORM_TITLE' => 'Vyhledávání ve spouštěčích workflow',
  'LBL_SELECT_1ST_FILTER' => 'Musíte vybrat správný filtr na první pole',
  'LBL_SELECT_2ND_FILTER' => 'Musíte vybrat správný filtr na druhé pole',
  'LBL_SELECT_AMOUNT' => 'Musíte zvolit částku',
  'LBL_SELECT_OPTION' => 'Prosím vyberte možnost.',
  'LBL_SELECT_TARGET_FIELD' => 'Prosím vyberte cílové pole.',
  'LBL_SELECT_TARGET_MOD' => 'Prosím vyberte cílový související modul.',
  'LBL_SHOW' => 'ukaž',
  'LBL_SHOW_PAST' => 'Modifikuj předchozí hodnoty:',
  'LBL_SPECIFIC_FIELD' => 'specifického pole',
  'LBL_SPECIFIC_FIELD_LNK' => 'specifické pole',
  'LBL_TRIGGER' => 'Když',
  'LBL_TRIGGER_FILTER_TITLE' => 'Filtr spouštěčů',
  'LBL_TRIGGER_FORM_TITLE' => 'Definuj podmínky pro provedení workflow',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'Když se změní cílový modul',
  'LBL_TYPE' => 'Typ:',
  'LBL_VALUE' => 'hodnota',
  'LBL_WHEN_VALUE1' => 'Když hodnota pole je',
  'LBL_WHEN_VALUE2' => 'Když hodnote je',
  'LNK_NEW_TRIGGER' => 'Vytvoř spouštěč',
  'LNK_NEW_WORKFLOW' => 'Vytvoření Workflow',
  'LNK_TRIGGER' => 'Workflow spouštěče',
  'LNK_WORKFLOW' => 'Objekty workflow',
  'NTC_REMOVE_TRIGGER' => 'Jste si jist, že chcete smazat tento spouštěč?',
  'NTC_REMOVE_TRIGGER_PRIMARY' => 'Odstranění primárního triggeru odstraní všechny triggery',
);

