<?php

array_push($job_strings, 'purge_audit_doce');
function purge_audit_doce()
{
    global $db;
    $error = false;
        
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job limpieza doce: Inicia');

    $sql = "DELETE from calls_audit WHERE date_created < DATE_SUB(now(), INTERVAL 12 MONTH);";
    $GLOBALS['db']->query($sql);
  
    $GLOBALS['log']->fatal('Job limpieza doce: Fin');
    
    return true;
}