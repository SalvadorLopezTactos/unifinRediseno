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
  'ERR_DELETE_RECORD' => 'Необходимо е да маркирате поне 1 запис, за да продължите.',
  'LABEL_PANEL_ASSIGNMENT' => 'Отговорник',
  'LBL_ACCOUNT_ID' => 'Организация',
  'LBL_ACCOUNT_NAME' => 'Организация:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Дейности',
  'LBL_ASSIGNED_TO_ID' => 'Отговорник:',
  'LBL_ASSIGNED_TO_NAME' => 'Отговорник:',
  'LBL_CAMPAIGN' => 'Кампания:',
  'LBL_CAMPAIGN_LINK' => 'Кампания',
  'LBL_CAMPAIGN_OPPORTUNITY' => 'Кампании',
  'LBL_CLOSED_RLIS' => '# от приключените приходни позции',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'Моите реализирани възможности',
  'LBL_COMMITTED' => 'Разпределена',
  'LBL_COMMIT_STAGE' => 'Изпрати етапа на възможността',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Контакти',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Related Contacts&#39; Emails',
  'LBL_CONTRACTS' => 'Договори',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Договори',
  'LBL_CREATED_ID' => 'Създадена от',
  'LBL_CREATED_USER' => 'Създаден потребител',
  'LBL_CURRENCIES' => 'Валути',
  'LBL_CURRENCY' => 'Валута:',
  'LBL_CURRENCY_ID' => 'Валута',
  'LBL_CURRENCY_NAME' => 'Име на валутата',
  'LBL_CURRENCY_RATE' => 'Валутен курс',
  'LBL_CURRENCY_SYMBOL' => 'Валутен символ',
  'LBL_DATE_CLOSED' => 'Дата на финализиране:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Очаквана дата на затваряне',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Възможности',
  'LBL_DESCRIPTION' => 'Описание:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Документи',
  'LBL_DUPLICATE' => 'Възможно е дублиране',
  'LBL_EDITLAYOUT' => 'Редактиране на подредби',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Отговорник',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Отговорник',
  'LBL_EXPORT_CAMPAIGN_ID' => 'Кампания',
  'LBL_EXPORT_CREATED_BY' => 'Създадено от',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Модифицирано от',
  'LBL_EXPORT_NAME' => 'Име',
  'LBL_FILENAME' => 'Прикачен файл',
  'LBL_FORECAST' => 'Включена в прогнозата',
  'LBL_HELP_CREATE' => 'Модулът {{plural_module_name}} дава възможност да проследявате водените търговски преговори и приходните позиции, асоциирани с тях. Всеки запис в модула {{module_name}} обобщава информацията за група от {{revenuelineitems_module}} като в същото време предоставя и връзка към допълнителни обекти като {{quotes_module}}, {{contacts_module}} и други.

За да създадете нов запис в модул {{plural_module_name}}:
1. Въведете стойности в отделните полета.
 - Полетата маркирани като "Задължителни" се изисква да имат зададена стойнист преди да се пристъпи към съхраняване на записа.
 - Натиснете върху "Покажи повече", за да бъдат визуализирани допълнителни полета ако е необходимо.
2. Натиснете "Съхрани", за да запазите новия запис и да се върнете в предходната страница.
 - Изберете "Съхрани и разгледай", за да отворите автоматично детайли за новия запис.
 - Изберете "Съхрани и създай нов", за да пристъпите към създаване на друг нов запис в модул  {{plural_module_name}}.
 3. След съхраняване на записа използвайте панела  {{revenuelineitems_module}} за добавяне на приходни позиции към възможността.',
  'LBL_HELP_RECORD' => 'Модулът {{plural_module_name}} дава възможност да проследявате водените търговски преговори и приходните позиции, асоциирани с тях. Всеки запис в модула {{module_name}} обобщава информацията за група от {{revenuelineitems_module}} като в същото време предоставя и връзка към допълнителни обекти като {{quotes_module}}, {{contacts_module}} и други.

