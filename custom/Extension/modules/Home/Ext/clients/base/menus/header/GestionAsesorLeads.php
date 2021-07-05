<?php
/**
 * Created by EJC 02/07/2021.
 * Gestion de Número de Leads asignado a Asesores
 */
$viewdefs['Home']['base']['menu']['header'][] = array(
    'route'=>'#Home/layout/GestionAsesorLeads',
    'label' =>'Gestión Leads Asignados',
    'acl_module'=>'Home',
    'icon' => 'fa_team',
);