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
  'DATE_FORMAT' => '(gggg-mm-dd)',
  'ERR_DELETE_RECORD' => 'Morate navesti broj zapisa da bi obrisali kontakt.',
  'ERR_INVALID_HOUR' => 'Molim, unesite sat između 0 i 24',
  'LBL_ACTIVITIES_REPORTS' => 'Izveštaj o Aktivnostima',
  'LBL_ASSIGNED_TO_NAME' => 'Dodeljeno',
  'LBL_ASSIGNED_USER' => 'Dodeljeno',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Kontakt',
  'LBL_CONTACT_FIRST_NAME' => 'Ime kontakta',
  'LBL_CONTACT_ID' => 'ID broj kontakta:',
  'LBL_CONTACT_LAST_NAME' => 'Prezime kontakta',
  'LBL_CONTACT_NAME' => 'Ime kontakta:',
  'LBL_CONTACT_PHONE' => 'Telefon kontakta:',
  'LBL_DATE_DUE' => 'Datum zaduživanja',
  'LBL_DATE_DUE_FLAG' => 'Nema datuma završetka',
  'LBL_DATE_START_FLAG' => 'Nema datuma početka',
  'LBL_DEFAULT_PRIORITY' => 'Srednje',
  'LBL_DESCRIPTION' => 'Opis:',
  'LBL_DESCRIPTION_INFORMATION' => 'Opisne informacije',
  'LBL_DUE_DATE' => 'Datum završetka:',
  'LBL_DUE_DATE_AND_TIME' => 'Datum i vreme završetka:',
  'LBL_DUE_TIME' => 'Vreme završetka:',
  'LBL_EDITLAYOUT' => 'Izmeni raspored',
  'LBL_EMAIL' => 'Email adresa:',
  'LBL_EMAIL_ADDRESS' => 'Email adresa:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID broj dodeljenog korisnika',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Ime dodeljenog korisnika',
  'LBL_EXPORT_CREATED_BY' => 'ID broj osobe koja je kreirala',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'ID korisnika koji je promenio',
  'LBL_EXPORT_PARENT_ID' => 'Povezano sa ID-jem',
  'LBL_EXPORT_PARENT_TYPE' => 'Povezano sa Modulom',
  'LBL_HELP_CREATE' => '{{plural_module_name}} modul se sastoji od fleksibilnih akcija, za-uraditi stavki, ili od drugih tipova aktivnosti koji zahtevaju kompletiranje. Da bi  {{module_name}} bio kreiran: 1. Obezbediti vrednost za polja po želji. - Polja označena kao "Obavezna" moraju biti uneta pre čuvanja podataka. - Klik na "Pokaži više" za prikaz dodatnih polja ako je potrebno. 2. Klik na "Sačuvaj" da dovršimo novi zapis i povratak na predhodnu stranu. - Izaberi "Sačuvaj i pregledaj" za otvaranje novog {{module_name}} u pogledu zapisa. - Izaberi "Sačuvaj i kreiraj novi" za momentalno kreiranje novog {{module_name}}.',
  'LBL_HELP_RECORD' => '{{plural_module_name}} modul se sastoji od fleksibilnih akcija, za-uraditi stavki, ili od drugih tipova aktivnosti koji zahtevaju kompletiranje. - Izmena polja ovog zapisa klikom na pojedinačno polje ili pritiskom na dugme Izmena. - Pregled ili izmena linkova ka drugim zapisima u podformama, uključujući {{campaigns_singular_module}} korisnike, prebacivanjem donjeg levog okvira na "Pregled Podataka". - Kreiraj i pregledaj korisničke komentare i snimi istoriju izmena u {{activitystream_singular_module}} prebacivanjem donjeg levog okvira na "Tok Aktivnosti". - Prati ili favorizuj ovaj zapis koristeći ikone desno od imena zapisa. - Dodatne akcije su dostupne u padajućem Akcija meniju desno od dugmeta Izmena.',
  'LBL_HELP_RECORDS' => '{{plural_module_name}} modul se sastoji od fleksibilnih akcija, za-uraditi stavki, ili od drugih tipova aktivnosti koji zahteva kompletiranje. {{module_name}} zapisi mogu biti vezani za jedan zapis u većini modula preko flex polja za vezu i može biti vezan za jedan {{contacts_singular_module}}. Postoji nekoliko načina da se kreira {{plural_module_name}} u Sugar-u kao što su preko {{plural_module_name}} modula, dupliranjem, uvozom {{plural_module_name}}, itd. Jednom kada je {{module_name}} zapis kreiran, moguć je pregled i izmena podataka koji se tiču {{module_name}} preko {{plural_module_name}} pregleda zapisa. Zavisno od detalja na {{module_name}}, moguć je pregled i izmena {{module_name}} informacija preko Kalendar modula. Svaki {{module_name}} zapis onda može da ukazuje na zapis Sugar-a kao što su {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, i mnogi drugi.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Beleške',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Dodeljeni korisnik',
  'LBL_LIST_CLOSE' => 'Zatvori',
  'LBL_LIST_COMPLETE' => 'Završi:',
  'LBL_LIST_CONTACT' => 'Kontakt',
  'LBL_LIST_DATE_MODIFIED' => 'Datum izmene',
  'LBL_LIST_DUE_DATE' => 'Datum završetka',
  'LBL_LIST_DUE_TIME' => 'Vreme završetka',
  'LBL_LIST_FORM_TITLE' => 'Lista zadataka',
  'LBL_LIST_MY_TASKS' => 'Moji aktuelni zadaci',
  'LBL_LIST_PRIORITY' => 'Prioritet',
  'LBL_LIST_RELATED_TO' => 'Povezano sa',
  'LBL_LIST_START_DATE' => 'Datum početka:',
  'LBL_LIST_START_TIME' => 'Vreme početka',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Naslov',
  'LBL_MODULE_NAME' => 'Zadaci',
  'LBL_MODULE_NAME_SINGULAR' => 'Zadatak',
  'LBL_MODULE_TITLE' => 'Zadaci: Početna strana',
  'LBL_NAME' => 'Naslov:',
  'LBL_NEW_FORM_DUE_DATE' => 'Datum završetka:',
  'LBL_NEW_FORM_DUE_TIME' => 'Vreme završetka:',
  'LBL_NEW_FORM_SUBJECT' => 'Naslov:',
  'LBL_NEW_FORM_TITLE' => 'Kreiraj zadatak',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Nijedna',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Beleške',
  'LBL_PARENT_ID' => 'Matični ID broj:',
  'LBL_PARENT_NAME' => 'Matični tip:',
  'LBL_PHONE' => 'Telefon:',
  'LBL_PRIORITY' => 'Prioritet:',
  'LBL_REVENUELINEITEMS' => 'Stavke prihoda',
  'LBL_SEARCH_FORM_TITLE' => 'Pretraga zadataka',
  'LBL_START_DATE' => 'Datum početka:',
  'LBL_START_DATE_AND_TIME' => 'Datum i vreme početka:',
  'LBL_START_TIME' => 'Vreme početka:',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Naslov:',
  'LBL_TASK' => 'Zadaci:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Zadatak uspešno zatvoren.',
  'LBL_TASK_INFORMATION' => 'Pregled zadatka',
  'LNK_IMPORT_TASKS' => 'Uvezi zadatke',
  'LNK_NEW_TASK' => 'Kreiraj zadatak',
  'LNK_TASK_LIST' => 'Pregledaj zadatke',
);

