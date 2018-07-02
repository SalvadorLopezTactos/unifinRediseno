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
  'ERR_DELETE_RECORD' => 'Lai dzēstu iespēju, jānorāda ieraksta numurs.',
  'LABEL_PANEL_ASSIGNMENT' => 'Piešķīrums',
  'LBL_ACCOUNT_ID' => 'Uzņēmuma ID',
  'LBL_ACCOUNT_NAME' => 'Uzņēmuma nosaukums:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Darbības',
  'LBL_ASSIGNED_TO_ID' => 'Piešķirts lietotājam:',
  'LBL_ASSIGNED_TO_NAME' => 'Piešķirts lietotājam:',
  'LBL_CAMPAIGN' => 'Kampaņa:',
  'LBL_CAMPAIGN_LINK' => 'Kampaņas saite',
  'LBL_CAMPAIGN_OPPORTUNITY' => 'Kampaņas',
  'LBL_CLOSED_RLIS' => '# no slēgtajiem ieņēmumu posteņiem',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'Aizvērtās izcīnītās iespējas',
  'LBL_COMMITTED' => 'Iesniegts',
  'LBL_COMMIT_STAGE' => 'Iesniegt posmu',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontaktpersonas',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Saistīto kontaktpersonu e-pasti',
  'LBL_CONTRACTS' => 'Līgumi',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Līgumi',
  'LBL_CREATED_ID' => 'Izveidotāja ID',
  'LBL_CREATED_USER' => 'Izveidoja lietotājs',
  'LBL_CURRENCIES' => 'Valūtas',
  'LBL_CURRENCY' => 'Valūta:',
  'LBL_CURRENCY_ID' => 'Valūtas ID',
  'LBL_CURRENCY_NAME' => 'Valūtas nosaukums',
  'LBL_CURRENCY_RATE' => 'Valūtas kurss',
  'LBL_CURRENCY_SYMBOL' => 'Valūtas simbols',
  'LBL_DATE_CLOSED' => 'Paredzēts slēgšanas datums:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Paredzētā slēgšanas datuma laikspiedols',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Iespējas',
  'LBL_DESCRIPTION' => 'Apraksts:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumenti',
  'LBL_DUPLICATE' => 'Varbūtējs iespējas dublikāts',
  'LBL_EDITLAYOUT' => 'Rediģēt izkārtojumu',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Piešķirts lietotājam ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Piešķirts lietotājam',
  'LBL_EXPORT_CAMPAIGN_ID' => 'Kampaņas ID',
  'LBL_EXPORT_CREATED_BY' => 'Izveidotāja ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificētāja ID',
  'LBL_EXPORT_NAME' => 'Nosaukums',
  'LBL_FILENAME' => 'Pielikums',
  'LBL_FORECAST' => 'Iekļatu prognozē',
  'LBL_HELP_CREATE' => '{{plural_module_name}} modulis ļauj jums sekot atsevišķām pārdošanām. Katrs {{module_name}}s ieraksts ir galvene ieņēmumu posteņu grupai kā arī ir saistīta ar citiem svarīgiem ierakstiem kā {{quotes_module}}, {{contacts_module}}, u.c.

Lai izveidotu ierakstu:
1. Ievadiet atbilstošos laukos prasītās vērtības.
 - Lauki saglabātu ierakstu ir jāaizpilda lauki kas atzīmēti kā obligāti.
 - Ja nepieciešams redzēt papildus laukus spiediet uz "Rādīt vairāk".
2. Spiediet "Saglabāt" lai pabeigtu jauna ierakst veidošanu un atgrieztos iepriekšējā lapā.
 - Izvēlieties "Saglabāt un apskatīt" lai atvērtu jauno kļūdu ierakstu skata logā.
 - Izvēlieties "Saglabāt un veidot jaunu" lai uzreiz izveidotu vēl vienu jaunu kļūdas pieteikumu.
3. Pēc saglabāšanas izmantojiet apakšpaneli {{revenuelineitems_module}} lai pievienoti rindas {{module_name}}i.',
  'LBL_HELP_RECORD' => '{{plural_module_name}} modulis ļauj jums sekot atsevišķām pārdošanām. Katrs {{module_name}}s ieraksts ir galvene ieņēmumu posteņu grupai kā arī ir saistīta ar citiem svarīgiem ierakstiem kā {{quotes_module}}, {{contacts_module}}, u.c.

