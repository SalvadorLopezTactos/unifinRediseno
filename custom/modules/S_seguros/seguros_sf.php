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
      if($cuenta->tipo_registro_cuenta_c == 2)
      {
    		$post_data = array(
    			'grant_type'    => 'password',
    			'client_id'     => '3MVG9vtcvGoeH2bhLFqJ90HqOGN4JHhmlzYkj9syKBhKTnMb413fNQcMXR__9SjkZ1mnXntt34hAloe5yWtiS',
    			'client_secret' => '123ED469F215FE672F9A9160C7D71FA207A0C9ED922D61086D7663325F03A074',
    			'username'      => 'eduardo.carrasco@curious-badger-g4y1nr.com',
    			'password'      => 'Tactos-2020OnvieP9Lq6LQ4Xk3lIACoGgs'
    		);
    		$headers = array(
    			'Content-type' => 'application/x-www-form-urlencoded;charset=UTF-8'
    		);
    		$curl = curl_init('https://curious-badger-g4y1nr-dev-ed.my.salesforce.com/services/oauth2/token');
    		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($curl, CURLOPT_POST, true);
    		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    		$response = curl_exec($curl);
    		curl_close($curl);
    		$sf_access_data = json_decode($response, true);
    		$access_token = $sf_access_data['access_token'];
    		$url = 'https://curious-badger-g4y1nr-dev-ed.my.salesforce.com/services/data/v42.0/sobjects/Account';
    		$content = json_encode(array("Name" => $cuenta->name));
    		$curl = curl_init($url);
    		curl_setopt($curl, CURLOPT_HEADER, false);
    		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($curl, CURLOPT_HTTPHEADER,
    		array("Authorization: OAuth $access_token",
    			"Content-type: application/json"));
    		curl_setopt($curl, CURLOPT_POST, true);
    		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    		$json_response = curl_exec($curl);
    		curl_close($curl);
    		$response = json_decode($json_response, true);
      }
    }
}