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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Skaff en API-nøkkel og hemmelig nøkkel fra Twitter ved å registrere Sugar-forekomsten din som en ny applikasjon.<br/><br>Fremgangsmåte for å registrere forekomsten din:<br/><br/><ol><li>Gå til nettsiden Twitter Developers: <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Logg på med Twitter-kontoen som du ønsker å registrere applikasjonen under.</li><li>Skriv inn et navn for applikasjonen på registreringsskjemaet. Dette er navnet brukere vil se når de autentiserer Twitter-kontoene sine på Sugar.</li><li>Skriv inn en beskrivelse.</li><li>Skriv inn en nettadresse til applikasjonsnettsiden.</li><li>Skriv inn en retur-URL (dette kan være hva som helst siden Sugar hopper over dette ved autentisering. Du kan f.eks. skrive inn nettadressen til Sugar-siden din).</li><li>Godta tjenestevilkårene for Twitter API.</li><li>Klikk på «Create your Twitter application».</li><li>Finn API-nøkkelen og den hemmelige nøkkelen på applikasjonssiden under kategorien «API-nøkler». Skriv inn API-nøkkelen og den hemmelige nøkkelen nedenfor.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Twitter-brukernavn',
    'LBL_ID' => 'Twitter-brukernavn',
	'company_url' => 'Link',
    'oauth_consumer_key' => 'API-nøkkel',
    'oauth_consumer_secret' => 'API-hemmelighet',
);

?>
