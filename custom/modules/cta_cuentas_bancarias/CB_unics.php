<?php
/**
 * Created by Adrian Arauz
 * Date: 26/06/20
 * Time: 09:48 AM
 */



require_once("custom/Levementum/UnifinAPI.php");

class envio_unics
{

    function Envia_UNICS($bean = null, $event = null, $args = null)
    {
        global $sugar_config, $db, $app_list_strings;
        $bank = $app_list_strings['banco_list'];
        //traer el bean de la cuenta para obtener el encodedkey_mambu_c
        $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->cta_cuentas_bancarias_accountsaccounts_ida, array('disable_row_level_security' => true));

        //Condicion para crear la cuenta en UNICS considerando $bean->ext2==""
        if ($bean->ext2 == "" && $bean->idcorto_c!= "" && $beanCuenta->idcliente_c!= "") {
            $GLOBALS['log']->fatal('Inicia Envio de CB a UNICS');
             $GLOBALS['log']->fatal($url);
            //Variable para envío de información
            $url = $sugar_config['url_unics_cb'] .'rest/uniclick/unicsCreaLinea';

            //Variables y validaciones para el body
            $comparacion = strpos($bean->usos, "^1^");
            if ($comparacion === false) {
                $domiciliacion = "";
            } else {
                $domiciliacion = "2";
            }

            //Validacion para Estado
            $estado = ($bean->estado == 1) ? "A" : "I";

            $body =
                array(
                    "idBanco" => $bean->banco,
                    "clCbCuenta" => $bean->cuenta,
                    "clCbClabe" => $bean->clabe,
                    "clCbsucursal" => $bean->sucursal,
                    "clCbPlaza" => $bean->plaza,
                    "IdUsoCuentaBancaria" => $domiciliacion,
                    "clCbIndicadorEstado" => $estado,
                    "idCuentaBancaria" => $bean->idcorto_c,
                    "idCliente" => $beanCuenta->idcliente_c,
                    "idMoneda" => "1"
                );

            $GLOBALS['log']->fatal('Petición: ' . json_encode($body));
            $callApi = new UnifinAPI();
            $resultado = $callApi->postCBunics($url, $body);
            $GLOBALS['log']->fatal('CREA NUEVA CUENTA BANCARIA en Unics: ' . $beanCuenta->name);
            $GLOBALS['log']->fatal('Resultado: ' . json_encode($resultado));

            if ($resultado['resultCode']===0){
                $bean->ext2="ENVIADO";
            }
        }
        $GLOBALS['log']->fatal('Termina envío de CB a unics');
    }
}