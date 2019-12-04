<?php

    /**
     * @file   opp_logic_hooks.php
     * @author trobinson@levementum.com
     * @date   6/3/2015 1:07 PM
     * @brief  opportunity logic hooks
     */
        require_once("custom/Levementum/UnifinAPI.php");
		require_once('include/SugarQuery/SugarQuery.php');

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

		function buscaDuplicados($bean, $event, $arguments)
		{
			if(empty($bean->fetched_row['id']))
			{
				global $db;
				$cliente = $bean->account_id;
				$tipo = $bean->tipo_producto_c;
				$query = "select count(*) as total from opportunities a, opportunities_cstm b, accounts_opportunities c where a.id = b.id_c and a.id = c.opportunity_id and a.deleted = 0 and c.account_id = '$cliente' and b.tct_etapa_ddw_c = 'SI' and isnull(b.estatus_c) and b.tipo_producto_c = '$tipo'";
				$result = $db->query($query);
				$row = $db->fetchByAssoc($result);
				$count = $row['total'];
				if($count > 0)
				{
					require_once 'include/api/SugarApiException.php';
					throw new SugarApiExceptionInvalidParameter("No puede guardar la presolicitud, existe una abierta para el mismo cliente");
				}
			}
		}

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
                    //$GLOBALS['log']->fatal(" <".$current_user->user_name."> :$aTeam->name : $aTeam->id");
                    $new_team_ids[] = $aTeam->id;
                }
                //set team id's for opp
                $bean->teams->replace($new_team_ids);
            }
        }

		 public function crearFolioSolicitud($bean = null, $event = null, $args = null)
        {

			      //Operaciones de solicitud de crédito
            //Recupera cuenta
            $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id);

            if(($bean->idsolicitud_c == 0 || empty($bean->idsolicitud_c)) && $bean->tipo_operacion_c == 1) {
                $GLOBALS['log']->fatal('>>>>>>>la funcion crearFolioSolici.... ha sido ejecutada<<<<<<<' );
                $callApi = new UnifinAPI();
                if($bean->canal_c == 1){
                    $numeroDeFolio = $bean->idsolicitud_c;
                }
                else{
                    $numeroDeFolio = $callApi->generarFolios(2);
                    $bean->idsolicitud_c = $numeroDeFolio;
                }
                if($bean->tct_etapa_ddw_c=='SI') {//@jesus
                    $bean->name = "PRE - SOLICITUD " . $numeroDeFolio . " - " . $beanCuenta->name;
                }else{
                    if($bean->tipo_de_operacion_c != "RATIFICACION_INCREMENTO"){
                        $bean->name = "SOLICITUD " . $numeroDeFolio . " - " . $beanCuenta->name;

                    }else{
                        $bean->name = "SOL. " . $numeroDeFolio . " - " . $bean->name;
                    }

                }
            }elseif ($bean->tct_etapa_ddw_c!='SI'){
                $bean->name = str_replace("PRE - ","",$bean->name) ;
            }
            /* @Jesus Carrillo
             Convertir a prospecto  interesado , si la cuenta inicial es prospecto
             */
            //$beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id);
            if($beanCuenta->tipo_registro_c=='Prospecto' && $beanCuenta->subtipo_cuenta_c == 'Contactado'){
                $beanCuenta->subtipo_cuenta_c='Interesado';
                $beanCuenta->save();
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
         }*/

		// CVV - 28/03/2016 - El modulo de Forecast fue deshabilitado
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
        }
    }

    /*
     * UNI406 4. Cuando existe un cliente con operaciones vigentes y en el panel de “operaciones” presiona el “+” para agregar una nueva solicitud,
     * lo deberá dirigir a la pantalla de nueva oportunidad para capturar los campos requeridos y en cuanto le de guardar,
     * debe crear la oportunidad e invocar el servicio de consulta folio solicitud y el servicio de integración de expediente en el BPM.
    */
    function creaSolicitud($bean = null, $event = null, $args = null)
    {
        global $db, $current_user;

        //$GLOBALS['log']->fatal('-Update: '. $args['isUpdate'] . '--Etapa: ' . $bean->tct_etapa_ddw_c);
        if(($args['isUpdate']==1 && $bean->tct_etapa_ddw_c=='SI' && $bean->tipo_producto_c !='6') || $bean->tipo_producto_c =='3' || $bean->tipo_producto_c =='7' || $bean->tipo_de_operacion_c == 'RATIFICACION_INCREMENTO'){//@jesus
            if (($bean->id_process_c == 0 || $bean->id_process_c == null || empty($bean->id_process_c))/* && $bean->estatus_c == 'P' */ && $bean->tipo_operacion_c == '1') {
            //Hay operaciones vigentes?
            // ** JSR INICIO
            $GLOBALS['log']->fatal('Entra creación de solicitud');
            $query = <<<SQL
			SELECT aop.account_id,aop.opportunity_id, oppc.estatus_c, oppc.monto_c, oppc.idsolicitud_c,
    acstm.idcliente_c,ac.name as nombre_cliente,  acstm.riesgo_c as riesgo,acstm.tipodepersona_c as tipo_persona,
    email_addresses.email_address as correo,acstm.lista_negra_c, acstm.pep_c, oppc.activo_c, oppc.id_activo_c,
    oppc.index_activo_c, oppc.plazo_c, oppc.enviar_por_correo_c, oppc.tipo_de_operacion_c, oppc.sub_activo_c, oppc.tipo_producto_c,
    f_aforo_c, f_tipo_factoraje_c, f_comentarios_generales_c, f_documento_descontar_c, usuario_bo_c, opp.amount, uu.user_name, oppc.ca_importe_enganche_c, oppc.ca_pago_mensual_c,
    oppc.ca_tasa_c, oppc.ca_valor_auto_iva_c, oppc.idcot_bpm_c, oppc.id_linea_credito_c, oppc.es_multiactivo_c, oppc.multiactivo_c,
    oppc.porcentaje_ca_c, oppc.vrc_c, oppc.vri_c, oppc.deposito_garantia_c, oppc.porcentaje_renta_inicial_c, oppc.ratificacion_incremento_c, oppc.porciento_ri_c,
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
						accounts_cstm acstm ON acstm.id_c = aop.account_id and acstm.tipo_registro_c in ('Prospecto','Cliente')
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
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : ** JSR ** DATOS DE LA OPERACION " . print_r($row, true));
            $callApi = new UnifinAPI();
            $solicitudCreditoResultado = $callApi->obtenSolicitudCredito($row);
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . "  <" . $current_user->user_name . "> : Opportunity({$bean->id_process_c}) changed to Integracion de Expediente ");
            try {
                $bean->id_process_c = $solicitudCreditoResultado['processInstanceId'];
                $process_id = $solicitudCreditoResultado['processInstanceId'];
                $query = "UPDATE opportunities_cstm
                              SET id_process_c =  '$process_id'
                              WHERE id_c = '{$bean->id}'";
                $queryResult = $db->query($query);
                /*Preguntar sobre el tipo de producto Leasing para la creacion de SOS
                  Línea con monto mayor/igual a 7.5 millones & Línea Leasing con id proceso
                */
              if ($bean->tipo_producto_c==1 && $bean->monto_c >= 7500000 && !empty($bean->id_process_c)){
                //Manda a llamar a la funcion solicitudSOS para la generacion de la copia de la linea SOS con Leasing
                    OpportunityLogic::solicitudSOS($bean);
                }
                if ($bean->id_process_c != 0 && $bean->id_process_c != null && $bean->id_process_c != "-1" && $bean->id_process_c != "" && $bean->tipo_producto_c != 4) {
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . "  <" . $current_user->user_name . "> : Despues de generar Process debe actualizarse la lista de condiciones financieras ");
                    $callApi->actualizaSolicitudCredito($bean);
                }
            } catch (Exception $e) {
                error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Error: " . $e->getMessage());
                $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Error " . $e->getMessage());
            }
        }
        }else{
            $GLOBALS['log']->fatal('------------------>Se cancelo peticion a Uni2<------------------');
        }
            //CVV se manda a llamar la funcion de actualizar la solicitud de UNICS
            //$callApi2 = new UnifinAPI();
            //$callApi2->actualizaSolicitudCredito($bean);
    }

        public function creaRatificacion($bean = null, $event = null, $args = null){
            global $current_user;
            $_REQUEST['crea_ratificacion'] += 1;
            if($bean->ratificacion_incremento_c==1 && $bean->tipo_operacion_c == '2' && $bean->tipo_de_operacion_c == 'LINEA_NUEVA'){
                // CVV - 30/03/2016 - Crea una nueva operacion para la solicitud de R/I
                $opp = BeanFactory::getBean('Opportunities');

                //Asignamos el ejecutivo actual a la nueva solicitud
                $account = BeanFactory::retrieveBean('Accounts', $bean->account_id);
                switch ($bean->tipo_producto_c) {
                    case '1':
                        $opp->assigned_user_id = $account->user_id_c;
                        break;
                    case '3':
                        $opp->assigned_user_id = $account->user_id2_c;
                        break;
                    case '4':
                        $opp->assigned_user_id = $account->user_id1_c;
                        break;
                    default:
                        $opp->assigned_user_id = $account->user_id_c;
                }

                // Generales de la operación
                $opp->name = " R/I " . $bean->name;
                //author: Salvador Lopez
                //La operación nueva debe nacer como "INTEGRACIÓN DE EXPEDIENTE" Y "EN ESPERA"
                $opp->tct_etapa_ddw_c="P";//Integración de Expediente
                $opp->estatus_c="PE";//En Espera

                $opp->monto_c = $bean->monto_ratificacion_increment_c + $bean->monto_c;
                $opp->amount = $bean->monto_ratificacion_increment_c + $bean->amount;
                $opp->monto_ratificacion_increment_c = $bean->monto_ratificacion_increment_c;
                $opp->account_id = $bean->account_id;
                $opp->tipo_producto_c = $bean->tipo_producto_c;
                $opp->tipo_de_operacion_c = 'RATIFICACION_INCREMENTO';
                $opp->opportunities_opportunities_1opportunities_ida = $bean->id;
                //$opp->assigned_user_id = $bean->assigned_user_id;
                $opp->usuario_bo_c = $bean->ri_usuario_bo_c;
                $opp->id_linea_credito_c = $bean->id_linea_credito_c;
                $opp->f_comentarios_generales_c = $bean->f_comentarios_generales_c;
                $opp->ca_pago_mensual_c = $bean->ca_pago_mensual_c;

                //AF - 16/03/2018 - Cambio de porcentaje de renta incial: Hereda valor de la línea nueva y no de condiciones financieras
                $opp->porciento_ri_c = $bean->porciento_ri_c;
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
                    //$GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." CVV - Plazo que se asignara". print_r( $plazos[1], true));
                    $opp->plazo_c = $plazos[1];
                    $opp->es_multiactivo_c = 1;
                    $opp->ca_tasa_c = $bean->condiciones_financieras_incremento_ratificacion['0']['tasa_minima'];
                    $opp->deposito_garantia_c = $bean->condiciones_financieras_incremento_ratificacion['0']['deposito_en_garantia'];
                    $opp->porcentaje_ca_c = $bean->condiciones_financieras_incremento_ratificacion['0']['comision_minima'];
                    $opp->porcentaje_renta_inicial_c = $bean->condiciones_financieras_incremento_ratificacion['0']['renta_inicial_minima'];
                    //$opp->porciento_ri_c = $bean->condiciones_financieras_incremento_ratificacion['0']['renta_inicial_minima'];
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
                                if (!in_array($value, $multiactivo_c)) {
                                    $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." CVV - Agregar item a multiactivo de R/I: ". print_r($key, true));
                                    $multiactivo_c[] = $value;
                                }
                            }
                        }
                    }

                    $opp->multiactivo_c = implode(",", $multiactivo_c);
                    $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." CVV - Contenido de multiactivo de R/I: ". print_r($opp->multiactivo_c, true));

                }
                if ($bean->tipo_producto_c == '4'){
                    $opp->plazo_c = $bean->plazo_c;
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

                //$opp->estatus_c = 'P';
                //Copia el listado de condiciones financieras para la nueva solicitud
                $opp->condiciones_financieras = $bean->condiciones_financieras_incremento_ratificacion;
                foreach ($opp->condiciones_financieras as $index => $c_financiera) {
                    unset($c_financiera['id']);
                    unset($c_financiera['lev_condicionesfinancieras_opportunitiesopportunities_ida']);
                    $c_financieras[$index] = $c_financiera;
                }

                $opp->condiciones_financieras = $c_financieras;
                $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> Condiciones en nueva solicitud : " . print_r(count($opp->condiciones_financieras),1));
                $id = $opp->save();

                //CVV - 02/04/2016 - Actualiza el estatus de la linea de credito para indicar que esta siendo Ratificada
                //$bean->tipo_de_operacion_c = 'RATIFICACION_INCREMENTO';
            }
        }

        public function setEtapaSubetapa($bean = null, $event = null, $args = null){

            global $app_list_strings, $db;

            //Generar consulta a BD
            $query_estatus_c = "SELECT estatus_c from opportunities_cstm where id_c='{$bean->id}'";
            $estatus_c_db = $db->query($query_estatus_c);
            while ($row = $db->fetchByAssoc($estatus_c_db)) {
                if($row['estatus_c'] == 'P' && $bean->estatus_c == 'PE'){
                    $update_estatus_c_pe = "update opportunities_cstm set estatus_c = 'PE' where id_c = '".$bean->id."'";
                    $result_update = $db->query($update_estatus_c_pe);
                }
            }


            $etapa="";
            $subetapa="";
            if (isset($app_list_strings['tct_etapa_ddw_c_list'])){

                $etapa = $app_list_strings['tct_etapa_ddw_c_list'][$bean->tct_etapa_ddw_c];
            }
            if (isset($app_list_strings['estatus_c_operacion_list'])){

                $subetapa = $app_list_strings['estatus_c_operacion_list'][$bean->estatus_c];
            }

            //Obtener etiquetas
            $bean->tct_estapa_subetapa_txf_c=trim($etapa) ." ".trim($subetapa);
            //Actualiza BD
            $query = "update opportunities_cstm set tct_estapa_subetapa_txf_c = '".trim($bean->tct_estapa_subetapa_txf_c)."' where id_c = '".$bean->id."'";
            $queryResult = $db->query($query);

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
                if ($bean->tipo_operacion_c == '1') {
			        // CVV - El Backlog solo debe generarse en solicitudes de linea nueva no R/I (leasing)
                    if ($bean->tipo_producto_c == '1' && $bean->tipo_de_operacion_c =="LINEA_NUEVA") {
                        global $db;
						//Si la Opp ya esta ligada a un BL se actualiza la información
                        $query = <<<SQL
SELECT lb.id FROM lev_backlog lb
INNER JOIN lev_backlog_opportunities_c lbo ON lbo.lev_backlog_opportunitieslev_backlog_idb = lb.id AND lbo.deleted = 0
INNER JOIN opportunities o ON o.id = lbo.lev_backlog_opportunitiesopportunities_ida AND o.deleted = 0
WHERE o.id = '{$bean->id}'
AND lb.deleted = 0
ORDER BY lb.date_entered DESC LIMIT 1
SQL;

                        $queryResult = $db->getone($query);

                        if (!empty($queryResult)) {
                            //CVV - Los Backlogs ya no se ligaran a una Solicitud de crédito
                            /*
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
                                    $backlog_new->etapa = $this->backlogEtapa($bean->estatus_c);
                                    $backlog_new->etapa_preliminar = $this->backlogEtapa($bean->estatus_c);
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
                                    $backlog_new->etapa = $this->backlogEtapa($bean->estatus_c);
                                    $backlog_new->etapa_preliminar = $this->backlogEtapa($bean->estatus_c);
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
                                $backlog->etapa = $this->backlogEtapa($bean->estatus_c);
                                $backlog->save();
                            }*/
                        }else {
                            //CVV - Si la solicitud no tiene BL, revisamos si el cliente tiene Backlogs vigentes
                            // Si el cliente ya tiene Backlogs registrados para el mes, no se debe generar otro registro de Backlog.
                            //Si tiene BL, validar que corresponda al mes de la solicitud, en caso de corresponder y no estar asociado a una SC, ligar a la Opp
                            $query = <<<SQL
SELECT lb.id
FROM lev_backlog lb
WHERE lb.account_id_c = '{$bean->account_id}'
AND lb.mes >= month(NOW()) -- Vigente
AND lb.anio >= year(NOW())
AND lb.deleted = 0
SQL;
                            //$GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> La solicitud NO tiene BL, revisamos si el cliente tiene Backlogs vigentes :" . print_r($query,1));
                            $queryResult = $db->query($query);
                            if ($db->getRowCount($queryResult) > 0) {
                                //CVV - Si el cliente tiene Backlogs vigentes, validar que se tenga algun BL para el mismo mes de la Solicitud, en caso de tener debe asociarse dicho BL a la Solicitud
                                $query = <<<SQL
                                select op.id_c, op.idsolicitud_c, lb.id, lb.mes
from opportunities_cstm op
INNER JOIN accounts_opportunities acc on acc.opportunity_id = op.id_c
INNER JOIN lev_backlog lb on lb.account_id_c = acc.account_id
LEFT OUTER JOIN lev_backlog_opportunities_c bop on bop.lev_backlog_opportunitieslev_backlog_idb = lb.id
where op.id_c = '{$bean->id}'
and lb.mes = op.mes_c
and lb.anio = op.anio_c
and bop.lev_backlog_opportunitiesopportunities_ida is null
order by lb.mes asc limit 1
SQL;
                                //$GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Si el cliente tiene Backlogs vigentes, validar que se tenga algun BL para el mismo mes de la Solicitud, en caso de tener debe asociarse dicho BL a la Solicitud: ". print_r($query,1));
                                $queryResult = $db->query($query);
                                // CVV - Si se tiene un Backlog disponible (del mismo cliente,para el mes/año de la SC y sin SC asociada, Se asocia a la solicitud

                                if ($db->getRowCount($queryResult) > 0) {
                                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Si existen BL disponibles");
                                    while ($row = $db->fetchByAssoc($queryResult)) {
                                        //Actualiza el Backlog (etapa y numero_de_solicitud)
                                        $query2 = "update lev_backlog set numero_de_solicitud = '{$row['idsolicitud_c']}' where id = '{$row['id']}'";
                                        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Se actualiza el Backlog que se asociara ". print_r($query2,1));
                                        $queryResult = $db->query($query2);

                                        //Inserta la relacion para ligar el BL a la Opp
                                        $query2 = "INSERT INTO lev_backlog_opportunities_c
                             (id, date_modified, deleted, lev_backlog_opportunitiesopportunities_ida, lev_backlog_opportunitieslev_backlog_idb)
                              VALUES (UUID(), NOW(), 0, '{$row['id_c']}', '{$row['id']}')";
                                        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Se inserta la relacion ". print_r($query2,1));
                                        $queryResult = $db->query($query2);
                                    }
                                }
                            }else{
                                // CVV - Si el cliente no tiene ningun BL, inserta uno nuevo
                                // Obtiene el monto disponible de las lineas de credito de Leasing
                                $query3 = "Select IFNULL(sum(op.amount),0) as Disponible
                                from Opportunities op
                                INNER JOIN opportunities_cstm cs on cs.id_c = op.id and cs.tipo_producto_c = 1 and tipo_operacion_c = 2
                                INNER JOIN accounts_opportunities accop on op.id = accop.opportunity_id
                                where accop.account_id = '{$bean->account_id}'";

                                $Disponible = $db->getOne($query3);

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
                                $backlog->monto_original = $Disponible;
                                $backlog->monto_real_logrado = 0;
                                $backlog->renta_inicial_comprometida = $bean->ca_importe_enganche_c;
                                $backlog->renta_inicial_real = 0;
                                $backlog->etapa = $this->backlogEtapa($bean->estatus_c);
                                $backlog->etapa_preliminar = $this->backlogEtapa($bean->estatus_c);
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
                if (!empty($bean->condiciones_financieras)){
                    //add update current records
                    $activo_previo = array();
                    // $GLOBALS['log']->fatal('--->TCT -  Condiciones financieras');
                    // $GLOBALS['log']->fatal($bean->condiciones_financieras);

                    foreach ($bean->condiciones_financieras as $c_financiera) {

                        $condicion = BeanFactory::getBean('lev_CondicionesFinancieras', $c_financiera['id']);

                        $plazos = explode("_", $c_financiera['plazo']);

                        $condicion->name = $bean->name . " - " . $bean->idsolicitud_c;
                        $condicion->idsolicitud = $bean->idsolicitud_c;

                        $activo_previo[$c_financiera['idactivo']] += 1;
                        $condicion->consecutivo = $activo_previo[$c_financiera['idactivo']];

                        //CVV Copia el id en caso de tener para no marcar todos los registros como deleted
                        $condicion->id = $c_financiera['id'];
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
                        $condicion->incremento_ratificacion = 0;

                        $GLOBALS['log']->fatal('Imprime idactivo petición: '. $c_financiera['idactivo']);
                        $GLOBALS['log']->fatal('Imprime idactivo bean: '.$condicion->idactivo);
                        //add current records ids to list
                        $current_id_list[] = $condicion->save();
                        $GLOBALS['log']->fatal('--->TCT -  Current_id_lst');
                        $GLOBALS['log']->fatal(print_r($current_id_list,true));

                    }
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <Arreglo que se asignará a la Opp> " . print_r($current_id_list,1));
                    //$GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <Arreglo que se compara> " . print_r($bean->lev_condicionesfinancieras_opportunities->getBeans(),1));

                    //retrieve all related records
                    $bean->load_relationship('lev_condicionesfinancieras_opportunities');
                    foreach ($bean->lev_condicionesfinancieras_opportunities->getBeans() as $c_financiera) {
                        if (!in_array($c_financiera->id, $current_id_list)) {
                            // $GLOBALS['log']->fatal('--->TCT -  Elimina relación');
                            // $GLOBALS['log']->fatal($c_financiera->id);
                            $c_financiera->mark_deleted($c_financiera->id);
                        }
                    }
                }
            }
        }

		public function AsignaCondicionesFinancieras($bean = null, $event = null, $args = null){
            //Asigna el rpimer registro del control de condiciones financieras para envíar a solicitud de UNI2
			if (count($bean->condiciones_financieras) > 0 and $bean->tipo_producto_c != '4'){
                $plazo_historico = $bean->plazo_c;
                //$bean->id_activo_c = $bean->condiciones_financieras[0][''];
                $bean->index_activo_c = $bean->condiciones_financieras['0']['idactivo'];
                $plazos = explode("_", $bean->condiciones_financieras['0']['plazo']);
                $bean->plazo_c = empty($plazos[1])? $plazo_historico : $plazos[1];
                $bean->es_multiactivo_c = 1;
                $bean->ca_tasa_c = $bean->condiciones_financieras['0']['tasa_minima'];
                $bean->deposito_garantia_c = $bean->condiciones_financieras['0']['deposito_en_garantia'] ? $bean->condiciones_financieras['0']['deposito_en_garantia'] : 0;
                $bean->porcentaje_ca_c = empty($bean->condiciones_financieras['0']['comision_minima'])? 0 : $bean->condiciones_financieras['0']['comision_minima'];
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
                // CVV Si la Opperación es ratificación de producto diferente de Factoraje
                if($bean->ratificacion_incremento_c == 1 && $bean->tipo_producto_c != 4 ) {
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
                    if (!empty($bean->condiciones_financieras)){
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
        }

        public function getActivos($bean)
        {
            $activos = array();
            foreach ($bean->condiciones_financieras as $c_financiera) {
                $activos[$c_financiera['idactivo']] = "^" . $c_financiera['idactivo'] . "^";
            }
            $activos = implode(",", $activos);
            return $activos;
        }

        public function backlogEtapa($estatus){
            $etapa = '';
            if($estatus == 'N' ||  $estatus == 'CZ' || $estatus == 'SL' || $estatus == 'OC' || $estatus == 'CT' || $estatus == 'LB' || $estatus == 'CA' || $estatus == 'AL' || $estatus == 'T'){
                $etapa = 'Autorizada';
            }
            if($estatus == 'K'){
                $etapa = 'Cancelada';
            }
            if($estatus == 'E' ||  $estatus == 'D' || $estatus == 'BC' || $estatus == 'EF' || $estatus == 'SC' || $estatus == 'RF' || $estatus == 'CC'){
                $etapa = 'Credito';
            }
            if($estatus == 'P' ||  $estatus == 'OP' || $estatus == 'DP'){
                $etapa = 'Prospecto';
            }
            if($estatus == 'R' ||  $estatus == 'CM'){
                $etapa = 'Rechazada';
            }
            return $etapa;
        }

        public function actualizatipoprod($bean = null, $event = null, $args = null){
            global $db;
            global $app_list_strings; //Obtención de listas de valores
            $tipo = $app_list_strings['tipo_registro_list']; //obtencion lista tipo de registro
            $subtipo = $app_list_strings['subtipo_cuenta_list'];  //Obtiene lista de los subtipos de cuenta

            $cliente = $bean->account_id; //ID de la Cuenta
            $GLOBALS['log']->fatal('Entra a Crear Resumen de Account ');
            $bean_Resumen = BeanFactory::retrieveBean('tct02_Resumen',$cliente);

            $producto= $bean->tipo_producto_c;
            $etapa=$bean->tct_etapa_ddw_c;
            $subetapa= $bean->estatus_c;
            //Condiciones para actualizar los tipos de Prospecto
            $GLOBALS['log']->fatal($bean->fetched_row[tct_etapa_ddw_c]);
            //Actualiza en Solicitud Inicial y actualiza campos con valor Prospecto Interesado
            $GLOBALS['log']->fatal('Valida solicitud inicial');
            if($etapa=="SI" && $bean->fetched_row[tct_etapa_ddw_c]!= $etapa){
                $GLOBALS['log']->fatal('Declara Prospecto Interesado');
                $etitipo = $tipo["Prospecto"];      //Obtiene el valor del campo obtenido de la lista con Etiqueta
                 $etisubtipo = $subtipo["Interesado"]; //Obtiene el valor del campo obtenido de la lista con Etiqueta
                 switch ($producto) {
                     case '1':
                         if($bean_Resumen->tct_tipo_l_txf_c=="Prospecto") {
                             $bean_Resumen->tct_tipo_l_txf_c = "Prospecto";
                             $bean_Resumen->tct_subtipo_l_txf_c = "Interesado";
                             $bean_Resumen->tct_tipo_cuenta_l_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                         }
                         break;
                     case '3':
                         if($bean_Resumen->tct_tipo_ca_txf_c=="Prospecto") {
                             $bean_Resumen->tct_tipo_ca_txf_c = "Prospecto";
                             $bean_Resumen->tct_subtipo_ca_txf_c = "Interesado";
                             $bean_Resumen->tct_tipo_cuenta_ca_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                         }
                         break;
                     case '4':
                         if($bean_Resumen->tct_tipo_f_txf_c=="Prospecto") {
                             $bean_Resumen->tct_tipo_f_txf_c = "Prospecto";
                             $bean_Resumen->tct_subtipo_f_txf_c = "Interesado";
                             $bean_Resumen->tct_tipo_cuenta_f_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                         }
                         break;
                     case '6':
                         if($bean_Resumen->tct_tipo_fl_txf_c=="Prospecto") {
                             $bean_Resumen->tct_tipo_fl_txf_c = "Prospecto";
                             $bean_Resumen->tct_subtipo_fl_txf_c = "Interesado";
                             $bean_Resumen->tct_tipo_cuenta_fl_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                         }
                         break;
                     default:
                 }
                //GUARDA REGISTRO DE RESUMEN
                $bean_Resumen->save();
            }
            //Actualiza en Integracion de Expediente y actualiza campos con valor Prospecto en Integracion de Expediente
            if($subetapa=="PE" && $bean->fetched_row[estatus_c]!= $subetapa){
                $GLOBALS['log']->fatal('Entra a validar Prospecto Integracion de Exp');
                $etitipo = $tipo["Prospecto"];      //Obtiene el valor del campo obtenido de la lista con Etiqueta
                $etisubtipo = $subtipo["Integracion de Expediente"]; //Obtiene el valor del campo obtenido de la lista con Etiqueta
                switch ($producto) {
                    case '1':
                        if($bean_Resumen->tct_tipo_l_txf_c=="Prospecto") {
                            $bean_Resumen->tct_tipo_l_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_l_txf_c = "Integracion de Expediente";
                            $bean_Resumen->tct_tipo_cuenta_l_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    case '3':
                        if($bean_Resumen->tct_tipo_ca_txf_c=="Prospecto" || $bean_Resumen->tct_tipo_ca_txf_c=="Lead") {
                            $bean_Resumen->tct_tipo_ca_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_ca_txf_c = "Integracion de Expediente";
                            $bean_Resumen->tct_tipo_cuenta_ca_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    case '4':
                        if($bean_Resumen->tct_tipo_f_txf_c=="Prospecto") {
                            $bean_Resumen->tct_tipo_f_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_f_txf_c = "Integracion de Expediente";
                            $bean_Resumen->tct_tipo_cuenta_f_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    case '6':
                        if($bean_Resumen->tct_tipo_fl_txf_c=="Prospecto") {
                            $bean_Resumen->tct_tipo_fl_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_fl_txf_c = "Integracion de Expediente";
                            $bean_Resumen->tct_tipo_cuenta_fl_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    default:
                }
                //GUARDA REGISTRO DE RESUMEN
                $bean_Resumen->save();
            }
            //Actualiza en Crédito y actualiza campos con valor Prospecto en Crédito
            if(($subetapa=="BC" || $subetapa=="CC" || $subetapa=="RF" || $subetapa=="EF" || $subetapa=="RM" || $subetapa=="SC" ||$subetapa=="D" || $subetapa=="CN" || $subetapa=="E") && $bean->fetched_row[estatus_c]!= $subetapa){
                $etitipo = $tipo["Prospecto"];      //Obtiene el valor del campo obtenido de la lista con Etiqueta
                $etisubtipo = $subtipo["Credito"]; //Obtiene el valor del campo obtenido de la lista con Etiqueta
                switch ($producto) {
                    case '1':
                        if($bean_Resumen->tct_tipo_l_txf_c=="Prospecto") {
                            $bean_Resumen->tct_tipo_l_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_l_txf_c = "Credito";
                            $bean_Resumen->tct_tipo_cuenta_l_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    case '3':
                        if($bean_Resumen->tct_tipo_ca_txf_c=="Prospecto") {
                            $bean_Resumen->tct_tipo_ca_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_ca_txf_c = "Credito";
                            $bean_Resumen->tct_tipo_cuenta_ca_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    case '4':
                        if($bean_Resumen->tct_tipo_f_txf_c=="Prospecto") {
                            $bean_Resumen->tct_tipo_f_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_f_txf_c = "Credito";
                            $bean_Resumen->tct_tipo_cuenta_f_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    case '6':
                        if($bean_Resumen->tct_tipo_fl_txf_c=="Prospecto") {
                            $bean_Resumen->tct_tipo_fl_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_fl_txf_c = "Credito";
                            $bean_Resumen->tct_tipo_cuenta_fl_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    default:
                }
                //GUARDA REGISTRO DE RESUMEN
                $bean_Resumen->save();
            }
            //Actualiza en Rechazado y actualiza campos con valor Prospecto Rechazado
            if(($subetapa=="R" || $subetapa=="CM") && $bean->fetched_row[estatus_c]!= $subetapa){
                $etitipo = $tipo["Prospecto"];      //Obtiene el valor del campo obtenido de la lista con Etiqueta
                $etisubtipo = $subtipo["Rechazado"]; //Obtiene el valor del campo obtenido de la lista con Etiqueta
                switch ($producto) {
                    case '1':
                        if($bean_Resumen->tct_tipo_l_txf_c=="Prospecto") {
                            $bean_Resumen->tct_tipo_l_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_l_txf_c = "Rechazado";
                            $bean_Resumen->tct_tipo_cuenta_l_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    case '3':
                        if($bean_Resumen->tct_tipo_ca_txf_c=="Prospecto") {
                            $bean_Resumen->tct_tipo_ca_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_ca_txf_c = "Rechazado";
                            $bean_Resumen->tct_tipo_cuenta_ca_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    case '4':
                        if($bean_Resumen->tct_tipo_f_txf_c=="Prospecto") {
                            $bean_Resumen->tct_tipo_f_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_f_txf_c = "Rechazado";
                            $bean_Resumen->tct_tipo_cuenta_f_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    case '6':
                        if($bean_Resumen->tct_tipo_fl_txf_c=="Prospecto") {
                            $bean_Resumen->tct_tipo_fl_txf_c = "Prospecto";
                            $bean_Resumen->tct_subtipo_fl_txf_c = "Rechazado";
                            $bean_Resumen->tct_tipo_cuenta_fl_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                        }
                        break;
                    default:
                }
                //GUARDA REGISTRO DE RESUMEN
                $bean_Resumen->save();
            }
            //Actualiza cuando la solicitud es Autorizada (N)
            if (!empty($bean_Resumen && $bean->estatus_c=="N" && $bean->fetched_row[estatus_c]!=$bean->estacus_c)) { //Etapa solicitud= N= Autorizada
                $etitipo = $tipo["Cliente"];      //Obtiene el valor del campo obtenido de la lista con Etiqueta
                $etisubtipo = $subtipo["Con Linea Vigente"]; //Obtiene el valor del campo obtenido de la lista con Etiqueta

                //Setea valores para los campos por producto (leasing, factoraje y CA en tipo y subtipo).
                //LEASING
                if ($bean->tipo_producto_c=="1") {
                    $bean_Resumen->tct_tipo_l_txf_c = "Cliente";
                    $bean_Resumen->tct_subtipo_l_txf_c = "Con Linea Vigente";
                    $bean_Resumen->tct_tipo_cuenta_l_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                }
                //FACTORAJE
                if($bean->tipo_producto_c=="4") {
                    $bean_Resumen->tct_tipo_f_txf_c = "Cliente";
                    $bean_Resumen->tct_subtipo_f_txf_c = "Con Linea Vigente";
                    $bean_Resumen->tct_tipo_cuenta_f_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                }
                //CREDITO AUTOMOTRIZ
                if($bean->tipo_producto_c=="3") {
                    $bean_Resumen->tct_tipo_ca_txf_c = "Cliente";
                    $bean_Resumen->tct_subtipo_ca_txf_c = "Con Linea Vigente";
                    $bean_Resumen->tct_tipo_cuenta_ca_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                }
                //FLEET
                if($bean->tipo_producto_c=="6") {
                    $bean_Resumen->tct_tipo_fl_txf_c = "Cliente";
                    $bean_Resumen->tct_subtipo_fl_txf_c = "Con Linea Vigente";
                    $bean_Resumen->tct_tipo_cuenta_fl_c = mb_strtoupper(trim($etitipo . ' ' . $etisubtipo),'UTF-8');
                }
                //GUARDA REGISTRO DE RESUMEN -
                $bean_Resumen->save();
            }
        }

        public function solicitudSOS ($oportunidadL)
        {
            global $db;
            //Pregunta si existe una solicitud de SOS antes de iniciar el proceso.
            $query = "select count(*) from accounts_opportunities
                    inner join opportunities_cstm on accounts_opportunities.opportunity_id= opportunities_cstm.id_c
                    WHERE accounts_opportunities.account_id='{$oportunidadL->account_id}'
                    and opportunities_cstm.tipo_producto_c=7
                    and opportunities_cstm.estatus_c!='K'";

            $queryResult = $db->getOne($query);
            $GLOBALS['log']->fatal($queryResult);

            if ($queryResult == 0) {

                //Genera nuevo registro a nivel db
                $GLOBALS['log']->fatal("Crea Solicitud de SOS");
                $oportunidadSOS = BeanFactory::newBean('Opportunities');
                $oportunidadSOS->account_id = $oportunidadL->account_id;
                $oportunidadSOS->tct_etapa_ddw_c = "P";
                $oportunidadSOS->estatus_c = "PE";
                $oportunidadSOS->tipo_producto_c = 7;
                $oportunidadSOS->monto_c = 0;
                $oportunidadSOS->amount = 0;
                $oportunidadSOS->assigned_user_id = $oportunidadL->assigned_user_id;
                $oportunidadSOS->tipo_operacion_c = "1";
                $oportunidadSOS->tipo_de_opracion_c = "LINEA_NUEVA";
                $oportunidadSOS->ca_pago_mensual_c = 0;
                $oportunidadSOS->opportunities_opportunities_2opportunities_ida = $oportunidadL->id;
                //Guarda el registro.
                $oportunidadSOS->save();
                $GLOBALS['log']->fatal($oportunidadSOS->id);
                //$GLOBALS['log']->fatal("Sale de la creación solicitud de SOS");

            }
        }

        public function cancelaSOS($bean, $event, $arguments)
        {
            //Función que cancela línea SOS a partir de una línea de Leasing
            //Valida que Solicitud Leasing se cancela
            if ($bean->tipo_producto_c==1 && !empty($bean->opportunities_opportunities_2opportunities_ida) && $bean->tct_oportunidad_perdida_chk_c && $bean->fetched_row[tct_oportunidad_perdida_chk_c] != $bean->tct_oportunidad_perdida_chk_c) {
                //Recupera solicitud SOS asociada
                $GLOBALS['log']->fatal("cancelaSOS : Inicia proceso para cancelar SOS asociada a Leasing");
                $beanSOS = BeanFactory::retrieveBean("Opportunities", $bean->opportunities_opportunities_2opportunities_ida);

                //Actualiza Oportunidad Perdida con datos de Solicitud Leasing
                $beanSOS->tct_oportunidad_perdida_chk_c = $bean->tct_oportunidad_perdida_chk_c;
                $beanSOS->tct_razon_op_perdida_ddw_c = $bean->tct_razon_op_perdida_ddw_c;
                $beanSOS->tct_competencia_quien_txf_c = $bean->tct_competencia_quien_txf_c;
                $beanSOS->tct_competencia_porque_txf_c = $bean->tct_competencia_porque_txf_c;
                $beanSOS->tct_sin_prod_financiero_ddw_c = $bean->tct_sin_prod_financiero_ddw_c;

                //Actualiza subetapa a cancelada
                $beanSOS->estatus_c='K';

                //Guarda cambios en SOS
                $beanSOS->save();
            }

            //Valida existencia de Id Process en Solicitud SOS para cancelar en BPM
            if ($bean->tipo_producto_c==7 && $bean->tct_oportunidad_perdida_chk_c && $bean->fetched_row[tct_oportunidad_perdida_chk_c] != $bean->tct_oportunidad_perdida_chk_c) {
                //Valida id Proceso
                if (!empty($bean->id_process_c)) {
                    //Ejecuta proceso para cancelar en BPM
                    $GLOBALS['log']->fatal("cancelaSOS : Inicia proceso para cancelar SOS en BPM");
                    //Instancia cancelaOperacionBPM
                    require_once 'custom/modules/Opportunities/clients/base/api/cancelaOperacionBPM.php';
                    $cancelaSOS = new cancelaOperacionBPM();

                    //Define argumentos para cancelar
                    global $current_user;
                    $args = [];
                    $args['data'] = [];
                    $args['data']['idSolicitud'] = $bean->idsolicitud_c;
                    $args['data']['usuarioAutenticado'] = $current_user->user_name;

                    //Solicita cancelación
                    $cancelaOPP = $cancelaSOS->cancelaOperacion(null, $args);

                }
            }
        }

    }
