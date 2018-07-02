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

// $Id: ExpectedVersions.php 25564 2007-08-13 23:06:28Z majed $

$expect_versions = array();

//$expect_versions['Custom Labels'] = array('name'=>'Custom Labels', 'db_version' =>'3.0', 'file_version'=>'3.0');
$expect_versions['Chart Data Cache'] = array('name'=>'Chart Data Cache', 'db_version' =>'3.5.1', 'file_version'=>'3.5.1');
$expect_versions['htaccess'] = array('name'=>'htaccess', 'db_version' =>'3.5.1', 'file_version'=>'3.5.1');
//$expect_versions['DST Fix'] = array('name'=>'DST Fix', 'db_version' =>'3.5.1b', 'file_version'=>'3.5.1b');
$expect_versions['Rebuild Relationships'] = array('name'=>'Rebuild Relationships', 'db_version' =>'4.0.0', 'file_version'=>'4.0.0');
$expect_versions['Rebuild Extensions'] = array('name'=>'Rebuild Extensions', 'db_version' =>'4.0.0', 'file_version'=>'4.0.0');
//$expect_versions['Studio Files'] = array('name'=>'Studio Files', 'db_version' =>'4.5.0', 'file_version'=>'4.5.0');
?>