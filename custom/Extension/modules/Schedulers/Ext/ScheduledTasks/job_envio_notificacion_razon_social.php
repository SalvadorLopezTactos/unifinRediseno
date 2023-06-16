<?php
array_push($job_strings, 'job_envio_notificacion_razon_social');

function job_envio_notificacion_razon_social()
{
    try {

        $GLOBALS['log']->fatal('Comienza job para envío de notificación');

        $querySelectCuentas = "SELECT id_c,name,rfc_c,json_audit_c,cambio_nombre_c,enviar_mensaje_c FROM accounts a INNER JOIN accounts_cstm ac
        ON a.id = ac.id_c
        WHERE ac.enviar_mensaje_c=1";

        $resultSelect = $GLOBALS['db']->query($querySelectCuentas);
        $json_audit_cuenta = "";
        $json_audit_direccion = "";

        $cambio_nombre_cuenta = "";
        $cambio_direccion = "";

        $text_cambios = '';

        if( $resultSelect->num_rows > 0 ){

            while ($row = $GLOBALS['db']->fetchByAssoc($resultSelect)) {

                $idCuenta = $row['id_c'];
                $nombreCuenta = $row['name'];
                $rfc = $row['rfc_c'];
                $cambio_nombre_cuenta = $row['cambio_nombre_c'];
                $json_audit_cuenta = $row['json_audit_c'];

                $idDireccion="";

                $text_cambios .= '<ul>';
                //Si se detecta que el nombre de la cuenta cambió, se procede a tomar en cuenta para armar el cuerpo del correo
                if( $cambio_nombre_cuenta ){
                    $objeto_json_cuenta = json_decode($json_audit_cuenta,true);
                    $GLOBALS['log']->fatal(print_r($objeto_json_cuenta,true));

                    //Arma cuerpo correo con diferencias del nombre de la cuenta
                    $text_cambios .= '<li><b>Razón social / Nombre</b>: <b>tenía el valor</b> '. $objeto_json_cuenta['nombre_actual'] .'<b> y cambió a </b>'.$objeto_json_cuenta['nombre_por_actualizar'].'</li>';
                }

                $beanCuenta = BeanFactory::getBean('Accounts', $idCuenta);
                $plataforma_json = "";

                //Obtiene las direcciones relacionadas para detectar la Fiscal y poder armar el cuerpo de la notificación
                $indicador_direcciones_fiscales = array(2,3,6,7,10,11,14,15,18,19,22,23,26,27,30,31,34,35,38,39,42,43,46,47,50,51,54,55,58,59,62,63);
                if ($beanCuenta->load_relationship('accounts_dire_direccion_1')) {
                    $relatedDirecciones = $beanCuenta->accounts_dire_direccion_1->getBeans();
                    
                    if (!empty($relatedDirecciones)) {
                        
                        foreach ($relatedDirecciones as $direccion) {
                            
                            //Valida si tiene dirección fiscal
                            $indicador = $direccion->indicador;
                            if( in_array($indicador,$indicador_direcciones_fiscales) && !$direccion->inactivo ){
                                $GLOBALS['log']->fatal("La dirección fiscal encontrada es: ".$direccion->id);   
                                
                                $idDireccion = $direccion->id;
                                $json_audit_direccion = $direccion->json_audit_c;
                                $cambio_direccion = $direccion->cambio_direccion_c;

                                //Si la dirección fiscal cambió, se procede a tomar en cuenta para el cuerpo del correo
                                if($cambio_direccion){

                                    $objeto_json_direccion = json_decode($json_audit_direccion,true);
                                    $GLOBALS['log']->fatal(print_r($objeto_json_direccion,true));

                                    $plataforma_json = $objeto_json_direccion["plataforma"];

                                    $direcciones_completas = buildNamesDireccionesCompletas($objeto_json_direccion);
                                    $direccion_actual_completa = $direcciones_completas[0];
                                    $direccion_por_actualizar_completa = $direcciones_completas[1];

                                    $text_cambios .= '<li><b>Dirección fiscal</b>: <b>tenía el valor </b>'. ucwords($direccion_actual_completa) .'<b> y cambió a </b>'.ucwords($direccion_por_actualizar_completa).'</b></li>';
                                }

                                //Se aplica break para salir del ciclo al encontrar la dirección fiscal
                                break;
                            }
                            
                        }
                    }
                }
                $text_cambios .= '</ul>';

                //ENVIAR MENSAJE
                global $app_list_strings;
                $producto_envio = getMultiproductoParaEnvioNotificacion( $beanCuenta );

                if( $producto_envio == 'Uniclick' ){
                    $emails_responsables_cambios_list = $app_list_strings['emails_uniclick_list'];
                }
    
                if( $producto_envio == 'Credito' ){
                    $emails_responsables_cambios_list = $app_list_strings['emails_multiproducto_list'];
                }
    
                if( $producto_envio == 'Credito-Uniclick' ){
                    $emails_responsables_cambios_list = array_merge( $app_list_strings['emails_uniclick_list'], $app_list_strings['emails_multiproducto_list'] );
                }

                //$emails_responsables_cambios_list = ( $producto_envio == 'Uniclick' ) ? $app_list_strings['emails_uniclick_list'] : $app_list_strings['emails_multiproducto_list'];
                //$emails_responsables_cambios_list = $app_list_strings['emails_responsables_cambios_list'];

                $body_correo = buildBodyCambioRazon( $rfc, $text_cambios, $idCuenta, $nombreCuenta );
                sendEmailCambioRazonSocial( $emails_responsables_cambios_list, $body_correo );

                //Una vez enviado el correo, se procede a resetear bandera para que no se vuelva a enviar la notificación
                reestableceBanderas($idCuenta,$idDireccion);

                //Se crea caso
                creaCaso($idCuenta,$plataforma_json);

            }

        }else{
            $GLOBALS['log']->fatal('No se encontraron cuentas que requieran envío de notificación');
        }
        
        $GLOBALS['log']->fatal('Termina job para envío de notificación');
        return true;


    } catch (Exception $e) {
        $GLOBALS['log']->fatal("Error: " . $e->getMessage());
    }
}

