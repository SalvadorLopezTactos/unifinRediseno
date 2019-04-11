<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 07/08/18
 * Time: 10:07
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetEtapaSubetapa extends SugarApi
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
                'path' => array('GetEtapaSubetapa'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'getEtapaSubetapaMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que regresa los valores concatenados de las dependiencias de las listas de etapa y subetapa',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    /**
     * Método que regresa un arreglo con los valores concatenados de etapa y sus respectivas subetapas dependientes
     *
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento
     * @return array $etapa_subetapa Array con los valores concatenados entre etapa y subetapa
     */
    public function getEtapaSubetapaMethod($api, $args)
    {
        global $app_list_strings;
        //Obteniendo valores de lista dependiente:
        $fields_opp=VardefManager::getFieldDefs('Opportunities');
        $val_dependientes=$fields_opp['estatus_c']['visibility_grid']['values'];

        $lista_padre='tct_etapa_ddw_c_list';
        $lista_padre_values=$app_list_strings[$lista_padre];

        $etapa_subetapa=array();
        $i=0;
        foreach ($val_dependientes as $key=>$val){
            $valor_lista=$lista_padre_values[$key];
            if($valor_lista != "" && $valor_lista != null){
                //Obtener etiqueta
                $label=$valor_lista;
                $nombre_lista_sub='estatus_c_operacion_list';
                $list_val_sub=$app_list_strings[$nombre_lista_sub];
                //Recorrer el val y obtener la etiqueta de la posición actual
                foreach ($val as $k=>$v){

                    if($list_val_sub[$v] != null){
                        array_push($etapa_subetapa,$label." ".$list_val_sub[$v]);
                        //$etapa_subetapa["".$i.""]=$label." ".$list_val_sub[$v];
                        $i++;
                    }
                }

            }
        }

        return $etapa_subetapa;


    }


}

?>
