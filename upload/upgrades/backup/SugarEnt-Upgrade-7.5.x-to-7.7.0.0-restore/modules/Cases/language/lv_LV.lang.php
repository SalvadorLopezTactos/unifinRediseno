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
  'ERR_DELETE_RECORD' => 'Lai dzēstu uzņēmumu, jānorāda ieraksta numurs.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Uzņēmumi',
  'LBL_ACCOUNT_ID' => 'Uzņēmuma ID',
  'LBL_ACCOUNT_NAME' => 'Uzņēmuma nosaukums:',
  'LBL_ACCOUNT_NAME_MOD' => 'Uzņēmuma nosaukums (Modificētājs)',
  'LBL_ACCOUNT_NAME_OWNER' => 'Uzņēmuma nosaukums (Atbildīgais)',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Darbības',
  'LBL_ASSIGNED_TO_NAME' => 'Piešķirts lietotājam',
  'LBL_ASSIGNED_USER_NAME_MOD' => 'Piešķirts (Modificētājs)',
  'LBL_ASSIGNED_USER_NAME_OWNER' => 'Piešķirts (Atbildīgais)',
  'LBL_ATTACH_NOTE' => 'Pievienot piezīmi',
  'LBL_BUGS_SUBPANEL_TITLE' => 'Kļūdas',
  'LBL_CASE' => 'Pieteikums:',
  'LBL_CASE_FROM_TWITTER_TITLE' => 'Tweet',
  'LBL_CASE_INFORMATION' => 'Apraksts',
  'LBL_CASE_NUMBER' => 'Pieteikuma numurs:',
  'LBL_CASE_SUBJECT' => 'Pieteikuma temats:',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontaktpersonas',
  'LBL_CONTACT_CASE_TITLE' => 'Kontakts-pieteikums:',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Saistīto kontaktu e-pasti',
  'LBL_CONTACT_NAME' => 'Kontaktpersonas vārds:',
  'LBL_CONTACT_ROLE' => 'Loma:',
  'LBL_CREATED_BY_NAME_MOD' => 'Izveidoja (Modificētājs)',
  'LBL_CREATED_BY_NAME_OWNER' => 'Izveidoja (Atbildīgais)',
  'LBL_CREATED_USER' => 'Izveidoja',
  'LBL_CREATE_KB_DOCUMENT' => 'Izveidot rakstu',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Pieteikumi',
  'LBL_DESCRIPTION' => 'Apraksts:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumenti',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Piešķirts lietotājam ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Piešķirts lietotājam',
  'LBL_EXPORT_CREATED_BY' => 'Izveidoja ID',
  'LBL_EXPORT_CREATED_BY_NAME' => 'Izveidoja lietotājs',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificētāja ID',
  'LBL_EXPORT_TEAM_COUNT' => 'Darba grupu skaits',
  'LBL_FILENANE_ATTACHMENT' => 'Pielikums',
  'LBL_HELP_CREATE' => '{{plural_module_name}} modulis paredzēts ar produktiem vai servisiem saistītu problēmu reģistrēšansai un pārvaldībai par kurām ir ziņojuši jūsu klienti.

Lai izveidotu ierakstu:
1. Ievadiet atbilstošos laukos prasītās vērtības.
- Lauki saglabātu ierakstu ir jāaizpilda lauki kas atzīmēti kā obligāti.
- Ja nepieciešams redzēt papildus laukus spiediet uz "Rādīt vairāk".
2. Spiediet "Saglabāt" lai pabeigtu jauna ierakst veidošanu un atgrieztos iepriekšējā lapā.
- Izvēlieties "Saglabāt un apskatīt" lai atvērtu jauno kļūdu ierakstu skata logā.
- Izvēlieties "Saglabāt un veidot jaunu" lai uzreiz izveidotu vēl vienu jaunu kļūdas pieteikumu.',
  'LBL_HELP_RECORD' => '{{plural_module_name}} modulis paredzēts ar produktiem vai servisiem saistītu problēmu reģistrēšansai un pārvaldībai par kurām ir ziņojuši jūsu klienti.

