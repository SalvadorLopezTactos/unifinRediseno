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
  'ERR_DELETE_RECORD' => 'Lai dzēstu kļūdu, jānorāda ieraksta numurs.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Uzņēmumi',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Darbības',
  'LBL_ASSIGNED_TO_NAME' => 'Piešķirts lietotājam',
  'LBL_BUG' => 'Kļūda:',
  'LBL_BUG_INFORMATION' => 'Apraksts',
  'LBL_BUG_NUMBER' => 'Kļūdas numurs:',
  'LBL_BUG_SUBJECT' => 'Kļūdas temats:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Pieteikumi',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontaktpersonas',
  'LBL_CONTACT_BUG_TITLE' => 'Kontakta kļūda:',
  'LBL_CONTACT_NAME' => 'Kontaktpersonas vārds:',
  'LBL_CONTACT_ROLE' => 'Loma:',
  'LBL_CREATED_BY' => 'Izveidoja:',
  'LBL_DATE_CREATED' => 'Izveidots:',
  'LBL_DATE_LAST_MODIFIED' => 'Modificēts:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Kļūdu sekotājs',
  'LBL_DESCRIPTION' => 'Apraksts:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumenti',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Piešķirts lietotājam ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Piešķirts lietotājam',
  'LBL_EXPORT_CREATED_BY' => 'Izveidotāja ID',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Izlabots laidienā:',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificētāja ID',
  'LBL_FIXED_IN_RELEASE' => 'Izlabots laidienā:',
  'LBL_FOUND_IN_RELEASE' => 'Atrasts laidienā:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Atrasts laidienā:',
  'LBL_HELP_CREATE' => 'Kļūdu modulis tiek izmantots lai reģistrētu un pārvaldītu ar produktu saistītās problēmas, kas parasti tiek reģistrētas kā kļūdas vai defekti, gan pašu atrastas gan klientu pieteiktās.

Lai izveidotu kļūdas pieteikumu:
1. Ievadiet atbilstošos laukos prasītās vērtības.
- Lauki saglabātu ierakstu ir jāaizpilda lauki kas atzīmēti kā obligāti.
- Ja nepieciešams redzēt papildus laukus spiediet uz "Rādīt vairāk".
2. Spiediet "Saglabāt" lai pabeigtu jauna ierakst veidošanu un atgrieztos iepriekšējā lapā.
- Izvēlieties "Saglabāt un apskatīt" lai atvērtu jauno kļūdu ierakstu skata logā.
- Izvēlieties "Saglabāt un veidot jaunu" lai uzreiz izveidotu vēl vienu jaunu kļūdas pieteikumu.',
  'LBL_HELP_RECORD' => '{{plural_module_name}} modulis tiek izmantos lai reģistrētu un pārvaldītu ar produktu saistītās problēmas, kas parasti tiek ziņotas kā  {{plural_module_name}} vei defekti, gan pašu atrastas gan klientu pieteiktas.

