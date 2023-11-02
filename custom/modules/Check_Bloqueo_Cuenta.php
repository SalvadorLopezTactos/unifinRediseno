<?php
require_once("custom/clients/base/api/GetBloqueoCuenta.php");
class Check_Bloqueo_Cuenta{

	//Evita guardado de registro en caso de que se relacione una cuenta bloqueada
	function verifica_cuenta_bloqueada($bean=null, $event=null, $args=null){
		
		$modulo = $bean->parent_type;
		//Ilocalizable
		if( $modulo == 'Accounts' ){

			$id_registro = $bean->parent_id;
            $GLOBALS['log']->fatal("ID REGISTRO: ".$id_registro);

            $api_bloqueo = new GetBloqueoCuenta();
            $args =array();
            $args['id_cuenta']=$id_registro;

            $responseBloqueo = $api_bloqueo->getBloqueoCuentaPorTipo(array(),$args);

            if( $responseBloqueo['bloqueo'] == 'SI' ){

                $tipos_bloqueo = $responseBloqueo['tipo'];
                require_once 'include/api/SugarApiException.php';
                throw new SugarApiExceptionInvalidParameter("El registro no se puede guardar ya que la cuenta relacionada se encuentra bloqueada por: ". implode(',',$tipos_bloqueo) );

            }
			
			
		} 
		
	}
}
