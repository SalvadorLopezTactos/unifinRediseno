<?php

class clase_Admin_Backlog
{
    function func_Admin_Backlog($bean, $event, $arguments)
    {
        global $db;

        if ($bean->fetched_row['lumo_c'] != $bean->lumo_c) {

            $GLOBALS['log']->fatal("ACTUALIZA LUMO EN BACKLOGS RELACIONADOS A LA CUENTA: " . $bean->id);

            $lumo = ($bean->lumo_c != '') ? 1 : 0;

            $query = "SELECT id as idBacklog, name, account_id_c, lumo_cuentas_c as lumoBacklog from lev_backlog lb
            inner join lev_backlog_cstm lbc on lbc.id_c = lb.id
            where account_id_c = '{$bean->id}'";
            $result = $db->query($query);

            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {

                $update_Backlog = "UPDATE lev_backlog_cstm lbc SET lbc.lumo_cuentas_c = '{$lumo}' WHERE lbc.id_c ='{$row['idBacklog']}'";
                $db->query($update_Backlog);
            }
        }
    }
}
