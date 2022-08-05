<?php
    /**
     * Created by JCM
     * Date: 23/10/2018
     */

$hook_array['after_save'][] = Array(
    8,
    'Actualiza relación entre minuta y reunión',
    'custom/modules/minut_Minutas/actualizaRelacionMinutaReunion.php',
    'actualizaRelacionMinutaReunionClass', // name of the class
    'actualizaRelacion' // name of the function
);
