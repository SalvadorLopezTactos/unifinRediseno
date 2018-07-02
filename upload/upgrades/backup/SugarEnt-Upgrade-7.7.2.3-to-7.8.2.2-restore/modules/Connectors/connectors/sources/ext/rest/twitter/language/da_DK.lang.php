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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Anskaf en API-nøgle og en hemmelighed fra Twitter ved at registrere din Sugar som ny applikation.<br/><br>Trin i forbindelse med registrering af dit eksempel:<br/><br/><ol><li>Gå til Twitter Developers site: <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new.</a>.</li><li>Log ind ved hjælp af den Twitter-konto, som du gerne vil registrere applikationen med.</li><li>Indtast et navn til programmet på registreringsformularen. Dette er det navn brugerne ser, når de godkender deres Twitter-konto fra Sugar.</li><li>Indtast en beskrivelse.</li><li>Indtast en applikations-website URL.</li><li>Indtast en tilbagemeldings-URL (kan være hvad som helst, i og med at Sugar forbigår denne ved godkendelsen. F.eks.: Indtast URL til dit Sugar site).</li><li>Accepter betingelserne for Twitter API.</li><li>Klik på "Opret din Twitter-applikation".</li><li>Find API-nøglen og API Secret på applikationssiden under "API-nøgler". Indtast nøglen og hemmelighed herunder.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Twitter brugernavn',
    'LBL_ID' => 'Twitter brugernavn',
	'company_url' => 'Link',
    'oauth_consumer_key' => 'API-nøgle',
    'oauth_consumer_secret' => 'API-hemmelighed',
);

?>
