<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'noti_libera');

    function noti_libera()
    {
    	// Busca liberaciones vencidas
		$last21days = date('Y-m-d', strtotime("-21 days"));
		$beanQuery = BeanFactory::newBean('tct02_Resumen');
		$sugarQueryOP = new SugarQuery();
		$sugarQueryOP->select(array('id', 'name', 'fecha_liberacion_leasing_c'));
		$sugarQueryOP->from($beanQuery);
		$sugarQueryOP->where()->equals('fecha_liberacion_leasing_c',$last21days);
		$resultOP = $sugarQueryOP->execute();
		$countOP = count($resultOP);
		for($current=0; $current < $countOP; $current++)
		{
			//Obtiene valores del cliente
			$beanAcct = BeanFactory::retrieveBean('Accounts', $resultOP[$current]['id']);
			$persona = $beanAcct->name;
			$notification_bean = BeanFactory::getBean("Notifications");
			$notification_bean->name = 'Contacta a tu cliente '.$persona;
			$notification_bean->description = 'ALERTA: La liberación de tu cliente '.$persona.' se hizo hace 3 semanas.';
			$notification_bean->parent_id = $beanAcct->id;
			$notification_bean->parent_type = 'Accounts';
			$notification_bean->assigned_user_id = $beanAcct->user_id_c;
			$notification_bean->severity = "alert";
			$notification_bean->is_read = 0;
			$notification_bean->save();

			/** Notificación RM */
            $notification_RM = BeanFactory::getBean("Notifications");
            $notification_RM->name = 'Contacta a tu cliente '.$persona;
            $notification_RM->description = 'ALERTA: La liberación de tu cliente '.$persona.' se hizo hace 3 semanas.';
            $notification_RM->parent_id = $beanAcct->id;
            $notification_RM->parent_type = 'Accounts';
            $notification_RM->assigned_user_id = $beanAcct->user_id8_c;
            $notification_RM->severity = "alert";
            $notification_RM->is_read = 0;
            $notification_RM->save();
		}
      return true;
    }