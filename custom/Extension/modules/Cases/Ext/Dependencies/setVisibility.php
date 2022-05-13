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
