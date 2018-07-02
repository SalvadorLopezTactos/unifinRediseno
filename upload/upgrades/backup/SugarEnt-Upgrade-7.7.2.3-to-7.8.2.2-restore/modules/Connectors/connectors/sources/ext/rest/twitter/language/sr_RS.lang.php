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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Nabavite potrošački ljuč i tajnu sa Twitter registrovanjem vaše Sugar instance kao nove aplikacije.<br/><br>Koraci za registraciju Vaše instance:<br/><br/><ol><li>Idite na Twitter sajt programera: <a href="http://dev.twitter.com/apps/new" target="_blank">http://dev.twitter.com/apps/new</a>.</li><li>Prijavite se koristeći Twitter nalog sa kojim želite da registrujete aplikaciju.</li><li>U formi za registraciju, unesite naziv za aplikaciju. Ovo je naziv koji će korisnici videti kada potvrde svoje Twitter naloge u Sugar-u.</li><li>Unesite opis</li><li>Unesite web sajt URL aplikacije.</li><li>Unesite Callback URL (može biti bilo šta jer Sugar zaobilazi ovo pri autentifikaciji. Na primer: Unesite svoju URL adresu Sugar-a).</li><li>Prihvatite Twitter API uslove korišćenja.</li><li>U okviru strane aplikacije pronađite potrošački ključ i tajnu pod karticom "Potrošački ključevi". Unesite ključ i tajnu ispod.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Twitter korisničko ime',
    'LBL_ID' => 'Twitter korisničko ime',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'Potrošački ključ',
    'oauth_consumer_secret' => 'Potrošačka tajna',
);

?>
