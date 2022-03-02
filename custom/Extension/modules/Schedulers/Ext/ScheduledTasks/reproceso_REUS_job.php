<?php

array_push($job_strings, 'reproceso_REUS_job');
function reproceso_REUS_job()
{
    //Se obtienen valores del config, ip
    global $sugar_config, $db;
    $error = false;
        
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job reproceso REUS: Inicia');
    $callApi = new UnifinAPI(); //clase con las funciones de REUS
    $respuesta = array();

    //recupera leads con pendiente REUS
    $query = "SELECT id , last_name , deleted from leads where id in ( 
    SELECT id_c as id FROM LEADS_CSTM where pendiente_reus_c = 1 and subtipo_registro_c <> 4
    ) and deleted = 0";
    $result = $GLOBALS['db']->query($query);
    while($row = $GLOBALS['db']->fetchByAssoc($result) ){
        $pila = array(
            'id' => $row['id'],
            'tipo'  => "lead"
        );
        array_push($respuesta, $pila);
    }
    //recupera cuentas con pendiente REUS
    $query = "SELECT id_c as id FROM ACCOUNTS_CSTM where pendiente_reus_c = 1";
    $result2 = $GLOBALS['db']->query($query);
    while($row = $GLOBALS['db']->fetchByAssoc($result2) ){
        $pila = array(
            'id' => $row['id'],
            'tipo'  => "cuenta"
        );
        array_push($respuesta, $pila);
    }
    
    $GLOBALS['log']->fatal('result_reus',count($respuesta));

    $mailLead = false;
    foreach($respuesta as $valor ){
        try{
        if($valor['tipo'] == 'lead'){
            $bean = BeanFactory::retrieveBean('Leads', $valor['id']);
        }else{
            $bean = BeanFactory::retrieveBean('Accounts', $valor['id']);
        }
        $bean->save();
        } catch (Exception $e) {
            $GLOBALS['log']->fatal('result_reus_excepcion',$e->messageLabel);
        }
    }

    $GLOBALS['log']->fatal('Job reproceso REUS: Fin');
    return true;
}