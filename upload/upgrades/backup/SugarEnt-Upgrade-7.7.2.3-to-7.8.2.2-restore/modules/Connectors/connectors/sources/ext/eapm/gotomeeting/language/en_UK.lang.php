<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$connector_strings = array(
    'LBL_LICENSING_INFO' =>
'<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">
Obtain API Key from Citrix Online GoToMeeting by registering a new application.<br>
&nbsp;<br>
Steps to register your instance:<br>
&nbsp;<br>
<ol>
<li>Log in to your Citrix Online developer account: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Click on Apply for Developer Key</li>
<li>In Product API select GoToMeeting and enter your instance URL in Application URL</li>
<li>You will see a column called API Key under Your Applications</li>
<li>Copy it below.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'API Key',
);
