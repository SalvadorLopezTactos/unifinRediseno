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
Ottenere una API Key da Citrix Online GoToMeeting registrando una nuova applicazione.<br>
&nbsp;<br> 
Passaggi per registrare la propria istanza:<br> 
&nbsp;<br> 
<ol> 
<li>Accedere al proprio account di sviluppatore Citrix Online: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li> 
<li>Fare clic su applica per la Chiave Sviluppatore </li> 
<li>In Product API selezionare GoToMeeting, e inserire il proprio URL istanza nell’URL Applicazione </li> 
<li>Si vedrà una colonna chiamata API Key sotto alla voce Le tue Applicazioni </li> 
<li>Copiarla qui sotto.</li> 
</ol> 
</td></tr></table>',
    'oauth_consumer_key' => 'Chiave API',
);
