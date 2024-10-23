<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ObtenerRelacionesAltaPO extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'RelacionesAltaPO' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('ObtenerRelacionesAltaPO','?'),
                'pathVars' => array('endpoint', 'idCuenta'),
                'method' => 'getRelacionesParaAltaPO',
                'shortHelp' => 'Obtiene registros de relaciones de la cuenta que no tengan ya un registro de público objetivo asociado',
            ),
            'EstableceBanderaPO' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('EstablecerBanderaPublicoObjetivoCreado'),
                'pathVars' => array('endpoint'),
                'method' => 'setBanderaPOcreado',
                'shortHelp' => 'Establece bandera a true para indicar que se ha generado un Público Objetivo a partir de la vusta de Alta de PO',
            ),
            'GenerarPO' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('crearPOdesdeRelacion'),
                'pathVars' => array('endpoint'),
                'method' => 'generaRegistroPO',
                'shortHelp' => 'Genera registro de Público Objetivo con información de una Cuenta proveniente de una relación',
            ),
            'autorizacionCreacionPO' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('AutorizaCreacionPO'),
                'pathVars' => array('method'),
                'method' => 'autorizaEnvioCorreo',
                'shortHelp' => 'Envía correo a dirctor para solicitar aprobacion de creación',
            ),
            'notificacionCreacionPO' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('NotificacionCreacionPO','?'),
                'pathVars' => array('method','tipoNotificacion'),
                'method' => 'enviaNotificacionRespuestaCreacionPO',
                'shortHelp' => 'Dependiendo el tipoNotificacion, se envía notificación al asesor con la respuesta del director',
            ),
        );
    }


    public function getRelacionesParaAltaPO($api, $args)
    {
        
        //JSR Prueba para leer listas de sugar
        $idCuenta = $args['idCuenta'];

        $beanCuenta = BeanFactory::getBean('Accounts', $idCuenta, array('disable_row_level_security' => true));

        $arrRelaciones=array();
        
        if($beanCuenta->load_relationship('rel_relaciones_accounts_1')){
            $relatedRelaciones = $beanCuenta->rel_relaciones_accounts_1->getBeans();
            if( count($relatedRelaciones) >0 ){
                foreach($relatedRelaciones as $rel) {
                    $GLOBALS['log']->fatal( $rel->id );
                    
                    //Por cada cuenta relacionada, verificamos que no exista en Público Objetivo
                    //account_id1_c
                    $beanCuentaRelacion = BeanFactory::retrieveBean('Accounts', $rel->account_id1_c , array('disable_row_level_security' => true));
                    $emailCuenta = $beanCuentaRelacion->email1;

                    $result = $this->verificaExistenciaEnPO($emailCuenta);
                    $GLOBALS['log']->fatal( print_r($result,true) );
                    $count = count($result);

                    //Si no se encuentran registros, quiere decir que la cuenta aún no tiene un regidtro de PO
                    if( $count == 0 ){
                        $arrayRelacion = array();
                        $arrayRelacion['idRelacion'] = $rel->id;
                        $arrayRelacion['idCuenta'] = $beanCuentaRelacion->id;
                        $arrayRelacion['nombre'] = $beanCuentaRelacion->name;
                        $arrayRelacion['email'] = $beanCuentaRelacion->email1;
                        $arrayRelacion['relaciones'] = $rel->relaciones_activas;
                        array_push( $arrRelaciones, $arrayRelacion);
                    }

                    //vVerificamos que no exista el email en Prospects
                    
                }
            }
        }


        return $arrRelaciones;

    }


    public function verificaExistenciaEnPO( $email ){
        $GLOBALS['log']->fatal("EL EMAIL A BUSCAR :" .$email);

        $prospectsBean = BeanFactory::getBean('Prospects');
        $prospectsBean->disable_row_level_security = true;

        $sql = new SugarQuery();
        $sql->select(array('id', 'clean_name_c'));
        $sql->from($prospectsBean);
        $sql->where()->equals('email1', $email);

        $result = $sql->execute();
        return $result;

    }

    public function setBanderaPOcreado($api, $args){
        
        $idRegistro = $args['idRegistro'];

        try{
            $beanResumen = BeanFactory::getBean('tct02_Resumen', $idRegistro, array('disable_row_level_security' => true));
        
            $beanResumen->po_creado_c = 1;

            $beanResumen->save();

        return ($beanResumen->id) ? 
            array(
                "msj" => "La bandera se ha actualizado correctamente",
                "idRegistro" => $beanResumen->id
            ):
            array(
                "msj" => "La bandera no se actualizó",
                "idRegistro" => ""
            );

        }catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido establecer la bandera");
            $GLOBALS['log']->fatal(print_r($e,true));

            return array(
                "msj" => "La bandera no se actualizó",
                "idRegistro" => ""
            );

        }

    }

    public function generaRegistroPO($api, $args){
        $idRegistro = $args['idRegistroRelacion'];

        try{
            $beanCuenta = BeanFactory::getBean('Accounts', $idRegistro, array('disable_row_level_security' => true));

            $nombre = $beanCuenta->primernombre_c;
            $paterno = $beanCuenta->apellidopaterno_c;
            $materno = $beanCuenta->apellidomaterno_c;
            $email = $beanCuenta->email1;
            $rfc = $beanCuenta->rfc_c;

            $telCasa = "";
            $telTrabajo = "";
            $telCelular = "";

            $telefonos = $this->getTelefonosCuenta( $beanCuenta );

            if( count($telefonos) > 0 ){
                if( isset($telefonos['casa']) )  $telCasa = $telefonos['casa'];
                if( isset($telefonos['trabajo']) )  $telTrabajo = $telefonos['trabajo'];
                if( isset($telefonos['celular']) )  $telCelular = $telefonos['celular'];
            }

            $idNuevoPO = $this->crearPO( $nombre, $paterno, $materno, $email, $telCasa, $telTrabajo, $telCelular, $rfc );

            return array(
                "status" => "ok",
                "msj" => "Registro de PO creado correctamente",
                "idRegistro" => $idNuevoPO
                );

        }catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido establecer la bandera");
            $GLOBALS['log']->fatal(print_r($e,true));

            return array(
                "status" => "error",
                "msj" => "El registro no se creó, debido a ". $e->getMessage(),
                "idRegistro" => ""
            );

        }

    }

    public function getTelefonosCuenta( $beanCuenta ){

        $arrTelefonos = [];

        if ($beanCuenta->load_relationship('accounts_tel_telefonos_1')) {
			$tel_telefonos = $beanCuenta->accounts_tel_telefonos_1->getBeans();
            if (!empty($tel_telefonos)) {
                foreach ($tel_telefonos as $tel) {
					$tipoTelefono = $tel->tipotelefono;
                    if($tipoTelefono == '1'){
                        $arrTelefonos['casa'] = $tel->telefono;
                    }
                    
                    if($tipoTelefono == '2'){
                        $arrTelefonos['trabajo'] = $tel->telefono;
                    }

                    if($tipoTelefono == '3'){
                        $arrTelefonos['celular'] = $tel->telefono;
                    }
				}
			}
		}

        return $arrTelefonos;

    }

    public function crearPO( $nombre, $paterno, $materno, $email, $telCasa, $telTrabajo, $telCelular, $rfc ){
        $GLOBALS['log']->fatal( "CREANDO PO" );
        $beanProspect = BeanFactory::newBean("Prospects");

        $beanProspect->nombre_c = $nombre;
        $beanProspect->apellido_paterno_c = $paterno;
        $beanProspect->apellido_materno_c = $materno;
        $beanProspect->email1 = $email;
        $beanProspect->phone_home = $telCasa;
        $beanProspect->phone_work = $telTrabajo;
        $beanProspect->phone_mobile = $telCelular;
        //$beanProspect->rfc_c = $rfc;


        $beanProspect->save();

        return $beanProspect->id;

    }


    public function autorizaEnvioCorreo($api, $args){

        $GLOBALS['log']->fatal("ENVIANDO CORREO");
        $GLOBALS['log']->fatal(print_r($args,true));

        $motivoCreacion = $args['mensaje'];
        $idRegistro = $args["idRegistro"];

        //Obtenemos el id del asesor de leasing
        $beanCuenta = BeanFactory::retrieveBean('Accounts', $idRegistro, array('disable_row_level_security' => true));

        $idAsesorLeasing = $beanCuenta->user_id_c;
        $beanAsesorLeasing = BeanFactory::retrieveBean('Users', $idAsesorLeasing, array('disable_row_level_security' => true));
        //$asesorName = $beanAsesor->first_name . " " . $beanAsesor->last_name;

        $id_director_comercial = $this->getIdDirectorComercial($beanAsesorLeasing);

        if($id_director_comercial != ""){
            $info_comercial = $this->getInfoUser($id_director_comercial);
            //$info_comercial = $this->getInfoUser("c57e811e-b81a-cde4-d6b4-5626c9961772");
            $name_comercial = $info_comercial['name'];
            $email_comercial = $info_comercial['email'];
        }

        $bodyCorreo = $this->buildBodyEnviaPeticionAutorizacionDirector( $name_comercial, $idRegistro, $beanCuenta->name, $motivoCreacion );
        if( !empty($email_comercial) ){

            $this->sendEmailPeticionAutorizacionDirector($email_comercial,$bodyCorreo,$beanCuenta->name );

        }

        return array(
            "status" => "success",
            "msj" => "Se ha enviado el correo"
            );

    }

    public function enviaNotificacionRespuestaCreacionPO($api, $args){

        $tipoNotificacion = $args['tipoNotificacion'];

        if( $tipoNotificacion == "autoriza" ){
            return array(
                "status" => "autoriza",
                "msj" => "SE ENVÍA CORREO DE AUTORIZACIÓN"
                );
        }else{
            return array(
                "status" => "rechazo",
                "msj" => "SE ENVÍA CORREO DE RECHAZO",
                );
        }
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

    public function buildBodyEnviaPeticionAutorizacionDirector( $nombreDirectorComercial, $idRegistro, $nombreRegistro, $motivoCreacion ){

        $linkCuenta = $GLOBALS['sugar_config']['site_url'] . '/#Accounts/' . $idRegistro;
        $htmlLink = '<b><a id="linkCuenta" href="' . $linkCuenta . '">' . $nombreRegistro . '</a></b>';

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Estimado/a '.$nombreDirectorComercial.',<br><br>
            Se requiere tu VoBo para la creación de un nuevo público objetivo en la cuenta de <br>
            '.$htmlLink.' para que el cliente pueda registrarse en Unileasing 2.0.<br><br>
            Refiere el siguiente motivo: '.$motivoCreacion.'
            <br><br>Si necesitas más información antes de aprobar, puedes solicitarla al asesor asignado.<br><br>
            Por favor, confirma tu decisión a la brevedad.
            <br><br>Atentamente Unifin</font></p>
            <br><br><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png">
            <br><span style="font-size:8.5pt;color:#757b80">____________________________________________</span>
            <p class="MsoNormal" style="text-align: justify;">
              <span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
                Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
                Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
                No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
                Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro <a href="https://www.unifin.com.mx/aviso-de-privacidad" target="_blank">Aviso de Privacidad</a>  publicado en <a href="http://www.unifin.com.mx/" target="_blank">www.unifin.com.mx</a>
              </span>
            </p>';

        return $mailHTML;

    }

    public function sendEmailPeticionAutorizacionDirector( $emailDirector, $body_correo, $nombreCuenta ){
        $GLOBALS['log']->fatal("Enviando correo al director para aprobar envío de correo");
        $GLOBALS['log']->fatal("email: ".$emailDirector);
        try{
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject('Solicitud de VoBo: Creación de nuevo PO – '.$nombreCuenta);
            $body = trim($body_correo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            
            $mailer->addRecipientsTo(new EmailIdentity($emailDirector, $emailDirector));

            $result = $mailer->send();

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar el correo electrónico");
            $GLOBALS['log']->fatal(print_r($e,true));

        }

    }

}


