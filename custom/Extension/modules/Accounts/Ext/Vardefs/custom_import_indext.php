<?php
/*$dictionary['Account']['indices'][] = array(
    'name' => 'Razon Social',
    'type' => 'index',
    'fields' => array(
        0 => 'razonsocial_c',
    ),
    'source' => 'non-db',
);*/

$dictionary['Account']['indices'] = array(
    1 => array(
        'name' => 'Razon Social',
        'type' => 'index',
        'fields' => array(
            0 => 'razonsocial_c',
        ),
        'source' => 'non-db',
    ),

    2 => array(
        'name' => 'Clean Name',
        'type' => 'index',
        'fields' => array(
            0 => 'clean_name',
        ),
        'source' => 'non-db',
    ),

    3 => array(
        'name' => 'RFC',
        'type' => 'index',
        'fields' => array(
            0 => 'rfc_c',
        ),
        'source' => 'non-db',
    ),

    4 => array(
        'name' => 'Name',
        'type' => 'index',
        'fields' => array(
            0 => 'name',
        ),
        'source' => 'non-db',
    ),
);