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
  'ERR_DELETE_RECORD' => 'Трябва да определите номер на записа, за да изтриете този проблем.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Организации',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Дейности',
  'LBL_ASSIGNED_TO_NAME' => 'Отговорник',
  'LBL_BUG' => 'Проблем:',
  'LBL_BUG_INFORMATION' => 'Проблеми',
  'LBL_BUG_NUMBER' => 'Номер на проблем:',
  'LBL_BUG_SUBJECT' => 'Относно:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Казуси',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Контакти',
  'LBL_CONTACT_BUG_TITLE' => 'Контакт-Проблем:',
  'LBL_CONTACT_NAME' => 'Контакт:',
  'LBL_CONTACT_ROLE' => 'Роля:',
  'LBL_CREATED_BY' => 'Създадено от:',
  'LBL_DATE_CREATED' => 'Създадено на:',
  'LBL_DATE_LAST_MODIFIED' => 'Модифицирано на:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Проблеми',
  'LBL_DESCRIPTION' => 'Описание:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Документи',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Отговорник',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Отговорник',
  'LBL_EXPORT_CREATED_BY' => 'Създаден от',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Отстранен в издание',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Модифициран от',
  'LBL_FIXED_IN_RELEASE' => 'Разрешени във версия:',
  'LBL_FOUND_IN_RELEASE' => 'Намерени във версия:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Открит в издание',
  'LBL_HELP_CREATE' => 'Модулът {{plural_module_name}} се използва за проследяване и управление на проблеми и/или дефекти на продукти, независимо дали са открити в организацията или са докладвани от клиенти.

Записите в модула {{module_name}} съдържат списъци с организации или лица, които могат да бъдат включвали в маркетинговата комуникация през модул {{campaigns_singular_module}}.
За да създадете нов запис в модул {{plural_module_name}}:
1. Въведете стойности в отделните полета.
- Полетата маркирани като "Задължителни" се изисква да имат зададена стойнист преди да се пристъпи към съхраняване на записа.
- Натиснете върху "Покажи повече", за да бъдат визуализирани допълнителни полета ако е необходимо.
2. Натиснете "Съхрани", за да запазите новия запис и да се върнете в предходната страница.
- Изберете "Съхрани и разгледай", за да отворите автоматично детайли за новия запис.
- Изберете "Съхрани и създай нов", за да пристъпите към създаване на друг нов запис в модул  {{plural_module_name}}.',
  'LBL_HELP_RECORD' => 'Модулът {{plural_module_name}} се използва за проследяване и управление на проблеми и/или дефекти на продукти, независимо дали са открити в организацията или са докладвани от клиенти.

