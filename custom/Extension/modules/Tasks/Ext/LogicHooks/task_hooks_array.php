<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/26/2015
 * Time: 8:11 PM
 */
$hook_array['before_save'][] = Array(
    1,
    'after workflow, get task details from parent account',
    'custom/modules/Tasks/Task_Hooks.php',
    'Task_Hooks', // name of the class
    'afterWorkflow'
);

$hook_array['before_save'][] = Array(
    2,
    'Funcion para guardar informacion del usuario logueado asi como asignado a la tarea CREADA.',
    'custom/modules/Tasks/Task_Hooks.php',
    'Task_Hooks', // name of the class
    'InfoTasks'
);

$hook_array['before_save'][] = Array(
    3,
    'Envia correo al asesor leasing de la cuenta',
    'custom/modules/Tasks/Task_Hooks.php',
    'Task_Hooks',
    'sendEmail'
);

$hook_array['before_save'][] = Array(
    4,
    'Relaciona última solicitud leasing para solicitud',
    'custom/modules/Tasks/Task_Hooks.php',
    'Task_Hooks',
    'relateOppLeasing'
);

$hook_array['before_save'][] = Array(
    5,
    'Envia notificacion al asesor leasing, comunicando actualización del registro',
    'custom/modules/Tasks/Task_Hooks.php',
    'Task_Hooks',
    'sendNotificationUpdate'
);

$hook_array['before_save'][] = Array(
   6,
   'Evita guardado de registro en caso de que se relacione una cuenta bloqueada',
   'custom/modules/Check_Bloqueo_Cuenta.php',
   'Check_Bloqueo_Cuenta',
   'verifica_cuenta_bloqueada'
);