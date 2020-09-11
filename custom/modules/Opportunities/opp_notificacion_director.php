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
        if($bean->director_solicitud_c!="" && $bean->director_solicitud_c!=null && $bean->director_notificado_c==0 && $bean->doc_scoring_chk_c==1 && $bean->tipo_de_operacion_c!='RATIFICACION_INCREMENTO'){

            $documento="";
            $extensionArchivo="";
            //ToDo Comprobar que tiene documento adjunto
            if($bean->load_relationship('opportunities_documents_1')){
                $beansDocs = $bean->opportunities_documents_1->getBeans();
                if (!empty($beansDocs)) {
                    foreach($beansDocs as $doc){

                        if($doc->tipo_documento_c=='3'){
                            $documento=$doc->document_revision_id;
                            $nombreArchivo=$doc->filename;
                            $explodeNameArchivo=explode(".", $nombreArchivo);
                            $extensionArchivo=$explodeNameArchivo[1];
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

            $correo_director="";

            //Obteniendo correo de director Leasing
            $beanDirector = BeanFactory::retrieveBean('Users', $idDirector);
            if(!empty($beanDirector)){
                $correo_director=$beanDirector->email1;
                $nombreDirector=$beanDirector->full_name;
            }

            $urlSugarDoc=$GLOBALS['sugar_config']['site_url'].'/#Documents/';

            if($correo_director!=""){
                $adjunto="";
                if($documento!=""){
                    $adjunto = "upload/".$documento;

                    $file_contents=file_get_contents($adjunto);

                    $archivo="upload/ScoringComercial_".$documento.".".$extensionArchivo;
                    file_put_contents($archivo, $file_contents);
                    $GLOBALS['log']->fatal("SE GENERO ARCHIVO DE SCORING ".$archivo);
                }

                //Obtener correo de director regional
                $idUsuarioAsignado=$bean->assigned_user_id;
                $region_asignado="";
                $correo_regional="";
                $id_regional="";
                $nombre_regional="";
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
                                $correo_regional=$beanRegional->email1;
                                $nombre_regional=$beanRegional->full_name;
                            }

                        }
                    }

                }


                $cuerpoCorreo= $this->estableceCuerpoNotificacion($nombreDirector,$nombreCuenta,$linkSolicitud);

                $GLOBALS['log']->fatal("ENVIANDO NOTIFICACION A DIRECTOR DE SOLICITUD ".$correo_director);

                //Enviando correo a asesor origen
                $this->enviarNotificacionDirector("Solicitud por validar {$bean->name}",$cuerpoCorreo,$correo_director,$nombreDirector,$archivo);

                //ENVIANDO NOTIFICACIÓN A DIRECTOR REGIONAL
                if($correo_regional!=""){
                    $cuerpoCorreoRegional= $this->estableceCuerpoNotificacion($nombre_regional,$nombreCuenta,$linkSolicitud);

                    $GLOBALS['log']->fatal("ENVIANDO NOTIFICACION A DIRECTOR REGIONAL DE SOLICITUD ".$correo_regional);

                    //Enviando correo a asesor origen
                    $this->enviarNotificacionDirector("Solicitud por validar {$bean->name}",$cuerpoCorreoRegional,$correo_regional,$nombre_regional,$archivo);

                }else{
                    $GLOBALS['log']->fatal("DIRECTOR REGIONAL LEASING ".$nombre_regional." NO TIENE EMAIL");
                }


                $bean->director_notificado_c=1;

            }else{
                $GLOBALS['log']->fatal("DIRECTOR LEASING ".$nombreDirector." NO TIENE EMAIL");
            }

        }

    }

    function notificaEstatusAsesor($bean, $event, $arguments){

        global $app_list_strings;

        $estatus=$bean->estatus_c;
        $idAsesor=$bean->assigned_user_id;
        $nombreAsesor=$bean->assigned_user_name;
        if($estatus=='K' && $bean->assigned_user_id!=""){//Solicitud cancelada
            //Comprobando el fetched_row
            $GLOBALS['log']->fatal("VALOR ANTERIOR DE ESTATUS ".$bean->fetched_row['estatus_c']);
            //Enviar notificación al asesor asignado
            //Se arma cuerpo de la notificación
            $urlSugar=$GLOBALS['sugar_config']['site_url'].'/#Opportunities/';
            $nombreCuenta=$bean->account_name;
            $idSolicitud=$bean->id;
            $linkSolicitud=$urlSugar.$idSolicitud;

            $correo_asesor="";

            //Obteniendo correo de director Leasing
            $beanAsesor = BeanFactory::retrieveBean('Users', $idAsesor);
            if(!empty($beanAsesor)){
                $correo_asesor=$beanAsesor->email1;
                $nombreAsesor=$beanAsesor->full_name;
            }

            if($correo_asesor!=""){

                //$estatus=$app_list_strings['estatus_c_operacion_list'][$estatus];
                $estatusString="Rechazada";

                $cuerpoCorreo= $this->estableceCuerpoNotificacionAsesor($nombreAsesor,$nombreCuenta,$estatusString,$linkSolicitud);

                $GLOBALS['log']->fatal("ENVIANDO NOTIFICACION (ESTATUS RECHAZADA) A ASESOR ASIGNADO DE SOLICITUD ".$correo_asesor);

                $this->enviarNotificacionDirector("Solicitud {$estatusString} {$bean->name}",$cuerpoCorreo,$correo_asesor,$nombreAsesor,"");

            }else{
                $GLOBALS['log']->fatal("ASESOR LEASING ".$nombreAsesor." NO TIENE EMAIL");
            }

        }else if($estatus=='PE' && $bean->assigned_user_id!=""){ //Solicitud Aprobada

            //Comprobando el fetched_row
            $GLOBALS['log']->fatal("VALOR ANTERIOR DE ESTATUS ".$bean->fetched_row['estatus_c']);
            //Enviar notificación al asesor asignado
            //Se arma cuerpo de la notificación
            $urlSugar=$GLOBALS['sugar_config']['site_url'].'/#Opportunities/';
            $nombreCuenta=$bean->account_name;
            $idSolicitud=$bean->id;
            $linkSolicitud=$urlSugar.$idSolicitud;

            $correo_asesor="";

            //Obteniendo correo de director Leasing
            $beanAsesor = BeanFactory::retrieveBean('Users', $idAsesor);
            if(!empty($beanAsesor)){
                $correo_asesor=$beanAsesor->email1;
                $nombreAsesor=$beanAsesor->full_name;
            }

            if($correo_asesor!=""){

                //$estatusString=$app_list_strings['estatus_c_operacion_list'][$estatus];
                $estatusString="Autorizada";

                $cuerpoCorreo= $this->estableceCuerpoNotificacionAsesor($nombreAsesor,$nombreCuenta,$estatusString,$linkSolicitud);

                $GLOBALS['log']->fatal("ENVIANDO NOTIFICACION (ESTATUS AUTORIZADA) A ASESOR ASIGNADO DE SOLICITUD ".$correo_asesor);

                $this->enviarNotificacionDirector("Solicitud {$estatusString} {$bean->name}",$cuerpoCorreo,$correo_asesor,$nombreAsesor,"");

            }else{
                $GLOBALS['log']->fatal("ASESOR LEASING ".$nombreAsesor." NO TIENE EMAIL");
            }

        }


    }

    public function estableceCuerpoNotificacion($nombreDirector,$nombreCuenta,$linkSolicitud){


        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombreDirector . '</b>
      <br><br>Se le informa que se ha generado una solicitud de Leasing para la cuenta: <b>'. $nombreCuenta.'</b> y se solicita su autorización.
      <br><br>Para ver el detalle de la solicitud dé <a id="linkSolicitud" href="'. $linkSolicitud.'">click aquí</a>
      <br><br>Se adjunta documento con scoring comercial
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
        if($estatus=="Autorizada"){
            $estatus="cuenta con el VoBo del director de producto";
        }
        if($estatus=="Rechazada"){
            $estatus="ha sido Rechazada";
        }

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombreAsesor . '</b>
      <br><br>Se le informa que la solicitud para la cuenta:  <b>'. $nombreCuenta.'</b> '.$estatus.'.
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

    public function enviarNotificacionDirector($asunto,$cuerpoCorreo,$correoDirector,$nombreDirector,$adjunto){
        //Enviando correo a asesor origen
        try{
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject($asunto);
            $body = trim($cuerpoCorreo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            $mailer->addRecipientsTo(new EmailIdentity($correoDirector, $nombreDirector));
            if($adjunto!=""){
                $mailer->addAttachment(new \Attachment($adjunto));
            }
            $result = $mailer->send();

        }catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ".$nombreDirector);
            $GLOBALS['log']->fatal("Exception ".$e);
        }


    }

}