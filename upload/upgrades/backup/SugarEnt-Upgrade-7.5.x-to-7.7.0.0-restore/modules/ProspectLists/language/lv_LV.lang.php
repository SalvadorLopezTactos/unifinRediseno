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
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Uzņēmumi',
  'LBL_ASSIGNED_TO' => 'Piešķirts lietotājam',
  'LBL_CAMPAIGNS_SUBPANEL_TITLE' => 'Kampaņas',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontaktpersonas',
  'LBL_COPY_PREFIX' => 'Kopija',
  'LBL_CREATED' => 'Izveidoja',
  'LBL_CREATED_BY' => 'Izveidoja',
  'LBL_DATE_CREATED' => 'Izveidots',
  'LBL_DATE_ENTERED' => 'Izveidots',
  'LBL_DATE_LAST_MODIFIED' => 'Modificēts',
  'LBL_DATE_MODIFIED' => 'Modificēts',
  'LBL_DESCRIPTION' => 'Apraksts',
  'LBL_DOMAIN' => 'Nav e-pastu uz šo domēnu',
  'LBL_DOMAIN_NAME' => 'Domēna vārds',
  'LBL_ENTRIES' => 'Ierakstu skaits',
  'LBL_HELP_CREATE' => 'Modulis "{{module_name}}" satur sarakstus ar personām vai uzņēmumiem, kurus jūs vēlaties iekļaut vai izslēgt no mārketinga epasta kampaņām modulī "{{campaigns_singular_module}}".

Lai izveidotu ierakstu:
1. Ievadiet atbilstošos laukos prasītās vērtības.
 - Lauki saglabātu ierakstu ir jāaizpilda lauki kas atzīmēti kā obligāti.
 - Ja nepieciešams redzēt papildus laukus spiediet uz "Rādīt vairāk".
2. Spiediet "Saglabāt" lai pabeigtu jauna ierakst veidošanu un atgrieztos iepriekšējā lapā.
 - Izvēlieties "Saglabāt un apskatīt" lai atvērtu jauno kļūdu ierakstu skata logā.
 - Izvēlieties "Saglabāt un veidot jaunu" lai uzreiz izveidotu vēl vienu jaunu kļūdas pieteikumu.',
  'LBL_HELP_RECORD' => 'Modulis "{{module_name}}" satur sarakstus ar personām vai uzņēmumiem, kurus jūs vēlaties iekļaut vai izslēgt no mārketinga epasta kampaņām modulī "{{campaigns_singular_module}}".

- Rediģējiet ieraksta laukus klikšķinot uz laukiem vai pogas Rediģēt.
- Apskatiet vai rediģējiet saites uz cietiem ierakstiem apakšpaneļos ieslēdzot datu skatu kreisajā apakšējā panelī.
- Veidojiet un apskaties lietotāju komentārus un ierakstu izmaiņu vēsturi darbību plūsmas panelī ieslēdzot darbību plūsmas skatu kreisajā apakšējā panelī.
- Sekojiet vai izceliet šo ierakstu izmantojot ikonas pa labi no ieraksta nosaukuma.
- Papildus darbības pieejamas izkrītošajā darbību izvēlnē pa labi no Rediģēšanas pogas.',
  'LBL_HELP_RECORDS' => 'Modulis "{{module_name}}" satur sarakstus ar personām vai uzņēmumiem, kurus jūs vēlaties iekļaut vai izslēgt no mārketinga epasta kampaņām modulī "{{campaigns_singular_module}}". {{plural_module_name}} var saturēt jebkādu skaitu un jebkurā kombinācijā mērķus, kontaktpersonas, interesentus, lietotājus un uzņēmumus. Mērķus var sagrupēt pēc mērķu modulī iepriekš definētiem kritērijiem, tādiem kā vecuma grupa, atrašanās vietas vai iepirkšanās paradumiem. {{plural_module_name}} tiek izmantots masu e-pasta sūtījumos modulī  {{campaigns_module}} kur tas tiek arī nokonfigurēts.',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Interesenti',
  'LBL_LIST_DESCRIPTION' => 'Apraksts',
  'LBL_LIST_END_DATE' => 'Beigu datums',
  'LBL_LIST_ENTRIES' => 'Mērķu skaits sarakstā',
  'LBL_LIST_FORM_TITLE' => 'Mērķu saraksti',
  'LBL_LIST_PROSPECTLIST_NAME' => 'Nosaukums',
  'LBL_LIST_PROSPECT_LIST_NAME' => 'Mērķu saraksts',
  'LBL_LIST_TYPE' => 'Veids',
  'LBL_LIST_TYPE_LIST_NAME' => 'Veids',
  'LBL_LIST_TYPE_NO' => 'Veids',
  'LBL_MARKETING_ID' => 'Mārketinga Id',
  'LBL_MARKETING_MESSAGE' => 'E-pasta mārketinga vēstule',
  'LBL_MARKETING_NAME' => 'Mārketinga nosaukums',
  'LBL_MODIFIED' => 'Modificēja',
  'LBL_MODIFIED_BY' => 'Modificēja',
  'LBL_MODULE_ID' => 'Mērķu saraksts',
  'LBL_MODULE_NAME' => 'Mērķu saraksts',
  'LBL_MODULE_NAME_SINGULAR' => 'Mērķu saraksts',
  'LBL_MODULE_TITLE' => 'Mērķu saraksts',
  'LBL_MORE_DETAIL' => 'Vairāk informācijas',
  'LBL_NAME' => 'Nosaukums',
  'LBL_NEW_FORM_TITLE' => 'Jauns mērķu saraksts',
  'LBL_PROSPECTS_SUBPANEL_TITLE' => 'Mērķi',
  'LBL_PROSPECT_LISTS_SUBPANEL_TITLE' => 'Mērķu saraksti',
  'LBL_PROSPECT_LIST_NAME' => 'Mērķu saraksts',
  'LBL_SEARCH_FORM_TITLE' => 'Mērķu sarakstu meklēšana',
  'LBL_TEAM' => 'Darba grupa',
  'LBL_TYPE' => 'Veids',
  'LBL_USERS_SUBPANEL_TITLE' => 'Lietotāji',
  'LNK_CAMPAIGN_LIST' => 'Kampaņas',
  'LNK_NEW_CAMPAIGN' => 'Izveidot kampaņu',
  'LNK_NEW_PROSPECT' => 'Izveidot mērķi',
  'LNK_NEW_PROSPECT_LIST' => 'Izveidot mērķu sarakstu',
  'LNK_PROSPECT_LIST' => 'Mērķi',
  'LNK_PROSPECT_LIST_LIST' => 'Mērķu saraksti',
);

