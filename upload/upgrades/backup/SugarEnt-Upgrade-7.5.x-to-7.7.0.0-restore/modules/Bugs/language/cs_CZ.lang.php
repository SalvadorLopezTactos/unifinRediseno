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
  'ERR_DELETE_RECORD' => 'Pro odstranění chyby musíte specifikovat číslo záznamu.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Společnosti',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivity',
  'LBL_ASSIGNED_TO_NAME' => 'Přiřazeno (komu)',
  'LBL_BUG' => 'Chyba:',
  'LBL_BUG_INFORMATION' => 'Přehled chyb',
  'LBL_BUG_NUMBER' => 'Číslo chyby:',
  'LBL_BUG_SUBJECT' => 'Chyba předmětu:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Případy',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakty',
  'LBL_CONTACT_BUG_TITLE' => 'Kontakt-chyba:',
  'LBL_CONTACT_NAME' => 'Jméno kontaktu:',
  'LBL_CONTACT_ROLE' => 'Role:',
  'LBL_CREATED_BY' => 'Vytvořil:',
  'LBL_DATE_CREATED' => 'Vytvořeno, datum:',
  'LBL_DATE_LAST_MODIFIED' => 'Datum úpravy:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Sledování chyb',
  'LBL_DESCRIPTION' => 'Popis:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumenty',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Přiřazený uživatel ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Přiřazený uživatel',
  'LBL_EXPORT_CREATED_BY' => 'Vytvořeno podle ID',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Opraveno ve verzi',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Upraveno podle ID',
  'LBL_FIXED_IN_RELEASE' => 'Opraveno ve verzi:',
  'LBL_FOUND_IN_RELEASE' => 'Nalezeno ve verzi:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Nalezeno v',
  'LBL_HELP_CREATE' => 'Modul Chyby se používá ke sledování a správě problémů souvisejících s produktem, obecně nazývaných Chyby nebo Nedostatky, jak nalezených interně nebo nahlášených klienty.

K zaznamenání chyby:
1. Zadejte dle potřeby hodnoty do polí.
- Pole označená jako povinná musejí být vyplněna před uložením.
- Klikněte na tlačítko Zobrazit více pro odhalení dalších polí, pokud je potřeba.
2. Klikněte “Uložit” k dokončení nového záznamu a návrat na předchozí stránku.
- Vyberte “Uložit a zobrazit” k otevření nové chyby v detailním okně.
- Vyberte “Uložit a vytvořit novou” k bezprostřednímu vytvoření další nové chyby.',
  'LBL_HELP_RECORD' => 'Modul Chyby se používá ke sledování a správě problémů souvisejících s produktem, obecně zmiňovaný jako chyby, jak nalezené interně nebo nahlášené zákazníky.

