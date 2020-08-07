<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/07/20
 * Time: 11:42 PM
 */

require_once("custom/aux_libraries/google-api-php-client-2.2.4/vendor/autoload.php");

class Drive_docs
{
    function Load_docs($bean = null, $event = null, $args = null)
    {
        $GLOBALS['log']->fatal('Inicia proceso de creación de folder-Cuenta con GoogleDrive');
        $bean_Resumen = BeanFactory::retrieveBean('tct02_Resumen', $bean->s_seguros_accountsaccounts_ida);
        $bean_Account = BeanFactory::retrieveBean('Accounts', $bean_Resumen->id);
        global $app_list_strings, $sugar_config;
        //Condicion para crear el folder de la cuenta
        if (empty($bean->google_drive2_c && !empty($bean->s_seguros_accountsaccounts_ida))) {
            $GLOBALS['log']->fatal('Valida que haya valor en tct02_resumen');
            if(empty($bean_Resumen->googledriveac_c)){
                $GLOBALS['log']->fatal('No existe valor en resumen, crea folder Cliente');
                $nombreAC=$bean_Account->name;
                $GLOBALS['log']->fatal($nombreAC);

                //configurar variable de entorno
                putenv("GOOGLE_APPLICATION_CREDENTIALS=./custom/aux_libraries/Inter_drive_keys/Credenciales.json");
                $client = new Google_Client();
                $client->useApplicationDefaultCredentials();
                $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
                //Instanciar el servicio
                $service = new Google_Service_Drive($client);
                //Instacia de archivo
                $file = new Google_Service_Drive_DriveFile();
                //Creacion de la carpeta y atributos
                $file->setName($nombreAC);
                //ID del carpeta en Drive donde se creará el nuevo folder
                $file->setParents(array($sugar_config['Folder_Inter']));
                $file->setMimeType('application/vnd.google-apps.folder');
                $GLOBALS['log']->fatal('Crea Carpeta con nombre ' . $nombreAC);
                //Crea archivo (directorio)
                $result = $service->files->create($file);
                $GLOBALS['log']->fatal("ID del folder CLIENTE es " .$result->id);
                //$GLOBALS['log']->fatal(print_r($result,true));
                //Asignar valor del campo drive al registro
                $bean->google_drive_c= "https://drive.google.com/drive/u/0/folders/" . $result->id;
                $bean_Resumen->googledriveac_c= $result->id;
                $bean_Resumen->save();
            }
            //Condición para crear subdirectorio con el tipo de seguro
            if(!empty($bean_Resumen->googledriveac_c)) {
                $tipo = $app_list_strings['tipo_negocio_list'];
                //guardamos el id del folder principal en variable
                $folderAc = $bean_Resumen->googledriveac_c;
                //Obtenemos el tipo de seguro
                $seguro = $tipo[$bean->tipo];
                //Mandamos a crear un nuevo folder, dentro del folderAc
                //configurar variable de entorno
                putenv("GOOGLE_APPLICATION_CREDENTIALS=./custom/aux_libraries/Inter_drive_keys/Credenciales.json");
                $client = new Google_Client();
                $client->useApplicationDefaultCredentials();
                $client->setScopes(['https://www.googleapis.com/auth/drive.file']);

                //Instanciar el servicio
                $service = new Google_Service_Drive($client);
                //Instacia de archivo
                $file = new Google_Service_Drive_DriveFile();
                //Creacion de la carpeta y atributos
                $file->setName($seguro);
                //ID del carpeta en Drive donde se creará el nuevo folder

                $file->setParents(array($folderAc));
                $file->setMimeType('application/vnd.google-apps.folder');
                $GLOBALS['log']->fatal('Crea Carpeta con oportunidad de seguro :' . $seguro);
                //Crea archivo (directorio)
                $result = $service->files->create($file);
                $GLOBALS['log']->fatal("ID del folder de Op de Seguro es " . $result->id);
                //$GLOBALS['log']->fatal(print_r($result, true));
                //Asignar valor del campo SEGURO del drive al registro
                $bean->google_drive2_c = $result->id;
            }
            if (!empty($bean->google_drive2_c)) {
                //Ahora creamos carpeta del año
                $anio = date("Y");
                //configurar variable de entorno
                putenv("GOOGLE_APPLICATION_CREDENTIALS=./custom/aux_libraries/Inter_drive_keys/Credenciales.json");
                //Instanciar el servicio
                $service = new Google_Service_Drive($client);
                //Instacia de archivo
                $file = new Google_Service_Drive_DriveFile();
                //Creacion de la carpeta y atributos
                $file->setName($anio);
                //ID del carpeta en Drive donde se creará el nuevo folder
                $idAnio = $bean->google_drive2_c;
                $file->setParents(array($idAnio));
                $file->setMimeType('application/vnd.google-apps.folder');
                $GLOBALS['log']->fatal('Crea Carpeta con anio :' . $anio);
                //Crea archivo (directorio)
                $result = $service->files->create($file);
                $GLOBALS['log']->fatal("ID del folder ANIO es " . $result->id);
                //$GLOBALS['log']->fatal(print_r($result, true));
                //Asignar valor del campo ANIO del drive al registro
                $bean->google_drive3_c = $result->id;
            }
            //Creación de dos subcarpetas dentro de la carpeta ANIO
            if (!empty($bean->google_drive3_c)) {
                //Carpeta TECNICA
                //configurar variable de entorno
                putenv("GOOGLE_APPLICATION_CREDENTIALS=./custom/aux_libraries/Inter_drive_keys/Credenciales.json");
                //Instanciar el servicio
                $service = new Google_Service_Drive($client);
                //Instacia de archivo
                $file = new Google_Service_Drive_DriveFile();
                //Creacion de la carpeta y atributos
                $file->setName("Técnica");
                //Definicion de carpeta padre, en este caso la carpeta ANIO
                $file->setParents(array($bean->google_drive3_c));
                $file->setMimeType('application/vnd.google-apps.folder');
                //Crea archivo (directorio)
                $result = $service->files->create($file);
                $GLOBALS['log']->fatal("ID del folder TECNICA es " . $result->id);
                //Asignar valor del campo ANIO del drive al registro
                $bean->google_drive4_c = $result->id;
            }
            if (!empty($bean->google_drive4_c)) {
                //Carpeta Artículo 492
                //configurar variable de entorno
                putenv("GOOGLE_APPLICATION_CREDENTIALS=./custom/aux_libraries/Inter_drive_keys/Credenciales.json");
                //Instanciar el servicio
                $service = new Google_Service_Drive($client);
                //Instacia de archivo
                $file = new Google_Service_Drive_DriveFile();
                //Creacion de la carpeta y atributos
                $file->setName("Artículo 492");
                //Definicion de carpeta padre, en este caso la carpeta ANIO
                $file->setParents(array($bean->google_drive3_c));
                $file->setMimeType('application/vnd.google-apps.folder');
                //Crea archivo (directorio)
                $result = $service->files->create($file);
                $GLOBALS['log']->fatal("ID del folder Artículo 492 es " . $result->id);
                //Asignar valor del campo Articulo 492 del drive al registro
                $bean->google_drive5_c = $result->id;
            }
        }
        $GLOBALS['log']->fatal('Finaliza proceso de integración con GoogleDrive');
    }
}
