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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Erhalten Sie einen API Key und einen Secret-Code von Twitter, indem Sie Ihre Instanz von Sugar als neue Anwendung registrieren.<br/><br>Vorgehensweise für die Registrierung:<br/><br/><ol><li>Gehen Sie zur Twitter Developers-Webseite: <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Melden Sie sich mit jenem Twitter-Konto an, unter dem Sie die Anwendung registrieren möchten.</li><li>Geben Sie im Registrierungsformular einen Namen für die Anwendung ein. Dies ist der Name, der den Benutzern angezeigt wird, wenn Sie ihre Twitter-Konten von Sugar aus authentifizieren.</li><li>Geben Sie eine Beschreibung ein.</li><li>Geben Sie eine URL für die Anwendung ein.</li><li>Geben Sie eine Callback URL ein. (Dies kann eine beliebige Webseite sein, da Sugar diese bei der Authentifizierung ignoriert. Beispiel: Geben Sie die URL Ihrer Sugar-Seite ein,)</li><li>Akzeptieren Sie die Twitter API-Nutzungsbedingungen.</li><li>Klicken Sie auf "Ihre Twitter-Anwendung erstellen".</li><li>Suchen Sie den API Key und den API Secret-Code in der Registerkarte "API Keys". Geben Sie den API Key und den Secret-Code unten ein.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Twitter-Benutzername',
    'LBL_ID' => 'Twitter-Benutzername',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'API-Schlüssel',
    'oauth_consumer_secret' => 'API-Secret',
);

?>
