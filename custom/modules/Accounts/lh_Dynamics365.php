<?php

class Accounts_Dynamics365
{
  public function IntegraDynamics($bean = null, $event = null, $args = null)
  {

      //Integración con Dynamics en creación de cuenta
      //Obteniendo tipo de Cuenta
      // Proveedor esproveedor_c check
      // Tipo proveedor tipo_registro_cuenta_c = 5
      // Tipo Cliente tipo_registro_cuenta_c = 3
      // Cedente Factoraje cedente_factor_c check
      // Deudor Factoraje deudor_factor_c check
      $tipo_cuenta=$bean->tipo_registro_cuenta_c;
      $proveedor=$bean->esproveedor_c;
      $cedente=$bean->cedente_factor_c;
      $deudor=$bean->deudor_factor_c;
      $GLOBALS['log']->fatal('TIPO CUENTA: '.$tipo_cuenta);
      $GLOBALS['log']->fatal('SUBTIPO CUENTA: '.$bean->subtipo_registro_cuenta_c);
      $GLOBALS['log']->fatal('ES PROVEEDOR: '.$proveedor);
      $GLOBALS['log']->fatal('CEDENTE: '.$cedente);
      $GLOBALS['log']->fatal('DEUDOR: '.$deudor);

      if(($tipo_cuenta=='5' || $tipo_cuenta=='3' || $proveedor || $cedente || $deudor) && empty($bean->control_dynamics_365_c)) {
        $GLOBALS['log']->fatal('***********ENTRA CONDICION PARA CONSUMIR DYNAMICS*************');
          //Consumir servicio de dynamics, declarado en custom api
          require_once("custom/clients/base/api/Dynamics365.php");
          $apiDynamics= new Dynamics365();
          $body=array('accion'=>$bean->id);
          $response=$apiDynamics->setRequestDynamics(null,$body);

          //Save result
          $bean->control_dynamics_365_c=$response[0];
          global $db;
          $update = "update accounts_cstm set
            control_dynamics_365_c='{$response[0]}'
            where id_c = '{$bean->id}'";
          $updateExecute = $db->query($update);

      }

      //Condición para integrar con servicio de Cuentas por pagar
      if(($tipo_cuenta=='5' || $tipo_cuenta=='3' || $proveedor || $cedente || $deudor) && empty($bean->id_cpp_365_chk_c)) {
        $GLOBALS['log']->fatal('***********ENTRA CONDICION PARA CONSUMIR Cuentas por pagar*************');
          //Consumir servicio de dynamics, declarado en custom api
          require_once("custom/clients/base/api/Dynamics365.php");
          $apiDynamics= new Dynamics365();
          $body=array('accion'=>$bean->id);
          $response=$apiDynamics->setRequestDynamics(null,$body);
      }

  }
}
