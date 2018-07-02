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
  'LBL_ASSIGNED_TO' => 'Vastuuhenkilö',
  'LBL_ASSIGNED_TO_ID' => 'Vastuuhenkilön ID',
  'LBL_ASSIGNED_TO_NAME' => 'Vastuuhenkilö:',
  'LBL_ASSIGNED_USER_ID' => 'Vastuukäyttäjän ID',
  'LBL_ASSOCIATED_QUOTE' => 'Tarjouksen aihe:',
  'LBL_BOOK_VALUE' => 'Kirjanpitoarvo:',
  'LBL_BOOK_VALUE_DATE' => 'Kirjanpitoarvon päiväys:',
  'LBL_BOOK_VALUE_USDOLLAR' => 'Kirjanpitoarvo (Yhdysvaltain dollari):',
  'LBL_CALCULATED_LINE_ITEM_AMOUNT' => 'Laskettu tarjotun tuoterivin määrä',
  'LBL_CAMPAIGN_ID' => 'Kampanjan ID',
  'LBL_CAMPAIGN_PRODUCT' => 'Kampanjan tuote',
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
  'LBL_CONVERT_INVALID_RLI' => 'Yhtä tai useampaa valitsemaasi tuoteriviä ei voida muuttaa tarjoukseksi:',
  'LBL_CONVERT_INVALID_RLI_ALREADYQUOTED_PLURAL' => 'Yksi tai useampi valittu tuoterivi on jo tarjottu.',
  'LBL_CONVERT_INVALID_RLI_PRODUCT' => 'Tuoterivi tarvitsee tuotteen tuotekatalogista, jotta tarjous voidaan generoida.',
  'LBL_CONVERT_INVALID_RLI_PRODUCT_PLURAL' => 'Yhdellä tai useammalla tuoterivillä pitää olla tuotekatalogista valittu tuote ennen kuin tarjousta voidaan generoida.',
  'LBL_CONVERT_TO_QUOTE' => 'Generoi tarjous',
  'LBL_CONVERT_TO_QUOTE_ERROR' => 'Virhe:',
  'LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE' => 'Tapahtui virhe muunnettaessa tätä tuoteriviä tarjoukseksi',
  'LBL_CONVERT_TO_QUOTE_INFO' => 'Odota',
  'LBL_CONVERT_TO_QUOTE_INFO_MESSAGE' => 'Generoidaan tarjousta tuoterivistä',
  'LBL_COST_PRICE' => 'Kustannus:',
  'LBL_COST_USDOLLAR' => 'Hinta (Yhdysvaltain dollari)',
  'LBL_CREATED_USER' => 'Luonut käyttäjä',
  'LBL_CURRENCY' => 'Valuutta:',
  'LBL_CURRENCY_ID' => 'Valuutta-ID:',
  'LBL_CURRENCY_NAME' => 'Valuutan nimi',
  'LBL_CURRENCY_RATE' => 'Valuuttakurssi',
  'LBL_CURRENCY_SYMBOL' => 'Valuuttasymboli',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Valuuttasymbolin nimi',
  'LBL_DATE_CLOSED' => 'Odotettu sulkupäivämäärä',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Odotetun sulkeutumispäivämäärän timestamp',
  'LBL_DATE_PURCHASED' => 'Ostettu:',
  'LBL_DATE_SUPPORT_EXPIRES' => 'Tuki päättyy:',
  'LBL_DATE_SUPPORT_STARTS' => 'Tuki alkaa:',
  'LBL_DEAL_TOT' => 'Diskontto:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Tuoterivit',
  'LBL_DESCRIPTION' => 'Kuvaus:',
  'LBL_DISCOUNT_AMOUNT' => 'Diskonttomäärä',
  'LBL_DISCOUNT_AS_PERCENT' => 'Diskontto prosentteina',
  'LBL_DISCOUNT_PRICE' => 'Yksikköhinta:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Diskonttohinnan päivämäärä:',
  'LBL_DISCOUNT_RATE' => 'Diskonttokorko',
  'LBL_DISCOUNT_RATE_USDOLLAR' => 'Diskonttokorko (Yhdysvaltain dollari)',
  'LBL_DISCOUNT_TOTAL' => 'Diskontto yhteensä',
  'LBL_DISCOUNT_TOTAL_USDOLLAR' => 'Diskontto (Yhdysvaltojen dollari)',
  'LBL_DISCOUNT_USDOLLAR' => 'Yksikköhinta (Yhdysvaltain dollari)',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumentit',
  'LBL_EDITLAYOUT' => 'Muokkaa asettelua',
  'LBL_EXPERT_ID' => 'Tuote-ekspertti',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Vastuuhenkilö',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Vastuuhenkilö',
  'LBL_EXPORT_CURRENCY_ID' => 'Valuutta ID',
  'LBL_EXT_PRICE' => 'Ext. Price',
  'LBL_FORECAST' => 'Sisällytä ennusteeseen',
  'LBL_HELP_CREATE' => 'Tuoterivit-moduuli tallentaa yksittäisiä liiketoiminnan tuoterivejä, jotka sisällytetään myyntimahdollisuustietueeseen ja seurataan koko myyntiprosessin ajan. Myyntimahdollisuus toimii ikään kuin otsikkona tuoteriveille.
