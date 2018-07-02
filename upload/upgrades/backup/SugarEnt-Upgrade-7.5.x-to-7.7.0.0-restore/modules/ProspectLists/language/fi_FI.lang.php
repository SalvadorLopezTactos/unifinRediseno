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
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Asiakkaat',
  'LBL_ASSIGNED_TO' => 'Vastuuhenkilö:',
  'LBL_CAMPAIGNS_SUBPANEL_TITLE' => 'Kampanjat',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Yhteystiedot',
  'LBL_COPY_PREFIX' => 'Kopio',
  'LBL_CREATED' => 'Luonut',
  'LBL_CREATED_BY' => 'Luonut',
  'LBL_DATE_CREATED' => 'Luotu',
  'LBL_DATE_ENTERED' => 'Luontipäivä',
  'LBL_DATE_LAST_MODIFIED' => 'Muutettu',
  'LBL_DATE_MODIFIED' => 'Muokattu viimeksi',
  'LBL_DESCRIPTION' => 'Kuvaus',
  'LBL_DOMAIN' => 'Ei sähköposteja verkkotunnukseen',
  'LBL_DOMAIN_NAME' => 'Verkkotunnus',
  'LBL_ENTRIES' => 'Merkintöjä yhteensä',
  'LBL_HELP_CREATE' => 'Tavoitelista on kokoelma henkilöitä tai organisaatioita, jotka haluat sisällyttää tai olla sisällyttämättä massamarkkinointikampanjoihin. Tavoitelistan luonnin vaiheet:

1. Syötä kentille arvoja.

 &nbsp;Pakollisiksi merkityt kentät pitää täyttää ennen kuin tietue voidaan luoda. Muut kentät ovat valinnaisia.

2. Paina ‘Tallenna’ luodaksesi tietueen. Tämän jälkeen palaat edelliselle sivulle.

 &nbsp;Painamalla ‘Tallenna ja näytä’, tietue luodaan, jonka jälkeen näytetään tavoitelistan tietuenäkymä.

 &nbsp;Paina ‘Tallenna ja luo uusi’, jos haluat heti luoda toisen tietueen.

3. Tallennuksen jälkeen, käytä tavoitteen tietuenäkymässä olevia alipaneeleita lisätäksesi kampanjalle vastaanottajia.',
  'LBL_HELP_RECORD' => 'Tavoitelista on kokoelma henkilöitä tai organisaatioita, jotka haluat sisällyttää tai olla sisällyttämättä massamarkkinointi&shy;kampanjoihin.

- Muokkaa tämän tietueen kenttiä painamalla itse kenttää, tai ‘Muokkaa’-painiketta.

- Muokkaa linkityksiä muihin moduuleihin, kuten kampanjan vastaanottajiin, valitsemalla alavasemmalla oleva paneeli ‘tietonäkymään’.

- Luo ja lue käyttäjäkommentteja ja tietueen historiaa aktiviteettivirrassa. Aktiviteettivirran saat valitsemalla alavasemmalla oleva paneeli ‘Aktiviteettivirta’-näkymään.

- Seuraa tai merkkaa tämä tietue suosikiksi käyttämällä tietueen nimen oikealta puolelta löytyviä kuvakkeita.

- Muut toiminnot löytyvät ‘Muokkaa’-painikkeen oikealla puolella olevasta ‘Toiminnot’-valikosta.',
  'LBL_HELP_RECORDS' => 'Tavoitelista on kokoelma henkilöitä tai organisaatioita, jotka haluat sisällyttää tai olla sisällyttämättä massamarkkinointikampanjoihin. Tavoitelistoissa voi olla monia tavoitteita, kontakteja, liidejä, käyttäjiä, ja asiakkaita. Tavoitteita voi ryhmittää tavoitelistaan tavoitteiden kriteerien, kuten ikäryhmän, sijainnin, tai kulutuskäytäntöjen mukaan. Tavoitelistoja käytetään massa&shy;sähköposti&shy;markkinointi&shy;kampanjoissa, joita voi hallita Kampanjat-moduulissa.',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Liidit',
  'LBL_LIST_DESCRIPTION' => 'Kuvaus',
  'LBL_LIST_END_DATE' => 'Päättymispäivä',
  'LBL_LIST_ENTRIES' => 'Prospekteja listassa',
  'LBL_LIST_FORM_TITLE' => 'Tavoitelistat',
  'LBL_LIST_PROSPECTLIST_NAME' => 'Nimi',
  'LBL_LIST_PROSPECT_LIST_NAME' => 'Tavoitelista',
  'LBL_LIST_TYPE' => 'Tyyppi',
  'LBL_LIST_TYPE_LIST_NAME' => 'Tyyppi',
  'LBL_LIST_TYPE_NO' => 'Tyyppi',
  'LBL_MARKETING_ID' => 'Markkinointitunnus',
  'LBL_MARKETING_MESSAGE' => 'Sähköpostimarkkinointiviesti',
  'LBL_MARKETING_NAME' => 'Markkinointinimi',
  'LBL_MODIFIED' => 'Muokannut',
  'LBL_MODIFIED_BY' => 'Muuttanut',
  'LBL_MODULE_ID' => 'Tavoitelistat',
  'LBL_MODULE_NAME' => 'Tavoitelistat',
  'LBL_MODULE_NAME_SINGULAR' => 'Tavoitelista',
  'LBL_MODULE_TITLE' => 'Tavoitelistat: Etusivu',
  'LBL_MORE_DETAIL' => 'Tarkemmin',
  'LBL_NAME' => 'Nimi',
  'LBL_NEW_FORM_TITLE' => 'Uusi tavoitelista',
  'LBL_PROSPECTS_SUBPANEL_TITLE' => 'Tavoitteet',
  'LBL_PROSPECT_LISTS_SUBPANEL_TITLE' => 'Tavoitelistat',
  'LBL_PROSPECT_LIST_NAME' => 'Tavoitelista:',
  'LBL_SEARCH_FORM_TITLE' => 'Tavoitelistojen Haku',
  'LBL_TEAM' => 'Tiimi',
  'LBL_TYPE' => 'Tyyppi',
  'LBL_USERS_SUBPANEL_TITLE' => 'Käyttäjät',
  'LNK_CAMPAIGN_LIST' => 'Kampanjat',
  'LNK_NEW_CAMPAIGN' => 'Luo kampanja',
  'LNK_NEW_PROSPECT' => 'Luo tavoite',
  'LNK_NEW_PROSPECT_LIST' => 'Luo tavoitelista',
  'LNK_PROSPECT_LIST' => 'Tavoitteet',
  'LNK_PROSPECT_LIST_LIST' => 'Näytä tavoitelistat',
);

