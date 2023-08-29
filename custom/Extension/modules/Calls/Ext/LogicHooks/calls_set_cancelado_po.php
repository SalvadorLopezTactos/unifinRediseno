<?php
/*
 * Created by Salvador Lopez.
 */

$hook_array['before_save'][] = Array(
   21,
   'Establece Cancelado registro de Público Objetivo en caso de establcer por 5ta ocasión resultado Ilocalizable',
   'custom/modules/Calls/Publico_Objetivo.php',
   'Publico_Objetivo',
   'set_cancelado_po'
);