Tuoterivin luonnin vaiheet:

1. Syötä kentille arvoja.

  Pakollisiksi merkityt kentät pitää täyttää ennen kuin tietue voidaan luoda. Muut kentät ovat valinnaisia.

2. Paina ‘Tallenna’ luodaksesi tietueen. Tämän jälkeen palaat edelliselle sivulle.

  Painamalla ‘Tallenna ja näytä’, tietue luodaan, jonka jälkeen näytetään tietueen tietuenäkymä.

  Paina ‘Tallenna ja luo uusi’, jos haluat heti luoda toisen tietueen.',
  'LBL_HELP_RECORD' => 'Tuoterivit-moduuli tallentaa yksittäisiä liiketoiminnan tuoterivejä, jotka sisällytetään myyntimahdollisuustietueeseen ja seurataan koko myyntiprosessin ajan. Myyntimahdollisuus toimii ikään kuin otsikkona tuoteriveille.

- Muokkaa tietueen kenttiä klikkaamalla itse kenttää, tai vaihtoehtoisesti ‘Muokkaa’-painiketta.

- Muokkaa linkkejä muihin teitueisiin valitsemalla alavasemmalla oleva paneeli ‘tietonäkymään’.

- Luo ja lue käyttäjäkommentteja ja tietueen historiaa aktiviteettivirrassa. Aktiviteettivirran saat valitsemalla alavasemmalla oleva paneeli ‘aktiviteettivirta’-näkymään.

- Seuraa tai merkkaa tämä tietue suosikiksi käyttämällä tietueen nimen oikealta puolelta löytyviä kuvakkeita.

