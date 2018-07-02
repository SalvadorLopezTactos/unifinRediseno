<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

require_once 'modules/Emails/ArchivedEmailsBeanLink.php';

/**
 * Links connected emails for a case
 */
class CaseEmailsLink extends ArchivedEmailsBeanLink
{

    /**
     * We need this one because cases have match by subject macro
     * @see ArchivedEmailsBeanLink::getEmailsJoin()
     */
    protected function getEmailsJoin($params = array())
    {
        $params['source'] = true;
        $join = parent::getEmailsJoin($params);
        if ($this->focus instanceof aCase && !empty($this->focus->case_number)) {
            $where = str_replace("%1", $this->focus->case_number, $this->focus->getEmailSubjectMacro());
            if (!empty($params['join_table_alias'])) {
                $table_name = $params['join_table_alias'];
            } else {
                $table_name = 'emails';
            }
            $where = DBManagerFactory::getInstance()->sqlLikeString($where, '%', false);
            preg_match('|^INNER JOIN \\((.*)\\) email_ids|ism', trim($join), $match);
            $inside = $match[1];
            $join = "INNER JOIN ( SELECT email_id, MIN(source) sources FROM ($inside) email_ids2 GROUP BY email_id ) email_ids ON $table_name.id=email_ids.email_id";
            $join .= " AND (email_ids.sources = 1 OR {$table_name}.name LIKE '%$where%')";
        }
        return $join;
    }
}
