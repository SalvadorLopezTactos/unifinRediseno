<?php
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

$connector_strings = [
    'LBL_LICENSING_INFO' => 'DocuSign-liittimen käyttö:
        <br> - Luo integrointiavain.
        <br> - Ota käyttöön DocuSign Connect kirjekuorille.
        (Eli webhook, jota DocuSign käyttää Sugarin pääsypisteen tilaukseen).
        <br> - Luo uusi sovellus DocuSignissa ja muista lisätä uudelleenohjaus-URI ja luoda salainen avain.
        Uudelleenohjaus-URIn on oltava https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect.
        <br>Jos Sugar-instanssissa on IP-rajoituksia, lisää DocuSignin IP-osoitteet sallittujen luetteloon.',
    'environment' => 'Ympäristö',
    'integration_key' => 'Integrointiavain',
    'client_secret' => 'Asiakkaan salaisuus',
];
