<?php

array_push($job_strings, 'report_backlog_client_manager');
function report_backlog_client_manager()
{
            
    global $db;
    $error = false;
    
    $year = date("Y");
    $month = intval(date("m"));
    $values = [];
    while($month<13){
        array_push($values,strval($month));
        $month ++;
    }

    $chan = '"' .implode('","', $values) . '"';
    $GLOBALS['log']->fatal('Job reporte de backlog actualizacion de mes: Inicia');

    $sql = "SELECT content from saved_reports where id = '30be92e2-dc62-11ec-961d-509a4cc52cc3'";
    $content = $db->getOne($sql);

    $inicio = strrpos($content, 'mes') + 65;
    $fin = strrpos($content , '"12"]}}', ($inicio + 1) ) + 4 ;
    $meses = substr($content, $inicio ,($fin-$inicio));
    
    $content = substr_replace($content, $chan, $inicio, strlen($meses)); // I am very happy today.
    $GLOBALS['log']->fatal('content',$content);
    
    $upd = "UPDATE saved_reports SET content = '{$content}' WHERE id = '30be92e2-dc62-11ec-961d-509a4cc52cc3';";
    $db->query($upd);

    $GLOBALS['log']->fatal('Job reporte de backlog actualizacion de mes: Fin');

    return true;
}