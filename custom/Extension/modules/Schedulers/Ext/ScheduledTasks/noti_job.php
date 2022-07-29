<?php
//add the job key to the list of job strings
array_push($job_strings, 'noti_job');

function noti_job()
{
    // Busca operaciones proximas a vencer
    $next60days = date('Y-m-d', strtotime("+60 days"));
    $beanQuery = BeanFactory::newBean('Opportunities');
    $sugarQueryOP = new SugarQuery();
    $sugarQueryOP->select(array('id', 'name', 'fecha_estimada_cierre_c', 'tipo_producto_c', 'account_id'));
    $sugarQueryOP->from($beanQuery);
    $sugarQueryOP->where()->equals('fecha_estimada_cierre_c', $next60days);
    $sugarQueryOP->where()->equals('tipo_operacion_c', '2');
    $sugarQueryOP->where()->equals('tipo_de_operacion_c', 'LINEA_NUEVA');
    $resultOP = $sugarQueryOP->execute();
    $countOP = count($resultOP);
    for ($current = 0; $current < $countOP; $current++) {
        //Obtiene valores del cliente
        $beanAcct = BeanFactory::retrieveBean('Accounts', $resultOP[$current]['account_id']);
        $operacion = $resultOP[$current]['name'];
        $persona = $beanAcct->name;
        if ($resultOP[$current]['tipo_producto_c'] == 1) {
            $promotor = $beanAcct->user_id_c;
        }
        if ($resultOP[$current]['tipo_producto_c'] == 3) {
            $promotor = $beanAcct->user_id2_c;
        }
        if ($resultOP[$current]['tipo_producto_c'] == 4) {
            $promotor = $beanAcct->user_id1_c;
        }

        //Crea Notificacion
        $notification_bean = BeanFactory::getBean("Notifications");
        $notification_bean->name = 'Vencimiento de línea de crédito ' . $persona;
        $notification_bean->description = 'ALERTA: Te recordamos que la línea de crédito autorizada a tu cliente ' . $persona . ' vencerá dentro de 2 meses.';
        $notification_bean->parent_id = $resultOP[$current]['id'];
        $notification_bean->parent_type = 'Opportunities';
        $notification_bean->assigned_user_id = $promotor;
        $notification_bean->severity = "alert";
        $notification_bean->is_read = 0;
        $notification_bean->save();

        /** Crea Notificación RM  */

        $promotorRM = $beanAcct->user_id8_c;
        $notificationRM_bean = BeanFactory::getBean("Notifications");
        $notificationRM_bean->name = 'Vencimiento de línea de crédito ' . $persona;
        $notificationRM_bean->description = 'ALERTA: Te recordamos que la línea de crédito autorizada a tu cliente ' . $persona . ' vencerá dentro de 2 meses.';
        $notificationRM_bean->parent_id = $resultOP[$current]['id'];
        $notificationRM_bean->parent_type = 'Opportunities';
        $notificationRM_bean->assigned_user_id = $promotorRM;
        $notificationRM_bean->severity = "alert";
        $notificationRM_bean->is_read = 0;
        $notificationRM_bean->save();

    }
    return true;
}