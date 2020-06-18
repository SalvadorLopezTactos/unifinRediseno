<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/06/20
 * Time: 11:40 AM
 */

require_once("custom/Levementum/UnifinAPI.php");

class Obtain_idCorto
{
    function idCortoCB($bean = null, $event = null, $args = null)
    {
        //Condicion para realizar consumo de API para obtener el id corto y asignarlo a la cuenta bancaria
        if ($bean->idcorto_c == "" || $bean->idcorto_c == null) {
            global $sugar_config;
            $GLOBALS['log']->fatal('Hace consulta idCortoCB para obtener folio');
            //URL para consulta en mambu
            $url = $sugar_config['url_cliente_corto'].'rest/uniclick/foliador';

            $body=array(
                "moduloFoliador"=>"CuentaBancaria"
            );
            //Ejecuta consulta a mambu
            $callApi = new UnifinAPI();
            $resultado = $callApi->postidcorto($url,$body);
            $GLOBALS['log']->fatal('Resultado: ' . json_encode($resultado));
            $GLOBALS['log']->fatal('Ejecutó consulta para obtener folio');

            if ($resultado['resultCode']===0) {
                $bean->idcorto_c=$resultado['data']['folio'];
            }
            $GLOBALS['log']->fatal('Termina mambu_idcorto');
        }
    }
}