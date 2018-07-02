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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Zdobądź Poufny klucz klienta z serwisu Twitter, rejestrując swoją instancję Sugar jako nową aplikację.<br/><br>Etapu rejestracji instancji:<br/><br/><ol><li>Przejdź do strony programistów Twitter: <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Zaloguj się na konto Twitter, pod którym chcesz zarejestrować aplikację.</li><li>W formularzu rejestracji wprowadź nazwę dla aplikacji. Nazwa ta będzie widoczna dla użytkowników podczas autoryzacji kont Twitter z poziomu SugarCRM.</li><li>Wprowadź opis.</li><li>Wprowadź adres URL strony internetowej aplikacji.</li><li>Wprowadź adres URL wywołania zwrotnego (może być dowolny, ponieważ system Sugar omija podczas uwierzytelniania. Przykład: Wprowadź adres URL strony Sugar).</li><li>Zaakceptuj warunki korzystania z interfejsu API serwisu Twitter.</li><li>Kliknij opcję Utwórz aplikację Twitter.</li><li>Na stronie aplikacji znajdź Klucz API i  Poufny klucz API w karcie Klucze API. Wprowadź je poniżej.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Nazwa użytkownika Twitter',
    'LBL_ID' => 'Nazwa użytkownika Twitter',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'Klucz API',
    'oauth_consumer_secret' => 'Poufny klucz API',
);

?>
