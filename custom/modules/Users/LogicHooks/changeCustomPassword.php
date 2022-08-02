<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class class_changeCustomPassword{

	function method_changeCustomPassword($bean, $event, $arguments){

		//Iniciar cambio de contraseña
		if(!empty($bean->contraseniaactual_c) && !empty($bean->nuevacontrasenia_c))
		{

				//Recuperar variables
				$GLOBALS['log']->fatal("Petición de cambio de contraseña LDAP");
		    $user = $bean->user_name;
		    $oldPassword = $bean->contraseniaactual_c;
		    $newPassword = $bean->nuevacontrasenia_c;
		    $validatePassword = $bean->confirmarnuevacontrasenia_c;
		  	//Endpoint: http://192.168.150.85:8080/uni2/rest/passSugarEndPoint/pass?user=adolfo.sanchez&oldPassword=Azucar878&newPassword=Azucar878
		  	global $sugar_config;
		  	$base_url = $sugar_config['bpm_url']; //config.php->bpm_url
		    $urlRequest = 'http://'.$base_url.'/uni2/rest/passSugarEndPoint/pass?user='.$user.'&oldPassword='.$oldPassword.'&newPassword='.$newPassword;

		    //Enviar petición
		    try {
			    //Envia petición de cambio
			    $result = class_changeCustomPassword::CallAPI('GET', $urlRequest);
					if ($result != "true") {
						$GLOBALS['log']->fatal('Error-Result1');
						sugar_die("La contraseña no pudo ser actualizada: ". $result);
					}

				} catch (Exception $e) {
						//Recupera error
				    $result = $e->getMessage();
						//Limpia variables
			    	$bean->contraseniaactual_c="";
						$bean->nuevacontrasenia_c="";
						$bean->confirmarnuevacontrasenia_c="";

						$GLOBALS['log']->fatal('Error-Catch');
						sugar_die("La contraseña no pudo ser actualizada: ". $result);
				}

				//Manipular respuesta
		    //$bean->description = $result;
	    	//Limpia variables
	    	$bean->contraseniaactual_c="";
				$bean->nuevacontrasenia_c="";
				$bean->confirmarnuevacontrasenia_c="";

			//Log
			// $GLOBALS['log']->fatal('Usuario: '.$user);
			// $GLOBALS['log']->fatal('Contraseña Actual: ' . $oldPassword);
			// $GLOBALS['log']->fatal('Nueva contraseña: ' . $newPassword);
			// $GLOBALS['log']->fatal('URL request: ' . $urlRequest);
			$GLOBALS['log']->fatal('Petición cambio de contraseña: ');
			$GLOBALS['log']->fatal('Resultado de petición: '. $result);
		}

    }

    function CallAPI($method, $url, $data = false)
	{
	    $curl = curl_init();

	    switch ($method)
	    {
	        case "POST":
	            curl_setopt($curl, CURLOPT_POST, 1);

	            if ($data)
	                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	            break;
	        case "PUT":
	            curl_setopt($curl, CURLOPT_PUT, 1);
	            break;
	        default:
	            if ($data)
	                $url = sprintf("%s?%s", $url, http_build_query($data));
	    }

	    // Optional Authentication:
	    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	    $result = curl_exec($curl);

	    curl_close($curl);

	    return $result;
	}


}
