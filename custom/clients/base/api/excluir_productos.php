<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 23/09/20
 * Time: 12:35 PM
 */

class excluir_productos extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GET_UserRoles' => array(
                'reqType' => 'GET',
                'path' => array('productoExcluye', '?', '?', '?', '?'),
                'pathVars' => array('', 'idCuenta', 'Producto', 'Negocio', 'Financiero'),
                'method' => 'Excluyeprecalif',
                'shortHelp' => 'Obtiene el campo exluir_precalifica de Uni_productos de la cuenta',
            ),
        );
    }

    public function Excluyeprecalif($api, $args)
    {

        global $db;
        $idCuenta = $args['idCuenta'];
        $Producto = $args['Producto'];
		$Negocio = $args['Negocio'];
		$Financiero = $args['Financiero'];
		$respuesta = 0;
		$query = <<<SQL
SELECT prod.name,prod.tipo_producto,cstm.exclu_precalif_c FROM accounts_uni_productos_1_c rel
INNER JOIN uni_productos prod
ON prod.id=rel.accounts_uni_productos_1uni_productos_idb
INNER JOIN uni_productos_cstm cstm
ON cstm.id_c=prod.id
where rel.accounts_uni_productos_1accounts_ida='{$idCuenta}'
AND prod.deleted='0' AND prod.tipo_producto='{$Producto}'
SQL;
		$queryResult = $db->query($query);
		while ($row = $db->fetchByAssoc($queryResult)) {
			$respuesta = $row['exclu_precalif_c'];
		}
		if(!$respuesta) {
			$query = <<<SQL
SELECT b.valida_comercial_c FROM prod_estructura_productos a, prod_estructura_productos_cstm b 
WHERE a.id = b.id_c and a.tipo_producto = '{$Producto}' AND a.negocio = '{$Negocio}'
AND a.producto_financiero = '{$Financiero}' and a.deleted = 0
SQL;
			$queryResult = $db->query($query);
			while ($row = $db->fetchByAssoc($queryResult)) {
				if(!$row['valida_comercial_c']) $respuesta = 1;
			}
		}
        $GLOBALS['log']->fatal('Respuesta Excluyeprecalif '.$respuesta);
        return $respuesta;
    }
}