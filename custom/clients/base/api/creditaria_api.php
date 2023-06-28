<?php
/**
 * Created by Tactos.
 * User: Eduardo Carrasco Beltrán
 * Date: 26/06/2023
 */

class creditaria_api extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'creditaria_api' => array(
                'reqType' => 'GET',
                'path' => array('creditaria_api','?'),
                'pathVars' => array('atendido','id_cuenta'),
                'method' => 'atendido',
                'shortHelp' => 'Recupera estatus de atención de cuenta de Seguros',
            ),
        );
    }

    public function atendido($api, $args)
    {
        global $db;
		$idCuenta = $args['id_cuenta'];
        $query = "select a.estatus_atencion, b.status_management_c from uni_productos a, uni_productos_cstm b where a.id = b.id_c and a.deleted = 0 and a.estatus_atencion <> 3 and a.tipo_producto = 10 and a.id in (select accounts_uni_productos_1uni_productos_idb from accounts_uni_productos_1_c where deleted = 0 and accounts_uni_productos_1accounts_ida = '{$idCuenta}')";
        $result = $db->query($query);
		$row = $db->fetchByAssoc($result);
        $respuesta = array(
            "estatus_atencion" => $row['estatus_atencion'],
            "status_management_c" => $row['status_management_c']
        );
        return $respuesta;
    }
}