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
	

$connector_strings = array (
  'LBL_ID' => 'Twitter-käyttäjänimi',
  'LBL_LICENSING_INFO' => '<table border=\'0\' cellspacing=\'1\'><tr><td valign=\'top\' width=\'35%\' class=\'dataLabel\'>Hae <i>Consumer Key</i> ja <i>-Secret</i> Twitteriltä rekisteröimällä Sugar-instanssisi uutena sovelluksena.<br /><br />Sugar-instanssisi rekisteröinti tapahtuu seuraavasti:<br /><br /><ol><li>Mene Twitter Developers -sivulle: <a href=\'http://dev.twitter.com/apps/new\' target=\'_blank\'>http://dev.twitter.com/apps/new</a>.</li><li>Kirjaudu sisään sillä Twitter-tilillä, jolla haluat registeröidä sovelluksen.</li><li>Syötä rekisteröintilomakkeeseen nimi sovellukselle. Käyttäjät näkevät tämän nimen kun he autentikoivat Twitter-tilinsä Sugarista.</li><li>Syötä kuvaus.</li><li>Syötä sovelluksen web-sivun URL. (Voi olla mikä tahansa.)</li><li>Valitse “Browser” sovellustyypille.</li><li>“Browser”:n valinnan jälkeen, syötä Callback URL. Tämä voi olla mikä tahansa, sillä Sugar ohittaa tämän autentikoitaessa. Voisit esimerkiksi syöttää Sugarin juuri-URL:n.</li><li>Syötä turvasanat.</li><li>Napsauta “Register application”.</li><li>Hyväksy Twitter APIn käyttöehdot.</li><li>Etsi sovellussivulta <i>Consumer Key</i> (API-avain) ja <i>Consumer Secret</i> (salainen avain). Syötä avain ja salasana alle.</li></ol></td></tr></table>',
  'LBL_NAME' => 'Twitter-käyttäjänimi',
  'company_url' => 'URL',
  'oauth_consumer_key' => 'Avain',
  'oauth_consumer_secret' => 'Salasana',
);
