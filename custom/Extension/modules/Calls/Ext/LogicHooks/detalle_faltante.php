<?php
/*
 * Created by Tactos.
 * User: ECB
 * Date: 2022-04-06
 */

$hook_array['before_save'][] = Array(
   5,
   'Llema el campo detalle_c',
   'custom/modules/Calls/detalle_faltante.php',
   'detalle_faltante',
   'detalle_faltante'
);
