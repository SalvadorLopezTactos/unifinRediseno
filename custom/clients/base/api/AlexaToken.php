<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz>
 * Date: 09/06/2021
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class AlexaToken extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'ValidateToken' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('ValidateToken'),
                'pathVars' => array(''),
                'method' => 'ValidateToken',
                'shortHelp' => 'Consulta para usar token valido',
            ),
        );
    }

    public function ValidateToken($api, $args){
        global $db;
        $GLOBALS['log']->fatal("Inicia ValidateToken");
        $token=[];
        //1.- Consulta hacia config para recuperar el Refresh Token en DB CRM
        $consulta_refresh= "SELECT value 
        from config 
        where category='Alexa'
        and name='RefreshToken' 
        limit 1;";

        $queryResult = $db->getOne($consulta_refresh);

        $GLOBALS['log']->fatal("Ejecuta consulta en Config y obtiene refresh_token " .$queryResult);


        if (!empty($queryResult)){
            $consult_config="SELECT id from oauth_tokens where id='{$queryResult}' limit 1;";
            $ResultToken = $db->getOne($consult_config);
            $GLOBALS['log']->fatal("Ejecuta consulta en oauth-token en busca del id - refresh_token ");

            if(!empty($ResultToken)){
                //Valida que el token no este vacio, de ser
                $consulta_token= "SELECT value 
                from config 
                where category='Alexa'
                and name='tokenCRM' 
                limit 1;";
                $obtieneToken = $db->getOne($consulta_token);
                $token['access_token']=$obtieneToken;
                //$token=$obtieneToken;

            }
        }
        //El token es vacio, no hay valido y manda a crear uno
        if (empty($token)){
            require_once("clients/base/api/OAuth2Api.php");
            $GLOBALS['log']->fatal("Crea nuevo token");
            
            $GLOBALS['log']->fatal("Valor de args ");
            $GLOBALS['log']->fatal(print_r($args, true));

            try {
                $callApi = new Oauth2Api();
            $response = $callApi->token($api,$args);
            $GLOBALS['log']->fatal(print_r($response, true));
            } catch (Exception $e) {
                $response = null;
            }
    

            $token=$response;
            //Al generar token nuevo, actualiza los valores en config de CRM
            $actualizaToken = "UPDATE config 
            set value='{$token['access_token']}' 
            where category='Alexa' and 
            name='tokenCRM';";
            //Ejecuta el update correspondiente del TOKEN
            $actualizaRespuesta = $GLOBALS['db']->query($actualizaToken);

            $actualizaRefresh = "UPDATE config 
            set value='{$token['refresh_token']}' 
            where category='Alexa' and 
            name='RefreshToken';";
            //Ejecuta el update correspondiente el Refresh Token
            $actualizaRespuesta = $GLOBALS['db']->query($actualizaRefresh);


        }

        return $token;

    }

    
}