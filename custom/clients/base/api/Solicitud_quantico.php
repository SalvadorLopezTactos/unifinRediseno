<?php
/*/**
 * Created by EJC.
 * User: tactos
 * Date: 11/04/2022
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");

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

        //$data = json_decode($data);
        $GLOBALS['log']->fatal('data',$data);
        return $data;
    }

    public function QuanticoUpdate( $SolId )
    {
        $bean = BeanFactory::getBean('Opportunities', $SolId , array('disable_row_level_security' => true));
        
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

            $GLOBALS['log']->fatal('Resultado: Actualizacion Quantico ' . json_encode($resultado));
        }
        $GLOBALS['log']->fatal('Finaliza QuanticoUpdate');
        return $resultado;
    }

    public function estatus($codigo, $descripcion, $id, $modulo, $errores)
    {
        $array_status = array();
        $array_status['status'] = $codigo;
        $array_status['descripcion'] = $descripcion;
        $array_status['id'] = $id;
        $array_status['modulo'] = $modulo;
        $array_status['errores'] = $errores;


        return $array_status;
    }
    
}
