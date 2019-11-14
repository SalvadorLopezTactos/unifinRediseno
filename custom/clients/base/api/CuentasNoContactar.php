<?php
/**
 * Created by PhpStorm.
 * User: Salvador Lopez <salvador.lopez@tactos.com.mx>
 * Date: 11/11/2019
 */

require_once("custom/Levementum/DropdownValuesHelper.php");
require_once("custom/Levementum/UnifinAPI.php");
require_once('config_override.php');

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class CuentasNoContactar extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'getCuentasNoContactar' => array(
                'reqType' => 'GET',
                'path' => array('CuentasNoContactar', '?'),
                'pathVars' => array('', 'id'),
                'method' => 'getCuentasNoContactar',
                'shortHelp' => 'Obtener cuentas para establecer: No Contactar',
            ),
            'updateCuentasNoContactar' => array(
                'reqType' => 'POST',
                'path' => array('ActualizarCuentasNoContactar'),
                'pathVars' => array(''),
                'method' => 'updateCuentasNoContactar',
                'shortHelp' => 'Establece Cuentas como No Contactar y se le asigna el asesor 9.- Moroso junto con Solicitudes y Backlog',
            ),

        );
    }

    public function getCuentasNoContactar($api, $args)
    {
        try {
            global $db;
            $user_id = $args['id'];
            //"c57e811e-b81a-cde4-d6b4-5626c9961772?PRODUCTO=LEASING?0?&tipos_cuenta=Lead,Prospecto,Cliente,Persona,Proveedor"
            $offset = $args['from'];
            $filtroCliente = $args['cliente'];
            //Omitiendo espacios en blanco
            $filtroCliente = trim($filtroCliente);
            $filtroTipoCuenta = $args['tipos_cuenta'];

            $tipos_separados = explode(",", $filtroTipoCuenta);
            $arr_aux = array();

            for ($i = 0; $i < count($tipos_separados); $i++) {
                array_push($arr_aux, "'" . $tipos_separados[$i] . "'");
            }

            $tipos_query = join(',', $arr_aux);


            $total_rows = <<<SQL
SELECT id, name, tipodepersona_c, tipo_registro_c, idcliente_c,tct_no_contactar_chk_c FROM accounts
INNER JOIN accounts_cstm ON accounts_cstm.id_c = accounts.id
SQL;
            if ($user_id == "undefined") {
                $total_rows .= " WHERE tipo_registro_c IN({$tipos_query}) AND deleted =0";
            } else {
                $total_rows .= " WHERE tipo_registro_c IN({$tipos_query})
AND (user_id_c='{$user_id}' OR user_id1_c='{$user_id}' OR user_id2_c='{$user_id}' OR user_id6_c='{$user_id}')
 AND deleted =0";
            }
            if (!empty($filtroCliente)) {
                $total_rows .= " AND name LIKE '%{$filtroCliente}%' ";
            }
            $totalResult = $db->query($total_rows);

            $response['total'] = $totalResult->num_rows;
            while ($row = $db->fetchByAssoc($totalResult)) {
                $response['full_cuentas'][] = $row['id'];
            }

            $query = <<<SQL
SELECT id, name, tipodepersona_c, tipo_registro_c, rfc_c, idcliente_c,tct_no_contactar_chk_c FROM accounts
INNER JOIN accounts_cstm ON accounts_cstm.id_c = accounts.id
SQL;
            if ($user_id == "undefined") {
                $query .= " WHERE tipo_registro_c IN({$tipos_query}) AND deleted =0";
            } else {
                $query .= " WHERE tipo_registro_c IN({$tipos_query})
AND (user_id_c='{$user_id}' OR user_id1_c='{$user_id}' OR user_id2_c='{$user_id}' OR user_id6_c='{$user_id}')
 AND deleted =0";
            }

            if (!empty($filtroCliente)) {
                $query .= " AND name LIKE '%{$filtroCliente}%' ";
            }
            $query .= " ORDER BY name ASC LIMIT 20 OFFSET {$offset}";
            $queryResult = $db->query($query);
            $response['total_cuentas'] = $queryResult->num_rows;
            while ($row = $db->fetchByAssoc($queryResult)) {
                $response['cuentas'][] = $row;
            }
            return $response;
        } catch (Exception $e) {
            global $current_user;
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> :  Error " . $e->getMessage());
        }
    }

    public function updateCuentasNoContactar($api, $args)
    {

        global $db, $current_user;

        //Obtener los ids de las Cuentas a actualizar
        $cuentas = $args['data']['cuentas'];
        $cuentas_resumen['actualizados']=array();
        $cuentas_resumen['no_actualizados']=array();
        //Obtener id de usuario 9 - Moroso
        $id_user_assing = '405cc6b7-fc4a-7cae-552f-5628f61fd849';

        $IntValue = new DropdownValuesHelper();
        $callApi = new UnifinAPI();

        for ($i = 0; $i < count($cuentas); $i++) {

            $account = BeanFactory::retrieveBean('Accounts', $cuentas[$i]);
            if ($account != null) {

                //Campo "No Contactar"
                $account->tct_no_contactar_chk_c = 1;
                //Leasing
                $account->user_id_c = $id_user_assing;
                //Crédito Automotriz
                $account->user_id2_c = $id_user_assing;
                //Factoraje
                $account->user_id1_c = $id_user_assing;
                //Fleet
                $account->user_id6_c = $id_user_assing;

                $account->save();

                array_push($cuentas_resumen['actualizados'],$cuentas[$i]);

                /*Actualizar solicitudes*/
                $query = <<<SQL
UPDATE opportunities
INNER JOIN accounts_opportunities ON accounts_opportunities.opportunity_id = opportunities.id AND accounts_opportunities.deleted = 0
INNER JOIN accounts ON accounts.id = accounts_opportunities.account_id AND accounts.deleted = 0
INNER JOIN opportunities_cstm cs ON opportunities.id = cs.id_c
SET opportunities.assigned_user_id = '{$id_user_assing}'
WHERE accounts.id = '{$cuentas[$i]}'
SQL;
                $queryResult = $db->query($query);

                /*Actualizar backlogs*/

                //Meses siguientes
                //$condicion=" AND ((b.anio = year(NOW()) and b.mes > month(NOW())) OR b.anio > year(NOW()))";
                //Mes actual y siguientes
                $condicion = " AND ((b.anio = year(NOW()) and b.mes >= month(NOW())) OR b.anio > year(NOW()))";
                $bl_cuenta = "SELECT b.id, b.mes,b.description
  FROM
      lev_backlog b
  WHERE
      b.account_id_c = '{$cuentas[$i]}'" . $condicion . "
          AND deleted = 0;";

                $result_bl_cuentas = $db->query($bl_cuenta);

                if ($result_bl_cuentas->num_rows > 0 && $result_bl_cuentas != null) {

                    while ($row = $db->fetchByAssoc($result_bl_cuentas)) {

                        $bl = BeanFactory::retrieveBean("lev_Backlog", $row['id']);
                        if ($bl != null) {
                            $bl->assigned_user_id = $id_user_assing;
                            //$bl->description=$row['description']. ' \n UNI2CRM - '. $hoy.'/'. $mes_actual.'/'. $anio_actual. ': BL Reasignado a promotor '. $IntValue->getUserName($reAsignado);
                            $bl->save();
                        }
                    }

                }

                $query = <<<SQL
select CASE WHEN idcliente_c > 0 THEN idcliente_c ELSE 0 END idCliente from accounts_cstm where id_c = '{$cuentas[$i]}'
SQL;
                $idCliente = $db->getone($query);

                if (intval($idCliente) > 0) {
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> :  Se sincronizaran promtores con UNICS ");
                    $hostLeasing = "http://" . $GLOBALS['unifin_url'] . "/Uni2WsClnt/WsRest/Uni2ClntService.svc/Uni2/AsignaPromotor?idCliente=" . $idCliente . "&usuarioPromotorLeasing=" . $IntValue->getUserName($id_user_assing) . "&usuarioDominio=" . $current_user->user_name;;
                    $callApi->unifingetCall($hostLeasing);
                    $hostFactoraje = "http://" . $GLOBALS['unifin_url'] . "/Uni2WsClnt/WsRest/Uni2ClntService.svc/Uni2/AsignaPromotor?idCliente=" . $idCliente . "&usuarioPromotorFactoring=" . $IntValue->getUserName($id_user_assing) . "&usuarioDominio=" . $current_user->user_name;;
                    $callApi->unifingetCall($hostFactoraje);
                    $hostCA = "http://" . $GLOBALS['unifin_url'] . "/Uni2WsClnt/WsRest/Uni2ClntService.svc/Uni2/AsignaPromotor?idCliente=" . $idCliente . "&usuarioPromotorCredit=" . $IntValue->getUserName($id_user_assing) . "&usuarioDominio=" . $current_user->user_name;
                    $callApi->unifingetCall($hostCA);

                } else {
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> :  La persona a reasignar no cuenta con IdCliente: " . print_r($idCliente, 1));
                }

            }else{

                array_push($cuentas_resumen['no_actualizados'],$cuentas[$i]);

            }


        }//for

        return $cuentas_resumen;

    }
}