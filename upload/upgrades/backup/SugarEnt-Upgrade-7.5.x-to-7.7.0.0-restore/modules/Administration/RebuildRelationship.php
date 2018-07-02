<?php
if (! defined ( 'sugarEntry' ) || ! sugarEntry)
    die ( 'Not A Valid Entry Point' ) ;
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
include ('include/modules.php') ;



global $db, $mod_strings ;
$log = & $GLOBALS [ 'log' ] ;
if (!empty($changedModules)) {
    $modulesChanged = array_keys($changedModules);
    $module1 = $modulesChanged[0];
    $module2 = !empty($modulesChanged[1]) ? $modulesChanged[1] : $modulesChanged[0];
    $query = "DELETE FROM relationships WHERE (rhs_module = '{$module1}' AND lhs_module = '{$module2}') OR (rhs_module = '{$module2}' AND lhs_module = '{$module2}')";
} else {
    $query = "DELETE FROM relationships" ;
}

$db->query ( $query ) ;

//clear cache before proceeding..
VardefManager::clearVardef () ;

$changedModules = empty($changedModules) ? $GLOBALS['beanList'] : $changedModules;

// loop through all of the modules and create entries in the Relationships table (the relationships metadata) for every standard relationship, that is, relationships defined in the /modules/<module>/vardefs.php
// SugarBean::createRelationshipMeta just takes the relationship definition in a file and inserts it as is into the Relationships table
// It does not override or recreate existing relationships
foreach ( $changedModules as $bean => $value )
{
        $focus = BeanFactory::newBean($bean);
        if ( $focus instanceOf SugarBean ) {
            // Add defensive coding around required args for relationship meta
            $objName = $focus->getObjectName();
            $tblName = $focus->table_name;
            if (empty($tblName) || empty($objName)) {
                $GLOBALS['log']->info("Either the object name or the table name for bean " . get_class($focus) . " is empty. Object Name is: $objName. Table name is $tblName.");
                continue;
            }
            $empty = array() ;
            if (empty ( $_REQUEST [ 'silent' ] ))
                echo $mod_strings [ 'LBL_REBUILD_REL_PROC_META' ] . $tblName . "..." ;
            SugarBean::createRelationshipMeta($objName, $db, $tblName, $empty, $focus->module_dir);
            SugarBean::createRelationshipMeta($objName, $db, $tblName, $empty, $focus->module_dir, true);
            if (empty ( $_REQUEST [ 'silent' ] ))
                echo $mod_strings [ 'LBL_DONE' ] . '<br>' ;
        }
}

// finally, whip through the list of relationships defined in TableDictionary.php, that is all the relationships in the metadata directory, and install those
    $dictionary = array ( ) ;
    require ('modules/TableDictionary.php') ;
    //for module installer incase we already loaded the table dictionary
    if (file_exists ( 'custom/application/Ext/TableDictionary/tabledictionary.ext.php' ))
    {
        include ('custom/application/Ext/TableDictionary/tabledictionary.ext.php') ;
    }
    $rel_dictionary = $dictionary ;
    foreach ( $rel_dictionary as $rel_name => $rel_data )
    {
        $table = isset($rel_data [ 'table' ]) ? $rel_data [ 'table' ] : "" ;

        if (empty ( $_REQUEST [ 'silent' ] ))
            echo $mod_strings [ 'LBL_REBUILD_REL_PROC_C_META' ] . $rel_name . "..." ;
        SugarBean::createRelationshipMeta ( $rel_name, $db, $table, $rel_dictionary, '' ) ;
        if (empty ( $_REQUEST [ 'silent' ] ))
            echo $mod_strings [ 'LBL_DONE' ] . '<br>' ;
    }

//clean relationship cache..will be rebuilt upon first access.
if (empty ( $_REQUEST [ 'silent' ] ))
    echo $mod_strings [ 'LBL_REBUILD_REL_DEL_CACHE' ] ;
Relationship::delete_cache () ;

//////////////////////////////////////////////////////////////////////////////
// Remove the "Rebuild Relationships" red text message on admin logins

// Refresh relationships metadata section cache
MetaDataManager::refreshSectionCache(array(MetaDataManager::MM_RELATIONSHIPS));


if (empty ( $_REQUEST [ 'silent' ] ))
    echo $mod_strings [ 'LBL_REBUILD_REL_UPD_WARNING' ] ;

// clear the database row if it exists (just to be sure)
$query = "DELETE FROM versions WHERE name='Rebuild Relationships'" ;
$log->info ( $query ) ;
$db->query ( $query ) ;

// insert a new database row to show the rebuild relationships is done
$id = create_guid () ;
$gmdate = gmdate('Y-m-d H:i:s');
$date_entered = db_convert ( "'$gmdate'", 'datetime' ) ;
$query = 'INSERT INTO versions (id, deleted, date_entered, date_modified, modified_user_id, created_by, name, file_version, db_version) ' . "VALUES ('$id', '0', $date_entered, $date_entered, '1', '1', 'Rebuild Relationships', '4.0.0', '4.0.0')" ;
$log->info ( $query ) ;
$db->query ( $query ) ;

$rel = BeanFactory::getBean('Relationships');
Relationship::delete_cache();
$rel->build_relationship_cache();

// unset the session variable so it is not picked up in DisplayWarnings.php
if (isset ( $_SESSION [ 'rebuild_relationships' ] ))
{
    unset ( $_SESSION [ 'rebuild_relationships' ] ) ;
}

if (empty ( $_REQUEST [ 'silent' ] ))
    echo $mod_strings [ 'LBL_DONE' ] ;
?>
