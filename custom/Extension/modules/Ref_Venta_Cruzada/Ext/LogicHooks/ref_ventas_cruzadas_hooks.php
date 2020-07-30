<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 30/07/20
 * Time: 10:55
 */
//Guarda y actualiza objetivos específicos
$hook_array['after_save'][] = Array(
    1,
    'Envio de notificaciones para referencias válidas y canceladas',
    'custom/modules/Ref_Venta_Cruzada/ref_cruzadas_hooks.php',
    'Ref_Cruzadas_Hooks', // name of the class
    'enviaNotificaciones' // name of the function
);