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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Zdobądź Poufny klucz klienta z Twitter&#169; poprzez zarejestrowanie swojej instancji Sugar jako nowej aplikacji.<br/><br>Aby zarejestrować swoją instancję:<br/><br/><ol><li>Przejdź do strony programistów Twitter&#169;: <a href=\'http://dev.twitter.com/apps/new\' target=\'_blank\'>http://dev.twitter.com/apps/new</a>.</li><li>Zaloguj się na konto Twitter, pod którym chcesz zarejestrować aplikację.</li><li>W formularzy rejestracji wprowadź nazwę dla aplikacji. Nazwa ta będzie widoczna dla użytkowników podczas autoryzacji kont Twitter z poziomu SugarCRM.</li><li>Wprowadź opis.</li><li>Wprowadź adres strony internetowej aplikacji (może być jakikolwiek).</li><li>/Jako typ aplikacji wybierz “Przeglądarka”.</li><li> wprowadź  URL wywołania (może być dowolny, ponieważ kontrola odbywa się na poziomie uwierzytelnienia. Przykład: Wprowadź URL katalogu głównego Sugar).</li><li>Wprowadź słowa zabezpieczające.</li><li>Kliknij “Zarejestruj aplikację”.</li><li>Zaakceptuj Warunki usług Twitter API.</li><li>Na stronie aplikacji znajdź Unikalny klucz licencyjny i  Poufny klucz klienta. Wprowadź je poniżej.</li></ol></td></tr></table>',
	'LBL_NAME' => 'Nazwa użytkownika Twitter',
	'LBL_ID' => 'Nazwa użytkownika Twitter',
	'company_url' => 'Adres URL',
    'oauth_consumer_key' => 'Unikalny klucz licencyjny',
    'oauth_consumer_secret' => 'Poufny klucz klienta',
);

?>
