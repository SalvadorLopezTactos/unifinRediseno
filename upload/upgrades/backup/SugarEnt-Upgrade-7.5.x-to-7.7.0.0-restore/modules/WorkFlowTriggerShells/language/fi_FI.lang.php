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
  'ERR_DELETE_EMPTY' => 'Tietue on jo poistettu tai se on muulla tavalla olematon.',
  'ERR_DELETE_RECORD' => 'Tietuenumero tulee määritellä, jotta voit poistaa tietueen.',
  'LBL_ALERT_TEMPLATES' => 'Homautusmallit',
  'LBL_APOSTROPHE_S' => ' ',
  'LBL_COMPARE_ANY_TIME_PART2' => 'ei muutu',
  'LBL_COMPARE_ANY_TIME_PART3' => 'määrittyyn aikaan',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'Kenttä ei muutu määrittyyn aikaan',
  'LBL_COMPARE_CHANGE_PART' => 'muuttuu',
  'LBL_COMPARE_CHANGE_TITLE' => 'Kun tavoitemoduulin kenttä muuttuu',
  'LBL_COMPARE_COUNT_TITLE' => 'Laukaise tietyllä määrällä',
  'LBL_COMPARE_SPECIFIC_PART' => 'muuttuu määritetyksi arvoksi tai arvosta',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => ' ',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'Kun kenttä tavoitemoduulissa muuttuu määritetyksi arvoksi tai arvosta',
  'LBL_COUNT_TRIGGER1' => 'Summa',
  'LBL_COUNT_TRIGGER1_2' => 'vertaa tähän määrään:',
  'LBL_COUNT_TRIGGER2' => 'suodattaa liittyvään',
  'LBL_COUNT_TRIGGER2_2' => 'vain',
  'LBL_COUNT_TRIGGER3' => 'suodattaa erityisesti seuraavan mukaan',
  'LBL_COUNT_TRIGGER4' => 'suodattaa toisen mukaan',
  'LBL_EVAL' => 'Laukaisuehdon evaluointi:',
  'LBL_FIELD' => 'kenttä',
  'LBL_FILTER_FIELD_PART1' => 'Suodata',
  'LBL_FILTER_FIELD_TITLE' => 'Kun tavoitemoduulin kentässä on määritetty arvo',
  'LBL_FILTER_FORM_TITLE' => 'Määritä Work Flow -ehto',
  'LBL_FILTER_LIST_STATEMEMT' => 'Suodata objekteja, perustuen seuraavaan:',
  'LBL_FILTER_REL_FIELD_PART1' => 'Määritä liittyvä',
  'LBL_FILTER_REL_FIELD_TITLE' => 'Kun tavoitemoduuli muuttuu, ja kentässä on liittyvä moduuli jossa on tietty arvo',
  'LBL_FUTURE_TRIGGER' => 'Määritä uusi',
  'LBL_LIST_EVAL' => 'eval:',
  'LBL_LIST_FIELD' => 'Kenttä:',
  'LBL_LIST_FORM_TITLE' => 'Laukaisuehtojen lista',
  'LBL_LIST_FRAME_PRI' => 'Laukaisuehto:',
  'LBL_LIST_FRAME_SEC' => 'Suodatin:',
  'LBL_LIST_NAME' => 'Kuvaus:',
  'LBL_LIST_STATEMEMT' => 'Laukaise tapahtuma, perustuen seuraavaan:',
  'LBL_LIST_TYPE' => 'Tyyppi:',
  'LBL_LIST_VALUE' => 'Arvo:',
  'LBL_MODULE' => 'moduuli',
  'LBL_MODULE_NAME' => 'Ehdot',
  'LBL_MODULE_NAME_SINGULAR' => 'Ehto',
  'LBL_MODULE_SECTION_TITLE' => 'Kun nämä ehdot täydentyvät,',
  'LBL_MODULE_TITLE' => 'Work Flow -laukaisuehdot: Etusivu',
  'LBL_MUST_SELECT_VALUE' => 'Sinun on valittava arvo tälle keentälle',
  'LBL_NAME' => 'Laukaisuehdon nimi:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Luo suodatin',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Luo suodatin',
  'LBL_NEW_FORM_TITLE' => 'Luo laukaisuehto',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Luo laukaisuehto',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Luo laukaisuehto',
  'LBL_PAST_TRIGGER' => 'Määritä vanha',
  'LBL_RECORD' => 'tietue',
  'LBL_SEARCH_FORM_TITLE' => 'Work Flow -laukaisuehtojen haku',
  'LBL_SELECT_1ST_FILTER' => 'Sinun pitää valita validi ensimmäinen suodatinkenttä',
  'LBL_SELECT_2ND_FILTER' => 'Sinun pitää valita validi toinen suodatinkenttä',
  'LBL_SELECT_AMOUNT' => 'Sinun pitää valita määrä',
  'LBL_SELECT_OPTION' => 'Valitse valinta.',
  'LBL_SELECT_TARGET_FIELD' => 'Valitse tavoitekenttä.',
  'LBL_SELECT_TARGET_MOD' => 'Valitse tavoite-linkitetty moduuli.',
  'LBL_SHOW' => 'Näytä',
  'LBL_SHOW_PAST' => 'Muokkaa edellistä arvoa:',
  'LBL_SPECIFIC_FIELD' => 'tietty kenttä',
  'LBL_SPECIFIC_FIELD_LNK' => 'tietty kenttä',
  'LBL_TRIGGER' => 'Kun',
  'LBL_TRIGGER_FILTER_TITLE' => 'Laukaisuehtosuodattimet',
  'LBL_TRIGGER_FORM_TITLE' => 'Määritä ehto Work Flown suoritukselle',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'Kun tavoitemoduuli muuuttuu',
  'LBL_TYPE' => 'Tyyppi:',
  'LBL_VALUE' => 'arvo',
  'LBL_WHEN_VALUE1' => 'Kun kentän arvo on',
  'LBL_WHEN_VALUE2' => 'Kun arvo on',
  'LNK_NEW_TRIGGER' => 'Luo laukaisuehto',
  'LNK_NEW_WORKFLOW' => 'Luo Work Flow',
  'LNK_TRIGGER' => 'Work Flow -laukaisuehdot',
  'LNK_WORKFLOW' => 'Work Flow -objektit',
  'NTC_REMOVE_TRIGGER' => 'Haluatko varmasti poistaa tämän laukaisuehdon?',
  'NTC_REMOVE_TRIGGER_PRIMARY' => 'Primäärilaukaisijan poistaminen poistaa kaikki laukaisijat.',
);