- Rediģējiet ieraksta laukus klikšķinot uz laukiem vai pogas Rediģēt.
- Apskatiet vai rediģējiet saites uz cietiem ierakstiem apakšpaneļos ieslēdzot datu skatu kreisajā apakšējā panelī.
- Veidojiet un apskaties lietotāju komentārus un ierakstu izmaiņu vēsturi darbību plūsmas panelī ieslēdzot darbību plūsmas skatu kreisajā apakšējā panelī.
- Sekojiet vai izceliet šo ierakstu izmantojot ikonas pa labi no ieraksta nosaukuma.
- Papildus darbības pieejamas izkrītošajā darbību izvēlnē pa labi no Rediģēšanas pogas.',
  'LBL_HELP_RECORDS' => 'Kļūdu modulis tiek izmantots lai reģistrētu un pārvaldītu ar produktu saistītās problēmas, kas parasti tiek reģistrētas kā kļūdas vai defekti, gan pašu atrastas gan klientu pieteiktās. Reģistrētās {{plural_module_name}} vēlāk var izmantot lai fiksētu versijā atrastās un izlabotās kļūdas.Kļūdu modulis ļauj lietotājiem ātri caurskatīt kļūdu informāciju un veikt to labojumus. Kad kļūda ir reģistrēta to var aplūkot un rediģēt ieraksta kartiņā.Katrs {{module_name}}s ieraksts ar būt pakārtot citiem Sugar ierakstiem, tādoiem kā  {{calls_module}}, {{contacts_module}}, {{cases_module}}, un daudziem citiem.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Vēsture',
  'LBL_INVITEE' => 'Kontaktpersonas',
  'LBL_LIST_ACCOUNT_NAME' => 'Uzņēmuma nosaukums',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Piešķirts lietotājam',
  'LBL_LIST_CONTACT_NAME' => 'Kontaktpersonas vārds',
  'LBL_LIST_EMAIL_ADDRESS' => 'E-pasta adrese',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Izlabots laidienā',
  'LBL_LIST_FORM_TITLE' => 'Kļūdu saraksts',
  'LBL_LIST_LAST_MODIFIED' => 'Pēdējās izmaiņas',
  'LBL_LIST_MY_BUGS' => 'Man piešķirtās kļūdas',
  'LBL_LIST_NUMBER' => 'Nr.',
  'LBL_LIST_PHONE' => 'Tālrunis',
  'LBL_LIST_PRIORITY' => 'Prioritāte',
  'LBL_LIST_RELEASE' => 'Laidiens',
  'LBL_LIST_RESOLUTION' => 'Risinājums',
  'LBL_LIST_STATUS' => 'Statuss',
  'LBL_LIST_SUBJECT' => 'Temats',
  'LBL_LIST_TYPE' => 'Tips',
  'LBL_MODIFIED_BY' => 'Pēdējais modificēja:',
  'LBL_MODULE_ID' => 'Kļūdas',
  'LBL_MODULE_NAME' => 'Kļūdas',
  'LBL_MODULE_NAME_SINGULAR' => 'Kļūda',
  'LBL_MODULE_TITLE' => 'Kļūdu sekotājs: Sākums',
  'LBL_NEW_FORM_TITLE' => 'Jauna kļūda',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Piezīmes',
  'LBL_NUMBER' => 'Numurs:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Ja Jūs esat atradis jaunu Kļūdu, par kuru vēlaties ziņot, klikšķiniet šeit lai ziņotu par jaunu Kļūdu.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Jūs varat filtrēt Kļūdu sarakstu, ievadot meklēšanas frāzi.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Piemēram, Jūs varat izmantot šo, lai atrastu iepriekš ziņotu kļūdu.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'Zināšanu Bāzes modulis tiek lietots darbam ar publicētajiem rakstiem. Izmantojiet zemāk esošās bultas, lai ietu cauri ātrajai apskatei.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Šajā lapā ir attēlots esošo Kļūdu saraksts.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Spiežot šeit jūs tiksiet atgriezts šajā skatījumā jebkurā laikā.',
  'LBL_PORTAL_VIEWABLE' => 'Redzams portālā',
  'LBL_PRIORITY' => 'Prioritāte:',
  'LBL_PRODUCT_CATEGORY' => 'Kategorija:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekti',
  'LBL_RELEASE' => 'Laidiens:',
  'LBL_RESOLUTION' => 'Risinājums:',
  'LBL_SEARCH_FORM_TITLE' => 'Kļūdu meklēšana',
  'LBL_SHOW_IN_PORTAL' => 'Radīt portālā',
  'LBL_SHOW_MORE' => 'Rādīt vairāk kļūdu',
  'LBL_SOURCE' => 'Avots:',
  'LBL_STATUS' => 'Statuss:',
  'LBL_SUBJECT' => 'Temats:',
  'LBL_SYSTEM_ID' => 'Sistēmas ID',
  'LBL_TYPE' => 'Tips:',
  'LBL_WORK_LOG' => 'Darba žurnāls:',
  'LNK_BUG_LIST' => 'Aplūkot kļūdas',
  'LNK_BUG_REPORTS' => 'Aplūkot kļūdu atskaites',
  'LNK_CREATE' => 'Ziņot par kļūdu',
  'LNK_CREATE_WHEN_EMPTY' => 'Ziņot par kļūdu tagad.',
  'LNK_IMPORT_BUGS' => 'Importēt kļūdas',
  'LNK_NEW_BUG' => 'Ziņot par kļūdu',
  'NTC_DELETE_CONFIRMATION' => 'Vai tiešām vēlaties izņemt kontaktpersonu no šī kļūdas ieraksta?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Vai tiešām vēlaties izņemt šo kļūdu no šī uzņēmuma ieraksta?',
  'NTC_REMOVE_INVITEE' => 'Vai tiešām vēlaties izņemt šo kontaktpersonu no kļūdas ieraksta?',
);

