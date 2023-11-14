<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/07/20
 * Time: 11:56 PM
 */
/*$hook_array['before_save'][] = Array(
    2,
    'Crea carpeta de documentos para seguros en Google Drive',//Just a quick comment about the logic of it
    'custom/modules/S_seguros/doc_seguros.php', //path to the logic hook
    'Drive_docs', // name of the class
    'Load_docs' // name of the function.
);*/
$hook_array['before_save'][] = Array(
    3,
    'Funcion para actualizar el tipo de registro por producto del cliente en uni_productos',//Just a quick comment about the logic of it
    'custom/modules/S_seguros/doc_seguros.php', //path to the logic hook
    'Drive_docs', // name of the class
    'actualizatipoprod' // name of the function.
);
$hook_array['before_save'][] = Array(
    4,
    'Establece registro en tabla de auditoría dependiendo de la plataforma proveniento de los servicios de Seguros',
    'custom/modules/S_seguros/Seguros_platform.php',
    'Seguros_platform_user',
    'set_audit_user_platform'
);
$hook_array['before_save'][] = Array(
    5,
    'Envía notificación por correo electrónico al detectar cambios sobre registros en etapa Ganada',
    'custom/modules/S_seguros/Seguros_LH.php',
    'Seguros_LH',
    'send_notification_ganada'
);
$hook_array['before_save'][] = Array(
   1,
   'Evita guardado de registro en caso de que se relacione una cuenta bloqueada',
   //Hsace referencia a archivo dentro de Opportunities para no generar uno nuevo ya que se reutiliza la funcionalidad para Leads
   'custom/modules/Opportunities/Check_Bloqueo_Cuenta_Opp.php',
   'Check_Bloqueo_Cuenta_Opp',
   'verifica_cuenta_bloqueada_opp'
);
