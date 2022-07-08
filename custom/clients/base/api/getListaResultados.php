<?php
/*
 * Created by PhpStorm.
 * User: AF.Tactos
 * Date: 2022-06-27
*/

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class getListaResultados extends SugarApi
{
    /**
     * Registro de todas las rutas para consumir los servicios del API
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
                'path' => array('getListaResultados', '?'),
                //endpoint variables
                'pathVars' => array('method', 'objetivo'),
                //method to call
                'method' => 'getListaResultadosMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método para recuperar resultados de reunión a partir del objetivo',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            )
        );
    }

    /**
     *
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento
     * $args['objetivo']  =  Id del Objetivo
    */
    public function getListaResultadosMethod($api, $args)
    {
        //Inicializa variable de resultado
        global $app_list_strings;
        $combinaciones = [];
        $list_values = array();
        //Valida existencia de archivo
        if (!file_exists("custom/Extension/modules/Meetings/Ext/Vardefs/sugarfield_resultado_c.php")) {
            $GLOBALS['log']->fatal("Error con información enviada");
            $respuesta['codigo'] = 400;
            $respuesta['mensaje'] = "No se pudo recuperar resultado para el objetivo proporcionado";
            throw new SugarApiExceptionInvalidParameter("Error con información enviada");
            // Regresa respuesta
            return $respuesta;
        }
        include ("custom/Extension/modules/Meetings/Ext/Vardefs/sugarfield_resultado_c.php");
        //Valida existencia de dependencia
        if ($dictionary['Meeting']['fields']['resultado_c']['visibility_grid'] == "" ) {
            $GLOBALS['log']->fatal("Error con información enviada");
            $respuesta['codigo'] = 400;
            $respuesta['mensaje'] = "No se pudo recuperar resultado para el objetivo proporcionado";
            throw new SugarApiExceptionInvalidParameter("Error con información enviada 2");
            // Regresa respuesta
            return $respuesta;
        }
        //Recupera valores de dependencia
        $combinaciones = $dictionary['Meeting']['fields']['resultado_c']['visibility_grid']['values'][$args['objetivo']];
        //return $combinaciones;
        foreach ($combinaciones as $resultados) {
            if($resultados != "" && $resultados != '5' && $resultados != '19'){
				$valores = ["response_id" => $resultados, "response_description" => $app_list_strings['resultado_list'][$resultados]];
				array_push($list_values,$valores);
            }
        }
        // Regresa respuesta
        return $list_values;
    }
}
?>
