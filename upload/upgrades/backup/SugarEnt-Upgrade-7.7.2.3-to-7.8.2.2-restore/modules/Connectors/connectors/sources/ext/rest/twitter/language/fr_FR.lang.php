<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

/*********************************************************************************
* Description:
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
* Reserved. Contributor(s): contact@synolia.com - www.synolia.com
* *******************************************************************************/


$connector_strings = array (
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"> <tr><td valign="top" width="35%" class="dataLabel"> Obtenez une clé API et un Secret de Twitter en enregistrant votre instance de Sugar comme une nouvelle application. <br/> <br>Étapes pour enregistrer votre instance : <br/> <br/> <ol><li>Allez sur le site des développeurs de Twitter : <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;> http://dev.twitter.com/apps/new</a>.</li> <li>Connectez-vous en utilisant le compte Twitter sous lequel vous souhaitez enregistrer l&#39;application.</li> <li>Dans le formulaire d&#39;inscription, entrez un nom pour l&#39;application. C&#39;est le nom que les utilisateurs verront lorsqu&#39;ils authentifieront leurs comptes Twitter depuis Sugar.</li> <li>Entrez une Description.</li> <li>Entrez une URL de site Web Application.</li> <li>Entrez une URL de Callback (peut être n&#39;importe quoi car Sugar contourne ceci lors de l&#39;authentification. Exemple : Entrez votre URL de site Sugar).</li> <li>Acceptez les conditions de service de l&#39;API de Twitter.</li> <li>Cliquez sur « Créer votre application Twitter ».</li> <li>Dans la page application, trouvez la clé API et le secret API sous l&#39;onglet « Clés de l&#39;API ». Entrez la clé et le code Secret ci-dessous.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Nom d&#39;utilisateur Twitter',
    'LBL_ID' => 'Nom d&#39;utilisateur Twitter',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'Clé API',
    'oauth_consumer_secret' => 'Code Secret API',
);

?>
