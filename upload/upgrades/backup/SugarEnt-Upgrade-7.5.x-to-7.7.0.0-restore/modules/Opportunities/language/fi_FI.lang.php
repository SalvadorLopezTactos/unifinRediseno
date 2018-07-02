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
  'ERR_DELETE_RECORD' => 'Tietuenumero tulee määritellä, jotta voit poistaa tilin.',
  'LABEL_PANEL_ASSIGNMENT' => 'Tehtävä',
  'LBL_ACCOUNT_ID' => 'Asiakkaan ID',
  'LBL_ACCOUNT_NAME' => 'Asiakkaan nimi:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktiviteetit',
  'LBL_ASSIGNED_TO_ID' => 'Vastuuhenkilö',
  'LBL_ASSIGNED_TO_NAME' => 'Vastuuhenkilö',
  'LBL_CAMPAIGN' => 'Kampanja:',
  'LBL_CAMPAIGN_LINK' => 'Kampanjalinkki',
  'LBL_CAMPAIGN_OPPORTUNITY' => 'Kampanjat',
  'LBL_CLOSED_RLIS' => 'Suljettujen tuoterivien määrä',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'Suljetut voitetut mahdollisuudet',
  'LBL_COMMITTED' => 'Commitoitu',
  'LBL_COMMIT_STAGE' => 'Commitin vaihe',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontaktit',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Liittyvien kontaktien sähköpostit',
  'LBL_CONTRACTS' => 'Sopimukset',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Sopimukset',
  'LBL_CREATED_ID' => 'Luoneen käyttäjän ID',
  'LBL_CREATED_USER' => 'Luonut',
  'LBL_CURRENCIES' => 'Valuutat',
  'LBL_CURRENCY' => 'Valuutta:',
  'LBL_CURRENCY_ID' => 'Valuutta ID',
  'LBL_CURRENCY_NAME' => 'Valuutan nimi',
  'LBL_CURRENCY_RATE' => 'Valuuttakurssi',
  'LBL_CURRENCY_SYMBOL' => 'Valuuttasymboli',
  'LBL_DATE_CLOSED' => 'Odotettu sulkupäivämäärä:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Odotettu sulkeutumispäivämäärän timestamp',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Myyntimahdollisuudet',
  'LBL_DESCRIPTION' => 'Kuvaus',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumentit',
  'LBL_DUPLICATE' => 'Myyntimahdollisuus on mahdollinen kaksoiskappale',
  'LBL_EDITLAYOUT' => 'Muokkaa asettelua',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Vastuuhenkilö',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Vastuuhenkilö',
  'LBL_EXPORT_CAMPAIGN_ID' => 'Kampanjan ID',
  'LBL_EXPORT_CREATED_BY' => 'Tekijän ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Muokkaajan ID',
  'LBL_EXPORT_NAME' => 'Nimi',
  'LBL_FILENAME' => 'Liitetiedosto',
  'LBL_FORECAST' => 'Sisällytä ennusteeseen',
  'LBL_HELP_CREATE' => 'Myyntimahdollisuudet-moduulilla voi seurata yksittäisiä myyntejä, ja myynneille kuuluvia tuoterivejä alusta loppuun. Jokainen myyntimahdollisuus on ‘otsikko’ ryhmälle tuoterivejä, sekä linkki muille tärkeille tietueille, kuten tarjouksille ja kontakteille.

Myyntimahdollisuus&shy;tietueen luonnin vaiheet:

1. Syötä kentille arvoja.

&nbsp; Pakollisiksi merkityt kentät pitää täyttää ennen kuin tietue voidaan luoda. Muut kentät ovat valinnaisia.

2. Paina ‘Tallenna’ luodaksesi tietueen. Tämän jälkeen palaat edelliselle sivulle.

&nbsp; Painamalla ‘Tallenna ja näytä’, tietue luodaan, jonka jälkeen näytetään myynti&shy;mahdollisuuden tietuenäkymä.

&nbsp; Paina ‘Tallenna ja luo uusi’, jos haluat heti luoda toisen tietueen.

3. Tallennuksen jälkeen, käytä ‘Tuoterivit’-alipaneeleita lisätäksesi myynti&shy;mahdollisuudelle tuoterivejä.',
  'LBL_HELP_RECORD' => 'Myyntimahdollisuudet-moduulilla voi seurata yksittäisiä myyntejä, ja myynneille kuuluvia tuoterivejä alusta loppuun. Jokainen myyntimahdollisuus on ‘otsikko’ ryhmälle tuoterivejä, sekä linkki muille tärkeille tietueille, kuten tarjouksille ja kontakteille.

- Muokkaa tietueen kenttiä napsauttamalla itse kenttää, tai ‘Muokkaa’-painiketta.

- Muokkaa linkityksiä muihin moduuleihin, kuten tuoteriveihin, valitsemalla alavasemmalla oleva paneeli ‘tietonäkymään’.

