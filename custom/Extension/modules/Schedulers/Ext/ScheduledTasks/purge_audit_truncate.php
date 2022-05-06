<?php

array_push($job_strings, 'purge_audit_truncate');
function purge_audit_truncate()
{
    global $db;
    $error = false;
        
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job limpieza truncate: Inicia');

    $sql = "TRUNCATE TABLE activities;";
    $GLOBALS['db']->query($sql);
    
    $sql = "TRUNCATE TABLE audit_events;";
    $GLOBALS['db']->query($sql);

    $sql = "TRUNCATE TABLE tct_usersplatform_audit;";
    $GLOBALS['db']->query($sql);
    
    $sql = "TRUNCATE TABLE job_queue_audit;";
    $GLOBALS['db']->query($sql);
  
    $GLOBALS['log']->fatal('Job limpieza truncate: Fin');

    return true;
}