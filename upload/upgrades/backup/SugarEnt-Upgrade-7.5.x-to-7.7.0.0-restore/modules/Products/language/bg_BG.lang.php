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
  'ERR_DELETE_RECORD' => 'Трябва да определите номер на записа, за да изтриете този продукт.',
  'LBL_ACCOUNT_ID' => 'Организация',
  'LBL_ACCOUNT_NAME' => 'Организация:',
  'LBL_ASSET_NUMBER' => 'Инвентарен номер:',
  'LBL_ASSIGNED_TO_NAME' => 'Отговорник:',
  'LBL_ASSIGNED_USER_ID' => 'Отговорник',
  'LBL_ASSOCIATED_QUOTE' => 'Заглавие на офертата:',
  'LBL_BOOK_VALUE' => 'Продажна цена:',
  'LBL_BOOK_VALUE_DATE' => 'Дата на продажба:',
  'LBL_BOOK_VALUE_USDOLLAR' => 'Стойност (щатски долари):',
  'LBL_CALCULATED_LINE_ITEM_AMOUNT' => 'Сума на оферираните позиции',
  'LBL_CAMPAIGN_PRODUCT' => 'Приходна позиция по кампания',
  'LBL_CATEGORY' => 'Категория:',
  'LBL_CATEGORY_NAME' => 'Име на категорията:',
  'LBL_COMMIT_STAGE' => 'Commit Stage',
  'LBL_COMMIT_STAGE_FORECAST' => 'Прогноза',
  'LBL_CONTACT' => 'Контакт',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Контакти',
  'LBL_CONTACT_ID' => 'Контакт',
  'LBL_CONTACT_NAME' => 'Контакт:',
  'LBL_CONTRACTS' => 'Договори',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Договори',
  'LBL_CONVERT_TO_QUOTE_ERROR' => 'Грешка:',
  'LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE' => 'Възникна грешка при преобразуване на офериран продукт в Оферта',
  'LBL_COST_PRICE' => 'Себестойност:',
  'LBL_COST_USDOLLAR' => 'Себестойност (US Dollar)',
  'LBL_CREATED_USER' => 'Създаден потребител',
  'LBL_CURRENCY' => 'Валута:',
  'LBL_CURRENCY_ID' => 'Идентификатор на валутата:',
  'LBL_CURRENCY_RATE' => 'Валутен курс',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Символ на валутата',
  'LBL_DATE_CLOSED' => 'Дата на финализиране',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Expected Close Date Timestamp',
  'LBL_DATE_PURCHASED' => 'Закупен на:',
  'LBL_DATE_SUPPORT_EXPIRES' => 'Край на поддръжка:',
  'LBL_DATE_SUPPORT_STARTS' => 'Начало на поддръжка:',
  'LBL_DEAL_TOT' => 'Отстъпка:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Продукти',
  'LBL_DESCRIPTION' => 'Описание:',
  'LBL_DISCOUNT_AMOUNT' => 'Сума отстъпка',
  'LBL_DISCOUNT_AS_PERCENT' => 'Отстъпка в %',
  'LBL_DISCOUNT_PRICE' => 'Единична цена:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Дата на предоставяне на отстъпка:',
  'LBL_DISCOUNT_RATE' => 'Отстъпка',
  'LBL_DISCOUNT_RATE_USDOLLAR' => 'Отстъпка (US Dollar)',
  'LBL_DISCOUNT_TOTAL' => 'Обща отстъпка',
  'LBL_DISCOUNT_TOTAL_USDOLLAR' => 'Отстъпка (US долари)',
  'LBL_DISCOUNT_USDOLLAR' => 'Отстъпка (US Dollar)',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Документи',
  'LBL_EDITLAYOUT' => 'Редактиране на подредби',
  'LBL_EXPERT_ID' => 'Продуктов експерт',
  'LBL_EXPORT_CURRENCY_ID' => 'Валута',
  'LBL_EXT_PRICE' => 'Обща цена',
  'LBL_FORECAST' => 'Включи в прогнозата',
  'LBL_HELP_CREATE' => 'Модулът {{plural_module_name}} съдържа записи за продукти, които са продадени на клиенти или са в процес на продажба.

