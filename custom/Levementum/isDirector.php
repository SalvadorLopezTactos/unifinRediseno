<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 7/24/2015
 * Time: 2:45 PM
 */

class isDirector{

    public function userReportsTo($currentUserId){

         global $db;
         $query = <<<SQL
SELECT reports_to_id FROM users
WHERE id = '{$currentUserId}'
SQL;

         $queryResult = $db->getOne($query);
        return $queryResult;
    }

    public function managerOf($currentUserId, $orden){

         global $db;
         $query = <<<SQL
SELECT id, first_name, last_name FROM users
WHERE reports_to_id = '{$currentUserId}' ORDER BY first_name $orden
SQL;
         $queryResult = $db->query($query);
        $manageOfUsers = array();
         while($row = $db->fetchByAssoc($queryResult))
         {
             $manageOfUsers[] = $row;
         }
        return $manageOfUsers;
    }

    public function getCurrentUserAccounts($currentUserId, $orden, $ordenBy, $titulo){

         global $db;
            $query = <<<SQL
                SELECT accounts.id AS AcctId, opportunities.id AS OppId, accounts.name AS cliente, opportunities_cstm.estatus_c, opportunities.name AS operacion, opportunities_cstm.activo_c,
                CAST(IF(opportunities_cstm.forecast_c = 'Backlog', opportunities_cstm.monto_c, NULL) AS DECIMAL) AS backlog,
                CAST(IF(opportunities_cstm.forecast_c = 'Pipeline', opportunities_cstm.monto_c, NULL) AS DECIMAL) AS pipeline,
                CAST(IF(DATEDIFF(opportunities_cstm.fecha_estimada_cierre_c, NOW()) = 30, opportunities_cstm.monto_c, NULL) AS DECIMAL) AS treinta,
                CAST(IF(DATEDIFF(opportunities_cstm.fecha_estimada_cierre_c, NOW()) BETWEEN 31 AND 60, opportunities_cstm.monto_c, NULL) AS DECIMAL) AS sesenta,
                CAST(IF(DATEDIFF(opportunities_cstm.fecha_estimada_cierre_c, NOW()) BETWEEN 61 AND 90, opportunities_cstm.monto_c, NULL) AS DECIMAL) AS noventa,
                CAST(IF(DATEDIFF(opportunities_cstm.fecha_estimada_cierre_c, NOW()) > 90, opportunities_cstm.monto_c, NULL) AS DECIMAL) AS noventamas,
                users.first_name, users.last_name, users.id AS userId, opportunities.name as name
                FROM accounts
                LEFT JOIN accounts_opportunities ON accounts_opportunities.account_id = accounts.id AND accounts_opportunities.deleted =0
                LEFT JOIN opportunities ON opportunities.id = accounts_opportunities.opportunity_id AND opportunities.deleted = 0
                LEFT JOIN opportunities_cstm ON opportunities_cstm.id_c = opportunities.id
                LEFT JOIN users ON users.id = accounts.assigned_user_id AND users.deleted = 0
                WHERE accounts.assigned_user_id = '{$currentUserId}' AND accounts.deleted = 0 AND opportunities.name IS NOT NULL AND opportunities_cstm.forecast_time_c != 'Muerta'
SQL;
            if($ordenBy != null && $orden != null){
                $query .= " ORDER BY $ordenBy $orden";
            }

            $queryResult = $db->query($query);
            $user_accounts = array();
            while ($row = $db->fetchByAssoc($queryResult)) {
                if($titulo != 'Promotor') {
                    $user_accounts['TotalPipelne'] += $row['pipeline'];
                    $user_accounts['Totalbacklog'] += $row['backlog'];
                    $user_accounts['Totaltreinta'] += $row['treinta'];
                    $user_accounts['Totalsesenta'] += $row['sesenta'];
                    $user_accounts['Totalnoventa'] += $row['noventa'];
                    $user_accounts['Totalnoventamas'] += $row['noventamas'];
                }
                if($titulo == 'Promotor'){
                    $user_accounts['Totales']['TotalPipelne'] += $row['pipeline'];
                    $user_accounts['Totales']['Totalbacklog'] += $row['backlog'];
                    $user_accounts['Totales']['Totaltreinta'] += $row['treinta'];
                    $user_accounts['Totales']['Totalsesenta'] += $row['sesenta'];
                    $user_accounts['Totales']['Totalnoventa'] += $row['noventa'];
                    $user_accounts['Totales']['Totalnoventamas'] += $row['noventamas'];
                }
                $user_accounts[] = $row;
            }

        return $user_accounts;
    }

    public function getcurrentUserManagerAccounts($currentUserId){

        $managerId = $this->userReportsTo($currentUserId);

        if($managerId != null){
             global $db;
             $query = <<<SQL
SELECT * FROM accounts
WHERE assigned_user_id = '{$managerId}' AND deleted = 0
SQL;
             $queryResult = $db->query($query);
            $manager_accounts = array();
             while($row = $db->fetchByAssoc($queryResult))
             {
                 $manager_accounts[] = $row;
             }
            return $manager_accounts;
        }
    }
}