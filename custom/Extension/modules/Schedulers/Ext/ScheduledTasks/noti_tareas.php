<?php
    array_push($job_strings, 'noti_tareas');

    function noti_tareas()
    {
    	// Busca tareas CAC
		$beanQuery = BeanFactory::newBean('Tasks');
		$sugarQuery = new SugarQuery();
		$sugarQuery->select(array('id', 'name', 'date_due', 'assigned_user_id'));
		$sugarQuery->from($beanQuery);
		$sugarQuery->where()->dateBetween('date_due', array(date("Y-m-d"),date("Y-m-d")));
		$sugarQuery->where()->notEquals('status','Completed');
		$sugarQuery->where()->notEquals('status','Exitoso');
		$sugarQuery->where()->notEquals('status','No Exitoso');		
		$sugarQuery->where()->equals('puesto_c',61);
		$result = $sugarQuery->execute();
		$cuenta = count($result);
		for($current=0; $current < $cuenta; $current++)
		{
			// Crea Notificación
			$notification_bean = BeanFactory::getBean("Notifications");
			$notification_bean->name = 'Atiende la tarea: '.$result[$current]['name'];
			$notification_bean->description = 'La tarea '.$result[$current]['name'].' vence el día de hoy, favor de atenderla';
			$notification_bean->parent_id = $result[$current]['id'];
			$notification_bean->parent_type = 'Tasks';
			$notification_bean->assigned_user_id = $result[$current]['assigned_user_id'];
			$notification_bean->severity = "alert";
			$notification_bean->is_read = 0;
			$notification_bean->save();
		}
		return true;
    }