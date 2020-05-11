<?php
/**
 * Created by Levementum.com
 * User: Jorge
 * Date: 6/3/2015
 * Time: 2:35 PM
 */



require_once("custom/Levementum/UnifinAPI.php");

class Account_Hooks
{
    public function nivelSatisfaccion($bean = null, $event = null, $args = null)
    {
        if($bean->fetched_row['nivel_satisfaccion_c'] != $bean->nivel_satisfaccion_c && $bean->nivel_satisfaccion_c != 'Sin Clasificar')
        {
            //Crea Notificacion al Promotor Leasing
            $notification_bean = BeanFactory::getBean("Notifications");
            $notification_bean->name = 'Resultado NPS '.$bean->name;
            $notification_bean->description = 'ALERTA: El resultado de la encuesta de Nivel de Satisfacción de '.$bean->name.' es: '.$bean->nivel_satisfaccion_c;
            $notification_bean->parent_id = $bean->id;
            $notification_bean->parent_type = 'Accounts';
            $notification_bean->assigned_user_id = $bean->user_id_c;
            $notification_bean->severity = "alert";
            $notification_bean->is_read = 0;
            $notification_bean->save();
            //Crea Notificacion al Director Leasing
            $User = new User();
            $User->retrieve($bean->user_id_c);
            $jefe = $User->reports_to_id;
            $notification_bean = BeanFactory::getBean("Notifications");
            $notification_bean->name = 'Resultado NPS '.$bean->name;
            $notification_bean->description = 'ALERTA: El resultado de la encuesta de Nivel de Satisfacción de '.$bean->name.' es: '.$bean->nivel_satisfaccion_c;
            $notification_bean->parent_id = $bean->id;
            $notification_bean->parent_type = 'Accounts';
            $notification_bean->assigned_user_id = $jefe;
            $notification_bean->severity = "alert";
            $notification_bean->is_read = 0;
            $notification_bean->save();
        }
        if($bean->fetched_row['nivel_satisfaccion_factoring_c'] != $bean->nivel_satisfaccion_factoring_c && $bean->nivel_satisfaccion_factoring_c != 'Sin Clasificar')
        {
            //Crea Notificacion al Promotor Factoraje
            $notification_bean = BeanFactory::getBean("Notifications");
            $notification_bean->name = 'Resultado NPS '.$bean->name;
            $notification_bean->description = 'ALERTA: El resultado de la encuesta de Nivel de Satisfacción de '.$bean->name.' es: '.$bean->nivel_satisfaccion_factoring_c;
            $notification_bean->parent_id = $bean->id;
            $notification_bean->parent_type = 'Accounts';
            $notification_bean->assigned_user_id = $bean->user_id1_c;
            $notification_bean->severity = "alert";
            $notification_bean->is_read = 0;
            $notification_bean->save();
            //Crea Notificacion al Director de Factoraje
            $User = new User();
            $User->retrieve($bean->user_id1_c);
            $jefe = $User->reports_to_id;
            $notification_bean = BeanFactory::getBean("Notifications");
            $notification_bean->name = 'Resultado NPS '.$bean->name;
            $notification_bean->description = 'ALERTA: El resultado de la encuesta de Nivel de Satisfacción de '.$bean->name.' es: '.$bean->nivel_satisfaccion_factoring_c;
            $notification_bean->parent_id = $bean->id;
            $notification_bean->parent_type = 'Accounts';
            $notification_bean->assigned_user_id = $jefe;
            $notification_bean->severity = "alert";
            $notification_bean->is_read = 0;
            $notification_bean->save();
        }
        if($bean->fetched_row['nivel_satisfaccion_ca_c'] != $bean->nivel_satisfaccion_ca_c && $bean->nivel_satisfaccion_ca_c != 'Sin Clasificar')
        {
            //Crea Notificacion al Promotor Leasing
            $notification_bean = BeanFactory::getBean("Notifications");
            $notification_bean->name = 'Resultado NPS '.$bean->name;
            $notification_bean->description = 'ALERTA: El resultado de la encuesta de Nivel de Satisfacción de '.$bean->name.' es: '.$bean->nivel_satisfaccion_ca_c;
            $notification_bean->parent_id = $bean->id;
            $notification_bean->parent_type = 'Accounts';
            $notification_bean->assigned_user_id = $bean->user_id2_c;
            $notification_bean->severity = "alert";
            $notification_bean->is_read = 0;
            $notification_bean->save();
            //Crea Notificacion al Director Leasing
            $User = new User();
            $User->retrieve($bean->user_id2_c);
            $jefe = $User->reports_to_id;
            $notification_bean = BeanFactory::getBean("Notifications");
            $notification_bean->name = 'Resultado NPS '.$bean->name;
            $notification_bean->description = 'ALERTA: El resultado de la encuesta de Nivel de Satisfacción de '.$bean->name.' es: '.$bean->nivel_satisfaccion_ca_c;
            $notification_bean->parent_id = $bean->id;
            $notification_bean->parent_type = 'Accounts';
            $notification_bean->assigned_user_id = $jefe;
            $notification_bean->severity = "alert";
            $notification_bean->is_read = 0;
            $notification_bean->save();
        }
    }

