<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20/05/20
 * Time: 12:55 PM
 */


class LineaUNICS
{
    function create_LC_unics($bean = null, $event = null, $args = null)
    {
        global $sugar_config,$db;
        //traer el bean de la cuenta para obtener regimen fiscal
        $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id);
        $beanUsuario = BeanFactory::retrieveBean('Users', $bean->asigned_user_id);

        if ($bean->tipo_producto_c == '8' && $bean->estatus_c=="N") {

            $GLOBALS['log']->fatal("Inicia create_LC_unics para creacion de Linea de credito UNICS");
            //Declara variables globales para la peticion del servicio Mambu
            $url=$sugar_config['url_unics_credit'];

            $body = array(
                "idSolicitud"=> $bean->idsolicitud_c,
                "idLinea"=> $bean->id_linea_credito_c,
                "idCliente"=> $beanCuenta->idcliente_c,
                "idPromotor"=> $beanUsuario->tct_id_unics_txf_c,
                "regimenFiscal"=> $beanCuenta->tipodepersona_c,
                "monto"=> $bean->monto_c,
                "vigencia"=> $bean->vigencialinea_c,
                "nombreLinea"=>$bean->name
            );

            $GLOBALS['log']->fatal(print_r($body,true));
            //Llama a UnifinAPI para que realice el consumo de servicio a Mambu
            $callApi = new UnifinAPI();
            $resultado = $callApi->postUNICS($url,$body);
            $GLOBALS['log']->fatal(print_r($resultado, true));

            if($resultado['resultCode']==0){
                $GLOBALS['log']->fatal('Ha realizado correctamente la linea de crédito a UNICS con la cuenta ' .$bean->name);
                $bean->unics_integracion_c=1;
                //Setear valor en campo nuevo 'resultCode'
                $updatefield = "UPDATE opportunities_cstm
                              SET unics_integracion_c =1
                              WHERE id_c = '".$bean->id."'";
                $GLOBALS['log']->fatal($updatefield);
                $queryResult = $db->query($updatefield);
            }else{
                $GLOBALS['log']->fatal("Error al procesar la solicitud, verifique información");
            }
        }
        $GLOBALS['log']->fatal('create_LC_unics para mandar Solicitudes a UNICS: END');
    }
}