<?php
/**
 * Created by JG.
 * User: tactos
 * Date: 24/11/20
 * Time: 02:17 PM
 */
class getProductosFinancieros extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETActivoAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetProductosFinancieros', '?'),
                'pathVars' => array('module', 'tipoProd'),
                'method' => 'getcstmProdFinan',
                'shortHelp' => 'Obtiene todos los productos relacionados a la cuenta',
            ),
        );
    }

    public function getcstmProdFinan($api, $args)
    {
        global $db;
        $producto = $args['tipoProd'];
        $records_in = [];

        $selectProductos="Select * from prod_estructura_productos WHERE tipo_producto={$producto}";
        $result = $GLOBALS['db']->query($selectProductos);
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $records_in[] = $row;
        }
        return $records_in;
    }

}