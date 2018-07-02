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
require_once('include/Expressions/Expression/Parser/Parser.php');
require_once("data/BeanFactory.php");
class ViewExecFunction extends ViewAjax
{
    var $vars = array("tmodule", "id", "params", "function");

    public function __construct()
    {
        parent::ViewAjax();
        foreach($this->vars as $var)
        {
            if (empty($_REQUEST[$var]))
                sugar_die("Required paramter $var not set in ViewRelFields");
            $this->$var = $_REQUEST[$var];
        }

    }

 	function display() {
        //First load the primary bean
        $focus = BeanFactory::getBean($this->tmodule, $this->id);

        $params = implode(",", json_decode(html_entity_decode($this->params)));
        $result = Parser::evaluate("{$this->function}($params)", $focus)->evaluate();
        //If the target field isn't a date, convert it to a user formated string
        if ($result instanceof DateTime)
        {
            global $timedate;
            if (isset($result->isDate) && $result->isDate)
                $result = $timedate->asUserDate($result);
            else
                $result = $timedate->asUser($result);
        }
        echo json_encode($result);
    }
}