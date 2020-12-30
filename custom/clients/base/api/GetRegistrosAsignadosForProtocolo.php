<?php
/**
 * Created by Salvador Lopez.
  */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetRegistrosAsignadosForProtocolo extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetRegistrosAsignadosForProtocolo','?'),
                //endpoint variables
                'pathVars' => array('method','id_user'),
                //method to call
                'method' => 'getRecordsAssign',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que obtiene el número de registros asignados (Cuentas y Leads) para controlar proceso de protocolo de reasignación de Leads',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function getRecordsAssign($api, $args)
    {
        
        global $db;
        $id_user=$args['id_user'];
        $total_leads=0;
        $total_cuentas=0;
        $total_registros=0;

        //Query para obtener el número de leads asignados al usuario actual
        $query = "SELECT count(l.id) as total_leads FROM leads l inner JOIN leads_cstm lc on l.id=lc.id_c 
WHERE l.assigned_user_id='{$id_user}'
and lc.subtipo_registro_c not in('4','3') and l.deleted=0";//4 - Convertido, 3 - Cancelado
        $result = $db->query($query);

        while($row = $db->fetchByAssoc($result)){
            $total_leads = $row['total_leads']; 
        }

        $query_cuentas="SELECT count(a.id) as total_cuentas FROM accounts a
INNER JOIN accounts_cstm ac on ac.id_c = a.id
INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb
INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
WHERE ac.tipo_registro_cuenta_c = '2'
and ac.subtipo_registro_cuenta_c IN ('2','7','8')
and ac.user_id_c = '{$id_user}'
and up.tipo_producto = '1'
and upc.status_management_c IS NULL OR upc.status_management_c = '1'
and a.deleted = 0 and up.deleted = 0";
    //tipo_registro_cuenta_c 2 - Prospecto , subtipo_registro_cuenta_c=2 - Contactado,7-Interesado, 8 - Integración de Expediente

        $resultCuentas = $db->query($query_cuentas);

        while($row = $db->fetchByAssoc($resultCuentas)){
            $total_cuentas = $row['total_cuentas']; 
        }

        $total_registros=$total_leads+$total_cuentas;

        return array('total_asignados'=>$total_registros);

    }


}

?>
