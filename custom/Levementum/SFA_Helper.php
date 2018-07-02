<?php

    class SFA_Helper
    {

        public function userReportsTo($currentUserId)
        {

            global $db;
            $query = <<<SQL
                    SELECT reports_to_id FROM users
                    WHERE id = '{$currentUserId}'
SQL;

            $queryResult = $db->getOne($query);
            return $queryResult;
        }

        public function managerOf($currentUserId, $orden)
        {

            global $db;
            $query = <<<SQL
                SELECT id, first_name, last_name FROM users
                WHERE reports_to_id = '{$currentUserId}' ORDER BY first_name $orden
SQL;
            $queryResult = $db->query($query);
            $manageOfUsers = array();
            while ($row = $db->fetchByAssoc($queryResult)) {
                $manageOfUsers[] = $row;
            }
            return $manageOfUsers;
        }

        //Deprecated do not rectify
        public function getcurrentUserManagerAccounts($currentUserId)
        {

            $managerId = $this->userReportsTo($currentUserId);

            if ($managerId != null) {
                global $db;
                $query = <<<SQL
                    SELECT * FROM accounts
                    WHERE assigned_user_id = '{$managerId}' AND deleted = 0
SQL;
                $queryResult = $db->query($query);
                $manager_accounts = array();
                while ($row = $db->fetchByAssoc($queryResult)) {
                    $manager_accounts[] = $row;
                }
                return $manager_accounts;
            }
        }

        //Deprecated do not rectify
        public function getCurrentUserRole($currentUserId)
        {

            global $db;
            $query = <<<SQL
                    SELECT acl_roles.name FROM acl_roles_users
                    INNER JOIN acl_roles ON acl_roles.id = acl_roles_users.role_id AND acl_roles.deleted = 0
                    WHERE user_id = '{$currentUserId}' AND acl_roles_users.deleted = 0
SQL;

            $queryResult = $db->getOne($query);
            return $queryResult;
        }

        public function getCurrentUserAccounts($currentUserId, $orden, $ordenBy)
        {
            global $db;
            $query = <<<SQL
                SELECT
                accounts.id AS AcctId,
                accounts.name AS AcctName,
                ac.estatus_c AS AcctEstatus,
                 opportunities.id AS OppId,
                  accounts.name AS cliente,
                   opportunities_cstm.estatus_c,
                    opportunities.name AS operacion,
                     opportunities_cstm.activo_c,
                     opportunities_cstm.activo_nombre_c,
                     ac.estatus_c AS tipo_cliente,
                     ac.account_id_c AS ReferenciadorId,
                     (SELECT NAME FROM accounts WHERE id = ac.account_id_c) AS Referenciador,
                     opportunities.assigned_user_id AS OppAssignedUser,
                     CONCAT(users.first_name, ' ', users.last_name) AS OppAssignedUserName,
                CAST(IF(opportunities_cstm.forecast_c = 'Backlog', opportunities.amount, NULL) AS DECIMAL) AS backlog,
                CAST(IF(opportunities_cstm.forecast_c = 'Pipeline', opportunities.amount, NULL) AS DECIMAL) AS pipeline,
                CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 1 AND 30, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount), NULL) AS DECIMAL) AS treinta,
				CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 31 AND 60, IF(opportunities_cstm.forecast_c = 'Backlog'  || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount), NULL) AS DECIMAL) AS sesenta,
				CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 61 AND 90, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount) , NULL) AS DECIMAL) AS noventa,
				CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) > 90, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount) , NULL) AS DECIMAL) AS noventamas,
                users.first_name, users.last_name, users.id AS userId, opportunities.name as name
                FROM accounts
                INNER JOIN accounts_cstm ac ON ac.id_c = accounts.id
                LEFT JOIN accounts_opportunities ON accounts_opportunities.account_id = accounts.id AND accounts_opportunities.deleted =0
                LEFT JOIN opportunities ON opportunities.id = accounts_opportunities.opportunity_id AND opportunities.deleted = 0
                LEFT JOIN opportunities_cstm ON opportunities_cstm.id_c = opportunities.id
                LEFT JOIN users ON users.id = accounts.assigned_user_id AND users.deleted = 0
                WHERE accounts.assigned_user_id = '{$currentUserId}' AND accounts.deleted = 0 AND opportunities.name IS NOT NULL AND opportunities_cstm.forecast_time_c != 'Muerta' 
				AND opportunities_cstm.estatus_c not in ('N','T','K','R','CM','AL')