За да създадете нов запис в модул {{plural_module_name}}:
1. Въведете стойности в отделните полета.
 - Полетата маркирани като "Задължителни" се изисква да имат зададена стойнист преди да се пристъпи към съхраняване на записа.
 - Натиснете върху "Покажи повече", за да бъдат визуализирани допълнителни полета ако е необходимо.
2. Натиснете "Съхрани", за да запазите новия запис и да се върнете в предходната страница.
 - Изберете "Съхрани и разгледай", за да отворите автоматично детайли за новия запис.
 - Изберете "Съхрани и създай нов", за да пристъпите към създаване на друг нов запис в модул  {{plural_module_name}}.',
  'LBL_HELP_RECORD' => 'Модулът {{plural_module_name}} съдържа записи за продукти, които са продадени на клиенти или са в процес на продажба

- Редактирайте текущия запис като натиснете конкретно поле или използвате бутона „Редактирай“.
- Разгледайте или модифицирайте връзките с други записи в системата, като за целта визуализирате панела „Свързани записи“.
- Поставете коментари към текущия запис и разгледайте история на извършените промени свързани с него, като преминете в панела „Хронология“.
- Следвайте или харесайте текущия запис като използвате иконите, намиращи се в дясно от името му.
- Можете да извършвате допълнителни действия със записа като използвате падащото меню в дясно на бутона „Редактирай“.',
  'LBL_HELP_RECORDS' => 'Модулът {{plural_module_name}} съдържа записи за продукти, които са продадени на клиенти или са в процес на продажба. Списъкът на продаваните от вашата организация продукта се поддържа в продуктов каталог, който се поддържа от Администратор на системата. Когато създавате записи за {{plural_module_name}} вие можете да избирате продукти от продуктовия каталог или да създавате нови. Съществуват различни начини да създадете {{plural_module_name}} в SugarCRM, като за целта можете да използвате опциите на модулите {{plural_module_name}} и {{quotes_module}}, да дублирате съществуващ запис, да импортирате {{plural_module_name}} и други. След като даден {{module_name}} е въведен в системата, можете да разгледате и редактирате информацията за него през изгледа „Детайли за записа“.',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Потенциални клиенти',
  'LBL_LEAD_SOURCE' => 'Източник на потенциалния клиент',
  'LBL_LIST_ACCOUNT_NAME' => 'Oрганизация',
  'LBL_LIST_CONTACT_NAME' => 'Контакт',
  'LBL_LIST_COST_PRICE' => 'Себестойност',
  'LBL_LIST_DATE_PURCHASED' => 'Закупен на',
  'LBL_LIST_DISCOUNT_PRICE' => 'Цена',
  'LBL_LIST_FORM_TITLE' => 'Списък с продукти:',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Партиден No.',
  'LBL_LIST_LIST_PRICE' => 'Списък',
  'LBL_LIST_MANUFACTURER' => 'Производител',
  'LBL_LIST_NAME' => 'Оферирана позиция',
  'LBL_LIST_PRICE' => 'Каталожна цена:',
  'LBL_LIST_QUANTITY' => 'Количество',
  'LBL_LIST_QUOTE_NAME' => 'Заглавие на офертата',
  'LBL_LIST_STATUS' => 'Статус',
  'LBL_LIST_SUPPORT_EXPIRES' => 'Поддръжка до',
  'LBL_LIST_USDOLLAR' => 'Каталожна цена (US Dollar)',
  'LBL_MANUFACTURER' => 'Производител:',
  'LBL_MANUFACTURERS' => 'Производители',
  'LBL_MANUFACTURER_NAME' => 'Име на производителя:',
  'LBL_MEMBER_OF' => 'Член на:',
  'LBL_MFT_PART_NUM' => 'Партиден номер:(производител)',
  'LBL_MODIFIED_USER' => 'Модифициран потребител',
  'LBL_MODULE_NAME' => 'Приходни позиции',
  'LBL_MODULE_NAME_SINGULAR' => 'Приходна позиция',
  'LBL_MODULE_TITLE' => 'Приходни позиции: Начало',
  'LBL_NAME' => 'Име',
  'LBL_NEW_FORM_TITLE' => 'Въвеждане на продукт',
  'LBL_NEXT_STEP' => 'Следваща стъпка:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Бележки',
  'LBL_OPPORTUNITY' => 'Възможност',
  'LBL_OPPORTUNITY_ID' => 'Идентификатор на възможността',
  'LBL_PRICING_FACTOR' => 'Ценообразуващ фактор',
  'LBL_PRICING_FORMULA' => 'Формула за ценообразуване:',
  'LBL_PROBABILITY' => 'Вероятност (%)',
  'LBL_PRODUCT' => 'Оферирана позиция:',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Оферирани позиции',
  'LBL_PRODUCT_CATEGORIES' => 'Продуктови категории',
  'LBL_PRODUCT_TEMPLATE' => 'Продуктов шаблон:',
  'LBL_PRODUCT_TEMPLATE_ID' => 'Шаблон на продукт:',
  'LBL_PRODUCT_TYPES' => 'Типове продукти',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Проекти',
  'LBL_QUANTITY' => 'Количество:',
  'LBL_QUOTE' => 'Оферта',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Оферти',
  'LBL_QUOTE_ID' => 'Оферта',
  'LBL_QUOTE_NAME' => 'Заглавие на офертата:',
  'LBL_RELATED_PRODUCTS' => 'Свързани оферирани позции',
  'LBL_RELATED_PRODUCTS_TITLE' => 'Оферирани позиции',
  'LBL_REVENUELINEITEM' => 'Приходна позиция',
  'LBL_REVENUELINEITEMS' => 'Приходни позиции',
  'LBL_REVENUELINEITEM_ID' => 'Идентификатор на приходна позиция:',
  'LBL_REVENUELINEITEM_NAME' => 'Име на приходна позиция:',
  'LBL_SALES_STAGE' => 'Етап на преговори',
  'LBL_SALES_STATUS' => 'Статус на приходна позиция',
  'LBL_SEARCH_FORM_TITLE' => 'Търсене в модул "Продукти"',
  'LBL_SELECT_DISCOUNT' => 'Отстъпка в %',
  'LBL_SERIAL_NUMBER' => 'Сериен номер:',
  'LBL_STATUS' => 'Статус:',
  'LBL_SUPPORT_CONTACT' => 'Отговорник по поддръжка:',
  'LBL_SUPPORT_DESCRIPTION' => 'Информация за поддръжката:',
  'LBL_SUPPORT_NAME' => 'Екип по поддръжка:',
  'LBL_SUPPORT_TERM' => 'Период на поддръжка:',
  'LBL_TAX_CLASS' => 'Форма на данъчно облагане:',
  'LBL_TYPE' => 'Категория:',
  'LBL_URL' => 'URL на продукта:',
  'LBL_VENDOR_PART_NUM' => 'Партиден номер(доставчик):',
  'LBL_WEBSITE' => 'Сайт',
  'LBL_WEIGHT' => 'Тегло:',
  'LNK_IMPORT_PRODUCTS' => 'Импортиране на продукти',
  'LNK_NEW_PRODUCT' => 'Въвеждане на продукт',
  'LNK_PRODUCT_LIST' => 'Списък с продукти',
  'NTC_DELETE_CONFIRMATION' => 'Сигурни ли сте, че желаете да изтриете този запис?',
  'NTC_REMOVE_CONFIRMATION' => 'Сигурни ли сте, че искате да изтриете тази връзка?',
);

