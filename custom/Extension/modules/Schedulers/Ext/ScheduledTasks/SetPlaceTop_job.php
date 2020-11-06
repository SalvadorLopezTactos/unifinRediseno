<?php 

array_push($job_strings, 'SetPlaceTop_job');
require_once('include/SugarQuery/SugarQuery.php');

function SetPlaceTop_job(){
	//Inicia ejecución
	$GLOBALS['log']->fatal('Job field_on_top Inicia');
	$module = 'Users';
	$record_id = '';
	
	$query = "select id, user_name from users where status = 'Active' and deleted = 0";
	$result = $GLOBALS['db']->query($query);
	while($row = $GLOBALS['db']->fetchByAssoc($result) )
	{
		$id = $row['id'];
		//$contents = $row['contents'];
		//$GLOBALS['log']->fatal('user_name'.$row['user_name']);
		$bean = BeanFactory::getBean($module, $id);
		//$GLOBALS['log']->fatal('contents',$bean->getPreference);
		$bean->setPreference('field_name_placement','field_on_top'); //set some settings to SESSION
		//$GLOBALS['log']->fatal('contents','field_on_side');
		$bean->savePreferencesToDB();
	
	}
	
	$GLOBALS['log']->fatal('Job Field on top: Termina');
	return true;
}