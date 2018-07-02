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
  'ERR_DELETE_RECORD' => '必须指定记录编号才能删除客户。',
  'ERR_REMOVING_ATTACHMENT' => '移除附件失败...',
  'LBL_ACCOUNT_ID' => '客户编号：',
  'LBL_ACTIVITIES_REPORTS' => '活动报表',
  'LBL_CASE_ID' => '客户反馈编号：',
  'LBL_CLOSE' => '关闭：',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => '联系人编号：',
  'LBL_CONTACT_NAME' => '联系人：',
  'LBL_CREATED_BY' => '创建人',
  'LBL_DATE_ENTERED' => '创建日期',
  'LBL_DATE_MODIFIED' => '修改日期',
  'LBL_DEFAULT_SUBPANEL_TITLE' => '备忘录',
  'LBL_DELETED' => '删除',
  'LBL_DESCRIPTION' => '备忘录',
  'LBL_EDITLAYOUT' => '编辑布局',
  'LBL_EMAIL_ADDRESS' => '电子邮件地址：',
  'LBL_EMAIL_ATTACHMENT' => '电子邮件附件',
  'LBL_EMBED_FLAG' => '嵌入到电子邮件中？',
  'LBL_EXPORT_PARENT_ID' => '与ID相关',
  'LBL_EXPORT_PARENT_TYPE' => '与模块相关',
  'LBL_FILENAME' => '附件：',
  'LBL_FILE_MIME_TYPE' => 'Mime类型',
  'LBL_FILE_URL' => '文件地址',
  'LBL_FIRST_NAME' => '名字',
  'LBL_HELP_CREATE' => 'To create a {{module_name}}:
1. Provide values for the fields as desired.
 - Fields marked "Required" must be completed prior to saving.
 - Click "Show More" to expose additional fields if necessary.
2. Click "Save" to finalize the new record and return to the previous page.
 - Choose "Save and view" to open the new {{module_name}} in record view.
 - Choose "Save and create new" to immediately create another new {{module_name}}.',
  'LBL_HELP_RECORD' => 'The {{plural_module_name}} module consists of individual {{plural_module_name}} that contain text or an attachment pertinent to the related record.

- Edit this record&#39;s fields by clicking an individual field or the Edit button.
- View or modify links to other records in the subpanels by toggling the bottom left pane to "Data View".
- Make and view user comments and record change history in the {{activitystream_singular_module}} by toggling the bottom left pane to "Activity Stream".
- Follow or favorite this record using the icons to the right of the record name.
- Additional actions are available in the dropdown Actions menu to the right of the Edit button.',
  'LBL_HELP_RECORDS' => 'The {{plural_module_name}} module consists of individual {{plural_module_name}} that contain text or an attachment pertinent to the related record. {{module_name}} records can be related to one record in most modules via the flex relate field and can also be related to a single {{contacts_singular_module}}. {{plural_module_name}} can hold generic text about a record or even an attachment related to the record. There are various ways you can create {{plural_module_name}} in Sugar such as via the {{plural_module_name}} module, importing {{plural_module_name}}, via History subpanels, etc. Once the {{module_name}} record is created, you can view and edit information pertaining to the {{module_name}} via the {{plural_module_name}} record view. Each {{module_name}} record may then relate to other Sugar records such as {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, and many others.',
  'LBL_LAST_NAME' => '姓',
  'LBL_LEAD_ID' => '潜在客户编号：',
  'LBL_LIST_ASSIGNED_TO_NAME' => '负责人',
  'LBL_LIST_CONTACT' => '联系人',
  'LBL_LIST_CONTACT_NAME' => '联系人',
  'LBL_LIST_DATE_MODIFIED' => '最终修改',
  'LBL_LIST_EDIT_BUTTON' => '编辑',
  'LBL_LIST_FILENAME' => '附件',
  'LBL_LIST_FORM_TITLE' => '备忘录列表',
  'LBL_LIST_RELATED_TO' => '关联到',
  'LBL_LIST_STATUS' => '状态',
  'LBL_LIST_SUBJECT' => '主题',
  'LBL_MEMBER_OF' => '成员：',
  'LBL_MODIFIED_BY' => '修改人',
  'LBL_MODULE_NAME' => '备忘录',
  'LBL_MODULE_NAME_SINGULAR' => '备忘录',
  'LBL_MODULE_TITLE' => '备忘录：首页',
  'LBL_MY_NOTES_DASHLETNAME' => '我的备忘录',
  'LBL_NEW_FORM_BTN' => '添加注释',
  'LBL_NEW_FORM_TITLE' => '新增备忘录或添加附件',
  'LBL_NOTE' => '备忘录：',
  'LBL_NOTES_SUBPANEL_TITLE' => '附件',
  'LBL_NOTE_INFORMATION' => '备忘录概述',
  'LBL_NOTE_STATUS' => '备忘录',
  'LBL_NOTE_SUBJECT' => '主题：',
  'LBL_OC_FILE_NOTICE' => '查看文件，请先登录系统。',
  'LBL_OPPORTUNITY_ID' => '商业机会编号：',
  'LBL_PANEL_DETAILS' => '详细说明',
  'LBL_PARENT_ID' => '原始编号：',
  'LBL_PARENT_TYPE' => '原始类型',
  'LBL_PHONE' => '电话：',
  'LBL_PORTAL_FLAG' => '在门户中显示？',
  'LBL_PRODUCT_ID' => '产品编号：',
  'LBL_QUOTE_ID' => '报价ID：',
  'LBL_RELATED_TO' => '关联到：',
  'LBL_REMOVING_ATTACHMENT' => '移除附件中...',
  'LBL_REVENUELINEITEMS' => '收入线项目',
  'LBL_SEARCH_FORM_TITLE' => '查找备忘录',
  'LBL_SEND_ANYWAYS' => '没有电子邮件主题，确定发送或保存吗？',
  'LBL_STATUS' => '状态',
  'LBL_SUBJECT' => '主题',
  'LNK_IMPORT_NOTES' => '导入备忘录',
  'LNK_NEW_NOTE' => '新增备忘录或附件',
  'LNK_NOTE_LIST' => '查找备忘录',
);

