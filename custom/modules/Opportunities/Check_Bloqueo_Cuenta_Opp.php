<?php
require_once("custom/clients/base/api/GetBloqueoCuenta.php");
class Check_Bloqueo_Cuenta_Opp{
    
    //Evita guardado de registro en caso de que se relacione una cuenta bloqueada
    function verifica_cuenta_bloqueada_opp($bean=null, $event=null, $args=null){
        global $current_user;
        $id_cuenta="";
        if( $bean->module_name == 'Lic_Licitaciones' ){
            $id_cuenta = $bean->lic_licitaciones_accountsaccounts_ida;
        }else if( $bean->module_name == 'S_seguros' ){
            $id_cuenta = $bean->s_seguros_accountsaccounts_ida;
        }else{
            $id_cuenta = $bean->account_id;
        }

        $api_bloqueo = new GetBloqueoCuenta();
        $args =array();
        $args['id_cuenta']=$id_cuenta;
        
        $responseBloqueo = $api_bloqueo->getBloqueoCuentaPorTipo(array(),$args);
        
        if( $responseBloqueo['bloqueo'] == 'SI' ){

            //Si la cuenta relacionada está bloqueada, pero el asesor pertenece al CAC, si se permite crear Casos
            if( $bean->module_name == 'Cases'){
                if (!$current_user->cac_c) {
                    $tipos_bloqueo = $responseBloqueo['tipo'];
                    require_once 'include/api/SugarApiException.php';
                    require_once 'custom/include/api/CstmException.php';
                    if( $_SESSION['platform'] == 'base'  || $_SESSION['platform'] == 'mobile'){
                        throw new SugarApiExceptionInvalidParameter("El registro no se puede guardar ya que la cuenta relacionada se encuentra bloqueada por: ". implode(',',$tipos_bloqueo) );
                    }else{
                        throw new CstmException("El registro no se puede guardar ya que la cuenta relacionada se encuentra bloqueada por: ". implode(',',$tipos_bloqueo) );
                    }
                }

            }else{
                $tipos_bloqueo = $responseBloqueo['tipo'];
                require_once 'include/api/SugarApiException.php';
                require_once 'custom/include/api/CstmException.php';
                if( $_SESSION['platform'] == 'base'  || $_SESSION['platform'] == 'mobile'){
                    throw new SugarApiExceptionInvalidParameter("El registro no se puede guardar ya que la cuenta relacionada se encuentra bloqueada por: ". implode(',',$tipos_bloqueo) );
                }else{
                    throw new CstmException("El registro no se puede guardar ya que la cuenta relacionada se encuentra bloqueada por: ". implode(',',$tipos_bloqueo) );
                }
            } 
        }
        
        
    }
}
