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
  'DATE_FORMAT' => '(гггг-мм-дд)',
  'ERR_DELETE_RECORD' => 'Трябва да въведете номер на записа, за да изтриете този контакт.',
  'ERR_INVALID_HOUR' => 'Моля, въведете час между 0 и 24',
  'LBL_ACTIVITIES_REPORTS' => 'Справка за дейности',
  'LBL_ASSIGNED_TO_NAME' => 'Отговорник:',
  'LBL_ASSIGNED_USER' => 'Отговорник',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Контакт:',
  'LBL_CONTACT_FIRST_NAME' => 'Име на контакта',
  'LBL_CONTACT_ID' => 'Контакт:',
  'LBL_CONTACT_LAST_NAME' => 'Фамилия на контакта',
  'LBL_CONTACT_NAME' => 'Контакт:',
  'LBL_CONTACT_PHONE' => 'Телефон за контакт:',
  'LBL_DATE_DUE' => 'Крайна дата',
  'LBL_DATE_DUE_FLAG' => 'Без крайна дата',
  'LBL_DATE_START_FLAG' => 'Без начална дата',
  'LBL_DEFAULT_PRIORITY' => 'Средна',
  'LBL_DESCRIPTION' => 'Описание:',
  'LBL_DESCRIPTION_INFORMATION' => 'Допълнителна информация',
  'LBL_DUE_DATE' => 'Крайна дата:',
  'LBL_DUE_DATE_AND_TIME' => 'Крайна дата и час:',
  'LBL_DUE_TIME' => 'Краен час:',
  'LBL_EDITLAYOUT' => 'Редактиране на подредби',
  'LBL_EMAIL' => 'Електронна поща:',
  'LBL_EMAIL_ADDRESS' => 'Електронна поща:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Отговорник (ID)',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Отговорник',
  'LBL_EXPORT_CREATED_BY' => 'Създадено от (ID)',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Модифицирано от (ID)',
  'LBL_EXPORT_PARENT_ID' => 'Свързан с ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Свързан с модул',
  'LBL_HELP_CREATE' => 'Модулът {{plural_module_name}} съдържа записи за действия, които трябва да бъдат приключени от съответните отговорници преди зададена крайна дата.

За да създадете нов запис в модул {{plural_module_name}}:
1. Въведете стойности в отделните полета.
 - Полетата маркирани като "Задължителни" се изисква да имат зададена стойнист преди да се пристъпи към съхраняване на записа.
 - Натиснете върху "Покажи повече", за да бъдат визуализирани допълнителни полета ако е необходимо.
2. Натиснете "Съхрани", за да запазите новия запис и да се върнете в предходната страница.
 - Изберете "Съхрани и разгледай", за да отворите автоматично детайли за новия запис.
 - Изберете "Съхрани и създай нов", за да пристъпите към създаване на друг нов запис в модул  {{plural_module_name}}.',
  'LBL_HELP_RECORD' => 'Модулът {{plural_module_name}} съдържа записи за действия, които трябва да бъдат приключени от съответните отговорници преди зададена крайна дата.

- Редактирайте текущия запис като натиснете конкретно поле или използвате бутона „Редактирай“.
- Разгледайте или модифицирайте връзките с други записи в системата, като за целта визуализирате панела „Свързани записи“.
- Поставете коментари към текущия запис и разгледайте история на извършените промени свързани с него, като преминете в панела „Хронология“.
- Следвайте или харесайте текущия запис като използвате иконите, намиращи се в дясно от името му.
- Можете да извършвате допълнителни действия със записа като използвате падащото меню в дясно на бутона „Редактирай“.',
  'LBL_HELP_RECORDS' => 'Модулът {{plural_module_name}} съдържа записи за действия, които трябва да бъдат приключени от съответните отговорници преди зададена крайна дата. Отделните {{plural_module_name}} могат да бъдат свързвани със записи в почти всички останали модули в системата, както и да бъдат асоциирани с отделен {{contacts_singular_module}}. Съществуват различни начини да създадете {{plural_module_name}} в SugarCRM, като за целта можете да използвате опциите на модула {{plural_module_name}}, да дублирате съществуващ запис, да импортирате {{plural_module_name}} и други. След като дадена {{module_name}} е въведена в системата, можете да разгледате и редактирате информацията за нея през изгледа „Детайли за записа“. В зависимост от данните въведени за конкретна {{module_name}}, тя може да бъде управлявана и през модул Календар в SugarCRM. Всяка {{module_name}} може да бъде свързана с други записи в Sugar, в това число {{accounts_module}}, {{contacts_module}}, {{opportunities_module}} и много други.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Бележки',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Отговорник',
  'LBL_LIST_CLOSE' => 'Затвори',
  'LBL_LIST_COMPLETE' => 'Приключена:',
  'LBL_LIST_CONTACT' => 'Контакт',
  'LBL_LIST_DATE_MODIFIED' => 'Модифицирано на',
  'LBL_LIST_DUE_DATE' => 'Падежна дата',
  'LBL_LIST_DUE_TIME' => 'Краен час',
  'LBL_LIST_FORM_TITLE' => 'Списък със задачи',
  'LBL_LIST_MY_TASKS' => 'Моите текущи задачи',
  'LBL_LIST_PRIORITY' => 'Степен на важност',
  'LBL_LIST_RELATED_TO' => 'Свързана с:',
  'LBL_LIST_START_DATE' => 'Начална дата',
  'LBL_LIST_START_TIME' => 'Начален час',
  'LBL_LIST_STATUS' => 'Статус',
  'LBL_LIST_SUBJECT' => 'Относно',
  'LBL_MODULE_NAME' => 'Задачи',
  'LBL_MODULE_NAME_SINGULAR' => 'Задача',
  'LBL_MODULE_TITLE' => 'Задачи',
  'LBL_NAME' => 'Име:',
  'LBL_NEW_FORM_DUE_DATE' => 'Крайна дата:',
  'LBL_NEW_FORM_DUE_TIME' => 'Краен час:',
  'LBL_NEW_FORM_SUBJECT' => 'Относно:',
  'LBL_NEW_FORM_TITLE' => 'Създаване на задача',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Няма',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Бележки',
  'LBL_PARENT_ID' => 'Родителско ID:',
  'LBL_PARENT_NAME' => 'Родителски тип:',
  'LBL_PHONE' => 'Телефон:',
  'LBL_PRIORITY' => 'Степен на важност:',
  'LBL_REVENUELINEITEMS' => 'Приходни позиции',
  'LBL_SEARCH_FORM_TITLE' => 'Търсене в модул "Задачи"',
  'LBL_START_DATE' => 'Начална дата:',
  'LBL_START_DATE_AND_TIME' => 'Начална дата и час:',
  'LBL_START_TIME' => 'Начален час:',
  'LBL_STATUS' => 'Статус:',
  'LBL_SUBJECT' => 'Относно:',
  'LBL_TASK' => 'Задачи',
  'LBL_TASK_CLOSE_SUCCESS' => 'Задачата е приключено успешно.',
  'LBL_TASK_INFORMATION' => 'Задача',
  'LNK_IMPORT_TASKS' => 'Импортиране на задачи',
  'LNK_NEW_TASK' => 'Създаване на задача',
  'LNK_TASK_LIST' => 'Списък със задачи',
);

