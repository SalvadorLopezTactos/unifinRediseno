<?php
    /**
     * Created by VML
     * Date: 14/02/2019
     */

$hook_array['after_save'][] = Array(
    10,
    'Crea una nueva reunion o llamada ',
    'custom/modules/minut_Minutas/minuta_Reun_Llama.php',
    'Minuta_reun_llam', // name of the class
    'SaveReunllam' // name of the function
);