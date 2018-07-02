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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Verkrijg een API Key en Secret van Twitter door uw Sugar-verzoek te registreren als een nieuwe applicatie.<br/><br>Stappen om uw aanmelding te registreren:<br/><br/><ol><li>Ga naar de ontwikkelaarssite van Twitter: <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Login met gebruik van uw Twitter-account waaronder u de applicatie wilt registreren.</li><li>Typ in het registratieformulier een naam in voor de applicatie. Dit is de naam die gebruikers zien als zij hun Twitter-accounts binnen Sugar autoriseren.</li><li>Typ een beschrijving in.</li><li>Typ een applicatiewebsite-URL in.</li><li>Typ een callback-URL in (kan van alles zijn aangezien Sugar dit omzeilt bij authenticatie. Voorbeeld: uw Sugarsite-URL).</li><li>Ga akkoord met de Twitter API-servicevoorwaarden.</li><li>Klik op "Maak uw Twitter-applicatie aan".</li><li>Binnen de applicatiepagina vindt u de API Key en API Secret onder de "API Keys"-tab. Typ hieronder de Key en Secret in.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Twitter-gebruikersnaam',
    'LBL_ID' => 'Twitter-gebruikersnaam',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'API sleutel',
    'oauth_consumer_secret' => 'API geheim',
);

?>
