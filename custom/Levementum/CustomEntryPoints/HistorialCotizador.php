<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 20/04/21
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("custom/Levementum/UnifinAPI.php");
global $current_user;
global $sugar_config;
$GLOBALS['log']->fatal("inicia HistorialCotizador");
//$objectGuid="2cd81b4b-28a5-4178-9752-b154abdb2642";
//Obteniendo id desde el uuario actual
$url=$sugar_config['quantico_url_base'];
//$objectGuid=$current_user->id_active_directory_c;
$objectGuid=$_GET['idActiveDirectory'];
//$host="https://unifin-dev.outsystemsenterprise.com//Database/rest/Security/CreateToken?ObjectGuid=".$objectGuid;
$host=$url."/Quantico_AccessControl/rest/CreateToken/CreateToken?ObjectGUID=".$objectGuid;

$resultado=callPostAPI("POST",$host,"");
$token=$resultado['Token'];
$GLOBALS['log']->fatal("Tiene Token HistorialCotizador: ".$token);
echo '<script type="text/javascript">
    window.onload = function () {
        if(document.getElementById("HistorialCotizador")!=null){

            document.getElementById("HistorialCotizador").click();

        }
    };
</script>
<!DOCTYPE html>
<html>
<body>

<a href="'.$url.'/Cotizador/quotes.aspx?&token='.$token.'" target="_blank" id="HistorialCotizador">Dirigirse a Historial de Cotizaciones</a>
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