function buildNamesDireccionesCompletas( $jsonDirecciones ){
    global $db;
    $GLOBALS['log']->fatal("ENTRÓ OTRA FUNCIÓN DESDE JOB");
    
    $direccion_completa_actual = "";
    $direccion_completa_por_actualizar = "";
    //CP
    $id_cp_actual = $jsonDirecciones['cp_actual'];
    $id_cp_por_actualizar = $jsonDirecciones['cp_por_actualizar'];
    //PAIS
    $id_pais_actual = $jsonDirecciones['pais_actual'];
    $id_pais_por_actualizar = $jsonDirecciones['pais_por_actualizar'];
    //ESTADO
    $id_estado_actual = $jsonDirecciones['estado_actual'];
    $id_estado_por_actualizar = $jsonDirecciones['estado_por_actualizar'];
    //MUNICIPIO
    $id_municipio_actual = $jsonDirecciones['municipio_actual'];
    $id_municipio_por_actualizar = $jsonDirecciones['municipio_por_actualizar'];
    //CIUDAD
    $id_ciudad_actual = $jsonDirecciones['ciudad_actual'];
    $id_ciudad_por_actualizar = $jsonDirecciones['ciudad_por_actualizar'];
    //COLONIA
    $id_colonia_actual = $jsonDirecciones['colonia_actual'];
    $id_colonia_por_actualizar = $jsonDirecciones['colonia_por_actualizar'];
    //CALLE
    $calle_actual = $jsonDirecciones['calle_actual'];
    $calle_por_actualizar = $jsonDirecciones['calle_por_actualizar'];
    //NUMEXT
    $numext_actual = $jsonDirecciones['numext_actual'];
    $numext_por_actualizar = $jsonDirecciones['numext_por_actualizar'];
    //NUMINT
    $numint_actual = $jsonDirecciones['numint_actual'];
    $numint_por_actualizar = $jsonDirecciones['numint_por_actualizar'];

    $cp_actual = obtenerNombreQuery('dire_codigopostal',$id_cp_actual);
    $cp_por_actualizar = obtenerNombreQuery('dire_codigopostal',$id_cp_por_actualizar);

    $pais_actual = obtenerNombreQuery('dire_pais',$id_pais_actual);
    $pais_por_actualizar = obtenerNombreQuery('dire_pais',$id_pais_por_actualizar);

    $estado_actual = obtenerNombreQuery('dire_estado',$id_estado_actual);
    $estado_por_actualizar = obtenerNombreQuery('dire_estado',$id_estado_por_actualizar);

    $municipio_actual = obtenerNombreQuery('dire_municipio',$id_municipio_actual);
    $municipio_por_actualizar = obtenerNombreQuery('dire_municipio',$id_municipio_por_actualizar);

    $ciudad_actual = obtenerNombreQuery('dire_ciudad',$id_ciudad_actual);
    $ciudad_por_actualizar = obtenerNombreQuery('dire_ciudad',$id_ciudad_por_actualizar);

    $colonia_actual = obtenerNombreQuery('dire_colonia',$id_colonia_actual);
    $colonia_por_actualizar = obtenerNombreQuery('dire_colonia',$id_colonia_por_actualizar);

    $direccion_completa_actual .= "Calle: ". $calle_actual .", CP: ". $cp_actual .", País: ". $pais_actual .", Estado: ". $estado_actual .", Municipio: ". $municipio_actual .", Ciudad: ". $ciudad_actual .", Colonia: ". $colonia_actual .", Número exterior: ". $numext_actual .", Número interior: ".$numint_actual;
    $direccion_completa_por_actualizar .= "Calle: ". $calle_por_actualizar .", CP: ". $cp_por_actualizar .", País: ". $pais_por_actualizar .", Estado: ". $estado_por_actualizar .", Municipio: ". $municipio_por_actualizar .", Ciudad: ". $ciudad_por_actualizar .", Colonia: ". $colonia_por_actualizar .", Número exterior: ". $numext_por_actualizar .", Número interior: ".$numint_por_actualizar;

    return array( $direccion_completa_actual, $direccion_completa_por_actualizar);
}

