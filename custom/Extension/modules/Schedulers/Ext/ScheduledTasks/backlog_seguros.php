<?php

array_push($job_strings, 'backlog_seguros');

function backlog_seguros(){
    $GLOBALS['log']->fatal("COMIENZA JOB PARA OBTENER BACKLOG DE SEGUROS");
    global $db;
    $mes_actual = date("n");
    $anio_actual = date("Y");
    //Obtener todos los backlogs
    //$sqlBl = "SELECT id,anio,mes,etapa FROM TCTBL_Backlog_Seguros WHERE deleted = 0";
    $sqlBl = "SELECT *
FROM tctbl_backlog_seguros
WHERE ( anio < YEAR(NOW()) OR (anio = YEAR(NOW()) AND mes < MONTH(NOW())) )
AND etapa != '9' and etapa != '10';";
    $queryResult = $db->query($sqlBl);

    $GLOBALS['log']->fatal("Se obtuvieron ". $queryResult->num_rows. " registros de Backlog");
    

    while ($row = $db->fetchByAssoc($queryResult)) {
        //En caso de encontrar Backlogs de seguros que no son Ganados o No Ganados y además tienen un mes y año anteriores al actual, se establece el mes y anio actual al registro
        $id_bl = $row['id'];
        $mes_bl = $row['mes'];
        $anio_bl = $row['anio'];
        $etapa = $row['etapa'];

        $bean_bl = BeanFactory::getBean('TCTBL_Backlog_Seguros', $id_bl, array('disable_row_level_security' => true));

        $bean_bl->mes = $mes_actual;
        $bean_bl->anio = $anio_actual;

        $bean_bl->save();

        $GLOBALS['log']->fatal("SE ACTUALIZA MES Y ANIO DEL BACKLOG DE SEGUROS CON EL ID: ".$bean_bl->id);

        
    }

    return true;
}
