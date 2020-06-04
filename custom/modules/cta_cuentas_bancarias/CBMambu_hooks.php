<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 28/05/20
 * Time: 03:18 PM
 */

require_once("custom/Levementum/UnifinAPI.php");

class CBMambu_hook
{

    function Envia_mambu($bean = null, $event = null, $args = null)
    {
        global $sugar_config,$db,$app_list_strings;
        $GLOBALS['log']->fatal('Inicia CBMambu_hook');
        $bank = $app_list_strings['banco_list']; 
        //traer el bean de la cuenta para obtener el encodedkey_mambu_c
        $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->cta_cuentas_bancarias_accountsaccounts_ida, array('disable_row_level_security' => true));

        //Condicion para crear la cuenta en Mambu considerando $bean->ext1==""
        if ($bean->ext1=="" && $bean->id!="" && $beanCuenta->encodedkey_mambu_c!="") {
            $GLOBALS['log']->fatal('Hace consulta para validar que tenga indice');
            //URL para consulta en mambu si existe la cuenta bancaria (fullDetails)
            $url=$sugar_config['url_mambu_gral'].'groups/'.$beanCuenta->encodedkey_mambu_c.'?fullDetails=true';
            $user=$sugar_config['user_mambu'];
            $pwd=$sugar_config['pwd_mambu'];
            $auth_encode=base64_encode( $user.':'.$pwd );

            //Ejecuta consulta a mambu
            $callApi = new UnifinAPI();
            $resultado = $callApi->getMambu($url,$auth_encode);
            $GLOBALS['log']->fatal('Resultado: '. json_encode($resultado));
            $GLOBALS['log']->fatal('Ejecutó consulta para validar cuenta bancaria existente');
            $indice=null;
            if(!empty($resultado['customInformation'])){
                foreach ($resultado['customInformation'] as $item){
                    if ($item['customFieldID']=="_guid_crm" && $item['value']==$bean->id){
                            $indice=$item['customFieldSetGroupIndex'];
                            $bean->ext1=$indice;
                    }
                }
            }
            $GLOBALS['log']->fatal('Valor INDICE : '.$indice);
            //Evalua si el id de la CB a crear/actualizar existe en custom information
                if ($indice>=0 && $indice!==null){
                     //ACTUALIZAR
                    //Evalua si se tiene encoded key, id e indice
                    if ($bean->ext1>=0 && $bean->id!="" && $beanCuenta->encodedkey_mambu_c!=""){
                        $resultadoUpdate=CBMambu_hook::updateCB($bean, $event,$args, $beanCuenta);
                        //Controlar mensaje final
                        $GLOBALS['log']->fatal('Ha actualizado correctamente la Cuenta Bancaria: '. $bean->banco);
                    }
                }else{
                    //No existe el id en custom information (Mambu) por ende da de alta la CB
                    /********************* ALTA CUENTA BANCARIA MAMBU ***************************/
                    $url=$sugar_config['url_mambu_gral'].'groups/'.$beanCuenta->encodedkey_mambu_c;
                    $user=$sugar_config['user_mambu'];
                    $pwd=$sugar_config['pwd_mambu'];
                    $auth_encode=base64_encode( $user.':'.$pwd );
                    //Valdación de campos para generación de body
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
                  
                    $body = 
                    array(
                        array(
                            "op"=>"add",
                            "path"=>"/_cuentas_bancarias_clientes/-",
                            "value"=> array(
                                "_pago_proveedor"=> $proveedor,
                                "_domiciliacion"=> $domiciliacion,
                                "_nombre_banco_cliente"=>$bank[$bean->banco],
                                "_guid_crm"=>$bean->id
                            )
                        ),
                    );

                    if($bean->cuenta!=""){
                        $body[0]['value']['_numero_cuenta_cliente']=$bean->cuenta;
                    }
                    if($bean->clabe!=""){
                        $body[0]['value']['_clabe_interbancaria']=$bean->clabe;
                    }

                    $GLOBALS['log']->fatal('Petición: '. json_encode($body));
                    //Llama a UnifinAPI para que realice el consumo de servicio a Mambu
                    $callApi = new UnifinAPI();
                    $resultado = $callApi->postCBMambu($url,$body,$auth_encode);
                    $GLOBALS['log']->fatal('CREA NUEVA CUENTA BANCARIA '.$beanCuenta->name);
                    $GLOBALS['log']->fatal('Resultado: '. json_encode($resultado));
                }


        }else{
            //ACTUALIZAR
            //Evalua si se tiene encoded key, id e indice
            if ($bean->ext1>=0  && $bean->id!="" && $beanCuenta->encodedkey_mambu_c!=""){
                $resultadoUpdate=CBMambu_hooks::updateCB($bean, $event,$args, $beanCuenta);

                //Controlar mensaje para log
            }
        }
        $GLOBALS['log']->fatal('Termina CBMambu_hook');
   }
    function updateCB($bean=null, $event=null,$args=null, $beanCuenta){
        global $sugar_config,$db,$app_list_strings;
         $bank = $app_list_strings['banco_list']; 
        //URL para PATCH
        $url=$sugar_config['url_mambu_gral'].'groups/'.$beanCuenta->encodedkey_mambu_c.'/custominformation';
        $user=$sugar_config['user_mambu'];
        $pwd=$sugar_config['pwd_mambu'];
        $auth_encode=base64_encode( $user.':'.$pwd );

        //Valdación de campos para generación de body
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
            "customInformation"=> array (
                array(
                    "customFieldID"=>"_pago_proveedor",
                    "value"=>$proveedor,
                    "customFieldSetGroupIndex"=>$bean->ext1
                ),
                array(
                    "customFieldID"=>"_domiciliacion",
                    "value"=>$domiciliacion,
                    "customFieldSetGroupIndex"=>$bean->ext1
                ),
                array(
                    "customFieldID"=>"_nombre_banco_cliente",
                    "value"=>$bank[$bean->banco],
                    "customFieldSetGroupIndex"=>$bean->ext1
                ),
                array(
                    "customFieldID"=>"_guid_crm",
                    "value"=>$bean->id,
                    "customFieldSetGroupIndex"=>$bean->ext1
                )
            )
        );

        if($bean->cuenta!=""){
                    $body['customInformation'][]=
                     array(
                    "customFieldID"=>"_numero_cuenta_cliente",
                    "value"=>$bean->cuenta,
                    "customFieldSetGroupIndex"=>$bean->ext1
                );                    
        }
        if($bean->clabe!=""){
                    $body['customInformation'][]=
                    array(
                    "customFieldID"=>"_clabe_interbancaria",
                    "value"=>$bean->clabe,
                    "customFieldSetGroupIndex"=>$bean->ext1
                );
        }

        $GLOBALS['log']->fatal('Petición: '. json_encode($body));
        //Llama a UnifinAPI para que realice el consumo de servicio a Mambu
        $callApi = new UnifinAPI();
        $resultado = $callApi->updateMambuCB($url,$body,$auth_encode);
        $GLOBALS['log']->fatal('Resultado: '. json_encode($resultado));

        return $resultado;
    }
}