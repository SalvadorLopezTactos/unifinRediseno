<?php
/**
 * Created by JG 12/11/2020.
 * Gestion de Accesos CRM
 */
$viewdefs['Home']['base']['menu']['header'][] = array(
    'route'=>'#Home/layout/GestionAccesoCRM',
    'label' =>'Gestión de acceso a CRM',
    'acl_module'=>'Home',
    'icon' => 'sicon-calendar-lg',
);