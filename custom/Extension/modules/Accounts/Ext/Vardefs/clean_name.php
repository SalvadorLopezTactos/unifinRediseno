<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 5/16/2017
 * Time: 2:53 PM
 */

if (!isset($dictionary['Account']['fields']['clean_name'])) {
    $dictionary['Account']['fields']['clean_name'] = array();
}

$clean_name = array(
    'name' => 'clean_name',
    'vname' => 'LBL_CLEAN_NAME',
    'type' => 'varchar',
    'audited' => false,
    'comments' => '',
    'calculated'=>false,
    'enforced'=>'',
    'required' => false,
    'massupdate' => true,
    'help' => '',
    'importable' => 'true',
    'reportable' => true,
    'massupdate' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => 255,
    'studio' => 'visible',
);

$dictionary['Account']['fields']['clean_name'] = array_merge($clean_name,
    $dictionary['Account']['fields']['clean_name']);

