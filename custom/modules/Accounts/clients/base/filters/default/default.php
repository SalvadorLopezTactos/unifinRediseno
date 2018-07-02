<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$viewdefs['Accounts']['base']['filter']['default'] = array(
    'default_filter' => 'all_records',
    'fields' => array(
        'name' => array(),
        'rfc_c' => array(),
        'idcliente_c' => array(),
        'tipo_registro_c' => array(),
        'promotorleasing_c' => array(),
        'promotorfactoraje_c' => array(),
        'promotorcredit_c' => array(),
        'unifin_team' => array(),
    ),
);