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
 //Request object must have these property values:
 //		Module: module name, this module should have a file called TreeData.php
 //		Function: name of the function to be called in TreeData.php, the function will be called statically.
 //		PARAM prefixed properties: array of these property/values will be passed to the function as parameter.


require_once('include/JSON.php');
require_once('include/upload_file.php');

//process request parameters. consider following parameters.
//function, and all parameters prefixed with PARAM.
//PARAMT_ are tree level parameters.
//PARAMN_ are node level parameters.
//module  name and function name parameters are the only ones consumed
//by this file..
//foreach ($_FILES['uploadfile'] as $key=>$value) {

//$GLOBALS['log']->fatal("AttachFiles: KEY ".$key);
//$GLOBALS['log']->fatal("AttachFiles: Value".$value);
        
$json = getJSONobj();
$docRev = $json->decode(html_entity_decode($_REQUEST['removeSaveAtt']));
if(isset($docRev['jsonObject']) && $docRev['jsonObject'] != null){
	$docRev = $docRev['jsonObject'];
 }	
if( $docRev[0] !=null) $docRevOrTagId= $docRev[0];
if( $docRev[1] !=null) $deleted= $docRev[1];
if( $docRev[2] !=null) $tagOrAtt= $docRev[2];


    $KBTag = BeanFactory::getBean('KBTags');
    if($tagOrAtt==1){
	  $q = 'UPDATE document_revisions SET deleted = '.$deleted.' WHERE id = \''.$docRevOrTagId.'\'';
    }
    else{
        if(isset($_REQUEST['kb_id'])  && !empty($_REQUEST['kb_id'])){
          $q = 'UPDATE kbdocuments_kbtags SET deleted = '.$deleted.' WHERE kbtag_id = \''.$docRevOrTagId.'\' and kbdocument_id = \''.$_REQUEST['kb_id'].'\'';
        }	
    }
	$KBTag->db->query($q);
$GLOBALS['log']->fatal($q);	
$response = $deleted; 
if (!empty($response)) {	
	$json = getJSONobj();
	print $json->encode($response);	
	//return the parameters
}
sugar_cleanup();
exit();
?>
