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
  'ERR_DELETE_EMPTY' => 'Такъв запис не съществува или вече е изтрит.',
  'ERR_DELETE_RECORD' => 'Трябва да посочите номер, за да изтриете този запис.',
  'LBL_ALERT_TEMPLATES' => 'Шаблони на известявания',
  'LBL_APOSTROPHE_S' => ' ',
  'LBL_COMPARE_ANY_TIME_PART2' => 'няма промяна за',
  'LBL_COMPARE_ANY_TIME_PART3' => 'определен период от време',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'Няма промяна в стойностите на полето за определен период от време',
  'LBL_COMPARE_CHANGE_PART' => ' ',
  'LBL_COMPARE_CHANGE_TITLE' => 'При промяна на стойности на полето в избрания модул',
  'LBL_COMPARE_COUNT_TITLE' => 'Стартирай при конкретна бройка',
  'LBL_COMPARE_SPECIFIC_PART' => 'на или от определена стойност',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => 'на или от определена стойност',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'При промяна на стойности на полето в избрания модул на или от определена стойност',
  'LBL_COUNT_TRIGGER1' => 'Всичко',
  'LBL_COUNT_TRIGGER1_2' => 'compares to this amount',
  'LBL_COUNT_TRIGGER2' => 'filter by related',
  'LBL_COUNT_TRIGGER2_2' => 'само',
  'LBL_COUNT_TRIGGER3' => 'filter specifically by',
  'LBL_COUNT_TRIGGER4' => 'filter by a second',
  'LBL_EVAL' => 'Стартирай оценка:',
  'LBL_FIELD' => 'поле',
  'LBL_FILTER_FIELD_PART1' => 'Филтриране по',
  'LBL_FILTER_FIELD_TITLE' => 'При наличие на определени стойности на полето в избрания модул',
  'LBL_FILTER_FORM_TITLE' => 'Дефинирай условие за процеса',
  'LBL_FILTER_LIST_STATEMEMT' => 'Filter objects based on the following:',
  'LBL_FILTER_REL_FIELD_PART1' => 'Определете в свързания',
  'LBL_FILTER_REL_FIELD_TITLE' => 'При промяна на избрания модул и наличие на определени стойности на полето в свързан модул',
  'LBL_FUTURE_TRIGGER' => 'Определяне на нова стойност за:',
  'LBL_LIST_EVAL' => 'Оценка:',
  'LBL_LIST_FIELD' => 'Поле:',
  'LBL_LIST_FORM_TITLE' => 'Списък с тригери',
  'LBL_LIST_FRAME_PRI' => 'Тригер:',
  'LBL_LIST_FRAME_SEC' => 'Филтър:',
  'LBL_LIST_NAME' => 'Описание:',
  'LBL_LIST_STATEMEMT' => 'Trigger an event based on the following:',
  'LBL_LIST_TYPE' => 'Категория:',
  'LBL_LIST_VALUE' => 'Стойност:',
  'LBL_MODULE' => 'модул',
  'LBL_MODULE_NAME' => 'Условия',
  'LBL_MODULE_NAME_SINGULAR' => 'Условие',
  'LBL_MODULE_SECTION_TITLE' => 'При наличие на следните условия',
  'LBL_MODULE_TITLE' => 'Тригери:',
  'LBL_MUST_SELECT_VALUE' => 'Необходимо е да изберете стойност за тези полета',
  'LBL_NAME' => 'Тригер:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'Ф',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Създай филтър',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Създай филтър [Alt+F]',
  'LBL_NEW_FORM_TITLE' => 'Създаване на тригер',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'Т',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Създаване на тригер',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Създай тригер [Alt+T]',
  'LBL_PAST_TRIGGER' => 'Определяне на стара стойност за:',
  'LBL_RECORD' => 'модул',
  'LBL_SEARCH_FORM_TITLE' => 'Търсене на тригер',
  'LBL_SELECT_1ST_FILTER' => 'Необходимо е да въведете валидна стойност в 1 поле за филтър',
  'LBL_SELECT_2ND_FILTER' => 'Необходимо е да въведете валидна стойност в 2 поле за филтър',
  'LBL_SELECT_AMOUNT' => 'Необходимо е да изберете сума',
  'LBL_SELECT_OPTION' => 'Моля, изберете опция.',
  'LBL_SELECT_TARGET_FIELD' => 'Моля, изберете полето.',
  'LBL_SELECT_TARGET_MOD' => 'Моля, изберете target related module.',
  'LBL_SHOW' => 'Покажи',
  'LBL_SHOW_PAST' => 'Модифицирай предишната стойност:',
  'LBL_SPECIFIC_FIELD' => 'specific field',
  'LBL_SPECIFIC_FIELD_LNK' => 'определено поле',
  'LBL_TRIGGER' => 'При промяна на',
  'LBL_TRIGGER_FILTER_TITLE' => 'Стартирай филтри',
  'LBL_TRIGGER_FORM_TITLE' => 'Дефинирай условие за изпълнение на процеса',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'При промяна на избрания модул',
  'LBL_TYPE' => 'Категория:',
  'LBL_VALUE' => 'стойност',
  'LBL_WHEN_VALUE1' => 'Стойността на полето е',
  'LBL_WHEN_VALUE2' => 'Стойността на',
  'LNK_NEW_TRIGGER' => 'Създаване на тригер',
  'LNK_NEW_WORKFLOW' => 'Дефиниране на процес',
  'LNK_TRIGGER' => 'Тригери',
  'LNK_WORKFLOW' => 'Обекти',
  'NTC_REMOVE_TRIGGER' => 'Сигурни ли сте че искате да премахнете този тригер?',
  'NTC_REMOVE_TRIGGER_PRIMARY' => 'Премахването на основното събитие ще премахне всички събития.',
);

