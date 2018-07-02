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
  'ERR_DELETE_EMPTY' => 'הרשומה כבר נמחקה או לא קיימת',
  'ERR_DELETE_RECORD' => 'יש לציין מספר רשומה על מנת למחוק רשונה',
  'LBL_ALERT_TEMPLATES' => 'תבניות אזעקה',
  'LBL_APOSTROPHE_S' => '&#39;s',
  'LBL_COMPARE_ANY_TIME_PART2' => 'לא משתנה עבור',
  'LBL_COMPARE_ANY_TIME_PART3' => 'פרק זמן מסויים',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'שדה שאיננו משתנה תוך פרק זמן מסויים',
  'LBL_COMPARE_CHANGE_PART' => 'שינויים',
  'LBL_COMPARE_CHANGE_TITLE' => 'כששדה במודול המטרה משתנה',
  'LBL_COMPARE_COUNT_TITLE' => 'טריגר בסיפרור מסויים',
  'LBL_COMPARE_SPECIFIC_PART' => 'שינויים אל או מאת ערך מסויים',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => ' ',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'כאשר שדה במודול המטרה משתנה אל או מאת ערך מסויים',
  'LBL_COUNT_TRIGGER1' => 'סך-הכל',
  'LBL_COUNT_TRIGGER1_2' => 'השווה לסכום זה',
  'LBL_COUNT_TRIGGER2' => 'סנן לפי הקשורים אל',
  'LBL_COUNT_TRIGGER2_2' => 'רק',
  'LBL_COUNT_TRIGGER3' => 'פילטר ספציפית על ידי',
  'LBL_COUNT_TRIGGER4' => 'סנן לפי שנייה',
  'LBL_EVAL' => 'הערכה לטריגר:',
  'LBL_FIELD' => 'שדה',
  'LBL_FILTER_FIELD_PART1' => 'מסונן על ידי',
  'LBL_FILTER_FIELD_TITLE' => 'כששדה במודול המטרה מכיל ערך מסויים',
  'LBL_FILTER_FORM_TITLE' => 'הגדר תנאי ל Workflow',
  'LBL_FILTER_LIST_STATEMEMT' => 'סינון אוביקטים מבוסס על הדברים הבאים:',
  'LBL_FILTER_REL_FIELD_PART1' => 'פרט קשורים אל',
  'LBL_FILTER_REL_FIELD_TITLE' => 'כשמודול המטרה משתנה ומודול המתייחס אליו מכיל ערך מסויים',
  'LBL_FUTURE_TRIGGER' => 'פרט עכשיו',
  'LBL_LIST_EVAL' => 'הערך:',
  'LBL_LIST_FIELD' => 'שדה:',
  'LBL_LIST_FORM_TITLE' => 'רשימת טריגרים',
  'LBL_LIST_FRAME_PRI' => 'טריגר:',
  'LBL_LIST_FRAME_SEC' => 'פילטר:',
  'LBL_LIST_NAME' => 'תיאור:',
  'LBL_LIST_STATEMEMT' => 'טריגר הוא אירוע המבוסס על הדברים הבאים:',
  'LBL_LIST_TYPE' => 'סוג:',
  'LBL_LIST_VALUE' => 'ערך:',
  'LBL_MODULE' => 'מודול',
  'LBL_MODULE_NAME' => 'תנאים',
  'LBL_MODULE_NAME_SINGULAR' => 'מצב',
  'LBL_MODULE_SECTION_TITLE' => 'כשהתנאים האלה מתקיימים',
  'LBL_MODULE_TITLE' => 'Workflow טריגרים: דף הבית',
  'LBL_MUST_SELECT_VALUE' => 'עליך לבחור ערך לשדה הזה',
  'LBL_NAME' => 'שם נטריגר:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'צור פילטר',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'צור פילטר [Alt+F]',
  'LBL_NEW_FORM_TITLE' => 'צור טריגר',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'צור טריגר',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'צור טריגר [Alt+T]',
  'LBL_PAST_TRIGGER' => 'פרט ישן',
  'LBL_RECORD' => 'מודול/ים',
  'LBL_SEARCH_FORM_TITLE' => 'Workflow חיפוש טריגר',
  'LBL_SELECT_1ST_FILTER' => 'עליך לבחור פילטר ראשון לשדה',
  'LBL_SELECT_2ND_FILTER' => 'עליך לבחור פילטר שני לשדה',
  'LBL_SELECT_AMOUNT' => 'עליך לבחור את הסכום',
  'LBL_SELECT_OPTION' => 'בחר באחת מהאפשרויות.',
  'LBL_SELECT_TARGET_FIELD' => 'בחר שדה מטרה.',
  'LBL_SELECT_TARGET_MOD' => 'בחר מודול מטרה .',
  'LBL_SHOW' => 'הצג',
  'LBL_SHOW_PAST' => 'שנה ערכים מהעבר:',
  'LBL_SPECIFIC_FIELD' => '&#39;s שדה מסויים',
  'LBL_SPECIFIC_FIELD_LNK' => 'שדה מסויים',
  'LBL_TRIGGER' => 'מתי',
  'LBL_TRIGGER_FILTER_TITLE' => 'טריגר לפילטרים',
  'LBL_TRIGGER_FORM_TITLE' => 'הגדר תנאים להפעלת Workflow',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'כשמודול המטרה משתנה',
  'LBL_TYPE' => 'סוג:',
  'LBL_VALUE' => 'ערך',
  'LBL_WHEN_VALUE1' => 'כשערך השדה הוא',
  'LBL_WHEN_VALUE2' => 'כשהערך של',
  'LNK_NEW_TRIGGER' => 'צור טריגר',
  'LNK_NEW_WORKFLOW' => 'צור Workflow',
  'LNK_TRIGGER' => 'Workflow טריגרים',
  'LNK_WORKFLOW' => 'Workflow אוביקטים',
  'NTC_REMOVE_TRIGGER' => 'אתה בטוח שברצונך להסיר את הרשומה הזו?',
  'NTC_REMOVE_TRIGGER_PRIMARY' => 'הסרת טריגר ראשי יסיר את כל הטריגרים',
);

