<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'ejecutado');

    function ejecutado()
    {
    	// Busca notificaciones sin ejecutar
		$beanQuery = BeanFactory::newBean('TCT2_Notificaciones');
		$sugarQueryOP = new SugarQuery();
		$sugarQueryOP->select(array('id', 'name', 'ejecutado_c'));
		$sugarQueryOP->from($beanQuery);
		$sugarQueryOP->where()->equals('ejecutado_c','0');
		$resultOP = $sugarQueryOP->execute();
		$countOP = count($resultOP);
		for($current=0; $current < $countOP; $current++)
		{
			//Obtiene valores del cliente
			$beanNoti = BeanFactory::retrieveBean('TCT2_Notificaciones', $resultOP[$current]['id']);
			$beanNoti->ejecutado_c = 1;
			$beanNoti->save();
		}
		return true;
    }