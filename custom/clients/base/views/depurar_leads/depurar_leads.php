<?php
$viewdefs['base']['view']['depurar_leads'] = array(
    'panels' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'assigned_user_name',
                    'label' => 'Asesor Actual',
                    'type' => 'relate',
                    'view' => 'edit',
                ),
            ),
        ),
    ),
    'panelsTo' => array(
    array(
        'fields' => array(
            array(
                'name' => 'assigned_user_name',
                'label' => 'Reasignar a: ',
                'type' => 'relate',
                'view' => 'edit',
            ),
        ),
    ),
)
);