- Редактирайте текущия запис като натиснете конкретно поле или използвате бутона „Редактирай“.
- Разгледайте или модифицирайте връзките с други записи в системата, като за целта визуализирате панела „Свързани записи“.
- Поставете коментари към текущия запис и разгледайте история на извършените промени свързани с него, като преминете в панела „Хронология“.
- Следвайте или харесайте текущия запис като използвате иконите, намиращи се в дясно от името му.
- Можете да извършвате допълнителни действия със записа като използвате падащото меню в дясно на бутона „Редактирай“.',
  'LBL_HELP_RECORDS' => 'Модулът {{plural_module_name}} дава възможност да проследявате водените търговски преговори и приходните позиции, асоциирани с тях. Всеки запис в модула {{plural_module_name}} обобщава информацията за група от {{revenuelineitems_module}}, като в същото време предоставя и връзка към допълнителни обекти като {{quotes_module}}, {{contacts_module}} и други. Всяка {{revenuelineitems_singular_module}} е вероятна продажба на конкретен продукт и съдържа в себе си свързаната с тази възможност търговска информация. Всяка {{revenuelineitems_singular_module}} обикновено преминава през няколко етапа докато накрая се превърне в "Спечелена" или "Загубена". Записът за възможността съдържа очакваната дата на финализиране на преговорите по отделните приходни позиции и респективно очакваните постъпления. Предлаганата от модулите „Възможности“ и „Приходни позиции“ функционалност може да бъде разширена чрез използване на опциите на модула {{forecasts_module}}, който от своя страна позволява да бъдат разбрани и прогнозирани търговските тенденции и да се фокусира дейността на търговските представители върху постигане на поставените квоти.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'История',
  'LBL_INVITEE' => 'Контакти',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Потенциални клиенти',
  'LBL_LEAD_SOURCE' => 'Източник:',
  'LBL_LIST_ACCOUNT_NAME' => 'Oрганизация',
  'LBL_LIST_AMOUNT' => 'Вероятен сценарий',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'Сума',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Отговорник',
  'LBL_LIST_DATE_CLOSED' => 'Затвори',
  'LBL_LIST_FORM_TITLE' => 'Списък с възможности:',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Име',
  'LBL_LIST_SALES_STAGE' => 'Етап на преговори',
  'LBL_MKTO_ID' => 'Идентификатор на потенциалния клиент в Marketo',
  'LBL_MKTO_SYNC' => 'Синхронизирай с Marketo®',
  'LBL_MODIFIED_ID' => 'Модифициран от',
  'LBL_MODIFIED_NAME' => 'Модифицирана от',
  'LBL_MODIFIED_USER' => 'Модифициран потребител',
  'LBL_MODULE_NAME' => 'Възможности',
  'LBL_MODULE_NAME_SINGULAR' => 'Възможност',
  'LBL_MODULE_TITLE' => 'Възможности',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'Моите реализирани възможности',
  'LBL_NAME' => 'Сделка',
  'LBL_NEW_FORM_TITLE' => 'Създаване на възможност',
  'LBL_NEXT_STEP' => 'Следваща стъпка:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Бележки',
  'LBL_OPPORTUNITY' => 'Свързан с възможност:',
  'LBL_OPPORTUNITY_NAME' => 'Възможност:',
  'LBL_OPPORTUNITY_ROLE' => 'Роля при реализиране на възможността',
  'LBL_OPPORTUNITY_TYPE' => 'Тип на възможността',
  'LBL_PIPELINE_TOTAL_IS' => 'Обща сума на текущи възможности',
  'LBL_PRIMARY_QUOTE_ID' => 'Основна оферта',
  'LBL_PROBABILITY' => 'Вероятност (%):',
  'LBL_PRODUCTS' => 'Оферирани продукти',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Оферирани позиции',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Проекти',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Проекти',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Оферти',
  'LBL_QUOTE_SUBPANEL_TITLE' => 'Оферти',
  'LBL_RAW_AMOUNT' => 'Приблизителна сума',
  'LBL_RLI' => 'Приходни позиции',
  'LBL_RLI_SUBPANEL_TITLE' => 'Приходни позиции',
  'LBL_SALES_STAGE' => 'Етап на преговори:',
  'LBL_SALES_STATUS' => 'Статус',
  'LBL_SEARCH_FORM_TITLE' => 'Търсене на възможности',
  'LBL_TEAM_ID' => 'Екип',
  'LBL_TIMEPERIODS' => 'Времеви периоди',
  'LBL_TIMEPERIOD_ID' => 'Идентификатор на времевия период',
  'LBL_TOP_OPPORTUNITIES' => 'Моите възможности',
  'LBL_TOTAL_OPPORTUNITIES' => 'Възможности',
  'LBL_TOTAL_RLIS' => '# от всички приходни позиции',
  'LBL_TYPE' => 'Категория:',
  'LBL_VIEW_FORM_TITLE' => 'Изглед с възможности',
  'LBL_WORKSHEET' => 'План',
  'LNK_CREATE' => 'Създай сделка',
  'LNK_IMPORT_OPPORTUNITIES' => 'Импортиране на възможности',
  'LNK_NEW_OPPORTUNITY' => 'Създаване на възможност',
  'LNK_OPPORTUNITY_LIST' => 'Списък с възможности',
  'LNK_OPPORTUNITY_REPORTS' => 'Справки за възможности',
  'MSG_DUPLICATE' => 'Създаденият запис има вероятност да дублира вече съществуваща възможност. Възможностите с близки имена са изброени отдолу.<br>Натиснете бутоина Съхрани ако желаете да създадете новия запис или бутона Отмени, за да се върнете в модула без да създавате нова възможност.',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => 'Не могат да бъдат изтривани Възможности, които съдържат приходни позиции',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Сигурни ли сте, че искате да изтриете тази връзка?',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'Сигурни ли сте, че искате да изтриете тази връзка?',
  'TPL_RLI_CREATE' => 'Трябва да има асоциирана приходна позиция с Възможността.',
  'TPL_RLI_CREATE_LINK_TEXT' => 'Въведете приходна позиция.',
  'UPDATE' => 'Възможности - Актуализация на валути',
  'UPDATE_BUGFOUND_COUNT' => 'Намерени проблеми:',
  'UPDATE_BUG_COUNT' => 'Намерени проблеми и опити за разрешаването им:',
  'UPDATE_COUNT' => 'Актуализирани записи:',
  'UPDATE_CREATE_CURRENCY' => 'Въвеждане на нова валута:',
  'UPDATE_DOLLARAMOUNTS' => 'Обновяване на сумата в щатски долари',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Актуализира сумите в полето U.S. Dollar на база на текущите разменни курсове на валутите. Стойността на това поле се използва при калкулации в графиката List View Currency Amounts.',
  'UPDATE_DONE' => 'Добави',
  'UPDATE_FAIL' => 'Не може да се актуализира -',
  'UPDATE_FIX' => 'Фиксиране на суми',
  'UPDATE_FIX_TXT' => 'Извършване фиксиране на грешни суми, посредством създаване на правилни знакови разделения от текущата сума. Променената сума се съхранява в поле amount_backup на базата данни. Ако по време на изпълнението получите съобщение за грешка, не се връщайте без да сте възстановили от архива; в противен случай архивът може да бъде презаписан с неверни данни.',
  'UPDATE_INCLUDE_CLOSE' => 'Включване на записите със статус "Приключени"',
  'UPDATE_MERGE' => 'Сливане на валути',
  'UPDATE_MERGE_TXT' => 'Сливане на няколко валути в една. Ако сте открили, че има много записи за една и съща валута, можете да ги слеете. Така се сливат и данните за валути от другите модули.',
  'UPDATE_NULL_VALUE' => 'Сумата NULL установена на 0 -',
  'UPDATE_RESTORE' => 'Възстановяване на суми',
  'UPDATE_RESTORE_COUNT' => 'Сумата в записите е възстановена:',
  'UPDATE_RESTORE_TXT' => 'Възстановяване на сумите от архива, създаден по време на фиксирането.',
  'UPDATE_VERIFY' => 'Проверка на сумата',
  'UPDATE_VERIFY_CURAMOUNT' => 'Текуща сума:',
  'UPDATE_VERIFY_FAIL' => 'Неуспешна проверка на запис:',
  'UPDATE_VERIFY_FIX' => 'Фиксиране на данни',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Нова сума:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Нова валута:',
  'UPDATE_VERIFY_TXT' => 'Проверка, че сумите в отделните възможности са валидни десетични числа, които съдържат само цифри (0-9) и разделители (.)',
  'WARNING_NO_DELETE_CLOSED_SELECTED' => 'Един или повече от селектираните записи съдържат приходни позиции и не могат да бъдат изтрити.',
);

