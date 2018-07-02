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
  'ERR_DELETE_RECORD' => 'Tietuenumero tulee määritellä jotta voit poistaa asiakkaan.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Asiakkaat',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktiviteetit',
  'LBL_ASSIGNED_TO_NAME' => 'Vastuuhenkilö',
  'LBL_BUG' => 'Bugi:',
  'LBL_BUG_INFORMATION' => 'Yleiskatsaus',
  'LBL_BUG_NUMBER' => 'Bugin numero:',
  'LBL_BUG_SUBJECT' => 'Bugin aihe:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Palvelupyynnöt',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Yhteystiedot',
  'LBL_CONTACT_BUG_TITLE' => 'Contact-Bug:',
  'LBL_CONTACT_NAME' => 'Yhteystiedot nimi:',
  'LBL_CONTACT_ROLE' => 'Rooli:',
  'LBL_CREATED_BY' => 'Luonut:',
  'LBL_DATE_CREATED' => 'Luotu:',
  'LBL_DATE_LAST_MODIFIED' => 'Muokattu:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Bug Tracker',
  'LBL_DESCRIPTION' => 'Kuvaus',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumentit',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Vastuuhenkilö',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Vastuuhenkilö',
  'LBL_EXPORT_CREATED_BY' => 'Tekijän ID',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Korjattu versiossa nimeltä',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Muokkaajan ID',
  'LBL_FIXED_IN_RELEASE' => 'Korjattu versiossa',
  'LBL_FOUND_IN_RELEASE' => 'Löydetty versiosta',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Löytyy versiosta nimeltä',
  'LBL_HELP_CREATE' => 'Bugitietueen luonnin vaiheet:

1. Syötä kentille arvoja. Pakollisiksi merkityt kentät pitää täyttää ennen kuin tietue voidaan luoda. Muut kentät ovat valinnaisia.

2. Paina ‘Tallenna’ luodaksesi tietueen. Tämän jälkeen palaat edelliselle sivulle.

  Painamalla ‘Tallenna ja näytä’, tietue luodaan, jonka jälkeen näytetään bugin tietuenäkymä.

  Paina ‘Tallenna ja luo uusi’, jos haluat heti luoda toisen bugin.',
  'LBL_HELP_RECORD' => 'Bugit-moduulilla voidaan seurata tuotteissa oloevia ongelmia.

- Muokkaa tietueen kenttiä klikkaamalla itse kenttää, tai vaihtoehtoisesti ‘Muokkaa’-painiketta.

- Muokkaa linkkejä muihin teitueisiin valitsemalla alavasemmalla oleva paneeli ‘tietonäkymään’.

- Luo ja lue käyttäjäkommentteja ja tietueen historiaa aktiviteettivirrassa. Aktiviteettivirran saat valitsemalla alavasemmalla oleva paneeli ‘aktiviteettivirta’-näkymään.

- Seuraa tai merkkaa tämä tietue suosikiksi käyttämällä tietueen nimen oikealta puolelta löytyviä kuvakkeita.

- Muut toiminnot löytyvät ‘Muokkaa’-painikkeen oikealla puolella olevasta ‘Toiminnot’-valikosta.',
  'LBL_HELP_RECORDS' => 'Bugit-moduulilla seurataan tuotteissa olevia ongelmia (joita kutsutaan bugeiksi). Bugeja voi löytää sisäisesti, tai ne voivat olla asiakkaiden raportoimia. Moduulilla voidaan myös seurata bugin korjauksen edistymistä. Kun bugitietue luodaan, sen tietoja voidaan lukea moduulin tietuenäkymästä. Jokainen bugitietue voidaan linkittää muihin Sugar-tietueisiin, kuten soittoihin, kontakteihin, tai palvelupyyntöihin.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historia',
  'LBL_INVITEE' => 'Yhteystiedot',
  'LBL_LIST_ACCOUNT_NAME' => 'Asiakkaan nimi',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Vastuukäyttäjä',
  'LBL_LIST_CONTACT_NAME' => 'Kontaktit',
  'LBL_LIST_EMAIL_ADDRESS' => 'Sähköpostiosoite',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Korjattu versiossa',
  'LBL_LIST_FORM_TITLE' => 'Bugilista',
  'LBL_LIST_LAST_MODIFIED' => 'Päivitetty',
  'LBL_LIST_MY_BUGS' => 'Minun osoitetut bugit',
  'LBL_LIST_NUMBER' => 'Num.',
  'LBL_LIST_PHONE' => 'Puhelin',
  'LBL_LIST_PRIORITY' => 'Prioriteetti',
  'LBL_LIST_RELEASE' => 'Versio',
  'LBL_LIST_RESOLUTION' => 'Ratkaisu',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Aihe',
  'LBL_LIST_TYPE' => 'Tyyppi',
  'LBL_MODIFIED_BY' => 'Viimeksi muokannut:',
  'LBL_MODULE_ID' => 'Bugit',
  'LBL_MODULE_NAME' => 'Bug Tracker',
  'LBL_MODULE_NAME_SINGULAR' => 'Bugi',
  'LBL_MODULE_TITLE' => 'Bug Tracker: Etusivu',
  'LBL_NEW_FORM_TITLE' => 'Uusi bugi',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Muistiot',
  'LBL_NUMBER' => 'Numero:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Jos olet löytänyt bugin jonka haluat raportoida, klikkaa tästä raportoidaksesi sen.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Voit suodattaa bugien listaa syöttämällä hakusanan.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Esimerkiksi voisit käyttää tätä löytääksesi bugin joka on jo raportoitu.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'Bugit-moduuli on tarkoitettu bugien näyttämiseen ja raportoimiseen.. Navigoi opastetun kierroksen läpi alla olevilla nuolilla.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Tämä sivu näyttää listan jo julkaistuista bugeista.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Klikkaamalla tästä palauttaa sinut tähän näkymään milloin vain.',
  'LBL_PORTAL_VIEWABLE' => 'Nähtävissä Portaalista',
  'LBL_PRIORITY' => 'Prioriteetti:',
  'LBL_PRODUCT_CATEGORY' => 'Kategoria:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projektit',
  'LBL_RELEASE' => 'Versio:',
  'LBL_RESOLUTION' => 'Ratkaisu:',
  'LBL_SEARCH_FORM_TITLE' => 'Bugihaku',
  'LBL_SHOW_IN_PORTAL' => 'Näytä Portalissa',
  'LBL_SHOW_MORE' => 'Näytä lisää bugeja',
  'LBL_SOURCE' => 'Lähde:',
  'LBL_STATUS' => 'Tila:',
  'LBL_SUBJECT' => 'Aihe',
  'LBL_SYSTEM_ID' => 'System ID',
  'LBL_TYPE' => 'Tyyppi:',
  'LBL_WORK_LOG' => 'Työloki:',
  'LNK_BUG_LIST' => 'Näytä bugit',
  'LNK_BUG_REPORTS' => 'Näytä bugiraportit',
  'LNK_CREATE' => 'Raportoi bugi',
  'LNK_CREATE_WHEN_EMPTY' => 'Raportoi bugi nyt.',
  'LNK_IMPORT_BUGS' => 'Tuo bugeja',
  'LNK_NEW_BUG' => 'Ilmoita virheestä',
  'NTC_DELETE_CONFIRMATION' => 'Haluatko poistaa tämän tietueen?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Oletko varma, että haluat poistaa tämän bugin tältä asiakkaalta?',
  'NTC_REMOVE_INVITEE' => 'Oletko varma, että haluat poistaa tämän yhteystiedon bugista?',
);