SQL;

            if ($ordenBy != null && $orden != null) {
                $query .= " ORDER BY $ordenBy $orden";
            }

            $queryResult = $db->query($query);
            $user_accounts = array();
            while ($row = $db->fetchByAssoc($queryResult)) {

                $user_accounts[$row['AcctId']]['Name'] = $row['AcctName'];
                $user_accounts[$row['AcctId']]['Estatus'] = $row['AcctEstatus'];
                $user_accounts[$row['AcctId']]['Totals'] = $this->getCurrentUserAccountsC1Totals($row['AcctId']);
                $user_accounts[$row['AcctId']]['Opps'][] = $row;
            }

            return $user_accounts;
        }

        public function getCurrentUserAccountsC1Totals($AccountId)
        {
            global $db, $current_user;
            $query = <<<SQL
                 SELECT
                accounts.id AS AcctId,
                accounts.name AS AcctName,
                     ac.estatus_c AS tipo_cliente,
                SUM(CAST(IF(opportunities_cstm.forecast_c = 'Backlog', opportunities.amount, NULL) AS DECIMAL)) AS backlog,
                SUM(CAST(IF(opportunities_cstm.forecast_c = 'Pipeline', opportunities.amount, NULL) AS DECIMAL)) AS pipeline,
				SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 1 AND 30, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount), NULL) AS DECIMAL)) AS treinta,
				SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 31 AND 60, IF(opportunities_cstm.forecast_c = 'Backlog'  || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount), NULL) AS DECIMAL)) AS sesenta,
				SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 61 AND 90, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount) , NULL) AS DECIMAL)) AS noventa,
				SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) > 90, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount) , NULL) AS DECIMAL)) AS noventamas
                FROM accounts
                INNER JOIN accounts_cstm ac ON ac.id_c = accounts.id
                LEFT JOIN accounts_opportunities ON accounts_opportunities.account_id = accounts.id AND accounts_opportunities.deleted =0
                LEFT JOIN opportunities ON opportunities.id = accounts_opportunities.opportunity_id AND opportunities.deleted = 0
                LEFT JOIN opportunities_cstm ON opportunities_cstm.id_c = opportunities.id
                LEFT JOIN users ON users.id = accounts.assigned_user_id AND users.deleted = 0
                WHERE accounts.id = '{$AccountId}'
                AND accounts.deleted = 0
                AND opportunities.name IS NOT NULL
                AND opportunities_cstm.forecast_time_c != 'Muerta'
                GROUP BY AcctId
