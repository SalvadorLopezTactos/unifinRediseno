<?php
/**
 * User: salvadorlopez@tactos.com.mx
 * Date: 16/03/20
 */
$viewdefs['Home']['base']['menu']['header'][] = array(
    'route'=>'#bwc/index.php?entryPoint=operacionesCRM',
    'label' =>'Gestión de firmas',
    'acl_module'=>'Home',
    'icon' => 'fa-table',
);