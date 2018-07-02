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



global $current_user,$beanList, $beanFiles, $mod_strings;

$installed_classes = array();
$ACLbeanList=$beanList;


// In the event that previous Tracker entries were installed from 510RC, we need to fix the category value
$GLOBALS['db']->query("UPDATE acl_actions set acltype = 'TrackerPerf' where category = 'TrackerPerfs'");
$GLOBALS['db']->query("UPDATE acl_actions set acltype = 'TrackerSession' where category = 'TrackerSessions'");
$GLOBALS['db']->query("UPDATE acl_actions set acltype = 'TrackerQuery' where category = 'TrackerQueries'");

if(is_admin($current_user)){
    foreach($ACLbeanList as $module=>$class){

        if(empty($installed_classes[$class]) && isset($beanFiles[$class])){
            if($class == 'Tracker'){
                ACLAction::addActions('Trackers', 'Tracker');
            } else {
                $mod = BeanFactory::newBeanByName($class);
                $GLOBALS['log']->debug("DOING: $class");
                if($mod instanceof SugarBean && $mod->bean_implements('ACL') && $mod->isACLRoleEditable()){
                    // BUG 10339: do not display messages for upgrade wizard
                    if(!isset($_REQUEST['upgradeWizard'])){
                        echo translate('LBL_ADDING','ACL','') . $mod->module_dir . '<br>';
                    }
                    $createACL = false;
                    $aclList = SugarACL::loadACLs($mod->getACLCategory());
                    foreach ($aclList as $acl) {
                        if ($acl instanceof SugarACLStatic) {
                            $createACL = true;
                        }
                    }

                    if (!empty($createACL)) {
                        if (!empty($mod->acltype)) {
                            ACLAction::addActions($mod->getACLCategory(), $mod->acltype);
                        } else {
                            ACLAction::addActions($mod->getACLCategory());
                        }
                    }

                    $installed_classes[$class] = true;
                }
            }
        }
    }



$installActions = false;
$missingAclRolesActions = false;

$role1 = BeanFactory::getBean('ACLRoles');

$role_id = $GLOBALS['db']->fetchOne("SELECT id FROM acl_roles where name = 'Tracker'");

if(!empty($role_id['id'])) {
   $role_id = $role_id['id'];
   $role1->retrieve($role_id);
   $count = $GLOBALS['db']->fetchOne("SELECT count(role_id) as count FROM acl_roles_actions where role_id = '{$role_id}'");
   // If there are no corresponding entries in acl_roles_actions, then we need to add it
   if(empty($count['count'])) {
        $missingAclRolesActions = true;
   }
} else {
   $role1->name = "Tracker";
   $role1->description = "Tracker Role";
   $role1_id = $role1->save();
   $role1->set_relationship('acl_roles_users', array('role_id'=>$role1->id ,'user_id'=>1), false);
   $installActions = true;
}

if($installActions || $missingAclRolesActions) {
    $defaultTrackerRoles = array(
        'Tracker'=>array(
            'Trackers'=>array('admin'=>1, 'access'=>89, 'view'=>90, 'list'=>90, 'edit'=>90, 'delete'=>90, 'import'=>90, 'export'=>90),
            'TrackerQueries'=>array('admin'=>1, 'access'=>89, 'view'=>90, 'list'=>90, 'edit'=>90, 'delete'=>90, 'import'=>90, 'export'=>90),
            'TrackerPerfs'=>array('admin'=>1, 'access'=>89, 'view'=>90, 'list'=>90, 'edit'=>90, 'delete'=>90, 'import'=>90, 'export'=>90),
            'TrackerSessions'=>array('admin'=>1, 'access'=>89, 'view'=>90, 'list'=>90, 'edit'=>90, 'delete'=>90, 'import'=>90, 'export'=>90),
        )
    );


    foreach($defaultTrackerRoles as $roleName=>$role){
        foreach($role as $category=>$actions){
            foreach($actions as $name=>$access_override){
                $queryACL="SELECT id FROM acl_actions where category='$category' and name='$name'";
                $actionId = $GLOBALS['db']->fetchOne($queryACL);
                if (isset($actionId['id']) && !empty($actionId['id'])){
                    $role1->setAction($role1->id, $actionId['id'], $access_override);
                }
            }
        }
    } //foreach
}
//Check for the existence of MLA roles
$installActions = false;
$missingAclRolesActions = false;


$role1 = BeanFactory::getBean('ACLRoles');

$result = $GLOBALS['db']->query("SELECT id FROM acl_roles where name = 'Sales Administrator'");
$role_id = $GLOBALS['db']->fetchByAssoc($result, true, true);
if(!empty($role_id['id'])) {
   $role_id = $role_id['id'];
   $role1->retrieve($role_id);
   $count = $GLOBALS['db']->fetchOne("SELECT count(role_id) as count FROM acl_roles_actions where role_id = '{$role_id}'");
   // If there are no corresponding entries in acl_roles_actions, then we need to add it
   if(empty($count['count'])) {
      $missingAclRolesActions = true;
   }
}
else {
   $installActions = true;
}

if($installActions || $missingAclRolesActions) {
// Adding MLA Roles
    $mlaRoles = array(
     'Sales Administrator'=>array(
         'Accounts'=>array('admin'=>100, 'access'=>89),
         'Contacts'=>array('admin'=>100, 'access'=>89),
         'Forecasts'=>array('admin'=>100, 'access'=>89),
         'Leads'=>array('admin'=>100, 'access'=>89),
         'Opportunities'=>array('admin'=>100, 'access'=>89),
         'Quotes'=>array('admin'=>100, 'access'=>89),

     ),
     'Marketing Administrator'=>array(
         'Accounts'=>array('admin'=>100, 'access'=>89),
         'Contacts'=>array('admin'=>100, 'access'=>89),
         'Campaigns'=>array('admin'=>100, 'access'=>89),
         'ProspectLists'=>array('admin'=>100, 'access'=>89),
         'Leads'=>array('admin'=>100, 'access'=>89),
         'Prospects'=>array('admin'=>100, 'access'=>89),

     ),
     'Customer Support Administrator'=>array(
         'Accounts'=>array('admin'=>100, 'access'=>89),
         'Contacts'=>array('admin'=>100, 'access'=>89),
         'Bugs'=>array('admin'=>100, 'access'=>89),
         'Cases'=>array('admin'=>100, 'access'=>89),
         'KBContents'=>array('admin'=>100, 'access'=>89),
        )
    );


    foreach($mlaRoles as $roleName=>$role){
        $ACLField = BeanFactory::getBean('ACLFields');
        $role1 = BeanFactory::getBean('ACLRoles');
        $role1->name = $roleName;
        $role1->description = $roleName." Role";
        $role1_id=$role1->save();
        foreach($role as $category=>$actions){
            foreach($actions as $name=>$access_override){
                if($name=='fields'){
                    foreach($access_override as $field_id=>$access){
                        $ACLField->setAccessControl($category, $role1_id, $field_id, $access);
                    }
                }else{
                    $queryACL="SELECT id FROM acl_actions where category='$category' and name='$name'";
                    $actionId = $GLOBALS['db']->fetchOne($queryACL);
                    if (isset($actionId['id']) && !empty($actionId['id'])){
                        $role1->setAction($role1_id, $actionId['id'], $access_override);
                    }
                }
            }
        }
    }
}
}
?>
