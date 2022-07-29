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
$search_tag_name = $json->decode(html_entity_decode($_REQUEST['searchTagName']));

if(!empty($search_tag_name)){
		       
        //create campaign log    
        $query="select id from kbtags where deleted = '0' and tag_name=$search_tag_name order by tag_name";	
        $result = $GLOBALS['db']->query($query);    
        $searched_tagIds  =  $GLOBALS['db']->fetchByAssoc($result);
          
        //next search the parents (root node) of each tag found
        //combine parent child/ren and expand tree
        $tagstree=new Tree('tagstree');
        $tagstree->set_param('module','KBTags');
        $tagstree->set_param('moduleview','SearchTags');
        $nodes=get_search_tags_nodes(true,$searched_tagIds);
                
        foreach ($nodes as $node) {
            $tagstree->add_node($node);       
        } 
     }         
        $response = $tagstree->generate_nodes_array();
                      
if (!empty($response)) {	
    echo $response;
	//$json = getJSONobj();
	//print $json->encode($response);	
	//return the parameters
}
sugar_cleanup();
exit();
?>