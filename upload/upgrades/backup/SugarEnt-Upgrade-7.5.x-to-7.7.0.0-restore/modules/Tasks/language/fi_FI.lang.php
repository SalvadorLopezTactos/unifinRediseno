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
  'DATE_FORMAT' => '(vvvv-kk-pp)',
  'ERR_DELETE_RECORD' => 'Tietuenumero tulee määritellä, jotta voit poistaa kontaktin.',
  'ERR_INVALID_HOUR' => 'Anna tunti.',
  'LBL_ACTIVITIES_REPORTS' => 'Toimintakertomus',
  'LBL_ASSIGNED_TO_NAME' => 'Vastuuhenkilö',
  'LBL_ASSIGNED_USER' => 'Vastuuhenkilö',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Kontaktin nimi',
  'LBL_CONTACT_FIRST_NAME' => 'Kontaktin etunimi',
  'LBL_CONTACT_ID' => 'Kontaktin ID:',
  'LBL_CONTACT_LAST_NAME' => 'Kontaktin sukunimi',
  'LBL_CONTACT_NAME' => 'Yhteystiedon nimi',
  'LBL_CONTACT_PHONE' => 'Kontaktin puhelinnumero:',
  'LBL_DATE_DUE' => 'Eräpäivä',
  'LBL_DATE_DUE_FLAG' => 'Ei eräpäivää',
  'LBL_DATE_START_FLAG' => 'Ei aloituspäivää',
  'LBL_DEFAULT_PRIORITY' => 'Keskisuuri',
  'LBL_DESCRIPTION' => 'Kuvaus',
  'LBL_DESCRIPTION_INFORMATION' => 'Kuvauksen tiedot',
  'LBL_DUE_DATE' => 'Eräpäivä',
  'LBL_DUE_DATE_AND_TIME' => 'Eräpäivä ja -aika',
  'LBL_DUE_TIME' => 'Erääntymisen aika',
  'LBL_EDITLAYOUT' => 'Muokkaa asettelua',
  'LBL_EMAIL' => 'Sähköpostiosoite',
  'LBL_EMAIL_ADDRESS' => 'Sähköpostiosoite',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Vastuuhenkilö',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Vastuuhenkilö',
  'LBL_EXPORT_CREATED_BY' => 'Tekijän ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Muokkaajan ID',
  'LBL_EXPORT_PARENT_ID' => 'Liittyvät ID:hen',
  'LBL_EXPORT_PARENT_TYPE' => 'Liittyvät moduuliin',
  'LBL_HELP_CREATE' => 'Tehtävät-moduuli tallentaa tietoja vapaamuotoisista toiminnoista, "to do" -kohteista, ja muista tehtävistä mitkä vaativat suoritusta. Tehtävätietueen luonnin vaiheet:

1. Syötä kentille arvoja.

  Pakollisiksi merkityt kentät pitää täyttää ennen kuin tietue voidaan luoda. Muut kentät ovat valinnaisia.

2. Paina ‘Tallenna’ luodaksesi tietueen. Tämän jälkeen palaat edelliselle sivulle.

  Painamalla ‘Tallenna ja näytä’, tietue luodaan, jonka jälkeen näytetään tietueen tietuenäkymä.

  Paina ‘Tallenna ja luo uusi’, jos haluat heti luoda toisen tietueen.',
  'LBL_HELP_RECORD' => 'Tehtävät-moduuli tallentaa tietoja vapaamuotoisista toiminnoista, "to do" -kohteista, ja muista tehtävistä mitkä vaativat suoritusta.

- Muokkaa tietueen kenttiä klikkaamalla itse kenttää, tai vaihtoehtoisesti ‘Muokkaa’-painiketta.

- Muokkaa linkkejä muihin teitueisiin valitsemalla alavasemmalla oleva paneeli ‘tietonäkymään’.

- Luo ja lue käyttäjäkommentteja ja tietueen historiaa aktiviteettivirrassa. Aktiviteettivirran saat valitsemalla alavasemmalla oleva paneeli ‘aktiviteettivirta’-näkymään.

