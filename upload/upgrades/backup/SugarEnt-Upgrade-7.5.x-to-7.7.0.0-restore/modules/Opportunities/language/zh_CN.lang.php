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
  'ERR_DELETE_RECORD' => '必须指定记录编号才能删除商业机会。',
  'LABEL_PANEL_ASSIGNMENT' => '分配任务',
  'LBL_ACCOUNT_ID' => '客户编号',
  'LBL_ACCOUNT_NAME' => '客户名称：',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => '活动',
  'LBL_ASSIGNED_TO_ID' => '指派的用户编号',
  'LBL_ASSIGNED_TO_NAME' => '负责人',
  'LBL_CAMPAIGN' => '市场活动：',
  'LBL_CAMPAIGN_LINK' => '活动链接',
  'LBL_CAMPAIGN_OPPORTUNITY' => '营销活动',
  'LBL_CLOSED_RLIS' => '# 关闭的收入线项目',
  'LBL_CLOSED_WON_OPPORTUNITIES' => '已关闭的成功的商业机会',
  'LBL_COMMITTED' => '已分配',
  'LBL_COMMIT_STAGE' => '提交阶段',
  'LBL_CONTACTS_SUBPANEL_TITLE' => '联系人',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => '相关联系人的邮件',
  'LBL_CONTRACTS' => '合同',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => '合同',
  'LBL_CREATED_ID' => '创建人编号',
  'LBL_CREATED_USER' => '创建人',
  'LBL_CURRENCIES' => '货币',
  'LBL_CURRENCY' => '货币：',
  'LBL_CURRENCY_ID' => '货币编号',
  'LBL_CURRENCY_NAME' => '货币名称',
  'LBL_CURRENCY_RATE' => '汇率',
  'LBL_CURRENCY_SYMBOL' => '货币符号',
  'LBL_DATE_CLOSED' => '预期完成日期：',
  'LBL_DATE_CLOSED_TIMESTAMP' => '预期关闭的日期时间戳',
  'LBL_DEFAULT_SUBPANEL_TITLE' => '商业机会',
  'LBL_DESCRIPTION' => '说明：',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => '文件',
  'LBL_DUPLICATE' => '可能重复的商业机会',
  'LBL_EDITLAYOUT' => '编辑布局',
  'LBL_EXPORT_ASSIGNED_USER_ID' => '指派用户ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => '指派用户名',
  'LBL_EXPORT_CAMPAIGN_ID' => '营销活动ID',
  'LBL_EXPORT_CREATED_BY' => '创建ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => '修改ID',
  'LBL_EXPORT_NAME' => '名字',
  'LBL_FILENAME' => '附件：',
  'LBL_FORECAST' => '销售预测包括',
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
  'LBL_LEADS_SUBPANEL_TITLE' => '潜在客户',
  'LBL_LEAD_SOURCE' => '潜在客户来源：',
  'LBL_LIST_ACCOUNT_NAME' => '客户名称',
  'LBL_LIST_AMOUNT' => '可能',
  'LBL_LIST_AMOUNT_USDOLLAR' => '客户',
  'LBL_LIST_ASSIGNED_TO_NAME' => '负责人用户姓名',
  'LBL_LIST_DATE_CLOSED' => '关闭',
  'LBL_LIST_FORM_TITLE' => '商业机会列表',
  'LBL_LIST_OPPORTUNITY_NAME' => '名称',
  'LBL_LIST_SALES_STAGE' => '销售阶段',
  'LBL_MKTO_ID' => 'Marketo Lead ID',
  'LBL_MKTO_SYNC' => 'Sync to Marketo&reg;',
  'LBL_MODIFIED_ID' => '修改人编号',
  'LBL_MODIFIED_NAME' => '修改人姓名',
  'LBL_MODIFIED_USER' => '修改人',
  'LBL_MODULE_NAME' => '商业机会',
  'LBL_MODULE_NAME_SINGULAR' => '商业机会',
  'LBL_MODULE_TITLE' => '商业机会:首页',
  'LBL_MY_CLOSED_OPPORTUNITIES' => '我的关闭的商业机会',
  'LBL_NAME' => '商业机会名称',
  'LBL_NEW_FORM_TITLE' => '新增商业机会',
  'LBL_NEXT_STEP' => '下个步驟：',
  'LBL_NOTES_SUBPANEL_TITLE' => '记录',
  'LBL_OPPORTUNITY' => '商业机会：',
  'LBL_OPPORTUNITY_NAME' => '商业机会名称：',
  'LBL_OPPORTUNITY_ROLE' => '商业机会角色',
  'LBL_OPPORTUNITY_TYPE' => '机会类型',
  'LBL_PIPELINE_TOTAL_IS' => '管道总计数据',
  'LBL_PRIMARY_QUOTE_ID' => '主要报价',
  'LBL_PROBABILITY' => '成交概率(%)：',
  'LBL_PRODUCTS' => '产品',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => '产品',
  'LBL_PROJECTS_SUBPANEL_TITLE' => '项目',
  'LBL_PROJECT_SUBPANEL_TITLE' => '项目',
  'LBL_QUOTES_SUBPANEL_TITLE' => '报价',
  'LBL_QUOTE_SUBPANEL_TITLE' => '报价',
  'LBL_RAW_AMOUNT' => '原始金额',
  'LBL_RLI' => '收入线项目',
  'LBL_RLI_SUBPANEL_TITLE' => '收入线项目',
  'LBL_SALES_STAGE' => '销售阶段：',
  'LBL_SALES_STATUS' => '状态',
  'LBL_SEARCH_FORM_TITLE' => '查找商业机会',
  'LBL_TEAM_ID' => '团队ID',
  'LBL_TIMEPERIODS' => '时间周期',
  'LBL_TIMEPERIOD_ID' => '时间周期编号',
  'LBL_TOP_OPPORTUNITIES' => '我的重要商业机会',
  'LBL_TOTAL_OPPORTUNITIES' => '商业机会总数',
  'LBL_TOTAL_RLIS' => '# 总的收入线项目',
  'LBL_TYPE' => '类型：',
  'LBL_VIEW_FORM_TITLE' => '显示商业机会',
  'LBL_WORKSHEET' => '工作表',
  'LNK_CREATE' => '创建',
  'LNK_IMPORT_OPPORTUNITIES' => '导入商业机会',
  'LNK_NEW_OPPORTUNITY' => '新增商业机会',
  'LNK_OPPORTUNITY_LIST' => '查看商业机会',
  'LNK_OPPORTUNITY_REPORTS' => '商业机会报表',
  'MSG_DUPLICATE' => '新增这条记录可能造成重复，您可以从下面列表选择或是点击新增來继续透过旧有记录建立新商业机会',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => '您不能删除包含关闭的收入线项目的销售机会',
  'NTC_REMOVE_OPP_CONFIRMATION' => '您确定要从这个商业机会移除这个联系人？',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => '您确定要从这个项目移除商业机会？',
  'TPL_RLI_CREATE' => '一个销售机会必须关联收入线项目。',
  'TPL_RLI_CREATE_LINK_TEXT' => '创建收入线项目',
  'UPDATE' => '商业机会-货币更新',
  'UPDATE_BUGFOUND_COUNT' => '发现的缺陷：',
  'UPDATE_BUG_COUNT' => '发现缺陷并且尝试解决：',
  'UPDATE_COUNT' => '更新记录：',
  'UPDATE_CREATE_CURRENCY' => '新增货币：',
  'UPDATE_DOLLARAMOUNTS' => '更新美元金额',
  'UPDATE_DOLLARAMOUNTS_TXT' => '通过目前的汇率來更新商业机会的美元金额，这个数值用來计算图片与货币金额浏览列表',
  'UPDATE_DONE' => '完成',
  'UPDATE_FAIL' => '无法更新-',
  'UPDATE_FIX' => '修改金额',
  'UPDATE_FIX_TXT' => '尝试从目前的金额新增正确的数字来修改任何错误的金额，原有的资料会备份到amount_backup字段，如果您执行过程中发现任何错误，记得在重新执行前先将备份的数值还原，避免备份的数值也跟着出錯。',
  'UPDATE_INCLUDE_CLOSE' => '包含关闭的记录',
  'UPDATE_MERGE' => '合并货币',
  'UPDATE_MERGE_TXT' => '合并多种货币成为单一货币，如果您发现同样的货币有多条记录，您可以将他们合并。这将会合并所有模组的货币记录。',
  'UPDATE_NULL_VALUE' => '沒有输入金额的项目会设置为0-',
  'UPDATE_RESTORE' => '还原金额',
  'UPDATE_RESTORE_COUNT' => '还原记录金额：',
  'UPDATE_RESTORE_TXT' => '通过修正期间新增的备份來还原金额数值。',
  'UPDATE_VERIFY' => '确认金额',
  'UPDATE_VERIFY_CURAMOUNT' => '目前金额：',
  'UPDATE_VERIFY_FAIL' => '确认错误的记录：',
  'UPDATE_VERIFY_FIX' => '执行修正将会变成',
  'UPDATE_VERIFY_NEWAMOUNT' => '新的金额：',
  'UPDATE_VERIFY_NEWCURRENCY' => '新的货币：',
  'UPDATE_VERIFY_TXT' => '确认商业机会中的金额字段都是数字与小数点的组合。',
  'WARNING_NO_DELETE_CLOSED_SELECTED' => '所选择的一个或多个记录包含关闭的收入行项目不能被删除。',
);

