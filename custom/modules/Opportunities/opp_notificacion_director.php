<?php
/**
 * User: salvadorlopez
 * Date: 01/09/20
 */
class NotificacionDirector
{
    function notificaDirector($bean, $event, $arguments)
    {
        global $current_user;
        global $db;

        if($bean->director_solicitud_c!="" && $bean->director_solicitud_c!=null && $bean->director_notificado_c==0 && $bean->doc_scoring_chk_c==1){
            $GLOBALS['log']->fatal("Inicia proceso de notificacion_director");
            $documento="";
            $extensionArchivo="";
            $documentos=array();
            if($bean->load_relationship('opportunities_documents_1')){
                $beansDocs = $bean->opportunities_documents_1->getBeans();
                if (!empty($beansDocs)) {
                    foreach($beansDocs as $doc){

                        if($doc->tipo_documento_c=='3'){
                            $documento=$doc->document_revision_id;
                            $nombreArchivo=$doc->filename;
                            $explodeNameArchivo=explode(".", $nombreArchivo);
                            $nombreDocAdjunto=$explodeNameArchivo[0];
                            $extensionArchivo=$explodeNameArchivo[1];

                            array_push($documentos,array('archivo'=>$documento,"extension"=>$extensionArchivo,"nombreDocumento"=>$nombreDocAdjunto));

                        }
                    }

                }

            }

            //Se arma cuerpo de la notificación
            $urlSugar=$GLOBALS['sugar_config']['site_url'].'/#Opportunities/';
            $infoDirector=$bean->director_solicitud_c;
            $infoDirectorSplit=explode(",", $infoDirector);
            $idDirector=$infoDirectorSplit[0];
            $nombreDirector=$infoDirectorSplit[1];
            $nombreCuenta=$bean->account_name;
            $idSolicitud=$bean->id;
            $linkSolicitud=$urlSugar.$idSolicitud;
            $descripcion=$bean->vobo_descripcion_txa_c;

            $correo_director="";

            //Obteniendo correo de director Leasing
            $beanDirector = BeanFactory::retrieveBean('Users', $idDirector);
            if(!empty($beanDirector)){
                $correo_director=$beanDirector->email1;
                $nombreDirector=$beanDirector->full_name;
            }
            //Se obtiene el correo y nombre del asesorRM
            $beanAsesorRM = BeanFactory::retrieveBean('Users', $bean->user_id1_c);
            if(!empty($beanAsesorRM)){
                $correo_rm=$beanAsesorRM->email1;
                $nombre_rm=$beanAsesorRM->full_name;
            }    
            $GLOBALS['log']->fatal("Director de la solicitud con nombre: ".$nombreDirector. 'y correo :' .$correo_director);

            $urlSugarDoc=$GLOBALS['sugar_config']['site_url'].'/#Documents/';

            $rutasAdjuntos=array();

            if($correo_director!=""){
                $adjunto="";
                /*
                if($documento!=""){
                    $adjunto = "upload/".$documento;
                    $file_contents=file_get_contents($adjunto);
                    $archivo="upload/ScoringComercial_".$documento.".".$extensionArchivo;
                    file_put_contents($archivo, $file_contents);
                    $GLOBALS['log']->fatal("SE GENERO ARCHIVO DE SCORING ".$archivo);
                }
                */
                if(count($documentos)>0){

                    for($i=0;$i<count($documentos);$i++){
                        //$recipients[$i]['correo']
                        $adjunto = "upload/".$documentos[$i]['archivo'];

                        $file_contents=file_get_contents($adjunto);

                        $archivo="upload/".$documentos[$i]['nombreDocumento'].".".$documentos[$i]['extension'];
                        file_put_contents($archivo, $file_contents);
                        $GLOBALS['log']->fatal("SE GENERO ARCHIVO DE SCORING ".$archivo);
                        array_push($rutasAdjuntos,$archivo);

                    }

                }

                //Obtener correo de director regional
                $idUsuarioAsignado=$bean->assigned_user_id;
                $region_asignado="";
                $correo_regional="";
                $id_regional="";
                $nombre_regional="";
                $array_user_regional=array();
                $beanAsignado = BeanFactory::retrieveBean('Users', $idUsuarioAsignado);
                if(!empty($beanAsignado)){
                    $region_asignado=$beanAsignado->region_c;
                }

                if($region_asignado!=""){
                    //PUESTO USUARIO DIRECTOR REGIONAL LEASING =33
                    $queryDirectorRegional=<<<SQL
                    SELECT id,puestousuario_c, u.status,u.user_name,uc.region_c FROM users u INNER JOIN  users_cstm uc
                    ON u.id=uc.id_c WHERE uc.puestousuario_c='33' AND u.status='Active' and uc.region_c='{$region_asignado}' and u.deleted=0;
                    SQL;
                    $queryResult = $db->query($queryDirectorRegional);
                    if($queryResult->num_rows>0){
                        while ($row = $db->fetchByAssoc($queryResult)) {
                            $id_regional = $row['id'];
                        }

                        if($id_regional!=""){
                            $beanRegional = BeanFactory::retrieveBean('Users', $id_regional);
                            if(!empty($beanRegional)){

                                array_push($array_user_regional,array('correo'=>$beanRegional->email1,"nombre"=>$beanRegional->full_name));
                            }

                        }
                    }

                }

                if(count($rutasAdjuntos)>0){
                    $idRM=$bean->user_id1_c;
                    $Valor= "569246c7-da62-4664-ef2a-5628f649537e";
                    $producto=$bean->tipo_producto_c;
                    $cuerpoCorreo= $this->estableceCuerpoNotificacion($nombreDirector,$nombreCuenta,$linkSolicitud,$descripcion,$nombre_rm,$idRM,$Valor,$producto);

                    $GLOBALS['log']->fatal("ENVIANDO NOTIFICACION A DIRECTOR DE SOLICITUD ".$correo_director);
                    //Enviando correo a director de solicitud con copia  a director regional leasing
                    $this->enviarNotificacionDirector("Solicitud por validar {$bean->name}",$cuerpoCorreo,$correo_director,$nombreDirector,$rutasAdjuntos,$array_user_regional,$current_user->id, $idSolicitud);

                    //ENVIANDO NOTIFICACIÓN A DIRECTOR REGIONAL
                    /*
                    if($correo_regional!=""){
                        $cuerpoCorreoRegional= $this->estableceCuerpoNotificacion($nombre_regional,$nombreCuenta,$linkSolicitud);
                        $GLOBALS['log']->fatal("ENVIANDO NOTIFICACION A DIRECTOR REGIONAL DE SOLICITUD ".$correo_regional);
                        //Enviando correo a asesor origen
                        $this->enviarNotificacionDirector("Solicitud por validar {$bean->name}",$cuerpoCorreoRegional,$correo_regional,$nombre_regional,$archivo);
                    }else{
                        $GLOBALS['log']->fatal("DIRECTOR REGIONAL LEASING ".$nombre_regional." NO TIENE EMAIL");
                    }
                    */


                    //$bean->director_notificado_c=1;
                    $query_actualiza = "UPDATE opportunities_cstm SET director_notificado_c=1 WHERE id_c='{$bean->id}'";
                    $result_actualiza = $db->query($query_actualiza);

                }else{
                    $GLOBALS['log']->fatal("NO SE ENVIA NOTIFICACION PUES NO TIENE DOCUMENTOS ADJUNTOS");
                    $query_actualiza_check = "UPDATE opportunities_cstm SET doc_scoring_chk_c=0 WHERE id_c='{$bean->id}'";
                    $result_actualiza = $db->query($query_actualiza_check);
                }

            }else{
                $GLOBALS['log']->fatal("DIRECTOR LEASING ".$nombreDirector." NO TIENE EMAIL");
            }

        }
        $GLOBALS['log']->fatal("Termina proceso de notificacion_director");
    }

