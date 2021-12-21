<?php

array_push($job_strings, 'reprocesoREUS_job');
function reprocesoREUS_job()
{
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job reproceso REUS: Inicia');

    $query = "SELECT id_c FROM LEADS_CSTM where pendiente_reus_c = 1";
    //$GLOBALS['log']->fatal('query'.$query);
    $datos = [];    
    $result = $GLOBALS['db']->query($query);
    
    while($row = $GLOBALS['db']->fetchByAssoc($result) ){
        $var = [];
        
    }

    return true;
}