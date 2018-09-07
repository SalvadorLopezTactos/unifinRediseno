<?php

$dependencies['Accounts']['tct_persona1_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'tct_persona1_c',
                'value' => 'equal($tipodepersona_c,"Persona Moral")',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'tct_persona1_c',
                'value' => 'or(equal($subtipo_cuenta_c,"Integracion de Expediente"),equal($tipo_registro_c,"Cliente"))',
            ),
        ),
    ),
);