<?php
    array_push($job_strings, 'encuestas_qp');

    function encuestas_qp()
    {
        //ECB 29/04/2022 Recupera respuestas de encuestas de QuestionPro
		global $sugar_config;
		require_once 'modules/Configurator/Configurator.php';
		$GLOBALS['log']->fatal("JOB Question Pro: Inicia Proceso");
		$beanQuery = BeanFactory::newBean('QPRO_Gestion_Encuestas');
		$sugarQueryGE = new SugarQuery();
		$sugarQueryGE->select(array('id', 'encuesta_id', 'ultima_respuesta_c'));
		$sugarQueryGE->from($beanQuery);
		$sugarQueryGE->where()->equals('estatus', 1);
		$resultGE = $sugarQueryGE->execute();
		$countGE = count($resultGE);
		for ($current = 0; $current < $countGE; $current++) {
			if($sugar_config['qp_peticiones'] <= $sugar_config['qp_max_peticiones']) {
				$curl = curl_init();
				$api = $sugar_config['qp_api'];
				$url = $sugar_config['qpro'].$resultGE[$current]['encuesta_id'].'/responses/filter?page=1&perPage=100&apiKey='.$api;
				$GLOBALS['log']->fatal("JOB Question Pro: Obteniendo respuesta de encuesta ". $resultGE[$current]['encuesta_id']);
				$ini = $resultGE[$current]['ultima_respuesta_c'];
				$fin = date('Y-m-d');
				$arreglo = array(
					"startDate" => $ini,
					"endDate" => $fin,
					"resultMode" => 2
				);
				$GLOBALS['log']->fatal("JOB Question Pro: Request");
				$GLOBALS['log']->fatal(print_r($arreglo,true));
				$content = json_encode($arreglo);
				curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_HTTPHEADER => array("Content-type: application/json"),
					CURLOPT_POSTFIELDS => $content,
				));
				$response = curl_exec($curl);
				$response = json_decode($response, true);
				$err = curl_error($curl);
				curl_close($curl);
				$configuratorObj = new Configurator();
				$configuratorObj->loadConfig();
				$configuratorObj->config['qp_peticiones'] = $sugar_config['qp_peticiones'] + 1;
				$GLOBALS['log']->fatal("JOB Question Pro: Petición número ".$configuratorObj->config['qp_peticiones']);
				$configuratorObj->saveConfig();
				if(!$err) {
					$beanGE = BeanFactory::retrieveBean('QPRO_Gestion_Encuestas', $resultGE[$current]['id'] ,array('disable_row_level_security' => true));
					$beanGE->ultima_respuesta_c = $fin;
					$beanGE->save();
					if(!isset($response['response']['error'])){
						$numero_respuestas=count($response['response']);
						$GLOBALS['log']->fatal("JOB Question Pro: Cantidad de respuestas obtenidas ".$numero_respuestas);
					}else{
						$GLOBALS['log']->fatal("JOB Question Pro: No se han obtenido respuestas en este periodo de tiempo");
					}
					
					foreach($response['response'] as $respuesta) {
						if(!empty($respuesta['customVariables']['idencuesta'])) {
							$fecha = date("Y-m-d", strtotime(str_replace(",","",substr($respuesta['timestamp'], 0, 12))));
							$encuesta = $respuesta['customVariables']['idencuesta'];
							$respuesta = '['.json_encode($respuesta['responseSet']).']';
							$queryUpdate = "update qpro_encuestas set respuesta_json = '$respuesta', fecha_respuesta = '$fecha' where id = '$encuesta' and fecha_respuesta is null";
							$resultUpdate = $GLOBALS['db']->query($queryUpdate);
						}
					}
				}
			}
			else { 
				global $app_list_strings;
				require_once 'include/SugarPHPMailer.php';
				require_once 'modules/Administration/Administration.php';
				$correos = $app_list_strings['correos_list'];
				$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se le informa que se ha alcanzado el límite máximo de peticiones hacia QuestionPro
					<br><br>Atentamente Unifin</font></p>
					<br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>		
					<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
					Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
					Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
					No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
					Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';
				$mailer = MailerFactory::getSystemDefaultMailer();
				$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
				$mailer->setSubject('Límite de peticiones a QuestionPro');
				$body = trim($mailHTML);
				$mailer->setHtmlBody($body);
				$mailer->clearRecipients();
				for ($i=1; $i <= count($correos); $i++) {
					$mailer->addRecipientsTo(new EmailIdentity($correos[$i]));
				}
				$result = $mailer->send();
				$GLOBALS['log']->fatal("No se pueden obtener respuestas de encuestas debido a que se ha alcanzado el límite de peticiones a QuestionPro");

				//Se establece nuevo valor a $current para salir del ciclo for
				$current=$countGE;
			}

		}
		$GLOBALS['log']->fatal("JOB Question Pro: Termina Proceso");
		
		return true;
    }