SQL;

            $GLOBALS['log']->info(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : $query ");

            $queryResult = $db->query($query);
            $user_accounts = array();
            $row = $db->fetchByAssoc($queryResult);

            return $row;
        }

        public function getCurrentUserAccountsC2Totals($AccountId)
        {
            global $db, $current_user;
            $query = <<<SQL
                 SELECT
                accounts.id AS AcctId,
                accounts.name AS AcctName,
                ac.estatus_c AS tipo_cliente,
                SUM(opportunities.amount) AS pipeline,
                FROM accounts
                INNER JOIN accounts_cstm ac ON ac.id_c = accounts.id
                LEFT JOIN accounts_opportunities ON accounts_opportunities.account_id = accounts.id AND accounts_opportunities.deleted =0
                LEFT JOIN opportunities ON opportunities.id = accounts_opportunities.opportunity_id AND opportunities.deleted = 0
                LEFT JOIN opportunities_cstm ON opportunities_cstm.id_c = opportunities.id
                LEFT JOIN users ON users.id = accounts.assigned_user_id AND users.deleted = 0
                WHERE accounts.id = '{$AccountId}'
                AND accounts.deleted = 0
                AND opportunities.name IS NOT NULL
                AND opportunities_cstm.forecast_time_c != 'Muerta'
                AND opportunities_cstm.forecast_c = 'Pipeline'
                GROUP BY AcctId
SQL;

            $GLOBALS['log']->info(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : $query ");

            $queryResult = $db->query($query);
            $user_accounts = array();
            $row = $db->fetchByAssoc($queryResult);

            return $row;
        }

        public function getTotalsByPromotor($user_ids, $supervisor = false)
        {
            $user_ids = join("','", $user_ids);

            if ($supervisor) {
                $supervisor_clause = "";
            } else {
                $supervisor_clause = "GROUP BY accounts.assigned_user_id";
            }
            global $db, $current_user;
            $query = <<<SQL
                 SELECT
                    accounts.assigned_user_id,
                    SUM(CAST(IF(opportunities_cstm.forecast_c = 'Backlog', opportunities.amount, NULL) AS DECIMAL)) AS backlog,
                    SUM(CAST(IF(opportunities_cstm.forecast_c = 'Pipeline', opportunities.amount, NULL) AS DECIMAL)) AS pipeline,
					SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 1 AND 30, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount), NULL) AS DECIMAL)) AS treinta,
					SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 31 AND 60, IF(opportunities_cstm.forecast_c = 'Backlog'  || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount), NULL) AS DECIMAL)) AS sesenta,
					SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 61 AND 90, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount) , NULL) AS DECIMAL)) AS noventa,
					SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) > 90, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount) , NULL) AS DECIMAL)) AS noventamas
                FROM accounts
                    INNER JOIN accounts_cstm ac ON ac.id_c = accounts.id
                    LEFT JOIN accounts_opportunities ON accounts_opportunities.account_id = accounts.id AND accounts_opportunities.deleted =0
                    LEFT JOIN opportunities ON opportunities.id = accounts_opportunities.opportunity_id AND opportunities.deleted = 0
                    LEFT JOIN opportunities_cstm ON opportunities_cstm.id_c = opportunities.id
                    LEFT JOIN users ON users.id = accounts.assigned_user_id AND users.deleted = 0
                WHERE accounts.assigned_user_id IN ('{$user_ids}')
                    AND accounts.deleted = 0
                    AND opportunities.name IS NOT NULL
                    AND opportunities_cstm.forecast_time_c != 'Muerta'
                {$supervisor_clause}
SQL;

            $GLOBALS['log']->fatal(" <".$current_user->user_name."> : GROUPED BY PROMOTOR: " . $query);

            $queryResult = $db->query($query);
            $user_accounts = array();
            $row = $db->fetchByAssoc($queryResult);

            return $row;
        }

        public function getTotalsByPromotorC2($user_ids, $supervisor = false)
        {
            $user_ids = join("','", $user_ids);

            if ($supervisor) {
                $supervisor_clause = "";
            } else {
                $supervisor_clause = "GROUP BY accounts.assigned_user_id";
            }
            global $db, $current_user;
            $query = <<<SQL
                 SELECT
                    accounts.assigned_user_id,
                    SUM(opportunities.amount) AS pipeline
                FROM accounts
                    INNER JOIN accounts_cstm ac ON ac.id_c = accounts.id
                    LEFT JOIN accounts_opportunities ON accounts_opportunities.account_id = accounts.id AND accounts_opportunities.deleted =0
                    LEFT JOIN opportunities ON opportunities.id = accounts_opportunities.opportunity_id AND opportunities.deleted = 0
                    LEFT JOIN opportunities_cstm ON opportunities_cstm.id_c = opportunities.id
                    LEFT JOIN users ON users.id = accounts.assigned_user_id AND users.deleted = 0
                WHERE accounts.assigned_user_id IN ('{$user_ids}')
                    AND accounts.deleted = 0
                    AND opportunities.name IS NOT NULL
                    AND opportunities_cstm.forecast_time_c != 'Muerta'
                    AND opportunities_cstm.forecast_c = 'Pipeline'
                {$supervisor_clause}
SQL;

            $GLOBALS['log']->fatal(" <".$current_user->user_name."> : GROUPED BY PROMOTOR: " . $query);

            $queryResult = $db->query($query);
            $user_accounts = array();
            $row = $db->fetchByAssoc($queryResult);

            return $row;
        }

        public function getGrandTotal($user_ids)
        {
            $user_ids = join("','", $user_ids);
            global $db, $current_user;
            $query = <<<SQL
                 SELECT
                    SUM(CAST(IF(opportunities_cstm.forecast_c = 'Backlog', opportunities.amount, NULL) AS DECIMAL)) AS backlog,
                    SUM(CAST(IF(opportunities_cstm.forecast_c = 'Pipeline', opportunities.amount, NULL) AS DECIMAL)) AS pipeline,
					SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 1 AND 30, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount), NULL) AS DECIMAL)) AS treinta,
					SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 31 AND 60, IF(opportunities_cstm.forecast_c = 'Backlog'  || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount), NULL) AS DECIMAL)) AS sesenta,
					SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) BETWEEN 61 AND 90, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount) , NULL) AS DECIMAL)) AS noventa,
					SUM(CAST(IF(DATEDIFF(opportunities.date_closed, NOW()) > 90, IF(opportunities_cstm.forecast_c = 'Backlog' || opportunities_cstm.forecast_c = 'Pipeline', NULL, opportunities.amount) , NULL) AS DECIMAL)) AS noventamas
                FROM accounts
                    INNER JOIN accounts_cstm ac ON ac.id_c = accounts.id
                    LEFT JOIN accounts_opportunities ON accounts_opportunities.account_id = accounts.id AND accounts_opportunities.deleted =0
                    LEFT JOIN opportunities ON opportunities.id = accounts_opportunities.opportunity_id AND opportunities.deleted = 0
                    LEFT JOIN opportunities_cstm ON opportunities_cstm.id_c = opportunities.id
                    LEFT JOIN users ON users.id = accounts.assigned_user_id AND users.deleted = 0
                WHERE accounts.deleted = 0
                    AND opportunities.name IS NOT NULL
                    AND opportunities_cstm.forecast_time_c != 'Muerta'
                    AND accounts.assigned_user_id IN ('{$user_ids}')

