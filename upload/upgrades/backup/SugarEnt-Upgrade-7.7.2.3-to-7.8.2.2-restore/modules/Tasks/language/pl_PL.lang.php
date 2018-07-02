<?php
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
  'LBL_MODULE_NAME' => 'Zadania',
  'LBL_MODULE_NAME_SINGULAR' => 'Zadanie',
  'LBL_TASK' => 'Zadania:',
  'LBL_MODULE_TITLE' => 'Zadania: Strona główna',
  'LBL_SEARCH_FORM_TITLE' => 'Wyszukiwanie',
  'LBL_LIST_FORM_TITLE' => 'Lista zadań',
  'LBL_NEW_FORM_TITLE' => 'Utwórz zadanie',
  'LBL_NEW_FORM_SUBJECT' => 'Temat:',
  'LBL_NEW_FORM_DUE_DATE' => 'Data zakończenia:',
  'LBL_NEW_FORM_DUE_TIME' => 'Godzina zakończenia:',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_LIST_CLOSE' => 'Zamknij',
  'LBL_LIST_SUBJECT' => 'Temat',
  'LBL_LIST_CONTACT' => 'Kontakt',
  'LBL_LIST_PRIORITY' => 'Priorytet',
  'LBL_LIST_RELATED_TO' => 'Powiązane z',
  'LBL_LIST_DUE_DATE' => 'Data zakończenia',
  'LBL_LIST_DUE_TIME' => 'Godzina zakończenia:',
  'LBL_SUBJECT' => 'Temat:',
  'LBL_STATUS' => 'Status:',
  'LBL_DUE_DATE' => 'Data zakończenia:',
  'LBL_DUE_TIME' => 'Godzina zakończenia:',
  'LBL_PRIORITY' => 'Priorytet:',
  'LBL_COLON' => ':',
  'LBL_DUE_DATE_AND_TIME' => 'Data i czas zakończenia:',
  'LBL_START_DATE_AND_TIME' => 'Data i czas rozpoczęcia:',
  'LBL_START_DATE' => 'Data rozpoczęcia:',
  'LBL_LIST_START_DATE' => 'Data rozpoczęcia',
  'LBL_START_TIME' => 'Czas rozpoczęcia:',
  'LBL_LIST_START_TIME' => 'Czas rozpoczęcia',
  'DATE_FORMAT' => '(rrrr-mm-dd)',
  'LBL_NONE' => 'Brak',
  'LBL_CONTACT' => 'Kontakt:',
  'LBL_EMAIL_ADDRESS' => 'Adres e-mail:',
  'LBL_PHONE' => 'Tel.:',
  'LBL_EMAIL' => 'E-mail:',
  'LBL_DESCRIPTION_INFORMATION' => 'Informacje o zadaniu',
  'LBL_DESCRIPTION' => 'Opis:',
  'LBL_NAME' => 'Nazwa:',
  'LBL_CONTACT_NAME' => 'Nazwa kontaktu ',
  'LBL_LIST_COMPLETE' => 'Zakończone:',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_DATE_DUE_FLAG' => 'Brak daty zakończenia',
  'LBL_DATE_START_FLAG' => 'Brak daty rozpoczęcia',
  'ERR_DELETE_RECORD' => 'Musisz podać numer rekordu, aby usunąć kontakt.',
  'ERR_INVALID_HOUR' => 'Wpisz godzinę pomiędzy 0 a 24',
  'LBL_DEFAULT_PRIORITY' => 'Średni',
  'LBL_LIST_MY_TASKS' => 'Moje rozpoczęte zadania',
  'LNK_NEW_TASK' => 'Utwórz zadanie',
  'LNK_TASK_LIST' => 'Zadania',
  'LNK_IMPORT_TASKS' => 'Import zadań',
  'LBL_CONTACT_FIRST_NAME'=>'Nazwisko kontaktu',
  'LBL_CONTACT_LAST_NAME'=>'Imię kontaktu',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Przydzielono do',
  'LBL_ASSIGNED_TO_NAME'=>'Przydzielono do:',
  'LBL_LIST_DATE_MODIFIED' => 'Data modyfikacji',
  'LBL_CONTACT_ID' => 'ID kontaktu:',
  'LBL_PARENT_ID' => 'ID jednostki nadrzędnej:',
  'LBL_CONTACT_PHONE' => 'Telefon kontaktu:',
  'LBL_PARENT_NAME' => 'Typ nadrzędny:',
  'LBL_ACTIVITIES_REPORTS' => 'Raport aktywności',
  'LBL_EDITLAYOUT' => 'Edytuj widok' /*for 508 compliance fix*/,
  'LBL_TASK_INFORMATION' => 'Podgląd',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Notatki',
  'LBL_REVENUELINEITEMS' => 'Pozycje szansy',
  //For export labels
  'LBL_DATE_DUE' => 'Data zakończenia',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Przydzielono do',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Przydzielono do',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Zmodyfikowane przez',
  'LBL_EXPORT_CREATED_BY' => 'Utworzone przez',
  'LBL_EXPORT_PARENT_TYPE' => 'Powiązane z modułem',
  'LBL_EXPORT_PARENT_ID' => 'Powiązane z',
  'LBL_TASK_CLOSE_SUCCESS' => 'Zamknięcie zadania powiodło się.',
  'LBL_ASSIGNED_USER' => 'Przydzielono do',

    'LBL_NOTES_SUBPANEL_TITLE' => 'Notatki',

    // Help Text
    // List View Help Text
    'LBL_HELP_RECORDS' => 'Moduł {{plural_module_name}} składa się z elastycznych działań, elementów do wykonania lub jakichkolwiek innych czynności wymagających ukończenia. Rekordy {{module_name}} mogą być powiązane z jednym rekordem w większości modułów poprzez pole „Powiązane z” oraz z jednym modułem {{contacts_singular_module}}. Jest kilka sposobów na utworzenie modułu {{plural_module_name}} w Sugar, np. poprzez moduł {{plural_module_name}}, duplikowanie lub importowanie {{plural_module_name}} itp. Po utworzeniu rekordu {{module_name}}, możesz przeglądać i edytować informacje dotyczące {{module_name}} poprzez widok rekordu {{plural_module_name}}. W zależności od szczegółów modułu {{module_name}} możesz przeglądać i edytować moduł {{module_name}} poprzez moduł Kalendarz. Każdy rekord {{module_name}} może zostać powiązany z innymi rekordami Sugar, np. z {{accounts_module}}, {{contacts_module}}, {{opportunities_module}} oraz wieloma innymi.',

    // Record View Help Text
    'LBL_HELP_RECORD' => 'Moduł {{plural_module_name}} składa się z elastycznych działań, elementów do wykonania lub jakichkolwiek innych czynności wymagających ukończenia.

