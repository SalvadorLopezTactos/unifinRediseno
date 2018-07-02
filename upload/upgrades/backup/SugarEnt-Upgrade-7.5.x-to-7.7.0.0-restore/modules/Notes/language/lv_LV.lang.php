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
  'ERR_DELETE_RECORD' => 'Jums ir jānorāda ieraksta numuru, lai dzēstu uzņēmumu.',
  'ERR_REMOVING_ATTACHMENT' => 'Neizdevās noņemt pielikumu...',
  'LBL_ACCOUNT_ID' => 'Uzņēmuma ID:',
  'LBL_ACTIVITIES_REPORTS' => 'Darbību atskaite',
  'LBL_CASE_ID' => 'Pieteikuma ID:',
  'LBL_CLOSE' => 'Aizvērt:',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'Kontakta ID:',
  'LBL_CONTACT_NAME' => 'Kontakts:',
  'LBL_CREATED_BY' => 'Izveidoja',
  'LBL_DATE_ENTERED' => 'Izveidots',
  'LBL_DATE_MODIFIED' => 'Modificēts',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Piezīmes',
  'LBL_DELETED' => 'Dzēsts',
  'LBL_DESCRIPTION' => 'Piezīme',
  'LBL_EDITLAYOUT' => 'Rediģēt izkārtojumu',
  'LBL_EMAIL_ADDRESS' => 'E-pasts:',
  'LBL_EMAIL_ATTACHMENT' => 'E-pasta pielikums',
  'LBL_EMBED_FLAG' => 'Iekļaut e-pastā?',
  'LBL_EXPORT_PARENT_ID' => 'Attiecas uz ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Attiecas uz moduli',
  'LBL_FILENAME' => 'Pielikums:',
  'LBL_FILE_MIME_TYPE' => 'Mime veids',
  'LBL_FILE_URL' => 'Faila URL',
  'LBL_FIRST_NAME' => 'Vārds',
  'LBL_HELP_CREATE' => 'Lai izveidotu piezīmi:
1. Ievadiet atbilstošos laukos prasītās vērtības.
 - Lauki saglabātu ierakstu ir jāaizpilda lauki kas atzīmēti kā obligāti.
 - Ja nepieciešams redzēt papildus laukus spiediet uz "Rādīt vairāk".
2. Spiediet "Saglabāt" lai pabeigtu jauna ierakst veidošanu un atgrieztos iepriekšējā lapā.
 - Izvēlieties "Saglabāt un apskatīt" lai atvērtu jauno kļūdu ierakstu skata logā.
 - Izvēlieties "Saglabāt un veidot jaunu" lai uzreiz izveidotu vēl vienu jaunu kļūdas pieteikumu.',
  'LBL_HELP_RECORD' => '{{plural_module_name}} modulis satur atsevišķas {{plural_module_name}}s, kas satur tekstu vai ar ierakstu saistītu pielikumu.

