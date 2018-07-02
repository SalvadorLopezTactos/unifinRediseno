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
/*
 * Created on May 14, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 //format '<action_name>' => '<view_name>',
 $action_view_map = array(
 						'index' => 'main',
 						//'quicklist'=>'quicklist', - unmap to this view and map to another, can change once we include Notifications
 						'quickview'=>'quickview',
						'quicklist' => 'systemquicklist',
 					);
?>
