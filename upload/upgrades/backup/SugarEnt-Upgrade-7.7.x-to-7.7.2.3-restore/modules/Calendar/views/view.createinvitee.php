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
require_once('include/MVC/View/views/view.ajax.php');
require_once('include/EditView/EditView2.php');


class CalendarViewCreateInvitee extends SugarView
{

    public function preDisplay()
    {
        $module = $_REQUEST['inviteeModule'];
        $this->bean = BeanFactory::getBean($module);

        if ($this->bean->ACLAccess('save')) {
            require_once('include/formbase.php');
            $this->bean = populateFromPost("", $this->bean);
            $this->bean->save();
        } else {
            $sendbackArr = array(
                'noAccess' => true,
                'module' => $this->bean->object_name,
            );
            echo json_encode($sendbackArr);
            die;
        }
    }

    public function display()
    {
        $sendbackArr = array(
            'module' => $this->bean->object_name,
            'fields' => array(),
        );
        foreach ($_REQUEST['fieldList'] as $field) {
            $sendbackArr['fields'][$field] = $this->bean->$field;
        }

        ob_clean();
        echo json_encode($sendbackArr);
    }
}

