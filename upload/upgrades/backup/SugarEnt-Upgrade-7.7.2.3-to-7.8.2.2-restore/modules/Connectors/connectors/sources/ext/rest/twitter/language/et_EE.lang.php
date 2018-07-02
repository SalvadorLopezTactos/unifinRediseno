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

/*********************************************************************************
* Description:
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
* Reserved. Contributor(s): contact@synolia.com - www.synolia.com
* *******************************************************************************/


$connector_strings = array (
    'LBL_LICENSING_INFO' => 'Obtain a Consumer Key and Secret from Twitter© by registering your Sugar instance as a new application.<br /><br />Steps to register your instance:<br /><br />   1. Go to the Twitter© Developers site:: http://dev.twitter.com/apps/new.<br />   2. Sign In using the Twitter account under which you would like to register the application.<br />   3. Within the registration form, enter a name for the application. This is the name users will see when they authenticate their Twitter accounts from within Sugar.<br />   4. Enter a Description.<br />   5. Enter an Application Website URL (could be anything).<br />   6. Select "Browser" for Application Type.<br />   7. After selecting "Browser" for Application Type, enter a Callback URL (could be anything since Sugar bypasses this on authentication. Example: Enter your Sugar root URL).<br />   8. Enter the security words.<br />   9. Click "Register application".<br />  10. Accept the Twitter API Terms of Service.<br />  11. Within the application page, find the Consumer Key and Consumer Secret. Enter the Key and Secret below.',
    'LBL_NAME' => 'Twitteri kasutajanimi',
    'LBL_ID' => 'Twitteri kasutajanimi',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'Consumer Key',
    'oauth_consumer_secret' => 'Consumer Secret',
);

?>
