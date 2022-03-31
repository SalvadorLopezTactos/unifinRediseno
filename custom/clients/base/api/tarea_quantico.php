<?php
/*
 * Created by Eduardo Carrasco
 * Date: 29/03/2022
 */
class tarea_quantico extends SugarApi
{
    public function registerApiRest()
    {
        return array(
                'tarea_quantico' => array(
                'reqType' => 'GET',
                'path' => array('tarea_quantico','?'),
                'pathVars' => array('', 'id'),
                'method' => 'tareas_quantico',
                'shortHelp' => 'Consumo para dar de alta tareas de integración de expediente para proveedores en Quantico',
            ),
        );
    }

	public function tareas_quantico($api, $args){
        global $sugar_config;
		$url = $sugar_config['quantico_url_base'].'/Suppliers_WS/rest/SupplierAPI/CreateSupplierExpedientTask/';
		$content = $args['id'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		$result = curl_exec($ch);
		$response = json_decode($result, true);
		if($response['Message'] == "El proveedor aún no está creado en Quantico") {
			$account = BeanFactory::retrieveBean('Accounts', $args['id'], array('disable_row_level_security' => true));
			if($account->tipodepersona_c == "Persona Fisica") $regimen = 1;
			if($account->tipodepersona_c == "Persona Fisica con Actividad Empresarial") $regimen = 2;
			if($account->tipodepersona_c == "Persona Moral") $regimen = 3;
			$arreglo = array(
                "CRMId" => $account->id,
                "Name" => $account->name,
                "RFC" => $account->rfc_c,
                "PersonTypeExternalId" => $regimen
            );
			$url = $sugar_config['quantico_url_base'].'/Suppliers_WS/rest/SupplierAPI/CreateSupplierInQuantico/';
			$content = json_encode($arreglo);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_ENCODING, '');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POST, true);
          	curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
          	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
			$result = curl_exec($ch);
			$response = json_decode($result, true);
			if($response['IsValid']) {
				$account->proveedor_quantico_c = 1;
				$account->save();
				$url = $sugar_config['quantico_url_base'].'/Suppliers_WS/rest/SupplierAPI/CreateSupplierExpedientTask/';
				$content = $args['id'];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_ENCODING, '');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
				$result = curl_exec($ch);
				$response = json_decode($result, true);
			}
        }
		$respuesta = $response['Message'];
        return $respuesta;
    }
}
