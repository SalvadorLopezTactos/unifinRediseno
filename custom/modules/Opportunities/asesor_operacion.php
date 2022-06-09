<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 22/07/20
 * Time: 08:52 AM
 */

class asesor_operacion_class
{
    function asesor_operacion_function($bean, $event, $arguments)
    {

  		// Asesor Asignado vacío ECB 24/02/2022
  		if(empty($bean->assigned_user_id) && !empty($bean->tipo_producto_c) && !empty($bean->negocio_c) && !empty($bean->producto_financiero_c)){
        global $db;
  			$query = "select b.asesor_producto_c from prod_estructura_productos a, prod_estructura_productos_cstm b where a.id = b.id_c and a.tipo_producto = '{$bean->tipo_producto_c}' and a.negocio = '{$bean->negocio_c}' and producto_financiero = '{$bean->producto_financiero_c}'";
  			$result = $db->query($query);
  			$row = $db->fetchByAssoc($result);
  			$asesor = $row['asesor_producto_c'];
  			if(!empty($asesor))
  			{
          $query = "select p.assigned_user_id, u.team_set_id, u.default_team
                from uni_productos p
                inner join accounts_uni_productos_1_c ap on ap.accounts_uni_productos_1uni_productos_idb=p.id
                inner join users u on u.id = p.assigned_user_id
                where
                	p.tipo_producto = '{$asesor}'
                    and ap.accounts_uni_productos_1accounts_ida='{$bean->account_id}'
                    and ap.deleted=0
                    and p.deleted=0;";
  				$result = $db->query($query);
  				$row = $db->fetchByAssoc($result);
  				$asignado = $row['assigned_user_id'];
  				if(!empty($asignado)){
              $bean->assigned_user_id = $asignado;
              $bean->team_set_id = $row['team_set_id'];
              $bean->team_id = $row['default_team'];
          }
  			}
      }
      //$GLOBALS['log']->fatal("solicitudes --> ".$bean->asesor_operacion_c . " asignado  " .$bean->assigned_user_id ." usuario " . $bean->user_id_c);
      if(empty($bean->asesor_operacion_c))
      {
          //$bean->asesor_operacion_c=$bean->assigned_user_id;
          $bean->user_id_c=$bean->assigned_user_id;
      }
  	}
}
