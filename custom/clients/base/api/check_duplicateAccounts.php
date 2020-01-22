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
        if ($bean->subtipo_registro_c != "4") {
            if ($count == 0) {
              //  $GLOBALS['log']->fatal("No existe Busco almenos una reunion en planificada");

                $responsMeeting = $this->getMeetingsUser($bean);

                if ($responsMeeting['status'] != "stop" && !empty($responsMeeting['data'])) {
                    /** Creamos la Cuenta */
                   // $GLOBALS['log']->fatal("Resultado Reunion  Exito -- " . print_r($responsMeeting['data'], true));

                    $bean_account = $this->createAccount($bean, $responsMeeting);

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
                        $msj_succes = <<<SITE
                        Conversion Completa <br>
<b></b><a href="$url/#Accounts/$bean_account->id">$bean_account->name</a></b>
SITE;


                        $finish = array("idCuenta" => $bean_account->id, "mensaje" => $msj_succes);

                    }
                    // return array("idCuenta" => $bean_account->id, $resultadoRelaciones);


                } else {
                  //  $GLOBALS['log']->fatal("Resultado Reunion " . print_r($responsMeeting, true));
                    // throw new SugarApiExceptionInvalidParameter("El proceso no puede continuar Falta al menos una Reunion Planificada");
                    $finish = array("idCuenta" => "", "mensaje" => "El proceso no puede continuar Falta al menos una Reunion Planificada");

                }

            } elseif ($count > 0) {
                // $Accountsexists = true;
               // $GLOBALS['log']->fatal("Cuenta encontrada ");
                // throw new SugarApiExceptionInvalidParameter($msjExiste);
                $finish = array("idCuenta" => "", "mensaje" => $msjExiste);


            }

        } else {
            $finish = array("idCuenta" => "", "mensaje" => "El Lead ya se ha sido convertido.");

        }
        return $finish;

    }

    public function createAccount($bean_Leads, $idMeetings)
    {
        $bean_account = BeanFactory::newBean('Accounts');

        $bean_account->subtipo_cuenta_c = "En Calificacion";
        $bean_account->tipo_registro_c="Lead";
        $bean_account->tipodepersona_c = $bean_Leads->regimen_fiscal_c;
        $bean_account->origendelprospecto_c = $bean_Leads->origen_c;
        if ($bean_Leads->origen_c == 1) {
            $bean_account->origendelprospecto_c = "Marketing";

        } elseif ($bean_Leads->origen_c==2) {
            $bean_account->origendelprospecto_c = "Inteligencia de Negocio";

        }

        $bean_account->tct_detalle_origen_ddw_c = $bean_Leads->detalle_origen_c;
        $bean_account->medio_digital_c = $bean_Leads->medio_digital_c;
        $bean_account->tct_punto_contacto_ddw_c = $bean_Leads->punto_contacto_c;
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
        $bean_account->puesto_c = $bean_Leads->puesto_c;
        $bean_account->email = $bean_Leads->email;
        // Asesores
        if ($idMeetings != null) {
            $bean_account->user_id_c = empty($idMeetings['data']['LEASING']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['LEASING'];
            $bean_account->user_id1_c = empty($idMeetings['data']['FACTORAJE']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['FACTORAJE'];
            $bean_account->user_id2_c = empty($idMeetings['data']['CREDITO AUTOMOTRIZ']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['CREDITO AUTOMOTRIZ'];
            $bean_account->user_id6_c = empty($idMeetings['data']['FLEET']) ? "569246c7-da62-4664-ef2a-5628f649537e" : $idMeetings['data']['FLEET'];
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
        $sql = new SugarQuery();
        $sql->select(array('id', 'clean_name'));
        $sql->from(BeanFactory::newBean('Accounts'));
        $sql->where()->equals('clean_name', $bean_lead->clean_name_c);
        $sql->where()->notEquals('id', $bean_lead->id);

        $result = $sql->execute();
        return $result;
    }

    public function getMeetingsUser($beanL)
    {
        $procede = array("status" => "stop", "data" => array("LEASING" => "", 'CREDITO AUTOMOTRIZ' => "", "FACTORAJE" => "", "FLEET" => ""));
        if ($beanL->load_relationship('meetings')) {
            $relatedBeans = $beanL->meetings->getBeans();

            if (!empty($relatedBeans)) {
                foreach ($relatedBeans as $meeting) {

                    if ($meeting->status != "Not Held") {

                        if ($meeting->status == "Planned") {
                            $procede['status'] = "continue";

                        }

                        $sqlUser = new SugarQuery();
                        $sqlUser->select(array('id', 'puestousuario_c', 'productos_c'));
                        $sqlUser->from(BeanFactory::newBean('Users'));
                        $sqlUser->where()->equals('id', $meeting->assigned_user_id);
                        //$sqlUser->where()->notEquals('puestousuario_c', "");
                        $sqlResult = $sqlUser->execute();

                        $productos = $sqlResult[0]['productos_c'];
                        $puesto = $sqlResult[0]['puestousuario_c'];

                        // agregar que discrimine agente telefonico y cordinar de centro de prospeccion  27 y 31
                        if (strpos($productos, '1') !== false && ($puesto != "27" && $puesto != "31")) {

                            $procede['data']['LEASING'] = $meeting->assigned_user_id;
                        }
                        if (strpos($productos, '3') !== false && ($puesto != "27" && $puesto != "31")) {

                            $procede['data']['CREDITO AUTOMOTRIZ'] = $meeting->assigned_user_id;
                        }
                        if (strpos($productos, '4') !== false && ($puesto != "27" && $puesto != "31")) {

                            $procede['data']['FACTORAJE'] = $meeting->assigned_user_id;
                        }
                        if (strpos($productos, '6') !== false && ($puesto != "27" && $puesto != "31")) {

                            $procede['data']['FLEET'] = $meeting->assigned_user_id;
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
                        $cuenta = $this->createAccount($lead, null);
                        if (!empty($cuenta->id)) {
                            $this->create_relationship($bean_account, $cuenta->id);
                            array_push($resultado['data'], $cuenta->id);

                        }
                    }

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
        $bean_relacion->tipodecontacto = "PROMOCION";
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
}