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
  'ERR_DELETE_RECORD' => 'Muszisz wybrac rekord, aby usunąć szansę.',
  'LABEL_PANEL_ASSIGNMENT' => 'Przydziały',
  'LBL_ACCOUNT_ID' => 'ID kontrahenta',
  'LBL_ACCOUNT_NAME' => 'Nazwa kontrahenta:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktywności',
  'LBL_ASSIGNED_TO_ID' => 'Przydzielono do:',
  'LBL_ASSIGNED_TO_NAME' => 'Przydzielono do:',
  'LBL_CAMPAIGN' => 'Kampania:',
  'LBL_CAMPAIGN_LINK' => 'Link kampanii',
  'LBL_CAMPAIGN_OPPORTUNITY' => 'Kampanie',
  'LBL_CLOSED_RLIS' => '# Elementów zrealizowanego przychodu',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'Szanse zakończone sukcesem',
  'LBL_COMMITTED' => 'Przydzielono',
  'LBL_COMMIT_STAGE' => 'Etap zaangażowania',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakty',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Adresy e-mail powiązanych kontaktów',
  'LBL_CONTRACTS' => 'Umowy',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Umowy',
  'LBL_CREATED_ID' => 'Utworzone przez:',
  'LBL_CREATED_USER' => 'Utworzony użytkownik',
  'LBL_CURRENCIES' => 'Waluty',
  'LBL_CURRENCY' => 'Waluta:',
  'LBL_CURRENCY_ID' => 'ID waluty',
  'LBL_CURRENCY_NAME' => 'Nazwa waluty',
  'LBL_CURRENCY_RATE' => 'Stawka waluty',
  'LBL_CURRENCY_SYMBOL' => 'Symbol waluty',
  'LBL_DATE_CLOSED' => 'Data zamknięcia:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Znacznik czasu oczekiwanej daty zakończenia',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Szanse',
  'LBL_DESCRIPTION' => 'Opis:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumenty',
  'LBL_DUPLICATE' => 'Istnieje już taka szansa',
  'LBL_EDITLAYOUT' => 'Edytuj widok',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Przydzielono do',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Przydzielono do',
  'LBL_EXPORT_CAMPAIGN_ID' => 'Kampania',
  'LBL_EXPORT_CREATED_BY' => 'Utworzono przez',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Zmodyfikowano przez',
  'LBL_EXPORT_NAME' => 'Nazwa',
  'LBL_FILENAME' => 'Załącznik',
  'LBL_FORECAST' => 'Uwzględnij w prognozie',
  'LBL_HELP_CREATE' => 'Moduł {{plural_module_name}} zezwala na śledzenie od początku do końca indywidualnej sprzedaży i pozycji powiązanych z daną sprzedażą. Każda {{module_name}} jest zbiorem pozycji szans oraz jest powiązana z ważnymi rekordami, takimi jak: Oferta, Kontakt itp.

Aby utworzyć Szansę:
1. Wprowadź odpowiednie wartości do pól.
 - Pola oznaczone jako "Wymagane" muszą zostać uzupełnione.
 - Kliknij "Pokaż więcej", aby wyświetlić więcej pól.
2. Kliknij "Zapisz", aby zapisać nowy rekord i powrócić do poprzedniej strony.
 - Wybierz "Zapisz i pokaż", aby otworzyć rekord widoku Szansy w nowym oknie.
 - Wybierz "Zapisz i utwórz nowy", aby bez zwłoki utworzyć nową Szansę.
3. Po zapisaniu, użyj subpanelu {{revenuelineitems_module}}, aby dodać pozycje do Szansy.',
  'LBL_HELP_RECORD' => 'Moduł {{plural_module_name}} zezwala na śledzenie od początku do końca indywidualnej sprzedaży i pozycji powiązanych z daną sprzedażą. Każda {{module_name}} jest zbiorem pozycji szans oraz jest powiązana z ważnymi rekordami, takimi jak: Oferta, Kontakt itp.

