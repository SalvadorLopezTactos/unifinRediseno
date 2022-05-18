<?php

array_push($job_strings, 'casos_estatus');
function casos_estatus()
{
    global $db;
    $error = false;
        
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job casos_estatus: Inicia');

    global $db;
    $sql = "SELECT id, name,status,follow_up_datetime,CURDATE() hoy, DATE_FORMAT(follow_up_datetime, '%Y-%m-%d ')  as dd
    from cases where follow_up_datetime is not null
	and (status = 1 or status = 2 or status = 5) and (curdate() >= DATE_FORMAT(follow_up_datetime, '%Y-%m-%d '))";
    $result = $db->query($sql);
    
    while ($row = $db->fetchByAssoc($result)) {
        $beanCase = null;
        $beanCase = BeanFactory::retrieveBean('Cases', $row['id'] ,array('disable_row_level_security' => true));
        $GLOBALS['log']->fatal("*id".$beanCase->id);
        $GLOBALS['log']->fatal("*id".$beanCase->name);
        $beanCase->status = '4';
        $beanCase->save();
    }
      
    $GLOBALS['log']->fatal('Job casos_estatus: Fin');
}