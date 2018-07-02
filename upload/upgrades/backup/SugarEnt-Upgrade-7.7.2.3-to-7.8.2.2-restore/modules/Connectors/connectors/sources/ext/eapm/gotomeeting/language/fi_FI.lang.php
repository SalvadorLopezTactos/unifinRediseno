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
Hanki API-avain Citrix Online GoToMeeting -palvelusta rekisteröimällä uusi sovellus.<br>
&nbsp;<br>
Rekisteröinti vaiheittain:<br>
&nbsp;<br>
<ol>
<li>Kirjaudu sisään Citrix Online -kehittäjätilillesi: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Napsauta "Apply for Developer Key"</li>
<li>Valitse "Product API" -sivulla GoToMeeting ja kirjoita instanssin URL-osoite "Application URL" -kohtaan</li>
<li>Näet "Your Applications" -kohdassa "API Key" -sarakkeen.</li>
<li>Kopioi avain alle.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'API-avain',
);
