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
  'ERR_DELETE_RECORD' => 'Pro vymazání zaměstnance musíte specifikovat číslo záznamu.',
  'ERR_REMOVING_ATTACHMENT' => 'Chyba při odstraňování přílohy...',
  'LBL_ACCOUNT_ID' => 'ID společnosti:',
  'LBL_ACTIVITIES_REPORTS' => 'Reporty aktivit',
  'LBL_CASE_ID' => 'ID případu:',
  'LBL_CLOSE' => 'Uzavřen:',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'ID kontaktu:',
  'LBL_CONTACT_NAME' => 'Kontakt:',
  'LBL_CREATED_BY' => 'Vytvořeno',
  'LBL_DATE_ENTERED' => 'Datum vytvoření',
  'LBL_DATE_MODIFIED' => 'Datum poslední úpravy',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Poznámky',
  'LBL_DELETED' => 'Odstranit',
  'LBL_DESCRIPTION' => 'Popis',
  'LBL_EDITLAYOUT' => 'Úprava rozvržení',
  'LBL_EMAIL_ADDRESS' => 'Emailová adresa:',
  'LBL_EMAIL_ATTACHMENT' => 'Příloha emailu',
  'LBL_EMBED_FLAG' => 'Vložit do emailu?',
  'LBL_EXPORT_PARENT_ID' => 'Týkající se ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Týkající se modulu',
  'LBL_FILENAME' => 'Příloha:',
  'LBL_FILE_MIME_TYPE' => 'MIME typ',
  'LBL_FILE_URL' => 'URL souboru',
  'LBL_FIRST_NAME' => 'Jméno:',
  'LBL_HELP_CREATE' => 'K vytvoření poznámky:
1. Vyplňte hodnoty do polí dle potřeby.
 - Pole označená jako "požadovaná" musí být vyplněna před uložením.
 - Případně klikněte na "Zobrazit více" pro odhalení dalších polí.
2. Klikněte na "Uložit" k dokončení nového záznamu a návratu na předchozí stránku.
 - Vyberte "Uložit a zobrazit" k otevření nové poznámky v pohledu na záznam.
 - Vyberte "Uložit a vytvořit novou" k bezprostřednímu vytvoření další nové poznámky.',
  'LBL_HELP_RECORD' => 'Modul Poznámky obsahuje jednotlivé poznámky, které obsahují text nebo přílohu vztahující se k souvisejícímu záznamu.

- Upravte pole tohoto záznamu kliknutím na jednotlivá pole nebo na tlačítko Upravit.
- Zobrazte nebo upravte vazby na ostatní záznamy v subpanelech přepnutím levého spodního panelu na "Datový pohled".
- Vytvořte a zobrazte uživatelské komentáře a historii změn záznamu v modulu {{activitystream_singular_module}} přepnutím spodního levého panelu na "Tok aktivit" .
- Sledujte nebo označte záznam jako oblíbený pomocí ikon vpravo od názvu záznamu.
- Další akce jsou dostupné v rozbalovacím menu Akce vpravo od tlačítka Upravit.',
  'LBL_HELP_RECORDS' => 'Modul Poznámky obsahuje jednotlivé poznámky, které obsahují text nebo přílohu vztahující se k souvisejícímu záznamu. Záznamy poznámky mohou být navázány na jeden záznam ve většině modulů prostřednictvím pole flexibilní vazby a může být také navázáno na jeden kontakt. Poznámky mohou obsahovat generický text o záznamu nebo dokonce přílohu související se záznamem. Jsou různé způsoby, jak můžete vytvořit poznámky v Sugaru, jako pomocí modulu Poznámky, importem poznámek, prostřednictvím subpanelu Historie atd. Jakmile je záznam vytvořen, můžete zobrazit a upravit informace vztahující se k poznámkám prostřednictvím pohledu Record View. Každý záznam poznámky může poté souviset k dalším záznamům Sugaru jako například společnostem, kontaktům, obchodům a mnoha dalším.',
  'LBL_LAST_NAME' => 'Příjmení:',
  'LBL_LEAD_ID' => 'ID příležitosti:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Zodpovědný uživatel',
  'LBL_LIST_CONTACT' => 'Kontakt',
  'LBL_LIST_CONTACT_NAME' => 'Kontakt',
  'LBL_LIST_DATE_MODIFIED' => 'Poslední úprava',
  'LBL_LIST_EDIT_BUTTON' => 'Upravit',
  'LBL_LIST_FILENAME' => 'Příloha',
  'LBL_LIST_FORM_TITLE' => 'Seznam poznámek',
  'LBL_LIST_RELATED_TO' => 'Vztahuje se k',
  'LBL_LIST_STATUS' => 'Stav',
  'LBL_LIST_SUBJECT' => 'Předmět',
  'LBL_MEMBER_OF' => 'Člen:',
  'LBL_MODIFIED_BY' => 'Upravil',
  'LBL_MODULE_NAME' => 'Poznámky',
  'LBL_MODULE_NAME_SINGULAR' => 'Poznámka',
  'LBL_MODULE_TITLE' => 'Poznámky',
  'LBL_MY_NOTES_DASHLETNAME' => 'Mé poznámky',
  'LBL_NEW_FORM_BTN' => 'Přidat poznámku',
  'LBL_NEW_FORM_TITLE' => 'Přidat poznámku nebo přílohu',
  'LBL_NOTE' => 'Poznámka:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Přílohy',
  'LBL_NOTE_INFORMATION' => 'Přehled poznámky',
  'LBL_NOTE_STATUS' => 'Poznámky',
  'LBL_NOTE_SUBJECT' => 'Předmět poznámky:',
  'LBL_OC_FILE_NOTICE' => 'Prosím přihlašte se k serveru pro zobrazní souboru',
  'LBL_OPPORTUNITY_ID' => 'ID obchodu:',
  'LBL_PANEL_DETAILS' => 'Podrobnosti',
  'LBL_PARENT_ID' => 'Rodičovské ID:',
  'LBL_PARENT_TYPE' => 'Rodičovský typ',
  'LBL_PHONE' => 'Telefon',
  'LBL_PORTAL_FLAG' => 'Zobrazit v portálu?',
  'LBL_PRODUCT_ID' => 'ID produktu:',
  'LBL_QUOTE_ID' => 'ID nabídky:',
  'LBL_RELATED_TO' => 'Vztahuje se k:',
  'LBL_REMOVING_ATTACHMENT' => 'Odstraňuji přílohu...',
  'LBL_REVENUELINEITEMS' => 'Řádky tržeb',
  'LBL_SEARCH_FORM_TITLE' => 'Vyhledat poznámku',
  'LBL_SEND_ANYWAYS' => 'Tento e-mail nemá žádný předmět. Přesto odeslat/uložit?',
  'LBL_STATUS' => 'Stav',
  'LBL_SUBJECT' => 'Předmět:',
  'LNK_IMPORT_NOTES' => 'Importovat poznámky',
  'LNK_NEW_NOTE' => 'Přidat poznámku nebo přílohu',
  'LNK_NOTE_LIST' => 'Poznámky',
);

