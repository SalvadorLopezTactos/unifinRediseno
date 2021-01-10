<?php
/**
 * Created by Salvador Lopez.
  */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetLeadsAccountsAplazadosCancelados extends SugarApi
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
                'path' => array('GetLeadsAccountsAplazadosCancelados','?'),
                //endpoint variables
                'pathVars' => array('method','id_user'),
                //method to call
                'method' => 'getRecordsCancelForProtocolo',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que obtiene registros de leads y cuentas en status Aplazado o Cancelado',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function getRecordsCancelForProtocolo($api, $args)
    {
        
        global $db;
        $id_user=$args['id_user'];
        $records=array('records'=>array());

        //Query para obtener leads Cancelados o Aplazados
        $query = "SELECT l.id,
lc.status_management_c,
lc.tipo_registro_c,
lc.subtipo_registro_c,
'' as idProducto,
'lead' as record,
concat('#Leads/',l.id) as href,
case 
WHEN lc.regimen_fiscal_c='3' THEN lc.nombre_empresa_c
ELSE concat(IFNULL(lc.nombre_c,''),' ',IFNULL(lc.apellido_paterno_c,''),' ',IFNULL(lc.apellido_materno_c,''))
END as name
FROM leads l
inner join leads_cstm lc on l.id=lc.id_c
WHERE (lc.status_management_c IN('2','3') or lc.subtipo_registro_c in('3'))
and l.assigned_user_id='{$id_user}'
and l.deleted=0
order by l.date_modified desc;";
        $result = $db->query($query);

        while($row = $db->fetchByAssoc($result)){
            array_push($records['records'], $row);
        }

        //Query para obtener Cuentas Cancelados o Aplazados
        $queryAccs="SELECT a.id as id,
ac.tipo_registro_cuenta_c as tipo_registro_c,
ac.subtipo_registro_cuenta_c as subtipo_registro_c,
upc.status_management_c as status_management_c,
up.id as idProducto,
'cuenta' as record,
concat('#Accounts/',a.id) as href,
case 
WHEN ac.tipodepersona_c='Persona Moral' THEN ac.razonsocial_c
ELSE concat(IFNULL(ac.primernombre_c,''),' ',IFNULL(ac.apellidopaterno_c,''),' ',IFNULL(ac.apellidomaterno_c, ''))
END as name
FROM accounts a
INNER JOIN accounts_cstm ac on ac.id_c = a.id
INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb
INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
WHERE ac.user_id_c = '{$id_user}'
and up.tipo_producto = '1'
and upc.status_management_c in('2','3')
and a.deleted = 0 and up.deleted = 0
order by a.date_modified desc";

        $resultAccs = $db->query($queryAccs);

        while($row = $db->fetchByAssoc($resultAccs)){
            array_push($records['records'], $row);
        }

        return $records;

    }


}

?>
