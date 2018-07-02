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
  'ERR_DELETE_RECORD' => 'Musisz podać numer rekordu, aby usunąć ten produkt.',
  'LBL_ACCOUNT_ID' => 'ID kontrahenta',
  'LBL_ACCOUNT_NAME' => 'Nazwa kontrahenta:',
  'LBL_ASSET_NUMBER' => 'Numer serwisowy producenta:',
  'LBL_ASSIGNED_TO_NAME' => 'Przydzielono do:',
  'LBL_ASSIGNED_USER_ID' => 'Przydzielony użytkownik',
  'LBL_ASSOCIATED_QUOTE' => 'Przedmiot oferty:',
  'LBL_BOOK_VALUE' => 'Wartość księgowa:',
  'LBL_BOOK_VALUE_DATE' => 'Data wyceny wartości księgowej:',
  'LBL_BOOK_VALUE_USDOLLAR' => 'Wartość księgowa (PLN):',
  'LBL_CALCULATED_LINE_ITEM_AMOUNT' => 'Łączna kwota pozycji oferty',
  'LBL_CAMPAIGN_PRODUCT' => 'Pozycja oferty kampanii',
  'LBL_CATEGORY' => 'Kategoria:',
  'LBL_CATEGORY_NAME' => 'Nazwa kategorii:',
  'LBL_COMMIT_STAGE' => 'Etap zaangażowania',
  'LBL_COMMIT_STAGE_FORECAST' => 'Prognoza',
  'LBL_CONTACT' => 'Kontakt',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakty',
  'LBL_CONTACT_ID' => 'ID kontaktu',
  'LBL_CONTACT_NAME' => 'Nazwa kontaktu:',
  'LBL_CONTRACTS' => 'Umowy',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Umowy',
  'LBL_CONVERT_TO_QUOTE_ERROR' => 'Błąd:',
  'LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE' => 'Wystąpił błąd podczas przekształcania tej Pozycji oferty w Ofertę',
  'LBL_COST_PRICE' => 'Koszt:',
  'LBL_COST_USDOLLAR' => 'Koszt (PLN)',
  'LBL_CREATED_USER' => 'Użytkownik tworzący',
  'LBL_CURRENCY' => 'Waluta:',
  'LBL_CURRENCY_ID' => 'ID waluty:',
  'LBL_CURRENCY_RATE' => 'Stawka waluty',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Nazwa symbolu waluty',
  'LBL_DATE_CLOSED' => 'Oczekiwana data zakończenia',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Znacznik czasu oczekiwanej daty zakończenia',
  'LBL_DATE_PURCHASED' => 'Kupiono:',
  'LBL_DATE_SUPPORT_EXPIRES' => 'Gwarancja wygasa:',
  'LBL_DATE_SUPPORT_STARTS' => 'Gwarancja rozpoczyna się:',
  'LBL_DEAL_TOT' => 'Kwota rabatu:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Pozycje ofert',
  'LBL_DESCRIPTION' => 'Opis:',
  'LBL_DISCOUNT_AMOUNT' => 'Cena ustalona',
  'LBL_DISCOUNT_AS_PERCENT' => 'Rabat w %',
  'LBL_DISCOUNT_PRICE' => 'Cena jednostkowa:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Data obniżki ceny:',
  'LBL_DISCOUNT_RATE' => 'Stawka rabatu',
  'LBL_DISCOUNT_RATE_USDOLLAR' => 'Stawka rabatu (PLN)',
  'LBL_DISCOUNT_TOTAL' => 'Całkowity rabat',
  'LBL_DISCOUNT_TOTAL_USDOLLAR' => 'Kwota rabatu (PLN)',
  'LBL_DISCOUNT_USDOLLAR' => 'Cena ustalona (PLN)',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumenty',
  'LBL_EDITLAYOUT' => 'Edytuj widok',
  'LBL_EXPERT_ID' => 'Ekspert produktowy',
  'LBL_EXPORT_CURRENCY_ID' => 'ID waluty',
  'LBL_EXT_PRICE' => 'Kwota calkowita',
  'LBL_FORECAST' => 'Uwzględnij w prognozie',
  'LBL_HELP_CREATE' => 'Moduł {{plural_module_name}} zawiera wszystkie produkty, które zostały już sprzedane lub są w trakcie sprzedaży klientom.

