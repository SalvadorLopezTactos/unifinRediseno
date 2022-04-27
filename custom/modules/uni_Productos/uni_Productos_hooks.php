<?php

class uni_Productos_hooks
{
    function cancelarOppsFromAccounts($bean, $event, $arguments){

      //Obteniendo el Estatus por producto
      // $GLOBALS['log']->fatal('---logic hook1---');
      $status=$bean->status_management_c;
      $tipo=$bean->tipo_producto;
      if($tipo=="1" && $status=="3"){//status ->3 =Cancelado
        //$GLOBALS['log']->fatal('---Cancela pre-solicitudes del producto Leasing---');
        //Obtiene cuenta
        $idCuenta=$bean->accounts_uni_productos_1accounts_ida;
        $beanCuenta = BeanFactory::getBean('Accounts', $idCuenta,array('disable_row_level_security' => true));

        if(!empty($beanCuenta)){
          if ($beanCuenta->load_relationship('opportunities')) {
            $opps = $beanCuenta->opportunities->getBeans();
            if (!empty($opps)) {
              foreach ($opps as $opp) {
                //Valida que sea pre-solicitud de Leasing
                if($opp->tct_etapa_ddw_c == 'SI' && $opp->tipo_producto_c=='1' && ($opp->producto_financiero_c=='0' || empty($opp->producto_financiero_c)) ){
                  //$GLOBALS['log']->fatal('---Cancelando Opportunidad: '.$opp->name.' '.$opp->id.'---');
                  $opp->tct_oportunidad_perdida_chk_c=1;
                  $opp->tct_razon_op_perdida_ddw_c='TR';//TIEMPO DE RESPUESTA
                  $opp->estatus_c='K';
                  $opp->save();
                }
              }
            }
          }
        }
      }
    }//Función
}//Clase
?>
