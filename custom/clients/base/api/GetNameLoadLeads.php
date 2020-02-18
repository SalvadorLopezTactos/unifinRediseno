<?php
/**
 * Created by Tactos.
 * User: JG
 * Date: 30/12/19
 * Time: 11:03 AM
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetNameLoadLeads extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetNameLoad'),
                //endpoint variables
                'pathVars' => array('module'),
                //method to call
                'method' => 'GetNameLoad_Leads_method',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método GET para obtener el nombre de las cargas realizadas',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

        );

    }


    public function GetNameLoad_Leads_method($api, $args)
    {
        global $db;
        $records_in = array();

        $query = "SELECT DISTINCT nombre_de_cargar_c FROM leads_cstm lc
INNER JOIN  leads l
ON lc.id_c=l.id WHERE nombre_de_cargar_c IS NOT NULL ORDER BY date_entered DESC ";
        $result = $db->query($query);

        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $temp = $row['nombre_de_cargar_c'];
            array_push($records_in, $row['nombre_de_cargar_c']);
        }
        return $records_in;
    }
}