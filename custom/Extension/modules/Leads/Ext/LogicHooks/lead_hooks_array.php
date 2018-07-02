<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/16/2015
 * Time: 4:24 PM
 */
$hook_array['after_save'][] = Array(
    1,
    'crear Persona prospecto',
    'custom/modules/Leads/Lead_Hooks.php',
    'Lead_Hooks',
    'crearProspecto'
);