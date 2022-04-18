<?php
/*/**
 * Created by EJC.
 * User: tactos
 * Date: 11/04/2022
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/Levementum/UnifinAPI.php');
require_once('custom/modules/Opportunities/clients/base/api/CancelaRatificacion.php');
require_once('custom/modules/Opportunities/clients/base/api/cancelaOperacionBPM.php');

class Solicitud_quantico extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GET_cancel_quantico' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('cancelQuantico','?'),
                'pathVars' => array('module','SolicitudId'),
                'method' => 'cancelaCliente',
                'shortHelp' => 'valida cancela cliente envio de quantico',
            ),
        );
    }

    public function cancelaCliente($api, $args)
    {
        $response_Services = [];
        
        $idSol = $args['SolicitudId'];
        //$data = $this->QuanticoUpdate($idSol);

        //$data = '{"Success":false,"Code":"405","ErrorMessage":"El usuario que  intenta cancelar la solicitud no existe en Quantico "}';

        //$data = json_encode($data);
        //$GLOBALS['log']->fatal('data',$data);
        //return $data;
        return true;
    }
}