- Rediģējiet ieraksta laukus klikšķinot uz laukiem vai pogas Rediģēt.
- Apskatiet vai rediģējiet saites uz cietiem ierakstiem apakšpaneļos ieslēdzot datu skatu kreisajā apakšējā panelī.
- Veidojiet un apskaties lietotāju komentārus un ierakstu izmaiņu vēsturi darbību plūsmas panelī ieslēdzot darbību plūsmas skatu kreisajā apakšējā panelī.
- Sekojiet vai izceliet šo ierakstu izmantojot ikonas pa labi no ieraksta nosaukuma.
- Papildus darbības pieejamas izkrītošajā darbību izvēlnē pa labi no Rediģēšanas pogas.',
  'LBL_HELP_RECORDS' => '{{plural_module_name}} modulis paredzēts ar produktiem vai servisiem saistītu problēmu reģistrēšansai un pārvaldībai par kurām ir ziņojuši jūsu klienti. {{plural_module_name}} parasti ir pakārtots modulim {{accounts_singular_module}}, un vairāki {{plural_module_name}} var būt pakārtoti vienam {{accounts_singular_module}}. Ir vairākas iespējas kā izveidot {{plural_module_name}} Sugar, izmantojot moduli {{plural_module_name}}, importējot {{plural_module_name}},  vai konvertējot no e-pasta. Kad {{module_name}} ir izveidots, jūs variet aplūkot un rediģēt informāciju kas attiecas uz {{module_name}} caur {{module_name}} kartiņas skatu. Katram {{module_name}} ierakstam tad var tikt pakārtots cits Sugar iereksts, tādas kā {{calls_module}}, {{contacts_module}}, {{bugs_module}}, un daudzi citi',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Vēsture',
  'LBL_INVITEE' => 'Ielūgtie',
  'LBL_KBDOCUMENTS_SUBPANEL_TITLE' => 'Zināšanu bāze',
  'LBL_LIST_ACCOUNT_NAME' => 'Uzņēmuma nosaukums',
  'LBL_LIST_ASSIGNED' => 'Piešķirts lietotājam',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Piešķirts lietotājam',
  'LBL_LIST_CLOSE' => 'Aizvērt',
  'LBL_LIST_DATE_CREATED' => 'Izveidots',
  'LBL_LIST_FORM_TITLE' => 'Pieteikumu saraksts',
  'LBL_LIST_LAST_MODIFIED' => 'Modificēts',
  'LBL_LIST_MY_CASES' => 'Mani atvērtie pieteikumi',
  'LBL_LIST_NUMBER' => 'Nr.',
  'LBL_LIST_PRIORITY' => 'Prioritāte',
  'LBL_LIST_STATUS' => 'Statuss',
  'LBL_LIST_SUBJECT' => 'Temats',
  'LBL_MEMBER_OF' => 'Klients',
  'LBL_MODIFIED_BY_NAME_MOD' => 'Modificēja (Modificētājs)',
  'LBL_MODIFIED_BY_NAME_OWNER' => 'Modificēja (Atbildīgais)',
  'LBL_MODIFIED_USER' => 'Modificēja',
  'LBL_MODIFIED_USER_NAME' => 'Modificēja',
  'LBL_MODIFIED_USER_NAME_MOD' => 'Modificēja (Modificētājs)',
  'LBL_MODIFIED_USER_NAME_OWNER' => 'Modificēja (Atbildīgais)',
  'LBL_MODULE_NAME' => 'Pieteikumi',
  'LBL_MODULE_NAME_SINGULAR' => 'Pieteikums',
  'LBL_MODULE_TITLE' => 'Pieteikumi',
  'LBL_NEW_FORM_TITLE' => 'Jauns pieteikums',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Piezīmes',
  'LBL_NUMBER' => 'Numurs:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Ja Jums ir jauns atbalsta Pieteikums, kuru vēlaties apstiprināt, klikšķiniet šeit, lai apstiprinātu jaunu Pieteikumu',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Jūs varat filtrēt Pieteikumu sarakstu, ievadot meklēšanas frāzi.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Piemēram, Jūs varat izmantot šo, lai atrastu iepriekš apstiprinātas problēmas.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'Pieteikumu modulis tiek lietots lai pārvaldītu atbalsta pieteikumus, kuri ietekmē jūsu klientus. Izmanto zemāk esošās bultas,lai izietu ātro apskati.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Šajā lapā attēlots Uzņēmumam piesaistīto Pieteikumu saraksts.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Spiežot šeit jūs tiksiet atgriezts šajā skatījumā jebkurā laikā.',
  'LBL_PORTAL_VIEWABLE' => 'Redzams portālā',
  'LBL_PRIORITY' => 'Prioritāte:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekti',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projekti',
  'LBL_RESOLUTION' => 'Risinājums:',
  'LBL_SEARCH_FORM_TITLE' => 'Pieteikumu meklēšana',
  'LBL_SHOW_IN_PORTAL' => 'Rādīt portālā',
  'LBL_SHOW_MORE' => 'Rādīt vairāk pieteikumu',
  'LBL_SOURCE' => 'Avots:',
  'LBL_STATUS' => 'Statuss:',
  'LBL_SUBJECT' => 'Temats:',
  'LBL_SYSTEM_ID' => 'Sistēmas ID',
  'LBL_TEAM_COUNT_MOD' => 'Darba grupu skaits (Modificētājs)',
  'LBL_TEAM_COUNT_OWNER' => 'Darba grupu skaits (Atbildīgais)',
  'LBL_TEAM_NAME_MOD' => 'Darba grupas nosaukums (Modificētājs)',
  'LBL_TEAM_NAME_OWNER' => 'Darba grupas nosaukums (Atbildīgais)',
  'LBL_TYPE' => 'Tips',
  'LBL_WORK_LOG' => 'Izmaiņu žurnāls',
  'LNK_CASE_LIST' => 'Pieteikumi',
  'LNK_CASE_REPORTS' => 'Pieteikumu atskaites',
  'LNK_CREATE' => 'Izveidot pieteikumu',
  'LNK_CREATE_WHEN_EMPTY' => 'Izveidot pieteikumu tagad.',
  'LNK_IMPORT_CASES' => 'Importēt pieteikumus',
  'LNK_NEW_CASE' => 'Izveidot pieteikumu',
  'NTC_REMOVE_FROM_BUG_CONFIRMATION' => 'Vai tiešām vēlaties šo pieteikumu noņemt no kļūdas?',
  'NTC_REMOVE_INVITEE' => 'Vai tiešām vēlaties noņemt šo kontaktu noņemt no pieteikuma?',
);

