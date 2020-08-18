<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez, AF
 * Date: 29/01/18
 * Time: 15:54
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ResumenClienteAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'GetResumen' => array(
                //request type
                'reqType' => 'GET',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('ResumenCliente', '?'),
                //endpoint variables
                'pathVars' => array('name', 'id'),
                //method to call
                'method' => 'getResumenPersona',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'An example of a GET endpoint',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function getResumenPersona($api, $args)
    {
        //$GLOBALS['log']->fatal("ResumenPersona: Genera  petición -- ");
        //Recupera Cliente
        $id_cliente = $args['id'];
        $beanPersona = BeanFactory::getBean("Accounts", $id_cliente);

        //Obtiene variables globales
        global $app_list_strings;
        global $current_user;

        //Define tipo de producto principal
        $producto =  $current_user->tipodeproducto_c;
        /* Valores de $producto
        1 = LEASING
        2 = CREDITO SIMPLE
        3 = CREDITO AUTOMOTRIZ
        4 = FACTORAJE
        5 = LINEA CREDITO SIMPLE
		6 = UNICLICK
        */

        //Define colores:
        $Azul = "#21618C";
        $Rojo = "#C0392B";
        $Amarillo = "#F1C40F";
        $Blanco = "#ffffff";

        ############################
        ## Genera estructura default
        $arr_principal = array();
        //colores
        $arr_principal['colores'] = array(
            "azul" => $Azul,
            "rojo" => $Rojo,
            "amarillo" => $Amarillo
        );
        /*Victor Martinez Lopez
        *20-Septiembre-2018
        *Nuevos Campos de de noticias
        */
        //Noticias General
        $arr_principal['noticia_general']=array(
            "noticia"=>""
            );
        //Noticias Macro Sector
        $arr_principal['noticia_macro_sector']=array(
            "noticia"=>""
            );
        //Noticias de Región
        $arr_principal['noticia_region']=array(
            "noticia"=>""
            );
        //Datos Clave
        $arr_principal['datos_clave']=array(
            "dato_clave"=>""
            );
        //General
        $arr_principal['general_cliente'] = array(
            "tipo" => "No definido",
            "segmento" => "Sin Segmento",
            "cobranza" => "Sin Clasificar",
            "sector_economico" => "Sin Especificar",
            "grupo_empresarial" => "Sin Grupo empresarial",
            "nivel_satisfaccion" => "Sin Clasificar",
            "color" => $Azul);
        //Leasing
        $arr_principal['leasing'] = array("linea_autorizada" => "",
            "estatus_atencion"=>"",
            "tipo_cuenta"=>"",
            "subtipo_cuenta"=>"",
            "fecha_vencimiento" => "",//más proxima
            "fecha_completa_vencimiento" => "",
            "linea_disponible" => "",
            "potencial" => "",
            "fecha_pago" => "",//mas lejana
            "anexos_activos" => 0,
            "anexos_historicos" => 0,
            "nivel_satisfaccion" => "Sin Clasificar",
            "promotor" => "",
            "color" => "");
        //Factoraje
        $arr_principal['factoring'] = array("linea_autorizada" => "",
            "estatus_atencion"=>"",
            "tipo_cuenta"=>"",
            "subtipo_cuenta"=>"",
            "fecha_vencimiento" => "",
            "fecha_completa_vencimiento" => "",
            "linea_disponible" => "",
            "fecha_pago" => "",
            "anexos_activos" => 0,
            "anexos_historicos" => 0,
            "nivel_satisfaccion" => "Sin Clasificar",
            "promotor" => "",
            "color" => "");
        //Crédito automotriz
        $arr_principal['credito_auto'] = array("linea_autorizada" => "",
            "estatus_atencion"=>"",
            "tipo_cuenta"=>"",
            "subtipo_cuenta"=>"",
            "fecha_vencimiento" => "",
            "fecha_completa_vencimiento" => "",
            "linea_disponible" => "",
            "fecha_pago" => "",
            "anexos_activos" => 0,
            "anexos_historicos" => 0,
            "nivel_satisfaccion" => "Sin Clasificar",
            "promotor" => "",
            "color" => "");
        //Fleet
        $arr_principal['fleet'] = array("linea_aproximada" => "",
            "estatus_atencion"=>"",
            "tipo_cuenta"=>"",
            "subtipo_cuenta"=>"",
            "numero_vehiculos" => "",
            "promotor" => "",
            "color" => "");
        //Crédito SOS
        $arr_principal['credito_sos'] = array("linea_autorizada" => "",
            "estatus_atencion"=>"",
            "fecha_vencimiento"=>"",
            "linea_disponible" => "",
            "fecha_pago" => "",
            "promotor" => "",
            "color" => "");
		 //Uniclick
        $arr_principal['uniclick'] = array("linea_autorizada" => "",
            "estatus_atencion"=>"",
            "tipo_cuenta"=>"",
            "subtipo_cuenta"=>"",
            "fecha_vencimiento"=>"",
            "linea_disponible" => "",
            "promotor" => "",
            "color" => "");
        //Unilease
        $arr_principal['unilease'] = array("linea_autorizada" => "",
            "estatus_atencion"=>"",
            "tipo_cuenta"=>"",
            "subtipo_cuenta"=>"",
            "fecha_vencimiento"=>"",
            "linea_disponible" => "",
            "promotor" => "",
            "color" => "");

        //Historial de contactos
        $arr_principal['historial_contactos'] = array(
            "ultima_cita" => "",
            "ultima_llamada" => "",
            "citas" => 0,
            "llamadas" => 0,
            "emails" => 0,
            "fecha_completa_cita" => "",
            "fecha_completa_llamada" => "",
            "estatus_atencion" => "",
            "color" => $Azul
        );
        //Alertas
        $arr_principal['alertas'] = array(
            "color" => $Azul,
            "total" => 0
            //"alerta" => array()
        );
        //Clasificacion Sectorial INEGI
        $arr_principal['inegi'] = array(
            "inegi_rama" => "",
            "inegi_subrama" => "",
            "inegi_sector" => "",
            "inegi_subsector" => "",
            "inegi_clase" => "",
            "inegi_descripcion" => ""
        );

        //String operaciones
        $operaciones_ids = "'".$id_cliente."'";

        ############################
        ## Recupera información de Persona
        ############################
        if($beanPersona){
            //General
            $arr_principal['general_cliente']['tipo'] = $beanPersona->tct_tipo_subtipo_txf_c;  // tipo_general_c
            $arr_principal['general_cliente']['segmento'] = $beanPersona->segmento_c;
            $arr_principal['general_cliente']['cobranza'] = $beanPersona->cobranza_c;
            $arr_principal['general_cliente']['sector_economico'] = $app_list_strings['sectoreconomico_list'][$beanPersona->sectoreconomico_c];
            $arr_principal['general_cliente']['grupo_empresarial'] = $beanPersona->parent_name;
            $arr_principal['general_cliente']['nivel_satisfaccion'] = $app_list_strings['nivel_satisfaccion_list'][$beanPersona->nivel_satisfaccion_c];
            //Promotores
            $arr_principal['leasing']['promotor']=$beanPersona->promotorleasing_c;
            $arr_principal['factoring']['promotor']=$beanPersona->promotorfactoraje_c;
            $arr_principal['credito_auto']['promotor']=$beanPersona->promotorcredit_c;
            $arr_principal['fleet']['promotor']=$beanPersona->promotorfleet_c;
			$arr_principal['credito_sos']['promotor']=$beanPersona->promotorleasing_c;
            $arr_principal['uniclick']['promotor']=$beanPersona->promotoruniclick_c;
            $arr_principal['unilease']['promotor']=$beanPersona->promotoruniclick_c;

            //Nivel satisfacción
            $arr_principal['leasing']['nivel_satisfaccion']=$beanPersona->nivel_satisfaccion_c;
            $arr_principal['factoring']['nivel_satisfaccion']=$beanPersona->nivel_satisfaccion_factoring_c;
            $arr_principal['credito_auto']['nivel_satisfaccion']=$beanPersona->nivel_satisfaccion_ca_c;

            //Estatus atención
            $arr_principal['historial_contactos']['estatus_atencion']=$beanPersona->tct_status_atencion_ddw_c;


        }

        ############################
        ## Recupera y procesa operaciones asociadas
        ############################
        if ($beanPersona->load_relationship('opportunities')) {
            //Recupera operaciones
            $relatedBeans = $beanPersona->opportunities->getBeans($beanPersona->id,array('disable_row_level_security' => true));

            //Línea autorizada
            $linea_aut_leasing = 0;
            $linea_aut_factoring = 0;
            $linea_aut_credito_aut = 0;
            $linea_aut_sos = 0;

            //Línea disponible
            $linea_disp_leasing = 0;
            $linea_disp_factoring = 0;
            $linea_disp_credito_aut = 0;
            $linea_disp_sos = 0;

            //Linea aproximada fleet
            $linea_aprox_fleet=0;
            $numero_vehiculos_fleet=0;

            //Fecha de vencimiento
            $vencimiento_leasing = '';//date("Y-m-d");
            $vencimiento_factoring ='';//date("Y-m-d");
            //$vencimiento_cauto = date("Y-m-d");
            $vencimiento_cauto = "";
            $vencimiento_sos = "";

            $vencimiento_sos='';

			$vencimiento_uniclick ='';
            $vencimiento_unilease ='';

            //Recorre operaciones
            foreach ($relatedBeans as $opps) {

                /**
                 *Filtro para operaciones
                 * Operación = LÍNEA DE CRÉDITO || tipo_operacion_c = 2
                 * Tipo de Solicitud = Línea Nueva || tipo_de_operacion_c = LINEA_NUEVA
                 */
                if ($opps->tipo_operacion_c == 2 && $opps->tipo_de_operacion_c == "LINEA_NUEVA" && $opps->tct_opp_estatus_c == 1) {

                    //Agrega Operaciones asociadas
                    $operaciones_ids .= ",'$opps->id'";
                    //Control para leasing
                    if ($opps->tipo_producto_c == 1) {
                        $linea_aut_leasing += $opps->monto_c;
                        $linea_disp_leasing += $opps->amount;
                        /* Cambiar por otro cmpo de fecha con valores fecha_estimada_cierre_c*/
                        /*********************************/

                        if (!empty($opps->vigencialinea_c)) {
                            //Establece fecha de vencimiento
                            $dateVL = $opps->vigencialinea_c;
                            $GLOBALS['log']->fatal('Validación $dateVL');
                            $GLOBALS['log']->fatal($dateVL);
                            $timedateVL = Date($dateVL);

                            //Compara fechas
                            if ($dateVL > $vencimiento_leasing || empty($vencimiento_leasing)) {
                                $vencimiento_leasing = $dateVL;
                            }

                            //Agrega valores en arreglo de resultados
                            $arr_principal['leasing']['linea_autorizada'] = $linea_aut_leasing;
                            $arr_principal['leasing']['fecha_vencimiento'] = $vencimiento_leasing;
                            $arr_principal['leasing']['linea_disponible'] = $linea_disp_leasing;
                            $arr_principal['leasing']['potencial'] = "";
                            $arr_principal['leasing']['fecha_pago'] = "";
                            //$arr_principal['leasing']['promotor']=$beanPersona->promotorleasing_c;

                            //Logs
                            /*
                            $GLOBALS['log']->fatal($dateVL);
                            $GLOBALS['log']->fatal($vencimiento_leasing);
                            */
                        }
                    }

                    //Control para factoring
                    if ($opps->tipo_producto_c == 4) {
                        $linea_aut_factoring += $opps->monto_c;
                        $linea_disp_factoring += $opps->amount;
                        /* Cambiar por otro cmpo de fecha con valores fecha_estimada_cierre_c*/
                        /*********************************/

                        if (!empty($opps->vigencialinea_c)) {
                            //Establece fecha de vencimiento
                            $dateVF = $opps->vigencialinea_c;
                            //$timedateVL = Date($dateVL);

                            //Compara fechas
                            if ($dateVF > $vencimiento_factoring || empty($vencimiento_factoring)) {
                                $vencimiento_factoring = $dateVF;
                            }

                            //Agrega valores en arreglo de resultados
                            $arr_principal['factoring']['linea_autorizada'] = $linea_aut_factoring;
                            $arr_principal['factoring']['fecha_vencimiento'] = $vencimiento_factoring;
                            $arr_principal['factoring']['linea_disponible'] = $linea_disp_factoring;
                            $arr_principal['factoring']['fecha_pago'] = "";
                            //$arr_principal['factoring']['promotor']=$beanPersona->promotorfactoraje_c;

                            //Logs
                            /*
                            $GLOBALS['log']->fatal($dateVF);
                            $GLOBALS['log']->fatal($vencimiento_factoring);
                            */
                        }
                    }

                    //Control para crédito auto
                    $fecha_val = date("Y-m-d");
                    if ($opps->tipo_producto_c == 3 && $opps->vigencialinea_c >= $fecha_val) {
                        $linea_aut_credito_aut += $opps->monto_c;
                        $linea_disp_credito_aut += $opps->amount;
                        /* Cambiar por otro cmpo de fecha con valores fecha_estimada_cierre_c*/
                        /*********************************/

                        if (!empty($opps->vigencialinea_c)) {
                            //Establece fecha de vencimiento
                            $dateVC = $opps->vigencialinea_c;
                            //$timedateVL = Date($dateVL);
                            if ($vencimiento_cauto == "") {
                                $vencimiento_cauto = $opps->vigencialinea_c;
                            }

                            //Compara fechas
                            if ($dateVC < $vencimiento_cauto || empty($vencimiento_cauto)) {
                                $vencimiento_cauto = $dateVC;
                            }

                            //Agrega valores en arreglo de resultados
                            $arr_principal['credito_auto']['linea_autorizada'] = $linea_aut_credito_aut;
                            $arr_principal['credito_auto']['fecha_vencimiento'] = $vencimiento_cauto;
                            $arr_principal['credito_auto']['linea_disponible'] = $linea_disp_credito_aut;
                            $arr_principal['credito_auto']['fecha_pago'] = "";
                            //$arr_principal['credito_auto']['promotor']=$beanPersona->promotorcredit_c;

                            //Logs
                            /*
                            $GLOBALS['log']->fatal($dateVF);
                            $GLOBALS['log']->fatal($vencimiento_factoring);
                            */
                        }
                    }

                    // Control para crédito sos
                    if ($opps->tipo_producto_c == 7) {
                        $linea_aut_sos += $opps->monto_c;
                        $linea_disp_sos += $opps->amount;
                        /* Cambiar por otro cmpo de fecha con valores fecha_estimada_cierre_c*/
                        /*********************************/

                        if (!empty($opps->vigencialinea_c)) {
                            //Establece fecha de vencimiento
                            $dateVL = $opps->vigencialinea_c;
                            $timedateVL = Date($dateVL);

                            //Compara fechas
                            if ($dateVL > $vencimiento_sos || empty($vencimiento_sos)) {
                                $vencimiento_sos = $dateVL;
                            }

                            //Agrega valores en arreglo de resultados
                            $arr_principal['credito_sos']['linea_autorizada'] = $linea_aut_sos;
                            $arr_principal['credito_sos']['fecha_vencimiento'] = $vencimiento_sos;
                            $arr_principal['credito_sos']['linea_disponible'] = $linea_disp_sos;
                            $arr_principal['credito_sos']['fecha_pago'] = "";

                        }
                    }

                    //control para Uniclick
                    if ($opps->tipo_producto_c == 8 && $opps->estatus_c != 'K') {
                        $linea_aprox_uniclick += $opps->monto_c;
    					          $linea_disp_sos += $opps->amount;
                        /* Cambiar por otro cmpo de fecha con valores fecha_estimada_cierre_c*/
                        /*********************************/

                        if (!empty($opps->vigencialinea_c)) {
                						//Establece fecha de vencimiento
                						$dateVL = $opps->vigencialinea_c;
                						$timedateVL = Date($dateVL);

                						//Compara fechas
                						if ($dateVL > $vencimiento_uniclick || empty($vencimiento_uniclick)) {
                						   $vencimiento_uniclick = $dateVL;
                						}

                						$arr_principal['uniclick']['linea_autorizada'] = $linea_aprox_uniclick;
                						$arr_principal['uniclick']['fecha_vencimiento'] = $vencimiento_uniclick;
                						$arr_principal['uniclick']['linea_disponible'] = $linea_disp_sos;
                        }
                    }

                    //Control para Unilease
                    if ($opps->tipo_producto_c == 9 && $opps->estatus_c != 'K') {
                        $linea_aprox_unilease += $opps->monto_c;
                        $linea_disp_sos += $opps->amount;
                        /* Cambiar por otro cmpo de fecha con valores fecha_estimada_cierre_c*/
                        /*********************************/

                        if (!empty($opps->vigencialinea_c)) {
                            //Establece fecha de vencimiento
                            $dateVL = $opps->vigencialinea_c;
                            $timedateVL = Date($dateVL);

                            //Compara fechas
                            if ($dateVL > $vencimiento_unilease || empty($vencimiento_unilease)) {
                                $vencimiento_unilease = $dateVL;
                            }

                            $arr_principal['unilease']['linea_autorizada'] = $linea_aprox_unilease;
                            $arr_principal['unilease']['fecha_vencimiento'] = $vencimiento_unilease;
                            $arr_principal['unilease']['linea_disponible'] = $linea_disp_sos;
                        }
                    }

                }
                // Control para fleet
                if ($opps->tipo_producto_c == 6 && $opps->estatus_c != 'K') {
                    $linea_aprox_fleet += $opps->monto_c;
                    $numero_vehiculos_fleet += $opps->tct_numero_vehiculos_c;

                    $arr_principal['fleet']['linea_aproximada'] = $linea_aprox_fleet;
                    $arr_principal['fleet']['numero_vehiculos'] = $numero_vehiculos_fleet;

                }

            }
        }

        ############################
        ## Recupera y procesa reuniones asociadas
        ############################
        if ($beanPersona->load_relationship('meetings')) {
            //Recupera reuniones
            $relatedMeetings = $beanPersona->meetings->getBeans();

            //Procesa si recupera registros
            if ($relatedMeetings) {
                //$GLOBALS['log']->fatal("ResumenPersona: Genera  petición -- Recupero reuniones ");
                //Establece última fecha de reunión
                //$dateUR = $relatedMeetings[0]->date_start;
                //$timedateUL = new TimeDate();
                //$ultima_reunion = $timedateUL->fromUser($dateUR, $current_user);
                $dateUR = "2000-01-01 10:00:01";
                $timedateUL = new TimeDate();
                $ultima_reunion = $timedateUL->fromDb($dateUR);

                $fecha_completa_reunion = $dateUR;
                //Obtiene total de reuniones
                $total_reuniones = 0;// count($relatedMeetings);

                //Recupera usuarios con mismo tipo_operacion_c
                $users = array();
                $query = "select m.date_start, uc.id_c
                          from meetings m
                          inner join users_cstm uc on uc.id_c=m.assigned_user_id
                          where
                          	parent_type='Accounts'
                              and parent_id = '".$id_cliente."'
                              and uc.tipodeproducto_c = ".$producto."
                          ;";
                $resultQ = $GLOBALS['db']->query($query);
                while ($row = $GLOBALS['db']->fetchByAssoc($resultQ)) {
                  //Obtiene fecha de inicio de reunión
                  $users[] = $row['id_c'];
                }

                //Recorre reuniones
                if (count($users)>0) {
                  foreach ($relatedMeetings as $meeting) {
                    //$GLOBALS['log']->fatal("ResumenPersona: Estado de reunión: " . $meeting->status);
                    //if (in_array($meeting->assigned_user_id, $users) && $meeting->status=='Held') {
                    if ($meeting->status == 'Held') {
                      //$GLOBALS['log']->fatal("ResumenPersona: Se cuenta esta reunión");
                      if (in_array($meeting->assigned_user_id, $users)) {
                        $total_reuniones++;

                        //Obtiene fecha de inicio de reunión
                        // $dateFR = $meeting->date_start;
                        // $timedateFR = new TimeDate();
                        // $fecha_reunion = $timedateFR->fromUser($dateFR, $current_user);
                        $dateFR = $meeting->date_start;
                        $timedateFR = new TimeDate();
                        $fecha_reunion = $timedateFR->fromDb($dateFR);
                        // $GLOBALS['log']->fatal("Fechas...reuniones");
                        // $GLOBALS['log']->fatal($dateFR);
                        // $GLOBALS['log']->fatal($fecha_reunion);

                        //Compara fechas y establece última fecha de reunión
                        if ( $fecha_reunion > $ultima_reunion){
                            //$ultima_reunion = $fecha_reunion->format("d/m/Y");
                            $ultima_reunion = $fecha_reunion;
                            $fecha_completa_reunion = $dateFR;
                        }
                      }

                      //Agrega valores al arreglo de respuesta
                      // $GLOBALS['log']->fatal("Ultima fecha");
                      // $GLOBALS['log']->fatal(date_format($ultima_reunion, "d/m/Y"));
                      if (date_format($ultima_reunion, "d/m/Y") == "01/11/2000") {
                        $arr_principal['historial_contactos']['ultima_cita']= '';
                        $arr_principal['historial_contactos']['fecha_completa_cita']= '';
                      }else{
                        $arr_principal['historial_contactos']['ultima_cita']= date_format($ultima_reunion, "d/m/Y");
                        $arr_principal['historial_contactos']['fecha_completa_cita']= $fecha_completa_reunion;
                      }

                    }
                  }
                }
                $arr_principal['historial_contactos']['citas']= $total_reuniones;


            }
        }

        ############################
        ## Recupera y procesa llamadas asociadas
        ############################
        if ($beanPersona->load_relationship('calls')) {
            //Recupera llamadas
            $relatedCalls = $beanPersona->calls->getBeans();

            //Procesa si recupera registros
            if ($relatedCalls) {
                //Establece última fecha de llamada
                //$dateUL = $relatedCalls[0]->date_start;
                //$timedateUL = new TimeDate();
                //$ultima_llamada = $timedateUL->fromUser($dateUL, $current_user);
                $dateUL = "2000-01-01 10:00:01";
                $timedateUL = new TimeDate();
                $ultima_llamada = $timedateUL->fromDb($dateUL);

                $fecha_completa_llamada = $dateUL;
                //$GLOBALS['log']->fatal($ultima_llamada);
                //Obtiene total de llamadas
                $total_llamadas = 0;// count($relatedCalls);

                //Recupera usuarios con mismo tipo_operacion_c
                $users = array();
                $query = "select c.date_start, uc.id_c
                          from calls c
                          inner join users_cstm uc on uc.id_c=c.assigned_user_id
                          where
                              parent_type='Accounts'
                              and parent_id = '".$id_cliente."'
                              and uc.tipodeproducto_c = ".$producto."
                          ;";
                $resultQ = $GLOBALS['db']->query($query);
                while ($row = $GLOBALS['db']->fetchByAssoc($resultQ)) {
                  //Obtiene fecha de inicio de reunión
                  $users[] = $row['id_c'];
                }


                //Recorre llamadas
                if (count($users)>0) {
                  foreach ($relatedCalls as $call) {
                    //$GLOBALS['log']->fatal("ResumenPersona: Estado de llamada: " . $call->status);
                      if ($call->status == 'Held') {
                        //$GLOBALS['log']->fatal("ResumenPersona: Procesa llamada");
                        if (in_array($call->assigned_user_id, $users)) {

                          $total_llamadas++;

                          //Obtiene fecha de inicio de reunión
                          // $dateFL = $call->date_start;
                          // $timedateFL = new TimeDate();
                          // $fecha_llamada = $timedateFL->fromUser($dateFL, $current_user);
                          $dateFL = $call->date_start;
                          $timedateFL = new TimeDate();
                          $fecha_llamada = $timedateFL->fromDb($dateFL);
                          // $GLOBALS['log']->fatal("Fechas...reuniones");
                          // $GLOBALS['log']->fatal($dateFL);
                          // $GLOBALS['log']->fatal($fecha_llamada);

                          //Compara fechas y establece última fecha de llamada
                          if ( $fecha_llamada > $ultima_llamada){
                              //$ultima_llamada = $fecha_llamada->format("d/m/Y");
                              $ultima_llamada = $fecha_llamada;
                              $fecha_completa_llamada = $dateFL;

                          }
                        }
                        //Agrega valores al arreglo de
                        // $GLOBALS['log']->fatal("Ultima fecha");
                        // $GLOBALS['log']->fatal(date_format($ultima_llamada, "d/m/Y"));
                        if (date_format($ultima_llamada, "d/m/Y") == "01/11/2000") {
                          $arr_principal['historial_contactos']['ultima_llamada']= '';
                          $arr_principal['historial_contactos']['fecha_completa_llamada']= '';
                        }else{
                          $arr_principal['historial_contactos']['ultima_llamada']= date_format($ultima_llamada, "d/m/Y");
                          $arr_principal['historial_contactos']['fecha_completa_llamada']= $fecha_completa_llamada;
                        }
                      }
                  }
                }


                $arr_principal['historial_contactos']['llamadas']= $total_llamadas;
                //$GLOBALS['log']->fatal("ResumenPersona: 2");
            }
        }

        ############################
        ## Recupera y procesa emails asociados
        ############################
        if ($beanPersona->load_relationship('archived_emails')) {
            //Recupera llamadas
            $relatedEmails = $beanPersona->archived_emails->getBeans();

            //Procesa si recupera registros
            if ($relatedEmails) {
                //Obtiene total de llamadas
                $total_emails = count($relatedEmails);

                //Agrega valores al arreglo de respuesta
                $arr_principal['historial_contactos']['emails']= $total_emails;
            }
        }

        ############################
        ## Recupera y procesa información de resumen
        ############################
        if($beanPersona){
            //Recupera información de resumen
            $beanResumen = BeanFactory::getBean('tct02_Resumen', $beanPersona->id);

            //Procesa registro
            if($beanResumen){
                //Recupera Leasing
                // $arr_principal['leasing']['tipo_cuenta']=$beanResumen->tct_tipo_cuenta_l_c;
                $arr_principal['leasing']['fecha_pago']= $beanResumen->leasing_fecha_pago;
                //Victor
                //codigo para cargar el contenido del .txt de la noticia actualizada
                $filename = 'custom/pdf/noticiaGeneral.txt';
                $resultado = "";

                //funcion fopen abre el archivo con la ruta del mismo y el mode r (read)
                $file = fopen( $filename,"r");

                //Controla accion del archivo ($resultado contiene la info del archivo abierto)
                while(!feof($file)) {
                    $resultado.= fgets($file);
                }
                fclose($file);
                $arr_principal['noticia_general']['noticia']=$resultado;
                $arr_principal['noticia_macro_sector']['noticia']=$beanResumen->tct_noticia_sector_c;
                $arr_principal['noticia_region']['noticia']=$beanResumen->tct_noticia_region_c;
                $arr_principal['datos_clave']['dato_clave']=$beanResumen->tct_datos_clave_txa_c;
                if(!empty($beanResumen->leasing_anexos_activos) && $beanResumen->leasing_anexos_activos!="")
                {
                    $arr_principal['leasing']['anexos_activos']= $beanResumen->leasing_anexos_activos;
                }
                if(!empty($beanResumen->leasing_anexos_historicos) && $beanResumen->leasing_anexos_historicos!="")
                {
                    $arr_principal['leasing']['anexos_historicos']= $beanResumen->leasing_anexos_historicos;
                }


                //Recupera Factoring
                // $arr_principal['factoring']['tipo_cuenta']=$beanResumen->tct_tipo_cuenta_f_c;
                $arr_principal['factoring']['fecha_pago']= $beanResumen->factoring_fecha_pago;
                if(!empty($beanResumen->factoring_anexos_activos) && $beanResumen->factoring_anexos_activos!="")
                {
                    $arr_principal['factoring']['anexos_activos']= $beanResumen->factoring_anexos_activos;
                }
                if(!empty($beanResumen->factoring_anexos_historicos) && $beanResumen->factoring_anexos_historicos!="")
                {
                    $arr_principal['factoring']['anexos_historicos']= $beanResumen->factoring_anexos_historicos;
                }


                //Recupera Credito Auto
                // $arr_principal['credito_auto']['tipo_cuenta']=$beanResumen->tct_tipo_cuenta_ca_c;
                $arr_principal['credito_auto']['fecha_pago']= $beanResumen->cauto_fecha_pago;
                if(!empty($beanResumen->cauto_anexos_activos) && $beanResumen->cauto_anexos_activos!="")
                {
                    $arr_principal['credito_auto']['anexos_activos']= $beanResumen->cauto_anexos_activos;
                }
                if(!empty($beanResumen->cauto_anexos_historicos) && $beanResumen->cauto_anexos_historicos!="")
                {
                    $arr_principal['credito_auto']['anexos_historicos']= $beanResumen->cauto_anexos_historicos;
                }

                //Recupera Fleet
                // $arr_principal['fleet']['tipo_cuenta']=$beanResumen->tct_tipo_cuenta_fl_c;

                //Recupera Crédito SOS
                $arr_principal['credito_sos']['fecha_pago']=$beanResumen->sos_fecha_pago_c;

				//Recupera Uniclick
                // $arr_principal['uniclick']['tipo_cuenta']=$beanResumen->tct_tipo_cuenta_uc_c;
                $arr_principal['uniclick']['fecha_pago']= $beanResumen->cauto_fecha_pago;

                //Recupera Unilease
                // $arr_principal['uniclick']['tipo_cuenta']=$beanResumen->tct_tipo_cuenta_uc_c;
                $arr_principal['unilease']['fecha_pago']= $beanResumen->cauto_fecha_pago;

                //Recupera Clasificación Sectorial INEGI
                $arr_principal['inegi']['inegi_rama'] = $beanResumen->inegi_rama_c;
                $arr_principal['inegi']['inegi_subrama'] = $beanResumen->inegi_subrama_c;
                $arr_principal['inegi']['inegi_sector'] = $beanResumen->inegi_sector_c;
                $arr_principal['inegi']['inegi_subsector'] = $beanResumen->inegi_subsector_c;
                $arr_principal['inegi']['inegi_clase'] = $beanResumen->inegi_clase_c;
                $arr_principal['inegi']['inegi_descripcion'] = $beanResumen->inegi_descripcion_c;

            }
        }

        ############################
        ## Recupera y procesa información de Productos
        ############################
        if ($beanPersona->load_relationship('accounts_uni_productos_1')) {
            //Recupera Productos
            $relateProduct = $beanPersona->accounts_uni_productos_1->getBeans($beanPersona->id,array('disable_row_level_security' => true));

            foreach ($relateProduct as $product) {

                $tipoCuenta = $product->tipo_cuenta;
                $subtipoCuenta = $product->subtipo_cuenta;
                $tipoProducto = $product->tipo_producto;
                $statusProducto = $product->estatus_atencion;
                $cobranza = $product->cobranza_c;

                if ($statusProducto == '' || $statusProducto == null){
                    $statusProducto = '0'; //0 = vacio
                }

                switch ($tipoProducto) {

                    case '1': //Leasing
                        $arr_principal['leasing']['tipo_cuenta'] = $tipoCuenta;
                        $arr_principal['leasing']['subtipo_cuenta'] = $subtipoCuenta;
                        $arr_principal['leasing']['estatus_atencion'] = $statusProducto;
                        $arr_principal['leasing']['cobranza'] = $cobranza;
                        break;
                    case '3': //Credito-Automotriz
                        $arr_principal['credito_auto']['tipo_cuenta'] = $tipoCuenta;
                        $arr_principal['credito_auto']['subtipo_cuenta'] = $subtipoCuenta;
                        $arr_principal['credito_auto']['estatus_atencion'] = $statusProducto;
                        $arr_principal['credito_auto']['cobranza'] = $cobranza;
                        break;
                    case '4': //Factoraje
                        $arr_principal['factoring']['tipo_cuenta'] = $tipoCuenta;
                        $arr_principal['factoring']['subtipo_cuenta'] = $subtipoCuenta;
                        $arr_principal['factoring']['estatus_atencion'] = $statusProducto;
                        $arr_principal['factoring']['cobranza'] = $cobranza;
                        break;
                    case '6': //Fleet
                        $arr_principal['fleet']['tipo_cuenta'] = $tipoCuenta;
                        $arr_principal['fleet']['subtipo_cuenta'] = $subtipoCuenta;
                        $arr_principal['fleet']['estatus_atencion'] = $statusProducto;
                        $arr_principal['fleet']['cobranza'] = $cobranza;
                        break;
                    case '7': //Credito SOS
                        $arr_principal['credito_sos']['estatus_atencion'] = $statusProducto;
                        $arr_principal['credito_sos']['cobranza'] = $cobranza;
                        break;
                    case '8': //Uniclick
                        $arr_principal['uniclick']['tipo_cuenta'] = $tipoCuenta;
                        $arr_principal['uniclick']['subtipo_cuenta'] = $subtipoCuenta;
                        $arr_principal['uniclick']['estatus_atencion'] = $statusProducto;
                        $arr_principal['uniclick']['cobranza'] = $cobranza;
                        break;
                    case '9': //Uniclick
                        $arr_principal['unilease']['tipo_cuenta'] = $tipoCuenta;
                        $arr_principal['unilease']['subtipo_cuenta'] = $subtipoCuenta;
                        $arr_principal['unilease']['estatus_atencion'] = $statusProducto;
                        $arr_principal['unilease']['cobranza'] = $cobranza;
                        break;
                    default:
                        break;
                }
            }
        }

        ############################
        ## Recupera alertas
        ############################
        //Forma petición
        $query = "select * from notifications
        where assigned_user_id='{$current_user->id}'
        and is_read = 0
        and parent_id in ($operaciones_ids)
        order by date_entered asc;";

        //Logs
        //$GLOBALS['log']->fatal($query);

        //Obtiene resultado
        $resultQ = $GLOBALS['db']->query($query);
        $alert_num = 0;

        //Procesa registros recuperados
        while ($row = $GLOBALS['db']->fetchByAssoc($resultQ)) {
          //Recupera alertas y procesa
          $alert_num ++;
          $alerta = array(
            "mensaje"=>str_replace("<br/>","",$row['description']),
            "prioridad"=>$app_list_strings['notifications_severity_list'][$row['severity']],
            "idNotificacion"=>$row['id'],
            "numero"=>$alert_num
          );
          //Agrega alerta a respuesta de salida
          $arr_principal['alertas']['alerta'][] = $alerta;
        }

        //Agrega total de alertas
        $arr_principal['alertas']['total'] = $alert_num;

        ############################
        ## Establecer color para bloques
        ############################
        //Recupera fecha actual
        $timedate = new TimeDate($current_user);
        $today = $timedate->getNow(true);

        /**
          * Leasing:
          * Si la línea está a dos meses de vencer que se pondrá en amarillo. Si está vencida en rojo
        */
        if( $arr_principal['leasing']['fecha_vencimiento'] != ''){
            //Fecha vencimiento
            $dateFVL = $arr_principal['leasing']['fecha_vencimiento'];
            $dateFVL = str_replace('/', '-', $dateFVL);
            $dateFVL = date('Y-m-d', strtotime($dateFVL));

            //Calcula diferencia
            $current_date = new DateTime($today->format("Y-m-d"));
            $fecha_VL = new DateTime($dateFVL);

            $diferencia = $current_date->diff($fecha_VL);
            $meses = ( $diferencia->y * 12 ) + $diferencia->m;

            //Logs
            /*
            $GLOBALS['log']->fatal('Valida fechas Leasign');
            // $GLOBALS['log']->fatal($current_date);
            // $GLOBALS['log']->fatal($fecha_VL);
            $GLOBALS['log']->fatal($meses);
            */

            //Rojo
            if($fecha_VL < $current_date ) {
                $arr_principal['leasing']['color']=$Rojo;
            }
            //amarillo
            if($fecha_VL > $current_date && $meses <= 2) {
                $arr_principal['leasing']['color']=$Amarillo;

            }

        }

        /**
          * Factoring:
          * Si la línea está a dos meses de vencer que se pondrá en amarillo. Si está vencida en rojo
        */
        if( $arr_principal['factoring']['fecha_vencimiento'] != ''){
            //Fecha vencimiento
            $dateFVF = $arr_principal['factoring']['fecha_vencimiento'];
            $dateFVF = str_replace('/', '-', $dateFVF);
            $dateFVF = date('Y-m-d', strtotime($dateFVF));

            //Calcula diferencia
            $current_date = new DateTime($today->format("Y-m-d"));
            $fecha_VL = new DateTime($dateFVF);

            $diferencia = $current_date->diff($fecha_VL);
            $meses = ( $diferencia->y * 12 ) + $diferencia->m;

            //Logs
            /*
            $GLOBALS['log']->fatal('Valida fechas Factoring');
            // $GLOBALS['log']->fatal($current_date);
            // $GLOBALS['log']->fatal($fecha_VL);
            $GLOBALS['log']->fatal($meses);
            */

            //Rojo
            if($fecha_VL < $current_date ) {
                $arr_principal['factoring']['color']=$Rojo;
            }
            //amarillo
            if($fecha_VL > $current_date && $meses <= 2) {
                $arr_principal['factoring']['color']=$Amarillo;

            }

        }

        /**
          * Crédito Auto:
          * Si la línea está a dos meses de vencer que se pondrá en amarillo. Si está vencida en rojo
        */
        if( $arr_principal['credito_auto']['fecha_vencimiento'] != ''){
            //Fecha vencimiento
            $dateFVC = $arr_principal['credito_auto']['fecha_vencimiento'];
            $dateFVC = str_replace('/', '-', $dateFVC);
            $dateFVC = date('Y-m-d', strtotime($dateFVC));

            //Calcula diferencia
            $current_date = new DateTime($today->format("Y-m-d"));
            $fecha_VL = new DateTime($dateFVC);

            $diferencia = $current_date->diff($fecha_VL);
            $meses = ( $diferencia->y * 12 ) + $diferencia->m;

            //Logs
            /*
            $GLOBALS['log']->fatal('Valida fechas Creduti auto');
            // $GLOBALS['log']->fatal($current_date);
            // $GLOBALS['log']->fatal($fecha_VL);
            $GLOBALS['log']->fatal($meses);
            */

            //Rojo
            if($fecha_VL < $current_date ) {
                $arr_principal['credito_auto']['color']=$Rojo;
            }
            //amarillo
            if($fecha_VL > $current_date && $meses <= 2) {
                $arr_principal['credito_auto']['color']=$Amarillo;

            }

        }

        /**
          * Historial de contacto:
          * Amarillo cuando hayan pasado más de 2 meses sin cita/llamada y rojo más de 3 meses.
        */
        if ($arr_principal['historial_contactos']['llamadas'] >= 1 || $arr_principal['historial_contactos']['citas'] >= 1) {
            //Today
            // $timedate = new TimeDate($current_user);
            // $today = $timedate->getNow(true);

            //Última reunión
            //$dateFR = $arr_principal['historial_contactos']['fecha_completa_cita'];
            //$timedateFR = new TimeDate();
            //$fecha_cita = $timedateFR->fromUser($dateFR, $current_user);

            $dateFR = $arr_principal['historial_contactos']['fecha_completa_cita'];
            $timedateFR = new TimeDate();
            $fecha_cita = $timedateFR->fromDb($dateFR);
            // $GLOBALS['log']->fatal('fecha de cita:');
            // $GLOBALS['log']->fatal($fecha_cita);
            //Última llamada
            // $dateFL = $arr_principal['historial_contactos']['fecha_completa_llamada'];
            // $timedateFL = new TimeDate();
            // $fecha_llamada = $timedateFL->fromUser($dateFL, $current_user);
            $dateFL = $arr_principal['historial_contactos']['fecha_completa_llamada'];
            $timedateFL = new TimeDate();
            $fecha_llamada = $timedateFL->fromDb($dateFL);
            // $GLOBALS['log']->fatal('fecha de llamada:');
            // $GLOBALS['log']->fatal($fecha_llamada);

            //Recupera última fecha de contacto
            $fecha_contacto = "";
            if ($fecha_llamada > $fecha_cita) {
              $fecha_contacto = $fecha_llamada;
            }else {
              $fecha_contacto = $fecha_cita;
            }

            // $GLOBALS['log']->fatal('fecha de contacto:');
            // $GLOBALS['log']->fatal($fecha_contacto);
            //Calcula diferencia
            $current_date = new DateTime($today->format("Y-m-d"));
            $fecha_contacto = new DateTime($fecha_contacto->format("Y-m-d"));

            $diferencia = $current_date->diff($fecha_contacto);
            $meses = ( $diferencia->y * 12 ) + $diferencia->m;

            // $GLOBALS['log']->fatal('diferencia:');
            // $GLOBALS['log']->fatal($meses);

            //Asigna color
            if($current_date > $fecha_contacto){
                if($meses == 2){
                    $arr_principal['historial_contactos']['color'] = $Amarillo;
                }
                if ($meses >= 3) {
                    $arr_principal['historial_contactos']['color'] = $Rojo;
                }
            }

            //Log
            /*
            $GLOBALS['log']->fatal($today->format("Y-m-d"));
            $GLOBALS['log']->fatal($fecha_contacto->format("Y-m-d"));
            $GLOBALS['log']->fatal($meses);
            */

        }else{
            $arr_principal['historial_contactos']['color'] = $Rojo;
        }


        ############################
        ## Regresa resultado
        // $GLOBALS['log']->fatal('resultado de API:');
        // $GLOBALS['log']->fatal($api->platform);
        //$api->platform;

        return $arr_principal;

    }

}
