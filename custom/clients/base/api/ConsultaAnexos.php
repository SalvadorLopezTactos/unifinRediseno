<?php
/**
 * Created by Tactos.
 * User: AFlores
 * Date: 15/05/2018
 * Description: API para obtener inforación a través de stored procedure;
    * Leasing - Anexos activos
    * Factoraje - Cesiones activas
    * C.Auto - Contratos activos
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");

class ConsultaAnexos extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //POST
            'POST_ConsultaAnexos' => array(
                //request type
                'reqType' => 'POST',
                //endpoint path
                'path' => array('ConsultaAnexos'),
                //endpoint variables
                'pathVars' => array(),
                //method to call
                'method' => 'getConsultaAnexos',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Recupera; Leasign-Anexos || Factoraje-Cesiones || C.Auto-Contratos',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    public function getConsultaAnexos($api, $args)
    {
        ############################
        ## Recupera atributos para petición
        $idCliente = $args['data']['id_cliente'];
        $tipo_peticion = $args['data']['tipo_peticion'];
        $idTipoProducto = 0;
        //Añadir atributo para historicos
        $tipo= "";

        ############################
        ## Genera estructura default
        $arr_principal = array();
        //Define estructura
        $arr_principal['titulo_modal'] = '';
        $arr_principal['anexos_activos'] = array();
        $arr_principal['cesiones_activas'] = array();
        $arr_principal['contratos_activos'] = array();
        $arr_principal['anexos_historicos'] = array();
        $arr_principal['cesiones_historicas'] = array();
        $arr_principal['contratos_historicos'] = array();
        $arr_principal['habilita_anexos_activos'] = false;
        $arr_principal['habilita_cesiones_activas'] = false;
        $arr_principal['habilita_contratos_activos'] = false;
        $arr_principal['suma_saldo_insoluto'] = 0;
        $arr_principal['totales_anexos_activos'] = array();
        $arr_principal['totales_cesiones_activas'] = array();
        $arr_principal['totales_contratos_activos'] = array();
        $arr_principal['totales_anexos_historicos'] = array();
        $arr_principal['totales_cesiones_historicas'] = array();
        $arr_principal['totales_contratos_historicos'] = array();


        ############################
        ## Establece valores de resultado
        //Asigna titulo
        switch ($tipo_peticion) {
          case 'anexos_activos':
            //Leasing
            $arr_principal['titulo_modal'] = 'Anexos activos';
            $arr_principal['habilita_anexos_activos'] = true;
            $idTipoProducto = 1;
            $tipo=0;
            break;
          case 'cesiones_activas':
            //Factoraje
            $arr_principal['titulo_modal'] = 'Cesiones activas';
            $arr_principal['habilita_cesiones_activas'] = true;
            $idTipoProducto = 4;
            $tipo=0;
            break;
          case 'contratos_activos':
            //CA
            $arr_principal['titulo_modal'] = 'Contratos activos';
            $arr_principal['habilita_contratos_activos'] = true;
            $idTipoProducto = 3;
            $tipo=0;
            break;
        case 'anexos_historicos':
            //Leasing
            $arr_principal['titulo_modal'] = 'Anexos Históricos';
            $arr_principal['habilita_anexos_activos_historicos'] = true;
            $idTipoProducto = 1;
            $tipo=1;
            break;
        case 'cesiones_historicas':
            //Factoraje
            $arr_principal['titulo_modal'] = 'Cesiones Históricas';
            $arr_principal['habilita_cesiones_activas_historicas'] = true;
            $idTipoProducto = 4;
            $tipo=1;
            break;
        case 'contratos_historicos':
            //CA
            $arr_principal['titulo_modal'] = 'Contratos Históricos';
            $arr_principal['habilita_contratos_activos_historicos'] = true;
            $idTipoProducto = 3;
            $tipo=1;
            break;
          default:
            $arr_principal['titulo_modal'] = '...';
            break;
        }


        //Consume servicio Anexos
        global $sugar_config;
        $url = $sugar_config['dwh_host_api'];
        $host = $url . "/contratos?cliente=".$idCliente."&prod=".$idTipoProducto."&tipo=".$tipo;
        //$host = $url . "/contratos?cliente=308&prod=1&tipo=0";
        $GLOBALS['log']->fatal($host);
        try {
            $callApi = new UnifinAPI();
            $GLOBALS['log']->fatal('---Petición Anexos---');
            $response = $callApi->unifingetCall($host);
            $GLOBALS['log']->fatal($response);
        } catch (Exception $e) {
            $response = null;
        }

        $GLOBALS['log']->fatal('TipoProducto: '. $idTipoProducto.'- peticion: '. $tipo_peticion);
        if (count($response)>0) {
            //Procesa resultado
            switch ($idTipoProducto) {
                case 1:
                    foreach ($response as $key => $value) {
                        //Anexos activos
                        $arr_principal[$tipo_peticion][] = array(
                            "columna1" => $value['Activo'],
                            "columna2" => $value['CntrNumero'],
                            "columna3" => $value['FechaActivacion'],
                            "columna4" => $value['FechaTerminacion'],
                            "columna5" => $value['Renta'],
                            "columna6" => $value['ProximaRenta'],
                            "columna7" => $value['VigenciaSeguro'],
                            "columna8" => $value['Monto'],
                            "columna9" => $value['MontoRenta'],
                            "columna10" => $value['MontoActivado'],
                            "columna11" => $value['ValorResidualsnIVA'],
                            "columna12" => $value['SaldoInsoluto'],
                            "columna13" => $value['CarteraVencida'],
                            "columna14" => $value['Moratorios'],
                            "columna15" => $value['DiasMora'],
                            "columna16" => $value['Tasa'],
                            "columna17" => $value['EstatusContrato'],

                        );

                        $arr_principal['totales_'.$tipo_peticion]['columna9']+= $value['MontoRenta'];
                        $arr_principal['totales_'.$tipo_peticion]['columna10']+= $value['MontoActivado'];
                        $arr_principal['totales_'.$tipo_peticion]['columna11']+= $value['ValorResidualsnIVA'];
                        $arr_principal['totales_'.$tipo_peticion]['columna12']+= $value['SaldoInsoluto'];
                        $arr_principal['totales_'.$tipo_peticion]['columna13']+= $value['CarteraVencida'];
                        $arr_principal['totales_'.$tipo_peticion]['columna14']+= $value['Moratorios'];
                        $arr_principal['totales_'.$tipo_peticion]['columna15']= ($value['DiasMora']>$arr_principal['totales_'.$tipo_peticion]['columna15'])? $value['DiasMora']:$arr_principal['totales_'.$tipo_peticion]['columna15'];
                    }
                    break;
                case 3:
                    foreach ($response as $key => $value) {
                        //Contratos activos
                        $arr_principal[$tipo_peticion][] = array(
                            "columna1" => $value['Activo'],
                            "columna2" => $value['CntrNumero'],
                            "columna3" => $value['FechaActivacion'],
                            "columna4" => $value['FechaTerminacion'],
                            "columna5" => $value['Renta'],
                            "columna6" => $value['ProximaRenta'],
                            "columna7" => $value['VigenciaSeguro'],
                            "columna8" => $value['Monto'],
                            "columna9" => $value['SaldoInsoluto'],
                            "columna10" => $value['CarteraVencida'],
                            "columna11" => $value['Moratorios'],
                            "columna12" => $value['DiasMora'],
                            "columna13" => $value['Tasa'],
                            "columna14" => $value['EstatusContrato'],
                        );
                        $arr_principal['suma_saldo_insoluto'] += $value['SaldoInsoluto'];

                        $arr_principal['totales_'.$tipo_peticion]['columna8']+= $value['Monto'];
                        $arr_principal['totales_'.$tipo_peticion]['columna10']+= $value['CarteraVencida'];
                        $arr_principal['totales_'.$tipo_peticion]['columna11']+= $value['Moratorios'];
                        $arr_principal['totales_'.$tipo_peticion]['columna12']= ($value['DiasMora']>$arr_principal['totales_'.$tipo_peticion]['columna12'])? $value['DiasMora']:$arr_principal['totales_'.$tipo_peticion]['columna12'];

                    }
                    break;
                case 4:
                    foreach ($response as $key => $value) {
                        //Cesiones activas
                        $arr_principal[$tipo_peticion][] = array(
                            "columna1" => $value['NumeroCesion'],
                            "columna2" => $value['Deudor'],
                            "columna3" => $value['FechaVencimiento'],
                            "columna4" => $value['MontoVencerFinanciado'],
                            "columna5" => $value['MontoDescuento'],
                            "columna6" => $value['CntrNumero'],
                            "columna7" => $value['FechaVencimientoContrato'],
                            "columna8" => $value['CarteraVencida'],
                            "columna9" => $value['Moratorios'],
                            "columna10" => $value['DiasMora'],
                            "columna11" => $value['EstatusContrato'],
                        );

                        $arr_principal['totales_'.$tipo_peticion]['columna4']+= $value['MontoVencerFinanciado'];
                        $arr_principal['totales_'.$tipo_peticion]['columna5']+= $value['MontoDescuento'];
                        $arr_principal['totales_'.$tipo_peticion]['columna8']+= $value['CarteraVencida'];
                        $arr_principal['totales_'.$tipo_peticion]['columna9']+= $value['Moratorios'];
                        $arr_principal['totales_'.$tipo_peticion]['columna10']= ($value['DiasMora']>$arr_principal['totales_'.$tipo_peticion]['columna10'])? $value['DiasMora']:$arr_principal['totales_'.$tipo_peticion]['columna10'];

                    }
                    break;
                default:
                    break;
            }

        }else{
            $GLOBALS['log']->fatal('---Sin resultSet1---');
        }



        return $arr_principal;
    }

  }
