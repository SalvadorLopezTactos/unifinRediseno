<?php

class ctaBancaria_Dynamics365
{
    public function IntegraDynamicsCreate($bean = null, $event = null, $args = null)
    {
        /* 
          * Integración con Dynamics para envío de cuentas bancarias
          * 1) Creación
          * tiene clabe interbancaria
        */
        
        if(!$args['isUpdate'] && !empty($bean->clabe) ) {
            //Invoca petición para envío de cuenta bancaria
            $this->consumoDynamics($bean);
        }
    }
    
    public function IntegraDynamicsUpdate($bean = null, $event = null, $args = null)
    {
        /* 
          * Integración con Dynamics para envío de cuentas bancarias
          * 2) Actualziación de banco o cuenta interbancaria:
          * Tiene clabe, tiene banco, tiene id(actualización)
        */
        
        if( !empty($bean->clabe) && !empty($bean->banco) && !empty($bean->id) && ($bean->fetched_row['clabe'] != $bean->clabe  || $bean->fetched_row['banco'] != $bean->banco) ) {
            //Invoca petición para envío de cuenta bancaria
            $this->consumoDynamics($bean);
        }
    }

    public function consumoDynamics($bean = null, $event = null, $args = null){
          //Consumir servicio de dynamics, declarado en custom api
          $GLOBALS['log']->fatal('Dynamics 365: Genera petición para integrar cuenta bancaria: ' . $bean->id);
          require_once("custom/clients/base/api/Dynamics365.php");
          $apiDynamics= new Dynamics365();
          $body=array(
            'accion'=>$bean->cta_cuentas_bancarias_accountsaccounts_ida,
            'idCuentaBancaria'=>$bean->id,
          );
          $response=$apiDynamics->setRequestDynamics(null,$body);
    }
}
