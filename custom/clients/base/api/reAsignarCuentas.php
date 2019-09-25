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

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
        try {
            global $db, $current_user;
            $reAsignado = $args['data']['reAssignado'];
            $product = $args['data']['producto_seleccionado'];
            $promoActual = $args['data']['promoActual'];
            $optRadio=$args['data']['optBl'];
            if ($product == "LEASING") {
                $user_field = "user_id_c"; //user_id_c = promotorleasing_c
            } else if ($product == "FACTORAJE") {
                $user_field = "user_id1_c"; //user_id1_c = promotorfactoraje_c
            } else if ($product == "CREDITO AUTOMOTRIZ") {
                $user_field = "user_id2_c"; //user_id2_c = promotorcredit_c
            }

            $IntValue = new DropdownValuesHelper();
            $callApi = new UnifinAPI();
            foreach ($args['data']['seleccionados'] as $key => $value) {
/*
                $query = <<<SQL
UPDATE accounts
SET assigned_user_id = '{$reAsignado}'
WHERE id = '{$value}'
SQL;
                $queryResult = $db->query($query);
*/

                $account = BeanFactory::retrieveBean('Accounts', $value);

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
                    default:
                        $account->user_id_c = $reAsignado;
                }

                $account->save();

                // Funcionalidad para notificar al promotor reasigando
                $User = new User();
                $User->retrieve($reAsignado);
                $para = $User->email1;
                if($para != null)
                {
          			if($User->optout_c == 1)
          			{
          				$reAsignado = '5cd93b08-6f5a-11e8-8553-00155d963615';
          			}
          			$jefeAsignado = '';
          			$jefe = $User->reports_to_id;
          			$User->retrieve($jefe);
          			if($User->optout_c != 1)
          			{
          				$jefeAsignado = $User->email1;
          			}
                    $User->retrieve($promoActual);
          			if($User->optout_c == 1)
          			{
          				$promoActual = '5cd93b08-6f5a-11e8-8553-00155d963615';
          			}
          			$jefeActual = '';
          			$jefe = $User->reports_to_id;
          			$User->retrieve($jefe);
          			if($User->optout_c != 1)
          			{
          				$jefeActual = $User->email1;
          			}
					$notifica=BeanFactory::newBean('TCT2_Notificaciones');
                    $notifica->name = $para.' '.date("Y-m-d H:i:s");
                    $notifica->created_by = $promoActual;
                    $notifica->assigned_user_id = $reAsignado;
                    $notifica->tipo = 'Cambio Promotor';
                    $notifica->tct2_notificaciones_accountsaccounts_ida = $value;
	          		$notifica->jefe_anterior_c = $jefeActual;
  					$notifica->jefe_nuevo_c = $jefeAsignado;
                    $notifica->save();
                    $notId = $notifica->id;
                 	global $db;
                    $query = "update tct2_notificaciones set created_by = '$promoActual' where id = '$notId'";
                    $result = $db->query($query);
                }

				//Actualiza Oportunidades
				if($product == 'LEASING') $producto = 1;
				if($product == 'CREDITO AUTOMOTRIZ') $producto = 3;
				if($product == 'FACTORAJE') $producto = 4;
                $query = <<<SQL
UPDATE opportunities
INNER JOIN accounts_opportunities ON accounts_opportunities.opportunity_id = opportunities.id AND accounts_opportunities.deleted = 0
INNER JOIN accounts ON accounts.id = accounts_opportunities.account_id AND accounts.deleted = 0
INNER JOIN opportunities_cstm cs ON opportunities.id = cs.id_c
SET opportunities.assigned_user_id = '{$reAsignado}'
WHERE accounts.id = '{$value}' AND cs.tipo_producto_c = '{$producto}'
SQL;
                $queryResult = $db->query($query);

                $queryUpdateTeams = "UPDATE opportunities
                  INNER JOIN accounts_opportunities ON accounts_opportunities.opportunity_id = opportunities.id AND accounts_opportunities.deleted = 0
                  INNER JOIN users ON opportunities.assigned_user_id = users.id
                  SET
                  	opportunities.team_id = users.team_set_id,
                      opportunities.team_set_id = concat(left(users.team_set_id, 33),'af0')
                  WHERE accounts_opportunities.account_id ='".$value."';";
                $resultUpdateTeams = $db->query($queryUpdateTeams);

                // Se comenta la actualizacion directa a BD para utilizar el BEAN y registrar bitacora
               /* $query = <<<SQL
UPDATE accounts_cstm
SET {$user_field} = '{$reAsignado}'
WHERE id_c = '{$value}'
SQL;
                $queryResult = $db->query($query);

                */
/*
                $query = <<<SQL
UPDATE dire_direccion
INNER JOIN accounts_dire_direccion_1_c ON accounts_dire_direccion_1_c.accounts_dire_direccion_1dire_direccion_idb = dire_direccion.id AND accounts_dire_direccion_1_c.deleted = 0
INNER JOIN accounts ON accounts.id = accounts_dire_direccion_1_c.accounts_dire_direccion_1accounts_ida AND accounts.deleted = 0
SET dire_direccion.assigned_user_id = '{$reAsignado}'
WHERE accounts.id = '{$value}'
SQL;
                $queryResult = $db->query($query);

                $query = <<<SQL
UPDATE tel_telefonos
INNER JOIN accounts_tel_telefonos_1_c ON accounts_tel_telefonos_1_c.accounts_tel_telefonos_1tel_telefonos_idb = tel_telefonos.id AND accounts_tel_telefonos_1_c.deleted = 0
INNER JOIN accounts ON accounts.id = accounts_tel_telefonos_1_c.accounts_tel_telefonos_1accounts_ida AND accounts.deleted = 0
SET tel_telefonos.assigned_user_id = '{$reAsignado}'
WHERE accounts.id = '{$value}'
SQL;
                $queryResult = $db->query($query);

                $query = <<<SQL
UPDATE meetings
SET assigned_user_id = '{$reAsignado}'
WHERE parent_id = '{$value}'
SQL;
                $queryResult = $db->query($query);

                $query = <<<SQL
UPDATE calls
SET assigned_user_id = '{$reAsignado}'
WHERE parent_id = '{$value}'
SQL;
                $queryResult = $db->query($query);

                $query = <<<SQL
UPDATE notes
SET assigned_user_id = '{$reAsignado}'
WHERE parent_id = '{$value}'
SQL;
                $queryResult = $db->query($query);

                $query = <<<SQL
UPDATE tasks
SET assigned_user_id = '{$reAsignado}'
WHERE parent_id = '{$value}'
SQL;
                $queryResult = $db->query($query);

                $query = <<<SQL
UPDATE opportunities
INNER JOIN accounts_opportunities ON accounts_opportunities.opportunity_id = opportunities.id AND accounts_opportunities.deleted = 0
INNER JOIN accounts ON accounts.id = accounts_opportunities.account_id AND accounts.deleted = 0
inner join opportunities_cstm cs on opportunities.id = cs.id_c
SET opportunities.assigned_user_id = '{$reAsignado}'
WHERE accounts.id = '{$value}' and cs.estatus_c in('P','OP','D','E')
SQL;
                $queryResult = $db->query($query);

                $query = <<<SQL
UPDATE rel_relaciones
INNER JOIN rel_relaciones_accounts_1_c ON rel_relaciones_accounts_1_c.rel_relaciones_accounts_1rel_relaciones_idb = rel_relaciones.id AND rel_relaciones_accounts_1_c.deleted = 0
INNER JOIN accounts ON accounts.id = rel_relaciones_accounts_1_c.rel_relaciones_accounts_1accounts_ida AND accounts.deleted = 0
SET rel_relaciones.assigned_user_id = '{$reAsignado}'
WHERE accounts.id = '{$value}'
SQL;
                $queryResult = $db->query($query);
*/
                /*
                if ($product == "LEASING") {
                    $query = <<<SQL
                update lev_backlog lev
SET assigned_user_id = '{$reAsignado}',
description = CONCAT(description, ' \n UNI2CRM - ', CONCAT(day(NOW()),'/', month(NOW()),'/', year(NOW())), ': BL Reasignado a promotor ', '{$IntValue->getUserName($reAsignado)}')
where lev.account_id_c = '{$value}'
AND deleted = 0
and ((lev.anio = year(NOW()) and lev.mes >= month(NOW())) OR lev.anio > year(NOW()));
SQL;
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> :  Update para reasignacion de BL: " . print_r($query, 1));
                    $queryResult = $db->query($query);
                }
                */

                //Actualizar el usuario asignado a registros de Backlog relacionados a las cuentas
                //Obtener Backlogs de la cuenta que sean de meses futuros
                if ($product == 'LEASING') {
                  $anio_actual=date("Y");
                  $mes_actual= intval(date("n"));
                  $hoy= date("d");
                  $condicion='';
                  if($optRadio=='siguientes'){

                      $condicion=" AND ((b.anio = year(NOW()) and b.mes > month(NOW())) OR b.anio > year(NOW()))";

                  }else{
                      $condicion=" AND ((b.anio = year(NOW()) and b.mes >= month(NOW())) OR b.anio > year(NOW()))";
                  }

                  $bl_cuenta="SELECT b.id, b.mes,b.description
  FROM
      lev_backlog b
  WHERE
      b.account_id_c = '{$value}'".$condicion."
          AND deleted = 0;";

                  $result_bl_cuentas = $db->query($bl_cuenta);

                  if($result_bl_cuentas->num_rows>0 && $result_bl_cuentas != null){

                      while ($row = $db->fetchByAssoc($result_bl_cuentas)) {

                          $bl=BeanFactory::retrieveBean("lev_Backlog", $row['id']);
                          if($bl != null){
                              $bl->assigned_user_id=$reAsignado;
                              $bl->description=$row['description']. ' \n UNI2CRM - '. $hoy.'/'. $mes_actual.'/'. $anio_actual. ': BL Reasignado a promotor '. $IntValue->getUserName($reAsignado);
                              $bl->save();
                          }
                      }

                  }
                }


                $query = <<<SQL
select CASE WHEN idcliente_c > 0 THEN idcliente_c ELSE 0 END idCliente from accounts_cstm where id_c = '{$value}'
SQL;
                $idCliente = $db->getone($query);

                if (intval($idCliente) > 0){
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> :  Se sincronizaran promtores con UNICS " );
                    if ($product == "LEASING") {
                        $host = "http://".$GLOBALS['unifin_url']."/Uni2WsClnt/WsRest/Uni2ClntService.svc/Uni2/AsignaPromotor?idCliente=".$idCliente."&usuarioPromotorLeasing=". $IntValue->getUserName($reAsignado) ."&usuarioDominio=" . $current_user->user_name;
                    } else if ($product == "FACTORAJE") {
                        $host = "http://".$GLOBALS['unifin_url']."/Uni2WsClnt/WsRest/Uni2ClntService.svc/Uni2/AsignaPromotor?idCliente=".$idCliente."&usuarioPromotorFactoring=". $IntValue->getUserName($reAsignado) ."&usuarioDominio=" . $current_user->user_name;
                    } else if ($product == "CREDITO AUTOMOTRIZ") {
                        $host = "http://".$GLOBALS['unifin_url']."/Uni2WsClnt/WsRest/Uni2ClntService.svc/Uni2/AsignaPromotor?idCliente=".$idCliente."&usuarioPromotorCredit=". $IntValue->getUserName($reAsignado) ."&usuarioDominio=" . $current_user->user_name;
                    }
                    $callApi->unifingetCall($host);
                }else{
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> :  La persona a reasignar no cuenta con IdCliente: " . print_r($idCliente,1));
                }
            }
            return true;


        } catch (Exception $e) {
            error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Error: " . $e->getMessage());
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> :  Error " . $e->getMessage());
        }
    }
}
