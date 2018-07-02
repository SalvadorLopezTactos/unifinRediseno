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
Poti obtine o cheie APi de la Citrix Online GoToMeeting inregistrand o noua aplicatie.<br>
&nbsp;<br>
Pasi pentru a inregistra instanta:<br>
&nbsp;<br>
<ol>
<li>Logheaza-te in contul tau de dezvoltator Citrix Online: https://developer.citrixonline.com/</li>
<li>Apasa butonul Aplica pentru o cheie de dezvoltator</li>
<li>In Produs API selecteaza GoToMeeting si introdu URL-ul instantei tale in campul URL Aplicatie</li>
<li>Vei vedea o coloana denumita Cheie API sub Aplicatiile tale</li>
<li>Copiaza cheia in campul de mai jos.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'Cheie API',
);
