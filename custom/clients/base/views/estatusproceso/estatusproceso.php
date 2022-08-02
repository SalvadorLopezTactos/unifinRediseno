<?php

$viewdefs['base']['view']['estatusproceso'] = array(
    'dashlets' => array(
        array(
            'label' => 'Estatus de la operacion',
            'description' => 'Informacion de la operacion',
            'config' => array(
                'limit' => '10',
            ),
            'preview' => array(
                'limit' => '10',
            ),
            'filter' => array(
                'module' => array(
                    'Opportunities',
                ),
                'view' => 'record'
            ),
        ),
    ),
    'variables' => array(
        'url' => ''
    )
);
?>