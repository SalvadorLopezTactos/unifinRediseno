<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetWeekDays extends SugarApi
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
                'path' => array('GetWeekDays'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => '_getWeekDays',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método para obtener los días habiles de la semana desde la fecha actual',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    public function _getWeekDays($api, $args)
    {
        try {

            //OBTIENE LA FECHA DE 3 DÍAS HABILES A PARTIR DE LA FECHA ACTUAL
            $fechaVencimiento = date('Y-m-d', strtotime('3 weekdays'));
            $get_fecha_vencimiento = ["fechaVencimiento" => $fechaVencimiento];

            return $get_fecha_vencimiento;
            
        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
