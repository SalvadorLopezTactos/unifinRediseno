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
  'ERR_DELETE_RECORD' => 'Musíte zadat číslo záznamu pro smazání daného produktu.',
  'LBL_ACCOUNT_ID' => 'ID společnosti',
  'LBL_ACCOUNT_NAME' => 'Název společnosti:',
  'LBL_ASSET_NUMBER' => 'Inventární číslo:',
  'LBL_ASSIGNED_TO_NAME' => 'Přiřazeno komu:',
  'LBL_ASSIGNED_USER_ID' => 'ID přiřazeného uživatele',
  'LBL_ASSOCIATED_QUOTE' => 'Předmět nabídky:',
  'LBL_BOOK_VALUE' => 'Účetní hodnota:',
  'LBL_BOOK_VALUE_DATE' => 'Datum účetní hodnoty',
  'LBL_BOOK_VALUE_USDOLLAR' => 'Účetní hodnota (US Dollar):',
  'LBL_CALCULATED_LINE_ITEM_AMOUNT' => 'Počítaná částka řádku',
  'LBL_CAMPAIGN_PRODUCT' => 'Řádek kampaně',
  'LBL_CATEGORY' => 'Kategorie:',
  'LBL_CATEGORY_NAME' => 'Název kategorie:',
  'LBL_COMMIT_STAGE' => 'Závazek',
  'LBL_COMMIT_STAGE_FORECAST' => 'Předpověď',
  'LBL_CONTACT' => 'Kontakt',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakty',
  'LBL_CONTACT_ID' => 'ID kontaktu',
  'LBL_CONTACT_NAME' => 'Jméno kontaktu:',
  'LBL_CONTRACTS' => 'Kontrakty',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Kontrakty',
  'LBL_CONVERT_TO_QUOTE_ERROR' => 'Chyba:',
  'LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE' => 'Během tvorby nabídky z řádku se vyskytla chyba',
  'LBL_COST_PRICE' => 'Náklady:',
  'LBL_COST_USDOLLAR' => 'Cena (US Dollar)',
  'LBL_CREATED_USER' => 'Vytvořeno uživatelem',
  'LBL_CURRENCY' => 'Měna:',
  'LBL_CURRENCY_ID' => 'ID měny',
  'LBL_CURRENCY_RATE' => 'Kurz',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Jméno symbolu měny',
  'LBL_DATE_CLOSED' => 'Předpokládané datum uzavření:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Předpokládané datum a čas uzavření:',
  'LBL_DATE_PURCHASED' => 'Zakoupeno:',
  'LBL_DATE_SUPPORT_EXPIRES' => 'Podpora končí:',
  'LBL_DATE_SUPPORT_STARTS' => 'Podpora začíná:',
  'LBL_DEAL_TOT' => 'Sleva:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Produkty',
  'LBL_DESCRIPTION' => 'Popis:',
  'LBL_DISCOUNT_AMOUNT' => 'Výše slevy',
  'LBL_DISCOUNT_AS_PERCENT' => 'Sleva v %',
  'LBL_DISCOUNT_PRICE' => 'Cena za jednotku:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Datum slevy:',
  'LBL_DISCOUNT_RATE' => 'Slevová sazba',
  'LBL_DISCOUNT_RATE_USDOLLAR' => 'Slevová sazba (US Dollar)',
  'LBL_DISCOUNT_TOTAL' => 'Celkem sleva',
  'LBL_DISCOUNT_TOTAL_USDOLLAR' => 'Sleva (US Dollar)',
  'LBL_DISCOUNT_USDOLLAR' => 'Cena za jednotku (US Dollar)',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumenty',
  'LBL_EDITLAYOUT' => 'Úprava rozvržení',
  'LBL_EXPERT_ID' => 'Produktový expert',
  'LBL_EXPORT_CURRENCY_ID' => 'ID měny',
  'LBL_EXT_PRICE' => 'Rozšířená cena',
  'LBL_FORECAST' => 'Předpověď',
  'LBL_HELP_CREATE' => 'Modul Produkty obsahuje všechny produkty, které již byly prodány nebo jsou právě prodávány klientům.

K vytvoření produktu:
1. Zadejte dle potřeby hodnoty do polí.
 - Pole označená jako povinná musejí být vyplněna před uložením.
 - Klikněte na tlačítko Zobrazit více pro odhalení dalších polí, pokud je potřeba.
2. Klikněte “Uložit” k dokončení nového záznamu a návrat na předchozí stránku.
 - Vyberte “Uložit a zobrazit” k otevření nového produktu v detailním okně.
 - Vyberte “Uložit a vytvořit nový” k bezprostřednímu vytvoření dalšího nového produktu.',
  'LBL_HELP_RECORD' => 'Modul Produkty obsahuje všechny produkty, které již byly prodány nebo jsou právě prodávány klientům

