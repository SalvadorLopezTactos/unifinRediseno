<?php
/**
 * @author F. Javier G. Solar
 * User: javier.garcia@tactos.com.mx
 * Date: 21/09/2018
 */


global $current_user;
$variable = 'user_id_c';

$viewdefs['Accounts']['base']['filter']['promotorAccounts'] = array(
    'create' => true,
    'filters' => array(
        array(

            'id' => 'promotorAccounts',
            'name' => 'Cuentas por Promotor',
            'filter_definition' => array(

                   /* array(
                        'promotorleasing_c' => array( // c57e811e-b81a-cde4-d6b4-5626c9961772
                            '$in' => array($current_user->id),
                        ),

                    ), */
                    array(
                        'user_id_c' => array( // c57e811e-b81a-cde4-d6b4-5626c9961772
                            '$in' => array($current_user->id),
                        ),
                    ),
            ),
            'editable' => true,
        )
    )
);
