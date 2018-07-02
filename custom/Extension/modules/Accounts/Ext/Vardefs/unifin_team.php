<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 4/17/2017
 * Time: 12:59 PM
 */

if (!isset($dictionary['Account']['fields']['unifin_team'])) {
    $dictionary['Account']['fields']['unifin_team'] = array();
}

$unifin_team = array(
    'name' => 'unifin_team',
    'vname' => 'LBL_UNIFIN_TEAM',
    'type' => 'enum',
    'audited' => false,
    'comments' => '',
    'calculated'=>false,
    'enforced'=>'',
    'required' => true,
    'massupdate' => true,
    'help' => '',
    'importable' => 'true',
    'reportable' => true,
    'dependency' => '',
    'visibility_grid' => '',
    'massupdate' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => 100,
    'options' => 'equipo_list',
    'studio' => false,
);

$dictionary['Account']['fields']['unifin_team'] = array_merge($unifin_team,
    $dictionary['Account']['fields']['unifin_team']);