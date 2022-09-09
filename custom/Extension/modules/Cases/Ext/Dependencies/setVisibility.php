<?php
/**
 * Created by tactos.
 * User: erick.cruz
 */

$dependencies['Cases']['contacto_principal_c_Visibility'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','name'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'contacto_principal_c',
                'value' => 'false',
            ),
        ),
    ),
);

/* Se omite dependencia para que sea visible en todo momento
$dependencies['Cases']['vip_c_Visibility'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('priority'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'vip_c',
                'value' => 'or(equal($priority,"P2"),equal($priority,"P3"))',
            ),
        ),
    ),
);
*/