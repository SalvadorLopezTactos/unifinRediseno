<?php
//add the job key to the list of job strings
array_push($job_strings, 'noti_seguro');

function noti_seguro()
{
    /*
    1.- Seguros vencidos Leasing
    */
    // Busca seguros vencidos Leasing
    $hoy = date('Y-m-d');
    $beanQuery = BeanFactory::newBean('tct02_Resumen');
    $sugarQueryOP = new SugarQuery();
    $sugarQueryOP->select(array('id', 'name', 'vencimiento_seguro_dia_c', 'vencimiento_seguro_leasing_c'));
    $sugarQueryOP->from($beanQuery);
    $sugarQueryOP->where()->equals('vencimiento_seguro_dia_c', $hoy);
    $resultOP = $sugarQueryOP->execute();
    $countOP = count($resultOP);
    for ($current = 0; $current < $countOP; $current++) {
        //Obtiene valores del cliente
        $beanAcct = BeanFactory::retrieveBean('Accounts', $resultOP[$current]['id']);
        $persona = $beanAcct->name;
        //Recupera seguros vencidos
        $mensaje = '<br/>' . $resultOP[$current]['vencimiento_seguro_leasing_c'];
        //Crea Notificacion al Promotor Leasing
        $notification_bean = BeanFactory::getBean("Notifications");
        $notification_bean->name = 'URGENTE: Seguro vencido de ' . $persona;
        $notification_bean->description = 'ALERTA: El seguro de ' . $persona . ' está vencido.<br/>Leasing/Anexos son:<br/>' . $mensaje;
        $notification_bean->parent_id = $beanAcct->id;
        $notification_bean->parent_type = 'Accounts';
        $notification_bean->assigned_user_id = $beanAcct->user_id_c;
        $notification_bean->severity = "alert";
        $notification_bean->is_read = 0;
        $notification_bean->save();

        //Crea Notificacion al Promotor RM
        $notification_RM1 = BeanFactory::getBean("Notifications");
        $notification_RM1->name = 'URGENTE: Seguro vencido de ' . $persona;
        $notification_RM1->description = 'ALERTA: El seguro de ' . $persona . ' está vencido.<br/>Leasing/Anexos son:<br/>' . $mensaje;
        $notification_RM1->parent_id = $beanAcct->id;
        $notification_RM1->parent_type = 'Accounts';
        $notification_RM1->assigned_user_id = $beanAcct->user_id8_c;
        $notification_RM1->severity = "alert";
        $notification_RM1->is_read = 0;
        $notification_RM1->save();

        //Crea Notificacion al Director
        $User = new User();
        $User->retrieve($beanAcct->user_id_c);
        $jefe = $User->reports_to_id;
        $notification_bean = BeanFactory::getBean("Notifications");
        $notification_bean->name = 'URGENTE: Seguro vencido de ' . $persona;
        $notification_bean->description = 'ALERTA: El seguro de ' . $persona . ' está vencido.<br/>Leasing/Anexos son:<br/>' . $mensaje;
        $notification_bean->parent_id = $beanAcct->id;
        $notification_bean->parent_type = 'Accounts';
        $notification_bean->assigned_user_id = $jefe;
        $notification_bean->severity = "alert";
        $notification_bean->is_read = 0;
        $notification_bean->save();

    }

    /*
    2.- Seguros vencidos CA
    */
    // Busca seguros vencidos CA
    $beanQuery = BeanFactory::newBean('tct02_Resumen');
    $sugarQueryOP = new SugarQuery();
    $sugarQueryOP->select(array('id', 'name', 'vencimiento_seguro_dia_ca_c', 'vencimiento_seguro_ca_c'));
    $sugarQueryOP->from($beanQuery);
    $sugarQueryOP->where()->equals('vencimiento_seguro_dia_ca_c', $hoy);
    $resultOP = $sugarQueryOP->execute();
    $countOP = count($resultOP);
    for ($current = 0; $current < $countOP; $current++) {
        //Obtiene valores del cliente
        $beanAcct = BeanFactory::retrieveBean('Accounts', $resultOP[$current]['id']);
        $persona = $beanAcct->name;
        //Recupera seguros vencidos
        $mensaje = '<br/>' . $resultOP[$current]['vencimiento_seguro_ca_c'];
        //Crea Notificacion al Promotor CA
        $notification_bean = BeanFactory::getBean("Notifications");
        $notification_bean->name = 'URGENTE: Seguro vencido de ' . $persona;
        $notification_bean->description = 'ALERTA: El seguro de ' . $persona . ' está vencido.<br/>CA/Contratos son:<br/>' . $mensaje;
        $notification_bean->parent_id = $beanAcct->id;
        $notification_bean->parent_type = 'Accounts';
        $notification_bean->assigned_user_id = $beanAcct->user_id2_c;
        $notification_bean->severity = "alert";
        $notification_bean->is_read = 0;
        $notification_bean->save();

        //Crea Notificacion al Promotor RM
        $notification_bean = BeanFactory::getBean("Notifications");
        $notification_bean->name = 'URGENTE: Seguro vencido de ' . $persona;
        $notification_bean->description = 'ALERTA: El seguro de ' . $persona . ' está vencido.<br/>CA/Contratos son:<br/>' . $mensaje;
        $notification_bean->parent_id = $beanAcct->id;
        $notification_bean->parent_type = 'Accounts';
        $notification_bean->assigned_user_id = $beanAcct->user_id8_c;
        $notification_bean->severity = "alert";
        $notification_bean->is_read = 0;
        $notification_bean->save();

        //Crea Notificacion al Director
        $User = new User();
        $User->retrieve($beanAcct->user_id2_c);
        $jefe = $User->reports_to_id;
        $notification_bean = BeanFactory::getBean("Notifications");
        $notification_bean->name = 'URGENTE: Seguro vencido de ' . $persona;
        $notification_bean->description = 'ALERTA: El seguro de ' . $persona . ' está vencido.<br/>CA/Contratos son:<br/>' . $mensaje;
        $notification_bean->parent_id = $beanAcct->id;
        $notification_bean->parent_type = 'Accounts';
        $notification_bean->assigned_user_id = $jefe;
        $notification_bean->severity = "alert";
        $notification_bean->is_read = 0;
        $notification_bean->save();
    }

    return true;
}
