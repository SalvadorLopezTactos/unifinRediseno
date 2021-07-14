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

        global $db, $app_list_strings;
        $id_user=$args['id_user'];
        $total_leads=0;
        $total_cuentas=0;
        $total_registros=0;

        //Query para obtener el número de leads asignados al usuario actual
        $query = "SELECT count(l.id) as total_leads FROM leads l inner JOIN leads_cstm lc on l.id=lc.id_c
WHERE l.assigned_user_id='{$id_user}'
and lc.contacto_asociado_c=0
and lc.subtipo_registro_c not in('4','3') and l.deleted=0
and lc.status_management_c=1"; //4 - Convertido, 3 - Cancelado
        $result = $db->query($query);

        while($row = $db->fetchByAssoc($result)){
            $total_leads = $row['total_leads'];
        }

        /*
        $query_cuentas="SELECT count(a.id) as total_cuentas FROM accounts a
INNER JOIN accounts_cstm ac on ac.id_c = a.id
INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb
and up.tipo_producto = '1'
INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
and (upc.status_management_c IS NULL OR upc.status_management_c = '1')
WHERE ac.tipo_registro_cuenta_c = '2'
and ac.subtipo_registro_cuenta_c IN ('2','7','8')
and ac.user_id_c = '{$id_user}'
and a.deleted = 0 and up.deleted = 0";
*/
    //tipo_registro_cuenta_c 2 - Prospecto , subtipo_registro_cuenta_c=2 - Contactado,7-Interesado, 8 - Integración de Expediente

    $query_cuentas="SELECT a.id FROM accounts a
        INNER JOIN accounts_cstm ac on ac.id_c = a.id
        INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
        INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb
            and up.tipo_producto = '1'
        INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
            and (upc.status_management_c IS NULL OR upc.status_management_c = '1')
        WHERE ac.tipo_registro_cuenta_c = '2'
        and ac.subtipo_registro_cuenta_c IN ('1','2','7','8','10')
        and ac.user_id_c = '{$id_user}'
        and a.deleted = 0 and up.deleted = 0";

        $resultCuentas = $db->query($query_cuentas);
        $arr_cuentas_filtradas=array();

        while($row = $db->fetchByAssoc($resultCuentas)){
            //$total_cuentas = $row['total_cuentas'];
            //Se llena arreglo con ids de cuentas para posteriormente concatenerlos y añadirlos dentro de la sentencia IN en el query
            array_push($arr_cuentas_filtradas,"'".$row['id']."'");
        }

        $string_in= implode(",", $arr_cuentas_filtradas);

        $queryCuentasGpoEmpresarial="SELECT count(conteoRegistros.id) as total_cuentas_gpo FROM (
            SELECT a.id,
            a.parent_id,
            up.subtipo_cuenta,
            MAX(
            CASE WHEN up.subtipo_cuenta IN ('1','2','7','8','10') THEN '1'
                ELSE '2'
                END) registro_valido,
            CASE WHEN a.parent_id IS NULL THEN a.id
                WHEN a.parent_id IS NOT NULL THEN a.parent_id
                END agrupador
            FROM accounts a
            INNER JOIN accounts_cstm ac on ac.id_c = a.id
            INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
            INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb
            and up.tipo_producto = '1'
            INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
            and (upc.status_management_c IS NULL OR upc.status_management_c = '1')
            WHERE(a.id IN({$string_in}) OR
            a.parent_id IN({$string_in}))
            and a.deleted = 0 and up.deleted = 0
            GROUP BY agrupador,a.id,a.parent_id,up.subtipo_cuenta
            ) conteoRegistros WHERE conteoRegistros.registro_valido='1'";

        $resultCuentasGpo = $db->query($queryCuentasGpoEmpresarial);

        while($row = $db->fetchByAssoc($resultCuentasGpo)){
            $total_cuentas = $row['total_cuentas_gpo'];
        }


        $total_registros=$total_leads+$total_cuentas;

        //Se agrega a la respuesta el puesto del usuario
        $usuario_asesor = BeanFactory::retrieveBean('Users', $id_user, array('disable_row_level_security' => true));
        $puesto_asesor=$usuario_asesor->puestousuario_c;
        $posicionOperativa=$usuario_asesor->posicion_operativa_c;
        $limitePersonal = ($usuario_asesor->limite_asignacion_lm_c > 0)? $usuario_asesor->limite_asignacion_lm_c: 0;
        $max_registros_list = $app_list_strings['limite_maximo_asignados_list'];
        $max_registros = ($limitePersonal>0) ? $limitePersonal : intval($max_registros_list['1']);

        return array('total_asignados'=>$total_registros,'puesto'=>$puesto_asesor,'posicion_operativa'=>$posicionOperativa,'limite'=>$max_registros);

    }


}

?>
