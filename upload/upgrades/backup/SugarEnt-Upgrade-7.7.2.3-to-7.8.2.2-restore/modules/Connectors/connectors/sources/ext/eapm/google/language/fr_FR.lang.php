<?php
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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">
Obenez une clé et un secret API de Google en enregistrant votre instance Sugar en tant que nouvelle application. 
<br/><br>Étapes pour enregistrer votre instance :
<br/><br/>
<ol>
<li>Allez sur le site des développeurs de Google :
<a href=&#39;https://console.developers.google.com/project&#39;
target=&#39;_blank&#39;>https://console.developers.google.com/project</a>.</li>

<li>Connectez-vous à l&#39;aide du compte Google avec lequel vous désirez enregistrer l&#39;application.</li>
<li>Créez un nouveau projet</li>
<li>Saisissez un nom de Projet et cliquez sur Créer.</li>
<li>Une fois le projet créé, activez les API Google Drive et Google Contact</li>
<li>Dans la section APIs & Auth > Credentials créez un nouvel id client </li>
<li>Sélectionnez Web Application et cliquez sur Configure conscent screen</li>
<li>Saisissez un nom de produit et cliquez sur Enregistrer</li>
<li>Dans la section Authorized redirect URIs, saisissez l&#39;url suivante : {$SITE_URL}/index.php?module=EAPM&action=GoogleOauth2Redirect</li>
<li>Cliquez sur Créer id client</li>
<li>Copiez l&#39;id client et le code secret du client dans les cases en-dessous</li>
</li>
</ol>
</td></tr>
</table>',
    'oauth2_client_id' => 'ID client',
    'oauth2_client_secret' => 'Code secret client',
);
