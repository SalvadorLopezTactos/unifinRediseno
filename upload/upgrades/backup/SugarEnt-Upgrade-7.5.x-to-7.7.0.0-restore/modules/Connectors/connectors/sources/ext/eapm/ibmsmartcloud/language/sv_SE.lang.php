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
	

$connector_strings = array (
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Få en Nyckel och Secret från IBM SmartCloud&copy; genom att registrera din Sugar instans som en ny applikation.<br><br />&nbsp;<br><br />Använd följande steg för att registrera din instans:<br><br />&nbsp;<br><br /><ol><br /><li>Logga in på ditt IBM SmartCloud konto (du måste vara administratör)</li><br /><li>Gå till "Administration" -> "Manage Organization"</li><br /><li>Gå till "Integrated Third-Party Appl" länken i sidomenyn och aktivera SugarCRM för alla användare.</li><br /><li>Gå till "Internal Apps" i sidomenyn och "Register App"</li><br /><li>Namnge den här appen till vad du vill ( t.ex. "SugarCRM Production"), och se till att _INTE_ markera "the OAuth 2.x checkbox" längst ner i popup-fönstret.</li><br /><li>Efter att appen skapats, klicka på den lilla triangel saken till höger om appnamnet och välj "Show Credentials" från dropdown-menyn.</li><br /><li>Kopiera "the credentials" nedanför.</li><br /></ol><br /></td></tr></table>',
  'oauth_consumer_key' => 'OAuth Consumer Nyckel',
  'oauth_consumer_secret' => 'OAuth Consumer Secret',
);

