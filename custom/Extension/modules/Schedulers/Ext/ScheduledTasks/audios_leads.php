<?php

array_push($job_strings, 'audios_leads');
/**
 * Created by Adrian Arauz.
 * Date: 21/11/20
 * Time: 11:53 AM
 */

/*
* Funcionalidad: Integración SugarCRM - OneDrive
* 1.- Conectar al FTP y validar que haya archivos nuevos
* 2.- Validar audios en OneDrive 
* 3.- Generar Token
* 4.- Validar exiencia de folder Año
+ 5.- Iterar Audios recuperados y enviarlos
*/

    function audios_leads(){
        global $sugar_config;
        $iduser=$sugar_config['OneDrive_IDuser'];
        $parentFolder=$sugar_config['OneDrive_url_directorio'];
        /*
        * 1.-Conectar al FTP y validar que haya archivos nuevos
        */
        $GLOBALS['log']->fatal('INICIA JOB, CONEXION A FTP AUDIOS');

        set_include_path(get_include_path() . PATH_SEPARATOR . 'custom/aux_libraries/phpseclib1.0.18');
        require_once('Net/SFTP.php');
        // Asignacion de Variables 
        $host = $sugar_config['viciDial_sftp_host'];
        $port = $sugar_config['viciDial_sftp_port'];
        $username = $sugar_config['viciDial_sftp_usr'];
        $password = $sugar_config['viciDial_sftp_pass'];
        $route= $sugar_config['viciDial_sftp_route'];
        

        //Conexion al FTP
        $sftp = new Net_SFTP($host, $port);
        if ( $sftp->login($username, $password) ) {
            $GLOBALS['log']->fatal('CONEXIÓN SFTP EXITOSA');
            //Variables año, mes dia
            $anio=date("Y");
            $mes=date("m");
            $dia=date("d");
            $ruta=$route.'/'.$anio.'/'.$mes.'/'.$dia;
            $directorio=$sftp->nlist($ruta);
            $GLOBALS['log']->fatal($anio);
            $GLOBALS['log']->fatal($mes);
            $GLOBALS['log']->fatal($dia);
            $files=0;

            $exe_variables=get_one_drive_config();
            
            //$GLOBALS['log']->fatal("Token obtenido :".$exe_variables['token']);
            $GLOBALS['log']->fatal(print_r($directorio,true));

            $exe_token=get_token($exe_variables);
    
            if (!empty($directorio)){
                //hacer consulta a drive para ver si existe el directorio AÑO en OneDrive
                $consult_idY = consultDrive($exe_variables,$parentFolder,$anio,$iduser);

                //Creacion del directorio año
                if($consult_idY==0){
                    $GLOBALS['log']->fatal("No existe directorio, creara directorio año");
                    $consult_idY = createfolder($exe_variables,$iduser,$parentFolder,$anio);
                }
                 //hacer consulta a drive para ver si existe el directorio MES en OneDrive
                 $consult_idM = consultDrive($exe_variables,$consult_idY,$mes,$iduser);
                if($consult_idM==0){
                    $GLOBALS['log']->fatal("No existe directorio, creara directorio mes");
                    $consult_idM = createfolder($exe_variables,$iduser,$consult_idY,$mes);
                }
               
                foreach($directorio as $file){
                    if (strlen($file)>2) {
                        $files++;
                        $GLOBALS['log']->fatal("Archivos en el directorio :".$files);
                        $contentfile=$sftp->get($route.'/'.$anio.'/'.$mes.'/'.$dia.'/'.$file);
                        //$GLOBALS['log']->fatal("Valores de ConsultDrive");
                        //$GLOBALS['log']->fatal(print_r($consult_idY, true));
                        //$GLOBALS['log']->fatal("Archivo a subir :".$file);
                        $file_name=$file;
                        //comando para subir a oneDrive
                        $exe_upload=upload_audios($exe_variables,$file_name,$contentfile,$consult_idM,$iduser);
                    }
                }
            }
        }else{
            $GLOBALS['log']->fatal('CONEXIÓN SFTP FALLIDA');
        }
            //Sale de la funcion
            $GLOBALS['log']->fatal('FINALIZA JOB, CONEXION A FTP AUDIOS');
            return true;
    }

    function get_one_drive_config()
    {
        //$GLOBALS['log']->fatal("Inicia get_one_drive_config");
        //Define arreglo de configuración
        $OneDrive = array();
        $OneDrive['token']="";
        $OneDrive['expire_in']="";
        $OneDrive['tenant_id']="";
        $OneDrive['client_id']="";
        $OneDrive['client_secret']="";

        //Recupera información de instancia OneDrive
        global $db;
        $one_drive_query = "select * from config where category = 'OneDrive';";
        $queryResult = $db->query($one_drive_query);
        while ($row = $db->fetchByAssoc($queryResult)) {
            switch ($row['name']) {
                case "token":
                    $OneDrive['token']=$row['value'];
                    break;
                case "expire_in":
                    $OneDrive['expire_in']=$row['value'];
                    break;
                case "tenant_id":
                    $OneDrive['tenant_id']=$row['value'];
                    break;
                case "client_id":
                    $OneDrive['client_id']=$row['value'];
                    break;
                case "client_secret":
                    $OneDrive['client_secret']=$row['value'];
                    break;
            }
        }
        //$GLOBALS['log']->fatal("Sale get_one_drive_config");
        //Regresa configuración
        return $OneDrive;
    }

    function get_token($OneDrive)
    {   
        //$GLOBALS['log']->fatal("Inicia get_token");
        //Arma petición para token
        global $db,$current_user;
        $uri = 'https://login.microsoftonline.com/'.$OneDrive['tenant_id'].'/oauth2/v2.0/token';
        $data = 'grant_type=client_credentials&client_id='.$OneDrive['client_id'].'&client_secret='.$OneDrive['client_secret'].'&scope=https%3A%2F%2Fgraph.microsoft.com%2F.default';

        try{
            //Inicializa curl
            $ch = curl_init();
            //Set variables
            curl_setopt($ch, CURLOPT_URL,$uri);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //Ejecuta solicitud
            $result = curl_exec ($ch);
            //Cierra curl y regresa resultado
            curl_close ($ch);
            $result = json_decode($result, true);

            //Guarda resultado en config
            $now = new DateTime();
            $now = date_modify($now, "+1 hour");
            $OneDrive['token']=$result['access_token'];
            $OneDrive['expire_in']=$now->format('Y-m-d H:i:s');
            $update_toke = "update config set value='{$OneDrive['token']}' where category='OneDrive' and name='token'";
            $update_expired = "update config set value='{$OneDrive['expire_in']}' where category='OneDrive' and name='expire_in'";
            $update_by = "update config set value='{$current_user->user_name}' where category='OneDrive' and name='generated_by'";
            $update_in = "update config set value='{$now->format('Y-m-d H:i:s')}' where category='OneDrive' and name='generated_in'";
            $resultado_token = $db->query($update_toke);
            $resultado_expired = $db->query($update_expired);
            $resultado_by = $db->query($update_by);
            $resultado_in = $db->query($update_in);
        } catch
        (Exception $e) {
            //$GLOBALS['log']->fatal('Error token: '. $e->getMessage());
        }
        //$GLOBALS['log']->fatal("Finaliza get_token");
        //Regresa token en $OneDrive['token']
        return $OneDrive;
    }

    function upload_audios($exe_variables, $file_name, $file_content=null,$consult_idM,$iduser)
    {
        //$GLOBALS['log']->fatal('INICIA upload_audios');
        //Arma petición para Subir Audio
        global $db,$current_user;
        $uri = 'https://graph.microsoft.com/v1.0/users/'.$iduser.'/drive/items/'.$consult_idM.':/'.$file_name.':/content';
        
        $GLOBALS['log']->fatal('Uri: '.$uri);
        //$GLOBALS['log']->fatal('Token: '.$exe_variables['token']);
        //$GLOBALS['log']->fatal('Cuerpo Audio: '.$file_content);
        //Inicializa curl
        $ch = curl_init();
        //Set variables
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_URL,$uri);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file_content);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain',
        'Authorization: Bearer '.$exe_variables['token'])
        );        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Ejecuta solicitud
        $result = curl_exec ($ch);
        //Cierra curl y regresa resultado
        curl_close ($ch);
        //$GLOBALS['log']->fatal('Termina upload_audios');
        //$GLOBALS['log']->fatal($result);
        return json_decode($result, true);
    }

    function consultDrive($exe_variables,$parentFolder,$nameFolder,$iduser)
    {
        //Arma petición para token. Peticion AÑO
        //Valor folder es de TEST= 01GKB4L5GC3JD4GTI42FALNFWKTJ7QEUPS
        $uri = 'https://graph.microsoft.com/v1.0/users/'.$iduser.'/drive/items/'.$parentFolder.'/children';
        //$GLOBALS['log']->fatal("Entra ConsultDrive");
        //Inicializa curl
        $ch = curl_init();
        //Set variables
        curl_setopt($ch, CURLOPT_URL,$uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$exe_variables['token'])
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Ejecuta solicitud
        $result = curl_exec ($ch);
        //$GLOBALS['log']->fatal("Ejecuta Consulta ConsultDrive ".$result);
        $result=json_decode($result,true);
        $idFolderchild=0;
            foreach($result['value'] as $i){
                if($i['name']==$nameFolder){
                    $idFolderchild=$i['id'];
                    $GLOBALS['log']->fatal("name_IDfolder :".$idFolderchild);
                }
            }
        //Cierra curl y regresa resultado
        curl_close ($ch);
        return $idFolderchild;
    }

    function createfolder($exe_variables,$iduser,$parentFolder,$nameFolder){
        $GLOBALS['log']->fatal("Inicia createfolder");
        $uri = 'https://graph.microsoft.com/v1.0/users/'.$iduser.'/drive/items/'.$parentFolder.'/children';

        $data='{"name":"'.$nameFolder.'","folder":{},"@microsoft.graph.conflictBehavior":"rename"}';
        //$data = json_encode($data);
        $GLOBALS['log']->fatal($data);

        //Inicializa curl
        $ch = curl_init();
        //Set variables
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_URL,$uri);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$exe_variables['token'])
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Ejecuta solicitud
        $result = curl_exec ($ch);
        $GLOBALS['log']->fatal($result);

        //Cierra curl y regresa resultado
        $result=json_decode($result,true);
        $id_generatedFolder=$result['id'];
        curl_close ($ch);
        $GLOBALS['log']->fatal("Sale createfolder");
        $GLOBALS['log']->fatal($id_generatedFolder);
        return $id_generatedFolder;
    }