function obtenerNombreQuery($nombre_tabla,$id_registro){
    global $db;
    $name="";
    $query_nombre = "Select name from ".$nombre_tabla." where id ='". $id_registro ."'";
    $result_query = $db->query($query_nombre);
    
    while ($row = $db->fetchByAssoc($result_query)) {
        $name = $row['name'];
    }

    return $name;

}

    /*
    * Obtiene productos relacionados de la cuenta para saber a cual grupo de correos electrónicos de Email se envia
    * Si es Cliente en cualquier producto, se envía a un grupo
    * Si UNICAMENTE es Cliente en producto Uniclick, se envía a otro grupo diferente
    */
    function getMultiproductoParaEnvioNotificacion ( $beanPersona ){

        $area_interna = "";

        if ($beanPersona->load_relationship('accounts_uni_productos_1')) {
            //Recupera Productos para conocer el tipo de cuenta por cada uno
            $relateProduct = $beanPersona->accounts_uni_productos_1->getBeans($beanPersona->id,array('disable_row_level_security' => true));
            $array_tipo_cuenta_producto = array();
            foreach ($relateProduct as $product) {
                    //Recupera valores por producto
                    $tipoCuenta = $product->tipo_cuenta;
                    $tipoProducto = $product->tipo_producto;
                    $subtipo = $product->subtipo_cuenta; // 11 - Venta Activo

                    if( $subtipo != "11" ){

                        switch ($tipoProducto) {
                            case '1': //Leasing
                                $array_tipo_cuenta_producto['leasing'] = $tipoCuenta;
                                break;
                            case '2': //Crédito Simple
                                $array_tipo_cuenta_producto['cs'] = $tipoCuenta;
                                break;
                            case '3': //Credito-Automotriz
                                $array_tipo_cuenta_producto['ca'] = $tipoCuenta;
                                break;
                            case '4': //Factoraje
                                $array_tipo_cuenta_producto['factoraje'] = $tipoCuenta;
                                break;
                            case '6': //Fleet
                                $array_tipo_cuenta_producto['fleet'] = $tipoCuenta;
                                break;
                            case '8': //Uniclick
                                $array_tipo_cuenta_producto['uniclick'] = $tipoCuenta;
                                break;
                            case '14': //Tarjeta Crédito
                                $array_tipo_cuenta_producto['tc'] = $tipoCuenta;
                                break;
                            
                        }
                    }
            }

            //Recorre arreglo generado para conocer si es multiproducto y el caso se debe asignar a Area Interna Crédito o Uniclick
            $contador_cliente = 0;
            $contador_cliente_uniclick = 0;
            foreach ( $array_tipo_cuenta_producto as $key => $value ){
                if( $value == '3' ){
                        if( $key == 'uniclick' ){
                            $contador_cliente_uniclick += 1; 
                        }else{
                            $contador_cliente += 1;
                        }
                    }
                }
                if( $contador_cliente_uniclick > 0 && $contador_cliente == 0 ){
                    //ES CLIENTE UNICLICK, SE ESTABLECE ÁREA INTERNA UNICLICK
                    $GLOBALS['log']->fatal("ES CLIENTE UNICLICK, SE ESTABLECE ÁREA INTERNA UNICLICK");
                    $area_interna = 'Uniclick';
                
                }
                if( $contador_cliente > 0 && $contador_cliente_uniclick > 0 ){
                    //ES MULTIPRODUCTO, SE ESTABLECE ÁREA INTERNA CRÉDITO
                    $GLOBALS['log']->fatal("ES MULTIPRODUCTO Y CLIENTE UNICLICK");
                    $area_interna = 'Credito-Uniclick';
                }

                if( $contador_cliente > 0 && $contador_cliente_uniclick == 0 ){
                    //ES MULTIPRODUCTO, SE ESTABLECE ÁREA INTERNA CRÉDITO
                    $GLOBALS['log']->fatal("ES MULTIPRODUCTO, SE ESTABLECE ÁREA INTERNA CRÉDITO");
                    $area_interna = 'Credito';
                }
                
                if( $contador_cliente == 0 && $contador_cliente_uniclick == 0){
                    //NO ES CLIENTE EN NINGÚN PRODUCTO
                    $GLOBALS['log']->fatal("NO ES CLIENTE EN NINGÚN PRODUCTO");
                    $area_interna = 'Credito';
                }

        }
        

        return $area_interna;

    }

