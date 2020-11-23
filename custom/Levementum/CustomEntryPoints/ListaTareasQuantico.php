<?php
/**
 * Created by Salvador Lopez.
 */
class ApiCallQuantico 
{
    
    function callQuantico($url,$type){

        //open connection
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        if($type=='POST'){
            curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch,CURLOPT_POST, true);
        }else{
            curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "GET");
        }
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array()));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

        //execute post
        $result = curl_exec($ch);

        $result_json=json_decode($result);

        return $result_json;

    }
}
global $current_user,$sugar_config;
    //Variables para puerto
    //$Host=$sugar_config['url_Refinanciamientos'];
$objGUID="36f736ec-89fa-441f-9cef-ac5458f9b629";

$url = "https://unifin-tst.outsystemsenterprise.com/Quantico_AccessControl/rest/CreateToken/CreateToken?ObjectGUID=".$objGUID;
//$url = "https://unifin-tst.outsystemsenterprise.com/Quantico_AccessControl/rest/CreateToken/CreateToken";

$objCall=ApiCallQuantico::callQuantico($url,"POST");

$token=$objCall->Token;

$GLOBALS['log']->fatal(print_r($objCall,true));


?>

<!DOCTYPE html>
<html>
<body>

    <?php

    if(!empty($token)){
        //https://unifin-tst.outsystemsenterprise.com/Quantico_AccessControl/Quantico_CRMLogin.aspx?token=12345-XYZ&amp;IsBackoffice=True
        $urlLoginQuantico="https://unifin-tst.outsystemsenterprise.com/Quantico_AccessControl/Quantico_CRMLogin.aspx?token=".$token."&IsBackoffice=True";

        $respuesta=ApiCallQuantico::callQuantico($urlLoginQuantico,"GET");
        $GLOBALS['log']->fatal(print_r($respuesta,true));

        echo '<iframe src="'.$respuesta.'" style="width:100%;height: 100%;position: absolute;"></iframe>';
    } else {
        echo '<h1>Este ObjectGuid no esta registrado en el sistema</h1>';
    }
?>


</body>
</html>


