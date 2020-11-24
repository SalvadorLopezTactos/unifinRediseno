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
//$objGUID="36f736ec-89fa-441f-9cef-ac5458f9b629";
$objGUID=$current_user->id_active_directory_c;
$url_token=$sugar_config['url_quantico_token'];

//$url = "https://unifin-tst.outsystemsenterprise.com/Quantico_AccessControl/rest/CreateToken/CreateToken?ObjectGUID=".$objGUID;
$url = $url_token.$objGUID;

$objCall=ApiCallQuantico::callQuantico($url,"POST");

$token=$objCall->Token;

$GLOBALS['log']->fatal(print_r($objCall,true));

?>

<!DOCTYPE html>
<html>
<body>

    <?php

    if(!empty($token)){

        $url_login=$sugar_config['url_quantico_login'];
        $booleano="";
        //Puesto 6= BO Leasing, 12 = BO Factoraje, 17= BO Crédito Automotriz
        if($current_user->puestousuario_c=='6' || $current_user->puestousuario_c=='12' || $current_user->puestousuario_c=='17')
        {
            $booleano="True";

        }else{
            $booleano="False";
        }
        //$urlLoginQuantico="https://unifin-tst.outsystemsenterprise.com/Quantico_AccessControl/Quantico_CRMLogin.aspx?token=".$token."&IsBackoffice=".$booleano;

        $urlLoginQuantico=$url_login.$token."&IsBackoffice=".$booleano;

        //$respuesta=ApiCallQuantico::callQuantico($urlLoginQuantico,"GET");
        //$GLOBALS['log']->fatal(print_r($respuesta,true));

        //echo '<iframe src="'.$urlLoginQuantico.'" style="width:100%;height: 100%;position: absolute;"></iframe>';
        echo '<a href="'.$urlLoginQuantico.'" target="_blank">Dirigirse a Quantico</a>';
    } else {
        echo '<h1>Este ObjectGuid del usuario firmado no está registrado en el sistema</h1>';
    }
?>


</body>
</html>


