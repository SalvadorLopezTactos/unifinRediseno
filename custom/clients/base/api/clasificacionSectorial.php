<?php
/**
 * Created by TCT.
 * User: erick.cruz@tactos.com.mx
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class clasificacionSectorial extends SugarApi
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
                'reqType' => 'PUT',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('clasificacionSectorial'),
                //endpoint variables
                'pathVars' => array(),
                //method to call
                'method' => 'setSectorInegiExterno',
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
    public function setSectorInegiExterno($api, $args)
    {
        $response=array();
		
		$bean_Account = null;
		$bean_Resumen = null;
        $idCuenta=$args['idCuenta'];
        $clase=$args['clase'];
		$GLOBALS['log']->fatal('idCuenta',$idCuenta);
        if( isset($idCuenta) && !(empty($idCuenta)) ){
            //Obtener id de cuenta con el idCliente del parámetro
            $bean_Resumen = BeanFactory::retrieveBean('tct02_Resumen', $idCuenta);
			$bean_Account = BeanFactory::retrieveBean('Accounts', $idCuenta);
			
			$query = 'select * from catalogo_clasificacion_sectorial where id_clase_inegi = "'.$clase.'"';
			$results = $GLOBALS['db']->query($query);
			$row = $GLOBALS['db']->fetchByAssoc($results);
			//$GLOBALS['log']->fatal('row',$row);
        }
		
		if(!empty($bean_Account) && !empty($bean_Resumen)){
			if( $results->num_rows > 0 ){
				
				$bean_Account->actividadeconomica_c = $row['id_actividad_economica_cnbv'];
				$bean_Account->subsectoreconomico_c = $row['id_subsector_economico_cnbv']; 
				$bean_Account->sectoreconomico_c = $row['id_sector_economico_cnbv']; 
				$bean_Account->tct_macro_sector_ddw_c = $row['id_macro_sector_cnbv'];
				
				$bean_Resumen->inegi_clase_c = $row['id_clase_inegi'];
                $bean_Resumen->inegi_rama_c = $row['id_rama_inegi'];
                $bean_Resumen->inegi_subrama_c = $row['id_subrama_inegi'];
				$bean_Resumen->inegi_sector_c = $row['id_sector_inegi'];
                $bean_Resumen->inegi_subsector_c = $row['id_subsector_inegi'];
                $bean_Resumen->inegi_descripcion_c = $row['id_descripcion_inegi'];
								
				$bean_Resumen->inegi_acualiza_uni2_c = 1 ;
				
				$bean_Account->save();
				$bean_Resumen->save();
				
				$response['code']='200';
				$response['status']='success';
				$response['description']='Registro actualizado exitosamente';
			}else{
				$response['code']='400';
				$response['status']='Error';
				$response['description']='No existe la clase proporcinada';
			}
			
		}else{
			$response['code']='400';
            $response['status']='Error';
            $response['description']='No existe una cuenta con el id proporcionado';
        }

        return $response;

    }


}

?>