- Muut toiminnot löytyvät ‘Muokkaa’-painikkeen oikealla puolella olevasta ‘Toiminnot’-valikosta.',
  'LBL_HELP_RECORDS' => 'Tuoterivit-moduuli tallentaa yksittäisiä liiketoiminnan tuoterivejä, jotka sisällytetään myyntimahdollisuustietueeseen ja seurataan koko myyntiprosessin ajan. Tämä sallii tarkempaa tietojenkäsittelyä kun toimitaan myyntimahdollisuuksien ja ennusteiden kanssa, sillä jokaisella myyntimahdollisuuden tuoterivillä voi olla oma myyntitilanne ja todennäköisyys, sekä yksittäisiä tuoterivejä voidaan sisällyttää ennustetyökirjoihin. Tuoterivi voi liittyä organisaatiosi tuotekatalogissa olevaan tuotteeseen. Näin tekemällä täytetään tuoteriviin automaattisesti tuotteen tiedot.',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Liidit',
  'LBL_LEAD_SOURCE' => 'Liidin lähde',
  'LBL_LIST_ACCOUNT_NAME' => 'Asiakkaan nimi',
  'LBL_LIST_COMMIT_STAGE' => 'Commitin vaihe',
  'LBL_LIST_CONTACT_NAME' => 'Kontaktin nimi',
  'LBL_LIST_COST_PRICE' => 'Kustannus',
  'LBL_LIST_DATE_CLOSED' => 'Odotettu sulkupäivämäärä',
  'LBL_LIST_DATE_PURCHASED' => 'Ostettu',
  'LBL_LIST_DISCOUNT_PRICE' => 'Hinta',
  'LBL_LIST_FORM_TITLE' => 'Tuoterivien lista',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Valmistusnumero',
  'LBL_LIST_LIST_PRICE' => 'Lista',
  'LBL_LIST_MANUFACTURER' => 'Valmistaja',
  'LBL_LIST_NAME' => 'Tuoterivi',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Myyntimahdollisuuden nimi',
  'LBL_LIST_PRICE' => 'Ohjehinta:',
  'LBL_LIST_PROBABILITY' => 'Todennäköisyys',
  'LBL_LIST_PRODUCT_TEMPLATE' => 'Tuotemalli:',
  'LBL_LIST_QUANTITY' => 'Määrä',
  'LBL_LIST_QUOTE_NAME' => 'Tarjouksen nimi',
  'LBL_LIST_SALES_STAGE' => 'Myyntivaihe',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUPPORT_EXPIRES' => 'Umpeutuu',
  'LBL_LIST_USDOLLAR' => 'Ohjehinta (Yhdysvaltain dollari)',
  'LBL_MANUFACTURER' => 'Valmistaja:',
  'LBL_MANUFACTURERS' => 'Valmistajat',
  'LBL_MANUFACTURER_NAME' => 'Valmistajan nimi:',
  'LBL_MEMBER_OF' => 'Jäsen:',
  'LBL_MFT_PART_NUM' => 'Valmistajan osanumero:',
  'LBL_MODIFIED_USER' => 'Muokannut käyttäjä',
  'LBL_MODULE_NAME' => 'Tuoterivit',
  'LBL_MODULE_NAME_SINGULAR' => 'Tuoterivi',
  'LBL_MODULE_TITLE' => 'Tuoterivit: Etusivu',
  'LBL_NAME' => 'Tuoterivi:',
  'LBL_NEW_FORM_TITLE' => 'Luo tuoterivi',
  'LBL_NEXT_STEP' => 'Seuraava vaihe:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Muistiinpanot',
  'LBL_NOT_QUOTED' => 'Ei tarjottu',
  'LBL_OPPORTUNITY' => 'Myyntimahdollisuus',
  'LBL_OPPORTUNITY_ID' => 'Myyntimahdollisuuden ID',
  'LBL_PRICING_FACTOR' => 'Hinnoittelutekijä',
  'LBL_PRICING_FORMULA' => 'Hintakaava:',
  'LBL_PROBABILITY' => 'Todennäköisyys (%):',
  'LBL_PRODUCT' => 'Tuote:',
  'LBL_PRODUCT_CATEGORIES' => 'Tuotekategoriat',
  'LBL_PRODUCT_TEMPLATE' => 'Tuotemalli:',
  'LBL_PRODUCT_TEMPLATES' => 'Tuotemallit',
  'LBL_PRODUCT_TEMPLATE_ID' => 'Tuotemallin ID:',
  'LBL_PRODUCT_TYPE' => 'Tuotetyyppi:',
  'LBL_PRODUCT_TYPES' => 'Tuotetyypit',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projektit',
  'LBL_QUANTITY' => 'Määrä:',
  'LBL_QUOTE' => 'Tarjous',
  'LBL_QUOTED' => 'Tarjottu',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Tarjoukset',
  'LBL_QUOTE_ID' => 'Tarjouksen ID',
  'LBL_QUOTE_NAME' => 'Tarjouksen nimi:',
  'LBL_RELATED_PRODUCTS' => 'Liittyvät tuoterivit:',
  'LBL_RELATED_PRODUCTS_TITLE' => 'Tuottotuotteet',
  'LBL_RLI_SUBPANEL_TITLE' => 'Tuoterivit',
  'LBL_SALES_STAGE' => 'Myyntivaihe',
  'LBL_SALES_STATUS' => 'Status',
  'LBL_SEARCH_FORM_TITLE' => 'Tuoterivien haku',
  'LBL_SELECT_DISCOUNT' => 'Diskontto prosentteina',
  'LBL_SERIAL_NUMBER' => 'Sarjanumero:',
  'LBL_STATUS' => 'Tila:',
  'LBL_SUPPORT_CONTACT' => 'Tuen kontakti:',
  'LBL_SUPPORT_DESCRIPTION' => 'Tuen kuvaus:',
  'LBL_SUPPORT_NAME' => 'Tuen otsikko:',
  'LBL_SUPPORT_TERM' => 'Tuen pituus:',
  'LBL_TAX_CLASS' => 'Veroluokka:',
  'LBL_TOTAL_DISCOUNT_AMOUNT' => 'Diskonttomäärän summa',
  'LBL_TYPE' => 'Tyyppi:',
  'LBL_URL' => 'Tuotteen URL:',
  'LBL_VENDOR_PART_NUM' => 'Myyjän osanumero:',
  'LBL_WEBSITE' => 'Web-sivu',
  'LBL_WEIGHT' => 'Paino:',
  'LNK_IMPORT_REVENUELINEITEMS' => 'Tuo tuoterivejä',
  'LNK_NEW_REVENUELINEITEM' => 'Luo tuoterivi',
  'LNK_REVENUELINEITEM_LIST' => 'Näytä tuoterivit',
  'NTC_DELETE_CONFIRMATION' => 'Haluatko varmasti poistaa tämän tietueen?',
  'NTC_REMOVE_CONFIRMATION' => 'Haluatko varmasti poistaa tämän tuotesuhteen?',
  'SAVE_RLI_QUOTE_NOTICE' => 'Tämä rivi on jo muutettu tarjoukseksi. Muutoksiasi ei päivitetä tarjoukseen.',
  'WARNING_DELETED_RECORD_LIST_RECOMMIT_1' => 'Yksi tai useampi tietue sisällytettiin',
  'WARNING_DELETED_RECORD_LIST_RECOMMIT_2' => 'Ne poistetaan ja sinun pitää commitoida uudelleen sinun',
  'WARNING_DELETED_RECORD_RECOMMIT_1' => 'Tämä tietue sisällytettiin',
  'WARNING_DELETED_RECORD_RECOMMIT_2' => 'Se poistetaan ja sinun pitää commitoida uudelleen sinun',
  'WARNING_MERGE_RLIS_WITH_DIFFERENT_OPPORTUNITIES' => 'Yhtä tai useampaa valitsemaasi tietuetta ei voida yhdistää, sillä ne kuuluvat eri myyntimahdollisuuksiin.',
);

