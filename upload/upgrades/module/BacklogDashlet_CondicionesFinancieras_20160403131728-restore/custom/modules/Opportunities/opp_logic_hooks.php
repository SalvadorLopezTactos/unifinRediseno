<?php

    /**
     * @file   opp_logic_hooks.php
     * @author trobinson@levementum.com
     * @date   6/3/2015 1:07 PM
     * @brief  opportunity logic hooks
     */
        require_once("custom/Levementum/UnifinAPI.php");
	
	class OpportunityLogic
    {
        /**
         * @author trobinson@levementum.com
         * @date   6/3/15
         * @brief  Create a Logic hook on the opportunity on beforeSave,
         * that it takes the teams of the Account and it it sync them to the opportunity
         *
         * @param  bean       The object.
         * @param  event      The type of logic hook that is being called.
         * @param  arguments  Additional arguments.
         * @return void
         * @hook_array before_save
         *
         */

        function setTeams($bean = null, $event = null, $args = null)
        {
            global $current_user;
            //get teams
            $bean->load_relationship('teams');
            //get related accounts
            $account = BeanFactory::retrieveBean("Accounts", $bean->account_id);
            if (empty($account)) {
                $GLOBALS['log']->fatal(" <".$current_user->user_name."> :Unable to retrieve Account for Opp $bean->name : $bean->id");
            } else {
                //get account teams
                //Create a TeamSet bean - no BeanFactory
                require_once('modules/Teams/TeamSet.php');
                $teamSetBean = new TeamSet();
                //get account teams
                $teams = $teamSetBean->getTeams($account->team_set_id);
                $bean->team_id = $account->team_id;
                $bean->team_set_id = $account->team_set_id;
                //build new team id array
                $new_team_ids = array();
                foreach ($teams as $aTeam) {
                    $GLOBALS['log']->fatal(" <".$current_user->user_name."> :$aTeam->name : $aTeam->id");
                    $new_team_ids[] = $aTeam->id;
                }
                //set team id's for opp
                $bean->teams->replace($new_team_ids);
            }
        }

		 public function crearFolioSolicitud($bean = null, $event = null, $args = null)
        {
			//Operaciones de solicitud de crédito
            if(($bean->idsolicitud_c == 0 || empty($bean->idsolicitud_c)) && $bean->tipo_operacion_c == 1) {
                $callApi = new UnifinAPI();
                if($bean->canal_c == 1){
                    $numeroDeFolio = $bean->idsolicitud_c;
                }
                else{
                    $numeroDeFolio = $callApi->generarFolios(2);
                    $bean->idsolicitud_c = $numeroDeFolio;
                }
                $bean->name = "SOLICITUD " . $numeroDeFolio . " - " . $bean->name;
            }
        }

        public function setFechadeCierre($bean = null, $event = null, $args = null){

        //BEGIN Set the name for the Activo
        require_once("custom/Levementum/UnifinAPI.php");
        $callApi = new UnifinAPI();
        $activo_list = $callApi->getActivoSubActivo();
        if (!empty($activo_list)) {
            foreach ($activo_list as $index => $activo) {
                $bean->activo_nombre_c = $activo['index'] == $bean->activo_c ? $activo['nombre'] : $bean->activo_nombre_c;
            }
        }
		// CVV - 28/03/2016 - Se asigna la fecha de cierre dependiendo del mes del Backlog
			if($bean->tipo_producto_c == '1' && $bean->tipo_operacion_c == '1'){
				$date_Back = $bean->anio_c . "-". $bean->mes_c . "-01";
				$date_close = date("Y-n-t", strtotime($date_Back));
			}else{
				$date_close = date("Y-n-j", strtotime("last day of this month"));
			}			
            $bean->fecha_estimada_cierre_c = $date_close;
            $bean->date_closed = $date_close;
			 
        //END Set the name for the Activo
        /*
         *  TODO No planchar la fecha de cierre al último día del mes
         * Carlos Zaragoza
         * Se comenta code que cambia la fecha al ultimo de mes
         //
         if($bean->forecast_c == 'Pipeline' || $bean->forecast_c == 'Backlog'){
             $last_day_of_month = date("Y-n-j", strtotime("last day of this month"));
             $bean->fecha_estimada_cierre_c = $last_day_of_month;
             $bean->date_closed = $last_day_of_month;
         }
    */
		// CVV - 28/03/2016 - El modulo de Forecast fue deshabilitado
		/*
        if ($bean->forecast_c == 'QuitarBoP') {
            if ($bean->forecast_time_c == 30) {
                $endOfCycle = date("Y-n-j", strtotime("+25 days"));
                $bean->fecha_estimada_cierre_c = $endOfCycle;
                $bean->date_closed = $endOfCycle;
            }
            if ($bean->forecast_time_c == 60) {
                $endOfCycle = date("Y-n-j", strtotime("+55 days"));
                $bean->fecha_estimada_cierre_c = $endOfCycle;
                $bean->date_closed = $endOfCycle;
            }
            if ($bean->forecast_time_c == 90) {
                $endOfCycle = date("Y-n-j", strtotime("+85 days"));
                $bean->fecha_estimada_cierre_c = $endOfCycle;
                $bean->date_closed = $endOfCycle;
            }
            if ($bean->forecast_time_c == '90mas') {
                $endOfCycle = date("Y-n-j", strtotime("+100 days"));
                $bean->fecha_estimada_cierre_c = $endOfCycle;
                $bean->date_closed = $endOfCycle;
            }
        }*/
    }

    /*
     * UNI406 4. Cuando existe un cliente con operaciones vigentes y en el panel de “operaciones” presiona el “+” para agregar una nueva solicitud,
     * lo deberá dirigir a la pantalla de nueva oportunidad para capturar los campos requeridos y en cuanto le de guardar,
     * debe crear la oportunidad e invocar el servicio de consulta folio solicitud y el servicio de integración de expediente en el BPM.
    */
    function creaSolicitud($bean = null, $event = null, $args = null)
    {
        global $db, $current_user;
            if(($bean->id_process_c == 0 || $bean->id_process_c == null) && $bean->estatus_c =='P' && $bean->tipo_operacion_c == '1') {
                //Hay operaciones vigentes?
                // ** JSR INICIO
                $query = <<<SQL
			SELECT aop.account_id,aop.opportunity_id, oppc.estatus_c, oppc.monto_c, oppc.idsolicitud_c,
    acstm.idcliente_c,ac.name as nombre_cliente,  acstm.riesgo_c as riesgo,acstm.tipodepersona_c as tipo_persona,
    email_addresses.email_address as correo,acstm.lista_negra_c, acstm.pep_c, oppc.activo_c, oppc.id_activo_c,
    oppc.index_activo_c, oppc.plazo_c, oppc.enviar_por_correo_c, oppc.tipo_de_operacion_c, oppc.sub_activo_c, oppc.tipo_producto_c,
    f_aforo_c, f_tipo_factoraje_c, f_comentarios_generales_c, f_documento_descontar_c, usuario_bo_c, opp.amount, uu.user_name, oppc.ca_importe_enganche_c, oppc.ca_pago_mensual_c,
    oppc.ca_tasa_c, oppc.ca_valor_auto_iva_c, oppc.idcot_bpm_c, oppc.id_linea_credito_c, oppc.es_multiactivo_c, oppc.multiactivo_c,
    oppc.porcentaje_ca_c, oppc.vrc_c, oppc.vri_c, oppc.deposito_garantia_c, oppc.porcentaje_renta_inicial_c, oppc.ratificacion_incremento_c,
    oppc.ri_ca_tasa_c, oppc.ri_deposito_garantia_c, oppc.ri_porcentaje_ca_c, oppc.ri_porcentaje_renta_inicial_c, oppc.ri_vrc_c,
    oppc.ri_vri_c, oppc.monto_ratificacion_increment_c, oppc.plazo_ratificado_incremento_c, oppc.ri_usuario_bo_c, oppc.instrumento_c, oppc.puntos_sobre_tasa_c, oppc.tipo_tasa_ordinario_c,
    oppc.tipo_tasa_moratorio_c, oppc.instrumento_moratorio_c, oppc.factor_moratorio_c, oppc.cartera_descontar_c, oppc.puntos_tasa_moratorio_c, oppc.tasa_fija_ordinario_c, oppc.tasa_fija_moratorio_c, oppc.plan_financiero_c
				FROM
					accounts_opportunities aop
					INNER join
						opportunities_cstm oppc ON oppc.id_c = aop.opportunity_id
					INNER JOIN
                        opportunities opp on opp.id = oppc.id_c
                    INNER JOIN
						accounts ac ON ac.id = aop.account_id
					INNER JOIN
						accounts_cstm acstm ON acstm.id_c = aop.account_id and acstm.tipo_registro_c = 'Cliente'
					LEFT JOIN
						email_addr_bean_rel  ON email_addr_bean_rel.bean_id = acstm.id_c and email_addr_bean_rel.primary_address = 1
					LEFT JOIN
						email_addresses ON email_addresses.id = email_addr_bean_rel.email_address_id AND email_addr_bean_rel.deleted = 0
					LEFT JOIN
					    users uu on uu.id =opp.assigned_user_id
					WHERE
						aop.opportunity_id = '{$bean->id}'
						AND aop.deleted = 0/*
						AND email_addr_bean_rel.primary_address = 1*/
SQL;
                //$GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> :: query " . $query);
                $queryResult = $db->query($query);
                $rowCount = $db->getRowCount($queryResult);

                //$GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : ** JSR ** " . $rowCount);
                if ($rowCount <= 0) {
                    return null;
                }
                $row = $bean->db->fetchByAssoc($queryResult);
                $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : ** JSR ** DATOS DE LA OPERACION " . print_r($row, true));
            	$callApi = new UnifinAPI();
            	$solicitudCreditoResultado = $callApi->obtenSolicitudCredito($row);
                $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . "  <".$current_user->user_name."> : Opportunity({$bean->id_process_c}) changed to Integracion de Expediente ");
                try {
                    $bean->id_process_c = $solicitudCreditoResultado['processInstanceId'];
                    $process_id = $solicitudCreditoResultado['processInstanceId'];
                    $query = "UPDATE opportunities_cstm
                              SET id_process_c =  '$process_id'
                              WHERE id_c = '{$bean->id}'";
                    $queryResult = $db->query($query);
                    if($bean->id_process_c != 0 && $bean->id_process_c != null && $bean->id_process_c != "-1" && $bean->id_process_c != "" && $bean->tipo_producto_c !=4 ){
                        //$GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . "  <".$current_user->user_name."> : Despues de generar Process debe actualizarse la lista de condiciones financieras ". print_r($bean,1));
						$callApi->actualizaSolicitudCredito($bean);
                    }
                } catch (Exception $e) {
                    error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Error: " . $e->getMessage());
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Error " . $e->getMessage());
                }
            }
            //CVV se manda a llamar la funcion de actualizar la solicitud de UNICS
            //$callApi2 = new UnifinAPI();
            //$callApi2->actualizaSolicitudCredito($bean);
        }

        public function creaRatificacion($bean = null, $event = null, $args = null){
            global $current_user;
            if($bean->ratificacion_incremento_c==1 && $bean->tipo_operacion_c == '2' && $bean->tipo_de_operacion_c == 'LINEA_NUEVA'){
                // CVV - 30/03/2016 - Crea una nueva operacion para la solicitud de R/I
                $opp = BeanFactory::getBean('Opportunities');

                // Generales de la operación
                $opp->name = "R/I para " . $bean->name;
                $opp->monto_c = $bean->monto_ratificacion_increment_c + $bean->monto_c;
                $opp->amount = $bean->monto_ratificacion_increment_c + $bean->amount;
                $opp->account_id = $bean->account_id;
                $opp->tipo_producto_c = $bean->tipo_producto_c;
                $opp->tipo_de_operacion_c = 'RATIFICACION_INCREMENTO';
                $opp->opportunities_opportunities_1opportunities_ida = $bean->id;
                $opp->assigned_user_id = $bean->assigned_user_id;
                $opp->usuario_bo_c = $bean->ri_usuario_bo_c;
                $opp->id_linea_credito_c = $bean->id_linea_credito_c;
                $opp->f_comentarios_generales_c = $bean->f_comentarios_generales_c;

                //CVV - 31/03/2016 - Se deben crear los campos de mes y año Backlog para la operacion de R/I y tomar los datos de esos nuevos campos
                $opp->mes_c = $bean->ri_mes_c;
                $opp->anio_c = $bean->ri_anio_c;
                // Se comenta para calcular la fecha de cierre hasta guardar la nueva Opp //
                // $opp->date_closed = date("Y-m-t", strtotime(date("Y-m-d")));

                //Asigna el primer registro del control de condiciones financieras para envíar a solicitud de UNI2
                if (count($bean->condiciones_financieras_incremento_ratificacion) > 0 and $bean->tipo_producto_c != '4'){
                    //$opp->id_activo_c = $bean->condiciones_financieras[0][''];
                    $opp->index_activo_c = $bean->condiciones_financieras_incremento_ratificacion['0']['idactivo'];
                    $plazos = explode("_", $bean->condiciones_financieras_incremento_ratificacion['0']['plazo']);
                    $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." CVV - Plazo que se asignara". print_r( $plazos[1], true));
                    $opp->plazo_c = $plazos[1];
                    $opp->es_multiactivo_c = 1;
                    $opp->ca_tasa_c = $bean->condiciones_financieras_incremento_ratificacion['0']['tasa_minima'];
                    $opp->deposito_garantia_c = $bean->condiciones_financieras_incremento_ratificacion['0']['deposito_en_garantia'];
                    $opp->porcentaje_ca_c = $bean->condiciones_financieras_incremento_ratificacion['0']['comision_minima'];
                    $opp->porcentaje_renta_inicial_c = $bean->condiciones_financieras_incremento_ratificacion['0']['renta_inicial_minima'];
                    $opp->vrc_c = $bean->condiciones_financieras_incremento_ratificacion['0']['vrc_minimo'];
                    $opp->vri_c = $bean->condiciones_financieras_incremento_ratificacion['0']['vri_minimo'];

                    //Obtiene la lista de activo para guardar multiactivos
                    global $app_list_strings;
                    $activos = array();
                    $multiactivo_c = array();
                    if (isset($app_list_strings['idactivo_list'])){
                        $activos = $app_list_strings['idactivo_list'];
                    }

                    //Arma lista de activos
                    foreach ($bean->condiciones_financieras_incremento_ratificacion as $condicion) {
                        foreach($activos as $key=>$value){
                            if($key == $condicion['idactivo']){
                                $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." CVV - Agregar item a multiactivo: ". print_r($key, true));
                                if (!in_array($value, $multiactivo_c)) {
                                    $multiactivo_c[] = $value;
                                }
                            }
                        }
                    }

                    $opp->multiactivo_c = implode(",", $multiactivo_c);
                    $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." CVV - Contenido de multiactivo: ". print_r($opp->multiactivo_c, true));

                    //Copia el listado de condiciones financieras para la nueva solicitud
                    $opp->condiciones_financieras = $bean->condiciones_financieras_incremento_ratificacion;

                }
                //Campos para factoraje
                $opp->porcentaje_ca_c = $bean->ri_porcentaje_ca_c;
                $opp->f_tipo_factoraje_c = $bean->f_tipo_factoraje_c;
                $opp->f_aforo_c = $bean->f_aforo_c;
                $opp->instrumento_c = $bean->ri_instrumento_c;
                $opp->puntos_sobre_tasa_c = $bean->ri_puntos_sobre_tasa_c;
                $opp->puntos_tasa_moratorio_c = $bean->ri_puntos_tasa_moratorio_c;
                $opp->tipo_tasa_ordinario_c = $bean->ri_tipo_tasa_ordinario_c;
                $opp->tipo_tasa_moratorio_c = $bean->ri_tipo_tasa_moratorio_c;
                $opp->instrumento_moratorio_c = $bean->ri_instrumento_moratorio_c;
                $opp->factor_moratorio_c = $bean->ri_factor_moratorio_c;
                $opp->cartera_descontar_c = $bean->ri_cartera_descontar_c;
                $opp->tasa_fija_ordinario_c = $bean->ri_tasa_fija_ordinario_c;
                $opp->tasa_fija_moratorio_c = $bean->ri_tasa_fija_moratorio_c;

                $opp->estatus_c = 'P';
                $opp->save();
				
				//CVV - 02/04/2016 - Actualiza el estatus de la linea de credito para indicar que esta siendo Ratificada
                $bean->tipo_de_operacion_c = 'RATIFICACION_INCREMENTO';

                /*try {

                    $query = "UPDATE opportunities_cstm
                                  SET tipo_de_operacion_c =   'RATIFICACION_INCREMENTO'
                                  WHERE id_c = '{$bean->id}'";
                    $queryResult = $db->query($query);
                } catch (Exception $e) {
                    error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Error: " . $e->getMessage());
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Error " . $e->getMessage());
                }*/
            }

        }

        /**
         * @file   opp_logic_hooks.php
         * @author Carlos Zaragoza Ortiz <czaragoza@legosoft.com.mx>
         * @date   12/8/2015 10:24 AM
         * @brief  Bitacora para seguimiento del cambio de estatus en Oportunidades
         * @var Opportunity $bean */
        public function bitacora_estatus($bean, $event, $args)
        {
            global $current_user, $db;

            //self::$fetchedRow[$bean->id] = $bean->fetched_row;
            try{
                if ( !empty($bean->id) ) {
                    $query_bitacora = "SELECT estatus, id_process from bt_bitacora_operaciones where guid_operacion='{$bean->id}' and secuencia = (SELECT MAX(secuencia) from bt_bitacora_operaciones where guid_operacion='{$bean->id}')";
                    $estatus_anterior = $db->query($query_bitacora);
                    while ($row = $db->fetchByAssoc($estatus_anterior)) {
                        $estatus = $row['estatus'];
                        $id_process = $row['id_process'];
                    }
                    if ($estatus !== $bean->estatus_c || $id_process !== $bean->id_process_c) {
                        $query = "SELECT (IF(MAX(secuencia) is null, 0, MAX(secuencia)))+1 as secuencia from bt_bitacora_operaciones where guid_operacion = '{$bean->id}'";
                        $maximo = $db->getOne($query);
                        $bitacora = BeanFactory::getBean('BT_Bitacora_Operaciones');
                        $bitacora->id = create_guid();
                        $bitacora->new_with_id = true;
                        $bitacora->guid_operacion = $bean->id;
                        $bitacora->secuencia = $maximo;
                        $bitacora->idsolicitud = $bean->idsolicitud_c;
                        $bitacora->id_process = $bean->id_process_c;
                        $bitacora->estatus = $bean->estatus_c;
                        $bitacora->save();
                    }
                }
            }catch (Exception $e){
                error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Error: " . $e->getMessage());
                $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Error " . $e->getMessage());
            }


        }

        public function creaBacklog($bean = null, $event = null, $args = null)
        {
            global $current_user;
            try {
				// CVV - El Backlog debe generar en solciitudes de linea nueva no R/I
                if ($bean->tipo_operacion_c == '1') {
			//		$GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Solicitud de credito, evalua creacion de Backlog: Producto=". print_r($bean->tipo_producto_c,1). " Tipo de linea=".print_r($bean->tipo_de_operacion_c),1);
                    if ($bean->tipo_producto_c == '1' && $bean->tipo_de_operacion_c =="LINEA_NUEVA") {
                        global $db;
						$GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Es linea nueva, Si el cliente ya tiene Backlogs registrados vigentes no se debe generar otro registro de Backlog");
						//CVV - Si el cliente ya tiene Backlogs registrados vigentes no se debe generar otro registro de Backlog
						$query = <<<SQL
SELECT lb.id 
FROM lev_backlog lb
WHERE lb.account_id_c = '{$bean->account_id}' 
AND lb.mes >= month(NOW()) -- Vigente
AND lb.anio >= year(NOW())
AND lb.deleted = 0
SQL;
$GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Valida Backlogs vigentes del cliente " . print_r($query,1));
                
				$queryResult = $db->query($query);
                if ($db->getRowCount($queryResult) > 0) {
                    return null;
                }
						
                $query = <<<SQL
SELECT lb.id FROM lev_backlog lb
INNER JOIN lev_backlog_opportunities_c lbo ON lbo.lev_backlog_opportunitieslev_backlog_idb = lb.id AND lbo.deleted = 0
INNER JOIN opportunities o ON o.id = lbo.lev_backlog_opportunitiesopportunities_ida AND o.deleted = 0
WHERE o.id = '{$bean->id}' AND lb.estatus_de_la_operacion = 'Activa'
AND lb.deleted = 0
ORDER BY lb.date_entered DESC LIMIT 1
SQL;

                        $queryResult = $db->getone($query);

                        if (!empty($queryResult)) {
                            $backlog = BeanFactory::retrieveBean('lev_Backlog', $queryResult);

                            if ($bean->mes_c != $backlog->mes || $bean->anio_c != $backlog->anio) {

                                if ($bean->mes_c > $backlog->mes) {
                                    $backlog->estatus_de_la_operacion = 'Enviada a otro mes';
                                    $backlog->monto_real_logrado = 0;
                                    $backlog->renta_inicial_comprometida = 0;
                                    $backlog->renta_inicial_real = 0;
                                    $backlog->save();

                                    $backlog_new = BeanFactory::getBean('lev_Backlog');
                                    $account = BeanFactory::retrieveBean('Accounts', $bean->account_id);
                                    $users = BeanFactory::retrieveBean('Users', $bean->assigned_user_id);

                                    $backlog_new->producto = $bean->tipo_producto_c;
                                    $backlog_new->region = $users->region_c;
                                    $backlog_new->equipo = $users->equipo_c;
                                    $backlog_new->mes = $bean->mes_c;
                                    $backlog_new->anio = $bean->anio_c;
                                    $backlog_new->lev_backlog_opportunitiesopportunities_ida = $bean->id;
                                    $backlog_new->account_id_c = $bean->account_id;
                                    $backlog_new->assigned_user_id = $bean->assigned_user_id;
                                    $backlog_new->monto_comprometido = $bean->amount;
                                    $backlog_new->monto_original = $bean->monto_c;
                                    $backlog_new->monto_real_logrado = 0;
                                    $backlog_new->renta_inicial_comprometida = $bean->ca_importe_enganche_c;
                                    $backlog_new->renta_inicial_real = 0;
                                    $backlog_new->etapa = $bean->estatus_c;
                                    $backlog_new->etapa_preliminar = $bean->estatus_c;
                                    $backlog_new->numero_de_solicitud = $bean->idsolicitud_c;

                                    $backlog_new->activo = $this->getActivos($bean);
                                    $backlog_new->estatus_de_la_operacion = 'Activa';
                                    $backlog_new->tipo_de_operacion = $this->getcurrentYearMonth($bean->mes_c, $bean->anio_c);
                                    if ($account->tipo_registro_c == "Prospecto") {
                                        $backlog_new->tipo = 'Prospecto';
                                    } elseif ($account->tipo_registro_c == "Cliente") {
                                        $backlog_new->tipo = 'Cliente';
                                    }
                                    $callApi = new UnifinAPI();
                                    $numeroDeFolio = $callApi->generarBacklogFolio();
                                    $backlog_new->numero_de_backlog = $numeroDeFolio;
                                    $backlog_new->name = 'BackLog ' . $backlog_new->mes . ' ' . $backlog_new->anio . ' - ' . $backlog_new->numero_de_backlog . ' - ' . $account->name; //BackLog Mes Año – FolioBacklog - Cliente
                                    $backlog_new->save();
                                } elseif ($bean->mes_c < $backlog->mes) {
                                    $backlog->deleted = 1;
                                    $backlog->save();

                                    $backlog_new = BeanFactory::getBean('lev_Backlog');
                                    $account = BeanFactory::retrieveBean('Accounts', $bean->account_id);
                                    $users = BeanFactory::retrieveBean('Users', $bean->assigned_user_id);

                                    $backlog_new->producto = $bean->tipo_producto_c;
                                    $backlog_new->region = $users->region_c;
                                    $backlog_new->equipo = $users->equipo_c;
                                    $backlog_new->mes = $bean->mes_c;
                                    $backlog_new->anio = $bean->anio_c;
                                    $backlog_new->lev_backlog_opportunitiesopportunities_ida = $bean->id;
                                    $backlog_new->account_id_c = $bean->account_id;
                                    $backlog_new->assigned_user_id = $bean->assigned_user_id;
                                    $backlog_new->monto_comprometido = $bean->amount;
                                    $backlog_new->monto_original = $bean->monto_c;
                                    $backlog_new->monto_real_logrado = 0;
                                    $backlog_new->renta_inicial_comprometida = $bean->ca_importe_enganche_c;
                                    $backlog_new->renta_inicial_real = 0;
                                    $backlog_new->etapa = $bean->estatus_c;
                                    $backlog_new->etapa_preliminar = $bean->estatus_c;
                                    $backlog_new->numero_de_solicitud = $bean->idsolicitud_c;

                                    $backlog_new->activo = $this->getActivos($bean);
                                    $backlog_new->estatus_de_la_operacion = 'Activa';
                                    $backlog_new->tipo_de_operacion = $this->getcurrentYearMonth($bean->mes_c, $bean->anio_c);
                                    if ($account->tipo_registro_c == "Prospecto") {
                                        $backlog_new->tipo = 'Prospecto';
                                    } elseif ($account->tipo_registro_c == "Cliente") {
                                        $backlog_new->tipo = 'Cliente';
                                    }

                                    $callApi = new UnifinAPI();
                                    $numeroDeFolio = $callApi->generarBacklogFolio();
                                    $backlog_new->numero_de_backlog = $numeroDeFolio;

                                    $backlog_new->name = 'BackLog ' . $backlog_new->mes . ' ' . $backlog_new->anio . ' - ' . $backlog_new->numero_de_backlog . ' - ' . $account->name; //BackLog Mes Año – FolioBacklog - Cliente
                                    $backlog_new->save();
                                }
                            } else {
                                //si solo cambio el estatus en la oportunidad, cambiamos la etapa en el backlog relacionado
                                $backlog->etapa = $bean->estatus_c;
                                $backlog->save();
                            }
                        } else {

                            $backlog = BeanFactory::getBean('lev_Backlog');
                            $account = BeanFactory::retrieveBean('Accounts', $bean->account_id);
                            $users = BeanFactory::retrieveBean('Users', $bean->assigned_user_id);

                            $backlog->producto = $bean->tipo_producto_c;
                            $backlog->region = $users->region_c;
                            $backlog->equipo = $users->equipo_c;
                            $backlog->mes = $bean->mes_c;
                            $backlog->anio = $bean->anio_c;
                            $backlog->lev_backlog_opportunitiesopportunities_ida = $bean->id;
                            $backlog->account_id_c = $bean->account_id;
                            $backlog->assigned_user_id = $bean->assigned_user_id;
                            $backlog->monto_comprometido = $bean->amount;
                            $backlog->monto_original = $bean->monto_c;
                            $backlog->monto_real_logrado = 0;
                            $backlog->renta_inicial_comprometida = $bean->ca_importe_enganche_c;
                            $backlog->renta_inicial_real = 0;
                            $backlog->etapa = $bean->estatus_c;
                            $backlog->etapa_preliminar = $bean->estatus_c;
                            $backlog->numero_de_solicitud = $bean->idsolicitud_c;
                            $backlog->activo = $this->getActivos($bean);

                            $backlog->estatus_de_la_operacion = 'Activa';

                            $backlog->tipo_de_operacion = $this->getcurrentYearMonth($bean->mes_c, $bean->anio_c);
                            if ($account->tipo_registro_c == "Prospecto") {
                                $backlog->tipo = 'Prospecto';
                            } elseif ($account->tipo_registro_c == "Cliente") {
                                $backlog->tipo = 'Cliente';
                            }

                            $callApi = new UnifinAPI();
                            $numeroDeFolio = $callApi->generarBacklogFolio();
                            $backlog->numero_de_backlog = $numeroDeFolio;
                            $backlog->name = 'BackLog ' . $backlog->mes . ' ' . $backlog->anio . ' - ' . $backlog->numero_de_backlog . ' - ' . $account->name; //BackLog Mes Año – FolioBacklog - Cliente
                            $backlog->save();
                        }
                    }
                }

            } catch (Exception $e) {
                $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " Error " . $e->getMessage());
            }
        }

        public function getcurrentYearMonth($mes, $anio){

            $currentYear = date("Y");
            $currentMonth = date("m");
            $currentDay = date("d");

            if($currentDay >= 20){
                $currentMonth += 1;
            }

            if($anio <= $currentYear){
                if($currentMonth == $mes){
                    $tipo_de_operacion =  "Adicional";
                }else{
                    $tipo_de_operacion = "Original";
                }
            }else{
                $tipo_de_operacion = "Original";
            }

           return $tipo_de_operacion;
        }

        public function condiciones_financieras($bean = null, $event = null, $args = null){
            $current_id_list = array();

            if($_REQUEST['module'] != 'Import' && $_SESSION['platform'] != 'unifinAPI' ) {
                //add update current records
                $activo_previo = array();
                foreach ($bean->condiciones_financieras as $c_financiera) {

                    $condicion = BeanFactory::getBean('lev_CondicionesFinancieras', $c_financiera['id']);
                    
                    $plazos = explode("_", $c_financiera['plazo']);

                    $condicion->name = $bean->name . " - " . $bean->idsolicitud_c;
                    $condicion->idsolicitud = $bean->idsolicitud_c;

                    $activo_previo[$c_financiera['idactivo']] += 1;
                    $condicion->consecutivo = $activo_previo[$c_financiera['idactivo']];

                    $condicion->idactivo = $c_financiera['idactivo'];
                    $condicion->plazo = $c_financiera['plazo'];
                    $condicion->plazo_minimo = $plazos[0];
                    $condicion->plazo_maximo = $plazos[1];
                    $condicion->tasa_minima = $c_financiera['tasa_minima'];
                    $condicion->tasa_maxima = $c_financiera['tasa_maxima'];
                    $condicion->vrc_minimo = $c_financiera['vrc_minimo'];
                    $condicion->vrc_maximo = $c_financiera['vrc_maximo'];
                    $condicion->vri_minimo = $c_financiera['vri_minimo'];
                    $condicion->vri_maximo = $c_financiera['vri_maximo'];
                    $condicion->comision_minima = $c_financiera['comision_minima'];
                    $condicion->comision_maxima = $c_financiera['comision_maxima'];
                    $condicion->renta_inicial_minima = $c_financiera['renta_inicial_minima'];
                    $condicion->renta_inicial_maxima = $c_financiera['renta_inicial_maxima'];
                    $condicion->deposito_en_garantia = $c_financiera['deposito_en_garantia'];
                    $condicion->uso_particular = $c_financiera['uso_particular'];
                    $condicion->uso_empresarial = $c_financiera['uso_empresarial'];
                    $condicion->activo_nuevo = $c_financiera['activo_nuevo'];
                    $condicion->lev_condicionesfinancieras_opportunitiesopportunities_ida = $bean->id;
                    $condicion->assigned_user_id = $bean->assigned_user_id;
                    $condicion->team_id = $bean->team_id;
                    $condicion->team_set_id = $bean->team_set_id;

                    //add current records ids to list
                    $current_id_list[] = $condicion->save();
                }
                //retrieve all related records
                $bean->load_relationship('lev_condicionesfinancieras_opportunities');
                foreach ($bean->lev_condicionesfinancieras_opportunities->getBeans() as $c_financiera) {
                    if (!in_array($c_financiera->id, $current_id_list)) {
                        $c_financiera->mark_deleted($c_financiera->id);
                    }
                }
            }
        }
		
		public function AsignaCondicionesFinancieras($bean = null, $event = null, $args = null){
            //Asigna el rpimer registro del control de condiciones financieras para envíar a solicitud de UNI2
			if (count($bean->condiciones_financieras) > 0 and $bean->tipo_producto_c != '4'){
                //$bean->id_activo_c = $bean->condiciones_financieras[0][''];
                $bean->index_activo_c = $bean->condiciones_financieras['0']['idactivo'];
                $GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <> :CVV Contenido en campo plazo para la CF  - " . print_r($bean->condiciones_financieras['0']['plazo'], true));
                $plazos = explode("_", $bean->condiciones_financieras['0']['plazo']);
                $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." CVV - Plazo que se asignara". print_r( $plazos[1], true));
                $bean->plazo_c = $plazos[1];
                $bean->es_multiactivo_c = 1;
                $bean->ca_tasa_c = $bean->condiciones_financieras['0']['tasa_minima'];
                $bean->deposito_garantia_c = $bean->condiciones_financieras['0']['deposito_en_garantia'];
                $bean->porcentaje_ca_c = $bean->condiciones_financieras['0']['comision_minima'];
                $bean->porcentaje_renta_inicial_c = $bean->condiciones_financieras['0']['renta_inicial_minima'];
                $bean->vrc_c = $bean->condiciones_financieras['0']['vrc_minimo'];
                $bean->vri_c = $bean->condiciones_financieras['0']['vri_minimo'];

                //Obtiene la lista de activo para guardar multiactivos
                global $app_list_strings;
                $activos = array();
                $multiactivo_c = array();
                if (isset($app_list_strings['idactivo_list'])){
                    $activos = $app_list_strings['idactivo_list'];
                }

                //Arma lista de activos
                foreach ($bean->condiciones_financieras as $condicion) {
                    foreach($activos as $key=>$value){
                        if($key == $condicion['idactivo']){
                            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." CVV - Agregar item a multiactivo: ". print_r($key, true));
                            if (!in_array($value, $multiactivo_c)) {
                                $multiactivo_c[] = $value;
                            }
                        }
                    }
                }

                $bean->multiactivo_c = implode(",", $multiactivo_c);
                //$bean->multiactivo_c  = 'AUTOS,OTROS';
                $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." CVV - Contenido de multiactivo: ". print_r($bean->multiactivo_c, true));
            }
        }

        public function condiciones_financieras_incremento_ratificacion($bean = null, $event = null, $args = null){
            $current_id_list = array();

            if($_REQUEST['module'] != 'Import' && $_SESSION['platform'] != 'unifinAPI' ) {

                if($bean->ratificacion_incremento_c == 1) {
                    //add update current records
                    $activo_previo = array();
                    foreach ($bean->condiciones_financieras_incremento_ratificacion as $c_financiera) {

                        $condicion = BeanFactory::getBean('lev_CondicionesFinancieras', $c_financiera['id']);
                        $plazos = explode("_", $c_financiera['plazo']);
                        if($condicion->incremento_ratificacion == 1) {

                            $activo_previo[$c_financiera['idactivo']] += 1;
                            $condicion->consecutivo = $activo_previo[$c_financiera['idactivo']];
                            $condicion->name = $bean->name . " - " . $bean->idsolicitud_c;
                            $condicion->idsolicitud = $bean->idsolicitud_c;
                            $condicion->incremento_ratificacion = 1;
                            $condicion->idactivo = $c_financiera['idactivo'];
                            $condicion->plazo = $c_financiera['plazo'];
                            $condicion->plazo_minimo = $plazos[0];
                            $condicion->plazo_maximo = $plazos[1];
                            $condicion->tasa_minima = $c_financiera['tasa_minima'];
                            $condicion->tasa_maxima = $c_financiera['tasa_maxima'];
                            $condicion->vrc_minimo = $c_financiera['vrc_minimo'];
                            $condicion->vrc_maximo = $c_financiera['vrc_maximo'];
                            $condicion->vri_minimo = $c_financiera['vri_minimo'];
                            $condicion->vri_maximo = $c_financiera['vri_maximo'];
                            $condicion->comision_minima = $c_financiera['comision_minima'];
                            $condicion->comision_maxima = $c_financiera['comision_maxima'];
                            $condicion->renta_inicial_minima = $c_financiera['renta_inicial_minima'];
                            $condicion->renta_inicial_maxima = $c_financiera['renta_inicial_maxima'];
                            $condicion->deposito_en_garantia = $c_financiera['deposito_en_garantia'];
                            $condicion->uso_particular = $c_financiera['uso_particular'];
                            $condicion->uso_empresarial = $c_financiera['uso_empresarial'];
                            $condicion->activo_nuevo = $c_financiera['activo_nuevo'];
                            $condicion->lev_condicionesfinancieras_opportunitiesopportunities_ida = $bean->id;
                            $condicion->assigned_user_id = $bean->assigned_user_id;
                            $condicion->team_id = $bean->team_id;
                            $condicion->team_set_id = $bean->team_set_id;

                            //add current records ids to list
                            $current_id_list[] = $condicion->save();

                        }else if($condicion->incremento_ratificacion == 0){

                            $new_condicion = BeanFactory::getBean('lev_CondicionesFinancieras');
                            $activo_previo[$c_financiera['idactivo']] += 1;
                            $new_condicion->consecutivo = $activo_previo[$c_financiera['idactivo']];
                            $new_condicion->name = $bean->name . " - " . $bean->idsolicitud_c;
                            $new_condicion->idsolicitud = $bean->idsolicitud_c;
                            $new_condicion->incremento_ratificacion = 1;
                            $new_condicion->idactivo = $c_financiera['idactivo'];
                            $new_condicion->plazo = $c_financiera['plazo'];
                            $new_condicion->plazo_minimo = $plazos[0];
                            $new_condicion->plazo_maximo = $plazos[1];
                            $new_condicion->tasa_minima = $c_financiera['tasa_minima'];
                            $new_condicion->tasa_maxima = $c_financiera['tasa_maxima'];
                            $new_condicion->vrc_minimo = $c_financiera['vrc_minimo'];
                            $new_condicion->vrc_maximo = $c_financiera['vrc_maximo'];
                            $new_condicion->vri_minimo = $c_financiera['vri_minimo'];
                            $new_condicion->vri_maximo = $c_financiera['vri_maximo'];
                            $new_condicion->comision_minima = $c_financiera['comision_minima'];
                            $new_condicion->comision_maxima = $c_financiera['comision_maxima'];
                            $new_condicion->renta_inicial_minima = $c_financiera['renta_inicial_minima'];
                            $new_condicion->renta_inicial_maxima = $c_financiera['renta_inicial_maxima'];
                            $new_condicion->deposito_en_garantia = $c_financiera['deposito_en_garantia'];
                            $new_condicion->uso_particular = $c_financiera['uso_particular'];
                            $new_condicion->uso_empresarial = $c_financiera['uso_empresarial'];
                            $new_condicion->activo_nuevo = $c_financiera['activo_nuevo'];
                            $new_condicion->lev_condicionesfinancieras_opportunitiesopportunities_ida = $bean->id;
                            $new_condicion->assigned_user_id = $bean->assigned_user_id;
                            $new_condicion->team_id = $bean->team_id;
                            $new_condicion->team_set_id = $bean->team_set_id;

                            //add current records ids to list
                            $current_id_list[] = $new_condicion->save();
                        }
                    }

                    //retrieve all related records
                    $bean->load_relationship('lev_condicionesfinancieras_opportunities');
                    foreach ($bean->lev_condicionesfinancieras_opportunities->getBeans() as $c_financiera) {
                        if($c_financiera->incremento_ratificacion == 1) {
                            if (!in_array($c_financiera->id, $current_id_list)) {
                                $c_financiera->mark_deleted($c_financiera->id);
                            }
                        }
                    }
                }
            }
        }

        public function getActivos($bean){
            $activos = array();
            foreach ($bean->condiciones_financieras as $c_financiera) {
                $activos[$c_financiera['idactivo']] = "^" . $c_financiera['idactivo'] . "^";
            }
            $activos = implode(",", $activos);
            return $activos;
        }
    }
