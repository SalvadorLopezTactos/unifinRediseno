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
// adding project-to-bugs relationship
$dictionary['projects_bugs'] = array (
    'table' => 'projects_bugs',
    'fields' => array (
        array('name' => 'id', 'type' => 'varchar', 'len' => '36'),
        array('name' => 'bug_id', 'type' => 'varchar', 'len' => '36'),
        array('name' => 'project_id', 'type' => 'varchar', 'len' => '36'),
        array('name' => 'date_modified', 'type' => 'datetime'),
        array('name' => 'deleted', 'type' => 'bool', 'len' => '1', 'default' => '0', 'required' => false),
    ),
    'indices' => array (
        array('name' => 'projects_bugs_pk', 'type' =>'primary', 'fields'=>array('id')),
        array('name' => 'idx_proj_bug_proj', 'type' =>'index', 'fields'=>array('project_id')),
        array('name' => 'idx_proj_bug_bug', 'type' =>'index', 'fields'=>array('bug_id')),
        array('name' => 'projects_bugs_alt', 'type'=>'alternate_key', 'fields'=>array('project_id','bug_id')),
    ),
    'relationships' => array (
        'projects_bugs' => array(
            'lhs_module' => 'Project',
            'lhs_table' => 'project',
            'lhs_key' => 'id',
            'rhs_module' => 'Bugs',
            'rhs_table' => 'bugs',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'projects_bugs',
            'join_key_lhs' => 'project_id',
            'join_key_rhs' => 'bug_id',
        ),
    ),
);
?>
