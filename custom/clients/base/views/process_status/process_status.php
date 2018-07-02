<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 02/03/18
 * Time: 08:13
 */

$viewdefs['base']['view']['process_status'] = array(
    'dashlets' => array(
        array(
            'label' => 'Estatus de la operación',
            'description' => 'Información de la operación',
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