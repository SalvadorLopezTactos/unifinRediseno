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
        $query .= " ORDER BY clean_name_c ASC LIMIT 20 OFFSET {$offset}";
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

        $query = "SELECT l.id,lc.nombre_c,lc.apellido_materno_c,lc.apellido_paterno_c FROM leads l INNER JOIN leads_cstm lc  ON lc.id_c=l.id WHERE  lc.nombre_de_cargar_c='$nameLoad' AND deleted=1";
        $resultLeads = $db->query($query);

        /**
         * Creamos encabezados y Cuerpo de Leads
         */
        $backlog_doc_id = uniqid('', false);
        $leads_doc_name = "ErroresLeads" . $fecha . " .csv";
        $csvfile = $sugar_config['upload_dir'] . $leads_doc_name;

        $bander = 0;
        $label = array();
        $fp = fopen($csvfile, 'w');

        while ($row = $db->fetchByAssoc($resultLeads)) {
            $str_row = array();

            if ($bander == 0) {
                foreach ($row as $key => $valor) {
                    $str_label=translate($GLOBALS['dictionary']['Lead']['fields'][$key]['vname'], "Leads");
                    $str_label=trim($str_label,":");
                    array_push($label, $str_label);
                }
                $bander++;
                $str_header = implode(",", $label);
                $str_header .= "\n";

                if ($fp) {
                    fwrite($fp, $str_header);
                }
            }

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


    /**  este codigo es funcional solo para leads que tengan deleted en cero ya que no
     * puede recuperar eliminados*/

    /* function expoort_Leads_CSV_v1($api, $args)
     {

         global $sugar_config;
         $fecha = date("Y - m - d H:i:s");

         $callApi = new RecordListApi();
         $resList = $callApi->recordListCreate($api, $args);

         if ($resList['id']) {
             $requestExport = Array
             (
                 "module" => "Leads",
                 "record_list_id" => $resList['id']
             );

             $exportApi = new ExportApi();
             $resExport = $exportApi->export($api, $requestExport);
             $GLOBALS['log']->fatal("Respuesta Exportacion " . $resExport);
             $GLOBALS['log']->fatal("Respuesta Exportacion " . count($resExport));

             if (!empty($resExport)) {
                 $backlog_doc_id = uniqid('', false);
                 $leads_doc_name = "ErroresLeads" . $fecha . " . csv";
                 $csvfile = $sugar_config['upload_dir'] . $leads_doc_name;

                 $fp = fopen($csvfile, 'w');
                 fwrite($fp, $resExport);
                 //fputcsv($fp, $resExport); # $line is an array of string values here
                 fclose($fp);

                 //return $leads_doc_name;
             }


         }

         return $leads_doc_name;
     }*/
    // apellido_materno_c valor  LBL_APPELIDO_MATERNO_C Apellido Materno

}