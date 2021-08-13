<?php
/*/**
 * Created by JG.
 * User: tactos
 * Date: 26/02/20
 * Time: 12:25 PM
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class altaLeadServices extends SugarApi
{
    public $obj_leads;

    public function registerApiRest()
    {
        return array(
            'POST_LeadAltaPortal' => array(
                'reqType' => 'POST',
                'noLoginRequired' => false,
                'path' => array('LeadAltaServicios'),
                'pathVars' => array(''),
                'method' => 'leadAltaServicio',
                'shortHelp' => 'Alta de Lead a través de diferentes servicios',
            ),
        );
    }

    public function leadAltaServicio($api, $args)
    {
        $response_Services = ["lead" => array(), "asociados" => array()];
// Valida que regimen fiscal no este vacio
        $os = array("1", "2", "3");

# OB003 Ajuste, tipo regimen fiscal valido
        if (!empty($args['lead']['regimen_fiscal_c']) && (in_array($args['lead']['regimen_fiscal_c'], $os, true))) {

            /** Agregamos atributos a cada lead y asociado */

            $obj_leads = $this->agrega_atributos($args);

			// Obtiene Compañía
			$compania_c = $args['lead']['compania_c'];

            // Obtiene id_landing
			$id_landing_c = $args['lead']['id_landing_c'];

            if ($args['lead']['regimen_fiscal_c'] != '3') {
                $obj_leads['lead'] = $this->sec_validacion($obj_leads['lead']);
                $response_Services['lead'] = $this->insert_Leads_Asociados($obj_leads['lead'], "");
// Actualizamos el campo asignado a de cada registro nuevo
                $this->get_asignado($response_Services, "1", $compania_c , $id_landing_c);

            } else {
                /** PErsona Moral */

                //  if (count($args['asociados']) > 0) {

                $obj_leads['lead'] = $this->sec_validacion($obj_leads['lead']);

                /** Inicia Proceso validación Lead hijo  solo si el regimen fiscal es Moral*/

                /*for ($i = 0; $i < count($obj_leads['asociados']); $i++) {
                    $obj_leads['asociados'][$i] = $this->sec_validacion($obj_leads['asociados'][$i]);
                }*/

                /** Validamos que ambos leads esten con estatus 200  */ # pendiente de validación OB001


                /*if ($obj_leads['asociados'][0]['requeridos'] == 'success' && $obj_leads['asociados'][0]['formato_texto'] == 'success'
                    && $obj_leads['asociados'][0]['formato_telefenos'] == 'success' && $obj_leads['asociados'][0]['formato_correo'] == 'success'
                ) {*/
                /** Proceso de Guardado */

                $response_Services['lead'] = $this->insert_Leads_Asociados($obj_leads['lead'], "");

                /*if (!empty($response_Services['lead']['id']) && $response_Services['lead']['modulo'] == 'Leads') {

                    for ($i = 0; $i < count($obj_leads['asociados']); $i++) {
                        $response_Services['asociados'][$i] = $this->insert_Leads_Asociados($obj_leads['asociados'][$i], $response_Services['lead']['id']);
                    }
                }*/
                // Actualizamos el campo asignado a de cada registro nuevo
                $this->get_asignado($response_Services, "3", $compania_c , $id_landing_c);
                /*  } else {

                      $GLOBALS['log']->fatal(print_r($obj_leads, true));

                      if ($obj_leads['lead']['requeridos'])
                          $response_Services ["lead"] = $this->estatus(422, 'Información incompleta', '', "", "Error en Asociado");

                      $response_Services ["asociados"][0] = $this->estatus(422, 'Información incompleta', '', "", $obj_leads['asociados'][0]['requeridos_error']);


                      if ($obj_leads['asociados'][0]['requeridos'] != 'success' || $obj_leads['asociados'][0]['formato_texto'] != 'success'
                          || $obj_leads['asociados'][0]['formato_telefenos'] != 'success' || $obj_leads['asociados'][0]['formato_correo'] != 'success'
                      ) {
                          $arrayErrores = array();
                          $obj_leads['asociados'][0]['requeridos'] == 'fail' ? array_push($arrayErrores, $obj_leads['asociados'][0]['requeridos_error']) : "";
                          $obj_leads['asociados'][0]['formato_texto'] == 'fail' ? array_push($arrayErrores, $obj_leads['asociados'][0]['formato_texto_error']) : "";
                          $obj_leads['asociados'][0]['formato_telefenos'] == 'fail' ? array_push($arrayErrores, 'Telefono') : "";
                          $obj_leads['asociados'][0]['formato_correo'] == 'fail' ? array_push($arrayErrores, 'Correo') : "";

                          $response_Services ["asociados"][0] = $this->estatus(424, 'Error de información', '', "", $arrayErrores);
                      }
                  }*/

                /*} else {
                    $response_Services ["lead"] = $this->estatus(422, 'Debe contenener al menos un contacto asociado', '', "", "");
                }*/

            }
        } else {
            $response_Services ["lead"] = $this->estatus(422, 'Información incompleta', '', "", "");
        }

        //$GLOBALS['log']->fatal(print_r($response_Services, true));

        return $response_Services;
    }

    public function sec_validacion($obj_leads)
    {
        $lead_paso1 = $this->validaReq($obj_leads);
        count($lead_paso1) == 0 ? $obj_leads['requeridos'] = "success" : $obj_leads['requeridos'] = "fail";
        count($lead_paso1) > 0 ? $obj_leads['requeridos_error'] = $lead_paso1 : array();

        //  if (count($lead_paso1) == 0) {
        $lead_paso2 = $this->validaTextCampos($obj_leads);
        count($lead_paso2) == 0 ? $obj_leads['formato_texto'] = "success" : $obj_leads['formato_texto'] = "fail";
        count($lead_paso2) > 0 ? $obj_leads['formato_texto_error'] = $lead_paso2 : array();


        //if (count($lead_paso2) == 0) {
        $lead_paso3 = $this->validaCorreo($obj_leads);
        count($lead_paso3) == 0 ? $obj_leads['formato_correo'] = "success" : $obj_leads['formato_correo'] = "fail";
        //}

        $lead_paso4 = $this->validaTelefonos($obj_leads);
        count($lead_paso4) == 0 ? $obj_leads['formato_telefenos'] = "success" : $obj_leads['formato_telefenos'] = "fail";

        $clean_name = $this->crea_clean_name($obj_leads);


        $lead_paso5 = $this->existsIn_Leads($obj_leads, $clean_name);
        !empty($lead_paso5) ? $obj_leads['duplicados_en_leads'] = $lead_paso5 : $obj_leads['duplicados_en_leads'] = "";
        //empty($lead_paso5['assigned_user_id']) ? $obj_leads['assigned_user_id'] = $lead_paso5['assigned_user_id'] : $obj_leads['assigned_user_id'] = $this->get_asignado();

        $lead_paso6 = $this->existsIn_Accounts($obj_leads, $clean_name);
        !empty($lead_paso6) ? $obj_leads['duplicados_en_cuentas'] = $lead_paso6 : $obj_leads['duplicados_en_cuentas'] = "";

        $this->enviacorreo($lead_paso5, $lead_paso6);
        return $obj_leads;
    }

    public function get_asignado($data_result, $regimenFiscal, $compania_c , $id_landing_c)
    {
        global $db;
        $users = [];
        /* Obetenemos el id del usuario de grupo de 9.- MKT*/
        $QueryId = "SELECT id from users
        WHERE first_name LIKE '%9.-%' AND last_name LIKE 'MKT'";
        $queryResultId = $db->query($QueryId);
        $row = $db->fetchByAssoc($queryResultId);
        $idMKT = $row['id'];

        /* Obtiene  el dia y la hora actual*/
        $queryFEcha = "SELECT date_format(NOW(),'%W %H %i') AS Fecha,UTC_TIMESTAMP()";
        $queryResult = $db->query($queryFEcha);
        $row = $db->fetchByAssoc($queryResult);
        $date_Hoy = $row['Fecha'];
        $array_date = explode(" ", $date_Hoy);
        $dia_semana = $array_date[0];
        $horaDia = $array_date[1] . ":" . $array_date[2];
        $dateInput = date('H:i', strtotime($horaDia));

        //$GLOBALS['log']->fatal("compania_c " . $compania_c);
        /* Obtiene el ultimo  usuario asignado y registrado en el config*/
        $query = "SELECT value from config  ";
        if($compania_c == '1'){ $query = $query . "WHERE name='last_assigned_user_unifin'"; }
        if($compania_c == '2'){ $query = $query . "WHERE name='last_assigned_user_uniclick'"; }
        //$GLOBALS['log']->fatal("query " . $query);

        $result = $db->query($query);
        $row = $db->fetchByAssoc($result);
        $last_indice = $row['value'];

        //VALIDACION DE REVISTA MEDICA
        if ($id_landing_c != 'LP Revista Médica' && $id_landing_c != 'LP REVISTA MÉDICA') {

            //$GLOBALS['log']->fatal("id_landing_c "  , $id_landing_c);
            if( strpos(strtoupper($id_landing_c), 'INSURANCE') !== false){
                $subpuesto_c = 5;
            }else{
                if($compania_c == 1) $subpuesto_c = 3;
                if($compania_c == 2) $subpuesto_c = 4;
            }

            $query_asesores = "SELECT
            user.id,
            user.date_entered,
            count(lead.assigned_user_id) AS total_asignados,
            uc.access_hours_c
            FROM users user
            INNER JOIN users_cstm uc
                ON uc.id_c = user.id
            LEFT JOIN leads lead
                ON lead.assigned_user_id = user.id
            where puestousuario_c='27' AND user.status = 'Active' AND subpuesto_c='$subpuesto_c'
            GROUP BY lead.assigned_user_id , user.id ORDER BY total_asignados,date_entered ASC";

            //$GLOBALS['log']->fatal("query_asesores "  , $query_asesores);
            $result_usr = $db->query($query_asesores);
            //$usuarios=;
            //$GLOBALS['log']->fatal("result_usr "  , $result_usr);
            while ($row = $db->fetchByAssoc($result_usr)) {
                $hours = json_decode($row['access_hours_c'], true);
                $hoursIn = !empty($hours) ? $hours[$dia_semana]['entrada'] : "";
                $hoursComida = !empty($hours) ? $hours[$dia_semana]['comida'] : "";
                $hoursRegreso = !empty($hours) ? $hours[$dia_semana]['regreso'] : "";
                $hoursOut = !empty($hours) ? $hours[$dia_semana]['salida'] : "";
                //$GLOBALS['log']->fatal("hoursIn" , $hoursIn);
                if ($hoursIn != "" && $hoursOut != "") {
                    if (($hoursIn != "Bloqueado" && $hoursOut != "Bloqueado") && ($hoursIn != "Libre" && $hoursOut != "Libre")) {
                        $enable = $this->accessHours($hoursIn, $hoursComida, $hoursRegreso, $hoursOut, $dateInput);
                        if ($enable) {
                            $users[] = $row['id'];
                        }
                    } elseif ($hoursIn == "Libre" && $hoursOut == "Libre") {
                        $users[] = $row['id'];
                    }
                } /*else {
                    $users[] = $row['id'];
                }*/
            }
            //$GLOBALS['log']->fatal("Usuarios MKT en servicio alta Leads  " . print_r($users, true));
            if (count($users) > 0) {
                $new_indice = $last_indice >= count($users) - 1 ? 0 : $last_indice + 1;
                $new_assigned_user = $users[$new_indice];

            } else {
                /* No existen usuarios disponibles y se asigna a  9.- MKT " */
                $new_assigned_user = $idMKT;
            }

        } else {

            //USUARIOS QUE TIENEN EL EQUIPO PRINCIPAL UNICS 7 SE LEAS ASIGNA LEADS - REVISTA MEDICA
            $query_revista = "SELECT
            user.id,
            user.date_entered,
            count(lead.assigned_user_id) AS total_asignados,
            uc.access_hours_c
            FROM users user
            INNER JOIN users_cstm uc
                ON uc.id_c = user.id
            LEFT JOIN leads lead
                ON lead.assigned_user_id = user.id
            WHERE user.status = 'Active' AND equipo_c = 7
            GROUP BY lead.assigned_user_id , user.id ORDER BY total_asignados,date_entered ASC
            LIMIT 1";

            $result_rm = $db->query($query_revista);
            $conteo = $result_rm->num_rows;

            if ($conteo > 0) {
                while ($row = $db->fetchByAssoc($result_rm)) {

                    $new_assigned_user = $row['id'];
                }
            }
        }


        if ($regimenFiscal != "3") {

            if ($data_result['lead']['status'] == 200) {

                $id_lead = $data_result['lead']['id'];

                $update_assigne_user = "UPDATE leads l INNER JOIN users u on u.id='".$new_assigned_user."' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='$new_assigned_user'  WHERE l.id ='$id_lead' ";
                $db->query($update_assigne_user);
                $GLOBALS['log']->fatal("Usuarios MKT en servicio alta Indice  " . $new_indice);

                if ( $new_indice > -1 ) {
                    $update_assigne_user = "UPDATE config SET value = $new_indice  WHERE category = 'AltaLeadsServices' " ;
                    if($compania_c == '1'){ $update_assigne_user = $update_assigne_user . "AND name = 'last_assigned_user_unifin'"; }
                    if($compania_c == '2'){ $update_assigne_user = $update_assigne_user . "AND name = 'last_assigned_user_uniclick'"; }
                    $db->query($update_assigne_user);
                }
            }
        } else {

            if ($data_result['lead']['status'] == 200 && $data_result['asociados'][0]['status'] == 200) {
               // $new_indice = $last_indice >= count($users) - 1 ? 0 : $last_indice + 1;
               // $new_assigned_user = $users[$new_indice];
                $id_lead = $data_result['lead']['id'];
                $id_lead_asociado = $data_result['asociados'][0]['id'];

                // Actualiza lead padre
                $update_assigne_user = "UPDATE leads l INNER JOIN users u on u.id='".$new_assigned_user."' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='$new_assigned_user'  WHERE l.id ='$id_lead'";
                $db->query($update_assigne_user);
                //Actualiza lead Hijo
                $update_assigne_user_asociado = "UPDATE leads l INNER JOIN users u on u.id='".$new_assigned_user."' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='$new_assigned_user'  WHERE l.id ='$id_lead_asociado' ";
                $db->query($update_assigne_user_asociado);

                if ( $new_indice > -1 ) {
                    $update_assigne_user = "UPDATE config SET value = $new_indice  WHERE category = 'AltaLeadsServices' ";
                    if($compania_c == '1'){ $update_assigne_user = $update_assigne_user . "AND name = 'last_assigned_user_unifin'"; }
                    if($compania_c == '2'){ $update_assigne_user = $update_assigne_user . "AND name = 'last_assigned_user_uniclick'"; }
                    $db->query($update_assigne_user);
                }

            } elseif ($data_result['lead']['status'] == 200) {

               // $new_indice = $last_indice >= count($users) - 1 ? 0 : $last_indice + 1;
                //$new_assigned_user = $users[$new_indice];
                $id_lead = $data_result['lead']['id'];

                $update_assigne_user = "UPDATE leads l INNER JOIN users u on u.id='".$new_assigned_user."' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='$new_assigned_user'  WHERE l.id ='$id_lead' ";
                $db->query($update_assigne_user);

                if ( $new_indice > -1 ) {
                    $update_assigne_user = "UPDATE config SET value = $new_indice  WHERE category = 'AltaLeadsServices' ";
                    if($compania_c == '1'){ $update_assigne_user = $update_assigne_user . "AND name = 'last_assigned_user_unifin'"; }
                    if($compania_c == '2'){ $update_assigne_user = $update_assigne_user . "AND name = 'last_assigned_user_uniclick'"; }
                    $db->query($update_assigne_user);
                }
            } elseif (($data_result['lead']['status'] == 503 && $data_result['lead']['modulo'] == 'Leads') && $data_result['asociados'][0]['status'] == 200) {

                $id_lead = $data_result['lead']['id'];
                $id_lead_asociado = $data_result['asociados'][0]['id'];

                $select_Existente = "Select assigned_user_id from leads where id='$id_lead'";
                $result_existente = $db->query($select_Existente);
                $row = $db->fetchByAssoc($result_existente);
                $existente_asignado = $row['assigned_user_id'];

                $update_assigne_user = "UPDATE leads l INNER JOIN users u on u.id='".$new_assigned_user."' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='$existente_asignado'  WHERE l.id ='$id_lead_asociado' ";
                $db->query($update_assigne_user);

            }

        }

    }

    public function insert_Leads_Asociados($lead_asociado, $parent_id)
    {

        $error_sec = "";

        if (empty($lead_asociado['duplicados_en_cuentas'])) {
            if (empty($lead_asociado['duplicados_en_leads'])) {

                if ($lead_asociado['requeridos'] != 'fail') {

                    if ($lead_asociado['formato_texto'] != 'fail' && $lead_asociado['formato_telefenos'] != 'fail' && $lead_asociado['formato_correo'] != 'fail') {

                        # inserta
                        $id_lead = $this->crea_Lead($lead_asociado);

                        if (!empty($parent_id)) {
                            # crea la relacion lead asociado

                            $this->crea_relacion($parent_id, $id_lead);
                        }
                        $response = $this->estatus(200, 'Alta de Leads exitoso', $id_lead, "Leads", "");

                    } else {
                        $arrayErrores = array();
                        $lead_asociado['formato_texto'] == 'fail' ? $arrayErrores = $lead_asociado['formato_texto_error'] : "";
                        $lead_asociado['formato_telefenos'] == 'fail' ? array_push($arrayErrores, 'Telefono') : "";
                        $lead_asociado['formato_correo'] == 'fail' ? array_push($arrayErrores, 'Correo') : "";

                        $response = $this->estatus(424, 'Formato de información no válido', '', "", $arrayErrores);
                    }

                } else {

                    $response = $this->estatus(422, 'Información incompleta', '', "", $lead_asociado['requeridos_error']);
                }
            } else {

                if (!empty($parent_id)) {
                    # crea la relacion lead asociado

                    $this->crea_relacion($parent_id, $lead_asociado['duplicados_en_leads']);
                }
                $response = $this->estatus(503, 'Lead existente en Cuentas/Leads', $lead_asociado['duplicados_en_leads'], "Leads", "");
            }
        } else {
            $response = $this->estatus(503, 'Lead existente en Cuentas/Leads', $lead_asociado['duplicados_en_cuentas'], "Cuentas", "");
        }


        return $response;
    }

    public function crea_Lead($dataOrigen)
    {
        $bean_Lead = BeanFactory::newBean('Leads');

        $bean_Lead->resultado_de_carga_c = $dataOrigen['origen_medio'];
        $regimen = $dataOrigen['regimen_fiscal_c'];
        /*switch ($regimen) {
            case 1:
                $bean_Lead->regimen_fiscal_c = $regimen;
                break;

            case 2:
                $bean_Lead->regimen_fiscal_c = "2";
                break;
            default:
                $bean_Lead->regimen_fiscal_c = "3";
                break;
        }*/
        $bean_Lead->regimen_fiscal_c = $regimen;

        $bean_Lead->nombre_c = $dataOrigen['nombre_c'];
        $bean_Lead->nombre_empresa_c = $dataOrigen['nombre_empresa_c'];
        $bean_Lead->apellido_paterno_c = $dataOrigen['apellido_paterno_c'];
        $bean_Lead->apellido_materno_c = $dataOrigen['apellido_materno_c'];
        $bean_Lead->origen_c = $dataOrigen['origen_c']; # se deja siempre como 1

        $detalle_origen = $dataOrigen['detalle_origen_c']; # se deja siempre como 3 Digital
        /*switch ($detalle_origen) {
            case 1:
                $bean_Lead->detalle_origen_c = "Base de datos";
                break;
            case 2:
                $bean_Lead->detalle_origen_c = "Centro de Prospeccion";
                break;
            case 3:
                $bean_Lead->detalle_origen_c = "Digital";
                break;
            case 4:
                $bean_Lead->detalle_origen_c = "Campanas";
                break;
            case 5:
                $bean_Lead->detalle_origen_c = "Acciones Estrategicas";
                break;
            case 6:
                $bean_Lead->detalle_origen_c = "Afiliaciones";
                break;
            case 7:
                $bean_Lead->detalle_origen_c = "Llamdas Inbound";
                break;
            case 8:
                $bean_Lead->detalle_origen_c = "Parques Industriales";
                break;
            case 9:
                $bean_Lead->detalle_origen_c = "Offline";
                break;
            case 10:
                $bean_Lead->detalle_origen_c = "Cartera Promotores";
                break;
            case 11:
                $bean_Lead->detalle_origen_c = "Recomendacion";
                break;
            default:
                $bean_Lead->detalle_origen_c = $dataOrigen['detalle_origen_c'];
                break;
        }*/
        $bean_Lead->detalle_origen_c = $detalle_origen;

        $medio = $dataOrigen['medio_digital_c'];
        /*switch ($medio) {
            case 1:
                $bean_Lead->medio_digital_c = "Facebook";
                break;
            case 2:
                $bean_Lead->medio_digital_c = "Twitter";
                break;
            case 3:
                $bean_Lead->medio_digital_c = "Instagram";
                break;
            case 4:
                $bean_Lead->medio_digital_c = "Web";
                break;
            case 5:
                $bean_Lead->medio_digital_c = "LinkedIn";
                break;
            case 6:
                $bean_Lead->medio_digital_c = "Radio Online";
                break;
            case 7:
                $bean_Lead->medio_digital_c = "Prensa Online";
                break;
            case 8:
                $bean_Lead->medio_digital_c = "TV Online";
                break;
            case 9:
                $bean_Lead->medio_digital_c = "Revistas Online";
                break;
            case 10:
                $bean_Lead->medio_digital_c = "TV";
                break;
            case 11:
                $bean_Lead->medio_digital_c = "Radio";
                break;
            case 12:
                $bean_Lead->medio_digital_c = "Prensa";
                break;
            case 13:
                $bean_Lead->medio_digital_c = "Revistas";
                break;
            case 14:
                $bean_Lead->medio_digital_c = "Espectaculares";
                break;

            default:
                $bean_Lead->medio_digital_c = $dataOrigen['medio_digital_c'];
                break;
        }*/
        $bean_Lead->medio_digital_c = $medio;

        $punto_contacto = $dataOrigen['punto_contacto_c'];
        /*switch ($punto_contacto) {

            case 1:
                $bean_Lead->punto_contacto_c = "Portal";

                break;
            case 2:
                $bean_Lead->punto_contacto_c = "Telefono";

                break;
            case 3:
                $bean_Lead->punto_contacto_c = "Chat";

                break;
            case 4:
                $bean_Lead->punto_contacto_c = "Publicacion";

                break;
            default:
                $bean_Lead->punto_contacto_c = $dataOrigen['punto_contacto_c'];
                break;
        }*/
        $bean_Lead->punto_contacto_c = $punto_contacto;

        $bean_Lead->origen_ag_tel_c = $dataOrigen['origen_ag_tel_c'];
        $bean_Lead->promotor_c = $dataOrigen['promotor_c'];
        $bean_Lead->origen_busqueda_c = $dataOrigen['origen_busqueda_c'];
        $bean_Lead->puesto_c = $dataOrigen['puesto_c'];
        $bean_Lead->macrosector_c = $dataOrigen['macrosector_c'];
        $bean_Lead->ventas_anuales_c = $dataOrigen['ventas_anuales_c'];
        $bean_Lead->zona_geografica_c = $dataOrigen['zona_geografica_c'];
        $bean_Lead->email1 = $dataOrigen['email'];
        $bean_Lead->phone_mobile = $dataOrigen['phone_mobile'];
        $bean_Lead->phone_home = $dataOrigen['phone_home'];
        $bean_Lead->phone_work = $dataOrigen['phone_work'];
        $bean_Lead->detalle_plataforma_c = $dataOrigen['GLID'];
        $bean_Lead->assigned_user_id = $dataOrigen['assigned_user_id'];
        /** Seccion de Digital Inbound **/
        $bean_Lead->id_landing_c = $dataOrigen['id_landing_c'];
        $bean_Lead->lead_source_c = $dataOrigen['lead_source_c'];
        $bean_Lead->facebook_pixel_c = $dataOrigen['facebook_pixel_c'];
        $bean_Lead->ga_client_id_c = $dataOrigen['ga_client_id_c'];
        $bean_Lead->keyword_c = $dataOrigen['keyword_c'];
        $bean_Lead->campana_c = $dataOrigen['campana_c'];
        $bean_Lead->compania_c = $dataOrigen['compania_c'];
        $bean_Lead->productos_interes_c = $dataOrigen['productos_interes_c'];
        $bean_Lead->opportunity_amount = $dataOrigen['opportunity_amount'];
        $bean_Lead->plazo_c = $dataOrigen['plazo_c'];
        $bean_Lead->pago_mensual_estimado_c = $dataOrigen['pago_mensual_estimado_c'];
        $bean_Lead->medios_contacto_deseado_c = $dataOrigen['medios_contacto_deseado_c'];
        $bean_Lead->medio_preferido_contacto_c = $dataOrigen['medio_preferido_contacto_c'];
        $bean_Lead->dia_contacto_c = $dataOrigen['dia_contacto_c'];
        $bean_Lead->hora_contacto_c = $dataOrigen['hora_contacto_c'];
        /** Seccion de Contacto **/
        $bean_Lead->contacto_nombre_c = $dataOrigen['contacto_nombre_c'];
        $bean_Lead->contacto_apellidop_c = $dataOrigen['contacto_apellidop_c'];
        $bean_Lead->contacto_apellidom_c = $dataOrigen['contacto_apellidom_c'];
        $bean_Lead->contacto_telefono_c = $dataOrigen['contacto_telefono_c'];
        $bean_Lead->contacto_email_c = $dataOrigen['contacto_email_c'];

        # falta obtener el asignado a

        $bean_Lead->save();

        return $bean_Lead->id;
    }

    public function crea_relacion($id_parent, $id_children)
    {
        $oLead = BeanFactory::getBean('Leads', $id_parent, array('disable_row_level_security' => true));
        $oLead->load_relationship('leads_leads_1');
        $oLead->leads_leads_1->add($id_children);
    }

    public function agrega_atributos($obj_input)
    {
        # Agrega atributos Lead
        $obj_input['lead']['requeridos'] = null;
        $obj_input['lead']['formato_texto'] = null;
        $obj_input['lead']['formato_telefenos'] = null;
        $obj_input['lead']['formato_correo'] = null;
        $obj_input['lead']['duplicados_en_leads'] = null;
        $obj_input['lead']['duplicados_en_cuentas'] = null;
        $obj_input['lead']['insertar'] = null;
        $obj_input['lead']['descripcion'] = null;
        # Agrega atributos en Asociados
        for ($i = 0; $i < count($obj_input['asociados']); $i++) {
            $obj_input['asociados'][$i]['requeridos'] = null;
            $obj_input['asociados'][$i]['formato_texto'] = null;
            $obj_input['asociados'][$i]['formato_telefenos'] = null;
            $obj_input['asociados'][$i]['formato_correo'] = null;
            $obj_input['asociados'][$i]['duplicados_en_leads'] = null;
            $obj_input['asociados'][$i]['duplicados_en_cuentas'] = null;
            $obj_input['asociados'][$i]['insertar'] = null;
            $obj_input['asociados'][$i]['descripcion'] = null;
        }
        return $obj_input;
    }

    public function validaReq($data)
    {
        $req_lead = ["email", "regimen_fiscal_c"];
        if (empty($data['phone_mobile']) && empty($data['phone_home']) && empty($data['phone_work'])) {
            array_push($req_lead, "phone_mobile");
        }


        if ($data['regimen_fiscal_c'] != "3") {
            array_push($req_lead, "nombre_c", "apellido_paterno_c");
        } else {
            array_push($req_lead, "nombre_empresa_c");
        }

        /** Validamos que el valor no sea vacio, null o undefine */
        $flag_req = [];
        foreach ($req_lead as $req) {
            if (empty($data[$req]) && isset($data[$req])) {
                array_push($flag_req, $req);
            }
        }


        return $flag_req;
    }

    public function validaTextCampos($data)
    {

        $campos_lead = ["nombre_c", "apellido_paterno_c", "apellido_materno_c", "contacto_nombre_c", "contacto_apellidop_c", "contacto_apellidom_c"];
        $error_campo = [];
        $expresion = "/^[a-zA-ZÀ-ÿ\s]*$/";

        if ($data['lead'] != "3") {
            foreach ($campos_lead as $campo) {

                if (!empty($data[$campo])) {
                    if (preg_match($expresion, $data[$campo]) != 1) {
                        array_push($error_campo, $campo);

                    }
                }
            }
        }
        return $error_campo;
    }

    public function validaCorreo($data)
    {
        $error_campo = array();
        $expresionCorreo = "/^\S+@\S+\.\S+[$%&|<>#]?$/";

        if (!empty($data['email'])) {
            if (!preg_match($expresionCorreo, $data['email'])) {

                array_push($error_campo, 'email');
            }
        }
        if (!empty($data['contacto_email_c'])) {
            if (!preg_match($expresionCorreo, $data['contacto_email_c'])) {
                array_push($error_campo, 'contacto_email_c');
            }
        }
        return $error_campo;
    }

    public function validaTelefonos($data)
    {
        $telefonos_lead = ["phone_mobile", "phone_home", "phone_work", "contacto_telefono_c"];
        $expresionTelefono = "/^[0-9]{8,13}$/";
        $error_telefonos = [];

        foreach ($telefonos_lead as $telefono) {
            $repetido = 0;

            if (!empty($data[$telefono]) && isset($data[$telefono])) {

                if (!preg_match($expresionTelefono, $data[$telefono])) {
                    array_push($error_telefonos, $telefono);
                } else {
                    /** validamos que no sea repetido el mismo digito **/
                    for ($i = 0; $i < strlen($data[$telefono]); $i++) {
                        if ($data[$telefono][0] == $data[$telefono][$i]) {
                            $repetido = $repetido + 1;
                        }
                    }

                    if ($repetido == strlen($data[$telefono])) {
                        array_push($error_telefonos, $telefono);
                    }

                }
            }
        }
        return $error_telefonos;
    }

    public function crea_clean_name($data)
    {
        $nombre = "";
        $clean_name = "";
        if ($data['regimen_fiscal_c'] != "3") {
            $nombre = $data['nombre_c'] . " " . $data['apellido_paterno_c'] . " " . $data['apellido_materno_c'];
        } else {
            $nombre = $data['nombre_empresa_c'];
        }

        //Consumir servicio de cleanName, declarado en custom api
        require_once("custom/clients/base/api/cleanName.php");
        $apiCleanName= new cleanName();
        $body=array('name'=>$nombre);
        $response=$apiCleanName->getCleanName(null,$body);
        if ($response['status']=='200') {
            $clean_name = $response['cleanName'];
        }

        return $clean_name;
    }

    public function existsIn_Leads($data, $cleanName)
    {
        $existe = "";
        $array_telefonos = [];

        if (!empty($data['phone_mobile'])) {
            array_push($array_telefonos, $data['phone_mobile']);
        }
        if (!empty($data['phone_home'])) {
            array_push($array_telefonos, $data['phone_home']);
        }
        if (!empty($data['phone_work'])) {
            array_push($array_telefonos, $data['phone_work']);
        }

        $sqlLead = new SugarQuery();
        $sqlLead->select(array('id', 'phone_mobile', 'phone_home', 'phone_work', 'clean_name_c', 'assigned_user_id'));
        $sqlLead->from(BeanFactory::getBean('Leads'), array('team_security' => false));
        $sqlLead->where()->queryOr()->in('phone_mobile', $array_telefonos)
            ->in('phone_home', $array_telefonos)->in('phone_work', $array_telefonos);
        $sqlLead->where()->equals('clean_name_c', $cleanName);
        $resultLead = $sqlLead->execute();

        $existe = !empty($resultLead[0]['id']) ? $resultLead[0]['id'] : "";

        /*$existe['id_lead'] = !empty($resultLead[0]['id']) ? $resultLead[0]['id'] : "";
        $existe['id_asignado'] = !empty($resultLead[0]['assigned_user_id']) ? $resultLead[0]['assigned_user_id'] : "";*/

        return $existe;
    }

    public function existsIn_Accounts($data, $cleanName)
    {
        $existe = "";
        $array_telefonos = [];

        if (!empty($data['phone_mobile'])) {
            array_push($array_telefonos, $data['phone_mobile']);
        }
        if (!empty($data['phone_home'])) {
            array_push($array_telefonos, $data['phone_home']);
        }
        if (!empty($data['phone_work'])) {
            array_push($array_telefonos, $data['phone_work']);
        }

        $sqlLead = new SugarQuery();
        $sqlLead->select(array('A.id', 'C.telefono', 'A.clean_name'));
        $sqlLead->from(BeanFactory::getBean('Accounts'), array('team_security' => false, 'alias' => 'A'));
        $sqlLead->joinTable('accounts_tel_telefonos_1_c', array('alias' => 'B', 'joinType' => "INNER",))->on()->equalsField('B.accounts_tel_telefonos_1accounts_ida', 'A.id');
        $sqlLead->joinTable('tel_telefonos', array('alias' => 'C', 'joinType' => "INNER",))->on()->equalsField('C.id', 'B.accounts_tel_telefonos_1tel_telefonos_idb');
        $sqlLead->where()->in('C.telefono', $array_telefonos);
        $sqlLead->where()->equals('A.clean_name', $cleanName);

        $resultLead = $sqlLead->execute();
        $existe = !empty($resultLead[0]['id']) ? $resultLead[0]['id'] : "";

        return $existe;
    }

    public function estatus($codigo, $descripcion, $id, $modulo, $errores)
    {
        $array_status = array();
        $array_status['status'] = $codigo;
        $array_status['descripcion'] = $descripcion;
        $array_status['id'] = $id;
        $array_status['modulo'] = $modulo;
        $array_status['errores'] = $errores;


        return $array_status;
    }

    public function enviacorreo($idlead = null, $idaccount = null)
    {
        require_once 'include/SugarPHPMailer.php';
        $correo = '';
        $user1 = '';
        $cliente = '';

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Estimado(a) <b> user1 .</b>
						<br><br>Tu Cliente/Prospecto cliente1 ha dejado sus datos como Lead en una campaña digital.
						<br><br>Favor de contactarlo para dar el seguimiento adecuado.
						<br><br>Si tienes alguna duda contacta a:
						<br><br>Equipo CRM
						<br>Inteligencia de Negocios<br>T: (55) 5249.5800 Ext.5737 y 5677';

        if ($idaccount != null || $idaccount != '') {
            $beanaccount = BeanFactory::retrieveBean('Accounts', $idaccount);
            $cliente = $beanaccount->name;
            if ($beanaccount->load_relationship('accounts_uni_productos_1')) {
                $GLOBALS['log']->fatal('ENvío mail x producto');
                //Fetch related beans
                $relatedBeans = $beanaccount->accounts_uni_productos_1->getBeans();
                foreach ($relatedBeans as $rel) {
                    $usuario = BeanFactory::retrieveBean('Users', $rel->assigned_user_id);
                    $user_name = $usuario->user_name;
                    $correo = $usuario->email1;
                    $user1 = $usuario->nombre_completo_c;

                    if ($user_name != 'SinGestor' && !empty($correo)) {
                        $GLOBALS['log']->fatal('cliente' . $cliente . ' usuario' . $user1 . ' correo' . $correo);
                        $mailHTML = str_replace('user1', $user1, $mailHTML);
                        $mailHTML = str_replace('cliente1', $cliente, $mailHTML);

                        $mailer = MailerFactory::getSystemDefaultMailer();
                        $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
                        $mailer->setSubject('Seguimiento de Campaña Digital a Cliente/Prospecto ' . $cliente . '.');
                        $body = trim($mailHTML);
                        $mailer->setHtmlBody($body);
                        $mailer->clearRecipients();
                        $mailer->addRecipientsTo(new EmailIdentity($correo, $usuario->first_name . ' ' . $usuario->last_name));
                        $result = $mailer->send();
                    }
                }
            }
        } else if ($idlead != null && ($idaccount == null || $idaccount == '')) {

            $beanlead = BeanFactory::retrieveBean('Leads', $idlead, array('disable_row_level_security' => true));
            $cliente = $beanlead->name;
            $usuario = BeanFactory::retrieveBean('Users', $beanlead->assigned_user_id, array('disable_row_level_security' => true));

            $correo = $usuario->email1;
            $user1 = $usuario->nombre_completo_c;
            $mailHTML = str_replace('user1', $user1, $mailHTML);
            $mailHTML = str_replace('cliente1', $cliente, $mailHTML);
            if (!empty($correo)) {
                $mailer = MailerFactory::getSystemDefaultMailer();
                $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
                $mailer->setSubject('Seguimiento de Campaña Digital a Cliente/Prospecto ' . $cliente . '.');
                $body = trim($mailHTML);
                $mailer->setHtmlBody($body);
                $mailer->clearRecipients();
                $mailer->addRecipientsTo(new EmailIdentity($correo, $usuario->first_name . ' ' . $usuario->last_name));
                $result = $mailer->send();
            }
        }
    }

    public function accessHours($from, $eat, $return, $to, $login)
    {
        $dateFrom = date("H:i", strtotime($from));
		$dateEat = date("H:i", strtotime($eat));
		$dateRet = date("H:i", strtotime($return));
        $dateTo = date("H:i", strtotime($to));
        $dateLogin = date("H:i", strtotime($login));
		if($dateFrom <= $dateLogin && $dateLogin <= $dateTo) $enable = 1;
		if($dateEat <= $dateLogin && $dateLogin <= $dateRet) $enable = 0;
        return ($enable);
    }
}
