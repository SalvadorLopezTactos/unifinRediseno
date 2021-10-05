<?php
class opp_tasks_class
{
    function opp_tasks_funct($bean, $event, $arguments)
    {
		if(empty($bean->fetched_row['id']))
		{
			//Busca Tareas sin asociar a una solicitud
			global $db;
			$asesor = $bean->assigned_user_id;
			$cuenta = $bean->account_id;
			$query = "select puestousuario_c from users_cstm where id_c = '$asesor'";
			$result = $db->query($query);
			$row = $db->fetchByAssoc($result);
			$puesto = $row['puestousuario_c'];
			if($puesto == 5 || $puesto == 11 || $puesto == 16 || $puesto == 53 || $puesto == 54)
			{
				$query = "select a.id from tasks a, tasks_cstm b where a.id = b.id_c and a.deleted = 0 and a.parent_id = '$cuenta'
						 and b.fecha_calificacion_c >= CURDATE() - INTERVAL 3 MONTH and a.id not in
						 (select tasks_opportunities_1tasks_ida from tasks_opportunities_1_c where deleted = 0) order by b.fecha_calificacion_c desc limit 1";
				$result = $db->query($query);
				$row = $db->fetchByAssoc($result);
				$tarea = $row['id'];
				if(!empty($tarea))
				{
					$beanTarea = BeanFactory::retrieveBean('Tasks', $tarea, array('disable_row_level_security' => true));
					$beanTarea->tasks_opportunities_1opportunities_idb = $bean->id;
					$beanTarea->solicitud_alta_c = 0;
					$beanTarea->save();
				}
			}
		}
    }
}
