<?php
/*
 * Created by PhpStorm.
 * User: AF.Tactos
 * Date: 2019-09-17
*/

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetDropdownDependencies extends SugarApi
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
                'reqType' => 'POST',
                //'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetDropdownDependencies'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'getDropdownDependenciesMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método para recuperar la dependencia de visibilidad entre 2 campos desplegables',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

        );

    }

    /**
     * Obtiene valores de listas pertenecientes a la instancia de Sugar
     *
     * Método para recuperar la dependencia de visibilidad entre 2 campos desplegables
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento: modulo & campo
     * $args['modulo']  =  Nombre del módulo plural
     * $args['moduloSingular']  =  Nombre del módulo singular
     * $args['campo']  =  Nombre del campo
    */
    public function getDropdownDependenciesMethod($api, $args)
    {
        //Inicializa variable de resultado
        $result = [];
        $result["estado"]="";
        $result["descripcion"]="";
        $result["padre"]="";
        $result["valores"]=[];

        //Valida existencia de archivo
        if (!file_exists("custom/Extension/modules/{$args['modulo']}/Ext/Vardefs/sugarfield_{$args['campo']}.php")) {
            $result["estado"]="error";
            $result["descripcion"]="El campo {$args['campo']} no existe en el módulo {$args['modulo']}";
            // Regresa respuesta
            return $result;
        }

        //Recupera $dictionary del campo indicado
        include ("custom/Extension/modules/{$args['modulo']}/Ext/Vardefs/sugarfield_{$args['campo']}.php");
        $moduloSingular = '';
        foreach ($dictionary as $key => $value){
            $moduloSingular = $key;
        }
        //Valida existencia de dependencia
        if ($dictionary[$moduloSingular]['fields'][$args['campo']]['visibility_grid'] == "" ) {
            $result["estado"]="error";
            $result["descripcion"]="El campo {$args['campo']} no tiene dependencia";
            // Regresa respuesta
            return $result;
        }

        //Recupera valores de dependencia
        $result["padre"]= $dictionary[$moduloSingular]['fields'][$args['campo']]['visibility_grid']['trigger'];
        $result["valores"] = $dictionary[$moduloSingular]['fields'][$args['campo']]['visibility_grid']['values'];
        $result["estado"]="exito";
        $result["descripcion"]="Se muestra la dependencia entre el campo {$args['campo']} y {$result['padre']}";

        // Regresa respuesta
        return $result;
    }
}

?>
