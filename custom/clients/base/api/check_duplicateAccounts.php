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
        $url = $sugar_config['site_url'];
        /**
         * Validamos que el Lead no exista en Cuentas
         */
        $bean = BeanFactory::retrieveBean('Leads', $id_Lead, array('disable_row_level_security' => true));
        // $GLOBALS['log']->fatal("nombre del LEads " . $bean->first_name);


        $result = $this->existLeadAccount($bean);
        $count = count($result);
        $GLOBALS['log']->fatal("existencia" . print_r($result, true));
        $GLOBALS['log']->fatal("Count consulta: " . $count);

        if ($bean->subtipo_registro_c != "4") {
            if ($count == 0) {

                $responsMeeting = $this->getMeetingsUser($bean);
                $GLOBALS['log']->fatal("nombre del Leads " . print_r($responsMeeting, true));

                $GLOBALS['log']->fatal("Requeridos " . $requeridos);

                $requeridos= $this->validaRequeridos($bean);

                if (($responsMeeting['status'] != "stop" && !empty($responsMeeting['data'])) && $requeridos=="") {
                    /** Creamos la Cuenta */
                    // $GLOBALS['log']->fatal("Resultado Reunion  Exito -- " . print_r($responsMeeting['data'], true));

                    $bean_account = $this->createAccount($bean, $responsMeeting, false);

                    // $GLOBALS['log']->fatal("Cuenta Creada--- " . $bean_account->id);

                    //$this->getContactAssoc($bean, $bean_account);

                    if (!empty($bean_account->id)) {
                        $resultadoRelaciones = $this->getContactAssoc($bean, $bean_account);

                        // Cambiamos Estatus Leads tipo_registro_c    ----  subtipo_registro_c
                        // $bean->tipo_registro_c = "";
                        $bean->subtipo_registro_c = 4;
                        $bean->account_id = $bean_account->id;
                        $bean->account_name = $bean_account->name;
                        $bean->save();
                        // Re-asignamos las reuniones realizadas y planificadas de Leads a Cuentas
                        $this->re_asign_meetings($bean, $bean_account->id);

                        $msj_succes = <<<SITE
                        Conversión Completa <br>
<b></b><a href="$url/#Accounts/$bean_account->id">$bean_account->name</a></b>
SITE;


                        $finish = array("idCuenta" => $bean_account->id, "mensaje" => $msj_succes);

                    }
                    // return array("idCuenta" => $bean_account->id, $resultadoRelaciones);


                } else {

                    if($requeridos!="")
                    {
                        $msj_reunion= "Hace falta completar la siguiente información para convertir un <b>Lead: </b><br>" . $requeridos . "<br>";
                    }

                    //  $GLOBALS['log']->fatal("Resultado Reunion " . print_r($responsMeeting, true));
                    // throw new SugarApiExceptionInvalidParameter("El proceso no puede continuar Falta al menos una Reunion Planificada");
                    if($responsMeeting['status'] == "stop")
                    {
                        $msj_reunion .= <<<SITE
                        El proceso no puede continuar. Falta al menos una <b>Reunión Planificada asignada a un Asesor.</b>
SITE;
                    }

                    $finish = array("idCuenta" => "", "mensaje" => $msj_reunion);

                }

            } elseif ($count > 0) {

                /** Si la cuenta existe actualizamos los asesores que se encuentre vacios o como 9 sin gestor en la cuenta encontrada */
                $id_account = $result[0]['id'];
                $responsMeeting = $this->getMeetingsUser($bean);
                $GLOBALS['log']->fatal("usuarios en Lead  " . print_r($responsMeeting, true));

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

    public function createAccount($bean_Leads, $idMeetings, $rel)
    {
        $bean_account = BeanFactory::newBean('Accounts');
        if ($rel) {
            $bean_account->subtipo_cuenta_c = "";
            $bean_account->tipo_registro_c = "Persona";
            $bean_account->user_id_c = "569246c7-da62-4664-ef2a-5628f649537e";
            $bean_account->user_id1_c = "569246c7-da62-4664-ef2a-5628f649537e";
            $bean_account->user_id2_c = "569246c7-da62-4664-ef2a-5628f649537e";
            $bean_account->user_id6_c = "569246c7-da62-4664-ef2a-5628f649537e";

        } else {
            $bean_account->subtipo_cuenta_c = "En Calificacion";
            $bean_account->tipo_registro_c = "Lead";
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

        $bean_account->origendelprospecto_c = $bean_Leads->origen_c;
        if ($bean_Leads->origen_c == 1) {
            $bean_account->origendelprospecto_c = "Marketing";

        } elseif ($bean_Leads->origen_c == 2) {
            $bean_account->origendelprospecto_c = "Inteligencia de Negocio";

        }

        //Switch para asignar los valores
        switch ($bean_Leads->detalle_origen_c) {
            case 1:
                $bean_account->tct_detalle_origen_ddw_c = "Base de datos";
                break;
            case 2:
                $bean_account->tct_detalle_origen_ddw_c = "Centro de Prospeccion";
                break;
            case 3:
                $bean_account->tct_detalle_origen_ddw_c = "Digital";
                break;
            case 4:
                $bean_account->tct_detalle_origen_ddw_c = "Campanas";
                break;
            case 5:
                $bean_account->tct_detalle_origen_ddw_c = "Acciones Estrategicas";
                break;
            case 6:
                $bean_account->tct_detalle_origen_ddw_c = "Afiliaciones";
                break;
            case 7:
                $bean_account->tct_detalle_origen_ddw_c = "Llamdas Inbound";
                break;
            case 8:
                $bean_account->tct_detalle_origen_ddw_c = "Parques Industriales";
                break;
            case 9:
                $bean_account->tct_detalle_origen_ddw_c = "Offline";
                break;
            case 10:
                $bean_account->tct_detalle_origen_ddw_c = "Cartera Promotores";
                break;
            case 11:
                $bean_account->tct_detalle_origen_ddw_c = "Recomendacion";
                break;
            default:
                $bean_account->tct_detalle_origen_ddw_c = $bean_Leads->detalle_origen_c;
                break;
        }

        $bean_account->user_id3_c = $bean_Leads->user_id1_c; // Agente telefonico
        $bean_account->user_id4_c = $bean_Leads->user_id_c; // ¿Que Asesor?

        switch ($bean_Leads->medio_digital_c) {
            case 1:
                $bean_account->medio_digital_c = "Facebook";
                break;
            case 2:
                $bean_account->medio_digital_c = "Twitter";
                break;
            case 3:
                $bean_account->medio_digital_c = "Instagram";
                break;
            case 4:
                $bean_account->medio_digital_c = "Web";
                break;
            case 5:
                $bean_account->medio_digital_c = "LinkedIn";
                break;
            case 6:
                $bean_account->medio_digital_c = "Radio Online";
                break;
            case 7:
                $bean_account->medio_digital_c = "Prensa Online";
                break;
            case 8:
                $bean_account->medio_digital_c = "TV Online";
                break;
            case 9:
                $bean_account->medio_digital_c = "Revistas Online";
                break;
            case 10:
                $bean_account->medio_digital_c = "TV";
                break;
            case 11:
                $bean_account->medio_digital_c = "Radio";
                break;
            case 12:
                $bean_account->medio_digital_c = "Prensa";
                break;
            case 13:
                $bean_account->medio_digital_c = "Revistas";
                break;
            case 14:
                $bean_account->medio_digital_c = "Espectaculares";
                break;

            default:
                $bean_account->medio_digital_c = $bean_Leads->medio_digital_c;
                break;
        }
        switch ($bean_Leads->punto_contacto_c) {

            case 1:
                $bean_account->tct_punto_contacto_ddw_c = "Portal";

                break;
            case 2:
                $bean_account->tct_punto_contacto_ddw_c = "Telefono";

                break;
            case 3:
                $bean_account->tct_punto_contacto_ddw_c = "Chat";

                break;
            case 4:
                $bean_account->tct_punto_contacto_ddw_c = "Publicacion";

                break;
            default:
                $bean_account->tct_punto_contacto_ddw_c = $bean_Leads->punto_contacto_c;
                break;
        }
        $bean_account->evento_c = $bean_Leads->evento_c;
        $bean_account->tct_origen_busqueda_txf_c = $bean_Leads->origen_busqueda_c;
        $bean_account->camara_c = $bean_Leads->camara_c;
        $bean_account->tct_que_promotor_rel_c = $bean_Leads->origen_ag_tel_c;
        $bean_account->nombre_comercial_c = $bean_Leads->nombre_empresa_c;
        $bean_account->razonsocial_c = $bean_Leads->nombre_empresa_c;
        $bean_account->primernombre_c = $bean_Leads->nombre_c;
        $bean_account->apellidomaterno_c = $bean_Leads->apellido_materno_c;
        $bean_account->apellidopaterno_c = $bean_Leads->apellido_paterno_c;
        $bean_account->tct_macro_sector_ddw_c = $bean_Leads->macrosector_c;
        $bean_account->ventas_anuales_c = $bean_Leads->ventas_anuales_c;
        $bean_account->potencial_cuenta_c = $bean_Leads->potencial_lead_c;
        $bean_account->zonageografica_c = $bean_Leads->zona_geografica_c;

        switch ($bean_Leads->puesto_c) {

            case 1:
                $bean_account->puesto_c = "Duenio";

                break;
            case 2:
                $bean_account->puesto_c = "Accionistas";

                break;
            case 3:
                $bean_account->puesto_c = "Director General";

                break;
            case 4:
                $bean_account->puesto_c = "Director Comercial";

                break;
            case 5:
                $bean_account->puesto_c = "Director de Finanzas";

                break;
            case 6:
                $bean_account->puesto_c = "Director de Operaciones";

                break;
            case 7:
                $bean_account->puesto_c = "Director de Sistemas";

                break;
            case 8:
                $bean_account->puesto_c = "Tesorero_Contralor";

                break;
            case 9:
                $bean_account->puesto_c = "Gerente";

                break;
            case 10:
                $bean_account->puesto_c = "Administrativo";

                break;
            case 11:
                $bean_account->puesto_c = "Otro";

                break;
            default:
                $bean_account->puesto_c = $bean_Leads->punto_contacto_c;
                break;
        }

        $bean_account->email = $bean_Leads->email;
        $bean_account->clean_name = $bean_Leads->clean_name_c;

        // Asesores
        if ($idMeetings != null) {
            $bean_account->user_id_c = empty($idMeetings['data']['LEASING']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['LEASING'];
            $bean_account->user_id1_c = empty($idMeetings['data']['FACTORAJE']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['FACTORAJE'];
            $bean_account->user_id2_c = empty($idMeetings['data']['CREDITO AUTOMOTRIZ']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['CREDITO AUTOMOTRIZ'];
            $bean_account->user_id6_c = empty($idMeetings['data']['FLEET']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['FLEET'];
            $bean_account->user_id7_c = empty($idMeetings['data']['UNICLICK']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['UNICLICK'];

        }

        $bean_account->save();
        // creamos las relaciones en telefono
        if (!empty($bean_Leads->phone_mobile)) {
            $this->create_phone($bean_account->id, $bean_Leads->phone_mobile, 3);

        }
        if (!empty($bean_Leads->phone_home)) {
            $this->create_phone($bean_account->id, $bean_Leads->phone_home, 1);

        }
        if (!empty($bean_Leads->phone_work)) {
            $this->create_phone($bean_account->id, $bean_Leads->phone_work, 2);

        }
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

        $result = $sql->execute();
        return $result;
    }

    public function getMeetingsUser($beanL)
    {
        $procede = array("status" => "stop", "data" => array());
        if ($beanL->load_relationship('meetings')) {
            $relatedBeans = $beanL->meetings->getBeans();

            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $meeting) {

                    if ($meeting->status != "Not Held") {

                        if ($meeting->status == "Planned") {
                            $procede['status'] = "continue";

                        }

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

                    }
                }
            } else {
                $procede['status'] = "stop";
                $procede['data'] = array();
                // $GLOBALS['log']->fatal("No tiene Reuniones no puede continuar aqui rompe  " . print_r($procede, true));

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

                array_push($campos_req, 'macrosector_c', 'ventas_anuales_c', 'zona_geografica_c', 'email');

                break;
        }

        /** Validamos que el valor no sea vacio, null o undefine */
        $flag_req = [];
        foreach ($campos_req as $req) {
            if (empty($beanLEad->$req) && isset($beanLEad->$req)) {
                array_push($flag_req, $req);
            }
        }
        $GLOBALS['log']->fatal("Si exist " . print_r($flag_req, true));
        $label = [];
        foreach ($flag_req as $key => $valor) {

            $str_label = translate($GLOBALS['dictionary']['Lead']['fields'][$valor]['vname'], "Leads");
            $str_label = trim($str_label, ":");
            $campos = $campos . '<b>' . $str_label . '</b><br>';

            array_push($label, $str_label);
        }

        $GLOBALS['log']->fatal("Si Labels " . print_r($label, true));

        if ($beanLEad->phone_mobile == '' && $beanLEad->phone_home == '' &&
            $beanLEad->phone_work == '' && $beanLEad->subtipo_registro_c == '2')
        {
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
                        $cuenta = $this->createAccount($lead, null, true);
                        if (!empty($cuenta->id)) {
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

    public function create_phone($idCuenta, $phone, $tipoTel)
    {
        $bean_relacionTel = BeanFactory::newBean('Tel_Telefonos');
        $bean_relacionTel->accounts_tel_telefonos_1accounts_ida = $idCuenta;
        $bean_relacionTel->name = $phone;
        $bean_relacionTel->telefono = $phone;
        $bean_relacionTel->tipotelefono = $tipoTel;

        $bean_relacionTel->tipotelefono = $tipoTel;
        $bean_relacionTel->tipotelefono = $tipoTel;
        $bean_relacionTel->estatus = "Activo";
        $bean_relacionTel->pais = 2;
        $bean_relacionTel->save();

    }


    public function re_asign_meetings($bean_LEad, $idCuenTa)
    {
        if ($bean_LEad->load_relationship('meetings')) {
            $relatedBeans = $bean_LEad->meetings->getBeans();

            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $meeting) {
                    if ($meeting->status != "Not Held") {
                        $meeting->parent_type = "Accounts";
                        $meeting->parent_id = $idCuenTa;
                        $meeting->save();

                    }
                }
            }
        }
    }

}
