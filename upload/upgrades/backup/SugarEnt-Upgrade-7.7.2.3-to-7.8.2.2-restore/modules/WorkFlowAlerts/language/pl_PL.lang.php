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
/*********************************************************************************

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$mod_strings = array (
  'LBL_MODULE_NAME' => 'Lista uczestników Workflow',
  'LBL_MODULE_NAME_SINGULAR' => 'Lista uczestników Workflow',
  'LBL_MODULE_TITLE' => 'Uczestnicy Workflow: Strona główna',
  'LBL_SEARCH_FORM_TITLE' => 'Wyszukiwanie uczestników Workflow',
  'LBL_LIST_FORM_TITLE' => 'Lista odbiorców',
  'LBL_NEW_FORM_TITLE' => 'Utwórz odbiorcę Workflow',

  'LBL_LIST_USER_TYPE' => 'Typ użytkownika',
  'LBL_LIST_ARRAY_TYPE' => 'Typ działania',
  'LBL_LIST_RELATE_TYPE' => 'Powiązane działania',
  'LBL_LIST_ADDRESS_TYPE' => 'Typ adresu',
  'LBL_LIST_FIELD_VALUE' => 'Użytkownik',
  'LBL_LIST_REL_MODULE1' => 'Moduł powiązany',
  'LBL_LIST_REL_MODULE2' => 'Moduł powiązany z modułem powiązanym:',
  'LBL_LIST_WHERE_FILTER' => 'Status',

  'LBL_USER_TYPE' => 'Typ użytkownika',
  'LBL_ARRAY_TYPE' => 'Typ akcji:',
  'LBL_RELATE_TYPE' => 'Typ zależności:',
  'LBL_WHERE_FILTER' => 'Status:',
  'LBL_FIELD_VALUE' => 'Użytkownik',
  'LBL_REL_MODULE1' => 'Moduł powiązany:',
  'LBL_REL_MODULE2' => 'Moduł powiązany z modułem powiązanym:',
  'LBL_CUSTOM_USER' => 'Użytkownik',

  'LNK_NEW_WORKFLOW' => 'Utwórz Workflow',
  'LNK_WORKFLOW' => 'Workflow',
  'LBL_LIST_STATEMENT' => 'Odbiorcy alertów:',
  'LBL_LIST_STATEMENT_CONTENT' => 'Wyślij alert do użytkownika:',

  /////////New UI Labels

  'LBL_ALERT_CURRENT_USER' => 			'Użytkownik przydzielony do modułu głównego',
  'LBL_ALERT_CURRENT_USER_TITLE' =>		'Użytkownik przydzielony do modułu głównego',
  'LBL_ALERT_REL_USER' => 				'Użytkownik przydzielony do modułu powiązanego',
  'LBL_ALERT_REL_USER_TITLE' => 		'Użytkownik przydzielony do modułu powiązanego',
  'LBL_ALERT_REL_USER_CUSTOM' => 		'Odbiorca przydzielony do modułu powiązanego',
  'LBL_ALERT_REL_USER_CUSTOM_TITLE' => 	'Odbiorca przydzielony do modułu powiązanego',
  'LBL_ALERT_TRIG_USER_CUSTOM' => 		'Odbiorca przydzielony do modułu głównego',
  'LBL_ALERT_TRIG_USER_CUSTOM_TITLE' => 	'Odbiorca przydzielony do modułu głównego',
  'LBL_ALERT_SPECIFIC_USER' => 			'Określony',
  'LBL_ALERT_SPECIFIC_USER_TITLE' => 	'Określony użytkownik',
  'LBL_ALERT_SPECIFIC_TEAM' => 			'Wszyscy użytkownicy w określonym',
  'LBL_ALERT_SPECIFIC_TEAM_TITLE' => 	'Wszyscy użytkownicy w określonym zespole',
  'LBL_ALERT_SPECIFIC_ROLE' => 			'Wszyscy użytkownicy w określonej',
  'LBL_ALERT_SPECIFIC_ROLE_TITLE' => 	'Wszyscy użytkownicy w określonej roli',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET_TITLE' => 	'Członkowie zespołu powiązanego z modułem głównym',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET' => 	'Wszyscy użytkownicy, którzy należą do zespołu(ów) powiązanych z modułem głównym',
  'LBL_ALERT_LOGIN_USER_TITLE' => 		'Zalogowani użytkownicy w czasie wykonywania',
  'LBL_RECORD' => 'Moduł',
  'LBL_TEAM' => 'Zespół',
  'LBL_USER' => 'Użytkownik',
  'LBL_USER_MANAGER' => 'Menedżer',
  'LBL_ROLE' => 'rola',


  'LBL_SEND_EMAIL' => 'Wyślij e-mail do:',
  'LBL_USER1' => ', który utworzył rekord',
  'LBL_USER2' => ', który ostatnio zmodyfikował rekord',
  'LBL_USER3' => 'Bieżący',
  'LBL_USER3b' => 'systemu.',
  'LBL_USER4' => ', który jest przydzielony do rekordu',
  'LBL_USER5' => ', który był przydzielony do rekordu',

  'LBL_ADDRESS_TO' => 'DO:',
  'LBL_ADDRESS_CC' => 'DW:',
  'LBL_ADDRESS_BCC' => 'UDW:',
  'LBL_ADDRESS_TYPE' => 'użyj adresów',
  'LBL_ADDRESS_TYPE_TARGET' => 'typ',


  'LBL_ALERT_REL1' => 'Moduł powiązany:',
  'LBL_ALERT_REL2' => 'Moduł powiązany z modułem powiązanym:',

  'LBL_NEXT_BUTTON' => 'Dalej',
  'LBL_PREVIOUS_BUTTON' => 'Wstecz',

	'LBL_BLANK' => '',

	'NTC_REMOVE_ALERT_USER' => 'Czy na pewno chcesz usunąć tego odbiorcę alertu?',



	//rel_user_custom

	'LBL_REL_CUSTOM_STRING' => 'Wybierz Adres e-mail i nazwy pól',
	'LBL_REL_CUSTOM' => 'Wybierz pole Adres e-mail',
	'LBL_REL_CUSTOM2' => 'Pole',
	'LBL_AND' => 'i nazwę Pola:',
	'LBL_REL_CUSTOM3' => 'Pole',
	'LBL_FILTER_CUSTOM' => '(Dodatkowy filtr) Filruj powiązany moduł po określonym:',
	'LBL_FIELD' => 'Pole',
	'LBL_SPECIFIC_FIELD' => 'polu',
	'LBL_FILTER_BY' => '(Dodatkowy filtr) Filruj powiązany moduł po określonym',


	//Invite Labels
	  'LBL_MODULE_NAME_INVITE' => 'Lista uczestników',
	'LBL_MODULE_NAME_SINGULAR_INVITE' => 'Lista uczestników',
	  'LBL_LIST_STATEMENT_INVITE' => 'Uczestnicy spotkania/rozmowy tel.:',

	'LBL_SELECT_VALUE' => 'Musisz wybrać prawidłową wartość.',
	'LBL_SELECT_NAME' => 'Musisz uzupełnić pole Nazwa',
	'LBL_SELECT_EMAIL' => 'Musisz uzupełnić pole Adres e-mail',
	'LBL_SELECT_FILTER' => 'Musisz uzupełnić pole filtrujące',
	'LBL_SELECT_NAME_EMAIL' => 'Musisz uzupełnić pola Nazwa i Adres e-mail',
	'LBL_PLEASE_SELECT' => 'Wybierz',
	'LBL_EDITLAYOUT' => 'Edytuj widok' /*for 508 compliance fix*/,
);


?>