function buildBodyCambioRazon( $rfc, $text_cambios, $idCuenta, $nombreCuenta ){
    global $sugar_config;
    $url = $sugar_config['site_url'];

    $linkCuenta = '<a href="'.$url.'/#Accounts/'. $idCuenta .'">'.$nombreCuenta.'</a>';

    $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">
        Se han detectado cambios sobre la cuenta con RFC: <b>'.$rfc.'</b>.<br>
        <br>A continuación se muestra las modificaciones generadas:<br>'.
        $text_cambios.'<br>
        Se solicita la revisión de esta cuenta ' .$linkCuenta. ' para autorizar o rechazar los cambios correspondientes.
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

function sendEmailCambioRazonSocial( $emails_address,$body_correo ){

    try{
        global $app_list_strings;
        $mailer = MailerFactory::getSystemDefaultMailer();
        $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
        $mailer->setSubject('UNIFIN CRM - Cambio de valores en cuenta con mismo RFC');
        $body = trim($body_correo);
        $mailer->setHtmlBody($body);
        $mailer->clearRecipients();
        for ($i=0; $i < count($emails_address); $i++) {
            $GLOBALS['log']->fatal("AGREGANDO CORREOS DESTINATARIOS: ".$emails_address[$i]);
            $mailer->addRecipientsTo(new EmailIdentity($emails_address[$i], $emails_address[$i]));
        }
        $result = $mailer->send();

    } catch (Exception $e){
        $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ");
        $GLOBALS['log']->fatal(print_r($e,true));

    }

}

function reestableceBanderas($idCuenta,$idDireccion){
    global $db;
    
    if( $idCuenta !== "" ){
        $updateQuery ="UPDATE accounts_cstm SET valid_cambio_razon_social_c = '1', enviar_mensaje_c = '0' WHERE id_c = '{$idCuenta}'";
        $db->query($updateQuery);
    }

    if( $idDireccion !== "" ){
        $updateDirQuery ="UPDATE dire_direccion_cstm SET valid_cambio_razon_social_c = '1' WHERE id_c = '{$idDireccion}'";
        $db->query($updateDirQuery);
    }
}

function creaCaso($idCuenta,$plataforma_json){
    $GLOBALS['log']->fatal('GENERA CASO RELACIONADO DESDE PLANIFICADOR');
    $plataforma = $plataforma_json;
    $idKarla = 'd51dd49e-b1e6-572f-d6de-5654bfeb8b3e';
    $idSamuel = '92b04f7d-e547-9d4f-c96a-5a31da014bdd';
    $asunto = 'Cambio de información con mismo RFC';
    // 8 - Crédito Uniclick, 1 - Arrendamiento
    $producto = ( $plataforma == 'cvimUniclick' || $plataforma == 'UNICLICK' ) ?  '8' : '1';
    $tipo = '8'; // Modificación de datos
    $subtipo = '48'; // Actualización de datos de contacto
    $prioridad = 'P4'; // Urgente
    $status = '1'; // No iniciado
    $asignado = ( $plataforma == 'cvimUniclick' || $plataforma == 'UNICLICK' ) ? $idSamuel : $idKarla;
    $area_interna = ( $plataforma == 'cvimUniclick' || $plataforma == 'UNICLICK' ) ?  'Uniclick': 'Credito'; // Agregar id de uniclick

    $caso = BeanFactory::newBean('Cases');
    $caso->name = $asunto;
    $caso->producto_c = $producto;
    $caso->type = $tipo;
    $caso->subtipo_c = $subtipo;
    $caso->priority = $prioridad;
    $caso->status = $status;
    $caso->assigned_user_id = $asignado;
    $caso->account_id = $idCuenta;
    $caso->area_interna_c = $area_interna;

    //Fix: Añade bandera para que al crear caso, la validación de asignación únicamente se aplique en cambio de razón social o direccion fiscal
    $caso->valida_cambio_fiscal_c = 1;

    $caso->save();
}