- Upravte pole tohoto záznamu kliknutím na jednotlivé pole nebo tlačítko Upravit.
- Zobrazte nebo změňte vazby na ostatní záznamy v podřízených panelech přepnutím spodního pole na Data..
- Vytvořte a prohlédněte si uživatelské komentáře a historii změn záznamu v modulu {{activitystream_singular_module}} přepnutím spodního levého pole na Tok aktivity.
- Sledujte nebo označte tento záznam jako oblíbený pomocí ikon vpravo od názvu záznamu.
- Další akce jsou dostupné ve výběrovém menu Akce vpavo od talčítka Upravit.',
  'LBL_HELP_RECORDS' => 'Modul Produkty obsahuje všechny produkty, které již byly prodány nebo jsou právě prodávány klientům. Seznam produktů prodaných vaší společností je umístěn v Admin -> Katalog produktů a administrátoři mají možnost přidávat produkty dle potřeby. Když vytváříte produkty, máte možnost buďto vybrat produkty z katalogu neby vytvořit nové produkty prostřednictvím modulu Produkty. Existují různé způsoby, kterými můžete vytvořit produkty v Sugaru, jako například prostřednictvím modulu Produkty, modulu Nabídky, duplikací, importem produktů atd. Jakmile je produkt vytvořen, můžete zobrazit a upravit informace příslušející k produktu prostřednictvím detailního pohledu modulu Produkty',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Zájemci',
  'LBL_LEAD_SOURCE' => 'Zdroj',
  'LBL_LIST_ACCOUNT_NAME' => 'Název společnosti',
  'LBL_LIST_CONTACT_NAME' => 'Jméno kontaktu',
  'LBL_LIST_COST_PRICE' => 'Náklady',
  'LBL_LIST_DATE_PURCHASED' => 'Zakoupeno',
  'LBL_LIST_DISCOUNT_PRICE' => 'Cena',
  'LBL_LIST_FORM_TITLE' => 'Seznam produktů',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Výrobní číslo',
  'LBL_LIST_LIST_PRICE' => 'Seznam',
  'LBL_LIST_MANUFACTURER' => 'Výrobce',
  'LBL_LIST_NAME' => 'Produkt',
  'LBL_LIST_PRICE' => 'Poslední cena:',
  'LBL_LIST_QUANTITY' => 'Množství',
  'LBL_LIST_QUOTE_NAME' => 'Název kvóty',
  'LBL_LIST_STATUS' => 'Stav',
  'LBL_LIST_SUPPORT_EXPIRES' => 'Končí',
  'LBL_LIST_USDOLLAR' => 'Poslední cena (US Dollar)',
  'LBL_MANUFACTURER' => 'Výrobce:',
  'LBL_MANUFACTURER_NAME' => 'Jméno výrobce:',
  'LBL_MEMBER_OF' => 'Členem:',
  'LBL_MFT_PART_NUM' => 'Číslo dílu výrobce',
  'LBL_MODIFIED_USER' => 'Upraveno uživatelem',
  'LBL_MODULE_NAME' => 'Produkty',
  'LBL_MODULE_NAME_SINGULAR' => 'Produkt',
  'LBL_MODULE_TITLE' => 'Verze: Domů',
  'LBL_NAME' => 'Název',
  'LBL_NEW_FORM_TITLE' => 'Vytvořit produkt',
  'LBL_NEXT_STEP' => 'Další krok:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Poznámky',
  'LBL_OPPORTUNITY' => 'Obchod',
  'LBL_OPPORTUNITY_ID' => 'ID obchodu:',
  'LBL_PRICING_FACTOR' => 'Faktor cen',
  'LBL_PRICING_FORMULA' => 'Cenový vzorec:',
  'LBL_PROBABILITY' => 'Pravděpodobnost (%):',
  'LBL_PRODUCT' => 'Produkt:',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Produkty',
  'LBL_PRODUCT_CATEGORIES' => 'Kategorie produktů',
  'LBL_PRODUCT_TEMPLATE' => 'Produktová šablona:',
  'LBL_PRODUCT_TEMPLATE_ID' => 'ID produktové šablony:',
  'LBL_PRODUCT_TYPES' => 'Typy produktů',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekty',
  'LBL_QUANTITY' => 'Množství:',
  'LBL_QUOTE' => 'Kvóta',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Nabídky',
  'LBL_QUOTE_ID' => 'ID kvóty',
  'LBL_QUOTE_NAME' => 'Jméno kvóty:',
  'LBL_RELATED_PRODUCTS' => 'Související řádek tržby',
  'LBL_RELATED_PRODUCTS_TITLE' => 'Produkty',
  'LBL_REVENUELINEITEM' => 'Řádek',
  'LBL_REVENUELINEITEMS' => 'Řádky',
  'LBL_REVENUELINEITEM_ID' => 'ID řádku',
  'LBL_REVENUELINEITEM_NAME' => 'Název řádku',
  'LBL_SALES_STAGE' => 'Fáze obchodu',
  'LBL_SALES_STATUS' => 'Stav řádku',
  'LBL_SEARCH_FORM_TITLE' => 'Vyhledávání produktů',
  'LBL_SELECT_DISCOUNT' => 'Sleva v %',
  'LBL_SERIAL_NUMBER' => 'Sériové číslo:',
  'LBL_STATUS' => 'Stav:',
  'LBL_SUPPORT_CONTACT' => 'Kontakt podpory:',
  'LBL_SUPPORT_DESCRIPTION' => 'Popis podpory:',
  'LBL_SUPPORT_NAME' => 'Název podpory:',
  'LBL_SUPPORT_TERM' => 'Tým podpory:',
  'LBL_TAX_CLASS' => 'Daňová třída:',
  'LBL_TYPE' => 'Typ:',
  'LBL_URL' => 'URL produktu:',
  'LBL_VENDOR_PART_NUM' => 'Číslo dílu prodejce',
  'LBL_WEBSITE' => 'Web',
  'LBL_WEIGHT' => 'Váha:',
  'LNK_IMPORT_PRODUCTS' => 'Importovat produkty',
  'LNK_NEW_PRODUCT' => 'Vytvořit produkt',
  'LNK_PRODUCT_LIST' => 'Zobrazit produkty',
  'NTC_DELETE_CONFIRMATION' => 'Jste si jisti, že chcete smazat tento záznam?',
  'NTC_REMOVE_CONFIRMATION' => 'Jste si jisti, že chcete odebrat tuto vazbu?',
);

