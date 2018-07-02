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
  'LBL_ID' => 'Twitter användarnamn',
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Få en API Nyckel och App Secret från  Twitter&#169; genom att skapa en applikation för din Sugar instans.<br/><br>Använd följande steg för att skapa en applikation för din instans:<br/><br/><ol><li>Gå till Twitters&#169; Utvecklarsida: <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Logga in genom att användaTwitterkontot under vilket du vill registrera din applikation.</li><li>Under registreringsformuläret, skriv in namnet för applikationen. Det är det här namnet användarna kommer att se när de autentiserar deras Twitter&#169; konton inifrån Sugar.</li><li>Skriv in en beskrivning.</li><li>Skriv in en Applikations hemsidas URL (kan vara vad som helst).</li><li>Välj "Browser" som Application Type.</li><li>Efter att ha valt "Browser" som Application Type,skriv in en Callback URL (could be anything since Sugar bypasses this on authentication. Example: Enter your Sugar root URL).</li><li>Skriv in säkerhetsorden</li><li>Klicka på "Register application".</li><li>Acceptera Twitters API Terms of Service.</li><li>Under applikationssidan, hitta Consumer Key and Consumer Secret. Skriv in Key and Secret nedanför.</li></ol></td></tr></table>',
  'LBL_NAME' => 'Twitter användarnamn',
  'company_url' => 'URL',
  'oauth_consumer_key' => 'Consumer Key',
  'oauth_consumer_secret' => 'Consumer Secret',
);

