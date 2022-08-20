<?php
/**
 * Created by Tactos
 * User: Eduardo Carrasco Beltrán
 * Date: 29/04/2021
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");
class DisposicionesDWH extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetDisposicionesDWH', '?'),
                //endpoint variables
                'pathVars' => array('method', 'id_cliente'),
                //method to call
                'method' => 'getDisposicionesDWH',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Obtiene disposiciones en proceso de un cliente',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    public function getDisposicionesDWH($api, $args)
    {
        global $sugar_config;
		$id_cliente=$args['id_cliente'];

        $host_dwh = $sugar_config['dwh_host_api'];
        $url_dwh=$host_dwh."/vista360?idcliente=".$id_cliente;
        
        $callApi = new UnifinAPI();
        
        $response = $callApi->unifingetCall($url_dwh);

        if(count($response)>0){
            for ($i=0; $i < count($response); $i++) {
                $response[$i]['numeroSolicitud']="";
                $id_solicitud=$response[$i]['idSolicitud'];
                if($id_solicitud != ""){
                    $beanSolicitud = BeanFactory::getBean("Opportunities", $id_solicitud,array('disable_row_level_security' => true));
                    
                    if(!empty($beanSolicitud)){
                        $numeroSolicitud=$beanSolicitud->idsolicitud_c;
                        $response[$i]['numeroSolicitud']=$numeroSolicitud;
                    }
                }
            }
        }

        return $response;
    }

}
?>
