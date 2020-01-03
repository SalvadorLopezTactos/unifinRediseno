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

class exportLeadsCSV extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            //GET
            'createcall' => array(
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
        );
    }


    function expoort_Leads_CSV($api, $args)
    {

        global $sugar_config;
        $fecha=date("Y-m-d H:i:s");

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

            if(!empty($resExport)){
                $backlog_doc_id = uniqid('', false);
                $leads_doc_name = "ErroresLeads".$fecha.".csv";
                $csvfile = $sugar_config['upload_dir'].$leads_doc_name;

                $fp = fopen($csvfile, 'w');
                fwrite($fp, $resExport);
                //fputcsv($fp, $resExport); # $line is an array of string values here
                fclose($fp);

                //return $leads_doc_name;
            }


        }

        return $leads_doc_name;
    }

}