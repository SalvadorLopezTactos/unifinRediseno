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
Erhalten Sie einen API-Schlüssel von Citrix Online GoToMeeting, indem Sie eine neue Anwendung registrieren.<br>
&nbsp;<br>
Vorgehensweise zur Registrierung Ihrer Instanz:<br>
&nbsp;<br>
<ol>
<li>Melden Sie sich mit Ihrem Citrix Online-Entwicklerkonto an: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Klicken Sie auf "Apply for Developer Key"</li>
<li>Unter Product API wählen Sie GoToMeeting aus und geben Sie Ihre Instanz-URL als Anwendungs-URL ein</li>
<li>Es wird jetzt eine Spalte mit dem Namen "API Key" unter "Your Applications" angezeigt</li>
<li>Kopieren Sie diese unten.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'API-Schlüssel',
);
