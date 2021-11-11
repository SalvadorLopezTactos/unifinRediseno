<?php

// class clase_Admin_Backlog
// {
//     function func_Admin_Backlog($bean, $event, $arguments)
//     {
//         global $db;

//         if ($bean->fetched_row['lumo_c'] != $bean->lumo_c) {

//             $GLOBALS['log']->fatal("ACTUALIZA LUMO EN BACKLOGS RELACIONADOS A LA CUENTA: " . $bean->id);

//             $lumo = ($bean->lumo_c != '') ? 1 : 0;

//             $update_Backlog = "UPDATE lev_backlog_cstm lbc INNER JOIN lev_backlog lb on lb.id = lbc.id_c SET lbc.lumo_cuentas_c = '{$lumo}' WHERE lb.account_id_c ='{$bean->id}'";
//             $db->query($update_Backlog);
            
//         }
//     }
// }
