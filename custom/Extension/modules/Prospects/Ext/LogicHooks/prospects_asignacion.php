<?php

$hook_array['before_save'][] = Array(
    12,
    'Establece asignado en creación de PO',
    'custom/modules/Prospects/Prospect_Asignacion.php',
    'Prospects_AsignacionPO',
    'set_assigned'
);
