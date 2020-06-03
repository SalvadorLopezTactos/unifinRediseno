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

        ############################
        ## Genera estructura default
        $arr_principal = array();
        //Define estructura
        $arr_principal['titulo_modal'] = '';
        $arr_principal['anexos_activos'] = array();
        $arr_principal['cesiones_activas'] = array();
        $arr_principal['contratos_activos'] = array();
        $arr_principal['habilita_anexos_activos'] = false;
        $arr_principal['habilita_cesiones_activas'] = false;
        $arr_principal['habilita_contratos_activos'] = false;
        $arr_principal['suma_saldo_insoluto'] = 0;


        ############################
        ## Establece valores de resultado
        //Asigna titulo
        switch ($tipo_peticion) {
          case 'anexos_activos':
            //Leasing
            $arr_principal['titulo_modal'] = 'Anexos activos';
            $arr_principal['habilita_anexos_activos'] = true;
            $idTipoProducto = 1;
            break;
          case 'cesiones_activas':
            //Factoraje
            $arr_principal['titulo_modal'] = 'Cesiones activas';
            $arr_principal['habilita_cesiones_activas'] = true;
            $idTipoProducto = 4;
            break;
          case 'contratos_activos':
            //CA
            $arr_principal['titulo_modal'] = 'Contratos activos';
            $arr_principal['habilita_contratos_activos'] = true;
            $idTipoProducto = 3;
            break;
          default:
            $arr_principal['titulo_modal'] = '...';
            break;
        }

        //Consume servicio Anexos
        global $sugar_config;
        $url = $sugar_config['esb_url'];
        $host = $url . "/crm/rest/obtieneAnexosCesiones";
        $fields = array(
                "idCliente" => $idCliente, //15358
                "idTipoProducto" => $idTipoProducto
            );

        try {
            $callApi = new UnifinAPI();
            $GLOBALS['log']->fatal('---Petición Anexos---');
            $response = $callApi->unifinpostCall($host, $fields);
            //$GLOBALS['log']->fatal($response);
        } catch (Exception $e) {
            $response = null;
        }


        if ($response['resultSet1']) {
            //Procesa resultado
            switch ($idTipoProducto) {
                case 1:
                    foreach ($response['resultSet1'] as $key => $value) {
                        //Anexos activos
                        $arr_principal['anexos_activos'][] = array(
                            "columna1" => $value['Activo'],
                            "columna2" => $value['CntrNumero'],
                            "columna3" => $value['FechaActivacion'],
                            "columna4" => $value['FechaTerminacion'],
                            "columna5" => $value['Renta'],
                            "columna6" => $value['ProximaRenta'],
                            "columna7" => $value['VigenciaSeguro'],
                            "columna8" => $value['Monto'],
                            "columna9" => $value['MontoRenta'],
                        );
                    }
                    break;
                case 3:
                    foreach ($response['resultSet1'] as $key => $value) {
                        //Anexos activos
                        $arr_principal['contratos_activos'][] = array(
                            "columna1" => $value['Activo'],
                            "columna2" => $value['CntrNumero'],
                            "columna3" => $value['FechaActivacion'],
                            "columna4" => $value['FechaTerminacion'],
                            "columna5" => $value['Renta'],
                            "columna6" => $value['ProximaRenta'],
                            "columna7" => $value['VigenciaSeguro'],
                            "columna8" => $value['Monto'],
                            "columna9" => $value['SaldoInsoluto'],
                        );
                        $arr_principal['suma_saldo_insoluto'] += $value['SaldoInsoluto'];

                    }
                    break;
                case 4:
                    foreach ($response['resultSet1'] as $key => $value) {
                        //Anexos activos
                        $arr_principal['cesiones_activas'][] = array(
                            "columna1" => $value['NumeroCesion'],
                            "columna2" => $value['Deudor'],
                            "columna3" => $value['FechaVencimiento'],
                            "columna4" => $value['MontoVencerFinanciado'],
                            "columna5" => $value['MontoDescuento'],
                        );
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
