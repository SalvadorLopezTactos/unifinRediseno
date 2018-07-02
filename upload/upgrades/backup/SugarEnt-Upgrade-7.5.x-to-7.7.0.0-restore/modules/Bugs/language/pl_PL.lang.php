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
  'ERR_DELETE_RECORD' => 'Musisz podać numer rekordu, aby usunąć błąd.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Kontrahenci',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Wydarzenia',
  'LBL_ASSIGNED_TO_NAME' => 'Przydzielono do',
  'LBL_BUG' => 'Błąd:',
  'LBL_BUG_INFORMATION' => 'Informacje ogólne',
  'LBL_BUG_NUMBER' => 'Numer błędu:',
  'LBL_BUG_SUBJECT' => 'Temat błędu:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Zgłoszenia',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakty',
  'LBL_CONTACT_BUG_TITLE' => 'Błąd - kontakt:',
  'LBL_CONTACT_NAME' => 'Nazwa kontaktu:',
  'LBL_CONTACT_ROLE' => 'Rola:',
  'LBL_CREATED_BY' => 'Utworzone przez:',
  'LBL_DATE_CREATED' => 'Data utworzenia:',
  'LBL_DATE_LAST_MODIFIED' => 'Data modyfikacji:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Śledzenie błędów',
  'LBL_DESCRIPTION' => 'Opis:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumenty',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Przydzielony użytkownik',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Nazwa przydzielonego użytkownika',
  'LBL_EXPORT_CREATED_BY' => 'Stworzone przez ID',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Naprawiony w wydaniu',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'ID osoby modyfikującej',
  'LBL_FIXED_IN_RELEASE' => 'Naprawione w wydaniu:',
  'LBL_FOUND_IN_RELEASE' => 'Odnalezione w wydaniu:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Odnaleziony w wydaniu',
  'LBL_HELP_CREATE' => 'Moduł Błędy jest używany do śledzenia i zarządzania problemami, związanymi z produktami, znalezionymi wewnętrznie lub zgłoszonymi przez klientów.

Aby utworzyć Błąd:
1. Wprowadź odpowiednie wartości do pól.
- Pola oznaczone jako "Wymagane" muszą zostać uzupełnione.
- Kliknij "Pokaż więcej", aby wyświetlić więcej pól.
2. Kliknij "Zapisz", aby zapisać nowy rekord i powrócić do poprzedniej strony.
- Wybierz "Zapisz i pokaż", aby otworzyć rekord widoku Błędu w nowym oknie.
- Wybierz "Zapisz i utwórz nowy", aby bez zwłoki utworzyć nowy Błąd.',
  'LBL_HELP_RECORD' => 'Moduł Błędy jest używany do śledzenia i zarządzania problemami, związanymi z produktami, znalezionymi wewnętrznie lub zgłoszonymi przez klientów.

