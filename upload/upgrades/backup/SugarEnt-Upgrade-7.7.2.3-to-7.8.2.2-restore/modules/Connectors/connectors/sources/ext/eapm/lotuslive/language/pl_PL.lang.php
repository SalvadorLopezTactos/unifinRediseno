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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Zdobądź Poufny klucz klienta z LotusLive&copy; poprzez zarejestrowanie swojej instancji Sugar jako nowej aplikacji.<br>
&nbsp;<br>
Kroki rejestracji aplikacji:<br>
&nbsp;<br>
<ol>
<li>Zaloguj się na swoje konto LotusLive  (musisz być administratorem): <a href="https://www.lotuslive.com/" target="_new">https://www.lotuslive.com/</a></li>
<li>Kliknij Administracja w pasku nawigacyjnym na górze.</li>
<li>Kliknij Zarządzaj Aplikacjami firmowymi.</li>
<li>Kliknij Zarejestruj aplikację.</li>
<li>Wprowadź nazwę i opis aplikacji. Mogą one być zmienione w dowolnym momencie poprzez kliknięcie menu obok aplikacji i wybranie edycji właściwości.</li>
<li> Podczas rejestracji dla Twojej aplikacji zostanie przypisany Poufny klucz OAuth. Zarejestrowane aplikacje są wyświetlone w Zarządzaniu Firmowymi aplikacjami. Aby zobaczyć klucz kliknij w menu odpowiedniej aplikacji i wybierz Pobierz listy uwierzytelniające.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'Unikalny klucz licencyjny OAuth',
    'oauth_consumer_secret' => 'Poufny klucz klienta OAuth',
);
