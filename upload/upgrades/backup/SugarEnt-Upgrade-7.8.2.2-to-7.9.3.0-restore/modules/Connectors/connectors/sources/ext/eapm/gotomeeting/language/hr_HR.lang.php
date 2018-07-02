<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$connector_strings = array(
    'LBL_LICENSING_INFO' =>
'<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">
Pribavite API ključ od usluge Citrix Online GoToMeeting tako da registrirate novu aplikaciju.<br>
&nbsp;<br>
Koraci za registraciju instance:<br>
&nbsp;<br>
<ol>
<li>Prijavite se u svoj račun za razvojne inženjere Citrix Online: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Kliknite na Prijavi se za ključ razvojnog inženjera</li>
<li>U odjeljku API proizvoda odaberite GoToMeeting i unesite URL adresu svoje instance u polje URL adresa aplikacije</li>
<li>Vidjet ćete stupac naziva API ključ u odjeljku Vaše aplikacije</li>
<li>Kopirajte ga ispod.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'API ključ',
);