- Upravte pole tohoto záznamu kliknutím na jednotlivé pole nebo tlačítko Upravit.
- Zobrazte nebo změňte vazby na ostatní záznamy v podřízených panelech přepnutím spodního pole na Data..
- Vytvořte a prohlédněte si uživatelské komentáře a historii změn záznamu v modulu {{activitystream_singular_module}} přepnutím spodního levého pole na Tok aktivity.
- Sledujte nebo označte tento záznam jako oblíbený pomocí ikon vpravo od názvu záznamu.
- Další akce jsou dostupné ve výběrovém menu Akce vpavo od talčítka Upravit.',
  'LBL_HELP_RECORDS' => 'Modul Chyby se používá ke sledování a správě problémů souvisejících s produktem, obecně zmiňovaný jako chyby, jak nalezené interně nebo nahlášené zákazníky. Chyby mohou být dále vybrány sledováním vydání, ve kterém byly nalezeny a opraveny. Modul Chyby dává uživatelům způsob, jak rychle prohlédnout všechny detaily chyby a proces, použitý k opravě. Jakmile je chyba vytvořena a uložena, můžete si prohlédnout a upravit informace příslušející k chybě promocí pohledu na záznam chyby. Každý záznam chyby může souviset s jinými záznamy Sugaru, jako například {{calls_module}}, {{contacts_module}}, {{cases_module}}, a mnohé další.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historie',
  'LBL_INVITEE' => 'Kontakty',
  'LBL_LIST_ACCOUNT_NAME' => 'Název společnosti',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Zodpovědný uživatel',
  'LBL_LIST_CONTACT_NAME' => 'Název kontaktu',
  'LBL_LIST_EMAIL_ADDRESS' => 'Emailová adresa',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Opraveno ve verzi',
  'LBL_LIST_FORM_TITLE' => 'Seznam chyb',
  'LBL_LIST_LAST_MODIFIED' => 'Poslední úprava',
  'LBL_LIST_MY_BUGS' => 'Moje přidělené chyby',
  'LBL_LIST_NUMBER' => 'Číslo',
  'LBL_LIST_PHONE' => 'Telefon',
  'LBL_LIST_PRIORITY' => 'Priorita',
  'LBL_LIST_RELEASE' => 'Nová verze',
  'LBL_LIST_RESOLUTION' => 'Výsledek',
  'LBL_LIST_STATUS' => 'Stav',
  'LBL_LIST_SUBJECT' => 'Předmět',
  'LBL_LIST_TYPE' => 'Typ',
  'LBL_MODIFIED_BY' => 'Naposled upravil:',
  'LBL_MODULE_ID' => 'Chyby',
  'LBL_MODULE_NAME' => 'Chyby',
  'LBL_MODULE_NAME_SINGULAR' => 'Chyba:',
  'LBL_MODULE_TITLE' => 'Sledování chyb',
  'LBL_NEW_FORM_TITLE' => 'Nová chyba',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Poznámky',
  'LBL_NUMBER' => 'Číslo:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Pokud jste našli novou chybu, kterou byste chtěli nahlásit, můžete tak učinit kliknutím zde.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Můžete omezit seznam chyb zadáním podmínek hledání.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Můžete například použít toto k vyhledání chyby, která byla předtím nahlášena.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'Modul Chyby slouží k zobrazení a nahlašování chyb. Použijte šipky níže k projití rychlým průvodcem.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Tato stránka zobrazuje seznam nahlášených chyb.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Kliknutím zde se kdykoliv vrátíte do tohoto pohledu.',
  'LBL_PORTAL_VIEWABLE' => 'Portál aktivní',
  'LBL_PRIORITY' => 'Priorita:',
  'LBL_PRODUCT_CATEGORY' => 'Kategorie:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekty',
  'LBL_RELEASE' => 'Nová verze:',
  'LBL_RESOLUTION' => 'Výsledek:',
  'LBL_SEARCH_FORM_TITLE' => 'Hledat chyby',
  'LBL_SHOW_IN_PORTAL' => 'Zobrazit na portálu',
  'LBL_SHOW_MORE' => 'Zobrazit více chyb',
  'LBL_SOURCE' => 'Zdroj:',
  'LBL_STATUS' => 'Stav:',
  'LBL_SUBJECT' => 'Předmět:',
  'LBL_SYSTEM_ID' => 'ID systému',
  'LBL_TYPE' => 'Typ:',
  'LBL_WORK_LOG' => 'Pracovní protokol:',
  'LNK_BUG_LIST' => 'Chyby',
  'LNK_BUG_REPORTS' => 'Zobrazit report chyb',
  'LNK_CREATE' => 'Report chyb',
  'LNK_CREATE_WHEN_EMPTY' => 'Reportovat chyby',
  'LNK_IMPORT_BUGS' => 'Import chyb',
  'LNK_NEW_BUG' => 'Report chyb',
  'NTC_DELETE_CONFIRMATION' => 'Opravdu chcete odstranit tento kontakt z chyb?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Opravdu chcete vyjmout tuto chybu ze společnosti?',
  'NTC_REMOVE_INVITEE' => 'Opravdu chcete odstranit tento kontakt z chyb?',
);

