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
    'LBL_LICENSING_INFO' => 'Koraci za uporabu DocuSign poveznika:
        <br> – generiranje ključa za integraciju
        <br> – omogućivanje usluge DocuSign Connect za omotnice
        (tj. mrežni povratni poziv koji se upotrebljava u okviru usluge DocuSign za pretplatu na ulaznu točku platforme Sugar)
        <br> – postavljanje nove aplikacije u okviru usluge DocuSign i obavezan unos URL-a i generiranje tajnog ključa;
        URL za preusmjeravanje mora biti sljedeći: https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect
        <br> u slučaju restrikcija IP-ja na instanci usluge Sugar, dozvoljavanje IP adresa usluge DocuSign.',
    'environment' => 'Okruženje',
    'integration_key' => 'Ključ za integraciju',
    'client_secret' => 'Klijentski tajni ključ',
];
