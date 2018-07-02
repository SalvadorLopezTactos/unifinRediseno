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
    'LBL_LICENSING_INFO' => '<table border=&#39;0&#39; cellspacing=&#39;1&#39;><tr><td valign=&#39;top&#39; width=&#39;35%&#39; class=&#39;dataLabel&#39;>Hae API-avain ja salasana Twitteristä rekisteröimällä Sugar-instanssisi uutena sovelluksena.<br/><br>Sugar-instanssisi rekisteröinti tapahtuu seuraavasti:<br/><br/><ol><li>Mene Twitter Developers -sivulle: <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Kirjaudu sisään sillä Twitter-tilillä, jolla haluat rekisteröidä sovelluksen.</li><li>Syötä rekisteröintilomakkeeseen sovelluksen nimi. Käyttäjät näkevät tämän nimen, kun he autentikoivat Twitter-tilinsä Sugarista.</li><li>Syötä kuvaus.</li><li>Syötä sovelluksen web-sivun URL-osoite.</li><li>Syötä Callback URL. Tämä voi olla mikä tahansa, sillä Sugar ohittaa tämän autentikoitaessa. Voisit esimerkiksi syöttää Sugar-sivusi URL:n.</li><li>Hyväksy Twitter API:n käyttöehdot.</li><li>Napsauta "Create your Twitter application".</li><li>Etsi sovellussivun "API Keys" -välilehdeltä API-avain ("API Key") ja API-salasana ("API Secret"). Syötä avain ja salasana alle.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Twitter-käyttäjänimi',
    'LBL_ID' => 'Twitter-käyttäjänimi',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'API-avain',
    'oauth_consumer_secret' => 'API-salasana',
);

?>
