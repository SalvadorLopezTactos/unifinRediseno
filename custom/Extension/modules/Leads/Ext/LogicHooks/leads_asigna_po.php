<?php
/**
 * Created by Tactos.
 * User: AF
 * Date: 30/08/23
 * Time: 10:03 PM
 */
$hook_array['before_save'][] = Array(
    13,
    'Establece asignado de PO',
    'custom/modules/Leads/Lead_Hooks.php',
    'Lead_Hooks',
    'asignadoPO'
);
