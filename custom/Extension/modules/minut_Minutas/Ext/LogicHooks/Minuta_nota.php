<?php
    /**
     * Victor Martinez Ĺópez
     * 15/11/2018
     */
$hook_array['after_save'][] = Array(
    7,
    'Se heredan valores a una nota',
    'custom/modules/minut_Minutas/min_Minuta_notas.php',
    'Minuta_nota', // name of the class
    'Hereda_datos' // name of the function
);