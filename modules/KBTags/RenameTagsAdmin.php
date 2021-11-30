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

$json = getJSONobj();
$tagdata = $json->decode(html_entity_decode($_REQUEST['newTagName']));
if(isset($tagdata['jsonObject']) && $tagdata['jsonObject'] != null){
	$tagdata = $tagdata['jsonObject'];
 }	
//save the tag
if( $tagdata[0] !=null) $new_tag_name= $tagdata[0];
if( $tagdata[1] !=null) $tag_id = $tagdata[1];
if( $tagdata[2] !=null) $parent_tag_id = $tagdata[2];

$found = false;

if(!empty($new_tag_name)){
	       
    //retrieve all the children of the parent tag. if parent tag is null then retrieve all 
    //tags whose parent is null. compare with the new tag name. 
    if($parent_tag_id == 'All_Tags'){
      	$parent_tag_id = '';
    }    
    $query="select id,tag_name from kbtags where deleted = 0 and";
    if (empty($parent_tag_id)) {
    	$query.=" parent_tag_id is null order by tag_name";	
    } else {
    	$query.=" parent_tag_id = '$parent_tag_id' order by tag_name";	    
    }  
    $result=$GLOBALS['db']->query($query);
    
	while (($row=$GLOBALS['db']->fetchByAssoc($result))!= null) {
      
      if (!empty($row['id']) && !empty($row['tag_name'])) {                            
         if(from_html($row['tag_name'])==$new_tag_name){
         	$found = true;         	
         	break;
         }
      }
	}  		        
}

 if(!$found){ 
           
    $kbtag = BeanFactory::getBean('KBTags', $tag_id);    
    $kbtag->tag_name  = $new_tag_name;    		         
    $kbtag->save();
     //refresh tree
    $tagstree=new Tree('tagstree');
    $tagstree->set_param('module','KBTags');            
    $tagstree->set_param('moduleview','admin');
    $nodes=get_tags_nodes(false,true,null);
    $root_node = new Node('All_Tags', $mod_strings['LBL_TAGS_ROOT_LABEL']);
    foreach ($nodes as $node) {                                         
    	$root_node->add_node($node);                       
    }
    $href_string = "javascript:handler:SUGAR.kb.adminClick()";
	if ($root_node) {
		$root_node->set_property("href",$href_string);   	
	}       
	 $root_node->expanded = true;    
	 $tagstree->add_node($root_node);                
	 $response = $tagstree->generate_nodes_array();
 }
 else{
 	$response = 1;
 }                  
 
if (!empty($response)) {	
    echo $response;
	//$json = getJSONobj();
	//print $json->encode($response);	
}
sugar_cleanup();
exit();
?>
