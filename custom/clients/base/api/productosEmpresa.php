<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class productosEmpresa extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('productosEmpresa'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'GetProductosEmpresa',
                //short help string to be displayed in the help documentation
                'shortHelp' => '',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    public function GetProductosEmpresa($api, $args)
    {
        global $app_list_strings;
        $empresas_list = $app_list_strings['empresas_list'];
        $productos_empresas_list = $app_list_strings['productos_empresas_list'];
        $tipo_producto_list = $app_list_strings['tipo_producto_list'];

        $i = 0;
        if (!empty($empresas_list) && !empty($productos_empresas_list) && !empty($tipo_producto_list)) {

            foreach ($empresas_list as $key_emp => $label_emp) {  //Empresas Unifin, Uniclick y Sin especificar

                $list_values['empresas'][] = array("id" => $key_emp, "nombre" => $label_emp, "productos" => array());

                foreach ($productos_empresas_list as $key_product => $label_product) {  //Productos de las Empresas
                    $etiqueta_producto = $tipo_producto_list[$key_product];  //Obtiene la Etiqueta del Producto

                    //Valida si ID Empresa es Igual al valor de Producto
                    if ($key_emp == $label_product) {

                        array_push($list_values["empresas"][$i]["productos"], array("id" => $key_product, "nombre" => $etiqueta_producto));
                    }
                }
                $i++;
            }

        } else {

            $list_values['Error'] = "Alguna lista de (empresas_list o productos_empresas_list o tipo_producto_list) no existe, favor de validar";
        }

        return $list_values;
    }
}
