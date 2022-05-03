<?php

array_push($job_strings, 'purge_audit_truncate');
function purge_audit_truncate()
{
    global $db;
    $error = false;
        
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job limpieza truncate: Inicia');

    $sql = "TRUNCATE TABLE activities;";
    $db->execute($sql);
    
    $sql = "TRUNCATE TABLE audit_events;";
    $db->execute($sql);

    $sql = "TRUNCATE TABLE tct_usersplatform_audit;";
    $db->execute($sql);
    
    $sql = "TRUNCATE TABLE job_queue_audit;";
    $db->execute($sql);
  
    $GLOBALS['log']->fatal('Job limpieza truncate: Fin');
}