- Rediģējiet ieraksta laukus klikšķinot uz laukiem vai pogas Rediģēt.
- Apskatiet vai rediģējiet saites uz cietiem ierakstiem apakšpaneļos ieslēdzot datu skatu kreisajā apakšējā panelī.
- Veidojiet un apskaties lietotāju komentārus un ierakstu izmaiņu vēsturi darbību plūsmas panelī ieslēdzot darbību plūsmas skatu kreisajā apakšējā panelī.
- Sekojiet vai izceliet šo ierakstu izmantojot ikonas pa labi no ieraksta nosaukuma.
- Papildus darbības pieejamas izkrītošajā darbību izvēlnē pa labi no Rediģēšanas pogas.',
  'LBL_HELP_RECORDS' => 'Modulis {{plural_module_name}} satur individuālas {{plural_module_name}}, kurās ir teksts vai pielikums ka papildina piezīmi. {{module_name}}s ieraksti var tik pakārtoti vienam ierakstam vairumā moduļu caur dinamisko saites lauku  un vēl vienam kontaktpersonas ierakstam. {{plural_module_name}} var saturēt vispārīgu aprakstu par saistīto moduli vai pat ar ierakstu saistītu pielikumu. Ir daudz dažādu veidu kā izveidot {{plural_module_name}} Sugar, piemēram caru moduli {{plural_module_name}}, importējot {{plural_module_name}}, caur vēstures apakšpaneli, u.c. Kad piezīmes ieraksts ir izveidots, jūs variet to skatīt un rediģēt piezīmes informāciju zaur piezīmes ieraksta kartiņu. Katrs piezīmes ieraksts var tik pakārtot citam Sugar ierakstam piemēram {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, un daudziem citiem.',
  'LBL_LAST_NAME' => 'Uzvārds',
  'LBL_LEAD_ID' => 'Interesenta ID:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Piešķirts lietotājam',
  'LBL_LIST_CONTACT' => 'Kontakts',
  'LBL_LIST_CONTACT_NAME' => 'Kontakts',
  'LBL_LIST_DATE_MODIFIED' => 'Modificēts',
  'LBL_LIST_EDIT_BUTTON' => 'Rediģēt',
  'LBL_LIST_FILENAME' => 'Pielikums',
  'LBL_LIST_FORM_TITLE' => 'Piezīmju saraksts',
  'LBL_LIST_RELATED_TO' => 'Atteicas uz',
  'LBL_LIST_STATUS' => 'Statuss',
  'LBL_LIST_SUBJECT' => 'Temats',
  'LBL_MEMBER_OF' => 'Pieder:',
  'LBL_MODIFIED_BY' => 'Rediģēja',
  'LBL_MODULE_NAME' => 'Piezīmes',
  'LBL_MODULE_NAME_SINGULAR' => 'Piezīme',
  'LBL_MODULE_TITLE' => 'Piezīmes',
  'LBL_MY_NOTES_DASHLETNAME' => 'Manas piezīmes',
  'LBL_NEW_FORM_BTN' => 'Pievienot piezīmi',
  'LBL_NEW_FORM_TITLE' => 'Izveidot piezīmi vai pielikumu',
  'LBL_NOTE' => 'Piezīme:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Pielikumi',
  'LBL_NOTE_INFORMATION' => 'Pārskats',
  'LBL_NOTE_STATUS' => 'Piezīme',
  'LBL_NOTE_SUBJECT' => 'Temats:',
  'LBL_OC_FILE_NOTICE' => 'Lūdzu piesakieties serverī, lai apskatītu failu',
  'LBL_OPPORTUNITY_ID' => 'Darījuma ID:',
  'LBL_PANEL_DETAILS' => 'Detaļas',
  'LBL_PARENT_ID' => 'Vecāka ID:',
  'LBL_PARENT_TYPE' => 'Vecāka veids',
  'LBL_PHONE' => 'Tālrunis:',
  'LBL_PORTAL_FLAG' => 'Parādīt portālā?',
  'LBL_PRODUCT_ID' => 'Produkta ID:',
  'LBL_QUOTE_ID' => 'Piedāvājuma ID:',
  'LBL_RELATED_TO' => 'Saistīts ar:',
  'LBL_REMOVING_ATTACHMENT' => 'Noņemu pielikumu...',
  'LBL_REVENUELINEITEMS' => 'Ieņēmumu posteņi',
  'LBL_SEARCH_FORM_TITLE' => 'Piezīmju meklēšana',
  'LBL_SEND_ANYWAYS' => 'E-pastam nav temata. Vai sūtīt/saglabāt tādu?',
  'LBL_STATUS' => 'Statuss',
  'LBL_SUBJECT' => 'Temats:',
  'LNK_IMPORT_NOTES' => 'Importēt piezīmes',
  'LNK_NEW_NOTE' => 'Izveidot piezīmi vai pielikumu',
  'LNK_NOTE_LIST' => 'Piezīmes',
);

