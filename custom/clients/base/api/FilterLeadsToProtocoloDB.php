<?php
/**
 * Created by Salvador Lopez.
  */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class FilterLeadsToProtocoloDB extends SugarApi
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
                'path' => array('FilterLeadsToDB','?','?'),
                //endpoint variables
                'pathVars' => array('method','nombre_archivo','oficina'),
                //method to call
                'method' => 'getLeadsFromFilterDB',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que obtiene registros de Leads disponibles para reasignación automática por Base de Datos desde Protocolo de reasignación',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

        );

    }

    public function getLeadsFromFilterDB($api, $args)
    {
        global $db;
        $nombre_archivo=$args['nombre_archivo'];
        $oficina=$args['oficina'];
        $records = array('records' => array());

        //Query para obtener el número de leads asignados al usuario actual
        $query = "SELECT l.id FROM leads l INNER JOIN leads_cstm lc
        ON l.id=lc.id_c
        WHERE nombre_de_cargar_c='{$nombre_archivo}' AND oficina_c='{$oficina}' and l.deleted=0";
        
        $result = $db->query($query);
        $pos = 0;
        while($row = $db->fetchByAssoc($result)){
            $records['records'][$pos]['id']= $row['id'];
            $pos++;
        }

        return $records;

    }


}

?>
