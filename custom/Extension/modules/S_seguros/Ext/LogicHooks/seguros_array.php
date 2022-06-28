<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/07/20
 * Time: 11:56 PM
 */
$hook_array['before_save'][] = Array(
    2,
    'Crea carpeta de documentos para seguros en Google Drive',//Just a quick comment about the logic of it
    'custom/modules/S_seguros/doc_seguros.php', //path to the logic hook
    'Drive_docs', // name of the class
    'Load_docs' // name of the function.
);
/*$hook_array['before_save'][] = Array(
    3,
    'Funcion para actualizar el tipo de registro por producto del cliente en uni_productos',//Just a quick comment about the logic of it
    'custom/modules/S_seguros/doc_seguros.php', //path to the logic hook
    'Drive_docs', // name of the class
    'actualizatipoprod' // name of the function.
);*/
$hook_array['before_save'][] = Array(
    4,
    'Establece registro en tabla de auditoría dependiendo de la plataforma proveniento de los servicios de Seguros',
    'custom/modules/S_seguros/Seguros_platform.php',
    'Seguros_platform_user',
    'set_audit_user_platform'
);