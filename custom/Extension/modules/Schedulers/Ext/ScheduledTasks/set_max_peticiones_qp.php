<?php 

array_push($job_strings, 'set_max_peticiones_qp');

function set_max_peticiones_qp(){
    //Inicia ejecución
    require_once 'modules/Configurator/Configurator.php';
    $GLOBALS['log']->fatal('Job Question Pro: Incia proceso para reiniciar contador de peticiones');
    
    $configuratorObj = new Configurator();
	$configuratorObj->loadConfig();
	$configuratorObj->config['qp_peticiones'] = 0;
	$configuratorObj->saveConfig();
    
	$GLOBALS['log']->fatal('Job Question Pro: Termina proceso para reiniciar contador de peticiones');
	return true;
}