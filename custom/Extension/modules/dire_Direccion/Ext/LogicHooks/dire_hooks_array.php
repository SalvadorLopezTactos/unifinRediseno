<?php
    /**
     * Created by Levementum.
     * User: jgarcia@levementum.com
     * Date: 6/3/2015
     * Time: 9:44 PM
     */

    $hook_array['before_save'][] = Array(
            1,
            'Turn all characters to Upper Case',
            'custom/modules/dire_Direccion/Dir_Direcciones_Hooks.php',
            'Dir_Direcciones_Hooks', // name of the class
            'textToUppperCase'
    );

