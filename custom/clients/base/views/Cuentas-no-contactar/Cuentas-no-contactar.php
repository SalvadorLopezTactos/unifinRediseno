<?php
/**
 * Created by Salvador Lopez salvador.lopez@tactos.com.mx
 * Date: 08/11/19
 */
$viewdefs['base']['view']['Cuentas-no-contactar'] = array(
    'panels' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'users_accounts_1_name',
                    'label' => 'Asesor',
                    'type' => 'relate',
                    'view' => 'edit',
                ),
            ),
        ),
    ),
);