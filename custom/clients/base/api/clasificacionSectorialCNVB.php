<?php
/**
 * Created by TCT.
 * User: erick.cruz@tactos.com.mx
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class clasificacionSectorialCNVB extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('clasificacionSectorialCNVB','?','?'),
                //endpoint variables
                'pathVars' => array('module','idActividadEconomica','idSubSector'),
                //method to call
                'method' => 'getSectorCNVB',
                //short help string to be displayed in the help documentation
                'shortHelp' => '',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    /**
     * Establece nuevo valor a campo de anexos en el módulo de resumen
     **
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento
     * @return array $response Array con estado de la referencia actualizada
     * @throws SugarApiExceptionInvalidParameter
     */
    public function getSectorCNVB($api, $args)
    {
        $response=array();
		
		$ActividadEconomica=$args['idActividadEconomica'];
        $SubSector=$args['idSubSector'];
		
        if( !(empty($ActividadEconomica)) && !(empty($SubSector)) ){
			//$GLOBALS['log']->fatal('ActividadEconomica',$ActividadEconomica);
            //Obtener id de cuenta con el idCliente del parámetro
            
			$query = 'select * from catalogo_clasificacion_sectorial where id_actividad_economica_cnbv = "'.$ActividadEconomica.'" and id_subsector_economico_cnbv = "'.$SubSector.'"';
			$results = $GLOBALS['db']->query($query);
			$row = $GLOBALS['db']->fetchByAssoc($results);
			// $GLOBALS['log']->fatal('row',$row);
        }
		
		if( $results->num_rows > 0 ){
			
			$response = $row;
			
		}else{
			$response['code']='400';
			$response['status']='Error';
			$response['description']='No existe la Actividad economica proporcinada';
		}

        return $response;

    }


}

?>
