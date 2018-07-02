<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Hankige API võti ja salavõti Twitterist, registreerides oma Sugari eksemplari uue rakendusena.<br/><br>Teie eksemplari registreerimise etapid on järgmised:<br/><br/><ol><li>Minge järgmisele Twitteri arendajate saidile: <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Logige sisse Twitteri kontoga, mille alt soovite rakenduse registreerida.</li><li>Sisestage rakenduse nimi registreerimisvormi. See on nimi, mida kasutajad näevad Twitteri kontode autentimisel Sugaris.</li><li>Sisestage kirjeldus.</li><li>Sisestage rakenduse veebisaidi URL.</li><li>Sisestage tagasihelistuse URL (võib olla mis tahes, kuna Sugar jätab selle autentimisel vahele. Näide: sisestage oma Sugari saidi URL).</li><li>Nõustuge Twitteri API kasutustingimustega.</li><li>Klõpsake suvandit Loo oma Twitteri rakendus.</li><li>Leidke rakenduse lehelt API võti ja API salavõti vahekaardilt API võtmed. Sisestage võti ja salavõti allpool.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Twitteri kasutajanimi',
    'LBL_ID' => 'Twitteri kasutajanimi',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'API võti',
    'oauth_consumer_secret' => 'API salavõti',
);

?>
