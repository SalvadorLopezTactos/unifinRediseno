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
Egy új alkalmazás regisztrálásával Citrix Online GoToMeeting API ügyfélkódot szerezhet.<br>
&nbsp;<br>
A regisztrálás lépései:<br>
&nbsp;<br>
<ol>
<li>Jelentkezzen be az Online Citrix fejlesztői fiókjába: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Kattintson a következőre: Apply for Developer Key</li>
<li>Az API Terméknél válassza ki a GoToMeeting opciót, és írja be a példa URL-jét az almalmazás URL-jébe </li>
<li>Az alkalmazásai alatt megjelenik majd egy API Key nevű oszlop</li>
<li>Másolja be alulra.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'API Fogyasztói kulcs',
);
