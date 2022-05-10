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
  				$query = "select assigned_user_id from uni_productos where tipo_producto = '{$asesor}' and id in (select accounts_uni_productos_1uni_productos_idb from accounts_uni_productos_1_c where accounts_uni_productos_1accounts_ida = '{$bean->account_id}')";
  				$result = $db->query($query);
  				$row = $db->fetchByAssoc($result);
  				$asignado = $row['assigned_user_id'];
  				if(!empty($asignado)) $bean->assigned_user_id = $asignado;
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
