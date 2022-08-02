<?php
/**
 * Created by Tactos
 * User: ECB
 * Date: 20/05/2022
 */

class validacion_comercial
{
    function validacion_comercial($bean, $event, $arguments)
    {
  		// Prende campo Aplica Validación Comercial
        global $db;
  		$query = "select b.valida_comercial_c from prod_estructura_productos a, prod_estructura_productos_cstm b where a.id = b.id_c and a.tipo_producto = '{$bean->tipo_producto_c}' and a.negocio = '{$bean->negocio_c}' and producto_financiero = '{$bean->producto_financiero_c}'";
  		$result = $db->query($query);
  		$row = $db->fetchByAssoc($result);
  		$valida = $row['valida_comercial_c'];
  		if($valida)
  		{
			require_once("custom/clients/base/api/excluir_productos.php");
			global $db, $current_user, $app_list_strings;
			$args_uni_producto = [];
			$args_uni_producto['idCuenta'] = $bean->account_id;
			$args_uni_producto['Producto'] = $bean->tipo_producto_c;
			$args_uni_producto['Negocio'] = $bean->negocio_c;
			$args_uni_producto['Financiero'] = $bean->producto_financiero_c;
			$EjecutaApi = new excluir_productos();
			$response_exluye = $EjecutaApi->Excluyeprecalif(null, $args_uni_producto);
  			if(!$response_exluye) $bean->valida_comercial_c = 1;
  		}
  	}
}
