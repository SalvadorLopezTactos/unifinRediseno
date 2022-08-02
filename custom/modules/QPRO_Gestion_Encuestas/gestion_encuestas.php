<?php
/*
 * Created by Tactos
 * Email: eduardo.carrasco@tactos.com.mx
 * Date: 20/04/2022
*/

class gestion_encuestas
{
    public function gestion_encuestas($bean = null, $event = null, $args = null)
    {
        // Obtiene datos de QuestionPro
        if($bean->fetched_row['id'] != $bean->id)
        {
			global $sugar_config;
			$curl = curl_init();
			$api = $sugar_config['qp_api'];
			$url = $sugar_config['qpro'].$bean->encuesta_id.'?apiKey='.$api;
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
			));
			$response = curl_exec($curl);
			$response = json_decode($response);
			$err = curl_error($curl);
			curl_close($curl);
			if(!$err) {
				$bean->fecha_expiracion = $response->response->expiryDate;
				$bean->url = $response->response->url;
			}
		}
	}
}