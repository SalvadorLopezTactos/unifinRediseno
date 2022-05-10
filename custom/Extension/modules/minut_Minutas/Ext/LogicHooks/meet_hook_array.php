<?php
    /**
     * Created by JCM
     * Date: 23/10/2018
     */

$hook_array['after_save'][] = Array(
    1,
    'Crea nueva minuta y genera los compromisos y las tareas relacionados',
    'custom/modules/minut_Minutas/minuta_hooks.php',
    'Minuta_Hooks', // name of the class
    'SaveMinuta' // name of the function
);