    function notificaEstatusAsesor($bean, $event, $arguments){

        global $app_list_strings;
        global $current_user;
        global $db;
        $GLOBALS['log']->fatal("Inicia notificaEstatusAsesor");
        $estatus=$bean->estatus_c;
        $idAsesor=$bean->assigned_user_id;
        $nombreAsesor=$bean->assigned_user_name;
        $producto=$bean->tipo_producto_c;
        $negocio=$bean->negocio_c;

        $infoDirector=$bean->director_solicitud_c;
        $idDirector="";
        if($infoDirector!=""){
            $infoDirectorSplit=explode(",", $infoDirector);
            $idDirector=$infoDirectorSplit[0];
        }
        $GLOBALS['log']->fatal("Evalua sea Vobo o Cancelada");
        if($estatus=='K' && $bean->assigned_user_id!="" && $current_user->id==$idDirector && ($producto=='1' || ($producto=='2' && ($negocio!='2' || $negocio!='10')))){//Solicitud cancelada
            $GLOBALS['log']->fatal("Condicion 1, estatus K");
            //Comprobando el fetched_row
            //Enviar notificación al asesor asignado
            //Se arma cuerpo de la notificación
            $urlSugar=$GLOBALS['sugar_config']['site_url'].'/#Opportunities/';
            $nombreCuenta=$bean->account_name;
            $idSolicitud=$bean->id;
            $linkSolicitud=$urlSugar.$idSolicitud;

            $correo_asesor="";

            $equipoPrincipal="";
            $users_bo_emails=array();

            //Obteniendo correo de director Leasing
            $beanAsesor = BeanFactory::retrieveBean('Users', $idAsesor);
            if(!empty($beanAsesor)){
                $GLOBALS['log']->fatal("Obteniendo correo de director Leasing");

                $correo_asesor=$beanAsesor->email1;
                $nombreAsesor=$beanAsesor->full_name;
                $equipoPrincipal=$beanAsesor->equipos_c;

                $GLOBALS['log']->fatal("Equipos del usuario: ".$equipoPrincipal);
            }

            if($correo_asesor!=""){

                if($equipoPrincipal!="" && $equipoPrincipal!="Equipo 0"){
                    $GLOBALS['log']->fatal("Realiza consulta cuando el equipo principal es: ".$equipoPrincipal);
                    //Puesto 6 = Backoffice Leasing
                    $queryBackOffice="SELECT id,puestousuario_c, u.status,u.user_name,uc.region_c,uc.equipos_c
                    FROM users u INNER JOIN users_cstm uc ON u.id=uc.id_c
                    WHERE uc.puestousuario_c='6' AND u.status='Active' and u.deleted=0 AND uc.equipos_c
                      LIKE'%^".$equipoPrincipal."^%'";
                    $GLOBALS['log']->fatal($queryBackOffice);
                    $queryResult = $db->query($queryBackOffice);
                    $users_bo=array();
                    if($queryResult->num_rows>0){
                        while ($row = $db->fetchByAssoc($queryResult)) {
                            array_push($users_bo,$row['id']);
                        }
                        if(count($users_bo)>0){
                            for ($i=0;$i<count($users_bo);$i++){
                                $beanAsignado = BeanFactory::retrieveBean('Users', $users_bo[$i]);
                                if(!empty($beanAsignado)){
                                    array_push($users_bo_emails,array('correo'=>$beanAsignado->email1,"nombre"=>$beanAsignado->full_name));

                                }
                            }

                        }
                    }

                }

                //$estatus=$app_list_strings['estatus_c_operacion_list'][$estatus];
                $estatusString="Rechazada";

                $cuerpoCorreo= $this->estableceCuerpoNotificacionAsesor($nombreAsesor,$nombreCuenta,$estatusString,$linkSolicitud);

                $GLOBALS['log']->fatal("ENVIANDO NOTIFICACION (ESTATUS RECHAZADA) A ASESOR ASIGNADO DE SOLICITUD ".$correo_asesor);

                $userid="";
                $recordid="";
                $userid=$current_user->id;
                $recordid=$bean->id;

                $this->enviarNotificacionDirector("Solicitud {$estatusString} {$bean->name}",$cuerpoCorreo,$correo_asesor,$nombreAsesor,array(),$users_bo_emails,$userid,$recordid);

                $oppName=$bean->name;
                $infoDirector=$bean->director_solicitud_c;
                $infoDirectorSplit=explode(",", $infoDirector);
                $nombreDirector=$infoDirectorSplit[1];
                 //obtiene el id del asesor RM Para Cancelacion
                 $beanAsesorRM = BeanFactory::retrieveBean('Users', $bean->user_id1_c);
                 $GLOBALS['log']->fatal("Evalua datos para informar al jefe RM");
                 if(!empty($beanAsesorRM)){
                     $correo_rm=$beanAsesorRM->email1;
                     $nombre_rm=$beanAsesorRM->full_name;
                    //OBTIENE CORREO DEL JEFE DEL ASESOR RM
                    $mailbossRM=array();  
                    if (!empty($beanAsesorRM->reports_to_id)){
                        $bossRM = BeanFactory::retrieveBean('Users', $beanAsesorRM->reports_to_id); 
                        if(!empty($bossRM->email1)){
                            $jefeRM_mail=$bossRM->email1;
                            $jefeRM_name=$bossRM->full_name;

                            $GLOBALS['log']->fatal("Notificacion a Jefe Asesor RM con nombre: ".$jefeRM_name. ' y correo :' .$jefeRM_mail);
                            $cuerpoCorreoBossRM= $this->NotificaDirectorRM($nombre_rm,$oppName,$linkSolicitud,$nombreDirector,$jefeRM_name);
                            $this->enviarNotificacionDirector("Solicitud {$estatusString} {$bean->name}",$cuerpoCorreoBossRM,$jefeRM_mail,$jefeRM_name,array(),$mailbossRM,$bean->user_id1_c,$bean->id);
                        }
                    } 
                }   
            }else{
                $GLOBALS['log']->fatal("ASESOR LEASING ".$nombreAsesor." NO TIENE EMAIL");
            }

        }elseif($estatus=='PE'&& $bean->assigned_user_id!="" && $current_user->id==$idDirector && ($producto=='1'|| ($producto=='2' && ($negocio!='2' || $negocio!='10')))){ //Solicitud Aprobada

            //Enviar notificación al asesor asignado
            $GLOBALS['log']->fatal("Entra condicion 2, enviar notificacion al Director asignado (estatus PE)");
            //Se arma cuerpo de la notificación
            $urlSugar=$GLOBALS['sugar_config']['site_url'].'/#Opportunities/';
            $nombreCuenta=$bean->account_name;
            $idSolicitud=$bean->id;
            $linkSolicitud=$urlSugar.$idSolicitud;
            $correo_asesor="";

            $equipoPrincipal="";
            $users_bo_emails=array();
            $GLOBALS['log']->fatal("Obtiene correo del dir leasing");
            //Obteniendo correo de director Leasing
            $beanAsesor = BeanFactory::retrieveBean('Users', $idAsesor);
            if(!empty($beanAsesor)){
                $correo_asesor=$beanAsesor->email1;
                $nombreAsesor=$beanAsesor->full_name;
                $equipoPrincipal=$beanAsesor->equipo_c;
            }
            
            if($correo_asesor!=""){
                $GLOBALS['log']->fatal("Correo Director Leasing : ".$correo_asesor);
                if($equipoPrincipal!="" && $equipoPrincipal!="Equipo 0"){
                    //Puesto 6 = Backoffice Leasing
                    $GLOBALS['log']->fatal("Estatus Aprobado, realiza consulta para equipo principal: ".$equipoPrincipal);
                    $queryBackOffice="SELECT id,puestousuario_c, u.status,u.user_name,uc.region_c,uc.equipos_c
                    FROM users u INNER JOIN users_cstm uc ON u.id=uc.id_c
                    WHERE uc.puestousuario_c='6' AND u.status='Active' and u.deleted=0 AND uc.equipos_c
                      LIKE'%^".$equipoPrincipal."^%'";
                    $queryResult = $db->query($queryBackOffice);
                    $GLOBALS['log']->fatal($queryBackOffice);
                    $users_bo=array();
                    if($queryResult->num_rows>0){
                        while ($row = $db->fetchByAssoc($queryResult)) {
                            array_push($users_bo,$row['id']);
                        }

                        if(count($users_bo)>0){
                            for ($i=0;$i<count($users_bo);$i++){
                                $beanAsignado = BeanFactory::retrieveBean('Users', $users_bo[$i]);
                                if(!empty($beanAsignado)){
                                    array_push($users_bo_emails,array('correo'=>$beanAsignado->email1,"nombre"=>$beanAsignado->full_name));
                                }
                            }

                        }
                    }

                }
                $GLOBALS['log']->fatal("Enviará notificacion AUTORIZADA, no cumple condicion de equipo != 0");
                $GLOBALS['log']->fatal("Correos Backoffice a enviar: ");
                $GLOBALS['log']->fatal("RESULTADO", print_r($users_bo_emails, true));
                //$estatusString=$app_list_strings['estatus_c_operacion_list'][$estatus];
                $estatusString="Autorizada";

                $cuerpoCorreo= $this->estableceCuerpoNotificacionAsesor($nombreAsesor,$nombreCuenta,$estatusString,$linkSolicitud,$nombre_rm);

                $GLOBALS['log']->fatal("ENVIANDO NOTIFICACION (ESTATUS AUTORIZADA) A ASESOR ASIGNADO DE SOLICITUD ".$correo_asesor);

                $userid="";
                $recordid="";
                $userid=$current_user->id;
                $recordid=$bean->id;

                $this->enviarNotificacionDirector("Solicitud {$estatusString} {$bean->name}",$cuerpoCorreo,$correo_asesor,$nombreAsesor,array(),$users_bo_emails,$userid,$recordid);

                //Manda ejecutar funcion para envio de notificacion a asesor RM 1.-Genera cuerpo de correo 2.- Envia notificacion al director de la solicitud
                $GLOBALS['log']->fatal("Crea cuerpo de notificacion a Asesor RM");
                $oppName=$bean->name;
                $infoDirector=$bean->director_solicitud_c;
                $infoDirectorSplit=explode(",", $infoDirector);
                $nombreDirector=$infoDirectorSplit[1];
                 //obtiene el id del asesor RM
                 $beanAsesorRM = BeanFactory::retrieveBean('Users', $bean->user_id1_c);
                 
                 if(!empty($beanAsesorRM)){
                     $correo_rm=$beanAsesorRM->email1;
                     $nombre_rm=$beanAsesorRM->full_name;
                    //OBTIENE CORREO DEL JEFE DEL ASESOR RM
                    $mailbossRM=array();  
                    if (!empty($bean->reports_to_id)){
                        $queryBoss="SELECT t1.email_address, t3.first_name,t3.last_name
                    FROM email_addresses t1
                    INNER JOIN email_addr_bean_rel t2 ON t2.email_address_id = t1.id AND t2.primary_address=1 AND t2.deleted=0
                    INNER JOIN users t3 ON t3.id = t2.bean_id AND t2.bean_module='Users'
                    WHERE t1.deleted = 0
                    AND t3.id ='{$bean->reports_to_id}'";
                        $queryResult = $db->query($queryBoss);
                        while ($row = $db->fetchByAssoc($queryResult)) {
                            if (!empty($row['email_address'])) {
                                $full_name="'{$row['first_name']}' '{$row['last_name']}'";
                                $mailBoss="'{$row['email_address']}";
                                $GLOBALS['log']->fatal("Correo del Boss RM a notificar :".$row['email_address'].' y con nombre completo :'.$full_name);
                                array_push($mailbossRM,array('correo'=>$mailBoss,"nombre"=>$full_name));
                            }
                        }
                    }    
                    $GLOBALS['log']->fatal("Notificacion a Asesor RM con nombre: ".$nombre_rm. ' y correo :' .$correo_rm);
                    $GLOBALS['log']->fatal("Valores de Jefe  RM: ".json_encode($mailbossRM));
                    //$cuerpoCorreoRM= $this->NotificacionRM($nombre_rm,$oppName,$linkSolicitud,$nombreDirector);
                    //$this->enviarNotificacionDirector("Solicitud {$estatusString} {$bean->name}",$cuerpoCorreoRM,$correo_rm,$nombre_rm,array(),$mailbossRM,$bean->user_id1_c,$bean->id);
                    
                    //Actualizar el usuario RM a la cuenta 
                    /*if(!empty($bean->user_id1_c)){
                        $GLOBALS['log']->fatal("Actualiza Asesor RM en la Cuenta ".$bean->account_name. 'con valor '.$bean->user_id1_c);
                        $queryUpdateRM = "UPDATE accounts_cstm SET user_id8_c='{$bean->user_id1_c}' WHERE id_c='{$bean->account_id}';";
                        $GLOBALS['log']->fatal($queryUpdateRM);
                        $ExecuteRMUpdate = $db->query($queryUpdateRM);
                    }*/
                 }               
            }else{
                $GLOBALS['log']->fatal("ASESOR LEASING ".$nombreAsesor." NO TIENE EMAIL");
            }
            $GLOBALS['log']->fatal("Finaliza notificaEstatusAsesor");
        }

    }

