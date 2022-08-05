<?php
    array_push($job_strings, 'tareas_vencidas');

    function tareas_vencidas()
    {
    	// Busca tareas vencidas no completadas
        $query="select a.id, b.ayuda_asesor_cp_c from tasks a, tasks_cstm b where a.id = b.id_c and a.date_due < now() and a.status <> 'Completed' and a.status <> 'Atrasada' and a.status <> 'Exitoso' and a.status <> 'No Exitoso' and a.deleted = 0";
        $result = $GLOBALS['db']->query($query);
        while($row = $GLOBALS['db']->fetchByAssoc($result))
        {
            $id = $row['id'];
			if($row['ayuda_asesor_cp_c'])
			{
				$queryUpdate="update tasks a, tasks_cstm b set a.status = 'Atrasada', b.atrasada_c = 'Ayuda Atrasada' where a.id = b.id_c and a.deleted = 0 and a.id = '{$id}'";
			}
			else
			{
				$queryUpdate="update tasks a, tasks_cstm b set a.status = 'Atrasada', b.atrasada_c = 'Atrasada' where a.id = b.id_c and a.deleted = 0 and a.id = '{$id}'";
			}
			$resultUpdate = $GLOBALS['db']->query($queryUpdate);
        }
		return true;
    }
