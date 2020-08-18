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
        if (empty($bean_Resumen->googledriveac_c)|| empty($bean->google_drive4_c) || empty($bean->google_drive5_c)){
            putenv("GOOGLE_APPLICATION_CREDENTIALS=./custom/aux_libraries/Inter_drive_keys/Credenciales.json");
            $client = new Google_Client();
            $client->useApplicationDefaultCredentials();
            $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
        }
        if (empty($bean->google_drive2_c && !empty($bean->s_seguros_accountsaccounts_ida))) {
            $GLOBALS['log']->fatal('Valida que haya valor en tct02_resumen');
            if(empty($bean_Resumen->googledriveac_c)){
                $GLOBALS['log']->fatal('No existe valor en resumen, crea folder Cliente');
                $nombreAC=$bean_Account->name;
                $GLOBALS['log']->fatal($nombreAC);

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
                //putenv("GOOGLE_APPLICATION_CREDENTIALS=./custom/aux_libraries/Inter_drive_keys/Credenciales.json");

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
                //putenv("GOOGLE_APPLICATION_CREDENTIALS=./custom/aux_libraries/Inter_drive_keys/Credenciales.json");
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
                //putenv("GOOGLE_APPLICATION_CREDENTIALS=./custom/aux_libraries/Inter_drive_keys/Credenciales.json");
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
                //putenv("GOOGLE_APPLICATION_CREDENTIALS=./custom/aux_libraries/Inter_drive_keys/Credenciales.json");
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

    function actualizatipoprod($bean = null, $event = null, $args = null){
        //Declara variables de Oportunidad
        $producto= "10"; //Seguros
        $etapa=$bean->etapa;
        $cliente = $bean->s_seguros_accountsaccounts_ida;

        //Evalua cambio en etapa o subetapa
        if ($bean->fetched_row['etapa']!=$etapa && $cliente) {

            //Actualiza en Solicitud Inicial y actualiza campos con valor Prospecto Interesado: 2,7
            $GLOBALS['log']->fatal('Actualiza tipo de Cuenta para producto: '.$producto);
            if($etapa=="1"){
                $GLOBALS['log']->fatal('Actualiza a Prospecto Interesado (cuenta)');
                Drive_docs::actualizaTipoCuentaProd('2','7',$cliente,$producto);
            }

            //Actualiza cuando la solicitud es Autorizada (N) Cliente Nuevo: 3, 13
            if ($bean->etapa=="9") { //Etapa solicitud 9 GANADA
                $GLOBALS['log']->fatal('Cliente Nuevo');
                Drive_docs::actualizaTipoCuentaProd('3','13',$cliente,$producto);
            }
            //Oportunidad de Seguro NO Ganada pasa la cuenta a Prospecto Rechazado  2 :10
            if ($bean->etapa=="10") { //Etapa solicitud 9 GANADA
                $GLOBALS['log']->fatal('Op de Seguro NO Ganada');
                Drive_docs::actualizaTipoCuentaProd('2','10',$cliente,$producto);
            }
        }
    }

    function actualizaTipoCuentaProd($tipo=null, $subtipo=null, $idCuenta=null, $tipoProducto=null)
    {
        global $app_list_strings;
        //Valuda cuenta Asociada y producto
        if($idCuenta && $tipoProducto){
            //Recupera cuenta
            $beanAccount = BeanFactory::getBean('Accounts', $idCuenta);
            //Recupera productos y actualiza Tipo y subtipo
            if ($beanAccount->load_relationship('accounts_uni_productos_1')) {
                $relateProducts = $beanAccount->accounts_uni_productos_1->getBeans($beanAccount->id,array('disable_row_level_security' => true));
                //Recupera valores
                $tipoList = $app_list_strings['tipo_registro_cuenta_list'];
                $subtipoList = $app_list_strings['subtipo_registro_cuenta_list'];
                $tipoSubtipo = mb_strtoupper(trim($tipoList[$tipo].' '.$subtipoList[$subtipo]),'UTF-8');
                //Itera productos recuperados
                foreach ($relateProducts as $product) {
                    if ($tipoProducto == $product->tipo_producto) {
                        if ($product->tipo_cuenta != "3" && $tipo == 2) {
                            //Actualiza tipo y subtipo de producto
                            $GLOBALS['log']->fatal('Actualiza tipo y subtipo de producto en CUENTA a '.$tipo .',' .$subtipo);
                            $beanAccount->tipo_registro_cuenta_c=$tipo;
                            $beanAccount->subtipo_registro_cuenta_c=$tipoSubtipo;
                            $product->tipo_cuenta = $tipo;
                            $product->subtipo_cuenta = $subtipo;
                            $product->tipo_subtipo_cuenta = $tipoSubtipo;
                            $product->save();
                        }
                        if ($product->tipo_cuenta != "3" && $tipo == 3) {
                            //Actualiza tipo y subtipo de producto
                            $beanAccount->tipo_registro_cuenta_c=$tipo;
                            $beanAccount->subtipo_registro_cuenta_c=$tipoSubtipo;
                            $product->tipo_cuenta = $tipo;
                            $product->subtipo_cuenta = $subtipo;
                            $product->tipo_subtipo_cuenta = $tipoSubtipo;
                            $product->save();
                        }
                    }
                }
                //$beanAccount->save();
            }
        }
    }
}
