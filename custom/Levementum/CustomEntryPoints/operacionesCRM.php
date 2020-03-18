<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez.lopez@tactos.com.mx
 * Date: 16/03/20
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("custom/Levementum/UnifinAPI.php");
global $current_user;
global $sugar_config;
//$objectGuid="2cd81b4b-28a5-4178-9752-b154abdb2642";
//Obteniendo id desde el uuario actual
$url=$sugar_config['outsystems_url'];
$objectGuid=$current_user->id_active_directory_c;
//$host="https://unifin-dev.outsystemsenterprise.com//Database/rest/Security/CreateToken?ObjectGuid=".$objectGuid;
$host=$url."//Database/rest/Security/CreateToken?ObjectGuid=".$objectGuid;

$resultado=callPostAPI("POST",$host,"");
$token=$resultado['Token'];
echo '<!DOCTYPE html>
<html>
<body>

<iframe src="'.$url.'/OperacionesCRM/?token='.$token.'" style="width:100%;height: 100%;position: absolute;"></iframe>

</body>
</html>';
function callPostAPI($method, $url, $data){

        $curl = curl_init();
        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array()));
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $result = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($result, true);
        return $response;
    }


