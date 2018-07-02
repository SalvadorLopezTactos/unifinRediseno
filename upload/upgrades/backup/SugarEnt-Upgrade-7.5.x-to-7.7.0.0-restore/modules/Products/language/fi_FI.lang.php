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


$mod_strings = array (
  'ERR_DELETE_RECORD' => 'Tietuenumero tulee määritellä, jotta voit poistaa tuotteen.',
  'LBL_ACCOUNT_ID' => 'Asiakkaan ID',
  'LBL_ACCOUNT_NAME' => 'Asiakkaan nimi:',
  'LBL_ASSET_NUMBER' => 'Asset-numero:',
  'LBL_ASSIGNED_TO_NAME' => 'Vastuuhenkilö:',
  'LBL_ASSIGNED_USER_ID' => 'Vastuukäyttäjän ID:',
  'LBL_ASSOCIATED_QUOTE' => 'Tarjouksen aihe:',
  'LBL_BOOK_VALUE' => 'Kirjanpitoarvo:',
  'LBL_BOOK_VALUE_DATE' => 'Kirjanpitoarvon päiväys:',
  'LBL_BOOK_VALUE_USDOLLAR' => 'Kirjanpitoarvo (USD):',
  'LBL_CALCULATED_LINE_ITEM_AMOUNT' => 'Laskettu tarjotun tuoterivin määrä',
  'LBL_CAMPAIGN_PRODUCT' => 'Kampanjan tarjottu tuoterivi',
  'LBL_CATEGORY' => 'Kategoria:',
  'LBL_CATEGORY_NAME' => 'Kategorian nimi:',
  'LBL_COMMIT_STAGE' => 'Commitin vaihe',
  'LBL_COMMIT_STAGE_FORECAST' => 'Ennuste',
  'LBL_CONTACT' => 'Kontakti',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontaktit',
  'LBL_CONTACT_ID' => 'Kontaktin ID',
  'LBL_CONTACT_NAME' => 'Kontaktin nimi:',
  'LBL_CONTRACTS' => 'Sopimukset',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Sopimukset',
  'LBL_CONVERT_TO_QUOTE_ERROR' => 'Virhe:',
  'LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE' => 'Tapahtui virhe muunnettaessa tätä tarjottua tuoteriviä tarjoukseksi',
  'LBL_COST_PRICE' => 'Kustannus:',
  'LBL_COST_USDOLLAR' => 'Hinta (Yhdysvaltain dollari)',
  'LBL_CREATED_USER' => 'Luonut käyttäjä',
  'LBL_CURRENCY' => 'Valuutta:',
  'LBL_CURRENCY_ID' => 'Valuutta-ID:',
  'LBL_CURRENCY_RATE' => 'Valuuttakurssi',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Valuuttasymbolin nimi',
  'LBL_DATE_CLOSED' => 'Odotettu sulkupäivämäärä',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Odotettu sulkeutumispäivämäärän timestamp',
  'LBL_DATE_PURCHASED' => 'Ostettu:',
  'LBL_DATE_SUPPORT_EXPIRES' => 'Tuki päättyy:',
  'LBL_DATE_SUPPORT_STARTS' => 'Tuki alkaa:',
  'LBL_DEAL_TOT' => 'Diskontto:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Tarjotut tuoterivit',
  'LBL_DESCRIPTION' => 'Kuvaus:',
  'LBL_DISCOUNT_AMOUNT' => 'Diskonttomäärä',
  'LBL_DISCOUNT_AS_PERCENT' => 'Diskontto prosentteina',
  'LBL_DISCOUNT_PRICE' => 'Yksikköhinta:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Diskonttohinnan päivämäärä:',
  'LBL_DISCOUNT_RATE' => 'Diskonttokorko',
  'LBL_DISCOUNT_RATE_USDOLLAR' => 'Diskonttokorko (USD)',
  'LBL_DISCOUNT_TOTAL' => 'Diskontto yhteensä',
  'LBL_DISCOUNT_TOTAL_USDOLLAR' => 'Diskontto (USD)',
  'LBL_DISCOUNT_USDOLLAR' => 'Yksikköhinta (Yhdysvaltain dollari)',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumentit',
  'LBL_EDITLAYOUT' => 'Muokkaa asettelua',
  'LBL_EXPERT_ID' => 'Tuote-ekspertti',
  'LBL_EXPORT_CURRENCY_ID' => 'Valuutta-ID',
  'LBL_EXT_PRICE' => 'Ext. Price',
  'LBL_FORECAST' => 'Sisällytä ennusteeseen',
  'LBL_HELP_CREATE' => 'Tuotteet-moduuli tallentaa tietoja asiakkaille myydyistä tuotteista, tai tuotteista joita ollaan myymässä asiakkaille.

1. Syötä kentille arvoja.

  Pakollisiksi merkityt kentät pitää täyttää ennen kuin tietue voidaan luoda. Muut kentät ovat valinnaisia.

2. Paina ‘Tallenna’ luodaksesi tietueen. Tämän jälkeen palaat edelliselle sivulle.

  Painamalla ‘Tallenna ja näytä’, tietue luodaan, jonka jälkeen näytetään tietueen tietuenäkymä.

  Paina ‘Tallenna ja luo uusi’, jos haluat heti luoda toisen tietueen.',
  'LBL_HELP_RECORD' => 'Tuotteet-moduuli tallentaa tietoja asiakkaille myydyistä tuotteista, tai tuotteista joita ollaan myymässä asiakkaille.

- Muokkaa tietueen kenttiä klikkaamalla itse kenttää, tai vaihtoehtoisesti ‘Muokkaa’-painiketta.

- Muokkaa linkkejä muihin teitueisiin valitsemalla alavasemmalla oleva paneeli ‘tietonäkymään’.

- Luo ja lue käyttäjäkommentteja ja tietueen historiaa aktiviteettivirrassa. Aktiviteettivirran saat valitsemalla alavasemmalla oleva paneeli ‘aktiviteettivirta’-näkymään.

- Seuraa tai merkkaa tämä tietue suosikiksi käyttämällä tietueen nimen oikealta puolelta löytyviä kuvakkeita.

- Muut toiminnot löytyvät ‘Muokkaa’-painikkeen oikealla puolella olevasta ‘Toiminnot’-valikosta.',
  'LBL_HELP_RECORDS' => 'Tuotteet-moduuli tallentaa tietoja asiakkaille myydyistä tuotteista, tai tuotteista joita ollaan myymässä asiakkaille. Organisaatiosi tuotelista löytyy sijainnista Hallinto > Tuotekatalogi, ja järjestelmänvalvojat voivat lisätä tuotteita milloin vain. Kun luodaan tuotetietuetta, voit valita tuotteen tuotekatalogista tai luoda uuden tuotteen. Tuotetietueen voi luoda Sugarissa monella tapaa: Tuotteet-moduulista, Tarjoukset-moduulista, tuomalla tietueita ulkoisesta lähteestä, ym. Kun tuotetietue on luotu, sen tietoja voi katsella ja muokata sen tietuenäkymästä.',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Liidit',
  'LBL_LEAD_SOURCE' => 'Liidin lähde',
  'LBL_LIST_ACCOUNT_NAME' => 'Asiakkaan nimi',
  'LBL_LIST_CONTACT_NAME' => 'Kontaktin nimi',
  'LBL_LIST_COST_PRICE' => 'Kustannus',
  'LBL_LIST_DATE_PURCHASED' => 'Ostettu',
  'LBL_LIST_DISCOUNT_PRICE' => 'Hinta',
  'LBL_LIST_FORM_TITLE' => 'Tarjottujen tuoterivien lista',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Valmistusnumero',
  'LBL_LIST_LIST_PRICE' => 'Lista',
  'LBL_LIST_MANUFACTURER' => 'Valmistaja',
  'LBL_LIST_NAME' => 'Tarjottu tuoterivi',
  'LBL_LIST_PRICE' => 'Ohjehinta:',
  'LBL_LIST_QUANTITY' => 'Määrä',
  'LBL_LIST_QUOTE_NAME' => 'Tarjouksen nimi',
  'LBL_LIST_STATUS' => 'Tilanne',
  'LBL_LIST_SUPPORT_EXPIRES' => 'Umpeutuu',
  'LBL_LIST_USDOLLAR' => 'Ohjehinta (Yhdysvaltain dollari)',
  'LBL_MANUFACTURER' => 'Valmistaja:',
  'LBL_MANUFACTURERS' => 'Valmistajat',
  'LBL_MANUFACTURER_NAME' => 'Valmistajan nimi:',
  'LBL_MEMBER_OF' => 'Jäsen:',
  'LBL_MFT_PART_NUM' => 'Valmistajan osanumero:',
  'LBL_MODIFIED_USER' => 'Muokannut käyttäjä',
  'LBL_MODULE_NAME' => 'Tarjotut tuoterivit',
  'LBL_MODULE_NAME_SINGULAR' => 'Tarjottu tuoterivi',
  'LBL_MODULE_TITLE' => 'Tarjotut tuoterivit: Etusivu',
  'LBL_NAME' => 'Nimi',
  'LBL_NEW_FORM_TITLE' => 'Luo tarjottu tuoterivi',
  'LBL_NEXT_STEP' => 'Seuraava vaihe:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Muistiinpanot',
  'LBL_OPPORTUNITY' => 'Myyntimahdollisuus',
  'LBL_OPPORTUNITY_ID' => 'Myyntimahdollisuuden ID',
  'LBL_PRICING_FACTOR' => 'Hinnoittelutekijä',
  'LBL_PRICING_FORMULA' => 'Hintakaava:',
  'LBL_PROBABILITY' => 'Todennäköisyys (%):',
  'LBL_PRODUCT' => 'Tarjottu tuoterivi:',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Tarjotut tuoterivit',
  'LBL_PRODUCT_CATEGORIES' => 'Tuotekategoriat',
  'LBL_PRODUCT_TEMPLATE' => 'Tuotemalli:',
  'LBL_PRODUCT_TEMPLATE_ID' => 'Tuotemallin ID:',
  'LBL_PRODUCT_TYPES' => 'Tuotetyypit',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projektit',
  'LBL_QUANTITY' => 'Määrä:',
  'LBL_QUOTE' => 'Tarjous',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Tarjoukset',
  'LBL_QUOTE_ID' => 'Tarjouksen ID',
  'LBL_QUOTE_NAME' => 'Tarjouksen nimi:',
  'LBL_RELATED_PRODUCTS' => 'Liittyvät tarjotut tuoterivit:',
  'LBL_RELATED_PRODUCTS_TITLE' => 'Tarjotut tuoterivit',
  'LBL_REVENUELINEITEM' => 'Tuoterivi',
  'LBL_REVENUELINEITEMS' => 'Tuoterivit',
  'LBL_REVENUELINEITEM_ID' => 'Tuoterivin ID:',
  'LBL_REVENUELINEITEM_NAME' => 'Tuoterivin nimi:',
  'LBL_SALES_STAGE' => 'Myyntivaihe',
  'LBL_SALES_STATUS' => 'Status',
  'LBL_SEARCH_FORM_TITLE' => 'Tarjottujen tuoterivien haku',
  'LBL_SELECT_DISCOUNT' => 'Valitse diskontto',
  'LBL_SERIAL_NUMBER' => 'Sarjanumero:',
  'LBL_STATUS' => 'Tilanne:',
  'LBL_SUPPORT_CONTACT' => 'Tuen kontakti:',
  'LBL_SUPPORT_DESCRIPTION' => 'Tuen kuvaus:',
  'LBL_SUPPORT_NAME' => 'Tuen otsikko:',
  'LBL_SUPPORT_TERM' => 'Tuen pituus:',
  'LBL_TAX_CLASS' => 'Veroluokka:',
  'LBL_TYPE' => 'Tyyppi:',
  'LBL_URL' => 'Tuotteen URL:',
  'LBL_VENDOR_PART_NUM' => 'Myyjän osanumero:',
  'LBL_WEBSITE' => 'Web-sivu',
  'LBL_WEIGHT' => 'Paino:',
  'LNK_IMPORT_PRODUCTS' => 'Tuo tarjottuja tuoterivejä',
  'LNK_NEW_PRODUCT' => 'Luo tarjottu tuoterivi',
  'LNK_PRODUCT_LIST' => 'Näytä tarjotut tuoterivit',
  'NTC_DELETE_CONFIRMATION' => 'Haluatko varmasti poistaa tämän tietueen?',
  'NTC_REMOVE_CONFIRMATION' => 'Haluatko varmasti poistaa tämän tuotesuhteen?',
);

