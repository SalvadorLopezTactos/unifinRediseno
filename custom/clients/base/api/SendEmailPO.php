<?php
/**
 * User: salvadorlopez
 * Date: 24/08/2023
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class SendEmailPO extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'sendEmailPo' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('SendEmailPO','?'),
                'pathVars' => array('method','id_po'),
                'method' => 'sendEmailProspect',
                'shortHelp' => 'Envía notificación por email a respectivos usuarios en proceso de Público Objetivo',
            ),
            'autorizacionPO' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('AutorizaEnvioPO','?'),
                'pathVars' => array('method','id_po'),
                'method' => 'autorizaEnvioCorreo',
                'shortHelp' => 'Envía correo a través de la aprobación del director del PO',
            ),
            'rechazoPO' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('RechazaEnvioPO','?'),
                'pathVars' => array('method','id_po'),
                'method' => 'rechazaEnvioCorreo',
                'shortHelp' => 'Envía correo a través del rechazo del director del PO',
            ),
        );
    }


    public function sendEmailProspect($api, $args)
    {
        global $sugar_config;
        $url_unileasing = $sugar_config['url_unileasing_email'];
        $id_prospecto = $args['id_po'];
        $response = "";
        $beanPO = BeanFactory::retrieveBean('Prospects', $id_prospecto, array('disable_row_level_security' => true));
        $linkPO=$GLOBALS['sugar_config']['site_url'].'/#Prospects/'.$id_prospecto;
        $nombreEmpresa = $beanPO->empresa_po_c;
        $email_po = $beanPO->email1;

        $envio_previo = $beanPO->envio_correo_po_c;
        $id_asesor = $beanPO->assigned_user_id;
        $beanAsesor = BeanFactory::retrieveBean('Users', $id_asesor, array('disable_row_level_security' => true));
        $asesorName = $beanAsesor->first_name . " " . $beanAsesor->last_name;
        $telefono_asesor = $beanAsesor->phone_mobile;
        $email_asesor = $beanAsesor->email1;


        $id_director_regional = $this->getIdDirectorRegional($beanAsesor);
        $id_director_comercial = $this->getIdDirectorComercial($beanAsesor);

        $name_regional = "";
        $email_regional = "";

        $name_comercial = "";
        $email_comercial = "";
        
        if($id_director_regional != ""){
            $info_regional = $this->getInfoUser($id_director_regional);
            $name_regional = $info_regional['name'];
            $email_regional = $info_regional['email'];
        }

        if($id_director_comercial != ""){
            $info_comercial = $this->getInfoUser($id_director_comercial);
            $name_comercial = $info_comercial['name'];
            $email_comercial = $info_comercial['email'];
        }

        if( $envio_previo ){

            //$response = "SI HAY ENVIO PREVIO: Enviar correo al director de asesor comercial y cc: director regional. Contenido: Email VoBo Director PO";
            $body_mail = $this->buildBodyEmailVoBo( $name_comercial, $asesorName, $beanPO->name, $linkPO  );
            //Enviando correo
            //ToDO: Antes de enviar, validar que si se haya encontrado un director para enviar notificación y no se intenta mandar correo a una dirección vacía
            if( $email_comercial != "" ){
                $this->sendEmailNotificationPO( $nombre_empresa, $email_comercial, $name_comercial, $email_regional, $name_regional, $body_mail );
                $response = "Se envió notificación a: ". $name_comercial. " y " .$name_regional; 
            }else{
                $response = "No existe Director Comercial al que se le pueda enviar notificación"; 
            }
            $beanPO->id_director_vobo_c = $id_director_comercial;
            $beanPO->save();

        }else{
            //No hay envío previo
            $link_unileasing = $url_unileasing . "/api/crm/contact/create?crm_id=".$id_prospecto."&assessor_id=".$id_asesor;

            $body_mail = $this->buildBodyPO( $beanPO->name, $link_unileasing, $asesorName, $telefono_asesor, $email_asesor );

            $GLOBALS['log']->fatal("El correo del PO es: ".$email_po);
            $GLOBALS['log']->fatal("El correo del Asesor es: ".$email_asesor);

            if( !empty($email_po) ){
                $this->sendEmailNotificationToProspect( $body_mail, $email_po, $beanPO->name );
                $response = "<br>Se envió notificación al Público Objetivo: ". $beanPO->name; 
            }

            //Enviando correo al asesor cc a Director Comercial y Director Regional
            $body_mail_asesor = $this->buildBodyNotificationAsesor( $asesorName, $beanPO->name );

            if( !empty($email_asesor) ){
                $this->sendEmailAsesorPO( $body_mail_asesor, $nombreEmpresa ,$email_asesor, $asesorName, $email_comercial, $name_comercial, $email_regional, $name_regional );
                $response .= "<br>Se envió notificación a: ". $asesorName. " , " .$name_comercial. " , ".$name_regional; 
            }

            //Se establece bandera para indicar que ya se ha enviado el correo previamente
            //Se establece id del director al que se le envió la notificación para que éste tenga la facultad de dar el VoBo o Rechazar
            $beanPO->envio_correo_po_c = 1;
            $beanPO->id_director_vobo_c = $id_director_comercial;
            $beanPO->save();
            
        }
        
        return $response;

    }

    public function autorizaEnvioCorreo($api, $args){
        
        global $sugar_config;
        $url_unileasing = $sugar_config['url_unileasing_email'];
        $id_prospecto = $args['id_po'];
        $response = '';

        $beanPO = BeanFactory::retrieveBean('Prospects', $id_prospecto, array('disable_row_level_security' => true));
        $email_po = $beanPO->email1;

        $id_asesor = $beanPO->assigned_user_id;
        $beanAsesor = BeanFactory::retrieveBean('Users', $id_asesor, array('disable_row_level_security' => true));
        $asesorName = $beanAsesor->first_name . " " . $beanAsesor->last_name;
        $telefono_asesor = $beanAsesor->phone_mobile;
        $email_asesor = $beanAsesor->email1;

        $id_director_regional = $this->getIdDirectorRegional($beanAsesor);
        $id_director_comercial = $this->getIdDirectorComercial($beanAsesor);

        $name_regional = "";
        $email_regional = "";

        $name_comercial = "";
        $email_comercial = "";
        
        if($id_director_regional != ""){
            $info_regional = $this->getInfoUser($id_director_regional);
            $name_regional = $info_regional['name'];
            $email_regional = $info_regional['email'];
        }

        if($id_director_comercial != ""){
            $info_comercial = $this->getInfoUser($id_director_comercial);
            $name_comercial = $info_comercial['name'];
            $email_comercial = $info_comercial['email'];
        }

        $link_unileasing = $url_unileasing . "/api/crm/contact/create?crm_id=".$id_prospecto."&assessor_id=".$id_asesor;

        $body_mail = $this->buildBodyPO( $beanPO->name, $link_unileasing, $asesorName, $telefono_asesor, $email_asesor );

        $GLOBALS['log']->fatal("El correo del PO es: ".$email_po);
        $GLOBALS['log']->fatal("El correo del Asesor es: ".$email_asesor);

        if( !empty($email_po) ){
            $this->sendEmailNotificationToProspect( $body_mail, $email_po, $beanPO->name );
            $response = "<br>Se envió notificación al Público Objetivo: ". $beanPO->name; 
        }

        //Enviando correo al asesor cc a Director Comercial y Director Regional
        $body_mail_asesor = $this->buildBodyNotificationAsesor( $asesorName, $beanPO->name );

        if( !empty($email_asesor) ){
            $this->sendEmailAsesorPO( $body_mail_asesor, $nombreEmpresa ,$email_asesor, $asesorName, $email_comercial, $name_comercial, $email_regional, $name_regional );
            $response .= "<br>Se envió notificación a: ". $asesorName. " , " .$name_comercial. " , ".$name_regional; 
        }

        //Resetea banderas
        $GLOBALS['log']->fatal('Reestableciendo banderas');
        //$beanPO->envio_correo_po_c = 0;
        $beanPO->id_director_vobo_c = "";
        $beanPO->save();
        $GLOBALS['log']->fatal('Banderas reestablecidas');
        
        return $response;
    }

    public function rechazaEnvioCorreo($api, $args){
        $id_prospecto = $args['id_po'];
        $response = '';

        $beanPO = BeanFactory::retrieveBean('Prospects', $id_prospecto, array('disable_row_level_security' => true));
        $nombreEmpresa = $beanPO->empresa_po_c;
        $email_po = $beanPO->email1;

        $id_asesor = $beanPO->assigned_user_id;
        $beanAsesor = BeanFactory::retrieveBean('Users', $id_asesor, array('disable_row_level_security' => true));
        $asesorName = $beanAsesor->first_name . " " . $beanAsesor->last_name;
        $telefono_asesor = $beanAsesor->phone_mobile;
        $email_asesor = $beanAsesor->email1;

        $id_director_regional = $this->getIdDirectorRegional($beanAsesor);
        $id_director_comercial = $this->getIdDirectorComercial($beanAsesor);

        $name_regional = "";
        $email_regional = "";

        $name_comercial = "";
        $email_comercial = "";
        
        if($id_director_regional != ""){
            $info_regional = $this->getInfoUser($id_director_regional);
            $name_regional = $info_regional['name'];
            $email_regional = $info_regional['email'];
        }

        if($id_director_comercial != ""){
            $info_comercial = $this->getInfoUser($id_director_comercial);
            $name_comercial = $info_comercial['name'];
            $email_comercial = $info_comercial['email'];
        }

        $body_correo_rechazo = $this->buildBodyRechazo( $asesorName, $beanPO->name );

        if( !empty($email_asesor) ){
            $this->sendEmailNotificationRechazo( $body_correo_rechazo, $nombreEmpresa ,$email_asesor, $asesorName, $email_comercial, $name_comercial, $email_regional, $name_regional );
            $response = "<br>Se envió notificación de rechazo a: ". $asesorName; 
        }

        //Resetea banderas
        $GLOBALS['log']->fatal('Reestablece id de director y permanece bandera de envío previo');
        //$beanPO->envio_correo_po_c = 0;
        $beanPO->id_director_vobo_c = "";
        $beanPO->save();
        $GLOBALS['log']->fatal('Banderas reestablecidas');

        return $response;
        //buildBodyRechazo( $nombre_asesor, $nombre_po )
    }

    public function getIdDirectorRegional( $beanAsesor ){

        $equipo_principal_asesor = $beanAsesor->equipo_c;
        $id_regional = "";
        $qGetDirectorRegional = "SELECT id_c,posicion_operativa_c,uc.equipos_c FROM users u 
        INNER JOIN users_cstm uc 
        ON u.id = uc.id_c
        AND uc.posicion_operativa_c LIKE '%^2^%' AND uc.equipos_c LIKE '%^{$equipo_principal_asesor}^%'
        WHERE u.status = 'Active' AND u.deleted=0";

        $GLOBALS['log']->fatal("Query DIRECTOR REGIONAL");
        $GLOBALS['log']->fatal($qGetDirectorRegional);

        $resultadoRegional = $GLOBALS['db']->query($qGetDirectorRegional);

        if ($resultadoRegional->num_rows > 0) {

            while ($row = $GLOBALS['db']->fetchByAssoc($resultadoRegional)) {
                $id_regional = $row['id_c'];
            }

        }

        return $id_regional;

    }

    public function getIdDirectorComercial( $beanAsesor ){

        $equipo_principal_asesor = $beanAsesor->equipo_c;
        $id_comercial = "";
        $qGetDirectorComercial = "SELECT id_c,posicion_operativa_c,uc.equipos_c FROM users u 
        INNER JOIN users_cstm uc 
        ON u.id = uc.id_c
        AND uc.posicion_operativa_c LIKE '%^1^%' AND uc.equipos_c LIKE '%^{$equipo_principal_asesor}^%'
        WHERE u.status = 'Active' AND u.deleted=0";

        $GLOBALS['log']->fatal("Query DIRECTOR COMERCIAL (Director Equipo)");
        $GLOBALS['log']->fatal($qGetDirectorComercial);

        $resultadoComercial = $GLOBALS['db']->query($qGetDirectorComercial);

        if ($resultadoComercial->num_rows > 0) {

            while ($row = $GLOBALS['db']->fetchByAssoc($resultadoComercial)) {
                $id_comercial = $row['id_c'];
            }

        }

        return $id_comercial;

    }

    public function getInfoUser( $id_user ){

        $beanUser = BeanFactory::retrieveBean('Users', $id_user, array('disable_row_level_security' => true));
        $emailUser = $beanUser->email1;
        $first_name = $beanUser->first_name;
        $last_name = $beanUser->last_name;
        $user = [];
        $user['name'] =  $first_name." ".$last_name;
        $user['email'] = $emailUser;

        return $user;
    }

    public function buildBodyEmailVoBo( $nombre_director, $nombre_asesor,$nombre_po, $link_po ){

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Estimado <b>' . $nombre_director . '</b>
            <br>El asesor a tu cargo ' . $nombre_asesor . ' necesita tu visto bueno para enviar una vez más el correo de registro en la plataforma para el contacto <b>'. $nombre_po .'</b>.
            <br>Solo dar clic sobre la siguiente liga para Autorizar o Rechazar el envío <a id="linkPO" href="'.$link_po.'">Ver detalle</a>
            <br><br>Atentamente Unifin</font></p>
            <br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
            <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
            Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
            Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
            No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
            Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';


        return $mailHTML;

    }

    public function buildBodyPO( $nombre_po, $link_unileasing, $nombre_asesor, $telefono, $correo_asesor ){
        
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Estimado <b>' . $nombre_po . '</b>
            <br>Para continuar con tu solicitud es necesario que te registres en nuestra página oficial solo dando clic en el siguiente enlace:
            <br><a id="linkPO" href="'.$link_unileasing.'">Ver detalle</a>
            <br><br>Si tienes alguna duda por favor comunícate con nosotros al 800 211 9000 o contacta a tu asesor asignado:
            <br>'.$nombre_asesor.'
            <br>'.$telefono.'
            <br>'.$correo_asesor.'
            <br><br>Atentamente Unifin</font></p>
            <br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
            <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
            Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
            Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
            No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
            Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';


        return $mailHTML;
    }

    public function buildBodyNotificationAsesor( $nombre_asesor, $nombre_po ){
        
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Estimado <b>' . $nombre_asesor . '</b>
            <br>Te comentamos que  a tu cliente/contacto:
            <br>'.$nombre_po.'
            <br>Le fue enviado el enlace para su registro en la plataforma Unileasing.
            <br>Es importante que lo contactes para dar seguimiento a su solicitud.
            <br><br>Atentamente Unifin</font></p>
            <br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
            <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
            Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
            Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
            No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
            Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';


        return $mailHTML;
    }

    public function buildBodyRechazo( $nombre_asesor, $nombre_po ){

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Estimado <b>' . $nombre_asesor . '</b>
            <br><br>Te comentamos que tu director rechazó el reenvío de correo de Onboarding de tu cliente/contacto:
            <br>'.$nombre_po.'
            <br>Contáctate con él para revisar el detalle.
            <br><br>Atentamente Unifin</font></p>
            <br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
            <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
            Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
            Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
            No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
            Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';


        return $mailHTML;

    }

    public function sendEmailNotificationPO( $nombre_empresa, $email, $name_email, $email_cc, $name_email_cc, $body_correo ){

        try{
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject('Reenvio Onboarding '.$nombre_empresa);
            $body = trim($body_correo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            
            $mailer->addRecipientsTo(new EmailIdentity($email, $name_email));
            $mailer->addRecipientsCc(new EmailIdentity($email_cc, $name_email_cc));
            
            $GLOBALS['log']->fatal("ENVIANDO CORREO A: ".$email." / ".$email_cc );
            $result = $mailer->send();

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar el correo electrónico");
            $GLOBALS['log']->fatal(print_r($e,true));

        }

    }

    public function sendEmailNotificationToProspect( $body_correo, $email_prospect, $name_prospect ){

        try{
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject('Continúa tu registro en Unileasing');
            $body = trim($body_correo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            
            $mailer->addRecipientsTo(new EmailIdentity($email_prospect, $name_prospect));
            
            $GLOBALS['log']->fatal("ENVIANDO CORREO A: ".$email_prospect );
            $result = $mailer->send();

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar el correo electrónico");
            $GLOBALS['log']->fatal(print_r($e,true));

        }

    }

    public function sendEmailAsesorPO( $body_correo, $nombre_empresa ,$email_asesor, $name_asesor, $email_comercial, $name_comercial, $email_regional, $name_regional ){

        try{
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject('Seguimiento Unileasing / '.$nombre_empresa);
            $body = trim($body_correo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            
            $mailer->addRecipientsTo(new EmailIdentity($email_asesor, $name_asesor));
            $mailer->addRecipientsCc(new EmailIdentity($email_comercial, $name_comercial));
            $mailer->addRecipientsCc(new EmailIdentity($email_regional, $name_regional));
            
            $GLOBALS['log']->fatal("ENVIANDO CORREO ASESOR: ".$email_asesor );
            $GLOBALS['log']->fatal("ENVIANDO CORREO COMERCIAL: ".$email_comercial );
            $GLOBALS['log']->fatal("ENVIANDO CORREO REGIONAL: ".$email_regional );
            $result = $mailer->send();

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar el correo electrónico");
            $GLOBALS['log']->fatal(print_r($e,true));

        }

    }

    public function sendEmailNotificationRechazo( $body_correo, $nombre_empresa ,$email_asesor, $name_asesor, $email_comercial, $name_comercial, $email_regional, $name_regional ){

        try{
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject('Rechazo Reenvío Unileasing / '.$nombre_empresa);
            $body = trim($body_correo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            
            $mailer->addRecipientsTo(new EmailIdentity($email_asesor, $name_asesor));
            $mailer->addRecipientsCc(new EmailIdentity($email_comercial, $name_comercial));
            $mailer->addRecipientsCc(new EmailIdentity($email_regional, $name_regional));
            
            $GLOBALS['log']->fatal("ENVIANDO CORREO DE RECHAZO ASESOR: ".$email_asesor );
            $GLOBALS['log']->fatal("ENVIANDO CORREO DE RECHAZO COMERCIAL: ".$email_comercial );
            $GLOBALS['log']->fatal("ENVIANDO CORREO DE RECHAZO REGIONAL: ".$email_regional );
            $result = $mailer->send();

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar el correo electrónico");
            $GLOBALS['log']->fatal(print_r($e,true));

        }

    }

}

