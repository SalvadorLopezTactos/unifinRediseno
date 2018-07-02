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

require_once('modules/KBDocuments/SearchUtils.php');


    $node_depth = isset($_REQUEST['PARAMT_depth']) ? $_REQUEST['PARAMT_depth'] : 0;
    $n_id = isset($_REQUEST['PARAMN_id_'.$node_depth]) ? $_REQUEST['PARAMN_id_'.$node_depth] : '';
    $zero_node =  isset($_REQUEST['PARAMN_id_0']) ? $_REQUEST['PARAMN_id_0'] : '';
    $sortCol = '';
    
    //if we do not get the node id, then cancel this call, we cannot proceed
    if(empty($n_id )){
        return;   
    }
    
    $search_str = ' kbdocuments.deleted =0';
    //if node id is untagged, then create query for all untagged articles
    if($n_id == 'UNTAGGED_NODE_ID'){
    $search_str .= " and kbdocuments.id NOT IN
                                (select kbdocument_id from kbdocuments_kbtags where deleted = 0)";      
        
    }else{
        //create query for articles under this tag
    $search_str .= " and kbdocuments.id
                        IN (
                            SELECT kbd.id
                            FROM kbdocuments kbd, kbdocuments_kbtags kbd_kt
                            WHERE kbd.id = kbd_kt.kbdocument_id
                            AND kbd.deleted = 0
                            AND kbd_kt.deleted = 0
                            AND kbd_kt.kbtag_id = '$n_id'
                        )";        
    
    }
    
    //check to see if sortCol has been specified
    if( isset($_REQUEST['sortCol']) && !empty($_REQUEST['sortCol'])) {
        //if sorcol has been set to PAGINATE, then this is a pagination and requires
        //reversing the sort order so listview data can process correctly
        if($_REQUEST['sortCol']=='PAGINATE'){
            if(isset($lvso) && !empty($lvso)){
                $lvso = (strcmp(strtolower($lvso), 'asc') == 0)?'DESC':'ASC';
            }
        }else{
            //this is a normal sort column command, override sort order 
            //with currently selected column (if this call is from sort event)
            $sortCol = $_REQUEST['sortCol'];
        }
    }
   //Set Request Object parameter so that Sort order will happen in get_fts_list method
   $_REQUEST['KBDocuments2_KBDOCUMENT_ORDER_BY'] = $sortCol;
       
   //if set to 'all tags', pass in query 'where' clause into method that returns list for admins
   if(!empty($zero_node) && strtolower($zero_node) == 'all_tags'){
   		$results = get_admin_fts_list($search_str,false,true);
   }else{   
        $results = get_fts_list($search_str,false,true);
   }

echo $results;

?>
