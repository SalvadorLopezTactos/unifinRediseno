<?php

class Backlog_Seguros_LH
{

    public function setNameRecord($bean = null, $event = null, $args = null){

        global $app_list_strings;

        $bean->name = 'Backlog '. $bean->no_backlog. ' - ' .$app_list_strings['mes_list'][$bean->mes]. " " . $app_list_strings['anio_list'][$bean->anio];
    }

}
