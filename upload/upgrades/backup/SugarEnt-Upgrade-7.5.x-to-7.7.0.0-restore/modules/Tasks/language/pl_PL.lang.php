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
  'ERR_DELETE_RECORD' => 'Wskaż rekord, który chcesz usunąć.',
  'ERR_INVALID_HOUR' => 'Wpisz godzinę pomiędzy 0 a 24',
  'LBL_ACTIVITIES_REPORTS' => 'Raport aktywności',
  'LBL_ASSIGNED_TO_NAME' => 'Przydzielono do:',
  'LBL_ASSIGNED_USER' => 'Przydzielono do',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Kontakt:',
  'LBL_CONTACT_FIRST_NAME' => 'Nazwisko kontaktu',
  'LBL_CONTACT_ID' => 'ID kontaktu:',
  'LBL_CONTACT_LAST_NAME' => 'Imię kontaktu',
  'LBL_CONTACT_NAME' => 'Kontakt',
  'LBL_CONTACT_PHONE' => 'Telefon kontaktu:',
  'LBL_DATE_DUE' => 'Data zakończenia',
  'LBL_DATE_DUE_FLAG' => 'Brak daty zakończenia',
  'LBL_DATE_START_FLAG' => 'Brak daty rozpoczęcia',
  'LBL_DEFAULT_PRIORITY' => 'Średni',
  'LBL_DESCRIPTION' => 'Opis:',
  'LBL_DESCRIPTION_INFORMATION' => 'Informacje o zadaniu',
  'LBL_DUE_DATE' => 'Data zakończenia:',
  'LBL_DUE_DATE_AND_TIME' => 'Data i czas zakończenia:',
  'LBL_DUE_TIME' => 'Godzina zakończenia:',
  'LBL_EDITLAYOUT' => 'Edytuj widok',
  'LBL_EMAIL' => 'E-mail:',
  'LBL_EMAIL_ADDRESS' => 'Adres e-mail:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Przydzielono do',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Przydzielono do',
  'LBL_EXPORT_CREATED_BY' => 'Utworzone przez',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Zmodyfikowane przez',
  'LBL_EXPORT_PARENT_ID' => 'Powiązane z',
  'LBL_EXPORT_PARENT_TYPE' => 'Powiązane z modułem',
  'LBL_HELP_CREATE' => 'Moduł {{plural_module_name}} składa się z elastycznych działań, elementów do wykonania lub jakichkolwiek innych czynności wymagających ukończenia.

Aby utworzyć Zadanie:
1. Wprowadź odpowiednie wartości do pól.
 - Pola oznaczone jako "Wymagane" muszą zostać uzupełnione.
 - Kliknij "Pokaż więcej", aby wyświetlić więcej pól.
2. Kliknij "Zapisz", aby zapisać nowy rekord i powrócić do poprzedniej strony.
 - Wybierz "Zapisz i pokaż", aby otworzyć rekord widoku Zadania w nowym oknie.
 - Wybierz "Zapisz i utwórz nowy", aby bez zwłoki utworzyć nowe Zadanie.',
  'LBL_HELP_RECORD' => 'Moduł {{plural_module_name}} składa się z elastycznych działań, elementów do wykonania lub jakichkolwiek innych czynności wymagających ukończenia.

- Edytuj pola tego rekordu poprze kliknięcie na odpowiednie pole lub na przycisk Edytuj.
- Przeglądaj lub modyfikuj powiązania z innymi rekordami w subpanelach poprzez przełączenie widoku dolnego lewego panelu na “Widok danych”.
- Dodawaj i przeglądaj komentarze użytkowników i historię zmian rekordu w Panelu aktywności poprzez przełączenie widoku dolnego lewego panelu na „Panel aktywności”.
- Obserwuj lub dodaj do ulubionych ten rekord za pomocą ikon znajdujących się z prawej strony nazwy rekordu.
- Dodatkowe działania dostępne są w liście rozwijalnej menu Działania po prawej stronie przycisku Edytuj.',
  'LBL_HELP_RECORDS' => 'Moduł {{plural_module_name}} składa się z elastycznych działań, elementów do wykonania lub jakichkolwiek innych czynności wymagających ukończenia. Rekordy Zadań mogą być powiązane z jednym rekordem w większości modułów poprzez pole „Powiązane z” oraz z jednym Kontaktem. Jest kilka sposobów na utworzenie {{plural_module_name}} w Sugar, np. poprzez moduł {{plural_module_name}}, duplikowanie lub importowanie Zadań itp. Po utworzeniu rekordu Zadania, możesz przeglądać i edytować informacje dotyczące Zadania poprzez widok rekordu Zadania. W zależności od szczegółów Zadania, możesz przeglądać i edytować Zadnie poprzez moduł Kalendarz. Każde {{module_name}} może zostać powiązane z innymi rekordami Sugar, np. z Kontrahentem, Kontaktem, Szansą oraz wieloma innymi.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Notatki',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Przydzielono do',
  'LBL_LIST_CLOSE' => 'Zamknij',
  'LBL_LIST_COMPLETE' => 'Zakończone:',
  'LBL_LIST_CONTACT' => 'Kontakt',
  'LBL_LIST_DATE_MODIFIED' => 'Data modyfikacji',
  'LBL_LIST_DUE_DATE' => 'Data zakończenia:',
  'LBL_LIST_DUE_TIME' => 'Godzina zakończenia:',
  'LBL_LIST_FORM_TITLE' => 'Lista zadań',
  'LBL_LIST_MY_TASKS' => 'Moje rozpoczęte zadania',
  'LBL_LIST_PRIORITY' => 'Priorytet',
  'LBL_LIST_RELATED_TO' => 'Powiązane z',
  'LBL_LIST_START_DATE' => 'Data rozpoczęcia',
  'LBL_LIST_START_TIME' => 'Czas rozpoczęcia',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Temat',
  'LBL_MODULE_NAME' => 'Zadania',
  'LBL_MODULE_NAME_SINGULAR' => 'Zadanie',
  'LBL_MODULE_TITLE' => 'Zadania: Strona główna',
  'LBL_NAME' => 'Nazwa:',
  'LBL_NEW_FORM_DUE_DATE' => 'Data zakończenia:',
  'LBL_NEW_FORM_DUE_TIME' => 'Godzina zakończenia:',
  'LBL_NEW_FORM_SUBJECT' => 'Temat:',
  'LBL_NEW_FORM_TITLE' => 'Utwórz zadanie',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Brak',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notatki',
  'LBL_PARENT_ID' => 'ID jednostki nadrzędnej:',
  'LBL_PARENT_NAME' => 'Typ nadrzędny:',
  'LBL_PHONE' => 'Tel.:',
  'LBL_PRIORITY' => 'Priorytet:',
  'LBL_REVENUELINEITEMS' => 'Pozycje szans',
  'LBL_SEARCH_FORM_TITLE' => 'Wyszukiwanie',
  'LBL_START_DATE' => 'Data rozpoczęcia:',
  'LBL_START_DATE_AND_TIME' => 'Data i czas rozpoczęcia:',
  'LBL_START_TIME' => 'Czas rozpoczęcia:',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Temat:',
  'LBL_TASK' => 'Zadania:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Zamknięcie zadania powiodło się.',
  'LBL_TASK_INFORMATION' => 'Podgląd',
  'LNK_IMPORT_TASKS' => 'Import zadań',
  'LNK_NEW_TASK' => 'Utwórz zadanie',
  'LNK_TASK_LIST' => 'Zadania',
);

