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

                $telefono = BeanFactory::getBean('Tel_Telefonos', $a_telefono['id']);
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
                //add current records ids to list
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
update dire_direccion set tipodedireccion = '{$direccion->tipodedireccion}',indicador = '{$direccion->indicador}',  calle = '{$direccion->calle}', numext = '{$direccion->numext}', numint= '{$direccion->numint}', principal=$principal, inactivo =$inactivo  where id = '{$direccion->id}';
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
        if ($bean->idprospecto_c == '' && $bean->tipo_registro_c == 'Prospecto') {
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
        if (($bean->idcliente_c == '' || $bean->idcliente_c == '0' ) && ($bean->estatus_c == 'Interesado' || $bean->tipo_registro_c == 'Cliente' || $bean->tipo_registro_c == 'Proveedor' || ($bean->tipo_registro_c == 'Persona' && $bean->tipo_relacion_c != "") || $bean->esproveedor_c || $bean->cedente_factor_c || $bean->deudor_factor_c || ($bean->tipo_registro_c=="Prospecto" && $bean->subtipo_cuenta_c=="Interesado"))) {
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
            $liberacion = $callApi->liberacionLista($bean->id, $bean->lista_negra_c, $bean->pep_c, $bean->idprospecto_c, $bean->tipo_registro_c, $current_user->user_name, $bean->name);
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

            if(($bean->tipo_registro_c != 'Persona' || ($bean->tipo_registro_c == 'Persona' && $bean->tipo_relacion_c != "")) && $bean->sincronizado_unics_c == 0) {

                if ($bean->estatus_c == 'Interesado' || ($bean->tipo_registro_c != 'Prospecto' && $_SESSION['estadoPersona'] == 'insertando')) {
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

             */
            if( (($bean->esproveedor_c || $bean->cedente_factor_c || $bean->deudor_factor_c) || ($bean->tipo_registro_c=="Prospecto" && $bean->subtipo_cuenta_c=="Interesado")) && $bean->sincronizado_unics_c == 0 && !empty($bean->idcliente_c) )
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
                if ($bean->field_defs[$field]['type'] == 'varchar') {
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
                if ($bean->tipo_registro_c == 'Lead') {
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
                    if (($bean->tipo_registro_c == 'Lead' && $relacionado==1) || $bean->tipo_registro_c != 'Lead') {
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
            if (!empty($bean->idcliente_c) && ($bean->tipo_registro_c == 'Cliente' || $bean->tipo_registro_c == 'Persona')) {
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
                        $contactoRel->tipo_registro_c = "Persona";
                        $contactoRel->tipo_relacion_c = "^Contacto^";
                        $contactoRel->assigned_user_id = $bean->assigned_user_id;
                        $contactoRel->team_set_id = $bean>team_set_id;
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
}
