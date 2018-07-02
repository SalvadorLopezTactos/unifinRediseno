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
Uzyskaj klucz API z usługi Citrix Online GoToMeeting, rejestrując nową aplikację.<br>
&nbsp;<br>
Etapy rejestracji instancji:<br>
&nbsp;<br>
<ol>
<li>Zaloguj się na koncie programisty Citrix Online: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Kliknij opcję Zażądaj klucza dla programisty</li>
<li>W interfejsie API dla produkty wybierz opcję GoToMeeting i wprowadź adres URL instancji w polu Adres URL aplikacji</li>
<li>Wyświetlona zostanie kolumna o nazwie klucz API w obszarze Twoje aplikacje</li>
<li>Skopiuj jej zawartość poniżej.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'Klucz API',
);
