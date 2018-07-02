<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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



require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopSelectButton.php');

class SugarWidgetSubPanelTopSelectReportsButton extends SugarWidgetSubPanelTopSelectButton
{
	//button_properties is a collection of properties associated with the widget_class definition. layoutmanager
	function SugarWidgetSubPanelTopSelectReportButton($button_properties=array())
	{
		$this->button_properties=$button_properties;
	}

    public function getWidgetId()
    {
    	$label = parent::getWidgetId();
        return str_replace("select_button", "select_reports_button", $label);
    }

}
?>
