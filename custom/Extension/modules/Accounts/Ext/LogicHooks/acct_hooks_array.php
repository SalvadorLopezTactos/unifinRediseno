<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 6/3/2015
 * Time: 9:44 PM
 */
/*
$hook_array['after_save'][] = Array(
    1,
    'evey time a new team is added to the account record, All related opportunities get the new team',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks', // name of the class
    'copy_team_to_Opp'
);
*/
//$hook_array['after_save'][] = Array(
//    2,
//    'Revisar el cambio en sugar para correos y mandarlos a unics',
//    'custom/modules/Accounts/Account_Hooks.php',
//    'Account_Hooks', // name of the class
//    'emailChangetoUnics'
//);

/* //Se deshabilita validación lista negra
$hook_array['after_save'][] = Array(
    2,
    'API call, liberacionLista',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'liberaciondeLista'
);*/

$hook_array['after_save'][] = Array(
    5,
    'API call, insertarClienteCompleto',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'clienteCompleto'
);

$hook_array['after_save'][] = Array(
    6,
    'API call, Actualizapersona en UNICS',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'actualizaPersona'
);

$hook_array['after_save'][] = Array(
    7,
    'API call, Inserta PLD en UNICS',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'insertaPLDUNICS'
);


$hook_array['after_save'][] = Array(
    8,
    'Manage Related Accounts of type Contact',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'account_contacts'
);

$hook_array['after_save'][] = Array(
    9,
    'Sincroniza UNICS Relacion',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'relacion2UNICS'
);

$hook_array['before_save'][] = Array(
    1,
    'Valida que tenga asesor asignado',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'valida_asesor'
);

$hook_array['before_save'][] = Array(
    2,
    'Check for Duplicates and Prevent the Save',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'seguimiento_futuro'
);

$hook_array['before_save'][] = Array(
    3,
    'Set the Primary team for Accounts',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'set_primary_team'
);

$hook_array['before_save'][] = Array(
    4,
    'change all text fields to UpperCase',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'textToUppperCase'
);

$hook_array['before_save'][] = Array(
    5,
    'detecta si estamos insertando o actualizando un servicio',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'detectaEstado'
);

$hook_array['before_save'][] = Array(
    6,
    'API call, generarFolioProspecto',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'crearFolioProspecto'
);

$hook_array['before_save'][] = Array(
    7,
    'API call, generarFolioCliente',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'crearFolioCliente'
);

/* //Se deshabilita validación lista negra
$hook_array['before_save'][] = Array(
    8,
    'API call, Lista Negra',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'listaNegraCall'
);*/
/*
 * // Se comenta ya que actualmente se valida desde el js
$hook_array['before_save'][] = Array(
    8,
    'RFC Duplicate',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'rfcDuplicate'
);
*/

$hook_array['before_save'][] = Array(
    11,
    'Nivel de satisfaccion del cliente',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'nivelSatisfaccion'
);

$hook_array['before_save'][] = Array(
    12,
    'Genera ClienteID Relacion',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'crearFolioRelacion'
);

$hook_array['after_save'][] = Array(
    10,
    'Genera Resumen vacío en la creacion de Cuenta',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'creaResumen'
);

$hook_array['after_save'][] = Array(
    11,
    'Guarda Valores de los campos Autos en la sección de Potencial de la Cuenta',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'guardapotencial'
);

$hook_array['before_save'][] = Array(
    13,
    'Se eliminan los espacios superiores a uno en los campos principales de la Cuenta',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'quitaespacios'
);

$hook_array['before_save'][] = Array(
    14,
    'Se establece por default el asesor 9 - Sin Gestor en los campos de asesores que no contengan valor',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'asignaSinGestor'
);
$hook_array['before_save'][] = Array(
    14,
    'Valida Id Cliente Uniclick',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'idUniclick'
);

$hook_array['after_save'][] = Array(
    12,
    'Guarda valores de la cuenta y crea registro en ANLZT_analizate',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'RegistroAnalizate'
);