- Edytuj pola tego rekordu poprze kliknięcie na odpowiednie pole lub na przycisk Edytuj.
- Przeglądaj lub modyfikuj powiązania z innymi rekordami w subpanelach poprzez przełączenie widoku dolnego lewego panelu na “Widok danych”.
- Dodawaj i przeglądaj komentarze użytkowników i historię zmian rekordu w Panelu aktywności poprzez przełączenie widoku dolnego lewego panelu na „Panel aktywności”.
- Obserwuj lub dodaj do ulubionych ten rekord za pomocą ikon znajdujących się z prawej strony nazwy rekordu.
- Dodatkowe działania dostępne są w liście rozwijalnej menu Działania po prawej stronie przycisku Edytuj.',
  'LBL_HELP_RECORDS' => 'Moduł Błędy jest używany do śledzenia i zarządzania problemami, związanymi z produktami, znalezionymi wewnętrznie lub zgłoszonymi przez klientów. Błędy mogą zostać sprawdzone poprzez śledzenie znalezionych i naprawionych błędów w wydaniu. Moduł Błędy pozwala na szybką ocenę wszystkich elementów  Błędu i proces jego naprawy. Po utworzeniu Błędu, możesz przeglądać i edytować informacje dotyczące Błędu poprzez widok rekordu Błędu. Każdy Błąd może zostać powiązany z innymi rekordami Sugar, np. z Rozmową telefoniczną, Kontaktem, Zgłoszeniem oraz wieloma innymi.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historia',
  'LBL_INVITEE' => 'Kontakty',
  'LBL_LIST_ACCOUNT_NAME' => 'Nazwa kontrahenta',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Przydzielony użytkownik',
  'LBL_LIST_CONTACT_NAME' => 'Nazwa kontaktu',
  'LBL_LIST_EMAIL_ADDRESS' => 'Adres e-mail',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Naprawione w wydaniu',
  'LBL_LIST_FORM_TITLE' => 'Lista błędów',
  'LBL_LIST_LAST_MODIFIED' => 'Ostatnia modyfikacja',
  'LBL_LIST_MY_BUGS' => 'Moje przypisane błędy',
  'LBL_LIST_NUMBER' => 'Nr',
  'LBL_LIST_PHONE' => 'Telefon',
  'LBL_LIST_PRIORITY' => 'Priotytet',
  'LBL_LIST_RELEASE' => 'Wydanie',
  'LBL_LIST_RESOLUTION' => 'Wynik analizy',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Temat',
  'LBL_LIST_TYPE' => 'Typ',
  'LBL_MODIFIED_BY' => 'Ostatnio modyfikowane przez:',
  'LBL_MODULE_ID' => 'Błędy',
  'LBL_MODULE_NAME' => 'Błędy',
  'LBL_MODULE_NAME_SINGULAR' => 'Błąd',
  'LBL_MODULE_TITLE' => 'Śledzenie błędów: Strona główna',
  'LBL_NEW_FORM_TITLE' => 'Zgłoś błąd',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notatki',
  'LBL_NUMBER' => 'Numer:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Kliknij tutaj, aby zgłosić nowy błąd.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Wprowadzenie wyrażenia wyszukiwania umożliwi filtrację listy błędów.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Możesz na przykład użyć tej opcji do znalezienia wcześniej zgłoszonego błędu.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'Moduł Błędy służy do zgłaszania i przeglądania błędów. Użyj poniższych strzałek, aby przejść dalej.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Ta strona wyświetla listę istniejących opublikowanych błędów.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Kliknięcie tutaj przeniesie Cię z powrotem do tego widoku.',
  'LBL_PORTAL_VIEWABLE' => 'Widoczny Portal',
  'LBL_PRIORITY' => 'Priorytet:',
  'LBL_PRODUCT_CATEGORY' => 'Kategoria:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekty',
  'LBL_RELEASE' => 'Wydanie:',
  'LBL_RESOLUTION' => 'Wynik analizy:',
  'LBL_SEARCH_FORM_TITLE' => 'Szukanie błędu',
  'LBL_SHOW_IN_PORTAL' => 'Pokaż w Portalu',
  'LBL_SHOW_MORE' => 'Pokaż więcej błędów',
  'LBL_SOURCE' => 'Źródło wykrycia:',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Temat:',
  'LBL_SYSTEM_ID' => 'ID systemu',
  'LBL_TYPE' => 'Typ:',
  'LBL_WORK_LOG' => 'Dziennik prac:',
  'LNK_BUG_LIST' => 'Błędy',
  'LNK_BUG_REPORTS' => 'Raporty błędów',
  'LNK_CREATE' => 'Zgłoś błąd',
  'LNK_CREATE_WHEN_EMPTY' => 'Zgłoś teraz błąd.',
  'LNK_IMPORT_BUGS' => 'Importuj błędy',
  'LNK_NEW_BUG' => 'Zgłoś błąd',
  'NTC_DELETE_CONFIRMATION' => 'Czy na pewno chcesz usunąć ten kontakt z tego błędu?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Czy na pewno chcesz usunąć ten błąd z tego kontrahenta?',
  'NTC_REMOVE_INVITEE' => 'Czy na pewno chcesz usunąć ten kontakt z błędu?',
);

