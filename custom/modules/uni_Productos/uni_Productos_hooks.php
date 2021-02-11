<?php

class uni_Productos_hooks
{
    function cancelarOppsFromAccounts($bean, $event, $arguments){

      //Obteniendo el Estatus por producto
      $status=$bean->status_management_c;
      $tipo=$bean->tipo_producto;
      if($tipo=="1" && $status=="3"){//status ->3 =Cancelado
        $GLOBALS['log']->fatal('---Se cancela producto Leasing---');
        //Obtiene cuenta
        $idCuenta=$bean->accounts_uni_productos_1accounts_ida;
        $beanCuenta = BeanFactory::getBean('Accounts', $idCuenta,array('disable_row_level_security' => true));

        if(!empty($beanCuenta)){
          if ($beanCuenta->load_relationship('opportunities')) {
            $opps = $beanCuenta->opportunities->getBeans();
            if (!empty($opps)) {
              foreach ($opps as $opp) {
                $GLOBALS['log']->fatal('---Cancelando Opportunidad: '.$opp->name.' '.$opp->id.'---');
                $opp->tct_oportunidad_perdida_chk_c=1;
                $opp->tct_razon_op_perdida_ddw_c='TR';//TIEMPO DE RESPUESTA
                $opp->estatus_c='K';
                $opp->save();
              }
            }
          }
        }
      }
    }//Función   
}//Clase
?>