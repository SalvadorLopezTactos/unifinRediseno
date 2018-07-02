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

$mod_strings = array(
    'ERR_DELETE_RECORD' => 'Musisz podać numer rekordu, aby usunąć kontrahenta.',
    'LBL_ACCOUNT_ID' => 'ID kontrahenta:',
    'LBL_CASE_ID' => 'ID zgłoszenia:',
    'LBL_CLOSE' => 'Zamknij:',
    'LBL_COLON' => ':',
    'LBL_CONTACT_ID' => 'ID Kontaktu:',
    'LBL_CONTACT_NAME' => 'Kontakt:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Notatki',
    'LBL_DESCRIPTION' => 'Notatka',
    'LBL_EMAIL_ADDRESS' => 'Adres e-mail:',
    'LBL_EMAIL_ATTACHMENT' => 'Załącznik wiadomości',
    'LBL_FILE_MIME_TYPE' => 'Type mime',
    'LBL_FILE_URL' => 'Plik URL',
    'LBL_FILENAME' => 'Załącznik:',
    'LBL_LEAD_ID' => 'ID Namiaru:',
    'LBL_LIST_CONTACT_NAME' => 'Kontakt',
    'LBL_LIST_DATE_MODIFIED' => 'Ostatnia modyfikacja',
    'LBL_LIST_FILENAME' => 'Załącznik',
    'LBL_LIST_FORM_TITLE' => 'Lista notatek',
    'LBL_LIST_RELATED_TO' => 'Powiązane z',
    'LBL_LIST_SUBJECT' => 'Temat',
    'LBL_LIST_STATUS' => 'Status',
    'LBL_LIST_CONTACT' => 'Kontakt',
    'LBL_MODULE_NAME' => 'Notatki',
    'LBL_MODULE_NAME_SINGULAR' => 'Notatka',
    'LBL_MODULE_TITLE' => 'Notatki: Strona główna',
    'LBL_NEW_FORM_TITLE' => 'Utwórz notatkę lub dodaj załącznik',
    'LBL_NEW_FORM_BTN' => 'Dodaj notatkę',
    'LBL_NOTE_STATUS' => 'Notatka',
    'LBL_NOTE_SUBJECT' => 'Temat:',
    'LBL_NOTES_SUBPANEL_TITLE' => 'Załącznik',
    'LBL_NOTE' => 'Notatka:',
    'LBL_OPPORTUNITY_ID' => 'ID szansy:',
    'LBL_PARENT_ID' => 'ID jednostki nadrzędnej:',
    'LBL_PARENT_TYPE' => 'Typ nadrzędny',
    'LBL_PHONE' => 'Telefon:',
    'LBL_PORTAL_FLAG' => 'Wyświetl w portalu',
    'LBL_EMBED_FLAG' => 'Umieść w wiadomości',
    'LBL_PRODUCT_ID' => 'ID produktu:',
    'LBL_QUOTE_ID' => 'ID oferty:',
    'LBL_RELATED_TO' => 'Powiązane z:',
    'LBL_SEARCH_FORM_TITLE' => 'Wyszukiwanie notatek',
    'LBL_STATUS' => 'Status',
    'LBL_SUBJECT' => 'Temat:',
    'LNK_IMPORT_NOTES' => 'Importuj notatki',
    'LNK_NEW_NOTE' => 'Utwórz notatkę lub dodaj załącznik',
    'LNK_NOTE_LIST' => 'Notatki',
    'LBL_MEMBER_OF' => 'Należy do:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Przydzielono do',
    'LBL_OC_FILE_NOTICE' => 'Zaloguj się na serwer, aby zobaczyć plik',
    'LBL_REMOVING_ATTACHMENT' => 'Usuwanie załącznika...',
    'ERR_REMOVING_ATTACHMENT' => 'Nie można usunąć załącznika...',
    'LBL_CREATED_BY' => 'Utworzone przez',
    'LBL_MODIFIED_BY' => 'Zmodyfikowane przez',
    'LBL_SEND_ANYWAYS' => 'Ta wiadomość nie ma tematu. Czy na pewno chcesz wysłać wiadomość bez tematu?',
    'LBL_LIST_EDIT_BUTTON' => 'Edytuj',
    'LBL_ACTIVITIES_REPORTS' => 'Raport aktywności',
    'LBL_PANEL_DETAILS' => 'Szczegóły',
    'LBL_NOTE_INFORMATION' => 'Przegląd informacji',
    'LBL_MY_NOTES_DASHLETNAME' => 'Moje notatki',
    'LBL_EDITLAYOUT' => 'Edytuj widok' /*for 508 compliance fix*/,
    //For export labels
    'LBL_FIRST_NAME' => 'Imię',
    'LBL_LAST_NAME' => 'Nazwisko',
    'LBL_EXPORT_PARENT_TYPE' => 'Powiązane z modułem',
    'LBL_EXPORT_PARENT_ID' => 'Powiązane z',
    'LBL_DATE_ENTERED' => 'Data utworzenia',
    'LBL_DATE_MODIFIED' => 'Data modyfikacji',
    'LBL_DELETED' => 'Usunięto',
    'LBL_REVENUELINEITEMS' => 'Pozycje szansy',

    // Help Text
    // List View Help Text
    'LBL_HELP_RECORDS' => '{{plural_module_name}} jest zbiorem modułów {{plural_module_name}}, które zawierają tekst lub załączniki odpowiednie dla powiązanego rekordu.
Rekordy {{module_name}} mogą być powiązane z jednym rekordem w większości modułów poprzez pole elastycznego powiązania lub z pojedynczym modułem {{contacts_singular_module}}.
{{plural_module_name}} może zawierać ogólny tekst dotyczący rekordu lub załącznik powiązany z rekordem.
W Sugar można na różne sposoby utworzyć moduł {{plural_module_name}}, na przykład poprzez moduł {{plural_module_name}}, importowanie {{plural_module_name}}, za pomocą subpaneli Historia itp.
Po utworzeniu rekordu {{module_name}}, można wyświetlać i edytować informacje dotyczące modułu {{module_name}}, korzystając z widoku {{plural_module_name}}. Każdy rekord {{module_name}} można następnie powiązać z innymi rekordami Sugar, takimi jak {{accounts_module}}, {{contacts_module}}, {{opportunities_module}} i wieloma innymi.',

    // Record View Help Text
    'LBL_HELP_RECORD' => 'Moduł {{plural_module_name}} składa się z pojedynczych modułów {{plural_module_name}}, które zawierają tekst lub załącznik dotyczący powiązanego rekordu.

- Edytuj pola tego rekordu poprze kliknięcie na odpowiednie pole lub na przycisk Edytuj.
- Przeglądaj lub modyfikuj powiązania z innymi rekordami w subpanelach poprzez przełączenie widoku dolnego lewego panelu na “Widok danych”.
- Dodawaj i przeglądaj komentarze użytkowników i historię zmian rekordu w module {{activitystream_singular_module}} poprzez przełączenie widoku dolnego lewego panelu na „Panel aktywności”.
- Obserwuj lub dodaj do ulubionych ten rekord za pomocą ikon znajdujących się z prawej strony nazwy rekordu.
- Dodatkowe działania dostępne są w liście rozwijalnej menu Działania po prawej stronie przycisku Edytuj.',

    // Create View Help Text
    'LBL_HELP_CREATE' => 'Aby utworzyć moduł {{module_name}}:
1. Wprowadź odpowiednie wartości do pól.
- Pola oznaczone jako "Wymagane" muszą zostać uzupełnione przed zapisem.
- Kliknij "Pokaż więcej", aby w razie konieczności wyświetlić dodatkowe pola.
2. Kliknij "Zapisz", aby zapisać nowy rekord i powrócić do poprzedniej strony.',
);
