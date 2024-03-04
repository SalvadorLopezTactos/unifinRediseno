<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/07/20
 * Time: 09:10 AM
 */

require_once("custom/Levementum/UnifinAPI.php");

class Upload_documents
{

    function File_to_drive($bean = null, $event = null, $args = null)
    {
        //Instancia clases requeridas
        include_once 'include/utils/file_utils.php';
        include_once 'include/utils/sugar_file_utils.php';
        global $sugar_config,$db;

        //Recupera variables de do cumento por procesar
        $file_name = $bean->filename;
        $file_id = $bean->document_revision_id;
        $doc_revision = BeanFactory::retrieveBean('DocumentRevisions',$file_id);
        //Valida que exista una url
        if (empty($doc_revision->doc_url) && !empty($bean->s_seguros_documents_1s_seguros_ida) && !empty($bean->tipo_documento_c)) {
            //Traer los datos del seguro
            $seguros = BeanFactory::retrieveBean('S_seguros', $bean->s_seguros_documents_1s_seguros_ida);
            $GLOBALS['log']->fatal('Carga modulo relacionado (Seguros)');
            require_once("include/upload_file.php");
            //Valida que se tenga un int_id_dynamics_c
            if (!empty($seguros->int_id_dynamics_c)) {
                try {
                    //Proceso de generación de subida documento a Google Drive
                    $GLOBALS['log']->fatal('Inicia proceso de subida de documento a Sharepoint');
                    //ruta al archivo
                    $GLOBALS['log']->fatal('File id :' .$file_id);
                    $file = new UploadFile();
                    //get the file location
                    $file->temp_file_location = $file->get_upload_path($file_id);
                    $file_content = $file->get_file_contents();
                    $file_encoded= base64_encode($file_content);
                    //$GLOBALS['log']->fatal('File encoded :' .$file_encoded);

                    //Crea request para subir documento
                    $url = $sugar_config['inter_sharepoint_url'];
                    $usuarioSharePoint = $sugar_config['inter_sharepoint_user'];
                    $content = array(
                      "UserName" => $usuarioSharePoint,
                    	"Id" => $seguros->int_id_dynamics_c,
                    	"Tipo" => "3",
                    	"NameFile" => $file_name,
                    	"File" => $file_encoded
                    );

                    //Asignar valor del campo drive al registro
                    $GLOBALS['log']->fatal('Sube archivo a sharepoint: ' . $seguros->int_id_dynamics_c . ' - '. $file_name);
                    //$GLOBALS['log']->fatal(print_r($result,true));
                    $callApiSP = new UnifinAPI();
                    $resultado = $callApiSP->unifinPostCall($url, $content);

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
                        //$GLOBALS['log']->fatal('Petición: ' . json_encode($body));
                        //Llama a unifinPostCall para que realice el consumo de servicio a Alfresco
                        $callApi = new UnifinAPI();
                        $resultado = $callApi->unifinPostCall($url, $body);
                        //$GLOBALS['log']->fatal('Resultado: ' . json_encode($resultado));
                        //Actualiza campo Documentos (nuevo)
                        if ($resultado['resultCode'] == 0) {
                            $update = "update documents_cstm set
                            id_alfresco_c='{$resultado['data']['objectId']}'
                            where id_c = '{$bean->id}'";
                            $updateExecute = $db->query($update);
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
                    $upload_stream = new UploadStream();
                    $removeFile= 'upload://'.$file_id;
                    if (!$upload_stream->unlink($removeFile)) {
                        $GLOBALS['log']->fatal("No se tiene un link file");
                    } else {
                        $GLOBALS['log']->fatal("Se tiene un unlink file");
                    }
                }
            }
            $GLOBALS['log']->fatal('Finaliza proceso de subida de documento a Sharepoint INTER');
        }
    }

    function set_field_to_notification($bean, $event, $arguments){
        if($bean->tipo_documento_c=="3"){
            //Establecer el check de la cuenta relacionada para lanzar notificacion
            $idSolicitud=$bean->opportunities_documents_1opportunities_ida;
            $beanOpp = BeanFactory::retrieveBean('Opportunities', $idSolicitud);
            if(!empty($beanOpp)){
                $GLOBALS['log']->fatal("-----------------");
                $GLOBALS['log']->fatal("ESTABLECIENDO CHECK EN SOLICITUDES PARA ENVIAR NOTIFICACION DE ARCHIVO ADJUNTO");
                $beanOpp->doc_scoring_chk_c=1;
                $beanOpp->save();

            }

        }

    }

    function set_team_cac($bean = null, $event = null, $args = null)
    {
        global $current_user,$db;
        $equipos = array();
        if($current_user->cac_c){
          //Agregar equipo CAC
          $query = "select id from teams where name = 'CAC';";
          $queryResult = $db->query($query);
          while ($row = $db->fetchByAssoc($queryResult)) {
              $equipos[] = $row['id'];
          }
        }else{
          //Agrega equipo Global
          $equipos[] = '1';
        }
        $GLOBALS['log']->fatal("Equipos". print_r($equipos,true));
        //Agrega equipos
        $bean->load_relationship('teams');
        $bean->teams->add(
          $equipos
        );
    }

    function upload_doc_quantico($bean = null, $event = null, $args = null){

        if( $bean->tipo_documento_c == '11' && $bean->data_document_quantico_c == ""){ //Carta de Buró de Crédito y aún no se ha integrado con Quantico
            //Instancia clases requeridas
            include_once 'include/utils/file_utils.php';
            include_once 'include/utils/sugar_file_utils.php';
            global $sugar_config, $db;

            try {

                $beanCaso = $this->getCase($bean);

                //Si se obtiene caso relacionado, se obtienen datos de la Cuenta y Solicitud
                if( $beanCaso != "" ){

                    $idCuenta = $beanCaso->account_id;
                    $idSolicitud = $beanCaso->opportunity_id_c;

                    $GLOBALS['log']->fatal('ID CUENTA: '.$idCuenta);
                    $GLOBALS['log']->fatal('ID SOLICICTUD:' . $idSolicitud);
                    

                    if( $idSolicitud != "" && $idCuenta !="" ){
                        $beanSolicitud = BeanFactory::retrieveBean('Opportunities', $idSolicitud, array('disable_row_level_security' => true));

                        $requestNumber = $beanSolicitud->idsolicitud_c;
                        $GLOBALS['log']->fatal('REQUEST NUMBER:' . $requestNumber);

                        //Recupera variables de documento por procesar
                        $file_id = $bean->document_revision_id;
                        $doc_revision = BeanFactory::retrieveBean('DocumentRevisions', $file_id);

                        $GLOBALS['log']->fatal('Inicia proceso de subida de documento a QUANTICO');
                        //ruta al archivo
                        $GLOBALS['log']->fatal('File id :' . $file_id);
                        $file = new UploadFile();
                        //get the file location
                        $file->temp_file_location = $file->get_upload_path($file_id);
                        $file_content = $file->get_file_contents();
                        $file_encoded = base64_encode($file_content);

                        //Crea request para subir documento
                        $host = $sugar_config['quantico_expediente_url'];

                        $url_endpoint = $host . "/Expedient_CS/rest/QuanticoDocuments/UploadRequestDocument";

                        $body = array(
                            "ClientGUID" => $idCuenta,
                            "DocumentReference" => "BURO_DE_CREDITO",
                            "FechaCreacion" => date("Y-m-d"),
                            "RequestNumber" => $requestNumber,
                            //"RequestNumber" => 169474,
                            "RelationshipTypeId" => 17,
                            "FileBase64" => $file_encoded
                        );

                        $callApiQuantico = new UnifinAPI();
                        $resultado = $callApiQuantico->unifinPostCall($url_endpoint, $body);
                        $GLOBALS['log']->fatal("RESPONSE SERVICIO");
                        $GLOBALS['log']->fatal(print_r($resultado, true));

                        if( isset( $resultado['Uuid'] )){
                            $idDocumentoQuantico = $resultado['Uuid'];
                            $versionDocumentoQuantico = $resultado['Version'];
                            $stringData = $idDocumentoQuantico." ". $versionDocumentoQuantico;
                            $sqlUpdate = "UPDATE documents_cstm SET data_document_quantico_c = '{$stringData}' WHERE (id_c = '{$bean->id}');";
                            $GLOBALS['db']->query($sqlUpdate);
                        }

                    }
                }else{

                }
                
            } catch (Exception $e) {
                $GLOBALS['log']->fatal("ERROR AL SUBIR CARTA BURÓ DE CRÉDITO");
                $GLOBALS['log']->fatal($e->getMessage());
            }
        }else{
            $GLOBALS['log']->fatal("NO SE SUBE DOCUMENTO");
        }


    }

    /**
     * Obtiene el último caso modificado relacionado al documento que se está guardando
     */
    function getCase($bean){

        $caseRelated = "";
        $GLOBALS['log']->fatal("ENTRA FUNCIÓN PARA CASOS");
        if ($bean->load_relationship('cases')) {
            $GLOBALS['log']->fatal("RECORRIENDO CASOS RELACIONADOS");
            $parametros = array(
                'orderby' => 'date_modified DESC',
                'disable_row_level_security' => true
            );
            $casosRelacionados = $bean->cases->getBeans($bean->id, $parametros);
            if (!empty($casosRelacionados)) {
                $i = 0;
                foreach ($casosRelacionados as $caso) {
                    $GLOBALS['log']->fatal("CASO: ".$caso->id);
                    if( $i == 0 ){
                        $caseRelated = $caso;
                        $i++;
                    }
                }
            }
        }

        return $caseRelated;

    }
}
