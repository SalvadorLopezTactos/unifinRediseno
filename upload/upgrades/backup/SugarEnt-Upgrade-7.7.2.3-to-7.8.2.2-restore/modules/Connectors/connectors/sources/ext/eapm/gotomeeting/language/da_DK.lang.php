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
Få API Key fra Citrix Online GoToMeeting ved at registrere en ny applikation.<br>
&nbsp;<br>
Trin i forbindelse med at registrere dit eksempel:<br>
&nbsp;<br>
<ol>
<li>Log ind på din Citrix Online udviklerkonto: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Klik på Apply for Developer Key</li>
<li>Vælg GoToMeeting under Product API, og indtast URL til dit eksempel i Application URL</li>
<li>Du vil se en kolonne under dine applikationer, der hedder API Key</li>
<li>Kopier den herunder.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'API-nøgle',
);
