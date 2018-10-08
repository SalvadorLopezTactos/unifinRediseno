<?php
/**
 * @author F. Javier G. Solar
 * User: javier.garcia@tactos.com.mx
 * Date: 21/09/2018
 */

<<<<<<< HEAD
//AF - 25/09/18

//Define variables
=======

>>>>>>> 43977a7c3fd403cd75b4edeab19569e01f7b5f2e
global $current_user;
//$field = 'user_id_c';
//$value = $current_user->id;
$puestoUsuario = $current_user->puestousuario_c;
//$GLOBALS['log']->fatal("Tiene el puesto:  ".$puestoUsuario);

//Define puestos por filtro L,F,CA
//Promotor
$filtroPromotor = array(5, 11, 16);
//Gerente, Subdirector, Director
$filtroEquipo = array(4, 10, 15, 3, 9, 2, 8, 14);
//DGA, Backoffice
$filtroEquipo2 = array(1, 7, 13, 6, 12, 17,33);
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
} elseif (in_array($puestoUsuario, $filtroEquipo)) {
    $field = 'unifin_team';
    $value = $current_user->equipo_c;
} elseif (in_array($puestoUsuario, $filtroEquipo2)) {
    $field = 'unifin_team';

    $value = str_replace("^","",$current_user->equipos_c);
    $GLOBALS['log']->fatal(print_r($value,true));

    $value=split(',',$value);

} elseif (in_array($puestoUsuario, $filtroSin)) {
    $field = "user_id_c";
   // $value = '';
}


//$GLOBALS['log']->fatal("Antes de crear el filtro  ".$field . "    " .  print_r($value,true));

$viewdefs['Accounts']['base']['filter']['promotorAccounts'] = array(
    'create' => true,
    'filters' => array(
        array(

            'id' => 'promotorAccounts',
            'name' => 'Mis Cuentas',
            'filter_definition' => array(

                array(
                    $field => array(
                        '$in' => array($value),
                    ),
                ),
            ),
            'editable' => true,
        )
    )
);


