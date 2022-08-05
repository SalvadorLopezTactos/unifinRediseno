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
        /*************************************/
        //check, if a valid url is provided
        if(!filter_var($url, FILTER_VALIDATE_URL))
        {
                return false;
        }

        //initialize curl
        $curlInit = curl_init($url);
        curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($curlInit,CURLOPT_HEADER,true);
        curl_setopt($curlInit,CURLOPT_NOBODY,true);
        curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

        //get answer
        $response = curl_exec($curlInit);
        $httpcode = curl_getinfo($curlInit, CURLINFO_HTTP_CODE);

        curl_close($curlInit);

        /*if ($response) return true;

        return false;*/
        /*******************************************/
        //Genera petición a dominio
        /*$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        */
        //Interpreta resultado
        if(($httpcode>=200 && $httpcode<=400) || $httpcode==0 ){
        //if($response || $httpcode == 0 ){
            return '00';
        } else {
            if($response != '' && $response != '0' ){
                return '00';
            }else{
                 //Segunda validación
                $url = str_replace("www.", "", $url);
                $url = str_replace("https://", "", $url);
                $url = str_replace("http://", "", $url);
                //Genera petición a dominio
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $data = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                curl_close($ch);
                //Interpreta resultado
                if((($httpcode>=200 && $httpcode<=400) || $httpcode==0) && ($data != '' && $data != '0' )){
                    return '00';
                } else {
                    if($data != '' && $data != '0' ){
                        return '00';
                    }else{
                        return '02';
                    }
                }
            }
        }
    }

}