- Edytuj pola tego rekordu poprze kliknięcie na odpowiednie pole lub na przycisk Edytuj.
- Przeglądaj lub modyfikuj powiązania z innymi rekordami w subpanelach poprzez przełączenie widoku dolnego lewego panelu na “Widok danych”.
- Dodawaj i przeglądaj komentarze użytkowników i historię zmian rekordu w Panelu aktywności poprzez przełączenie widoku dolnego lewego panelu na „Panel aktywności”.
- Obserwuj lub dodaj do ulubionych ten rekord za pomocą ikon znajdujących się z prawej strony nazwy rekordu.
- Dodatkowe działania dostępne są w liście rozwijalnej menu Działania po prawej stronie przycisku Edytuj.',
  'LBL_HELP_RECORDS' => 'Moduł {{plural_module_name}} zezwala na śledzenie od początku do końca indywidualnej sprzedaży i pozycji powiązanych z daną sprzedażą. Każda {{module_name}} jest zbiorem pozycji szans oraz jest powiązana z ważnymi rekordami, takimi jak: Oferta, Kontakt itp. Każda Pozycja szansy jest spodziewaną sprzedażą określonego produktu I zawiera istotne informacje nt. sprzedaży. Każda Pozycja szansy zwykle przechodzi przez klika Etapów sprzedaży zanim zostanie oznaczona jako “Zakończona sukcesem” lub “Zakończona porażką”. Rekord Szansy odzwierciedla spodziewaną kwotę i datę zamknięcia Pozycji szansy. {{plural_module_name}} i Pozycje szans mogą być wykorzystywane również przez moduł Prognozy do zrozumienia i przewidywania trendów sprzedaży oraz do pomocy w osiąganiu targetów sprzedażowych.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historia',
  'LBL_INVITEE' => 'Kontakty',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Namiary',
  'LBL_LEAD_SOURCE' => 'Źródło pozyskania:',
  'LBL_LIST_ACCOUNT_NAME' => 'Nazwa kontrahenta',
  'LBL_LIST_AMOUNT' => 'Prawdopodobny',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'Łączna kwota',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Przydzielony użytkownik',
  'LBL_LIST_DATE_CLOSED' => 'Data zamknięcia',
  'LBL_LIST_FORM_TITLE' => 'Lista szans',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Nazwa',
  'LBL_LIST_SALES_STAGE' => 'Etap sprzedaży',
  'LBL_MKTO_ID' => 'ID namiaru Marketo',
  'LBL_MKTO_SYNC' => 'Synchronizuj z Marketo®',
  'LBL_MODIFIED_ID' => 'Zmodyfikowane przez',
  'LBL_MODIFIED_NAME' => 'Zmodyfikowane przez',
  'LBL_MODIFIED_USER' => 'Zmodyfikowany użytkownik',
  'LBL_MODULE_NAME' => 'Szanse',
  'LBL_MODULE_NAME_SINGULAR' => 'Szansa',
  'LBL_MODULE_TITLE' => 'Szanse: Strona główna',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'Moje zamknięte szanse',
  'LBL_NAME' => 'Nazwa szansy',
  'LBL_NEW_FORM_TITLE' => 'Utwórz szansę',
  'LBL_NEXT_STEP' => 'Następny krok:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notatki',
  'LBL_OPPORTUNITY' => 'Szansa:',
  'LBL_OPPORTUNITY_NAME' => 'Nazwa szansy:',
  'LBL_OPPORTUNITY_ROLE' => 'Rola w szansie',
  'LBL_OPPORTUNITY_TYPE' => 'Typ szansy',
  'LBL_PIPELINE_TOTAL_IS' => 'Wartość całkowita szans sprzedaży',
  'LBL_PRIMARY_QUOTE_ID' => 'Kwota początkowa',
  'LBL_PROBABILITY' => 'Prawdopodobieństwo (%):',
  'LBL_PRODUCTS' => 'Pozycje ofert',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Pozycje ofert',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekty',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projekty',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Oferty',
  'LBL_QUOTE_SUBPANEL_TITLE' => 'Oferty',
  'LBL_RAW_AMOUNT' => 'Kwota początkowa',
  'LBL_RLI' => 'Pozycje szans',
  'LBL_RLI_SUBPANEL_TITLE' => 'Pozycje szans',
  'LBL_SALES_STAGE' => 'Etap sprzedaży:',
  'LBL_SALES_STATUS' => 'Status',
  'LBL_SEARCH_FORM_TITLE' => 'Wyszukiwanie',
  'LBL_TEAM_ID' => 'ID zespołu',
  'LBL_TIMEPERIODS' => 'Przedziały czasu',
  'LBL_TIMEPERIOD_ID' => 'ID przedziału czasu',
  'LBL_TOP_OPPORTUNITIES' => 'Moje najważniejsze szanse',
  'LBL_TOTAL_OPPORTUNITIES' => 'Wszystkie szanse',
  'LBL_TOTAL_RLIS' => '# Elementów całkowitego przychodu',
  'LBL_TYPE' => 'Typ:',
  'LBL_VIEW_FORM_TITLE' => 'Widok szans',
  'LBL_WORKSHEET' => 'Arkusz roboczy',
  'LNK_CREATE' => 'Utwórz transakcję',
  'LNK_IMPORT_OPPORTUNITIES' => 'Import szans',
  'LNK_NEW_OPPORTUNITY' => 'Utwórz szansę',
  'LNK_OPPORTUNITY_LIST' => 'Szanse',
  'LNK_OPPORTUNITY_REPORTS' => 'Raporty szans',
  'MSG_DUPLICATE' => 'Utworzenie tej szansy prawdopodobnie spowoduje powstanie duplikatu już istniejącej szansy. Istniejące rekordy szans o podobnych nazwach są wymienione poniżej.<br>Kliknij Zapisz, aby utworzyć nową szansę lub kliknij Anuluj, aby powrócić do modułu bez utworzenia szansy.',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => 'Nie możesz usunąć szans, które zawierają zamknięte Pozycje szans',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Czy na pewno usunąć powiązanie tego kontaktu z szansą?',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'Czy na pewno chcesz usunąć powiązanie tego zadania z szansą?',
  'TPL_RLI_CREATE' => 'Szansa musi być powiązana z pozycją szansy. <a href="javascript:void(0);" id="createRLI">Utwórz pozycję szansy</a>.',
  'TPL_RLI_CREATE_LINK_TEXT' => 'Utwórz pozycję szansy',
  'UPDATE' => 'Szansa - Aktualizacja waluty',
  'UPDATE_BUGFOUND_COUNT' => 'Znalezione błędy:',
  'UPDATE_BUG_COUNT' => 'Znaleziono błąd, trwa próba naprawienia:',
  'UPDATE_COUNT' => 'Zaktualizowane rekordy:',
  'UPDATE_CREATE_CURRENCY' => 'Tworzenie nowej waluty:',
  'UPDATE_DOLLARAMOUNTS' => 'Aktualizuj kwotę w PLN',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Aktualizuje kwoty szans w oparciu o aktualne stawki kursowe PLN. Wartości te są używane do sporządzania wykresów oraz list wartości kwot.',
  'UPDATE_DONE' => 'Zrobione',
  'UPDATE_FAIL' => 'Nie można zaktualizować -',
  'UPDATE_FIX' => 'Napraw kwoty',
  'UPDATE_FIX_TXT' => 'Próba naprawienia wartości kwot poprzez przekształcenie znalezionych wartości do postaci liczbowej. Obecne wartości zostaną zapisane w kopii bezpieczeństwa. Jeśli operacja spowoduje powstanie błędów, przywróć poprzednie wartości z kopii bezpieczeństwa. Nie ponawiaj tej operacji po wykryciu nieprawidłowości. Grozi to nadpisaniem kopii bezpieczeństwa błędnymi danymi.',
  'UPDATE_INCLUDE_CLOSE' => 'Dodaj zamknięte rekordy',
  'UPDATE_MERGE' => 'Scal waluty',
  'UPDATE_MERGE_TXT' => 'Scala wiele walut w jedną. Użyj tej funkcji jeśli Twoje dane zawierają różne oznaczenia tej samej waluty np.: PLN, PLZ, ZŁ, zł.',
  'UPDATE_NULL_VALUE' => 'Wartosć kwoty nieznana. Ustawiono na 0 -',
  'UPDATE_RESTORE' => 'Przywróć kwoty',
  'UPDATE_RESTORE_COUNT' => 'Przywrócono kwoty rekordów:',
  'UPDATE_RESTORE_TXT' => 'Przywracanie wartości kwot z kopii bezpieczeństwa.',
  'UPDATE_VERIFY' => 'Weryfikuj kwoty',
  'UPDATE_VERIFY_CURAMOUNT' => 'Bieżąca kwota:',
  'UPDATE_VERIFY_FAIL' => 'Błąd weryfikacji rekordu:',
  'UPDATE_VERIFY_FIX' => 'Naprawa zwróci',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nowa kwota:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nowa waluta:',
  'UPDATE_VERIFY_TXT' => 'Weryfikuje czy wartości zapisane są w postaci cyfrowej (cyfry 0-9) oraz w postaci dziesiętnej.',
  'WARNING_NO_DELETE_CLOSED_SELECTED' => 'Co najmniej jeden wybrany rekord zawiera zamknięte Pozycje szans i nie może zostać usunięty.',
);

