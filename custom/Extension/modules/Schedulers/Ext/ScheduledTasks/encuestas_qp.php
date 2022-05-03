<?php
    array_push($job_strings, 'encuestas_qp');

    function encuestas_qp()
    {
        //ECB 29/04/2022 Recupera respuestas de encuestas de QuestionPro
		global $sugar_config;
		$query = "select encuesta_id from qpro_gestion_encuestas where deleted = 0 and estatus = 1";
        $results = $GLOBALS['db']->query($query);
        while($row = $GLOBALS['db']->fetchByAssoc($results)) {
			$curl = curl_init();
			$api = $sugar_config['qp_api'];
			$url = $sugar_config['qpro'].$row['encuesta_id'].'/responses?page=1&perPage=100&apiKey='.$api;
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
			$response = json_decode($response, true);
			$err = curl_error($curl);
			curl_close($curl);
			if(!$err) {
				foreach($response['response'] as $respuesta) {
					if(!empty($respuesta['customVariables']['idencuesta'])) {
						$encuesta = $respuesta['customVariables']['idencuesta'];
						$respuesta = '['.json_encode($respuesta['responseSet']).']';
						$queryUpdate = "update qpro_encuestas set respuesta_json = '$respuesta', fecha_respuesta = now() where id = '$encuesta' and fecha_respuesta is null";
						$resultUpdate = $GLOBALS['db']->query($queryUpdate);
					}
				}
			}
		}
        return true;
    }
