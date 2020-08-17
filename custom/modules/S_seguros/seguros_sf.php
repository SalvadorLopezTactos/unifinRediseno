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
      $cuenta = BeanFactory::getBean('Accounts', $bean->s_seguros_accountsaccounts_ida);
      $resumen = BeanFactory::getBean('tct02_Resumen', $bean->s_seguros_accountsaccounts_ida);
//      if($cuenta->tipo_registro_cuenta_c == 2)
        $GLOBALS['log']->fatal('Inicia Seguros_SalesForce');
//      {
        global $sugar_config;
        global $app_list_strings;
   			require_once 'include/api/SugarApiException.php';
        //Consulta Cuenta
        if(!$cuenta->salesforce_id_c)
        {
          $token = $this->getToken();
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
            $cuenta->salesforce_id_c = $id_sf;
            $cuenta->save();
          }
        }
        //Prospecto
        if($bean->etapa == 1 && !$bean->id_salesforce)
        {
          $token = $this->getToken();
          $recordTypeId = $app_list_strings['tipo_registro_id_list'][$bean->tipo_registro_sf_c];
          $type = $app_list_strings['tipo_sf_list'][$bean->tipo_sf_c];
          $tipoDeRegistroC = $app_list_strings['area_r_list'][$bean->area];
          $ramoC = $app_list_strings['subramos_list'][$bean->subramos_c];
          $currencyIsoCode = $app_list_strings['monedas_list'][$bean->monedas_c];
          $oportunidadInternacionalC = $app_list_strings['nacional_list'][$bean->nacional_c];
          $oficinaC = $app_list_strings['oficina_list'][$bean->oficina_c];
          $kamC = $app_list_strings['kam_list'][$bean->kam_c];
          $referenciadorDeLaOportunidadC = $app_list_strings['referenciador_list'][$bean->referenciador_c];
          if($bean->tipo_referenciador == 1) $usuarios = BeanFactory::getBean('Users', $bean->user_id1_c);
          if($bean->tipo_referenciador == 2) $usuarios = BeanFactory::getBean('Users', $bean->user_id2_c);
          $referenciador = $usuarios->nombre_completo_c;
          if($bean->tipo_referenciador == 1) $referenciadorCuenta = $referenciador." ".$bean->region;
          if($bean->tipo_referenciador == 2) $referenciadorCuenta = $referenciador." ".$bean->departamento_c;
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
          if($bean->tipo_registro_sf_c == 1) unset($arreglo['oportunidadInternacionalC']);
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
          if($id_op)
          {
            $bean->id_salesforce = $id_op;
          }
          else
          {
            throw new SugarApiExceptionInvalidParameter("No se puede guardar. ".$response[errores][0]['describeError']);
          }
        }
        //Cotizando
        if($bean->etapa == 2)
        {
          $token = $this->getToken();
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
        //Presentación
        if($bean->etapa == 6)
        {
          $token = $this->getToken();
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
        //Re-negociación
        if($bean->etapa == 7)
        {
          $token = $this->getToken();
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
        //Ganada
        if($bean->etapa == 9)
        {
          $token = $this->getToken();
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
        //Perdida
        if($bean->etapa == 10)
        {
          $token = $this->getToken();
          $stageName = $app_list_strings['etapa_seguros_list'][$bean->etapa];
          $razonPerdida = $app_list_strings['razon_perdida_list'][$bean->razon_perdida_c];
          $no_renovable_c = $app_list_strings['no_renovable_list'][$bean->no_renovable_c];
      		$url = $sugar_config['seguros_sf'].'data/cambioEtapa';
      		$content = json_encode(array(
            "etapa" => "PERDIDA",
            "oportinidadId" => $bean->id_salesforce,
            "stageName" => $stageName,
            "razonPerdida" => $razonPerdida,
            "comentariosRazonPerdida" => $bean->comentarios_c,
            "ramoNoRenovablec" => $no_renovable_c
          ));
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
//      }
        $GLOBALS['log']->fatal('Finaliza Seguros_SalesForce');
    }

    public function getToken()
    {
      //Obtiene Token
      global $sugar_config;
      $loginurl = $sugar_config['seguros_sf'].'public/token';
      $params = "user=generica"
        . "&password=generica";
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