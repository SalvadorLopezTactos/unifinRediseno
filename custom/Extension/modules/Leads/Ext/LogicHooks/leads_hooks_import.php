<?php
/**
 * Created by Tactos.
 * User: JG
 * Date: 26/12/19
 * Time: 10:03 AM
 */
$hook_array['before_save'][] = Array(
    1,
    'Valida Campos Requeridos',
    'custom/modules/Leads/Lead_Hooks.php',
    'Lead_Hooks',
    'validaCampos'
);

$hook_array['before_save'][] = Array(
    2,
    'Change all text fields to UpperCase',
    'custom/modules/Leads/leads_validateString.php',
    'leads_validateString',
    'textToUppperCase'
);

$hook_array['before_save'][] = Array(
    3,
    'Se eliminan los espacios superiores a uno en los campos principales de la Cuenta',
    'custom/modules/Leads/leads_validateString.php',
    'leads_validateString',
    'quitaespacios'
);

$hook_array['before_save'][] = Array(
    4,
    'Se eliminan los espacios superiores a uno en los campos principales de la Cuenta',
    'custom/modules/Leads/leads_validateString.php',
    'leads_validateString',
    'ExistenciaEnCuentas'
);

$hook_array['before_save'][] = Array(
    5,
    'Se cambia puesto a Otro si viene vacio',
    'custom/modules/Leads/Lead_Hooks.php',
    'Lead_Hooks',
    'cambiaPuesto'
);

$hook_array['before_save'][] = Array(
    6,
    'Se llena Macro Sector',
    'custom/modules/Leads/Lead_Hooks.php',
    'Lead_Hooks',
    'llenaMacro'
);