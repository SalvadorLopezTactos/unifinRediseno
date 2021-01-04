<?php
/**
 * Created by JG 12/11/2020.
 * Gestion de Accesos CRM
 */
$viewdefs['Home']['base']['menu']['header'][] = array(
    'route'=>'#Home/layout/GestionAccesoCRM',
    'label' =>'Gestión Acceso CRM',
    'acl_module'=>'Home',
    'icon' => 'fa-calendar',
);