<?php
/**
 * Created by PhpStorm.
 * User: Salvador Lopez <salvador.lopez@tactos.com.mx>
 * Date: 11/11/2019
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class CuentasNoContactar extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'getCuentasNoContactar' => array(
                'reqType' => 'GET',
                'path' => array('CuentasNoContactar','?'),
                'pathVars' => array('','id'),
                'method' => 'getCuentasNoContactar',
                'shortHelp' => 'Obtener cuentas para establecer: No Contactar',
            ),
        );
    }

    public function getCuentasNoContactar($api, $args)
    {
        try
        {
            global $db;
            $user_id = $args['id'];
            //"c57e811e-b81a-cde4-d6b4-5626c9961772?PRODUCTO=LEASING?0?&tipos_cuenta=Lead,Prospecto,Cliente,Persona,Proveedor"
            $offset = $args['from'];
            $filtroCliente = $args['cliente'];
            //Omitiendo espacios en blanco
            $filtroCliente=trim($filtroCliente);
            $filtroTipoCuenta=$args['tipos_cuenta'];

            $tipos_separados=explode(",",$filtroTipoCuenta);
            $arr_aux=array();

            for($i=0;$i<count($tipos_separados);$i++){
                array_push($arr_aux,"'".$tipos_separados[$i]."'");
            }

            $tipos_query= join(',',$arr_aux);


            $total_rows = <<<SQL
SELECT id, name, tipodepersona_c, tipo_registro_c, idcliente_c,tct_no_contactar_chk_c FROM accounts
INNER JOIN accounts_cstm ON accounts_cstm.id_c = accounts.id
SQL;
            if($user_id == "undefined"){
                $total_rows .= " WHERE tipo_registro_c IN({$tipos_query}) AND deleted =0";
            }
			else{
				$total_rows .= " WHERE tipo_registro_c IN({$tipos_query})
AND (user_id_c='{$user_id}' OR user_id1_c='{$user_id}' OR user_id2_c='{$user_id}' OR user_id6_c='{$user_id}')
 AND deleted =0";
			}
            if(!empty($filtroCliente)){
                $total_rows .= " AND name LIKE '%{$filtroCliente}%' ";
            }
            $totalResult = $db->query($total_rows);

            $response['total'] = $totalResult->num_rows;
            while($row = $db->fetchByAssoc($totalResult))
            {
                $response['full_cuentas'][] = $row['id'];
            }

            $query = <<<SQL
SELECT id, name, tipodepersona_c, tipo_registro_c, rfc_c, idcliente_c,tct_no_contactar_chk_c FROM accounts
INNER JOIN accounts_cstm ON accounts_cstm.id_c = accounts.id
SQL;
            if($user_id == "undefined"){
                $query .= " WHERE tipo_registro_c IN({$tipos_query}) AND deleted =0";
            }
			else{
				$query .= " WHERE tipo_registro_c IN({$tipos_query})
AND (user_id_c='{$user_id}' OR user_id1_c='{$user_id}' OR user_id2_c='{$user_id}' OR user_id6_c='{$user_id}')
 AND deleted =0";
			}

            if(!empty($filtroCliente)){
                $query .= " AND name LIKE '%{$filtroCliente}%' ";
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
            global $current_user;
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> :  Error ".$e->getMessage());
        }
    }
}