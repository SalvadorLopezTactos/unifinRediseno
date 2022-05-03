<?php

array_push($job_strings, 'purge_audit_seis');
function purge_audit_seis()
{
    global $db;
    $error = false;
        
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job limpieza seis: Inicia');

    $sql = "DELETE from pmse_bpm_flow WHERE date_entered < DATE_SUB(now(), INTERVAL 6 MONTH);";
    $GLOBALS['db']->query($sql);
  
    $GLOBALS['log']->fatal('Job limpieza seis: Fin');
    
    return true;
}