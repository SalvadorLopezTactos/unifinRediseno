<?php
/**
 * Created by Salvador Lopez.
 * User: salvador.lopez@tactos.com.mx
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ClientManager extends SugarApi
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
                'path' => array('GetCMInfoKanban'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'getInfoKanban',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Obtiene información para poblar dashlet con vista Kanban de Client Manager',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function getInfoKanban($api, $args){
        global $sugar_config;

        $response=array(
            "Lead_Sin_Contactar"=>array(
                "Total_Registros"=>"180",
                "Total_Monto"=>"20000",
                "Registros"=>array(
                    array(
                        "Nombre"=>"Lead 1",
                        "Dias_Etapa"=>"2",
                        "Favorito"=>1,
                        "Preview"=>array("Info Preview")
                    ),
                    array(
                        "Nombre"=>"Lead 2",
                        "Dias_Etapa"=>"2",
                        "Favorito"=>0,
                        "Preview"=>array("Info Preview")
                    )
                )
            ),
            "Prospecto_Contactado"=>array(
                "Total_Registros"=>"180",
                "Total_Monto"=>"20000",
                "Registros"=>array(
                    array(
                        "Nombre"=>"Lead 1",
                        "Dias_Etapa"=>"2",
                        "Favorito"=>"true",
                        "Preview"=>array("Info Preview")
                    ),
                    array(
                        "Nombre"=>"Lead 2",
                        "Dias_Etapa"=>"2",
                        "Favorito"=>"true",
                        "Preview"=>array("Info Preview")
                    )
                )
            )
            
        );

        return $response;

    }

}

?>
