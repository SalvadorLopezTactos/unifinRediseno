<?php
/**
 * @author F. Javier G. Solar
 * User: javier.garcia@tactos.com.mx
 * Date: 21/09/2018
 */

//AF - 25/09/18

//Define variables
global $current_user;
$field = 'user_id_c';
$value = $current_user->id;
$puestoUsuario = $current_user->puestousuario_c;

//Define puestos por filtro L,F,CA
//Promotor
$filtroPromotor = array(5,11,16);
//Gerente, Subdirector, Director
$filtroEquipo = array(4,10,15,3,9,2,8,14);
//DGA, Backoffice
$filtroEquipo2 = array(1,7,13,6,12,17);
//No filtro
$filtroSin = array(18);

//Establece tipo de filtro; Promotor/Equipo
if (in_array($puestoUsuario, $filtroPromotor)) {
    //Agrega campo Promotor
    switch ($puestoUsuario) {
        case 5:
            $field = 'user_id_c';
            break;
        case 11:
            $field = 'user_id1_c';
            break;
        case 16:
            $field = 'user_id2_c';
            break;
        default:
            $field = 'user_id_c';
    }

    //Establece valor
    $value = $current_user->id;
}else{
    //Agrega campo Equipo
    $field = 'unifin_team';
    $value = 1;

    //Establece valor
    if(in_array($puestoUsuario, $filtroEquipo)){
        $value = $current_user->equipo_c;
    }elseif (condition) {
        # code...
    }
}



$viewdefs['Accounts']['base']['filter']['promotorAccounts'] = array(
    'create' => true,
    'filters' => array(
        array(

            'id' => 'promotorAccounts',
            'name' => 'Mis Cuentas',
            'filter_definition' => array(

                   /* array(
                        'promotorleasing_c' => array( // c57e811e-b81a-cde4-d6b4-5626c9961772
                            '$in' => array($current_user->id),
                        ),

                    ), */
                    array(
                        $field => array( // c57e811e-b81a-cde4-d6b4-5626c9961772
                            '$in' => array($value),
                        ),
                    ),
            ),
            'editable' => true,
        )
    )
);


