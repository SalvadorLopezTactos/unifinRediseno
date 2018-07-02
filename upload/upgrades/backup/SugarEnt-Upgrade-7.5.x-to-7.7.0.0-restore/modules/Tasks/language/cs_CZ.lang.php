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
  'DATE_FORMAT' => '(rrrr-mm-dd)',
  'ERR_DELETE_RECORD' => 'Pro smazání kontaktu musí být zadáno číslo záznamu.',
  'ERR_INVALID_HOUR' => 'Prosím zadejte hodinu mezi 0 a 24',
  'LBL_ACTIVITIES_REPORTS' => 'Report aktivit',
  'LBL_ASSIGNED_TO_NAME' => 'Přiřazeno (komu):',
  'LBL_ASSIGNED_USER' => 'Přiřazeno komu',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Kontakt:',
  'LBL_CONTACT_FIRST_NAME' => 'Křestní jméno',
  'LBL_CONTACT_ID' => 'ID kontaktu:',
  'LBL_CONTACT_LAST_NAME' => 'Příjmení',
  'LBL_CONTACT_NAME' => 'Kontaktní jméno:',
  'LBL_CONTACT_PHONE' => 'kontaktní telefon:',
  'LBL_DATE_DUE' => 'Datum splnění',
  'LBL_DATE_DUE_FLAG' => 'Nepřesné datum',
  'LBL_DATE_START_FLAG' => 'Nezahájené datum',
  'LBL_DEFAULT_PRIORITY' => 'Střední',
  'LBL_DESCRIPTION' => 'Popis:',
  'LBL_DESCRIPTION_INFORMATION' => 'Popis',
  'LBL_DUE_DATE' => 'Udělat do dne:',
  'LBL_DUE_DATE_AND_TIME' => 'Dokončit do datum a čas:',
  'LBL_DUE_TIME' => 'Udělat do (čas):',
  'LBL_EDITLAYOUT' => 'Úprava rozvržení',
  'LBL_EMAIL' => 'Email:',
  'LBL_EMAIL_ADDRESS' => 'Emailová adresa:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID přiřazeného uživatele',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Přiřazený uživatel',
  'LBL_EXPORT_CREATED_BY' => 'Vytvořeno podle ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Upraveno podle ID',
  'LBL_EXPORT_PARENT_ID' => 'Týkající se ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Týkající se modulu',
  'LBL_HELP_CREATE' => 'Modul Úkoly se skládá z flexibilních akcí, to-do položek, nebo jiného druhu činnosti, která vyžaduje dokončení. Chceteli vytvořit Úkol: 1. Vyplňte hodnoty polí dle potřeby. - Pole oznařená “Povinné” musejí být vyplněné před uložením. - Pokud bude potřeba, klikněte na “Zobrazit více” pro zobrazení dalších polí. 2. Klikněte na tlačítko “Uložit” pro dokončení nového záznamu a navrácení na předchozí stránku. - Zvolte “Uložit a zobrazit” pro otevření přehledu nově vytvořeného Úkolu. - Zvolte “Uložit a vytvořit nový” v případě, že chcete pokračovat vytvářením dalšího Úkolu.',
  'LBL_HELP_RECORD' => 'Modul Úkoly se skládá z flexibilních akcí, to-do položek, nebo jiného druhu činnosti, která vyžaduje dokončení. Upravte pole tohoto záznamu klepnutím na jednotlivé pole nebo na tlačítko Upravit. - Zobrazte nebo upravte odkazy na jiné záznamy v subpanelech, včetně příjemců Kampaně, přepnutím spodního levého podokna na “Zobrazení dat” - Vytvořte a zobrazte uživatelské komentáře a historii změn v modulu Aktivity přepnutím spodního levého podokna na “Aktivity”. - Sledujte záznam nebo si ho přidejte do oblíbených pomocí tlačítek vpravo od názvu záznamu. - Další akce jsou k dispozici v rozbalovací nabídce vpravo od tlačítka Upravit.',
  'LBL_HELP_RECORDS' => 'Modul Úkoly se skládá z flexibilních akcí, to-do položek, nebo jiného druhu činnosti, která vyžaduje dokončení. Záznamy modulu Úkoly mohou být navázány na jeden záznam z většiny modulů pomocí flex relačního pole a také mohou být navázány na jednen Kontakt. Existují různé způsoby, jak vytvořit Úkol v Sugar, např. pomocí modulu Úkoly, duplikací, importem Úkolů atp. Po vytvoření Úkolu můžete informace o něm zobrazovat a měnit z přehledu záznamu. V závslosti na podrobnostech Úkolu můžete také být schopni zobrazovat a měnit informace o záznamu prostřednictvím modulu Kalendář. Každý záznam v modulu Úkoly pak může být navázán na další záznamy v Sugar, jako jsou Společnosti, Kontakty, Obchody a mnoho dalších.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Poznámky',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Zodpovědný uživatel',
  'LBL_LIST_CLOSE' => 'Zavřít',
  'LBL_LIST_COMPLETE' => 'Dokončeno:',
  'LBL_LIST_CONTACT' => 'Kontakt',
  'LBL_LIST_DATE_MODIFIED' => 'Datum úprav',
  'LBL_LIST_DUE_DATE' => 'Do data',
  'LBL_LIST_DUE_TIME' => 'Termín (čas)',
  'LBL_LIST_FORM_TITLE' => 'Seznam úkolů',
  'LBL_LIST_MY_TASKS' => 'Moje otevřené úkoly',
  'LBL_LIST_PRIORITY' => 'Priorita',
  'LBL_LIST_RELATED_TO' => 'Týka se',
  'LBL_LIST_START_DATE' => 'Počáteční datum',
  'LBL_LIST_START_TIME' => 'Počáteční čas',
  'LBL_LIST_STATUS' => 'Stav',
  'LBL_LIST_SUBJECT' => 'Předmět',
  'LBL_MODULE_NAME' => 'Úkoly',
  'LBL_MODULE_NAME_SINGULAR' => 'Úkol',
  'LBL_MODULE_TITLE' => 'Úkoly',
  'LBL_NAME' => 'Název:',
  'LBL_NEW_FORM_DUE_DATE' => 'Udělat do dne:',
  'LBL_NEW_FORM_DUE_TIME' => 'Udělat do (čas):',
  'LBL_NEW_FORM_SUBJECT' => 'Předmět:',
  'LBL_NEW_FORM_TITLE' => 'Přidat úkol',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Žádný',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Poznámky',
  'LBL_PARENT_ID' => 'ID zdrojové:',
  'LBL_PARENT_NAME' => 'Typ zdroje:',
  'LBL_PHONE' => 'Telefon',
  'LBL_PRIORITY' => 'Priorita:',
  'LBL_REVENUELINEITEMS' => 'Řádky obchodu',
  'LBL_SEARCH_FORM_TITLE' => 'Vyhledat úkol',
  'LBL_START_DATE' => 'Počáteční datum:',
  'LBL_START_DATE_AND_TIME' => 'Počáteční datum & čas:',
  'LBL_START_TIME' => 'Počátenčí čas:',
  'LBL_STATUS' => 'Stav:',
  'LBL_SUBJECT' => 'Předmět:',
  'LBL_TASK' => 'Úkoly:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Úkol úspěšně uzavřen',
  'LBL_TASK_INFORMATION' => 'Přehled úkolu',
  'LNK_IMPORT_TASKS' => 'Importuj úkoly',
  'LNK_NEW_TASK' => 'Přidat úkol',
  'LNK_TASK_LIST' => 'Úkoly',
);

