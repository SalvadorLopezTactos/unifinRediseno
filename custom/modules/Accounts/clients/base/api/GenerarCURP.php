<?php
/**
 * Created by PhpStorm.
 * User: Levementum
 * Date: 6/29/2015
 * Time: 3:03 PM
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");
class GenerarCURP extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'postvalidarCURPAPI' => array(
                'reqType' => 'POST',
                'path' => array('Accounts', 'GenerarCURP'),
                'pathVars' => array('',''),
                'method' => 'GenerarCURP',
                'shortHelp' => 'Genera CURP de la persona',
            ),
        );
    }

    public function GenerarCURP($api, $args)
    {
        global $current_user;
        try
        {
            $fecha_de_nacimiento = $args['curpdata']['fechadenacimiento'];
            $primernombre = $args['curpdata']['primernombre'];
            $apellidoP = $args['curpdata']['apellidoP'];
            $apellidoM = $args['curpdata']['apellidoM'];
            $genero = $args['curpdata']['genero'];
            $pais = $args['curpdata']['pais'];
            $estado = $args['curpdata']['estado'];
            $tipodepersona = $args['curpdata']['tipodepersona'];
			if($tipodepersona != 'Persona Moral' && $fecha_de_nacimiento != '' && $primernombre != '' && $apellidoP != '' && $apellidoM != '' && $genero != '' && $pais != '' && $estado != ''){
            	$callApi = new UnifinAPI();
				$curpInfo = $callApi->CalculaCURP($primernombre, $apellidoP, $apellidoM, $fecha_de_nacimiento, $genero, $pais,$estado);
			}
            return $curpInfo;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__."  <".$current_user->user_name."> :Error ".$e->getMessage());
        }

    }

}

