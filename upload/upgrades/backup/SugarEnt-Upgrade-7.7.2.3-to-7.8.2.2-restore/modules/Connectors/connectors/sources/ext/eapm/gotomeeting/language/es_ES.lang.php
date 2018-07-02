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
Obtenga la clave API de Citrix Online GoToMeeting registrándo una nueva aplicación.<br>
&nbsp;<br>
Pasos para registrar su instancia:<br>
&nbsp;<br>
<ol>
<li>Inicie sesión con su cuenta de desarrollador Citrix Online: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Haga clic en Solicitar una clave de desarrollador</li>
<li>En Producto API seleccione GoToMeeting e introduzca su URL de instancia en la URL de la aplicación</li>
<li>Verá una columna llamada Clave API en Sus aplicaciones</li>
<li>Cópiela a continuación.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'Clave API',
);
