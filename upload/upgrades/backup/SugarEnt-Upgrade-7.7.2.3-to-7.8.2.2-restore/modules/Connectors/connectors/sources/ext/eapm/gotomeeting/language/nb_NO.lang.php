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
Hent API Key fra Citrix Online GoToMeeting ved å registrere en ny søknad.<br>
&nbsp;<br>
Slik registrerer du forekomsten din:<br>
&nbsp;<br>
<ol>
<li>Logg på din Citrix Online Developer-konto: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Klikk på «Søk om utviklernøkkel»</li>
<li>Under produkt-API velger du GoToMeeting og angir forekomst-URL-en i applikasjons-URL-en.</li>
<li>Du kommer til å se en søyle som heter API-nøkkel under «Dine applikasjoner»</li>
<li>Kopier den nedenfor.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'API-nøkkel',
);
