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
  'ERR_DELETE_RECORD' => '您必须指定一个记录编号才能删除这个缺陷.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => '客户',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => '活动',
  'LBL_ASSIGNED_TO_NAME' => '指派',
  'LBL_BUG' => '缺陷追踪:',
  'LBL_BUG_INFORMATION' => '缺陷概述',
  'LBL_BUG_NUMBER' => '缺陷编号:',
  'LBL_BUG_SUBJECT' => '缺陷主题:',
  'LBL_CASES_SUBPANEL_TITLE' => '客户反馈',
  'LBL_CONTACTS_SUBPANEL_TITLE' => '联系人',
  'LBL_CONTACT_BUG_TITLE' => '联系人-缺陷追踪:',
  'LBL_CONTACT_NAME' => '联系人姓名:',
  'LBL_CONTACT_ROLE' => '角色:',
  'LBL_CREATED_BY' => '创建者:',
  'LBL_DATE_CREATED' => '创建日期:',
  'LBL_DATE_LAST_MODIFIED' => '修改日期:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => '缺陷追踪',
  'LBL_DESCRIPTION' => '说明:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => '文件',
  'LBL_EXPORT_ASSIGNED_USER_ID' => '负责人ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => '负责人用户名',
  'LBL_EXPORT_CREATED_BY' => '创建人ID',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => '与显示名字绑定',
  'LBL_EXPORT_MODIFIED_USER_ID' => '修改人ID',
  'LBL_FIXED_IN_RELEASE' => '在现有版本上修复:',
  'LBL_FOUND_IN_RELEASE' => '在现有版本上创建:',
  'LBL_FOUND_IN_RELEASE_NAME' => '在显示名称中查到',
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
  'LBL_HISTORY_SUBPANEL_TITLE' => '历史记录',
  'LBL_INVITEE' => '联系人',
  'LBL_LIST_ACCOUNT_NAME' => '客户名称',
  'LBL_LIST_ASSIGNED_TO_NAME' => '指定使用者',
  'LBL_LIST_CONTACT_NAME' => '联系人名称',
  'LBL_LIST_EMAIL_ADDRESS' => '邮箱地址',
  'LBL_LIST_FIXED_IN_RELEASE' => '在现有版本上修复',
  'LBL_LIST_FORM_TITLE' => '缺陷列表',
  'LBL_LIST_LAST_MODIFIED' => '最新修改',
  'LBL_LIST_MY_BUGS' => '指派给我的缺陷',
  'LBL_LIST_NUMBER' => '编号.',
  'LBL_LIST_PHONE' => '联系电话',
  'LBL_LIST_PRIORITY' => '优先级',
  'LBL_LIST_RELEASE' => '版本',
  'LBL_LIST_RESOLUTION' => '分析',
  'LBL_LIST_STATUS' => '状态',
  'LBL_LIST_SUBJECT' => '主题',
  'LBL_LIST_TYPE' => '类型',
  'LBL_MODIFIED_BY' => '最新修改人:',
  'LBL_MODULE_ID' => '缺陷追踪',
  'LBL_MODULE_NAME' => '缺陷追踪',
  'LBL_MODULE_NAME_SINGULAR' => '缺陷追踪',
  'LBL_MODULE_TITLE' => '缺陷追踪: 首页',
  'LBL_NEW_FORM_TITLE' => '新增缺陷',
  'LBL_NOTES_SUBPANEL_TITLE' => '记录',
  'LBL_NUMBER' => '编号:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => '如果您想报告已经找到了新的问题，您可以点击这里举报一个新的问题。',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => '您可以通过提供一个搜索条件来过滤文章列表',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => '例如，您可以使用它来找到一篇感兴趣的关于某个特定话题的文章。',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => '该的知识库模块的用于处理发表的文章。使用下面的箭头开始快速的游览',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => '此页显示发表的文章列表。',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => '点击此处您将随时返回到知识库。',
  'LBL_PORTAL_VIEWABLE' => '可视门户站点',
  'LBL_PRIORITY' => '优先级:',
  'LBL_PRODUCT_CATEGORY' => '类别:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => '项目',
  'LBL_RELEASE' => '版本:',
  'LBL_RESOLUTION' => '分析:',
  'LBL_SEARCH_FORM_TITLE' => '缺陷搜索',
  'LBL_SHOW_IN_PORTAL' => '显示在门户',
  'LBL_SHOW_MORE' => '显示更多缺陷',
  'LBL_SOURCE' => '来源:',
  'LBL_STATUS' => '状态:',
  'LBL_SUBJECT' => '主题:',
  'LBL_SYSTEM_ID' => '系统编号',
  'LBL_TYPE' => '类型:',
  'LBL_WORK_LOG' => '工作日志:',
  'LNK_BUG_LIST' => '缺陷',
  'LNK_BUG_REPORTS' => '缺陷报表',
  'LNK_CREATE' => '汇报缺陷',
  'LNK_CREATE_WHEN_EMPTY' => '现在报告一个缺陷。',
  'LNK_IMPORT_BUGS' => '输入缺陷',
  'LNK_NEW_BUG' => '报表缺陷',
  'NTC_DELETE_CONFIRMATION' => '您确定要从缺陷中移除此联系人吗?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => '您确定要从这个客户中移除这个缺陷?',
  'NTC_REMOVE_INVITEE' => '您确定要从缺陷里除去这个联系人吗?',
);

