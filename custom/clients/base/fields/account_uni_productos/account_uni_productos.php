<?php


$viewdefs['base']['fields']['accounts_uni_productos'] = array(
    'panels' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'users_accounts_1_name',
                    'label' => 'Responnsable de Ingesta',
                    'type' => 'relate',
                    'view' => 'edit',
                ),
                array(
                    'name' => 'users_accounts_2_name',
                    'label' => 'Responsable de Validación 1',
                    'type' => 'relate',
                    'view' => 'edit',
                ),
                array(
                    'name' => 'users_accounts_3_name',
                    'label' => 'Responsable de Validación 2',
                    'type' => 'relate',
                    'view' => 'edit',
                ),
            ),
        ),
    ),

);