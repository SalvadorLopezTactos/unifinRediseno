<?php
/**
 * @author: JSR
 * @date: 14/04/2016
 * @comments: Rest API to display countries list
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");
class BancosAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'BancosAPI' => array(
                'reqType' => 'GET',
                'path' => array('BancosAPI'),
                'pathVars' => array(''),
                'method' => 'getBancosList',
                'shortHelp' => 'Obtiene la lista de bancos de CRM',
            ),
        );
    }


    public function getBancosList($api, $args)
    {
        global $app_list_strings, $current_user;
        try
        {
            $i = 0;
			$list = array();
			if (isset($app_list_strings['Institucion_list']))
			{
				//$list = $app_list_strings['Institucion_list'];
                foreach ($app_list_strings['Institucion_list'] as $key=>$value) {
                    $list[$i]->idBanco = $key;
                    $list[$i]->sNombre = $value;

                    $i++;
                }
			}
            return $list;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }

}


