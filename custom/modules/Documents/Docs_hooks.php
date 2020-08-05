<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/07/20
 * Time: 09:10 AM
 */

require_once("custom/aux_libraries/google-api-php-client-2.2.4/vendor/autoload.php");
require_once("custom/Levementum/UnifinAPI.php");

class Upload_documents
{

    function File_to_drive($bean = null, $event = null, $args = null)
    {
        //Instancia clases requeridas
        include_once 'include/utils/file_utils.php';
        include_once 'include/utils/sugar_file_utils.php';
        global $sugar_config;

        //Recupera variables de documento por procesar
        $file_name = $bean->filename;
        $file_id = $bean->document_revision_id;
        $doc_revision = BeanFactory::retrieveBean('DocumentRevisions',$file_id);
        //Valida que exista una url
        if (empty($doc_revision->doc_url) && !empty($bean->s_seguros_documents_1s_seguros_ida) && !empty($bean->tipo_documento_c)) {
            //Traer los datos del seguro
            $seguros = BeanFactory::retrieveBean('S_seguros', $bean->s_seguros_documents_1s_seguros_ida);
            $GLOBALS['log']->fatal('Carga modulo relacionado (Seguros)');
            //Valida que se tenga una url Folder
            if (!empty($seguros->google_drive4_c)|| !empty($seguros->google_drive5_c)) {

                $idGoogle = ($bean->tipo_documento_c==1) ? $seguros->google_drive4_c :$seguros->google_drive5_c;

                try {
                    //Proceso de generación de subida documento a Google Drive
                    $GLOBALS['log']->fatal('Inicia proceso de subida de documento a Google Drive');
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
                    //ruta al archivo
                    //$fiel_ext = get_file_extension($file_name, true);
                    $file_content = sugar_file_get_contents('upload/'.$file_id, true);
                    $file_encoded= base64_encode($file_content);
                    $GLOBALS['log']->fatal('File encoded :' .$file_encoded);

                    //obtenemos el mime type
                    $file_mime = get_file_mime_type('upload/'.$file_id, true);
                    $GLOBALS['log']->fatal('File name :' .$file_name);
                    $GLOBALS['log']->fatal('File Mime :' .$file_mime);
                    $file->setName($file_name);

                    //id de la carpeta donde hemos dado el permiso a la cuenta de servicio
                    $file->setParents(array($idGoogle));
                    $file->setMimeType($file_mime);
                    //Crea el archivo en Google Drive
                    $result = $service->files->create(
                        $file,
                        array(
                            'data' => $file_content,
                            'mimeType' => $file_mime,
                            'uploadType' => 'media',
                        )
                    );
                    //Asignar valor del campo drive al registro
                    $GLOBALS['log']->fatal('Sube archivo al drive :' .$idGoogle);
                    //$GLOBALS['log']->fatal(print_r($result,true));

                } catch (Google_Service_Exception $gs) {

                    $m = json_decode($gs->getMessage());
                    $GLOBALS['log']->fatal($m->error->message);

                } catch (Exception $e) {
                    $GLOBALS['log']->fatal($e->getMessage());

                }
            //Envío de documento a Alfresco
                try {
                    if (!empty($seguros->s_seguros_accountsaccounts_ida && $bean->id_alfresco_c == "")) {
                        $GLOBALS['log']->fatal('Sube archivo a Alfresco');
                        //crea body y declara URL
                        $url=$sugar_config['url_alfresco'].'expediente/uploadDocument';

                        //Validación tipo documento
                        $Doc = ($bean->tipo_documento_c == 1) ? "0028" : "0029";

                        $body = array(
                            "fileName" => $file_name,
                            "persona" => $seguros->s_seguros_accountsaccounts_ida,
                            "empresa" => "U_FI",
                            "documento" => $Doc,
                            "identificador" => $seguros->id,
                            "key" => "",
                            "forceUpdate" => true,
                            "file" => $file_encoded
                        );

                        //invoca a unifinPostCall
                        $GLOBALS['log']->fatal('Petición: ' . json_encode($body));
                        //Llama a unifinPostCall para que realice el consumo de servicio a Alfresco
                        $callApi = new UnifinAPI();
                        $resultado = $callApi->unifinPostCall($url, $body);
                        //$GLOBALS['log']->fatal('Resultado: ' . json_encode($resultado));
                        //Actualiza campo Documentos (nuevo)
                        if ($resultado['resultCode'] == 0) {
                            $bean->id_alfresco_c = $resultado['data']['objectId'];
                            $GLOBALS['log']->fatal('Actualiza campo id_alfresco_c');

                        }

                    }
                }
                catch (Exception $e) {
                    $GLOBALS['log']->fatal($e->getMessage());

                }
            }
            //Elimina archivo upload/$file_id
            if (!empty($result->id)) {
                $removeFile = 'upload/'.$file_id;
                $GLOBALS['log']->fatal("Se elimina documento de SugarCRM");
                if (stream_resolve_include_path($removeFile) != false) {
                    require_once("include/upload_file.php");
                    $upload_stream = new UploadStream();
                    $removeFile= 'upload://'.$file_id;
                    if (!$upload_stream->unlink($removeFile)) {
                        $GLOBALS['log']->fatal("No se tiene un link file");
                    } else {
                        $GLOBALS['log']->fatal("Se tiene un unlink file");
                    }
                }
            }
            $GLOBALS['log']->fatal('Finaliza proceso de subida de documento a GoogleDrive');
        }
    }
}
