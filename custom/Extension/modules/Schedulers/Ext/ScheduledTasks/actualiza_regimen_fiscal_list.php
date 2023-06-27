<?php

array_push($job_strings, 'actualiza_regimen_fiscal_list');
function actualiza_regimen_fiscal_list(){
    global $sugar_config;
    require_once("custom/Levementum/UnifinAPI.php");
    require_once('modules/Configurator/Configurator.php');

    $GLOBALS['log']->fatal("Inicia planificador para actualizar lista de régimenes fiscales SAT");
    //$GLOBALS['log']->fatal(print_r($sugar_config['regimen_fiscal_sat_list'],true));
    $regimen_fiscal_sat_list = $sugar_config['regimen_fiscal_sat_list'];

    $url = $sugar_config['regimenes_sat_url'].'/auth/login/token';
    $user = $sugar_config['regimenes_sat_user'];
    $password = $sugar_config['regimenes_sat_password'];

    $instanciaAPI = new UnifinAPI();
    $responseToken = $instanciaAPI->postSimilarityToken( $url, $user, $password  );
    //$GLOBALS['log']->fatal("RESPONSE TOKEN");
    //$GLOBALS['log']->fatal( print_r($responseToken,true) );

    if( !empty($responseToken) ){
        $token = $responseToken['access_token'];
        $urlRegimenes = $sugar_config['regimenes_sat_url'].'/catalogs/regimes/list-all/';

        $responseListRegimenes = $instanciaAPI->getInfoRegimenesSAT( $urlRegimenes, $token );

        $GLOBALS['log']->fatal( print_r($responseListRegimenes,true) );
        $saveConfig = false;
        if( count($responseListRegimenes['member']) > 0 ){

            for ($i=0; $i < count($responseListRegimenes['member']); $i++) {
                $code = $responseListRegimenes['member'][$i]['code'];

                $valorConfig = getRegimenDeConfig( $code, $sugar_config['regimen_fiscal_sat_list'] );

                if( $valorConfig !== "" ){

                    if( $valorConfig !==  $responseListRegimenes['member'][$i]['regimen']  ){
                        $saveConfig = true;
                        $regimen_fiscal_sat_list[$code]= $responseListRegimenes['member'][$i]['regimen'];
                    }

                }else{
                    $saveConfig = true;
                    $GLOBALS['log']->fatal( "No se encontró valor, se procede a agregarlo a config " );
                    $regimen_fiscal_sat_list[$code]= $responseListRegimenes['member'][$i]['regimen'];
                }
                
            }

        }

        if( $saveConfig ){
            $GLOBALS['log']->fatal("Se encontró un valor diferente, se procede a guardar");
            $GLOBALS['log']->fatal(print_r($regimen_fiscal_sat_list,true));
            $configuratorObj = new Configurator();
	        $configuratorObj->loadConfig();
	        $configuratorObj->config['regimen_fiscal_sat_list'] = $regimen_fiscal_sat_list;
	        $configuratorObj->saveConfig();
        }

    }

    $GLOBALS['log']->fatal("Termina planificador para actualizar lista de régimenes fiscales SAT");

    return true;
}

function getRegimenDeConfig( $code, $list_config ){
    $valor= "";

    $GLOBALS['log']->fatal( "Validando el código ".$code );

    if( !empty( $list_config[$code] ) ){
        
        $valor = $list_config[$code];
        $GLOBALS['log']->fatal( "Se encontró valor en lista config ".$valor );
    }

    return $valor;

}