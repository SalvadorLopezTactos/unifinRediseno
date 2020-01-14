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
        /**
         * Validamos que el Lead no exista en Cuentas
         */
        $bean = BeanFactory::retrieveBean('Leads', $id_Lead, array('disable_row_level_security' => true));
        $GLOBALS['log']->fatal("nombre del LEads " . $bean->first_name);


        $result = $this->existLeadAccount($bean);
        $count = count($result);
        if ($bean->subtipo_registro_c != "4") {
            if ($count == 0) {
                $GLOBALS['log']->fatal("No existe Busco almenos una reunion en planificada");

                $responsMeeting = $this->getMeetingsUser($bean);

                if ($responsMeeting['status'] != "stop" && !empty($responsMeeting['data'])) {
                    /** Creamos la Cuenta */
                    $GLOBALS['log']->fatal("Resultado Reunion  Exito -- " . print_r($responsMeeting['data'], true));

                    $bean_account = $this->createAccount($bean, $responsMeeting);

                    $GLOBALS['log']->fatal("Cuenta Creada--- " . $bean_account->id);

                    //$this->getContactAssoc($bean, $bean_account);

                    if (!empty($bean_account->id)) {
                        $resultadoRelaciones = $this->getContactAssoc($bean, $bean_account);

                        // Cambiamos Estatus Leads tipo_registro_c    ----  subtipo_registro_c
                       // $bean->tipo_registro_c = "";
                        $bean->subtipo_registro_c = 4;
                        $bean->save();
                    }

                } else {
                    throw new SugarApiExceptionInvalidParameter("El proceso no puede continuar Falta al menos una Reunion Palnificada");
                    $GLOBALS['log']->fatal("Resultado Reunion " . print_r($responsMeeting, true));
                }

            } elseif ($count > 0) {
                // $Accountsexists = true;
                $GLOBALS['log']->fatal("Cuenta encontrada ");
                throw new SugarApiExceptionInvalidParameter($msjExiste);
            }
            return array("idCuenta" => $bean_account->id, $resultadoRelaciones);

        }
    }

    public function createAccount($bean_Leads, $idMeetings)
    {
        $bean_account = BeanFactory::newBean('Accounts');

        $bean_account->tipodepersona_c = $bean_Leads->regimen_fiscal_c;
        $bean_account->origendelprospecto_c = $bean_Leads->origen_c;
        $bean_account->tct_detalle_origen_ddw_c = $bean_Leads->detalle_origen_c;
        $bean_account->medio_digital_c = $bean_Leads->medio_digital_c;
        $bean_account->tct_punto_contacto_ddw_c = $bean_Leads->punto_contacto_c;
        $bean_account->evento_c = $bean_Leads->evento_c;
        $bean_account->tct_origen_busqueda_txf_c = $bean_Leads->origen_busqueda_c;
        $bean_account->camara_c = $bean_Leads->camara_c;
        $bean_account->tct_que_promotor_rel_c = $bean_Leads->origen_ag_tel_c;
        $bean_account->nombre_comercial_c = $bean_Leads->nombre_empresa;
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
            $bean_account->user_id_c = empty($idMeetings['data']['LEASING']) ? "ca179abe-2e50-11ea-9783-9829a662ce81" : $idMeetings['data']['LEASING'];
            $bean_account->user_id1_c = empty($idMeetings['data']['FACTORAJE']) ? "ca179abe-2e50-11ea-9783-9829a662ce81" : $idMeetings['data']['FACTORAJE'];
            $bean_account->user_id2_c = empty($idMeetings['data']['CREDITO AUTOMOTRIZ']) ? "ca179abe-2e50-11ea-9783-9829a662ce81" : $idMeetings['data']['CREDITO AUTOMOTRIZ'];
            $bean_account->user_id6_c = empty($idMeetings['data']['FLEET']) ? "ca179abe-2e50-11ea-9783-9829a662ce81" : $idMeetings['data']['FLEET'];
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
        $procede = array("status" => "", "data" => array("LEASING" => "", 'CREDITO AUTOMOTRIZ' => "", "FACTORAJE" => "", "FLEET" => ""));
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
                        $sqlResult = $sqlUser->execute();

                        $productos = $sqlResult[0]['productos_c'];

                        if (strpos($productos, '1') !== false) {

                            $procede['data']['LEASING'] = $meeting->assigned_user_id;
                        }
                        if (strpos($productos, '3') !== false) {

                            $procede['data']['CREDITO AUTOMOTRIZ'] = $meeting->assigned_user_id;
                        }
                        if (strpos($productos, '4') !== false) {

                            $procede['data']['FACTORAJE'] = $meeting->assigned_user_id;
                        }
                        if (strpos($productos, '6') !== false) {

                            $procede['data']['FLEET'] = $meeting->assigned_user_id;
                        }

                    }
                }
            } else {
                $procede['status'] = "stop";
                $GLOBALS['log']->fatal("No tiene Reuniones no puede continuar aqui rompe  ");

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

                    $GLOBALS['log']->fatal("Leads " . $lead->nombre_c);
                    $GLOBALS['log']->fatal("Leads " . $lead->clean_name_c);


                    $result = $this->existLeadAccount($lead);
                    $count = count($result);

                    if ($count > 0) {
                        $GLOBALS['log']->fatal("Si existe recupero el id  " . $result[0]['id'] . " y creamos la relacion");

                        $this->create_relationship($bean_account, $result[0]['id']);
                        array_push($resultado['data'], $result[0]['id']);
                    } else {
                        $GLOBALS['log']->fatal("No existe el Contacto asociado en Cuentas hay que crearlo ");
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
        $GLOBALS['log']->fatal("Resultado de Relaciones " . print_r($resultado, true));

        return $resultado;
    }

    public function create_relationship($id_parent, $idAccount)
    {
        // rel_relaciones_accounts_1
        $GLOBALS['log']->fatal("id Padre " . $id_parent->id . "  id hijo " . $idAccount);

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
        $bean_relacionTel->telefono = $phone;
        $bean_relacionTel->tipotelefono = $tipoTel;

        $bean_relacionTel->tipotelefono = $tipoTel;
        $bean_relacionTel->tipotelefono = $tipoTel;
        $bean_relacionTel->estatus = "Activo";
        $bean_relacionTel->pais = 2;
        $bean_relacionTel->save();

    }
}