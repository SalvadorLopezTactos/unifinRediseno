<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 2/01/20
 * Time: 03:08 PM
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('clients/base/api/ExportApi.php');
require_once('clients/base/api/RecordListApi.php');
require_once('include/utils.php');


class exportLeadsCSV extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            //GET
            'exportLeads' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('exportLeadsCSV'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'expoort_Leads_CSV',
                //short help string to be displayed in the help documentation
                'shortHelp' => 't',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

            'getLeads' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetLeadsAll'),
                //endpoint variables
                'pathVars' => array('module'),
                //method to call
                'method' => 'GetAll_Leads',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método GET para obtener el nombre de las cargas realizadas',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

        );
    }


    function GetAll_Leads($api, $args)
    {
        global $db;

        $nameLoad = $args['nombre_de_cargar_c'];
        $offset = $args['offset'];

        /** Validamos si existen registros duplicados para mostrar boton de exportar */
        $queryDupli = "SELECT * FROM leads l INNER JOIN leads_cstm lc  ON lc.id_c=l.id WHERE  lc.nombre_de_cargar_c='$nameLoad' and deleted=1 ";
        $dupliLeads = $db->query($queryDupli);
        $response['Leads_dupli'] = $dupliLeads->num_rows > 0 ? true : false;

        $GLOBALS['log']->fatal("duplicados " . $response['Leads_dupli']);


        /**
         * Registro de Leads totales
         */
        $query = "SELECT * FROM leads l INNER JOIN leads_cstm lc  ON lc.id_c=l.id WHERE  lc.nombre_de_cargar_c='$nameLoad'";
        $totalLeads = $db->query($query);
        $response['Leads_all'] = $totalLeads->num_rows;

        /**
         * Toatal de registros por indice
         */
        $query = "SELECT * FROM leads l INNER JOIN leads_cstm lc  ON lc.id_c=l.id WHERE  lc.nombre_de_cargar_c='$nameLoad'";
        $query .= " ORDER BY resultado_de_carga_c ASC LIMIT 20 OFFSET {$offset}";
        $resultLeads = $db->query($query);

        $response['total_leads'] = $resultLeads->num_rows;


        while ($row = $db->fetchByAssoc($resultLeads)) {
            $response['Leads'][] = $row;
        }
        return $response;
    }

    function expoort_Leads_CSV($api, $args)
    {
        global $sugar_config;
        global $db;
        $fecha = date("Y - m - d H:i:s");
        $nameLoad = $args['name_load'];

        $query = "SELECT nombre_c,apellido_paterno_c,apellido_materno_c,nombre_empresa_c,regimen_fiscal_c,e.email_address email,l.phone_mobile,l.phone_work,l.phone_home,origen_c,macrosector_c,potencial_lead_c,ventas_anuales_c,
  zona_geografica_c,puesto_c, nombre_de_cargar_c,assigned_user_id,
  concat(u.first_name , ' ' , u.last_name) assigned_user_name
FROM leads l
  INNER JOIN leads_cstm lc ON lc.id_c=l.id
  left join email_addr_bean_rel eb on eb.bean_id=l.id
  left join email_addresses e on e.id=eb.email_address_id
  inner join users u on u.id = l.assigned_user_id
WHERE lc.nombre_de_cargar_c='$nameLoad' AND l.deleted=1";
        $resultLeads = $db->query($query);

        /**
         * Creamos encabezados y Cuerpo de Leads
         */
        $backlog_doc_id = uniqid('', false);
        $leads_doc_name = "ErroresLeads" . $fecha . ".csv";
        $csvfile = $sugar_config['upload_dir'] . $leads_doc_name;

        $fp = fopen($csvfile, 'w');

        $csvHeader = "Nombre(s),Apellido Paterno,Apellido Materno,Nombre Empresa,Régimen Fiscal,Correo Electrónico,Móvil,Teléfono de Oficina,Teléfono de casa,Origen,Macro Sector,Potencial de Lead,Ventas Anuales,Zona geográfica,Puesto,Nombre de la Cargar,ID de Usuario asignado,Nombre de Usuario Asignado";
        $csvHeader .= "\n";

        if ($fp) {
            fwrite($fp, $csvHeader);
        }

        while ($row = $db->fetchByAssoc($resultLeads)) {
            $str_row = array();

            foreach ($row as $keys => $valores) {
                array_push($str_row, $valores);
            }

            $strfilar = implode(",", $str_row);
            $strfilar .= "\n";

            if ($fp) {
                fwrite($fp, $strfilar);
            }
        }
        fclose($fp);
        return $leads_doc_name;
    }


}