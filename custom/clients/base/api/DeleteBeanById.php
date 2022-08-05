<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 05/09/18
 */


if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class DeleteBeanById extends SugarApi
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
                'path' => array('DeleteBeanById', '?','?'),
                //endpoint variables
                'pathVars' => array('method', 'module','id'),
                //method to call
                'method' => 'deleteBean',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Elimina registro que posea id pasado como parámetro',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    /**
     * Elimina bean de un módulo pasado como parámetri
     *
     * Método que elimina un bean con id pasado como parámetro de un módulo en específico
     *
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento
     * @return boolean $response indicando éxito en la operación de eliminación de bean
     * @throws SugarApiExceptionInvalidParameter
     */
    public function deleteBean($api, $args)
    {
        global $app_list_strings;
        $modulo=$args['module'];
        $id=$args['id'];

        //$response=false;

        //Obteniendo bean
        $beanModule = BeanFactory::retrieveBean($modulo, $id);
        $beanModule->subtipo_registro_cuenta_c="6"; // No viable - 6
        $beanModule->mark_deleted($id);
        $beanModule->save();

        return true;

    }


}

?>