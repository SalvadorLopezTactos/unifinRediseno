<?php

/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 9/01/20
 * Time: 05:03 PM
 */
class check_duplicateAccounts extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            //GET
            'existsAccounts' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('existsLeadAccounts'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'validation_process',
                //short help string to be displayed in the help documentation
                'shortHelp' => 't',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            )

        );
    }

    public function validation_process($api, $args)
    {
        $id_Lead = $args['id'];
        $msjExiste = "El Lead que intentas convertir ya está registrada como Cuenta";
        $hayReunionPlaneada = false;
        $responseLEads = array();
        $finish = array();
        global $sugar_config;
        global $app_list_strings;
        global $current_user;
        $url = $sugar_config['site_url'];
        /**
         * Validamos que el Lead no exista en Cuentas
         */
        $bean = BeanFactory::retrieveBean('Leads', $id_Lead, array('disable_row_level_security' => true));
        // $GLOBALS['log']->fatal("nombre del LEads " . $bean->first_name);
        $result = $this->existLeadAccount($bean);
        $count = count($result);
        if ($bean->subtipo_registro_c != "4" && $bean->subtipo_registro_c != "3") { //SUBTIPO DE LEAD ES DIFERENTE DE 4-CONVERTIDO Y DE 3-CANCELADO
            if ($count == 0) {
                $responsMeeting = $this->getMeetingsUser($bean);
                $requeridos = $this->validaRequeridos($bean);
                if ($responsMeeting['status'] != "stop" && $requeridos == "") {
                    /** Creamos la Cuenta */
                    //Obtener el puesto del usuario
                    $idAsesor = $responsMeeting['data']['LEASING'];
                    //Comprobando que el usuario asignado a la reunión tenga menos de 20 registros asignados
                    //Obteniendo puesto del usuario asignado a la reunión
                    $usuario_asesor = BeanFactory::retrieveBean('Users', $idAsesor, array('disable_row_level_security' => true));
                    $puesto_asesor = $usuario_asesor->puestousuario_c;
                    $limitePersonal = ($usuario_asesor->limite_asignacion_lm_c > 0) ? $usuario_asesor->limite_asignacion_lm_c : 0;
                    $args = array('id_user' => $idAsesor);
                    $classProtocolo = new GetRegistrosAsignadosForProtocolo();
                    $objRegistrosAsignados = $classProtocolo->getRecordsAssign("", $args);
                    $total_asignados = $objRegistrosAsignados['total_asignados'];

                    $GLOBALS['log']->fatal("Total de asignados: " . $total_asignados . " Usuario: " . $usuario_asesor->user_name . " Puesto: " . $puesto_asesor);

                    //Obteniendo número máximo de registros asignados que puede tener un asesor
                    $max_registros_list = $app_list_strings['limite_maximo_asignados_list'];
                    $max_registros = ($limitePersonal > 0) ? $limitePersonal : intval($max_registros_list['1']);

                    //Se manipula el $total_asignados para que el usuario logueado si tenga posibilidad de convertir
                    //en el caso de que se encuentre asignado al bean del Lead y evitar mostrar la restricción sobre el límite máximo de asignados
                    if ($current_user->id == $bean->assigned_user_id) {
                        $total_asignados = 0;
                    }

                    if ($total_asignados >= $max_registros && ($puesto_asesor == '2' || $puesto_asesor == '5')) { //2-Director Leasing, 5-Asesor Leasing

                        $msj_reunion = "No es posible generar la conversión pues el Asesor asignado a la Reunión/Llamada ya cuenta con más de " . $max_registros . " registros Asignados<br>Para continuar es necesario atender alguno de sus registros asignados";

                        $finish = array("idCuenta" => "", "mensaje" => $msj_reunion);
                    } else {
                        $arr_cases=$this->getLeadCasos($bean);
                        $bean_account = $this->createAccount($bean, $responsMeeting, false,$arr_cases);

                        if (!empty($bean_account->id)) {
                            $resultadoRelaciones = $this->getContactAssoc($bean, $bean_account);

                            // Cambiamos Estatus Leads tipo_registro_c    ----  subtipo_registro_c
                            // $bean->tipo_registro_c = "";
                            $bean->subtipo_registro_c = 4;
                            $bean->account_id = $bean_account->id;
                            $bean->account_name = $bean_account->name;
                            $bean->save();
                            // Re-asignamos reuniones, llamadas, tareas y notas de Leads a Cuentas
                            $this->re_asign_meetings($bean, $bean_account->id);

                            $msj_succes = <<<SITE
                            Conversión Completa <br>
    <b></b><a href="$url/#Accounts/$bean_account->id">$bean_account->name</a></b>
    SITE;

                            $finish = array("idCuenta" => $bean_account->id, "mensaje" => $msj_succes);
                        }
                    }

                    // return array("idCuenta" => $bean_account->id, $resultadoRelaciones);
                } else {
                    if ($requeridos != "") {
                        $msj_reunion = "Hace falta completar la siguiente información para convertir un <b>Lead: </b><br>" . $requeridos . "<br>";
                    }
                    if ($responsMeeting['status'] == "stop" || $responsMeeting['vacio']) {
                        $msj_reunion .= <<<SITE
                        El proceso no puede continuar. Falta al menos una <b>Reunión/Llamada Planificada o Realizada asignada a un Asesor.</b>
SITE;
                    }
                    $finish = array("idCuenta" => "", "mensaje" => $msj_reunion);
                }
            } elseif ($count > 0) {
                /** Si la cuenta existe actualizamos los asesores que se encuentre vacios o como 9 sin gestor en la cuenta encontrada */
                $id_account = $result[0]['id'];
                $responsMeeting = $this->getMeetingsUser($bean);
                if ($responsMeeting['status'] == 'continue') {
                    $beanAccountExist = BeanFactory::retrieveBean('Accounts', $id_account, array('disable_row_level_security' => true));
                    $beanAccountExist->user_id_c = (($beanAccountExist->user_id_c == "569246c7-da62-4664-ef2a-5628f649537e"
                        || $beanAccountExist->user_id_c == "") && $responsMeeting['data']['LEASING'] != "") ? $responsMeeting['data']['LEASING'] : $beanAccountExist->user_id_c;
                    $beanAccountExist->user_id1_c = (($beanAccountExist->user_id1_c == "569246c7-da62-4664-ef2a-5628f649537e"
                        || $beanAccountExist->user_id1_c == "") && $responsMeeting['data']['FACTORAJE'] != "") ? $responsMeeting['data']['FACTORAJE'] : $beanAccountExist->user_id1_c;
                    $beanAccountExist->user_id2_c = (($beanAccountExist->user_id2_c == "569246c7-da62-4664-ef2a-5628f649537e"
                        || $beanAccountExist->user_id2_c == "") && $responsMeeting['data']['CREDITO AUTOMOTRIZ'] != "") ? $responsMeeting['data']['CREDITO AUTOMOTRIZ'] : $beanAccountExist->user_id2_c;
                    $beanAccountExist->user_id6_c = (($beanAccountExist->user_id6_c == "569246c7-da62-4664-ef2a-5628f649537e"
                        || $beanAccountExist->user_id6_c == "") && $responsMeeting['data']['FLEET'] != "") ? $responsMeeting['data']['FLEET'] : $beanAccountExist->user_id6_c;
                    $beanAccountExist->user_id8_c = (($beanAccountExist->user_id8_c == "569246c7-da62-4664-ef2a-5628f649537e"
                        || $beanAccountExist->user_id8_c == "") && $responsMeeting['data']['RM'] != "") ? $responsMeeting['data']['RM'] : $beanAccountExist->user_id8_c;
                    $beanAccountExist->save();
                }
                $bean->subtipo_registro_c = "4";
                $bean->save();
                $msj_succes_duplic = <<<SITE
                        Los Asesores han sido actualizados en la cuenta <br>
<b></b><a href="$url/#Accounts/$beanAccountExist->id">$beanAccountExist->name</a></b>
SITE;
                $finish = array("idCuenta" => $beanAccountExist->id, "mensaje" => $msj_succes_duplic);
            }
        } else {
            $finish = array("idCuenta" => "", "mensaje" => "El Lead ya ha sido convertido.");
        }
        return $finish;
    }

    public function createAccount($bean_Leads, $idMeetings, $rel,$cases)
    {
        $bean_account = BeanFactory::newBean('Accounts');
        if ($rel) {
            $bean_account->subtipo_registro_cuenta_c = "";
            $bean_account->tipo_registro_cuenta_c = "4"; // Persona - 4
            $bean_account->user_id_c = "569246c7-da62-4664-ef2a-5628f649537e";
            $bean_account->user_id1_c = "569246c7-da62-4664-ef2a-5628f649537e";
            $bean_account->user_id2_c = "569246c7-da62-4664-ef2a-5628f649537e";
            $bean_account->user_id6_c = "569246c7-da62-4664-ef2a-5628f649537e";
            $bean_account->user_id8_c = "569246c7-da62-4664-ef2a-5628f649537e";
        } else {
            $bean_account->subtipo_registro_cuenta_c = "2"; // Contactado - 2
            $bean_account->tipo_registro_cuenta_c = "2"; //Prospecto - 2
        }
        switch ($bean_Leads->regimen_fiscal_c) {
            case 1:
                $bean_account->tipodepersona_c = "Persona Fisica";
                break;
            case 2:
                $bean_account->tipodepersona_c = "Persona Fisica con Actividad Empresarial";
                break;
            case 3:
                $bean_account->tipodepersona_c = "Persona Moral";
                break;
            default:
                $bean_account->tipodepersona_c = $bean_Leads->regimen_fiscal_c;
                break;
        }
        $bean_account->origen_cuenta_c = $bean_Leads->origen_c;
        $bean_account->detalle_origen_c = $bean_Leads->detalle_origen_c;
        $bean_account->prospeccion_propia_c = $bean_Leads->prospeccion_propia_c;
        $bean_account->user_id3_c = $bean_Leads->user_id1_c; // Agente telefonico
        $bean_account->user_id4_c = $bean_Leads->user_id_c; // ¿Que Asesor?
        $bean_account->medio_detalle_origen_c = $bean_Leads->medio_digital_c;
        $bean_account->punto_contacto_origen_c = $bean_Leads->punto_contacto_c;
        $bean_account->evento_c = $bean_Leads->evento_c;
        $bean_account->tct_origen_busqueda_txf_c = $bean_Leads->origen_busqueda_c;
        $bean_account->camara_c = $bean_Leads->camara_c;
        $bean_account->tct_que_promotor_rel_c = $bean_Leads->origen_ag_tel_c;
        $bean_account->account_id1_c = $bean_Leads->account_id_c; //Vendor
        $bean_account->account_id_c = $bean_Leads->account_id1_c; //Socio comercial
        $bean_account->codigo_expo_c = $bean_Leads->codigo_expo_c; //Código Expo
        $bean_account->nombre_comercial_c = $bean_Leads->nombre_empresa_c;
        $bean_account->razonsocial_c = $bean_Leads->nombre_empresa_c;
        $bean_account->primernombre_c = $bean_Leads->nombre_c;
        $bean_account->apellidomaterno_c = $bean_Leads->apellido_materno_c;
        $bean_account->apellidopaterno_c = $bean_Leads->apellido_paterno_c;
        $bean_account->genero_c = $bean_Leads->genero_c;
        //$bean_account->tct_macro_sector_ddw_c = $bean_Leads->macrosector_c;
        $bean_account->ventas_anuales_c = $bean_Leads->ventas_anuales_c;
        $bean_account->potencial_cuenta_c = $bean_Leads->potencial_lead_c;
        $bean_account->zonageografica_c = $bean_Leads->zona_geografica_c;
        $bean_account->puesto_cuenta_c = $bean_Leads->puesto_c;
        $bean_account->email = $bean_Leads->email;
        $bean_account->clean_name = $bean_Leads->clean_name_c;
		    $bean_account->rfc_c = $bean_Leads->rfc_c;
        $bean_account->convertido_c = 1;
        $bean_account->onboarding_chk_c=$bean_Leads->onboarding_chk_c;
        $GLOBALS['log']->fatal("lead". $bean_Leads->origen_c .'-'.$bean_Leads->detalle_origen_c);
        if($bean_Leads->origen_c == '12' && $bean_Leads->detalle_origen_c == '12'){
            $bean_account->alianza_soc_chk_c = 1;
        }else{
            $bean_account->alianza_soc_chk_c = $bean_Leads->alianza_soc_chk_c;
        }

        // Asesores
        if ($idMeetings != null) {
            $bean_account->user_id_c = empty($idMeetings['data']['LEASING']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['LEASING'];
            $bean_account->user_id1_c = empty($idMeetings['data']['FACTORAJE']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['FACTORAJE'];
            $bean_account->user_id2_c = empty($idMeetings['data']['CREDITO AUTOMOTRIZ']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['CREDITO AUTOMOTRIZ'];
            $bean_account->user_id6_c = empty($idMeetings['data']['FLEET']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['FLEET'];
            $bean_account->user_id8_c = empty($idMeetings['data']['RM']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['RM'];
            if (empty($idMeetings['data']['UNICLICK']) && empty($idMeetings['data']['UNILEASE'])) {
                $bean_account->user_id7_c = '569246c7-da62-4664-ef2a-5628f649537e';
            } else if (!empty($idMeetings['data']['UNICLICK'])) {
                $bean_account->user_id7_c = $idMeetings['data']['UNICLICK'];
            } else if (!empty($idMeetings['data']['UNILEASE'])) {
                $bean_account->user_id7_c = $idMeetings['data']['UNILEASE'];
            }
        }
        //Clasificación Sectorial
        if (!empty($bean_Leads->actividad_economica_c)) {
            $bean_account->actividadeconomica_c = $bean_Leads->actividad_economica_c;
            $bean_account->sectoreconomico_c = $bean_Leads->sector_economico_c;
            $bean_account->subsectoreconomico_c = $bean_Leads->subsector_c;
            $bean_account->tct_macro_sector_ddw_c = $bean_Leads->macrosector_c;
        }
        //Valida si es homonimo
        if($bean_Leads->homonimo_c){
            $bean_account->tct_homonimo_chk_c = 1;
        }
        //Guarda cuenta
        $bean_account->save();

        /* Se agregan los casos del Lead hacia la Cuenta */
        if(count($cases)>0){
            for ($i=0; $i <count($cases) ; $i++) {
                $bean_account->load_relationship('cases');
                $bean_account->cases->add($cases[$i]);
            }
        }

        // creamos las relaciones en telefono
        $principal = 1;
        if (!empty($bean_Leads->phone_mobile)) {
            $resp_reus_tel = $this->create_phone($bean_account->id, $bean_Leads->phone_mobile, 3, $bean_Leads->m_estatus_telefono_c, $principal);
            $principal = 0;
        }
        if (!empty($bean_Leads->phone_home)) {
            $resp_reus_tel = $this->create_phone($bean_account->id, $bean_Leads->phone_home, 1, $bean_Leads->c_estatus_telefono_c, $principal);
            $principal = 0;
        }
        if (!empty($bean_Leads->phone_work)) {
            $resp_reus_tel = $this->create_phone($bean_account->id, $bean_Leads->phone_work, 2, $bean_Leads->o_estatus_telefono_c, $principal);
            $principal = 0;
        }

        $bean_account->pendiente_reus_c = ($resp_reus_tel == 3) ? true : false;

        //Campos PB
        $bean_Resumen = BeanFactory::retrieveBean('tct02_Resumen', $bean_account->id, array('disable_row_level_security' => true));
        $bean_Resumen->pb_division_c = $bean_Leads->pb_division_c;
        $bean_Resumen->pb_grupo_c = $bean_Leads->pb_grupo_c;
        $bean_Resumen->pb_clase_c = $bean_Leads->pb_clase_c;
        //Campos INEGI
        if (!empty($bean_Leads->actividad_economica_c)) {
            $bean_Resumen->inegi_clase_c = $bean_Leads->inegi_clase_c;
            $bean_Resumen->inegi_rama_c = $bean_Leads->inegi_rama_c;
            $bean_Resumen->inegi_subrama_c = $bean_Leads->inegi_subrama_c;
            $bean_Resumen->inegi_sector_c = $bean_Leads->inegi_sector_c;
            $bean_Resumen->inegi_subsector_c = $bean_Leads->inegi_subsector_c;
            $bean_Resumen->inegi_macro_c = $bean_Leads->inegi_macro_c;
        }
        $bean_Resumen->save();

        return $bean_account;
    }

    public function existLeadAccount($bean_lead)
    {
        $accounts_bean = BeanFactory::getBean('Accounts');
        $accounts_bean->disable_row_level_security = true;

        $sql = new SugarQuery();
        $sql->select(array('id', 'clean_name'));
        $sql->from($accounts_bean);
        $sql->where()->equals('clean_name', $bean_lead->clean_name_c);
        $sql->where()->notEquals('id', $bean_lead->id);
        if($bean_lead->homonimo_c){
            $result = array();
        }else{
            $result = $sql->execute();
        }
        
        return $result;
    }

    public function getMeetingsUser($beanL)
    {
		global $current_user;
        $procede = array("status" => "stop", "data" => array());
        //Recupera reuniones
        if ($beanL->load_relationship('meetings')) {
            $relatedBeans = $beanL->meetings->getBeans();

            if (!empty($relatedBeans)) {

                foreach ($relatedBeans as $meeting) {

                    //if ($meeting->status != "Not Held") {

                    $procede['status'] = "continue";
                    $sqlUser = new SugarQuery();
                    $sqlUser->select(array('id', 'puestousuario_c', 'tipodeproducto_c'));
                    $sqlUser->from(BeanFactory::newBean('Users'));
                    $sqlUser->where()->equals('id', $meeting->assigned_user_id);
                    //$sqlUser->where()->notEquals('puestousuario_c', "");
                    $sqlResult = $sqlUser->execute();

                    $productos = $sqlResult[0]['tipodeproducto_c'];
                    $puesto = $sqlResult[0]['puestousuario_c'];

                    // agregar que discrimine agente telefonico y cordinar de centro de prospeccion  27 y 31
                    if ($productos == '1' && ($puesto != "27" && $puesto != "31")) {

                        $procede['data']['LEASING'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '3' && ($puesto != "27" && $puesto != "31")) {

                        $procede['data']['CREDITO AUTOMOTRIZ'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '4' && ($puesto != "27" && $puesto != "31")) {

                        $procede['data']['FACTORAJE'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '6' && ($puesto != "27" && $puesto != "31")) {

                        $procede['data']['FLEET'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '8') {

                        $procede['data']['UNICLICK'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '9') {

                        $procede['data']['UNILEASE'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '11') {

                        $procede['data']['RM'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '10') {

                        $procede['data']['SEGUROS'] = $meeting->assigned_user_id;
                    }

                    $procede['vacio'] = empty($procede['data']) ? true : false;

                    //}
                }
            } else {
				if(!in_array("Seguros - Creditaria", ACLRole::getUserRoleNames($current_user->id))) {
					$procede['status'] = "stop";
					$procede['data'] = array();
					// $GLOBALS['log']->fatal("No tiene Reuniones no puede continuar aqui rompe  " . print_r($procede, true));
				} else $procede['status'] = "continue";
            }
        }
        //Recupera llamadas
        if ($beanL->load_relationship('calls')) {
            $relatedBeans = $beanL->calls->getBeans();

            if (!empty($relatedBeans)) {

                foreach ($relatedBeans as $meeting) {

                    //if ($meeting->status != "Not Held") {

                    $procede['status'] = "continue";
                    $sqlUser = new SugarQuery();
                    $sqlUser->select(array('id', 'puestousuario_c', 'tipodeproducto_c'));
                    $sqlUser->from(BeanFactory::newBean('Users'));
                    $sqlUser->where()->equals('id', $meeting->assigned_user_id);
                    //$sqlUser->where()->notEquals('puestousuario_c', "");
                    $sqlResult = $sqlUser->execute();

                    $productos = $sqlResult[0]['tipodeproducto_c'];
                    $puesto = $sqlResult[0]['puestousuario_c'];

                    // agregar que discrimine agente telefonico y cordinar de centro de prospeccion  27 y 31
                    if ($productos == '1' && ($puesto != "27" && $puesto != "31")) {

                        $procede['data']['LEASING'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '3' && ($puesto != "27" && $puesto != "31")) {

                        $procede['data']['CREDITO AUTOMOTRIZ'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '4' && ($puesto != "27" && $puesto != "31")) {

                        $procede['data']['FACTORAJE'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '6' && ($puesto != "27" && $puesto != "31")) {

                        $procede['data']['FLEET'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '8') {

                        $procede['data']['UNICLICK'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '9') {

                        $procede['data']['UNILEASE'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '11') {

                        $procede['data']['RM'] = $meeting->assigned_user_id;
                    }
                    if ($productos == '10') {

                        $procede['data']['SEGUROS'] = $meeting->assigned_user_id;
                    }

                    $procede['vacio'] = empty($procede['data']) ? true : false;

                    //}
                }
            }
        }

        return $procede;
    }

    public function validaRequeridos($beanLEad)
    {
        $campos = "";
        $subTipoLead = $beanLEad->subtipo_registro_c;
        $tipoPersona = $beanLEad->regimen_fiscal_c;
        $campos_req = ['origen_c'];
        $response = false;
        $errors = [];

        switch ($subTipoLead) {
                /*******SUB-TIPO SIN CONTACTAR*****/
            case '1':
                if ($tipoPersona == '3') {
                    array_push($campos_req, 'nombre_empresa_c');
                } else {
                    array_push($campos_req, 'nombre_c', 'apellido_paterno_c');
                }
                break;
                /********SUB-TIPO CONTACTADO*******/
            case '2':
                if ($tipoPersona == '3') {
                    array_push($campos_req, 'nombre_empresa_c');
                } else {
                    array_push($campos_req, 'nombre_c', 'apellido_paterno_c', 'puesto_c');
                }

                array_push($campos_req, 'ventas_anuales_c', 'zona_geografica_c', 'email');

                break;
        }

        /** Validamos que el valor no sea vacio, null o undefine */
        $flag_req = [];
        foreach ($campos_req as $req) {
            if (empty($beanLEad->$req) && isset($beanLEad->$req)) {
                array_push($flag_req, $req);
            }
        }
        $label = [];
        foreach ($flag_req as $key => $valor) {

            $str_label = translate($GLOBALS['dictionary']['Lead']['fields'][$valor]['vname'], "Leads");
            $str_label = trim($str_label, ":");
            $campos = $campos . '<b>' . $str_label . '</b><br>';

            array_push($label, $str_label);
        }


        if ($beanLEad->phone_mobile == '' && $beanLEad->phone_home == '' && $beanLEad->phone_work == '' && $beanLEad->subtipo_registro_c == '2') {
            $campos = $campos . '<b>' . 'Al menos un Teléfono' . '</b><br>';
        }
        $GLOBALS['log']->fatal("Si Labels  en vista " . $campos);
        return $campos;
    }

    public function getContactAssoc($beanLead, $bean_account)
    {
        $resultado = array("data" => array());
        if ($beanLead->load_relationship('leads_leads_1')) {
            $relatedBeans = $beanLead->leads_leads_1->getBeans();
            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $lead) {
                    $result = $this->existLeadAccount($lead);
                    $count = count($result);
                    if ($count > 0) {
                        // $GLOBALS['log']->fatal("Si existe recupero el id  " . $result[0]['id'] . " y creamos la relacion");
                        $this->create_relationship($bean_account, $result[0]['id']);
                        array_push($resultado['data'], $result[0]['id']);
                    } else {
                        // $GLOBALS['log']->fatal("No existe el Contacto asociado en Cuentas hay que crearlo ");
                        $cuenta = $this->createAccount($lead, null, true,array());
                        if (!empty($cuenta->id)) {
                            $this->re_asign_meetings($lead, $cuenta->id);
                            $this->create_relationship($bean_account, $cuenta->id);
                            array_push($resultado['data'], $cuenta->id);
                            $lead->account_id = $cuenta->id;
                            $lead->account_name = $cuenta->name;
                        }
                    }
                    $lead->subtipo_registro_c = 4;
                    $lead->save();
                }
            } else {
                // no existen Asociados no se hace nada
                $resultado['data'] = null;
            }
        }
        // $GLOBALS['log']->fatal("Resultado de Relaciones " . print_r($resultado, true));
        return $resultado;
    }

    public function getLeadCasos($beanLead){
        $arr_casos=array();
        if ($beanLead->load_relationship('leads_cases_1')) {
            $relatedCases = $beanLead->leads_cases_1->getBeans();
            if (!empty($relatedCases)) {
                foreach ($relatedCases as $case) {
                    array_push($arr_casos,$case->id);
                }
            }
        }
        return $arr_casos;
    }

    public function create_relationship($id_parent, $idAccount)
    {
        // rel_relaciones_accounts_1
        // $GLOBALS['log']->fatal("id Padre " . $id_parent->id . "  id hijo " . $idAccount);
        $bean_relacion = BeanFactory::newBean('Rel_Relaciones');
        $bean_relacion->rel_relaciones_accounts_1accounts_ida = $id_parent->id; // Cuenta padre
        $bean_relacion->rel_relaciones_accounts_1_name = $id_parent->name;
        $bean_relacion->relaciones_activas = "^Contacto^";
        $bean_relacion->account_id1_c = $idAccount; // cuenta hijo
        $bean_relacion->tipodecontacto = "Promocion";
        $bean_relacion->save();
    }

    public function create_phone($idCuenta, $phone, $tipoTel, $estatus_telefono, $principal)
    {
        /************* Validación REUS telefono *****************/
        $reus = $this->REUS_telefono($phone);
        /************* Creación Telefono ************************/
        $bean_relacionTel = BeanFactory::newBean('Tel_Telefonos');
        $bean_relacionTel->accounts_tel_telefonos_1accounts_ida = $idCuenta;
        $bean_relacionTel->name = $phone;
        $bean_relacionTel->telefono = $phone;
        $bean_relacionTel->tipotelefono = $tipoTel;
        $bean_relacionTel->tipotelefono = $tipoTel;
        $bean_relacionTel->tipotelefono = $tipoTel;
        $bean_relacionTel->estatus = "Activo";
        $bean_relacionTel->pais = 2;
        $bean_relacionTel->principal = $principal;
        if($reus == 1) { $bean_relacionTel->registro_reus_c = 1; }
	      $bean_relacionTel->estatus_telefono_c = $estatus_telefono;
        $bean_relacionTel->save();
        return $reus;
    }

    public function re_asign_meetings($bean_LEad, $idCuenTa)
    {
        //Reasigna Llamadas
        if ($bean_LEad->load_relationship('calls')) {
            $relatedBeans = $bean_LEad->calls->getBeans();
            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $call) {
                    global $db;
                    $meetUpdate = "update calls set parent_type = 'Accounts', status='Held', parent_id = '{$idCuenTa}' where id = '{$call->id}'";
                    $updateResult = $db->query($meetUpdate);
                }
            }
        }
        //Reasigna Reuniones
        if ($bean_LEad->load_relationship('meetings')) {
            $relatedBeans = $bean_LEad->meetings->getBeans();
            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $meeting) {
                    global $db;
                    $meetUpdate = "update meetings set parent_type = 'Accounts', parent_id = '{$idCuenTa}' where id = '{$meeting->id}'";
                    $updateResult = $db->query($meetUpdate);
                }
            }
        }
        //Reasigna Tareas
        if ($bean_LEad->load_relationship('tasks')) {
            $relatedBeans = $bean_LEad->tasks->getBeans();
            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $task) {
                    global $db;
                    $meetUpdate = "update tasks set parent_type = 'Accounts', parent_id = '{$idCuenTa}' where id = '{$task->id}'";
                    $updateResult = $db->query($meetUpdate);
                    $bean_LEad->load_relationship('tasks_leads_1');
                    $bean_LEad->tasks_leads_1->add($task->id);
                }
            }
        }
        //Reasigna Notas
        if ($bean_LEad->load_relationship('notes')) {
            $relatedBeans = $bean_LEad->notes->getBeans();
            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $note) {
                    global $db;
                    $meetUpdate = "update notes set parent_type = 'Accounts', parent_id = '{$idCuenTa}' where id = '{$note->id}'";
                    $updateResult = $db->query($meetUpdate);
                    $bean_LEad->load_relationship('notes_leads_1');
                    $bean_LEad->notes_leads_1->add($note->id);
                }
            }
        }

         //Recupera ANALIZATE
         if ($bean_LEad->load_relationship('leads_anlzt_analizate_1')) {
            $relatedBeans = $bean_LEad->leads_anlzt_analizate_1->getBeans();
            if (!empty($relatedBeans)) {
                    global $db;
                    $insertanalizate = "INSERT IGNORE INTO anlzt_analizate_accounts_c
                    select id,
                    NOW() date_modified,
                    0 deleted,
                    '{$idCuenTa}' anlzt_analizate_accountsaccounts_ida,
                    leads_anlzt_analizate_1anlzt_analizate_idb anlzt_analizate_accountsanlzt_analizate_idb 
                    FROM leads_anlzt_analizate_1_c 
                    where leads_anlzt_analizate_1leads_ida='{$bean_LEad->id}'";
                    $insertResult = $db->query($insertanalizate);
            }
        }

        //Reasigna Licitaciones
        $GLOBALS['log']->fatal("Obtiene Licitaciones y añade a la cuenta.");
        global $db;
        $query = "SELECT licitacion.id FROM lic_licitaciones as licitacion
        INNER JOIN leads_lic_licitaciones_1_c as intermedia ON intermedia.leads_lic_licitaciones_1lic_licitaciones_idb = licitacion.id AND intermedia.deleted = 0
        WHERE intermedia.leads_lic_licitaciones_1leads_ida = '{$bean_LEad->id}'";

        $queryResult = $db->query($query);
        while ($row = $db->fetchByAssoc($queryResult)) {

            $beanlicitacion = BeanFactory::retrieveBean('Lic_Licitaciones', $row['id'], array('disable_row_level_security' => true));
            $beanlicitacion->lic_licitaciones_accountsaccounts_ida  = $idCuenTa;
            $GLOBALS['log']->fatal("guarda licitacion a la cuenta.");
            $beanlicitacion->save();
        }

        //Reasigna Direcciones
        $GLOBALS['log']->fatal("Obtiene Direcciones y las guarda en la cuenta.");
        global $db;
        $queryDir = "SELECT direccion.id FROM dire_direccion as direccion
        INNER JOIN leads_dire_direccion_1_c as intermedia ON intermedia.leads_dire_direccion_1dire_direccion_idb = direccion.id AND intermedia.deleted = 0
        WHERE intermedia.leads_dire_direccion_1leads_ida = '{$bean_LEad->id}'";

        $queryResultD = $db->query($queryDir);
        while ($rowD = $db->fetchByAssoc($queryResultD)) {

            $beanDirecciones = BeanFactory::retrieveBean('dire_Direccion', $rowD['id'], array('disable_row_level_security' => true));
            $beanDirecciones->accounts_dire_direccion_1accounts_ida  = $idCuenTa;
            $beanDirecciones->save();
        }
    }

    public function REUS_telefono($telefono = null)
    {
        $resp = 0;
        global $sugar_config, $db, $current_user;
        $phoneCuenta = false;
        //API DHW REUS PARA TELEFONOS
        $callApi = new UnifinAPI();
        $host = $sugar_config['dwh_reus_telefonos'] . "?valor=";
        //OBTENEMOS LOS TELEFONOS DE LA CUENTA
        $host .= $telefono;
        // $GLOBALS['log']->fatal($host);
        $resultado = $callApi->getDWHREUS($host);
        //$resultado = '[{"valor":"5518504488","existe":"SI"},{"valor":"5569783395","existe":"NO"}]';
        //$resultado = json_decode($resultado);
        $GLOBALS['log']->fatal('Resultado DWH REUS TELEFONOS - CUENTAS: ' . json_encode($resultado));
        if ($resultado != "" && $resultado != null) {
            //RESULTADO DEL SERVICIO DWH REUS
            foreach ($resultado as $key => $val) {
                //VALIDA EN LOS TELEFONOS DE MOBILE, CASA Y OFICINA SI ESTAN REGISTRADOS EN REUS
                // Y ACTIVA EL CHECK DEL REGISTRO REUS EN CRM
                if ($telefono == $val['valor']){
                    if ($val['existe'] == 'SI'){
                        $resp = 1;
                    }
                    if ($val['existe'] == 'NO'){
                        $resp = 2;
                    }
                }
            }
        } else {
            //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
            $GLOBALS['log']->fatal('SERVICIO DWH REUS CUENTAS NO RESPONDE - TELEFONOS');
            $resp = 3;
        }
        return $resp;
    }
}
