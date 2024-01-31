<?php

class Backlog_Seguros_LH
{

    public function setNameRecord($bean = null, $event = null, $args = null){

        global $app_list_strings;

        $stringName = 'Backlog '. $bean->no_backlog. ' - ' .$app_list_strings['mes_list'][$bean->mes]. " " . $app_list_strings['anio_list'][$bean->anio];
        $stringQuery ="UPDATE tctbl_backlog_seguros SET name = '{$stringName}' WHERE id = '{$bean->id}'";

        $GLOBALS['log']->fatal("Se establece nombre del Backlog");
        $GLOBALS['log']->fatal($stringQuery);
        $GLOBALS['db']->query($stringQuery);

    }

}
