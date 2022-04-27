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
require_once('vendor/ytree/Tree.php');
require_once('vendor/ytree/Node.php');
require_once('modules/KBTags/TreeData.php');

//process request parameters. consider following parameters.
//function, and all parameters prefixed with PARAM.
//PARAMT_ are tree level parameters.
//PARAMN_ are node level parameters.


$json = getJSONobj();
$selectedArticles = $json->decode(html_entity_decode($_REQUEST['selectedArticles']));
 if(isset($selectedArticles['jsonObject']) && $selectedArticles['jsonObject'] != null){
	$selectedArticles = $selectedArticles['jsonObject'];
 }	 
 
foreach($selectedArticles as $articleId){
	if(!empty($articleId)){		
		
		       
        //retrieve article  
        $kbarticle = BeanFactory::getBean('KBDocuments', $articleId);        	        		       
        $deleted=1; 
        //also retrieve children and check if there is any article linked                                                 
        $kbarticle->deleted = 1;
        $kbarticle->save();
        //also delete related 
        $kbdocrevs = KBDocument::get_kbdocument_revisions($articleId);
    
  	   if (!empty($kbdocrevs) && is_array($kbdocrevs)) {
		 foreach($kbdocrevs as $key=>$thiskbid) {	
			$thiskbversion = BeanFactory::getBean('KBDocumentRevisions', $thiskbid);			
	        $docrev_ids = KBDocumentRevision::get_docrevs($thiskbid);
			foreach($docrev_ids as $key=>$thisdocrevid){
			 $thisdocrev = BeanFactory::getBean('DocumentRevisions', $thisdocrevid);
			 UploadFile::unlink_file($thisdocrevid,$thisdocrev->filename);
			 //mark version deleted
			 $thisdocrev->mark_deleted($thisdocrev->id);
			 //also retrieve the content
			 if($thisdocrev->file_ext == null && $thisdocrev->file_mime_type == null){
			   //this is content retrieve and mark it delete
			   	
			 }			 
			}				
		   //mark kbdoc revision deleted	
		   $thiskbversion->mark_deleted($thiskbversion->id);
		  }				
	    }                   
          
		$q = 'UPDATE kbdocuments_kbtags SET deleted = '.$deleted.' WHERE kbdocument_id = \''.$articleId.'\'';    
		$GLOBALS['db']->query($q);
	}
}	
        $tagstree=new Tree('tagstree');
        $tagstree->set_param('module','KBTags');
        $tagstree->set_param('moduleview','admin');
        //$nodes=get_tags_nodes(true);
        $nodes=get_tags_nodes(false,true,null);    
	    $root_node = new Node('All_Tags', $mod_strings['LBL_TAGS_ROOT_LABEL']);
	       foreach ($nodes as $node) {                                         
	            $root_node->add_node($node);                       
	        }
		 $root_node->expanded = true;    
		 $tagstree->add_node($root_node);                
               
        $response = $tagstree->generate_nodes_array();
        $response= $response."<script> document.getElementById('selected_directory_children').innerHTML='' </script>";         
if (!empty($response)) {	
    echo $response;
	//$json = getJSONobj();
	//print $json->encode($response);	
	//return the parameters
}
sugar_cleanup();
exit();
?>