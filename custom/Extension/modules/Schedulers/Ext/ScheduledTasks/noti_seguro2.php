<?php
//add the job key to the list of job strings
array_push($job_strings, 'noti_seguro2');

function noti_seguro2()
{
    /*
    1.- Seguros próximo a vencer Leasing
    */
    // Busca seguros proximos a vencer de Leasing
    $next60days = date('Y-m-d', strtotime("+60 days"));
    $beanQuery = BeanFactory::newBean('tct02_Resumen');
    $sugarQueryOP = new SugarQuery();
    $sugarQueryOP->select(array('id', 'name', 'vencimiento_seguro_futuro_c', 'renovacion_seguro_leasing_c'));
    $sugarQueryOP->from($beanQuery);
    $sugarQueryOP->where()->equals('vencimiento_seguro_futuro_c', $next60days);
    $resultOP = $sugarQueryOP->execute();
    $countOP = count($resultOP);
    for ($current = 0; $current < $countOP; $current++) {
        //Obtiene valores del cliente
        $beanAcct = BeanFactory::retrieveBean('Accounts', $resultOP[$current]['id']);
        $persona = $beanAcct->name;
        //Recupera seguros por vencer
        $mensaje = '<br/>' . $resultOP[$current]['renovacion_seguro_leasing_c'];
        //Crea Notificacion
        $notification_bean = BeanFactory::getBean("Notifications");
        $notification_bean->name = 'Renovación de Seguro de ' . $persona;
        $notification_bean->description = 'ALERTA: El seguro de ' . $persona . ' vencerá dentro de 2 meses.<br/>Leasing/Anexos son:<br/>' . $mensaje;
        $notification_bean->parent_id = $resultOP[$current]['id'];
        $notification_bean->parent_type = 'Accounts';
        $notification_bean->assigned_user_id = $beanAcct->user_id_c;
        $notification_bean->severity = "alert";
        $notification_bean->is_read = 0;
        $notification_bean->save();

        //Crea Notificacion RM
        $notification_RM = BeanFactory::getBean("Notifications");
        $notification_RM->name = 'Renovación de Seguro de ' . $persona;
        $notification_RM->description = 'ALERTA: El seguro de ' . $persona . ' vencerá dentro de 2 meses.<br/>Leasing/Anexos son:<br/>' . $mensaje;
        $notification_RM->parent_id = $resultOP[$current]['id'];
        $notification_RM->parent_type = 'Accounts';
        $notification_RM->assigned_user_id = $beanAcct->user_id8_c;
        $notification_RM->severity = "alert";
        $notification_RM->is_read = 0;
        $notification_RM->save();

    }

    /*
    2.- Seguros próximo a vencer CA
    */
    // Busca seguros proximos a vencer de CA
    $beanQuery = BeanFactory::newBean('tct02_Resumen');
    $sugarQueryOP = new SugarQuery();
    $sugarQueryOP->select(array('id', 'name', 'vencimiento_seguro_futuro_ca_c', 'renovacion_seguro_ca_c'));
    $sugarQueryOP->from($beanQuery);
    $sugarQueryOP->where()->equals('vencimiento_seguro_futuro_ca_c', $next60days);
    $resultOP = $sugarQueryOP->execute();
    $countOP = count($resultOP);
    for ($current = 0; $current < $countOP; $current++) {
        //Obtiene valores del cliente
        $beanAcct = BeanFactory::retrieveBean('Accounts', $resultOP[$current]['id']);
        $persona = $beanAcct->name;
        //Recupera seguros por vencer
        $mensaje = '<br/>' . $resultOP[$current]['renovacion_seguro_ca_c'];
        //Crea Notificacion
        $notification_bean = BeanFactory::getBean("Notifications");
        $notification_bean->name = 'Renovación de Seguro de ' . $persona;
        $notification_bean->description = 'ALERTA: El seguro de ' . $persona . ' vencerá dentro de 2 meses.<br/>CA/Contratos son:<br/>' . $mensaje;
        $notification_bean->parent_id = $beanAcct->id;
        $notification_bean->parent_type = 'Accounts';
        $notification_bean->assigned_user_id = $beanAcct->user_id2_c;
        $notification_bean->severity = "alert";
        $notification_bean->is_read = 0;
        $notification_bean->save();

        //Crea Notificacion RM
        $notification_RM = BeanFactory::getBean("Notifications");
        $notification_RM->name = 'Renovación de Seguro de ' . $persona;
        $notification_RM->description = 'ALERTA: El seguro de ' . $persona . ' vencerá dentro de 2 meses.<br/>CA/Contratos son:<br/>' . $mensaje;
        $notification_RM->parent_id = $beanAcct->id;
        $notification_RM->parent_type = 'Accounts';
        $notification_RM->assigned_user_id = $beanAcct->user_id8_c;
        $notification_RM->severity = "alert";
        $notification_RM->is_read = 0;
        $notification_RM->save();
    }
    return true;
}
