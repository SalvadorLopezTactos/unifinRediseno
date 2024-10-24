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
/*********************************************************************************
 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$mod_strings = [
    'LBL_SEND_DATE_TIME' => 'Saatmiskuupäev',
    'LBL_IN_QUEUE' => 'Töös',
    'LBL_IN_QUEUE_DATE' => 'Ootelepaneku kuupäev',

    'ERR_INT_ONLY_EMAIL_PER_RUN' => 'Paki kohta saadetavate e-kirjade arvu täpsustamisel kasutage ainult täisarve',

    'LBL_ATTACHMENT_AUDIT' => 'saadetud. Seda ei dubleeritud lokaalselt, et säilitada kettamahtu.',
    'LBL_CONFIGURE_SETTINGS' => 'Konfigureeri e-posti sätteid',
    'LBL_CUSTOM_LOCATION' => 'Kasutaja on määratletud',
    'LBL_DEFAULT_LOCATION' => 'Vaikimisi',

    'LBL_DISCLOSURE_TITLE' => 'Lisa avalikustamisteade igale e-kirjale',
    'LBL_DISCLOSURE_TEXT_TITLE' => 'Avaldamise sisu',
    'LBL_DISCLOSURE_TEXT_SAMPLE' => 'TEADE: see e-kiri on suunatud ainult kindla(te)le saaja(te)le ja võib sisaldada konfidentsiaalset ja privilegeeritud teavet. Volitamata isikutel on selle teabe vaatamine, kasutamine, avalikustamine ja levitamine keelatud. Kui te ei ole kirja adressaat, siis palun hävitage kõik algteate koopiad ja teavitage saatjat, et saaksime aadressi kirjet parandada. Täname!',

    'LBL_EMAIL_DEFAULT_CHARSET' => 'Koosta e-kirjad selles märgistikus',
    'LBL_EMAIL_DEFAULT_EDITOR' => 'Koosta e-kiri seda klienti kasutades',
    'LBL_EMAIL_DEFAULT_DELETE_ATTACHMENTS' => 'Kustuta koos kustutatud e-kirjadega ka seotud märkused ja manused',
    'LBL_EMAIL_GMAIL_DEFAULTS' => 'Täida Gmail&#153;-i vaikeseaded',
    'LBL_EMAIL_PER_RUN_REQ' => 'Saadetud e-kirju paki kohta:',
    'LBL_EMAIL_SMTP_SSL' => 'Kas lubada SMTP üle SSL-i?',
    'LBL_EMAIL_USER_TITLE' => 'Kasutaja e-posti vaikeseaded',
    'LBL_EMAIL_OUTBOUND_CONFIGURATION' => 'Väljaminevate e-kirjade konfiguratsioon',
    'LBL_EMAILS_PER_RUN' => 'Saadetud e-kirju paki kohta:',
    'LBL_ID' => 'ID',
    'LBL_LIST_CAMPAIGN' => 'Kampaania',
    'LBL_LIST_FORM_PROCESSED_TITLE' => 'Töödeldud',
    'LBL_LIST_FORM_TITLE' => 'Ootejärjekord',
    'LBL_LIST_FROM_EMAIL' => 'E-kirjast',
    'LBL_LIST_FROM_NAME' => 'Saatja nimi',
    'LBL_LIST_IN_QUEUE' => 'Töös',
    'LBL_LIST_MESSAGE_NAME' => 'Turundussõnum',
    'LBL_LIST_RECIPIENT_EMAIL' => 'Saaja e-post',
    'LBL_LIST_RECIPIENT_NAME' => 'Saaja nimi',
    'LBL_LIST_SEND_ATTEMPTS' => 'Saada katsed',
    'LBL_LIST_SEND_DATE_TIME' => 'Saadetud',
    'LBL_LIST_USER_NAME' => 'Kasutajanimi',
    'LBL_LOCATION_ONLY' => 'Asukoht',
    'LBL_LOCATION_TRACK' => 'Kampaania jälgimise failide asukoht (nagu campaign_tracker.php)',
    'LBL_CAMP_MESSAGE_COPY' => 'Säilitage kampaania sõnumite koopiad:',
    'LBL_CAMP_MESSAGE_COPY_DESC' => 'Kas soovite talletada kõigi kampaaniate käigus saadetud <bold>IGA</bold> meiliteate täielikud koopiad? <bold>Soovitame mitte ja see on ka vaikimisi seadistus</bold>. Valides Ei talletatakse vaid saadetud sõnumi mall ja muutujad, mis on vajalikud individuaalse sõnumi taasloomiseks.',
    'LBL_MAIL_SENDTYPE' => 'E-kirja edastamise agent:',
    'LBL_MAIL_SMTPAUTH_REQ' => 'Kasuta SMTP autentimist:',
    'LBL_MAIL_SMTPPASS' => 'Parool:',
    'LBL_MAIL_SMTPPORT' => 'SMTP port:',
    'LBL_MAIL_SMTPSERVER' => 'SMTP meiliserver:',
    'LBL_MAIL_SMTPUSER' => 'Kasutajanimi:',
    'LBL_CHOOSE_EMAIL_PROVIDER' => 'Valige oma meiliteenuse pakkuja',
    'LBL_YAHOOMAIL_SMTPPASS' => 'Yahoo! Maili parool',
    'LBL_YAHOOMAIL_SMTPUSER' => 'Yahoo! Maili ID',
    'LBL_GMAIL_SMTPPASS' => 'Gmaili parool',
    'LBL_GMAIL_SMTPUSER' => 'Gmaili e-posti aadress',
    'LBL_EXCHANGE_SMTPPASS' => 'Exchange&#39;i parool',
    'LBL_EXCHANGE_SMTPUSER' => 'Exchange&#39;i kasutajanimi',
    'LBL_EXCHANGE_SMTPPORT' => 'Exchange&#39;i serveri port',
    'LBL_EXCHANGE_SMTPSERVER' => 'Exchange&#39;i server',
    'LBL_AUTH_STATUS' => 'Olek',
    'LBL_AUTHORIZED_ACCOUNT' => 'Volitatud e-posti aadress',
    'LBL_EMAIL_LINK_TYPE' => 'E-posti klient',
    'LBL_EMAIL_LINK_TYPE_HELP' => '<b>Sugari e-posti klient:</b> saatke e-kirju, kasutades e-posti klienti Sugari rakenduses.<br>See suvand on saadaval vaid juhul, kui teie administraator on konfigureerinud teie e-posti sätted seda lubama. Küsimuste korral võtke ühendust oma administraatoriga.<br><b>Välise e-posti klient:</b> saatke e-kiri, kasutades e-posti klienti väljaspool Sugari rakendust, nagu Microsoft Outlook.',
    'LBL_MARKETING_ID' => 'Turunduse ID',
    'LBL_MODULE_ID' => 'EmailMan',
    'LBL_MODULE_NAME' => 'E-kirja sätted',
    'LBL_MODULE_NAME_SINGULAR' => 'E-kirja sätted',
    'LBL_CONFIGURE_CAMPAIGN_EMAIL_SETTINGS' => 'Konfigureeri kampaania e-kirja sätteid',
    'LBL_MODULE_TITLE' => 'Väljaminevate e-kirjade ootejärjekorra haldamine',
    'LBL_NOTIFICATION_ON_DESC' => 'Lubatuna saadetakse e-kirjad kasutajatele, kui kirjed on neile määratud.',
    'LBL_NOTIFY_FROMADDRESS' => 'Saatja aadress:',
    'LBL_NOTIFY_FROMNAME' => 'Saatja nimi:',
    'LBL_NOTIFY_ON' => 'Määramisteavitused',
    'LBL_ALLOW_USER_EMAIL_ACCOUNT' => 'Luba kasutajatel e-posti kontosid seadistada',
    'LBL_NOTIFY_SEND_BY_DEFAULT' => 'Saada teavitused uutele kasutajatele',
    'LBL_NOTIFY_TITLE' => 'E-posti suvandid',
    'LBL_OLD_ID' => 'Vana ID',
    'LBL_OUTBOUND_EMAIL_TITLE' => 'Väljaminevate e-kirjade suvandid',
    'LBL_RELATED_ID' => 'Seotud ID',
    'LBL_RELATED_TYPE' => 'Seotud tüüp',
    'LBL_SAVE_OUTBOUND_RAW' => 'Salvesta väljaminevad toormeilid',
    'LBL_SEARCH_FORM_PROCESSED_TITLE' => 'Töödeldud otsing',
    'LBL_SEARCH_FORM_TITLE' => 'Ootejärjekorra otsing',
    'LBL_VIEW_PROCESSED_EMAILS' => 'Vaata töödeldud e-kirju',
    'LBL_VIEW_QUEUED_EMAILS' => 'Vaata ootel e-kirju',
    'TRACKING_ENTRIES_LOCATION_DEFAULT_VALUE' => 'Config.php väärtus suvandi site_url seadistamiseks',
    'TXT_REMOVE_ME_ALT' => 'Enda eemaldamiseks sellest e-posti listist avage',
    'TXT_REMOVE_ME_CLICK' => 'klõpsake siin',
    'TXT_REMOVE_ME' => 'Enda eemaldamiseks sellest e-posti listist',
    'LBL_NOTIFY_SEND_FROM_ASSIGNING_USER' => 'Saada teavitus määratud kasutaja e-posti aadressilt',
    'LBL_EMAIL_OPT_OUT_DEFAULT' => 'Jäta uued meiliaadressid adressaatide seast automaatselt välja',

    'LBL_SECURITY_TITLE' => 'E-posti turvasätted',
    'LBL_SECURITY_DESC' => 'Kontrollige järgmist, mis EI tohiks olla lubatud sissetulevas e-kirjas või kuvatud e-kirjade moodulis.',
    'LBL_SECURITY_APPLET' => 'Apleti silt',
    'LBL_SECURITY_BASE' => 'Baassilt',
    'LBL_SECURITY_EMBED' => 'Manuse silt',
    'LBL_SECURITY_FORM' => 'Vormi silt',
    'LBL_SECURITY_FRAME' => 'Paneeli silt',
    'LBL_SECURITY_FRAMESET' => 'Paneelistiku silt',
    'LBL_SECURITY_IFRAME' => 'iFrame&#39;i silt',
    'LBL_SECURITY_IMPORT' => 'Impordi silt',
    'LBL_SECURITY_LAYER' => 'Kihi silt',
    'LBL_SECURITY_LINK' => 'Lingi silt',
    'LBL_SECURITY_OBJECT' => 'Objekti silt',
    'LBL_SECURITY_OUTLOOK_DEFAULTS' => 'Valige Outlooki turvalisuse minimaalsed vaikesätted (õige kuva küljel tõrked).',
    'LBL_SECURITY_SCRIPT' => 'Skripti silt',
    'LBL_SECURITY_STYLE' => 'Stiili silt',
    'LBL_SECURITY_TOGGLE_ALL' => 'Lülita kõiki suvandeid',
    'LBL_SECURITY_XMP' => 'Xmp silt',
    'LBL_YES' => 'Jah',
    'LBL_NO' => 'Ei',
    'LBL_PREPEND_TEST' => '[Test]:',
    'LBL_SEND_ATTEMPTS' => 'Saada katsed',
    'LBL_OUTGOING_SECTION_HELP' => 'Konfigureerige vaikimisi väljaminev meiliserver e-postiga teadete, sealhulgas töövoo teatiste saatmiseks.',
    'LBL_ALLOW_DEFAULT_SELECTION' => 'Luba kasutajatel seda kontot kasutada väljaminevate e-kirjade jaoks:',
    'LBL_ALLOW_DEFAULT_SELECTION_HELP' => 'Kui valitud on see suvand, saavad kõik kasutajad saata e-kirju, kasutades sama väljaminevate<br> e-kirjade kontot, mida kasutati süsteemiteadete ja -hoiatuste saatmiseks. Kui seda suvandit pole valitud,<br> saavad kasutajad väljamineva e-kirja serverit siiski kasutada pärast oma kontoteabe esitamist.',
    'LBL_FROM_ADDRESS_HELP' => 'Lubatuna on määrava kasutaja nimi ja e-posti aadress e-kirja väljale Saatja kaasatud. See funktsioon ei pruugi töötada SMTP serveritega, mis ei võimalda saatmist serveri kontost erinevalt e-posti kontolt.',
    'LBL_EMAIL_OPT_OUT_DEFAULT_TOOLTIP' => 'Uued lisatud meiliaadressid jäetakse adressaatide hulgast automaatselt välja. Välja jäetud meiliaadressidele ei saa saata kampaania meile. Selle sätte muutmine ei mõjuta olemasolevaid meiliaadresse.',
    'LBL_GMAIL_LOGO' => 'Gmail' /*for 508 compliance fix*/,
    'LBL_YAHOO_MAIL_LOGO' => 'Yahoo Mail' /*for 508 compliance fix*/,
    'LBL_EXCHANGE_LOGO' => 'Exchange' /*for 508 compliance fix*/,
    'LBL_HELP' => 'Abi' /*for 508 compliance fix*/,
    'LBL_UNAUTH_ACCESS' => 'Volitamata juurdepääs haldamisele.',
    'LBL_INVALID_ENTRY_POINT' => 'Pole kehtiv sisendpunkt',
];
