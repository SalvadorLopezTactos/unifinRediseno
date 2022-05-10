<?php
/**
 * Created by PhpStorm.
 * User: Levementum
 * Date: 7/13/2015
 * Time: 3:03 PM
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");
class subActivoAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETsubActivoAPI' => array(
                'reqType' => 'GET',
                'path' => array('subActivoAPI'),
                'pathVars' => array(''),
                'method' => 'obtenActivoSubActivo',
                'shortHelp' => 'Obtiene la lista de Activo y subsequentemente la de Sub Activo del Servidor de Unifin',
            ),
        );
    }

    public function obtenActivoSubActivo($api, $args)
    {
        try
        {
            global $db, $sugar_config, $current_user;
            $response = array();
            //$GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : args " . print_r($args,1));
            $callApi = new UnifinAPI();

            if($args['activo']=="main" && $args['activo']!=""){
                $response = $callApi->getActivoSubActivo(null);
            }
            if($args['activo']!="" && $args['activo']!="main"){
                $response = $callApi->getActivoSubActivo($args['activo']);
            }

            if(empty($response)){
                $response[''] = 'No Resultados';
            }else{
                foreach ($response as $index => $activo ) {
                    $resultado[$activo['index']] = $activo['nombre'];
                }

                $response = $resultado;

            }

           // $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> :  " . print_r($response,1));
            return $response;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
            return null;
        }

    }

}

