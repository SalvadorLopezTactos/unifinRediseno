<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 19/08/18
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Dynamics365 extends SugarApi
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
                'reqType' => 'POST',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('Dynamics365'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'setRequestDynamics',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Integración con Dynamics 365',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function setRequestDynamics($api, $args)
    {

        $response=$args['accion'];

        return $response;

    }


}

?>
