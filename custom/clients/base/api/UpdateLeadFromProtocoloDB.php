<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 07/08/18
 * Time: 10:07
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class UpdateLeadFromProtocoloDB extends SugarApi
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
                'path' => array('UpdateLeadFromProtocolo','?','?'),
                //endpoint variables
                'pathVars' => array('method','id_lead','id_usuario'),
                //method to call
                'method' => 'updateLeadFromProtocoloMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que actualiza registro de Lead a través de Protocolo con la opción de Base de Datos',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function updateLeadFromProtocoloMethod($api, $args)
    {
        global $db;
        $id_lead=$args['id_lead'];
        $id_usuario=$args['id_usuario'];

        $queryAsignado = "UPDATE leads SET assigned_user_id='{$id_usuario}' WHERE id='{$id_lead}'";
        $result = $db->query($queryAsignado);
        
        $queryArchivoCarga = "UPDATE leads_cstm SET nombre_de_cargar_c='' WHERE id_c='{$id_lead}'";
        $resultArchivo = $db->query($queryArchivoCarga);

        //Query para regresar información del lead actualizado y poder manipularlo desde el js de protocolo
        $queryLead = "SELECT id_c,name_c FROM leads_cstm WHERE id_c='{$id_lead}'";
        
        $resultLead = $db->query($queryLead);
        $arreglo_response=array();
        while($row = $db->fetchByAssoc($resultLead)){
            $arreglo_response['id']=$row['id_c'];
            $arreglo_response['name']=$row['name_c'];
        }

        return $arreglo_response;

    }


}

?>
