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
$GLOBALS['log']->fatal("inicia CallQuantico");

//$url = "https://unifin-tst.outsystemsenterprise.com/Quantico_AccessControl/rest/CreateToken/CreateToken?ObjectGUID=".$objGUID;
$url = $url_token.$objGUID;
$GLOBALS['log']->fatal($url);
$GLOBALS['log']->fatal("ID Active Directory: ".$objGUID);

$objCall=ApiCallQuantico::callQuantico($url,"POST");

$token=$objCall->Token;

$GLOBALS['log']->fatal(print_r($objCall,true));
$GLOBALS['log']->fatal(print_r($token,true));

?>
<script type="text/javascript">
    window.onload = function () {
        if(document.getElementById('linkQuantico')!=null){

            document.getElementById('linkQuantico').click();

        }
    };

</script>

<!DOCTYPE html>
<html>
<body>

    <?php

    if(!empty($token)){
        $GLOBALS['log']->fatal("Valida que haya token para poder cargar URL de Quantico Vista de tareas");

        $url_login=$sugar_config['quantico_url_base'];        
        //Puesto 6= BO Leasing, 12 = BO Factoraje, 17= BO Crédito Automotriz
        if($current_user->puestousuario_c=='6' || $current_user->puestousuario_c=='12' || $current_user->puestousuario_c=='17')
        {
            $urlLoginQuantico=$url_login."/Quantico/UnAsignedTasks.aspx?Token=".$token;
            $GLOBALS['log']->fatal("tiene backoffice, la URL es: " .$urlLoginQuantico);

        }else{
            $urlLoginQuantico=$url_login."/Quantico/AssignedTasks.aspx?Token=".$token;
            $GLOBALS['log']->fatal("NO tiene backoffice, la URL es: " .$urlLoginQuantico);
        }
        //$urlLoginQuantico="https://unifin-tst.outsystemsenterprise.com/Quantico_AccessControl/Quantico_CRMLogin.aspx?token=".$token."&IsBackoffice=".$booleano;
        //$respuesta=ApiCallQuantico::callQuantico($urlLoginQuantico,"GET");
        $GLOBALS['log']->fatal(print_r($respuesta,true));
        //echo '<iframe src="'.$urlLoginQuantico.'" style="width:100%;height: 100%;position: absolute;"></iframe>';
        echo '<a href="'.$urlLoginQuantico.'" target="_blank" id="linkQuantico">Dirigirse a Quantico</a>';
    } else {
        echo '<div style="text-align: center;vertical-align: middle;">
    <h1>Este ObjectGuid del usuario firmado no está registrado en el sistema</h1>
    </div>';
    }
?>


</body>
</html>


