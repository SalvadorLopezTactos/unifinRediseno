<?php
require_once("custom/clients/base/api/GetBloqueoCuenta.php");
class Check_Bloqueo_Cuenta_Opp{
    
    //Evita guardado de registro en caso de que se relacione una cuenta bloqueada
    function verifica_cuenta_bloqueada_opp($bean=null, $event=null, $args=null){
        
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
            
            $tipos_bloqueo = $responseBloqueo['tipo'];
            require_once 'include/api/SugarApiException.php';
            throw new SugarApiExceptionInvalidParameter("El registro no se puede guardar ya que la cuenta relacionada se encuentra bloqueada por: ". implode(',',$tipos_bloqueo) );
            
        }
        
        
    }
}
