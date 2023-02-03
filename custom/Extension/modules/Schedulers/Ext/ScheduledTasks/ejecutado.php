<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'ejecutado');

    function ejecutado()
    {
    	$GLOBALS['log']->fatal("Inicia Job para actualizar ejecutado");
		$beanQuery = "SELECT n.id,n.name,nc.ejecutado_c FROM tct2_notificaciones n INNER JOIN tct2_notificaciones_cstm nc ON n.id=nc.id_c WHERE nc.ejecutado_c=0 and n.deleted=0";

		$resultNoti = $GLOBALS['db']->query($beanQuery);

            while ($rowNoti = $GLOBALS['db']->fetchByAssoc($resultNoti)) {
                $beanNoti = BeanFactory::retrieveBean('TCT2_Notificaciones', $rowNoti['id']);
				$beanNoti->ejecutado_c = 1;
				$beanNoti->save();
            }

		return true;
    }