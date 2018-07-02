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
Obteniu la clau API del Citrix Online GoToMeeting registrant una aplicació nova.<br>
&nbsp;<br>
Passos per registrar la vostra instància:<br>
&nbsp;<br>
<ol>
<li>Inicieu sessió amb el compte de desenvolupador Citrix Online: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Feu clic a Sol·licita la clau de desenvolupador</li>
<li>A Producte API seleccioneu GoToMeeting i introduïu l&#39;URL de la instància a l&#39;URL d&#39;aplicació</li>
<li>Veureu una columna anomenada Clau AI a Les vostres aplicacions</li>
<li>Copieu-la a continuació.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'Clau API',
);
