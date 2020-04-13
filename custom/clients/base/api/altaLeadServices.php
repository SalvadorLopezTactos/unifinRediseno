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


            if ($args['lead']['regimen_fiscal_c'] != '3') {
                $obj_leads['lead'] = $this->sec_validacion($obj_leads['lead']);
                $response_Services['lead'] = $this->insert_Leads_Asociados($obj_leads['lead'], "");

// Actualizamos el campo asignado a de cada registro nuevo
                $this->get_asignado($response_Services, "1");

            } else {

                if (count($args['asociados']) > 0) {

                    $obj_leads['lead'] = $this->sec_validacion($obj_leads['lead']);

                    /** Inicia Proceso validación Lead hijo  solo si el regimen fiscal es Moral*/

                    for ($i = 0; $i < count($obj_leads['asociados']); $i++) {
                        $obj_leads['asociados'][$i] = $this->sec_validacion($obj_leads['asociados'][$i]);
                    }

                    /** Validamos que ambos leads esten con estatus 200  */ # pendiente de validación OB001

                    //$GLOBALS['log']->fatal(print_r($obj_leads, true));

                    if ($obj_leads['asociados'][0]['requeridos'] == 'success' && $obj_leads['asociados'][0]['formato_texto'] == 'success'
                            && $obj_leads['asociados'][0]['formato_telefenos'] == 'success' && $obj_leads['asociados'][0]['formato_correo'] == 'success') {

                        /** Proceso de Guardado */

                        $response_Services['lead'] = $this->insert_Leads_Asociados($obj_leads['lead'], "");

                        if (!empty($response_Services['lead']['id']) && $response_Services['lead']['modulo'] == 'Leads') {

                            for ($i = 0; $i < count($obj_leads['asociados']); $i++) {
                                $response_Services['asociados'][$i] = $this->insert_Leads_Asociados($obj_leads['asociados'][$i], $response_Services['lead']['id']);
                            }
                        }
                        // Actualizamos el campo asignado a de cada registro nuevo

                        $this->get_asignado($response_Services, "3");
                    } else {
                        $response_Services ["lead"] = $this->estatus(422, 'Información incompleta', '', "");

                        $response_Services ["asociados"][0] = $this->estatus(422, 'Información incompleta', '', "");

                        if($obj_leads['asociados'][0]['formato_texto'] != 'success'
                            || $obj_leads['asociados'][0]['formato_telefenos'] != 'success' || $obj_leads['asociados'][0]['formato_correo'] != 'success')
                        {
                            $response_Services ["asociados"][0] = $this->estatus(424, 'Formato de información no válido', '', "");

                        }


                    }


                } else {
                    $response_Services ["lead"] = $this->estatus(422, 'Debe contenener al menos un contacto asociado', '', "");
                }

            }


        } else {
            $response_Services ["lead"] = $this->estatus(422, 'Información incompleta', '', "");

        }

        return $response_Services;
    }

    public function sec_validacion($obj_leads)
    {
        $lead_paso1 = $this->validaReq($obj_leads);
        count($lead_paso1) == 0 ? $obj_leads['requeridos'] = "success" : $obj_leads['requeridos'] = "fail";

        //  if (count($lead_paso1) == 0) {
        $lead_paso2 = $this->validaTextCampos($obj_leads);
        count($lead_paso2) == 0 ? $obj_leads['formato_texto'] = "success" : $obj_leads['formato_texto'] = "fail";


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

        return $obj_leads;
    }

    public function get_asignado($data_result, $regimenFiscal)
    {

        global $db;

        $query = "Select value from config  where name='last_assigned_user' ";
        $result = $db->query($query);
        $row = $db->fetchByAssoc($result);
        $last_indice = $row['value'];

        $query_asesores = "SELECT id,date_entered from users u INNER JOIN users_cstm uc ON uc.id_c=u.id
        where puestousuario_c='27' AND subpuesto_c='3' ORDER BY date_entered ASC ";
        $result_usr = $db->query($query_asesores);
        //$usuarios=;
        while ($row = $db->fetchByAssoc($result_usr)) {
            //Obtiene fecha de inicio de reunión
            $users[] = $row['id'];
        }


        if ($regimenFiscal != "3") {

            if ($data_result['lead']['status'] == 200) {
                $new_indice = $last_indice >= count($users) - 1 ? 0 : $last_indice + 1;

                $new_assigned_user = $users[$new_indice];
                $id_lead = $data_result['lead']['id'];

                $update_assigne_user = "UPDATE leads SET  assigned_user_id ='$new_assigned_user'  WHERE id ='$id_lead' ";
                $db->query($update_assigne_user);

                $update_assigne_user = "UPDATE config SET value = $new_indice  WHERE category = 'AltaLeadsServices' AND name = 'last_assigned_user'";
                $db->query($update_assigne_user);
            }
        } else {

            if ($data_result['lead']['status'] == 200 && $data_result['asociados'][0]['status'] == 200) {
                $new_indice = $last_indice >= count($users) - 1 ? 0 : $last_indice + 1;
                $new_assigned_user = $users[$new_indice];
                $id_lead = $data_result['lead']['id'];
                $id_lead_asociado = $data_result['asociados'][0]['id'];

                // Actualiza lead padre
                $update_assigne_user = "UPDATE leads SET  assigned_user_id ='$new_assigned_user'  WHERE id ='$id_lead' ";
                $db->query($update_assigne_user);
                //Actualiza lead Hijo
                $update_assigne_user_asociado = "UPDATE leads SET  assigned_user_id ='$new_assigned_user'  WHERE id ='$id_lead_asociado' ";
                $db->query($update_assigne_user_asociado);

                $update_assigne_user = "UPDATE config SET value = $new_indice  WHERE category = 'AltaLeadsServices' AND name = 'last_assigned_user'";
                $db->query($update_assigne_user);
            } elseif ($data_result['lead']['status'] == 200) {

                $new_indice = $last_indice >= count($users) - 1 ? 0 : $last_indice + 1;
                $new_assigned_user = $users[$new_indice];
                $id_lead = $data_result['lead']['id'];

                $update_assigne_user = "UPDATE leads SET  assigned_user_id ='$new_assigned_user'  WHERE id ='$id_lead' ";
                $db->query($update_assigne_user);

                $update_assigne_user = "UPDATE config SET value = $new_indice  WHERE category = 'AltaLeadsServices' AND name = 'last_assigned_user'";
                $db->query($update_assigne_user);
            } elseif (($data_result['lead']['status'] == 503 && $data_result['lead']['modulo'] == 'Leads') && $data_result['asociados'][0]['status'] == 200) {

                $id_lead = $data_result['lead']['id'];
                $id_lead_asociado = $data_result['asociados'][0]['id'];

                $select_Existente = "Select assigned_user_id from leads where id='$id_lead'";
                $result_existente = $db->query($select_Existente);
                $row = $db->fetchByAssoc($result_existente);
                $existente_asignado = $row['assigned_user_id'];

                $update_assigne_user = "UPDATE leads SET  assigned_user_id ='$existente_asignado'  WHERE id ='$id_lead_asociado' ";
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
                        $response = $this->estatus(200, 'Alta de Leads exitoso', $id_lead, "Leads");


                    } else {
                        $response = $this->estatus(424, 'Formato de información no válido', '', "");
                    }

                } else {
                    $response = $this->estatus(422, 'Información incompleta', '', "");
                }
            } else {

                if (!empty($parent_id)) {
                    # crea la relacion lead asociado

                    $this->crea_relacion($parent_id, $lead_asociado['duplicados_en_leads']);
                }
                $response = $this->estatus(503, 'Lead existente en Cuentas/Leads', $lead_asociado['duplicados_en_leads'], "Leads");
            }
        } else {
            $response = $this->estatus(503, 'Lead existente en Cuentas/Leads', $lead_asociado['duplicados_en_cuentas'], "Cuentas");
        }

        return $response;
    }

    public function crea_Lead($dataOrigen)
    {
        $bean_Lead = BeanFactory::newBean('Leads');

        $bean_Lead->resultado_de_carga_c = $dataOrigen['origen_medio'];
        $regimen = $dataOrigen['regimen_fiscal_c'];
        switch ($regimen) {
            case 1:
                $bean_Lead->regimen_fiscal_c = "Persona Fisica";
                break;

            case 2:
                $bean_Lead->regimen_fiscal_c = "Persona Fisica con Actividad Empresarial";
                break;
            default:
                $bean_Lead->regimen_fiscal_c = "Persona Moral";
                break;
        }

        $bean_Lead->nombre_c = $dataOrigen['nombre_c'];
        $bean_Lead->nombre_empresa_c = $dataOrigen['nombre_empresa_c'];
        $bean_Lead->apellido_paterno_c = $dataOrigen['apellido_paterno_c'];
        $bean_Lead->apellido_materno_c = $dataOrigen['apellido_materno_c'];
        $bean_Lead->origen_c = $dataOrigen['origen_c']; # se deja siempre como 1

        $detalle_origen = $dataOrigen['detalle_origen_c']; # se deja siempre como 3 Digital
        switch ($detalle_origen) {
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
        }

        $medio = $dataOrigen['medio_digital_c'];
        switch ($medio) {
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
        }

        $punto_contacto = $dataOrigen['punto_contacto_c'];
        switch ($punto_contacto) {

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
        }

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
        $bean_Lead->detalle_plataforma_c = $dataOrigen['detalle_plataforma'];
        $bean_Lead->assigned_user_id = $dataOrigen['assigned_user_id'];
        $bean_Lead->id_landing_c = $dataOrigen['id_landing_c'];
        $bean_Lead->lead_source_c = $dataOrigen['lead_source_c'];
        $bean_Lead->facebook_pixel_c = $dataOrigen['facebook_pixel_c'];
        $bean_Lead->ga_client_id_c = $dataOrigen['ga_client_id_c'];
        $bean_Lead->keyword_c = $dataOrigen['keyword_c'];
        $bean_Lead->campana_c = $dataOrigen['campana_c'];
        $bean_Lead->compania_c = $dataOrigen['compania_c'];

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

        $campos_lead = ["nombre_c", "apellido_paterno_c", "apellido_materno_c"];
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
        return $error_campo;
    }

    public function validaTelefonos($data)
    {
        $telefonos_lead = ["phone_mobile", "phone_home", "phone_work"];
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
        global $app_list_strings, $current_user; //Obtención de listas de valores
        $clean_name = "";
        //Se crean variables que limpien los excesos de espacios en los campos establecidos.
        $limpianame = preg_replace('/\s\s+/', ' ', $data['fullname']); // PENDIENTE
        $limpianombre = preg_replace('/\s\s+/', ' ', $data['nombre_c']);
        $limpiaapaterno = preg_replace('/\s\s+/', ' ', $data['apellido_paterno_c']);
        $limpiamaterno = preg_replace('/\s\s+/', ' ', $data['apellido_materno_c']);
        $limpiarazon = preg_replace('/\s\s+/', ' ', $data['nombre_empresa_c']); # prendiente

        $tipo = $app_list_strings['validacion_simbolos_list']; //obtencion lista simbolos
        $acronimos = $app_list_strings['validacion_duplicados_list'];

        if ($data['regimen_fiscal_c'] != "3") {
            $full_name = $data['nombre_c'] . " " . $data['apellido_paterno_c'] . " " . $data['apellido_materno_c'];
            $nombre = $full_name;
            $nombre = mb_strtoupper($nombre, "UTF-8");
            $separa = explode(" ", $nombre);
            $longitud = count($separa);
            for ($i = 0; $i < $longitud; $i++) {
                foreach ($tipo as $t => $key) {
                    $separa[$i] = str_replace($key, "", $separa[$i]);
                }
            }
            $une = implode($separa);
            $clean_name = $une;
        } else {
            $nombre = $data['nombre_empresa_c'];
            $nombre = mb_strtoupper($nombre, "UTF-8");
            $separa = explode(" ", $nombre);
            $separa_limpio = $separa;
            $longitud = count($separa);
            $eliminados = 0;
            //Itera el arreglo separado
            for ($i = 0; $i < $longitud; $i++) {
                foreach ($tipo as $t => $key) {
                    $separa[$i] = str_replace($key, "", $separa[$i]);
                    $separa_limpio[$i] = str_replace($key, "", $separa_limpio[$i]);
                }
                foreach ($acronimos as $a => $key) {
                    if ($separa[$i] == $a) {
                        $separa[$i] = "";
                        $eliminados++;
                    }
                }
            }
            //Condicion para eliminar los acronimos
            if (($longitud - $eliminados) <= 1) {
                $separa = $separa_limpio;
            }
            //Convierte el array a string nuevamente
            $une = implode($separa);
            $clean_name = $une;
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

    public function estatus($codigo, $descripcion, $id, $modulo)
    {
        $array_status = array();
        $array_status['status'] = $codigo;
        $array_status['descripcion'] = $descripcion;
        $array_status['id'] = $id;
        $array_status['modulo'] = $modulo;

        return $array_status;
    }


}


