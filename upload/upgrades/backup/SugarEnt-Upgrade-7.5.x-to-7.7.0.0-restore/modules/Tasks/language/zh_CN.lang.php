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
  'DATE_FORMAT' => '(年-月-日)',
  'ERR_DELETE_RECORD' => '必须指定记录编号才能删除客户。',
  'ERR_INVALID_HOUR' => '请输入0到24之间的小时数',
  'LBL_ACTIVITIES_REPORTS' => '活动报告',
  'LBL_ASSIGNED_TO_NAME' => '指派给:',
  'LBL_ASSIGNED_USER' => '负责人',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => '联系人:',
  'LBL_CONTACT_FIRST_NAME' => '联系人的名',
  'LBL_CONTACT_ID' => '联系人编号:',
  'LBL_CONTACT_LAST_NAME' => '联系人的姓',
  'LBL_CONTACT_NAME' => '联系人名称',
  'LBL_CONTACT_PHONE' => '联系人电话:',
  'LBL_DATE_DUE' => '截止日期',
  'LBL_DATE_DUE_FLAG' => '无截止日期',
  'LBL_DATE_START_FLAG' => '无开始日期',
  'LBL_DEFAULT_PRIORITY' => '中',
  'LBL_DESCRIPTION' => '说明:',
  'LBL_DESCRIPTION_INFORMATION' => '说明信息',
  'LBL_DUE_DATE' => '截止日期:',
  'LBL_DUE_DATE_AND_TIME' => '截止日期 & 时间:',
  'LBL_DUE_TIME' => '截止时间:',
  'LBL_EDITLAYOUT' => '编辑布局',
  'LBL_EMAIL' => '电子邮件地址:',
  'LBL_EMAIL_ADDRESS' => '电子邮件地址:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => '被分配用户ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => '被分配者名称',
  'LBL_EXPORT_CREATED_BY' => '由ID创建',
  'LBL_EXPORT_MODIFIED_USER_ID' => '由ID修改',
  'LBL_EXPORT_PARENT_ID' => '关联到ID',
  'LBL_EXPORT_PARENT_TYPE' => '关联到模块',
  'LBL_HELP_CREATE' => 'The {{module_name}} module consists of individual people who are unqualified prospects that you have some information on, but is not yet a qualified {{leads_singular_module}}.

To create a {{module_name}}:
1. Provide values for the fields as desired.
 - Fields marked "Required" must be completed prior to saving.
 - Click "Show More" to expose additional fields if necessary.
2. Click "Save" to finalize the new record and return to the previous page.
 - Choose "Save and view" to open the new {{module_name}} in record view.
 - Choose "Save and create new" to immediately create another new {{module_name}}.',
  'LBL_HELP_RECORD' => 'The {{module_name}} module consists of individual people who are unqualified prospects that you have some information on, but is not yet a qualified {{leads_singular_module}}.

- Edit this record&#39;s fields by clicking an individual field or the Edit button.
- View or modify links to other records in the subpanels by toggling the bottom left pane to "Data View".
- Make and view user comments and record change history in the {{activitystream_singular_module}} by toggling the bottom left pane to "Activity Stream".
- Follow or favorite this record using the icons to the right of the record name.
- Additional actions are available in the dropdown Actions menu to the right of the Edit button.',
  'LBL_HELP_RECORDS' => 'The {{module_name}} module consists of individual people who are unqualified prospects that you have some information on, but is not yet a qualified {{leads_singular_module}}. Information (e.g. name, email address) regarding these {{plural_module_name}} are normally acquired from business cards you receive while attending various trades shows, conferences, etc. {{plural_module_name}} in Sugar are stand-alone records as they are not related to {{contacts_module}}, {{leads_module}}, {{accounts_module}}, or {{opportunities_module}}. There are various ways you can create {{plural_module_name}} in Sugar such as via the {{plural_module_name}} module, importing {{plural_module_name}}, etc. Once the {{module_name}} record is created, you can view and edit information pertaining to the {{module_name}} via the {{plural_module_name}} Record view.',
  'LBL_HISTORY_SUBPANEL_TITLE' => '记录',
  'LBL_LIST_ASSIGNED_TO_NAME' => '指派的用户',
  'LBL_LIST_CLOSE' => '关闭',
  'LBL_LIST_COMPLETE' => '完成:',
  'LBL_LIST_CONTACT' => '联系人',
  'LBL_LIST_DATE_MODIFIED' => '修改日期',
  'LBL_LIST_DUE_DATE' => '截止日期',
  'LBL_LIST_DUE_TIME' => '截止时间',
  'LBL_LIST_FORM_TITLE' => '任务列表',
  'LBL_LIST_MY_TASKS' => '我的公开任务',
  'LBL_LIST_PRIORITY' => '优先级',
  'LBL_LIST_RELATED_TO' => '相关',
  'LBL_LIST_START_DATE' => '开始日期',
  'LBL_LIST_START_TIME' => '开始时间',
  'LBL_LIST_STATUS' => '状态',
  'LBL_LIST_SUBJECT' => '主题',
  'LBL_MODULE_NAME' => '任务',
  'LBL_MODULE_NAME_SINGULAR' => '任务',
  'LBL_MODULE_TITLE' => '任务: 首页',
  'LBL_NAME' => '名称:',
  'LBL_NEW_FORM_DUE_DATE' => '截止日期:',
  'LBL_NEW_FORM_DUE_TIME' => '截止时间:',
  'LBL_NEW_FORM_SUBJECT' => '主题:',
  'LBL_NEW_FORM_TITLE' => '新增任务',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => '无',
  'LBL_NOTES_SUBPANEL_TITLE' => '记录',
  'LBL_PARENT_ID' => '上级编号:',
  'LBL_PARENT_NAME' => '上级类型:',
  'LBL_PHONE' => '电话:',
  'LBL_PRIORITY' => '优先级:',
  'LBL_REVENUELINEITEMS' => '收入线项目',
  'LBL_SEARCH_FORM_TITLE' => '任务搜索',
  'LBL_START_DATE' => '开始日期:',
  'LBL_START_DATE_AND_TIME' => '开始日期& 时间:',
  'LBL_START_TIME' => '开始时间:',
  'LBL_STATUS' => '状态:',
  'LBL_SUBJECT' => '主题:',
  'LBL_TASK' => '任务:',
  'LBL_TASK_CLOSE_SUCCESS' => '任务成功结束',
  'LBL_TASK_INFORMATION' => '任务查看',
  'LNK_IMPORT_TASKS' => '导入任务',
  'LNK_NEW_TASK' => '新增任务',
  'LNK_TASK_LIST' => '查看任务',
);

