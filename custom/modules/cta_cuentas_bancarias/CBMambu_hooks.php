<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 28/05/20
 * Time: 03:18 PM
 */

require_once("custom/Levementum/UnifinAPI.php");

class CBMambu_hooks
{

    function Envia_mambu($bean = null, $event = null, $args = null)
    {
        global $sugar_config,$db;

        //Condicion para crear la cuenta en Mambu considerando $bean->ext1==""
        if ($bean->ext1=="") {

            $GLOBALS['log']->fatal("Inicia CBMambu_hooks para creacion de Cuenta Bancaria en Mambu");
            //Declara variables globales para la peticion del servicio Mambu
            //Pendiente a que manden el servicio de ALTA
            $url=$sugar_config[''];
            $user=$sugar_config['user_mambu'];
            $pwd=$sugar_config['pwd_mambu'];
            $auth_encode=base64_encode( $user.':'.$pwd );

            $domiciliacion="";
            //Condicion para envio de domiciliacion
            $proveedor="";

            $comparacion= strpos($bean->usos, "^1^");
            if ($comparacion ===false){
                $domiciliacion="FALSE";
            }else{
                $domiciliacion="TRUE";
            }
            $comparacion= strpos($bean->usos, "^2^");
            if ($comparacion ===false){
                $proveedor="FALSE";
            }else{
                $proveedor="TRUE";
            }

            $body = array(
                "op"=>"add",
                "path"=>"/_cuentas_bancarias_clientes/-",
                "value"=> array(
                    "_pago_proveedor"=> $proveedor,
                    "_domiciliacion"=> $domiciliacion,
                    "_numero_cuenta_cliente"=> $bean->cuenta,
                    "_clabe_interbancaria"=> $bean->clabe,
                    "_nombre_banco_cliente"=> $bean->banco
                ),

            );

            $GLOBALS['log']->fatal('Petición: '. json_encode($body));
            //Llama a UnifinAPI para que realice el consumo de servicio a Mambu
            $callApi = new UnifinAPI();
            $resultado = $callApi->postMambu($url,$body,$auth_encode);
            $GLOBALS['log']->fatal('Resultado: '. json_encode($resultado));

            if(!empty($resultado['encodedKey'])){
                $GLOBALS['log']->fatal('Ha realizado correctamente la creacion de cuenta bancaria en Mambu');

                //Realiza update al campo ext1 con el valor de ENVIADO
                $query = "UPDATE cta_cuenta_bancaria
                              SET ext1 ='ENVIADO'
                              WHERE id = '".$bean->id."'";
                $queryResult = $db->query($query);
            }else{
                $GLOBALS['log']->fatal("Error al procesar la solicitud, verifique información");
            }
        }else{

        }
    }
}