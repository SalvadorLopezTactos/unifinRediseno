<?php
/*
 * Created by Salvador Lopez.
 */

$hook_array['before_save'][] = Array(
   5,
   'Establece Cancelado registro de Público Objetivo en caso de establcer por 5ta ocasión resultado Ilocalizable',
   'custom/modules/Meetings/Publico_Objetivo_Meetings.php',
   'Publico_Objetivo_Meetings',
   'set_cancelado_po'
);
