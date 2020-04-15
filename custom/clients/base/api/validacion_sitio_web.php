<?php
/**
 * Created by PhpStorm.
 * User: ERick de Jesús Cruz
 * Date: 2020/04/03
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class validacion_sitio_web extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('validacion_sitio_web'),
                //endpoint variables
                'pathVars' => array(),
                //method to call
                'method' => 'ping_web',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'None',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }
    //http://localhost/unifinRediseno/rest/v11_4/validacion_sitio_web
    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function ping_web($api, $args)
    {
        //Recupera página web
		    $url = $args['website'];
        //Genera petición a dominio
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        //Interpreta resultado
        if($httpcode>=200 && $httpcode<300){
            return '00';
        } else {
            return '02';
        }
    }

}
