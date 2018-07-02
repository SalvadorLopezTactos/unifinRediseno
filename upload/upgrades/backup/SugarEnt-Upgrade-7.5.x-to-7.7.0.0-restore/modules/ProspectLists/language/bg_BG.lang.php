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
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Организации',
  'LBL_ASSIGNED_TO' => 'Отговорник',
  'LBL_CAMPAIGNS_SUBPANEL_TITLE' => 'Кампании',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Контакти',
  'LBL_COPY_PREFIX' => 'Копие на',
  'LBL_CREATED' => 'Създадено от',
  'LBL_CREATED_BY' => 'Създадено от',
  'LBL_DATE_CREATED' => 'Създадено на:',
  'LBL_DATE_ENTERED' => 'Въведено на',
  'LBL_DATE_LAST_MODIFIED' => 'Модифицирано на:',
  'LBL_DATE_MODIFIED' => 'Модифицирано на',
  'LBL_DESCRIPTION' => 'Описание',
  'LBL_DOMAIN' => 'Блокиран домейн:',
  'LBL_DOMAIN_NAME' => 'Име на домейн',
  'LBL_ENTRIES' => 'Брой записи в групата:',
  'LBL_HELP_CREATE' => 'Записите в модула {{plural_module_name}} съдържат списъци с организации или лица, които могат да бъдат включвани в маркетинговата комуникация през модул {{campaigns_module}}.
За да създадете нов запис в модул {{plural_module_name}}:
1. Въведете стойности в отделните полета.
 - Полетата маркирани като "Задължителни" се изисква да имат зададена стойнист преди да се пристъпи към съхраняване на записа.
 - Натиснете върху "Покажи повече", за да бъдат визуализирани допълнителни полета ако е необходимо.
2. Натиснете "Съхрани", за да запазите новия запис и да се върнете в предходната страница.
 - Изберете "Съхрани и разгледай", за да отворите автоматично детайли за новия запис.
 - Изберете "Съхрани и създай нов", за да пристъпите към създаване на друг нов запис в модул {{plural_module_name}}..
 3. След съхраняване на записа използвайте панелите за Целеви клиенти, Организации, Контакти, Потенциални клиенти и потребители, за да добавите записи към целевата група.',
  'LBL_HELP_RECORD' => 'Записите в модула {{plural_module_name}} съдържат списъци с организации или лица, които могат да бъдат включвали в маркетинговата комуникация през модул {{campaigns_module}}.

- Редактирайте текущия запис като натиснете конкретно поле или използвате бутона „Редактирай“.
- Разгледайте или модифицирайте връзките с други записи в системата, като за целта визуализирате панела „Свързани записи“.
- Поставете коментари към текущия запис и разгледайте история на извършените промени свързани с него, като преминете в панела „Хронология“.
- Следвайте или харесайте текущия запис като използвате иконите, намиращи се в дясно от името му.
- Можете да извършвате допълнителни действия със записа като използвате падащото меню в дясно на бутона „Редактирай“.',
  'LBL_HELP_RECORDS' => 'Записите в модула {{plural_module_name}} съдържат списъци с организации или лица, които могат да бъдат включвани в маркетинговата комуникация през модул {{plural_campaign_module}}. Отделните {{plural_module_name}} могат да съдържат комбинация от {{contacts_module}}, {{leads_module}}, Потребители и {{accounts_module}}. Групирането на целевите клиенти може да се извършва според предефинирани критерии, в това число възрастова група, географски признак или история на сделките.',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Потенциални клиенти',
  'LBL_LIST_DESCRIPTION' => 'Описание',
  'LBL_LIST_END_DATE' => 'Крайна дата',
  'LBL_LIST_ENTRIES' => 'Брой записи в групата',
  'LBL_LIST_FORM_TITLE' => 'Списък с целеви групи',
  'LBL_LIST_PROSPECTLIST_NAME' => 'Име',
  'LBL_LIST_PROSPECT_LIST_NAME' => 'Целева група',
  'LBL_LIST_TYPE' => 'Тип',
  'LBL_LIST_TYPE_LIST_NAME' => 'Тип',
  'LBL_LIST_TYPE_NO' => 'Тип',
  'LBL_MARKETING_ID' => 'Послание',
  'LBL_MARKETING_MESSAGE' => 'Изращане на маркетингово съобщение',
  'LBL_MARKETING_NAME' => 'Маркетингово послание',
  'LBL_MODIFIED' => 'Модифицирано от',
  'LBL_MODIFIED_BY' => 'Модифицирано от',
  'LBL_MODULE_ID' => 'Целеви групи',
  'LBL_MODULE_NAME' => 'Целеви групи',
  'LBL_MODULE_NAME_SINGULAR' => 'Целева група',
  'LBL_MODULE_TITLE' => 'Целеви групи',
  'LBL_MORE_DETAIL' => 'Детайли',
  'LBL_NAME' => 'Име',
  'LBL_NEW_FORM_TITLE' => 'Нова целева група',
  'LBL_PROSPECTS_SUBPANEL_TITLE' => 'Целеви клиенти',
  'LBL_PROSPECT_LISTS_SUBPANEL_TITLE' => 'Целеви групи',
  'LBL_PROSPECT_LIST_NAME' => 'Име',
  'LBL_SEARCH_FORM_TITLE' => 'Търсене в модул "Целеви групи"',
  'LBL_TEAM' => 'Екип',
  'LBL_TYPE' => 'Тип',
  'LBL_USERS_SUBPANEL_TITLE' => 'Потребители',
  'LNK_CAMPAIGN_LIST' => 'Кампании',
  'LNK_NEW_CAMPAIGN' => 'Създаване на кампания',
  'LNK_NEW_PROSPECT' => 'Създаване на целеви клиент',
  'LNK_NEW_PROSPECT_LIST' => 'Създаване на целева група',
  'LNK_PROSPECT_LIST' => 'Целеви клиенти',
  'LNK_PROSPECT_LIST_LIST' => 'Списък с целеви групи',
);