    function notificaParticipacionRM($bean, $event, $arguments){
        global $app_list_strings;
        global $current_user;
        global $db;
        $GLOBALS['log']->fatal("Inicia notificaParticipacionRM RM");
        $GLOBALS['log']->fatal("Valor director Notificado: " .$bean->director_notificado_c);
        $GLOBALS['log']->fatal("Valor Doc Scoring: " .$bean->doc_scoring_chk_c);
        $GLOBALS['log']->fatal("Valor vobo Dir: ".$bean->vobo_dir_c);
        $GLOBALS['log']->fatal("Valor Status Opp: ".$bean->estatus_c);
        $GLOBALS['log']->fatal("Valor Producto: " .$bean->tipo_producto_c);
        $mailbossRM_acc=array();
        if ($bean->director_notificado_c==1 && $bean->doc_scoring_chk_c==1 && $bean->vobo_dir_c==1 && $bean->estatus_c=='1' && ($bean->tipo_producto_c=="1" || $bean->tipo_producto_c=='2')){
            //Notificacion 1.-
            //Validacion para enviar notificacion al asesor RM asignado a la opp
            //obtiene el bean de la cuenta y el valor del asesor RM
            $GLOBALS['log']->fatal("Inicia Notificacion 1 RM");
            $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id);
            $asesorRMacc= $beanCuenta->user_id8_c;
            //Valor de  usuario 9 - Sin Gestor
            $Valor= "569246c7-da62-4664-ef2a-5628f649537e";
            $reports_to_id="";
            if($asesorRMacc==$bean->user_id1_c && $asesorRMacc!=$Valor && ($bean->user_id1_c!=$Valor || !empty($bean->user_id1_c))){
                $GLOBALS['log']->fatal("Cumple Notificacion 1 RM");
                //Recupera informacion y jefe RM del asesor RM de la cuenta
                $GLOBALS['log']->fatal("Recupera informacion y jefe RM del asesor RM de la cuenta");
                $queryasesor="SELECT t1.email_address, t3.first_name,t3.last_name,t3.reports_to_id
                FROM email_addresses t1
                INNER JOIN email_addr_bean_rel t2 ON t2.email_address_id = t1.id AND t2.primary_address=1 AND t2.deleted=0
                INNER JOIN users t3 ON t3.id = t2.bean_id AND t2.bean_module='Users'
                WHERE t1.deleted = 0
                AND t3.id ='$asesorRMacc'";
                $GLOBALS['log']->fatal("Ejecuta " .print_r($queryasesor, true));
                $queryResult = $db->query($queryasesor);
                while ($row = $db->fetchByAssoc($queryResult)) {
                    if (!empty($row['email_address'])) {
                    $NombreRMacc=$row['first_name'].' '.$row['last_name'];
                    $CorreoRMAcc=$row['email_address'];
                    $reports_to_id=$row['reports_to_id'];
                    }
                }
                $GLOBALS['log']->fatal("Obtiene valores del Asesor RM de la CUENTA :" .$NombreRMacc);
                $GLOBALS['log']->fatal("OBTIENE CORREO DEL JEFE DEL ASESOR RM");
                $mailbossRM_acc=array();
                if(!empty($reports_to_id)){
                    //OBTIENE CORREO DEL JEFE DEL ASESOR RM
                    $GLOBALS['log']->fatal("Obtiene nombre y correo del JEFE RM de la cuenta");
                    //Ejecuta consulta para traer datos del jefe RM de la cuenta
                    $queryBoss="SELECT t1.email_address, t3.first_name,t3.last_name
                    FROM email_addresses t1
                    INNER JOIN email_addr_bean_rel t2 ON t2.email_address_id = t1.id AND t2.primary_address=1 AND t2.deleted=0
                    INNER JOIN users t3 ON t3.id = t2.bean_id AND t2.bean_module='Users'
                    WHERE t1.deleted = 0
                    AND t3.id = '{$reports_to_id}'";
                    $queryResult = $db->query($queryBoss);
                    while ($row = $db->fetchByAssoc($queryResult)) {
                        if (!empty($row['email_address'])) {
                        $GLOBALS['log']->fatal("Recupera valores de full name y correo del boss RM.");
                        $full_name=$row['first_name'].' '.$row['last_name'];
                        $mailBoss=$row['email_address'];
                        $GLOBALS['log']->fatal("Correo del Boss RM a notificar :".$mailBoss.' y con nombre completo :'.$full_name);
                        array_push($mailbossRM_acc,array('correo'=>$mailBoss,"nombre"=>$full_name));
                        }
                    }
                } 
                //Setea a Marco Antonio Flores
                $GLOBALS['log']->fatal("Setea a Marco Antonio Flores");
                $BossRM = $app_list_strings['JefeRM_list'];
                foreach ($BossRM as $nombre => $correo) {
                    //Acción para agregar en arreglo
                    array_push($mailbossRM_acc,array('correo'=>$correo,"nombre"=>$nombre));
                }
                
                if (!empty($CorreoRMAcc)){
                    $GLOBALS['log']->fatal("Envia Notificacion 1 al RM y jefe RM de la cuenta :".$NombreRMacc .' con jefe ' .$full_name);
                    //Se declaran parametros extras (url y director OPP)
                    $urlSugar=$GLOBALS['sugar_config']['site_url'].'/#Opportunities/';
                    $idSolicitud=$bean->id;
                    $linkSolicitud=$urlSugar.$idSolicitud;
                    $infoDirector=$bean->director_solicitud_c;
                    $infoDirectorSplit=explode(",", $infoDirector);
                    $idDirector=$infoDirectorSplit[0];
                    $nombreDirector=$infoDirectorSplit[1];
                    $oppName=$bean->name;
                    $GLOBALS['log']->fatal("Notificacion1 == Arreglo de RM's : ".json_encode($mailbossRM_acc));
                    //Envia notificacion al RM y jefe RM de la cuenta previo
                    $cuerpoCorreonotifRM= $this->NotificaRM1($NombreRMacc,$oppName,$linkSolicitud,$nombreDirector);
                    $this->enviarNotificacionDirector("Solicitud autorizada {$bean->name}",$cuerpoCorreonotifRM,$CorreoRMAcc,$NombreRMacc,array(),$mailbossRM_acc,$bean->user_id1_c,$bean->id);
                }
                $GLOBALS['log']->fatal("Termina Notificacion 1 RM");
            }             
            //Notificacion 2.-
            //Valida que el RM en la opp sea vacio o 9 - sin Gestor
            if ($bean->user_id1_c=="" || $bean->user_id1_c==$Valor) {
                $GLOBALS['log']->fatal("Inicia Notificacion 2 RM");
                //obtiene el id del asesor RM
                $beanAsesorRM = BeanFactory::retrieveBean('Users', $bean->user_id1_c);
                $mailbossRM_acc=array();
                //El valor es el 9- sin Gestor, se opta por traer el RM de la cuenta
                $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id);
                $accountRM= $beanCuenta->user_id8_c;
                $reports_to_id="";
                $NombreRMacc="";
	            //Validamos que la cuenta no tenga 9.- Sin gestor, de no ser asi, se obtiene a su jefe para notifiacion
                if ($accountRM !="" && $accountRM!=$Valor){
                    //Recupera informacion del RM de la cuenta y su jefe
                        $queryasesorRM="SELECT t1.email_address, t3.first_name,t3.last_name,t3.reports_to_id
                        FROM email_addresses t1
                        INNER JOIN email_addr_bean_rel t2 ON t2.email_address_id = t1.id AND t2.primary_address=1 AND t2.deleted=0
                        INNER JOIN users t3 ON t3.id = t2.bean_id AND t2.bean_module='Users'
                        WHERE t1.deleted = 0
                        AND t3.id ='{$accountRM}'";
                        $queryResult = $db->query($queryasesorRM);
                        while ($row = $db->fetchByAssoc($queryResult)) {
                            if (!empty($row['reports_to_id'])) {
                                $NombreRMacc=$row['first_name'].' '.$row['last_name'];
                                $reports_to_id=$row['reports_to_id'];
                            }
                        }   
                        //Ejecuta segunda consulta para traer el nombre completo y correo del jefe RM de la cuenta
                        $queryBoss="SELECT t1.email_address, t3.first_name,t3.last_name
                        FROM email_addresses t1
                        INNER JOIN email_addr_bean_rel t2 ON t2.email_address_id = t1.id AND t2.primary_address=1 AND t2.deleted=0
                        INNER JOIN users t3 ON t3.id = t2.bean_id AND t2.bean_module='Users'
                        WHERE t1.deleted = 0
                        AND t3.id ='{$reports_to_id}'";
                        $queryResult = $db->query($queryBoss);
                        while ($row = $db->fetchByAssoc($queryResult)) {
                            if (!empty($row['email_address'])) {
                                $GLOBALS['log']->fatal("Recupera valores de full name y correo del boss RM de la cuenta asi como setea a Marco Antonio Flores");
                                $full_name=$row['first_name'].' '.$row['last_name'];
                                $mailBoss=$row['email_address'];
                                $GLOBALS['log']->fatal("Correo del jefe RM de la Cuenta :".$mailBoss.' y con nombre completo :'.$full_name);
                                array_push($mailbossRM_acc,array('correo'=>$mailBoss,"nombre"=>$full_name));
                                //Setea a Marco Antonio Flores
                                $BossRM = $app_list_strings['JefeRM_list'];
                                    foreach ($BossRM as $nombre => $correo) {
                                        //Acción para agregar en arreglo
                                        array_push($mailbossRM_acc,array('correo'=>$correo,"nombre"=>$nombre));
                                    }
                            }
                        }
                        //Se declaran parametros extras (url y director OPP)
                    $urlSugar=$GLOBALS['sugar_config']['site_url'].'/#Opportunities/';
                    $idSolicitud=$bean->id;
                    $linkSolicitud=$urlSugar.$idSolicitud;
                    $infoDirector=$bean->director_solicitud_c;
                    $infoDirectorSplit=explode(",", $infoDirector);
                    $idDirector=$infoDirectorSplit[0];
                    $nombreDirector=$infoDirectorSplit[1];
                    $oppName=$bean->name;
                //Ejecuta funciones para envio de notificacion
                $GLOBALS['log']->fatal("Envia Notificacion 2 al RM y jefe RM de la cuenta :".$NombreRMacc .' con jefe ' .$full_name);
                $CorreoRMAccount= $this->NotificaRM2($NombreRMacc,$oppName,$linkSolicitud,$nombreDirector);
                $this->enviarNotificacionDirector("Sin participación de RM {$bean->name}",$CorreoRMAccount,$mailBoss,$full_name,array(),$mailbossRM_acc,$bean->user_id1_c,$bean->id); 
                $GLOBALS['log']->fatal("Termina Notificacion 2 RM");
                }
	        }
            //Notificacion 3.-
            //Valida que el RM en la opp sea vacio o 9 - sin Gestor
            if ($bean->user_id1_c!="" && $bean->user_id1_c!=$Valor) {
                $GLOBALS['log']->fatal("Inicia Notificacion 3 RM");
                    //obtiene el id del asesor RM
                $beanAsesorRM = BeanFactory::retrieveBean('Users', $bean->user_id1_c);
                //Valor de  usuario 9 - Sin Gestor
                $Valor= "569246c7-da62-4664-ef2a-5628f649537e";
                $mailbossesRM_acc=array();
                //El valor es el 9- sin Gestor, se opta por traer el RM de la cuenta
                $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id);
                $accountRM= $beanCuenta->user_id8_c;
                $reports_to_id="";
                //Validamos que la cuenta no tenga 9.- Sin gestor pero que sea diferente al RM de la opp
                if ($accountRM!=$Valor && $accountRM!=$bean->user_id1_c){
                    //Recupera informacion del RM de la cuenta y su jefe
                        $queryasesorRM="SELECT t1.email_address, t3.first_name,t3.last_name,t3.reports_to_id
                        FROM email_addresses t1
                        INNER JOIN email_addr_bean_rel t2 ON t2.email_address_id = t1.id AND t2.primary_address=1 AND t2.deleted=0
                        INNER JOIN users t3 ON t3.id = t2.bean_id AND t2.bean_module='Users'
                        WHERE t1.deleted = 0
                        AND t3.id ='{$accountRM}'";
                        $queryResult = $db->query($queryasesorRM);
                        while ($row = $db->fetchByAssoc($queryResult)) {
                            if (!empty($row['reports_to_id'])) {
                            $reports_to_id=$row['reports_to_id'];
                            $asesorAccount=$row['first_name'].' '.$row['last_name'];
                            $mailasesorAcccount=$row['email_address'];
                            }
                        }   
                        //Ejecuta segunda consulta para traer el nombre completo y correo del jefe RM de la cuenta
                        $queryBoss="SELECT t1.email_address, t3.first_name,t3.last_name
                        FROM email_addresses t1
                        INNER JOIN email_addr_bean_rel t2 ON t2.email_address_id = t1.id AND t2.primary_address=1 AND t2.deleted=0
                        INNER JOIN users t3 ON t3.id = t2.bean_id AND t2.bean_module='Users'
                        WHERE t1.deleted = 0
                        AND t3.id ='{$reports_to_id}'";
                        $queryResult = $db->query($queryBoss);
                        while ($row = $db->fetchByAssoc($queryResult)) {
                            if (!empty($row['email_address'])) {
                                $GLOBALS['log']->fatal("Recupera valores de full name y correo del boss RM de la cuenta asi como setea a Marco Antonio Flores");
                                $full_nameBossAcc=$row['first_name'].' '.$row['last_name'];
                                $mailBossAcc=$row['email_address'];
                                $GLOBALS['log']->fatal("Correo del jefe RM de la Cuenta :".$mailBossAcc.' y con nombre completo :'.$full_nameBossAcc);
                                array_push($mailbossesRM_acc,array('correo'=>$mailBossAcc,"nombre"=>$full_nameBossAcc));
                                //Setea a Marco Antonio Flores
                                $BossRM = $app_list_strings['JefeRM_list'];
                                    foreach ($BossRM as $nombre => $correo) {
                                        //Acción para agregar en arreglo
                                        array_push($mailbossesRM_acc,array('correo'=>$correo,"nombre"=>$nombre));
                                    }
                            }
                        }
                        //Se obtiene informacion del RM de la OPP asi como su jefe para añadirse en el $mailbossRM_acc
                        //Recupera informacion del RM de la cuenta y su jefe
                        $reports_to_id2="";
                        $queryasesorRM="SELECT t1.email_address, t3.first_name,t3.last_name,t3.reports_to_id
                        FROM email_addresses t1
                        INNER JOIN email_addr_bean_rel t2 ON t2.email_address_id = t1.id AND t2.primary_address=1 AND t2.deleted=0
                        INNER JOIN users t3 ON t3.id = t2.bean_id AND t2.bean_module='Users'
                        WHERE t1.deleted = 0
                        AND t3.id ='{$bean->user_id1_c}'";
                        $queryResult = $db->query($queryasesorRM);
                        while ($row = $db->fetchByAssoc($queryResult)) {
                            if (!empty($row['reports_to_id'])) {
                            $reports_to_id2=$row['reports_to_id'];
                            $asesorRMn=$row['first_name'].' '.$row['last_name'];
                            $mailasesorRMn=$row['email_address'];
                            array_push($mailbossesRM_acc,array('correo'=>$mailasesorRMn,"nombre"=>$asesorRMn));
                            }
                        }
                        //Ejecuta segunda consulta para traer el nombre completo y correo del jefe RM de la Opp
                        $queryBoss="SELECT t1.email_address, t3.first_name,t3.last_name
                        FROM email_addresses t1
                        INNER JOIN email_addr_bean_rel t2 ON t2.email_address_id = t1.id AND t2.primary_address=1 AND t2.deleted=0
                        INNER JOIN users t3 ON t3.id = t2.bean_id AND t2.bean_module='Users'
                        WHERE t1.deleted = 0
                        AND t3.id ='{$reports_to_id2}'";
                        $queryResult = $db->query($queryBoss);
                        while ($row = $db->fetchByAssoc($queryResult)) {
                            if (!empty($row['email_address'])) {
                                $GLOBALS['log']->fatal("Recupera valores de full name y correo del boss RM de la opp asi como setea a Marco Antonio Flores");
                                $full_nameBossOpp=$row['first_name'].' '.$row['last_name'];
                                $mailBossOpp=$row['email_address'];
                                $GLOBALS['log']->fatal("Correo del jefe RM de la Cuenta :".$mailBossOpp.' y con nombre completo :'.$full_nameBossOpp);
                                array_push($mailbossesRM_acc,array('correo'=>$mailBossOpp,"nombre"=>$full_nameBossOpp));
                                //Setea a Marco Antonio Flores
                                $BossRM = $app_list_strings['JefeRM_list'];
                                    foreach ($BossRM as $nombre => $correo) {
                                        //Acción para agregar en arreglo
                                        array_push($mailbossesRM_acc,array('correo'=>$correo,"nombre"=>$nombre));
                                    }
                            }
                        }   
                        $infoDirector=$bean->director_solicitud_c;
                        $infoDirectorSplit=explode(",", $infoDirector);
                        $IdDirector=$infoDirectorSplit[0];
                        $nombreDirector=$infoDirectorSplit[1];
                        $queryasesorRM="SELECT t1.email_address, t3.first_name,t3.last_name
                        FROM email_addresses t1
                        INNER JOIN email_addr_bean_rel t2 ON t2.email_address_id = t1.id AND t2.primary_address=1 AND t2.deleted=0
                        INNER JOIN users t3 ON t3.id = t2.bean_id AND t2.bean_module='Users'
                        WHERE t1.deleted = 0
                        AND t3.id ='$IdDirector'";
                        $queryResult = $db->query($queryasesorRM);
                        while ($row = $db->fetchByAssoc($queryResult)) {
                            if (!empty($row['email_address'])) {
                            $DirectorFullname=$row['first_name'].' '.$row['last_name'];
                            $mailDirector=$row['email_address'];
                            }
                        }
                    $GLOBALS['log']->fatal("Director de la OPP: " .$DirectorFullname.' con correo: ' .$mailDirector);
                    $GLOBALS['log']->fatal("Arreglo de RM's : ".json_encode($mailbossesRM_acc));
                    //Se declaran parametros extras (url y director OPP)
                    $urlSugar=$GLOBALS['sugar_config']['site_url'].'/#Opportunities/';
                    $idSolicitud=$bean->id;
                    $linkSolicitud=$urlSugar.$idSolicitud;
                    $oppName=$bean->name;
                    //Ejecuta funciones para envio de notificacion al Asesor y Jefe RM de la Cuenta
                    $GLOBALS['log']->fatal("Envia Notificacion 3 al RM y jefe RM de la cuenta :".$asesorRMn .' con jefe ' .$full_nameBossOpp);
                    $BodyNotif3= $this->NotificaRM3($asesorAccount,$oppName,$linkSolicitud,$nombreDirector,$asesorRMn);
                    $this->enviarNotificacionDirector("Cambio de asesor RM en:  {$bean->name}",$BodyNotif3,$mailDirector,$DirectorFullname,array(),$mailbossesRM_acc,$bean->user_id1_c,$bean->id);

                    //Actualizar el usuario RM a la cuenta 
                    if(!empty($bean->user_id1_c)){
                        $GLOBALS['log']->fatal("Actualiza Asesor RM en la Cuenta ".$bean->account_name. 'con valor '.$bean->user_id1_c);
                        $queryUpdateRM = "UPDATE accounts_cstm SET user_id8_c='$bean->user_id1_c' WHERE id_c='$bean->account_id'";
                        $GLOBALS['log']->fatal($queryUpdateRM);
                        $ExecuteRMUpdate = $db->query($queryUpdateRM);
                    }
                }
                $GLOBALS['log']->fatal("Termina Notificacion 3 RM");
            }  
           
       }
    }   

    public function estableceCuerpoNotificacion($nombreDirector,$nombreCuenta,$linkSolicitud,$descripcion,$nombre_rm=null,$idRM,$Valor,$producto){
        global $app_list_strings;

        //Añadir validacion para envio de producto (no etiqueta)
        $etiqueta= $app_list_strings['tipo_producto_list'][$producto];
        //$GLOBALS['log']->fatal("Valor de Producto a Notificacion :" .$etiqueta);
        if ($idRM!=$Valor && !empty($nombre_rm)){      
            $mensaje='<br><br>Se le informa que se ha generado una solicitud de '.$etiqueta. ' para la cuenta: <b>'. $nombreCuenta.'</b> ; se solicita su aprobación y validación de participación del asesor RM <b>'.$nombre_rm.'.</b>';  
        }else{
            $mensaje='<br><br>Se le informa que se ha generado una solicitud de '.$etiqueta. ' para la cuenta: <b>'. $nombreCuenta.'</b> y se solicita su aprobación.'; 
        }
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombreDirector . '</b>'.
                $mensaje.'
                <br><br>Para ver el detalle de la solicitud dé <a id="linkSolicitud" href="'. $linkSolicitud.'">clic aquí</a>
                <br><br>Se adjunta documento con scoring comercial
                <br><br>Comentarios de asesor:<br>'.$descripcion.'
                <br><br>Atentamente Unifin</font></p>
                <br><p class="imagen"><img border="0" width="350" height="107" style="width:3.6458in;height:1.1145in" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
                <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
                <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
                Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
                Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
                No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
                Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';
        
        return $mailHTML;

    }

    public function estableceCuerpoNotificacionAsesor($nombreAsesor,$nombreCuenta,$estatus,$linkSolicitud){
        
        $mensaje="";
        if($estatus=="Autorizada"){
            $estatus="cuenta con el VoBo del director de producto";
            $mensaje='<br><br>Se le informa que la propuesta a nombre de:  <b>'. $nombreCuenta.'</b> recibió el VoBo para continuar con la integración del expediente';
        }
        if($estatus=="Rechazada"){
            $estatus="ha sido Rechazada";
            $mensaje='<br><br>Se le informa que la solicitud para la cuenta:  <b>'. $nombreCuenta.'</b> '.$estatus.'';
        }


        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombreAsesor . '</b>'.
            $mensaje.'
      <br><br>Para ver el detalle de la solicitud dé <a id="linkSolicitud" href="'. $linkSolicitud.'">clic aquí</a>
      <br><br>Atentamente Unifin</font></p>
      <br><p class="imagen"><img border="0" width="350" height="107" style="width:3.6458in;height:1.1145in" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
      <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
      <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
       Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
       Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
       No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
       Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        return $mailHTML;

    }

    public function enviarNotificacionDirector($asunto,$cuerpoCorreo,$correoDirector,$nombreDirector,$adjuntos=array(),$recipients=array() , $userid,$recordid){
        //Enviando correo a asesor origen
        $GLOBALS['log']->fatal("ENVIA A :".$correoDirector.', '.$nombreDirector);
        $insert = '';
        $hoy = date("Y-m-d H:i:s");
        $cc ='';
        $GLOBALS['log']->fatal("Correo Jefe RM :".print_r($recipients,true));
        try{
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject($asunto);
            $body = trim($cuerpoCorreo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            $mailer->addRecipientsTo(new EmailIdentity($correoDirector, $nombreDirector));
            if(count($recipients)>0){
                for($i=0;$i<count($recipients);$i++){
                    $mailer->addRecipientsCc(new EmailIdentity($recipients[$i]['correo'], $recipients[$i]['nombre']));
                    $cc = $cc.$recipients[$i]['correo'].',';
                }

            }

            /*Se agregan como copia oculta Correos de Wendy Reyes y Cristian Carral*/
            $mailer->addRecipientsBcc(new EmailIdentity('ccarral@unifin.com.mx', 'Cristian Carral'));
            $mailcco = 'ccarral@unifin.com.mx';

            //Añadiendo múltiples adjuntos
            $GLOBALS['log']->fatal("ADJUNTOS TIENE: ".count($adjuntos)." ELEMENTOS");
            if(count($adjuntos)>0){
                for($i=0;$i<count($adjuntos);$i++){
                    $mailer->addAttachment(new \Attachment($adjuntos[$i]));
                    $GLOBALS['log']->fatal("SE ADJUNTA ARCHIVO: ".$adjuntos[$i]);
                }
            }
            $result = $mailer->send();

            //$GLOBALS['log']->fatal('mailer',$mailer);

            if($correoDirector != ''){
                $insert = "INSERT INTO user_email_log (id, user_id , related_id ,date_entered, name_email, subject,type,related_type,status,description)
                VALUES (uuid() , '{$userid}' , '{$recordid}', '{$hoy}','{$correoDirector}', '{$asunto}','TO', 'Solicitudes','OK', 'Correo exitosamente enviado')";
            }
            //$GLOBALS['log']->fatal($insert);
            $GLOBALS['db']->query($insert);
            if($cc !=''){
                $insert = "INSERT INTO user_email_log (id, user_id , related_id ,date_entered, name_email, subject,type,related_type,status,description)
                VALUES (uuid() , '{$userid}' , '{$recordid}', '{$hoy}','{$cc}', '{$asunto}','CC', 'Solicitudes','OK','Correo exitosamente enviado')";
                $GLOBALS['db']->query($insert);
            }

            $insert = "INSERT INTO user_email_log (id, user_id , related_id ,date_entered, name_email, subject,type,related_type,status,description)
            VALUES (uuid() , '{$userid}' , '{$recordid}', '{$hoy}','{$mailcco}', '{$asunto}','CCO', 'Solicitudes','OK','Correo exitosamente enviado')";
            $GLOBALS['db']->query($insert);

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ".$nombreDirector);
            $GLOBALS['log']->fatal("Exception ".$e);

            $insert = "INSERT INTO user_email_log (id, user_id , related_id ,date_entered, name_email, subject,type,related_type,status,error_code,description)
            VALUES (uuid() , '{$userid}' , '{$recordid}','{$hoy}','".$correoDirector."-".$cc."-".$mailcco."' , '{$asunto}','to', 'Solicitudes','ERROR','01', '{$e->getMessage()}')";
            //$GLOBALS['log']->fatal($insert);
            $GLOBALS['db']->query($insert);
        } catch (MailerException $me) {
            $message = $me->getMessage();
            switch ($me->getCode()) {
                case \MailerException::FailedToConnectToRemoteServer:
                    $GLOBALS["log"]->fatal("BeanUpdatesMailer :: error sending email, system smtp server is not set");
                    break;
                default:
                    $GLOBALS["log"]->fatal("BeanUpdatesMailer :: error sending e-mail (method: {$mailTransmissionProtocol}), (error: {$message})");
                    break;
            }
            $insert = "INSERT INTO user_email_log (id, user_id , related_id ,date_entered, name_email, subject,type,related_type,status,error_code,description)
            VALUES (uuid() , '{$userid}' , '{$recordid}','{$hoy}' ,'".$correoDirector."-".$cc."-".$mailcco."', '{$asunto}','to', 'Solicitudes','ERROR','02', '{$message}')";
            //$GLOBALS['log']->fatal($insert);
            $GLOBALS['db']->query($insert);
        }

    }

    public function NotificacionRM($nombre_rm,$oppName,$linkSolicitud,$nombreDirector){
        
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombre_rm . '</b>
      <br><br>Se le informa que ha sido validada su participación en la solicitud: ' .$oppName .', por el director: '.$nombreDirector.'
      <br><br>Para ver el detalle de la solicitud dé <a id="linkSolicitud" href="'. $linkSolicitud.'">clic aquí</a>
      <br><br>Atentamente Unifin
      <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
      <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
       Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
       Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
       No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
       Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        $GLOBALS['log']->fatal("Inicia NotificacionRM envio de mensaje a AsesoRM ".$mailHTML);
        return $mailHTML;

    }

    public function NotificaDirectorRM($nombre_rm,$oppName,$linkSolicitud,$nombreDirector,$jefe_rm){
        
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $jefe_rm . '</b>
      <br><br>Se le informa que ha sido rechazada la participación del asesor ' .$nombre_rm .', para la solicitud: '.$oppName.', por el director: '.$nombreDirector.'
      <br><br>Para ver el detalle de la solicitud dé <a id="linkSolicitud" href="'. $linkSolicitud.'">clic aquí</a>
      <br><br>Atentamente Unifin
      <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
      <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
       Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
       Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
       No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
       Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        $GLOBALS['log']->fatal("Inicia NotificacionRM envio de mensaje a AsesoRM ".$mailHTML);
        return $mailHTML;

    }
    public function NotificaRM1($nombre_rm,$oppName,$linkSolicitud,$nombreDirector){
        
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b></b>
      <br><br>Se le informa que el director ' .$nombreDirector .' ha confirmado que el asesor RM '.$nombre_rm.' tuvo participación en la operación ligada a la solicitud '.$oppName.'
      <br><br>Para ver el detalle de la solicitud dé <a id="linkSolicitud" href="'. $linkSolicitud.'">clic aquí</a>
      <br><br>Atentamente Unifin

      <br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/blog/wp-content/uploads/2021/01/UNIFIN_centrado_Poder2.png"></span></p>
      <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
      <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
       Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
       Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
       No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
       Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        $GLOBALS['log']->fatal("Inicia NotificaRM1 ".$mailHTML);
        return $mailHTML;

    }

    public function NotificaRM2($NombreRMacc,$oppName,$linkSolicitud,$nombreDirector){
        
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b></b>
      <br><br>Se le informa que el director ' .$nombreDirector .' ha confirmado que el asesor RM '.$NombreRMacc.' no tuvo participación en la operación ligada a la solicitud '.$oppName.'
      <br><br>Para ver el detalle de la solicitud dé <a id="linkSolicitud" href="'. $linkSolicitud.'">clic aquí</a>
      <br><br>Atentamente Unifin

      <br><p class="imagen"><img border="0"  id="bannerUnifin" src="https://www.unifin.com.mx/blog/wp-content/uploads/2021/01/UNIFIN_centrado_Poder2.png"></span></p>
      <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
      <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
       Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
       Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
       No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
       Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        $GLOBALS['log']->fatal("Inicia NotificacionRM envio de mensaje a AsesoRM ".$mailHTML);
        return $mailHTML;

    }

    public function NotificaRM3($asesorAccount,$oppName,$linkSolicitud,$nombreDirector,$asesorRMn){
        
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b></b>
      <br><br>Se le informa que el director ' .$nombreDirector .' ha confirmado que el asesor RM '.$asesorRMn.' participó en la operación ligada a la solicitud: '.$oppName.', en lugar del asesor RM ' .$asesorAccount.' asociado originalmente a la operación. 
      <br><br>Para ver el detalle de la solicitud dé <a id="linkSolicitud" href="'. $linkSolicitud.'">clic aquí</a>
      <br><br>Atentamente Unifin

      <br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/blog/wp-content/uploads/2021/01/UNIFIN_centrado_Poder2.png"></span></p>
      <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
      <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
       Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
       Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
       No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
       Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        $GLOBALS['log']->fatal("Inicia NotificacionRM envio de mensaje a AsesoRM ".$mailHTML);
        return $mailHTML;

    }
}