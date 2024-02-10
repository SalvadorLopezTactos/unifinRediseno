<?php

array_push($job_strings, 'backlog_seguros_ganadas_no_ganadas');

function backlog_seguros_ganadas_no_ganadas(){
    $GLOBALS['log']->fatal("COMIENZA JOB PARA OBTENER OPORTUNIDADES DE SEGURO GANADAS Y NO GANADAS");
    global $db;

    //Consulta los registros de OPORTUNIDAD DE SEGUROS que tengan relación Activa con Backlog Seguros y tengan la etapa de GANADA o NO GANADA
    $sqlSegurosBL = "SELECT t.tctbl_backlog_seguros_s_seguros_1tctbl_backlog_seguros_ida id_bl,s.id id_seguro
FROM s_seguros s
INNER JOIN tctbl_backlog_seguros_s_seguros_1_c t
ON s.id = t.tctbl_backlog_seguros_s_seguros_1s_seguros_idb
WHERE (s.etapa= '9' or s.etapa ='10') and s.deleted = 0
AND t.deleted = 0;";
    $queryResult = $db->query($sqlSegurosBL);

    $GLOBALS['log']->fatal("Se obtuvieron ". $queryResult->num_rows. " registros de Seguros que tienen relación activa con Backlog en Etapa GANADA o NO GANADA");
    

    while ($row = $db->fetchByAssoc($queryResult)) {
        //En caso de encontrar Backlogs de seguros que no son Ganados o No Ganados y además tienen un mes y año anteriores al actual, se establece el mes y anio actual al registro
        $id_seguro = $row['id_seguro'];

        $GLOBALS['log']->fatal("PROCESANDO EL ID DE SEGURO:" .$id_seguro);

        $bean_seguro = BeanFactory::getBean('S_seguros', $id_seguro, array('disable_row_level_security' => true));

        if ($bean_seguro->load_relationship('tctbl_backlog_seguros_s_seguros_1')) {

            $bean_seguro->tctbl_backlog_seguros_s_seguros_1->delete($bean_seguro->tctbl_backlog_seguros_s_segurostctbl_backlog_seguros_ida);

        }

        $bean_seguro->save();

        
    }

    return true;
}
