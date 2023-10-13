<?php
/**
 * Created by PhpStorm.
 * User: Salvador Lopez
 * Date: 18/04/2023
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetCambiosRazonDireFiscal extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'getCambiosRazon' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('cambiosRazonSocialDireFiscal','?'),
                'pathVars' => array('metodo','id_registro'),
                'method' => 'getCambiosAudit',
                'shortHelp' => 'Obtiene estructura del campo edit para obtener cambios en dirección fiscal de la cuenta relacionada',
                'longHelp' => '',
            ),
            'apruebaCambiosRazonSocial' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('AprobarCambiosRazonSocialDireFiscal'),
                'pathVars' => array('metodo'),
                'method' => 'aprobarCambios',
                'shortHelp' => 'Obtiene elementos en body de petición para establecer los nuevos valores aprobados tanto para el cliente como para la dirección fiscal',
                'longHelp' => '',
            ),
            'rechazaCambiosRazonSocial' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('RechazarCambiosRazonSocialDireFiscal'),
                'pathVars' => array('metodo'),
                'method' => 'rechazarCambios',
                'shortHelp' => 'Resetea Banderas de cuenta y direcciones inidicando que se rechazaron los cambios solicitados al actualizar nombre y/o dirección fiscal',
                'longHelp' => '',
            ),
        );
    }
    /*
    * Obtiene dirección fiscal de cuenta que tiene valor en campo json_audit_c
    */
    public function getCambiosAudit($api, $args){

        $id_registro = $args['id_registro'];
        $array_json_audit = array();

        $queryAudit = "SELECT d.id idDireccion, dc.json_audit_c FROM accounts a
        INNER JOIN accounts_dire_direccion_1_c ad ON a.id = ad.accounts_dire_direccion_1accounts_ida
        INNER JOIN dire_direccion d ON ad.accounts_dire_direccion_1dire_direccion_idb = d.id
        INNER JOIN dire_direccion_cstm dc ON d.id = dc.id_c
        WHERE a.id= '{$id_registro}'
        -- AND d.indicador IN (2,3,6,7,10,11,14,15,18,19,22,23,26,27,30,31,34,35,38,39,42,43,46,47,50,51,54,55,58,59,62,63)
        AND dc.json_audit_c is not null
        AND dc.json_audit_c != ''
        ORDER BY d.date_modified DESC";

        $results = $GLOBALS['db']->query($queryAudit);
        if( $results->num_rows > 0 ){
            while($row = $GLOBALS['db']->fetchByAssoc($results)) {
                
                $array_json_audit[] = $row['json_audit_c'];
                
            }
        }

        return $array_json_audit;
    }

    public function aprobarCambios($api, $args){
        global $current_user;
        $response = array();
        $date = TimeDate::getInstance()->nowDb();
        $id_cuenta = $args['idCuenta'];
        $beanCuenta = BeanFactory::getBean('Accounts', $id_cuenta , array('disable_row_level_security' => true));
        
        if( !empty($args['cuenta']) ){
        
            if( !empty($beanCuenta) ){

                if( $args['cuenta']['tipo'] !== 'Persona Moral' ){
                    //Se establecen valores para Primer Nombre, Paterno y Materno
                    $beanCuenta->primernombre_c = $args['cuenta']['primer_nombre_por_actualizar'];
                    $beanCuenta->apellidopaterno_c = $args['cuenta']['paterno_por_actualizar'];
                    $beanCuenta->apellidomaterno_c = $args['cuenta']['materno_por_actualizar'];
                }else{//Al ser Moral, se establecen nuevos valores en Razón Social y Nombre Comercial
                    $beanCuenta->razonsocial_c = $args['cuenta']['razon_social_por_actualizar'];
                    $beanCuenta->nombre_comercial_c = $args['cuenta']['razon_social_por_actualizar'];
                }

                //$beanCuenta->save();

                array_push($response,"Cuenta actualizada correctamente");
            }
        }

        
        if( !empty($args['direccion']) ){
            $id_direccion = $args['direccion']['id_direccion'];
            if( $id_cuenta == "" ){
                $id_cuenta = $this->getIdCuenta($id_direccion);
            }

            //En caso de tener 5 caracteres en el string, quiere decir que es el CP y hay que obtener el id del Código Postal
            if( strlen($args['direccion']['cp_por_actualizar']) == 5 ){
                $id_codigo_postal = $this->getIdCodigoPostal( $args['direccion']['cp_por_actualizar'] );
            }else{
                $id_codigo_postal =  $args['direccion']['cp_por_actualizar'];
            }
           
            $beanDireccion = BeanFactory::getBean('dire_Direccion', $id_direccion , array('disable_row_level_security' => true));
            if( isset($args['direccion']['indicador']) && $args['direccion']['indicador'] !== "" ){
                $beanDireccion->indicador = $args['direccion']['indicador'];
            }
            $beanDireccion->dire_direccion_dire_codigopostaldire_codigopostal_ida = $id_codigo_postal;
            $beanDireccion->dire_direccion_dire_paisdire_pais_ida = $args['direccion']['pais_por_actualizar'];
            $beanDireccion->dire_direccion_dire_estadodire_estado_ida = $args['direccion']['estado_por_actualizar'];
            $beanDireccion->dire_direccion_dire_municipiodire_municipio_ida = $args['direccion']['municipio_por_actualizar'];
            $beanDireccion->dire_direccion_dire_ciudaddire_ciudad_ida = $args['direccion']['ciudad_por_actualizar'];
            $beanDireccion->dire_direccion_dire_coloniadire_colonia_ida = $args['direccion']['colonia_por_actualizar'];
            $beanDireccion->calle =$args['direccion']['calle_por_actualizar'];
            $beanDireccion->numext =$args['direccion']['numext_por_actualizar'];
            $beanDireccion->numint =$args['direccion']['numint_por_actualizar'];
            $direccion_completa = $args['direccion']['calle_por_actualizar'] . " " . $args['direccion']['numext_por_actualizar'] . " " . ($args['direccion']['numint_por_actualizar'] != "" ? "Int: " . $args['direccion']['numint_por_actualizar'] : "") . ", Colonia " . $beanDireccion->dire_direccion_dire_colonia_name . ", Municipio " . $beanDireccion->dire_direccion_dire_municipio_name;

            $beanDireccion->name = $direccion_completa;
            $beanDireccion->cambio_direccion_c = 0;
            $beanDireccion->json_audit_c = '';
            $beanDireccion->valid_cambio_razon_social_c = 0;

            $beanDireccion->save();

            array_push($response,"Direccion " .$beanDireccion->id. " actualizada correctamente");

        }

        if( !empty($args['direcciones']) && $beanCuenta->cambio_dirfiscal_c == 1 ){
            
            $direcciones = $args['direcciones']['json_dire_actualizar'];

            if( count($direcciones) > 0 ){
                for ($i=0; $i < count($direcciones); $i++) {
                    $id_direccion = $direcciones[$i]['id'];

                    if( $id_direccion != "" ){
                        $bean_direccion = BeanFactory::getBean('dire_Direccion', $id_direccion , array('disable_row_level_security' => true));

                    }else{
                        $bean_direccion = BeanFactory::newBean('dire_Direccion');
                        $bean_direccion->accounts_dire_direccion_1accounts_ida = $id_cuenta;
                    }

                    $bean_direccion->indicador = $direcciones[$i]['indicador'];
                    $tipo_string = "";
                    if ( !empty($direcciones[$i]['tipodedireccion'] !== "") ) {
                        $tipo_string .= '^' . $direcciones[$i]['tipodedireccion'][0] . '^';
                    }
                    $bean_direccion->tipodedireccion = $tipo_string;

                    $bean_direccion->dire_direccion_dire_codigopostaldire_codigopostal_ida = $direcciones[$i]['postal'];
                    $bean_direccion->dire_direccion_dire_paisdire_pais_ida = $direcciones[$i]['pais'];
                    $bean_direccion->dire_direccion_dire_estadodire_estado_ida = $direcciones[$i]['estado'];
                    $bean_direccion->dire_direccion_dire_municipiodire_municipio_ida = $direcciones[$i]['municipio'];
                    $bean_direccion->dire_direccion_dire_ciudaddire_ciudad_ida = $direcciones[$i]['ciudad'];
                    $bean_direccion->dire_direccion_dire_coloniadire_colonia_ida = $direcciones[$i]['colonia'];
                    $bean_direccion->calle = $direcciones[$i]['calle'];
                    $bean_direccion->numext = $direcciones[$i]['numext'];
                    $bean_direccion->numint = $direcciones[$i]['numint'];

                    $bean_direccion->save();

                    array_push($response,"Direccion " .$bean_direccion->id. " actualizada correctamente");
                }
            }

        }

        if( $beanCuenta == "" || empty($beanCuenta) ){
            $beanCuenta = BeanFactory::getBean('Accounts', $id_cuenta , array('disable_row_level_security' => true));
        }

        $beanCuenta->valid_cambio_razon_social_c = 0;
        $beanCuenta->cambio_nombre_c = 0;
        $beanCuenta->cambio_dirfiscal_c = 0;
        $beanCuenta->json_audit_c = '';
        $beanCuenta->json_direccion_audit_c = '';
        $beanCuenta->omitir_guardado_direcciones_c = 0;
        $beanCuenta->direccion_actualizada_api_c = 0;

        //Establece valor sobre el campo del usuario que aprobo/rechazó el cambio
        $beanCuenta->user_id9_c = $current_user->id;
        $beanCuenta->usr_aprueba_rechaza_c = $current_user->full_name;
        $beanCuenta->fecha_aprueba_rechaza_c = $date;
        $beanCuenta->accion_cambio_fiscal_c = "Aprobó";

        $beanCuenta->save();

        return $response;

    }

    public function rechazarCambios($api, $args){
        global $current_user;
        global $app_list_strings;
        $response = array();
        $id_cuenta = "";
        $date = TimeDate::getInstance()->nowDb();

        if( !empty($args['cuenta']) ){
            $id_cuenta = $args['cuenta']['id_cuenta'];
            $razon_rechazo = $args['cuenta']['razon_rechazo'];
            
            $beanCuenta = BeanFactory::getBean('Accounts', $id_cuenta , array('disable_row_level_security' => true));
            $nombreCuenta = $beanCuenta->name;
            $idUsuarioLeasing = $beanCuenta->user_id_c;

            //Al ser rechazados los cambios, las banderas únicamente se actualizan desde bd para evitar pasar por todos los LH
            $this->reestableceBanderasCuenta($id_cuenta);
            $this->insertAuditAccion($id_cuenta);

            //Guardar razón rechazo
            $this->saveRazonRechazo($id_cuenta, $razon_rechazo);

            //Envía correo
            $bodyCorreo = $this->buildBodyCorreoRechazo( $nombreCuenta, $razon_rechazo );
            $emailsDestinatarios = $this->getUsuariosDestinatariosRechazo( $idUsuarioLeasing );

            $GLOBALS['log']->fatal( print_r($emailsDestinatarios,true) );

            $this->sendEmailRechazo( $nombreCuenta,$emailsDestinatarios, $bodyCorreo );

            array_push($response,"Cambios de Cuenta rechazados");
        }

        if( !empty($args['direccion']) ){
            $id_direccion = $args['direccion']['id_direccion'];
            if( $id_cuenta == "" ){
                $id_cuenta = $this->getIdCuenta($id_direccion);
                //Resetea banderas de Cuentas
                $this->reestableceBanderasCuenta($id_cuenta);
            }

            $this->reestableceBanderasDireccion($id_direccion);

            array_push($response,"Cambios de Dirección rechazados");

        }

        if( !empty($args['direcciones']) ){
            $id_cuenta = $args['idCuenta'];

            $this->insertAuditAccion($id_cuenta);
            $this->insertAuditJSONDirecciones($id_cuenta);
            $this->reestableceBanderasCuenta($id_cuenta);

            array_push($response,"Cambios de Direcciones rechazados");

        }
        
        return $response;
    }

    public function getIdCodigoPostal($cp){

        $queryCP = "SELECT id FROM dire_codigopostal WHERE name = '{$cp}'";
        
        $resultCP = $GLOBALS['db']->query($queryCP);
        $id_cp = "";
        
        if( $resultCP->num_rows >0 ){
            while ($row = $GLOBALS['db']->fetchByAssoc($resultCP)) {
                $id_cp = $row['id'];
            }
        }

        return $id_cp;
    }

    public function getIdCuenta($id_direccion){
        $id_cuenta = "";
        //Si no se tiene id de cuenta, se obtiene el id de la cuenta relacionada a la dirección
        $queryGetCuenta ="SELECT accounts_dire_direccion_1accounts_ida FROM accounts_dire_direccion_1_c WHERE accounts_dire_direccion_1dire_direccion_idb='{$id_direccion}'";
        $resultCuenta = $GLOBALS['db']->query($queryGetCuenta);
        if( $resultCuenta->num_rows > 0){
            while ($row = $GLOBALS['db']->fetchByAssoc($resultCuenta)) {
                $id_cuenta = $row['accounts_dire_direccion_1accounts_ida'];
            }
        }

        return $id_cuenta;
    }

    public function reestableceBanderasCuenta($id_cuenta){
        global $current_user;
        $date = TimeDate::getInstance()->nowDb();
        
        $queryUpdateBanderasAccount = "UPDATE accounts_cstm SET valid_cambio_razon_social_c = '0', cambio_nombre_c = '0', cambio_dirfiscal_c = '0', json_audit_c = '', user_id9_c = '{$current_user->id}', fecha_aprueba_rechaza_c ='{$date}', json_direccion_audit_c = '', omitir_guardado_direcciones_c = '0', accion_cambio_fiscal_c = 'Rechazó', direccion_actualizada_api_c = '0' WHERE id_c = '{$id_cuenta}'";
        $GLOBALS['log']->fatal("UPDATE BANDERAS DE CUENTA");
        $GLOBALS['log']->fatal($queryUpdateBanderasAccount);

        $GLOBALS['db']->query($queryUpdateBanderasAccount);
    }

    public function insertAuditAccion($id_cuenta){

        global $current_user;
        $id_user = $current_user->id;
        $parent_id = $id_cuenta;
        $id_audit = create_guid();
        $date = TimeDate::getInstance()->nowDb();

        $insertQueryAudit ="INSERT INTO `accounts_audit` (`id`,`parent_id`,`date_created`,`created_by`,`field_name`,`data_type`,`before_value_string`,`after_value_string`,`before_value_text`,`after_value_text`,`event_id`,`date_updated`) VALUES ('{$id_audit}','{$parent_id}','{$date}','{$id_user}','accion_cambio_fiscal_c','varchar','','Rechazó',NULL,NULL,'',NULL)";
        
        $GLOBALS['db']->query($insertQueryAudit);

    }

    public function saveRazonRechazo($id_cuenta, $razon_rechazo){
        $beanResumen = BeanFactory::getBean('tct02_Resumen', $id_cuenta , array('disable_row_level_security' => true));

        $beanResumen->razon_rechazo_regimen_c = $razon_rechazo;

        $beanResumen->save();
    }

    public function buildBodyCorreoRechazo( $nombreCuenta, $razonRechazo ){

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">
            Se rechaza la actualización de la razón social de <b>'.$nombreCuenta.'</b>.<br>
            <br>Descripción de rechazo: '.$razonRechazo.'<br>
            <br>Atentamente Unifin</font></p>
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

    public function getUsuariosDestinatariosRechazo( $idUsuarioLeasing ){
        global $app_list_strings;
        $emailsList = array();
        if( !empty( $idUsuarioLeasing )){

            $beanUserLeasing = BeanFactory::getBean('Users', $idUsuarioLeasing , array('disable_row_level_security' => true));
            $estado = $beanUserLeasing->status;
            $emailLeasing = "";

            $notificaJefe = ( $estado == 'Inactive' ) ? true : false;

            if( $notificaJefe ){
                $idJefe = $beanUserLeasing->reports_to_id;
                $beanJefe = BeanFactory::getBean('Users', $idJefe , array('disable_row_level_security' => true));
                $emailLeasing = $beanJefe->email1;

            }else{

                $emailLeasing = $beanUserLeasing->email1;
            }

            if( $emailLeasing !== ""){
                array_push($emailsList, $emailLeasing);
            }

        }else{
            //Si la cuenta no tiene usuario leasing, se notifica a Juan Carlos Vera
            $listRechazoLeasing = $app_list_strings['robina_rechazo_leasing_list'];
            $emailEncargadoLeasing = "";
            for ($i=0; $i < count($listRechazoLeasing); $i++) { 
                $emailEncargadoLeasing = $listRechazoLeasing[$i];
            }

            if( $emailEncargadoLeasing !== ""){
                array_push($emailsList, $emailEncargadoLeasing);
            }

        }

        $listEmailsEncargados = $app_list_strings['robina_rechazo_list'];

        for ($i=0; $i < count($listEmailsEncargados) ; $i++) { 
            array_push($emailsList, $listEmailsEncargados[$i]);
        }

        return $emailsList;
    }

    public function sendEmailRechazo( $nombreCuenta,$emailsList, $bodyCorreo ){
        try{
            global $app_list_strings;
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject('Se rechaza la actualización de la razón Social de '.$nombreCuenta);
            $body = trim($bodyCorreo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            for ($i=0; $i < count($emailsList); $i++) {
                $GLOBALS['log']->fatal("AGREGANDO CORREOS DESTINATARIOS: ".$emailsList[$i]);
                $mailer->addRecipientsTo(new EmailIdentity($emailsList[$i], $emailsList[$i]));
            }
            $result = $mailer->send();

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ");
            $GLOBALS['log']->fatal(print_r($e,true));

        }
    }

    public function insertAuditJSONDirecciones($id_cuenta){

        global $current_user;
        $id_user = $current_user->id;
        $parent_id = $id_cuenta;
        $id_audit = create_guid();
        $date = TimeDate::getInstance()->nowDb();

        $beanCuenta = BeanFactory::getBean('Accounts', $id_cuenta , array('disable_row_level_security' => true));

        $json_direcciones = $beanCuenta->json_direccion_audit_c;

        $insertQueryAudit ="INSERT INTO `accounts_audit` (`id`,`parent_id`,`date_created`,`created_by`,`field_name`,`data_type`,`before_value_string`,`after_value_string`,`before_value_text`,`after_value_text`,`event_id`,`date_updated`) VALUES ('{$id_audit}','{$parent_id}','{$date}','{$id_user}','json_direccion_audit_c','text',NULL,NULL,'{$json_direcciones}','','',NULL)";
        
        $GLOBALS['db']->query($insertQueryAudit);

    }

    public function reestableceBanderasDireccion($id_direccion){

        $queryResetDireccion = "UPDATE dire_direccion_cstm SET json_audit_c = '', cambio_direccion_c = '0', valid_cambio_razon_social_c = '0' WHERE id_c = '{$id_direccion}'";
        $GLOBALS['log']->fatal("UPDATE BANDERAS DE DIRECCION");
        $GLOBALS['log']->fatal($queryResetDireccion);
        $GLOBALS['db']->query($queryResetDireccion);
    }

}
