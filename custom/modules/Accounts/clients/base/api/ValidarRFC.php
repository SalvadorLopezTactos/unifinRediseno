<?php
/**
 * Created by PhpStorm.
 * User: Levementum
 * Date: 6/29/2015
 * Time: 3:03 PM
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");
class ValidarRFC extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'postvalidarRFCAPI' => array(
                'reqType' => 'POST',
                'path' => array('Accounts', 'ValidarRFC'),
                'pathVars' => array('',''),
                'method' => 'validaRFC',
                'shortHelp' => 'Pregunta a servicios de Unifin, si el RFC es Valido',
            ),
        );
    }

    public function validaRFC($api, $args)
    {
        global $current_user;
        try
        {
            $fecha_de_nacimiento = $args['rfcdata']['fechadenacimiento'];
            $primernombre = $args['rfcdata']['primernombre'];
            $apellidoP = $args['rfcdata']['apellidoP'];
            $apellidoM = $args['rfcdata']['apellidoM'];
            $genero = $args['rfcdata']['genero'];
            $pais = $args['rfcdata']['pais'];
            $estado = $args['rfcdata']['estado'];
            $razonsocial = $args['rfcdata']['razonsocial'];
            $tipodepersona = $args['rfcdata']['tipodepersona'];
            $fecha_constitutiva = $args['rfcdata']['fechaconstitutiva'];

            $callApi = new UnifinAPI();

            if($tipodepersona == 'Persona Fisica' || $tipodepersona == 'Persona Fisica con Actividad Empresarial'){
                $rfcInfo = $callApi->validaRFCPersonaFisica($fecha_de_nacimiento, $primernombre, $apellidoP, $apellidoM, $genero, $pais,$estado);
            }elseif($tipodepersona == 'Persona Moral'){
                $rfcInfo = $callApi->validaRFCPersonaMoral($fecha_constitutiva, $razonsocial);
            }

            return $rfcInfo;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }

}

