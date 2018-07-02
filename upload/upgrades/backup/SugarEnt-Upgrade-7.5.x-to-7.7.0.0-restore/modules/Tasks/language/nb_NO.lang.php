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
  'DATE_FORMAT' => '(åååå-mm-dd)',
  'ERR_DELETE_RECORD' => 'Du må oppgi et registreringsnummer for å slette denne kontakten.',
  'ERR_INVALID_HOUR' => 'Vennligst velg en time mellom 0 og 24.',
  'LBL_ACTIVITIES_REPORTS' => 'Aktivitets Rapport',
  'LBL_ASSIGNED_TO_NAME' => 'Tildelt:',
  'LBL_ASSIGNED_USER' => 'Tildelt til',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Kontakt:',
  'LBL_CONTACT_FIRST_NAME' => 'Kontaktens fornavn',
  'LBL_CONTACT_ID' => 'Kontakt- ID:',
  'LBL_CONTACT_LAST_NAME' => 'Kontaktens etternavn',
  'LBL_CONTACT_NAME' => 'Kontaktnavn:',
  'LBL_CONTACT_PHONE' => 'Kontakt telefon:',
  'LBL_DATE_DUE' => 'Frist Dato',
  'LBL_DATE_DUE_FLAG' => 'Ingen passende dato',
  'LBL_DATE_START_FLAG' => 'Ingen startdato',
  'LBL_DEFAULT_PRIORITY' => 'Medium',
  'LBL_DESCRIPTION' => 'Beskrivelse:',
  'LBL_DESCRIPTION_INFORMATION' => 'Beskrivelsesinformasjon',
  'LBL_DUE_DATE' => 'Passende dato:',
  'LBL_DUE_DATE_AND_TIME' => 'Passende dato & tid:',
  'LBL_DUE_TIME' => 'Passende tid:',
  'LBL_EDITLAYOUT' => 'Redigér Oppsett',
  'LBL_EMAIL' => 'E-postadresse:',
  'LBL_EMAIL_ADDRESS' => 'Email Adresse:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Tildelt Bruker-ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Tildelt Brukernavn',
  'LBL_EXPORT_CREATED_BY' => 'Opprettet Av ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Endret av ID',
  'LBL_EXPORT_PARENT_ID' => 'Relatert til ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Relatert til Modul',
  'LBL_HELP_CREATE' => '{{plural_module_name}} modul består av fleksible tiltak, gjøremål, eller annen type aktivitet som krever gjennomføring. For å opprette en {{module_name}}: 1. Gi verdier for feltene som ønsket. - Felt som er merket "kreves" må fullføres før du lagrer. - Klikk "Vis mer" for å avsløre flere felt hvis det er nødvendig. 2. Klikk "Lagre" for å sluttføre den nye registrering og gå tilbake til forrige side. - Velg "Lagre og vis" for å åpne den nye {{module_name}} i registreringsvisning. - Velg "Lagre og skape nye" til umiddelbart å opprette en ny {{module_name}}.',
  'LBL_HELP_RECORD' => '{{plural_module_name}} modulen består av fleksible tiltak, gjøremål, eller annen type aktivitet som krever gjennomføring. - Rediger denne postens felt ved å klikke på en enkelt felt eller Rediger-knappen. - Vis eller endre lenker til andre poster i underpaneler ved veksling av venstre rute nederst til "Data View". - Lag og vis brukerkommentarer og postendrings historie i {{activitystream_singular_module}} ved veksling av ruten nederst venstre til "Activity Stream". - Følg eller favoritt denne posten ved hjelp av ikonene til høyre for posten navn. - Ytterligere tiltak er tilgjengelig i dropdown Handlings menyen til høyre for Rediger-knappen.',
  'LBL_HELP_RECORDS' => '{{plural_module_name}} modulen består av fleksible tiltak, gjøremål, eller annen type aktivitet som krever gjennomføring. {{module_name}} registreringer kan være relatert til en registrering i de fleste moduler via flex-relatere felt, og kan også være relatert til en enkelt {{contacts_singular_module}}. Det finnes ulike måter du kan opprette {{plural_module_name}}  i Sugar eksempel via {{plural_module_name}} modul, duplisering, import {{plural_module_name} osv. Når {{module_name}} registrering er opprettet , kan du se på og redigere informasjon knyttet til {{module_name}} via {{plural_module_name}}  post visning. Avhengig av detaljene på {{module_name}}, kan du også være i stand til å se på og redigere {{module_name}} informasjon via kalendermodulen. Hver {{module_name}}  registrering kan da forholde seg til andre Sugar poster som {{accounts_module}},  {{contacts_module}}, {{opportunities_module}}, og mange andre.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Notater',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Tildelt bruker',
  'LBL_LIST_CLOSE' => 'Lukk',
  'LBL_LIST_COMPLETE' => 'Fullstendig:',
  'LBL_LIST_CONTACT' => 'Kontakt',
  'LBL_LIST_DATE_MODIFIED' => 'Dato for endring',
  'LBL_LIST_DUE_DATE' => 'Passende dato',
  'LBL_LIST_DUE_TIME' => 'Passende tid',
  'LBL_LIST_FORM_TITLE' => 'Oppgaveliste',
  'LBL_LIST_MY_TASKS' => 'Mine åpne oppgaver',
  'LBL_LIST_PRIORITY' => 'Prioritet',
  'LBL_LIST_RELATED_TO' => 'Relatert til',
  'LBL_LIST_START_DATE' => 'Startdato',
  'LBL_LIST_START_TIME' => 'Starttid',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Emne',
  'LBL_MODULE_NAME' => 'Oppgaver',
  'LBL_MODULE_NAME_SINGULAR' => 'Oppgave',
  'LBL_MODULE_TITLE' => 'Oppgaver: Hjem',
  'LBL_NAME' => 'Navn:',
  'LBL_NEW_FORM_DUE_DATE' => 'Passende dato:',
  'LBL_NEW_FORM_DUE_TIME' => 'Passende tid:',
  'LBL_NEW_FORM_SUBJECT' => 'Emne:',
  'LBL_NEW_FORM_TITLE' => 'Opprett oppgave',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Ingen',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notater',
  'LBL_PARENT_ID' => 'Overordnet- ID:',
  'LBL_PARENT_NAME' => 'Overordnet type:',
  'LBL_PHONE' => 'Telefonnummer:',
  'LBL_PRIORITY' => 'Prioritet',
  'LBL_REVENUELINEITEMS' => 'Omsetning linjeelementer',
  'LBL_SEARCH_FORM_TITLE' => 'Oppgavesøk',
  'LBL_START_DATE' => 'Startdato:',
  'LBL_START_DATE_AND_TIME' => 'Startdato & -tid:',
  'LBL_START_TIME' => 'Starttid:',
  'LBL_STATUS' => 'Emne:',
  'LBL_SUBJECT' => 'Emne',
  'LBL_TASK' => 'Oppgaver:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Oppgaven lukket med suksess.',
  'LBL_TASK_INFORMATION' => 'Oppgaveoversikt',
  'LNK_IMPORT_TASKS' => 'Importer oppgaver',
  'LNK_NEW_TASK' => 'Opprett oppgave',
  'LNK_TASK_LIST' => 'Oppgaver',
);