- Luo ja lue käyttäjäkommentteja ja tietueen historiaa aktiviteettivirrassa. Aktiviteettivirran saat valitsemalla alavasemmalla oleva paneeli ‘Aktiviteettivirta’-näkymään.

- Seuraa tai merkkaa tämä tietue suosikiksi käyttämällä tietueen nimen oikealta puolelta löytyviä kuvakkeita.

- Muut toiminnot löytyvät ‘Muokkaa’-painikkeen oikealla puolella olevasta ‘Toiminnot’-valikosta.',
  'LBL_HELP_RECORDS' => 'Myyntimahdollisuudet-moduulilla voi seurata yksittäisiä myyntejä, ja myynneille kuuluvia tuoterivejä alusta loppuun. Jokainen myyntimahdollisuus on ‘otsikko’ ryhmälle tuoterivejä, sekä linkki muille tärkeille tietueille, kuten tarjouksille ja kontakteille. Jokainen tuoterivi on jonkin tuotteen mahdollinen myynti, ja sisältää myyntiin liittyviä tietoja. Tyypillisesti tuoterivi menee monen myyntivaiheen läpi, kunnes se merkitään ‘suljetuksi ja voitetuksi’ tai ‘suljetuksi ja hävityksi’. Tietueena myynti&shy;mahdollisuus näyttää tuoterivien summan ja odotetun sulku&shy;päivämäärän. Myynti&shy;mahdollisuuksia ja tuoterivejä voidaan hyödyntää enemmän käyttäen Sugarin Ennusteet-moduulia, joilla voidaan tulkita ja ennustaa myyntitrendejä ja kehittää myyntityötä.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historia',
  'LBL_INVITEE' => 'Kontaktit',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Liidit',
  'LBL_LEAD_SOURCE' => 'Liidin lähde:',
  'LBL_LIST_ACCOUNT_NAME' => 'Asiakkaan nimi',
  'LBL_LIST_AMOUNT' => 'Todennäköinen',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'Määrä',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Vastuuhenkilö',
  'LBL_LIST_DATE_CLOSED' => 'Sulje',
  'LBL_LIST_FORM_TITLE' => 'Myyntimahdollisuuksien luettelo',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Nimi',
  'LBL_LIST_SALES_STAGE' => 'Myynnin vaihe',
  'LBL_MKTO_ID' => 'Marketo liidi-ID',
  'LBL_MKTO_SYNC' => 'Synkronoi Marketoon',
  'LBL_MODIFIED_ID' => 'Muokkaajan ID',
  'LBL_MODIFIED_NAME' => 'Muokkaajan nimi',
  'LBL_MODIFIED_USER' => 'Muokannut',
  'LBL_MODULE_NAME' => 'Myyntimahdollisuudet',
  'LBL_MODULE_NAME_SINGULAR' => 'Myyntimahdollisuus',
  'LBL_MODULE_TITLE' => 'Myyntimahdollisuudet: Etusivu',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'Suljetut myyntimahdollisuudet',
  'LBL_NAME' => 'Nimi',
  'LBL_NEW_FORM_TITLE' => 'Luo myyntimahdollisuus',
  'LBL_NEXT_STEP' => 'Seuraava vaihe:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Muistiot',
  'LBL_OPPORTUNITY' => 'Myyntimahdollisuus',
  'LBL_OPPORTUNITY_NAME' => 'Mahdollisuuden nimi:',
  'LBL_OPPORTUNITY_ROLE' => 'Myyntimahdollisuuden rooli',
  'LBL_OPPORTUNITY_TYPE' => 'Myyntimahdollisuuden tyyppi',
  'LBL_PIPELINE_TOTAL_IS' => 'Myyntiputken summa on',
  'LBL_PRIMARY_QUOTE_ID' => 'Ensisijainen tarjous',
  'LBL_PROBABILITY' => 'Todennäköisyys (%):',
  'LBL_PRODUCTS' => 'Tarjotut tuoterivit',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Tarjotut tuoterivit',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projektit',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projektit',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Tarjoukset',
  'LBL_QUOTE_SUBPANEL_TITLE' => 'Tarjoukset',
  'LBL_RAW_AMOUNT' => 'Raaka määrä',
  'LBL_RLI' => 'Tuoterivit',
  'LBL_RLI_SUBPANEL_TITLE' => 'Tuoterivit',
  'LBL_SALES_STAGE' => 'Myyntivaihe:',
  'LBL_SALES_STATUS' => 'Status',
  'LBL_SEARCH_FORM_TITLE' => 'Myyntimahdollisuuksien haku',
  'LBL_TEAM_ID' => 'Tiimin ID',
  'LBL_TIMEPERIODS' => 'Ajanjaksot',
  'LBL_TIMEPERIOD_ID' => 'Ajanjakson ID',
  'LBL_TOP_OPPORTUNITIES' => '10 parasta myyntimahdollisuutta',
  'LBL_TOTAL_OPPORTUNITIES' => 'Myyntimahdollisuuksia yhteensä',
  'LBL_TOTAL_RLIS' => 'Tuoterivien yhteismäärä',
  'LBL_TYPE' => 'Tyyppi:',
  'LBL_VIEW_FORM_TITLE' => 'Myyntimahdollisuuksien näkymä',
  'LBL_WORKSHEET' => 'Työkirja',
  'LNK_CREATE' => 'Luo diili',
  'LNK_IMPORT_OPPORTUNITIES' => 'Tuo myyntimahdollisuuksia',
  'LNK_NEW_OPPORTUNITY' => 'Luo myyntimahdollisuus',
  'LNK_OPPORTUNITY_LIST' => 'Näytä myyntimahdollisuudet',
  'LNK_OPPORTUNITY_REPORTS' => 'Näytä myyntimahdollisuusraportit',
  'MSG_DUPLICATE' => 'Myyntimahdollisuustietue jonka aiot luoda saattaa olla kopio jo olemassa olevasta myyntimahdollisuustietueesta. Myyntimahdollisuustietueet, joilla on samankaltainen nimi, on listattu alla.<br/>Klikkaa Tallenna jatkaaksesi tämän mahdollisuuden luomista, tai klikkaa Peruuta palataksesi moduuliin luomatta mahdollisuutta.',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => 'Et voi poistaa myyntimahdollisuuksia joissa on suljettuja tuoterivejä',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Oletko varma, että haluat poistaa tämän yhteystiedon myyntimahdollisuudesta?',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'Oletko varma, että haluat poistaa tämän myyntimahdollisuuden projektista?',
  'TPL_RLI_CREATE' => 'Myyntimahdollisuudella pitää olla liittyvä tuoterivi. <a href=&#39;javascript:void(0);&#39; id=&#39;createRLI&#39;>Luo tuoterivi</a>.',
  'TPL_RLI_CREATE_LINK_TEXT' => 'Luo tuoterivi',
  'UPDATE' => 'Myyntimahdollisuus - Valuuttapäivitys',
  'UPDATE_BUGFOUND_COUNT' => 'Vikoja todettu:',
  'UPDATE_BUG_COUNT' => 'Virheitä löydetty ja yritetty korjata:',
  'UPDATE_COUNT' => 'Tietueita päivitetty:',
  'UPDATE_CREATE_CURRENCY' => 'Luodaan uutta valuuttaa:',
  'UPDATE_DOLLARAMOUNTS' => 'Päivitä USD-määriä',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Päivitä mahdollisuuksien USD-määrät nykyisten valuuttakurssien perusteella. Tätä arvoa käytetään kaavojen ja listanäkymien valuuttamäärien laskemiseen.',
  'UPDATE_DONE' => 'Tehty',
  'UPDATE_FAIL' => 'Ei voitu päivittää -',
  'UPDATE_FIX' => 'Korjaa määrät',
  'UPDATE_FIX_TXT' => 'Yrittää korjata mahdolliset virheelliset määrät luomalla oikeamuotoisen desimaalin nykyisestä määrästä. Jokainen muunnettu määrä varmuuskopioidaan amount_backup tietokantakenttään. Jos suoritat tämän ja ilmenee vikoja, älä suorita sitä palauttamatta vanhoja arvoja varmuuskopiosta, sillä varmuuskopio saattaa joutua ylikirjoitetuksi virheellisillä arvoilla.',
  'UPDATE_INCLUDE_CLOSE' => 'Sisällytä suljetut tietueet',
  'UPDATE_MERGE' => 'Yhdistä valuutat',
  'UPDATE_MERGE_TXT' => 'Yhdistää useita valuuttoja yhteen. Jos löydetään useita saman valuutan valuuttatietuita, ne yhdistetään. Tämä yhdistää kyseisen valuutan myös kaikille muille moduuleille.',
  'UPDATE_NULL_VALUE' => 'Määrä on NULL, arvoksi asetetaan 0 -',
  'UPDATE_RESTORE' => 'Palauta määrät',
  'UPDATE_RESTORE_COUNT' => 'Tietueita palautettu:',
  'UPDATE_RESTORE_TXT' => 'Palauttaa määräarvot korjauksen aikana tehtyistä varmuuskopioista.',
  'UPDATE_VERIFY' => 'Varmista määrät',
  'UPDATE_VERIFY_CURAMOUNT' => 'Nykyinen määrä:',
  'UPDATE_VERIFY_FAIL' => 'Tietue ei läpäissyt vahvistusta:',
  'UPDATE_VERIFY_FIX' => 'Korjauksen suorittaminen antaisi',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Uusi määrä:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Uusi valuutta:',
  'UPDATE_VERIFY_TXT' => 'Varmistaa, että mahdollisuuksissa olevat määrät ovat sallittuja desimaalinumeroita, jotka sisältävät vain numeroita (0-9) ja desimaaleja (.)',
  'WARNING_NO_DELETE_CLOSED_SELECTED' => 'Valituista tietueista yhdessä tai useammassa on suljettuja tuoterivejä, eikä niitä voi poistaa.',
);

