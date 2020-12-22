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
        if ($bean->idsolicitud_c != "" && $bean->id_process_c != "" && ($bean->tipo_producto_c == "1" || $bean->tipo_producto_c == "3"
                || $bean->tipo_producto_c == "4") && $bean->quantico_id_c == "") {
            $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id, array('disable_row_level_security' => true));
            $body = array(
                "RequestId" => $bean->idsolicitud_c,
                "ProcessId" => $bean->id_process_c,
                "ClientId" => $bean->account_id,
                "ClientName" => $bean->account_name,
                "ProductId" => $bean->producto_financiero_c,
                "RequestTypeId" => $bean->tipo_de_operacion_c,
                "PersonTypeId" => $beanCuenta->tipodepersona_c,
                "ProductTypeId" => $bean->tipo_producto_c,
                "CurrencyTypeId" => "1",
                "RequestAmount" => $bean->monto_c,
                "IncreaseAmount" => "0",
                "AdviserId" => $bean->assigned_user_id,
                "AdviserName" => $bean->assigned_user_name,
                //"SinglePaymentPercentage"=>$bean->porciento_ri_c,
                "SinglePaymentPercentage" => '0',
                "CreditLineId" => '0',
                "BackOfficeId" => str_replace("^","", $arrayBo[0]),
                "BackOfficeName" =>$app_list_strings['usuario_bo_0'][str_replace("^","",$arrayBo[0])]
            );
            $callApi = new UnifinAPI();
            $resultado = $callApi->postQuantico($body, $auth_encode);
            $GLOBALS['log']->fatal('Resultado: PEticion Quantico integracion ' . json_encode($resultado));
            if ($resultado['Success']) {
                $GLOBALS['log']->fatal('Ha realizado correctamente');
                $query = "UPDATE opportunities_cstm
                              SET quantico_id_c ='" . $resultado['ErrorMessage'] . "'
                              WHERE id_c = '" . $bean->id . "'";
                $queryResult = $db->query($query);
            } else {
                $GLOBALS['log']->fatal("Error al procesar la solicitud a Quantico, verifique información");
            }

        }


    }

}