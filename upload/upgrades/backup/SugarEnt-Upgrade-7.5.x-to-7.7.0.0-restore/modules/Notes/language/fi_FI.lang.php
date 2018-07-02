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
  'ERR_DELETE_RECORD' => 'Tietuenumero tulee määritellä, jotta voit poistaa asiakkaan.',
  'ERR_REMOVING_ATTACHMENT' => 'Liitteen poistaminen epäonnistui...',
  'LBL_ACCOUNT_ID' => 'Asiakkaan ID:',
  'LBL_ACTIVITIES_REPORTS' => 'Toimintakertomus',
  'LBL_CASE_ID' => 'Palvelupyynnön ID:',
  'LBL_CLOSE' => 'Sulje:',
  'LBL_COLON' => '&#58;',
  'LBL_CONTACT_ID' => 'Kontaktin ID:',
  'LBL_CONTACT_NAME' => 'Kontaktin nimi:',
  'LBL_CREATED_BY' => 'Luoja',
  'LBL_DATE_ENTERED' => 'Luontipäivä',
  'LBL_DATE_MODIFIED' => 'Muokattu viimeksi',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Muistiot',
  'LBL_DELETED' => 'Poistettu',
  'LBL_DESCRIPTION' => 'Kuvaus',
  'LBL_EDITLAYOUT' => 'Muokkaa asettelua',
  'LBL_EMAIL_ADDRESS' => 'Sähköpostiosoite:',
  'LBL_EMAIL_ATTACHMENT' => 'Liitä',
  'LBL_EMBED_FLAG' => 'Upota sähköpostiin?',
  'LBL_EXPORT_PARENT_ID' => 'Liittyvän tietueen ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Liittyy moduuliin',
  'LBL_FILENAME' => 'Liite:',
  'LBL_FILE_MIME_TYPE' => 'Mime-tyyppi',
  'LBL_FILE_URL' => 'Tiedoston URL',
  'LBL_FIRST_NAME' => 'Etunimi',
  'LBL_HELP_CREATE' => 'Muistion luonnin vaiheet:

1. Syötä kentille arvoja. Pakollisiksi merkityt kentät pitää täyttää ennen kuin tietue voidaan luoda. Muut kentät ovat valinnaisia.

2. Paina ‘Tallenna’ luodaksesi tietueen. Tämän jälkeen palaat edelliselle sivulle.

&nbsp; Painamalla ‘Tallenna ja näytä’, tietue luodaan, jonka jälkeen näytetään muistion tietuenäkymä.

&nbsp; Paina ‘Tallenna ja luo uusi’, jos haluat heti luoda toisen muistion.',
  'LBL_HELP_RECORD' => 'Muistiot-moduuli tallentaa muistioita, jotka koostuvat tekstistä tai liitetiedostosta.

- Muokkaa tietueen kenttiä klikkaamalla itse kenttää, tai vaihtoehtoisesti ‘Muokkaa’-painiketta.

- Muokkaa linkkejä muihin teitueisiin valitsemalla alavasemmalla oleva paneeli ‘tietonäkymään’.

- Luo ja lue käyttäjäkommentteja ja tietueen historiaa aktiviteettivirrassa. Aktiviteettivirran saat valitsemalla alavasemmalla oleva paneeli ‘aktiviteettivirta’-näkymään.

- Seuraa tai merkkaa tämä tietue suosikiksi käyttämällä tietueen nimen oikealta puolelta löytyviä kuvakkeita.

- Muut toiminnot löytyvät ‘Muokkaa’-painikkeen oikealla puolella olevasta ‘Toiminnot’-valikosta.',
  'LBL_HELP_RECORDS' => 'Muistiot-moduuli tallentaa muistioita, jotka koostuvat tekstistä tai liitetiedostosta. Muistioita voi liittää muiden moduulien tietueisiin ‘flex relate’ -kentän kautta. Muistion voi myös liittää kontaktiin. Muistioita voi luoda Muistiot-moduulin kautta, tuomalla muistioita ulkoisesta lähteestä, historia-alipaneelien kautta, ja muilla tavoin. Luotuja muistioita voi muokata niiden tietuenäkymissä.',
  'LBL_LAST_NAME' => 'Sukunimi',
  'LBL_LEAD_ID' => 'Liidin ID:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Vastuuhenkilö',
  'LBL_LIST_CONTACT' => 'Kontakti',
  'LBL_LIST_CONTACT_NAME' => 'Kontaktit',
  'LBL_LIST_DATE_MODIFIED' => 'Päivitetty',
  'LBL_LIST_EDIT_BUTTON' => 'Muokkaa',
  'LBL_LIST_FILENAME' => 'Liite',
  'LBL_LIST_FORM_TITLE' => 'Muistiolista',
  'LBL_LIST_RELATED_TO' => 'Liittyy',
  'LBL_LIST_STATUS' => 'Tila',
  'LBL_LIST_SUBJECT' => 'Aihe',
  'LBL_MEMBER_OF' => 'Jäsen',
  'LBL_MODIFIED_BY' => 'Muokkaaja',
  'LBL_MODULE_NAME' => 'Muistiot',
  'LBL_MODULE_NAME_SINGULAR' => 'Muistio',
  'LBL_MODULE_TITLE' => 'Muistiot: Etusivu',
  'LBL_MY_NOTES_DASHLETNAME' => 'Muistiot',
  'LBL_NEW_FORM_BTN' => 'Lisää muistio',
  'LBL_NEW_FORM_TITLE' => 'Luo muistio tai lisää liite',
  'LBL_NOTE' => 'Muistio:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Muistiot ja liitteet',
  'LBL_NOTE_INFORMATION' => 'Yleiskatsaus',
  'LBL_NOTE_STATUS' => 'Muistio',
  'LBL_NOTE_SUBJECT' => 'Aihe:',
  'LBL_OC_FILE_NOTICE' => 'Kirjaudu palvelimeen nähdäksesi tiedoston',
  'LBL_OPPORTUNITY_ID' => 'Myyntimahdollisuuden ID:',
  'LBL_PANEL_DETAILS' => 'Tiedot',
  'LBL_PARENT_ID' => 'Vanhemman ID:',
  'LBL_PARENT_TYPE' => 'Kannan tyyppi',
  'LBL_PHONE' => 'Puhelin:',
  'LBL_PORTAL_FLAG' => 'Näytä Portalissa?',
  'LBL_PRODUCT_ID' => 'Tuotteen ID:',
  'LBL_QUOTE_ID' => 'Tarjouksen ID:',
  'LBL_RELATED_TO' => 'Liittyy:',
  'LBL_REMOVING_ATTACHMENT' => 'Poistetaan liitettä ...',
  'LBL_REVENUELINEITEMS' => 'Tuoterivit',
  'LBL_SEARCH_FORM_TITLE' => 'Muistioiden haku',
  'LBL_SEND_ANYWAYS' => 'Sähköpostissa ei ole aihetta. Lähetä/tallenna siitä huolimatta?',
  'LBL_STATUS' => 'Tila:',
  'LBL_SUBJECT' => 'Aihe',
  'LNK_IMPORT_NOTES' => 'Tuo merkintöjä',
  'LNK_NEW_NOTE' => 'Luo merkintä tai liite',
  'LNK_NOTE_LIST' => 'Näytä merkinnät',
);

