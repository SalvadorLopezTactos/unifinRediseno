<?php
/**
 * Created by PhpStorm.
 * User: Tactos
 * Date: 20/09/2023
 * Time: 3:03 PM
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class expedienteUniclickURL extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GET_URLExpediente' => array(
                'reqType' => 'GET',
                'path' => array('getURLExpediente'),
                'pathVars' => array(''),
                'method' => 'getURLExpedienteMethod',
                'shortHelp' => 'Obtiene la URL para mostrar expediente uniclick',
            ),
        );
    }

    public function getURLExpedienteMethod($api, $args)
    {
        try
        {
            global $sugar_config,$current_user;
            $host = $sugar_config['expediente_uniclick'].'/uni2-expediente-ui/expediente/?token=';

            return $host;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
            return '';
        }

    }

}
