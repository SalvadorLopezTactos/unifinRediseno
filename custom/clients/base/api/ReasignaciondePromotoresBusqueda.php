<?php
/**
 * Created by PhpStorm.
 * User: Levementum
 * Date: 7/17/2015
 * Time: 4:36 PM
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class ReasignaciondePromotoresBusqueda extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETReasignaciondePromotoresBusqueda' => array(
                'reqType' => 'GET',
                'path' => array('ReasignaciondePromotoresBusqueda','?'),
                'pathVars' => array('','id'),
                'method' => 'obtenerCuentas',
                'shortHelp' => 'Obtener cuentas de promotores',
            ),
        );
    }

    public function obtenerCuentas($api, $args)
    {
        try
        {
            global $db;
            $user_id = $args['id'];
            $product_offset = $args['PRODUCTO'];
            $product_offset = explode("?", $product_offset);
            $product = $product_offset[0];
            $offset = $product_offset[1];
            $filtroCliente = $product_offset[2];
            //Omitiendo espacios en blanco
            $filtroCliente=trim($filtroCliente);
            $filtroTipoCuenta=$args['tipos_cuenta'];

            $tipos_separados=explode(",",$filtroTipoCuenta);
            $arr_aux=array();

            for($i=0;$i<count($tipos_separados);$i++){
                array_push($arr_aux,"'".$tipos_separados[$i]."'");
            }

            $tipos_query= join(',',$arr_aux);


             if($product == "LEASING"){
                 $user_field = "user_id_c"; //user_id_c = promotorleasing_c
             }else if($product == "FACTORAJE"){
                 $user_field = "user_id1_c"; //user_id1_c = promotorfactoraje_c
             }else if($product == "CREDITO AUTOMOTRIZ"){
                 $user_field = "user_id2_c"; //user_id2_c = promotorcredit_c
             }else if($product == "FLEET"){
                 $user_field = "user_id6_c";
             }else if($product == "UNICLICK"){
                 $user_field = "user_id7_c";
             }else if($product == "UNILEASE"){
                 $user_field = "user_id7_c";
             }

            $total_rows = <<<SQL
SELECT id, name, tipodepersona_c, tipo_registro_cuenta_c, idcliente_c FROM accounts
INNER JOIN accounts_cstm ON accounts_cstm.id_c = accounts.id
SQL;
            if($user_id == "undefined"){
                $total_rows .= " WHERE tipo_registro_cuenta_c IN({$tipos_query}) AND deleted =0";
            }
			else{
				$total_rows .= " WHERE {$user_field} = '{$user_id}' AND tipo_registro_cuenta_c IN({$tipos_query}) AND deleted =0";
			}
            if(!empty($filtroCliente)){
                $total_rows .= " AND tipo_registro_cuenta_c IN({$tipos_query}) AND name LIKE '%{$filtroCliente}%' ";
            }
            $totalResult = $db->query($total_rows);

            $response['total'] = $totalResult->num_rows;
            while($row = $db->fetchByAssoc($totalResult))
            {
                $response['full_cuentas'][] = $row['id'];
            }

            $query = <<<SQL
SELECT id, name, tipodepersona_c, tipo_registro_cuenta_c, rfc_c, idcliente_c FROM accounts
INNER JOIN accounts_cstm ON accounts_cstm.id_c = accounts.id
SQL;
            if($user_id == "undefined"){
                $query .= " WHERE tipo_registro_cuenta_c IN({$tipos_query}) AND deleted =0";
            }
			else{
				$query .= " WHERE {$user_field} = '{$user_id}' AND tipo_registro_cuenta_c IN({$tipos_query}) AND deleted =0";
			}

            if(!empty($filtroCliente)){
                $query .= " AND tipo_registro_cuenta_c IN({$tipos_query}) AND name LIKE '%{$filtroCliente}%' ";
            }
            $query .= " ORDER BY name ASC LIMIT 20 OFFSET {$offset}";
            $queryResult = $db->query($query);
            $response['total_cuentas'] = $queryResult->num_rows;
            while($row = $db->fetchByAssoc($queryResult))
            {
                 $response['cuentas'][] = $row;
            }        
            return $response;
        }catch (Exception $e){
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> :  Error ".$e->getMessage());
        }
    }
}