- Rediģējiet ieraksta laukus klikšķinot uz laukiem vai pogas Rediģēt.
- Apskatiet vai rediģējiet saites uz cietiem ierakstiem apakšpaneļos ieslēdzot datu skatu kreisajā apakšējā panelī.
- Veidojiet un apskaties lietotāju komentārus un ierakstu izmaiņu vēsturi darbību plūsmas panelī ieslēdzot darbību plūsmas skatu kreisajā apakšējā panelī.
- Sekojiet vai izceliet šo ierakstu izmantojot ikonas pa labi no ieraksta nosaukuma.
- Papildus darbības pieejamas izkrītošajā darbību izvēlnē pa labi no Rediģēšanas pogas.',
  'LBL_HELP_RECORDS' => '{{plural_module_name}} modulis ļauj jums sekot atsevišķām pārdošanām. Katrs {{module_name}}s ieraksts ir galvene ieņēmumu posteņu grupai kā arī ir saistīta ar citiem svarīgiem ierakstiem kā {{quotes_module}}, {{contacts_module}}, u.c. Katrs ieņēmumu postenis ir potenciāla pārdošana kādam produktam un ietver atbilstošu pārdošanas informāciju. Katrs ieņēmumu postenis ieziet caur vairākiem pārdošanas posmiem, kamēr tiek atzīmēts kā Uzvarēts vai Zaudēts. {{module_name}}s ieraksts atspoguļo iekļauto ieņēmumu posteņu summu un plānoto slēgšanas datumu. {{plural_module_name}} un {{revenuelineitems_module}} dati var tikt pārsūtīti tālāk uz prognožu moduli lai saprastu un paredzētu pārdošanas virzību kā āri fokusēties uz pārdošanas kvotas sasniegšanu.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Vēsture',
  'LBL_INVITEE' => 'Kontaktpersonas',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Interesenti',
  'LBL_LEAD_SOURCE' => 'Interesenta avots:',
  'LBL_LIST_ACCOUNT_NAME' => 'Uzņēmuma nosaukums',
  'LBL_LIST_AMOUNT' => 'Ticamākā',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'Kopsumma',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Piešķirts lietotājam',
  'LBL_LIST_DATE_CLOSED' => 'Aizvērt',
  'LBL_LIST_FORM_TITLE' => 'Iespēju saraksts',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Nosaukums',
  'LBL_LIST_SALES_STAGE' => 'Pārdošanas posms',
  'LBL_MKTO_ID' => 'Marketo Lead ID',
  'LBL_MKTO_SYNC' => 'Sync to Marketo&reg;',
  'LBL_MODIFIED_ID' => 'Modificētāja ID',
  'LBL_MODIFIED_NAME' => 'Modificēja lietotājs',
  'LBL_MODIFIED_USER' => 'Modificēja lietotājs',
  'LBL_MODULE_NAME' => 'Iespējas',
  'LBL_MODULE_NAME_SINGULAR' => 'Iespēja',
  'LBL_MODULE_TITLE' => 'Iespējas: Sākums',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'Manas aizvērtās iespējas',
  'LBL_NAME' => 'Iespējas nosaukums',
  'LBL_NEW_FORM_TITLE' => 'Izveidot iespēju',
  'LBL_NEXT_STEP' => 'Nākamais solis:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Piezīmes',
  'LBL_OPPORTUNITY' => 'Iespēja:',
  'LBL_OPPORTUNITY_NAME' => 'Iespējas nosaukums:',
  'LBL_OPPORTUNITY_ROLE' => 'Iespējas loma',
  'LBL_OPPORTUNITY_TYPE' => 'Iespējas tips',
  'LBL_PIPELINE_TOTAL_IS' => 'Piltuves kopsumma ir',
  'LBL_PRIMARY_QUOTE_ID' => 'Sākotnējais piedāvājums',
  'LBL_PROBABILITY' => 'Varbūtība (%):',
  'LBL_PRODUCTS' => 'Produkti',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Piedāvājuma rindas',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekti',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projekti',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Piedāvājumi',
  'LBL_QUOTE_SUBPANEL_TITLE' => 'Piedāvājumi',
  'LBL_RAW_AMOUNT' => 'Neapstrādāta summa',
  'LBL_RLI' => 'Ieņēmumu posteņi',
  'LBL_RLI_SUBPANEL_TITLE' => 'Ieņēmumu posteņi',
  'LBL_SALES_STAGE' => 'Pārdošanas posms:',
  'LBL_SALES_STATUS' => 'Statuss',
  'LBL_SEARCH_FORM_TITLE' => 'Iespēju meklēšana',
  'LBL_TEAM_ID' => 'Darba grupas ID',
  'LBL_TIMEPERIODS' => 'Laika periodi',
  'LBL_TIMEPERIOD_ID' => 'Laika perioda ID',
  'LBL_TOP_OPPORTUNITIES' => 'Manas top atvērtās iespējas',
  'LBL_TOTAL_OPPORTUNITIES' => 'Iespēju kopskaits',
  'LBL_TOTAL_RLIS' => '# no visiem ieņēmumu posteņiem',
  'LBL_TYPE' => 'Veids:',
  'LBL_VIEW_FORM_TITLE' => 'Iespēju skatījums',
  'LBL_WORKSHEET' => 'Darblapa',
  'LNK_CREATE' => 'Izveidot darījumu',
  'LNK_IMPORT_OPPORTUNITIES' => 'Importēt iespējas',
  'LNK_NEW_OPPORTUNITY' => 'Jauna iespēja',
  'LNK_OPPORTUNITY_LIST' => 'Aplūkot iespējas',
  'LNK_OPPORTUNITY_REPORTS' => 'Aplūkot iespēju atskaites',
  'MSG_DUPLICATE' => 'Veidojamā iespēja varbūt ir dublikāts citai iespējai. Līdzīgi nosauktās iespējas uzskaitītas zemāk.<br>Klikšķiniet saglabāt, lai turpinātu veidot šo iespēju, vai klikšķiniet Atcelt, lai atgrieztos modulī, neveidojot iespēju.',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => 'Jūs nevarat dzēst iespējas, kuras satur aizvērtus ieņēmumu posteņus',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Vai jūs tiešām vēlaties izņemt šo kontaktpersonu no iespējas?',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'Vai jūs vēlāties izņemt šo iespēju no projekta?',
  'TPL_RLI_CREATE' => 'Iespējai jābūt piesaistītam Ieņēmumu postenim. <a href="javascript:void(0);" id="createRLI"Izveidot Ieņēmumu posteni</a>.',
  'TPL_RLI_CREATE_LINK_TEXT' => 'Izveidot ieņēmumu posteni.',
  'UPDATE' => 'Iespēja - Atjaunināt valūtu',
  'UPDATE_BUGFOUND_COUNT' => 'Atrastās kļūdas:',
  'UPDATE_BUG_COUNT' => 'Kļūdas atrastas, un mēģinātas izlabot:',
  'UPDATE_COUNT' => 'Atjaunināti ieraksti:',
  'UPDATE_CREATE_CURRENCY' => 'Veido jaunu valūtu:',
  'UPDATE_DOLLARAMOUNTS' => 'Atjaunot pamatvalūtas summas',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Atjaunot pamatvalūtu summas iespējām, balstoties uz patreizējo valūtas kursu. Šī vērtība tiek lietota, lai aprēķinātu Grafikus un Saraksta skatījuma valūtu summas.',
  'UPDATE_DONE' => 'Pabeigts',
  'UPDATE_FAIL' => 'Nav iespējams atjaunināt -',
  'UPDATE_FIX' => 'Izlabot summas',
  'UPDATE_FIX_TXT' => 'Mēģina salabot jebkuras nederīgās summas, veidojot derīgu decimālo formu patreizējajai summai. Jebkura modificētā summa ir dublēta datubāzes laukā - amount_backup. Ja  šo darbību izpildot pamaniet kļūdas, pirms darbības atkārtotas izpildes atjaunojiet summas no dublējuma. Pretējā gadījumā dublējums var tikt pārrakstīts ar nederīgiem datiem.',
  'UPDATE_INCLUDE_CLOSE' => 'Iekļaut aizvērtos ierakstus',
  'UPDATE_MERGE' => 'Sapludināt valūtas',
  'UPDATE_MERGE_TXT' => 'Sapludināt vairāku valūtu informāciju vienā valūtā. Ja ir vairāki ieraksti vienai un tai pašai valūtai, tie tiks sapludināti kopā. Rezultātā notiks valūtu sapludināšana arī visos citos moduļos.',
  'UPDATE_NULL_VALUE' => 'Summa ir NULL, tiek uzstādīta uz 0 -',
  'UPDATE_RESTORE' => 'Atjaunot summas',
  'UPDATE_RESTORE_COUNT' => 'Atjaunotas summas:',
  'UPDATE_RESTORE_TXT' => 'Atjauno summu vērtības no labošanas laikā veidotajiem dublējumiem.',
  'UPDATE_VERIFY' => 'Pārbaudīt summas',
  'UPDATE_VERIFY_CURAMOUNT' => 'Patreizējā summa:',
  'UPDATE_VERIFY_FAIL' => 'Ieraksta pārbaude neveiksmīga:',
  'UPDATE_VERIFY_FIX' => 'Pēc izlabošanas iegūsim',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Jaunā summa:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Jaunā valūta:',
  'UPDATE_VERIFY_TXT' => 'Pārbauda vai iespēju summu vērtības ir derīgi decimālie skaitļi, kuri satur tikai ciparus0-9) un decimālos punktus(.)',
  'WARNING_NO_DELETE_CLOSED_SELECTED' => 'Viens vai vairāki no atlasītajiem ierakstiem satur aizvērtus ieņēmumu posteņus un nevar tikt dzēsti.',
);

