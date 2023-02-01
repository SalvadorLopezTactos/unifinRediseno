<?php
/*/**
 * Created by EJC.
 * User: tactos
 * Date: 11/04/2022
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/Levementum/UnifinAPI.php');
require_once('custom/modules/Opportunities/clients/base/api/CancelaRatificacion.php');
require_once('custom/modules/Opportunities/clients/base/api/cancelaOperacionBPM.php');

class Solicitud_quantico extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GET_cancel_quantico' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('cancelQuantico','?'),
                'pathVars' => array('module','SolicitudId'),
                'method' => 'cancelaCliente',
                'shortHelp' => 'valida cancela cliente envio de quantico',
            ),
        );
    }

    public function cancelaCliente($api, $args)
    {
        $response_Services = [];
        
        $idSol = $args['SolicitudId'];
        $data = $this->QuanticoUpdate($idSol);

        //$data = '{"Success":false,"Code":"405","ErrorMessage":"El usuario que  intenta cancelar la solicitud no existe en Quantico "}';

        //$data = json_encode($data);
        //$GLOBALS['log']->fatal('data',$data);
        return $data;
    }

    public function QuanticoUpdate( $SolId )
    {
        $bean = BeanFactory::getBean('Opportunities', $SolId , array('disable_row_level_security' => true));
        $GLOBALS['log']->fatal('Id',$bean->id);
        $mensaje = "";
        $codigo = "";
        $servicio = "";
        $estatus = "";

        if ($bean->id != '') {   
        //if ($bean->idsolicitud_c != "" && $bean->quantico_id_c != "" && $bean->cancelado_quantico_c == "" && $bean->tct_oportunidad_perdida_chk_c) {
            $GLOBALS['log']->fatal('Inicia Cancelación de Solicitud Quantico ejc');
            global $sugar_config, $db, $app_list_strings, $current_user;
            $user = $sugar_config['quantico_usr'];
            $pwd = $sugar_config['quantico_psw'];
            $auth_encode = base64_encode($user . ':' . $pwd);
            //Se genera mensaje mediante las opciones de cancelacion
            $mensaje = "";
            
            if ($bean->tct_razon_op_perdida_ddw_c != "") {
                switch ($bean->tct_razon_op_perdida_ddw_c) {
                    case 'P':
                        $mensaje = "El motivo de cancelación es el precio.";
                        break;
                    case 'C':
                        $mensaje = "El motivo de cancelación se debe a que la empresa" . $bean->tct_competencia_quien_txf_c . " " . $bean->tct_competencia_porque_txf_c;
                        break;
                    case 'NPR':
                        $mensaje = "No se cuenta con el producto " . $bean->tct_sin_prod_financiero_ddw_c;
                        break;
                    case 'PRP':
                        $mensaje = "Se pagó con recursos propios.";
                        break;
                    case 'ANF':
                        $mensaje = "Debido a activos no financiables.";
                        break;
                    case 'CDN':
                        $mensaje = "El cliente decide no comprar el activo.";
                        break;
                    case 'CNC':
                        $mensaje = "El cliente decide no ccompletó el expediente.";
                        break;
                    case 'TR':
                        $mensaje = "Debido al tiempo de respuesta.";
                        break;
                    case 'DI':
                        $mensaje = "Debido datos incorrectos/duplicidad.";
                        break;
                    case '10':
                        $mensaje = "Debido que no cumple con el scoring comercial.";
                        break;
                    default:
                        $mensaje;
                }
            }

            //Se define URL
            $host = $sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/CancelCreditRequest';

            $body = array(
                "RequestNumber" => $bean->idsolicitud_c,
                "UserComercialId" => $current_user->id_active_directory_c,
                "Comment" => $mensaje
            );
            $callApi = new UnifinAPI();
            
            $resultado = $callApi->postQuantico($host, $body, $auth_encode);

            $GLOBALS['log']->fatal('Resultado: Actualizacion Quantico ' , $resultado);
            $cancelar = False;
            //{"Success":false,"Code":"405","ErrorMessage":"El usuario que  intenta cancelar la solicitud no existe en Quantico "}
            
            if ($resultado['Success'] != '' && $resultado['ErrorMessage'] == "") {
                $cancelar = True;
            } else {
                //$GLOBALS['log']->fatal("Error al actualizar a Quantico: ");
                $GLOBALS['log']->fatal("Error al actualizar a Quantico: " , $resultado['Code']);
                if($resultado['Code'] == '404'){
                    $cancelar = True;                
                }
            }

            $mensaje = "";
            $codigo = "";
            $servicio = "";
            $estatus = "";
            
            if($cancelar ){
                if ($bean->tct_etapa_ddw_c == "SI" && $bean->tipo_de_operacion_c != "RATIFICACION_INCREMENTO") {
                    
                    $mensaje = "";
                    $estatus = "Success";
                    $codigo = "";
                    $servicio = "";
                    //$bean->estatus_c = 'K';
                    //$bean->save();
                } else {
                    
                    $GLOBALS['log']->fatal('id_process_c : '.$bean->id_process_c);
                    if (trim($bean->id_process_c , "") == "") {
                        $parametros = new stdClass();
                        $parametros->id_linea_padre = $bean->id_linea_credito_c;
                        $parametros->id = $bean->id;
                        $parametros->conProceso = 0;
                        $parametros->tipo_de_operacion_c = $bean->tipo_de_operacion_c;
                        $parametros->tipo_operacion_c = $bean->tipo_operacion_c;
                        
                        $parametrosJSON = json_encode($parametros);

                        $callRatificacion = new CancelaRatificacion();
                        $GLOBALS['log']->fatal('parametrosJSON-ratificaicon : '.$parametrosJSON);
                        $resultado = $callRatificacion->cancelRatificacion($api, $parametrosJSON);
                        $GLOBALS['log']->fatal('resultado_ratificacion: '.$resultado);
                        if ($resultado != null) {
                            $GLOBALS['log']->fatal('Se cancelo padre');
                            //$bean->estatus_c = 'K';
                            //$bean->save();
                            /**************************/
                            $mensaje = "Se cancelo el Padre";
                            $codigo = "";
                            $servicio = "ratificacion";
                            $estatus = "Success";
                            
                            $GLOBALS['log']->fatal('id_process_c: '.$id_process_c);
                        } else {
                            $GLOBALS['log']->fatal('No Se cancelo padre');
                            $mensaje = "No Se cancelo padre";
                            $codigo = "";
                            $servicio = "ratificacion";
                            $estatus = "error";
                            
                        }
                    } else {
                        if ($bean->estatus_c != 'K') {
                            /*
                            $OppParams = new stdClass();
                            $OppParams->idSolicitud = $bean->idsolicitud_c;
                            $OppParams->usuarioAutenticado = $bean->assigned_user_name;
                            $OppParamsJSON = json_encode($OppParams);
                            */
                            $OppParamsJSON = [];
                            $OppParamsJSON['data'] = [];
                            $OppParamsJSON['data']['idSolicitud'] = $bean->idsolicitud_c;
                            $OppParamsJSON['data']['usuarioAutenticado'] = $bean->assigned_user_name;

                            $callOpBPM = new cancelaOperacionBPM();
                            
                            $GLOBALS['log']->fatal('parametrosJSON',$OppParamsJSON);
                            $resultadoRat = $callOpBPM->cancelaOperacion($api, $OppParamsJSON);
                            $GLOBALS['log']->fatal('resultadoRat',$resultadoRat);
                            if ($resultadoRat != null) {
                                if ($resultadoRat->estatus == 'error') {
                                    /*
                                    $mensaje = "Error: " . $resultadoRat->descripcion;
                                    $codigo = "";
                                    $servicio = "operaBpm";
                                    $estatus = "error";
                                    */
                                } else {
                                    /*
                                    $mensaje = "Se ha cancelado la operaci\u00F3n";
                                    $codigo = "";
                                    $servicio = "operaBpm";
                                    $estatus = "Success";
                                    */
                                }
                                // mandamos llamar el servicio para cancelar localmente:                            
                                $parametros = new stdClass();
                                $parametros->id_linea_padre = $bean->id_linea_credito_c;
                                $parametros->id = $bean->id;
                                $parametros->conProceso = 1;
                                $parametros->tipo_de_operacion_c = $bean->tipo_de_operacion_c;
                                $parametros->tipo_operacion_c = $bean->tipo_operacion_c;
                            
                                $parametrosJSON = json_encode($parametros);

                                $callRatificacion = new CancelaRatificacion();
                                //$GLOBALS['log']->fatal('args',$args);
                                $resultado = $callRatificacion->cancelRatificacion($api, $parametrosJSON);
                                if ($resultado != null) {
                                    //$bean->estatus_c = 'K';
                                    //$bean->save();

                                    $mensaje = "Se ha cancelado la operaci\u00F3n";
                                    $codigo = "";
                                    $servicio = "ratificacion";
                                    $estatus = "Success";
                                    
                                    $GLOBALS['log']->fatal('Se cancela padre');
                                } else {
                                    $GLOBALS['log']->fatal('No Se cancelo padre');
                                    $mensaje = "No Se cancelo padre";
                                    $codigo = "";
                                    $servicio = "ratificacion";
                                    $estatus = "error";
                                    
                                }
                            }
                        }else {
                            $mensaje = "Esta Operaci\u00F3n ya habia sido cancelada anteriormente";
                            $codigo = "";
                            $servicio = "";
                            $estatus = "error";
                        }
                    }
                }
            }else{
                $bean->tct_razon_op_perdida_ddw_c = '';
                $bean->tct_oportunidad_perdida_chk_c = $cancelar;
                $bean->save();

                $mensaje = $resultado['ErrorMessage'];
                $estatus = "error";
                $codigo = $resultado['Code'];
                $servicio = "Quantico";
            }
        }
        $GLOBALS['log']->fatal('Finaliza cancelado');

        $data = $this->estatus($codigo,$estatus ,$mensaje,$servicio);
        $GLOBALS['log']->fatal('data',$data);
        return $data;
    }

    public function estatus($codigo , $estatus , $mensaje, $servicio)
    {
        if($codigo == "" && $estatus == "" && $mensaje == "" && $servicio == ""){
            $array_status = "";
        }else{
            $array_status = array();
            $array_status['estatus'] = $estatus;
            $array_status['mensaje'] = $mensaje;
            $array_status['code'] = $codigo;
            $array_status['servicio'] = $servicio;
        }
        
        return $array_status;
    }
    
}
