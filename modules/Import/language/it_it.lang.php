<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/*********************************************************************************
 * Description:    Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/
global $timedate;

$mod_strings = [
    'LBL_GOOD_FILE' => 'Lettura di importazione del file avvenuta con successo.',
    'LBL_RECORD_CONTAIN_LOCK_FIELD' => 'Il record importato sta partecipando a un flusso e non può essere modificato perché alcuni campi sono bloccati per la modifica dal flusso.',
    'LBL_RECORDS_SKIPPED_DUE_TO_ERROR' => 'Records saltato a causa di un errore',
    'LBL_UPDATE_SUCCESSFULLY' => 'Record creati o aggiornati con successo',
    'LBL_SUCCESSFULLY_IMPORTED' => 'Record creati con successo',
    'LBL_STEP_4_TITLE' => 'Step 4: Importa il File',
    'LBL_STEP_5_TITLE' => 'Step 5: Visualizza i risultati',
    'LBL_CUSTOM_ENCLOSURE' => 'Campi qualificati da:',
    'LBL_ERROR_UNABLE_TO_PUBLISH' => 'Impossibile pubblicare. Esiste un´altro import map con lo stesso nome.',
    'LBL_ERROR_UNABLE_TO_UNPUBLISH' => 'Impossibile non-pubblicare una mappa di proprietà di un altro utente. Sei proprietario di un Import map con lo stesso nome.',
    'LBL_ERROR_IMPORTS_NOT_SET_UP' => 'Le importazione non sono previste per questo tipo di modulo',
    'LBL_IMPORT_TYPE' => 'Cosa ti piacerebbe fare con i dati importati?',
    'LBL_IDM_IMPORT_TYPE_CREATE' => 'Create New Records',
    'LBL_IDM_IMPORT_TYPE_UPDATE' => 'Update Existing Records',
    'LBL_IMPORT_BUTTON' => 'Creare solo nuovi record',
    'LBL_UPDATE_BUTTON' => 'Creare nuovi record e aggiornare quelli esistenti',
    'LBL_CREATE_BUTTON_HELP' => 'Per creare nuovi record usare questa opzione. Nota: le righe nel file di importazione contenenti valori che corrispondono all´ID di record esistenti non verranno importanti se i valori sono mappati al campo ID.',
    'LBL_UPDATE_BUTTON_HELP' => 'Utilizzare questa opzione per aggiornare i record esistenti. I valori nel file di importazione saranno mappati con i record esistenti sulla base dell´ID del record nel file di importazione.',
    'LBL_NO_ID' => 'ID Richiesto',
    'LBL_PRE_CHECK_SKIPPED' => 'Pre-Selezione saltata',
    'LBL_NOLOCALE_NEEDED' => 'Nessuna conversione locale richiesta',
    'LBL_FIELD_NAME' => 'Nome Campo',
    'LBL_VALUE' => 'Valore',
    'LBL_ROW_NUMBER' => 'Numero riga',
    'LBL_NONE' => 'Nessuno',
    'LBL_REQUIRED_VALUE' => 'Manca il valore richiesto',
    'LBL_ERROR_SYNC_USERS' => 'Valore non valido per la sincronizzazione in Outlook:',
    'LBL_ID_EXISTS_ALREADY' => 'ID esiste già in questa tabella',
    'LBL_SYNC_KEY_EXISTS_ALREADY' => 'SYNC_KEY già esistente in questa tabella',
    'LBL_ASSIGNED_USER' => 'Se l´utente non esiste utilizzare l´utente corrente',
    'LBL_SHOW_HIDDEN' => 'Mostra i campi che non sono normalmente importabili',
    'LBL_UPDATE_RECORDS' => 'Aggiornare record esistenti invece di importarli (No annullare)',
    'LBL_TEST' => 'Test d´Importazione (non salvare o modificare dati)',
    'LBL_TRUNCATE_TABLE' => 'Tabella vuoti prima di dell´importazione (cancellare tutti i records)',
    'LBL_RELATED_ACCOUNTS' => 'Non creare le aziende relative',
    'LBL_NO_DATECHECK' => 'Salva il controllo della data (più veloce ma non andrà a buon fine se la data è sbagliata)',
    'LBL_NO_WORKFLOW' => 'Non eseguire il workflow durante l´importazione',
    'LBL_NO_EMAILS' => 'Non inviare notifiche e-mail nel corso di questa importazione',
    'LBL_NO_PRECHECK' => 'Modalità Formato Nativo',
    'LBL_STRICT_CHECKS' => 'Usa livello massimo di regole (controllare indirizzi e-mail e anche i numeri di telefono)',
    'LBL_ERROR_SELECTING_RECORD' => 'Errore di selezione record:',
    'LBL_ERROR_DELETING_RECORD' => 'Errore nella cancellazione del record:',
    'LBL_NOT_SET_UP' => 'L´importazione non è prevista per questo tipo di modulo',
    'LBL_ARE_YOU_SURE' => 'Sei sicuro? Quest´operazione eliminerà tutti i dati di questo modulo.',
    'LBL_NO_RECORD' => 'Nessun record con questo ID da aggiornare',
    'LBL_NOT_SET_UP_FOR_IMPORTS' => 'L´importazione non è prevista per questo tipo di modulo',
    'LBL_DEBUG_MODE' => 'Attiva la modalità debug',
    'LBL_ERROR_INVALID_ID' => 'ID dato è troppo lungo da adattare al campo (la lunghezza massima è 36 caratteri)',
    'LBL_ERROR_INVALID_PHONE' => 'Telefono non valido',
    'LBL_ERROR_INVALID_NAME' => 'Stringa troppo lunga da adattare al campo',
    'LBL_ERROR_INVALID_VARCHAR' => 'Stringa troppo lunga da adattare al campo',
    'LBL_ERROR_INVALID_DATETIME' => 'Dataora non valida',
    'LBL_ERROR_INVALID_DATETIMECOMBO' => 'Dataora non valida',
    'LBL_ERROR_INVALID_INT' => 'Numero intero non valido',
    'LBL_ERROR_INVALID_NUM' => 'Valore numerico non valido',
    'LBL_ERROR_INVALID_TIME' => 'Ora non valida',
    'LBL_ERROR_INVALID_EMAIL' => 'Indirizzo email non valido',
    'LBL_ERROR_INVALID_BOOL' => 'Valore non valido (dovrebbe essere 1 o 0)',
    'LBL_ERROR_INVALID_DATE' => 'Invalid date dtring',
    'LBL_ERROR_INVALID_USER' => 'Nome utente o Id non validi',
    'LBL_ERROR_INVALID_TEAM' => 'Nome gruppo o Id non validi',
    'LBL_ERROR_INVALID_ACCOUNT' => 'Nome azienda o Id non validi',
    'LBL_ERROR_INVALID_RELATE' => 'Campo invalido',
    'LBL_ERROR_INVALID_CURRENCY' => 'Valore della valuta non valido',
    'LBL_ERROR_INVALID_FLOAT' => 'Numero a virgola mobile non valido',
    'LBL_ERROR_NOT_IN_ENUM' => 'Il valore non è nell´elenco DropDown. I valori permessi sono:',
    'LBL_ERROR_ENUM_EMPTY' => 'Valore non presente nell&#39;elenco dropDown. L&#39;elenco dropDown è vuoto',
    'LBL_NOT_MULTIENUM' => 'Non un MultiEnum',
    'LBL_IMPORT_MODULE_NO_TYPE' => 'L´importazione non è prevista per questo tipo di modulo',
    'LBL_IMPORT_MODULE_NO_USERS' => 'ATTENZIONE: Non ci sono utenti definiti nel tuo sistema. Se si esegue l´importazione senza prima aggiungere gli utenti, tutti i records saranno di proprietà dell´Ammiistratore.',
    'LBL_IMPORT_MODULE_MAP_ERROR' => 'Impossibile pubblicare. Esiste un´altro import map con lo stesso nome.',
    'LBL_IMPORT_MODULE_MAP_ERROR2' => 'Impossibile non-pubblicare una mappa di proprietà di un altro utente. Sei proprietario di un Import map con lo stesso nome.',
    'LBL_IMPORT_MODULE_NO_DIRECTORY' => 'La cartella',
    'LBL_IMPORT_MODULE_NO_DIRECTORY_END' => 'non esiste o non è scrivibile',
    'LBL_IMPORT_MODULE_ERROR_NO_UPLOAD' => 'Il file non è stato caricato con successo.  E´ possibile che la dimensione dell´upload_max_ file d´impostazione nel tuo php.ini file è impostato su un numero piccolo',
    'LBL_IMPORT_MODULE_ERROR_LARGE_FILE' => 'Il file è troppo grande. Massimo:',
    'LBL_IMPORT_MODULE_ERROR_LARGE_FILE_END' => 'Byte. Cambiare $sugar_config[&#39;upload_maxsize&#39;] in config.php',
    'LBL_MODULE_NAME' => 'Importa',
    'LBL_MODULE_NAME_SINGULAR' => 'Importazione',
    'LBL_TRY_AGAIN' => 'Riprova',
    'LBL_START_OVER' => 'Ricominciare',
    'LBL_ERROR' => 'Errore:',
    'LBL_IMPORT_ERROR_MAX_REC_LIMIT_REACHED' => 'Il file di importazione contiene {0} righe. Il numero ottimale di righe è {1}. Più righe potrebbero rallentare il processo di importazione. Clicca OK per continuare con l´importazione. Clicca Annulla per modificare il file e ricaricarlo.',
    'ERR_IMPORT_SYSTEM_ADMININSTRATOR' => 'Non è possibile importare un utente amministratore del sistema.',
    'ERR_REPORT_LOOP' => 'Il sistema ha rilevato un ciclo senza uscita. Un utente non può dipendere da sè stesso, nè un superiore dipendere da un subordinato.',
    'ERR_MULTIPLE' => 'Sono state definite colonne multiple con lo stesso nome campo.',
    'ERR_MISSING_REQUIRED_FIELDS' => 'Mancano campi richiesti:',
    'ERR_MISSING_MAP_NAME' => 'Mancata mappatura del nome personalizzato',
    'ERR_USERS_IMPORT_DISABLED_TO_IDM_MODE' => 'L&#39;importazione di utenti è disattivata per la modalità IDM.',
    'ERR_SELECT_FULL_NAME' => 'Non puoi selezionare il Nome completo quando sia Nome che cognome sono selezionati.',
    'ERR_SELECT_FILE' => 'Seleziona un file da caricare.',
    'LBL_SELECT_FILE' => 'Seleziona file:',
    'LBL_CUSTOM' => 'Personalizzato',
    'LBL_CUSTOM_CSV' => 'File con valori separati da virgola',
    'LBL_CSV' => 'File con valori separati da virgola',
    'LBL_EXTERNAL_SOURCE' => 'Applicazione esterna o servizio',
    'LBL_TAB' => 'File con valori separati da Tab',
    'LBL_CUSTOM_DELIMITED' => 'File con valori separati da altri simboli',
    'LBL_CUSTOM_DELIMITER' => 'Campi separati da:',
    'LBL_FILE_OPTIONS' => 'Opzioni File',
    'LBL_CUSTOM_TAB' => 'File con valori separati da Tab',
    'LBL_DONT_MAP' => '-- Non importare questo campo --',
    'LBL_STEP_MODULE' => 'Per quale modulo vuoi importare dati?',
    'LBL_STEP_1_TITLE' => 'Step 1: Seleziona la fonte dei dati',
    'LBL_CONFIRM_TITLE' => 'Step {0}: Conferma le proprietà del file di importazione',
    'LBL_CONFIRM_EXT_TITLE' => 'Step {0}: Conferma le proprietà della fonte esterna',
    'LBL_WHAT_IS' => 'Qual è la fonte dei dati?',
    'LBL_MICROSOFT_OUTLOOK' => 'Microsoft Outlook',
    'LBL_MICROSOFT_OUTLOOK_HELP' => 'Le mappature personalizzare per Microsoft Outlook si basano su file di importazione delimitati da virgole (.csv). Se il tuo file di importazione è delimitato da tab, la mappatura non sarà applicata come previsto.',
    'LBL_ACT' => 'Agisci!',
    'LBL_SALESFORCE' => 'Salesforce',
    'LBL_MY_SAVED' => 'Le mie Risorse:',
    'LBL_PUBLISH' => 'Pubblica',
    'LBL_DELETE' => 'Cancella',
    'LBL_PUBLISHED_SOURCES' => 'Fonti pubblicate:',
    'LBL_UNPUBLISH' => 'Non-Pubblicato',
    'LBL_NEXT' => 'Avanti >',
    'LBL_BACK' => '< Indietro',
    'LBL_STEP_2_TITLE' => 'Step 2: Carica il file di importazione',
    'LBL_HAS_HEADER' => 'Il file comprende l´intestazione:',
    'LBL_NUM_1' => '1',
    'LBL_NUM_2' => '2',
    'LBL_NUM_3' => '3',
    'LBL_NUM_4' => '4',
    'LBL_NUM_5' => '5',
    'LBL_NUM_6' => '6',
    'LBL_NUM_7' => '7',
    'LBL_NUM_8' => '8',
    'LBL_NUM_9' => '9',
    'LBL_NUM_10' => '10',
    'LBL_NUM_11' => '11',
    'LBL_NUM_12' => '12',
    'LBL_NOTES' => 'Nota:',
    'LBL_NOW_CHOOSE' => 'Ora scegli il file da importare:',
    'LBL_IMPORT_OUTLOOK_TITLE' => 'Microsoft Outlook 98 e 2000 può esportare dati in formato <b>Valori Separati da Virgola</b>, che può essere utilizzato anche per importare dati all´interno del sistema. Per esportare i tuoi dati da Outlook, si prega di seguire i passi qui sotto:',
    'LBL_OUTLOOK_NUM_1' => 'Avvia <b>Outlook</b>',
    'LBL_OUTLOOK_NUM_2' => 'Seleziona il menu <b>File</b>, poi opzione <b>Importa e Esporta ...</b>',
    'LBL_OUTLOOK_NUM_3' => 'Scegli <b>Esporta in un file</b> e clicca Prossimo',
    'LBL_OUTLOOK_NUM_4' => 'Scegli <b>Comma Separated Values (Windows)</b> e clicca <b>Prossimo</b>.<br>  Nota: potresti dover istallare il componente di export',
    'LBL_OUTLOOK_NUM_5' => 'Seleziona la cartella <b>Contatti</b> e clicca <b>Prossimo</b>. Puoi selezionare diverse cartelle di contatti se i tuoi contatti sono in varie cartelle',
    'LBL_OUTLOOK_NUM_6' => 'Scegli un nome file e clicca <b>Prossimo</b>',
    'LBL_OUTLOOK_NUM_7' => 'Clicca <b>Fine</b>',
    'LBL_IMPORT_SF_TITLE' => 'Salesforce.com può esportare dati in formato <b>Valori Separati da Virgola</b>, che può essere utilizzato anche per importare dati all´interno del sistema. Per esportare i tuoi dati da Salesforce.com, si prega di seguire i passi qui sotto:',
    'LBL_SF_NUM_1' => 'Apri il tuo browser, vai su http://www.salesforce.com, e collegati con il tuo indirizzo email e la password',
    'LBL_SF_NUM_2' => 'Seleziona sul tab <b>Report</b> nel menu in alto',
    'LBL_SF_NUM_3' => 'Per esportare le aziende:</b> Clicca sul link <b>Active Accounts</b> link<br><b>Per esportare i contatti:</b> Clicca sul link <b>Mailing List</b> link',
    'LBL_SF_NUM_4' => 'Su <b>Step 1: Scegli il tipo di rapporto</b>, seleziona <b>Rapporto Tabulare</b>clicca <b>Procedi</b>',
    'LBL_SF_NUM_5' => 'Su <b>Step 2: Scegli le colonne del rapporto</b>, seleziona le colonne che vuoi esportare e clicca <b>Procedi</b>',
    'LBL_SF_NUM_6' => 'Su <b>Step 3: Scegli le informazioni da sommaree</b>, clicca <b>Procedi</b>',
    'LBL_SF_NUM_7' => 'Su <b>Step 4: Ordina le colonne del rapporto</b>, clicca <b>Procedi</b>',
    'LBL_SF_NUM_8' => 'Su <b>Step 5: Scegli il criterio del rapporto</b>, sotto <b>Data Inizio</b>, scegli una data passata sufficiente per includere tutti le Aziende. Puoi anche esportare un sottoinsieme delle aziende usando criteri più avanzati. Quando hai finito, clicca <b>Esegui Rapporto</b>',
    'LBL_SF_NUM_9' => 'Sarà generato un rapporto, e la pagina dovrebbe mostrare <b>Stato Generazione Rapporto: Completo.</b> Ora clicca <b>Esporta in Excel</b>',
    'LBL_SF_NUM_10' => 'Su <b>Esporta Report:</b>, per <b>Formato File da Esportare:</b>, scegli <b>Valori Separati da Virgola .csv</b>. Clicca <b>Esporta</b>.',
    'LBL_SF_NUM_11' => 'Apparirà un dialogo per salvare il file esportato sul tuo computer.',
    'LBL_IMPORT_ACT_TITLE' => 'Act! può esportare dati in formato <b>Valori Separati da Virgola</b>, che possono essere utilizzati anche per importare dati all´interno del sistema. Per esportare i tuoi dati da Act!, si prega di seguire i passi qui sotto:',
    'LBL_ACT_NUM_1' => 'Lancia <b>ACT!</b>',
    'LBL_ACT_NUM_2' => 'Selezionare il menù <b>File</b>, il <b>Cambio Data</b> menù opzioni,poi l´<b>Esporta...</b> menù opzioni',
    'LBL_ACT_NUM_3' => 'Selezionare il tipo di file <b>Testo-Delimitato</b>',
    'LBL_ACT_NUM_4' => 'Scegli un nome da attribure al file e una posizione per esportare dati e poi cliccare <b>Prossimo</b>',
    'LBL_ACT_NUM_5' => 'Selezionare <b>solo i records dei contatti</b>',
    'LBL_ACT_NUM_6' => 'Cliccare il pulsante <b>Opzioni...</b>',
    'LBL_ACT_NUM_7' => 'Seleziona<b>Virgola</b> come separatore tra campi',
    'LBL_ACT_NUM_8' => 'Seleziona <b>Si, esporta i nomi dei campi</b> e clicca <b>OK</b>',
    'LBL_ACT_NUM_9' => 'Cliccare <b>Avanti</b>',
    'LBL_ACT_NUM_10' => 'Selezionare <b>Tutti i Record</b> e poi cliccare <b>Fine</b>',
    'LBL_IMPORT_CUSTOM_TITLE' => 'Molte applicazioni ti permettono di esportare dati in formato <b>Comma Delimited text file (.csv)</b> seguendo questi passi generali:',
    'LBL_CUSTOM_NUM_1' => 'Esegui applicazione e apri il file di dati',
    'LBL_CUSTOM_NUM_2' => 'Seleziona il <b>Salva con Nome...</b> o opzione di menu <b>Esporta...</b>',
    'LBL_CUSTOM_NUM_3' => 'Salva il file in formato <b>CSV</b> o <b>Valori Separati da virgola (Comma Separated Values)</b>',
    'LBL_IMPORT_TAB_TITLE' => 'Molte applicazioni ti permettono di esportare dati in formato <b>Tab Delimited text file (.tsv or .tab)</b>seguendo questi passi generali:',
    'LBL_TAB_NUM_1' => 'Eseguire applicazione e apri il file di dati',
    'LBL_TAB_NUM_2' => 'Selezionare il <b>Salva con Nome...</b> o opzione di menu <b>Esporta...</b>',
    'LBL_TAB_NUM_3' => 'Salvare il file nel formato <b>TSV</b> o <b>Valori Separati da Tab</b>',
    'LBL_STEP_3_TITLE' => 'Step 3: conferma i campi e importa',
    'LBL_STEP_DUP_TITLE' => 'Step {0}: Controlla la presenza di possibili duplicati',
    'LBL_SELECT_FIELDS_TO_MAP' => 'Nell´elenco qui sotto, selezionare i campi del file di importazione, che dovrebbero essere importati in ogni campo del sistema. Quando hai terminato, cliccare <b>Importa Ora</b>:',
    'LBL_DATABASE_FIELD' => 'Campi del database',
    'LBL_HEADER_ROW' => 'Riga di intestazione',
    'LBL_HEADER_ROW_OPTION_HELP' => 'Seleziona se la prima riga del file di importazione è la riga di intestazione contenente le etichette dei campi.',
    'LBL_ROW' => 'Riga',
    'LBL_SAVE_AS_CUSTOM' => 'Salva come Mapping Personalizzata:',
    'LBL_SAVE_AS_CUSTOM_NAME' => 'Nome Mapping Personalizzata:',
    'LBL_CONTACTS_NOTE_1' => 'Devi mappare o il Cognome o il Nome completo.',
    'LBL_CONTACTS_NOTE_2' => 'Se mappi il Nome completo, allora Nome e Cognome vengono ignorati.',
    'LBL_CONTACTS_NOTE_3' => 'Se mappi il Nome completo, allora i dati in questo campo verranno separati in Nome e Cognome  durante inserimento nel database.',
    'LBL_CONTACTS_NOTE_4' => 'I campi Indirizzo 2 e Indirizzo 3 sono concatenati assieme a Indirizzo durante l´inserimento nel database.',
    'LBL_ACCOUNTS_NOTE_1' => 'Il nome azienda deve essere mappato.',
    'LBL_REQUIRED_NOTE' => 'Campo Rimosso:',
    'LBL_IMPORT_NOW' => 'Importa ora',
    'LBL_' => '',
    'LBL_CANNOT_OPEN' => 'Non posso aprire in lettura il file di import',
    'LBL_NOT_SAME_NUMBER' => 'Non ci sono lo stesso numero di campi per riga nel tuo file',
    'LBL_NO_LINES' => 'Non sono state rilevate righe nel tuo file di importazione. Assicurarsi che non ci siano righe vuote nel tuo file e riprovare.',
    'LBL_FILE_ALREADY_BEEN_OR' => 'Il file di import è gia stato processato o non esiste',
    'LBL_SUCCESS' => 'Riuscito:',
    'LBL_FAILURE' => 'Importazione fallita:',
    'LBL_SUCCESSFULLY' => 'Importazione riuscita',
    'LBL_LAST_IMPORT_UNDONE' => 'La tua ultima importazione è stato annullata',
    'LBL_NO_IMPORT_TO_UNDO' => 'Non ci sono importazioni da annullare.',
    'LBL_FAIL' => 'Fallito:',
    'LBL_RECORDS_SKIPPED' => 'Righe saltate',
    'LBL_IDS_EXISTED_OR_LONGER' => 'ID che già esistono o sono più lunghe di 36 caratteri',
    'LBL_RESULTS' => 'Risultati',
    'LBL_CREATED_TAB' => 'Record creati',
    'LBL_DUPLICATE_TAB' => 'Duplicati',
    'LBL_ERROR_TAB' => 'Errori',
    'LBL_IMPORT_MORE' => 'Importa ancora',
    'LBL_FINISHED' => 'Ritorna a',
    'LBL_UNDO_LAST_IMPORT' => 'Annulla ultima Importazione',
    'LBL_LAST_IMPORTED' => 'Ultimo Importato',
    'ERR_MULTIPLE_PARENTS' => 'Si può definire un unico Parent ID',
    'LBL_DUPLICATES' => 'Duplicati Trovati',
    'LNK_DUPLICATE_LIST' => 'Scarica l´elenco dei duplicati',
    'LNK_ERROR_LIST' => 'Scarica l´elenco degli errori',
    'LNK_RECORDS_SKIPPED_DUE_TO_ERROR' => 'Scarica i record che non possono essere importati.',
    'LBL_UNIQUE_INDEX' => 'Scegli l´indice per il confronto dei duplicati',
    'LBL_VERIFY_DUPS' => 'Verificare voci duplicate contro gli indici selezionati.',
    'LBL_INDEX_USED' => 'Indici usati:',
    'LBL_INDEX_NOT_USED' => 'Indici non usati:',
    'LBL_IMPORT_MODULE_ERROR_NO_MOVE' => 'Il file non è stato aggiornato con successo.  Cerca i permessi dei file nella directory cahe dell installazione di Sugar',
    'LBL_IMPORT_FIELDDEF_ID' => 'Numero ID unico',
    'LBL_IMPORT_FIELDDEF_RELATE' => 'Nome o ID',
    'LBL_IMPORT_FIELDDEF_PHONE' => 'Telefono',
    'LBL_IMPORT_FIELDDEF_TEAM_LIST' => 'ID Nome gruppo',
    'LBL_IMPORT_FIELDDEF_NAME' => 'Qualsiasi Testo',
    'LBL_IMPORT_FIELDDEF_VARCHAR' => 'Qualsiasi Testo',
    'LBL_IMPORT_FIELDDEF_TEXT' => 'Qualsiasi Testo',
    'LBL_IMPORT_FIELDDEF_TIME' => 'Ora',
    'LBL_IMPORT_FIELDDEF_DATE' => 'Date',
    'LBL_IMPORT_FIELDDEF_DATETIME' => 'Data/ora',
    'LBL_IMPORT_FIELDDEF_ASSIGNED_USER_NAME' => 'Nome utente o ID',
    'LBL_IMPORT_FIELDDEF_BOOL' => '´0´ o ´1´',
    'LBL_IMPORT_FIELDDEF_ENUM' => 'Elenco',
    'LBL_IMPORT_FIELDDEF_EMAIL' => 'Indirizzo Email',
    'LBL_IMPORT_FIELDDEF_INT' => 'Numerico (No Decimali)',
    'LBL_IMPORT_FIELDDEF_DOUBLE' => 'Numerico (No Decimali)',
    'LBL_IMPORT_FIELDDEF_NUM' => 'Numerico (No Decimali)',
    'LBL_IMPORT_FIELDDEF_CURRENCY' => 'Numerico (Decimali Permessi)',
    'LBL_IMPORT_FIELDDEF_FLOAT' => 'Numerico (Decimali Permessi)',
    'LBL_DATE_FORMAT' => 'Formato Data:',
    'LBL_TIME_FORMAT' => 'Formato Ora:',
    'LBL_TIMEZONE' => 'Fuso Orario:',
    'LBL_ADD_ROW' => 'Aggiungi Campo',
    'LBL_REMOVE_ROW' => 'Campo Rimosso',
    'LBL_DEFAULT_VALUE' => 'Valore di Default',
    'LBL_SHOW_ADVANCED_OPTIONS' => 'Mostra Opzioni Avanzate',
    'LBL_HIDE_ADVANCED_OPTIONS' => 'Nascondi Opzioni Avanzate',
    'LBL_SHOW_NOTES' => 'Visualizza Note',
    'LBL_HIDE_NOTES' => 'Nascondi Note',
    'LBL_SHOW_PREVIEW_COLUMNS' => 'Mostra l´anteprima delle colonne',
    'LBL_HIDE_PREVIEW_COLUMNS' => 'Nascondi l´anteprima delle colonne',
    'LBL_DUPLICATE_CHECK_OPERATOR' => 'Verificare la presenza di duplicati utilizzando l&#39;operatore:',
    'LBL_SAVE_MAPPING_AS' => 'Salva la Mapping Come',
    'LBL_OPTION_ENCLOSURE_QUOTE' => 'Singola Virgoletta(´)',
    'LBL_OPTION_ENCLOSURE_DOUBLEQUOTE' => 'Doppie Virgolette(")',
    'LBL_OPTION_ENCLOSURE_NONE' => 'Nessuno',
    'LBL_OPTION_ENCLOSURE_OTHER' => 'Altro:',
    'LBL_IMPORT_COMPLETE' => 'Importazione Completata',
    'LBL_IMPORT_COMPLETED' => 'Importazione Completata',
    'LBL_IMPORT_ERROR' => 'Errori di importazione:',
    'LBL_IMPORT_RECORDS' => 'Importazione Records',
    'LBL_IMPORT_RECORDS_OF' => 'di',
    'LBL_IMPORT_RECORDS_TO' => 'a',
    'LBL_CURRENCY' => 'Valuta',
    'LBL_SYSTEM_SIG_DIGITS' => 'Cifre importanti di sistema',
    'LBL_NUMBER_GROUPING_SEP' => 'Separatore Migliaia:',
    'LBL_DECIMAL_SEP' => 'Simbolo Decimale',
    'LBL_LOCALE_DEFAULT_NAME_FORMAT' => 'Formato Nome Visualizzato',
    'LBL_LOCALE_EXAMPLE_NAME_FORMAT' => 'Esempio',
    'LBL_LOCALE_NAME_FORMAT_DESC' => '<i>"s" Titolo, "f" Nome, "l" Cognome</i>',
    'LBL_CHARSET' => 'Codifica File',
    'LBL_MY_SAVED_HELP' => 'A saved mapping specifies a previously used combination of a specific data source and a set of database fields to map to the fields in the import file.<br>Click <b>Publish</b> to make the mapping available to other users.<br>Click <b>Un-Publish</b> to make the mapping unavailable to other users.',
    'LBL_MY_SAVED_ADMIN_HELP' => 'Utilizza questa opzione per applicare a questa importazione le impostazioni predefinite di importazione, comprese le proprietà di importazione, mappatura e controllo dei duplicati.<br /><br />Clicca Pubblica per rendere la mappatura disponibile ad altri utenti.<br />Clicca Non pubblicare per non rendere la mappatura disponibile ad altri utenti.<br />Clicca Elimina per eliminare la mappatura per tutti gli utenti.',
    'LBL_MY_PUBLISHED_HELP' => 'A published mapping specifies a previously used combination of a specific data source and a set of database fields to map to the fields in the import file.',
    'LBL_ENCLOSURE_HELP' => '<p>Il<b> separatore di testo</b> è utilizzato per racchiudere il contenuto del campo, incluso ogni carattere utilizzato come separatore.<br><br>Esempio: Se il separatore è la virgola (,) e il separatore di testo sono le virgolette("),<br><b>"Cupertino, California"</b> è importato all´interno dell\\applicativo in un solo campo e appare come <b>Cupertino, California</b>.<br>Se il separatore di testo non c´è, o il separatore di testo è un carattere diverso,<br><b>"Cupertino, California"</b> è importato all´interno di due campi adiacenti come <b>"Cupertino</b> e <b>Texas"</b>.<br><br>Nota: L´importazione del file potrebbe non contenere alcun separatore di testo.<br>Il separatore di testo di default che delimita i file creati in Excel sono le virgolette.</p>',
    'LBL_DELIMITER_COMMA_HELP' => 'Selezionare questa opzione se il carattere che separa i campi nel file di importazione è la <b>virgola</b>, o l´estenzione del file è .csv.',
    'LBL_DELIMITER_TAB_HELP' => 'Selezionare questa opzione se il carattere che separa i campi nel file di importazione è il <b>TAB</b>, e l´estenzione del file è .txt.',
    'LBL_DELIMITER_CUSTOM_HELP' => 'Selezionare questa opzione se il carattere che separa i campi nel file di importazione non è nè la virgola nè un TAB, e digitare il tipo di carattere nel campo adiacente.',
    'LBL_DATABASE_FIELD_HELP' => 'Seleziona un campo dall´elenco di tutti i campi esistenti nel database per il modulo.',
    'LBL_HEADER_ROW_HELP' => 'Questi sono i campi che comprendono la riga di intestazione dei file importato.',
    'LBL_DEFAULT_VALUE_HELP' => 'Se il campo nel file di importazione non contiene dati indicare il valore da usare per i campi nel record creato o aggiornato.',
    'LBL_ROW_HELP' => 'Questo è il dato della prima riga, non di intestazione, del file di importazione.',
    'LBL_SAVE_MAPPING_HELP' => 'Enter a name for the set of database fields used above for mapping to the fields in the import file fields.<br>The set of fields, including the order of the fields and the data souce selected in Import Step 1, will be saved during the import attempt.<br>The saved mapping can then be selected in Import Step 1 to for another import.',
    'LBL_IMPORT_FILE_SETTINGS_HELP' => 'Specificare le impostazioni nel file di importazione per assicurarsi che i dati siano importati<br> correttamente. Queste impostazioni non elimineranno le tue preferenze. I records<br> creati o aggiornati conteneranno le impostazioni specificate nella tua pagina My Account.',
    'LBL_VERIFY_DUPLCATES_HELP' => 'Selezionare i campi nel file di importazione da utilizzare per il controllo dei duplicati.<br>Se i dati nei campi selezionati corrispondono ai dati nei campi dei record esistenti, non verrà creato un nuovo records per il file contenente il dato del campo duplicato. <br> Le righe che contengono i dati dei campi duplicati saranno identificati nei Risultati dell´Importazione.',
    'LBL_IMPORT_STARTED' => 'Importazione Iniziata:',
    'LBL_IMPORT_FILE_SETTINGS' => 'Importa Impostazioni File',
    'LBL_IDM_RECORD_CANNOT_BE_CREATED' => 'Record non aggiunto. I nuovi utenti devono essere aggiunti nelle Impostazioni di SugarCloud',
    'LBL_RECORD_CANNOT_BE_UPDATED' => 'Il record non può essere aggiornato a causa di problemi nei permessi',
    'LBL_DELETE_MAP_CONFIRMATION' => 'Sei sicuro di voler eliminare questa mappatura?',
    'LBL_THIRD_PARTY_CSV_SOURCES' => 'Se i dati del file di importazione sono stato esportati da una qualsiasi delle seguenti fonti, seleziona quale.',
    'LBL_THIRD_PARTY_CSV_SOURCES_HELP' => 'Seleziona la fonte a cui applicare le mappature personalizzate in modo automatico con lo scopo di semplificare il processo di mappatura (prossimo step).',
    'LBL_EXTERNAL_SOURCE_HELP' => 'Utilizza questa opzione per importare dati direttamente da un´applicazione esterna o da un servizio, come ad esempio Gmail.',
    'LBL_EXAMPLE_FILE' => 'Download modello del file di importazione',
    'LBL_CONFIRM_IMPORT' => 'Hai scelto di aggiornare i record durante il processo di importazione. Gli aggiornamenti apportati ai record esistenti non possono essere annullati. Tuttavia, i record creati durante il processo di importazione possono essere annullai (eliminati), se lo si desidera. Clicca Annulla per scegliere l´opzione di creare sono nuovi record, oppure cliccare OK per continuare.',
    'LBL_IDM_CONFIRM_IMPORT' => 'Updates made to existing records during the import process cannot be undone. Click Cancel to create new records, or click OK to continue.',
    'LBL_CONFIRM_MAP_OVERRIDE' => 'Attenzione: Per questa importazione hai già scelto una mappatura personalizzata, vuoi continuare?',
    'LBL_EXTERNAL_FIELD' => 'Campo Esterno',
    'LBL_SAMPLE_URL_HELP' => 'Scarica un esempio del file di importazione contenente la riga di intestazione dei campi del modulo. Il file può essere usato come template per creare un file di importazione contenente i dati che vorresti importare.',
    'LBL_AUTO_DETECT_ERROR' => 'Non è stato rilevato il delimitatore di campo e di qualificazione nel file di importazione. Si prega di verificare le impostazione nelle Proprietà del file di importazione.',
    'LBL_MIME_TYPE_ERROR_1' => 'Il file selezionato non sembra contenere un elenco delimitato. Si prega di controllare il tipo di file. Consigliamo file delimitati da virgola (.csv).',
    'LBL_MIME_TYPE_ERROR_2' => 'Per procedere con l´importazione del file selezionato, clicca OK. Per caricare il nuovo file, clicca Riprova',
    'LBL_FIELD_DELIMETED_HELP' => 'Il delimitatore di campo specifica il carattere utilizzato per separare le colonne campo.',
    'LBL_FILE_UPLOAD_WIDGET_HELP' => 'Seleziona un file contente dati separati da un delimitatore, quale virgola o spazio. Consigliamo file .csv.',
    'LBL_EXTERNAL_ERROR_NO_SOURCE' => 'Impossibile recuperare adattore fonte. Riprova più tardi.',
    'LBL_EXTERNAL_ERROR_FEED_CORRUPTED' => 'Impossibile recuperare feed esterno. Riprova più tardi.',
    'LBL_ERROR_IMPORT_CACHE_NOT_WRITABLE' => 'Directory della cache di importazione non è scrivibile.',
    'LBL_ADD_FIELD_HELP' => 'Scegli questa opzione per aggiungere un valore ad un campo in tutti i record creati e/o caricati. Seleziona il campo e inserisci o seleziona il valore per quel campo nella colonna Valori Predefiniti.',
    'LBL_MISSING_HEADER_ROW' => 'Nessuna riga di intestazione trovata',
    'LBL_CANCEL' => 'Annulla',
    'LBL_SELECT_DS_INSTRUCTION' => 'Sei pronto per iniziare con l´importazione? Selezionare la fonte dei dati che si desidera importare.',
    'LBL_SELECT_UPLOAD_INSTRUCTION' => 'Seleziona un file dal tuo computer che contenga i dati che si desidera importare, o scarica il modello per avere un aiuto sulla creazione del file di importazione.',
    'LBL_SELECT_IDM_CREATE_INSTRUCTION' => 'Per creare nuovi record, accedere alle <a href="{0}" target="_blank">Impostazioni SugarCloud</a>.',
    'LBL_SELECT_IDM_UPLOAD_INSTRUCTION' => 'Per aggiornare i record esistenti, selezionare un file sul computer in uso che contiene i dati che si desidera importare.',
    'LBL_SELECT_PROPERTY_INSTRUCTION' => 'Ecco come gran parte delle prime righe del file di importazione appaiono secondo le proprietà del file. Se è stata rilevata una riga di intestazione, questa viene visualizzata nella riga superiore della tabella. Visualizza le proprietà del file di importazione per apportare modifiche o impostare proprietà aggiuntive. Aggiornando le proprietà si aggiorneranno anche i dati che riportati nella tabella.',
    'LBL_SELECT_MAPPING_INSTRUCTION' => 'La tabella seguente contiene tutti i campi del modulo che possono essere mappati come dati nel file di importazione. Se il file contiene una riga di intestazione, le colonne del file vengono mappate con i campi corrispondenti. Controlla che la mappatura contenga i campi che ti aspetti, e apporta modifiche se necessario. Per aiutarti nella mappatura, la Riga 1 visualizza i dati nel file. Assicurati di mappare tutti i campi obbligatori (marcati da un asterisco).',
    'LBL_IDM_SELECT_MAPPING_INSTRUCTION' => 'The table below contains all of the editable fields in the module that can be mapped to the data in the import file. If the file contains a header row, the columns in the file have been mapped to matching fields. If the import data contain dates, the year must be in YYYY format. Check the mappings to make sure that they are what you expect, and make changes, as necessary. To help you check the mappings, Row 1 displays the data in the file. Be sure to map to all of the required fields (noted by an asterisk).',
    'LBL_IDM_SELECT_MAPPING_FIELDS_INSTRUCTION' => '<a href="{0}" target="_blank">Fields</a> that are only editable in SugarIdentity via the SugarCloud Settings console will not be available to map.',
    'LBL_SELECT_DUPLICATE_INSTRUCTION' => 'Per evitare la creazione di duplicati, seleziona quali dei campi mappati vuoi utilizzare per fare un controllo duplicati in fase di importazione. I valori all´interno dei records esistenti nei campi selezionati saranno controllati con i dati nel file di importazione. Se vengono trovati dati corrispondenti, le righe nel file di importazione contente i dati saranno visualizzate con i risultati di importazione (pagine seguente). Sarai poi in grado di selezione quali di queste righe continuare ad importare.',
    'LBL_EXT_SOURCE_SIGN_IN' => 'Entra',
    'LBL_EXT_SOURCE_SIGN_OUT' => 'Esci',
    'LBL_DUP_HELP' => 'Queste sono le righe che non sono state importate dal file poichè, sulla base del controllo duplicati, contengono dei dati che coincidono con dei record già esistenti.Quest´ultimi sono evidenziati. Per re-importare queste righe, scarica la lista, fai le opportune modifiche e clicca su Importa ancora',
    'LBL_DESELECT' => 'Deselezionare',
    'LBL_SUMMARY' => 'Sommario',
    'LBL_OK' => 'OK',
    'LBL_ERROR_HELP' => 'Queste sono le righe che non sono state importate dal file a causa di alcuni errori. Per re-importare queste righe, scarica la lista, fai le opportune modifiche e clicca su Importa ancora',
    'LBL_EXTERNAL_MAP_HELP' => 'La seguente tabella contiene i campi del file esterno da importare e i campi corrispondenti nel modulo SugarCRM. Controlla la mappatura affinchè sia come prevista e in caso apportare le dovute modifiche. Assicurarsi di mappare tutti i campi obbligatori (evidenziati con un asterisco).',
    'LBL_EXTERNAL_MAP_NOTE' => 'Si proverà l´importazione dei contatti all´interno di tutti i gruppi contatti di Google.',
    'LBL_EXTERNAL_MAP_NOTE_SUB' => 'Il nome utente degli utenti creati recentemente sarà di default anche il Nome Completo dei Contatti di Google. Il nome utente potrà essere cambiato dopo che il record dell´utente è stato creato.',
    'LBL_EXTERNAL_MAP_SUB_HELP' => 'Clicca Importa Ora per iniziare l´importazione. Saranno creati solo i record che contengono il cognome.  Non verranno creati nuovi record per quei dati che saranno identificati come duplicati in base al nome e/o agli indirizzi email di record esistent.',
    'LBL_EXTERNAL_FIELD_TOOLTIP' => 'Questa colonna mostra i campi del file esterno di importazione contenenti i dati che saranno usati per creare nuovi record.',
    'LBL_EXTERNAL_DEFAULT_TOOPLTIP' => 'Indicare il valore da usare nel campo del record creato quando il campo nel file esterno di importazione non contiene alcun dato.',
    'LBL_EXTERNAL_ASSIGNED_TOOLTIP' => 'Per assegnare i nuovi record ad un utente diverso da te stesso, utilizza la colonna Valore di Default e seleziona il nuovo utente.',
    'LBL_EXTERNAL_TEAM_TOOLTIP' => 'Per assegnare i nuovi record ad un gruppo diverso dal tuo, utilizza la colonna Valore di Default e seleziona il nuovo gruppo.',
    'LBL_SIGN_IN_HELP' => 'Per abilitare il servizio si prega di entrare in Account Esterni all´interno della pagina di impostazioni utente.',
    'LBL_NO_EMAIL_DEFS_IN_MODULE' => "Gestione indirizzi email all´interno di un modulo che non supporta la funzionalità.",
];
