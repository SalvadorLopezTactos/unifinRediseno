<?php
    array_push($job_strings, 'reasignacsv');

    function reasignacsv()
    {
    	// Busca notificaciones con levadmin
		$beanQuery = BeanFactory::newBean('TCT2_Notificaciones');
		$sugarQueryOP = new SugarQuery();
		$sugarQueryOP->select(array('id', 'name', 'created_by', 'ejecutado_c', 'actual_c'));
		$sugarQueryOP->from($beanQuery);
		$sugarQueryOP->where()->equals('ejecutado_c','1');
		$sugarQueryOP->where()->equals('created_by','1');
    $sugarQueryOP->where()->notEquals('actual_c','');
		$resultOP = $sugarQueryOP->execute();
		$countOP = count($resultOP);
		for($current=0; $current < $countOP; $current++)
		{
			$beanNoti = BeanFactory::retrieveBean('TCT2_Notificaciones', $resultOP[$current]['id']);
			$beanNoti->created_by = $resultOP[$current]['actual_c'];
			$beanNoti->ejecutado_c = 0;
			$beanNoti->save();
		}
		return true;
    }