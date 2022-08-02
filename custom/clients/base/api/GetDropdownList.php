<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 07/08/18
 * Time: 10:07
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetDropdownList extends SugarApi
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
                'path' => array('GetDropdownList', '?'),
                //endpoint variables
                'pathVars' => array('method', 'list_name'),
                //method to call
                'method' => 'getDropdownListMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que obtiene clave => valor de la lista pasada como parámetro en la URL',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    /**
     * Obtiene valores de listas pertenecientes a la instancia de Sugar
     *
     * Método que regresa los valores de la lista pasada como parámetro por la URL en forma clave => valor
     *
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento
     * @return array $list_values Array con los valores de la lista pasada como parámetro
     * @throws SugarApiExceptionInvalidParameter
     */
    public function getDropdownListMethod($api, $args)
    {
        global $app_list_strings;
        $list_name=$args['list_name'];

        $findme   = ',';
        $pos = strpos($list_name, $findme);
        /*
         * Se agrega esta sección para obtener múltiples valores de listas en una sola petición
         * y de esta manera evitar hacer un llamado por cada nombre de lista disponible en SugarCRM
         * (Se aplica ya que desde la aplicación móvil no se están obteniendo los valores desde JS con la sentencia app.lang.getAppListStrings('nombre_lista'))
         * */
        if($pos!=false){

            $listas=explode(",", $list_name);
            foreach ($listas as $lalista){
                if (isset($app_list_strings[$lalista]))
                {
                    $list_values[''.$lalista.'']= $app_list_strings[$lalista];
                }else{
                    $list_values[''.$lalista.'']="La lista {$lalista} no existe";
                }

            }

        }else{

            if (isset($app_list_strings[$list_name]))
            {
                $list_values = $app_list_strings[$list_name];
            }else{
                $list_values[]="La lista {$list_name} no existe";
            }

        }
        $list_values[""]= ($list_values[""]!="")?$list_values[""]:"";
        return $list_values;

    }


}

?>