- Edytuj pola tego rekordu poprze kliknięcie na odpowiednie pole lub na przycisk Edytuj.
- Przeglądaj lub modyfikuj powiązania z innymi rekordami w subpanelach poprzez przełączenie widoku dolnego lewego panelu na “Widok danych”.
- Dodawaj i przeglądaj komentarze użytkowników i historię zmian rekordu w module {{activitystream_singular_module}} poprzez przełączenie widoku dolnego lewego panelu na „Panel aktywności”.
- Obserwuj lub dodaj do ulubionych ten rekord za pomocą ikon znajdujących się z prawej strony nazwy rekordu.
- Dodatkowe działania dostępne są w liście rozwijalnej menu Działania po prawej stronie przycisku Edytuj.',

    // Create View Help Text
    'LBL_HELP_CREATE' => 'Moduł {{plural_module_name}} składa się z elastycznych działań, elementów do wykonania lub jakichkolwiek innych czynności wymagających ukończenia.

Aby utworzyć moduł {{module_name}}:
1. Wprowadź odpowiednie wartości do pól.
- Pola oznaczone jako "Wymagane" muszą zostać uzupełnione przed zapisaniem.
- Kliknij "Pokaż więcej", aby w razie konieczności wyświetlić dodatkowe pola.
2. Kliknij "Zapisz", aby zapisać nowy rekord i powrócić do poprzedniej strony.',

);