Aby utworzyć Produkt:
1. Wprowadź odpowiednie wartości do pól.
 - Pola oznaczone jako "Wymagane" muszą zostać uzupełnione.
 - Kliknij "Pokaż więcej", aby wyświetlić więcej pól.
2. Kliknij "Zapisz", aby zapisać nowy rekord i powrócić do poprzedniej strony.
 - Wybierz "Zapisz i pokaż", aby otworzyć rekord widoku Produktu w nowym oknie.
 - Wybierz "Zapisz i utwórz nowy", aby bez zwłoki utworzyć nowy Produkt.',
  'LBL_HELP_RECORD' => 'Moduł {{plural_module_name}} zawiera wszystkie produkty, które zostały już sprzedane lub są w trakcie sprzedaży klientom.

- Edytuj pola tego rekordu poprze kliknięcie na odpowiednie pole lub na przycisk Edytuj.
- Przeglądaj lub modyfikuj powiązania z innymi rekordami w subpanelach poprzez przełączenie widoku dolnego lewego panelu na “Widok danych”.
- Dodawaj i przeglądaj komentarze użytkowników i historię zmian rekordu w Panelu aktywności poprzez przełączenie widoku dolnego lewego panelu na „Panel aktywności”.
- Obserwuj lub dodaj do ulubionych ten rekord za pomocą ikon znajdujących się z prawej strony nazwy rekordu.
- Dodatkowe działania dostępne są w liście rozwijalnej menu Działania po prawej stronie przycisku Edytuj.',
  'LBL_HELP_RECORDS' => 'Moduł {{plural_module_name}} zawiera wszystkie produkty, które zostały już sprzedane lub są w trakcie sprzedaży klientom. Lista produktów sprzedawanych przez Twoją firmę znajduje się w: Administracja > Katalog produktów i administratorzy mają możliwość dodawania produktów w razie potrzeby. Podczas tworzenia produktów, możesz wybrać produkty z katalogu bądź utworzyć nowy produkt za pomocą modułu {{plural_module_name}}. Jest kilka sposobów na utworzenie Produktów w Sugar, np. poprzez moduł {{plural_module_name}}, moduł Oferty, duplikowanie, importowanie produktów itp. Po utworzeniu rekordu Produktu, możesz przeglądać i edytować informacje dotyczące Produktu poprzez widok rekordu Produktu.',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Namiary',
  'LBL_LEAD_SOURCE' => 'Źródło pozyskania',
  'LBL_LIST_ACCOUNT_NAME' => 'Nazwa kontrahenta',
  'LBL_LIST_CONTACT_NAME' => 'Nazwa kontaktu',
  'LBL_LIST_COST_PRICE' => 'Koszt',
  'LBL_LIST_DATE_PURCHASED' => 'Kupione',
  'LBL_LIST_DISCOUNT_PRICE' => 'Cena',
  'LBL_LIST_FORM_TITLE' => 'Lista pozycji oferty',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Nr wg producenta',
  'LBL_LIST_LIST_PRICE' => 'Cena katalogowa',
  'LBL_LIST_MANUFACTURER' => 'Producent',
  'LBL_LIST_NAME' => 'Pozycja oferty',
  'LBL_LIST_PRICE' => 'Cennik:',
  'LBL_LIST_QUANTITY' => 'Ilość',
  'LBL_LIST_QUOTE_NAME' => 'Nazwa oferty',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUPPORT_EXPIRES' => 'Wygasa',
  'LBL_LIST_USDOLLAR' => 'Cennik (PLN)',
  'LBL_MANUFACTURER' => 'Producent:',
  'LBL_MANUFACTURERS' => 'Producenci',
  'LBL_MANUFACTURER_NAME' => 'Nazwa producenta:',
  'LBL_MEMBER_OF' => 'Należy do:',
  'LBL_MFT_PART_NUM' => 'Nr kat. producenta:',
  'LBL_MODIFIED_USER' => 'Użytkownik modyfikujący',
  'LBL_MODULE_NAME' => 'Pozycje ofert',
  'LBL_MODULE_NAME_SINGULAR' => 'Pozycja oferty',
  'LBL_MODULE_TITLE' => 'Pozycje ofert: Strona główna',
  'LBL_NAME' => 'Nazwa',
  'LBL_NEW_FORM_TITLE' => 'Utwórz pozycję oferty',
  'LBL_NEXT_STEP' => 'Następny krok:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notatki',
  'LBL_OPPORTUNITY' => 'Szansa',
  'LBL_OPPORTUNITY_ID' => 'ID szansy',
  'LBL_PRICING_FACTOR' => 'Współczynnik wyceny',
  'LBL_PRICING_FORMULA' => 'Formuła wyceny:',
  'LBL_PROBABILITY' => 'Prawdopodobieństwo (%)',
  'LBL_PRODUCT' => 'Pozycja oferty:',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Pozycje ofert',
  'LBL_PRODUCT_CATEGORIES' => 'Kategorie produktów',
  'LBL_PRODUCT_TEMPLATE' => 'Produkt:',
  'LBL_PRODUCT_TEMPLATE_ID' => 'ID produktu',
  'LBL_PRODUCT_TYPES' => 'Typy produktów',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekty',
  'LBL_QUANTITY' => 'Ilość:',
  'LBL_QUOTE' => 'Oferty',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Oferty',
  'LBL_QUOTE_ID' => 'ID oferty',
  'LBL_QUOTE_NAME' => 'Nazwa oferty:',
  'LBL_RELATED_PRODUCTS' => 'Powiązane pozycje ofert',
  'LBL_RELATED_PRODUCTS_TITLE' => 'Pozycje ofert',
  'LBL_REVENUELINEITEM' => 'Pozycja szansy',
  'LBL_REVENUELINEITEMS' => 'Pozycje szans',
  'LBL_REVENUELINEITEM_ID' => 'ID pozycji szansy:',
  'LBL_REVENUELINEITEM_NAME' => 'Nazwa pozycji szansy:',
  'LBL_SALES_STAGE' => 'Etap sprzedaży',
  'LBL_SALES_STATUS' => 'Status przychodu',
  'LBL_SEARCH_FORM_TITLE' => 'Wyszukiwanie pozycji ofert',
  'LBL_SELECT_DISCOUNT' => 'Rabat w %',
  'LBL_SERIAL_NUMBER' => 'Numer seryjny:',
  'LBL_STATUS' => 'Status:',
  'LBL_SUPPORT_CONTACT' => 'Kontakt do gwaranta:',
  'LBL_SUPPORT_DESCRIPTION' => 'Typ gwarancji:',
  'LBL_SUPPORT_NAME' => 'Gwarant:',
  'LBL_SUPPORT_TERM' => 'Okres gwarancji:',
  'LBL_TAX_CLASS' => 'Obowiązek podatkowy:',
  'LBL_TYPE' => 'Typ produktu:',
  'LBL_URL' => 'Link do produktu:',
  'LBL_VENDOR_PART_NUM' => 'Nr kat. sprzedawcy:',
  'LBL_WEBSITE' => 'Strona www',
  'LBL_WEIGHT' => 'Waga:',
  'LNK_IMPORT_PRODUCTS' => 'Import pozycji ofert',
  'LNK_NEW_PRODUCT' => 'Utwórz pozycję oferty',
  'LNK_PRODUCT_LIST' => 'Pozycje ofert',
  'NTC_DELETE_CONFIRMATION' => 'Czy na pewno chcesz usunąć ten rekord?',
  'NTC_REMOVE_CONFIRMATION' => 'Czy na pewno chcesz usunąć tę zależność produktu?',
);

