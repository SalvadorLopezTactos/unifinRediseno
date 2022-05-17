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
        $host=$sugar_config['bpm_url'];
		$ch = curl_init();
        if($id == 1) $url = "http://".$host."/uni2/rest/backlog/disposiciones?backlog=".$num."&mes=".$mes."&anio=".$anio;
		if($id == 2) {
			$url = "http://".$host."/uni2/rest/backlog/cancelacion";
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
            $content = json_encode($arreglo);
        	curl_setopt($ch, CURLOPT_HEADER, false);
        	curl_setopt($ch, CURLOPT_HTTPHEADER,
				array("Content-type: application/json")
			);
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		}
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4000);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response = json_decode($result, true);
		curl_close($ch);
        return $response;
    }
}
?>
