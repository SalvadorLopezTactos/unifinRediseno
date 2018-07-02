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
  'ERR_DELETE_RECORD' => 'Вы должны указать номер записи перед удалением контрагента.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Контрагенты',
  'LBL_ACCOUNT_ID' => 'Контрагент',
  'LBL_ACCOUNT_NAME' => 'Контрагент',
  'LBL_ACCOUNT_NAME_MOD' => 'Контрагент',
  'LBL_ACCOUNT_NAME_OWNER' => 'Контрагент: Владелец',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Мероприятия',
  'LBL_ASSIGNED_TO_NAME' => 'Ответственный (-ая)',
  'LBL_ASSIGNED_USER_NAME_MOD' => 'Ответственный пользователь',
  'LBL_ASSIGNED_USER_NAME_OWNER' => 'Ответственный пользователь: Владелец',
  'LBL_ATTACH_NOTE' => 'Добавить заметку',
  'LBL_BUGS_SUBPANEL_TITLE' => 'Ошибки',
  'LBL_CASE' => 'Обращение:',
  'LBL_CASE_FROM_TWITTER_TITLE' => 'Tweet',
  'LBL_CASE_INFORMATION' => 'Обзор обращения',
  'LBL_CASE_NUMBER' => 'Номер обращения:',
  'LBL_CASE_SUBJECT' => 'Тема обращения:',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Контакты',
  'LBL_CONTACT_CASE_TITLE' => 'Контакт-Обращение:',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Email-сообщения соответствующих контактов',
  'LBL_CONTACT_NAME' => 'Контактное лицо:',
  'LBL_CONTACT_ROLE' => 'Роль:',
  'LBL_CREATED_BY_NAME_MOD' => 'Создано',
  'LBL_CREATED_BY_NAME_OWNER' => 'Создано: Владелец',
  'LBL_CREATED_USER' => 'Создано пользователем',
  'LBL_CREATE_KB_DOCUMENT' => 'Добавить статью в Базе знаний',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Обращения',
  'LBL_DESCRIPTION' => 'Описание:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Документы',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Ответственный (ID)',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Ответственный пользователь',
  'LBL_EXPORT_CREATED_BY' => 'Создано (ID):',
  'LBL_EXPORT_CREATED_BY_NAME' => 'Создано Пользователем',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Изменено (ID):',
  'LBL_EXPORT_TEAM_COUNT' => 'Team Count',
  'LBL_FILENANE_ATTACHMENT' => 'Приложение',
  'LBL_HELP_CREATE' => '{plural_module_name}} модуль используется, чтобы отслеживать и управлять ошибками, связанными с продуктом или услугой, о которых сообщают ваши клиенты.

Чтобы создать {{module_name}}:
1. Укажите значения полей.
- Поля с пометкой "Обязательно" должны быть заполнены перед сохранением.
- Нажмите "Показать больше", чтобы отобразить дополнительные поля при необходимости.
2. Нажмите "Сохранить" для сохранения новой записи и возвращения на предыдущую страницу.
- Выберите "Сохранить и просмотреть", чтобы открыть новый {{module_name}} в режиме просмотра записи.
- Выберите "Сохранить и создать", чтобы сразу создать новый {{module_name}}.',
  'LBL_HELP_RECORD' => '{{plural_module_name}} модуль используется, чтобы отслеживать и управлять ошибками, связанными с продуктом или услугой, о которых сообщают ваши клиенты.

