<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/Levementum/UnifinAPI.php');

class CotejoDigital extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_CotejoDigital' => array(
                'reqType' => 'POST',
                'path' => array('ObtenerCotejoDigital'),
                'pathVars' => array(''),
                'method' => 'getCotejoDigital',
                'shortHelp' => 'Genera petición para descargar cotejo digital de quantico',
            ),
        );
    }
    
    
    public function getCotejoDigital($api, $args){
        
        global $sugar_config, $db, $app_list_strings, $current_user;
        $user = $sugar_config['quantico_usr'];
        $pwd = $sugar_config['quantico_psw'];
        $auth_encode = base64_encode($user . ':' . $pwd);
        $guid_persona = $args['idPersona'];

        $quantico_url = $sugar_config['quantico_url_base'];
        $host = $quantico_url."/CreditRequestIntegration/rest/ExpedientDocument/DownloadDocument";

        $body_request = array(
            "PersonCRMGUID" => $guid_persona,
            "DocumentReference"=> "VALIDACION_DIGITAL_CSF"
        );

        $callApi = new UnifinAPI();
        
        try {
            $resultado = $callApi->postQuantico($host, $body_request, $auth_encode);
            if( isset($resultado['FileBase64']) ){
                $archivo_cotejo = $this->buildFilePDF($resultado['FileBase64']);
    
                return array("status"=> "OK", "mssg"=> $archivo_cotejo);
            }else{
                return array("status"=> "Error", "mssg"=>"El cotejo digital no se pudo generar");
            }

        } catch (Exception $e) {
            return array("status"=> "Error", "mssg"=> $e->getMessage());
        }
        
    }
    
    public function buildFilePDF( $base64 ){
        $folderPath = "custom/cotejoDigital/";

        if( !file_exists($folderPath) ){
            mkdir( $folderPath , 0777, true);
        }
        
        $str_base64 = base64_decode($base64);

        //Se genera el archivo pdf con el string obtenido
        $archivo = $folderPath .'Cotejo_'. uniqid() . '.pdf';

        $GLOBALS['log']->fatal( "Se genera archivo cotejo: ".$archivo );

        file_put_contents($archivo, $str_base64);

        return $archivo;

    }

}
