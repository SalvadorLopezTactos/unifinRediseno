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

/*********************************************************************************
 * Hebrew vertion by:
 * Menahem Lurie Consultancy and IT Management,SugarCRM partner - Israel
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * *******************************************************************************/


$connector_strings = array (
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Obtain a Consumer Key and Secret from Twitter&amp;#169; by registering your Sugar instance as a new application.<br/><br>Steps to register your instance:<br/><br/><ol><li>Go to the Twitter&amp;#169; Developers site: <a href=\'http://dev.twitter.com/apps/new\' target=\'_blank\'>http://dev.twitter.com/apps/new</a>.</li><li>Sign In using the Twitter account under which you would like to register the application.</li><li>Within the registration form, enter a name for the application. This is the name users will see when they authenticate their Twitter accounts from within Sugar.</li><li>Enter a Description.</li><li>Enter an Application Website URL (could be anything).</li><li>Select "Browser" for Application Type.</li><li>After selecting "Browser" for Application Type, enter a Callback URL (could be anything since Sugar bypasses this on authentication. Example: Enter your Sugar root URL).</li><li>Enter the security words.</li><li>Click "Register application".</li><li>Accept the Twitter API Terms of Service.</li><li>Within the application page, find the Consumer Key and Consumer Secret. Enter the Key and Secret below.</li></ol></td></tr></table>',
    'LBL_NAME' => 'שם משתמש בטוויטר',
    'LBL_ID' => 'שם משתמש בטוויטר',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'מפתח לקוח',
    'oauth_consumer_secret' => 'סיסמא של הצרכן',
);
