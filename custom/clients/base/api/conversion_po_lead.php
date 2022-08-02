<?php

/**
 * User: Adrian Arauz
 * Date: 28/04/2022
 * Time: 01:03 PM
 */
class conversion_po_lead extends SugarApi
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
                'path' => array('existsPOLeads'),
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
        $id_Prospect = $args['id'];
        $msjExiste = "El registro Público Objetivo que intentas convertir ya está registrada como Lead";
        $hayReunionPlaneada = false;
        $responseLEads = array();
        $finish = array();
        global $sugar_config;
        global $app_list_strings;
        global $current_user;
        $url = $sugar_config['site_url'];
        /**
         * Validamos que el PO no exista en Leads
         */
        $beanPO = BeanFactory::retrieveBean('Prospects', $id_Prospect, array('disable_row_level_security' => true));
        // $GLOBALS['log']->fatal("nombre del LEads " . $bean->first_name);
        $result = $this->existLeadAccount($beanPO);
        $count = count($result);
        if ($beanPO->estatus_po_c != "4" && $beanPO->estatus_po_c != "3") { //Estatus ES DIFERENTE DE 4-CONVERTIDO Y DE 3-CANCELADO
            if ($count == 0) {

                $responsMeeting = $this->getMeetingsUser($beanPO);
                $requeridos = $this->validaRequeridos($beanPO);

                if ($responsMeeting['status'] != "stop" && $requeridos == "") {

                    /** Creamos el registro LEAD */
                    $bean_Lead = $this->createLead($beanPO, $responsMeeting, false);
                    $GLOBALS['log']->fatal("Genera conversion y registro en Leads");
                    $GLOBALS['log']->fatal($bean_Lead->id);

                        if ($bean_Lead->id) {
                            //$resultadoRelaciones = $this->getContactAssoc($beanPO, $bean_Lead);
                            //Actualiza registro PO
                            //$GLOBALS['log']->fatal("el ID no esta vacio, actualiza valores PO");
                            $beanPO->estatus_po_c = 3;
                            $beanPO->lead_id = $bean_Lead->id;
                            //$beanPO->save();
                            //$GLOBALS['log']->fatal("Actualiza valores en el registro PO (Estatus)");
                            // Re-asignamos reuniones, llamadas, tareas y notas de PO a Leads
                            $this->re_asign_meetings($beanPO, $bean_Lead->id);
                            //$GLOBALS['log']->fatal("Obtiene reuniones para re asignarlas PO");

                            $msj_succes = <<<SITE
                            Conversión Completa <br>
    <b></b><a href="$url/#Leads/$bean_Lead->id">$bean_Lead->name</a></b>
    SITE;

                            $finish = array("idCuenta" => $bean_Lead->id, "mensaje" => $msj_succes);
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
                $beanLeadExist = BeanFactory::retrieveBean('Leads', $bean_Lead->id, array('disable_row_level_security' => true));
                $msj_succes_duplic = <<<SITE
                        Este registro ya existe como Lead. No puede ser convertido. <br>
<b></b><a href="$url/#Leads/$beanLeadExist->id">$beanLeadExist->name</a></b>
SITE;
                $finish = array("idCuenta" => $beanLeadExist->id, "mensaje" => $msj_succes_duplic);
            }
        } else {
            $finish = array("idCuenta" => "", "mensaje" => "El registro ya ha sido convertido.");
        }
        return $finish;
    }

    public function createLead($beanPO, $idMeetings, $rel)
    {   //Crea bean y setea campos
        $bean_lead = BeanFactory::newBean('Leads');

        $bean_lead->regimen_fiscal_c = $beanPO->regimen_fiscal_c;
        $bean_lead->nombre_empresa_c = $beanPO->nombre_empresa_c;
        $bean_lead->nombre_c = $beanPO->nombre_c;
        $bean_lead->apellido_paterno_c = $beanPO->apellido_paterno_c;
        $bean_lead->apellido_materno_c = $beanPO->apellido_materno_c;
        $bean_lead->puesto_c = $beanPO->puesto_c;
        $bean_lead->origen_c = $beanPO->origen_c;
        $bean_lead->detalle_origen_c = $beanPO->detalle_origen_c;
        $bean_lead->origen_busqueda_c = $beanPO->origen_busqueda_c;
        $bean_lead->camara_c = $beanPO->camara_c;
        $bean_lead->origen_ag_tel_c = $beanPO->origen_ag_tel_c;
        $bean_lead->ventas_anuales_c= $beanPO->ventas_anuales_c;
        $bean_lead->potencial_lead_c = $beanPO->potencial_lead_c;
        $bean_lead->rfc_c = $beanPO->rfc_c;
        $bean_lead->zona_geografica_c = $beanPO->zona_geografica_c;
        $bean_lead->nombre_de_cargar_c = $beanPO->nombre_de_carga_c;
        $bean_lead->alianza_c = $beanPO->alianza_c;
        $bean_lead->status_management_c = $beanPO->status_management_c;
        $bean_lead->fecha_asignacion_c = $beanPO->fecha_asignacion_c;
        $bean_lead->contacto_asociado_c = $beanPO->contacto_asociado_c;
        $bean_lead->leads_leads_1_name = $beanPO->leads_leads_1_name;
        $bean_lead->genero_c = $beanPO->genero_c;
        $bean_lead->medio_digital_c=$beanPO->medio_digital_c;

        $bean_lead->email = $beanPO->email;
        $bean_lead->clean_name = $beanPO->clean_name_c;

        $bean_lead->convertido_c = 0;
        $bean_lead->onboarding_chk_c=0;
        //Nace lead como NUEVO =13
        $bean_lead->subtipo_registro_c='13';
        $bean_lead->assigned_user_id=$beanPO->assigned_user_id;

        //Clasificación Sectorial
        if (!empty($beanPO->actividad_economica_c)) {
            $bean_lead->actividad_economica_c = $beanPO->actividad_economica_c;
            $bean_lead->subsector_c = $beanPO->subsector_c;
            $bean_lead->sector_economico_c = $beanPO->sector_economico_c;
            $bean_lead->macrosector_c = $beanPO->macrosector_c;
            $bean_lead->inegi_clase_c = $beanPO->inegi_clase_c;
            $bean_lead->inegi_subrama_c= $beanPO->inegi_subrama_c;
            $bean_lead->inegi_rama_c = $beanPO->inegi_rama_c;
            $bean_lead->inegi_subsector_c = $beanPO->inegi_subsector_c;
            $bean_lead->inegi_sector_c = $beanPO->inegi_sector_c;
            $bean_lead->inegi_macro_c = $beanPO->inegi_macro_c;
        }

        // Mapeo en Teléfonos
        $bean_lead->phone_mobile=$beanPO->phone_mobile;
        $bean_lead->phone_home=$beanPO->phone_home;
        $bean_lead->phone_work=$beanPO->phone_work;

        $bean_lead->m_estatus_telefono_c=$beanPO->m_estatus_telefono_c;
        $bean_lead->c_estatus_telefono_c=$beanPO->c_estatus_telefono_c;
        $bean_lead->o_estatus_telefono_c=$beanPO->o_estatus_telefono_c;

        $bean_lead->c_registro_reus_c=$beanPO->c_registro_reus_c;
        $bean_lead->m_registro_reus_c=$beanPO->m_registro_reus_c;
        $bean_lead->o_registro_reus_c=$beanPO->o_registro_reus_c;
        $bean_lead->pendiente_reus_c=$beanPO->pendiente_reus_c;

        $bean_lead->save();
        return $bean_lead;
    }

    public function existLeadAccount($beanPO)
    {
        $leads_bean = BeanFactory::getBean('Leads');
        $leads_bean->disable_row_level_security = true;

        $sql = new SugarQuery();
        $sql->select(array('id', 'clean_name_c'));
        $sql->from($leads_bean);
        $sql->where()->equals('clean_name_c', $beanPO->clean_name_c);
        $sql->where()->notEquals('id', $beanPO->id);

        $result = $sql->execute();
        return $result;
    }

    public function getMeetingsUser($beanPO)
    {
        $procede = array("status" => "stop", "data" => array());
        //Recupera reuniones
        $beanPO->load_relationship('meetings');
        if ($beanPO->load_relationship('meetings')) {
            $relatedBeans = $beanPO->meetings->getBeans();

            if (!empty($relatedBeans)) {

                $procede['vacio'] = false;
                $procede['status'] = "continue";

            } else {
                $procede['status'] = "stop";
                $procede['data'] = array();
                // $GLOBALS['log']->fatal("No tiene Reuniones no puede continuar aqui rompe  " . print_r($procede, true));

            }
        }
        //Recupera llamadas
        if ($beanPO->load_relationship('calls')) {
            $relatedBeans = $beanPO->calls->getBeans();

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

                    $procede['vacio'] = empty($procede['data']) ? true : false;

                    //}
                }
            }
        }


        return $procede;
    }

    public function validaRequeridos($beanPO)
    {
        $campos = "";
        $tipoPersona = $beanPO->regimen_fiscal_c;
        $campos_req = [];
        $response = false;
        $errors = [];

        /*******Campos requeridos en LEAD en PF y PM*****/

        if ($tipoPersona != '3') {
            array_push($campos_req, 'nombre_c', 'apellido_paterno_c');

        }else{
            array_push($campos_req, 'nombre_empresa_c');

        }

        /** Validamos que el valor no sea vacio, null o undefined */
        $flag_req = [];
        foreach ($campos_req as $req) {
            if (empty($beanPO->$req) && isset($beanPO->$req)) {
                array_push($flag_req, $req);
            }
        }
        $label = [];
        foreach ($flag_req as $key => $valor) {

            $str_label = translate($GLOBALS['dictionary']['Prospect']['fields'][$valor]['vname'], "Prospects");
            $str_label = trim($str_label, ":");
            $campos = $campos . '<b>' . $str_label . '</b><br>';

            array_push($label, $str_label);
        }

        //$GLOBALS['log']->fatal("Si Labels  en vista " . $campos);
        return $campos;
    }

    public function getContactAssoc($beanPO, $bean_Lead)
    {
        $resultado = array("data" => array());
        if ($beanPO->load_relationship('prospects_prospects_1')) {
            $relatedBeans = $beanPO->prospects_prospects_1->getBeans();
            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $PO) {
                    $result = $this->existLeadAccount($PO);
                    $count = count($result);
                    if ($count > 0) {
                        // $GLOBALS['log']->fatal("Si existe recupero el id  " . $result[0]['id'] . " y creamos la relacion");
                        array_push($resultado['data'], $result[0]['id']);
                    } else {
                        // $GLOBALS['log']->fatal("No existe el Contacto asociado en Cuentas hay que crearlo ");
                        $lead = $this->createLead($PO, null, true);
                        if (!empty($lead->id)) {
                            $this->re_asign_meetings($PO, $lead->id);
                            $this->create_relationship($bean_Lead, $lead->id);
                            array_push($resultado['data'], $lead->id);
                            $PO->lead_id = $lead->id;
                        }
                    }
                    $PO->estatus_po_c = "3";
                    $PO->save();
                }
            } else {
                // no existen Asociados no se hace nada
                $resultado['data'] = null;
            }
        }
        // $GLOBALS['log']->fatal("Resultado de Relaciones " . print_r($resultado, true));
        return $resultado;
    }

    public function create_relationship($id_parent, $idLead)
    {
        // rel_relaciones_accounts_1
        // $GLOBALS['log']->fatal("id Padre " . $id_parent->id . "  id hijo " . $idAccount);
        $bean_relacion = BeanFactory::retrieveBean('Leads', $idLead, array('disable_row_level_security' => true));
        $bean_relacion->leads_leads_1leads_ida=$id_parent->id;
        $bean_relacion->save();
    }


    public function re_asign_meetings($beanPO, $idLead)
    {
        //Reasigna Llamadas
        if ($beanPO->load_relationship('calls')) {
            $relatedBeans = $beanPO->calls->getBeans();
            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $call) {
                    global $db;
                    // $meetUpdate = "update calls set parent_type = 'Leads', parent_id = '{$idLead}' where id = '{$call->id}'";
                    // $updateResult = $db->query($meetUpdate);
                    $insertCallsLeads = "INSERT INTO calls_leads (id, call_id, lead_id, required, accept_status, date_modified, deleted)
                                          VALUES (uuid(), '{$call->id}', '{$idLead}', '1', 'none', UTC_TIMESTAMP(), '0');";
                    $insertResultCL = $db->query($insertCallsLeads);
                }
            }
        }
        //Reasigna Reuniones
        if ($beanPO->load_relationship('meetings')) {
            $relatedBeans = $beanPO->meetings->getBeans();
            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $meeting) {
                    global $db;
                    // $meetUpdate = "update meetings set parent_type = 'Leads', parent_id = '{$idLead}' where id = '{$meeting->id}'";
                    // $updateResult = $db->query($meetUpdate);
                    // $beanLead->load_relationship('lead_meetings');
                    // $beanLead->lead_meetings->add($meeting->id);
                    $insertMeetLeads = "INSERT INTO meetings_leads (id, meeting_id, lead_id, required, accept_status, date_modified, deleted)
                                          VALUES (uuid(), '{$meeting->id}', '{$idLead}', '1', 'none', UTC_TIMESTAMP(), '0');";
                    $insertResultML = $db->query($insertMeetLeads);
                }
            }
        }
        //Reasigna Tareas
        if ($beanPO->load_relationship('tasks')) {
            $relatedBeans = $beanPO->tasks->getBeans();
            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $task) {
                    global $db;
                    $meetUpdate = "update tasks set parent_type = 'Leads', parent_id = '{$idLead}' where id = '{$task->id}'";
                    $updateResult = $db->query($meetUpdate);
                  //  $beanLead->load_relationship('lead_tasks');
                    // $beanLead->lead_tasks->add($task->id);
                    // $beanTask = BeanFactory::retrieveBean('Tasks', $task->id, array('disable_row_level_security' => true));
                    // $beanNewTask = BeanFactory::newBean('Tasks');
                    // $beanNewTask = $beanTask;
                    // $beanNewTask->id = '';
                    // $beanNewTask->parent_type = 'Leads';
                    // $beanNewTask->parent_id = $idLead;
                    // $beanNewTask->update_date_modified = false;
                    // $beanNewTask->save();
                }
            }
        }
        //Reasigna Notas
        if ($beanPO->load_relationship('notes')) {
            $relatedBeans = $beanPO->notes->getBeans();
            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $note) {
                    global $db;
                    $meetUpdate = "update notes set parent_type = 'Leads', parent_id = '{$idLead}' where id = '{$note->id}'";
                    $updateResult = $db->query($meetUpdate);
                    // $beanPO->load_relationship('lead_notes');
                    // $beanPO->lead_notes->add($note->id);
                    // $beanNote = BeanFactory::retrieveBean('Notes', $note->id, array('disable_row_level_security' => true));
                    // $beanNewNote = BeanFactory::newBean('Notes');
                    // $beanNewNote = $beanNote;
                    // $beanNewNote->id = '';
                    // $beanNewNote->parent_type = 'Leads';
                    // $beanNewNote->parent_id = $idLead;
                    // $beanNewNote->update_date_modified = false;
                    // $beanNewNote->save();
                }
            }
        }


        //Reasigna Direcciones
        $GLOBALS['log']->fatal("Obtiene Direcciones y las guarda en el LEAD.");
        global $db;
        $queryDir = "SELECT direccion.id FROM dire_direccion as direccion
        INNER JOIN prospects_dire_direccion_1_c as intermedia ON intermedia.prospects_dire_direccion_1dire_direccion_idb = direccion.id AND intermedia.deleted = 0
        WHERE intermedia.prospects_dire_direccion_1prospects_ida = '{$beanPO->id}'";

        $queryResultD = $db->query($queryDir);
        while ($rowD = $db->fetchByAssoc($queryResultD)) {

            $beanDirecciones = BeanFactory::retrieveBean('dire_Direccion', $rowD['id'], array('disable_row_level_security' => true));
            $beanDirecciones->leads_dire_direccion_1leads_ida  = $idLead;
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
