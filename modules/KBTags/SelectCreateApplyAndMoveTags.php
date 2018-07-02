<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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
require_once('modules/KBTags/KBTree.php');

$json = getJSONobj();
//$tagsMode = $json->decode(html_entity_decode($_REQUEST['tagsMode']));
$tagsMode = trim(html_entity_decode($_REQUEST['tagsMode']), "\"");

if (!empty($_REQUEST['searchTagName'])) {
    $search_tag_name = $json->decode(html_entity_decode($_REQUEST['searchTagName']));
    if (isset($search_tag_name) && $search_tag_name != null) {
        $search_tag_name = $search_tag_name;
        $tagsMode = 'Search Tags';
    }
}

$KBTag = BeanFactory::getBean('KBTags');
$response = '';
if ($tagsMode == 'Select Create Tags') {
    $tagstree = new Tree('tagstree');
    $tagstree->set_param('module', 'KBTags');
    $tagstree->set_param('moduleview', 'modal');
    //$nodes = get_tags_nodes_cached(null);
    $nodes = get_tags_nodes(false, false, null);
    $root_node = new Node('All_Tags', $mod_strings['LBL_TAGS_ROOT_LABEL']);
    //$tagstree->add_node($root_node);
    foreach ($nodes as $node) {
        $root_node->add_node($node);
    }
    $href_string = "javascript:handler:SUGAR.kb.modalClose('tagstree')";
    if ($root_node) {
        $root_node->set_property("href", $href_string);
    }
    $root_node->expanded = true;
    $tagstree->add_node($root_node);
    $response = $tagstree->generate_nodes_array();
}

if ($tagsMode == 'Move Tags') {
    $tagstreeModal = new Tree('tagstreeMoveDocsModal');
    $tagstreeModal->set_param('module', 'KBTags');
    $tagstreeModal->set_param('moduleview', 'modalMoveDocs');
    $nodes = get_tags_modal_nodes(null, false);
    foreach ($nodes as $node) {
        $tagstreeModal->add_node($node);
    }
    $response = $tagstreeModal->generate_nodes_array();
}
if ($tagsMode == 'Apply Tags') {
    $tagstreeApply = new Tree('tagstreeApplyTags');
    $tagstreeApply->set_param('module', 'KBTags');
    $tagstreeApply->set_param('moduleview', 'applyTags');
    $nodes = get_tags_modal_nodes(null, true);
    foreach ($nodes as $node) {
        $tagstreeApply->add_node($node);
    }
    $response = $tagstreeApply->generate_nodes_array();
}
//ADDING FOR SEARCH
if ($tagsMode == 'Search Tags') {
    global $mod_strings;

    if (!empty($search_tag_name)) {
        $search_tag_name = $GLOBALS['db']->quote($search_tag_name[0]);

        $query = "select id,tag_name from kbtags where tag_name='$search_tag_name' and deleted = 0";
        $result = $GLOBALS['db']->query($query);
        //$searched_tagIds  =  $GLOBALS['db']->fetchByAssoc($result);

        $searched_and_related_Ids = array();
        $searched_ids = array();
        //for each search tag id find all the way to the root and save the nodes enroute
        //in the sequence.
        $found = 0;
        while (($searchIds = $GLOBALS['db']->fetchByAssoc($result)) != null) {
            $found = 1;
            $searched_and_related_Ids[$searchIds['id']] = getRootNode($searchIds['id'], $searchIds['tag_name']);
        }

        if ($found == 1) {
            $root_node = get_searched_tags_nodes($searched_and_related_Ids);
            $tagstree = new KBTree('tagstree');
            $tagstree->set_param('module', 'KBTags');
            $tagstree->set_param('moduleview', 'modal');
            $tagstree->add_node($root_node);
            //			    $response = generate_nodes_array_custom($tagstree);
            $response = $tagstree->generate_nodes_array($tagstree);
        } else {
            $not_found_msg = $mod_strings['LBL_NO_MATHING_TAG_FOUND'];
            $response = "<script>alert('$not_found_msg')</script>";
        }
        echo $response;
        sugar_cleanup();
        exit();

    }
}

if (!empty($response)) {
    //echo $response;
    //echo 'result = ' . $json->encode($response);
    echo 'result = ' . $json->encode((array('body' => $response)));
}
sugar_cleanup();
exit();
?>