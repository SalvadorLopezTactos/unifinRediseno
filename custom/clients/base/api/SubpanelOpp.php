<?php


class SubpanelOpp extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GET_UserRoles' => array(
                'reqType' => 'GET',
                'path' => array('multilienaUniprod', '?', '?'),
                'pathVars' => array('', 'idCuenta', 'idProducto'),
                'method' => 'productoMultiline',
                'shortHelp' => 'Obtiene la lista de Bproductos relacionados 
                con la cuenta y regresa si el multiliena esta activo',
            ),
            'POST_BenefSuby' => array(
                'reqType' => 'POST',
                'noLoginRequired' => false,
                'path' => array('duplicateOpp'),
                'pathVars' => array(''),
                'method' => 'duplicadosBenefeSuby',
                'shortHelp' => 'Consulta oportunidades que no contengan la misma 
                información de Area beneficiada y Subyacente',
            ),
        );


    }

    public function productoMultiline($api, $args)
    {

        global $db;
        $idCuenta = $args['idCuenta'];
        $idProducto = $args['idProducto'];

        $query = <<<SQL
SELECT prod.name,prod.tipo_producto,cstm.multilinea_c FROM accounts_uni_productos_1_c rel
INNER JOIN uni_productos prod
ON prod.id=rel.accounts_uni_productos_1uni_productos_idb
INNER JOIN uni_productos_cstm cstm
ON cstm.id_c=prod.id
where rel.accounts_uni_productos_1accounts_ida='{$idCuenta}'
      AND prod.deleted='0' AND prod.tipo_producto='{$idProducto}'
SQL;
        $response = null;
        $queryResult = $db->query($query);
        while ($row = $db->fetchByAssoc($queryResult)) {
            $response = $row['multilinea_c'];
        }

        $GLOBALS['log']->fatal($response);

        return $response;
    }

    public function duplicadosBenefeSuby($api, $args)
    {
        $GLOBALS['log']->fatal("Del query " . print_r($args, true));
        global $db;
        $accountId = $args['data']['account_id'];
        $tipo_producto_c = $args['data']['tipo_producto_c'];
        $idOportunidad=$args['data']['idOportunidad'];
        $concatenado=$args['data']['concatenado'];
		$negocio_c=$args['data']['negocio_c'];
		$producto_financiero_c=$args['data']['producto_financiero_c'];
        $GLOBALS['log']->fatal("id oportunidad " . $idOportunidad . "  c " .$concatenado);

        $query = "SELECT * from accounts_opportunities rel
  INNER JOIN opportunities op
    ON op.id=rel.opportunity_id
       AND rel.account_id='{$accountId}'
  INNER JOIN opportunities_cstm cstm
    ON cstm.id_c=op.id
WHERE CONCAT(COALESCE(cstm.estado_benef_c,''),COALESCE(cstm.municipio_benef_c,''),COALESCE(cstm.ent_gob_benef_c,''),
                     COALESCE(cstm.account_id1_c,''),COALESCE(cstm.emp_no_reg_benef_c,''))='{$concatenado}'
      AND cstm.tipo_producto_c= '{$tipo_producto_c}'
	  AND cstm.negocio_c= '{$negocio_c}'
	  AND cstm.producto_financiero_c= '{$producto_financiero_c}'
      AND op.deleted=0
      AND (cstm.estatus_c!='K' AND cstm.estatus_c!='R' AND cstm.estatus_c!='CM' OR cstm.estatus_c is NULL )
      AND op.id !='{$idOportunidad}'";

        $GLOBALS['log']->fatal("Del query " . $query);

        $result = $db->query($query);
        $duplicado = 0;
        $mensaje = '';
        $GLOBALS['log']->fatal("Del query " . $result->num_rows);
        $contOpp = $result->num_rows;
        if ($contOpp > 0) {
            $duplicado = 1;
            $mensaje = 'No es posible crear una Pre-solicitud cuando ya se encuentra una Pre-solicitud o Solicitud con
            la misma información del Área beneficiada';
        }
        $respuesta = ["duplicado" => $duplicado, "mensaje" => $mensaje];
        $GLOBALS['log']->fatal("Del query " . print_r($respuesta, true));
        return $respuesta;
    }
}
