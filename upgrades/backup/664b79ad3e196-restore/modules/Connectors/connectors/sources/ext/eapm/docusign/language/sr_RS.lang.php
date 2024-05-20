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
    'LBL_LICENSING_INFO' => 'Koraci za korišćenje DocuSign konektora:
        <br> – generišite ključ za integraciju
        <br> – omogućite uslugu DocuSign Connect za koverte
        (tj. veb-huk koji se koristi u okviru usluge DocuSign za pretplatu na ulaznu tačku platforme Sugar)
        <br> – podesite novu aplikaciju u okviru usluge DocuSign i obavezno unesite URL i generišite tajni ključ;
        URI za preusmeravanje mora biti sledeći: https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect
        <br> u slučaju ograničenja IP-ja na instanci usluge Sugar, dozvolite IP adrese usluge DocuSign.',
    'environment' => 'Okruženje',
    'integration_key' => 'Ključ za integraciju',
    'client_secret' => 'Tajni ključ klijenta',
];
