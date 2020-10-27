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
                    $cuerpoCorreo= $this->estableceCuerpoNotificacion($nombreDirector,$nombreCuenta,$linkSolicitud,$descripcion);

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

        $infoDirector=$bean->director_solicitud_c;
        $idDirector="";
        if($infoDirector!=""){
            $infoDirectorSplit=explode(",", $infoDirector);
            $idDirector=$infoDirectorSplit[0];
        }

        if($estatus=='K' && $bean->assigned_user_id!="" && $current_user->id==$idDirector && $producto=='1'){//Solicitud cancelada
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
                      IN('^".$equipoPrincipal."^')";
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

                $this->enviarNotificacionDirector("Solicitud {$estatusString} {$bean->name}",$cuerpoCorreo,$correo_asesor,$nombreAsesor,array(),$users_bo_emails);

            }else{
                $GLOBALS['log']->fatal("ASESOR LEASING ".$nombreAsesor." NO TIENE EMAIL");
            }

        }elseif($estatus=='PE' && $bean->assigned_user_id!="" && $current_user->id==$idDirector && $producto=='1'){ //Solicitud Aprobada

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
                      IN('^".$equipoPrincipal."^')";
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

                $cuerpoCorreo= $this->estableceCuerpoNotificacionAsesor($nombreAsesor,$nombreCuenta,$estatusString,$linkSolicitud);

                $GLOBALS['log']->fatal("ENVIANDO NOTIFICACION (ESTATUS AUTORIZADA) A ASESOR ASIGNADO DE SOLICITUD ".$correo_asesor);

                $this->enviarNotificacionDirector("Solicitud {$estatusString} {$bean->name}",$cuerpoCorreo,$correo_asesor,$nombreAsesor,array(),$users_bo_emails);

            }else{
                $GLOBALS['log']->fatal("ASESOR LEASING ".$nombreAsesor." NO TIENE EMAIL");
            }

        }

    }


    public function estableceCuerpoNotificacion($nombreDirector,$nombreCuenta,$linkSolicitud,$descripcion){


        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombreDirector . '</b>
      <br><br>Se le informa que se ha generado una solicitud de Leasing para la cuenta: <b>'. $nombreCuenta.'</b> y se solicita su VoBo.
      <br><br>Para ver el detalle de la solicitud dé <a id="linkSolicitud" href="'. $linkSolicitud.'">click aquí</a>
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
      <br><br>Para ver el detalle de la solicitud dé <a id="linkSolicitud" href="'. $linkSolicitud.'">click aquí</a>
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
        $insert = '';
        $hoy = date("Y-m-d H:i:s");
        $cc ='';

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
            $mailer->addRecipientsBcc(new EmailIdentity('wendy.reyes@unifin.com.mx', 'Wendy Reyes Peralta'));
            $mailer->addRecipientsBcc(new EmailIdentity('ccarral@unifin.com.mx', 'Cristian Carral'));
            $mailcco = 'wendy.reyes@unifin.com.mx,ccarral@unifin.com.mx';

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

}