<?php
/**
 * User: ejc
 * Date: 12/06/2020
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetRFCapi extends SugarApi
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
                'path' => array('GetRFCValido'),
                //endpoint variables
                'pathVars' => array(),
                //method to call
                'method' => 'getRFCV',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que realiza petición a servicio externo que obtiene información de RFC válido',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function getRFCV($api, $args){
        global $sugar_config;

        $rfc=$args['rfc'];
        $url=$sugar_config['url_rfc'];
		
		$body = "rfc=".$rfc."";

        $response=$this->callValidateRFC($url,$body);

        return $response;
    }

  
    public function callValidateRFC($url,$body){
       
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url.'?'.$body);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		//curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	
        //obtenemos la respuesta
        $result = curl_exec($ch);
		
        curl_close ($ch);
		
		//$result = '{"code":4,"msj":"RFC válido, y susceptible de recibir facturas","rfc": "GACK9107166N7"}';
        return json_decode($result, true);

    }


}

?>
