<?php


class Cotizaciones_dynamics
{
    public function envioDynamics($bean = null, $event = null, $args = null)
    {
        //Creacion de Cotizacion y envio a Dynamics
        if(empty($bean->int_id_dynamics))
        {
          global $db,$sugar_config, $app_list_strings;
          $Seguro = BeanFactory::getBean('S_seguros', $bean->cot_cotizaciones_s_seguross_seguros_ida, array('disable_row_level_security' => true));
          $cuenta = BeanFactory::getBean('Accounts', $Seguro->s_seguros_accountsaccounts_ida, array('disable_row_level_security' => true));
          $token = $this->getToken();
          if($token)
          {
            $aseguradora = $app_list_strings['aseguradoras_list'][$bean->aseguradora_c];
            $closeDate = date("d/m/Y", strtotime($closeDate));
            $url = $sugar_config['inter_dynamics_url'].'Cotizacion';
            $arreglo = array(
                "int_razon_social_id" => $cuenta->int_id_dynamics_c,
                "int_oportunidad_id" => $Seguro->int_id_dynamics_c,
                "int_prima_neta" => $bean->int_prima_neta,
                "int_comision" => $bean->int_comision,
                "int_comision_porcentaje" => $bean->int_comision_porcentaje,
                "int_aseguradora_id" => $aseguradora
            );
            $content = json_encode($arreglo);
            $GLOBALS['log']->fatal('Seguros_Dynamics - Crea cotizacion - Dynamics: '. $url);
            $GLOBALS['log']->fatal($content);
            $curl = curl_init($url);
        		curl_setopt($curl, CURLOPT_HEADER, false);
        		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        		curl_setopt($curl, CURLOPT_HTTPHEADER,
        		array("Authorization: Bearer $token",
        			"Content-type: application/json"));
        		curl_setopt($curl, CURLOPT_POST, true);
        		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        		$json_response = curl_exec($curl);
        		curl_close($curl);
        		$response = json_decode($json_response, true);
            $id_op = $response['id_CRM'];
            $GLOBALS['log']->fatal('Creacion de Cotizacion en Dynamics: ' .$response);
            $GLOBALS['log']->fatal(json_encode(print_r($response,true)));
            if($id_op)
            {
              $bean->int_id_dynamics = $id_op;
            }
            else
            {
              if($response) throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response[errores][0]['describeError']);
            }
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("Servicio de Dynamics no disponible");
          }
        }
        //Actualizacion
        if(!empty($bean->int_id_dynamics)  && ($bean->fetched_row['int_prima_neta'] != $bean->int_prima_neta || $bean->fetched_row['int_comision'] != $bean->int_comision || $bean->fetched_row['int_comision_porcentaje'] != $bean->int_comision_porcentaje
            ||$bean->fetched_row['aseguradora_c'] != $bean->aseguradora_c))
        {
          $token = $this->getToken();
          if($token)
          {
           
            $url = $sugar_config['inter_dynamics_url'].'Cotizacion/'.$bean->int_id_dynamics;
        		$arreglo = array(
                    "int_prima_neta" => $bean->int_prima_neta,
                    "int_comision" => $bean->int_comision,
                    "int_comision_porcentaje" => $bean->int_comision_porcentaje,
                    "int_aseguradora_id" => $aseguradora
                );
            $content = json_encode($arreglo);
            $GLOBALS['log']->fatal('Seguros_Dynamics - Actualiza Cotizacion: '. $url);
            $GLOBALS['log']->fatal($content);
            $curl = curl_init($url);
        		curl_setopt($curl, CURLOPT_HEADER, false);
        		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        		curl_setopt($curl, CURLOPT_HTTPHEADER,
        		array("Authorization: Bearer $token",
        			"Content-type: application/json"));
        		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        		$response = curl_exec($curl);
            $GLOBALS['log']->fatal('Cotizacion Actualizada: ' .$response);
            curl_close($curl);
            if($response['critical'] == 'true') throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response);
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("Servicio de Dynamics no disponible");
          }
        }
        //Actualizar ids aseguradoras
        if($bean->fetched_row['int_aseguradora_id_c'] != $bean->int_aseguradora_id_c && !empty($bean->int_aseguradora_id_c)){
            $listaSugar = $app_list_strings['aseguradoras_list'];
            $idSugar = '';
            foreach ($listaSugar as $key => $value) {
            if($bean->int_aseguradora_id_c == $value){
                $idSugar = $key;
            }
            }
            $bean->aseguradora_c = $idSugar;
        }

    }

    public function getToken()
    {
      //Obtiene Token
      global $sugar_config;
      $loginurl = $sugar_config['inter_dynamics_token_url'];
      $usr = $sugar_config['inter_dynamics_usr'];
      $psw = $sugar_config['inter_dynamics_psw'];
      $params = json_encode(array(
          'name'=>$usr,
          'password'=>$psw,
          'int_serv_servicio'=>'Valida Token'
      ));
      $GLOBALS['log']->fatal('Petición Token Dynamics INTER: '. $loginurl );
      $curl = curl_init($loginurl);
      curl_setopt($curl, CURLOPT_HEADER, false);
      curl_setopt($curl, CURLOPT_HTTPHEADER,
        		array(
        			"Content-type: application/json"));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
      $response = curl_exec($curl);
      $response = json_decode($response, true);
      $GLOBALS['log']->fatal($response);
  		curl_close($curl);
  		return $response['Token'];
    }
}