- Чтобы редактировать поля данной записи, нажмите на самом поле или кликните на кнопку Редактировать.
- Чтобы просмотреть или изменить ссылки, ведущие к другим записям, на субпанеле переключите левую нижнюю панель на "Просмотр данных".
- Чтобы оставлять и просматривать пользовательские комментарии, а также изменять историю в рамках одной записи в {{activitystream_singular_module}}, переключите левую нижнюю панель на "Лента активностей".
- Чтобы подписаться или добавить в Избранное данную запись, используйте иконки справа от записи.
- Дополнительные действия доступны в выпадающем меню Действий справа от кнопки Редактировать.',
  'LBL_HELP_RECORDS' => '{{plural_module_name}} модуль используется, чтобы отслеживать и управлять ошибками, связанными с продуктом или услугой, о которых сообщают ваши клиенты. {{plural_module_name}} относятся к {{accounts_singular_module}} записи, и множественные {{plural_module_name}} могут быть связаны с единичным {{accounts_singular_module}}. Существуют разные способы создания {{plural_module_name}} в Sugar как и через {{plural_module_name}} модуль, импорт {{plural_module_name}}, или конвертацию e-mail обращения. Как только {{module_name}} создан, вы можете просмотреть и редактировать информацию, относящуюся к {{module_name}} в {{module_name}} режиме просмотра записи. Каждая {{module_name}} запись может быть соотнесена с другими записями Sugar, такими как {{calls_module}}, {{contacts_module}}, {{bugs_module}}, и многими другими.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'История',
  'LBL_INVITEE' => 'Контакты',
  'LBL_KBDOCUMENTS_SUBPANEL_TITLE' => 'База Знаний',
  'LBL_LIST_ACCOUNT_NAME' => 'Контрагент',
  'LBL_LIST_ASSIGNED' => 'Ответственный (-ая):',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Ответственный (-ая)',
  'LBL_LIST_CLOSE' => 'Закрыть',
  'LBL_LIST_DATE_CREATED' => 'Дата создания',
  'LBL_LIST_FORM_TITLE' => 'Список обращений',
  'LBL_LIST_LAST_MODIFIED' => 'Последнее изменение',
  'LBL_LIST_MY_CASES' => 'Мои открытые обращения',
  'LBL_LIST_NUMBER' => 'Ном.',
  'LBL_LIST_PRIORITY' => 'Приоритет',
  'LBL_LIST_STATUS' => 'Статус',
  'LBL_LIST_SUBJECT' => 'Тема',
  'LBL_MEMBER_OF' => 'Контрагент',
  'LBL_MODIFIED_BY_NAME_MOD' => 'Изменено: Владелец',
  'LBL_MODIFIED_BY_NAME_OWNER' => 'Изменено: Владелец',
  'LBL_MODIFIED_USER' => 'Изменено пользователем',
  'LBL_MODIFIED_USER_NAME' => 'Изменено Пользователем',
  'LBL_MODIFIED_USER_NAME_MOD' => 'Изменено пользователем: Владелец',
  'LBL_MODIFIED_USER_NAME_OWNER' => 'Изменено пользователем: Владелец',
  'LBL_MODULE_NAME' => 'Обращения',
  'LBL_MODULE_NAME_SINGULAR' => 'Обращение',
  'LBL_MODULE_TITLE' => 'Обращения: Главная',
  'LBL_NEW_FORM_TITLE' => 'Новое обращение',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Заметки',
  'LBL_NUMBER' => 'Номер:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Если вы хотите оформить кейс в поддержку, нажмите здесь, чтобы создать новый кейс.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Вы можете отфильтровать список обращений по поисковому запросу.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'К примеру, Вы можете воспользоваться этим для поиска кейса, который был уже оформлен.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'Модуль обращений для управления обращениями в поддержку. Используйте стрелки внизу для быстрого ознакомления с модулем',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Эта страница выводит список существующих обращений, связанных с Вашим аккаунтом',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Для возврата в предыдущее окно в любое время нажмите здесь.',
  'LBL_PORTAL_VIEWABLE' => 'Отобразить в портале',
  'LBL_PRIORITY' => 'Приоритет:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Проекты',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Проекты',
  'LBL_RESOLUTION' => 'Решение:',
  'LBL_SEARCH_FORM_TITLE' => 'Найти обращение',
  'LBL_SHOW_IN_PORTAL' => 'Обзор в портале',
  'LBL_SHOW_MORE' => 'Показать больше обращений',
  'LBL_SOURCE' => 'Источник:',
  'LBL_STATUS' => 'Статус:',
  'LBL_SUBJECT' => 'Тема:',
  'LBL_SYSTEM_ID' => 'Системный ID',
  'LBL_TEAM_COUNT_MOD' => 'Team Count Mod',
  'LBL_TEAM_COUNT_OWNER' => 'Team Count Owner',
  'LBL_TEAM_NAME_MOD' => 'Имя команды',
  'LBL_TEAM_NAME_OWNER' => 'Имя команды: Владелец',
  'LBL_TYPE' => 'Тип',
  'LBL_WORK_LOG' => 'Рабочий лог:',
  'LNK_CASE_LIST' => 'Просмотр обращений',
  'LNK_CASE_REPORTS' => 'Просмотр отчетов по обращениям',
  'LNK_CREATE' => 'Новое обращение',
  'LNK_CREATE_WHEN_EMPTY' => 'Создать обращение сейчас.',
  'LNK_IMPORT_CASES' => 'Импорт обращений',
  'LNK_NEW_CASE' => 'Новое обращение',
  'NTC_REMOVE_FROM_BUG_CONFIRMATION' => 'Вы действительно хотите удалить это обращение из данной ошибки?',
  'NTC_REMOVE_INVITEE' => 'Вы действительно хотите удалить этот контакт из данного обращения?',
);

