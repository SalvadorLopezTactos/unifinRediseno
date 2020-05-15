<?php
/**
 * Created by salvador.lopez@tactos.com.mx
 * Se lanza integración con Unics para establecer producto Unilease cuando se detecta que la línea es AUTORIZADA
 */

class ProductUnilease
{

    function setUnicsUnilease($bean = null, $event = null, $args = null)
    {
        global $sugar_config,$db;

        if ($bean->tipo_producto_c == '9' && $bean->estatus_c=="N" && $bean->unilease_integracion_c==0) {

            $GLOBALS['log']->fatal("Inicia Integracion UNILEASE");
            $url=$sugar_config['url_uni2_unilease'];
            $idSolicitud=$bean->idsolicitud_c;
            $idLineaCredito=$bean->id_process_c;

            $body = array(
                "idSolicitud" => $idSolicitud,
                "idLineaCredito" => $idLineaCredito

            );

            $GLOBALS['log']->fatal(print_r($body,true));
            $callApi = new UnifinAPI();
            $resultado = $callApi->unifinPostCall($url,$body);
            $GLOBALS['log']->fatal("Respuesta uni2 Unilease");
            $GLOBALS['log']->fatal($resultado);
            if($resultado['code']==0){
                $bean->unilease_integracion_c=1;
                $query = <<<SQL
UPDATE opportunities_cstm SET unilease_integracion_c =1
WHERE id_c = '{$bean->id}'
SQL;
                $queryResult = $db->query($query);

            }

        }
    }
}