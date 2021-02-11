<?php
/**
 * Created by JG.
 * User: tactos
 * Date: 21/12/20
 * Time: 12:47 PM
 */

class IntegracionQuantico
{
    public function QuanticoIntegracion($bean = null, $event = null, $args = null)
    {
        global $sugar_config, $db,$app_list_strings;
        $user = $sugar_config['quantico_usr'];
        $pwd = $sugar_config['quantico_psw'];
        $auth_encode = base64_encode($user . ':' . $pwd);
        $arrayBo = explode(',', $bean->usuario_bo_c);
        if ($bean->idsolicitud_c != "" && $bean->id_process_c != "" && $bean->quantico_id_c == "") {
            $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id, array('disable_row_level_security' => true));

            if($beanCuenta->tipodepersona_c=='Persona Fisica')
            {
                $tipoPersona="1";
            }
            if ($beanCuenta->tipodepersona_c=='Persona Fisica con Actividad Empresarial')
            {
                $tipoPersona="2";
            }
            if ($beanCuenta->tipodepersona_c=='Persona Moral')
            {
                $tipoPersona="3";
            }

            //Se define URL
            $host=$sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/PostRegister';
            $beanUser = BeanFactory::retrieveBean('Users', $bean->assigned_user_id);
            $idActiveDirectory=$beanUser->id_active_directory_c;

            $body = array(
                "RequestId" => $bean->idsolicitud_c,
                "ProcessId" => $bean->id_process_c,
                "OpportunitiesId" => $bean->id,
                "ClientId" => $bean->account_id,
                "ClientName" => $bean->account_name,
                "ProductId" => $bean->producto_financiero_c,
                "RequestTypeId" => $bean->tipo_de_operacion_c,
                "PersonTypeId" => $tipoPersona,
                "ProductTypeId" => $bean->tipo_producto_c,
                "CurrencyTypeId" => "1",
                "RequestAmount" => $bean->monto_c,
                "IncreaseAmount" => "0",
                "AdviserId" => $idActiveDirectory,
                "AdviserName" => $bean->assigned_user_name,
                //"SinglePaymentPercentage"=>$bean->porciento_ri_c,
                "SinglePaymentPercentage" => '0',
                "CreditLineId" => '0',
                "BackOfficeId" => str_replace("^","", $arrayBo[0]),
                "BackOfficeName" =>$app_list_strings['usuario_bo_0'][str_replace("^","",$arrayBo[0])]
            );
            $GLOBALS['log']->fatal('Body Quantico integracion ' . json_encode($body));
            $callApi = new UnifinAPI();
            $resultado = $callApi->postQuantico($host,$body,$auth_encode);
            $GLOBALS['log']->fatal('Resultado: PEticion Quantico integracion ' . json_encode($resultado));

            if ($resultado['Success']) {
                $GLOBALS['log']->fatal('Ha realizado correctamente');
                $query = "UPDATE opportunities_cstm
                              SET quantico_id_c ='{$resultado['ErrorMessage']}'
                              WHERE id_c = '{$bean->id}'";
                $queryResult = $db->query($query);
                $bean->quantico_id_c=$resultado['ErrorMessage'];

            } else {
                $GLOBALS['log']->fatal("Error al procesar la solicitud a Quantico, verifique información");
            }

        }


    }

    public function QuanticoUpdate($bean = null, $event = null, $args = null)
    {
        $GLOBALS['log']->fatal('Inicia QuanticoUpdate');
        global $sugar_config, $db,$app_list_strings,$current_user;
        $user = $sugar_config['quantico_usr'];
        $pwd = $sugar_config['quantico_psw'];
        $auth_encode = base64_encode($user . ':' . $pwd);
        
        if ($bean->idsolicitud_c != "" && $bean->quantico_id_c != "" && $bean->cancelado_quantico_c=="" && $bean->tct_oportunidad_perdida_chk_c) {
            $GLOBALS['log']->fatal('Inicia QuanticoUpdate');
            //Se genera mensaje mediante las opciones de cancelacion
            $mensaje="";
            if($bean->tct_razon_op_perdida_ddw_c!=""){
                switch ($bean->tct_razon_op_perdida_ddw_c) {
                    case 'P':
                        $mensaje = "El motivo de cancelación es el precio.";
                        break;
                    case 'C':
                        $mensaje = "El motivo de cancelación se debe a que la empresa" .$bean->tct_competencia_quien_txf_c ." ".$bean->tct_competencia_porque_txf_c;
                        break;
                    case 'NPR':
                        $mensaje = "No se cuenta con el producto ".$bean->tct_sin_prod_financiero_ddw_c;
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
            $host=$sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/CancelCreditRequest';

            $body = array(
                "RequestNumber" => $bean->idsolicitud_c,
                "UserComercialId" => $current_user->id_active_directory_c,
                "Comment" => $mensaje
            );
            $callApi = new UnifinAPI();
            $resultado = $callApi->postQuantico($host,$body,$auth_encode);
            $GLOBALS['log']->fatal('Resultado: Actualizacion Quantico ' . json_encode($resultado));

            if ($resultado['Success'] && $resultado['ErrorMessage']=="") {
                $GLOBALS['log']->fatal('Actualización Correcta');
                $query = "UPDATE opportunities_cstm
                              SET cancelado_quantico_c ='Actualización Correcta de Quantico.'
                              WHERE id_c = '{$bean->id}'";
                $queryResult = $db->query($query);
                $bean->cancelado_quantico_c=$resultado['ErrorMessage'];
            } else {
                $GLOBALS['log']->fatal("Error al actualizar a Quantico");
            }
        }
        $GLOBALS['log']->fatal('Finaliza QuanticoUpdate');
    }

}