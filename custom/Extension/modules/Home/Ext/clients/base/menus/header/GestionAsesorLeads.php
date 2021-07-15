<?php
/**
 * Created by EJC 02/07/2021.
 * Gestion de Número de Leads asignado a Asesores
 */
$viewdefs['Home']['base']['menu']['header'][] = array(
    'route'=>'#Home/layout/GestionAsesorLeads',
    'label' =>'Gestión de asignación LM',
    'acl_module'=>'Home',
    'icon' => 'fa-users',
);
