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
    $file = "custom/plantillaCSV/clientes_lv.csv";
    date_default_timezone_set('America/Mexico_City');
    $fecha= date('Y').date('m').date('d').date('h').date('m').date('s');

    //Path en donde se guardará el archivo por sftp
    $path_unifin=$sugar_config['path_unifin'];
    $path_historicos=$sugar_config['path_historicos'];


    if (file_exists($file)) {
        $sftp = new Net_SFTP($host, $port);

        if ( $sftp->login($username, $password) ) {
            $GLOBALS['log']->fatal('------------CONEXIÓN SFTP EXITOSA------------');
            $success = $sftp->put(
                $path_unifin.'/conversiones_unifin.csv',
                $file,
                NET_SFTP_LOCAL_FILE
            );

            $success = $sftp->put(
                $path_historicos.'/conversiones_unifin_'.$fecha.'.csv',
                $file,
                NET_SFTP_LOCAL_FILE
            );

            //Limpiando el archivo plantilla y dejando únicamente las cabeceras
            $file = fopen("custom/plantillaCSV/clientes_lv.csv","w");
            fwrite($file, 'Parameters:TimeZone=America/Mexico_City,,,,'.PHP_EOL);
            fwrite($file, 'Google Click ID,Conversion Name,Conversion Time,Conversion Value,Conversion Currency'.PHP_EOL);
            fclose($file);

        } else {
            $GLOBALS['log']->fatal('Conexión SFTP fallida:');//------------------------------------
        }

    }

    $GLOBALS['log']->fatal('-----------Termina subida de csv por SFTP-----------');
    return true;

}