- Seuraa tai merkkaa tämä tietue suosikiksi käyttämällä tietueen nimen oikealta puolelta löytyviä kuvakkeita.

- Muut toiminnot löytyvät ‘Muokkaa’-painikkeen oikealla puolella olevasta ‘Toiminnot’-valikosta.',
  'LBL_HELP_RECORDS' => 'Tehtävät-moduuli tallentaa tietoja vapaamuotoisista toiminnoista, "to do" -kohteista, ja muista tehtävistä mitkä vaativat suoritusta. Tehtävätietueita voi liittää yhteen tietueeseen useimmissa moduuleissa "flex relate" -kentän kautta, sekä myös yhteen kontaktiin. Tehtäviä voi luoda Sugarissa Tehtävät-moduulissa, kopioinnilla, tuomalla tietueita ulkoisesta lähteestä, yms. Kun tehtävätietue on luotu, voit katsoa ja muokata tietueen tietoja tietuenäkymästä. Tehtävän tiedoista riippuen, saattaa olla mahdollista muokata tehtävää kalenterimoduulista. Jokainen tehtävämoduuli voidaan linkittää muihin Sugarin tietueisiin, kuten asiakkaisiin, kontakteihin, myyntimahdollisuuksiin, jne.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Muistiot',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Vastuuhenkilö',
  'LBL_LIST_CLOSE' => 'Sulje',
  'LBL_LIST_COMPLETE' => 'Valmis:',
  'LBL_LIST_CONTACT' => 'Yhteystiedot',
  'LBL_LIST_DATE_MODIFIED' => 'Muokattu viimeksi',
  'LBL_LIST_DUE_DATE' => 'Eräpäivä',
  'LBL_LIST_DUE_TIME' => 'Erääntymisen aika',
  'LBL_LIST_FORM_TITLE' => 'Tehtävälista',
  'LBL_LIST_MY_TASKS' => 'Omat avoimet tehtävät',
  'LBL_LIST_PRIORITY' => 'Prioriteetti',
  'LBL_LIST_RELATED_TO' => 'Liittyvät',
  'LBL_LIST_START_DATE' => 'Aloituspäivä',
  'LBL_LIST_START_TIME' => 'Aloitusaika',
  'LBL_LIST_STATUS' => 'Tila',
  'LBL_LIST_SUBJECT' => 'Aihe',
  'LBL_MODULE_NAME' => 'Tehtävät',
  'LBL_MODULE_NAME_SINGULAR' => 'Tehtävä',
  'LBL_MODULE_TITLE' => 'Tehtävät: Etusivu',
  'LBL_NAME' => 'Nimi',
  'LBL_NEW_FORM_DUE_DATE' => 'Eräpäivä',
  'LBL_NEW_FORM_DUE_TIME' => 'Erääntymisen aika',
  'LBL_NEW_FORM_SUBJECT' => 'Aihe',
  'LBL_NEW_FORM_TITLE' => 'Luo Tehtävä',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Tyhjä',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Muistiot',
  'LBL_PARENT_ID' => 'Vanhemman ID:',
  'LBL_PARENT_NAME' => 'Vanhemman tyyppi:',
  'LBL_PHONE' => 'Puhelin',
  'LBL_PRIORITY' => 'Prioriteetti',
  'LBL_REVENUELINEITEMS' => 'Tuoterivit',
  'LBL_SEARCH_FORM_TITLE' => 'Tehtävien haku',
  'LBL_START_DATE' => 'Aloituspäivä',
  'LBL_START_DATE_AND_TIME' => 'Aloituspäivä ja -aika',
  'LBL_START_TIME' => 'Aloitusaika',
  'LBL_STATUS' => 'Tila',
  'LBL_SUBJECT' => 'Aihe',
  'LBL_TASK' => 'Tehtävät:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Tehtävä suljettiin.',
  'LBL_TASK_INFORMATION' => 'Yleiskatsaus',
  'LNK_IMPORT_TASKS' => 'Tuo tehtäviä',
  'LNK_NEW_TASK' => 'Luo tehtävä',
  'LNK_TASK_LIST' => 'Näytä tehtävät',
);