    public function detectaEstado($bean = null, $event = null, $args = null)
    {
        global $current_user;
        if (empty($bean->fetched_row['id'])) {
            $_SESSION['estadoPersona'] = 'insertando';
        } else {
            $_SESSION['estadoPersona'] = 'actualizando';
        }
        $GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . "  <".$current_user->user_name."> : ESTADO: " . $_SESSION['estadoPersona'] );
    }

    public function set_primary_team($bean = null, $event = null, $args = null)
    {

        global $db;
        $query = <<<SQL
SELECT team_set_id, default_team FROM users
WHERE id = '{$bean->user_id_c}'
SQL;
        $queryResult = $db->query($query);
        while ($row = $db->fetchByAssoc($queryResult)) {
            $bean->team_id = $row['default_team'];
        }
    }

    /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 6/3/2015 Description: when the account is saved, bring the personal team of the Promotor leasing,
     * Promotor Factoraje, Promotor Credito, store their default team set teams into the account. and then push these teams to all the opportunities
     * related to the account*/
    /*
    public function copy_team_to_Opp($bean = null, $event = null, $args = null)
    {

        $bean->load_relationship('teams');
        $new_account_team_ids = array();
        //query the teams for Promotor leasing, Promotor Factoraje, and Promotor Credito users
        global $db;
        $query = <<<SQL
SELECT team_set_id, default_team FROM users
WHERE id IN ('{$bean->user_id_c}', '{$bean->user_id1_c}','{$bean->user_id2_c}')
SQL;
        $queryResult = $db->query($query);
        while ($row = $db->fetchByAssoc($queryResult)) {
            $new_account_team_ids[] = $row['default_team'];
        }
        $new_account_team_ids[] = '3acdb6c1-384a-6f06-ff8b-56571ff92cc3'; // Default Team para Juridico.

        //Add the teams to the account
        $bean->teams->replace($new_account_team_ids);
        //trobinson@levementum.com commented out to fix save loop likely not neccisary needs testing
//        $bean->save();

        require_once('modules/Teams/TeamSet.php');
        $teamSetBean = new TeamSet();

        //Retrieve the teams from the team_set_id
        $teams = $teamSetBean->getTeams($bean->team_set_id);
        //Retrieve Related Opportunities
        $related_opps = $bean->get_linked_beans('opportunities', 'Opportunity');

        //Add teams to related opportunities
        foreach ($related_opps as $related_opp) {
            $related_opp->load_relationship('teams');
            $related_opp->team_id = $bean->team_id;
            $related_opp->team_set_id = $bean->team_set_id;
            $new_team_ids = array();
            foreach ($teams as $aTeam) {
                $new_team_ids[] = $aTeam->id;
            }
            $bean->teams->replace($new_team_ids);
            $related_opp->save();
        }
    }*/

    /* END CUSTOMIZATION */

    /**
     * @author trobinson@levementum.com
     * @date   6/5/15
     * @brief  process telephono relationships
     *
     * @param  bean       The object.
     * @param  event      The type of logic hook that is being called.
     * @param  arguments  Additional arguments.
     * @return void
     * @hook_array tbd
     *
     */
    public function account_telefonos($bean = null, $event = null, $args = null)
    {
        $current_id_list = array();

        if($_REQUEST['module'] != 'Import' && $_SESSION['platform'] != 'unifinAPI' ) {
            //add update current records
            foreach ($bean->account_telefonos as $a_telefono) {
                if(!empty($a_telefono['id'])){
                    $telefono = BeanFactory::getBean('Tel_Telefonos', $a_telefono['id']);
                }else{
                    $telefono = BeanFactory::newBean('Tel_Telefonos');
                }
                $telefono->name = $a_telefono['telefono'] . ' ' . $a_telefono['extension'];
                $telefono->secuencia = $a_telefono['secuencia'];
                $telefono->telefono = $a_telefono['telefono'];
                $telefono->tipotelefono = $a_telefono['tipotelefono'];
                $telefono->extension = $a_telefono['extension'];
                $telefono->estatus = $a_telefono['estatus'];
                $telefono->pais = $a_telefono['pais'];
                $telefono->principal = $a_telefono['principal'] == 1 ? 1 : 0;
                $telefono->accounts_tel_telefonos_1accounts_ida = $bean->id;
                $telefono->assigned_user_id = $bean->assigned_user_id;
                $telefono->team_set_id = $bean->team_set_id;
                $telefono->team_id = $bean->team_id;
                $telefono->whatsapp_c = $a_telefono['whatsapp_c'] == 1 ? 1 : 0;
                $GLOBALS['log']->fatal('WhatsApp: '.$telefono->whatsapp_c);
                $current_id_list[] = $telefono->save();
            }
            //retrieve all related records
            $bean->load_relationship('accounts_tel_telefonos_1');
            foreach ($bean->accounts_tel_telefonos_1->getBeans() as $a_telefono) {
                if (!in_array($a_telefono->id, $current_id_list)) {
                    //$a_telefono->mark_deleted($a_telefono->id);
                }
            }
        }
    }

    /**
     * @author bdekoning@levementum.com
     * @date 6/10/15
     * @brief Updates/creates new Direcciones records based on saved values from record
     *
     * @param Account $bean
     * @param $event
     * @param $args
     *
     * after_save
     */
    public function account_direcciones(&$bean, $event, $args)
    {
        global $current_user,$db;
        $current_id_list = array();
        // select type | Street (Calle) | primary | inactive
        // populate relationships from dropdowns

        //Nuevo account_direcciones_n
        if($_REQUEST['module'] != 'Import' && $_SESSION['platform'] != 'unifinAPI' ) {
            foreach ($bean->account_direcciones as $direccion_row) {
                /** @var dire_Direccion $direccion */
                $direccion = BeanFactory::getBean('dire_Direccion', $direccion_row['id']);

                if(empty($direccion_row['id'])){
                    //generar el guid
                    $guid = create_guid();
                    $direccion->id = $guid;
                    $direccion->new_with_id = true;
                    $new = true;
                }else{
                    $new = false;
                }
                $direccion->name = $direccion_row['calle'];
                //parse array to string for multiselects
                $tipo_string = "";
                if (count($direccion_row['tipodedireccion']) > 0) {
                    $tipo_string .= '^' . $direccion_row['tipodedireccion'][0] . '^';
                    for ($i = 1; $i < count($direccion_row['tipodedireccion']); $i++) {
                        $tipo_string .= ',^' . $direccion_row['tipodedireccion'][$i] . '^';
                    }
                }
                $direccion->tipodedireccion = $tipo_string;
                $direccion->calle = $direccion_row['calle'];
                $direccion->principal = ($direccion_row['principal'] == true); // ensure boolean conversion
                $direccion->inactivo = ($direccion_row['inactivo'] == true);
                $direccion->numint = $direccion_row['numint'];
                $direccion->numext = $direccion_row['numext'];
                $direccion->indicador = $direccion_row['indicador'];
                //teams
                $direccion->team_id = $bean->team_id;
                $direccion->team_set_id = $bean->team_set_id;
                $direccion->assigned_user_id = $bean->assigned_user_id;
                //
                // populate related account id
                $direccion->accounts_dire_direccion_1accounts_ida = $bean->id;

                $nombre_colonia_query = "Select name from dire_colonia where id ='". $direccion_row['colonia']."'";
                $nombre_municipio_query = "Select name from dire_municipio where id ='". $direccion_row['municipio']."'";
                $querycolonia = $db->query($nombre_colonia_query);
                $coloniaName = $db->fetchByAssoc($querycolonia);
                $querymunicipio = $db->query($nombre_municipio_query);
                $municipioName = $db->fetchByAssoc($querymunicipio);
                $direccion_completa =$direccion_row['calle']." ".$direccion_row['numext']." ".($direccion_row['numint']!=""?"Int: ".$direccion_row['numint']:""). ", Colonia ".$coloniaName['name'].", Municipio ".$municipioName['name'];
                $direccion->name = $direccion_completa;


                // update related records
                if ($direccion->load_relationship('dire_direccion_dire_pais')) {
                    if ($direccion_row['pais'] !== $direccion->dire_direccion_dire_paisdire_pais_ida) {
                        $direccion->dire_direccion_dire_pais->delete($direccion->id);
                        $direccion->dire_direccion_dire_pais->add($direccion_row['pais']);
                    }
                }

                if ($direccion->load_relationship('dire_direccion_dire_estado')) {
                    if ($direccion_row['estado'] !== $direccion->dire_direccion_dire_estadodire_estado_ida) {
                        $direccion->dire_direccion_dire_estado->delete($direccion->id);
                        $direccion->dire_direccion_dire_estado->add($direccion_row['estado']);
                    }
                }

                if ($direccion->load_relationship('dire_direccion_dire_municipio')) {
                    if ($direccion_row['municipio'] !== $direccion->dire_direccion_dire_municipiodire_municipio_ida) {
                        $direccion->dire_direccion_dire_municipio->delete($direccion->id);
                        $direccion->dire_direccion_dire_municipio->add($direccion_row['municipio']);
                    }
                }

                if ($direccion->load_relationship('dire_direccion_dire_ciudad')) {
                    if ($direccion_row['ciudad'] !== $direccion->dire_direccion_dire_ciudaddire_ciudad_ida) {
                        $direccion->dire_direccion_dire_ciudad->delete($direccion->id);
                        $direccion->dire_direccion_dire_ciudad->add($direccion_row['ciudad']);
                    }
                }

                if ($direccion->load_relationship('dire_direccion_dire_codigopostal')) {
                    try {
                        //if (!empty($direccion_row['postal'])) {
                        if ($direccion_row['postal'] !== $direccion->dire_direccion_dire_codigopostal) {
                            $direccion->dire_direccion_dire_codigopostal->delete($direccion->id);
                            $direccion->dire_direccion_dire_codigopostal->add($direccion_row['postal']);
                        }
                    } catch (Exception $e) {
                        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error " . $e->getMessage());
                    }
                }

                if ($direccion->load_relationship('dire_direccion_dire_colonia')) {
                    if ($direccion_row['colonia'] !== $direccion->dire_direccion_dire_coloniadire_colonia_ida) {
                        $direccion->dire_direccion_dire_colonia->delete($direccion->id);
                        $direccion->dire_direccion_dire_colonia->add($direccion_row['colonia']);
                    }
                }

                $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : DIRECCION NOMBRE" . $direccion_completa);
                $current_id_list[] = $direccion->id;
                if($new){
                    $direccion->save();
                }else{
                    $inactivo= $direccion->inactivo==1?$direccion->inactivo:0;
                    $principal = $direccion->principal==1?$direccion->principal:0;
                    $query = <<<SQL
update dire_direccion set  name = '{$direccion->name}', tipodedireccion = '{$direccion->tipodedireccion}',indicador = '{$direccion->indicador}',  calle = '{$direccion->calle}', numext = '{$direccion->numext}', numint= '{$direccion->numint}', principal=$principal, inactivo =$inactivo  where id = '{$direccion->id}';
SQL;
                    try{
                        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Update *784 " . $query);
                        $resultado = $db->query($query);
                        $callApi = new UnifinAPI();
                        if ($direccion->sincronizado_unics_c == '0') {
                            $direccion = $callApi->insertaDireccion($direccion);
                        } else {
                            $direccion = $callApi->actualizaDireccion($direccion);
                        }
                        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : resultado " . $db->getAffectedRowCount($resultado));
                    }catch (Exception $e){
                        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error " . $e->getMessage());
                    }

                }
                //$direccion->save();
            }
            //retrieve all related records
            $bean->load_relationship('accounts_dire_direccion_1');
            foreach ($bean->accounts_dire_direccion_1->getBeans() as $a_direccion) {
                if (!in_array($a_direccion->id, $current_id_list)) {
                    //$a_direccion->mark_deleted($a_direccion->id);
                }
            }
        }
    }

    /* TODO: Add Definition and comment */
    public function listaNegraCall($bean = null, $event = null, $args = null)
    {
        if ($bean->primernombre_c != $bean->fetched_row['primernombre_c'] || $bean->segundonombre_c != $bean->fetched_row['segundonombre_c']
            || $bean->apellidopaterno_c != $bean->fetched_row['apellidopaterno_c'] || $bean->razonsocial_c != $bean->fetched_row['razonsocial_c']) {

            //login class located at custom/Levementum/UnifinAPI.php
            global $db;
            $callApi = new UnifinAPI();
            $coincidencias = $callApi->listaNegra($bean->primernombre_c, $bean->segundonombre_c,
                $bean->apellidopaterno_c, $bean->apellidomaterno_c, $bean->tipodepersona_c, $bean->razonsocial_c);
            $bean->lista_negra_c = $coincidencias['listaNegra'] <= 0 ? 0 : 1 ;
            $bean->pep_c = $coincidencias['PEP'] <= 0 ? 0 : 1 ;

            // todo: Validar que el valor de Alto riesgo sea solo por valor del oficial de cumplimiento - Waldo //VAlor anterior 0
            if ($bean->lista_negra_c > 0 || $bean->pep_c > 0) {
                $bean->riesgo_c = 'Alto';
            } else{
                //Validar riesgo pais y profesión antes de establecer el riesgo como bajo
                global $db, $current_user;
                $query = <<<SQL
SELECT ifnull(p.altoriesgo,0) as AltoRiesgo
FROM accounts_cstm acc
LEFT OUTER JOIN dire_pais p on acc.pais_nacimiento_c = p.id
where acc.id_c = '{$bean->user_id_c}'
SQL;
                $queryResult = $db->query($query);
                while ($row = $db->fetchByAssoc($queryResult)) {
                    if ($row['AltoRiesgo']==1){
                        $bean->riesgo_c = 'Alto';
                    }else{
                        //Valida el riesgo por profesión
                        /*
                        if(!_.isEmpty(this.model.get("profesion_c")) || this.model.get("profesion_c") != null) {
                            this.model.set("riesgo_c", "Bajo");
                            var profesionActual = this.model.get("profesion_c");
                            var profesiones_de_riesgo = app.lang.getAppListStrings('profesion_riesgo_list');
                            Object.keys(profesiones_de_riesgo).forEach(function (key) {
                                if (key == profesionActual) {
                                    self.model.set("riesgo_c", "Alto");
                                }
                            });
                        }*/

                        $bean->riesgo_c = 'Bajo';
                    }
                }
            }
            $GLOBALS['log']->fatal(" <".$current_user->user_name."> : coincidencias['PEP'] " . print_r($coincidencias['PEP'], 1));
            $GLOBALS['log']->fatal(" <".$current_user->user_name."> : coincidencias['listaNegra'] " . print_r($coincidencias['listaNegra'], 1));
            $GLOBALS['log']->fatal(" <".$current_user->user_name."> : $bean->riesgo_c " . print_r($bean->riesgo_c, 1));
        }
    }

    /* TODO: Add Definition and comment */
    public function crearFolioProspecto($bean = null, $event = null, $args = null)
    {
        global $current_user;
        if ($bean->idprospecto_c == '' && $bean->tipo_registro_cuenta_c == '2') { //2 = Propsecto
            global $db;
            $callApi = new UnifinAPI();
            $numeroDeFolio = $callApi->generarFolios(3);
            $bean->idprospecto_c = $numeroDeFolio;
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : numeroDeFolio   " . ": $numeroDeFolio ");
        }
    }

    /* TODO: Add Definition and comment */
    public function crearFolioCliente($bean = null, $event = null, $args = null)
    {
        global $current_user;
        //Tipo Cuenta: 3-Cliente, 4-Persona, 5-Proveedor **** SubTipo-Cuenta: 7-Interesado
        if (($bean->idcliente_c == '' || $bean->idcliente_c == '0' ) && ($bean->estatus_c == 'Interesado' || $bean->tipo_registro_cuenta_c == '3' || $bean->tipo_registro_cuenta_c == '5' || ($bean->tipo_registro_cuenta_c == '4' && $bean->tipo_relacion_c != "") || $bean->esproveedor_c || $bean->cedente_factor_c || $bean->deudor_factor_c || ($bean->tipo_registro_cuenta_c=="2" && $bean->subtipo_registro_cuenta_c=="7"))) {
            global $db;
            $callApi = new UnifinAPI();
            $numeroDeFolio = $callApi->generarFolios(1,$bean);
            $bean->idcliente_c = $numeroDeFolio;
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> :numeroDeFolio   " . ": $numeroDeFolio ");

            //$this->actualizaOportunidadProspecto($bean);
        }

        //Generación de referencia bancaria
        if($bean->idcliente_c > 0 && (empty($bean->referencia_bancaria_c) || $bean->referencia_bancaria_c == '')){
            $bean->referencia_bancaria_c = $this->GeneraReferenciaBancaria($bean->idcliente_c);
        }
    }

    //UNI403 1. Cuando se crea un prospecto nuevo, si se podrá agregar una nueva oportunidad (pero solamente una),
    // con los campos Monto, activo y Plazo en este momento no debes de ir por un folio de solicitud a UNICS si no solamente
    // crear la oportunidad en SUGAR, con un estatus de “OPORTUNIDAD DE PROSPECTO”. Cuando se le da interesado a este prospecto,
    // además de la funcionalidad actual (invocación de BPM y de folio de cliente), deberás de obtener un folio de solicitud
    // para actualizar el folio y estatus (“INTEGRACION DE EXPEDIENTE”) de dicha oportunidad.
    // TODO UNIFIN: Modificar función actualizaOportunidadProspecto de Account_Hook.php ya que está haciendo un Query buscando oportunidades en estatus "'Oportunidad de Prospecto'" para crear procesos
    public function actualizaOportunidadProspecto($bean){
        //$GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__."Carlos Zaragoza BEAN : " . print_r($bean,1));
        $callApi = new UnifinAPI();
        try {
            global $db, $current_user;
            $query = "SELECT
                          a.name
                          ,oppc.estatus_c as estatus
                          , oppc.id_c as opportunity_id
                          , oppc.monto_c
                          , oppc.enviar_por_correo_c
                          , oppc.tipo_producto_c
                          , oppc.usuario_bo_c
                          , oppc.tipo_de_operacion_c
                          , oppc.plazo_c
                          , oppc.id_activo_c
                          , oppc.index_activo_c
                          , oppc.ca_valor_auto_iva_c
                          , oppc.ca_tasa_c
                          , oppc.ca_pago_mensual_c
                          , oppc.ca_importe_enganche_c
                          , oppc.idcot_bpm_c
                          , oppc.id_linea_credito_c
                          , oppc.es_multiactivo_c
                          , oppc.multiactivo_c
                          , oppc.porcentaje_ca_c
                          , oppc.vrc_c
                          , oppc.vri_c
                          , oppc.deposito_garantia_c
                          , oppc.porcentaje_renta_inicial_c
                          , oppc.ratificacion_incremento_c
                          , oppc.ri_ca_tasa_c
                          , oppc.ri_deposito_garantia_c
                          , oppc.ri_porcentaje_ca_c
                          , oppc.ri_porcentaje_renta_inicial_c
                          , oppc.ri_vrc_c
                          , oppc.ri_vri_c
                          , oppc.monto_ratificacion_increment_c
                          , oppc.plazo_ratificado_incremento_c
                          , oppc.ri_usuario_bo_c
                          , oppc.instrumento_c
                          , oppc.puntos_sobre_tasa_c
                          , oppc.puntos_tasa_moratorio_c
                          , oppc.tipo_tasa_ordinario_c
                          , oppc.tipo_tasa_moratorio_c
                          , oppc.instrumento_moratorio_c
                          , oppc.factor_moratorio_c
                          , oppc.cartera_descontar_c
                          , oppc.tasa_fija_ordinario_c
                          , oppc.tasa_fija_moratorio_c
                        FROM
                          accounts_opportunities aopp
                          INNER JOIN opportunities_cstm oppc ON oppc.id_c = aopp.opportunity_id
                          INNER JOIN opportunities opp ON oppc.id_c = opp.id
                          INNER JOIN accounts a ON a.id = aopp.account_id
                        WHERE account_id = '{$bean->id}'
                        AND oppc.estatus_c = 'OP'
                        AND aopp.deleted = 0
                        ";
            $queryResult = $db->query($query);
            //$GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__.": query " . print_r($query,1));

            while ($row = $db->fetchByAssoc($queryResult)) {
                //obten el folio de la solicitud
                $numeroDeFolio = $callApi->generarFolios(2);

                //PARAMETROS
                //TODO UNIFIN: Error: Al actualizar la persona se están disparando los hooks de operaciones e iniciando procesos (Dentro del query validar que no se tenga process ID)
                $row['idsolicitud_c'] = $numeroDeFolio;

                //Carga Promotor
                $prom = BeanFactory::getBean('Users');
                $prom->retrieve($bean->user_id_c);
                $row['promotor_leasing'] = $prom->user_name;
                //Cuenta
                $row['account_id'] = $bean->id;
                $row['idcliente_c'] = $bean->idcliente_c;
                $row['nombre_cliente'] = $bean->name;
                $row['correo'] = $bean->email1;
                $row['riesgo'] = $bean->riesgo_c;
                $row['tipo_persona'] = $bean->tipodepersona_c;
                $row['lista_negra_c'] = $bean->lista_negra_c;
                $row['pep_c'] = $bean->pep_c;
                //FIN DE PARAMETROS



                //$GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . "CZ: parametros para UNI2-01 antes de obtenSolicitud: " . print_r($row, 1));
                $solicitudCreditoResultado = $callApi->obtenSolicitudCredito($row);
                $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : solicitudCreditoResultado " . print_r($solicitudCreditoResultado,1));

                //Actualiza la operacion con el id de solicitud y pon el estatus en Integracion de expediente
                $opp = BeanFactory::getBean('Opportunities');
                $opp->retrieve($row['opportunity_id']);
                $opp->estatus_c = 'P';
                $opp->idsolicitud_c = $solicitudCreditoResultado['idSolicitud'];
                $opp->save();

                $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Opportunity({$opp->id}) changed to Integracion de Expediente OP");


            } //while
        } catch
        (Exception $e) {
            error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error " . $e->getMessage());
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error " . $e->getMessage());
        }
    }


    public function liberaciondeLista($bean = null, $event = null, $args = null)
    {
        global $current_user;
        $callApi = new UnifinAPI();
        // ** jsr ** inicio
        if(($bean->id_process_c == 0 || $bean->id_process_c == null || $bean->id_process_c == "") && ($bean->lista_negra_c == 1 || $bean->pep_c == 1)) {
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : ** JSR ** if a ejecutar OFICIAL DE CUMPLIMIENTO   " . ": $bean->id_process_c ");
            $liberacion = $callApi->liberacionLista($bean->id, $bean->lista_negra_c, $bean->pep_c, $bean->idprospecto_c, $bean->tipo_registro_cuenta_c, $current_user->user_name, $bean->name);
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Inicia OFICIAL DE CUMPLIMIENTO   " . ": $liberacion ");
        }
        // ** jsr ** fin
    }

    /* CVV INICIO**/
    public function clienteCompleto($bean = null, $event = null, $args = null)
    {

        /*** ALI INICIO ***/
        if($bean->canal_c == 1 && $bean->sincronizado_unics_c == 0)
        {
            $GLOBALS['log']-> fatal ("1");
            $callApi = new UnifinAPI();
            $cliente = $callApi->InsertaPersona($bean);
            $this->emailChangetoUnics($bean);
        }
        else
        {
            //Tipo Cuenta = 4 - Persona  2 - Prospecto
            if(($bean->tipo_registro_cuenta_c != '4' || ($bean->tipo_registro_cuenta_c == '4' && $bean->tipo_relacion_c != "")) && $bean->sincronizado_unics_c == 0) {

                if ($bean->estatus_c == 'Interesado' || ($bean->tipo_registro_cuenta_c != '2' && $_SESSION['estadoPersona'] == 'insertando')) {
                    $callApi = new UnifinAPI();
                    $cliente = $callApi->insertarClienteCompleto($bean);
                }
            }
            /**
             * F. Javier G. Solar 12/07/2018
             * Se realiza el proceso de envió de cuenta al sistema UNICS, solo si no se ha
            *realizado.
            *Conservar los campos que sean obligatorios de acuerdo a la opción
            *seleccionada

             */ // Tipo Cuenta 2-Prospecto, subTipo Cuenta 7-Interesado
            if( (($bean->esproveedor_c || $bean->cedente_factor_c || $bean->deudor_factor_c) || ($bean->tipo_registro_cuenta_c=="2" && $bean->subtipo_registro_cuenta_c=="7")) && $bean->sincronizado_unics_c == 0 && !empty($bean->idcliente_c) )
            {
                $callApi = new UnifinAPI();
                $cliente = $callApi->insertarClienteCompleto($bean);


            }

        }
      //  $this->actualizaOportunidadProspecto($bean);
        /*** ALI FIN ***/
    }

    /**
     * Cuando se graba un prospecto como Seguimiento Futuro, requerira una fecha y hora y creara una cita en el calendario para darle seguimiento al cliente
     * @param Account $bean
     * @param Array $event
     * @param Array $args
     */
    public function seguimiento_futuro($bean = null, $event = null, $args = null)
    {
        global $current_user;
        if ($bean->estatus_c != 'Seguimiento Futuro' || empty($bean->seguimiento_futuro_c)
            || $bean->seguimiento_futuro_c == $bean->fetched_row['seguimiento_futuro_c']) {
            return null;
        }
        try {
            if ($bean->tiposeguimiento_c == 'Reunion') {
                $meeting = BeanFactory::getBean('Meetings');
                $meeting->date_start = $bean->seguimiento_futuro_c;
                $meeting->date_end = $bean->seguimiento_futuro_c;
                $meeting->parent_type = 'Accounts';
                $meeting->parent_id = $bean->id;
                $meeting->duration_minutes = '15';
                $meeting->reminder_time = 15;
                $meeting->assigned_user_id = $bean->assigned_user_id;
                $meeting->name = $bean->name . " (Seguimiento Futuro)";
                $meeting->description = $bean->descripciondetarea_c;
                $meeting->save();
            }
            if ($bean->tiposeguimiento_c == 'Llamada') {
                $call = BeanFactory::getBean('Calls');
                $call->date_start = $bean->seguimiento_futuro_c;
                $call->date_end = $bean->seguimiento_futuro_c;
                $call->parent_type = 'Accounts';
                $call->parent_id = $bean->id;
                $call->duration_minutes = '15';
                $call->reminder_time = 15;
                $call->assigned_user_id = $bean->assigned_user_id;
                $call->name = $bean->name . " (Seguimiento Futuro)";
                $call->description = $bean->descripciondetarea_c;
                $call->save();

            }
            if ($bean->tiposeguimiento_c == 'Tarea') {
                $task = BeanFactory::getBean('Tasks');
                $task->date_start = $bean->seguimiento_futuro_c;
                $task->date_due = $bean->seguimiento_futuro_c;
                $task->parent_type = 'Accounts';
                $task->parent_id = $bean->id;
                $task->assigned_user_id = $bean->assigned_user_id;
                $task->name = $bean->name . " (Seguimiento Futuro)";
                $task->description = $bean->descripciondetarea_c;
                $task->save();

            }

        } catch (Exception $e) {
            error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error: " . $e->getMessage());
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error " . $e->getMessage());
        }

        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : SEGUIMIENTO FUTURO: " . print_r($meeting, 1));

    }

    public function textToUppperCase($bean = null, $event = null, $args = null)
    {
        if($_REQUEST['module'] != 'Import') {
            foreach ($bean as $field => $value) {
                if ($bean->field_defs[$field]['type'] == 'varchar' && $field !='encodedkey_mambu_c') {
                    $value = mb_strtoupper($value, "UTF-8");
                    $bean->$field = $value;
                }
                if ($bean->field_defs[$field]['name'] == 'name') {
                    $value = mb_strtoupper($value, "UTF-8");
                    $bean->$field = $value;
                }
            }
        }
    }

    /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 6/19/2015 Description: Logic hook to call WS Actualiza persona en UNICS*/
    /*** CVV INCIO **/
    public function actualizaPersona($bean = null, $event = null, $args = null)
    {
        global $current_user;
        global $db;
        try {
            $GLOBALS['log']->fatal(" <".$current_user->user_name."> :El estatus en sesion al actualizar Persona es:" . $_SESSION['estadoPersona']);
            /*
              AF - 2018/11/01
              Modica condición para  actualizar  registros que tengan idCliente y Leads que sean relación de otras cuentas
            */
            //no se debe disparar si es lead
            if (!empty($bean->idcliente_c) && $_SESSION['estadoPersona'] == 'actualizando') {
                $callApi = new UnifinAPI();

                //Evalua si envía lead
                $relacionado = 0;
                if ($bean->tipo_registro_cuenta_c == '1') { //Tipo Cuenta 1-Lead
                  // Consulta si tiene relación
                  $query = "select id_c from rel_relaciones_cstm
                          where account_id1_c ='". $bean->id ."'
                          limit 1;";
                  $queryResult = $db->query($query);
                  //Si tiene relaciones envia petición
                  while ($row = $db->fetchByAssoc($queryResult)) {
                      $relacionado = 1;
                  }
                }
                //CVV - valida que la persona ya se encuentre sincornizada con UNICS, de lo contrario manda a insertar completo
                if($bean->sincronizado_unics_c == 1){
                    if (($bean->tipo_registro_cuenta_c == '1' && ($relacionado==1 || $bean->esproveedor_c || $bean->deudor_factor_c)) || $bean->tipo_registro_cuenta_c != '1') {
                      $Actualizacliente = $callApi->actualizaPersonaUNICS($bean);
                      $this->emailChangetoUnics($bean);
                    }
                }else{
                    $Actualizacliente = $callApi->insertarClienteCompleto($bean);
                }
            }
        } catch (Exception $e) {
            error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error: " . $e->getMessage());
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error " . $e->getMessage());
        }
    }
    /*** CVV FIN **/
    public function insertaPLDUNICS($bean = null, $event = null, $args = null)
    {
        global $current_user;
        try {
            if (!empty($bean->idcliente_c) && ($bean->tipo_registro_cuenta_c == '3' || $bean->tipo_registro_cuenta_c == '4')) { //Tipo Cuenta 3-Cliente, 4-Persona
                $callApi = new UnifinAPI();
                $PLD = $callApi->insertaPLD($bean, $_SESSION['estadoPersona']);
                $_SESSION['estadoPersona'] = '';
            }
        } catch (Exception $e) {
            error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error: " . $e->getMessage());
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error " . $e->getMessage());
        }
    }

    public function account_contacts(&$bean, $event, $args)
    {
        if($bean->tipodepersona_c == 'Persona Moral') {
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." bean->account_contacts :  " . print_r($bean->account_contacts,true));

            if ($bean->account_contacts != null && $bean->account_contacts != '') {
                foreach ($bean->account_contacts as $contact_row) {
                    if($contact_row['primerNombre'] != null) {
                        $contactoRel = BeanFactory::getBean('Accounts');
                        $contactoRel->tipodepersona_c = "Persona Fisica";
                        $contactoRel->primernombre_c = $contact_row['primerNombre'] . ($contact_row['segundoNombre'] != "" ? " ". $contact_row['segundoNombre'] : "");
                        //$contactoRel->segundonombre_c = $contact_row['segundoNombre'];
                        $contactoRel->apellidopaterno_c = $contact_row['apellidoPaterno'];
                        $contactoRel->apellidomaterno_c = $contact_row['apellidoMaterno'];
                        $contactoRel->email1 = $contact_row['emailContacto'];
                        $contactoRel->tipo_registro_cuenta_c = "4"; //Tipo cuenta 4-Persona
                        $contactoRel->tipo_relacion_c = "^Contacto^";
                        $contactoRel->assigned_user_id = $bean->assigned_user_id;
                        $contactoRel->team_set_id = $bean->team_set_id;
                        $contactoRel->team_id = $bean->team_id;
                        $contactoRel->promotorcredit_c = $bean->promotorcredit_c;
                        $contactoRel->promotorfactoraje_c = $bean->promotorfactoraje_c;
                        $contactoRel->promotorleasing_c = $bean->promotorleasing_c;

                        $contactoRel->save();
                        $Rel = BeanFactory::getBean('Rel_Relaciones');
                        $Rel->account_id1_c = $contactoRel->id;
                        $Rel->rel_relaciones_accounts_1accounts_ida = $bean->id;
                        $Rel->rel_relaciones_accountsaccounts_ida = $bean->id;
                        $Rel->name = "Temp";
                        $Rel->relaciones_activas = "^Contacto^";
                        $Rel->tipodecontacto = "^Promocion^";
                        $Rel->assigned_user_id = $bean->assigned_user_id;
                        $Rel->team_set_id  = $bean->team_set_id;
                        $Rel->team_id = $bean->team_id;
                        $Rel->save();

                        if(!empty($contact_row['telefonoContacto'])) {
                            $telefono = BeanFactory::getBean('Tel_Telefonos');
                            $telefono->name = $contact_row['telefonoContacto'];
                            $telefono->telefono = $contact_row['telefonoContacto'];
                            $telefono->accounts_tel_telefonos_1accounts_ida = $contactoRel->id;
                            $telefono->tipotelefono = 1;
                            $telefono->assigned_user_id = $bean->assigned_user_id;
                            $telefono->team_set_id = $bean->team_set_id;
                            $telefono->team_id = $bean->team_id;
                            //$GLOBALS['log']->fatal('>>>>llamada desde account_contacts<<<<<<<');
                            $telefono->save();
                        }
                    }
                }
            }
        }
    }
    /*
     * @author Carlos Zaragoza Ortiz
     * @brief Envia lista de correos de un account al servicio de UNICs
     *
     * */
    public function emailChangetoUnics($bean){
        global $current_user, $db;
        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Entra a email");
        //Este es el correo anterior $bean->email1
        $GLOBALS['log']->fatal(" <".$current_user->user_name."> : bean correo", $bean->email1);
        //$GLOBALS['log']->fatal(" <".$current_user->user_name."> : bean", print_r($bean,true));

        $query=<<<SQL
select ac.id_c, ac.idcliente_c, e.id, e.email_address,  er.deleted from email_addr_bean_rel er, email_addresses e, accounts_cstm ac
where er.bean_id = '{$bean->id}'  and er.email_address_id = e.id and ac.id_c = er.bean_id;
SQL;
        $queryResult = $db->query($query);
        //$header = $db->getOne($query);
        while ($row = $db->fetchByAssoc($queryResult)) {
            $id = $row['id'];
            $cliente = $row['idcliente_c'];
            $correo[] =  array(
                "GuidMail" => $row['id'],
                "Email" => $row['email_address'],
                "Estado" => $row['deleted'],

            );
        }
        $correos['GuidCliente'] = $id;
        $correos['IdCliente'] = $cliente;
        $correos['Emails'] = $correo;
        $main['oCorreos']= $correos;
        $GLOBALS['log']->fatal(" <".$current_user->user_name."> : bean addresses", print_r($correos, true));

        $callApi = new UnifinAPI();
        if($correos['GuidCliente'] != null){
            $resultado = $callApi->correosDeCliente($main);

            $GLOBALS['log']->fatal(" <".$current_user->user_name."> : RESULTADO", print_r($resultado, true));
        }

    }
    /** @var Account $bean*/
    public function rfcDuplicate($bean, $event, $args)
    {
        global $db, $current_user;
        if($bean->tipodepersona_c == 'Persona Moral'){
            $query = "Select count(*) as duplicados from accounts_cstm
where rfc_c = '{$bean->rfc_c}' and
 razonsocial_c = '$bean->razonsocial_c' AND
 id_c <> '{$bean->id}'";
        }else{
            $query = "Select count(*) as duplicados from accounts_cstm
where rfc_c = '{$bean->rfc_c}' and
 primernombre_c = '$bean->primernombre_c' AND
 segundonombre_c = '$bean->segundonombre_c' AND
 apellidopaterno_c = '$bean->apellidopaterno_c' AND
 apellidomaterno_c = '$bean->apellidomaterno_c' AND
 id_c <> '{$bean->id}'";
        }

        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Consulta RFC " . $query);
        $queryResult = $db->getOne($query);
        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Duplicados " . $queryResult);
        if ($queryResult > 0) {
            require_once 'include/api/SugarApiException.php';
            throw new SugarApiExceptionInvalidParameter("Ya existe una persona registrada con mismo nombre y RFC.");

        } else {
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : No hay duplicados " . $queryResult);
        }
    }

    public function GeneraReferenciaBancaria($idCliente)
    {
        $sum = 0;
        $digits = str_split($idCliente);
        for ($i = 0; $i < strlen($idCliente); $i++) {
            if((strlen($idCliente) - ($i+1)) % 2 == 0){
                $sum = $sum + ($digits[$i] * 2 > 9 ? ($digits[$i] * 2) - 9 : $digits[$i] * 2 );
            }else{
                $sum = $sum + $digits[$i];
            }
        }
        $sum = 10 - $sum %10;
        return $idCliente . ($sum % 10);
    }

    public function crearFolioRelacion($bean = null, $event = null, $args = null)
    {
   		global $db;
		$idCuenta = $bean->id;
		$query = "select id_c from rel_relaciones_cstm where account_id1_c = '$idCuenta'";
        $result = $db->query($query);
    	$row = $db->fetchByAssoc($result);
		if($row)
    	{
			if ($bean->idcliente_c == '' || $bean->idcliente_c == '0') {
				$callApi = new UnifinAPI();
				$numeroDeFolio = $callApi->generarFolios(1,$bean);
				$bean->idcliente_c = $numeroDeFolio;
			}
		}
    }

    public function relacion2UNICS($bean = null, $event = null, $args = null)
    {
   		global $db;
		$idCuenta = $bean->id;
		$query = "select id_c from rel_relaciones_cstm where account_id1_c = '$idCuenta'";
        $result = $db->query($query);
    	$row = $db->fetchByAssoc($result);
		if($row)
    	{
			if($bean->sincronizado_unics_c == 0)
			{
				$callApi = new UnifinAPI();
				$cliente = $callApi->insertarClienteCompleto($bean);
			}
		}
    }

    public function creaResumen($bean = null, $event = null, $args = null)
    {
        global $db;
        $idCuenta = $bean->id;
        $GLOBALS['log']->fatal('Entra a Crear Resumen de Account ');
        $bean_Resumen = BeanFactory::retrieveBean('tct02_Resumen',$idCuenta);

        if ($bean_Resumen== null || empty($bean_Resumen)){
            // global $app_list_strings, $current_user; //Obtención de listas de valores
            // $tipo = $app_list_strings['tipo_registro_list']; //obtencion lista tipo de registro
            // $subtipo = $app_list_strings['subtipo_cuenta_list'];  //Obtiene lista de los subtipos de cuenta
            // $etitipo= $tipo[$bean->tipo_registro_cuenta_c];      //Obtiene el valor del campo obtenido de la lista con Etiqueta
            // $etisubtipo= $subtipo[$bean->subtipo_registro_cuenta_c]; //Obtiene el valor del campo obtenido de la lista con Etiqueta

            $GLOBALS['log']->fatal('Entra a condición para crear Resumen');
            $bean_Resumen = BeanFactory::newBean('tct02_Resumen');
            $bean_Resumen->new_with_id = true;
            $bean_Resumen->name = $bean->name;
            $bean_Resumen->id = $idCuenta;

            //Setea valores para los campos por producto (leasing, factoraje y CA en tipo y subtipo).
            //LEASING
            // $bean_Resumen->tct_tipo_l_txf_c= $bean->tipo_registro_c;
            // $bean_Resumen->tct_subtipo_l_txf_c=$bean->subtipo_cuenta_c;
            // $bean_Resumen->tct_tipo_cuenta_l_c= mb_strtoupper(trim($etitipo.' '.$etisubtipo));
            //FACTORAJE
            // $bean_Resumen->tct_tipo_f_txf_c= $bean->tipo_registro_c;
            // $bean_Resumen->tct_subtipo_f_txf_c=$bean->subtipo_cuenta_c;
            // $bean_Resumen->tct_tipo_cuenta_f_c= mb_strtoupper(trim($etitipo.' '.$etisubtipo));
            //CREDITO AUTOMOTRIZ
            // $bean_Resumen->tct_tipo_ca_txf_c= $bean->tipo_registro_c;
            // $bean_Resumen->tct_subtipo_ca_txf_c=$bean->subtipo_cuenta_c;
            // $bean_Resumen->tct_tipo_cuenta_ca_c= mb_strtoupper(trim($etitipo.' '.$etisubtipo));
            //FLEET
            // $bean_Resumen->tct_tipo_fl_txf_c= $bean->tipo_registro_c;
            // $bean_Resumen->tct_subtipo_fl_txf_c=$bean->subtipo_cuenta_c;
            // $bean_Resumen->tct_tipo_cuenta_fl_c= mb_strtoupper(trim($etitipo.' '.$etisubtipo));
            //UNICLICK
            // $bean_Resumen->tct_tipo_uc_txf_c= $bean->tipo_registro_c;
            // $bean_Resumen->tct_subtipo_uc_txf_c=$bean->subtipo_cuenta_c;
            // $bean_Resumen->tct_tipo_cuenta_uc_c= mb_strtoupper(trim($etitipo.' '.$etisubtipo));

            //Evalua tipo de cuenta
            // if ($bean->tipo_registro_c == 'Prospecto' && $bean->subtipo_cuenta_c == 'Integracion de Expediente' ) {
            //     //Setea valores para los campos por producto (leasing, factoraje y CA en tipo y subtipo).
            //     //LEASING
            //     $bean_Resumen->tct_tipo_l_txf_c= 'Lead';
            //     $bean_Resumen->tct_subtipo_l_txf_c= 'En Calificacion';
            //     $bean_Resumen->tct_tipo_cuenta_l_c= 'LEAD EN CALIFICACIÓN';
            //     //FACTORAJE
            //     $bean_Resumen->tct_tipo_f_txf_c= 'Lead';
            //     $bean_Resumen->tct_subtipo_f_txf_c='En Calificacion';
            //     $bean_Resumen->tct_tipo_cuenta_f_c= 'LEAD EN CALIFICACIÓN';
            //     //FLEET
            //     $bean_Resumen->tct_tipo_fl_txf_c= 'Lead';
            //     $bean_Resumen->tct_subtipo_fl_txf_c='En Calificacion';
            //     $bean_Resumen->tct_tipo_cuenta_fl_c= 'LEAD EN CALIFICACIÓN';
            //     //UNICLICK
            //     $bean_Resumen->tct_tipo_uc_txf_c= 'Lead';
            //     $bean_Resumen->tct_subtipo_uc_txf_c='En Calificacion';
            //     $bean_Resumen->tct_tipo_cuenta_uc_c= 'LEAD EN CALIFICACIÓN';
            // }
            //GUARDA REGISTRO DE RESUMEN
            $bean_Resumen->save();
        }
        $GLOBALS['log']->fatal('Finaliza y crea Resumen para vista 360');
    }

    //Función para validar que una cuenta tenga asesor asignado, si no tiene usuario establece 9.-Sin gestor
    /*
      Condiciones:
      Tipo =  Prospecto
      Asesor L,CA, F = Vacío
    */
    public function valida_asesor($bean = null, $event = null, $args = null)
    {
        // $GLOBALS['log']->fatal('L- '. $bean->user_id_c . ' - '. $bean->promotorleasing_c);
        // $GLOBALS['log']->fatal('F- '. $bean->user_id1_c . ' - '. $bean->promotorfactoraje_c);
        // $GLOBALS['log']->fatal('C- '. $bean->user_id2_c . ' - '. $bean->promotorcredit_c);

        $idSinGestor = '569246c7-da62-4664-ef2a-5628f649537e';
        //Valida Cuenta tipo promotor
        if($bean->tipo_registro_cuenta_c == '2'){ //2-Prospecto
          //Valida promotor Leasing
          if ((empty($bean->user_id_c) || $bean->user_id_c =="") && empty($bean->promotorleasing_c)) {
              $bean->user_id_c = $idSinGestor;
          }
          //Valida promotor Factoraje
          if ((empty($bean->user_id1_c) || $bean->user_id1_c =="") && empty($bean->promotorfactoraje_c)) {
              $bean->user_id1_c = $idSinGestor;
          }
          //Valida promotor CA
          if ((empty($bean->user_id2_c) || $bean->user_id2_c =="") && empty($bean->promotorcredit_c)) {
              $bean->user_id2_c = $idSinGestor;
          }
          //Valida promotor Fleet
          if ((empty($bean->user_id6_c) || $bean->user_id6_c =="") && empty($bean->promotorfleet_c)) {
              $bean->user_id6_c = $idSinGestor;
          }
          //Valida promotor Uniclick
          if ((empty($bean->user_id7_c) || $bean->user_id7_c =="") && empty($bean->promotoruniclick_c)) {
             $bean->user_id7_c = $idSinGestor;
          }
        }
    }

    public function guardapotencial($bean=null, $event= null, $args= null){

        global $db;
        $idCuenta = $bean->id;
        //$GLOBALS['log']->fatal('Entra a guardar autos Potencial en Resumen');
        $PotencialAutos = json_decode($bean->potencial_autos);
        //Recupera el bean de tct02_resumen
        $bean_Resumen = BeanFactory::retrieveBean('tct02_Resumen',$idCuenta);
        //$GLOBALS['log']->fatal(print_r($PotencialAutos,true));
        //$GLOBALS['log']->fatal(print_r($bean->potencial_autos,true));

        if (!empty($bean_Resumen) && !empty($PotencialAutos)){
            //$GLOBALS['log']->fatal('Entra Resumen OK ');
            //$GLOBALS['log']->fatal($PotencialAutos->autos->tct_no_autos_u_int_c);
            //Setea los valores en los campos de tct02_resumen
            $bean_Resumen->tct_no_autos_u_int_c = $PotencialAutos->autos->tct_no_autos_u_int_c;
            $bean_Resumen->tct_no_autos_e_int_c =$PotencialAutos->autos->tct_no_autos_e_int_c;
            $bean_Resumen->tct_no_motos_int_c =$PotencialAutos->autos->tct_no_motos_int_c;
            $bean_Resumen->tct_no_camiones_int_c =$PotencialAutos->autos->tct_no_camiones_int_c;

            //Guardar registro
            $bean_Resumen->save();
        }

    }

    public function quitaespacios($bean=null, $event= null, $args= null){

        global $db;
        global $app_list_strings, $current_user; //Obtención de listas de valores
        $idCuenta = $bean->id;
        //$GLOBALS['log']->fatal('Limpia espacios');
        //Se crean variables que limpien los excesos de espacios en los campos establecidos.
        $limpianame= preg_replace('/\s\s+/', ' ', $bean->name);
        $limpianombre= preg_replace('/\s\s+/', ' ', $bean->primernombre_c);
        $limpiaapaterno= preg_replace('/\s\s+/', ' ', $bean->apellidopaterno_c);
        $limpiamaterno= preg_replace('/\s\s+/', ' ', $bean->apellidomaterno_c);
        $limpiarazon= preg_replace('/\s\s+/', ' ', $bean->razonsocial_c);
        $limpianomcomercial= preg_replace('/\s\s+/', ' ', $bean->nombre_comercial_c);

        //Actualiza valores limpios a los campos de la Cuenta
        $bean->name= $limpianame;
        $bean->primernombre_c= $limpianombre;
        $bean->apellidopaterno_c= $limpiaapaterno;
        $bean->apellidomaterno_c=$limpiamaterno;
        $bean->razonsocial_c=$limpiarazon;
        $bean->nombre_comercial_c=$limpianomcomercial;
        if ($bean->tipodepersona_c=="Persona Moral"){
            $bean->name=$bean->razonsocial_c;
        }

        //Crea Clean_name (exclusivo para aplicativos externos a CRM)
        if ($bean->clean_name=="" || $bean->clean_name==null){
            $tipo = $app_list_strings['validacion_simbolos_list']; //obtencion lista simbolos
            $acronimos= $app_list_strings['validacion_duplicados_list'];

            if ($bean->tipodepersona_c!="Persona Moral"){
                //$GLOBALS['log']->fatal(print_r($tipo,true));
                //Cambia a mayúsculas y quita espacios a cada campo
                //Concatena los tres campos para formar el clean_name
                $nombre= $bean->name;
                $nombre= mb_strtoupper($nombre, "UTF-8");
                $separa= explode( " ",$nombre);
                //$GLOBALS['log']->fatal(print_r($separa,true));
                $longitud=count($separa);
                //Itera el arreglo separado
                for ($i = 0; $i < $longitud; $i++) {
                    foreach ($tipo as $t=>$key){
                        $separa[$i]=str_replace($key,"", $separa[$i]);
                    }
                }
                $une= implode($separa);
                $bean->clean_name= $une;
                //$GLOBALS['log']->fatal($bean->clean_name);

            }else{
                //$GLOBALS['log']->fatal($bean->razonsocial_c);
                $nombre=$bean->name;
                $nombre= mb_strtoupper($nombre, "UTF-8");
                $separa= explode( " ",$nombre);
                $separa_limpio=$separa;
                $GLOBALS['log']->fatal(print_r($separa,true));
                $longitud=count($separa);
                $eliminados=0;
                //Itera el arreglo separado
                for ($i = 0; $i < $longitud; $i++) {
                    foreach ($tipo as $t=>$key){
                        $separa[$i]=str_replace($key,"", $separa[$i]);
                        $separa_limpio[$i]=str_replace($key,"", $separa_limpio[$i]);
                    }
                    foreach ($acronimos as $a=>$key){
                        if($separa[$i]==$a){
                            $separa[$i]="";
                            $eliminados++;
                        }
                        //$GLOBALS['log']->fatal($a);
                        $GLOBALS['log']->fatal(print_r($separa,true));


                    }
                }
                //Condicion para eliminar los acronimos
                if(($longitud-$eliminados)<=1){
                    $separa=$separa_limpio;
                }
                //Convierte el array a string nuevamente
                $une= implode($separa);
                $bean->clean_name= $une;
            }
        }
    }

    public function asignaSinGestor($bean=null, $event= null, $args= null){

        $idSinGestor='569246c7-da62-4664-ef2a-5628f649537e';

        //Promotor Leasing
        if (($bean->user_id_c==null|| $bean->user_id_c =="") && empty($bean->promotorleasing_c)) {
            $bean->user_id_c = $idSinGestor;
        }

        //Promotor Factoraje
        if (($bean->user_id1_c==null|| $bean->user_id1_c =="") && empty($bean->promotorfactoraje_c)) {
            $bean->user_id1_c = $idSinGestor;
        }

        //Promotor CA
        if (($bean->user_id2_c==null|| $bean->user_id2_c =="") && empty($bean->promotorcredit_c)) {
            $bean->user_id2_c = $idSinGestor;
        }

        //Promotor Fleet
        if (($bean->user_id6_c==null|| $bean->user_id6_c =="") && empty($bean->promotorfleet_c)) {
            $bean->user_id6_c = $idSinGestor;
        }

        //Promotor Uniclick
        if (($bean->user_id7_c==null|| $bean->user_id7_c =="") && empty($bean->promotoruniclick_c)) {
            $bean->user_id7_c = $idSinGestor;
        }

    }
    public function idUniclick($bean=null, $event= null, $args= null){
      //Valida que no exista id uniclick duplicado
      global $db;
      if(!empty($bean->id_uniclick_c) && $bean->id!=""){
        //Consulta id_uniclick_c
        $query = "SELECT id_c, id_uniclick_c FROM accounts_cstm
            WHERE id_c != '{$bean->id}' and id_uniclick_c = '{$bean->id_uniclick_c}'";
        //Ejecuta consulta
        $queryResult = $db->query($query);
        while ($row = $db->fetchByAssoc($queryResult)) {
          require_once 'include/api/SugarApiException.php';
          throw new SugarApiExceptionInvalidParameter("Ya existe una cuenta registrada con el mismo Id Cliente Uniclick");
        }
      }
    }

    public function NuevoAnalizate($bean=null, $event= null, $args= null){
        //Se ejecuta para creación de nuevos registros:
        /*
        * Tipo de cuenta = Proveedor
        * o Es Proveedor = True
        */
        if (!$args['isUpdate'] && $bean->email1!="" && ($bean->tipo_registro_cuenta_c=="5" || $bean->esproveedor_c==1)){ //Tipo Cuenta 5-Proveedor
            $GLOBALS['log']->fatal('Genera Registro Analizate: Crear - Nuevo Proveedor');
            $this->RegistroAnalizate($bean);

        }
    }

    public function EditaAnalizate($bean=null, $event= null, $args= null){
      //Se ejecuta para edición de registros existentes:
      /*
      * Se actualiza Es Proveedor = True
      */
        if ($args['isUpdate'] && $bean->fetched_row['esproveedor_c']==0 && $bean->esproveedor_c==1 && $bean->email1!=""){
            $GLOBALS['log']->fatal('Genera Registro Analizate: Edita - Nuevo Proveedor');
            $this->RegistroAnalizate($bean);
        }
    }

    public function RegistroAnalizate($bean=null, $event= null, $args= null){
        //Crea nuevo bean Analizate (registro) y la relacion con acccounts (registro creado).
        $url_portalFinanciera= '&UUID='.$bean->id.'&RFC_CIEC='.$bean->rfc_c;
        $relacion = BeanFactory::newBean('ANLZT_analizate');
        $relacion->anlzt_analizate_accountsaccounts_ida=$bean->id;
        $relacion->empresa=1;
        $relacion->estado=1;
        $relacion->tipo=1;
        $relacion->fecha_actualizacion=$bean->date_entered;
        $relacion->url_portal=$url_portalFinanciera;
        $relacion->assigned_user_id=$bean->user_id_c;
        $relacion->load_relationship('anlzt_analizate_accounts');
        $relacion->anlzt_analizate_accounts->add($bean->id);
        $relacion->save();
    }

  	public function NuevaCuentaProductos ($bean=null, $event= null, $args= null){
        //Se ejecuta para creación productos para nuevos registros(cuentas):
        /* Dev: Erick de JEsus
        * Tipo de cuenta = Todas
        */
        //Sólo se ejecuta en la creación
        if (!$args['isUpdate']){
            //Declara variables para generación de registros
            global $current_user;
            global $app_list_strings;
            $beanprod = null;

            $module = 'uni_Productos';
            $key_productos = array('1','4','3','6','8','7');
            $name_productos = array('-LEASING','-FACTORAJE','-CRÉDITO AUTOMOTRIZ','-FLEET','-UNICLICK','-CRÉDITO SOS');
            $count = count($name_productos);
            $current_prod = null;
            $fechaAsignaAsesor = date("Y-m-d"); //Fecha de Hoy

            $tipo = $app_list_strings['tipo_registro_cuenta_list'];
            $subtipo = $app_list_strings['subtipo_registro_cuenta_list'];
            $etitipo= $tipo[$bean->tipo_registro_cuenta_c];
            $etisubtipo= $subtipo[$bean->subtipo_registro_cuenta_c];
            for ($i = 0; $i < $count; $i++) {
              	//$GLOBALS['log']->fatal($current_prod);
              	$beanprod = BeanFactory::newBean($module);
              	$beanprod->name = $bean->name.$name_productos[$i];
              	$beanprod->tipo_producto = $key_productos[$i];
                $beanprod->fecha_asignacion_c = $fechaAsignaAsesor;
                $beanprod->tipo_cuenta = empty($bean->tipo_registro_cuenta_c) ? '1' : $bean->tipo_registro_cuenta_c;
                $beanprod->subtipo_cuenta = (empty($bean->subtipo_registro_cuenta_c) && $beanprod->tipo_cuenta=='1') ? '5' : $bean->subtipo_registro_cuenta_c;
                $beanprod->tipo_subtipo_cuenta = mb_strtoupper(trim($etitipo.' '.$etisubtipo));
                //Caso especial: Alta portal CA
                if ($beanprod->tipo_producto == '3' && $GLOBALS['service']->platform!= 'base' && $GLOBALS['service']->platform!= 'mobile') {
                    $beanprod->tipo_cuenta = "2"; //2-Prospecto
                    $beanprod->subtipo_cuenta = "8"; //Integración de expediente
                    $beanprod->tipo_subtipo_cuenta = "PROSPECTO INTEGRACIÓN DE EXPEDIENTE";
                    //Actualiza campo general
                    global $db;
                    $update = "update accounts_cstm set
                      tipo_cuenta='2', subtipo_cuenta ='8'
                      where id_c = '{$bean->id}'";
                    $updateExecute = $db->query($update);
                }
                //Asignación de usuario
              	switch ($key_productos[$i]) {
                    case '1': //Leasing
                        $beanprod->assigned_user_id = $bean->user_id_c;
                    break;
                    case '4': //Factoraje
                        $beanprod->assigned_user_id = $bean->user_id1_c;
              			break;
              		  case '3': //Credito-Automotriz
                        $beanprod->assigned_user_id = $bean->user_id2_c;
              			break;
                    case '6': //Fleet
                        $beanprod->assigned_user_id = $bean->user_id6_c;
              			break;
                    case '7': //Credito-SOS
                        $beanprod->assigned_user_id = $bean->user_id_c;
                    break;
                    case '8': //Uniclick
                        $beanprod->assigned_user_id = $bean->user_id7_c;
              			break;
              	}
                //Guarda registro y vincula a cuenta
              	$beanprod->save();
              	$bean->load_relationship('accounts_uni_productos_1');
              	$bean->accounts_uni_productos_1->add($beanprod->id);
              	$beanprod = null;
  		      }
        }
    }

    public function set_csv_linea_vigente($bean=null, $event= null, $args= null){
        //Se escribe en archivo csv únicamente cuando se ha cambiado el Tipo y Subtipo de Cuenta a Cliente Con Linea Vigente
        //Esta función se dispara a través de Proccess Author "Cliente con Línea" ****** Tipo-Cuenta: 2-Prospecto, 3-Cliente **** SubTipo-Cuenta: 18-Con linea vigente, 8-Integracion de expediente
  	    if(($bean->subtipo_registro_cuenta_c=='18' && $bean->tipo_registro_cuenta_c=='3' && $bean->fetched_row['subtipo_registro_cuenta_c']!='18' && !$bean->conversion_gclid_c) || ($bean->subtipo_registro_cuenta_c=='8' && $bean->tipo_registro_cuenta_c=='2' && $bean->fetched_row['subtipo_registro_cuenta_c']!='8' && !$bean->conversion_gclid_c)){
            $GLOBALS['log']->fatal('------------ENTRA CONDICIÓN CLIENTE CON LINEA VIGENTE DISPARA DESDE PROCCESS AUTHOR------------');
            $gclid='';//este campo se obtiene del lead relacionado campo gclid
            $conversion_name='Conv CRM';
            $tipo_producto_solicitud='';
            //Obteniendo gclid de lead relacionado
            if ($bean->load_relationship('leads')) {
                $params=array('limit' => 1, 'orderby' => 'date_modified DESC', 'disable_row_level_security' => true);
                //Fetch related beans
                $leads = $bean->leads->getBeans($bean->id,$params);
                //Ordenarlas por fecha de modificación para obtener el valor de la línea de la solicitud que actuaalizó esta cuenta
                if (!empty($leads)) {
                    foreach ($leads as $lead) {
                        if($lead->detalle_plataforma_c != "" && $lead->detalle_plataforma_c != null){
                            $gclid=$lead->detalle_plataforma_c;
                        }
                    }
                }
            }

            //Únicamente se controlan Clientes que cuentan con valor en su campo gclid en su respectivo Lead relacionado
            if($gclid != '' && $gclid !=null){
                $GLOBALS['log']->fatal('------------LEAD SI CUENTA CON GCLID------------');
                //Monto de línea= Campo Opps= monto_c
                $conversion_value='0';
                if ($bean->load_relationship('opportunities')) {
                    $parametros=array('limit' => 1, 'orderby' => 'date_modified DESC', 'disable_row_level_security' => true);
                    //Fetch related beans
                    $opps_relacionadas = $bean->opportunities->getBeans($bean->id, $parametros);
                    //Ordenarlas por fecha de modificación para obtener el valor de la línea de la solicitud que actuaalizó esta cuenta
                    if (!empty($opps_relacionadas)) {
                        foreach ($opps_relacionadas as $opp) {
                            $conversion_value=$opp->monto_c;
                            $tipo_producto_solicitud=$opp->tipo_producto_c;
                        }
                    }
                }

                //Se escribe en csv cuando trae tipo de producto
                if($tipo_producto_solicitud !=''){
                    $GLOBALS['log']->fatal('------------SE ESCRIBE EN CSV PARA SUBIR SFTP------------');
                    //Estableciendo la hora en formato "24/03/2020 19:00:00"
                    date_default_timezone_set('America/Mexico_City');
                    $conversion_time=date ('d/m/Y H:i:s');
                    //Limpiando el monto, ya que en el csv espera solo cantidades enteras, sin decimales
                    $conv_entero=explode('.',$conversion_value);
                    $ruta_archivo="custom/plantillaCSV/clientes_lv.csv";
                    if (file_exists($ruta_archivo)) {
                        $file = fopen($ruta_archivo,"a");
                        fwrite($file, $gclid.','.$conversion_name.','.$conversion_time.','.$conv_entero[0].','.PHP_EOL);
                        fclose($file);
                    }
                    //Actualiza Cuenta a conversión GCLID
                    $bean->conversion_gclid_c = 1;
                }
            }
        }
    }
	
    public function set_account_mambu($bean=null, $event= null, $args= null){	
        global $sugar_config;	
        if($bean->subtipo_cuenta_c=='Con Linea Vigente' && $bean->tipo_registro_c=='Cliente' && $bean->fetched_row['subtipo_cuenta_c']!='Con Linea Vigente' && $bean->encodedkey_mambu_c ==""){	
            //variables para consumo de servicio	
            $url=$sugar_config['url_mambu_clientes'];	
            $user=$sugar_config['user_mambu'];	
            $pwd=$sugar_config['pwd_mambu'];	
            $auth_encode=base64_encode( $user.':'.$pwd );	
            //variables para payload	
            $id_crm=$bean->id;	
            $nombre='';	
            $apellido='';	
            $id_cliente_corto=$bean->idcliente_c;	
            //$id_cliente_corto='52597';	
            if($bean->tipodepersona_c!='Persona Moral'){	
                $nombre=$bean->primernombre_c;	
                $apellido=$bean->apellidopaterno_c .' '.$bean->apellidomaterno_c;	
            }else{	
                $nombre=$bean->razonsocial_c;	
                $apellido='PM';	
            }	
            //Obteniendo referencias bancarias	
            $array_referencias=array();	
            if ($bean->load_relationship('refba_referencia_bancaria_accounts')) {	
                $referencias=$bean->refba_referencia_bancaria_accounts->getBeans();	
                if (!empty($referencias)) {	
                    foreach ($referencias as $ref) {	
                        $ref_bancaria= $ref->numerocuenta_c;	
                        $nombre_banco=$ref->institucion;	
                        $new_referencia=array(	
                            "Referencia_Bancaria"=>$ref_bancaria,	
                            "Nombre_del_Banco_Clientes"=>$nombre_banco	
                        );	
                        array_push($array_referencias,$new_referencia);	
                    }	
                }	
            }	
            $body = array(	
                "firstName" => $nombre,	
                "lastName" => $apellido,	
                "_Referencias_Bancarias_Clientes"=>$array_referencias,	
                "_Referencia_Crm"=>array(	
                    "Id_Crm"=> $id_crm,	
                    "id_cliente_corto"=>$id_cliente_corto	
                )	
            );	
            $GLOBALS['log']->fatal(json_encode($body));	
            $callApi = new UnifinAPI();	
            $resultado = $callApi->postMambu($url,$body,$auth_encode);	
            $GLOBALS['log']->fatal('--------------MAMBU RESPONSE-----------------');	
            $GLOBALS['log']->fatal($resultado);	
            if(!empty($resultado['encodedKey'])){	
                $bean->encodedkey_mambu_c=$resultado['encodedKey'];	
            }	
            //Obtener solicitudes	
            if ($bean->load_relationship('opportunities')) {	
                //Fetch related beans	
                $solicitudes=$bean->opportunities->getBeans();	
                if (!empty($solicitudes)) {	
                    foreach ($solicitudes as $sol) {	
                        //Disparar integración hacia mambú de solicitudes para estatus AUTORIZADA	
                        if($sol->tipo_producto_c=='8' && $sol->tct_id_mambu_c=="" && $sol->estatus_c=='N'){	
                            $sol->save();	
                        }	
                    }	
                }	
            }	
        }	
    }	

}
