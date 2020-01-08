<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 27/12/19
 * Time: 01:00 PM
 */

$viewdefs['Leads']['base']['menu']['header'][] = array(
    'route'=>'#Leads/layout/Reporte_Carga_Leads',
    'label' =>'LNK_LEADS_IMPORT_REPORT',
    'acl_module'=>'Leads',
    'icon' => 'fa-table',
);