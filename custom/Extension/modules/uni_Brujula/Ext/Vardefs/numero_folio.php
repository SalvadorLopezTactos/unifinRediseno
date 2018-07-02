<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 9/23/2016
 * Time: 11:19 AM
 */
$dictionary["uni_Brujula"]["fields"]["numero_folio"] = array(
    'required' => true,
    'name' => 'numero_folio',
    'vname' => 'LBL_NUMERO_FOLIO',
    'type' => 'int',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => true,
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'auto_increment' => true,
);

$dictionary["uni_Brujula"]["indices"]["numero_folio"] = array(
    'name' => 'numero_folio',
    'type' => 'unique',
    'fields' => array(
        'numero_folio'
    ),
);


