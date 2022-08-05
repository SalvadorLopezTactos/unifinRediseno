<?php
/**
 * User: salvadorlopez@tactos.com.mx
 * Date: 26/03/20
 */
array_push($job_strings, 'upload_file_googleads');

function upload_file_googleads(){

    global $sugar_config;

    $GLOBALS['log']->fatal('------------------------');//------------------------------------
    $GLOBALS['log']->fatal('DISPARA JOB PARA SUBIR CSV:');//------------------------------------
    set_include_path(get_include_path() . PATH_SEPARATOR . 'custom/aux_libraries/phpseclib1.0.18');
    require_once('Net/SFTP.php');

    //$host = '172.26.1.48';
    //$port = '22';
    //$username = 'userftp';
    //$password = 'Us3rFtP#.';

    $host = $sugar_config['host_sftp'];
    $port = $sugar_config['host_port'];
    $username = $sugar_config['host_user'];
    $password = $sugar_config['host_pwd'];
    $leads_calidad = "custom/plantillaCSV/leads_calidad.csv";
	$leads_no_calidad = "custom/plantillaCSV/leads_no_calidad.csv";
    date_default_timezone_set('America/Mexico_City');
    $fecha= date('Y').date('m').date('d').date('h').date('m').date('s');

    //Path en donde se guardará el archivo por sftp
    $path_unifin=$sugar_config['path_unifin'];

    if (file_exists($leads_calidad) || file_exists($leads_no_calidad)) {
        $sftp = new Net_SFTP($host, $port);
		$GLOBALS['log']->fatal('------------ENTRA SFTP------------');
        if ( $sftp->login($username, $password) ) {
            $GLOBALS['log']->fatal('------------CONEXIÓN SFTP EXITOSA------------');
            $success = $sftp->put(
                $path_unifin.'/leads_calidad.csv',
                $leads_calidad,
                NET_SFTP_LOCAL_FILE
            );
            $success = $sftp->put(
                $path_unifin.'/leads_no_calidad.csv',
                $leads_no_calidad,
                NET_SFTP_LOCAL_FILE
            );
            //Limpiando el archivo plantilla y dejando únicamente las cabeceras
            $leads_calidad = fopen("custom/plantillaCSV/leads_calidad.csv","w");
            fwrite($leads_calidad, 'Parameters:TimeZone=America/Mexico_City,,,,'.PHP_EOL);
            fwrite($leads_calidad, 'Email,Phone Number,Conversion Name,Conversion Time,Conversion Value,Conversion Currency'.PHP_EOL);
            fclose($leads_calidad);
            $leads_no_calidad = fopen("custom/plantillaCSV/leads_no_calidad.csv","w");
            fwrite($leads_no_calidad, 'Parameters:TimeZone=America/Mexico_City,,,,'.PHP_EOL);
            fwrite($leads_no_calidad, 'Email,Phone Number,Conversion Name,Conversion Time,Conversion Value,Conversion Currency'.PHP_EOL);
            fclose($leads_no_calidad);
        } else {
            $GLOBALS['log']->fatal('Conexión SFTP fallida:');//------------------------------------
        }
    }

    $GLOBALS['log']->fatal('-----------Termina subida de csv por SFTP-----------');
    return true;
}