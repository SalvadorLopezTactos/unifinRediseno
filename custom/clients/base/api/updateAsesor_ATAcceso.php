<?php
/**
 * Created by JG.
 * User: tactos
 * Date: 24/12/20
 * Time: 02:05 PM
 */

class updateAsesor_ATAcceso extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POSTreUpdateAcceso' => array(
                'reqType' => 'POST',
                'path' => array('updateAsesores'),
                'pathVars' => array(''),
                'method' => 'updateAgentesTele',
                'shortHelp' => 'Método POST para actualizar el horario de acceso a CRM de los Agentes Telefonicos',
            ),

        );
    }

    public function updateAgentesTele($api, $args)
    {
        global $db;
        $records = "'" . join("','", $args['data']['seleccionados']) . "'";
        $nuevoHorario =  !$args['data']['excluir']? $args['data']['horario']:"";

        //$GLOBALS['log']->fatal("Records  " . $records);
        //$GLOBALS['log']->fatal("Usuarios " . print_r($nuevoHorario,true));


        $Query = "UPDATE users_cstm
SET access_hours_c ='{$nuevoHorario}'
WHERE id_c IN ($records)";
        $result = $GLOBALS['db']->query($Query);
        $GLOBALS['log']->fatal("Usuarios " . $Query);
        $GLOBALS['log']->fatal("Usuarios " . $result);

        return $result;
    }


}