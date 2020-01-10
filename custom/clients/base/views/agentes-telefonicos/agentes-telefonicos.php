<?php
$viewdefs['base']['view']['agentes-telefonicos'] = array(
    'panels' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'assigned_user_name',
                    'label' => 'Informa a',
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
                'label' => 'Informa a:',
                'type' => 'relate',
                'view' => 'edit',
            ),
        ),
    ),
)
);