- Редактирайте текущия запис като натиснете конкретно поле или използвате бутона „Редактирай“.
- Разгледайте или модифицирайте връзките с други записи в системата, като за целта визуализирате панела „Свързани записи“.
- Поставете коментари към текущия запис и разгледайте история на извършените промени свързани с него, като преминете в панела „Хронология“.
- Следвайте или харесайте текущия запис като използвате иконите, намиращи се в дясно от името му.
- Можете да извършвате допълнителни действия със записа като използвате падащото меню в дясно на бутона „Редактирай“.',
  'LBL_HELP_RECORDS' => 'Модулът {{plural_module_name}} се използва за проследяване и управление на проблеми и/или дефекти на продукти, независимо дали са открити в организацията или са докладвани от клиенти. Откритите {{plural_module_name}} могат да бъдат допълнително анализирани чрез проследяване на откритите решения. Модулът {{plural_module_name}} предоставя на потребителите възможност да прегледат лесно и бързо всички детайли, свързани с проблема и процесът по неготово разрешаване. След като даден {{module_name}} е въведен в системата, можете да разгледате и редактирате информацията за него през изгледа „Детайли за записа“. Всеки {{module_name}}може да бъде свързан с други записи в Sugar, в това число{{calls_module}}, {{contacts_module}}, {{cases_module}} и много други.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'История',
  'LBL_INVITEE' => 'Контакти',
  'LBL_LIST_ACCOUNT_NAME' => 'Oрганизация',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Отговорник',
  'LBL_LIST_CONTACT_NAME' => 'Контакт',
  'LBL_LIST_EMAIL_ADDRESS' => 'Адрес на ел. поща',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Разрешени във версия',
  'LBL_LIST_FORM_TITLE' => 'Списък с проблеми',
  'LBL_LIST_LAST_MODIFIED' => 'Последно модифициран',
  'LBL_LIST_MY_BUGS' => 'Моите отбелязани проблеми',
  'LBL_LIST_NUMBER' => 'Ном.',
  'LBL_LIST_PHONE' => 'Телефон',
  'LBL_LIST_PRIORITY' => 'Степен на важност',
  'LBL_LIST_RELEASE' => 'Версия',
  'LBL_LIST_RESOLUTION' => 'Решение',
  'LBL_LIST_STATUS' => 'Статус',
  'LBL_LIST_SUBJECT' => 'Относно',
  'LBL_LIST_TYPE' => 'Тип',
  'LBL_MODIFIED_BY' => 'Модифицирано от:',
  'LBL_MODULE_ID' => 'Проблеми',
  'LBL_MODULE_NAME' => 'Проблеми',
  'LBL_MODULE_NAME_SINGULAR' => 'Проблем',
  'LBL_MODULE_TITLE' => 'Проблеми',
  'LBL_NEW_FORM_TITLE' => 'Въвеждане на нов проблем',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Бележки',
  'LBL_NUMBER' => 'Номер:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Можете да натиснете тук, в случай че желаете да повдигнете нов проблем.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Можете да филтрирате списъка с проблеми като задавате критерии за търсене.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Можете да използвате това например, за да намерите конкретен проблем, които е бил повдигнат.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'Чрез модула Проблеми можете да разглеждате и повдигане проблеми. Използвайте стрелките отдолу, за кратък преглед на възможностите.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Страницата визуализира списък със повдигнати проблеми.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Натискайкитук можете да се върнете в този списък по всяко време.',
  'LBL_PORTAL_VIEWABLE' => 'Видим в Потребителски портал',
  'LBL_PRIORITY' => 'Степен на важност:',
  'LBL_PRODUCT_CATEGORY' => 'Категория:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Проекти',
  'LBL_RELEASE' => 'Версия:',
  'LBL_RESOLUTION' => 'Решение:',
  'LBL_SEARCH_FORM_TITLE' => 'Търсене в модул "Проблеми"',
  'LBL_SHOW_IN_PORTAL' => 'Видим за портала',
  'LBL_SHOW_MORE' => 'Покажи повече',
  'LBL_SOURCE' => 'Източник:',
  'LBL_STATUS' => 'Статус:',
  'LBL_SUBJECT' => 'Относно:',
  'LBL_SYSTEM_ID' => 'ID на системата',
  'LBL_TYPE' => 'Категория:',
  'LBL_WORK_LOG' => 'Работен дневник на събития:',
  'LNK_BUG_LIST' => 'Списък с проблеми',
  'LNK_BUG_REPORTS' => 'Справки за проблеми',
  'LNK_CREATE' => 'Докладване за проблем',
  'LNK_CREATE_WHEN_EMPTY' => 'Докладвай проблем сега:',
  'LNK_IMPORT_BUGS' => 'Импортиране на проблеми',
  'LNK_NEW_BUG' => 'Докладване за проблем',
  'NTC_DELETE_CONFIRMATION' => 'Сигурни ли сте, че искате да изтриете този контакт от проблема?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Сигурни ли сте, че искате да изтриете проблема от този запис?',
  'NTC_REMOVE_INVITEE' => 'Сигурни ли сте, че искате да изтриете този контакт от проблема?',
);

