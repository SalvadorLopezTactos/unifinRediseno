<?php
/**
 * Created by erick.cruz@tactos.com.mx.
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class actualizaREUS extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'existsAccounts' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('actualizaReus'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'actualiza_Reus',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Actualizacion de teléfonos y correos de REUS',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            )

        );
    }


    public function actualiza_Reus($api, $args)
    {
        $salida = ["estado" => array(), "detalle" => array()];
        $telefonosReus = $args['telefonosReus'];
        $telefonosNoReus = $args['telefonosNoReus'];
        $correosReus = $args['correosReus'];
        $correosNoReus = $args['correosNoReus'];

        /*if(count($telefonosReus)){
            $GLOBALS['log']->fatal("telefonosReus: " . print_r($telefonosReus, true));
        
        }
        if(count($telefonosNoReus)){
            $GLOBALS['log']->fatal("telefonosNoReus: " . print_r($telefonosNoReus, true));
        
        }
        if(count($correosReus)){
            $GLOBALS['log']->fatal("correosReus: " . print_r($correosReus, true));
        
        }
        if(count($correosNoReus)){
            $GLOBALS['log']->fatal("correosNoReus: " . print_r($correosNoReus, true));

        }*/
        
        $salida["estado"] = 200;
        $salida["detalle"] = "CRM Actualizado Correctamente";

        return $salida;
    }

}