SQL;
            $GLOBALS['log']->info(" <".$current_user->user_name."> : GRAND TOTAL: " . $query);

            $queryResult = $db->query($query);
            $user_accounts = array();
            $row = $db->fetchByAssoc($queryResult);

            return $row;
        }

        public function getCurrentUserAccountsC2($currentUserId, $orden, $ordenBy)
        {
            global $db;
            $query = <<<SQL
                SELECT
                accounts.id AS AcctId,
                accounts.name AS AcctName,
                ac.estatus_c AS AcctEstatus,
                 opportunities.id AS OppId,
                  accounts.name AS cliente,
                   opportunities_cstm.estatus_c,
                    opportunities.name AS operacion,
                     opportunities_cstm.activo_c,
                     opportunities_cstm.activo_nombre_c,
                     ac.estatus_c AS tipo_cliente,
                     ac.account_id_c AS ReferenciadorId,
                     (SELECT NAME FROM accounts WHERE id = ac.account_id_c) AS Referenciador,
                     opportunities.assigned_user_id AS OppAssignedUser,
                     CONCAT(users.first_name, ' ', users.last_name) AS OppAssignedUserName,
                     opportunities.amount AS pipeline,
                 users.first_name, users.last_name, users.id AS userId, opportunities.name as name
                FROM accounts
                INNER JOIN accounts_cstm ac ON ac.id_c = accounts.id
                LEFT JOIN accounts_opportunities ON accounts_opportunities.account_id = accounts.id AND accounts_opportunities.deleted =0
                LEFT JOIN opportunities ON opportunities.id = accounts_opportunities.opportunity_id AND opportunities.deleted = 0
                LEFT JOIN opportunities_cstm ON opportunities_cstm.id_c = opportunities.id
                LEFT JOIN users ON users.id = accounts.assigned_user_id AND users.deleted = 0
                WHERE accounts.assigned_user_id = '{$currentUserId}'
                   AND accounts.deleted = 0
                   AND opportunities.name IS NOT NULL
                   AND opportunities_cstm.forecast_time_c != 'Muerta'
                   AND opportunities_cstm.forecast_c = 'Pipeline'
SQL;

            if ($ordenBy != null && $orden != null) {
                $query .= " ORDER BY $ordenBy $orden";
            }

            $queryResult = $db->query($query);
            $user_accounts = array();
            while ($row = $db->fetchByAssoc($queryResult)) {

                $user_accounts[$row['AcctId']]['Name'] = $row['AcctName'];
                $user_accounts[$row['AcctId']]['Estatus'] = $row['AcctEstatus'];
                $user_accounts[$row['AcctId']]['Totals'] = $this->getCurrentUserAccountsC2Totals($row['AcctId']);
                $user_accounts[$row['AcctId']]['Opps'][] = $row;
            }

            return $user_accounts;
        }
    }