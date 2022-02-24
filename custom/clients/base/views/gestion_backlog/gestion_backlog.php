<?php
/**
 * Created by Salvador Lopez salvador.lopez@tactos.com.mx
 * Date: 28/01/22
 */
$viewdefs['base']['view']['gestion_backlog'] = array(
    'panels' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'assigned_user_name',
                    'label' => 'Asesor',
                    'type' => 'relate',
                    'view' => 'edit',
                ),
			),
        ),
    ),
);