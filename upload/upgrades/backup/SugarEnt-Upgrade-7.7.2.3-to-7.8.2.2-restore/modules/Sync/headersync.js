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
 
// $Id: style.js 23344 2007-06-05 20:32:59Z eddy $

function start_sync()
{
	height = 30;
	window.open("index.php?action=Popup&check_available=1&module=Sync&clean_sync=0","sync","width=300,height="+ height+",resizable=1,scrollbars=1");
}

function work_online()
{
	document.location.href = "index.php?action=index&module=Sync&go_online=1&check_available=1";
}
