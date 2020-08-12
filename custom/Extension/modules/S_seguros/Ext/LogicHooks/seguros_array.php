<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/07/20
 * Time: 11:56 PM
 */
$hook_array['before_save'][] = Array(
    1,
    'Crea carpeta de documentos para seguros en Google Drive',//Just a quick comment about the logic of it
    'custom/modules/S_seguros/doc_seguros.php', //path to the logic hook
    'Drive_docs', // name of the class
    'Load_docs' // name of the function.
);
$hook_array['before_save'][] = Array(
    2,
    'Funcion para actualizar el tipo de registro por producto del cliente en uni_productos',//Just a quick comment about the logic of it
    'custom/modules/S_seguros/doc_seguros.php', //path to the logic hook
    'Drive_docs', // name of the class
    'actualizatipoprod' // name of the function.
);