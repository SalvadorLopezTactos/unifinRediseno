<?php
/**
 * Created by Tactos
 * User: Eduardo Carrasco Beltrán
 * Date: 29/04/2021
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class DisposicionesUni2 extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('DisposicionesUni2'),
                'pathVars' => array('method'),
                'method' => 'getDisposicionesUni2',
                'shortHelp' => 'Integración con Uni2',
                'longHelp' => 'Obtiene Disposiciones de Uni2 por Backlog',
            ),
        );
    }

    public function getDisposicionesUni2($api, $args)
    {
        global $sugar_config;
		$id=$args['id'];
        $num=$args['num'];
		$mes=$args['mes'];
        $anio=$args['anio'];

        $user = $sugar_config['quantico_usr'];
        $pwd = $sugar_config['quantico_psw'];
        $auth_encode = base64_encode($user . ':' . $pwd);
        $host=$sugar_config['quantico_url_base'];

        $callApi = new UnifinAPI();

        if($id == 1){
            $url = $host."/QuanticoBacklog_API/rest/QuanticoRestApi/GetDispositions?Backlog=".$num."&Mes=".$mes."&Anio=".$anio;
            $response = $callApi->getQuanticoCF($url, $auth_encode);
        }
		if($id == 2) {
			$url = $host."/QuanticoBacklog_API/rest/BacklogApi/Cancelation";
			$motivo = $args['motivo'];
			$comentarios = $args['comentarios'];
			$usuario = $args['usuario'];
          	$arreglo = array(
				"backlog" => $num,
                "mes" => $mes,
                "anio" => $anio,
                "motivoCancelacion" => $motivo,
                "comentarioCancelacion" => $comentarios,
				"usuario" => $usuario
            );

            $response = $callApi->postQuantico($url,$arreglo,$auth_encode);

        }
        
        return $response;
    }

}
?>
