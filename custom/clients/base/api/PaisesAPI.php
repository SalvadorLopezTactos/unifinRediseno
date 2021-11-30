<?php
/**
 * @author: JSR
 * @date: 14/04/2016
 * @comments: Rest API to display countries list
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");
class PaisesAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'PaisesAPI' => array(
                'reqType' => 'GET',
                'path' => array('PaisesAPI'),
                'pathVars' => array(''),
                'method' => 'getPaisesList',
                'shortHelp' => 'Obtiene la lista de paises de CRM',
            ),
        );
    }


    public function getPaisesList($api, $args)
    {
        global $app_list_strings, $current_user;
        try
        {
			$list = array();
            $i = 0;
			if (isset($app_list_strings['paises_list']))
			{
				//$list = $app_list_strings['paises_list'];

                foreach ($app_list_strings['paises_list'] as $key=>$value) {
                    $list[$i]->idPais = $key;
                    $list[$i]->sDescripcion = $value;

                    $i++;
                }
			} 
			
			//console.log(salida);
			//$GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : lista " . print_r($list, true));
	/*
				$i = 1;
				 $new_list = array();
				 $vList = array();
                foreach ($list as $aList) {
                    //$GLOBALS['log']->fatal(" <".$current_user->user_name."> :$aTeam->name : $aTeam->id");
					 $valores = explode("\"", $aList);
					 $vList = explode (":",$valores[0]);
					$new_list[$i]->idPais = $vList[-1];
					$new_list[$i]->sDescripcion = $vList[0];
					
					//$GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : lll " . print_r($valores, true));
					//$GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : lista " . print_r($aList[0], true));
					$i++;
                }*/
				//$json_string = $new_list;
				
				//$json_string = json_encode($list);
				//$json_string;
            return $list;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }

}


