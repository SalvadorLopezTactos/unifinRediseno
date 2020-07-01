<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("clients/base/api/PersonFilterApi.php");

class CustomPersonFilterApi extends PersonFilterApi {
    
    protected function getCustomWhereForModule($module, $query = null) {
        if ($query instanceof SugarQuery) {
            if ($module == 'Employees') {
                $query->where()->equals('employee_status', 'Active')->equals('show_on_employees','1');
                return;
            }
            $query->where()->queryOr()->equals('status', 'Active')->equals('status', 'Inactive')->equals('portal_only', '0');
            return;
        }

        if ($module == 'Employees') {
            return "users.employee_status = 'Active' AND users.show_on_employees = 1";
        }
        
        return "users.status = 'Active' OR users.status = 'Inactive' AND users.portal_only = 0";
    }
}
