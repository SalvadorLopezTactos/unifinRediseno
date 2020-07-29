<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 7/20/2015
 * Time: 4:00 PM
 */

require_once("custom/Levementum/DropdownValuesHelper.php");
require_once("custom/Levementum/UnifinAPI.php");
require_once('config_override.php');

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class reAsignarCuentas extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POSTreAsignarCuentas' => array(
                'reqType' => 'POST',
                'path' => array('reAsignarCuentas'),
                'pathVars' => array(''),
                'method' => 'asignarCuentas',
                'shortHelp' => 'Obtener cuentas de promotores',
            ),
        );
    }

    public function asignarCuentas($api, $args)
    {
        global $db, $current_user;
        $actualizados = array();
        $no_actualizados = array();
        $reAsignado = $args['data']['reAssignado'];
        $product = $args['data']['producto_seleccionado'];
        //Eliminando saltos de línea
        $product = str_replace("\r", "", $product);
        $promoActual = $args['data']['promoActual'];
        $optRadio = $args['data']['optBl'];
        $nombreArchivo = $args['data']['nombreArchivo'];
        $statusProducto = $args['data']['status_producto'];
        $idProducto = $args['data']['producto_seleccionado_id'];

        if ($product == "LEASING") {
            $user_field = "user_id_c"; //user_id_c = promotorleasing_c
        } else if ($product == "FACTORAJE") {
            $user_field = "user_id1_c"; //user_id1_c = promotorfactoraje_c
        } else if ($product == "CREDITO AUTOMOTRIZ") {
            $user_field = "user_id2_c"; //user_id2_c = promotorcredit_c
        } else if ($product == "FLEET") {
            $user_field = "user_id6_c";
        } else if ($product == "UNICLICK") {
            $user_field = "user_id7_c";
        }else if ($product == "UNILEASE") {
            $user_field = "user_id7_c";
        }else if ($product == "RM") {
            $user_field = "user_id8_c";
        }


        $IntValue = new DropdownValuesHelper();
        $callApi = new UnifinAPI();
        foreach ($args['data']['seleccionados'] as $key => $value) {

            $account = BeanFactory::retrieveBean('Accounts', $value,array('disable_row_level_security' => true));

            if ($account == null || $user_field == null || $reAsignado == null || $promoActual == null) {

                array_push($no_actualizados, $value);
            } else {

                /****************************Re-Asigna Fecha y Re-Asigna Asesor en UNI_PRODUCTOS*****************/
                if ($account->load_relationship('accounts_uni_productos_1')){
                    $uniProducto = $account->accounts_uni_productos_1->getBeans($account->id,array('disable_row_level_security' => true));

                    $fechaReAsignaAsesor = date("Y-m-d"); //Fecha de Hoy

                    foreach ($uniProducto as $asignaFecha) {

                        switch ($product) {
                            case 'LEASING':
                                if ($asignaFecha->tipo_producto == '1') {  //Leasing
                                    // $GLOBALS['log']->fatal("Leasing UniProductos - Reasignado");
                                    $asignaFecha->fecha_asignacion_c = $fechaReAsignaAsesor;
                                    $asignaFecha->assigned_user_id = $reAsignado;
                                }
                                break;
                            case 'CREDITO AUTOMOTRIZ':
                                if ($asignaFecha->tipo_producto == '3') { //Credito-Automotriz
                                    // $GLOBALS['log']->fatal("Credito UniProductos - Reasignado");
                                    $asignaFecha->fecha_asignacion_c = $fechaReAsignaAsesor;
                                    $asignaFecha->assigned_user_id = $reAsignado;
                                }
                                break;
                            case 'FACTORAJE':
                                if ($asignaFecha->tipo_producto == '4') { //Factoraje
                                    // $GLOBALS['log']->fatal("Factoraje UniProductos - Reasignado");
                                    $asignaFecha->fecha_asignacion_c = $fechaReAsignaAsesor;
                                    $asignaFecha->assigned_user_id = $reAsignado;
                                }
                                break;
                            case 'FLEET':
                                if ($asignaFecha->tipo_producto == '6') { //Fleet
                                    // $GLOBALS['log']->fatal("Fleet UniProductos - Reasignado");
                                    $asignaFecha->fecha_asignacion_c = $fechaReAsignaAsesor;
                                    $asignaFecha->assigned_user_id = $reAsignado;
                                }
                                break;
                            case 'UNICLICK':
                                if ($asignaFecha->tipo_producto == '8') { //Uniclick
                                    // $GLOBALS['log']->fatal("Uniclick UniProductos - Reasignado");
                                    $asignaFecha->fecha_asignacion_c = $fechaReAsignaAsesor;
                                    $asignaFecha->assigned_user_id = $reAsignado;
                                }
                                break;
                            case 'UNILEASE':
                                if ($asignaFecha->tipo_producto == '8') { //Uniclick
                                    // $GLOBALS['log']->fatal("Uniclick UniProductos - Reasignado");
                                    $asignaFecha->fecha_asignacion_c = $fechaReAsignaAsesor;
                                    $asignaFecha->assigned_user_id = $reAsignado;
                                }
                                break;
                        }
                        /** Excepcion para actualiza SOS cuando es tipo producto LEASINGS */
                        if($asignaFecha->tipo_producto == '7' && $product=='LEASING')
                        {
                            $GLOBALS['log']->fatal("Actualizar SOS");
                            $asignaFecha->fecha_asignacion_c = $fechaReAsignaAsesor;
                            $asignaFecha->assigned_user_id = $reAsignado;
                        }

                        $asignaFecha->save();
                    }
                }

                switch ($product) {
                    case 'LEASING':
                        $account->user_id_c = $reAsignado;
                        break;
                    case 'CREDITO AUTOMOTRIZ':
                        $account->user_id2_c = $reAsignado;
                        break;
                    case 'FACTORAJE':
                        $account->user_id1_c = $reAsignado;
                        break;
                    case 'FLEET':
                        $account->user_id6_c = $reAsignado;
                        break;
                    case 'UNICLICK':
                        $account->user_id7_c = $reAsignado;
                        break;
                    case 'UNILEASE':
                        $account->user_id7_c = $reAsignado;
                        break;
                    case 'RM':
                        $account->user_id8_c = $reAsignado;
                        break;
                }

                $account->save();

                array_push($actualizados, $account->id);

                // Funcionalidad para notificar al promotor reasigando
                $User = new User();
                $User->retrieve($reAsignado);
                $para = $User->email1;
                if ($para != null) {
                    if($User->status!='Active'){
                        $reAsignado='';
                    }else{
                        if ($User->optout_c == 1) {
                            $reAsignado = '5cd93b08-6f5a-11e8-8553-00155d963615';
                        }
                    }

                    $jefeAsignado = '';
                    $jefe = $User->reports_to_id;
                    $User->retrieve($jefe);
                    //Establecer id a nuevo jefe solo si éste es Activo
                    if($User->status=='Active'){
                        if ($User->optout_c != 1) {
                            $jefeAsignado = $User->email1;
                        }
                    }else{
                        $jefeAsignado='';
                    }

                    $User->retrieve($promoActual);
                    if($User->status=='Active'){
                        if ($User->optout_c == 1) {
                            $promoActual = '5cd93b08-6f5a-11e8-8553-00155d963615';
                        }
                    }else{
                        $promoActual='';
                    }

                    $jefeActual = '';
                    $jefe = $User->reports_to_id;
                    $User->retrieve($jefe);
                    //Establecer id a jefe Actual solo si éste es Activo
                    if($User->status=='Active'){
                        if ($User->optout_c != 1) {
                            $jefeActual = $User->email1;
                        }
                    }else{
                        $jefeActual='';
                    }

                    $notifica = BeanFactory::newBean('TCT2_Notificaciones');
                    $notifica->name = $para . ' ' . date("Y-m-d H:i:s");
                    $notifica->created_by = $promoActual;
                    $notifica->assigned_user_id = $reAsignado;
                    $notifica->tipo = 'Cambio Promotor';
                    $notifica->tct2_notificaciones_accountsaccounts_ida = $value;
                    $notifica->jefe_anterior_c = $jefeActual;
                    $notifica->jefe_nuevo_c = $jefeAsignado;
                    $notifica->actual_c = $promoActual;
                    $notifica->save();
                    $notId = $notifica->id;
                    global $db;
                    $query = "update tct2_notificaciones set created_by = '$promoActual' where id = '$notId'";
                    $result = $db->query($query);
                }

                //Restablece usuario por asignar
                $reAsignado = $args['data']['reAssignado'];

                //Actualiza Oportunidades
                if ($product == 'LEASING') $producto = 1;
                if ($product == 'CREDITO AUTOMOTRIZ') $producto = 3;
                if ($product == 'FACTORAJE') $producto = 4;
                if ($product == 'FLEET') $producto = 6;
                if ($product == 'UNICLICK') $producto = 8;
                if ($product == 'UNILEASE') $producto = 9;
                if ($product == 'RM') $producto =11; # Validar si se debe reasignar las oportunidades

                $usr_bean = BeanFactory::retrieveBean("Users", $reAsignado, array('disable_row_level_security' => true));

                $query = <<<SQL
UPDATE opportunities
INNER JOIN accounts_opportunities ON accounts_opportunities.opportunity_id = opportunities.id AND accounts_opportunities.deleted = 0
INNER JOIN accounts ON accounts.id = accounts_opportunities.account_id AND accounts.deleted = 0
INNER JOIN opportunities_cstm cs ON opportunities.id = cs.id_c
SET opportunities.assigned_user_id = '{$reAsignado}',
opportunities.team_id = '{$usr_bean->default_team}',
opportunities.team_set_id = '{$usr_bean->team_set_id}'
WHERE accounts.id = '{$value}' AND cs.tipo_producto_c = '{$producto}'
SQL;
                $queryResult = $db->query($query);

                /*   $queryUpdateTeams = "UPDATE opportunities
                     INNER JOIN accounts_opportunities ON accounts_opportunities.opportunity_id = opportunities.id AND accounts_opportunities.deleted = 0
                     INNER JOIN users ON opportunities.assigned_user_id = users.id
                     SET
                         opportunities.team_id = users.team_set_id,
                         opportunities.team_set_id = concat(left(users.team_set_id, 33),'af0')
                     WHERE accounts_opportunities.account_id ='" . $value . "';";
                   $resultUpdateTeams = $db->query($queryUpdateTeams);*/

                //Actualizar el usuario asignado a registros de Backlog relacionados a las cuentas
                //Obtener Backlogs de la cuenta que sean de meses futuros

//                $usr_prd_principal=$current_user->tipodeproducto_c;

            //    if ($product == 'LEASING') {
                    $anio_actual = date("Y");
                    $mes_actual = intval(date("n"));
                    $hoy = date("d");
                    $condicion = '';
                    if ($optRadio == 'siguientes') {
                        $condicion = "AND ((b.anio = year(NOW()) and b.mes > month(NOW())) OR b.anio > year(NOW()))";
                    } else {
                        $condicion = " AND ((b.anio = year(NOW()) and b.mes >= month(NOW())) OR b.anio > year(NOW()))";
                    }

                    if($producto=='1')
                    {
                       $sos_condicion=" OR cstm.producto_c='7'";
                    }

                    $bl_cuenta = "SELECT b.id, b.mes,b.description
FROM
  lev_backlog b
  INNER JOIN lev_backlog_cstm cstm
  ON cstm.id_c=b.id
WHERE
  b.account_id_c = '{$value}'" . $condicion . "
  AND (cstm.producto_c='{$producto}' ".$sos_condicion.") AND deleted = 0";

                    $result_bl_cuentas = $db->query($bl_cuenta);

                    if ($result_bl_cuentas->num_rows > 0 && $result_bl_cuentas != null) {
                        //Recupera nuevo usuario asignado
                        $User = new User();
                        $User->retrieve($reAsignado);
                        while ($row = $db->fetchByAssoc($result_bl_cuentas)) {

                            $bl = BeanFactory::retrieveBean("lev_Backlog", $row['id'],array('disable_row_level_security' => true));
                            if ($bl != null) {
                                //Actualiza valores
                                $bl->assigned_user_id = $reAsignado;
                                $bl->description = $row['description'] . ' \n UNI2CRM - ' . $hoy . '/' . $mes_actual . '/' . $anio_actual . ': BL Reasignado a promotor ' . $IntValue->getUserName($reAsignado);
                                $bl->equipo = $User->equipo_c;
                                $bl->region = $User->region_c;
                                $bl->save();
                            }
                        }

                    }
//                }


                $query = <<<SQL
select CASE WHEN idcliente_c > 0 THEN idcliente_c ELSE 0 END idCliente from accounts_cstm where id_c = '{$value}'
SQL;
                $idCliente = $db->getone($query);
                //Peticiones para actualizar uni2
                if (intval($idCliente) > 0) {
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> :  Se sincronizaran promtores con UNICS ");
                    if ($product == "LEASING") {
                        $host = "http://" . $GLOBALS['unifin_url'] . "/Uni2WsClnt/WsRest/Uni2ClntService.svc/Uni2/AsignaPromotor?idCliente=" . $idCliente . "&usuarioPromotorLeasing=" . $IntValue->getUserName($reAsignado) . "&usuarioDominio=" . $current_user->user_name;
                    } else if ($product == "FACTORAJE") {
                        $host = "http://" . $GLOBALS['unifin_url'] . "/Uni2WsClnt/WsRest/Uni2ClntService.svc/Uni2/AsignaPromotor?idCliente=" . $idCliente . "&usuarioPromotorFactoring=" . $IntValue->getUserName($reAsignado) . "&usuarioDominio=" . $current_user->user_name;
                    } else if ($product == "CREDITO AUTOMOTRIZ") {
                        $host = "http://" . $GLOBALS['unifin_url'] . "/Uni2WsClnt/WsRest/Uni2ClntService.svc/Uni2/AsignaPromotor?idCliente=" . $idCliente . "&usuarioPromotorCredit=" . $IntValue->getUserName($reAsignado) . "&usuarioDominio=" . $current_user->user_name;
                    }
                    $callApi->unifingetCall($host);
                } else {
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> :  La persona a reasignar no cuenta con IdCliente: " . print_r($idCliente, 1));
                }
            }
        }
        $main_array['actualizados'] = $actualizados;
        $main_array['no_actualizados'] = $no_actualizados;
        if (count($no_actualizados) > 0 && $nombreArchivo != null && !empty($nombreArchivo)) {

            $fichero = 'custom/errores_reasignacion/' . $nombreArchivo . '.txt';
            $texto_archivo = '';
            for ($i = 0;
                 $i < count($no_actualizados);
                 $i++) {
                $texto_archivo .= $no_actualizados[$i] . "\n";
            }

// Escribir los contenidos en el fichero,
//// usando la bandera FILE_APPEND para añadir el contenido al final del fichero
/// // y la bandera LOCK_EX para evitar que cualquiera escriba en el fichero al mismo tiempo
            file_put_contents($fichero, $texto_archivo, FILE_APPEND | LOCK_EX);

        }

        return $main_array;

    }
}
