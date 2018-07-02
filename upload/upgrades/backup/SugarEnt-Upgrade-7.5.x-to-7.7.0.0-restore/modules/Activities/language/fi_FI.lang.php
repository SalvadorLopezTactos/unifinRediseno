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
  'LBL_ACCEPT' => 'Hyväksy',
  'LBL_ACCEPT_THIS' => 'Hyväksy?',
  'LBL_COLON' => ':',
  'LBL_CONTACT_NAME' => 'Kontaktin nimi:',
  'LBL_DATE' => 'Päivämäärä',
  'LBL_DATE_TIME' => 'Aloituspäivä ja -aika:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Avoimet aktiviteetit',
  'LBL_DELETE_ACTIVITY' => 'Haluatko varmasti poistaa tämän aktiviteetin?',
  'LBL_DESCRIPTION' => 'Kuvaus',
  'LBL_DESCRIPTION_INFORMATION' => 'Kuvauksen tiedot',
  'LBL_DIRECTION' => 'Suunta',
  'LBL_DURATION' => 'Kesto:',
  'LBL_DURATION_MINUTES' => 'Kesto minuuteissa:',
  'LBL_HISTORY' => 'Historia',
  'LBL_HOURS_MINS' => '(Tunnit / minuutit)',
  'LBL_INVITEE' => 'Kutsutut',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Vastuuhenkilö',
  'LBL_LIST_CLOSE' => 'Sulje',
  'LBL_LIST_CONTACT' => 'Kontakti',
  'LBL_LIST_DATE' => 'Päivämäärä',
  'LBL_LIST_DIRECTION' => 'Suunta',
  'LBL_LIST_DUE_DATE' => 'Eräpäivä',
  'LBL_LIST_FORM_TITLE' => 'Aktiviteettilista',
  'LBL_LIST_LAST_MODIFIED' => 'Päivitetty',
  'LBL_LIST_RELATED_TO' => 'Liittyvät',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Aihe',
  'LBL_LIST_TIME' => 'Aloitusaika',
  'LBL_LOCATION' => 'Paikka:',
  'LBL_MEETING' => 'Kokous',
  'LBL_MODULE_NAME' => 'Aktiviteetit',
  'LBL_MODULE_NAME_SINGULAR' => 'Aktiviteettivirta',
  'LBL_MODULE_TITLE' => 'Aktiviteetit: Etusivu',
  'LBL_NEW_NOTE_BUTTON_KEY' => 'T',
  'LBL_NEW_NOTE_BUTTON_LABEL' => 'Luo merkintä tai liite',
  'LBL_NEW_NOTE_BUTTON_TITLE' => 'Luo merkintä tai liite',
  'LBL_NEW_TASK_BUTTON_KEY' => 'N',
  'LBL_NEW_TASK_BUTTON_LABEL' => 'Luo tehtävä',
  'LBL_NEW_TASK_BUTTON_TITLE' => 'Luo tehtävä',
  'LBL_OPEN_ACTIVITIES' => 'Avaa aktiviteetit',
  'LBL_SCHEDULE_CALL_BUTTON_KEY' => 'C',
  'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'Kirjaa puhelu',
  'LBL_SCHEDULE_CALL_BUTTON_TITLE' => 'Kirjaa puhelu',
  'LBL_SCHEDULE_MEETING_BUTTON_KEY' => 'M',
  'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'Ajoita kokous',
  'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'Ajoita kokous',
  'LBL_SEARCH_FORM_TITLE' => 'Aktiviteettien haku',
  'LBL_STATUS' => 'Tila:',
  'LBL_SUBJECT' => 'Aihe',
  'LBL_TIME' => 'Aloitusaika:',
  'LBL_TODAY' => 'Tänään',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'Arkistoi sähköposti',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'Arkistoi sähköposti [Alt+K]',
  'LBL_UPCOMING' => 'Tulevat kokoukset',
  'LNK_CALL_LIST' => 'Katso puhelut',
  'LNK_EMAIL_LIST' => 'Näytä sähköpostit',
  'LNK_IMPORT_CALLS' => 'Tuo puhelut',
  'LNK_IMPORT_MEETINGS' => 'Tuo kokoukset',
  'LNK_IMPORT_NOTES' => 'Tuo merkinnät',
  'LNK_IMPORT_TASKS' => 'Tuo tehtävät',
  'LNK_MEETING_LIST' => 'Näytä kokoukset',
  'LNK_NEW_APPOINTMENT' => 'Uusi tapaaminen',
  'LNK_NEW_CALL' => 'Kirjaa puhelu',
  'LNK_NEW_EMAIL' => 'Luo arkistoitu sähköposti',
  'LNK_NEW_MEETING' => 'Ajoita kokous',
  'LNK_NEW_NOTE' => 'Luo muistio tai lisää liite',
  'LNK_NEW_TASK' => 'Luo tehtävä',
  'LNK_NOTE_LIST' => 'Näytä muistiot',
  'LNK_TASK_LIST' => 'Näytä tehtävät',
  'LNK_VIEW_CALENDAR' => 'Näytä kalenteri',
  'NTC_NONE' => 'Ei mitään',
  'NTC_NONE_SCHEDULED' => 'Ei ole ajoitettu.',
  'NTC_REMOVE_INVITEE' => 'Oletko varma, että haluat poistaa tämän kutsutun kokouksesta?',
  'appointment_filter_dom' => 
  array (
    'last next_month' => 'ensi kuussa',
    'last this_month' => 'tässä kuussa',
    'next Saturday' => 'ensi viikolla',
    'this Saturday' => 'tällä viikolla',
    'today' => 'tänään',
    'tomorrow' => 'huomenna',
  ),
);

