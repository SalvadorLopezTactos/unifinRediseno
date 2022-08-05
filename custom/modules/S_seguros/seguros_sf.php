<?php
/*
 * Created by Tactos
 * Email: eduardo.carrasco@tactos.com.mx
 * Date: 27/07/2020
*/

class Seguros_SF
{
    public function getAccount($bean = null, $event = null, $args = null)
    {
        // Valida si viene de Uni2
        if($bean->seguro_uni2_c)
        {
          if($bean->id_disposicion_c)
          {
            global $db;
            $id_disposicion = "select id_disposicion_c from s_seguros_cstm where id_c <> '{$bean->id}' and id_disposicion_c = '{$bean->id_disposicion_c}'";
            $resultado = $db->query($id_disposicion);
            $encontrado = $db->fetchByAssoc($resultado);
            if($encontrado) throw new SugarApiExceptionInvalidParameter("No se puede guardar. Ya existe el Id Disposición");
          }
        }
        else
        {
          //Consulta Cuenta        
          $cuenta = BeanFactory::getBean('Accounts', $bean->s_seguros_accountsaccounts_ida, array('disable_row_level_security' => true));
          $resumen = BeanFactory::getBean('tct02_Resumen', $bean->s_seguros_accountsaccounts_ida, array('disable_row_level_security' => true));
          $GLOBALS['log']->fatal('Inicia Seguros_SalesForce');
          global $sugar_config;
          global $app_list_strings;
     			require_once 'include/api/SugarApiException.php';
          if(!$cuenta->salesforce_id_c)
          {
            $token = $this->getToken();
            if($token)
            {
          		$url = $sugar_config['seguros_sf'].'data/acoountExists';
          		$content = json_encode(array("nameAccount" => $cuenta->name));
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
              $id_sf = $response['id'];
              if($id_sf)
              {
                global $db;
                $update = "update accounts_cstm set
                  salesforce_id_c='{$id_sf}'
                  where id_c = '{$cuenta->id}'";
                $updateExecute = $db->query($update);
              }
            }
            else
            {
              throw new SugarApiExceptionInvalidParameter("Servicio de SalesForce no disponible");
            } 
          }
        }
        //Prospecto
        if($bean->fetched_row['etapa'] != $bean->etapa && $bean->etapa == 1 && !$bean->id_salesforce && !$bean->seguro_uni2_c)
        {
          global $db;
          $token = $this->getToken();
          if($token)
          {
            $recordTypeId = $app_list_strings['tipo_registro_id_list'][$bean->tipo_registro_sf_c];
            $type = $app_list_strings['tipo_sf_list'][$bean->tipo_sf_c];
            $tipoDeRegistroC = $app_list_strings['area_r_list'][$bean->area];
            $ramoC = $app_list_strings['subramos_list'][$bean->subramos_c];
            $currencyIsoCode = $app_list_strings['monedas_list'][$bean->monedas_c];
            $oportunidadInternacionalC = $app_list_strings['nacional_list'][$bean->nacional_c];
            $oficinaC = $app_list_strings['oficina_list'][$bean->oficina_c];
            $kamC = $app_list_strings['kam_list'][$bean->kam_c];
            $idUsuario = ($bean->tipo_referenciador == 1) ? $bean->user_id1_c : $bean->user_id2_c;
            $referenciadorDeLaOportunidadC = $app_list_strings['referenciador_list'][$bean->referenciador_c];
            $nombreUsuarioQuery = "Select nombre_completo_c from users_cstm where id_c ='{$idUsuario}'";
            $resultUsuario = $db->query($nombreUsuarioQuery);
            $referenciador = $db->fetchByAssoc($resultUsuario);
            if($bean->tipo_referenciador == 1) $referenciadorCuenta = $referenciador['nombre_completo_c']." ".$bean->region;
            if($bean->tipo_referenciador == 2) $referenciadorCuenta = $referenciador['nombre_completo_c']." ".$bean->departamento_c;
            if($bean->tipo_referenciador == 3) $referenciadorCuenta = $app_list_strings['ejecutivo_c_list'][$bean->ejecutivo_c];
            $stageName = $app_list_strings['etapa_seguros_list'][$bean->etapa];
            $closeDate = $bean->fecha_cierre_c;
            $closeDate = date("d/m/Y", strtotime($closeDate));
        		$url = $sugar_config['seguros_sf'].'data/creaProspecto';
            if(!$cuenta->salesforce_id_c)
            {
          		$arreglo = array(
                "sugarId" => $bean->id,
                "recordTypeId" => $recordTypeId,
                "nameAccount" => $cuenta->name,
                "name" => $bean->name,
                "type" => $type,
                "tipoDeRegistroC" => $tipoDeRegistroC,
                "ramoC" => $ramoC,
                "currencyIsoCode" => $currencyIsoCode,
                "oportunidadInternacionalC" => $oportunidadInternacionalC,
                "oficinaC" => $oficinaC,
                "kamC" => $kamC,
                "referenciadorDeLaOportunidadC" => $referenciadorDeLaOportunidadC,
                "referenciadorCuenta" => $referenciadorCuenta,
                "stageName" => $stageName,
                "closeDate" => $closeDate,
                "primaTotalObjetivoC" => $bean->prima_obj_c,
                "ingresoObjetivopC" => $bean->incentivo,
                "ingresoObjetivoC" => $bean->ingreso_inc
              );
            }
            else
            {
          		$arreglo = array(
                "sugarId" => $bean->id,
                "recordTypeId" => $recordTypeId,
                "accountId" => $cuenta->salesforce_id_c,
                "name" => $bean->name,
                "type" => $type,
                "tipoDeRegistroC" => $tipoDeRegistroC,
                "ramoC" => $ramoC,
                "currencyIsoCode" => $currencyIsoCode,
                "oportunidadInternacionalC" => $oportunidadInternacionalC,
                "oficinaC" => $oficinaC,
                "kamC" => $kamC,
                "referenciadorDeLaOportunidadC" => $referenciadorDeLaOportunidadC,
                "referenciadorCuenta" => $referenciadorCuenta,
                "stageName" => $stageName,
                "closeDate" => $closeDate,
                "primaTotalObjetivoC" => $bean->prima_obj_c,
                "ingresoObjetivopC" => $bean->incentivo,
                "ingresoObjetivoC" => $bean->ingreso_inc
              );
            }
            $content = json_encode($arreglo);
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
            $id_op = $response['oportunidadId'];
            $GLOBALS['log']->fatal('Informacion de Prospecto enviada: ' .$response);
            $GLOBALS['log']->fatal(json_encode(print_r($response,true)));
            if($id_op)
            {
              $bean->id_salesforce = $id_op;
            }
            else
            {
              if($response) throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response[errores][0]['describeError']);
            }
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("Servicio de SalesForce no disponible");
          }
        }
        //Cotizando
        if($bean->fetched_row['etapa'] != $bean->etapa && $bean->etapa == 2 && !$bean->seguro_uni2_c)
        {
          $token = $this->getToken();
          if($token)
          {
            $serviciosaincluirc = $app_list_strings['servicios_a_incluir_c_list'][$bean->servicios_a_incluir_c];
            $stageName = $app_list_strings['etapa_seguros_list'][$bean->etapa];
            $fechaRequierePropuestaC = $bean->fecha_req;
            $fechaRequierePropuestaC = date("d/m/Y", strtotime($fechaRequierePropuestaC));
            if($bean->requiere_ayuda_c == 1) $requiereAyudaDeReaTcnica = 0;
            if($bean->requiere_ayuda_c == 2) $requiereAyudaDeReaTcnica = 1;
        		$url = $sugar_config['seguros_sf'].'data/createCotizando';
        		$content = json_encode(array(
              "oportunidadId" => $bean->id_salesforce,
              "stageName" => $stageName,
              "requiereAyudaDeReaTcnica" => $requiereAyudaDeReaTcnica,
              "fechaRequierePropuestaC" => $fechaRequierePropuestaC,
              "description" => $bean->description,
              "serviciosaincluirc" => $serviciosaincluirc,
              "linkdedoccotizacinc" => "https://drive.google.com/drive/u/0/folders/".$bean->google_drive4_c
            ));
            $GLOBALS['log']->fatal($content);
            $curl = curl_init($url);
        		curl_setopt($curl, CURLOPT_HEADER, false);
        		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        		curl_setopt($curl, CURLOPT_HTTPHEADER,
        		array("Authorization: Bearer $token",
        			"Content-type: application/json"));
        		curl_setopt($curl, CURLOPT_POST, true);
        		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        		$response = curl_exec($curl);
        		curl_close($curl);
            $GLOBALS['log']->fatal('Informacion de Cotizando enviada: ' .$response);
            if($response != 'Correcto') throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response);
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("Servicio de SalesForce no disponible");
          }
        }
        //Cotizado
        if($bean->fetched_row['etapa'] != $bean->etapa && $bean->etapa == 4 && $bean->tipo_registro_sf_c == 1 && !$bean->seguro_uni2_c)
        {
          $token = $this->getToken();
          if($token)
          {
            $stageName = $app_list_strings['etapa_seguros_list'][$bean->etapa];
        		$url = $sugar_config['seguros_sf'].'data/cambioEtapa';
        		$content = json_encode(array(
              "etapa" => "COTIZADO",
              "oportinidadId" => $bean->id_salesforce,
              "stageName" => $stageName
            ));
            $GLOBALS['log']->fatal($content);
            $curl = curl_init($url);
        		curl_setopt($curl, CURLOPT_HEADER, false);
        		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        		curl_setopt($curl, CURLOPT_HTTPHEADER,
        		array("Authorization: Bearer $token",
        			"Content-type: application/json"));
        		curl_setopt($curl, CURLOPT_POST, true);
        		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        		$response = curl_exec($curl);
        		curl_close($curl);
            if($response != 'Correcto') throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response);
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("Servicio de SalesForce no disponible");
          }            
        }
        //No Cotizado
        if($bean->fetched_row['etapa'] != $bean->etapa && $bean->etapa == 5 && $bean->tipo_registro_sf_c == 1 && !$bean->seguro_uni2_c)
        {
          $token = $this->getToken();
          if($token)
          {
            $stageName = $app_list_strings['etapa_seguros_list'][$bean->etapa];
            $motivo = $app_list_strings['motivo_no_cotizado_list'][$bean->motivo_no_cotizado_c];
        		$url = $sugar_config['seguros_sf'].'data/cambioEtapa';
        		$content = json_encode(array(
              "etapa" => "NOCOTIZADO",
              "oportinidadId" => $bean->id_salesforce,
              "stageName" => $stageName,
              "motivosNoCotizada" => $motivo
            ));
            $GLOBALS['log']->fatal($content);
            $curl = curl_init($url);
        		curl_setopt($curl, CURLOPT_HEADER, false);
        		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        		curl_setopt($curl, CURLOPT_HTTPHEADER,
        		array("Authorization: Bearer $token",
        			"Content-type: application/json"));
        		curl_setopt($curl, CURLOPT_POST, true);
        		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        		$response = curl_exec($curl);
        		curl_close($curl);
            if($response != 'Correcto') throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response);
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("Servicio de SalesForce no disponible");
          }
        }
        //Presentación
        if($bean->fetched_row['etapa'] != $bean->etapa && $bean->etapa == 6 && !$bean->seguro_uni2_c)
        {
          $token = $this->getToken();
          if($token)
          {
            $stageName = $app_list_strings['etapa_seguros_list'][$bean->etapa];
        		$url = $sugar_config['seguros_sf'].'data/cambioEtapa';
        		$content = json_encode(array(
              "etapa" => "PRESENTACION",
              "oportinidadId" => $bean->id_salesforce,
              "stageName" => $stageName
            ));
            $GLOBALS['log']->fatal($content);
            $curl = curl_init($url);
        		curl_setopt($curl, CURLOPT_HEADER, false);
        		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        		curl_setopt($curl, CURLOPT_HTTPHEADER,
        		array("Authorization: Bearer $token",
        			"Content-type: application/json"));
        		curl_setopt($curl, CURLOPT_POST, true);
        		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        		$response = curl_exec($curl);
        		curl_close($curl);
            if($response != 'Correcto') throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response);
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("Servicio de SalesForce no disponible");
          }
        }
        //Re-negociación
        if($bean->fetched_row['etapa'] != $bean->etapa && $bean->etapa == 7 && !$bean->seguro_uni2_c)
        {
          $token = $this->getToken();
          if($token)
          {
            $stageName = $app_list_strings['etapa_seguros_list'][$bean->etapa];
        		$url = $sugar_config['seguros_sf'].'data/cambioEtapa';
        		$content = json_encode(array(
              "etapa" => "RENEGOCIADA",
              "oportinidadId" => $bean->id_salesforce,
              "stageName" => $stageName,
              "motivosRenegociaciNC" => $bean->motivos_c
            ));
            $GLOBALS['log']->fatal($content);
            $curl = curl_init($url);
        		curl_setopt($curl, CURLOPT_HEADER, false);
        		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        		curl_setopt($curl, CURLOPT_HTTPHEADER,
        		array("Authorization: Bearer $token",
        			"Content-type: application/json"));
        		curl_setopt($curl, CURLOPT_POST, true);
        		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        		$response = curl_exec($curl);
            $GLOBALS['log']->fatal('Informacion de Re-negociacon enviada: ' .$response);
            curl_close($curl);
            if($response != 'Correcto') throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response);            
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("Servicio de SalesForce no disponible");
          }
        }
        //Ganada
        if($bean->fetched_row['etapa'] != $bean->etapa && $bean->etapa == 9 && !$bean->seguro_uni2_c)
        {
          $token = $this->getToken();
          if($token)
          {
            $stageName = $app_list_strings['etapa_seguros_list'][$bean->etapa];
            $forma_pago = $app_list_strings['forma_pago_list'][$bean->forma_pago];
            $currencyIsoCode = $app_list_strings['monedas_list'][$bean->monedas_c];
            $aseguradora_c = $app_list_strings['aseguradoras_list'][$bean->aseguradora_c];
            $ejecutivo_c = $app_list_strings['ejecutivo_list'][$bean->ejecutivo_c];
            $fecha_ini_c = $bean->fecha_ini_c;
            $fecha_ini_c = date("d/m/Y", strtotime($fecha_ini_c));
            $fecha_fin_c = $bean->fecha_fin_c;
            $fecha_fin_c = date("d/m/Y", strtotime($fecha_fin_c));
        		$url = $sugar_config['seguros_sf'].'data/cambioEtapa';
        		$content = json_encode(array(
              "etapa" => "GANADA",
              "oportinidadId" => $bean->id_salesforce,
              "stageName" => $stageName,
              "primaNetaTotalC" => $bean->prima_neta_ganada_c,
              "feeC" => $bean->fee_c,
              "feePC" => $bean->fee_p_c,
              "formaPagoEmitidaC" => $forma_pago,
              "comisiNC" => $bean->comision_c,
              "currencyIsoCode" => $currencyIsoCode,
              "aseguradoraGanadoraC" => $aseguradora_c,
              "fechaInicioVigencia_ogC" => $fecha_ini_c,
              "fechaFinVigenciaOgC" => $fecha_fin_c,
              "ejecutivoAsignadoNuevoC" => $ejecutivo_c,
              "linkDocClienteC" => "https://drive.google.com/drive/u/0/folders/".$resumen->googledriveac_c
            ));
            $GLOBALS['log']->fatal($content);
            $curl = curl_init($url);
        		curl_setopt($curl, CURLOPT_HEADER, false);
        		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        		curl_setopt($curl, CURLOPT_HTTPHEADER,
        		array("Authorization: Bearer $token",
        			"Content-type: application/json"));
        		curl_setopt($curl, CURLOPT_POST, true);
        		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        		$response = curl_exec($curl);
            $GLOBALS['log']->fatal('Informacion de Ganada enviada: ' .$response);
            curl_close($curl);
            if($response != 'Correcto') throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response);
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("Servicio de SalesForce no disponible");
          }
        }
        //No Ganada
        if($bean->fetched_row['etapa'] != $bean->etapa && $bean->etapa == 10 && !$bean->seguro_uni2_c)
        {
          $token = $this->getToken();
          if($token)
          {
            $stageName = $app_list_strings['etapa_seguros_list'][$bean->etapa];
            $razonPerdida = $app_list_strings['razon_perdida_list'][$bean->razon_perdida_c];
            $no_renovable_c = $app_list_strings['no_renovable_list'][$bean->no_renovable_c];
        		$url = $sugar_config['seguros_sf'].'data/cambioEtapa';
        		$arreglo = array(
              "etapa" => "PERDIDA",
              "oportinidadId" => $bean->id_salesforce,
              "stageName" => $stageName,
              "razonPerdida" => $razonPerdida,
              "comentariosRazonPerdida" => $bean->comentarios_c,
              "ramoNoRenovablec" => $no_renovable_c
            );
            if($bean->tipo_registro_sf_c == 1) unset($arreglo['ramoNoRenovablec']);
            $content = json_encode($arreglo);
        		$curl = curl_init($url);
        		curl_setopt($curl, CURLOPT_HEADER, false);
        		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        		curl_setopt($curl, CURLOPT_HTTPHEADER,
        		array("Authorization: Bearer $token",
        			"Content-type: application/json"));
        		curl_setopt($curl, CURLOPT_POST, true);
        		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        		$response = curl_exec($curl);
            $GLOBALS['log']->fatal('Informacion de Perdida enviada: ' .$response);
            curl_close($curl);
            if($response != 'Correcto') throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response);
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("Servicio de SalesForce no disponible");
          }
        }
        //Solicitud de Cotización
        if($bean->fetched_row['etapa'] != $bean->etapa && $bean->etapa == 11 && !$bean->seguro_uni2_c)
        {
          $token = $this->getToken();
          if($token)
          {
            $stageName = $app_list_strings['etapa_seguros_list'][$bean->etapa];
        		$url = $sugar_config['seguros_sf'].'data/cambioEtapa';
        		$content = json_encode(array(
              "etapa" => "SOLICITUDCOTIZACION",
              "oportinidadId" => $bean->id_salesforce,
              "stageName" => $stageName
            ));
            $GLOBALS['log']->fatal($content);
            $curl = curl_init($url);
        		curl_setopt($curl, CURLOPT_HEADER, false);
        		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        		curl_setopt($curl, CURLOPT_HTTPHEADER,
        		array("Authorization: Bearer $token",
        			"Content-type: application/json"));
        		curl_setopt($curl, CURLOPT_POST, true);
        		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        		$response = curl_exec($curl);
        		curl_close($curl);
            if($response != 'Correcto') throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response);
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("Servicio de SalesForce no disponible");
          }
        }
        $GLOBALS['log']->fatal('Finaliza Seguros_SalesForce');
    }

    public function getToken()
    {
      //Obtiene Token
      global $sugar_config;
      $loginurl = $sugar_config['seguros_sf'].'public/token';
      $usr = $sugar_config['seguros_usr'];
      $psw = $sugar_config['seguros_psw'];
      $params = "user=".$usr."&password=".$psw;
      $curl = curl_init($loginurl);
      curl_setopt($curl, CURLOPT_HEADER, false);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
      $response = curl_exec($curl);
      $response = json_decode($response, true);
  		curl_close($curl);
  		return $response['token'];
    }
}
