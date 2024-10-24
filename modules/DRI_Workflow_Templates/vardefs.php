<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$dictionary['DRI_Workflow_Template'] = [
    'table' => 'dri_workflow_templates',
    'audited' => false,
    'unified_search' => false,
    'icon' => 'sicon-customer-journey-lg',
    'duplicate_merge' => true,
    'comment' => 'DRI_Workflow_Template',
    'optimistic_lock' => true,
    'uses' => [
        'default',
        'team_security',
    ],
    'fields' => [
        'available_modules' => [
            'name' => 'available_modules',
            'vname' => 'LBL_AVAILABLE_MODULES',
            'required' => true,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'options' => null,
            'type' => 'multienum',
            'isMultiSelect' => true,
            'help' => 'LBL_SMART_GUIDE_ACCESSIBLE',
            'function' => [
                'name' => 'listTemplateAvailableModulesEnumOptions',
            ],
        ],
        'disabled_stage_actions' => [
            'name' => 'disabled_stage_actions',
            'vname' => 'LBL_DISABLED_STAGE_ACTIONS',
            'required' => false,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'options' => 'dri_workflow_templates_disabled_stage_actions_list',
            'type' => 'multienum',
            'isMultiSelect' => true,
            'help' => 'LBL_SMART_GUIDE_MODIFY_ACTIONS',
        ],
        'disabled_activity_actions' => [
            'name' => 'disabled_activity_actions',
            'vname' => 'LBL_DISABLED_ACTIVITY_ACTIONS',
            'required' => false,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'options' => 'dri_workflow_templates_disabled_activity_actions_list',
            'type' => 'multienum',
            'isMultiSelect' => true,
            'help' => 'LBL_SMART_GUIDE_DISABLE_ACTIONS',
        ],
        'active_limit' => [
            'name' => 'active_limit',
            'vname' => 'LBL_ACTIVE_LIMIT',
            'required' => false,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'type' => 'int',
            'len' => 8,
            'options' => 'numeric_range_search_dom',
            'enable_range_search' => true,
            'help' => 'LBL_SMART_GUIDE_ACTIVATES',
        ],
        'points' => [
            'name' => 'points',
            'vname' => 'LBL_POINTS',
            'required' => false,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'type' => 'int',
            'len' => 8,
            'options' => 'numeric_range_search_dom',
            'enable_range_search' => true,
            'readonly' => true,
            'disable_num_format' => true,
        ],
        'related_activities' => [
            'name' => 'related_activities',
            'vname' => 'LBL_RELATED_ACTIVITIES',
            'required' => false,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'type' => 'int',
            'len' => 8,
            'options' => 'numeric_range_search_dom',
            'enable_range_search' => true,
            'readonly' => true,
            'disable_num_format' => true,
        ],
        'active' => [
            'name' => 'active',
            'vname' => 'LBL_ACTIVE',
            'required' => false,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => true,
            'type' => 'bool',
            'default' => true,
        ],
        'update_assignees' => [
            'name' => 'update_assignees',
            'vname' => 'LBL_UPDATE_ASSIGNEES',
            'required' => false,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => true,
            'type' => 'bool',
            'default' => false,
            'help' => 'LBL_SMART_GUIDE_TARGET_ASSIGNEE',
        ],
        'assignee_rule' => [
            'name' => 'assignee_rule',
            'vname' => 'LBL_ASSIGNEE_RULE',
            'required' => true,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'options' => 'dri_workflow_templates_assignee_rule_list',
            'type' => 'enum',
            'default' => 'stage_start',
            'help' => 'LBL_SMART_GUIDE_USER_ASSIGNED',
        ],
        'target_assignee' => [
            'name' => 'target_assignee',
            'vname' => 'LBL_TARGET_ASSIGNEE',
            'required' => true,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'options' => 'dri_workflow_templates_target_assignee_list',
            'type' => 'enum',
            'default' => 'current_user',
            'help' => 'LBL_SMART_GUIDE_ACTIVITIES_ASSIGNED',
        ],
        'stage_numbering' => [
            'name' => 'stage_numbering',
            'vname' => 'LBL_STAGE_NUMBERS',
            'required' => false,
            'reportable' => false,
            'audited' => false,
            'importable' => 'true',
            'massupdate' => true,
            'type' => 'toggle',
            'dbType' => 'bool',
            'default' => '0',
            'studio' => true,
            'help' => 'LBL_SMART_GUIDE_STAGE_NUMBERS',
            'label_right' => 'LBL_CUSTOMER_JOURNEY_STAGE_NUMBER_SHOW',
            'label_left' => 'LBL_CUSTOMER_JOURNEY_STAGE_NUMBER_HIDE',
        ],
        'cancel_action' => [
            'name' => 'cancel_action',
            'vname' => 'LBL_CANCEL_ACTION',
            'required' => true,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'options' => 'dri_workflow_templates_cancel_action_list',
            'type' => 'enum',
            'default' => 'set_not_applicable',
        ],
        'not_applicable_action' => [
            'name' => 'not_applicable_action',
            'vname' => 'LBL_NOT_APPLICABLE_ACTION',
            'required' => true,
            'reportable' => true,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'options' => 'dri_workflow_templates_not_applicable_action_list',
            'type' => 'enum',
            'default' => 'default',
        ],
        'dri_workflows' => [
            'name' => 'dri_workflows',
            'vname' => 'LBL_DRI_WORKFLOWS',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'DRI_Workflow',
            'relationship' => 'dri_workflow_dri_workflow_templates',
            'module' => 'DRI_Workflows',
        ],
        'dri_subworkflow_templates' => [
            'name' => 'dri_subworkflow_templates',
            'vname' => 'LBL_DRI_SUBWORKFLOW_TEMPLATES',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'DRI_SubWorkflow_Template',
            'relationship' => 'dri_subworkflow_template_dri_workflow_templates',
            'module' => 'DRI_SubWorkflow_Templates',
        ],
        'dri_workflow_task_templates' => [
            'name' => 'dri_workflow_task_templates',
            'vname' => 'LBL_DRI_WORKFLOW_TASK_TEMPLATES',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'DRI_Workflow_Task_Template',
            'relationship' => 'dri_workflow_task_template_dri_workflow_templates',
            'module' => 'DRI_Workflow_Task_Templates',
        ],
        'copies' => [
            'name' => 'copies',
            'vname' => 'LBL_COPIES',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'DRI_Workflow_Template',
            'relationship' => 'dri_workflow_template_copied_template_dri_workflow_templates',
            'module' => 'DRI_Workflow_Templates',
        ],
        'tasks' => [
            'name' => 'tasks',
            'vname' => 'LBL_TASKS',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'Task',
            'relationship' => 'task_dri_workflow_templates',
            'module' => 'Tasks',
        ],
        'meetings' => [
            'name' => 'meetings',
            'vname' => 'LBL_MEETINGS',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'Meeting',
            'relationship' => 'meeting_dri_workflow_templates',
            'module' => 'Meetings',
        ],
        'calls' => [
            'name' => 'calls',
            'vname' => 'LBL_CALLS',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'Call',
            'relationship' => 'call_dri_workflow_templates',
            'module' => 'Calls',
        ],
        'accounts' => [
            'name' => 'accounts',
            'vname' => 'LBL_ACCOUNTS',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'Account',
            'relationship' => 'account_dri_workflow_templates',
            'module' => 'Accounts',
        ],
        'contacts' => [
            'name' => 'contacts',
            'vname' => 'LBL_CONTACTS',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'Contact',
            'relationship' => 'contact_dri_workflow_templates',
            'module' => 'Contacts',
        ],
        'leads' => [
            'name' => 'leads',
            'vname' => 'LBL_LEADS',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'Lead',
            'relationship' => 'lead_dri_workflow_templates',
            'module' => 'Leads',
        ],
        'cases' => [
            'name' => 'cases',
            'vname' => 'LBL_CASES',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'aCase',
            'relationship' => 'case_dri_workflow_templates',
            'module' => 'Cases',
        ],
        'opportunities' => [
            'name' => 'opportunities',
            'vname' => 'LBL_OPPORTUNITIES',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'Opportunity',
            'relationship' => 'opportunity_dri_workflow_templates',
            'module' => 'Opportunities',
        ],
        'start_next_journey_activities' => [
            'name' => 'start_next_journey_activities',
            'vname' => 'LBL_START_NEXT_JOURNEY_ACTIVITIES',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'DRI_Workflow_Task_Template',
            'relationship' => 'dri_workflow_task_template_start_next_journey_dri_workflow_templates',
            'module' => 'DRI_Workflow_Task_Templates',
        ],
        'start_next_journey_stages' => [
            'name' => 'start_next_journey_stages',
            'vname' => 'LBL_START_NEXT_JOURNEY_STAGES',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'DRI_SubWorkflow_Template',
            'relationship' => 'dri_subworkflow_template_start_next_journey_dri_workflow_templates',
            'module' => 'DRI_SubWorkflow_Templates',
        ],
        'web_hooks' => [
            'name' => 'web_hooks',
            'vname' => 'LBL_WEB_HOOKS',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'CJ_WebHook',
            'relationship' => 'dri_workflow_templates_flex_relate_cj_web_hooks',
            'module' => 'CJ_WebHooks',
        ],
        'forms' => [
            'name' => 'forms',
            'vname' => 'LBL_FORMS',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'CJ_Form',
            'relationship' => 'dri_workflow_templates_flex_relate_cj_forms',
            'module' => 'CJ_Forms',
        ],
        'copied_template_id' => [
            'name' => 'copied_template_id',
            'vname' => 'LBL_COPIED_TEMPLATE',
            'required' => false,
            'reportable' => false,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'type' => 'id',
        ],
        'copied_template_name' => [
            'name' => 'copied_template_name',
            'vname' => 'LBL_COPIED_TEMPLATE',
            'required' => false,
            'reportable' => false,
            'audited' => true,
            'importable' => 'true',
            'massupdate' => false,
            'source' => 'non-db',
            'type' => 'relate',
            'rname' => 'name',
            'table' => 'dri_workflow_templates',
            'id_name' => 'copied_template_id',
            'sort_on' => 'name',
            'module' => 'DRI_Workflow_Templates',
            'dependency' => 'not(equal($copied_template_name, ""))',
            'link' => 'copied_template_link',
        ],
        'copied_template_link' => [
            'name' => 'copied_template_link',
            'vname' => 'LBL_COPIED_TEMPLATE',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'right',
            'bean_name' => 'DRI_Workflow_Template',
            'relationship' => 'dri_workflow_template_copied_template_dri_workflow_templates',
            'module' => 'DRI_Workflow_Templates',
        ],
        'dri_workflows' => [
            'name' => 'dri_workflows',
            'vname' => 'LBL_DRI_WORKFLOWS',
            'source' => 'non-db',
            'type' => 'link',
            'side' => 'left',
            'bean_name' => 'DRI_Workflow',
            'relationship' => 'dri_workflow_dri_workflow_templates',
            'module' => 'DRI_Workflows',
        ],
    ],
    'relationships' => [
        'dri_workflow_templates_flex_relate_cj_web_hooks' => [
            'lhs_key' => 'id',
            'relationship_type' => 'one-to-many',
            'lhs_module' => 'DRI_Workflow_Templates',
            'lhs_table' => 'dri_workflow_templates',
            'rhs_key' => 'parent_id',
            'rhs_module' => 'CJ_WebHooks',
            'rhs_table' => 'cj_web_hooks',
            'relationship_role_column_value' => 'DRI_Workflow_Templates',
            'relationship_role_column' => 'parent_type',
        ],
        'dri_workflow_templates_flex_relate_cj_forms' => [
            'lhs_key' => 'id',
            'relationship_type' => 'one-to-many',
            'lhs_module' => 'DRI_Workflow_Templates',
            'lhs_table' => 'dri_workflow_templates',
            'rhs_key' => 'parent_id',
            'rhs_module' => 'CJ_Forms',
            'rhs_table' => 'cj_forms',
            'relationship_role_column_value' => 'DRI_Workflow_Templates',
            'relationship_role_column' => 'parent_type',
        ],
        'dri_workflow_template_copied_template_dri_workflow_templates' => [
            'relationship_type' => 'one-to-many',
            'lhs_key' => 'id',
            'lhs_module' => 'DRI_Workflow_Templates',
            'lhs_table' => 'dri_workflow_templates',
            'rhs_module' => 'DRI_Workflow_Templates',
            'rhs_table' => 'dri_workflow_templates',
            'rhs_key' => 'copied_template_id',
        ],
    ],
    'indices' => [
        'idx_cj_jry_tpl_copied_tpl_id' => [
            'name' => 'idx_cj_jry_tpl_copied_tpl_id',
            'type' => 'index',
            'fields' => [
                'copied_template_id',
            ],
        ],
    ],
    'duplicate_check' => [
        'enabled' => false,
    ],
    'acls' => [
        'SugarACLCustomerJourney' => true,
    ],
];

VardefManager::createVardef(
    'DRI_Workflow_Templates',
    'DRI_Workflow_Template'
);

$dictionary['DRI_Workflow_Template']['fields']['description']['full_text_search'] = [
    'enabled' => false,
];
