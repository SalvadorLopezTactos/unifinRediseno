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
        if ($bean->tipo_producto_c == '8' && $bean->estatus_c=="N" && !$bean->unics_integracion_c) {
            $GLOBALS['log']->fatal("Inicia create_LC_unics para creacion de Linea de credito UNICS");
            //Declara variables globales para la peticion del servicio Mambu
            $url=$sugar_config['url_unics_credit'].'/rest/uniclick/unicsCreaLinea';

            //traer el bean de la cuenta para obtener regimen fiscal
            $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id, array('disable_row_level_security' => true));
            //Consulta usuario
            $beanUser = BeanFactory::newBean('Users');
            $sql = new SugarQuery();
            $sql->select('tct_id_unics_txf_c');
            $sql->from($beanUser);
            $sql->Where()->equals('id', $bean->assigned_user_id);
            $result = $sql->execute();
            //Arma petición
            $body = array(
                "idSolicitud"=> $bean->idsolicitud_c,
                "idLinea"=> $bean->id_linea_credito_c,
                "idCliente"=> $beanCuenta->idcliente_c,
                "idPromotor"=> $result[0]['tct_id_unics_txf_c'],
                "regimenFiscal"=> $beanCuenta->tipodepersona_c,
                "monto"=> $bean->monto_c,
                "vigencia"=> $bean->vigencialinea_c,
                "nombreLinea"=>$bean->name
            );
            $GLOBALS['log']->fatal('Petición: '.json_encode($body));
            //Llama a UnifinAPI para que realice el consumo de servicio a Mambu
            $callApi = new UnifinAPI();
            $resultado = $callApi->postUNICS($url,$body);
            $GLOBALS['log']->fatal('Resultado: '.json_encode($resultado));

            //Maneja resultado
            if($resultado['resultCode']==0){
                $GLOBALS['log']->fatal('Ha realizado correctamente la linea de crédito a UNICS con la cuenta ' .$bean->name);
                $bean->unics_integracion_c=1;
                //Setear valor en campo nuevo 'resultCode'
                $updatefield = "UPDATE opportunities_cstm
                              SET unics_integracion_c =1
                              WHERE id_c = '".$bean->id."'";
                $queryResult = $db->query($updatefield);
                //$GLOBALS['log']->fatal($updatefield);
            }else{
                $GLOBALS['log']->fatal("Error al procesar la solicitud, verifique información");
            }
            $GLOBALS['log']->fatal('create_LC_unics para mandar Solicitudes a UNICS: END');
        }

    }
}
