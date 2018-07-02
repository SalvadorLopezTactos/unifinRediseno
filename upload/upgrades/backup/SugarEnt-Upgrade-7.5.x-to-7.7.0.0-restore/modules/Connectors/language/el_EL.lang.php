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
  'ERROR_EMPTY_RECORD_ID' => 'Λάθος: Η Ταυτότητα Εγγραφής δεν είναι καθορισμένη ή άδεια.',
  'ERROR_EMPTY_SOURCE_ID' => 'Λάθος: Η Ταυτότητα Πηγής δεν είναι καθορισμένη ή άδεια.',
  'ERROR_EMPTY_WRAPPER' => 'Λάθος: Δεν είναι δυνατή η περίπτωση ανάκτησης περιτυλίγματος για την πηγή [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Λάθος: Δεν βρέθηκαν πρόσθετες λεπτομέρεις για την εγγραφή.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Λάθος: Δεν υπάρχουν συνδέσεις που να αντιστοιχίζονται σε αυτή την ενότητα.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Λάθος: Δεν υπάρχουν πεδία ενότητας που να έχουν χαρτογραφηθεί για εμφάνιση στα αποτελέσματα. Παρακαλούμε επικοινωνήστε με το διαχειριστή του συστήματος.',
  'ERROR_NO_FIELDS_MAPPED' => 'Λάθος: Θα πρέπει να χαρτογραφήσετε τουλάχιστον ένα πεδίο Connector σε ένα πεδίο ενότητας για κάθε ενότητα εισόδου.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Καμία ενότητα δεν έχει ενεργοποιηθεί για αυτή την σύνδεση . Επιλέξτε μια ενότητα για αυτή την σύνδεση στη σελίδα Ενεργοποίηση Connectors.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Λάθος: Δεν υπάρχουν συνδέσεις που έχουν ενεργοποιηθεί στα πεδία αναζήτησης που ορίζονται.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Λάθος: Δεν υπάρχουν πεδία αναζήτησης που ορίζονται για την ενότητα και την σύνδεση. Παρακαλούμε επικοινωνήστε με το διαχειριστή του συστήματος.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Λάθος: Κανένα αρχείο sourcedefs.php δεν βρέθηκε.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Λάθος: Δεν έχουν καθοριστεί πηγές από όπου μπορείτε να ανακτήσετε δεδομένα.',
  'ERROR_RECORD_NOT_SELECTED' => 'Λάθος: Παρακαλώ επιλέξτε μία εγγραφή από τη λίστα πριν προχωρήσετε.',
  'LBL_ADDRCITY' => 'Πόλη',
  'LBL_ADDRCOUNTRY' => 'Χώρα',
  'LBL_ADDRCOUNTRY_ID' => 'Ταυτότητα Χώρας',
  'LBL_ADDRSTATEPROV' => 'Περιοχή',
  'LBL_ADD_MODULE' => 'Προσθήκη',
  'LBL_ADMINISTRATION' => 'Διαχείριση Connector',
  'LBL_ADMINISTRATION_MAIN' => 'Ρυθμίσεις Connector',
  'LBL_AVAILABLE' => 'Διαθέσιμο',
  'LBL_BACK' => '< Πίσω',
  'LBL_CLOSE' => 'Κλείσιμο',
  'LBL_COMPANY_ID' => 'Ταυτότητα Εταιρείας',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Μερικά υποχρεωτικά πεδία έχουν μείνει κενά. Να προχωρήσει να αποθηκεύσει τις αλλαγές;',
  'LBL_CONNECTOR' => 'Connector',
  'LBL_CONNECTOR_FIELDS' => 'Πεδία Connector',
  'LBL_DATA' => 'Δεδομένα',
  'LBL_DEFAULT' => 'Προεπιλογή',
  'LBL_DELETE_MAPPING_ENTRY' => 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτή την είσοδο;',
  'LBL_DISABLED' => 'Απενεργοποιημένη',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Καμία αντιστοιχία δεν βρέθηκε για τα κριτήρια αναζήτησης σας.',
  'LBL_ENABLED' => 'Ενεργοποιημένη',
  'LBL_EXTERNAL' => 'Επιτρέπεται στους χρήστες να δημιουργήσουν εξωτερικό λογαριασμό αρχείων σε αυτή την σύνδεση.',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Προκειμένου να χρησιμοποιήσετε αυτή την σύνδεση, οι ιδιότητες θα πρέπει επίσης να Καθοριστούν στις Ιδιότητες Σύνδεσης Connector στις ρυθμίσεις σελίδας.',
  'LBL_FINSALES' => 'Ετήσιες Πωλήσεις',
  'LBL_INFO_INLINE' => 'Πληροφορίες',
  'LBL_MARKET_CAP' => 'Κεφαλαιοποίηση',
  'LBL_MERGE' => 'Συγχώνευση',
  'LBL_MODIFY_DISPLAY_DESC' => 'Επιλέξτε ποιά ενότητα είναι ενεργοποιημένη για κάθε σύνδεση.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Ρυθμίσεις Connector: Ενεργοποίηση  Connectors',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Ενεργοποίηση Συνδέσεων',
  'LBL_MODIFY_MAPPING_DESC' => 'Χάρτης πεδίων Connector σε ενότητα πεδίων, προκειμένου να διαπιστωθούν ποια δεδομένα σύνδεσης μπορούν να προβληθούν και να συγχωνευθούν στις εγγραφές ενότητας',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Ρυθμίσεις Connector: Χάρτης Πεδίων Connector',
  'LBL_MODIFY_MAPPING_TITLE' => 'Χάρτης Πεδίων Connector',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Ρυθμίστε τις ιδιότητες για κάθε σύνδεση, συμπεριλαμβανομένων των URLs και των κλειδιών API.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Ρυθμίσεις Σύνδεσης: Καθορισμός Ιδιοτήτων Σύνδεσης',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Καθορισμός Ιδιοτήτων Connector',
  'LBL_MODIFY_SEARCH' => 'Αναζήτηση',
  'LBL_MODIFY_SEARCH_DESC' => 'Επιλέξτε τα πεδία Connector να χρησιμοποιήσετε να αναζητήσετε δεδομένα για κάθε ενότητα.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Ρυθμίσεις Connector: Αναζήτηση Διαχείριση Connector',
  'LBL_MODIFY_SEARCH_TITLE' => 'Αναζήτηση Διαχείριση Connector',
  'LBL_MODULE_FIELDS' => 'Πεδία Ενότητας',
  'LBL_MODULE_NAME' => 'Connectors',
  'LBL_MODULE_NAME_SINGULAR' => 'Connector',
  'LBL_NO_PROPERTIES' => 'Δεν υπάρχουν διαμορφώσιμες ιδιότητες για αυτή την σύνδεση.',
  'LBL_PARENT_DUNS' => 'Γονικό DUNS',
  'LBL_PREVIOUS' => '< Πίσω',
  'LBL_QUOTE' => 'Προσφορά',
  'LBL_RECNAME' => 'Όνομα Εταιρείας',
  'LBL_RESET_BUTTON_TITLE' => 'Επαναφορά',
  'LBL_RESET_TO_DEFAULT' => 'Επαναφορά στην Προεπιλογή',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Είστε βέβαιοι ότι θέλετε να επαναφέρετε την προεπιλεγμένη ρύθμιση;',
  'LBL_RESULT_LIST' => 'Λίστα Δεδομένων',
  'LBL_RUN_WIZARD' => 'Εκτέλεση Οδηγού',
  'LBL_SAVE' => 'Αποθήκευση',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Εύρεση...',
  'LBL_SHOW_IN_LISTVIEW' => 'Εμφάνιση στην Προβολή Λίστας Συγχώνευσης',
  'LBL_SMART_COPY' => 'Έξυπνη Αντιγραφή',
  'LBL_STEP1' => 'Αναζήτηση και Προβολή Δεδομένων',
  'LBL_STEP2' => 'Συγχώνευση Εγγραφών με',
  'LBL_SUMMARY' => 'Περίληψη',
  'LBL_TEST_SOURCE' => 'Δοκιμή Σύνδεσης',
  'LBL_TEST_SOURCE_FAILED' => 'Αποτυχημένη Δοκιμή',
  'LBL_TEST_SOURCE_RUNNING' => 'Εκτέλεση δοκιμής...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Επιτυχημένη Δοκιμή',
  'LBL_TITLE' => 'Συγχώνευση Δεδομένων',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Απόλυτο Γονικό DUNS',
  'dnb_countries_iso' => 
  array (
    'AD' => 'Ανδόρρα',
    'AE' => 'Ηνωμένα Αραβικά Εμιράτα',
    'AF' => 'Αφγανιστάν',
    'AG' => 'Αντίγκουα και Μπαρμπούντα',
    'AI' => 'Ανγκουίλα',
    'AL' => 'Αλβανία',
    'AM' => 'Αρμενία',
    'AN' => 'Ολλανδικές Αντίλλες',
    'AO' => 'Ανγκόλα',
    'AQ' => 'Ανταρκτική',
    'AR' => 'Αργεντινή',
    'AS' => 'Αμερικανική Σαμόα',
    'AT' => 'Αυστρία',
    'AU' => 'Αυστραλία',
    'AW' => 'Αρούμπα',
    'AZ' => 'Αζερμπαϊτζάν',
    'BA' => 'Βοσνία και Ερζεγοβίνη',
    'BB' => 'Μπαρμπάντος',
    'BD' => 'Μπανγκλαντές',
    'BE' => 'Βέλγιο',
    'BF' => 'Μπουρκίνα Φάσο',
    'BG' => 'Βουλγαρία',
    'BH' => 'Μπαχρέιν',
    'BI' => 'Μπουρούντι',
    'BJ' => 'Μπενίν',
    'BM' => 'Βερμούδες',
    'BN' => 'Μπρουνέι',
    'BO' => 'Βολιβία',
    'BR' => 'Βραζιλία',
    'BS' => 'Μπαχάμες',
    'BT' => 'Μπουτάν',
    'BV' => 'Νησιά Μπουβέ',
    'BW' => 'Βοσνία και Ερζεγοβίνη',
    'BY' => 'Λευκορωσία',
    'BZ' => 'Μπελίζ',
    'CA' => 'Καναδά',
    'CC' => 'Νησιά Κόκος (Κίλινγκ)',
    'CD' => 'Λαϊκή Δημοκρατία του Κονγκό',
    'CF' => 'Κεντροαφρικανική Δημοκρατία',
    'CG' => 'Κονγκό',
    'CH' => 'Ελβετία',
    'CI' => 'Ακτή Ελεφαντοστού',
    'CK' => 'Νήσοι Κουκ',
    'CL' => 'Χιλή',
    'CM' => 'Καμερούν',
    'CN' => 'Κίνα',
    'CO' => 'Κολομβία',
    'CR' => 'Κόστα Ρίκα',
    'CU' => 'Κούβα',
    'CV' => 'Πράσινο Ακρωτήριο',
    'CX' => 'Νήσος των Χριστουγέννων',
    'CY' => 'Κύπρος',
    'CZ' => 'Δημοκρατία της Τσεχίας',
    'DE' => 'Γερμανία',
    'DJ' => 'Τζιμπουτ',
    'DK' => 'Δανία',
    'DM' => 'Δομινίκα',
    'DO' => 'Δομινικανή Δημοκρατία',
    'DZ' => 'Αλγερία',
    'EC' => 'Ισημερινός',
    'EE' => 'Εσθονία',
    'EG' => 'Αίγυπτος',
    'EH' => 'Δυτική Σαχάρα',
    'ER' => 'Ερυθραία',
    'ES' => 'Ισπανία',
    'ET' => 'Αιθιοπία',
    'FI' => 'Φινλανδία',
    'FJ' => 'Φίτζ',
    'FK' => 'Νήσοι Φώκλαντ',
    'FM' => 'Μικρονησία',
    'FO' => 'Νησιά Φερόε',
    'FR' => 'Γαλλία',
    'FX' => 'Γαλλία, Μητροπολιτική',
    'GA' => 'Γκαμπόν',
    'GB' => 'Ηνωμένο Βασίλειο',
    'GD' => 'Γρενάδα',
    'GE' => 'Γεωργία',
    'GF' => 'Γαλλική Γουιάνα',
    'GH' => 'Γκάνα',
    'GI' => 'Γιβραλτάρ',
    'GL' => 'Γροιλανδία',
    'GM' => 'Γκάμπια',
    'GN' => 'Γουινέα',
    'GP' => 'Γουαδελούπη',
    'GQ' => 'Ισημερινή Γουινέα',
    'GR' => 'Ελλάδα',
    'GS' => 'Νότια Γεωργία και Νότιες Νήσοι Σάντουιτς',
    'GT' => 'Γουατεμάλα',
    'GU' => 'Γκουάμ',
    'GW' => 'Γουινέα-Μπισσάου',
    'GY' => 'Γουιάνα',
    'HK' => 'Χονγκ Κονγκ',
    'HM' => 'Νήσοι Mc Donald',
    'HN' => 'Ονδούρα',
    'HR' => 'Κροατία',
    'HT' => 'Αϊτή',
    'HU' => 'Ουγγαρία',
    'ID' => 'Ινδονησία',
    'IE' => 'Ιρλανδία',
    'IL' => 'Ισραήλ',
    'IN' => 'Ινδία',
    'IO' => 'Βρετανικό Έδαφος Ινδικού Ωκεανού',
    'IQ' => 'Ιράκ',
    'IR' => 'Ιράν',
    'IS' => 'Ισλανδία',
    'IT' => 'Ιταλία',
    'JM' => 'Τζαμάικα',
    'JO' => 'Ιορδανία',
    'JP' => 'Ιαπωνία',
    'KE' => 'Κένυα',
    'KG' => 'Κιργιστάν',
    'KH' => 'Καμπότζη',
    'KI' => 'Κιριμπάτι',
    'KM' => 'Κομόρες',
    'KN' => 'Άγιος Χριστόφορος και Νέβις',
    'KP' => 'Νότια Κορέα',
    'KR' => 'Νότια Κορέα',
    'KW' => 'Κουβέιτ',
    'KY' => 'Κέιμαν Νήσοι',
    'KZ' => 'Καζακστάν',
    'LA' => 'Λάος',
    'LB' => 'Λίβανος',
    'LC' => 'Αγία Λουκία',
    'LI' => 'Λίχτενσταϊν',
    'LK' => 'Σρι Λάνκα',
    'LR' => 'Λιβερία',
    'LS' => 'Λεσότο',
    'LT' => 'Λιθουανία',
    'LU' => 'Λουξεμβούργο',
    'LV' => 'Λετονία',
    'LY' => 'Λιβύη',
    'MA' => 'Μαρόκο',
    'MC' => 'Μονακό',
    'MD' => 'Μολδαβία',
    'ME' => 'Μαυροβούνιο',
    'MG' => 'Μαδαγασκάρη',
    'MH' => 'Νήσος του Μαν',
    'MK' => 'Πρώην Γιουγκοσλαβική Δημοκρατία της Μακεδονίας',
    'ML' => 'Μάλι',
    'MM' => 'Μιανμάρ',
    'MN' => 'Μογγολία',
    'MO' => 'Μακάο',
    'MP' => 'Νήσοι Βόρειες Μαριάνες',
    'MQ' => 'Μαρτινίκα',
    'MR' => 'Μαυριτανία',
    'MS' => 'Μοντσερράτ',
    'MT' => 'Μάλτα',
    'MU' => 'Μαυρίκιος',
    'MV' => 'Μαλδίβες',
    'MW' => 'Μαλάουι',
    'MX' => 'Μεξικό',
    'MY' => 'Μαλαισία',
    'MZ' => 'Μοζαμβίκη',
    'NA' => 'Ναμίμπια',
    'NC' => 'Νέα Καληδονία',
    'NE' => 'Νίγηρας',
    'NF' => 'Νησί Νόρφολκ',
    'NG' => 'Νιγηρία',
    'NI' => 'Νικαράγουα',
    'NL' => 'Ολλανδία',
    'NO' => 'Νορβηγία',
    'NP' => 'Νεπάλ',
    'NR' => 'Ναουρού',
    'NU' => 'Νιούε',
    'NZ' => 'Νέα Ζηλανδία',
    'OM' => 'Ομάν',
    'PA' => 'Παναμάς',
    'PE' => 'Περού',
    'PF' => 'Γαλλική Πολυνησία',
    'PG' => 'Παπούα Νέα Γουινέα',
    'PH' => 'Φιλιππίνες',
    'PK' => 'Πακιστάν',
    'PL' => 'Πολωνία',
    'PM' => 'Σέντ Πιέρ και Μικελόν',
    'PN' => 'Νησιά Πίτκερν',
    'PR' => 'Πουέρτο Ρίκο',
    'PS' => 'Παλαιστίνη',
    'PT' => 'Πορτογαλία',
    'PW' => 'Παραγουάη',
    'PY' => 'Παραγουάη',
    'QA' => 'Κατάρ',
    'RE' => 'Επανένωση',
    'RO' => 'Ρουμανία',
    'RS' => 'Σερβία',
    'RU' => 'Ρωσία',
    'RW' => 'Ρουάντα',
    'SA' => 'Σαουδική Αραβία',
    'SB' => 'Νήσοι Σολομώντα',
    'SC' => 'Σεϋχέλλες',
    'SD' => 'Σουδάν',
    'SE' => 'Σουηδία',
    'SG' => 'Σιγκαπούρη',
    'SH' => 'Αγίας Ελένης',
    'SI' => 'Σλοβενία',
    'SJ' => 'Σβάλμπαρντ και Γιαν Μαγιέν Νήσοι',
    'SK' => 'Σλοβακία',
    'SL' => 'Σιέρα Λεόνε',
    'SM' => 'Σαμόα',
    'SN' => 'Σενεγάλη',
    'SO' => 'Σομαλία',
    'SR' => 'Σουρινάμ',
    'ST' => 'Σάο Τομέ και Πρίνσιπε',
    'SV' => 'Ελ Σαλβαδόρ',
    'SY' => 'Συρία',
    'SZ' => 'Σουαζιλάνδη',
    'TC' => 'Νήσοι Τερκς και Κάικος',
    'TD' => 'Τσαντ',
    'TF' => 'Νότια Γαλλικά Εδάφη',
    'TG' => 'Τόγκο',
    'TH' => 'Ταϊλάνδη',
    'TJ' => 'Τατζικιστάν',
    'TK' => 'Τοκελάου',
    'TM' => 'Τουρκμενιστάν',
    'TN' => 'Τυνησία',
    'TO' => 'Τόνγκα',
    'TP' => 'Ανατολικό Τιμόρ',
    'TR' => 'Τουρκία',
    'TT' => 'Τρινιντάντ και Τομπάγκο',
    'TV' => 'Τουβαλού',
    'TW' => 'Ταϊβάν',
    'TZ' => 'Τανζανία',
    'UA' => 'Ουκρανία',
    'UG' => 'Ουγκάντα',
    'UM' => 'Μικρά Εξωτερικά Νησιά των Ηνωμένων Πολιτειών',
    'US' => 'ΗΠΑ',
    'UY' => 'Ουρουγουάη',
    'UZ' => 'Ουρουγουάη',
    'VA' => 'Βατικανό',
    'VC' => 'Άγιος Βικέντιος και Γρεναδίνες',
    'VE' => 'Βενεζουέλα',
    'VG' => 'Βρετανικές Παρθένοι Νήσοι',
    'VI' => 'Αμερικανικές Παρθένοι Νήσοι',
    'VN' => 'Βιετνάμ',
    'VU' => 'Βανουάτου',
    'WF' => 'Νησιά Ουόλις και Φουτούνα',
    'WS' => 'Σαμόα',
    'YE' => 'Υεμένη',
    'YT' => 'Μαγιότ',
    'ZA' => 'Νότια Αφρική',
    'ZM' => 'Ζάμπια',
    'ZW' => 'Ζιμπάμπουε',
  ),
  'dnb_states_iso' => 
  array (
    'AD' => 
    array (
      1 => 
      array (
        'code' => 'ALV',
        'name' => 'Andorra la Vella',
      ),
      2 => 
      array (
        'code' => 'CAN',
        'name' => 'Canillo',
      ),
      3 => 
      array (
        'code' => 'ENC',
        'name' => 'Encamp',
      ),
      4 => 
      array (
        'code' => 'ESE',
        'name' => 'Escaldes-Engordany',
      ),
      5 => 
      array (
        'code' => 'LMA',
        'name' => 'La Massana',
      ),
      6 => 
      array (
        'code' => 'ORD',
        'name' => 'Ordino',
      ),
      7 => 
      array (
        'code' => 'SJL',
        'name' => 'Sant Julià de Lòria',
      ),
    ),
    'AE' => 
    array (
      1 => 
      array (
        'code' => 'AZ',
        'name' => 'Abu Zaby',
      ),
      2 => 
      array (
        'code' => 'AJ',
        'name' => '&#39;Ajman',
      ),
      3 => 
      array (
        'code' => 'FU',
        'name' => 'Al Fujayrah',
      ),
      4 => 
      array (
        'code' => 'SH',
        'name' => 'Ash Shariqah',
      ),
      5 => 
      array (
        'code' => 'DU',
        'name' => 'Dubayy',
      ),
      6 => 
      array (
        'code' => 'RK',
        'name' => 'R&#39;as al Khaymah',
      ),
      7 => 
      array (
        'code' => 'UQ',
        'name' => 'Umm al Qaywayn',
      ),
    ),
    'AF' => 
    array (
      1 => 
      array (
        'code' => 'BAL',
        'name' => 'Balkh',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => 'Bamian',
      ),
      3 => 
      array (
        'code' => 'BDG',
        'name' => 'Badghis',
      ),
      4 => 
      array (
        'code' => 'BDS',
        'name' => 'Badakhshan',
      ),
      5 => 
      array (
        'code' => 'BGL',
        'name' => 'Baghlan',
      ),
      6 => 
      array (
        'code' => 'FRA',
        'name' => 'Farah',
      ),
      7 => 
      array (
        'code' => 'FYB',
        'name' => 'Faryab',
      ),
      8 => 
      array (
        'code' => 'GHA',
        'name' => 'Ghazni',
      ),
      9 => 
      array (
        'code' => 'GHO',
        'name' => 'Ghowr',
      ),
      10 => 
      array (
        'code' => 'HEL',
        'name' => 'Helmand',
      ),
      11 => 
      array (
        'code' => 'HER',
        'name' => 'Herat',
      ),
      12 => 
      array (
        'code' => 'JOW',
        'name' => 'Jowzjan',
      ),
      13 => 
      array (
        'code' => 'KAB',
        'name' => 'Kabul',
      ),
      14 => 
      array (
        'code' => 'KAN',
        'name' => 'Kandahar',
      ),
      15 => 
      array (
        'code' => 'KAP',
        'name' => 'Kapisa',
      ),
      16 => 
      array (
        'code' => 'KDZ',
        'name' => 'Kondoz',
      ),
      17 => 
      array (
        'code' => 'KHO',
        'name' => 'Khost',
      ),
      18 => 
      array (
        'code' => 'KNR',
        'name' => 'Konar',
      ),
      19 => 
      array (
        'code' => 'LAG',
        'name' => 'Laghman',
      ),
      20 => 
      array (
        'code' => 'LOW',
        'name' => 'Lowgar',
      ),
      21 => 
      array (
        'code' => 'NAN',
        'name' => 'Nangrahar',
      ),
      22 => 
      array (
        'code' => 'NIM',
        'name' => 'Nimruz',
      ),
      23 => 
      array (
        'code' => 'NUR',
        'name' => 'Nurestan',
      ),
      24 => 
      array (
        'code' => 'ORU',
        'name' => 'Oruzgan',
      ),
      25 => 
      array (
        'code' => 'PAR',
        'name' => 'Parwan',
      ),
      26 => 
      array (
        'code' => 'PIA',
        'name' => 'Paktia',
      ),
      27 => 
      array (
        'code' => 'PKA',
        'name' => 'Paktika',
      ),
      28 => 
      array (
        'code' => 'SAM',
        'name' => 'Samangan',
      ),
      29 => 
      array (
        'code' => 'SAR',
        'name' => 'Sar-e Pol',
      ),
      30 => 
      array (
        'code' => 'TAK',
        'name' => 'Takhar',
      ),
      31 => 
      array (
        'code' => 'WAR',
        'name' => 'Wardak',
      ),
      32 => 
      array (
        'code' => 'ZAB',
        'name' => 'Zabol',
      ),
    ),
    'AI' => 
    array (
      1 => 
      array (
        'code' => 'ANG',
        'name' => 'Anguillita',
      ),
      2 => 
      array (
        'code' => 'ANG',
        'name' => 'Anguila',
      ),
      3 => 
      array (
        'code' => 'DOG',
        'name' => 'Dog',
      ),
      4 => 
      array (
        'code' => 'LIT',
        'name' => 'Little Scrub',
      ),
      5 => 
      array (
        'code' => 'PRI',
        'name' => 'Prickly Pear',
      ),
      6 => 
      array (
        'code' => 'SAN',
        'name' => 'Sandy',
      ),
      7 => 
      array (
        'code' => 'SCR',
        'name' => 'Scrub',
      ),
      8 => 
      array (
        'code' => 'SEA',
        'name' => 'Seal',
      ),
      9 => 
      array (
        'code' => 'SOM',
        'name' => 'Sombrero',
      ),
    ),
    'AL' => 
    array (
      1 => 
      array (
        'code' => 'BR',
        'name' => 'Berat',
      ),
      2 => 
      array (
        'code' => 'BU',
        'name' => 'Bulqize',
      ),
      3 => 
      array (
        'code' => 'DI',
        'name' => 'Diber',
      ),
      4 => 
      array (
        'code' => 'DL',
        'name' => 'Delvine',
      ),
      5 => 
      array (
        'code' => 'DR',
        'name' => 'Durres',
      ),
      6 => 
      array (
        'code' => 'DV',
        'name' => 'Devoll',
      ),
      7 => 
      array (
        'code' => 'EL',
        'name' => 'Elbasan',
      ),
      8 => 
      array (
        'code' => 'ER',
        'name' => 'Kolonje',
      ),
      9 => 
      array (
        'code' => 'FR',
        'name' => 'Fier',
      ),
      10 => 
      array (
        'code' => 'GJ',
        'name' => 'Gjirokaster',
      ),
      11 => 
      array (
        'code' => 'GR',
        'name' => 'Gramsh',
      ),
      12 => 
      array (
        'code' => 'HA',
        'name' => 'Has',
      ),
      13 => 
      array (
        'code' => 'KA',
        'name' => 'Kavaje',
      ),
      14 => 
      array (
        'code' => 'KB',
        'name' => 'Kurbin',
      ),
      15 => 
      array (
        'code' => 'KC',
        'name' => 'Kucove',
      ),
      16 => 
      array (
        'code' => 'KO',
        'name' => 'Korce',
      ),
      17 => 
      array (
        'code' => 'KR',
        'name' => 'Kruje',
      ),
      18 => 
      array (
        'code' => 'KU',
        'name' => 'Kukes',
      ),
      19 => 
      array (
        'code' => 'LB',
        'name' => 'Librazhd',
      ),
      20 => 
      array (
        'code' => 'LE',
        'name' => 'Lezhe',
      ),
      21 => 
      array (
        'code' => 'LU',
        'name' => 'Lushnje',
      ),
      22 => 
      array (
        'code' => 'MK',
        'name' => 'Mallakaster',
      ),
      23 => 
      array (
        'code' => 'MM',
        'name' => 'Malesi e Madhe',
      ),
      24 => 
      array (
        'code' => 'MR',
        'name' => 'Mirdite',
      ),
      25 => 
      array (
        'code' => 'MT',
        'name' => 'Mat',
      ),
      26 => 
      array (
        'code' => 'PG',
        'name' => 'Pogradec',
      ),
      27 => 
      array (
        'code' => 'PQ',
        'name' => 'Peqin',
      ),
      28 => 
      array (
        'code' => 'PR',
        'name' => 'Permet',
      ),
      29 => 
      array (
        'code' => 'PU',
        'name' => 'Puke',
      ),
      30 => 
      array (
        'code' => 'SH',
        'name' => 'Shkoder',
      ),
      31 => 
      array (
        'code' => 'SK',
        'name' => 'Skrapar',
      ),
      32 => 
      array (
        'code' => 'SR',
        'name' => 'Sarande',
      ),
      33 => 
      array (
        'code' => 'TE',
        'name' => 'Tepelene',
      ),
      34 => 
      array (
        'code' => 'TP',
        'name' => 'Tropoje',
      ),
      35 => 
      array (
        'code' => 'TR',
        'name' => 'Tirane',
      ),
      36 => 
      array (
        'code' => 'VL',
        'name' => 'Vlore',
      ),
    ),
    'AM' => 
    array (
      1 => 
      array (
        'code' => 'AGT',
        'name' => 'Aragatsotn',
      ),
      2 => 
      array (
        'code' => 'ARR',
        'name' => 'Ararat',
      ),
      3 => 
      array (
        'code' => 'ARM',
        'name' => 'Armavir',
      ),
      4 => 
      array (
        'code' => 'GEG',
        'name' => 'Geghark &#39;unik&#39;',
      ),
      5 => 
      array (
        'code' => 'KOT',
        'name' => 'Kotayk&#39;',
      ),
      6 => 
      array (
        'code' => 'LOR',
        'name' => 'Lorri',
      ),
      7 => 
      array (
        'code' => 'SHI',
        'name' => 'Shirak',
      ),
      8 => 
      array (
        'code' => 'SYU',
        'name' => 'Syunik&#39;',
      ),
      9 => 
      array (
        'code' => 'TAV',
        'name' => 'Tavush',
      ),
      10 => 
      array (
        'code' => 'VAY',
        'name' => 'Vayots&#39; Dzor',
      ),
      11 => 
      array (
        'code' => 'YER',
        'name' => 'Yerevan',
      ),
    ),
    'AN' => 
    array (
      1 => 
      array (
        'code' => 'BON',
        'name' => 'Bonaire',
      ),
      2 => 
      array (
        'code' => 'CUR',
        'name' => 'Curaçao',
      ),
      3 => 
      array (
        'code' => 'SAB',
        'name' => 'Saba',
      ),
      4 => 
      array (
        'code' => 'SEU',
        'name' => 'Sint Eustatius',
      ),
      5 => 
      array (
        'code' => 'SMA',
        'name' => 'Sint Maarten',
      ),
    ),
    'AO' => 
    array (
      1 => 
      array (
        'code' => 'BGO',
        'name' => 'Bengo',
      ),
      2 => 
      array (
        'code' => 'BGU',
        'name' => 'Benguela',
      ),
      3 => 
      array (
        'code' => 'BIE',
        'name' => 'Bie',
      ),
      4 => 
      array (
        'code' => 'CAB',
        'name' => 'Cabinda',
      ),
      5 => 
      array (
        'code' => 'CCU',
        'name' => 'Cuando-Cubango',
      ),
      6 => 
      array (
        'code' => 'CNO',
        'name' => 'Cuanza Norte',
      ),
      7 => 
      array (
        'code' => 'CUS',
        'name' => 'Cuanza Sul',
      ),
      8 => 
      array (
        'code' => 'CNN',
        'name' => 'Cunene',
      ),
      9 => 
      array (
        'code' => 'HUA',
        'name' => 'Huambo',
      ),
      10 => 
      array (
        'code' => 'HUI',
        'name' => 'Huila',
      ),
      11 => 
      array (
        'code' => 'LUA',
        'name' => 'Luanda',
      ),
      12 => 
      array (
        'code' => 'LNO',
        'name' => 'Lunda Norte',
      ),
      13 => 
      array (
        'code' => 'LSU',
        'name' => 'Lunda Sul',
      ),
      14 => 
      array (
        'code' => 'MAL',
        'name' => 'Malange',
      ),
      15 => 
      array (
        'code' => 'MOX',
        'name' => 'Moxico',
      ),
      16 => 
      array (
        'code' => 'NAM',
        'name' => 'Namibe',
      ),
      17 => 
      array (
        'code' => 'UIG',
        'name' => 'Uige',
      ),
      18 => 
      array (
        'code' => 'ZAI',
        'name' => 'Zaire',
      ),
    ),
    'AQ' => 
    array (
      1 => 
      array (
        'code' => 'ASG',
        'name' => 'Saint George',
      ),
      2 => 
      array (
        'code' => 'ASH',
        'name' => 'Saint Philip',
      ),
      3 => 
      array (
        'code' => 'ASJ',
        'name' => 'Saint John',
      ),
      4 => 
      array (
        'code' => 'ASL',
        'name' => 'Saint Paul',
      ),
      5 => 
      array (
        'code' => 'ASM',
        'name' => 'Saint Mary',
      ),
      6 => 
      array (
        'code' => 'ASR',
        'name' => 'Saint Peter',
      ),
      7 => 
      array (
        'code' => 'BAR',
        'name' => 'Barbuda',
      ),
      8 => 
      array (
        'code' => 'RED',
        'name' => 'Redonda',
      ),
    ),
    'AR' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Antartida e Islas del Atlantico',
      ),
      2 => 
      array (
        'code' => 'BA',
        'name' => 'Buenos Aires',
      ),
      3 => 
      array (
        'code' => 'CA',
        'name' => 'Catamarca',
      ),
      4 => 
      array (
        'code' => 'CH',
        'name' => 'Chaco',
      ),
      5 => 
      array (
        'code' => 'CU',
        'name' => 'Chubut',
      ),
      6 => 
      array (
        'code' => 'CO',
        'name' => 'Cordoba',
      ),
      7 => 
      array (
        'code' => 'CR',
        'name' => 'Corrientes',
      ),
      8 => 
      array (
        'code' => 'CF',
        'name' => 'Capital Federal',
      ),
      9 => 
      array (
        'code' => 'ER',
        'name' => 'Entre Rios',
      ),
      10 => 
      array (
        'code' => 'FO',
        'name' => 'Formosa',
      ),
      11 => 
      array (
        'code' => 'JU',
        'name' => 'Jujuy',
      ),
      12 => 
      array (
        'code' => 'LP',
        'name' => 'La Pampa',
      ),
      13 => 
      array (
        'code' => 'LR',
        'name' => 'La Rioja',
      ),
      14 => 
      array (
        'code' => 'ME',
        'name' => 'Mendoza',
      ),
      15 => 
      array (
        'code' => 'MI',
        'name' => 'Misiones',
      ),
      16 => 
      array (
        'code' => 'NE',
        'name' => 'Neuquen',
      ),
      17 => 
      array (
        'code' => 'RN',
        'name' => 'Rio Negro',
      ),
      18 => 
      array (
        'code' => 'SA',
        'name' => 'Salta',
      ),
      19 => 
      array (
        'code' => 'SJ',
        'name' => 'San Juan',
      ),
      20 => 
      array (
        'code' => 'SL',
        'name' => 'San Luis',
      ),
      21 => 
      array (
        'code' => 'SC',
        'name' => 'Santa Cruz',
      ),
      22 => 
      array (
        'code' => 'SF',
        'name' => 'Santa Fe',
      ),
      23 => 
      array (
        'code' => 'SD',
        'name' => 'Santiago del Estero',
      ),
      24 => 
      array (
        'code' => 'TF',
        'name' => 'Tierra del Fuego',
      ),
      25 => 
      array (
        'code' => 'TU',
        'name' => 'Tucuman',
      ),
    ),
    'AS' => 
    array (
      1 => 
      array (
        'code' => 'E',
        'name' => 'Eastern',
      ),
      2 => 
      array (
        'code' => 'M',
        'name' => 'Manu&#39;a',
      ),
      3 => 
      array (
        'code' => 'R',
        'name' => 'Rose Island',
      ),
      4 => 
      array (
        'code' => 'S',
        'name' => 'Swains Island',
      ),
      5 => 
      array (
        'code' => 'W',
        'name' => 'Western',
      ),
    ),
    'AT' => 
    array (
      1 => 
      array (
        'code' => 'BUR',
        'name' => 'Burgenland',
      ),
      2 => 
      array (
        'code' => 'KAR',
        'name' => 'Krnten',
      ),
      3 => 
      array (
        'code' => 'NOS',
        'name' => 'Niederöesterreich',
      ),
      4 => 
      array (
        'code' => 'OOS',
        'name' => 'Oberöesterreich',
      ),
      5 => 
      array (
        'code' => 'SAL',
        'name' => 'Salzburg',
      ),
      6 => 
      array (
        'code' => 'STE',
        'name' => 'Steiermark',
      ),
      7 => 
      array (
        'code' => 'TIR',
        'name' => 'Tirol',
      ),
      8 => 
      array (
        'code' => 'VOR',
        'name' => 'Vorarlberg',
      ),
      9 => 
      array (
        'code' => 'WIE',
        'name' => 'Wien',
      ),
    ),
    'AU' => 
    array (
      1 => 
      array (
        'code' => 'ACT',
        'name' => 'Australian Capital Territory',
      ),
      2 => 
      array (
        'code' => 'NSW',
        'name' => 'New South Wales',
      ),
      3 => 
      array (
        'code' => 'NT',
        'name' => 'Northern Territory',
      ),
      4 => 
      array (
        'code' => 'QLD',
        'name' => 'Queensland',
      ),
      5 => 
      array (
        'code' => 'SA',
        'name' => 'South Australia',
      ),
      6 => 
      array (
        'code' => 'TAS',
        'name' => 'Tasmania',
      ),
      7 => 
      array (
        'code' => 'VIC',
        'name' => 'Victoria',
      ),
      8 => 
      array (
        'code' => 'WA',
        'name' => 'Western Australia',
      ),
    ),
    'AW' => 
    array (
      1 => 
      array (
        'code' => 'ARU',
        'name' => 'Aruba',
      ),
      2 => 
      array (
        'code' => 'DRU',
        'name' => 'Druif Beach',
      ),
      3 => 
      array (
        'code' => 'MAN',
        'name' => 'Manchebo Beach',
      ),
      4 => 
      array (
        'code' => 'NOO',
        'name' => 'Noord',
      ),
      5 => 
      array (
        'code' => 'ORA',
        'name' => 'Oranjestad',
      ),
      6 => 
      array (
        'code' => 'PAL',
        'name' => 'Palm Beach',
      ),
      7 => 
      array (
        'code' => 'ROO',
        'name' => 'Rooi Thomas',
      ),
      8 => 
      array (
        'code' => 'SIN',
        'name' => 'Sint Nicolaas',
      ),
      9 => 
      array (
        'code' => 'SIN',
        'name' => 'Sint Nicolas',
      ),
      10 => 
      array (
        'code' => 'WAY',
        'name' => 'Wayaca',
      ),
    ),
    'AZ' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => 'Ali Bayramli',
      ),
      2 => 
      array (
        'code' => 'ABS',
        'name' => 'Abseron',
      ),
      3 => 
      array (
        'code' => 'AGC',
        'name' => 'AgcabAdi',
      ),
      4 => 
      array (
        'code' => 'AGM',
        'name' => 'Agdam',
      ),
      5 => 
      array (
        'code' => 'AGS',
        'name' => 'Agdas',
      ),
      6 => 
      array (
        'code' => 'AGA',
        'name' => 'Agstafa',
      ),
      7 => 
      array (
        'code' => 'AGU',
        'name' => 'Agsu',
      ),
      8 => 
      array (
        'code' => 'AST',
        'name' => 'Astara',
      ),
      9 => 
      array (
        'code' => 'BA',
        'name' => 'Baki',
      ),
      10 => 
      array (
        'code' => 'BAB',
        'name' => 'BabAk',
      ),
      11 => 
      array (
        'code' => 'BAL',
        'name' => 'BalakAn',
      ),
      12 => 
      array (
        'code' => 'BAR',
        'name' => 'BArdA',
      ),
      13 => 
      array (
        'code' => 'BEY',
        'name' => 'Beylaqan',
      ),
      14 => 
      array (
        'code' => 'BIL',
        'name' => 'Bilasuvar',
      ),
      15 => 
      array (
        'code' => 'CAB',
        'name' => 'Cabrayil',
      ),
      16 => 
      array (
        'code' => 'CAL',
        'name' => 'Calilabab',
      ),
      17 => 
      array (
        'code' => 'CUL',
        'name' => 'Culfa',
      ),
      18 => 
      array (
        'code' => 'DAS',
        'name' => 'Daskasan',
      ),
      19 => 
      array (
        'code' => 'DAV',
        'name' => 'Davaci',
      ),
      20 => 
      array (
        'code' => 'FUZ',
        'name' => 'Fuzuli',
      ),
      21 => 
      array (
        'code' => 'GA',
        'name' => 'Ganca',
      ),
      22 => 
      array (
        'code' => 'GAD',
        'name' => 'Gadabay',
      ),
      23 => 
      array (
        'code' => 'GOR',
        'name' => 'Goranboy',
      ),
      24 => 
      array (
        'code' => 'GOY',
        'name' => 'Goycay',
      ),
      25 => 
      array (
        'code' => 'HAC',
        'name' => 'Haciqabul',
      ),
      26 => 
      array (
        'code' => 'IMI',
        'name' => 'Imisli',
      ),
      27 => 
      array (
        'code' => 'ISM',
        'name' => 'Ismayilli',
      ),
      28 => 
      array (
        'code' => 'KAL',
        'name' => 'Kalbacar',
      ),
      29 => 
      array (
        'code' => 'KUR',
        'name' => 'Kurdamir',
      ),
      30 => 
      array (
        'code' => 'LA',
        'name' => 'Lankaran',
      ),
      31 => 
      array (
        'code' => 'LAC',
        'name' => 'Lacin',
      ),
      32 => 
      array (
        'code' => 'LAN',
        'name' => 'Lankaran',
      ),
      33 => 
      array (
        'code' => 'LER',
        'name' => 'Lerik',
      ),
      34 => 
      array (
        'code' => 'MAS',
        'name' => 'Masalli',
      ),
      35 => 
      array (
        'code' => 'MI',
        'name' => 'Mingacevir',
      ),
      36 => 
      array (
        'code' => 'NA',
        'name' => 'Naftalan',
      ),
      37 => 
      array (
        'code' => 'NX',
        'name' => 'Naxcivan',
      ),
      38 => 
      array (
        'code' => 'NEF',
        'name' => 'Neftcala',
      ),
      39 => 
      array (
        'code' => 'OGU',
        'name' => 'Oguz',
      ),
      40 => 
      array (
        'code' => 'ORD',
        'name' => 'Ordubad',
      ),
      41 => 
      array (
        'code' => 'QAB',
        'name' => 'Qabala',
      ),
      42 => 
      array (
        'code' => 'QAX',
        'name' => 'Qax',
      ),
      43 => 
      array (
        'code' => 'QAZ',
        'name' => 'Qazax',
      ),
      44 => 
      array (
        'code' => 'QOB',
        'name' => 'Qobustan',
      ),
      45 => 
      array (
        'code' => 'QBA',
        'name' => 'Quba',
      ),
      46 => 
      array (
        'code' => 'QBI',
        'name' => 'Qubadli',
      ),
      47 => 
      array (
        'code' => 'QUS',
        'name' => 'Qusar',
      ),
      48 => 
      array (
        'code' => 'SA',
        'name' => 'Saki',
      ),
      49 => 
      array (
        'code' => 'SAT',
        'name' => 'Saatli',
      ),
      50 => 
      array (
        'code' => 'SAB',
        'name' => 'Sabirabad',
      ),
      51 => 
      array (
        'code' => 'SAD',
        'name' => 'Sadarak',
      ),
      52 => 
      array (
        'code' => 'SAH',
        'name' => 'Sahbuz',
      ),
      53 => 
      array (
        'code' => 'SAK',
        'name' => 'Saki',
      ),
      54 => 
      array (
        'code' => 'SAL',
        'name' => 'Salyan',
      ),
      55 => 
      array (
        'code' => 'SM',
        'name' => 'Sumqayit',
      ),
      56 => 
      array (
        'code' => 'SMI',
        'name' => 'Samaxi',
      ),
      57 => 
      array (
        'code' => 'SKR',
        'name' => 'Samkir',
      ),
      58 => 
      array (
        'code' => 'SMX',
        'name' => 'Samux',
      ),
      59 => 
      array (
        'code' => 'SAR',
        'name' => 'Sarur',
      ),
      60 => 
      array (
        'code' => 'SIY',
        'name' => 'Siyazan',
      ),
      61 => 
      array (
        'code' => 'SS',
        'name' => 'Susa',
      ),
      62 => 
      array (
        'code' => 'SUS',
        'name' => 'Susa',
      ),
      63 => 
      array (
        'code' => 'TAR',
        'name' => 'Tartar',
      ),
      64 => 
      array (
        'code' => 'TOV',
        'name' => 'Tovuz',
      ),
      65 => 
      array (
        'code' => 'UCA',
        'name' => 'Ucar',
      ),
      66 => 
      array (
        'code' => 'XA',
        'name' => 'Xankandi',
      ),
      67 => 
      array (
        'code' => 'XAC',
        'name' => 'Xacmaz',
      ),
      68 => 
      array (
        'code' => 'XAN',
        'name' => 'Xanlar',
      ),
      69 => 
      array (
        'code' => 'XIZ',
        'name' => 'Xizi',
      ),
      70 => 
      array (
        'code' => 'XCI',
        'name' => 'Xocali',
      ),
      71 => 
      array (
        'code' => 'XVD',
        'name' => 'Xocavand',
      ),
      72 => 
      array (
        'code' => 'YAR',
        'name' => 'Yardimli',
      ),
      73 => 
      array (
        'code' => 'YEV',
        'name' => 'Yevlax',
      ),
      74 => 
      array (
        'code' => 'ZAN',
        'name' => 'Zangilan',
      ),
      75 => 
      array (
        'code' => 'ZAQ',
        'name' => 'Zaqatala',
      ),
      76 => 
      array (
        'code' => 'ZAR',
        'name' => 'Zardab',
      ),
    ),
    'BA' => 
    array (
      1 => 
      array (
        'code' => 'BRO',
        'name' => 'Brcko district',
      ),
      2 => 
      array (
        'code' => 'FBP',
        'name' => 'Bosanskopodrinjski Kanton',
      ),
      3 => 
      array (
        'code' => 'FHN',
        'name' => 'Hercegovacko-neretvanski Kanton',
      ),
      4 => 
      array (
        'code' => 'FPO',
        'name' => 'Posavski Kanton',
      ),
      5 => 
      array (
        'code' => 'FSA',
        'name' => 'Kanton Sarajevo',
      ),
      6 => 
      array (
        'code' => 'FSB',
        'name' => 'Srednjebosanski Kanton',
      ),
      7 => 
      array (
        'code' => 'FTU',
        'name' => 'Tuzlanski Kanton',
      ),
      8 => 
      array (
        'code' => 'FUS',
        'name' => 'Unsko-Sanski Kanton',
      ),
      9 => 
      array (
        'code' => 'FZA',
        'name' => 'Zapadnobosanska',
      ),
      10 => 
      array (
        'code' => 'FZE',
        'name' => 'Zenicko-Dobojski Kanton',
      ),
      11 => 
      array (
        'code' => 'FZH',
        'name' => 'Zapadnohercegovacka Zupanija',
      ),
      12 => 
      array (
        'code' => 'SBI',
        'name' => 'Bijeljina',
      ),
      13 => 
      array (
        'code' => 'SBL',
        'name' => 'Banja Luka',
      ),
      14 => 
      array (
        'code' => 'SDO',
        'name' => 'Doboj',
      ),
      15 => 
      array (
        'code' => 'SFO',
        'name' => 'Foca',
      ),
      16 => 
      array (
        'code' => 'SSR',
        'name' => 'Sarajevo-Romanija or Sokolac',
      ),
      17 => 
      array (
        'code' => 'STR',
        'name' => 'Trebinje',
      ),
      18 => 
      array (
        'code' => 'SVL',
        'name' => 'Vlasenica',
      ),
    ),
    'BB' => 
    array (
      1 => 
      array (
        'code' => 'CC',
        'name' => 'Christ Church',
      ),
      2 => 
      array (
        'code' => 'AND',
        'name' => 'Saint Andrew',
      ),
      3 => 
      array (
        'code' => 'GEO',
        'name' => 'Saint George',
      ),
      4 => 
      array (
        'code' => 'JAM',
        'name' => 'Saint James',
      ),
      5 => 
      array (
        'code' => 'JOH',
        'name' => 'Saint John',
      ),
      6 => 
      array (
        'code' => 'JOS',
        'name' => 'Saint Joseph',
      ),
      7 => 
      array (
        'code' => 'LUC',
        'name' => 'Saint Lucy',
      ),
      8 => 
      array (
        'code' => 'MIC',
        'name' => 'Saint Michael',
      ),
      9 => 
      array (
        'code' => 'PET',
        'name' => 'Saint Peter',
      ),
      10 => 
      array (
        'code' => 'PHI',
        'name' => 'Saint Philip',
      ),
      11 => 
      array (
        'code' => 'THO',
        'name' => 'Saint Thomas',
      ),
    ),
    'BD' => 
    array (
      1 => 
      array (
        'code' => 'BAR',
        'name' => 'Barisal',
      ),
      2 => 
      array (
        'code' => 'CHI',
        'name' => 'Chittagong',
      ),
      3 => 
      array (
        'code' => 'DHA',
        'name' => 'Dhaka',
      ),
      4 => 
      array (
        'code' => 'KHU',
        'name' => 'Khulna',
      ),
      5 => 
      array (
        'code' => 'RAJ',
        'name' => 'Rajshahi',
      ),
      6 => 
      array (
        'code' => 'SYL',
        'name' => 'Sylhet',
      ),
    ),
    'BE' => 
    array (
      1 => 
      array (
        'code' => 'VAN',
        'name' => 'Antwerpen',
      ),
      2 => 
      array (
        'code' => 'WBR',
        'name' => 'Brabant Wallon',
      ),
      3 => 
      array (
        'code' => 'WHT',
        'name' => 'Hainaut',
      ),
      4 => 
      array (
        'code' => 'WLG',
        'name' => 'Liege',
      ),
      5 => 
      array (
        'code' => 'VLI',
        'name' => 'Limburg',
      ),
      6 => 
      array (
        'code' => 'WLX',
        'name' => 'Luxembourg',
      ),
      7 => 
      array (
        'code' => 'WNA',
        'name' => 'Namur',
      ),
      8 => 
      array (
        'code' => 'VOV',
        'name' => 'Oost-Vlaanderen',
      ),
      9 => 
      array (
        'code' => 'VBR',
        'name' => 'Vlaams Brabant',
      ),
      10 => 
      array (
        'code' => 'VWV',
        'name' => 'West-Vlaanderen',
      ),
    ),
    'BF' => 
    array (
      1 => 
      array (
        'code' => 'BAL',
        'name' => 'Bale',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => 'Bam',
      ),
      3 => 
      array (
        'code' => 'BAN',
        'name' => 'Banwa',
      ),
      4 => 
      array (
        'code' => 'BAZ',
        'name' => 'Bazega',
      ),
      5 => 
      array (
        'code' => 'BOR',
        'name' => 'Bougouriba',
      ),
      6 => 
      array (
        'code' => 'BLG',
        'name' => 'Boulgou',
      ),
      7 => 
      array (
        'code' => 'BOK',
        'name' => 'Boulkiemde',
      ),
      8 => 
      array (
        'code' => 'COM',
        'name' => 'Comoe',
      ),
      9 => 
      array (
        'code' => 'GAN',
        'name' => 'Ganzourgou',
      ),
      10 => 
      array (
        'code' => 'GNA',
        'name' => 'Gnagna',
      ),
      11 => 
      array (
        'code' => 'GOU',
        'name' => 'Gourma',
      ),
      12 => 
      array (
        'code' => 'HOU',
        'name' => 'Houet',
      ),
      13 => 
      array (
        'code' => 'IOA',
        'name' => 'Ioba',
      ),
      14 => 
      array (
        'code' => 'KAD',
        'name' => 'Kadiogo',
      ),
      15 => 
      array (
        'code' => 'KEN',
        'name' => 'Kenedougou',
      ),
      16 => 
      array (
        'code' => 'KOD',
        'name' => 'Komondjari',
      ),
      17 => 
      array (
        'code' => 'KOP',
        'name' => 'Kompienga',
      ),
      18 => 
      array (
        'code' => 'KOS',
        'name' => 'Kossi',
      ),
      19 => 
      array (
        'code' => 'KOL',
        'name' => 'Koulpelogo',
      ),
      20 => 
      array (
        'code' => 'KOT',
        'name' => 'Kouritenga',
      ),
      21 => 
      array (
        'code' => 'KOW',
        'name' => 'Kourweogo',
      ),
      22 => 
      array (
        'code' => 'LER',
        'name' => 'Leraba',
      ),
      23 => 
      array (
        'code' => 'LOR',
        'name' => 'Loroum',
      ),
      24 => 
      array (
        'code' => 'MOU',
        'name' => 'Mouhoun',
      ),
      25 => 
      array (
        'code' => 'NAH',
        'name' => 'Nahouri',
      ),
      26 => 
      array (
        'code' => 'NAM',
        'name' => 'Namentenga',
      ),
      27 => 
      array (
        'code' => 'NAY',
        'name' => 'Nayala',
      ),
      28 => 
      array (
        'code' => 'NOU',
        'name' => 'Noumbiel',
      ),
      29 => 
      array (
        'code' => 'OUB',
        'name' => 'Oubritenga',
      ),
      30 => 
      array (
        'code' => 'OUD',
        'name' => 'Oudalan',
      ),
      31 => 
      array (
        'code' => 'PAS',
        'name' => 'Passore',
      ),
      32 => 
      array (
        'code' => 'PON',
        'name' => 'Poni',
      ),
      33 => 
      array (
        'code' => 'SAG',
        'name' => 'Sanguie',
      ),
      34 => 
      array (
        'code' => 'SAM',
        'name' => 'Sanmatenga',
      ),
      35 => 
      array (
        'code' => 'SEN',
        'name' => 'Seno',
      ),
      36 => 
      array (
        'code' => 'SIS',
        'name' => 'Sissili',
      ),
      37 => 
      array (
        'code' => 'SOM',
        'name' => 'Soum',
      ),
      38 => 
      array (
        'code' => 'SOR',
        'name' => 'Sourou',
      ),
      39 => 
      array (
        'code' => 'TAP',
        'name' => 'Tapoa',
      ),
      40 => 
      array (
        'code' => 'TUY',
        'name' => 'Tuy',
      ),
      41 => 
      array (
        'code' => 'YAG',
        'name' => 'Yagha',
      ),
      42 => 
      array (
        'code' => 'YAT',
        'name' => 'Yatenga',
      ),
      43 => 
      array (
        'code' => 'ZIR',
        'name' => 'Ziro',
      ),
      44 => 
      array (
        'code' => 'ZOD',
        'name' => 'Zondoma',
      ),
      45 => 
      array (
        'code' => 'ZOW',
        'name' => 'Zoundweogo',
      ),
    ),
    'BG' => 
    array (
      1 => 
      array (
        'code' => 'BG-01',
        'name' => 'Blagoevgrad',
      ),
      2 => 
      array (
        'code' => 'BG-02',
        'name' => 'Burgas',
      ),
      3 => 
      array (
        'code' => 'BG-03',
        'name' => 'Dobrich',
      ),
      4 => 
      array (
        'code' => 'BG-04',
        'name' => 'Gabrovo',
      ),
      5 => 
      array (
        'code' => 'BG-05',
        'name' => 'Haskovo',
      ),
      6 => 
      array (
        'code' => 'BG-06',
        'name' => 'Kardjali',
      ),
      7 => 
      array (
        'code' => 'BG-07',
        'name' => 'Kyustendil',
      ),
      8 => 
      array (
        'code' => 'BG-08',
        'name' => 'Lovech',
      ),
      9 => 
      array (
        'code' => 'BG-09',
        'name' => 'Montana',
      ),
      10 => 
      array (
        'code' => 'BG-10',
        'name' => 'Pazardjik',
      ),
      11 => 
      array (
        'code' => 'BG-11',
        'name' => 'Pernik',
      ),
      12 => 
      array (
        'code' => 'BG-12',
        'name' => 'Pleven',
      ),
      13 => 
      array (
        'code' => 'BG-13',
        'name' => 'Plovdiv',
      ),
      14 => 
      array (
        'code' => 'BG-14',
        'name' => 'Razgrad',
      ),
      15 => 
      array (
        'code' => 'BG-15',
        'name' => 'Shumen',
      ),
      16 => 
      array (
        'code' => 'BG-16',
        'name' => 'Silistra',
      ),
      17 => 
      array (
        'code' => 'BG-17',
        'name' => 'Sliven',
      ),
      18 => 
      array (
        'code' => 'BG-18',
        'name' => 'Smolyan',
      ),
      19 => 
      array (
        'code' => 'BG-19',
        'name' => 'Sofia',
      ),
      20 => 
      array (
        'code' => 'BG-20',
        'name' => 'Sofia - town',
      ),
      21 => 
      array (
        'code' => 'BG-21',
        'name' => 'Stara Zagora',
      ),
      22 => 
      array (
        'code' => 'BG-22',
        'name' => 'Targovishte',
      ),
      23 => 
      array (
        'code' => 'BG-23',
        'name' => 'Varna',
      ),
      24 => 
      array (
        'code' => 'BG-24',
        'name' => 'Veliko Tarnovo',
      ),
      25 => 
      array (
        'code' => 'BG-25',
        'name' => 'Vidin',
      ),
      26 => 
      array (
        'code' => 'BG-26',
        'name' => 'Vratza',
      ),
      27 => 
      array (
        'code' => 'BG-27',
        'name' => 'Yambol',
      ),
    ),
    'BH' => 
    array (
      1 => 
      array (
        'code' => 'CAP',
        'name' => 'Capital',
      ),
      2 => 
      array (
        'code' => 'CEN',
        'name' => 'Central',
      ),
      3 => 
      array (
        'code' => 'MUH',
        'name' => 'Muharraq',
      ),
      4 => 
      array (
        'code' => 'NOR',
        'name' => 'Northern',
      ),
      5 => 
      array (
        'code' => 'SOU',
        'name' => 'Southern',
      ),
    ),
    'BI' => 
    array (
      1 => 
      array (
        'code' => 'BB',
        'name' => 'Bubanza',
      ),
      2 => 
      array (
        'code' => 'BJ',
        'name' => 'Bujumbura',
      ),
      3 => 
      array (
        'code' => 'BR',
        'name' => 'Bururi',
      ),
      4 => 
      array (
        'code' => 'CA',
        'name' => 'Cankuzo',
      ),
      5 => 
      array (
        'code' => 'CI',
        'name' => 'Cibitoke',
      ),
      6 => 
      array (
        'code' => 'GI',
        'name' => 'Gitega',
      ),
      7 => 
      array (
        'code' => 'KR',
        'name' => 'Karuzi',
      ),
      8 => 
      array (
        'code' => 'KY',
        'name' => 'Kayanza',
      ),
      9 => 
      array (
        'code' => 'KI',
        'name' => 'Kirundo',
      ),
      10 => 
      array (
        'code' => 'MA',
        'name' => 'Makamba',
      ),
      11 => 
      array (
        'code' => 'MU',
        'name' => 'Muramvya',
      ),
      12 => 
      array (
        'code' => 'MY',
        'name' => 'Muyinga',
      ),
      13 => 
      array (
        'code' => 'MW',
        'name' => 'Mwaro',
      ),
      14 => 
      array (
        'code' => 'NG',
        'name' => 'Ngozi',
      ),
      15 => 
      array (
        'code' => 'RT',
        'name' => 'Rutana',
      ),
      16 => 
      array (
        'code' => 'RY',
        'name' => 'Ruyigi',
      ),
    ),
    'BJ' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Alibori',
      ),
      2 => 
      array (
        'code' => 'AK',
        'name' => 'Atakora',
      ),
      3 => 
      array (
        'code' => 'AQ',
        'name' => 'Atlantique',
      ),
      4 => 
      array (
        'code' => 'BO',
        'name' => 'Borgou',
      ),
      5 => 
      array (
        'code' => 'CO',
        'name' => 'Collines',
      ),
      6 => 
      array (
        'code' => 'DO',
        'name' => 'Donga',
      ),
      7 => 
      array (
        'code' => 'KO',
        'name' => 'Kouffo',
      ),
      8 => 
      array (
        'code' => 'LI',
        'name' => 'Littoral',
      ),
      9 => 
      array (
        'code' => 'MO',
        'name' => 'Mono',
      ),
      10 => 
      array (
        'code' => 'OU',
        'name' => 'Oueme',
      ),
      11 => 
      array (
        'code' => 'PL',
        'name' => 'Plateau',
      ),
      12 => 
      array (
        'code' => 'ZO',
        'name' => 'Zou',
      ),
    ),
    'BM' => 
    array (
      1 => 
      array (
        'code' => 'DS',
        'name' => 'Devonshire',
      ),
      2 => 
      array (
        'code' => 'HC',
        'name' => 'Hamilton City',
      ),
      3 => 
      array (
        'code' => 'HA',
        'name' => 'Hamilton',
      ),
      4 => 
      array (
        'code' => 'PG',
        'name' => 'Paget',
      ),
      5 => 
      array (
        'code' => 'PB',
        'name' => 'Pembroke',
      ),
      6 => 
      array (
        'code' => 'GC',
        'name' => 'Saint George City',
      ),
      7 => 
      array (
        'code' => 'SG',
        'name' => 'Saint George&#39;s',
      ),
      8 => 
      array (
        'code' => 'SA',
        'name' => 'Sandys',
      ),
      9 => 
      array (
        'code' => 'SM',
        'name' => 'Smith&#39;s',
      ),
      10 => 
      array (
        'code' => 'SH',
        'name' => 'Southampton',
      ),
      11 => 
      array (
        'code' => 'WA',
        'name' => 'Warwick',
      ),
    ),
    'BN' => 
    array (
      1 => 
      array (
        'code' => 'BEL',
        'name' => 'Belait',
      ),
      2 => 
      array (
        'code' => 'BRM',
        'name' => 'Brunei and Muara',
      ),
      3 => 
      array (
        'code' => 'TEM',
        'name' => 'Temburong',
      ),
      4 => 
      array (
        'code' => 'TUT',
        'name' => 'Tutong',
      ),
    ),
    'BO' => 
    array (
      1 => 
      array (
        'code' => 'BEN',
        'name' => 'Beni',
      ),
      2 => 
      array (
        'code' => 'CHU',
        'name' => 'Chuquisaca',
      ),
      3 => 
      array (
        'code' => 'COC',
        'name' => 'Cochabamba',
      ),
      4 => 
      array (
        'code' => 'LPZ',
        'name' => 'La Paz',
      ),
      5 => 
      array (
        'code' => 'ORU',
        'name' => 'Oruro',
      ),
      6 => 
      array (
        'code' => 'PAN',
        'name' => 'Pando',
      ),
      7 => 
      array (
        'code' => 'POT',
        'name' => 'Potosi',
      ),
      8 => 
      array (
        'code' => 'SCZ',
        'name' => 'Santa Cruz',
      ),
      9 => 
      array (
        'code' => 'TAR',
        'name' => 'Tarija',
      ),
    ),
    'BR' => 
    array (
      1 => 
      array (
        'code' => 'AC',
        'name' => 'Acre',
      ),
      2 => 
      array (
        'code' => 'AL',
        'name' => 'Alagoas',
      ),
      3 => 
      array (
        'code' => 'AP',
        'name' => 'Amapa',
      ),
      4 => 
      array (
        'code' => 'AM',
        'name' => 'Amazonas',
      ),
      5 => 
      array (
        'code' => 'BA',
        'name' => 'Bahia',
      ),
      6 => 
      array (
        'code' => 'CE',
        'name' => 'Ceara',
      ),
      7 => 
      array (
        'code' => 'DF',
        'name' => 'Distrito Federal',
      ),
      8 => 
      array (
        'code' => 'ES',
        'name' => 'Espirito Santo',
      ),
      9 => 
      array (
        'code' => 'GO',
        'name' => 'Goias',
      ),
      10 => 
      array (
        'code' => 'MA',
        'name' => 'Maranhao',
      ),
      11 => 
      array (
        'code' => 'MT',
        'name' => 'Mato Grosso',
      ),
      12 => 
      array (
        'code' => 'MS',
        'name' => 'Mato Grosso do Sul',
      ),
      13 => 
      array (
        'code' => 'MG',
        'name' => 'Minas Gerais',
      ),
      14 => 
      array (
        'code' => 'PA',
        'name' => 'Para',
      ),
      15 => 
      array (
        'code' => 'PB',
        'name' => 'Paraiba',
      ),
      16 => 
      array (
        'code' => 'PR',
        'name' => 'Parana',
      ),
      17 => 
      array (
        'code' => 'PE',
        'name' => 'Pernambuco',
      ),
      18 => 
      array (
        'code' => 'PI',
        'name' => 'Piaui',
      ),
      19 => 
      array (
        'code' => 'RJ',
        'name' => 'Rio de Janeiro',
      ),
      20 => 
      array (
        'code' => 'RN',
        'name' => 'Rio Grande do Norte',
      ),
      21 => 
      array (
        'code' => 'RS',
        'name' => 'Rio Grande do Sul',
      ),
      22 => 
      array (
        'code' => 'RO',
        'name' => 'Rondonia',
      ),
      23 => 
      array (
        'code' => 'RR',
        'name' => 'Roraima',
      ),
      24 => 
      array (
        'code' => 'SC',
        'name' => 'Santa Catarina',
      ),
      25 => 
      array (
        'code' => 'SP',
        'name' => 'Sao Paulo',
      ),
      26 => 
      array (
        'code' => 'SE',
        'name' => 'Sergipe',
      ),
      27 => 
      array (
        'code' => 'TO',
        'name' => 'Tocantins',
      ),
    ),
    'BS' => 
    array (
      1 => 
      array (
        'code' => 'ACK',
        'name' => 'Acklins',
      ),
      2 => 
      array (
        'code' => 'BER',
        'name' => 'Berry Islands',
      ),
      3 => 
      array (
        'code' => 'BIM',
        'name' => 'Bimini',
      ),
      4 => 
      array (
        'code' => 'BLK',
        'name' => 'Black Point',
      ),
      5 => 
      array (
        'code' => 'CAT',
        'name' => 'Cat Island',
      ),
      6 => 
      array (
        'code' => 'CAB',
        'name' => 'Central Abaco',
      ),
      7 => 
      array (
        'code' => 'CAN',
        'name' => 'Central Andros',
      ),
      8 => 
      array (
        'code' => 'CEL',
        'name' => 'Central Eleuthera',
      ),
      9 => 
      array (
        'code' => 'FRE',
        'name' => 'City of Freeport',
      ),
      10 => 
      array (
        'code' => 'CRO',
        'name' => 'Crooked Island',
      ),
      11 => 
      array (
        'code' => 'EGB',
        'name' => 'East Grand Bahama',
      ),
      12 => 
      array (
        'code' => 'EXU',
        'name' => 'Exuma',
      ),
      13 => 
      array (
        'code' => 'GRD',
        'name' => 'Grand Cay',
      ),
      14 => 
      array (
        'code' => 'HAR',
        'name' => 'Harbour Island',
      ),
      15 => 
      array (
        'code' => 'HOP',
        'name' => 'Hope Town',
      ),
      16 => 
      array (
        'code' => 'INA',
        'name' => 'Inagua',
      ),
      17 => 
      array (
        'code' => 'LNG',
        'name' => 'Long Island',
      ),
      18 => 
      array (
        'code' => 'MAN',
        'name' => 'Mangrove Cay',
      ),
      19 => 
      array (
        'code' => 'MAY',
        'name' => 'Mayaguana',
      ),
      20 => 
      array (
        'code' => 'MOO',
        'name' => 'Moore&#39;s Island',
      ),
      21 => 
      array (
        'code' => 'NAB',
        'name' => 'North Abaco',
      ),
      22 => 
      array (
        'code' => 'NAN',
        'name' => 'North Andros',
      ),
      23 => 
      array (
        'code' => 'NEL',
        'name' => 'North Eleuthera',
      ),
      24 => 
      array (
        'code' => 'RAG',
        'name' => 'Ragged Island',
      ),
      25 => 
      array (
        'code' => 'RUM',
        'name' => 'Rum Cay',
      ),
      26 => 
      array (
        'code' => 'SAL',
        'name' => 'San Salvador',
      ),
      27 => 
      array (
        'code' => 'SAB',
        'name' => 'South Abaco',
      ),
      28 => 
      array (
        'code' => 'SAN',
        'name' => 'South Andros',
      ),
      29 => 
      array (
        'code' => 'SEL',
        'name' => 'South Eleuthera',
      ),
      30 => 
      array (
        'code' => 'SWE',
        'name' => 'Spanish Wells',
      ),
      31 => 
      array (
        'code' => 'WGB',
        'name' => 'West Grand Bahama',
      ),
    ),
    'BT' => 
    array (
      1 => 
      array (
        'code' => 'BUM',
        'name' => 'Bumthang',
      ),
      2 => 
      array (
        'code' => 'CHU',
        'name' => 'Chukha',
      ),
      3 => 
      array (
        'code' => 'DAG',
        'name' => 'Dagana',
      ),
      4 => 
      array (
        'code' => 'GAS',
        'name' => 'Gasa',
      ),
      5 => 
      array (
        'code' => 'HAA',
        'name' => 'Haa',
      ),
      6 => 
      array (
        'code' => 'LHU',
        'name' => 'Lhuntse',
      ),
      7 => 
      array (
        'code' => 'MON',
        'name' => 'Mongar',
      ),
      8 => 
      array (
        'code' => 'PAR',
        'name' => 'Paro',
      ),
      9 => 
      array (
        'code' => 'PEM',
        'name' => 'Pemagatshel',
      ),
      10 => 
      array (
        'code' => 'PUN',
        'name' => 'Punakha',
      ),
      11 => 
      array (
        'code' => 'SJO',
        'name' => 'Samdrup Jongkhar',
      ),
      12 => 
      array (
        'code' => 'SAT',
        'name' => 'Samtse',
      ),
      13 => 
      array (
        'code' => 'SAR',
        'name' => 'Sarpang',
      ),
      14 => 
      array (
        'code' => 'THI',
        'name' => 'Thimphu',
      ),
      15 => 
      array (
        'code' => 'TRG',
        'name' => 'Trashigang',
      ),
      16 => 
      array (
        'code' => 'TRY',
        'name' => 'Trashiyangste',
      ),
      17 => 
      array (
        'code' => 'TRO',
        'name' => 'Trongsa',
      ),
      18 => 
      array (
        'code' => 'TSI',
        'name' => 'Tsirang',
      ),
      19 => 
      array (
        'code' => 'WPH',
        'name' => 'Wangdue Phodrang',
      ),
      20 => 
      array (
        'code' => 'ZHE',
        'name' => 'Zhemgang',
      ),
    ),
    'BW' => 
    array (
      1 => 
      array (
        'code' => 'CE',
        'name' => 'Central',
      ),
      2 => 
      array (
        'code' => 'GH',
        'name' => 'Ghanzi',
      ),
      3 => 
      array (
        'code' => 'KD',
        'name' => 'Kgalagadi',
      ),
      4 => 
      array (
        'code' => 'KT',
        'name' => 'Kgatleng',
      ),
      5 => 
      array (
        'code' => 'KW',
        'name' => 'Kweneng',
      ),
      6 => 
      array (
        'code' => 'NG',
        'name' => 'Ngamiland',
      ),
      7 => 
      array (
        'code' => 'NE',
        'name' => 'North East',
      ),
      8 => 
      array (
        'code' => 'NW',
        'name' => 'North West',
      ),
      9 => 
      array (
        'code' => 'SE',
        'name' => 'South East',
      ),
      10 => 
      array (
        'code' => 'SO',
        'name' => 'Southern',
      ),
    ),
    'BY' => 
    array (
      1 => 
      array (
        'code' => 'BR',
        'name' => 'Brestskaya (Brest)',
      ),
      2 => 
      array (
        'code' => 'HO',
        'name' => 'Homyel&#39;skaya (Homyel&#39;)',
      ),
      3 => 
      array (
        'code' => 'HM',
        'name' => 'Horad Minsk',
      ),
      4 => 
      array (
        'code' => 'HR',
        'name' => 'Hrodzyenskaya (Hrodna)',
      ),
      5 => 
      array (
        'code' => 'MA',
        'name' => 'Mahilyowskaya (Mahilyow)',
      ),
      6 => 
      array (
        'code' => 'MI',
        'name' => 'Minskaya',
      ),
      7 => 
      array (
        'code' => 'VI',
        'name' => 'Vitsyebskaya (Vitsyebsk)',
      ),
    ),
    'BZ' => 
    array (
      1 => 
      array (
        'code' => 'BZ',
        'name' => 'Belize',
      ),
      2 => 
      array (
        'code' => 'CY',
        'name' => 'Cayo',
      ),
      3 => 
      array (
        'code' => 'CR',
        'name' => 'Corozal',
      ),
      4 => 
      array (
        'code' => 'OW',
        'name' => 'Orange Walk',
      ),
      5 => 
      array (
        'code' => 'SC',
        'name' => 'Stann Creek',
      ),
      6 => 
      array (
        'code' => 'TO',
        'name' => 'Toledo',
      ),
    ),
    'CA' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => 'Alberta',
      ),
      2 => 
      array (
        'code' => 'BC',
        'name' => 'British Columbia',
      ),
      3 => 
      array (
        'code' => 'MB',
        'name' => 'Manitoba',
      ),
      4 => 
      array (
        'code' => 'NB',
        'name' => 'New Brunswick',
      ),
      5 => 
      array (
        'code' => 'NL',
        'name' => 'Newfoundland and Labrador',
      ),
      6 => 
      array (
        'code' => 'NT',
        'name' => 'Northwest Territories',
      ),
      7 => 
      array (
        'code' => 'NS',
        'name' => 'Nova Scotia',
      ),
      8 => 
      array (
        'code' => 'NU',
        'name' => 'Nunavut',
      ),
      9 => 
      array (
        'code' => 'ON',
        'name' => 'Ontario',
      ),
      10 => 
      array (
        'code' => 'PE',
        'name' => 'Prince Edward Island',
      ),
      11 => 
      array (
        'code' => 'QC',
        'name' => 'Québec',
      ),
      12 => 
      array (
        'code' => 'SK',
        'name' => 'Saskatchewan',
      ),
      13 => 
      array (
        'code' => 'YT',
        'name' => 'Yukon Territory',
      ),
    ),
    'CC' => 
    array (
      1 => 
      array (
        'code' => 'D',
        'name' => 'Direction Island',
      ),
      2 => 
      array (
        'code' => 'H',
        'name' => 'Home Island',
      ),
      3 => 
      array (
        'code' => 'O',
        'name' => 'Horsburgh Island',
      ),
      4 => 
      array (
        'code' => 'S',
        'name' => 'South Island',
      ),
      5 => 
      array (
        'code' => 'W',
        'name' => 'West Island',
      ),
    ),
    'CF' => 
    array (
      1 => 
      array (
        'code' => 'BAN',
        'name' => 'Bangui',
      ),
      2 => 
      array (
        'code' => 'BBA',
        'name' => 'Bamingui-Bangoran',
      ),
      3 => 
      array (
        'code' => 'BKO',
        'name' => 'Basse-Kotto',
      ),
      4 => 
      array (
        'code' => 'HKO',
        'name' => 'Haute-Kotto',
      ),
      5 => 
      array (
        'code' => 'HMB',
        'name' => 'Haut-Mbomou',
      ),
      6 => 
      array (
        'code' => 'KEM',
        'name' => 'Kemo',
      ),
      7 => 
      array (
        'code' => 'LOB',
        'name' => 'Lobaye',
      ),
      8 => 
      array (
        'code' => 'MBO',
        'name' => 'Mbomou',
      ),
      9 => 
      array (
        'code' => 'MKD',
        'name' => 'Mambéré-Kadéï',
      ),
      10 => 
      array (
        'code' => 'NGR',
        'name' => 'Nana-Grebizi',
      ),
      11 => 
      array (
        'code' => 'NMM',
        'name' => 'Nana-Mambere',
      ),
      12 => 
      array (
        'code' => 'OMP',
        'name' => 'Ombella-M&#39;Poko',
      ),
      13 => 
      array (
        'code' => 'OPE',
        'name' => 'Ouham-Pende',
      ),
      14 => 
      array (
        'code' => 'OUH',
        'name' => 'Ouham',
      ),
      15 => 
      array (
        'code' => 'OUK',
        'name' => 'Ouaka',
      ),
      16 => 
      array (
        'code' => 'SMB',
        'name' => 'Sangha-Mbaere',
      ),
      17 => 
      array (
        'code' => 'VAK',
        'name' => 'Vakaga',
      ),
    ),
    'CG' => 
    array (
      1 => 
      array (
        'code' => 'BO',
        'name' => 'Bouenza',
      ),
      2 => 
      array (
        'code' => 'BR',
        'name' => 'Brazzaville',
      ),
      3 => 
      array (
        'code' => 'CU',
        'name' => 'Cuvette',
      ),
      4 => 
      array (
        'code' => 'CO',
        'name' => 'Cuvette-Ouest',
      ),
      5 => 
      array (
        'code' => 'KO',
        'name' => 'Kouilou',
      ),
      6 => 
      array (
        'code' => 'LE',
        'name' => 'Lekoumou',
      ),
      7 => 
      array (
        'code' => 'LI',
        'name' => 'Likouala',
      ),
      8 => 
      array (
        'code' => 'NI',
        'name' => 'Niari',
      ),
      9 => 
      array (
        'code' => 'PL',
        'name' => 'Plateaux',
      ),
      10 => 
      array (
        'code' => 'PO',
        'name' => 'Pool',
      ),
      11 => 
      array (
        'code' => 'SA',
        'name' => 'Sangha',
      ),
    ),
    'CH' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => 'Aargau',
      ),
      2 => 
      array (
        'code' => 'AR',
        'name' => 'Appenzell Ausserrhoden',
      ),
      3 => 
      array (
        'code' => 'AI',
        'name' => 'Appenzell Innerrhoden',
      ),
      4 => 
      array (
        'code' => 'BS',
        'name' => 'Basel-Stadt',
      ),
      5 => 
      array (
        'code' => 'BL',
        'name' => 'Basel-Landschaft',
      ),
      6 => 
      array (
        'code' => 'BE',
        'name' => 'Bern',
      ),
      7 => 
      array (
        'code' => 'FR',
        'name' => 'Fribourg',
      ),
      8 => 
      array (
        'code' => 'GE',
        'name' => 'Genève',
      ),
      9 => 
      array (
        'code' => 'GL',
        'name' => 'Glarus',
      ),
      10 => 
      array (
        'code' => 'GR',
        'name' => 'Graubünden',
      ),
      11 => 
      array (
        'code' => 'JU',
        'name' => 'Jura',
      ),
      12 => 
      array (
        'code' => 'LU',
        'name' => 'Lucerne',
      ),
      13 => 
      array (
        'code' => 'NE',
        'name' => 'Neuchâtel',
      ),
      14 => 
      array (
        'code' => 'NW',
        'name' => 'Nidwalden',
      ),
      15 => 
      array (
        'code' => 'OW',
        'name' => 'Obwalden',
      ),
      16 => 
      array (
        'code' => 'SG',
        'name' => 'St. Gallen',
      ),
      17 => 
      array (
        'code' => 'SH',
        'name' => 'Schaffhausen',
      ),
      18 => 
      array (
        'code' => 'SZ',
        'name' => 'Schwyz',
      ),
      19 => 
      array (
        'code' => 'SO',
        'name' => 'Solothurn',
      ),
      20 => 
      array (
        'code' => 'TG',
        'name' => 'Thurgau',
      ),
      21 => 
      array (
        'code' => 'TI',
        'name' => 'Ticino',
      ),
      22 => 
      array (
        'code' => 'UR',
        'name' => 'Uri',
      ),
      23 => 
      array (
        'code' => 'VS',
        'name' => 'Valais',
      ),
      24 => 
      array (
        'code' => 'VD',
        'name' => 'Vaud',
      ),
      25 => 
      array (
        'code' => 'ZG',
        'name' => 'Zug',
      ),
      26 => 
      array (
        'code' => 'ZH',
        'name' => 'Zürich',
      ),
    ),
    'CI' => 
    array (
      1 => 
      array (
        'code' => 'ABE',
        'name' => 'Abengourou',
      ),
      2 => 
      array (
        'code' => 'ABI',
        'name' => 'Abidjan',
      ),
      3 => 
      array (
        'code' => 'ABO',
        'name' => 'Aboisso',
      ),
      4 => 
      array (
        'code' => 'ADI',
        'name' => 'Adiake',
      ),
      5 => 
      array (
        'code' => 'ADZ',
        'name' => 'Adzope',
      ),
      6 => 
      array (
        'code' => 'AGB',
        'name' => 'Agboville',
      ),
      7 => 
      array (
        'code' => 'AGN',
        'name' => 'Agnibilekrou',
      ),
      8 => 
      array (
        'code' => 'ALE',
        'name' => 'Alepe',
      ),
      9 => 
      array (
        'code' => 'BOC',
        'name' => 'Bocanda',
      ),
      10 => 
      array (
        'code' => 'BAN',
        'name' => 'Bangolo',
      ),
      11 => 
      array (
        'code' => 'BEO',
        'name' => 'Beoumi',
      ),
      12 => 
      array (
        'code' => 'BIA',
        'name' => 'Biankouma',
      ),
      13 => 
      array (
        'code' => 'BDK',
        'name' => 'Bondoukou',
      ),
      14 => 
      array (
        'code' => 'BGN',
        'name' => 'Bongouanou',
      ),
      15 => 
      array (
        'code' => 'BFL',
        'name' => 'Bouafle',
      ),
      16 => 
      array (
        'code' => 'BKE',
        'name' => 'Bouake',
      ),
      17 => 
      array (
        'code' => 'BNA',
        'name' => 'Bouna',
      ),
      18 => 
      array (
        'code' => 'BDL',
        'name' => 'Boundiali',
      ),
      19 => 
      array (
        'code' => 'DKL',
        'name' => 'Dabakala',
      ),
      20 => 
      array (
        'code' => 'DBU',
        'name' => 'Dabou',
      ),
      21 => 
      array (
        'code' => 'DAL',
        'name' => 'Daloa',
      ),
      22 => 
      array (
        'code' => 'DAN',
        'name' => 'Danane',
      ),
      23 => 
      array (
        'code' => 'DAO',
        'name' => 'Daoukro',
      ),
      24 => 
      array (
        'code' => 'DIM',
        'name' => 'Dimbokro',
      ),
      25 => 
      array (
        'code' => 'DIV',
        'name' => 'Divo',
      ),
      26 => 
      array (
        'code' => 'DUE',
        'name' => 'Duekoue',
      ),
      27 => 
      array (
        'code' => 'FER',
        'name' => 'Ferkessedougou',
      ),
      28 => 
      array (
        'code' => 'GAG',
        'name' => 'Gagnoa',
      ),
      29 => 
      array (
        'code' => 'GBA',
        'name' => 'Grand-Bassam',
      ),
      30 => 
      array (
        'code' => 'GLA',
        'name' => 'Grand-Lahou',
      ),
      31 => 
      array (
        'code' => 'GUI',
        'name' => 'Guiglo',
      ),
      32 => 
      array (
        'code' => 'ISS',
        'name' => 'Issia',
      ),
      33 => 
      array (
        'code' => 'JAC',
        'name' => 'Jacqueville',
      ),
      34 => 
      array (
        'code' => 'KAT',
        'name' => 'Katiola',
      ),
      35 => 
      array (
        'code' => 'KOR',
        'name' => 'Korhogo',
      ),
      36 => 
      array (
        'code' => 'LAK',
        'name' => 'Lakota',
      ),
      37 => 
      array (
        'code' => 'MAN',
        'name' => 'Man',
      ),
      38 => 
      array (
        'code' => 'MKN',
        'name' => 'Mankono',
      ),
      39 => 
      array (
        'code' => 'MBA',
        'name' => 'Mbahiakro',
      ),
      40 => 
      array (
        'code' => 'ODI',
        'name' => 'Odienne',
      ),
      41 => 
      array (
        'code' => 'OUM',
        'name' => 'Oume',
      ),
      42 => 
      array (
        'code' => 'SAK',
        'name' => 'Sakassou',
      ),
      43 => 
      array (
        'code' => 'SPE',
        'name' => 'San-Pedro',
      ),
      44 => 
      array (
        'code' => 'SAS',
        'name' => 'Sassandra',
      ),
      45 => 
      array (
        'code' => 'SEG',
        'name' => 'Seguela',
      ),
      46 => 
      array (
        'code' => 'SIN',
        'name' => 'Sinfra',
      ),
      47 => 
      array (
        'code' => 'SOU',
        'name' => 'Soubre',
      ),
      48 => 
      array (
        'code' => 'TAB',
        'name' => 'Tabou',
      ),
      49 => 
      array (
        'code' => 'TAN',
        'name' => 'Tanda',
      ),
      50 => 
      array (
        'code' => 'TIE',
        'name' => 'Tiebissou',
      ),
      51 => 
      array (
        'code' => 'TIN',
        'name' => 'Tingrela',
      ),
      52 => 
      array (
        'code' => 'TIA',
        'name' => 'Tiassale',
      ),
      53 => 
      array (
        'code' => 'TBA',
        'name' => 'Touba',
      ),
      54 => 
      array (
        'code' => 'TLP',
        'name' => 'Toulepleu',
      ),
      55 => 
      array (
        'code' => 'TMD',
        'name' => 'Toumodi',
      ),
      56 => 
      array (
        'code' => 'VAV',
        'name' => 'Vavoua',
      ),
      57 => 
      array (
        'code' => 'YAM',
        'name' => 'Yamoussoukro',
      ),
      58 => 
      array (
        'code' => 'ZUE',
        'name' => 'Zuenoula',
      ),
    ),
    'CK' => 
    array (
      1 => 
      array (
        'code' => 'AI',
        'name' => 'Aitutaki',
      ),
      2 => 
      array (
        'code' => 'AT',
        'name' => 'Atiu',
      ),
      3 => 
      array (
        'code' => 'MA',
        'name' => 'Manuae',
      ),
      4 => 
      array (
        'code' => 'MG',
        'name' => 'Mangaia',
      ),
      5 => 
      array (
        'code' => 'MK',
        'name' => 'Manihiki',
      ),
      6 => 
      array (
        'code' => 'MT',
        'name' => 'Mitiaro',
      ),
      7 => 
      array (
        'code' => 'MU',
        'name' => 'Mauke',
      ),
      8 => 
      array (
        'code' => 'NI',
        'name' => 'Nassau Island',
      ),
      9 => 
      array (
        'code' => 'PA',
        'name' => 'Palmerston',
      ),
      10 => 
      array (
        'code' => 'PE',
        'name' => 'Penrhyn',
      ),
      11 => 
      array (
        'code' => 'PU',
        'name' => 'Pukapuka',
      ),
      12 => 
      array (
        'code' => 'RK',
        'name' => 'Rakahanga',
      ),
      13 => 
      array (
        'code' => 'RR',
        'name' => 'Rarotonga',
      ),
      14 => 
      array (
        'code' => 'SU',
        'name' => 'Surwarrow',
      ),
      15 => 
      array (
        'code' => 'TA',
        'name' => 'Takutea',
      ),
    ),
    'CL' => 
    array (
      1 => 
      array (
        'code' => 'AI',
        'name' => 'Aisen del General Carlos Ibanez',
      ),
      2 => 
      array (
        'code' => 'AN',
        'name' => 'Antofagasta',
      ),
      3 => 
      array (
        'code' => 'AR',
        'name' => 'Araucania',
      ),
      4 => 
      array (
        'code' => 'AT',
        'name' => 'Atacama',
      ),
      5 => 
      array (
        'code' => 'BI',
        'name' => 'Bio-Bio',
      ),
      6 => 
      array (
        'code' => 'CO',
        'name' => 'Coquimbo',
      ),
      7 => 
      array (
        'code' => 'LI',
        'name' => 'Libertador General Bernardo O&#39;Hi',
      ),
      8 => 
      array (
        'code' => 'LL',
        'name' => 'Los Lagos',
      ),
      9 => 
      array (
        'code' => 'MA',
        'name' => 'Magallanes y de la Antartica Chi',
      ),
      10 => 
      array (
        'code' => 'ML',
        'name' => 'Maule',
      ),
      11 => 
      array (
        'code' => 'RM',
        'name' => 'Region Metropolitana',
      ),
      12 => 
      array (
        'code' => 'TA',
        'name' => 'Tarapaca',
      ),
      13 => 
      array (
        'code' => 'VS',
        'name' => 'Valparaiso',
      ),
    ),
    'CM' => 
    array (
      1 => 
      array (
        'code' => 'ADA',
        'name' => 'Adamawa (Adamaoua)',
      ),
      2 => 
      array (
        'code' => 'CEN',
        'name' => 'Centre',
      ),
      3 => 
      array (
        'code' => 'EST',
        'name' => 'East (Est)',
      ),
      4 => 
      array (
        'code' => 'EXN',
        'name' => 'Extrême-Nord',
      ),
      5 => 
      array (
        'code' => 'LIT',
        'name' => 'Littoral',
      ),
      6 => 
      array (
        'code' => 'NOR',
        'name' => 'North (Nord)',
      ),
      7 => 
      array (
        'code' => 'NOT',
        'name' => 'Northwest (Nord-Ouest)',
      ),
      8 => 
      array (
        'code' => 'OUE',
        'name' => 'West (Ouest)',
      ),
      9 => 
      array (
        'code' => 'SUD',
        'name' => 'South (Sud)',
      ),
      10 => 
      array (
        'code' => 'SOU',
        'name' => 'Southwest (Sud-Ouest)',
      ),
    ),
    'CN' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Anhui',
      ),
      2 => 
      array (
        'code' => 'BE',
        'name' => 'Beijing',
      ),
      3 => 
      array (
        'code' => 'CH',
        'name' => 'Chongqing',
      ),
      4 => 
      array (
        'code' => 'FU',
        'name' => 'Fujian',
      ),
      5 => 
      array (
        'code' => 'GA',
        'name' => 'Gansu',
      ),
      6 => 
      array (
        'code' => 'GU',
        'name' => 'Guangdong',
      ),
      7 => 
      array (
        'code' => 'GX',
        'name' => 'Guangxi',
      ),
      8 => 
      array (
        'code' => 'GZ',
        'name' => 'Guizhou',
      ),
      9 => 
      array (
        'code' => 'HA',
        'name' => 'Hainan',
      ),
      10 => 
      array (
        'code' => 'HB',
        'name' => 'Hebei',
      ),
      11 => 
      array (
        'code' => 'HL',
        'name' => 'Heilongjiang',
      ),
      12 => 
      array (
        'code' => 'HE',
        'name' => 'Henan',
      ),
      13 => 
      array (
        'code' => 'HK',
        'name' => 'Hong Kong',
      ),
      14 => 
      array (
        'code' => 'HU',
        'name' => 'Hubei',
      ),
      15 => 
      array (
        'code' => 'HN',
        'name' => 'Hunan',
      ),
      16 => 
      array (
        'code' => 'IM',
        'name' => 'Inner Mongolia',
      ),
      17 => 
      array (
        'code' => 'JI',
        'name' => 'Jiangsu',
      ),
      18 => 
      array (
        'code' => 'JX',
        'name' => 'Jiangxi',
      ),
      19 => 
      array (
        'code' => 'JL',
        'name' => 'Jilin',
      ),
      20 => 
      array (
        'code' => 'LI',
        'name' => 'Liaoning',
      ),
      21 => 
      array (
        'code' => 'MA',
        'name' => 'Macau',
      ),
      22 => 
      array (
        'code' => 'NI',
        'name' => 'Ningxia',
      ),
      23 => 
      array (
        'code' => 'SH',
        'name' => 'Shaanxi',
      ),
      24 => 
      array (
        'code' => 'SA',
        'name' => 'Shandong',
      ),
      25 => 
      array (
        'code' => 'SG',
        'name' => 'Shanghai',
      ),
      26 => 
      array (
        'code' => 'SX',
        'name' => 'Shanxi',
      ),
      27 => 
      array (
        'code' => 'SI',
        'name' => 'Sichuan',
      ),
      28 => 
      array (
        'code' => 'TI',
        'name' => 'Tianjin',
      ),
      29 => 
      array (
        'code' => 'XI',
        'name' => 'Xinjiang',
      ),
      30 => 
      array (
        'code' => 'YU',
        'name' => 'Yunnan',
      ),
      31 => 
      array (
        'code' => 'ZH',
        'name' => 'Zhejiang',
      ),
    ),
    'CO' => 
    array (
      1 => 
      array (
        'code' => 'AMZ',
        'name' => 'Amazonas',
      ),
      2 => 
      array (
        'code' => 'ANT',
        'name' => 'Antioquia',
      ),
      3 => 
      array (
        'code' => 'ARA',
        'name' => 'Arauca',
      ),
      4 => 
      array (
        'code' => 'ATL',
        'name' => 'Atlantico',
      ),
      5 => 
      array (
        'code' => 'BDC',
        'name' => 'Bogota D.C.',
      ),
      6 => 
      array (
        'code' => 'BOL',
        'name' => 'Bolivar',
      ),
      7 => 
      array (
        'code' => 'BOY',
        'name' => 'Boyaca',
      ),
      8 => 
      array (
        'code' => 'CAL',
        'name' => 'Caldas',
      ),
      9 => 
      array (
        'code' => 'CAQ',
        'name' => 'Caqueta',
      ),
      10 => 
      array (
        'code' => 'CAS',
        'name' => 'Casanare',
      ),
      11 => 
      array (
        'code' => 'CAU',
        'name' => 'Cauca',
      ),
      12 => 
      array (
        'code' => 'CES',
        'name' => 'Cesar',
      ),
      13 => 
      array (
        'code' => 'CHO',
        'name' => 'Choco',
      ),
      14 => 
      array (
        'code' => 'COR',
        'name' => 'Cordoba',
      ),
      15 => 
      array (
        'code' => 'CAM',
        'name' => 'Cundinamarca',
      ),
      16 => 
      array (
        'code' => 'GNA',
        'name' => 'Guainia',
      ),
      17 => 
      array (
        'code' => 'GJR',
        'name' => 'Guajira',
      ),
      18 => 
      array (
        'code' => 'GVR',
        'name' => 'Guaviare',
      ),
      19 => 
      array (
        'code' => 'HUI',
        'name' => 'Huila',
      ),
      20 => 
      array (
        'code' => 'MAG',
        'name' => 'Magdalena',
      ),
      21 => 
      array (
        'code' => 'MET',
        'name' => 'Meta',
      ),
      22 => 
      array (
        'code' => 'NAR',
        'name' => 'Narino',
      ),
      23 => 
      array (
        'code' => 'NDS',
        'name' => 'Norte de Santander',
      ),
      24 => 
      array (
        'code' => 'PUT',
        'name' => 'Putumayo',
      ),
      25 => 
      array (
        'code' => 'QUI',
        'name' => 'Quindio',
      ),
      26 => 
      array (
        'code' => 'RIS',
        'name' => 'Risaralda',
      ),
      27 => 
      array (
        'code' => 'SAP',
        'name' => 'San Andres y Providencia',
      ),
      28 => 
      array (
        'code' => 'SAN',
        'name' => 'Santander',
      ),
      29 => 
      array (
        'code' => 'SUC',
        'name' => 'Sucre',
      ),
      30 => 
      array (
        'code' => 'TOL',
        'name' => 'Tolima',
      ),
      31 => 
      array (
        'code' => 'VDC',
        'name' => 'Valle del Cauca',
      ),
      32 => 
      array (
        'code' => 'VAU',
        'name' => 'Vaupes',
      ),
      33 => 
      array (
        'code' => 'VIC',
        'name' => 'Vichada',
      ),
    ),
    'CR' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Alajuela',
      ),
      2 => 
      array (
        'code' => 'CA',
        'name' => 'Cartago',
      ),
      3 => 
      array (
        'code' => 'GU',
        'name' => 'Guanacaste',
      ),
      4 => 
      array (
        'code' => 'HE',
        'name' => 'Heredia',
      ),
      5 => 
      array (
        'code' => 'LI',
        'name' => 'Limon',
      ),
      6 => 
      array (
        'code' => 'PU',
        'name' => 'Puntarenas',
      ),
      7 => 
      array (
        'code' => 'SJ',
        'name' => 'San Jose',
      ),
    ),
    'CU' => 
    array (
      1 => 
      array (
        'code' => 'CA',
        'name' => 'Camaguey',
      ),
      2 => 
      array (
        'code' => 'CD',
        'name' => 'Ciego de Avila',
      ),
      3 => 
      array (
        'code' => 'CI',
        'name' => 'Cienfuegos',
      ),
      4 => 
      array (
        'code' => 'CH',
        'name' => 'Ciudad de La Habana',
      ),
      5 => 
      array (
        'code' => 'GR',
        'name' => 'Granma',
      ),
      6 => 
      array (
        'code' => 'GU',
        'name' => 'Guantanamo',
      ),
      7 => 
      array (
        'code' => 'HO',
        'name' => 'Holguin',
      ),
      8 => 
      array (
        'code' => 'IJ',
        'name' => 'Isla de la Juventud',
      ),
      9 => 
      array (
        'code' => 'LH',
        'name' => 'La Habana',
      ),
      10 => 
      array (
        'code' => 'LT',
        'name' => 'Las Tunas',
      ),
      11 => 
      array (
        'code' => 'MA',
        'name' => 'Matanzas',
      ),
      12 => 
      array (
        'code' => 'PR',
        'name' => 'Pinar del Rio',
      ),
      13 => 
      array (
        'code' => 'SS',
        'name' => 'Sancti Spiritus',
      ),
      14 => 
      array (
        'code' => 'SC',
        'name' => 'Santiago de Cuba',
      ),
      15 => 
      array (
        'code' => 'VC',
        'name' => 'Villa Clara',
      ),
    ),
    'CV' => 
    array (
      1 => 
      array (
        'code' => 'BV',
        'name' => 'Boa Vista',
      ),
      2 => 
      array (
        'code' => 'BR',
        'name' => 'Brava',
      ),
      3 => 
      array (
        'code' => 'CS',
        'name' => 'Calheta de Sao Miguel',
      ),
      4 => 
      array (
        'code' => 'MA',
        'name' => 'Maio',
      ),
      5 => 
      array (
        'code' => 'MO',
        'name' => 'Mosteiros',
      ),
      6 => 
      array (
        'code' => 'PA',
        'name' => 'Paul',
      ),
      7 => 
      array (
        'code' => 'PN',
        'name' => 'Porto Novo',
      ),
      8 => 
      array (
        'code' => 'PR',
        'name' => 'Praia',
      ),
      9 => 
      array (
        'code' => 'RG',
        'name' => 'Ribeira Grande',
      ),
      10 => 
      array (
        'code' => 'SL',
        'name' => 'Sal',
      ),
      11 => 
      array (
        'code' => 'CA',
        'name' => 'Santa Catarina',
      ),
      12 => 
      array (
        'code' => 'CR',
        'name' => 'Santa Cruz',
      ),
      13 => 
      array (
        'code' => 'SD',
        'name' => 'Sao Domingos',
      ),
      14 => 
      array (
        'code' => 'SF',
        'name' => 'Sao Filipe',
      ),
      15 => 
      array (
        'code' => 'SN',
        'name' => 'Sao Nicolau',
      ),
      16 => 
      array (
        'code' => 'SV',
        'name' => 'Sao Vicente',
      ),
      17 => 
      array (
        'code' => 'TA',
        'name' => 'Tarrafal',
      ),
    ),
    'CY' => 
    array (
      1 => 
      array (
        'code' => 'F',
        'name' => 'Famagusta',
      ),
      2 => 
      array (
        'code' => 'K',
        'name' => 'Kyrenia',
      ),
      3 => 
      array (
        'code' => 'A',
        'name' => 'Larnaca',
      ),
      4 => 
      array (
        'code' => 'I',
        'name' => 'Limassol',
      ),
      5 => 
      array (
        'code' => 'N',
        'name' => 'Nicosia',
      ),
      6 => 
      array (
        'code' => 'P',
        'name' => 'Paphos',
      ),
    ),
    'CZ' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Hlavní město Praha',
      ),
      2 => 
      array (
        'code' => 'B',
        'name' => 'Jihomoravský',
      ),
      3 => 
      array (
        'code' => 'C',
        'name' => 'Jihočeský',
      ),
      4 => 
      array (
        'code' => 'E',
        'name' => 'Pardubický',
      ),
      5 => 
      array (
        'code' => 'H',
        'name' => 'Královéhradecký',
      ),
      6 => 
      array (
        'code' => 'J',
        'name' => 'Vysočina',
      ),
      7 => 
      array (
        'code' => 'K',
        'name' => 'Karlovarský',
      ),
      8 => 
      array (
        'code' => 'L',
        'name' => 'Liberecký',
      ),
      9 => 
      array (
        'code' => 'M',
        'name' => 'Olomoucký',
      ),
      10 => 
      array (
        'code' => 'P',
        'name' => 'Plzeňský',
      ),
      11 => 
      array (
        'code' => 'S',
        'name' => 'Středočeský',
      ),
      12 => 
      array (
        'code' => 'T',
        'name' => 'Moravskoslezský',
      ),
      13 => 
      array (
        'code' => 'U',
        'name' => 'Ústecký',
      ),
      14 => 
      array (
        'code' => 'Z',
        'name' => 'Zlínský',
      ),
    ),
    'Country' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => 'Περιοχές',
      ),
    ),
    'DE' => 
    array (
      1 => 
      array (
        'code' => 'BAW',
        'name' => 'Baden-Württemberg',
      ),
      2 => 
      array (
        'code' => 'BAY',
        'name' => 'Bayern',
      ),
      3 => 
      array (
        'code' => 'BER',
        'name' => 'Berlin',
      ),
      4 => 
      array (
        'code' => 'BRG',
        'name' => 'Brandenburg',
      ),
      5 => 
      array (
        'code' => 'BRE',
        'name' => 'Bremen',
      ),
      6 => 
      array (
        'code' => 'HAM',
        'name' => 'Hamburg',
      ),
      7 => 
      array (
        'code' => 'HES',
        'name' => 'Hessen',
      ),
      8 => 
      array (
        'code' => 'MEC',
        'name' => 'Mecklenburg-Vorpommern',
      ),
      9 => 
      array (
        'code' => 'NDS',
        'name' => 'Niedersachsen',
      ),
      10 => 
      array (
        'code' => 'NRW',
        'name' => 'Nordrhein-Westfalen',
      ),
      11 => 
      array (
        'code' => 'RHE',
        'name' => 'Rheinland-Pfalz',
      ),
      12 => 
      array (
        'code' => 'SAR',
        'name' => 'Saarland',
      ),
      13 => 
      array (
        'code' => 'SAS',
        'name' => 'Sachsen',
      ),
      14 => 
      array (
        'code' => 'SAC',
        'name' => 'Sachsen-Anhalt',
      ),
      15 => 
      array (
        'code' => 'SCN',
        'name' => 'Schleswig-Holstein',
      ),
      16 => 
      array (
        'code' => 'THE',
        'name' => 'Thüringen',
      ),
    ),
    'DJ' => 
    array (
      1 => 
      array (
        'code' => 'S',
        'name' => '&#39;Ali Sabih',
      ),
      2 => 
      array (
        'code' => 'K',
        'name' => 'Dikhil',
      ),
      3 => 
      array (
        'code' => 'J',
        'name' => 'Djibouti',
      ),
      4 => 
      array (
        'code' => 'O',
        'name' => 'Obock',
      ),
      5 => 
      array (
        'code' => 'T',
        'name' => 'Tadjoura',
      ),
    ),
    'DK' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => 'Arhus',
      ),
      2 => 
      array (
        'code' => 'BH',
        'name' => 'Bornholm',
      ),
      3 => 
      array (
        'code' => 'CO',
        'name' => 'Copenhagen',
      ),
      4 => 
      array (
        'code' => 'FO',
        'name' => 'Faroe Islands',
      ),
      5 => 
      array (
        'code' => 'FR',
        'name' => 'Frederiksborg',
      ),
      6 => 
      array (
        'code' => 'FY',
        'name' => 'Fyn',
      ),
      7 => 
      array (
        'code' => 'KO',
        'name' => 'Kobenhavn',
      ),
      8 => 
      array (
        'code' => 'NO',
        'name' => 'Nordjylland',
      ),
      9 => 
      array (
        'code' => 'RI',
        'name' => 'Ribe',
      ),
      10 => 
      array (
        'code' => 'RK',
        'name' => 'Ringkobing',
      ),
      11 => 
      array (
        'code' => 'RO',
        'name' => 'Roskilde',
      ),
      12 => 
      array (
        'code' => 'SO',
        'name' => 'Sonderjylland',
      ),
      13 => 
      array (
        'code' => 'ST',
        'name' => 'Storstrom',
      ),
      14 => 
      array (
        'code' => 'VK',
        'name' => 'Vejle',
      ),
      15 => 
      array (
        'code' => 'VJ',
        'name' => 'Vestjælland',
      ),
      16 => 
      array (
        'code' => 'VB',
        'name' => 'Viborg',
      ),
    ),
    'DM' => 
    array (
      1 => 
      array (
        'code' => 'AND',
        'name' => 'Saint Andrew Parish',
      ),
      2 => 
      array (
        'code' => 'DAV',
        'name' => 'Saint David Parish',
      ),
      3 => 
      array (
        'code' => 'GEO',
        'name' => 'Saint George Parish',
      ),
      4 => 
      array (
        'code' => 'JOH',
        'name' => 'Saint John Parish',
      ),
      5 => 
      array (
        'code' => 'JOS',
        'name' => 'Saint Joseph Parish',
      ),
      6 => 
      array (
        'code' => 'LUK',
        'name' => 'Saint Luke Parish',
      ),
      7 => 
      array (
        'code' => 'MAR',
        'name' => 'Saint Mark Parish',
      ),
      8 => 
      array (
        'code' => 'PAT',
        'name' => 'Saint Patrick Parish',
      ),
      9 => 
      array (
        'code' => 'PAU',
        'name' => 'Saint Paul Parish',
      ),
      10 => 
      array (
        'code' => 'PET',
        'name' => 'Saint Peter Parish',
      ),
    ),
    'DO' => 
    array (
      1 => 
      array (
        'code' => 'DN',
        'name' => 'Distrito Nacional',
      ),
      2 => 
      array (
        'code' => 'AZ',
        'name' => 'Azua',
      ),
      3 => 
      array (
        'code' => 'BC',
        'name' => 'Baoruco',
      ),
      4 => 
      array (
        'code' => 'BH',
        'name' => 'Barahona',
      ),
      5 => 
      array (
        'code' => 'DJ',
        'name' => 'Dajabon',
      ),
      6 => 
      array (
        'code' => 'DU',
        'name' => 'Duarte',
      ),
      7 => 
      array (
        'code' => 'EL',
        'name' => 'Elias Pina',
      ),
      8 => 
      array (
        'code' => 'SY',
        'name' => 'El Seybo',
      ),
      9 => 
      array (
        'code' => 'ET',
        'name' => 'Espaillat',
      ),
      10 => 
      array (
        'code' => 'HM',
        'name' => 'Hato Mayor',
      ),
      11 => 
      array (
        'code' => 'IN',
        'name' => 'Independencia',
      ),
      12 => 
      array (
        'code' => 'AL',
        'name' => 'La Altagracia',
      ),
      13 => 
      array (
        'code' => 'RO',
        'name' => 'La Romana',
      ),
      14 => 
      array (
        'code' => 'VE',
        'name' => 'La Vega',
      ),
      15 => 
      array (
        'code' => 'MT',
        'name' => 'Maria Trinidad Sanchez',
      ),
      16 => 
      array (
        'code' => 'MN',
        'name' => 'Monsenor Nouel',
      ),
      17 => 
      array (
        'code' => 'MC',
        'name' => 'Monte Cristi',
      ),
      18 => 
      array (
        'code' => 'MP',
        'name' => 'Monte Plata',
      ),
      19 => 
      array (
        'code' => 'PD',
        'name' => 'Pedernales',
      ),
      20 => 
      array (
        'code' => 'PR',
        'name' => 'Peravia (Bani)',
      ),
      21 => 
      array (
        'code' => 'PP',
        'name' => 'Puerto Plata',
      ),
      22 => 
      array (
        'code' => 'SL',
        'name' => 'Salcedo',
      ),
      23 => 
      array (
        'code' => 'SM',
        'name' => 'Samana',
      ),
      24 => 
      array (
        'code' => 'SH',
        'name' => 'Sanchez Ramirez',
      ),
      25 => 
      array (
        'code' => 'SC',
        'name' => 'San Cristobal',
      ),
      26 => 
      array (
        'code' => 'JO',
        'name' => 'San Jose de Ocoa',
      ),
      27 => 
      array (
        'code' => 'SJ',
        'name' => 'San Juan',
      ),
      28 => 
      array (
        'code' => 'PM',
        'name' => 'San Pedro de Macoris',
      ),
      29 => 
      array (
        'code' => 'SA',
        'name' => 'Santiago',
      ),
      30 => 
      array (
        'code' => 'ST',
        'name' => 'Santiago Rodriguez',
      ),
      31 => 
      array (
        'code' => 'SD',
        'name' => 'Santo Domingo',
      ),
      32 => 
      array (
        'code' => 'VA',
        'name' => 'Valverde',
      ),
    ),
    'DZ' => 
    array (
      1 => 
      array (
        'code' => 'ADE',
        'name' => 'Ain Defla',
      ),
      2 => 
      array (
        'code' => 'ADR',
        'name' => 'Adrar',
      ),
      3 => 
      array (
        'code' => 'ALG',
        'name' => 'Alger',
      ),
      4 => 
      array (
        'code' => 'ANN',
        'name' => 'Annaba',
      ),
      5 => 
      array (
        'code' => 'ATE',
        'name' => 'Ain Temouchent',
      ),
      6 => 
      array (
        'code' => 'BAT',
        'name' => 'Batna',
      ),
      7 => 
      array (
        'code' => 'BBA',
        'name' => 'Bordj Bou Arreridj',
      ),
      8 => 
      array (
        'code' => 'BEC',
        'name' => 'Bechar',
      ),
      9 => 
      array (
        'code' => 'BEJ',
        'name' => 'Bejaia',
      ),
      10 => 
      array (
        'code' => 'BIS',
        'name' => 'Biskra',
      ),
      11 => 
      array (
        'code' => 'BLI',
        'name' => 'Blida',
      ),
      12 => 
      array (
        'code' => 'BMD',
        'name' => 'Boumerdes',
      ),
      13 => 
      array (
        'code' => 'BOA',
        'name' => 'Bouira',
      ),
      14 => 
      array (
        'code' => 'CHL',
        'name' => 'Chlef',
      ),
      15 => 
      array (
        'code' => 'CON',
        'name' => 'Constantine',
      ),
      16 => 
      array (
        'code' => 'DJE',
        'name' => 'Djelfa',
      ),
      17 => 
      array (
        'code' => 'EBA',
        'name' => 'El Bayadh',
      ),
      18 => 
      array (
        'code' => 'EOU',
        'name' => 'El Oued',
      ),
      19 => 
      array (
        'code' => 'ETA',
        'name' => 'El Tarf',
      ),
      20 => 
      array (
        'code' => 'GHA',
        'name' => 'Ghardaia',
      ),
      21 => 
      array (
        'code' => 'GUE',
        'name' => 'Guelma',
      ),
      22 => 
      array (
        'code' => 'ILL',
        'name' => 'Illizi',
      ),
      23 => 
      array (
        'code' => 'JIJ',
        'name' => 'Jijel',
      ),
      24 => 
      array (
        'code' => 'KHE',
        'name' => 'Khenchela',
      ),
      25 => 
      array (
        'code' => 'LAG',
        'name' => 'Laghouat',
      ),
      26 => 
      array (
        'code' => 'MED',
        'name' => 'Medea',
      ),
      27 => 
      array (
        'code' => 'MIL',
        'name' => 'Mila',
      ),
      28 => 
      array (
        'code' => 'MOS',
        'name' => 'Mostaganem',
      ),
      29 => 
      array (
        'code' => 'MSI',
        'name' => 'M&#39;Sila',
      ),
      30 => 
      array (
        'code' => 'MUA',
        'name' => 'Muaskar',
      ),
      31 => 
      array (
        'code' => 'NAA',
        'name' => 'Naama',
      ),
      32 => 
      array (
        'code' => 'OEB',
        'name' => 'Oum el-Bouaghi',
      ),
      33 => 
      array (
        'code' => 'ORA',
        'name' => 'Oran',
      ),
      34 => 
      array (
        'code' => 'OUA',
        'name' => 'Ouargla',
      ),
      35 => 
      array (
        'code' => 'REL',
        'name' => 'Relizane',
      ),
      36 => 
      array (
        'code' => 'SAH',
        'name' => 'Souk Ahras',
      ),
      37 => 
      array (
        'code' => 'SAI',
        'name' => 'Saida',
      ),
      38 => 
      array (
        'code' => 'SBA',
        'name' => 'Sidi Bel Abbes',
      ),
      39 => 
      array (
        'code' => 'SET',
        'name' => 'Setif',
      ),
      40 => 
      array (
        'code' => 'SKI',
        'name' => 'Skikda',
      ),
      41 => 
      array (
        'code' => 'TAM',
        'name' => 'Tamanghasset',
      ),
      42 => 
      array (
        'code' => 'TEB',
        'name' => 'Tebessa',
      ),
      43 => 
      array (
        'code' => 'TIA',
        'name' => 'Tiaret',
      ),
      44 => 
      array (
        'code' => 'TIN',
        'name' => 'Tindouf',
      ),
      45 => 
      array (
        'code' => 'TIP',
        'name' => 'Tipaza',
      ),
      46 => 
      array (
        'code' => 'TIS',
        'name' => 'Tissemsilt',
      ),
      47 => 
      array (
        'code' => 'TLE',
        'name' => 'Tlemcen',
      ),
      48 => 
      array (
        'code' => 'TOU',
        'name' => 'Tizi Ouzou',
      ),
    ),
    'EC' => 
    array (
      1 => 
      array (
        'code' => 'AZU',
        'name' => 'Azuay',
      ),
      2 => 
      array (
        'code' => 'BOL',
        'name' => 'Bolivar',
      ),
      3 => 
      array (
        'code' => 'CAN',
        'name' => 'Cañar',
      ),
      4 => 
      array (
        'code' => 'CAR',
        'name' => 'Carchi',
      ),
      5 => 
      array (
        'code' => 'CHI',
        'name' => 'Chimborazo',
      ),
      6 => 
      array (
        'code' => 'COT',
        'name' => 'Cotopaxi',
      ),
      7 => 
      array (
        'code' => 'EOR',
        'name' => 'El Oro',
      ),
      8 => 
      array (
        'code' => 'ESM',
        'name' => 'Esmeraldas',
      ),
      9 => 
      array (
        'code' => 'GPS',
        'name' => 'Galápagos',
      ),
      10 => 
      array (
        'code' => 'GUA',
        'name' => 'Guayas',
      ),
      11 => 
      array (
        'code' => 'IMB',
        'name' => 'Imbabura',
      ),
      12 => 
      array (
        'code' => 'LOJ',
        'name' => 'Loja',
      ),
      13 => 
      array (
        'code' => 'LRO',
        'name' => 'Los Ríos',
      ),
      14 => 
      array (
        'code' => 'MAN',
        'name' => 'Manabí',
      ),
      15 => 
      array (
        'code' => 'MSA',
        'name' => 'Morona Santiago',
      ),
      16 => 
      array (
        'code' => 'NAP',
        'name' => 'Napo',
      ),
      17 => 
      array (
        'code' => 'ORE',
        'name' => 'Orellana',
      ),
      18 => 
      array (
        'code' => 'PAS',
        'name' => 'Pastaza',
      ),
      19 => 
      array (
        'code' => 'PIC',
        'name' => 'Pichincha',
      ),
      20 => 
      array (
        'code' => 'SUC',
        'name' => 'Sucumbíos',
      ),
      21 => 
      array (
        'code' => 'TUN',
        'name' => 'Tungurahua',
      ),
      22 => 
      array (
        'code' => 'ZCH',
        'name' => 'Zamora Chinchipe',
      ),
    ),
    'EE' => 
    array (
      1 => 
      array (
        'code' => 'HA',
        'name' => 'Harjumaa (Tallinn)',
      ),
      2 => 
      array (
        'code' => 'HI',
        'name' => 'Hiiumaa (Kardla)',
      ),
      3 => 
      array (
        'code' => 'IV',
        'name' => 'Ida-Virumaa (Johvi)',
      ),
      4 => 
      array (
        'code' => 'JA',
        'name' => 'Jarvamaa (Paide)',
      ),
      5 => 
      array (
        'code' => 'JO',
        'name' => 'Jogevamaa (Jogeva)',
      ),
      6 => 
      array (
        'code' => 'LV',
        'name' => 'Laane-Virumaa (Rakvere)',
      ),
      7 => 
      array (
        'code' => 'LA',
        'name' => 'Laanemaa (Haapsalu)',
      ),
      8 => 
      array (
        'code' => 'PA',
        'name' => 'Parnumaa (Parnu)',
      ),
      9 => 
      array (
        'code' => 'PO',
        'name' => 'Polvamaa (Polva)',
      ),
      10 => 
      array (
        'code' => 'RA',
        'name' => 'Raplamaa (Rapla)',
      ),
      11 => 
      array (
        'code' => 'SA',
        'name' => 'Saaremaa (Kuessaare)',
      ),
      12 => 
      array (
        'code' => 'TA',
        'name' => 'Tartumaa (Tartu)',
      ),
      13 => 
      array (
        'code' => 'VA',
        'name' => 'Valgamaa (Valga)',
      ),
      14 => 
      array (
        'code' => 'VI',
        'name' => 'Viljandimaa (Viljandi)',
      ),
      15 => 
      array (
        'code' => 'VO',
        'name' => 'Vorumaa (Voru)',
      ),
    ),
    'EG' => 
    array (
      1 => 
      array (
        'code' => 'DHY',
        'name' => 'Ad Daqahliyah',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => 'Al Bahr al Ahmar',
      ),
      3 => 
      array (
        'code' => 'BHY',
        'name' => 'Al Buhayrah',
      ),
      4 => 
      array (
        'code' => 'FYM',
        'name' => 'Al Fayyum',
      ),
      5 => 
      array (
        'code' => 'GBY',
        'name' => 'Al Gharbiyah',
      ),
      6 => 
      array (
        'code' => 'IDR',
        'name' => 'Al Iskandariyah',
      ),
      7 => 
      array (
        'code' => 'IML',
        'name' => 'Al Isma &#39;iliyah',
      ),
      8 => 
      array (
        'code' => 'JZH',
        'name' => 'Al Jizah',
      ),
      9 => 
      array (
        'code' => 'MFY',
        'name' => 'Al Minufiyah',
      ),
      10 => 
      array (
        'code' => 'MNY',
        'name' => 'Al Minya',
      ),
      11 => 
      array (
        'code' => 'QHR',
        'name' => 'Al Qahirah',
      ),
      12 => 
      array (
        'code' => 'QLY',
        'name' => 'Al Qalyubiyah',
      ),
      13 => 
      array (
        'code' => 'WJD',
        'name' => 'Al Wadi al Jadid',
      ),
      14 => 
      array (
        'code' => 'SHQ',
        'name' => 'Ash Sharqiyah',
      ),
      15 => 
      array (
        'code' => 'SWY',
        'name' => 'As Suways',
      ),
      16 => 
      array (
        'code' => 'ASW',
        'name' => 'Aswan',
      ),
      17 => 
      array (
        'code' => 'ASY',
        'name' => 'Asyut',
      ),
      18 => 
      array (
        'code' => 'BSW',
        'name' => 'Bani Suwayf',
      ),
      19 => 
      array (
        'code' => 'BSD',
        'name' => 'Bur Sa&#39;id',
      ),
      20 => 
      array (
        'code' => 'DMY',
        'name' => 'Dumyat',
      ),
      21 => 
      array (
        'code' => 'JNS',
        'name' => 'Janub Sina&#39;',
      ),
      22 => 
      array (
        'code' => 'KSH',
        'name' => 'Kafr ash Shaykh',
      ),
      23 => 
      array (
        'code' => 'MAT',
        'name' => 'Matruh',
      ),
      24 => 
      array (
        'code' => 'QIN',
        'name' => 'Qina',
      ),
      25 => 
      array (
        'code' => 'SHS',
        'name' => 'Shamal Sina&#39;',
      ),
      26 => 
      array (
        'code' => 'SUH',
        'name' => 'Suhaj',
      ),
    ),
    'ER' => 
    array (
      1 => 
      array (
        'code' => 'MA',
        'name' => 'Central (Maekel)',
      ),
      2 => 
      array (
        'code' => 'KE',
        'name' => 'Anseba (Keren)',
      ),
      3 => 
      array (
        'code' => 'DK',
        'name' => 'Southern Red Sea (Debub-Keih-Bah)',
      ),
      4 => 
      array (
        'code' => 'SK',
        'name' => 'Northern Red Sea (Semien-Keih-Ba)',
      ),
      5 => 
      array (
        'code' => 'DE',
        'name' => 'Southern (Debub)',
      ),
      6 => 
      array (
        'code' => 'BR',
        'name' => 'Gash-Barka (Barentu)',
      ),
    ),
    'ES' => 
    array (
      1 => 
      array (
        'code' => 'CA',
        'name' => 'La Coruña',
      ),
      2 => 
      array (
        'code' => 'AL',
        'name' => 'Álava',
      ),
      3 => 
      array (
        'code' => 'AB',
        'name' => 'Albacete',
      ),
      4 => 
      array (
        'code' => 'AC',
        'name' => 'Alicante',
      ),
      5 => 
      array (
        'code' => 'AM',
        'name' => 'Almeria',
      ),
      6 => 
      array (
        'code' => 'AS',
        'name' => 'Asturias',
      ),
      7 => 
      array (
        'code' => 'AV',
        'name' => 'Ávila',
      ),
      8 => 
      array (
        'code' => 'BJ',
        'name' => 'Badajoz',
      ),
      9 => 
      array (
        'code' => 'IB',
        'name' => 'Baleares',
      ),
      10 => 
      array (
        'code' => 'BA',
        'name' => 'Barcelona',
      ),
      11 => 
      array (
        'code' => 'BU',
        'name' => 'Burgos',
      ),
      12 => 
      array (
        'code' => 'CC',
        'name' => 'Cáceres',
      ),
      13 => 
      array (
        'code' => 'CZ',
        'name' => 'Cádiz',
      ),
      14 => 
      array (
        'code' => 'CT',
        'name' => 'Cantabria',
      ),
      15 => 
      array (
        'code' => 'CL',
        'name' => 'Castellón',
      ),
      16 => 
      array (
        'code' => 'CE',
        'name' => 'Ceuta',
      ),
      17 => 
      array (
        'code' => 'CR',
        'name' => 'Ciudad Real',
      ),
      18 => 
      array (
        'code' => 'CD',
        'name' => 'Córdoba',
      ),
      19 => 
      array (
        'code' => 'CU',
        'name' => 'Cuenca',
      ),
      20 => 
      array (
        'code' => 'GI',
        'name' => 'Gerona',
      ),
      21 => 
      array (
        'code' => 'GD',
        'name' => 'Granada',
      ),
      22 => 
      array (
        'code' => 'GJ',
        'name' => 'Guadalajara',
      ),
      23 => 
      array (
        'code' => 'GP',
        'name' => 'Guipúzcoa',
      ),
      24 => 
      array (
        'code' => 'HL',
        'name' => 'Huelva',
      ),
      25 => 
      array (
        'code' => 'HS',
        'name' => 'Huesca',
      ),
      26 => 
      array (
        'code' => 'JN',
        'name' => 'Jaén',
      ),
      27 => 
      array (
        'code' => 'RJ',
        'name' => 'La Rioja',
      ),
      28 => 
      array (
        'code' => 'PM',
        'name' => 'Las Palmas',
      ),
      29 => 
      array (
        'code' => 'LE',
        'name' => 'León',
      ),
      30 => 
      array (
        'code' => 'LL',
        'name' => 'Lérida',
      ),
      31 => 
      array (
        'code' => 'LG',
        'name' => 'Lugo',
      ),
      32 => 
      array (
        'code' => 'MD',
        'name' => 'Madrid',
      ),
      33 => 
      array (
        'code' => 'MA',
        'name' => 'Málaga',
      ),
      34 => 
      array (
        'code' => 'ML',
        'name' => 'Melilla',
      ),
      35 => 
      array (
        'code' => 'MU',
        'name' => 'Murcia',
      ),
      36 => 
      array (
        'code' => 'NV',
        'name' => 'Navarra',
      ),
      37 => 
      array (
        'code' => 'OU',
        'name' => 'Ourense',
      ),
      38 => 
      array (
        'code' => 'PL',
        'name' => 'Palencia',
      ),
      39 => 
      array (
        'code' => 'PO',
        'name' => 'Pontevedra',
      ),
      40 => 
      array (
        'code' => 'SL',
        'name' => 'Salamanca',
      ),
      41 => 
      array (
        'code' => 'SC',
        'name' => 'Santa Cruz de Tenerife',
      ),
      42 => 
      array (
        'code' => 'SG',
        'name' => 'Segovia',
      ),
      43 => 
      array (
        'code' => 'SV',
        'name' => 'Sevilla',
      ),
      44 => 
      array (
        'code' => 'SO',
        'name' => 'Soria',
      ),
      45 => 
      array (
        'code' => 'TA',
        'name' => 'Tarragona',
      ),
      46 => 
      array (
        'code' => 'TE',
        'name' => 'Teruel',
      ),
      47 => 
      array (
        'code' => 'TO',
        'name' => 'Toledo',
      ),
      48 => 
      array (
        'code' => 'VC',
        'name' => 'Valencia',
      ),
      49 => 
      array (
        'code' => 'VD',
        'name' => 'Valladolid',
      ),
      50 => 
      array (
        'code' => 'VZ',
        'name' => 'Vizcaya',
      ),
      51 => 
      array (
        'code' => 'ZM',
        'name' => 'Zamora',
      ),
      52 => 
      array (
        'code' => 'ZR',
        'name' => 'Zaragoza',
      ),
    ),
    'ET' => 
    array (
      1 => 
      array (
        'code' => 'AF',
        'name' => 'Afar',
      ),
      2 => 
      array (
        'code' => 'AH',
        'name' => 'Amhara',
      ),
      3 => 
      array (
        'code' => 'BG',
        'name' => 'Benishangul-Gumaz',
      ),
      4 => 
      array (
        'code' => 'GB',
        'name' => 'Gambela',
      ),
      5 => 
      array (
        'code' => 'HR',
        'name' => 'Hariai',
      ),
      6 => 
      array (
        'code' => 'OR',
        'name' => 'Oromia',
      ),
      7 => 
      array (
        'code' => 'SM',
        'name' => 'Somali',
      ),
      8 => 
      array (
        'code' => 'SN',
        'name' => 'Southern Nations - Nationalities',
      ),
      9 => 
      array (
        'code' => 'TG',
        'name' => 'Tigray',
      ),
      10 => 
      array (
        'code' => 'AA',
        'name' => 'Addis Ababa',
      ),
      11 => 
      array (
        'code' => 'DD',
        'name' => 'Dire Dawa',
      ),
    ),
    'FI' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Ahvenanmaan Laani',
      ),
      2 => 
      array (
        'code' => 'ES',
        'name' => 'Etela-Suomen Laani',
      ),
      3 => 
      array (
        'code' => 'IS',
        'name' => 'Ita-Suomen Laani',
      ),
      4 => 
      array (
        'code' => 'LS',
        'name' => 'Lansi-Suomen Laani',
      ),
      5 => 
      array (
        'code' => 'LA',
        'name' => 'Lapin Lanani',
      ),
      6 => 
      array (
        'code' => 'OU',
        'name' => 'Oulun Laani',
      ),
    ),
    'FJ' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => 'Central Division',
      ),
      2 => 
      array (
        'code' => 'E',
        'name' => 'Eastern Division',
      ),
      3 => 
      array (
        'code' => 'N',
        'name' => 'Northern Division',
      ),
      4 => 
      array (
        'code' => 'R',
        'name' => 'Rotuma',
      ),
      5 => 
      array (
        'code' => 'W',
        'name' => 'Western Division',
      ),
    ),
    'FM' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => 'Chuuk',
      ),
      2 => 
      array (
        'code' => 'K',
        'name' => 'Kosrae',
      ),
      3 => 
      array (
        'code' => 'P',
        'name' => 'Pohnpei',
      ),
      4 => 
      array (
        'code' => 'Y',
        'name' => 'Yap',
      ),
    ),
    'FO' => 
    array (
      1 => 
      array (
        'code' => 'TÛR',
        'name' => 'Tûrshavnar Kommuna',
      ),
      2 => 
      array (
        'code' => 'KLA',
        'name' => 'Klaksvík',
      ),
      3 => 
      array (
        'code' => 'RUN',
        'name' => 'Runavík',
      ),
      4 => 
      array (
        'code' => 'TVØ',
        'name' => 'Tvøroyri',
      ),
      5 => 
      array (
        'code' => 'FUG',
        'name' => 'Fuglafjørður',
      ),
      6 => 
      array (
        'code' => 'SUN',
        'name' => 'Sunda Kommuna',
      ),
      7 => 
      array (
        'code' => 'VáG',
        'name' => 'Vágur',
      ),
      8 => 
      array (
        'code' => 'NES',
        'name' => 'Nes',
      ),
      9 => 
      array (
        'code' => 'VES',
        'name' => 'Vestmanna',
      ),
      10 => 
      array (
        'code' => 'MIð',
        'name' => 'Miðvágur',
      ),
      11 => 
      array (
        'code' => 'SØR',
        'name' => 'Sørvágur',
      ),
      12 => 
      array (
        'code' => 'GØT',
        'name' => 'Gøtu Kommuna',
      ),
      13 => 
      array (
        'code' => 'SJû',
        'name' => 'Sjûvar Kommuna',
      ),
      14 => 
      array (
        'code' => 'LEI',
        'name' => 'Leirvík',
      ),
      15 => 
      array (
        'code' => 'SAN',
        'name' => 'Sandavágur',
      ),
      16 => 
      array (
        'code' => 'HVA',
        'name' => 'Hvalba',
      ),
      17 => 
      array (
        'code' => 'EIð',
        'name' => 'Eiði',
      ),
      18 => 
      array (
        'code' => 'KVí',
        'name' => 'Kvívík',
      ),
      19 => 
      array (
        'code' => 'SAN',
        'name' => 'Sandur',
      ),
      20 => 
      array (
        'code' => 'SKO',
        'name' => 'Skopun',
      ),
      21 => 
      array (
        'code' => 'HVA',
        'name' => 'Hvannasund',
      ),
      22 => 
      array (
        'code' => 'SUM',
        'name' => 'Sumba',
      ),
      23 => 
      array (
        'code' => 'VIð',
        'name' => 'Viðareiði',
      ),
      24 => 
      array (
        'code' => 'POR',
        'name' => 'Porkeri',
      ),
      25 => 
      array (
        'code' => 'SKá',
        'name' => 'Skálavík',
      ),
      26 => 
      array (
        'code' => 'KUN',
        'name' => 'Kunoy',
      ),
      27 => 
      array (
        'code' => 'HÚS',
        'name' => 'HÚsavík',
      ),
      28 => 
      array (
        'code' => 'HOV',
        'name' => 'Hov',
      ),
      29 => 
      array (
        'code' => 'FáM',
        'name' => 'Fámjin',
      ),
      30 => 
      array (
        'code' => 'FUN',
        'name' => 'Funningur',
      ),
      31 => 
      array (
        'code' => 'HÚS',
        'name' => 'HÚsar',
      ),
      32 => 
      array (
        'code' => 'SKÚ',
        'name' => 'SkÚvoy',
      ),
      33 => 
      array (
        'code' => 'SVí',
        'name' => 'Svínoy',
      ),
      34 => 
      array (
        'code' => 'FUG',
        'name' => 'Fugloy',
      ),
    ),
    'FR' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Alsace',
      ),
      2 => 
      array (
        'code' => 'AQ',
        'name' => 'Aquitaine',
      ),
      3 => 
      array (
        'code' => 'AU',
        'name' => 'Auvergne',
      ),
      4 => 
      array (
        'code' => 'BR',
        'name' => 'Brittany',
      ),
      5 => 
      array (
        'code' => 'BU',
        'name' => 'Burgundy',
      ),
      6 => 
      array (
        'code' => 'CE',
        'name' => 'Center Loire Valley',
      ),
      7 => 
      array (
        'code' => 'CH',
        'name' => 'Champagne',
      ),
      8 => 
      array (
        'code' => 'CO',
        'name' => 'Corse',
      ),
      9 => 
      array (
        'code' => 'FR',
        'name' => 'France Comte',
      ),
      10 => 
      array (
        'code' => 'LA',
        'name' => 'Languedoc Roussillon',
      ),
      11 => 
      array (
        'code' => 'LI',
        'name' => 'Limousin',
      ),
      12 => 
      array (
        'code' => 'LO',
        'name' => 'Lorraine',
      ),
      13 => 
      array (
        'code' => 'MI',
        'name' => 'Midi Pyrenees',
      ),
      14 => 
      array (
        'code' => 'NO',
        'name' => 'Nord Pas de Calais',
      ),
      15 => 
      array (
        'code' => 'NR',
        'name' => 'Normandy',
      ),
      16 => 
      array (
        'code' => 'PA',
        'name' => 'Paris / Ile de France',
      ),
      17 => 
      array (
        'code' => 'PI',
        'name' => 'Picardie',
      ),
      18 => 
      array (
        'code' => 'PO',
        'name' => 'Poitou Charente',
      ),
      19 => 
      array (
        'code' => 'PR',
        'name' => 'Provence',
      ),
      20 => 
      array (
        'code' => 'RH',
        'name' => 'Rhone Alps',
      ),
      21 => 
      array (
        'code' => 'RI',
        'name' => 'Riviera',
      ),
      22 => 
      array (
        'code' => 'WE',
        'name' => 'Western Loire Valley',
      ),
    ),
    'FX' => 
    array (
      1 => 
      array (
        'code' => 'Et',
        'name' => 'Etranger',
      ),
      2 => 
      array (
        'code' => '01',
        'name' => 'Ain',
      ),
      3 => 
      array (
        'code' => '02',
        'name' => 'Aisne',
      ),
      4 => 
      array (
        'code' => '03',
        'name' => 'Allier',
      ),
      5 => 
      array (
        'code' => '04',
        'name' => 'Alpes de Haute Provence',
      ),
      6 => 
      array (
        'code' => '05',
        'name' => 'Hautes-Alpes',
      ),
      7 => 
      array (
        'code' => '06',
        'name' => 'Alpes Maritimes',
      ),
      8 => 
      array (
        'code' => '07',
        'name' => 'Ardèche',
      ),
      9 => 
      array (
        'code' => '08',
        'name' => 'Ardennes',
      ),
      10 => 
      array (
        'code' => '09',
        'name' => 'Ariège',
      ),
      11 => 
      array (
        'code' => '10',
        'name' => 'Aube',
      ),
      12 => 
      array (
        'code' => '11',
        'name' => 'Aude',
      ),
      13 => 
      array (
        'code' => '12',
        'name' => 'Aveyron',
      ),
      14 => 
      array (
        'code' => '13',
        'name' => 'Bouches du Rhône',
      ),
      15 => 
      array (
        'code' => '14',
        'name' => 'Calvados',
      ),
      16 => 
      array (
        'code' => '15',
        'name' => 'Cantal',
      ),
      17 => 
      array (
        'code' => '16',
        'name' => 'Charente',
      ),
      18 => 
      array (
        'code' => '17',
        'name' => 'Charente Maritime',
      ),
      19 => 
      array (
        'code' => '18',
        'name' => 'Cher',
      ),
      20 => 
      array (
        'code' => '19',
        'name' => 'Corrèze',
      ),
      21 => 
      array (
        'code' => '2A',
        'name' => 'Corse du Sud',
      ),
      22 => 
      array (
        'code' => '2B',
        'name' => 'Haute Corse',
      ),
      23 => 
      array (
        'code' => '21',
        'name' => 'Côte d&#39;or',
      ),
      24 => 
      array (
        'code' => '22',
        'name' => 'Côtes d&#39;Armor',
      ),
      25 => 
      array (
        'code' => '23',
        'name' => 'Creuse',
      ),
      26 => 
      array (
        'code' => '24',
        'name' => 'Dordogne',
      ),
      27 => 
      array (
        'code' => '25',
        'name' => 'Doubs',
      ),
      28 => 
      array (
        'code' => '26',
        'name' => 'Drôme',
      ),
      29 => 
      array (
        'code' => '27',
        'name' => 'Eure',
      ),
      30 => 
      array (
        'code' => '28',
        'name' => 'Eure et Loir',
      ),
      31 => 
      array (
        'code' => '29',
        'name' => 'Finistère',
      ),
      32 => 
      array (
        'code' => '30',
        'name' => 'Gard',
      ),
      33 => 
      array (
        'code' => '31',
        'name' => 'Haute Garonne',
      ),
      34 => 
      array (
        'code' => '32',
        'name' => 'Gers',
      ),
      35 => 
      array (
        'code' => '33',
        'name' => 'Gironde',
      ),
      36 => 
      array (
        'code' => '34',
        'name' => 'Hérault',
      ),
      37 => 
      array (
        'code' => '35',
        'name' => 'Ille et Vilaine',
      ),
      38 => 
      array (
        'code' => '36',
        'name' => 'Indre',
      ),
      39 => 
      array (
        'code' => '37',
        'name' => 'Indre et Loire',
      ),
      40 => 
      array (
        'code' => '38',
        'name' => 'Isére',
      ),
      41 => 
      array (
        'code' => '39',
        'name' => 'Jura',
      ),
      42 => 
      array (
        'code' => '40',
        'name' => 'Landes',
      ),
      43 => 
      array (
        'code' => '41',
        'name' => 'Loir et Cher',
      ),
      44 => 
      array (
        'code' => '42',
        'name' => 'Loire',
      ),
      45 => 
      array (
        'code' => '43',
        'name' => 'Haute Loire',
      ),
      46 => 
      array (
        'code' => '44',
        'name' => 'Loire Atlantique',
      ),
      47 => 
      array (
        'code' => '45',
        'name' => 'Loiret',
      ),
      48 => 
      array (
        'code' => '46',
        'name' => 'Lot',
      ),
      49 => 
      array (
        'code' => '47',
        'name' => 'Lot et Garonne',
      ),
      50 => 
      array (
        'code' => '48',
        'name' => 'Lozère',
      ),
      51 => 
      array (
        'code' => '49',
        'name' => 'Maine et Loire',
      ),
      52 => 
      array (
        'code' => '50',
        'name' => 'Manche',
      ),
      53 => 
      array (
        'code' => '51',
        'name' => 'Marne',
      ),
      54 => 
      array (
        'code' => '52',
        'name' => 'Haute Marne',
      ),
      55 => 
      array (
        'code' => '53',
        'name' => 'Mayenne',
      ),
      56 => 
      array (
        'code' => '54',
        'name' => 'Meurthe et Moselle',
      ),
      57 => 
      array (
        'code' => '55',
        'name' => 'Meuse',
      ),
      58 => 
      array (
        'code' => '56',
        'name' => 'Morbihan',
      ),
      59 => 
      array (
        'code' => '57',
        'name' => 'Moselle',
      ),
      60 => 
      array (
        'code' => '58',
        'name' => 'Nièvre',
      ),
      61 => 
      array (
        'code' => '59',
        'name' => 'Nord',
      ),
      62 => 
      array (
        'code' => '60',
        'name' => 'Oise',
      ),
      63 => 
      array (
        'code' => '61',
        'name' => 'Orne',
      ),
      64 => 
      array (
        'code' => '62',
        'name' => 'Pas de Calais',
      ),
      65 => 
      array (
        'code' => '63',
        'name' => 'Puy de Dôme',
      ),
      66 => 
      array (
        'code' => '64',
        'name' => 'Pyrenees Atlantique',
      ),
      67 => 
      array (
        'code' => '65',
        'name' => 'Hautes Pyrenees',
      ),
      68 => 
      array (
        'code' => '66',
        'name' => 'Pyrenees Orientale',
      ),
      69 => 
      array (
        'code' => '67',
        'name' => 'Bas Rhin',
      ),
      70 => 
      array (
        'code' => '68',
        'name' => 'Haut Rhin',
      ),
      71 => 
      array (
        'code' => '69',
        'name' => 'Rhône',
      ),
      72 => 
      array (
        'code' => '70',
        'name' => 'Haute Saône',
      ),
      73 => 
      array (
        'code' => '71',
        'name' => 'Saône et Loire',
      ),
      74 => 
      array (
        'code' => '72',
        'name' => 'Sarthe',
      ),
      75 => 
      array (
        'code' => '73',
        'name' => 'Savoie',
      ),
      76 => 
      array (
        'code' => '74',
        'name' => 'Haute Savoie',
      ),
      77 => 
      array (
        'code' => '75',
        'name' => 'Paris',
      ),
      78 => 
      array (
        'code' => '76',
        'name' => 'Seine Martitime',
      ),
      79 => 
      array (
        'code' => '77',
        'name' => 'Seine et Marne',
      ),
      80 => 
      array (
        'code' => '78',
        'name' => 'Yvelines',
      ),
      81 => 
      array (
        'code' => '79',
        'name' => 'Deux Sèvres',
      ),
      82 => 
      array (
        'code' => '80',
        'name' => 'Somme',
      ),
      83 => 
      array (
        'code' => '81',
        'name' => 'Tarn',
      ),
      84 => 
      array (
        'code' => '82',
        'name' => 'Tarn et Garonne',
      ),
      85 => 
      array (
        'code' => '83',
        'name' => 'Var',
      ),
      86 => 
      array (
        'code' => '84',
        'name' => 'Vaucluse',
      ),
      87 => 
      array (
        'code' => '85',
        'name' => 'Vendée',
      ),
      88 => 
      array (
        'code' => '86',
        'name' => 'Vienne',
      ),
      89 => 
      array (
        'code' => '87',
        'name' => 'Haute Vienne',
      ),
      90 => 
      array (
        'code' => '88',
        'name' => 'Vosges',
      ),
      91 => 
      array (
        'code' => '89',
        'name' => 'Yonne',
      ),
      92 => 
      array (
        'code' => '90',
        'name' => 'Territoire de Belfort',
      ),
      93 => 
      array (
        'code' => '91',
        'name' => 'Essonne',
      ),
      94 => 
      array (
        'code' => '92',
        'name' => 'Hauts de Seine',
      ),
      95 => 
      array (
        'code' => '93',
        'name' => 'Seine St-Denis',
      ),
      96 => 
      array (
        'code' => '94',
        'name' => 'Val de Marne',
      ),
      97 => 
      array (
        'code' => '95',
        'name' => 'Val d&#39;oise',
      ),
    ),
    'GA' => 
    array (
      1 => 
      array (
        'code' => 'ES',
        'name' => 'Estuaire',
      ),
      2 => 
      array (
        'code' => 'HO',
        'name' => 'Haut-Ogooue',
      ),
      3 => 
      array (
        'code' => 'MO',
        'name' => 'Moyen-Ogooue',
      ),
      4 => 
      array (
        'code' => 'NG',
        'name' => 'Ngounie',
      ),
      5 => 
      array (
        'code' => 'NY',
        'name' => 'Nyanga',
      ),
      6 => 
      array (
        'code' => 'OI',
        'name' => 'Ogooue-Ivindo',
      ),
      7 => 
      array (
        'code' => 'OL',
        'name' => 'Ogooue-Lolo',
      ),
      8 => 
      array (
        'code' => 'OM',
        'name' => 'Ogooue-Maritime',
      ),
      9 => 
      array (
        'code' => 'WN',
        'name' => 'Woleu-Ntem',
      ),
    ),
    'GB' => 
    array (
      1 => 
      array (
        'code' => 'ABN',
        'name' => 'Aberdeen',
      ),
      2 => 
      array (
        'code' => 'ABNS',
        'name' => 'Aberdeenshire',
      ),
      3 => 
      array (
        'code' => 'ANG',
        'name' => 'Anglesey',
      ),
      4 => 
      array (
        'code' => 'AGS',
        'name' => 'Angus',
      ),
      5 => 
      array (
        'code' => 'ARY',
        'name' => 'Argyll and Bute',
      ),
      6 => 
      array (
        'code' => 'BEDS',
        'name' => 'Bedfordshire',
      ),
      7 => 
      array (
        'code' => 'BERKS',
        'name' => 'Berkshire',
      ),
      8 => 
      array (
        'code' => 'BLA',
        'name' => 'Blaenau Gwent',
      ),
      9 => 
      array (
        'code' => 'BRI',
        'name' => 'Bridgend',
      ),
      10 => 
      array (
        'code' => 'BSTL',
        'name' => 'Bristol',
      ),
      11 => 
      array (
        'code' => 'BUCKS',
        'name' => 'Buckinghamshire',
      ),
      12 => 
      array (
        'code' => 'CAE',
        'name' => 'Caerphilly',
      ),
      13 => 
      array (
        'code' => 'CAMBS',
        'name' => 'Cambridgeshire',
      ),
      14 => 
      array (
        'code' => 'CDF',
        'name' => 'Cardiff',
      ),
      15 => 
      array (
        'code' => 'CARM',
        'name' => 'Carmarthenshire',
      ),
      16 => 
      array (
        'code' => 'CDGN',
        'name' => 'Ceredigion',
      ),
      17 => 
      array (
        'code' => 'CHES',
        'name' => 'Cheshire',
      ),
      18 => 
      array (
        'code' => 'CLACK',
        'name' => 'Clackmannanshire',
      ),
      19 => 
      array (
        'code' => 'CON',
        'name' => 'Conwy',
      ),
      20 => 
      array (
        'code' => 'CORN',
        'name' => 'Cornwall',
      ),
      21 => 
      array (
        'code' => 'DNBG',
        'name' => 'Denbighshire',
      ),
      22 => 
      array (
        'code' => 'DERBY',
        'name' => 'Derbyshire',
      ),
      23 => 
      array (
        'code' => 'DVN',
        'name' => 'Devon',
      ),
      24 => 
      array (
        'code' => 'DOR',
        'name' => 'Dorset',
      ),
      25 => 
      array (
        'code' => 'DGL',
        'name' => 'Dumfries and Galloway',
      ),
      26 => 
      array (
        'code' => 'DUND',
        'name' => 'Dundee',
      ),
      27 => 
      array (
        'code' => 'DHM',
        'name' => 'Durham',
      ),
      28 => 
      array (
        'code' => 'ARYE',
        'name' => 'East Ayrshire',
      ),
      29 => 
      array (
        'code' => 'DUNBE',
        'name' => 'East Dunbartonshire',
      ),
      30 => 
      array (
        'code' => 'LOTE',
        'name' => 'East Lothian',
      ),
      31 => 
      array (
        'code' => 'RENE',
        'name' => 'East Renfrewshire',
      ),
      32 => 
      array (
        'code' => 'ERYS',
        'name' => 'East Riding of Yorkshire',
      ),
      33 => 
      array (
        'code' => 'SXE',
        'name' => 'East Sussex',
      ),
      34 => 
      array (
        'code' => 'EDIN',
        'name' => 'Edinburgh',
      ),
      35 => 
      array (
        'code' => 'ESX',
        'name' => 'Essex',
      ),
      36 => 
      array (
        'code' => 'FALK',
        'name' => 'Falkirk',
      ),
      37 => 
      array (
        'code' => 'FFE',
        'name' => 'Fife',
      ),
      38 => 
      array (
        'code' => 'FLINT',
        'name' => 'Flintshire',
      ),
      39 => 
      array (
        'code' => 'GLAS',
        'name' => 'Glasgow',
      ),
      40 => 
      array (
        'code' => 'GLOS',
        'name' => 'Gloucestershire',
      ),
      41 => 
      array (
        'code' => 'LDN',
        'name' => 'Greater London',
      ),
      42 => 
      array (
        'code' => 'MCH',
        'name' => 'Greater Manchester',
      ),
      43 => 
      array (
        'code' => 'GDD',
        'name' => 'Gwynedd',
      ),
      44 => 
      array (
        'code' => 'HANTS',
        'name' => 'Hampshire',
      ),
      45 => 
      array (
        'code' => 'HWR',
        'name' => 'Herefordshire',
      ),
      46 => 
      array (
        'code' => 'HERTS',
        'name' => 'Hertfordshire',
      ),
      47 => 
      array (
        'code' => 'HLD',
        'name' => 'Highlands',
      ),
      48 => 
      array (
        'code' => 'IVER',
        'name' => 'Inverclyde',
      ),
      49 => 
      array (
        'code' => 'IOW',
        'name' => 'Isle of Wight',
      ),
      50 => 
      array (
        'code' => 'KNT',
        'name' => 'Kent',
      ),
      51 => 
      array (
        'code' => 'LANCS',
        'name' => 'Lancashire',
      ),
      52 => 
      array (
        'code' => 'LEICS',
        'name' => 'Leicestershire',
      ),
      53 => 
      array (
        'code' => 'LINCS',
        'name' => 'Lincolnshire',
      ),
      54 => 
      array (
        'code' => 'MSY',
        'name' => 'Merseyside',
      ),
      55 => 
      array (
        'code' => 'MERT',
        'name' => 'Merthyr Tydfil',
      ),
      56 => 
      array (
        'code' => 'MLOT',
        'name' => 'Midlothian',
      ),
      57 => 
      array (
        'code' => 'MMOUTH',
        'name' => 'Monmouthshire',
      ),
      58 => 
      array (
        'code' => 'MORAY',
        'name' => 'Moray',
      ),
      59 => 
      array (
        'code' => 'NPRTAL',
        'name' => 'Neath Port Talbot',
      ),
      60 => 
      array (
        'code' => 'NEWPT',
        'name' => 'Newport',
      ),
      61 => 
      array (
        'code' => 'NOR',
        'name' => 'Norfolk',
      ),
      62 => 
      array (
        'code' => 'ARYN',
        'name' => 'North Ayrshire',
      ),
      63 => 
      array (
        'code' => 'LANN',
        'name' => 'North Lanarkshire',
      ),
      64 => 
      array (
        'code' => 'YSN',
        'name' => 'North Yorkshire',
      ),
      65 => 
      array (
        'code' => 'NHM',
        'name' => 'Northamptonshire',
      ),
      66 => 
      array (
        'code' => 'NLD',
        'name' => 'Northumberland',
      ),
      67 => 
      array (
        'code' => 'NOT',
        'name' => 'Nottinghamshire',
      ),
      68 => 
      array (
        'code' => 'ORK',
        'name' => 'Orkney Islands',
      ),
      69 => 
      array (
        'code' => 'OFE',
        'name' => 'Oxfordshire',
      ),
      70 => 
      array (
        'code' => 'PEM',
        'name' => 'Pembrokeshire',
      ),
      71 => 
      array (
        'code' => 'PERTH',
        'name' => 'Perth and Kinross',
      ),
      72 => 
      array (
        'code' => 'PWS',
        'name' => 'Powys',
      ),
      73 => 
      array (
        'code' => 'REN',
        'name' => 'Renfrewshire',
      ),
      74 => 
      array (
        'code' => 'RHON',
        'name' => 'Rhondda Cynon Taff',
      ),
      75 => 
      array (
        'code' => 'RUT',
        'name' => 'Rutland',
      ),
      76 => 
      array (
        'code' => 'BOR',
        'name' => 'Scottish Borders',
      ),
      77 => 
      array (
        'code' => 'SHET',
        'name' => 'Shetland Islands',
      ),
      78 => 
      array (
        'code' => 'SPE',
        'name' => 'Shropshire',
      ),
      79 => 
      array (
        'code' => 'SOM',
        'name' => 'Somerset',
      ),
      80 => 
      array (
        'code' => 'ARYS',
        'name' => 'South Ayrshire',
      ),
      81 => 
      array (
        'code' => 'LANS',
        'name' => 'South Lanarkshire',
      ),
      82 => 
      array (
        'code' => 'YSS',
        'name' => 'South Yorkshire',
      ),
      83 => 
      array (
        'code' => 'SFD',
        'name' => 'Staffordshire',
      ),
      84 => 
      array (
        'code' => 'STIR',
        'name' => 'Stirling',
      ),
      85 => 
      array (
        'code' => 'SFK',
        'name' => 'Suffolk',
      ),
      86 => 
      array (
        'code' => 'SRY',
        'name' => 'Surrey',
      ),
      87 => 
      array (
        'code' => 'SWAN',
        'name' => 'Swansea',
      ),
      88 => 
      array (
        'code' => 'TORF',
        'name' => 'Torfaen',
      ),
      89 => 
      array (
        'code' => 'TWR',
        'name' => 'Tyne and Wear',
      ),
      90 => 
      array (
        'code' => 'VGLAM',
        'name' => 'Vale of Glamorgan',
      ),
      91 => 
      array (
        'code' => 'WARKS',
        'name' => 'Warwickshire',
      ),
      92 => 
      array (
        'code' => 'WDUN',
        'name' => 'West Dunbartonshire',
      ),
      93 => 
      array (
        'code' => 'WLOT',
        'name' => 'West Lothian',
      ),
      94 => 
      array (
        'code' => 'WMD',
        'name' => 'West Midlands',
      ),
      95 => 
      array (
        'code' => 'SXW',
        'name' => 'West Sussex',
      ),
      96 => 
      array (
        'code' => 'YSW',
        'name' => 'West Yorkshire',
      ),
      97 => 
      array (
        'code' => 'WIL',
        'name' => 'Western Isles',
      ),
      98 => 
      array (
        'code' => 'WLT',
        'name' => 'Wiltshire',
      ),
      99 => 
      array (
        'code' => 'WORCS',
        'name' => 'Worcestershire',
      ),
      100 => 
      array (
        'code' => 'WRX',
        'name' => 'Wrexham',
      ),
    ),
    'GE' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => 'Abkhazia',
      ),
      2 => 
      array (
        'code' => 'AJ',
        'name' => 'Ajaria',
      ),
      3 => 
      array (
        'code' => 'GU',
        'name' => 'Guria',
      ),
      4 => 
      array (
        'code' => 'IM',
        'name' => 'Imereti',
      ),
      5 => 
      array (
        'code' => 'KA',
        'name' => 'Kakheti',
      ),
      6 => 
      array (
        'code' => 'KK',
        'name' => 'Kvemo Kartli',
      ),
      7 => 
      array (
        'code' => 'MM',
        'name' => 'Mtskheta-Mtianeti',
      ),
      8 => 
      array (
        'code' => 'RL',
        'name' => 'Racha Lechkhumi and Kvemo Svanet',
      ),
      9 => 
      array (
        'code' => 'SJ',
        'name' => 'Samtskhe-Javakheti',
      ),
      10 => 
      array (
        'code' => 'SK',
        'name' => 'Shida Kartli',
      ),
      11 => 
      array (
        'code' => 'SZ',
        'name' => 'Samegrelo-Zemo Svaneti',
      ),
      12 => 
      array (
        'code' => 'TB',
        'name' => 'Tbilisi',
      ),
    ),
    'GF' => 
    array (
      1 => 
      array (
        'code' => 'AWA',
        'name' => 'Awala-Yalimapo',
      ),
      2 => 
      array (
        'code' => 'MAN',
        'name' => 'Mana',
      ),
      3 => 
      array (
        'code' => 'SAI',
        'name' => 'Saint-Laurent-Du-Maroni',
      ),
      4 => 
      array (
        'code' => 'APA',
        'name' => 'Apatou',
      ),
      5 => 
      array (
        'code' => 'GRA',
        'name' => 'Grand-Santi',
      ),
      6 => 
      array (
        'code' => 'PAP',
        'name' => 'Papaïchton',
      ),
      7 => 
      array (
        'code' => 'SAÜ',
        'name' => 'SaÜl',
      ),
      8 => 
      array (
        'code' => 'MAR',
        'name' => 'Maripasoula',
      ),
      9 => 
      array (
        'code' => 'CAM',
        'name' => 'Camopi',
      ),
      10 => 
      array (
        'code' => 'SAI',
        'name' => 'Saint-Georges',
      ),
      11 => 
      array (
        'code' => 'OUA',
        'name' => 'Ouanary',
      ),
      12 => 
      array (
        'code' => 'RéG',
        'name' => 'Régina',
      ),
      13 => 
      array (
        'code' => 'ROU',
        'name' => 'Roura',
      ),
      14 => 
      array (
        'code' => 'SAI',
        'name' => 'Saint-élie',
      ),
      15 => 
      array (
        'code' => 'IRA',
        'name' => 'Iracoubo',
      ),
      16 => 
      array (
        'code' => 'SIN',
        'name' => 'Sinnamary',
      ),
      17 => 
      array (
        'code' => 'KOU',
        'name' => 'Kourou',
      ),
      18 => 
      array (
        'code' => 'MAC',
        'name' => 'Macouria',
      ),
      19 => 
      array (
        'code' => 'MON',
        'name' => 'Montsinéry-Tonnegrande',
      ),
      20 => 
      array (
        'code' => 'MAT',
        'name' => 'Matoury',
      ),
      21 => 
      array (
        'code' => 'CAY',
        'name' => 'Cayenne',
      ),
      22 => 
      array (
        'code' => 'REM',
        'name' => 'Remire-Montjoly',
      ),
    ),
    'GH' => 
    array (
      1 => 
      array (
        'code' => 'AS',
        'name' => 'Ashanti Region',
      ),
      2 => 
      array (
        'code' => 'BA',
        'name' => 'Brong-Ahafo Region',
      ),
      3 => 
      array (
        'code' => 'CE',
        'name' => 'Central Region',
      ),
      4 => 
      array (
        'code' => 'EA',
        'name' => 'Eastern Region',
      ),
      5 => 
      array (
        'code' => 'GA',
        'name' => 'Greater Accra Region',
      ),
      6 => 
      array (
        'code' => 'NO',
        'name' => 'Northern Region',
      ),
      7 => 
      array (
        'code' => 'UE',
        'name' => 'Upper East Region',
      ),
      8 => 
      array (
        'code' => 'UW',
        'name' => 'Upper West Region',
      ),
      9 => 
      array (
        'code' => 'VO',
        'name' => 'Volta Region',
      ),
      10 => 
      array (
        'code' => 'WE',
        'name' => 'Western Region',
      ),
    ),
    'GI' => 
    array (
      1 => 
      array (
        'code' => 'EAS',
        'name' => 'East Side',
      ),
      2 => 
      array (
        'code' => 'NOR',
        'name' => 'North District',
      ),
      3 => 
      array (
        'code' => 'REC',
        'name' => 'Reclamation Areas',
      ),
      4 => 
      array (
        'code' => 'SAN',
        'name' => 'Sandpits Area',
      ),
      5 => 
      array (
        'code' => 'SOU',
        'name' => 'South District',
      ),
      6 => 
      array (
        'code' => 'TOW',
        'name' => 'Town Area',
      ),
      7 => 
      array (
        'code' => 'UPP',
        'name' => 'Upper Town',
      ),
      8 => 
      array (
        'code' => 'OTH',
        'name' => 'Other',
      ),
    ),
    'GL' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Avannaa',
      ),
      2 => 
      array (
        'code' => 'T',
        'name' => 'Tunu',
      ),
      3 => 
      array (
        'code' => 'K',
        'name' => 'Kitaa',
      ),
    ),
    'GM' => 
    array (
      1 => 
      array (
        'code' => 'BJ',
        'name' => 'Banjul',
      ),
      2 => 
      array (
        'code' => 'BS',
        'name' => 'Basse',
      ),
      3 => 
      array (
        'code' => 'BR',
        'name' => 'Brikama',
      ),
      4 => 
      array (
        'code' => 'JA',
        'name' => 'Janjangbure',
      ),
      5 => 
      array (
        'code' => 'KA',
        'name' => 'Kanifeng',
      ),
      6 => 
      array (
        'code' => 'KE',
        'name' => 'Kerewan',
      ),
      7 => 
      array (
        'code' => 'KU',
        'name' => 'Kuntaur',
      ),
      8 => 
      array (
        'code' => 'MA',
        'name' => 'Mansakonko',
      ),
      9 => 
      array (
        'code' => 'LR',
        'name' => 'Lower River',
      ),
      10 => 
      array (
        'code' => 'CR',
        'name' => 'Central River',
      ),
      11 => 
      array (
        'code' => 'NB',
        'name' => 'North Bank',
      ),
      12 => 
      array (
        'code' => 'UR',
        'name' => 'Upper River',
      ),
      13 => 
      array (
        'code' => 'WE',
        'name' => 'Western',
      ),
    ),
    'GN' => 
    array (
      1 => 
      array (
        'code' => 'CNK',
        'name' => 'Conakry',
      ),
      2 => 
      array (
        'code' => 'BYL',
        'name' => 'Beyla',
      ),
      3 => 
      array (
        'code' => 'BFA',
        'name' => 'Boffa',
      ),
      4 => 
      array (
        'code' => 'BOK',
        'name' => 'Boke',
      ),
      5 => 
      array (
        'code' => 'COY',
        'name' => 'Coyah',
      ),
      6 => 
      array (
        'code' => 'DBL',
        'name' => 'Dabola',
      ),
      7 => 
      array (
        'code' => 'DLB',
        'name' => 'Dalaba',
      ),
      8 => 
      array (
        'code' => 'DGR',
        'name' => 'Dinguiraye',
      ),
      9 => 
      array (
        'code' => 'DBR',
        'name' => 'Dubreka',
      ),
      10 => 
      array (
        'code' => 'FRN',
        'name' => 'Faranah',
      ),
      11 => 
      array (
        'code' => 'FRC',
        'name' => 'Forecariah',
      ),
      12 => 
      array (
        'code' => 'FRI',
        'name' => 'Fria',
      ),
      13 => 
      array (
        'code' => 'GAO',
        'name' => 'Gaoual',
      ),
      14 => 
      array (
        'code' => 'GCD',
        'name' => 'Gueckedou',
      ),
      15 => 
      array (
        'code' => 'KNK',
        'name' => 'Kankan',
      ),
      16 => 
      array (
        'code' => 'KRN',
        'name' => 'Kerouane',
      ),
      17 => 
      array (
        'code' => 'KND',
        'name' => 'Kindia',
      ),
      18 => 
      array (
        'code' => 'KSD',
        'name' => 'Kissidougou',
      ),
      19 => 
      array (
        'code' => 'KBA',
        'name' => 'Koubia',
      ),
      20 => 
      array (
        'code' => 'KDA',
        'name' => 'Koundara',
      ),
      21 => 
      array (
        'code' => 'KRA',
        'name' => 'Kouroussa',
      ),
      22 => 
      array (
        'code' => 'LAB',
        'name' => 'Labe',
      ),
      23 => 
      array (
        'code' => 'LLM',
        'name' => 'Lelouma',
      ),
      24 => 
      array (
        'code' => 'LOL',
        'name' => 'Lola',
      ),
      25 => 
      array (
        'code' => 'MCT',
        'name' => 'Macenta',
      ),
      26 => 
      array (
        'code' => 'MAL',
        'name' => 'Mali',
      ),
      27 => 
      array (
        'code' => 'MAM',
        'name' => 'Mamou',
      ),
      28 => 
      array (
        'code' => 'MAN',
        'name' => 'Mandiana',
      ),
      29 => 
      array (
        'code' => 'NZR',
        'name' => 'Nzerekore',
      ),
      30 => 
      array (
        'code' => 'PIT',
        'name' => 'Pita',
      ),
      31 => 
      array (
        'code' => 'SIG',
        'name' => 'Siguiri',
      ),
      32 => 
      array (
        'code' => 'TLM',
        'name' => 'Telimele',
      ),
      33 => 
      array (
        'code' => 'TOG',
        'name' => 'Tougue',
      ),
      34 => 
      array (
        'code' => 'YOM',
        'name' => 'Yomou',
      ),
    ),
    'GP' => 
    array (
      1 => 
      array (
        'code' => 'ARR',
        'name' => 'Arrondissements Of The Guadeloup',
      ),
      2 => 
      array (
        'code' => 'CAN',
        'name' => 'Cantons Of The Guadeloup Depart',
      ),
      3 => 
      array (
        'code' => 'COM',
        'name' => 'Communes Of The Guadeloup Depart',
      ),
    ),
    'GQ' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Provincia Annobon',
      ),
      2 => 
      array (
        'code' => 'BN',
        'name' => 'Provincia Bioko Norte',
      ),
      3 => 
      array (
        'code' => 'BS',
        'name' => 'Provincia Bioko Sur',
      ),
      4 => 
      array (
        'code' => 'CS',
        'name' => 'Provincia Centro Sur',
      ),
      5 => 
      array (
        'code' => 'KN',
        'name' => 'Provincia Kie-Ntem',
      ),
      6 => 
      array (
        'code' => 'LI',
        'name' => 'Provincia Litoral',
      ),
      7 => 
      array (
        'code' => 'WN',
        'name' => 'Provincia Wele-Nzas',
      ),
    ),
    'GR' => 
    array (
      1 => 
      array (
        'code' => 'AT',
        'name' => 'Attica',
      ),
      2 => 
      array (
        'code' => 'CN',
        'name' => 'Central Greece',
      ),
      3 => 
      array (
        'code' => 'CM',
        'name' => 'Central Macedonia',
      ),
      4 => 
      array (
        'code' => 'CR',
        'name' => 'Crete',
      ),
      5 => 
      array (
        'code' => 'EM',
        'name' => 'East Macedonia and Thrace',
      ),
      6 => 
      array (
        'code' => 'EP',
        'name' => 'Epirus',
      ),
      7 => 
      array (
        'code' => 'II',
        'name' => 'Ionian Islands',
      ),
      8 => 
      array (
        'code' => 'NA',
        'name' => 'North Aegean',
      ),
      9 => 
      array (
        'code' => 'PP',
        'name' => 'Peloponnesos',
      ),
      10 => 
      array (
        'code' => 'SA',
        'name' => 'South Aegean',
      ),
      11 => 
      array (
        'code' => 'TH',
        'name' => 'Thessaly',
      ),
      12 => 
      array (
        'code' => 'WG',
        'name' => 'West Greece',
      ),
      13 => 
      array (
        'code' => 'WM',
        'name' => 'West Macedonia',
      ),
    ),
    'GT' => 
    array (
      1 => 
      array (
        'code' => 'AV',
        'name' => 'Alta Verapaz',
      ),
      2 => 
      array (
        'code' => 'BV',
        'name' => 'Baja Verapaz',
      ),
      3 => 
      array (
        'code' => 'CM',
        'name' => 'Chimaltenango',
      ),
      4 => 
      array (
        'code' => 'CQ',
        'name' => 'Chiquimula',
      ),
      5 => 
      array (
        'code' => 'PE',
        'name' => 'El Peten',
      ),
      6 => 
      array (
        'code' => 'PR',
        'name' => 'El Progreso',
      ),
      7 => 
      array (
        'code' => 'QC',
        'name' => 'El Quiche',
      ),
      8 => 
      array (
        'code' => 'ES',
        'name' => 'Escuintla',
      ),
      9 => 
      array (
        'code' => 'GU',
        'name' => 'Guatemala',
      ),
      10 => 
      array (
        'code' => 'HU',
        'name' => 'Huehuetenango',
      ),
      11 => 
      array (
        'code' => 'IZ',
        'name' => 'Izabal',
      ),
      12 => 
      array (
        'code' => 'JA',
        'name' => 'Jalapa',
      ),
      13 => 
      array (
        'code' => 'JU',
        'name' => 'Jutiapa',
      ),
      14 => 
      array (
        'code' => 'QZ',
        'name' => 'Quetzaltenango',
      ),
      15 => 
      array (
        'code' => 'RE',
        'name' => 'Retalhuleu',
      ),
      16 => 
      array (
        'code' => 'ST',
        'name' => 'Sacatepequez',
      ),
      17 => 
      array (
        'code' => 'SM',
        'name' => 'San Marcos',
      ),
      18 => 
      array (
        'code' => 'SR',
        'name' => 'Santa Rosa',
      ),
      19 => 
      array (
        'code' => 'SO',
        'name' => 'Solola',
      ),
      20 => 
      array (
        'code' => 'SU',
        'name' => 'Suchitepequez',
      ),
      21 => 
      array (
        'code' => 'TO',
        'name' => 'Totonicapan',
      ),
      22 => 
      array (
        'code' => 'ZA',
        'name' => 'Zacapa',
      ),
    ),
    'GU' => 
    array (
      1 => 
      array (
        'code' => 'AGA',
        'name' => 'Agana Heights',
      ),
      2 => 
      array (
        'code' => 'AGA',
        'name' => 'Agat',
      ),
      3 => 
      array (
        'code' => 'ASA',
        'name' => 'Asan Maina',
      ),
      4 => 
      array (
        'code' => 'BAR',
        'name' => 'Barrigada',
      ),
      5 => 
      array (
        'code' => 'CHA',
        'name' => 'Chalan Pago Ordot',
      ),
      6 => 
      array (
        'code' => 'DED',
        'name' => 'Dededo',
      ),
      7 => 
      array (
        'code' => 'HAG',
        'name' => 'HagÅtña',
      ),
      8 => 
      array (
        'code' => 'INA',
        'name' => 'Inarajan',
      ),
      9 => 
      array (
        'code' => 'MAN',
        'name' => 'Mangilao',
      ),
      10 => 
      array (
        'code' => 'MER',
        'name' => 'Merizo',
      ),
      11 => 
      array (
        'code' => 'MON',
        'name' => 'Mongmong Toto Maite',
      ),
      12 => 
      array (
        'code' => 'PIT',
        'name' => 'Piti',
      ),
      13 => 
      array (
        'code' => 'SAN',
        'name' => 'Santa Rita',
      ),
      14 => 
      array (
        'code' => 'SIN',
        'name' => 'Sinajana',
      ),
      15 => 
      array (
        'code' => 'TAL',
        'name' => 'Talofofo',
      ),
      16 => 
      array (
        'code' => 'TAM',
        'name' => 'Tamuning',
      ),
      17 => 
      array (
        'code' => 'UMA',
        'name' => 'Umatac',
      ),
      18 => 
      array (
        'code' => 'YIG',
        'name' => 'Yigo',
      ),
      19 => 
      array (
        'code' => 'YON',
        'name' => 'Yona',
      ),
    ),
    'GW' => 
    array (
      1 => 
      array (
        'code' => 'BF',
        'name' => 'Bafata Region',
      ),
      2 => 
      array (
        'code' => 'BB',
        'name' => 'Biombo Region',
      ),
      3 => 
      array (
        'code' => 'BS',
        'name' => 'Bissau Region',
      ),
      4 => 
      array (
        'code' => 'BL',
        'name' => 'Bolama Region',
      ),
      5 => 
      array (
        'code' => 'CA',
        'name' => 'Cacheu Region',
      ),
      6 => 
      array (
        'code' => 'GA',
        'name' => 'Gabu Region',
      ),
      7 => 
      array (
        'code' => 'OI',
        'name' => 'Oio Region',
      ),
      8 => 
      array (
        'code' => 'QU',
        'name' => 'Quinara Region',
      ),
      9 => 
      array (
        'code' => 'TO',
        'name' => 'Tombali Region',
      ),
    ),
    'GY' => 
    array (
      1 => 
      array (
        'code' => 'BW',
        'name' => 'Barima-Waini',
      ),
      2 => 
      array (
        'code' => 'CM',
        'name' => 'Cuyuni-Mazaruni',
      ),
      3 => 
      array (
        'code' => 'DM',
        'name' => 'Demerara-Mahaica',
      ),
      4 => 
      array (
        'code' => 'EC',
        'name' => 'East Berbice-Corentyne',
      ),
      5 => 
      array (
        'code' => 'EW',
        'name' => 'Essequibo Islands-West Demerara',
      ),
      6 => 
      array (
        'code' => 'MB',
        'name' => 'Mahaica-Berbice',
      ),
      7 => 
      array (
        'code' => 'PM',
        'name' => 'Pomeroon-Supenaam',
      ),
      8 => 
      array (
        'code' => 'PI',
        'name' => 'Potaro-Siparuni',
      ),
      9 => 
      array (
        'code' => 'UD',
        'name' => 'Upper Demerara-Berbice',
      ),
      10 => 
      array (
        'code' => 'UT',
        'name' => 'Upper Takutu-Upper Essequibo',
      ),
    ),
    'HK' => 
    array (
      1 => 
      array (
        'code' => 'HCW',
        'name' => 'Central and Western Hong Kong Is',
      ),
      2 => 
      array (
        'code' => 'HEA',
        'name' => 'Eastern Hong Kong Island',
      ),
      3 => 
      array (
        'code' => 'HSO',
        'name' => 'Southern Hong Kong Island',
      ),
      4 => 
      array (
        'code' => 'HWC',
        'name' => 'Wan Chai Hong Kong Island',
      ),
      5 => 
      array (
        'code' => 'KKC',
        'name' => 'Kowloon City Kowloon',
      ),
      6 => 
      array (
        'code' => 'KKT',
        'name' => 'Kwun Tong Kowloon',
      ),
      7 => 
      array (
        'code' => 'KSS',
        'name' => 'Sham Shui Po Kowloon',
      ),
      8 => 
      array (
        'code' => 'KWT',
        'name' => 'Wong Tai Sin Kowloon',
      ),
      9 => 
      array (
        'code' => 'KYT',
        'name' => 'Yau Tsim Mong Kowloon',
      ),
      10 => 
      array (
        'code' => 'NIS',
        'name' => 'Islands New Territories',
      ),
      11 => 
      array (
        'code' => 'NKT',
        'name' => 'Kwai Tsing New Territories',
      ),
      12 => 
      array (
        'code' => 'NNO',
        'name' => 'North New Territories',
      ),
      13 => 
      array (
        'code' => 'NSK',
        'name' => 'Sai Kung New Territories',
      ),
      14 => 
      array (
        'code' => 'NST',
        'name' => 'Sha Tin New Territories',
      ),
      15 => 
      array (
        'code' => 'NTP',
        'name' => 'Tai Po New Territories',
      ),
      16 => 
      array (
        'code' => 'NTW',
        'name' => 'Tsuen Wan New Territories',
      ),
      17 => 
      array (
        'code' => 'NTM',
        'name' => 'Tuen Mun New Territories',
      ),
      18 => 
      array (
        'code' => 'NYL',
        'name' => 'Yuen Long New Territories',
      ),
    ),
    'HM' => 
    array (
      1 => 
      array (
        'code' => 'F',
        'name' => 'Flat Island',
      ),
      2 => 
      array (
        'code' => 'M',
        'name' => 'McDonald Island',
      ),
      3 => 
      array (
        'code' => 'S',
        'name' => 'Shag Island',
      ),
      4 => 
      array (
        'code' => 'H',
        'name' => 'Heard Island',
      ),
    ),
    'HN' => 
    array (
      1 => 
      array (
        'code' => 'AT',
        'name' => 'Atlantida',
      ),
      2 => 
      array (
        'code' => 'CH',
        'name' => 'Choluteca',
      ),
      3 => 
      array (
        'code' => 'CL',
        'name' => 'Colon',
      ),
      4 => 
      array (
        'code' => 'CM',
        'name' => 'Comayagua',
      ),
      5 => 
      array (
        'code' => 'CP',
        'name' => 'Copan',
      ),
      6 => 
      array (
        'code' => 'CR',
        'name' => 'Cortes',
      ),
      7 => 
      array (
        'code' => 'PA',
        'name' => 'El Paraiso',
      ),
      8 => 
      array (
        'code' => 'FM',
        'name' => 'Francisco Morazan',
      ),
      9 => 
      array (
        'code' => 'GD',
        'name' => 'Gracias a Dios',
      ),
      10 => 
      array (
        'code' => 'IN',
        'name' => 'Intibuca',
      ),
      11 => 
      array (
        'code' => 'IB',
        'name' => 'Islas de la Bahia (Bay Islands)',
      ),
      12 => 
      array (
        'code' => 'PZ',
        'name' => 'La Paz',
      ),
      13 => 
      array (
        'code' => 'LE',
        'name' => 'Lempira',
      ),
      14 => 
      array (
        'code' => 'OC',
        'name' => 'Ocotepeque',
      ),
      15 => 
      array (
        'code' => 'OL',
        'name' => 'Olancho',
      ),
      16 => 
      array (
        'code' => 'SB',
        'name' => 'Santa Barbara',
      ),
      17 => 
      array (
        'code' => 'VA',
        'name' => 'Valle',
      ),
      18 => 
      array (
        'code' => 'YO',
        'name' => 'Yoro',
      ),
    ),
    'HR' => 
    array (
      1 => 
      array (
        'code' => 'BB',
        'name' => 'Bjelovar-Bilogora',
      ),
      2 => 
      array (
        'code' => 'CZ',
        'name' => 'City of Zagreb',
      ),
      3 => 
      array (
        'code' => 'DN',
        'name' => 'Dubrovnik-Neretva',
      ),
      4 => 
      array (
        'code' => 'IS',
        'name' => 'Istra',
      ),
      5 => 
      array (
        'code' => 'KA',
        'name' => 'Karlovac',
      ),
      6 => 
      array (
        'code' => 'KK',
        'name' => 'Koprivnica-Krizevci',
      ),
      7 => 
      array (
        'code' => 'KZ',
        'name' => 'Krapina-Zagorje',
      ),
      8 => 
      array (
        'code' => 'LS',
        'name' => 'Lika-Senj',
      ),
      9 => 
      array (
        'code' => 'ME',
        'name' => 'Medimurje',
      ),
      10 => 
      array (
        'code' => 'OB',
        'name' => 'Osijek-Baranja',
      ),
      11 => 
      array (
        'code' => 'PS',
        'name' => 'Pozega-Slavonia',
      ),
      12 => 
      array (
        'code' => 'PG',
        'name' => 'Primorje-Gorski Kotar',
      ),
      13 => 
      array (
        'code' => 'SI',
        'name' => 'Sibenik',
      ),
      14 => 
      array (
        'code' => 'SM',
        'name' => 'Sisak-Moslavina',
      ),
      15 => 
      array (
        'code' => 'SB',
        'name' => 'Slavonski Brod-Posavina',
      ),
      16 => 
      array (
        'code' => 'SD',
        'name' => 'Split-Dalmatia',
      ),
      17 => 
      array (
        'code' => 'VA',
        'name' => 'Varazdin',
      ),
      18 => 
      array (
        'code' => 'VP',
        'name' => 'Virovitica-Podravina',
      ),
      19 => 
      array (
        'code' => 'VS',
        'name' => 'Vukovar-Srijem',
      ),
      20 => 
      array (
        'code' => 'ZK',
        'name' => 'Zadar-Knin',
      ),
      21 => 
      array (
        'code' => 'ZA',
        'name' => 'Zagreb',
      ),
    ),
    'HT' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => 'Artibonite',
      ),
      2 => 
      array (
        'code' => 'CE',
        'name' => 'Centre',
      ),
      3 => 
      array (
        'code' => 'GA',
        'name' => 'Grand&#39;Anse',
      ),
      4 => 
      array (
        'code' => 'ND',
        'name' => 'Nord',
      ),
      5 => 
      array (
        'code' => 'NE',
        'name' => 'Nord-Est',
      ),
      6 => 
      array (
        'code' => 'NO',
        'name' => 'Nord-Ouest',
      ),
      7 => 
      array (
        'code' => 'OU',
        'name' => 'Ouest',
      ),
      8 => 
      array (
        'code' => 'SD',
        'name' => 'Sud',
      ),
      9 => 
      array (
        'code' => 'SE',
        'name' => 'Sud-Est',
      ),
    ),
    'HU' => 
    array (
      1 => 
      array (
        'code' => 'BK',
        'name' => 'Bacs-Kiskun',
      ),
      2 => 
      array (
        'code' => 'BA',
        'name' => 'Baranya',
      ),
      3 => 
      array (
        'code' => 'BE',
        'name' => 'Bekes',
      ),
      4 => 
      array (
        'code' => 'BS',
        'name' => 'Bekescsaba',
      ),
      5 => 
      array (
        'code' => 'BZ',
        'name' => 'Borsod-Abauj-Zemplen',
      ),
      6 => 
      array (
        'code' => 'BU',
        'name' => 'Budapest',
      ),
      7 => 
      array (
        'code' => 'CS',
        'name' => 'Csongrad',
      ),
      8 => 
      array (
        'code' => 'DE',
        'name' => 'Debrecen',
      ),
      9 => 
      array (
        'code' => 'DU',
        'name' => 'Dunaujvaros',
      ),
      10 => 
      array (
        'code' => 'EG',
        'name' => 'Eger',
      ),
      11 => 
      array (
        'code' => 'FE',
        'name' => 'Fejer',
      ),
      12 => 
      array (
        'code' => 'GY',
        'name' => 'Gyor',
      ),
      13 => 
      array (
        'code' => 'GM',
        'name' => 'Gyor-Moson-Sopron',
      ),
      14 => 
      array (
        'code' => 'HB',
        'name' => 'Hajdu-Bihar',
      ),
      15 => 
      array (
        'code' => 'HE',
        'name' => 'Heves',
      ),
      16 => 
      array (
        'code' => 'HO',
        'name' => 'Hodmezovasarhely',
      ),
      17 => 
      array (
        'code' => 'JN',
        'name' => 'Jasz-Nagykun-Szolnok',
      ),
      18 => 
      array (
        'code' => 'KA',
        'name' => 'Kaposvar',
      ),
      19 => 
      array (
        'code' => 'KE',
        'name' => 'Kecskemet',
      ),
      20 => 
      array (
        'code' => 'KO',
        'name' => 'Komarom-Esztergom',
      ),
      21 => 
      array (
        'code' => 'MI',
        'name' => 'Miskolc',
      ),
      22 => 
      array (
        'code' => 'NA',
        'name' => 'Nagykanizsa',
      ),
      23 => 
      array (
        'code' => 'NO',
        'name' => 'Nograd',
      ),
      24 => 
      array (
        'code' => 'NY',
        'name' => 'Nyiregyhaza',
      ),
      25 => 
      array (
        'code' => 'PE',
        'name' => 'Pecs',
      ),
      26 => 
      array (
        'code' => 'PS',
        'name' => 'Pest',
      ),
      27 => 
      array (
        'code' => 'SO',
        'name' => 'Somogy',
      ),
      28 => 
      array (
        'code' => 'SP',
        'name' => 'Sopron',
      ),
      29 => 
      array (
        'code' => 'SS',
        'name' => 'Szabolcs-Szatmar-Bereg',
      ),
      30 => 
      array (
        'code' => 'SZ',
        'name' => 'Szeged',
      ),
      31 => 
      array (
        'code' => 'SE',
        'name' => 'Szekesfehervar',
      ),
      32 => 
      array (
        'code' => 'SL',
        'name' => 'Szolnok',
      ),
      33 => 
      array (
        'code' => 'SM',
        'name' => 'Szombathely',
      ),
      34 => 
      array (
        'code' => 'TA',
        'name' => 'Tatabanya',
      ),
      35 => 
      array (
        'code' => 'TO',
        'name' => 'Tolna',
      ),
      36 => 
      array (
        'code' => 'VA',
        'name' => 'Vas',
      ),
      37 => 
      array (
        'code' => 'VE',
        'name' => 'Veszprem',
      ),
      38 => 
      array (
        'code' => 'ZA',
        'name' => 'Zala',
      ),
      39 => 
      array (
        'code' => 'ZZ',
        'name' => 'Zalaegerszeg',
      ),
    ),
    'ID' => 
    array (
      1 => 
      array (
        'code' => 'DA',
        'name' => 'Daista Aceh',
      ),
      2 => 
      array (
        'code' => 'SU',
        'name' => 'Sumatera Utara',
      ),
      3 => 
      array (
        'code' => 'SB',
        'name' => 'Sumatera Barat',
      ),
      4 => 
      array (
        'code' => 'SI',
        'name' => 'Riau',
      ),
      5 => 
      array (
        'code' => 'JA',
        'name' => 'Jambi',
      ),
      6 => 
      array (
        'code' => 'SS',
        'name' => 'Sumatera Selatan',
      ),
      7 => 
      array (
        'code' => 'BE',
        'name' => 'Bengkulu',
      ),
      8 => 
      array (
        'code' => 'LA',
        'name' => 'Lampung',
      ),
      9 => 
      array (
        'code' => 'JK',
        'name' => 'Dki Jakarta',
      ),
      10 => 
      array (
        'code' => 'JB',
        'name' => 'Jawa Barat',
      ),
      11 => 
      array (
        'code' => 'JT',
        'name' => 'Jawa Tengah',
      ),
      12 => 
      array (
        'code' => 'DY',
        'name' => 'Daista Yogyakarta',
      ),
      13 => 
      array (
        'code' => 'JT',
        'name' => 'Jawa Timur',
      ),
      14 => 
      array (
        'code' => 'KB',
        'name' => 'Kalimantan Barat',
      ),
      15 => 
      array (
        'code' => 'KT',
        'name' => 'Kalimantan Tengah',
      ),
      16 => 
      array (
        'code' => 'KI',
        'name' => 'Kalimantan Timur',
      ),
      17 => 
      array (
        'code' => 'KS',
        'name' => 'Kalimantan Selatan',
      ),
      18 => 
      array (
        'code' => 'BA',
        'name' => 'Bali',
      ),
      19 => 
      array (
        'code' => 'NB',
        'name' => 'Nusa Tenggara Barat',
      ),
      20 => 
      array (
        'code' => 'NT',
        'name' => 'Nusa Tenggara Timur',
      ),
      21 => 
      array (
        'code' => 'SN',
        'name' => 'Sulawesi Selatan',
      ),
      22 => 
      array (
        'code' => 'ST',
        'name' => 'Sulawesi Tengah',
      ),
      23 => 
      array (
        'code' => 'SA',
        'name' => 'Sulawesi Utara',
      ),
      24 => 
      array (
        'code' => 'SG',
        'name' => 'Sulawesi Tenggara',
      ),
      25 => 
      array (
        'code' => 'MA',
        'name' => 'Maluku',
      ),
      26 => 
      array (
        'code' => 'MU',
        'name' => 'Maluku Utara',
      ),
      27 => 
      array (
        'code' => 'IJ',
        'name' => 'Irian Jaya Timur',
      ),
      28 => 
      array (
        'code' => 'IT',
        'name' => 'Irian Jaya Tengah',
      ),
      29 => 
      array (
        'code' => 'IB',
        'name' => 'Irian Jawa Barat',
      ),
      30 => 
      array (
        'code' => 'BT',
        'name' => 'Banten',
      ),
      31 => 
      array (
        'code' => 'BB',
        'name' => 'Bangka Belitung',
      ),
      32 => 
      array (
        'code' => 'GO',
        'name' => 'Gorontalo',
      ),
    ),
    'IE' => 
    array (
      1 => 
      array (
        'code' => 'CA',
        'name' => 'Carlow',
      ),
      2 => 
      array (
        'code' => 'CV',
        'name' => 'Cavan',
      ),
      3 => 
      array (
        'code' => 'CL',
        'name' => 'Clare',
      ),
      4 => 
      array (
        'code' => 'CO',
        'name' => 'Cork',
      ),
      5 => 
      array (
        'code' => 'DO',
        'name' => 'Donegal',
      ),
      6 => 
      array (
        'code' => 'DU',
        'name' => 'Dublin',
      ),
      7 => 
      array (
        'code' => 'GA',
        'name' => 'Galway',
      ),
      8 => 
      array (
        'code' => 'KE',
        'name' => 'Kerry',
      ),
      9 => 
      array (
        'code' => 'KI',
        'name' => 'Kildare',
      ),
      10 => 
      array (
        'code' => 'KL',
        'name' => 'Kilkenny',
      ),
      11 => 
      array (
        'code' => 'LA',
        'name' => 'Laois',
      ),
      12 => 
      array (
        'code' => 'LE',
        'name' => 'Leitrim',
      ),
      13 => 
      array (
        'code' => 'LI',
        'name' => 'Limerick',
      ),
      14 => 
      array (
        'code' => 'LO',
        'name' => 'Longford',
      ),
      15 => 
      array (
        'code' => 'LU',
        'name' => 'Louth',
      ),
      16 => 
      array (
        'code' => 'MA',
        'name' => 'Mayo',
      ),
      17 => 
      array (
        'code' => 'ME',
        'name' => 'Meath',
      ),
      18 => 
      array (
        'code' => 'MO',
        'name' => 'Monaghan',
      ),
      19 => 
      array (
        'code' => 'OF',
        'name' => 'Offaly',
      ),
      20 => 
      array (
        'code' => 'RO',
        'name' => 'Roscommon',
      ),
      21 => 
      array (
        'code' => 'SL',
        'name' => 'Sligo',
      ),
      22 => 
      array (
        'code' => 'TI',
        'name' => 'Tipperary',
      ),
      23 => 
      array (
        'code' => 'WA',
        'name' => 'Waterford',
      ),
      24 => 
      array (
        'code' => 'WE',
        'name' => 'Westmeath',
      ),
      25 => 
      array (
        'code' => 'WX',
        'name' => 'Wexford',
      ),
      26 => 
      array (
        'code' => 'WI',
        'name' => 'Wicklow',
      ),
    ),
    'IL' => 
    array (
      1 => 
      array (
        'code' => 'BS',
        'name' => 'Be&#39;er Sheva',
      ),
      2 => 
      array (
        'code' => 'BH',
        'name' => 'Bika&#39;at Hayarden',
      ),
      3 => 
      array (
        'code' => 'EA',
        'name' => 'Eilat and Arava',
      ),
      4 => 
      array (
        'code' => 'GA',
        'name' => 'Galil',
      ),
      5 => 
      array (
        'code' => 'HA',
        'name' => 'Haifa',
      ),
      6 => 
      array (
        'code' => 'JM',
        'name' => 'Jehuda Mountains',
      ),
      7 => 
      array (
        'code' => 'JE',
        'name' => 'Jerusalem',
      ),
      8 => 
      array (
        'code' => 'NE',
        'name' => 'Negev',
      ),
      10 => 
      array (
        'code' => 'SE',
        'name' => 'Semaria',
      ),
      11 => 
      array (
        'code' => 'SH',
        'name' => 'Sharon',
      ),
      12 => 
      array (
        'code' => 'TA',
        'name' => 'Tel Aviv (Gosh Dan)',
      ),
    ),
    'IN' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Andaman and Nicobar Islands',
      ),
      2 => 
      array (
        'code' => 'AP',
        'name' => 'Andhra Pradesh',
      ),
      3 => 
      array (
        'code' => 'AR',
        'name' => 'Arunachal Pradesh',
      ),
      4 => 
      array (
        'code' => 'AS',
        'name' => 'Assam',
      ),
      5 => 
      array (
        'code' => 'BI',
        'name' => 'Bihar',
      ),
      6 => 
      array (
        'code' => 'CH',
        'name' => 'Chandigarh',
      ),
      7 => 
      array (
        'code' => 'DA',
        'name' => 'Dadra and Nagar Haveli',
      ),
      8 => 
      array (
        'code' => 'DM',
        'name' => 'Daman and Diu',
      ),
      9 => 
      array (
        'code' => 'DE',
        'name' => 'Delhi',
      ),
      10 => 
      array (
        'code' => 'GO',
        'name' => 'Goa',
      ),
      11 => 
      array (
        'code' => 'GU',
        'name' => 'Gujarat',
      ),
      12 => 
      array (
        'code' => 'HA',
        'name' => 'Haryana',
      ),
      13 => 
      array (
        'code' => 'HP',
        'name' => 'Himachal Pradesh',
      ),
      14 => 
      array (
        'code' => 'JA',
        'name' => 'Jammu and Kashmir',
      ),
      15 => 
      array (
        'code' => 'KA',
        'name' => 'Karnataka',
      ),
      16 => 
      array (
        'code' => 'KE',
        'name' => 'Kerala',
      ),
      17 => 
      array (
        'code' => 'LI',
        'name' => 'Lakshadweep Islands',
      ),
      18 => 
      array (
        'code' => 'MP',
        'name' => 'Madhya Pradesh',
      ),
      19 => 
      array (
        'code' => 'MA',
        'name' => 'Maharashtra',
      ),
      20 => 
      array (
        'code' => 'MN',
        'name' => 'Manipur',
      ),
      21 => 
      array (
        'code' => 'ME',
        'name' => 'Meghalaya',
      ),
      22 => 
      array (
        'code' => 'MI',
        'name' => 'Mizoram',
      ),
      23 => 
      array (
        'code' => 'NA',
        'name' => 'Nagaland',
      ),
      24 => 
      array (
        'code' => 'OR',
        'name' => 'Orissa',
      ),
      25 => 
      array (
        'code' => 'PO',
        'name' => 'Pondicherry',
      ),
      26 => 
      array (
        'code' => 'PU',
        'name' => 'Punjab',
      ),
      27 => 
      array (
        'code' => 'RA',
        'name' => 'Rajasthan',
      ),
      28 => 
      array (
        'code' => 'SI',
        'name' => 'Sikkim',
      ),
      29 => 
      array (
        'code' => 'TN',
        'name' => 'Tamil Nadu',
      ),
      30 => 
      array (
        'code' => 'TR',
        'name' => 'Tripura',
      ),
      31 => 
      array (
        'code' => 'UP',
        'name' => 'Uttar Pradesh',
      ),
      32 => 
      array (
        'code' => 'WB',
        'name' => 'West Bengal',
      ),
    ),
    'IO' => 
    array (
      1 => 
      array (
        'code' => 'DG',
        'name' => 'Diego Garcia',
      ),
      2 => 
      array (
        'code' => 'DI',
        'name' => 'Danger Island',
      ),
      3 => 
      array (
        'code' => 'EA',
        'name' => 'Eagle Islands',
      ),
      4 => 
      array (
        'code' => 'EG',
        'name' => 'Egmont Islands',
      ),
      5 => 
      array (
        'code' => 'NI',
        'name' => 'Nelsons Island',
      ),
      6 => 
      array (
        'code' => 'PB',
        'name' => 'Peros Banhos',
      ),
      7 => 
      array (
        'code' => 'SI',
        'name' => 'Salomon Islands',
      ),
      8 => 
      array (
        'code' => 'TB',
        'name' => 'Three Brothers',
      ),
    ),
    'IQ' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => 'Al Anbar',
      ),
      2 => 
      array (
        'code' => 'AL',
        'name' => 'Arbil',
      ),
      3 => 
      array (
        'code' => 'BA',
        'name' => 'Al Basrah',
      ),
      4 => 
      array (
        'code' => 'BB',
        'name' => 'Babil',
      ),
      5 => 
      array (
        'code' => 'BD',
        'name' => 'Baghdad',
      ),
      6 => 
      array (
        'code' => 'DH',
        'name' => 'Dahuk',
      ),
      7 => 
      array (
        'code' => 'DQ',
        'name' => 'Dhi Qar',
      ),
      8 => 
      array (
        'code' => 'DY',
        'name' => 'Diyala',
      ),
      9 => 
      array (
        'code' => 'KB',
        'name' => 'Al Karbala',
      ),
      10 => 
      array (
        'code' => 'MU',
        'name' => 'Al Muthanna',
      ),
      11 => 
      array (
        'code' => 'MY',
        'name' => 'Maysan',
      ),
      12 => 
      array (
        'code' => 'NJ',
        'name' => 'An Najaf',
      ),
      13 => 
      array (
        'code' => 'NN',
        'name' => 'Ninawa',
      ),
      14 => 
      array (
        'code' => 'QA',
        'name' => 'Al Qadisyah',
      ),
      15 => 
      array (
        'code' => 'SD',
        'name' => 'Salah ad Din',
      ),
      16 => 
      array (
        'code' => 'SL',
        'name' => 'As Sulaymaniyah',
      ),
      17 => 
      array (
        'code' => 'TM',
        'name' => 'At Ta&#39;mim',
      ),
      18 => 
      array (
        'code' => 'WS',
        'name' => 'Wasit',
      ),
    ),
    'IR' => 
    array (
      1 => 
      array (
        'code' => 'ARD',
        'name' => 'Ardabil',
      ),
      2 => 
      array (
        'code' => 'BSH',
        'name' => 'Bushehr',
      ),
      3 => 
      array (
        'code' => 'CMB',
        'name' => 'Chahar Mahaal and Bakhtiari',
      ),
      4 => 
      array (
        'code' => 'EAZ',
        'name' => 'East Azarbaijan',
      ),
      5 => 
      array (
        'code' => 'EFH',
        'name' => 'Esfahan',
      ),
      6 => 
      array (
        'code' => 'FAR',
        'name' => 'Fars',
      ),
      7 => 
      array (
        'code' => 'GIL',
        'name' => 'Gilan',
      ),
      8 => 
      array (
        'code' => 'GLS',
        'name' => 'Golestan',
      ),
      9 => 
      array (
        'code' => 'HMD',
        'name' => 'Hamadan',
      ),
      10 => 
      array (
        'code' => 'HRM',
        'name' => 'Hormozgan',
      ),
      11 => 
      array (
        'code' => 'ILM',
        'name' => 'Ilam',
      ),
      12 => 
      array (
        'code' => 'KBA',
        'name' => 'Kohkiluyeh and Buyer Ahmad',
      ),
      13 => 
      array (
        'code' => 'KRB',
        'name' => 'Kerman',
      ),
      14 => 
      array (
        'code' => 'KRD',
        'name' => 'Kurdistan',
      ),
      15 => 
      array (
        'code' => 'KRM',
        'name' => 'Kermanshah',
      ),
      16 => 
      array (
        'code' => 'KZT',
        'name' => 'Khuzestan',
      ),
      17 => 
      array (
        'code' => 'LRS',
        'name' => 'Lorestan',
      ),
      18 => 
      array (
        'code' => 'MKZ',
        'name' => 'Markazi',
      ),
      19 => 
      array (
        'code' => 'MZD',
        'name' => 'Mazandaran',
      ),
      20 => 
      array (
        'code' => 'NKH',
        'name' => 'North Khorasan',
      ),
      21 => 
      array (
        'code' => 'QAZ',
        'name' => 'Qazvin',
      ),
      22 => 
      array (
        'code' => 'QOM',
        'name' => 'Qom',
      ),
      23 => 
      array (
        'code' => 'RKH',
        'name' => 'Razavi Khorasan',
      ),
      24 => 
      array (
        'code' => 'SBL',
        'name' => 'Sistan and Baluchistan',
      ),
      25 => 
      array (
        'code' => 'SKH',
        'name' => 'South Khorasan',
      ),
      26 => 
      array (
        'code' => 'SMN',
        'name' => 'Semnan',
      ),
      27 => 
      array (
        'code' => 'TEH',
        'name' => 'Tehran',
      ),
      28 => 
      array (
        'code' => 'WEZ',
        'name' => 'West Azarbaijan',
      ),
      29 => 
      array (
        'code' => 'YZD',
        'name' => 'Yazd',
      ),
      30 => 
      array (
        'code' => 'ZAN',
        'name' => 'Zanjan',
      ),
    ),
    'IS' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Austurland',
      ),
      2 => 
      array (
        'code' => 'HF',
        'name' => 'Hofuoborgarsvaeoi',
      ),
      3 => 
      array (
        'code' => 'NE',
        'name' => 'Norourland eystra',
      ),
      4 => 
      array (
        'code' => 'NV',
        'name' => 'Norourland vestra',
      ),
      5 => 
      array (
        'code' => 'SL',
        'name' => 'Suourland',
      ),
      6 => 
      array (
        'code' => 'SN',
        'name' => 'Suournes',
      ),
      7 => 
      array (
        'code' => 'VF',
        'name' => 'Vestfiroir',
      ),
      8 => 
      array (
        'code' => 'VL',
        'name' => 'Vesturland',
      ),
    ),
    'IT' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => 'Agrigento',
      ),
      2 => 
      array (
        'code' => 'AL',
        'name' => 'Alessandria',
      ),
      3 => 
      array (
        'code' => 'AN',
        'name' => 'Ancona',
      ),
      4 => 
      array (
        'code' => 'AO',
        'name' => 'Aosta',
      ),
      5 => 
      array (
        'code' => 'AR',
        'name' => 'Arezzo',
      ),
      6 => 
      array (
        'code' => 'AP',
        'name' => 'Ascoli Piceno',
      ),
      7 => 
      array (
        'code' => 'AT',
        'name' => 'Asti',
      ),
      8 => 
      array (
        'code' => 'AV',
        'name' => 'Avellino',
      ),
      9 => 
      array (
        'code' => 'BA',
        'name' => 'Bari',
      ),
      10 => 
      array (
        'code' => 'BL',
        'name' => 'Belluno',
      ),
      11 => 
      array (
        'code' => 'BN',
        'name' => 'Benevento',
      ),
      12 => 
      array (
        'code' => 'BG',
        'name' => 'Bergamo',
      ),
      13 => 
      array (
        'code' => 'BI',
        'name' => 'Biella',
      ),
      14 => 
      array (
        'code' => 'BO',
        'name' => 'Bologna',
      ),
      15 => 
      array (
        'code' => 'BZ',
        'name' => 'Bolzano',
      ),
      16 => 
      array (
        'code' => 'BS',
        'name' => 'Brescia',
      ),
      17 => 
      array (
        'code' => 'BR',
        'name' => 'Brindisi',
      ),
      18 => 
      array (
        'code' => 'CA',
        'name' => 'Cagliari',
      ),
      19 => 
      array (
        'code' => 'CL',
        'name' => 'Caltanissetta',
      ),
      20 => 
      array (
        'code' => 'CB',
        'name' => 'Campobasso',
      ),
      21 => 
      array (
        'code' => 'CE',
        'name' => 'Caserta',
      ),
      22 => 
      array (
        'code' => 'CT',
        'name' => 'Catania',
      ),
      23 => 
      array (
        'code' => 'CZ',
        'name' => 'Catanzaro',
      ),
      24 => 
      array (
        'code' => 'CH',
        'name' => 'Chieti',
      ),
      25 => 
      array (
        'code' => 'CO',
        'name' => 'Como',
      ),
      26 => 
      array (
        'code' => 'CS',
        'name' => 'Cosenza',
      ),
      27 => 
      array (
        'code' => 'CR',
        'name' => 'Cremona',
      ),
      28 => 
      array (
        'code' => 'KR',
        'name' => 'Crotone',
      ),
      29 => 
      array (
        'code' => 'CN',
        'name' => 'Cuneo',
      ),
      30 => 
      array (
        'code' => 'EN',
        'name' => 'Enna',
      ),
      31 => 
      array (
        'code' => 'FE',
        'name' => 'Ferrara',
      ),
      32 => 
      array (
        'code' => 'FI',
        'name' => 'Firenze',
      ),
      33 => 
      array (
        'code' => 'FG',
        'name' => 'Foggia',
      ),
      34 => 
      array (
        'code' => 'FO',
        'name' => 'Forlì',
      ),
      35 => 
      array (
        'code' => 'FR',
        'name' => 'Frosinone',
      ),
      36 => 
      array (
        'code' => 'GE',
        'name' => 'Genova',
      ),
      37 => 
      array (
        'code' => 'GO',
        'name' => 'Gorizia',
      ),
      38 => 
      array (
        'code' => 'GR',
        'name' => 'Grosseto',
      ),
      39 => 
      array (
        'code' => 'IM',
        'name' => 'Imperia',
      ),
      40 => 
      array (
        'code' => 'IS',
        'name' => 'Isernia',
      ),
      41 => 
      array (
        'code' => 'AQ',
        'name' => 'Aquila',
      ),
      42 => 
      array (
        'code' => 'SP',
        'name' => 'La Spezia',
      ),
      43 => 
      array (
        'code' => 'LT',
        'name' => 'Latina',
      ),
      44 => 
      array (
        'code' => 'LE',
        'name' => 'Lecce',
      ),
      45 => 
      array (
        'code' => 'LC',
        'name' => 'Lecco',
      ),
      46 => 
      array (
        'code' => 'LI',
        'name' => 'Livorno',
      ),
      47 => 
      array (
        'code' => 'LO',
        'name' => 'Lodi',
      ),
      48 => 
      array (
        'code' => 'LU',
        'name' => 'Lucca',
      ),
      49 => 
      array (
        'code' => 'MC',
        'name' => 'Macerata',
      ),
      50 => 
      array (
        'code' => 'MN',
        'name' => 'Mantova',
      ),
      51 => 
      array (
        'code' => 'MS',
        'name' => 'Massa-Carrara',
      ),
      52 => 
      array (
        'code' => 'MT',
        'name' => 'Matera',
      ),
      53 => 
      array (
        'code' => 'ME',
        'name' => 'Messina',
      ),
      54 => 
      array (
        'code' => 'MI',
        'name' => 'Milano',
      ),
      55 => 
      array (
        'code' => 'MO',
        'name' => 'Modena',
      ),
      56 => 
      array (
        'code' => 'NA',
        'name' => 'Napoli',
      ),
      57 => 
      array (
        'code' => 'NO',
        'name' => 'Novara',
      ),
      58 => 
      array (
        'code' => 'NU',
        'name' => 'Nuoro',
      ),
      59 => 
      array (
        'code' => 'OR',
        'name' => 'Oristano',
      ),
      60 => 
      array (
        'code' => 'PD',
        'name' => 'Padova',
      ),
      61 => 
      array (
        'code' => 'PA',
        'name' => 'Palermo',
      ),
      62 => 
      array (
        'code' => 'PR',
        'name' => 'Parma',
      ),
      63 => 
      array (
        'code' => 'PG',
        'name' => 'Perugia',
      ),
      64 => 
      array (
        'code' => 'PV',
        'name' => 'Pavia',
      ),
      65 => 
      array (
        'code' => 'PU',
        'name' => 'Pesaro Urbino',
      ),
      66 => 
      array (
        'code' => 'PE',
        'name' => 'Pescara',
      ),
      67 => 
      array (
        'code' => 'PC',
        'name' => 'Piacenza',
      ),
      68 => 
      array (
        'code' => 'PI',
        'name' => 'Pisa',
      ),
      69 => 
      array (
        'code' => 'PT',
        'name' => 'Pistoia',
      ),
      70 => 
      array (
        'code' => 'PN',
        'name' => 'Pordenone',
      ),
      71 => 
      array (
        'code' => 'PZ',
        'name' => 'Potenza',
      ),
      72 => 
      array (
        'code' => 'PO',
        'name' => 'Prato',
      ),
      73 => 
      array (
        'code' => 'RG',
        'name' => 'Ragusa',
      ),
      74 => 
      array (
        'code' => 'RA',
        'name' => 'Ravenna',
      ),
      75 => 
      array (
        'code' => 'RC',
        'name' => 'Reggio Calabria',
      ),
      76 => 
      array (
        'code' => 'RE',
        'name' => 'Reggio Emilia',
      ),
      77 => 
      array (
        'code' => 'RI',
        'name' => 'Rieti',
      ),
      78 => 
      array (
        'code' => 'RN',
        'name' => 'Rimini',
      ),
      79 => 
      array (
        'code' => 'RM',
        'name' => 'Roma',
      ),
      80 => 
      array (
        'code' => 'RO',
        'name' => 'Rovigo',
      ),
      81 => 
      array (
        'code' => 'SA',
        'name' => 'Salerno',
      ),
      82 => 
      array (
        'code' => 'SS',
        'name' => 'Sassari',
      ),
      83 => 
      array (
        'code' => 'SV',
        'name' => 'Savona',
      ),
      84 => 
      array (
        'code' => 'SI',
        'name' => 'Siena',
      ),
      85 => 
      array (
        'code' => 'SR',
        'name' => 'Siracusa',
      ),
      86 => 
      array (
        'code' => 'SO',
        'name' => 'Sondrio',
      ),
      87 => 
      array (
        'code' => 'TA',
        'name' => 'Taranto',
      ),
      88 => 
      array (
        'code' => 'TE',
        'name' => 'Teramo',
      ),
      89 => 
      array (
        'code' => 'TR',
        'name' => 'Terni',
      ),
      90 => 
      array (
        'code' => 'TO',
        'name' => 'Torino',
      ),
      91 => 
      array (
        'code' => 'TP',
        'name' => 'Trapani',
      ),
      92 => 
      array (
        'code' => 'TN',
        'name' => 'Trento',
      ),
      93 => 
      array (
        'code' => 'TV',
        'name' => 'Treviso',
      ),
      94 => 
      array (
        'code' => 'TS',
        'name' => 'Trieste',
      ),
      95 => 
      array (
        'code' => 'UD',
        'name' => 'Udine',
      ),
      96 => 
      array (
        'code' => 'VA',
        'name' => 'Varese',
      ),
      97 => 
      array (
        'code' => 'VE',
        'name' => 'Venezia',
      ),
      98 => 
      array (
        'code' => 'VB',
        'name' => 'Verbania',
      ),
      99 => 
      array (
        'code' => 'VC',
        'name' => 'Vercelli',
      ),
      100 => 
      array (
        'code' => 'VR',
        'name' => 'Verona',
      ),
      101 => 
      array (
        'code' => 'VV',
        'name' => 'Vibo Valentia',
      ),
      102 => 
      array (
        'code' => 'VI',
        'name' => 'Vicenza',
      ),
      103 => 
      array (
        'code' => 'VT',
        'name' => 'Viterbo',
      ),
      104 => 
      array (
        'code' => 'CI',
        'name' => 'Carbonia-Iglesias',
      ),
      105 => 
      array (
        'code' => 'VS',
        'name' => 'Medio Campidano',
      ),
      106 => 
      array (
        'code' => 'OG',
        'name' => 'Ogliastra',
      ),
      107 => 
      array (
        'code' => 'OT',
        'name' => 'Olbia-Tempio',
      ),
      108 => 
      array (
        'code' => 'MB',
        'name' => 'Monza e Brianza',
      ),
      109 => 
      array (
        'code' => 'FM',
        'name' => 'Fermo',
      ),
      110 => 
      array (
        'code' => 'BT',
        'name' => 'Barletta-Andria-Trani',
      ),
    ),
    'JM' => 
    array (
      1 => 
      array (
        'code' => 'CLA',
        'name' => 'Clarendon Parish',
      ),
      2 => 
      array (
        'code' => 'HAN',
        'name' => 'Hanover Parish',
      ),
      3 => 
      array (
        'code' => 'KIN',
        'name' => 'Kingston Parish',
      ),
      4 => 
      array (
        'code' => 'MAN',
        'name' => 'Manchester Parish',
      ),
      5 => 
      array (
        'code' => 'POR',
        'name' => 'Portland Parish',
      ),
      6 => 
      array (
        'code' => 'AND',
        'name' => 'Saint Andrew Parish',
      ),
      7 => 
      array (
        'code' => 'ANN',
        'name' => 'Saint Ann Parish',
      ),
      8 => 
      array (
        'code' => 'CAT',
        'name' => 'Saint Catherine Parish',
      ),
      9 => 
      array (
        'code' => 'ELI',
        'name' => 'Saint Elizabeth Parish',
      ),
      10 => 
      array (
        'code' => 'JAM',
        'name' => 'Saint James Parish',
      ),
      11 => 
      array (
        'code' => 'MAR',
        'name' => 'Saint Mary Parish',
      ),
      12 => 
      array (
        'code' => 'THO',
        'name' => 'Saint Thomas Parish',
      ),
      13 => 
      array (
        'code' => 'TRL',
        'name' => 'Trelawny Parish',
      ),
      14 => 
      array (
        'code' => 'WML',
        'name' => 'Westmoreland Parish',
      ),
    ),
    'JO' => 
    array (
      1 => 
      array (
        'code' => 'AM',
        'name' => '&#39;Amman',
      ),
      2 => 
      array (
        'code' => 'AJ',
        'name' => 'Ajlun',
      ),
      3 => 
      array (
        'code' => 'AA',
        'name' => 'Al&#39;Aqabah',
      ),
      4 => 
      array (
        'code' => 'AB',
        'name' => 'Al Balqa&#39;',
      ),
      5 => 
      array (
        'code' => 'AK',
        'name' => 'Al Karak',
      ),
      6 => 
      array (
        'code' => 'AL',
        'name' => 'Al Mafraq',
      ),
      7 => 
      array (
        'code' => 'AT',
        'name' => 'At Tafilah',
      ),
      8 => 
      array (
        'code' => 'AZ',
        'name' => 'Az Zarqa&#39;',
      ),
      9 => 
      array (
        'code' => 'IR',
        'name' => 'Irbid',
      ),
      10 => 
      array (
        'code' => 'JA',
        'name' => 'Jarash',
      ),
      11 => 
      array (
        'code' => 'MA',
        'name' => 'Ma&#39;an',
      ),
      12 => 
      array (
        'code' => 'MD',
        'name' => 'Madaba',
      ),
    ),
    'JP' => 
    array (
      1 => 
      array (
        'code' => 'AI',
        'name' => 'Aichi',
      ),
      2 => 
      array (
        'code' => 'AK',
        'name' => 'Akita',
      ),
      3 => 
      array (
        'code' => 'AO',
        'name' => 'Aomori',
      ),
      4 => 
      array (
        'code' => 'CH',
        'name' => 'Chiba',
      ),
      5 => 
      array (
        'code' => 'EH',
        'name' => 'Ehime',
      ),
      6 => 
      array (
        'code' => 'FK',
        'name' => 'Fukui',
      ),
      7 => 
      array (
        'code' => 'FU',
        'name' => 'Fukuoka',
      ),
      8 => 
      array (
        'code' => 'FS',
        'name' => 'Fukushima',
      ),
      9 => 
      array (
        'code' => 'GI',
        'name' => 'Gifu',
      ),
      10 => 
      array (
        'code' => 'GU',
        'name' => 'Gumma',
      ),
      11 => 
      array (
        'code' => 'HI',
        'name' => 'Hiroshima',
      ),
      12 => 
      array (
        'code' => 'HO',
        'name' => 'Hokkaido',
      ),
      13 => 
      array (
        'code' => 'HY',
        'name' => 'Hyogo',
      ),
      14 => 
      array (
        'code' => 'IB',
        'name' => 'Ibaraki',
      ),
      15 => 
      array (
        'code' => 'IS',
        'name' => 'Ishikawa',
      ),
      16 => 
      array (
        'code' => 'IW',
        'name' => 'Iwate',
      ),
      17 => 
      array (
        'code' => 'KA',
        'name' => 'Kagawa',
      ),
      18 => 
      array (
        'code' => 'KG',
        'name' => 'Kagoshima',
      ),
      19 => 
      array (
        'code' => 'KN',
        'name' => 'Kanagawa',
      ),
      20 => 
      array (
        'code' => 'KO',
        'name' => 'Kochi',
      ),
      21 => 
      array (
        'code' => 'KU',
        'name' => 'Kumamoto',
      ),
      22 => 
      array (
        'code' => 'KY',
        'name' => 'Kyoto',
      ),
      23 => 
      array (
        'code' => 'MI',
        'name' => 'Mie',
      ),
      24 => 
      array (
        'code' => 'MY',
        'name' => 'Miyagi',
      ),
      25 => 
      array (
        'code' => 'MZ',
        'name' => 'Miyazaki',
      ),
      26 => 
      array (
        'code' => 'NA',
        'name' => 'Nagano',
      ),
      27 => 
      array (
        'code' => 'NG',
        'name' => 'Nagasaki',
      ),
      28 => 
      array (
        'code' => 'NR',
        'name' => 'Nara',
      ),
      29 => 
      array (
        'code' => 'NI',
        'name' => 'Niigata',
      ),
      30 => 
      array (
        'code' => 'OI',
        'name' => 'Oita',
      ),
      31 => 
      array (
        'code' => 'OK',
        'name' => 'Okayama',
      ),
      32 => 
      array (
        'code' => 'ON',
        'name' => 'Okinawa',
      ),
      33 => 
      array (
        'code' => 'OS',
        'name' => 'Osaka',
      ),
      34 => 
      array (
        'code' => 'SA',
        'name' => 'Saga',
      ),
      35 => 
      array (
        'code' => 'SI',
        'name' => 'Saitama',
      ),
      36 => 
      array (
        'code' => 'SH',
        'name' => 'Shiga',
      ),
      37 => 
      array (
        'code' => 'SM',
        'name' => 'Shimane',
      ),
      38 => 
      array (
        'code' => 'SZ',
        'name' => 'Shizuoka',
      ),
      39 => 
      array (
        'code' => 'TO',
        'name' => 'Tochigi',
      ),
      40 => 
      array (
        'code' => 'TS',
        'name' => 'Tokushima',
      ),
      41 => 
      array (
        'code' => 'TK',
        'name' => 'Tokyo',
      ),
      42 => 
      array (
        'code' => 'TT',
        'name' => 'Tottori',
      ),
      43 => 
      array (
        'code' => 'TY',
        'name' => 'Toyama',
      ),
      44 => 
      array (
        'code' => 'WA',
        'name' => 'Wakayama',
      ),
      45 => 
      array (
        'code' => 'YA',
        'name' => 'Yamagata',
      ),
      46 => 
      array (
        'code' => 'YM',
        'name' => 'Yamaguchi',
      ),
      47 => 
      array (
        'code' => 'YN',
        'name' => 'Yamanashi',
      ),
    ),
    'KE' => 
    array (
      1 => 
      array (
        'code' => 'CE',
        'name' => 'Central',
      ),
      2 => 
      array (
        'code' => 'CO',
        'name' => 'Coast',
      ),
      3 => 
      array (
        'code' => 'EA',
        'name' => 'Eastern',
      ),
      4 => 
      array (
        'code' => 'NA',
        'name' => 'Nairobi Area',
      ),
      5 => 
      array (
        'code' => 'NE',
        'name' => 'North Eastern',
      ),
      6 => 
      array (
        'code' => 'NY',
        'name' => 'Nyanza',
      ),
      7 => 
      array (
        'code' => 'RV',
        'name' => 'Rift Valley',
      ),
      8 => 
      array (
        'code' => 'WE',
        'name' => 'Western',
      ),
    ),
    'KG' => 
    array (
      1 => 
      array (
        'code' => 'GB',
        'name' => 'Bishkek',
      ),
      2 => 
      array (
        'code' => 'B',
        'name' => 'Batken',
      ),
      3 => 
      array (
        'code' => 'C',
        'name' => 'Chu',
      ),
      4 => 
      array (
        'code' => 'J',
        'name' => 'Jalal-Abad',
      ),
      5 => 
      array (
        'code' => 'N',
        'name' => 'Naryn',
      ),
      6 => 
      array (
        'code' => 'O',
        'name' => 'Osh',
      ),
      7 => 
      array (
        'code' => 'T',
        'name' => 'Talas',
      ),
      8 => 
      array (
        'code' => 'Y',
        'name' => 'Ysyk-Kol',
      ),
    ),
    'KH' => 
    array (
      1 => 
      array (
        'code' => 'BA',
        'name' => 'Battambang',
      ),
      2 => 
      array (
        'code' => 'BM',
        'name' => 'Banteay Meanchey',
      ),
      3 => 
      array (
        'code' => 'KB',
        'name' => 'Keb',
      ),
      4 => 
      array (
        'code' => 'KK',
        'name' => 'Kaoh Kong',
      ),
      5 => 
      array (
        'code' => 'KL',
        'name' => 'Kandal',
      ),
      6 => 
      array (
        'code' => 'KM',
        'name' => 'Kampong Cham',
      ),
      7 => 
      array (
        'code' => 'KN',
        'name' => 'Kampong Chhnang',
      ),
      8 => 
      array (
        'code' => 'KO',
        'name' => 'Kampong Som',
      ),
      9 => 
      array (
        'code' => 'KP',
        'name' => 'Kampot',
      ),
      10 => 
      array (
        'code' => 'KR',
        'name' => 'Kratie',
      ),
      11 => 
      array (
        'code' => 'KT',
        'name' => 'Kampong Thom',
      ),
      12 => 
      array (
        'code' => 'KU',
        'name' => 'Kampong Speu',
      ),
      13 => 
      array (
        'code' => 'MK',
        'name' => 'Mondul Kiri',
      ),
      14 => 
      array (
        'code' => 'OM',
        'name' => 'Oddar Meancheay',
      ),
      15 => 
      array (
        'code' => 'PA',
        'name' => 'Pailin',
      ),
      16 => 
      array (
        'code' => 'PG',
        'name' => 'Prey Veng',
      ),
      17 => 
      array (
        'code' => 'PP',
        'name' => 'Phnom Penh',
      ),
      18 => 
      array (
        'code' => 'PR',
        'name' => 'Preah Vihear',
      ),
      19 => 
      array (
        'code' => 'PS',
        'name' => 'Preah Seihanu (Kompong Som or Si)',
      ),
      20 => 
      array (
        'code' => 'PU',
        'name' => 'Pursat',
      ),
      21 => 
      array (
        'code' => 'RK',
        'name' => 'Ratanak Kiri',
      ),
      22 => 
      array (
        'code' => 'SI',
        'name' => 'Siemreap',
      ),
      23 => 
      array (
        'code' => 'SR',
        'name' => 'Svay Rieng',
      ),
      24 => 
      array (
        'code' => 'ST',
        'name' => 'Stung Treng',
      ),
      25 => 
      array (
        'code' => 'TK',
        'name' => 'Takeo',
      ),
    ),
    'KI' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => 'Abaiang',
      ),
      2 => 
      array (
        'code' => 'AM',
        'name' => 'Abemama',
      ),
      3 => 
      array (
        'code' => 'AK',
        'name' => 'Aranuka',
      ),
      4 => 
      array (
        'code' => 'AO',
        'name' => 'Arorae',
      ),
      5 => 
      array (
        'code' => 'BA',
        'name' => 'Banaba',
      ),
      6 => 
      array (
        'code' => 'BE',
        'name' => 'Beru',
      ),
      7 => 
      array (
        'code' => 'bT',
        'name' => 'Butaritari',
      ),
      8 => 
      array (
        'code' => 'KA',
        'name' => 'Kanton',
      ),
      9 => 
      array (
        'code' => 'KR',
        'name' => 'Kiritimati',
      ),
      10 => 
      array (
        'code' => 'KU',
        'name' => 'Kuria',
      ),
      11 => 
      array (
        'code' => 'MI',
        'name' => 'Maiana',
      ),
      12 => 
      array (
        'code' => 'MN',
        'name' => 'Makin',
      ),
      13 => 
      array (
        'code' => 'ME',
        'name' => 'Marakei',
      ),
      14 => 
      array (
        'code' => 'NI',
        'name' => 'Nikunau',
      ),
      15 => 
      array (
        'code' => 'NO',
        'name' => 'Nonouti',
      ),
      16 => 
      array (
        'code' => 'ON',
        'name' => 'Onotoa',
      ),
      17 => 
      array (
        'code' => 'TT',
        'name' => 'Tabiteuea',
      ),
      18 => 
      array (
        'code' => 'TR',
        'name' => 'Tabuaeran',
      ),
      19 => 
      array (
        'code' => 'TM',
        'name' => 'Tamana',
      ),
      20 => 
      array (
        'code' => 'TW',
        'name' => 'Tarawa',
      ),
      21 => 
      array (
        'code' => 'TE',
        'name' => 'Teraina',
      ),
    ),
    'KM' => 
    array (
      1 => 
      array (
        'code' => 'G',
        'name' => 'Grande Comore',
      ),
      2 => 
      array (
        'code' => 'A',
        'name' => 'Anjouan',
      ),
      3 => 
      array (
        'code' => 'M',
        'name' => 'Moheli',
      ),
    ),
    'KN' => 
    array (
      1 => 
      array (
        'code' => 'CCN',
        'name' => 'Christ Church Nichola Town',
      ),
      2 => 
      array (
        'code' => 'SAS',
        'name' => 'Saint Anne Sandy Point',
      ),
      3 => 
      array (
        'code' => 'SGB',
        'name' => 'Saint George Basseterre',
      ),
      4 => 
      array (
        'code' => 'SGG',
        'name' => 'Saint George Gingerland',
      ),
      5 => 
      array (
        'code' => 'SJW',
        'name' => 'Saint James Windward',
      ),
      6 => 
      array (
        'code' => 'SJC',
        'name' => 'Saint John Capesterre',
      ),
      7 => 
      array (
        'code' => 'SJF',
        'name' => 'Saint John Figtree',
      ),
      8 => 
      array (
        'code' => 'SMC',
        'name' => 'Saint Mary Cayon',
      ),
      9 => 
      array (
        'code' => 'CAP',
        'name' => 'Saint Paul Capesterre',
      ),
      10 => 
      array (
        'code' => 'CHA',
        'name' => 'Saint Paul Charlestown',
      ),
      11 => 
      array (
        'code' => 'SPB',
        'name' => 'Saint Peter Basseterre',
      ),
      12 => 
      array (
        'code' => 'STL',
        'name' => 'Saint Thomas Lowland',
      ),
      13 => 
      array (
        'code' => 'STM',
        'name' => 'Saint Thomas Middle Island',
      ),
      14 => 
      array (
        'code' => 'TPP',
        'name' => 'Trinity Palmetto Point',
      ),
    ),
    'KP' => 
    array (
      1 => 
      array (
        'code' => 'CHA',
        'name' => 'Chagang-do',
      ),
      2 => 
      array (
        'code' => 'HAB',
        'name' => 'Hamgyong-bukto',
      ),
      3 => 
      array (
        'code' => 'HAN',
        'name' => 'Hamgyong-namdo',
      ),
      4 => 
      array (
        'code' => 'HWB',
        'name' => 'Hwanghae-bukto',
      ),
      5 => 
      array (
        'code' => 'HWN',
        'name' => 'Hwanghae-namdo',
      ),
      6 => 
      array (
        'code' => 'KAN',
        'name' => 'Kangwon-do',
      ),
      7 => 
      array (
        'code' => 'PYB',
        'name' => 'P\\&#39;yongan-bukto',
      ),
      8 => 
      array (
        'code' => 'PYN',
        'name' => 'P\\&#39;yongan-namdo',
      ),
      9 => 
      array (
        'code' => 'YAN',
        'name' => 'Ryanggang-do (Yanggang-do)',
      ),
      10 => 
      array (
        'code' => 'NAJ',
        'name' => 'Rason Directly Governed City',
      ),
      11 => 
      array (
        'code' => 'PYO',
        'name' => 'P&#39;yongyang Special City',
      ),
    ),
    'KR' => 
    array (
      1 => 
      array (
        'code' => 'CO',
        'name' => 'Ch&#39;ungch&#39;ong-bukto',
      ),
      2 => 
      array (
        'code' => 'CH',
        'name' => 'Ch&#39;ungch&#39;ong-namdo',
      ),
      3 => 
      array (
        'code' => 'CD',
        'name' => 'Cheju-do',
      ),
      4 => 
      array (
        'code' => 'CB',
        'name' => 'Cholla-bukto',
      ),
      5 => 
      array (
        'code' => 'CN',
        'name' => 'Cholla-namdo',
      ),
      6 => 
      array (
        'code' => 'IG',
        'name' => 'Inch&#39;on-gwangyoksi',
      ),
      7 => 
      array (
        'code' => 'KA',
        'name' => 'Kangwon-do',
      ),
      8 => 
      array (
        'code' => 'KG',
        'name' => 'Kwangju-gwangyoksi',
      ),
      9 => 
      array (
        'code' => 'KD',
        'name' => 'Kyonggi-do',
      ),
      10 => 
      array (
        'code' => 'KB',
        'name' => 'Kyongsang-bukto',
      ),
      11 => 
      array (
        'code' => 'KN',
        'name' => 'Kyongsang-namdo',
      ),
      12 => 
      array (
        'code' => 'PG',
        'name' => 'Pusan-gwangyoksi',
      ),
      13 => 
      array (
        'code' => 'SO',
        'name' => 'Soul-t&#39;ukpyolsi',
      ),
      14 => 
      array (
        'code' => 'TA',
        'name' => 'Taegu-gwangyoksi',
      ),
      15 => 
      array (
        'code' => 'TG',
        'name' => 'Taejon-gwangyoksi',
      ),
    ),
    'KW' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Al&#39;Asimah',
      ),
      2 => 
      array (
        'code' => 'AA',
        'name' => 'Al Ahmadi',
      ),
      3 => 
      array (
        'code' => 'AF',
        'name' => 'Al Farwaniyah',
      ),
      4 => 
      array (
        'code' => 'AJ',
        'name' => 'Al Jahra&#39;',
      ),
      5 => 
      array (
        'code' => 'HA',
        'name' => 'Hawalli',
      ),
    ),
    'KY' => 
    array (
      1 => 
      array (
        'code' => 'CR',
        'name' => 'Creek',
      ),
      2 => 
      array (
        'code' => 'EA',
        'name' => 'Eastern',
      ),
      3 => 
      array (
        'code' => 'ML',
        'name' => 'Midland',
      ),
      4 => 
      array (
        'code' => 'ST',
        'name' => 'South Town',
      ),
      5 => 
      array (
        'code' => 'SP',
        'name' => 'Spot Bay',
      ),
      6 => 
      array (
        'code' => 'SK',
        'name' => 'Stake Bay',
      ),
      7 => 
      array (
        'code' => 'WD',
        'name' => 'West End',
      ),
      8 => 
      array (
        'code' => 'WN',
        'name' => 'Western',
      ),
    ),
    'KZ' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Almaty',
      ),
      2 => 
      array (
        'code' => 'AC',
        'name' => 'Almaty City',
      ),
      3 => 
      array (
        'code' => 'AM',
        'name' => 'Aqmola',
      ),
      4 => 
      array (
        'code' => 'AQ',
        'name' => 'Aqtobe',
      ),
      5 => 
      array (
        'code' => 'AS',
        'name' => 'Astana City',
      ),
      6 => 
      array (
        'code' => 'AT',
        'name' => 'Atyrau',
      ),
      7 => 
      array (
        'code' => 'BA',
        'name' => 'Batys Qazaqstan',
      ),
      8 => 
      array (
        'code' => 'BY',
        'name' => 'Bayqongyr City',
      ),
      9 => 
      array (
        'code' => 'MA',
        'name' => 'Mangghystau',
      ),
      10 => 
      array (
        'code' => 'ON',
        'name' => 'Ongtustik Qazaqstan',
      ),
      11 => 
      array (
        'code' => 'PA',
        'name' => 'Pavlodar',
      ),
      12 => 
      array (
        'code' => 'QA',
        'name' => 'Qaraghandy',
      ),
      13 => 
      array (
        'code' => 'QO',
        'name' => 'Qostanay',
      ),
      14 => 
      array (
        'code' => 'QY',
        'name' => 'Qyzylorda',
      ),
      15 => 
      array (
        'code' => 'SH',
        'name' => 'Shyghys Qazaqstan',
      ),
      16 => 
      array (
        'code' => 'SO',
        'name' => 'Soltustik Qazaqstan',
      ),
      17 => 
      array (
        'code' => 'ZH',
        'name' => 'Zhambyl',
      ),
    ),
    'LA' => 
    array (
      1 => 
      array (
        'code' => 'VT',
        'name' => 'Vientiane',
      ),
      2 => 
      array (
        'code' => 'AT',
        'name' => 'Attapu',
      ),
      3 => 
      array (
        'code' => 'BK',
        'name' => 'Bokeo',
      ),
      4 => 
      array (
        'code' => 'BL',
        'name' => 'Bolikhamxai',
      ),
      5 => 
      array (
        'code' => 'CH',
        'name' => 'Champasak',
      ),
      6 => 
      array (
        'code' => 'HO',
        'name' => 'Houaphan',
      ),
      7 => 
      array (
        'code' => 'KH',
        'name' => 'Khammouan',
      ),
      8 => 
      array (
        'code' => 'LM',
        'name' => 'Louang Namtha',
      ),
      9 => 
      array (
        'code' => 'LP',
        'name' => 'Louangphabang',
      ),
      10 => 
      array (
        'code' => 'OU',
        'name' => 'Oudomxai',
      ),
      11 => 
      array (
        'code' => 'PH',
        'name' => 'Phongsali',
      ),
      12 => 
      array (
        'code' => 'SL',
        'name' => 'Salavan',
      ),
      13 => 
      array (
        'code' => 'SV',
        'name' => 'Savannakhet',
      ),
      14 => 
      array (
        'code' => 'VI',
        'name' => 'Vientiane',
      ),
      15 => 
      array (
        'code' => 'XA',
        'name' => 'Xaignabouli',
      ),
      16 => 
      array (
        'code' => 'XE',
        'name' => 'Xekong',
      ),
      17 => 
      array (
        'code' => 'XI',
        'name' => 'Xiangkhoang',
      ),
      18 => 
      array (
        'code' => 'XN',
        'name' => 'Xaisomboun',
      ),
    ),
    'LB' => 
    array (
      1 => 
      array (
        'code' => 'BIN',
        'name' => 'Bint Jbeil',
      ),
      2 => 
      array (
        'code' => 'HAS',
        'name' => 'Hasbaya',
      ),
      3 => 
      array (
        'code' => 'MAR',
        'name' => 'Marjeyoun',
      ),
      4 => 
      array (
        'code' => 'NAB',
        'name' => 'Nabatieh',
      ),
      5 => 
      array (
        'code' => 'BAA',
        'name' => 'Baalbek',
      ),
      6 => 
      array (
        'code' => 'HER',
        'name' => 'Hermel',
      ),
      7 => 
      array (
        'code' => 'RAS',
        'name' => 'Rashaya',
      ),
      8 => 
      array (
        'code' => 'WES',
        'name' => 'Western Beqaa',
      ),
      9 => 
      array (
        'code' => 'ZAH',
        'name' => 'Zahle',
      ),
      10 => 
      array (
        'code' => 'AKK',
        'name' => 'Akkar',
      ),
      11 => 
      array (
        'code' => 'BAT',
        'name' => 'Batroun',
      ),
      12 => 
      array (
        'code' => 'BSH',
        'name' => 'Bsharri',
      ),
      13 => 
      array (
        'code' => 'KOU',
        'name' => 'Koura',
      ),
      14 => 
      array (
        'code' => 'MIN',
        'name' => 'Miniyeh-Danniyeh',
      ),
      15 => 
      array (
        'code' => 'TRI',
        'name' => 'Tripoli',
      ),
      16 => 
      array (
        'code' => 'ZGH',
        'name' => 'Zgharta',
      ),
      17 => 
      array (
        'code' => 'ALE',
        'name' => 'Aley',
      ),
      18 => 
      array (
        'code' => 'BAA',
        'name' => 'Baabda',
      ),
      19 => 
      array (
        'code' => 'BYB',
        'name' => 'Byblos',
      ),
      20 => 
      array (
        'code' => 'CHO',
        'name' => 'Chouf',
      ),
      21 => 
      array (
        'code' => 'KES',
        'name' => 'Kesrwan',
      ),
      22 => 
      array (
        'code' => 'MAT',
        'name' => 'Matn',
      ),
      23 => 
      array (
        'code' => 'JEZ',
        'name' => 'Jezzine',
      ),
      24 => 
      array (
        'code' => 'SID',
        'name' => 'Sidon',
      ),
      25 => 
      array (
        'code' => 'TYR',
        'name' => 'Tyre',
      ),
    ),
    'LC' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => 'Anse-la-Raye',
      ),
      2 => 
      array (
        'code' => 'CA',
        'name' => 'Castries',
      ),
      3 => 
      array (
        'code' => 'CH',
        'name' => 'Choiseul',
      ),
      4 => 
      array (
        'code' => 'DA',
        'name' => 'Dauphin',
      ),
      5 => 
      array (
        'code' => 'DE',
        'name' => 'Dennery',
      ),
      6 => 
      array (
        'code' => 'GI',
        'name' => 'Gros-Islet',
      ),
      7 => 
      array (
        'code' => 'LA',
        'name' => 'Laborie',
      ),
      8 => 
      array (
        'code' => 'MI',
        'name' => 'Micoud',
      ),
      9 => 
      array (
        'code' => 'PR',
        'name' => 'Praslin',
      ),
      10 => 
      array (
        'code' => 'SO',
        'name' => 'Soufriere',
      ),
      11 => 
      array (
        'code' => 'VF',
        'name' => 'Vieux-Fort',
      ),
    ),
    'LI' => 
    array (
      1 => 
      array (
        'code' => 'V',
        'name' => 'Vaduz',
      ),
      2 => 
      array (
        'code' => 'A',
        'name' => 'Schaan',
      ),
      3 => 
      array (
        'code' => 'B',
        'name' => 'Balzers',
      ),
      4 => 
      array (
        'code' => 'N',
        'name' => 'Triesen',
      ),
      5 => 
      array (
        'code' => 'E',
        'name' => 'Eschen',
      ),
      6 => 
      array (
        'code' => 'M',
        'name' => 'Mauren',
      ),
      7 => 
      array (
        'code' => 'T',
        'name' => 'Triesenberg',
      ),
      8 => 
      array (
        'code' => 'R',
        'name' => 'Ruggell',
      ),
      9 => 
      array (
        'code' => 'G',
        'name' => 'Gamprin',
      ),
      10 => 
      array (
        'code' => 'L',
        'name' => 'Schellenberg',
      ),
      11 => 
      array (
        'code' => 'P',
        'name' => 'Planken',
      ),
    ),
    'LK' => 
    array (
      1 => 
      array (
        'code' => 'CE',
        'name' => 'Central',
      ),
      2 => 
      array (
        'code' => 'EA',
        'name' => 'Eastern',
      ),
      3 => 
      array (
        'code' => 'NC',
        'name' => 'North Central',
      ),
      4 => 
      array (
        'code' => 'NO',
        'name' => 'Northern',
      ),
      5 => 
      array (
        'code' => 'NW',
        'name' => 'North Western',
      ),
      6 => 
      array (
        'code' => 'SA',
        'name' => 'Sabaragamuwa',
      ),
      7 => 
      array (
        'code' => 'SO',
        'name' => 'Southern',
      ),
      8 => 
      array (
        'code' => 'UV',
        'name' => 'Uva',
      ),
      9 => 
      array (
        'code' => 'WE',
        'name' => 'Western',
      ),
    ),
    'LR' => 
    array (
      1 => 
      array (
        'code' => 'BI',
        'name' => 'Bomi',
      ),
      2 => 
      array (
        'code' => 'BG',
        'name' => 'Bong',
      ),
      3 => 
      array (
        'code' => 'GB',
        'name' => 'Grand Bassa',
      ),
      4 => 
      array (
        'code' => 'CM',
        'name' => 'Grand Cape Mount',
      ),
      5 => 
      array (
        'code' => 'GG',
        'name' => 'Grand Gedeh',
      ),
      6 => 
      array (
        'code' => 'GK',
        'name' => 'Grand Kru',
      ),
      7 => 
      array (
        'code' => 'LO',
        'name' => 'Lofa',
      ),
      8 => 
      array (
        'code' => 'MG',
        'name' => 'Margibi',
      ),
      9 => 
      array (
        'code' => 'ML',
        'name' => 'Maryland',
      ),
      10 => 
      array (
        'code' => 'MS',
        'name' => 'Montserrado',
      ),
      11 => 
      array (
        'code' => 'NB',
        'name' => 'Nimba',
      ),
      12 => 
      array (
        'code' => 'RC',
        'name' => 'River Cess',
      ),
      13 => 
      array (
        'code' => 'SN',
        'name' => 'Sinoe',
      ),
    ),
    'LS' => 
    array (
      1 => 
      array (
        'code' => 'BE',
        'name' => 'Berea',
      ),
      2 => 
      array (
        'code' => 'BB',
        'name' => 'Butha-Buthe',
      ),
      3 => 
      array (
        'code' => 'LE',
        'name' => 'Leribe',
      ),
      4 => 
      array (
        'code' => 'MF',
        'name' => 'Mafeteng',
      ),
      5 => 
      array (
        'code' => 'MS',
        'name' => 'Maseru',
      ),
      6 => 
      array (
        'code' => 'MH',
        'name' => 'Mohale&#39;s Hoek',
      ),
      7 => 
      array (
        'code' => 'MK',
        'name' => 'Mokhotlong',
      ),
      8 => 
      array (
        'code' => 'QN',
        'name' => 'Qacha&#39;s Nek',
      ),
      9 => 
      array (
        'code' => 'QT',
        'name' => 'Quthing',
      ),
      10 => 
      array (
        'code' => 'TT',
        'name' => 'Thaba-Tseka',
      ),
    ),
    'LT' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Alytus',
      ),
      2 => 
      array (
        'code' => 'KA',
        'name' => 'Kaunas',
      ),
      3 => 
      array (
        'code' => 'KL',
        'name' => 'Klaipeda',
      ),
      4 => 
      array (
        'code' => 'MA',
        'name' => 'Marijampole',
      ),
      5 => 
      array (
        'code' => 'PA',
        'name' => 'Panevezys',
      ),
      6 => 
      array (
        'code' => 'SI',
        'name' => 'Siauliai',
      ),
      7 => 
      array (
        'code' => 'TA',
        'name' => 'Taurage',
      ),
      8 => 
      array (
        'code' => 'TE',
        'name' => 'Telsiai',
      ),
      9 => 
      array (
        'code' => 'UT',
        'name' => 'Utena',
      ),
      10 => 
      array (
        'code' => 'VI',
        'name' => 'Vilnius',
      ),
    ),
    'LU' => 
    array (
      1 => 
      array (
        'code' => 'DD',
        'name' => 'Diekirch',
      ),
      2 => 
      array (
        'code' => 'DC',
        'name' => 'Clervaux',
      ),
      3 => 
      array (
        'code' => 'DR',
        'name' => 'Redange',
      ),
      4 => 
      array (
        'code' => 'DV',
        'name' => 'Vianden',
      ),
      5 => 
      array (
        'code' => 'DW',
        'name' => 'Wiltz',
      ),
      6 => 
      array (
        'code' => 'GG',
        'name' => 'Grevenmacher',
      ),
      7 => 
      array (
        'code' => 'GE',
        'name' => 'Echternach',
      ),
      8 => 
      array (
        'code' => 'GR',
        'name' => 'Remich',
      ),
      9 => 
      array (
        'code' => 'LL',
        'name' => 'Luxembourg',
      ),
      10 => 
      array (
        'code' => 'LC',
        'name' => 'Capellen',
      ),
      11 => 
      array (
        'code' => 'LE',
        'name' => 'Esch-sur-Alzette',
      ),
      12 => 
      array (
        'code' => 'LM',
        'name' => 'Mersch',
      ),
    ),
    'LV' => 
    array (
      1 => 
      array (
        'code' => 'AIZ',
        'name' => 'Aizkraukles Rajons',
      ),
      2 => 
      array (
        'code' => 'ALU',
        'name' => 'Aluksnes Rajons',
      ),
      3 => 
      array (
        'code' => 'BAL',
        'name' => 'Balvu Rajons',
      ),
      4 => 
      array (
        'code' => 'BAU',
        'name' => 'Bauskas Rajons',
      ),
      5 => 
      array (
        'code' => 'CES',
        'name' => 'Cesu Rajons',
      ),
      6 => 
      array (
        'code' => 'DGR',
        'name' => 'Daugavpils Rajons',
      ),
      7 => 
      array (
        'code' => 'DOB',
        'name' => 'Dobeles Rajons',
      ),
      8 => 
      array (
        'code' => 'GUL',
        'name' => 'Gulbenes Rajons',
      ),
      9 => 
      array (
        'code' => 'JEK',
        'name' => 'Jekabpils Rajons',
      ),
      10 => 
      array (
        'code' => 'JGR',
        'name' => 'Jelgavas Rajons',
      ),
      11 => 
      array (
        'code' => 'KRA',
        'name' => 'Kraslavas Rajons',
      ),
      12 => 
      array (
        'code' => 'KUL',
        'name' => 'Kuldigas Rajons',
      ),
      13 => 
      array (
        'code' => 'LPR',
        'name' => 'Liepajas Rajons',
      ),
      14 => 
      array (
        'code' => 'LIM',
        'name' => 'Limbazu Rajons',
      ),
      15 => 
      array (
        'code' => 'LUD',
        'name' => 'Ludzas Rajons',
      ),
      16 => 
      array (
        'code' => 'MAD',
        'name' => 'Madonas Rajons',
      ),
      17 => 
      array (
        'code' => 'OGR',
        'name' => 'Ogres Rajons',
      ),
      18 => 
      array (
        'code' => 'PRE',
        'name' => 'Preilu Rajons',
      ),
      19 => 
      array (
        'code' => 'RZR',
        'name' => 'Rezeknes Rajons',
      ),
      20 => 
      array (
        'code' => 'RGR',
        'name' => 'Rigas Rajons',
      ),
      21 => 
      array (
        'code' => 'SAL',
        'name' => 'Saldus Rajons',
      ),
      22 => 
      array (
        'code' => 'TAL',
        'name' => 'Talsu Rajons',
      ),
      23 => 
      array (
        'code' => 'TUK',
        'name' => 'Tukuma Rajons',
      ),
      24 => 
      array (
        'code' => 'VLK',
        'name' => 'Valkas Rajons',
      ),
      25 => 
      array (
        'code' => 'VLM',
        'name' => 'Valmieras Rajons',
      ),
      26 => 
      array (
        'code' => 'VSR',
        'name' => 'Ventspils Rajons',
      ),
      27 => 
      array (
        'code' => 'DGV',
        'name' => 'Daugavpils',
      ),
      28 => 
      array (
        'code' => 'JGV',
        'name' => 'Jelgava',
      ),
      29 => 
      array (
        'code' => 'JUR',
        'name' => 'Jurmala',
      ),
      30 => 
      array (
        'code' => 'LPK',
        'name' => 'Liepaja',
      ),
      31 => 
      array (
        'code' => 'RZK',
        'name' => 'Rezekne',
      ),
      32 => 
      array (
        'code' => 'RGA',
        'name' => 'Riga',
      ),
      33 => 
      array (
        'code' => 'VSL',
        'name' => 'Ventspils',
      ),
    ),
    'LY' => 
    array (
      1 => 
      array (
        'code' => 'AJ',
        'name' => 'Ajdabiya',
      ),
      2 => 
      array (
        'code' => 'AZ',
        'name' => 'Al &#39;Aziziyah',
      ),
      3 => 
      array (
        'code' => 'FA',
        'name' => 'Al Fatih',
      ),
      4 => 
      array (
        'code' => 'JA',
        'name' => 'Al Jabal al Akhdar',
      ),
      5 => 
      array (
        'code' => 'JU',
        'name' => 'Al Jufrah',
      ),
      6 => 
      array (
        'code' => 'KH',
        'name' => 'Al Khums',
      ),
      7 => 
      array (
        'code' => 'KU',
        'name' => 'Al Kufrah',
      ),
      8 => 
      array (
        'code' => 'NK',
        'name' => 'An Nuqat al Khams',
      ),
      9 => 
      array (
        'code' => 'AS',
        'name' => 'Ash Shati&#39;',
      ),
      10 => 
      array (
        'code' => 'AW',
        'name' => 'Awbari',
      ),
      11 => 
      array (
        'code' => 'ZA',
        'name' => 'Az Zawiyah',
      ),
      12 => 
      array (
        'code' => 'BA',
        'name' => 'Banghazi',
      ),
      13 => 
      array (
        'code' => 'DA',
        'name' => 'Darnah',
      ),
      14 => 
      array (
        'code' => 'GD',
        'name' => 'Ghadamis',
      ),
      15 => 
      array (
        'code' => 'GY',
        'name' => 'Gharyan',
      ),
      16 => 
      array (
        'code' => 'MI',
        'name' => 'Misratah',
      ),
      17 => 
      array (
        'code' => 'MZ',
        'name' => 'Murzuq',
      ),
      18 => 
      array (
        'code' => 'SB',
        'name' => 'Sabha',
      ),
      19 => 
      array (
        'code' => 'SW',
        'name' => 'Sawfajjin',
      ),
      20 => 
      array (
        'code' => 'SU',
        'name' => 'Surt',
      ),
      21 => 
      array (
        'code' => 'TL',
        'name' => 'Tarabulus (Tripoli)',
      ),
      22 => 
      array (
        'code' => 'TH',
        'name' => 'Tarhunah',
      ),
      23 => 
      array (
        'code' => 'TU',
        'name' => 'Tubruq',
      ),
      24 => 
      array (
        'code' => 'YA',
        'name' => 'Yafran',
      ),
      25 => 
      array (
        'code' => 'ZL',
        'name' => 'Zlitan',
      ),
    ),
    'MA' => 
    array (
      1 => 
      array (
        'code' => 'AGD',
        'name' => 'Agadir',
      ),
      2 => 
      array (
        'code' => 'HOC',
        'name' => 'Al Hoceima',
      ),
      3 => 
      array (
        'code' => 'AZI',
        'name' => 'Azilal',
      ),
      4 => 
      array (
        'code' => 'BME',
        'name' => 'Beni Mellal',
      ),
      5 => 
      array (
        'code' => 'BSL',
        'name' => 'Ben Slimane',
      ),
      6 => 
      array (
        'code' => 'BLM',
        'name' => 'Boulemane',
      ),
      7 => 
      array (
        'code' => 'CBL',
        'name' => 'Casablanca',
      ),
      8 => 
      array (
        'code' => 'CHA',
        'name' => 'Chaouen',
      ),
      9 => 
      array (
        'code' => 'EJA',
        'name' => 'El Jadida',
      ),
      10 => 
      array (
        'code' => 'EKS',
        'name' => 'El Kelaa des Sraghna',
      ),
      11 => 
      array (
        'code' => 'ERA',
        'name' => 'Er Rachidia',
      ),
      12 => 
      array (
        'code' => 'ESS',
        'name' => 'Essaouira',
      ),
      13 => 
      array (
        'code' => 'FES',
        'name' => 'Fes',
      ),
      14 => 
      array (
        'code' => 'FIG',
        'name' => 'Figuig',
      ),
      15 => 
      array (
        'code' => 'GLM',
        'name' => 'Guelmim',
      ),
      16 => 
      array (
        'code' => 'IFR',
        'name' => 'Ifrane',
      ),
      17 => 
      array (
        'code' => 'KEN',
        'name' => 'Kenitra',
      ),
      18 => 
      array (
        'code' => 'KHM',
        'name' => 'Khemisset',
      ),
      19 => 
      array (
        'code' => 'KHN',
        'name' => 'Khenifra',
      ),
      20 => 
      array (
        'code' => 'KHO',
        'name' => 'Khouribga',
      ),
      21 => 
      array (
        'code' => 'LYN',
        'name' => 'Laayoune',
      ),
      22 => 
      array (
        'code' => 'LAR',
        'name' => 'Larache',
      ),
      23 => 
      array (
        'code' => 'MRK',
        'name' => 'Marrakech',
      ),
      24 => 
      array (
        'code' => 'MKN',
        'name' => 'Meknes',
      ),
      25 => 
      array (
        'code' => 'NAD',
        'name' => 'Nador',
      ),
      26 => 
      array (
        'code' => 'ORZ',
        'name' => 'Ouarzazate',
      ),
      27 => 
      array (
        'code' => 'OUJ',
        'name' => 'Oujda',
      ),
      28 => 
      array (
        'code' => 'RSA',
        'name' => 'Rabat-Sale',
      ),
      29 => 
      array (
        'code' => 'SAF',
        'name' => 'Safi',
      ),
      30 => 
      array (
        'code' => 'SET',
        'name' => 'Settat',
      ),
      31 => 
      array (
        'code' => 'SKA',
        'name' => 'Sidi Kacem',
      ),
      32 => 
      array (
        'code' => 'TGR',
        'name' => 'Tangier',
      ),
      33 => 
      array (
        'code' => 'TAN',
        'name' => 'Tan-Tan',
      ),
      34 => 
      array (
        'code' => 'TAO',
        'name' => 'Taounate',
      ),
      35 => 
      array (
        'code' => 'TRD',
        'name' => 'Taroudannt',
      ),
      36 => 
      array (
        'code' => 'TAT',
        'name' => 'Tata',
      ),
      37 => 
      array (
        'code' => 'TAZ',
        'name' => 'Taza',
      ),
      38 => 
      array (
        'code' => 'TET',
        'name' => 'Tetouan',
      ),
      39 => 
      array (
        'code' => 'TIZ',
        'name' => 'Tiznit',
      ),
      40 => 
      array (
        'code' => 'ADK',
        'name' => 'Ad Dakhla',
      ),
      41 => 
      array (
        'code' => 'BJD',
        'name' => 'Boujdour',
      ),
      42 => 
      array (
        'code' => 'ESM',
        'name' => 'Es Smara',
      ),
    ),
    'MC' => 
    array (
      1 => 
      array (
        'code' => 'FV',
        'name' => 'Fontvieille',
      ),
      2 => 
      array (
        'code' => 'LC',
        'name' => 'La Condamine',
      ),
      3 => 
      array (
        'code' => 'MV',
        'name' => 'Monaco-Ville',
      ),
      4 => 
      array (
        'code' => 'MC',
        'name' => 'Monte-Carlo',
      ),
    ),
    'MD' => 
    array (
      1 => 
      array (
        'code' => 'GA',
        'name' => 'Gagauzia',
      ),
      2 => 
      array (
        'code' => 'CU',
        'name' => 'Chisinau',
      ),
      3 => 
      array (
        'code' => 'BA',
        'name' => 'Balti',
      ),
      4 => 
      array (
        'code' => 'CA',
        'name' => 'Cahul',
      ),
      5 => 
      array (
        'code' => 'ED',
        'name' => 'Edinet',
      ),
      6 => 
      array (
        'code' => 'LA',
        'name' => 'Lapusna',
      ),
      7 => 
      array (
        'code' => 'OR',
        'name' => 'Orhei',
      ),
      8 => 
      array (
        'code' => 'SO',
        'name' => 'Soroca',
      ),
      9 => 
      array (
        'code' => 'TI',
        'name' => 'Tighina',
      ),
      10 => 
      array (
        'code' => 'UN',
        'name' => 'Ungheni',
      ),
      11 => 
      array (
        'code' => 'SN',
        'name' => 'Stânga Nistrului',
      ),
    ),
    'MG' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Antananarivo',
      ),
      2 => 
      array (
        'code' => 'AS',
        'name' => 'Antsiranana',
      ),
      3 => 
      array (
        'code' => 'FN',
        'name' => 'Fianarantsoa',
      ),
      4 => 
      array (
        'code' => 'MJ',
        'name' => 'Mahajanga',
      ),
      5 => 
      array (
        'code' => 'TM',
        'name' => 'Toamasina',
      ),
      6 => 
      array (
        'code' => 'TL',
        'name' => 'Toliara',
      ),
    ),
    'MH' => 
    array (
      1 => 
      array (
        'code' => 'ALG',
        'name' => 'Ailinginae',
      ),
      2 => 
      array (
        'code' => 'ALL',
        'name' => 'Ailinglaplap',
      ),
      3 => 
      array (
        'code' => 'ALK',
        'name' => 'Ailuk',
      ),
      4 => 
      array (
        'code' => 'ARN',
        'name' => 'Arno',
      ),
      5 => 
      array (
        'code' => 'AUR',
        'name' => 'Aur',
      ),
      6 => 
      array (
        'code' => 'BKR',
        'name' => 'Bikar',
      ),
      7 => 
      array (
        'code' => 'BKN',
        'name' => 'Bikini',
      ),
      8 => 
      array (
        'code' => 'BKK',
        'name' => 'Bokak',
      ),
      9 => 
      array (
        'code' => 'EBN',
        'name' => 'Ebon',
      ),
      10 => 
      array (
        'code' => 'ENT',
        'name' => 'Enewetak',
      ),
      11 => 
      array (
        'code' => 'EKB',
        'name' => 'Erikub',
      ),
      12 => 
      array (
        'code' => 'JBT',
        'name' => 'Jabat',
      ),
      13 => 
      array (
        'code' => 'JLT',
        'name' => 'Jaluit',
      ),
      14 => 
      array (
        'code' => 'JEM',
        'name' => 'Jemo',
      ),
      15 => 
      array (
        'code' => 'KIL',
        'name' => 'Kili',
      ),
      16 => 
      array (
        'code' => 'KWJ',
        'name' => 'Kwajalein',
      ),
      17 => 
      array (
        'code' => 'LAE',
        'name' => 'Lae',
      ),
      18 => 
      array (
        'code' => 'LIB',
        'name' => 'Lib',
      ),
      19 => 
      array (
        'code' => 'LKP',
        'name' => 'Likiep',
      ),
      20 => 
      array (
        'code' => 'MJR',
        'name' => 'Majuro',
      ),
      21 => 
      array (
        'code' => 'MLP',
        'name' => 'Maloelap',
      ),
      22 => 
      array (
        'code' => 'MJT',
        'name' => 'Mejit',
      ),
      23 => 
      array (
        'code' => 'MIL',
        'name' => 'Mili',
      ),
      24 => 
      array (
        'code' => 'NMK',
        'name' => 'Namorik',
      ),
      25 => 
      array (
        'code' => 'NAM',
        'name' => 'Namu',
      ),
      26 => 
      array (
        'code' => 'RGL',
        'name' => 'Rongelap',
      ),
      27 => 
      array (
        'code' => 'RGK',
        'name' => 'Rongrik',
      ),
      28 => 
      array (
        'code' => 'TOK',
        'name' => 'Toke',
      ),
      29 => 
      array (
        'code' => 'UJA',
        'name' => 'Ujae',
      ),
      30 => 
      array (
        'code' => 'UJL',
        'name' => 'Ujelang',
      ),
      31 => 
      array (
        'code' => 'UTK',
        'name' => 'Utirik',
      ),
      32 => 
      array (
        'code' => 'WTH',
        'name' => 'Wotho',
      ),
      33 => 
      array (
        'code' => 'WTJ',
        'name' => 'Wotje',
      ),
    ),
    'MK' => 
    array (
      1 => 
      array (
        'code' => 'AER',
        'name' => 'Aerodrom',
      ),
      2 => 
      array (
        'code' => 'ARA',
        'name' => 'Aračinovo',
      ),
      3 => 
      array (
        'code' => 'BER',
        'name' => 'Berovo',
      ),
      4 => 
      array (
        'code' => 'BIT',
        'name' => 'Bitola',
      ),
      5 => 
      array (
        'code' => 'BOG',
        'name' => 'Bogdanci',
      ),
      6 => 
      array (
        'code' => 'BOG',
        'name' => 'Bogovinje',
      ),
      7 => 
      array (
        'code' => 'BOS',
        'name' => 'Bosilovo',
      ),
      8 => 
      array (
        'code' => 'BRV',
        'name' => 'Brvenica',
      ),
      9 => 
      array (
        'code' => 'BUT',
        'name' => 'Butel',
      ),
      10 => 
      array (
        'code' => 'ČAI',
        'name' => 'Čair',
      ),
      11 => 
      array (
        'code' => 'ČAš',
        'name' => 'Čaška',
      ),
      12 => 
      array (
        'code' => 'CEN',
        'name' => 'Centar',
      ),
      13 => 
      array (
        'code' => 'CEN',
        'name' => 'Centar Župa',
      ),
      14 => 
      array (
        'code' => 'Češ',
        'name' => 'Češinovo-Obleš',
      ),
      15 => 
      array (
        'code' => 'ČUČ',
        'name' => 'Čučer-Sandevo',
      ),
      16 => 
      array (
        'code' => 'DEB',
        'name' => 'Debar',
      ),
      17 => 
      array (
        'code' => 'DEB',
        'name' => 'Debarca',
      ),
      18 => 
      array (
        'code' => 'DEL',
        'name' => 'Delčevo',
      ),
      19 => 
      array (
        'code' => 'DEM',
        'name' => 'Demir Hisar',
      ),
      20 => 
      array (
        'code' => 'DEM',
        'name' => 'Demir Kapija',
      ),
      21 => 
      array (
        'code' => 'DOL',
        'name' => 'Dolneni',
      ),
      22 => 
      array (
        'code' => 'DRU',
        'name' => 'Drugovo',
      ),
      23 => 
      array (
        'code' => 'GAZ',
        'name' => 'Gazi Baba',
      ),
      24 => 
      array (
        'code' => 'GEV',
        'name' => 'Gevgelija',
      ),
      25 => 
      array (
        'code' => 'GJO',
        'name' => 'Gjorče Petrov',
      ),
      26 => 
      array (
        'code' => 'GOS',
        'name' => 'Gostivar',
      ),
      27 => 
      array (
        'code' => 'GRA',
        'name' => 'Gradsko',
      ),
      28 => 
      array (
        'code' => 'ILI',
        'name' => 'Ilinden',
      ),
      29 => 
      array (
        'code' => 'JEG',
        'name' => 'Jegunovce',
      ),
      30 => 
      array (
        'code' => 'KAR',
        'name' => 'Karbinci',
      ),
      31 => 
      array (
        'code' => 'KAR',
        'name' => 'Karpoš',
      ),
      32 => 
      array (
        'code' => 'KAV',
        'name' => 'Kavadarci',
      ),
      33 => 
      array (
        'code' => 'KIČ',
        'name' => 'Kičevo',
      ),
      34 => 
      array (
        'code' => 'KIS',
        'name' => 'Kisela Voda',
      ),
      35 => 
      array (
        'code' => 'KOč',
        'name' => 'Kočani',
      ),
      36 => 
      array (
        'code' => 'KON',
        'name' => 'Konče',
      ),
      37 => 
      array (
        'code' => 'KRA',
        'name' => 'Kratovo',
      ),
      38 => 
      array (
        'code' => 'KRI',
        'name' => 'Kriva Palanka',
      ),
      39 => 
      array (
        'code' => 'KRI',
        'name' => 'Krivogaštani',
      ),
      40 => 
      array (
        'code' => 'KRU',
        'name' => 'Kruševo',
      ),
      41 => 
      array (
        'code' => 'KUM',
        'name' => 'Kumanovo',
      ),
      42 => 
      array (
        'code' => 'LIP',
        'name' => 'Lipkovo',
      ),
      43 => 
      array (
        'code' => 'LOZ',
        'name' => 'Lozovo',
      ),
      44 => 
      array (
        'code' => 'MAK',
        'name' => 'Makedonska Kamenica',
      ),
      45 => 
      array (
        'code' => 'MAK',
        'name' => 'Makedonski Brod',
      ),
      46 => 
      array (
        'code' => 'MAV',
        'name' => 'Mavrovo and Rostuša',
      ),
      47 => 
      array (
        'code' => 'MOG',
        'name' => 'Mogila',
      ),
      48 => 
      array (
        'code' => 'NEG',
        'name' => 'Negotino',
      ),
      49 => 
      array (
        'code' => 'NOV',
        'name' => 'Novaci',
      ),
      50 => 
      array (
        'code' => 'NOV',
        'name' => 'Novo Selo',
      ),
      51 => 
      array (
        'code' => 'OHR',
        'name' => 'Ohrid',
      ),
      52 => 
      array (
        'code' => 'MD',
        'name' => 'Oslomej',
      ),
      53 => 
      array (
        'code' => 'PEH',
        'name' => 'Pehčevo',
      ),
      54 => 
      array (
        'code' => 'PET',
        'name' => 'Petrovec',
      ),
      55 => 
      array (
        'code' => 'PLA',
        'name' => 'Plasnica',
      ),
      56 => 
      array (
        'code' => 'PRI',
        'name' => 'Prilep',
      ),
      57 => 
      array (
        'code' => 'PRO',
        'name' => 'Probištip',
      ),
      58 => 
      array (
        'code' => 'RAD',
        'name' => 'Radoviš',
      ),
      59 => 
      array (
        'code' => 'RAN',
        'name' => 'Rankovce',
      ),
      60 => 
      array (
        'code' => 'RES',
        'name' => 'Resen',
      ),
      61 => 
      array (
        'code' => 'ROS',
        'name' => 'Rosoman',
      ),
      62 => 
      array (
        'code' => 'SAR',
        'name' => 'Saraj',
      ),
      63 => 
      array (
        'code' => 'SOP',
        'name' => 'Sopište',
      ),
      64 => 
      array (
        'code' => 'STA',
        'name' => 'Star Dojran',
      ),
      65 => 
      array (
        'code' => 'STA',
        'name' => 'Staro Nagoričane',
      ),
      66 => 
      array (
        'code' => 'ŠTI',
        'name' => 'Štip',
      ),
      67 => 
      array (
        'code' => 'STR',
        'name' => 'Struga',
      ),
      68 => 
      array (
        'code' => 'STR',
        'name' => 'Strumica',
      ),
      69 => 
      array (
        'code' => 'STU',
        'name' => 'Studeničani',
      ),
      70 => 
      array (
        'code' => 'ŠUT',
        'name' => 'Šuto Orizari',
      ),
      71 => 
      array (
        'code' => 'SVE',
        'name' => 'Sveti Nikole',
      ),
      72 => 
      array (
        'code' => 'TEA',
        'name' => 'Tearce',
      ),
      73 => 
      array (
        'code' => 'TET',
        'name' => 'Tetovo',
      ),
      74 => 
      array (
        'code' => 'VAL',
        'name' => 'Valandovo',
      ),
      75 => 
      array (
        'code' => 'VAS',
        'name' => 'Vasilevo',
      ),
      76 => 
      array (
        'code' => 'VEL',
        'name' => 'Veles',
      ),
      77 => 
      array (
        'code' => 'VEV',
        'name' => 'Vevčani',
      ),
      78 => 
      array (
        'code' => 'VIN',
        'name' => 'Vinica',
      ),
      79 => 
      array (
        'code' => 'VRA',
        'name' => 'Vraneštica',
      ),
      80 => 
      array (
        'code' => 'VRA',
        'name' => 'Vrapčište',
      ),
      81 => 
      array (
        'code' => 'ZAJ',
        'name' => 'Zajas',
      ),
      82 => 
      array (
        'code' => 'ZEL',
        'name' => 'Zelenikovo',
      ),
      83 => 
      array (
        'code' => 'ŽEL',
        'name' => 'Želino',
      ),
      84 => 
      array (
        'code' => 'ZRN',
        'name' => 'Zrnovci',
      ),
    ),
    'ML' => 
    array (
      1 => 
      array (
        'code' => 'GA',
        'name' => 'Gao',
      ),
      2 => 
      array (
        'code' => 'KY',
        'name' => 'Kayes',
      ),
      3 => 
      array (
        'code' => 'KD',
        'name' => 'Kidal',
      ),
      4 => 
      array (
        'code' => 'KL',
        'name' => 'Koulikoro',
      ),
      5 => 
      array (
        'code' => 'MP',
        'name' => 'Mopti',
      ),
      6 => 
      array (
        'code' => 'SG',
        'name' => 'Segou',
      ),
      7 => 
      array (
        'code' => 'SK',
        'name' => 'Sikasso',
      ),
      8 => 
      array (
        'code' => 'TB',
        'name' => 'Tombouctou',
      ),
      9 => 
      array (
        'code' => 'CD',
        'name' => 'Bamako Capital District',
      ),
    ),
    'MM' => 
    array (
      1 => 
      array (
        'code' => 'AY',
        'name' => 'Ayeyarwady',
      ),
      2 => 
      array (
        'code' => 'BG',
        'name' => 'Bago',
      ),
      3 => 
      array (
        'code' => 'MG',
        'name' => 'Magway',
      ),
      4 => 
      array (
        'code' => 'MD',
        'name' => 'Mandalay',
      ),
      5 => 
      array (
        'code' => 'SG',
        'name' => 'Sagaing',
      ),
      6 => 
      array (
        'code' => 'TN',
        'name' => 'Tanintharyi',
      ),
      7 => 
      array (
        'code' => 'YG',
        'name' => 'Yangon',
      ),
      8 => 
      array (
        'code' => 'CH',
        'name' => 'Chin State',
      ),
      9 => 
      array (
        'code' => 'KC',
        'name' => 'Kachin State',
      ),
      10 => 
      array (
        'code' => 'KH',
        'name' => 'Kayah State',
      ),
      11 => 
      array (
        'code' => 'KN',
        'name' => 'Kayin State',
      ),
      12 => 
      array (
        'code' => 'MN',
        'name' => 'Mon State',
      ),
      13 => 
      array (
        'code' => 'RK',
        'name' => 'Rakhine State',
      ),
      14 => 
      array (
        'code' => 'SH',
        'name' => 'Shan State',
      ),
    ),
    'MN' => 
    array (
      1 => 
      array (
        'code' => '1',
        'name' => 'Ulanbaatar',
      ),
      2 => 
      array (
        'code' => '035',
        'name' => 'Orhon',
      ),
      3 => 
      array (
        'code' => '037',
        'name' => 'Darhan uul',
      ),
      4 => 
      array (
        'code' => '039',
        'name' => 'Hentiy',
      ),
      5 => 
      array (
        'code' => '041',
        'name' => 'Hovsgol',
      ),
      6 => 
      array (
        'code' => '043',
        'name' => 'Hovd',
      ),
      7 => 
      array (
        'code' => '046',
        'name' => 'Uvs',
      ),
      8 => 
      array (
        'code' => '047',
        'name' => 'Tov',
      ),
      9 => 
      array (
        'code' => '049',
        'name' => 'Selenge',
      ),
      10 => 
      array (
        'code' => '051',
        'name' => 'Suhbaatar',
      ),
      11 => 
      array (
        'code' => '053',
        'name' => 'Omnogovi',
      ),
      12 => 
      array (
        'code' => '055',
        'name' => 'Ovorhangay',
      ),
      13 => 
      array (
        'code' => '057',
        'name' => 'Dzavhan',
      ),
      14 => 
      array (
        'code' => '059',
        'name' => 'DundgovL',
      ),
      15 => 
      array (
        'code' => '061',
        'name' => 'Dornod',
      ),
      16 => 
      array (
        'code' => '063',
        'name' => 'Dornogov',
      ),
      17 => 
      array (
        'code' => '064',
        'name' => 'Govi-Sumber',
      ),
      18 => 
      array (
        'code' => '065',
        'name' => 'Govi-Altay',
      ),
      19 => 
      array (
        'code' => '067',
        'name' => 'Bulgan',
      ),
      20 => 
      array (
        'code' => '069',
        'name' => 'Bayanhongor',
      ),
      21 => 
      array (
        'code' => '071',
        'name' => 'Bayan-Olgiy',
      ),
      22 => 
      array (
        'code' => '073',
        'name' => 'Arhangay',
      ),
    ),
    'MO' => 
    array (
      1 => 
      array (
        'code' => 'OLF',
        'name' => 'Our Lady Fatima Parish',
      ),
      2 => 
      array (
        'code' => 'ANT',
        'name' => 'St. Anthony Parish',
      ),
      3 => 
      array (
        'code' => 'LAZ',
        'name' => 'St. Lazarus Parish',
      ),
      4 => 
      array (
        'code' => 'CAT',
        'name' => 'Cathedral Parish',
      ),
      5 => 
      array (
        'code' => 'LAW',
        'name' => 'St. Lawrence Parish',
      ),
    ),
    'MP' => 
    array (
      1 => 
      array (
        'code' => 'N',
        'name' => 'Northern Islands',
      ),
      2 => 
      array (
        'code' => 'R',
        'name' => 'Rota',
      ),
      3 => 
      array (
        'code' => 'S',
        'name' => 'Saipan',
      ),
      4 => 
      array (
        'code' => 'T',
        'name' => 'Tinian',
      ),
    ),
    'MQ' => 
    array (
      1 => 
      array (
        'code' => 'LAJ',
        'name' => 'L&#39;Ajoupa-Bouillon',
      ),
      2 => 
      array (
        'code' => 'LES',
        'name' => 'Les Anses-d&#39;Arlet',
      ),
      3 => 
      array (
        'code' => 'BAS',
        'name' => 'Basse-Pointe',
      ),
      4 => 
      array (
        'code' => 'BEL',
        'name' => 'Bellefontaine',
      ),
      5 => 
      array (
        'code' => 'LE',
        'name' => 'Le Carbet',
      ),
      6 => 
      array (
        'code' => 'CAS',
        'name' => 'Case-Pilote',
      ),
      7 => 
      array (
        'code' => 'LE',
        'name' => 'Le Diamant',
      ),
      8 => 
      array (
        'code' => 'DUC',
        'name' => 'Ducos',
      ),
      9 => 
      array (
        'code' => 'FON',
        'name' => 'Fonds-Saint-Denis',
      ),
      10 => 
      array (
        'code' => 'FOR',
        'name' => 'Fort-De-France',
      ),
      11 => 
      array (
        'code' => 'LE',
        'name' => 'Le François',
      ),
      12 => 
      array (
        'code' => 'GRA',
        'name' => 'Grand&#39;Rivière',
      ),
      13 => 
      array (
        'code' => 'GRO',
        'name' => 'Gros-Morne',
      ),
      14 => 
      array (
        'code' => 'LE',
        'name' => 'Le Lamentin',
      ),
      15 => 
      array (
        'code' => 'LE',
        'name' => 'Le Lorrain',
      ),
      16 => 
      array (
        'code' => 'MAC',
        'name' => 'Macouba',
      ),
      17 => 
      array (
        'code' => 'LE',
        'name' => 'Le Marigot',
      ),
      18 => 
      array (
        'code' => 'LE',
        'name' => 'Le Marin',
      ),
      19 => 
      array (
        'code' => 'LE',
        'name' => 'Le Morne-Rouge',
      ),
      20 => 
      array (
        'code' => 'LE',
        'name' => 'Le Morne-Vert',
      ),
      21 => 
      array (
        'code' => 'LE',
        'name' => 'Le Prêcheur',
      ),
      22 => 
      array (
        'code' => 'RIV',
        'name' => 'Rivière-Pilote',
      ),
      23 => 
      array (
        'code' => 'RIV',
        'name' => 'Rivière-Salée',
      ),
      24 => 
      array (
        'code' => 'LE',
        'name' => 'Le Robert',
      ),
      25 => 
      array (
        'code' => 'SAI',
        'name' => 'Sainte-Anne',
      ),
      26 => 
      array (
        'code' => 'SAI',
        'name' => 'Sainte-Luce',
      ),
      27 => 
      array (
        'code' => 'SAI',
        'name' => 'Sainte-Marie',
      ),
      28 => 
      array (
        'code' => 'SAI',
        'name' => 'Saint-Esprit',
      ),
      29 => 
      array (
        'code' => 'SAI',
        'name' => 'Saint-Joseph',
      ),
      30 => 
      array (
        'code' => 'SAI',
        'name' => 'Saint-Pierre',
      ),
      31 => 
      array (
        'code' => 'SCH',
        'name' => 'Schœlcher',
      ),
      32 => 
      array (
        'code' => 'LA',
        'name' => 'La Trinité',
      ),
      33 => 
      array (
        'code' => 'LES',
        'name' => 'Les Trois-Îlets',
      ),
      34 => 
      array (
        'code' => 'LE',
        'name' => 'Le Vauclin',
      ),
    ),
    'MR' => 
    array (
      1 => 
      array (
        'code' => 'AD',
        'name' => 'Adrar',
      ),
      2 => 
      array (
        'code' => 'AS',
        'name' => 'Assaba',
      ),
      3 => 
      array (
        'code' => 'BR',
        'name' => 'Brakna',
      ),
      4 => 
      array (
        'code' => 'DN',
        'name' => 'Dakhlet Nouadhibou',
      ),
      5 => 
      array (
        'code' => 'GO',
        'name' => 'Gorgol',
      ),
      6 => 
      array (
        'code' => 'GM',
        'name' => 'Guidimaka',
      ),
      7 => 
      array (
        'code' => 'HC',
        'name' => 'Hodh Ech Chargui',
      ),
      8 => 
      array (
        'code' => 'HG',
        'name' => 'Hodh El Gharbi',
      ),
      9 => 
      array (
        'code' => 'IN',
        'name' => 'Inchiri',
      ),
      10 => 
      array (
        'code' => 'TA',
        'name' => 'Tagant',
      ),
      11 => 
      array (
        'code' => 'TZ',
        'name' => 'Tiris Zemmour',
      ),
      12 => 
      array (
        'code' => 'TR',
        'name' => 'Trarza',
      ),
      13 => 
      array (
        'code' => 'NO',
        'name' => 'Nouakchott',
      ),
    ),
    'MS' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Saint Anthony',
      ),
      2 => 
      array (
        'code' => 'G',
        'name' => 'Saint Georges',
      ),
      3 => 
      array (
        'code' => 'P',
        'name' => 'Saint Peter',
      ),
    ),
    'MT' => 
    array (
      1 => 
      array (
        'code' => 'ATT',
        'name' => 'Attard',
      ),
      2 => 
      array (
        'code' => 'BAL',
        'name' => 'Balzan',
      ),
      3 => 
      array (
        'code' => 'BGU',
        'name' => 'Birgu',
      ),
      4 => 
      array (
        'code' => 'BKK',
        'name' => 'Birkirkara',
      ),
      5 => 
      array (
        'code' => 'BRZ',
        'name' => 'Birzebbuga',
      ),
      6 => 
      array (
        'code' => 'BOR',
        'name' => 'Bormla',
      ),
      7 => 
      array (
        'code' => 'DIN',
        'name' => 'Dingli',
      ),
      8 => 
      array (
        'code' => 'FGU',
        'name' => 'Fgura',
      ),
      9 => 
      array (
        'code' => 'FLO',
        'name' => 'Floriana',
      ),
      10 => 
      array (
        'code' => 'GDJ',
        'name' => 'Gudja',
      ),
      11 => 
      array (
        'code' => 'GZR',
        'name' => 'Gzira',
      ),
      12 => 
      array (
        'code' => 'GRG',
        'name' => 'Gargur',
      ),
      13 => 
      array (
        'code' => 'GXQ',
        'name' => 'Gaxaq',
      ),
      14 => 
      array (
        'code' => 'HMR',
        'name' => 'Hamrun',
      ),
      15 => 
      array (
        'code' => 'IKL',
        'name' => 'Iklin',
      ),
      16 => 
      array (
        'code' => 'ISL',
        'name' => 'Isla',
      ),
      17 => 
      array (
        'code' => 'KLK',
        'name' => 'Kalkara',
      ),
      18 => 
      array (
        'code' => 'KRK',
        'name' => 'Kirkop',
      ),
      19 => 
      array (
        'code' => 'LIJ',
        'name' => 'Lija',
      ),
      20 => 
      array (
        'code' => 'LUQ',
        'name' => 'Luqa',
      ),
      21 => 
      array (
        'code' => 'MRS',
        'name' => 'Marsa',
      ),
      22 => 
      array (
        'code' => 'MKL',
        'name' => 'Marsaskala',
      ),
      23 => 
      array (
        'code' => 'MXL',
        'name' => 'Marsaxlokk',
      ),
      24 => 
      array (
        'code' => 'MDN',
        'name' => 'Mdina',
      ),
      25 => 
      array (
        'code' => 'MEL',
        'name' => 'Melliea',
      ),
      26 => 
      array (
        'code' => 'MGR',
        'name' => 'Mgarr',
      ),
      27 => 
      array (
        'code' => 'MST',
        'name' => 'Mosta',
      ),
      28 => 
      array (
        'code' => 'MQA',
        'name' => 'Mqabba',
      ),
      29 => 
      array (
        'code' => 'MSI',
        'name' => 'Msida',
      ),
      30 => 
      array (
        'code' => 'MTF',
        'name' => 'Mtarfa',
      ),
      31 => 
      array (
        'code' => 'NAX',
        'name' => 'Naxxar',
      ),
      32 => 
      array (
        'code' => 'PAO',
        'name' => 'Paola',
      ),
      33 => 
      array (
        'code' => 'PEM',
        'name' => 'Pembroke',
      ),
      34 => 
      array (
        'code' => 'PIE',
        'name' => 'Pieta',
      ),
      35 => 
      array (
        'code' => 'QOR',
        'name' => 'Qormi',
      ),
      36 => 
      array (
        'code' => 'QRE',
        'name' => 'Qrendi',
      ),
      37 => 
      array (
        'code' => 'RAB',
        'name' => 'Rabat',
      ),
      38 => 
      array (
        'code' => 'SAF',
        'name' => 'Safi',
      ),
      39 => 
      array (
        'code' => 'SGI',
        'name' => 'San Giljan',
      ),
      40 => 
      array (
        'code' => 'SLU',
        'name' => 'Santa Lucija',
      ),
      41 => 
      array (
        'code' => 'SPB',
        'name' => 'San Pawl il-Bahar',
      ),
      42 => 
      array (
        'code' => 'SGW',
        'name' => 'San Gwann',
      ),
      43 => 
      array (
        'code' => 'SVE',
        'name' => 'Santa Venera',
      ),
      44 => 
      array (
        'code' => 'SIG',
        'name' => 'Siggiewi',
      ),
      45 => 
      array (
        'code' => 'SLM',
        'name' => 'Sliema',
      ),
      46 => 
      array (
        'code' => 'SWQ',
        'name' => 'Swieqi',
      ),
      47 => 
      array (
        'code' => 'TXB',
        'name' => 'Ta Xbiex',
      ),
      48 => 
      array (
        'code' => 'TRX',
        'name' => 'Tarxien',
      ),
      49 => 
      array (
        'code' => 'VLT',
        'name' => 'Valletta',
      ),
      50 => 
      array (
        'code' => 'XGJ',
        'name' => 'Xgajra',
      ),
      51 => 
      array (
        'code' => 'ZBR',
        'name' => 'Zabbar',
      ),
      52 => 
      array (
        'code' => 'ZBG',
        'name' => 'Zebbug',
      ),
      53 => 
      array (
        'code' => 'ZJT',
        'name' => 'Zejtun',
      ),
      54 => 
      array (
        'code' => 'ZRQ',
        'name' => 'Zurrieq',
      ),
      55 => 
      array (
        'code' => 'FNT',
        'name' => 'Fontana',
      ),
      56 => 
      array (
        'code' => 'GHJ',
        'name' => 'Ghajnsielem',
      ),
      57 => 
      array (
        'code' => 'GHR',
        'name' => 'Gharb',
      ),
      58 => 
      array (
        'code' => 'GHS',
        'name' => 'Ghasri',
      ),
      59 => 
      array (
        'code' => 'KRC',
        'name' => 'Kercem',
      ),
      60 => 
      array (
        'code' => 'MUN',
        'name' => 'Munxar',
      ),
      61 => 
      array (
        'code' => 'NAD',
        'name' => 'Nadur',
      ),
      62 => 
      array (
        'code' => 'QAL',
        'name' => 'Qala',
      ),
      63 => 
      array (
        'code' => 'VIC',
        'name' => 'Victoria',
      ),
      64 => 
      array (
        'code' => 'SLA',
        'name' => 'San Lawrenz',
      ),
      65 => 
      array (
        'code' => 'SNT',
        'name' => 'Sannat',
      ),
      66 => 
      array (
        'code' => 'ZAG',
        'name' => 'Xagra',
      ),
      67 => 
      array (
        'code' => 'XEW',
        'name' => 'Xewkija',
      ),
      68 => 
      array (
        'code' => 'ZEB',
        'name' => 'Zebbug',
      ),
    ),
    'MU' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => 'Agalega Islands',
      ),
      2 => 
      array (
        'code' => 'BL',
        'name' => 'Black River',
      ),
      3 => 
      array (
        'code' => 'BR',
        'name' => 'Beau Bassin-Rose Hill',
      ),
      4 => 
      array (
        'code' => 'CC',
        'name' => 'Cargados Carajos Shoals (Saint B)',
      ),
      5 => 
      array (
        'code' => 'CU',
        'name' => 'Curepipe',
      ),
      6 => 
      array (
        'code' => 'FL',
        'name' => 'Flacq',
      ),
      7 => 
      array (
        'code' => 'GP',
        'name' => 'Grand Port',
      ),
      8 => 
      array (
        'code' => 'MO',
        'name' => 'Moka',
      ),
      9 => 
      array (
        'code' => 'PA',
        'name' => 'Pamplemousses',
      ),
      10 => 
      array (
        'code' => 'PL',
        'name' => 'Port Louis',
      ),
      11 => 
      array (
        'code' => 'PU',
        'name' => 'Port Louis',
      ),
      12 => 
      array (
        'code' => 'PW',
        'name' => 'Plaines Wilhems',
      ),
      13 => 
      array (
        'code' => 'QB',
        'name' => 'Quatre Bornes',
      ),
      14 => 
      array (
        'code' => 'RO',
        'name' => 'Rodrigues',
      ),
      15 => 
      array (
        'code' => 'RR',
        'name' => 'Riviere du Rempart',
      ),
      16 => 
      array (
        'code' => 'SA',
        'name' => 'Savanne',
      ),
      17 => 
      array (
        'code' => 'VP',
        'name' => 'Vacoas-Phoenix',
      ),
    ),
    'MV' => 
    array (
      1 => 
      array (
        'code' => 'AAD',
        'name' => 'Ari Atoll Dheknu',
      ),
      2 => 
      array (
        'code' => 'AAU',
        'name' => 'Ari Atoll Uthuru',
      ),
      3 => 
      array (
        'code' => 'ADD',
        'name' => 'Addu',
      ),
      4 => 
      array (
        'code' => 'FAA',
        'name' => 'Faadhippolhu',
      ),
      5 => 
      array (
        'code' => 'FEA',
        'name' => 'Felidhe Atoll',
      ),
      6 => 
      array (
        'code' => 'FMU',
        'name' => 'Fua Mulaku',
      ),
      7 => 
      array (
        'code' => 'HAD',
        'name' => 'Huvadhu Atoll Dhekunu',
      ),
      8 => 
      array (
        'code' => 'HAU',
        'name' => 'Huvadhu Atoll Uthuru',
      ),
      9 => 
      array (
        'code' => 'HDH',
        'name' => 'Hadhdhunmathi',
      ),
      10 => 
      array (
        'code' => 'KLH',
        'name' => 'Kolhumadulu',
      ),
      11 => 
      array (
        'code' => 'MAA',
        'name' => 'Male Atoll',
      ),
      12 => 
      array (
        'code' => 'MAD',
        'name' => 'Maalhosmadulu Dhekunu',
      ),
      13 => 
      array (
        'code' => 'MAU',
        'name' => 'Maalhosmadulu Uthuru',
      ),
      14 => 
      array (
        'code' => 'MLD',
        'name' => 'Miladhunmadulu Dhekunu',
      ),
      15 => 
      array (
        'code' => 'MLU',
        'name' => 'Miladhunmadulu Uthuru',
      ),
      16 => 
      array (
        'code' => 'MUA',
        'name' => 'Mulaku Atoll',
      ),
      17 => 
      array (
        'code' => 'NAD',
        'name' => 'Nilandhe Atoll Dhekunu',
      ),
      18 => 
      array (
        'code' => 'NAU',
        'name' => 'Nilandhe Atoll Uthuru',
      ),
      19 => 
      array (
        'code' => 'THD',
        'name' => 'Thiladhunmathi Dhekunu',
      ),
      20 => 
      array (
        'code' => 'THU',
        'name' => 'Thiladhunmathi Uthuru',
      ),
    ),
    'MW' => 
    array (
      1 => 
      array (
        'code' => 'BLK',
        'name' => 'Balaka',
      ),
      2 => 
      array (
        'code' => 'BLT',
        'name' => 'Blantyre',
      ),
      3 => 
      array (
        'code' => 'CKW',
        'name' => 'Chikwawa',
      ),
      4 => 
      array (
        'code' => 'CRD',
        'name' => 'Chiradzulu',
      ),
      5 => 
      array (
        'code' => 'CTP',
        'name' => 'Chitipa',
      ),
      6 => 
      array (
        'code' => 'DDZ',
        'name' => 'Dedza',
      ),
      7 => 
      array (
        'code' => 'DWA',
        'name' => 'Dowa',
      ),
      8 => 
      array (
        'code' => 'KRG',
        'name' => 'Karonga',
      ),
      9 => 
      array (
        'code' => 'KSG',
        'name' => 'Kasungu',
      ),
      10 => 
      array (
        'code' => 'LKM',
        'name' => 'Likoma',
      ),
      11 => 
      array (
        'code' => 'LLG',
        'name' => 'Lilongwe',
      ),
      12 => 
      array (
        'code' => 'MCG',
        'name' => 'Machinga',
      ),
      13 => 
      array (
        'code' => 'MGC',
        'name' => 'Mangochi',
      ),
      14 => 
      array (
        'code' => 'MCH',
        'name' => 'Mchinji',
      ),
      15 => 
      array (
        'code' => 'MLJ',
        'name' => 'Mulanje',
      ),
      16 => 
      array (
        'code' => 'MWZ',
        'name' => 'Mwanza',
      ),
      17 => 
      array (
        'code' => 'MZM',
        'name' => 'Mzimba',
      ),
      18 => 
      array (
        'code' => 'NTU',
        'name' => 'Ntcheu',
      ),
      19 => 
      array (
        'code' => 'NKB',
        'name' => 'Nkhata Bay',
      ),
      20 => 
      array (
        'code' => 'NKH',
        'name' => 'Nkhotakota',
      ),
      21 => 
      array (
        'code' => 'NSJ',
        'name' => 'Nsanje',
      ),
      22 => 
      array (
        'code' => 'NTI',
        'name' => 'Ntchisi',
      ),
      23 => 
      array (
        'code' => 'PHL',
        'name' => 'Phalombe',
      ),
      24 => 
      array (
        'code' => 'RMP',
        'name' => 'Rumphi',
      ),
      25 => 
      array (
        'code' => 'SLM',
        'name' => 'Salima',
      ),
      26 => 
      array (
        'code' => 'THY',
        'name' => 'Thyolo',
      ),
      27 => 
      array (
        'code' => 'ZBA',
        'name' => 'Zomba',
      ),
    ),
    'MX' => 
    array (
      1 => 
      array (
        'code' => 'AGU',
        'name' => 'Aguascalientes',
      ),
      2 => 
      array (
        'code' => 'BCN',
        'name' => 'Baja California Norte',
      ),
      3 => 
      array (
        'code' => 'BCS',
        'name' => 'Baja California Sur',
      ),
      4 => 
      array (
        'code' => 'CAM',
        'name' => 'Campeche',
      ),
      5 => 
      array (
        'code' => 'CHP',
        'name' => 'Chiapas',
      ),
      6 => 
      array (
        'code' => 'CHH',
        'name' => 'Chihuahua',
      ),
      7 => 
      array (
        'code' => 'COA',
        'name' => 'Coahuila de Zaragoza',
      ),
      8 => 
      array (
        'code' => 'COL',
        'name' => 'Colima',
      ),
      9 => 
      array (
        'code' => 'DIF',
        'name' => 'Distrito Federal',
      ),
      10 => 
      array (
        'code' => 'DUR',
        'name' => 'Durango',
      ),
      11 => 
      array (
        'code' => 'GUA',
        'name' => 'Guanajuato',
      ),
      12 => 
      array (
        'code' => 'GRO',
        'name' => 'Guerrero',
      ),
      13 => 
      array (
        'code' => 'HID',
        'name' => 'Hidalgo',
      ),
      14 => 
      array (
        'code' => 'JAL',
        'name' => 'Jalisco',
      ),
      15 => 
      array (
        'code' => 'MEX',
        'name' => 'Mexico',
      ),
      16 => 
      array (
        'code' => 'MIC',
        'name' => 'Michoacan de Ocampo',
      ),
      17 => 
      array (
        'code' => 'MOR',
        'name' => 'Morelos',
      ),
      18 => 
      array (
        'code' => 'NAY',
        'name' => 'Nayarit',
      ),
      19 => 
      array (
        'code' => 'NLE',
        'name' => 'Nuevo Leon',
      ),
      20 => 
      array (
        'code' => 'OAX',
        'name' => 'Oaxaca',
      ),
      21 => 
      array (
        'code' => 'PUE',
        'name' => 'Puebla',
      ),
      22 => 
      array (
        'code' => 'QUE',
        'name' => 'Queretaro de Arteaga',
      ),
      23 => 
      array (
        'code' => 'ROO',
        'name' => 'Quintana Roo',
      ),
      24 => 
      array (
        'code' => 'SLP',
        'name' => 'San Luis Potosi',
      ),
      25 => 
      array (
        'code' => 'SIN',
        'name' => 'Sinaloa',
      ),
      26 => 
      array (
        'code' => 'SON',
        'name' => 'Sonora',
      ),
      27 => 
      array (
        'code' => 'TAB',
        'name' => 'Tabasco',
      ),
      28 => 
      array (
        'code' => 'TAM',
        'name' => 'Tamaulipas',
      ),
      29 => 
      array (
        'code' => 'TLA',
        'name' => 'Tlaxcala',
      ),
      30 => 
      array (
        'code' => 'VER',
        'name' => 'Veracruz-Llave',
      ),
      31 => 
      array (
        'code' => 'YUC',
        'name' => 'Yucatan',
      ),
      32 => 
      array (
        'code' => 'ZAC',
        'name' => 'Zacatecas',
      ),
    ),
    'MY' => 
    array (
      1 => 
      array (
        'code' => 'Johor',
        'name' => 'Johor',
      ),
      2 => 
      array (
        'code' => 'Kedah',
        'name' => 'Kedah',
      ),
      3 => 
      array (
        'code' => 'Kelantan',
        'name' => 'Kelantan',
      ),
      4 => 
      array (
        'code' => 'Labuan',
        'name' => 'Labuan',
      ),
      5 => 
      array (
        'code' => 'Melaka',
        'name' => 'Melaka',
      ),
      6 => 
      array (
        'code' => 'Negeri Sembilan',
        'name' => 'Negeri Sembilan',
      ),
      7 => 
      array (
        'code' => 'Pahang',
        'name' => 'Pahang',
      ),
      8 => 
      array (
        'code' => 'Perak',
        'name' => 'Perak',
      ),
      9 => 
      array (
        'code' => 'Perlis',
        'name' => 'Perlis',
      ),
      10 => 
      array (
        'code' => 'Pulau Pinang',
        'name' => 'Pulau Pinang',
      ),
      11 => 
      array (
        'code' => 'Sabah',
        'name' => 'Sabah',
      ),
      12 => 
      array (
        'code' => 'Sarawak',
        'name' => 'Sarawak',
      ),
      13 => 
      array (
        'code' => 'Selangor',
        'name' => 'Selangor',
      ),
      14 => 
      array (
        'code' => 'Terengganu',
        'name' => 'Terengganu',
      ),
      15 => 
      array (
        'code' => 'Kuala Lumpur',
        'name' => 'Kuala Lumpur',
      ),
    ),
    'MZ' => 
    array (
      1 => 
      array (
        'code' => 'CD',
        'name' => 'Cabo Delgado',
      ),
      2 => 
      array (
        'code' => 'GZ',
        'name' => 'Gaza',
      ),
      3 => 
      array (
        'code' => 'IN',
        'name' => 'Inhambane',
      ),
      4 => 
      array (
        'code' => 'MN',
        'name' => 'Manica',
      ),
      5 => 
      array (
        'code' => 'MC',
        'name' => 'Maputo (city)',
      ),
      6 => 
      array (
        'code' => 'MP',
        'name' => 'Maputo',
      ),
      7 => 
      array (
        'code' => 'NA',
        'name' => 'Nampula',
      ),
      8 => 
      array (
        'code' => 'NI',
        'name' => 'Niassa',
      ),
      9 => 
      array (
        'code' => 'SO',
        'name' => 'Sofala',
      ),
      10 => 
      array (
        'code' => 'TE',
        'name' => 'Tete',
      ),
      11 => 
      array (
        'code' => 'ZA',
        'name' => 'Zambezia',
      ),
    ),
    'NA' => 
    array (
      1 => 
      array (
        'code' => 'CA',
        'name' => 'Caprivi',
      ),
      2 => 
      array (
        'code' => 'ER',
        'name' => 'Erongo',
      ),
      3 => 
      array (
        'code' => 'HA',
        'name' => 'Hardap',
      ),
      4 => 
      array (
        'code' => 'KR',
        'name' => 'Karas',
      ),
      5 => 
      array (
        'code' => 'KV',
        'name' => 'Kavango',
      ),
      6 => 
      array (
        'code' => 'KH',
        'name' => 'Khomas',
      ),
      7 => 
      array (
        'code' => 'KU',
        'name' => 'Kunene',
      ),
      8 => 
      array (
        'code' => 'OW',
        'name' => 'Ohangwena',
      ),
      9 => 
      array (
        'code' => 'OK',
        'name' => 'Omaheke',
      ),
      10 => 
      array (
        'code' => 'OT',
        'name' => 'Omusati',
      ),
      11 => 
      array (
        'code' => 'ON',
        'name' => 'Oshana',
      ),
      12 => 
      array (
        'code' => 'OO',
        'name' => 'Oshikoto',
      ),
      13 => 
      array (
        'code' => 'OJ',
        'name' => 'Otjozondjupa',
      ),
    ),
    'NC' => 
    array (
      1 => 
      array (
        'code' => 'L',
        'name' => 'Iles Loyaute',
      ),
      2 => 
      array (
        'code' => 'N',
        'name' => 'Nord',
      ),
      3 => 
      array (
        'code' => 'S',
        'name' => 'Sud',
      ),
    ),
    'NE' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => 'Agadez',
      ),
      2 => 
      array (
        'code' => 'DF',
        'name' => 'Diffa',
      ),
      3 => 
      array (
        'code' => 'DS',
        'name' => 'Dosso',
      ),
      4 => 
      array (
        'code' => 'MA',
        'name' => 'Maradi',
      ),
      5 => 
      array (
        'code' => 'NM',
        'name' => 'Niamey',
      ),
      6 => 
      array (
        'code' => 'TH',
        'name' => 'Tahoua',
      ),
      7 => 
      array (
        'code' => 'TL',
        'name' => 'Tillaberi',
      ),
      8 => 
      array (
        'code' => 'ZD',
        'name' => 'Zinder',
      ),
    ),
    'NF' => 
    array (
      1 => 
      array (
        'code' => 'NOR',
        'name' => 'Norfolk Island',
      ),
    ),
    'NG' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => 'Abia',
      ),
      2 => 
      array (
        'code' => 'CT',
        'name' => 'Abuja Federal Capital Territory',
      ),
      3 => 
      array (
        'code' => 'AD',
        'name' => 'Adamawa',
      ),
      4 => 
      array (
        'code' => 'AK',
        'name' => 'Akwa Ibom',
      ),
      5 => 
      array (
        'code' => 'AN',
        'name' => 'Anambra',
      ),
      6 => 
      array (
        'code' => 'BC',
        'name' => 'Bauchi',
      ),
      7 => 
      array (
        'code' => 'BY',
        'name' => 'Bayelsa',
      ),
      8 => 
      array (
        'code' => 'BN',
        'name' => 'Benue',
      ),
      9 => 
      array (
        'code' => 'BO',
        'name' => 'Borno',
      ),
      10 => 
      array (
        'code' => 'CR',
        'name' => 'Cross River',
      ),
      11 => 
      array (
        'code' => 'DE',
        'name' => 'Delta',
      ),
      12 => 
      array (
        'code' => 'EB',
        'name' => 'Ebonyi',
      ),
      13 => 
      array (
        'code' => 'ED',
        'name' => 'Edo',
      ),
      14 => 
      array (
        'code' => 'EK',
        'name' => 'Ekiti',
      ),
      15 => 
      array (
        'code' => 'EN',
        'name' => 'Enugu',
      ),
      16 => 
      array (
        'code' => 'GO',
        'name' => 'Gombe',
      ),
      17 => 
      array (
        'code' => 'IM',
        'name' => 'Imo',
      ),
      18 => 
      array (
        'code' => 'JI',
        'name' => 'Jigawa',
      ),
      19 => 
      array (
        'code' => 'KD',
        'name' => 'Kaduna',
      ),
      20 => 
      array (
        'code' => 'KN',
        'name' => 'Kano',
      ),
      21 => 
      array (
        'code' => 'KT',
        'name' => 'Katsina',
      ),
      22 => 
      array (
        'code' => 'KE',
        'name' => 'Kebbi',
      ),
      23 => 
      array (
        'code' => 'KO',
        'name' => 'Kogi',
      ),
      24 => 
      array (
        'code' => 'KW',
        'name' => 'Kwara',
      ),
      25 => 
      array (
        'code' => 'LA',
        'name' => 'Lagos',
      ),
      26 => 
      array (
        'code' => 'NA',
        'name' => 'Nassarawa',
      ),
      27 => 
      array (
        'code' => 'NI',
        'name' => 'Niger',
      ),
      28 => 
      array (
        'code' => 'OG',
        'name' => 'Ogun',
      ),
      29 => 
      array (
        'code' => 'ONG',
        'name' => 'Ondo',
      ),
      30 => 
      array (
        'code' => 'OS',
        'name' => 'Osun',
      ),
      31 => 
      array (
        'code' => 'OY',
        'name' => 'Oyo',
      ),
      32 => 
      array (
        'code' => 'PL',
        'name' => 'Plateau',
      ),
      33 => 
      array (
        'code' => 'RI',
        'name' => 'Rivers',
      ),
      34 => 
      array (
        'code' => 'SO',
        'name' => 'Sokoto',
      ),
      35 => 
      array (
        'code' => 'TA',
        'name' => 'Taraba',
      ),
      36 => 
      array (
        'code' => 'YO',
        'name' => 'Yobe',
      ),
      37 => 
      array (
        'code' => 'ZA',
        'name' => 'Zamfara',
      ),
    ),
    'NI' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Atlantico Norte',
      ),
      2 => 
      array (
        'code' => 'AS',
        'name' => 'Atlantico Sur',
      ),
      3 => 
      array (
        'code' => 'BO',
        'name' => 'Boaco',
      ),
      4 => 
      array (
        'code' => 'CA',
        'name' => 'Carazo',
      ),
      5 => 
      array (
        'code' => 'CI',
        'name' => 'Chinandega',
      ),
      6 => 
      array (
        'code' => 'CO',
        'name' => 'Chontales',
      ),
      7 => 
      array (
        'code' => 'ES',
        'name' => 'Esteli',
      ),
      8 => 
      array (
        'code' => 'GR',
        'name' => 'Granada',
      ),
      9 => 
      array (
        'code' => 'JI',
        'name' => 'Jinotega',
      ),
      10 => 
      array (
        'code' => 'LE',
        'name' => 'Leon',
      ),
      11 => 
      array (
        'code' => 'MD',
        'name' => 'Madriz',
      ),
      12 => 
      array (
        'code' => 'MN',
        'name' => 'Managua',
      ),
      13 => 
      array (
        'code' => 'MS',
        'name' => 'Masaya',
      ),
      14 => 
      array (
        'code' => 'MT',
        'name' => 'Matagalpa',
      ),
      15 => 
      array (
        'code' => 'NS',
        'name' => 'Nuevo Segovia',
      ),
      16 => 
      array (
        'code' => 'RS',
        'name' => 'Rio San Juan',
      ),
      17 => 
      array (
        'code' => 'RI',
        'name' => 'Rivas',
      ),
    ),
    'NL' => 
    array (
      1 => 
      array (
        'code' => 'DR',
        'name' => 'Drenthe',
      ),
      2 => 
      array (
        'code' => 'FL',
        'name' => 'Flevoland',
      ),
      3 => 
      array (
        'code' => 'FR',
        'name' => 'Friesland',
      ),
      4 => 
      array (
        'code' => 'GE',
        'name' => 'Gelderland',
      ),
      5 => 
      array (
        'code' => 'GR',
        'name' => 'Groningen',
      ),
      6 => 
      array (
        'code' => 'LI',
        'name' => 'Limburg',
      ),
      7 => 
      array (
        'code' => 'NB',
        'name' => 'Noord Brabant',
      ),
      8 => 
      array (
        'code' => 'NH',
        'name' => 'Noord Holland',
      ),
      9 => 
      array (
        'code' => 'OV',
        'name' => 'Overijssel',
      ),
      10 => 
      array (
        'code' => 'UT',
        'name' => 'Utrecht',
      ),
      11 => 
      array (
        'code' => 'ZE',
        'name' => 'Zeeland',
      ),
      12 => 
      array (
        'code' => 'ZH',
        'name' => 'Zuid Holland',
      ),
    ),
    'NO' => 
    array (
      1 => 
      array (
        'code' => 'AK',
        'name' => 'Akershus',
      ),
      2 => 
      array (
        'code' => 'AA',
        'name' => 'Aust-Agder',
      ),
      3 => 
      array (
        'code' => 'BU',
        'name' => 'Buskerud',
      ),
      4 => 
      array (
        'code' => 'FM',
        'name' => 'Finnmark',
      ),
      5 => 
      array (
        'code' => 'HM',
        'name' => 'Hedmark',
      ),
      6 => 
      array (
        'code' => 'HL',
        'name' => 'Hordaland',
      ),
      7 => 
      array (
        'code' => 'MR',
        'name' => 'Møre og Romsdal',
      ),
      8 => 
      array (
        'code' => 'NL',
        'name' => 'Nordland',
      ),
      9 => 
      array (
        'code' => 'NT',
        'name' => 'Nord-Trøndelag',
      ),
      10 => 
      array (
        'code' => 'OP',
        'name' => 'Oppland',
      ),
      11 => 
      array (
        'code' => 'OL',
        'name' => 'Oslo',
      ),
      12 => 
      array (
        'code' => 'RL',
        'name' => 'Rogaland',
      ),
      13 => 
      array (
        'code' => 'SJ',
        'name' => 'Sogn og Fjordane',
      ),
      14 => 
      array (
        'code' => 'ST',
        'name' => 'Sør-Trøndelag',
      ),
      15 => 
      array (
        'code' => 'SV',
        'name' => 'Svalbard',
      ),
      16 => 
      array (
        'code' => 'TM',
        'name' => 'Telemark',
      ),
      17 => 
      array (
        'code' => 'TR',
        'name' => 'Troms',
      ),
      18 => 
      array (
        'code' => 'VA',
        'name' => 'Vest-Agder',
      ),
      19 => 
      array (
        'code' => 'VF',
        'name' => 'Vestfold',
      ),
      20 => 
      array (
        'code' => 'OF',
        'name' => 'Østfold',
      ),
    ),
    'NP' => 
    array (
      1 => 
      array (
        'code' => 'BA',
        'name' => 'Bagmati',
      ),
      2 => 
      array (
        'code' => 'BH',
        'name' => 'Bheri',
      ),
      3 => 
      array (
        'code' => 'DH',
        'name' => 'Dhawalagiri',
      ),
      4 => 
      array (
        'code' => 'GA',
        'name' => 'Gandaki',
      ),
      5 => 
      array (
        'code' => 'JA',
        'name' => 'Janakpur',
      ),
      6 => 
      array (
        'code' => 'KA',
        'name' => 'Karnali',
      ),
      7 => 
      array (
        'code' => 'KO',
        'name' => 'Kosi',
      ),
      8 => 
      array (
        'code' => 'LU',
        'name' => 'Lumbini',
      ),
      9 => 
      array (
        'code' => 'MA',
        'name' => 'Mahakali',
      ),
      10 => 
      array (
        'code' => 'ME',
        'name' => 'Mechi',
      ),
      11 => 
      array (
        'code' => 'NA',
        'name' => 'Narayani',
      ),
      12 => 
      array (
        'code' => 'RA',
        'name' => 'Rapti',
      ),
      13 => 
      array (
        'code' => 'SA',
        'name' => 'Sagarmatha',
      ),
      14 => 
      array (
        'code' => 'SE',
        'name' => 'Seti',
      ),
    ),
    'NR' => 
    array (
      1 => 
      array (
        'code' => 'AO',
        'name' => 'Aiwo',
      ),
      2 => 
      array (
        'code' => 'AA',
        'name' => 'Anabar',
      ),
      3 => 
      array (
        'code' => 'AT',
        'name' => 'Anetan',
      ),
      4 => 
      array (
        'code' => 'AI',
        'name' => 'Anibare',
      ),
      5 => 
      array (
        'code' => 'BA',
        'name' => 'Baiti',
      ),
      6 => 
      array (
        'code' => 'BO',
        'name' => 'Boe',
      ),
      7 => 
      array (
        'code' => 'BU',
        'name' => 'Buada',
      ),
      8 => 
      array (
        'code' => 'DE',
        'name' => 'Denigomodu',
      ),
      9 => 
      array (
        'code' => 'EW',
        'name' => 'Ewa',
      ),
      10 => 
      array (
        'code' => 'IJ',
        'name' => 'Ijuw',
      ),
      11 => 
      array (
        'code' => 'ME',
        'name' => 'Meneng',
      ),
      12 => 
      array (
        'code' => 'NI',
        'name' => 'Nibok',
      ),
      13 => 
      array (
        'code' => 'UA',
        'name' => 'Uaboe',
      ),
      14 => 
      array (
        'code' => 'YA',
        'name' => 'Yaren',
      ),
    ),
    'NU' => 
    array (
      1 => 
      array (
        'code' => 'MAK',
        'name' => 'Makefu',
      ),
      2 => 
      array (
        'code' => 'TUA',
        'name' => 'Tuapa',
      ),
      3 => 
      array (
        'code' => 'NAM',
        'name' => 'Namukulu',
      ),
      4 => 
      array (
        'code' => 'HIK',
        'name' => 'Hikutavake',
      ),
      5 => 
      array (
        'code' => 'TOI',
        'name' => 'Toi',
      ),
      6 => 
      array (
        'code' => 'MUT',
        'name' => 'Mutalau',
      ),
      7 => 
      array (
        'code' => 'LAK',
        'name' => 'Lakepa',
      ),
      8 => 
      array (
        'code' => 'LIK',
        'name' => 'Liku',
      ),
      9 => 
      array (
        'code' => 'HAK',
        'name' => 'Hakupu',
      ),
      10 => 
      array (
        'code' => 'VAI',
        'name' => 'Vaiea',
      ),
      11 => 
      array (
        'code' => 'AVA',
        'name' => 'Avatele',
      ),
      12 => 
      array (
        'code' => 'TAM',
        'name' => 'Tamakautoga',
      ),
      13 => 
      array (
        'code' => 'ALO',
        'name' => 'Alofi South',
      ),
      14 => 
      array (
        'code' => 'ALO',
        'name' => 'Alofi North',
      ),
    ),
    'NZ' => 
    array (
      1 => 
      array (
        'code' => 'AUK',
        'name' => 'Auckland',
      ),
      2 => 
      array (
        'code' => 'BOP',
        'name' => 'Bay of Plenty',
      ),
      3 => 
      array (
        'code' => 'CAN',
        'name' => 'Canterbury',
      ),
      4 => 
      array (
        'code' => 'COR',
        'name' => 'Coromandel',
      ),
      5 => 
      array (
        'code' => 'GIS',
        'name' => 'Gisborne',
      ),
      6 => 
      array (
        'code' => 'FIO',
        'name' => 'Fiordland',
      ),
      7 => 
      array (
        'code' => 'HKB',
        'name' => 'Hawke&#39;s Bay',
      ),
      8 => 
      array (
        'code' => 'MBH',
        'name' => 'Marlborough',
      ),
      9 => 
      array (
        'code' => 'MWT',
        'name' => 'Manawatu-Wanganui',
      ),
      10 => 
      array (
        'code' => 'MCM',
        'name' => 'Mt Cook-Mackenzie',
      ),
      11 => 
      array (
        'code' => 'NSN',
        'name' => 'Nelson',
      ),
      12 => 
      array (
        'code' => 'NTL',
        'name' => 'Northland',
      ),
      13 => 
      array (
        'code' => 'OTA',
        'name' => 'Otago',
      ),
      14 => 
      array (
        'code' => 'STL',
        'name' => 'Southland',
      ),
      15 => 
      array (
        'code' => 'TKI',
        'name' => 'Taranaki',
      ),
      16 => 
      array (
        'code' => 'WGN',
        'name' => 'Wellington',
      ),
      17 => 
      array (
        'code' => 'WKO',
        'name' => 'Waikato',
      ),
      18 => 
      array (
        'code' => 'WAI',
        'name' => 'Wairprarapa',
      ),
      19 => 
      array (
        'code' => 'WTC',
        'name' => 'West Coast',
      ),
    ),
    'OM' => 
    array (
      1 => 
      array (
        'code' => 'DA',
        'name' => 'Ad Dakhiliyah',
      ),
      2 => 
      array (
        'code' => 'BA',
        'name' => 'Al Batinah',
      ),
      3 => 
      array (
        'code' => 'WU',
        'name' => 'Al Wusta',
      ),
      4 => 
      array (
        'code' => 'SH',
        'name' => 'Ash Sharqiyah',
      ),
      5 => 
      array (
        'code' => 'ZA',
        'name' => 'Az Zahirah',
      ),
      6 => 
      array (
        'code' => 'MA',
        'name' => 'Masqat',
      ),
      7 => 
      array (
        'code' => 'MU',
        'name' => 'Musandam',
      ),
      8 => 
      array (
        'code' => 'ZU',
        'name' => 'Zufar',
      ),
    ),
    'PA' => 
    array (
      1 => 
      array (
        'code' => 'BT',
        'name' => 'Bocas del Toro',
      ),
      2 => 
      array (
        'code' => 'CH',
        'name' => 'Chiriqui',
      ),
      3 => 
      array (
        'code' => 'CC',
        'name' => 'Cocle',
      ),
      4 => 
      array (
        'code' => 'CL',
        'name' => 'Colon',
      ),
      5 => 
      array (
        'code' => 'DA',
        'name' => 'Darien',
      ),
      6 => 
      array (
        'code' => 'HE',
        'name' => 'Herrera',
      ),
      7 => 
      array (
        'code' => 'LS',
        'name' => 'Los Santos',
      ),
      8 => 
      array (
        'code' => 'PA',
        'name' => 'Panama',
      ),
      9 => 
      array (
        'code' => 'SB',
        'name' => 'San Blas',
      ),
      10 => 
      array (
        'code' => 'VG',
        'name' => 'Veraguas',
      ),
    ),
    'PE' => 
    array (
      1 => 
      array (
        'code' => 'AM',
        'name' => 'Amazonas',
      ),
      2 => 
      array (
        'code' => 'AN',
        'name' => 'Ancash',
      ),
      3 => 
      array (
        'code' => 'AP',
        'name' => 'Apurimac',
      ),
      4 => 
      array (
        'code' => 'AR',
        'name' => 'Arequipa',
      ),
      5 => 
      array (
        'code' => 'AY',
        'name' => 'Ayacucho',
      ),
      6 => 
      array (
        'code' => 'CJ',
        'name' => 'Cajamarca',
      ),
      7 => 
      array (
        'code' => 'CL',
        'name' => 'Callao',
      ),
      8 => 
      array (
        'code' => 'CU',
        'name' => 'Cusco',
      ),
      9 => 
      array (
        'code' => 'HV',
        'name' => 'Huancavelica',
      ),
      10 => 
      array (
        'code' => 'HO',
        'name' => 'Huanuco',
      ),
      11 => 
      array (
        'code' => 'IC',
        'name' => 'Ica',
      ),
      12 => 
      array (
        'code' => 'JU',
        'name' => 'Junin',
      ),
      13 => 
      array (
        'code' => 'LD',
        'name' => 'La Libertad',
      ),
      14 => 
      array (
        'code' => 'LY',
        'name' => 'Lambayeque',
      ),
      15 => 
      array (
        'code' => 'LI',
        'name' => 'Lima',
      ),
      16 => 
      array (
        'code' => 'LO',
        'name' => 'Loreto',
      ),
      17 => 
      array (
        'code' => 'MD',
        'name' => 'Madre de Dios',
      ),
      18 => 
      array (
        'code' => 'MO',
        'name' => 'Moquegua',
      ),
      19 => 
      array (
        'code' => 'PA',
        'name' => 'Pasco',
      ),
      20 => 
      array (
        'code' => 'PI',
        'name' => 'Piura',
      ),
      21 => 
      array (
        'code' => 'PU',
        'name' => 'Puno',
      ),
      22 => 
      array (
        'code' => 'SM',
        'name' => 'San Martin',
      ),
      23 => 
      array (
        'code' => 'TA',
        'name' => 'Tacna',
      ),
      24 => 
      array (
        'code' => 'TU',
        'name' => 'Tumbes',
      ),
      25 => 
      array (
        'code' => 'UC',
        'name' => 'Ucayali',
      ),
    ),
    'PF' => 
    array (
      1 => 
      array (
        'code' => 'M',
        'name' => 'Archipel des Marquises',
      ),
      2 => 
      array (
        'code' => 'T',
        'name' => 'Archipel des Tuamotu',
      ),
      3 => 
      array (
        'code' => 'I',
        'name' => 'Archipel des Tubuai',
      ),
      4 => 
      array (
        'code' => 'V',
        'name' => 'Iles du Vent',
      ),
      5 => 
      array (
        'code' => 'S',
        'name' => 'Iles Sous-le-Vent',
      ),
    ),
    'PG' => 
    array (
      1 => 
      array (
        'code' => 'BV',
        'name' => 'Bougainville',
      ),
      2 => 
      array (
        'code' => 'CE',
        'name' => 'Central',
      ),
      3 => 
      array (
        'code' => 'CH',
        'name' => 'Chimbu',
      ),
      4 => 
      array (
        'code' => 'EH',
        'name' => 'Eastern Highlands',
      ),
      5 => 
      array (
        'code' => 'EB',
        'name' => 'East New Britain',
      ),
      6 => 
      array (
        'code' => 'ES',
        'name' => 'East Sepik',
      ),
      7 => 
      array (
        'code' => 'EN',
        'name' => 'Enga',
      ),
      8 => 
      array (
        'code' => 'GU',
        'name' => 'Gulf',
      ),
      9 => 
      array (
        'code' => 'MD',
        'name' => 'Madang',
      ),
      10 => 
      array (
        'code' => 'MN',
        'name' => 'Manus',
      ),
      11 => 
      array (
        'code' => 'MB',
        'name' => 'Milne Bay',
      ),
      12 => 
      array (
        'code' => 'MR',
        'name' => 'Morobe',
      ),
      13 => 
      array (
        'code' => 'NC',
        'name' => 'National Capital',
      ),
      14 => 
      array (
        'code' => 'NI',
        'name' => 'New Ireland',
      ),
      15 => 
      array (
        'code' => 'NO',
        'name' => 'Northern',
      ),
      16 => 
      array (
        'code' => 'SA',
        'name' => 'Sandaun',
      ),
      17 => 
      array (
        'code' => 'SH',
        'name' => 'Southern Highlands',
      ),
      18 => 
      array (
        'code' => 'WE',
        'name' => 'Western',
      ),
      19 => 
      array (
        'code' => 'WH',
        'name' => 'Western Highlands',
      ),
      20 => 
      array (
        'code' => 'WB',
        'name' => 'West New Britain',
      ),
    ),
    'PH' => 
    array (
      1 => 
      array (
        'code' => 'ABR',
        'name' => 'Abra',
      ),
      2 => 
      array (
        'code' => 'ANO',
        'name' => 'Agusan del Norte',
      ),
      3 => 
      array (
        'code' => 'ASU',
        'name' => 'Agusan del Sur',
      ),
      4 => 
      array (
        'code' => 'AKL',
        'name' => 'Aklan',
      ),
      5 => 
      array (
        'code' => 'ALB',
        'name' => 'Albay',
      ),
      6 => 
      array (
        'code' => 'ANT',
        'name' => 'Antique',
      ),
      7 => 
      array (
        'code' => 'APY',
        'name' => 'Apayao',
      ),
      8 => 
      array (
        'code' => 'AUR',
        'name' => 'Aurora',
      ),
      9 => 
      array (
        'code' => 'BAS',
        'name' => 'Basilan',
      ),
      10 => 
      array (
        'code' => 'BTA',
        'name' => 'Bataan',
      ),
      11 => 
      array (
        'code' => 'BTE',
        'name' => 'Batanes',
      ),
      12 => 
      array (
        'code' => 'BTG',
        'name' => 'Batangas',
      ),
      13 => 
      array (
        'code' => 'BLR',
        'name' => 'Biliran',
      ),
      14 => 
      array (
        'code' => 'BEN',
        'name' => 'Benguet',
      ),
      15 => 
      array (
        'code' => 'BOL',
        'name' => 'Bohol',
      ),
      16 => 
      array (
        'code' => 'BUK',
        'name' => 'Bukidnon',
      ),
      17 => 
      array (
        'code' => 'BUL',
        'name' => 'Bulacan',
      ),
      18 => 
      array (
        'code' => 'CAG',
        'name' => 'Cagayan',
      ),
      19 => 
      array (
        'code' => 'CNO',
        'name' => 'Camarines Norte',
      ),
      20 => 
      array (
        'code' => 'CSU',
        'name' => 'Camarines Sur',
      ),
      21 => 
      array (
        'code' => 'CAM',
        'name' => 'Camiguin',
      ),
      22 => 
      array (
        'code' => 'CAP',
        'name' => 'Capiz',
      ),
      23 => 
      array (
        'code' => 'CAT',
        'name' => 'Catanduanes',
      ),
      24 => 
      array (
        'code' => 'CAV',
        'name' => 'Cavite',
      ),
      25 => 
      array (
        'code' => 'CEB',
        'name' => 'Cebu',
      ),
      26 => 
      array (
        'code' => 'CMP',
        'name' => 'Compostela',
      ),
      27 => 
      array (
        'code' => 'DNO',
        'name' => 'Davao del Norte',
      ),
      28 => 
      array (
        'code' => 'DSU',
        'name' => 'Davao del Sur',
      ),
      29 => 
      array (
        'code' => 'DOR',
        'name' => 'Davao Oriental',
      ),
      30 => 
      array (
        'code' => 'ESA',
        'name' => 'Eastern Samar',
      ),
      31 => 
      array (
        'code' => 'GUI',
        'name' => 'Guimaras',
      ),
      32 => 
      array (
        'code' => 'IFU',
        'name' => 'Ifugao',
      ),
      33 => 
      array (
        'code' => 'INO',
        'name' => 'Ilocos Norte',
      ),
      34 => 
      array (
        'code' => 'ISU',
        'name' => 'Ilocos Sur',
      ),
      35 => 
      array (
        'code' => 'ILO',
        'name' => 'Iloilo',
      ),
      36 => 
      array (
        'code' => 'ISA',
        'name' => 'Isabela',
      ),
      37 => 
      array (
        'code' => 'KAL',
        'name' => 'Kalinga',
      ),
      38 => 
      array (
        'code' => 'LAG',
        'name' => 'Laguna',
      ),
      39 => 
      array (
        'code' => 'LNO',
        'name' => 'Lanao del Norte',
      ),
      40 => 
      array (
        'code' => 'LSU',
        'name' => 'Lanao del Sur',
      ),
      41 => 
      array (
        'code' => 'UNI',
        'name' => 'La Union',
      ),
      42 => 
      array (
        'code' => 'LEY',
        'name' => 'Leyte',
      ),
      43 => 
      array (
        'code' => 'MAG',
        'name' => 'Maguindanao',
      ),
      44 => 
      array (
        'code' => 'MRN',
        'name' => 'Marinduque',
      ),
      45 => 
      array (
        'code' => 'MSB',
        'name' => 'Masbate',
      ),
      46 => 
      array (
        'code' => 'MIC',
        'name' => 'Mindoro Occidental',
      ),
      47 => 
      array (
        'code' => 'MIR',
        'name' => 'Mindoro Oriental',
      ),
      48 => 
      array (
        'code' => 'MSC',
        'name' => 'Misamis Occidental',
      ),
      49 => 
      array (
        'code' => 'MOR',
        'name' => 'Misamis Oriental',
      ),
      50 => 
      array (
        'code' => 'MOP',
        'name' => 'Mountain',
      ),
      51 => 
      array (
        'code' => 'NOC',
        'name' => 'Negros Occidental',
      ),
      52 => 
      array (
        'code' => 'NOR',
        'name' => 'Negros Oriental',
      ),
      53 => 
      array (
        'code' => 'NCT',
        'name' => 'North Cotabato',
      ),
      54 => 
      array (
        'code' => 'NSM',
        'name' => 'Northern Samar',
      ),
      55 => 
      array (
        'code' => 'NEC',
        'name' => 'Nueva Ecija',
      ),
      56 => 
      array (
        'code' => 'NVZ',
        'name' => 'Nueva Vizcaya',
      ),
      57 => 
      array (
        'code' => 'PLW',
        'name' => 'Palawan',
      ),
      58 => 
      array (
        'code' => 'PMP',
        'name' => 'Pampanga',
      ),
      59 => 
      array (
        'code' => 'PNG',
        'name' => 'Pangasinan',
      ),
      60 => 
      array (
        'code' => 'QZN',
        'name' => 'Quezon',
      ),
      61 => 
      array (
        'code' => 'QRN',
        'name' => 'Quirino',
      ),
      62 => 
      array (
        'code' => 'RIZ',
        'name' => 'Rizal',
      ),
      63 => 
      array (
        'code' => 'ROM',
        'name' => 'Romblon',
      ),
      64 => 
      array (
        'code' => 'SMR',
        'name' => 'Samar',
      ),
      65 => 
      array (
        'code' => 'SRG',
        'name' => 'Sarangani',
      ),
      66 => 
      array (
        'code' => 'SQJ',
        'name' => 'Siquijor',
      ),
      67 => 
      array (
        'code' => 'SRS',
        'name' => 'Sorsogon',
      ),
      68 => 
      array (
        'code' => 'SCO',
        'name' => 'South Cotabato',
      ),
      69 => 
      array (
        'code' => 'SLE',
        'name' => 'Southern Leyte',
      ),
      70 => 
      array (
        'code' => 'SKU',
        'name' => 'Sultan Kudarat',
      ),
      71 => 
      array (
        'code' => 'SLU',
        'name' => 'Sulu',
      ),
      72 => 
      array (
        'code' => 'SNO',
        'name' => 'Surigao del Norte',
      ),
      73 => 
      array (
        'code' => 'SSU',
        'name' => 'Surigao del Sur',
      ),
      74 => 
      array (
        'code' => 'TAR',
        'name' => 'Tarlac',
      ),
      75 => 
      array (
        'code' => 'TAW',
        'name' => 'Tawi-Tawi',
      ),
      76 => 
      array (
        'code' => 'ZBL',
        'name' => 'Zambales',
      ),
      77 => 
      array (
        'code' => 'ZNO',
        'name' => 'Zamboanga del Norte',
      ),
      78 => 
      array (
        'code' => 'ZSU',
        'name' => 'Zamboanga del Sur',
      ),
      79 => 
      array (
        'code' => 'ZSI',
        'name' => 'Zamboanga Sibugay',
      ),
    ),
    'PK' => 
    array (
      1 => 
      array (
        'code' => 'B',
        'name' => 'Balochistan',
      ),
      2 => 
      array (
        'code' => 'T',
        'name' => 'Federally Administered Tribal Ar',
      ),
      3 => 
      array (
        'code' => 'I',
        'name' => 'Islamabad Capital Territory',
      ),
      4 => 
      array (
        'code' => 'N',
        'name' => 'North-West Frontier',
      ),
      5 => 
      array (
        'code' => 'P',
        'name' => 'Punjab',
      ),
      6 => 
      array (
        'code' => 'S',
        'name' => 'Sindh',
      ),
    ),
    'PL' => 
    array (
      1 => 
      array (
        'code' => 'DO',
        'name' => 'Dolnośląskie',
      ),
      2 => 
      array (
        'code' => 'KP',
        'name' => 'Kujawsko-Pomorskie',
      ),
      3 => 
      array (
        'code' => 'LL',
        'name' => 'Lubelskie',
      ),
      4 => 
      array (
        'code' => 'LU',
        'name' => 'Lubuskie',
      ),
      5 => 
      array (
        'code' => 'LO',
        'name' => 'Łódzkie',
      ),
      6 => 
      array (
        'code' => 'ML',
        'name' => 'Małopolskie',
      ),
      7 => 
      array (
        'code' => 'MZ',
        'name' => 'Mazowieckie',
      ),
      8 => 
      array (
        'code' => 'OP',
        'name' => 'Opolskie',
      ),
      9 => 
      array (
        'code' => 'PP',
        'name' => 'Podkarpackie',
      ),
      10 => 
      array (
        'code' => 'PL',
        'name' => 'Podlaskie',
      ),
      11 => 
      array (
        'code' => 'PM',
        'name' => 'Pomorskie',
      ),
      12 => 
      array (
        'code' => 'SL',
        'name' => 'Śląskie',
      ),
      13 => 
      array (
        'code' => 'SW',
        'name' => 'Świętokrzyskie',
      ),
      14 => 
      array (
        'code' => 'WM',
        'name' => 'Warmińsko-Mazurskie',
      ),
      15 => 
      array (
        'code' => 'WP',
        'name' => 'Wielkopolskie',
      ),
      16 => 
      array (
        'code' => 'ZA',
        'name' => 'Zachodniopomorskie',
      ),
    ),
    'PM' => 
    array (
      1 => 
      array (
        'code' => 'P',
        'name' => 'Saint Pierre',
      ),
      2 => 
      array (
        'code' => 'M',
        'name' => 'Miquelon',
      ),
    ),
    'PN' => 
    array (
      1 => 
      array (
        'code' => 'PIT',
        'name' => 'Pitcairn Island',
      ),
    ),
    'PR' => 
    array (
      1 => 
      array (
        'code' => 'A-A',
        'name' => 'Añasco',
      ),
      2 => 
      array (
        'code' => 'ADJ',
        'name' => 'Adjuntas',
      ),
      3 => 
      array (
        'code' => 'AGU',
        'name' => 'Aguada',
      ),
      4 => 
      array (
        'code' => 'AGU',
        'name' => 'Aguadilla',
      ),
      5 => 
      array (
        'code' => 'AGU',
        'name' => 'Aguas Buenas',
      ),
      6 => 
      array (
        'code' => 'AIB',
        'name' => 'Aibonito',
      ),
      7 => 
      array (
        'code' => 'ARE',
        'name' => 'Arecibo',
      ),
      8 => 
      array (
        'code' => 'ARR',
        'name' => 'Arroyo',
      ),
      9 => 
      array (
        'code' => 'BAR',
        'name' => 'Barceloneta',
      ),
      10 => 
      array (
        'code' => 'BAR',
        'name' => 'Barranquitas',
      ),
      11 => 
      array (
        'code' => 'BAY',
        'name' => 'Bayamón',
      ),
      12 => 
      array (
        'code' => 'CAB',
        'name' => 'Cabo Rojo',
      ),
      13 => 
      array (
        'code' => 'CAG',
        'name' => 'Caguas',
      ),
      14 => 
      array (
        'code' => 'CAM',
        'name' => 'Camuy',
      ),
      15 => 
      array (
        'code' => 'CAN',
        'name' => 'Canóvanas',
      ),
      16 => 
      array (
        'code' => 'CAR',
        'name' => 'Carolina',
      ),
      17 => 
      array (
        'code' => 'CAT',
        'name' => 'Cataño',
      ),
      18 => 
      array (
        'code' => 'CAY',
        'name' => 'Cayey',
      ),
      19 => 
      array (
        'code' => 'CEI',
        'name' => 'Ceiba',
      ),
      20 => 
      array (
        'code' => 'CIA',
        'name' => 'Ciales',
      ),
      21 => 
      array (
        'code' => 'CID',
        'name' => 'Cidra',
      ),
      22 => 
      array (
        'code' => 'COA',
        'name' => 'Coamo',
      ),
      23 => 
      array (
        'code' => 'COM',
        'name' => 'Comerío',
      ),
      24 => 
      array (
        'code' => 'COR',
        'name' => 'Corozal',
      ),
      25 => 
      array (
        'code' => 'CUL',
        'name' => 'Culebra',
      ),
      26 => 
      array (
        'code' => 'DOR',
        'name' => 'Dorado',
      ),
      27 => 
      array (
        'code' => 'FAJ',
        'name' => 'Fajardo',
      ),
      28 => 
      array (
        'code' => 'FLO',
        'name' => 'Florida',
      ),
      29 => 
      array (
        'code' => 'GUA',
        'name' => 'Guayama',
      ),
      30 => 
      array (
        'code' => 'GUA',
        'name' => 'Guayanilla',
      ),
      31 => 
      array (
        'code' => 'GUA',
        'name' => 'Guaynabo',
      ),
      32 => 
      array (
        'code' => 'GUR',
        'name' => 'Gurabo',
      ),
      33 => 
      array (
        'code' => 'GU¡',
        'name' => 'Guánica',
      ),
      34 => 
      array (
        'code' => 'HAT',
        'name' => 'Hatillo',
      ),
      35 => 
      array (
        'code' => 'HOR',
        'name' => 'Hormigueros',
      ),
      36 => 
      array (
        'code' => 'HUM',
        'name' => 'Humacao',
      ),
      37 => 
      array (
        'code' => 'ISA',
        'name' => 'Isabela',
      ),
      38 => 
      array (
        'code' => 'JAY',
        'name' => 'Jayuya',
      ),
      39 => 
      array (
        'code' => 'JUA',
        'name' => 'Juana Díaz',
      ),
      40 => 
      array (
        'code' => 'JUN',
        'name' => 'Juncos',
      ),
      41 => 
      array (
        'code' => 'LAJ',
        'name' => 'Lajas',
      ),
      42 => 
      array (
        'code' => 'LAR',
        'name' => 'Lares',
      ),
      43 => 
      array (
        'code' => 'LAS',
        'name' => 'Las Marías',
      ),
      44 => 
      array (
        'code' => 'LAS',
        'name' => 'Las Piedras',
      ),
      45 => 
      array (
        'code' => 'LOÕ',
        'name' => 'Loíza',
      ),
      46 => 
      array (
        'code' => 'LUQ',
        'name' => 'Luquillo',
      ),
      47 => 
      array (
        'code' => 'MAN',
        'name' => 'Manatí',
      ),
      48 => 
      array (
        'code' => 'MAR',
        'name' => 'Maricao',
      ),
      49 => 
      array (
        'code' => 'MAU',
        'name' => 'Maunabo',
      ),
      50 => 
      array (
        'code' => 'MAY',
        'name' => 'Mayagüez',
      ),
      51 => 
      array (
        'code' => 'MOC',
        'name' => 'Moca',
      ),
      52 => 
      array (
        'code' => 'MOR',
        'name' => 'Morovis',
      ),
      53 => 
      array (
        'code' => 'NAG',
        'name' => 'Naguabo',
      ),
      54 => 
      array (
        'code' => 'NAR',
        'name' => 'Naranjito',
      ),
      55 => 
      array (
        'code' => 'ORO',
        'name' => 'Orocovis',
      ),
      56 => 
      array (
        'code' => 'PAT',
        'name' => 'Patillas',
      ),
      57 => 
      array (
        'code' => 'PE-',
        'name' => 'Peñuelas',
      ),
      58 => 
      array (
        'code' => 'PON',
        'name' => 'Ponce',
      ),
      59 => 
      array (
        'code' => 'QUE',
        'name' => 'Quebradillas',
      ),
      60 => 
      array (
        'code' => 'RIN',
        'name' => 'Rincón',
      ),
      61 => 
      array (
        'code' => 'RIO',
        'name' => 'Rio Grande',
      ),
      62 => 
      array (
        'code' => 'SAB',
        'name' => 'Sabana Grande',
      ),
      63 => 
      array (
        'code' => 'SAL',
        'name' => 'Salinas',
      ),
      64 => 
      array (
        'code' => 'SAN',
        'name' => 'San Germàn',
      ),
      65 => 
      array (
        'code' => 'SAN',
        'name' => 'San Juan',
      ),
      66 => 
      array (
        'code' => 'SAN',
        'name' => 'San Lorenzo',
      ),
      67 => 
      array (
        'code' => 'SAN',
        'name' => 'San Sebastiàn',
      ),
      68 => 
      array (
        'code' => 'SAN',
        'name' => 'Santa Isabel',
      ),
      69 => 
      array (
        'code' => 'TOA',
        'name' => 'Toa Alta',
      ),
      70 => 
      array (
        'code' => 'TOA',
        'name' => 'Toa Baja',
      ),
      71 => 
      array (
        'code' => 'TRU',
        'name' => 'Trujillo Alto',
      ),
      72 => 
      array (
        'code' => 'UTU',
        'name' => 'Utuado',
      ),
      73 => 
      array (
        'code' => 'VEG',
        'name' => 'Vega Alta',
      ),
      74 => 
      array (
        'code' => 'VEG',
        'name' => 'Vega Baja',
      ),
      75 => 
      array (
        'code' => 'VIE',
        'name' => 'Vieques',
      ),
      76 => 
      array (
        'code' => 'VIL',
        'name' => 'Villalba',
      ),
      77 => 
      array (
        'code' => 'YAB',
        'name' => 'Yabucoa',
      ),
      78 => 
      array (
        'code' => 'YAU',
        'name' => 'Yauco',
      ),
    ),
    'PT' => 
    array (
      1 => 
      array (
        'code' => 'AC',
        'name' => 'Açores',
      ),
      2 => 
      array (
        'code' => 'AV',
        'name' => 'Aveiro',
      ),
      3 => 
      array (
        'code' => 'BE',
        'name' => 'Beja',
      ),
      4 => 
      array (
        'code' => 'BR',
        'name' => 'Braga',
      ),
      5 => 
      array (
        'code' => 'BA',
        'name' => 'Bragança',
      ),
      6 => 
      array (
        'code' => 'CB',
        'name' => 'Castelo Branco',
      ),
      7 => 
      array (
        'code' => 'CO',
        'name' => 'Coimbra',
      ),
      8 => 
      array (
        'code' => 'EV',
        'name' => 'évora',
      ),
      9 => 
      array (
        'code' => 'FA',
        'name' => 'Faro',
      ),
      10 => 
      array (
        'code' => 'GU',
        'name' => 'Guarda',
      ),
      12 => 
      array (
        'code' => 'LE',
        'name' => 'Leiria',
      ),
      13 => 
      array (
        'code' => 'LI',
        'name' => 'Lisboa',
      ),
      14 => 
      array (
        'code' => 'ME',
        'name' => 'Madeira',
      ),
      15 => 
      array (
        'code' => 'PO',
        'name' => 'Portalegre',
      ),
      16 => 
      array (
        'code' => 'PR',
        'name' => 'Porto',
      ),
      17 => 
      array (
        'code' => 'SA',
        'name' => 'Santarém',
      ),
      18 => 
      array (
        'code' => 'SE',
        'name' => 'SetÚbal',
      ),
      19 => 
      array (
        'code' => 'VC',
        'name' => 'Viana do Castelo',
      ),
      20 => 
      array (
        'code' => 'VR',
        'name' => 'Vila Real',
      ),
      21 => 
      array (
        'code' => 'VI',
        'name' => 'Viseu',
      ),
    ),
    'PW' => 
    array (
      1 => 
      array (
        'code' => 'AM',
        'name' => 'Aimeliik',
      ),
      2 => 
      array (
        'code' => 'AR',
        'name' => 'Airai',
      ),
      3 => 
      array (
        'code' => 'AN',
        'name' => 'Angaur',
      ),
      4 => 
      array (
        'code' => 'HA',
        'name' => 'Hatohobei',
      ),
      5 => 
      array (
        'code' => 'KA',
        'name' => 'Kayangel',
      ),
      6 => 
      array (
        'code' => 'KO',
        'name' => 'Koror',
      ),
      7 => 
      array (
        'code' => 'ME',
        'name' => 'Melekeok',
      ),
      8 => 
      array (
        'code' => 'NA',
        'name' => 'Ngaraard',
      ),
      9 => 
      array (
        'code' => 'NG',
        'name' => 'Ngarchelong',
      ),
      10 => 
      array (
        'code' => 'ND',
        'name' => 'Ngardmau',
      ),
      11 => 
      array (
        'code' => 'NT',
        'name' => 'Ngatpang',
      ),
      12 => 
      array (
        'code' => 'NC',
        'name' => 'Ngchesar',
      ),
      13 => 
      array (
        'code' => 'NR',
        'name' => 'Ngeremlengui',
      ),
      14 => 
      array (
        'code' => 'NW',
        'name' => 'Ngiwal',
      ),
      15 => 
      array (
        'code' => 'PE',
        'name' => 'Peleliu',
      ),
      16 => 
      array (
        'code' => 'SO',
        'name' => 'Sonsorol',
      ),
    ),
    'PY' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => 'Alto Paraguay',
      ),
      2 => 
      array (
        'code' => 'AN',
        'name' => 'Alto Parana',
      ),
      3 => 
      array (
        'code' => 'AM',
        'name' => 'Amambay',
      ),
      4 => 
      array (
        'code' => 'AS',
        'name' => 'Asuncion',
      ),
      5 => 
      array (
        'code' => 'BO',
        'name' => 'Boqueron',
      ),
      6 => 
      array (
        'code' => 'CG',
        'name' => 'Caaguazu',
      ),
      7 => 
      array (
        'code' => 'CZ',
        'name' => 'Caazapa',
      ),
      8 => 
      array (
        'code' => 'CN',
        'name' => 'Canindeyu',
      ),
      9 => 
      array (
        'code' => 'CE',
        'name' => 'Central',
      ),
      10 => 
      array (
        'code' => 'CC',
        'name' => 'Concepcion',
      ),
      11 => 
      array (
        'code' => 'CD',
        'name' => 'Cordillera',
      ),
      12 => 
      array (
        'code' => 'GU',
        'name' => 'Guaira',
      ),
      13 => 
      array (
        'code' => 'IT',
        'name' => 'Itapua',
      ),
      14 => 
      array (
        'code' => 'MI',
        'name' => 'Misiones',
      ),
      15 => 
      array (
        'code' => 'NE',
        'name' => 'Neembucu',
      ),
      16 => 
      array (
        'code' => 'PA',
        'name' => 'Paraguari',
      ),
      17 => 
      array (
        'code' => 'PH',
        'name' => 'Presidente Hayes',
      ),
      18 => 
      array (
        'code' => 'SP',
        'name' => 'San Pedro',
      ),
    ),
    'QA' => 
    array (
      1 => 
      array (
        'code' => 'DW',
        'name' => 'Ad Dawhah',
      ),
      2 => 
      array (
        'code' => 'GW',
        'name' => 'Al Ghuwayriyah',
      ),
      3 => 
      array (
        'code' => 'JM',
        'name' => 'Al Jumayliyah',
      ),
      4 => 
      array (
        'code' => 'KR',
        'name' => 'Al Khawr',
      ),
      5 => 
      array (
        'code' => 'WK',
        'name' => 'Al Wakrah',
      ),
      6 => 
      array (
        'code' => 'RN',
        'name' => 'Ar Rayyan',
      ),
      7 => 
      array (
        'code' => 'JB',
        'name' => 'Jarayan al Batinah',
      ),
      8 => 
      array (
        'code' => 'MS',
        'name' => 'Madinat ash Shamal',
      ),
      9 => 
      array (
        'code' => 'UD',
        'name' => 'Umm Sa&#39;id',
      ),
      10 => 
      array (
        'code' => 'UL',
        'name' => 'Umm Salal',
      ),
    ),
    'RO' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => 'Alba',
      ),
      2 => 
      array (
        'code' => 'AR',
        'name' => 'Arad',
      ),
      3 => 
      array (
        'code' => 'AG',
        'name' => 'Arges',
      ),
      4 => 
      array (
        'code' => 'BC',
        'name' => 'Bacau',
      ),
      5 => 
      array (
        'code' => 'BH',
        'name' => 'Bihor',
      ),
      6 => 
      array (
        'code' => 'BN',
        'name' => 'Bistrita-Nasaud',
      ),
      7 => 
      array (
        'code' => 'BT',
        'name' => 'Botosani',
      ),
      8 => 
      array (
        'code' => 'BV',
        'name' => 'Brasov',
      ),
      9 => 
      array (
        'code' => 'BR',
        'name' => 'Braila',
      ),
      10 => 
      array (
        'code' => 'B',
        'name' => 'Bucuresti',
      ),
      11 => 
      array (
        'code' => 'BZ',
        'name' => 'Buzau',
      ),
      12 => 
      array (
        'code' => 'CS',
        'name' => 'Caras-Severin',
      ),
      13 => 
      array (
        'code' => 'CL',
        'name' => 'Calarasi',
      ),
      14 => 
      array (
        'code' => 'CJ',
        'name' => 'Cluj',
      ),
      15 => 
      array (
        'code' => 'CT',
        'name' => 'Constanta',
      ),
      16 => 
      array (
        'code' => 'CV',
        'name' => 'Covasna',
      ),
      17 => 
      array (
        'code' => 'DB',
        'name' => 'Dimbovita',
      ),
      18 => 
      array (
        'code' => 'DJ',
        'name' => 'Dolj',
      ),
      19 => 
      array (
        'code' => 'GL',
        'name' => 'Galati',
      ),
      20 => 
      array (
        'code' => 'GR',
        'name' => 'Giurgiu',
      ),
      21 => 
      array (
        'code' => 'GJ',
        'name' => 'Gorj',
      ),
      22 => 
      array (
        'code' => 'HR',
        'name' => 'Harghita',
      ),
      23 => 
      array (
        'code' => 'HD',
        'name' => 'Hunedoara',
      ),
      24 => 
      array (
        'code' => 'IL',
        'name' => 'Ialomita',
      ),
      25 => 
      array (
        'code' => 'IS',
        'name' => 'Iasi',
      ),
      26 => 
      array (
        'code' => 'IF',
        'name' => 'Ilfov',
      ),
      27 => 
      array (
        'code' => 'MM',
        'name' => 'Maramures',
      ),
      28 => 
      array (
        'code' => 'MH',
        'name' => 'Mehedinti',
      ),
      29 => 
      array (
        'code' => 'MS',
        'name' => 'Mures',
      ),
      30 => 
      array (
        'code' => 'NT',
        'name' => 'Neamt',
      ),
      31 => 
      array (
        'code' => 'OT',
        'name' => 'Olt',
      ),
      32 => 
      array (
        'code' => 'PH',
        'name' => 'Prahova',
      ),
      33 => 
      array (
        'code' => 'SM',
        'name' => 'Satu-Mare',
      ),
      34 => 
      array (
        'code' => 'SJ',
        'name' => 'Salaj',
      ),
      35 => 
      array (
        'code' => 'SB',
        'name' => 'Sibiu',
      ),
      36 => 
      array (
        'code' => 'SV',
        'name' => 'Suceava',
      ),
      37 => 
      array (
        'code' => 'TR',
        'name' => 'Teleorman',
      ),
      38 => 
      array (
        'code' => 'TM',
        'name' => 'Timis',
      ),
      39 => 
      array (
        'code' => 'TL',
        'name' => 'Tulcea',
      ),
      40 => 
      array (
        'code' => 'VS',
        'name' => 'Vaslui',
      ),
      41 => 
      array (
        'code' => 'VL',
        'name' => 'Valcea',
      ),
      42 => 
      array (
        'code' => 'VN',
        'name' => 'Vrancea',
      ),
    ),
    'RU' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => 'Abakan',
      ),
      2 => 
      array (
        'code' => 'AG',
        'name' => 'Aginskoye',
      ),
      3 => 
      array (
        'code' => 'AN',
        'name' => 'Anadyr',
      ),
      4 => 
      array (
        'code' => 'AR',
        'name' => 'Arkahangelsk',
      ),
      5 => 
      array (
        'code' => 'AS',
        'name' => 'Astrakhan',
      ),
      6 => 
      array (
        'code' => 'BA',
        'name' => 'Barnaul',
      ),
      7 => 
      array (
        'code' => 'BE',
        'name' => 'Belgorod',
      ),
      8 => 
      array (
        'code' => 'BI',
        'name' => 'Birobidzhan',
      ),
      9 => 
      array (
        'code' => 'BL',
        'name' => 'Blagoveshchensk',
      ),
      10 => 
      array (
        'code' => 'BR',
        'name' => 'Bryansk',
      ),
      11 => 
      array (
        'code' => 'CH',
        'name' => 'Cheboksary',
      ),
      12 => 
      array (
        'code' => 'CL',
        'name' => 'Chelyabinsk',
      ),
      13 => 
      array (
        'code' => 'CR',
        'name' => 'Cherkessk',
      ),
      14 => 
      array (
        'code' => 'CI',
        'name' => 'Chita',
      ),
      15 => 
      array (
        'code' => 'DU',
        'name' => 'Dudinka',
      ),
      16 => 
      array (
        'code' => 'EL',
        'name' => 'Elista',
      ),
      17 => 
      array (
        'code' => 'GO',
        'name' => 'Gomo-Altaysk',
      ),
      18 => 
      array (
        'code' => 'GA',
        'name' => 'Gorno-Altaysk',
      ),
      19 => 
      array (
        'code' => 'GR',
        'name' => 'Groznyy',
      ),
      20 => 
      array (
        'code' => 'IR',
        'name' => 'Irkutsk',
      ),
      21 => 
      array (
        'code' => 'IV',
        'name' => 'Ivanovo',
      ),
      22 => 
      array (
        'code' => 'IZ',
        'name' => 'Izhevsk',
      ),
      23 => 
      array (
        'code' => 'KA',
        'name' => 'Kalinigrad',
      ),
      24 => 
      array (
        'code' => 'KL',
        'name' => 'Kaluga',
      ),
      25 => 
      array (
        'code' => 'KS',
        'name' => 'Kasnodar',
      ),
      26 => 
      array (
        'code' => 'KZ',
        'name' => 'Kazan',
      ),
      27 => 
      array (
        'code' => 'KE',
        'name' => 'Kemerovo',
      ),
      28 => 
      array (
        'code' => 'KH',
        'name' => 'Khabarovsk',
      ),
      29 => 
      array (
        'code' => 'KM',
        'name' => 'Khanty-Mansiysk',
      ),
      30 => 
      array (
        'code' => 'KO',
        'name' => 'Kostroma',
      ),
      31 => 
      array (
        'code' => 'KR',
        'name' => 'Krasnodar',
      ),
      32 => 
      array (
        'code' => 'KN',
        'name' => 'Krasnoyarsk',
      ),
      33 => 
      array (
        'code' => 'KU',
        'name' => 'Kudymkar',
      ),
      34 => 
      array (
        'code' => 'KG',
        'name' => 'Kurgan',
      ),
      35 => 
      array (
        'code' => 'KK',
        'name' => 'Kursk',
      ),
      36 => 
      array (
        'code' => 'KY',
        'name' => 'Kyzyl',
      ),
      37 => 
      array (
        'code' => 'LI',
        'name' => 'Lipetsk',
      ),
      38 => 
      array (
        'code' => 'MA',
        'name' => 'Magadan',
      ),
      39 => 
      array (
        'code' => 'MK',
        'name' => 'Makhachkala',
      ),
      40 => 
      array (
        'code' => 'MY',
        'name' => 'Maykop',
      ),
      41 => 
      array (
        'code' => 'MO',
        'name' => 'Moscow',
      ),
      42 => 
      array (
        'code' => 'MU',
        'name' => 'Murmansk',
      ),
      43 => 
      array (
        'code' => 'NA',
        'name' => 'Nalchik',
      ),
      44 => 
      array (
        'code' => 'NR',
        'name' => 'Naryan Mar',
      ),
      45 => 
      array (
        'code' => 'NZ',
        'name' => 'Nazran',
      ),
      46 => 
      array (
        'code' => 'NI',
        'name' => 'Nizhniy Novgorod',
      ),
      47 => 
      array (
        'code' => 'NO',
        'name' => 'Novgorod',
      ),
      48 => 
      array (
        'code' => 'NV',
        'name' => 'Novosibirsk',
      ),
      49 => 
      array (
        'code' => 'OM',
        'name' => 'Omsk',
      ),
      50 => 
      array (
        'code' => 'OR',
        'name' => 'Orel',
      ),
      51 => 
      array (
        'code' => 'OE',
        'name' => 'Orenburg',
      ),
      52 => 
      array (
        'code' => 'PA',
        'name' => 'Palana',
      ),
      53 => 
      array (
        'code' => 'PE',
        'name' => 'Penza',
      ),
      54 => 
      array (
        'code' => 'PR',
        'name' => 'Perm',
      ),
      55 => 
      array (
        'code' => 'PK',
        'name' => 'Petropavlovsk-Kamchatskiy',
      ),
      56 => 
      array (
        'code' => 'PT',
        'name' => 'Petrozavodsk',
      ),
      57 => 
      array (
        'code' => 'PS',
        'name' => 'Pskov',
      ),
      58 => 
      array (
        'code' => 'RO',
        'name' => 'Rostov-na-Donu',
      ),
      59 => 
      array (
        'code' => 'RY',
        'name' => 'Ryazan',
      ),
      60 => 
      array (
        'code' => 'SL',
        'name' => 'Salekhard',
      ),
      61 => 
      array (
        'code' => 'SA',
        'name' => 'Samara',
      ),
      62 => 
      array (
        'code' => 'SR',
        'name' => 'Saransk',
      ),
      63 => 
      array (
        'code' => 'SV',
        'name' => 'Saratov',
      ),
      64 => 
      array (
        'code' => 'SM',
        'name' => 'Smolensk',
      ),
      65 => 
      array (
        'code' => 'SP',
        'name' => 'St. Petersburg',
      ),
      66 => 
      array (
        'code' => 'ST',
        'name' => 'Stavropol',
      ),
      67 => 
      array (
        'code' => 'SY',
        'name' => 'Syktyvkar',
      ),
      68 => 
      array (
        'code' => 'TA',
        'name' => 'Tambov',
      ),
      69 => 
      array (
        'code' => 'TO',
        'name' => 'Tomsk',
      ),
      70 => 
      array (
        'code' => 'TU',
        'name' => 'Tula',
      ),
      71 => 
      array (
        'code' => 'TR',
        'name' => 'Tura',
      ),
      72 => 
      array (
        'code' => 'TV',
        'name' => 'Tver',
      ),
      73 => 
      array (
        'code' => 'TY',
        'name' => 'Tyumen',
      ),
      74 => 
      array (
        'code' => 'UF',
        'name' => 'Ufa',
      ),
      75 => 
      array (
        'code' => 'UL',
        'name' => 'Ul&#39;yanovsk',
      ),
      76 => 
      array (
        'code' => 'UU',
        'name' => 'Ulan-Ude',
      ),
      77 => 
      array (
        'code' => 'US',
        'name' => 'Ust&#39;-Ordynskiy',
      ),
      78 => 
      array (
        'code' => 'VL',
        'name' => 'Vladikavkaz',
      ),
      79 => 
      array (
        'code' => 'VA',
        'name' => 'Vladimir',
      ),
      80 => 
      array (
        'code' => 'VV',
        'name' => 'Vladivostok',
      ),
      81 => 
      array (
        'code' => 'VG',
        'name' => 'Volgograd',
      ),
      82 => 
      array (
        'code' => 'VD',
        'name' => 'Vologda',
      ),
      83 => 
      array (
        'code' => 'VO',
        'name' => 'Voronezh',
      ),
      84 => 
      array (
        'code' => 'VY',
        'name' => 'Vyatka',
      ),
      85 => 
      array (
        'code' => 'YA',
        'name' => 'Yakutsk',
      ),
      86 => 
      array (
        'code' => 'YR',
        'name' => 'Yaroslavl',
      ),
      87 => 
      array (
        'code' => 'YE',
        'name' => 'Yekaterinburg',
      ),
      88 => 
      array (
        'code' => 'YO',
        'name' => 'Yoshkar-Ola',
      ),
    ),
    'RW' => 
    array (
      1 => 
      array (
        'code' => 'BU',
        'name' => 'Butare',
      ),
      2 => 
      array (
        'code' => 'BY',
        'name' => 'Byumba',
      ),
      3 => 
      array (
        'code' => 'CY',
        'name' => 'Cyangugu',
      ),
      4 => 
      array (
        'code' => 'GK',
        'name' => 'Gikongoro',
      ),
      5 => 
      array (
        'code' => 'GS',
        'name' => 'Gisenyi',
      ),
      6 => 
      array (
        'code' => 'GT',
        'name' => 'Gitarama',
      ),
      7 => 
      array (
        'code' => 'KG',
        'name' => 'Kibungo',
      ),
      8 => 
      array (
        'code' => 'KY',
        'name' => 'Kibuye',
      ),
      9 => 
      array (
        'code' => 'KR',
        'name' => 'Kigali Rurale',
      ),
      10 => 
      array (
        'code' => 'KV',
        'name' => 'Kigali-ville',
      ),
      11 => 
      array (
        'code' => 'RU',
        'name' => 'Ruhengeri',
      ),
      12 => 
      array (
        'code' => 'UM',
        'name' => 'Umutara',
      ),
    ),
    'SA' => 
    array (
      1 => 
      array (
        'code' => 'BH',
        'name' => 'Al Bahah',
      ),
      2 => 
      array (
        'code' => 'HS',
        'name' => 'Al Hudud ash Shamaliyah',
      ),
      3 => 
      array (
        'code' => 'JF',
        'name' => 'Al Jawf',
      ),
      4 => 
      array (
        'code' => 'MD',
        'name' => 'Al Madinah',
      ),
      5 => 
      array (
        'code' => 'QS',
        'name' => 'Al Qasim',
      ),
      6 => 
      array (
        'code' => 'RD',
        'name' => 'Ar Riyad',
      ),
      7 => 
      array (
        'code' => 'AQ',
        'name' => 'Ash Sharqiyah (Eastern)',
      ),
      8 => 
      array (
        'code' => 'AS',
        'name' => '&#39;Asir',
      ),
      9 => 
      array (
        'code' => 'HL',
        'name' => 'Ha&#39;il',
      ),
      10 => 
      array (
        'code' => 'JZ',
        'name' => 'Jizan',
      ),
      11 => 
      array (
        'code' => 'ML',
        'name' => 'Makkah',
      ),
      12 => 
      array (
        'code' => 'NR',
        'name' => 'Najran',
      ),
      13 => 
      array (
        'code' => 'TB',
        'name' => 'Tabuk',
      ),
    ),
    'SB' => 
    array (
      1 => 
      array (
        'code' => 'CE',
        'name' => 'Central',
      ),
      2 => 
      array (
        'code' => 'CH',
        'name' => 'Choiseul',
      ),
      3 => 
      array (
        'code' => 'GC',
        'name' => 'Guadalcanal',
      ),
      4 => 
      array (
        'code' => 'HO',
        'name' => 'Honiara',
      ),
      5 => 
      array (
        'code' => 'IS',
        'name' => 'Isabel',
      ),
      6 => 
      array (
        'code' => 'MK',
        'name' => 'Makira',
      ),
      7 => 
      array (
        'code' => 'ML',
        'name' => 'Malaita',
      ),
      8 => 
      array (
        'code' => 'RB',
        'name' => 'Rennell and Bellona',
      ),
      9 => 
      array (
        'code' => 'TM',
        'name' => 'Temotu',
      ),
      10 => 
      array (
        'code' => 'WE',
        'name' => 'Western',
      ),
    ),
    'SC' => 
    array (
      1 => 
      array (
        'code' => 'AP',
        'name' => 'Anse aux Pins',
      ),
      2 => 
      array (
        'code' => 'AB',
        'name' => 'Anse Boileau',
      ),
      3 => 
      array (
        'code' => 'AE',
        'name' => 'Anse Etoile',
      ),
      4 => 
      array (
        'code' => 'AL',
        'name' => 'Anse Louis',
      ),
      5 => 
      array (
        'code' => 'AR',
        'name' => 'Anse Royale',
      ),
      6 => 
      array (
        'code' => 'BL',
        'name' => 'Baie Lazare',
      ),
      7 => 
      array (
        'code' => 'BS',
        'name' => 'Baie Sainte Anne',
      ),
      8 => 
      array (
        'code' => 'BV',
        'name' => 'Beau Vallon',
      ),
      9 => 
      array (
        'code' => 'BA',
        'name' => 'Bel Air',
      ),
      10 => 
      array (
        'code' => 'BO',
        'name' => 'Bel Ombre',
      ),
      11 => 
      array (
        'code' => 'CA',
        'name' => 'Cascade',
      ),
      12 => 
      array (
        'code' => 'GL',
        'name' => 'Glacis',
      ),
      13 => 
      array (
        'code' => 'GM',
        'name' => 'Grand&#39; Anse (on Mahe)',
      ),
      14 => 
      array (
        'code' => 'GP',
        'name' => 'Grand&#39; Anse (on Praslin)',
      ),
      15 => 
      array (
        'code' => 'DG',
        'name' => 'La Digue',
      ),
      16 => 
      array (
        'code' => 'RA',
        'name' => 'La Riviere Anglaise',
      ),
      17 => 
      array (
        'code' => 'MB',
        'name' => 'Mont Buxton',
      ),
      18 => 
      array (
        'code' => 'MF',
        'name' => 'Mont Fleuri',
      ),
      19 => 
      array (
        'code' => 'PL',
        'name' => 'Plaisance',
      ),
      20 => 
      array (
        'code' => 'PR',
        'name' => 'Pointe La Rue',
      ),
      21 => 
      array (
        'code' => 'PG',
        'name' => 'Port Glaud',
      ),
      22 => 
      array (
        'code' => 'SL',
        'name' => 'Saint Louis',
      ),
      23 => 
      array (
        'code' => 'TA',
        'name' => 'Takamaka',
      ),
    ),
    'SD' => 
    array (
      1 => 
      array (
        'code' => 'ANL',
        'name' => 'A&#39;ali an Nil',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => 'Al Bahr al Ahmar',
      ),
      3 => 
      array (
        'code' => 'BRT',
        'name' => 'Al Buhayrat',
      ),
      4 => 
      array (
        'code' => 'JZR',
        'name' => 'Al Jazirah',
      ),
      5 => 
      array (
        'code' => 'KRT',
        'name' => 'Al Khartum',
      ),
      6 => 
      array (
        'code' => 'QDR',
        'name' => 'Al Qadarif',
      ),
      7 => 
      array (
        'code' => 'WDH',
        'name' => 'Al Wahdah',
      ),
      8 => 
      array (
        'code' => 'ANB',
        'name' => 'An Nil al Abyad',
      ),
      9 => 
      array (
        'code' => 'ANZ',
        'name' => 'An Nil al Azraq',
      ),
      10 => 
      array (
        'code' => 'ASH',
        'name' => 'Ash Shamaliyah',
      ),
      11 => 
      array (
        'code' => 'BJA',
        'name' => 'Bahr al Jabal',
      ),
      12 => 
      array (
        'code' => 'GIS',
        'name' => 'Gharb al Istiwa&#39;iyah',
      ),
      13 => 
      array (
        'code' => 'GBG',
        'name' => 'Gharb Bahr al Ghazal',
      ),
      14 => 
      array (
        'code' => 'GDA',
        'name' => 'Gharb Darfur',
      ),
      15 => 
      array (
        'code' => 'GKU',
        'name' => 'Gharb Kurdufan',
      ),
      16 => 
      array (
        'code' => 'JDA',
        'name' => 'Janub Darfur',
      ),
      17 => 
      array (
        'code' => 'JKU',
        'name' => 'Janub Kurdufan',
      ),
      18 => 
      array (
        'code' => 'JQL',
        'name' => 'Junqali',
      ),
      19 => 
      array (
        'code' => 'KSL',
        'name' => 'Kassala',
      ),
      20 => 
      array (
        'code' => 'NNL',
        'name' => 'Nahr an Nil',
      ),
      21 => 
      array (
        'code' => 'SBG',
        'name' => 'Shamal Bahr al Ghazal',
      ),
      22 => 
      array (
        'code' => 'SDA',
        'name' => 'Shamal Darfur',
      ),
      23 => 
      array (
        'code' => 'SKU',
        'name' => 'Shamal Kurdufan',
      ),
      24 => 
      array (
        'code' => 'SIS',
        'name' => 'Sharq al Istiwa&#39;iyah',
      ),
      25 => 
      array (
        'code' => 'SNR',
        'name' => 'Sinnar',
      ),
      26 => 
      array (
        'code' => 'WRB',
        'name' => 'Warab',
      ),
    ),
    'SE' => 
    array (
      1 => 
      array (
        'code' => 'K',
        'name' => 'Blekinge',
      ),
      2 => 
      array (
        'code' => 'W',
        'name' => 'Dalama',
      ),
      3 => 
      array (
        'code' => 'I',
        'name' => 'Gotland',
      ),
      4 => 
      array (
        'code' => 'X',
        'name' => 'Gävleborg',
      ),
      5 => 
      array (
        'code' => 'N',
        'name' => 'Halland',
      ),
      6 => 
      array (
        'code' => 'Z',
        'name' => 'Jämtland',
      ),
      7 => 
      array (
        'code' => 'F',
        'name' => 'Jönköping',
      ),
      8 => 
      array (
        'code' => 'H',
        'name' => 'Kalmar',
      ),
      9 => 
      array (
        'code' => 'G',
        'name' => 'Kronoberg',
      ),
      10 => 
      array (
        'code' => 'BD',
        'name' => 'Norrbotten',
      ),
      11 => 
      array (
        'code' => 'M',
        'name' => 'Skåne',
      ),
      12 => 
      array (
        'code' => 'AB',
        'name' => 'Stockholm',
      ),
      13 => 
      array (
        'code' => 'D',
        'name' => 'Södermanland',
      ),
      14 => 
      array (
        'code' => 'C',
        'name' => 'Uppsala',
      ),
      15 => 
      array (
        'code' => 'S',
        'name' => 'Värmland',
      ),
      16 => 
      array (
        'code' => 'AC',
        'name' => 'Västerbotten',
      ),
      17 => 
      array (
        'code' => 'Y',
        'name' => 'Västernorrland',
      ),
      18 => 
      array (
        'code' => 'U',
        'name' => 'Västmanland',
      ),
      19 => 
      array (
        'code' => 'O',
        'name' => 'Västra Götaland',
      ),
      20 => 
      array (
        'code' => 'T',
        'name' => 'Örebro',
      ),
      21 => 
      array (
        'code' => 'E',
        'name' => 'Östergötland',
      ),
    ),
    'SH' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Ascension',
      ),
      2 => 
      array (
        'code' => 'S',
        'name' => 'Saint Helena',
      ),
      3 => 
      array (
        'code' => 'T',
        'name' => 'Tristan da Cunha',
      ),
    ),
    'SI' => 
    array (
      1 => 
      array (
        'code' => '4',
        'name' => 'Štajerska',
      ),
      2 => 
      array (
        'code' => '2A',
        'name' => 'Gorenjska',
      ),
      3 => 
      array (
        'code' => '5',
        'name' => 'Prekmurje',
      ),
      4 => 
      array (
        'code' => '3',
        'name' => 'Koroška',
      ),
      5 => 
      array (
        'code' => '2B',
        'name' => 'Notranjska',
      ),
      6 => 
      array (
        'code' => '1',
        'name' => 'Primorska',
      ),
      7 => 
      array (
        'code' => '2C',
        'name' => 'Dolenjska',
      ),
      8 => 
      array (
        'code' => '2C',
        'name' => 'Bela Krajina',
      ),
    ),
    'SK' => 
    array (
      1 => 
      array (
        'code' => 'BA',
        'name' => 'Banskobystricky',
      ),
      2 => 
      array (
        'code' => 'BR',
        'name' => 'Bratislavsky',
      ),
      3 => 
      array (
        'code' => 'KO',
        'name' => 'Kosicky',
      ),
      4 => 
      array (
        'code' => 'NI',
        'name' => 'Nitriansky',
      ),
      5 => 
      array (
        'code' => 'PR',
        'name' => 'Presovsky',
      ),
      6 => 
      array (
        'code' => 'TC',
        'name' => 'Trenciansky',
      ),
      7 => 
      array (
        'code' => 'TV',
        'name' => 'Trnavsky',
      ),
      8 => 
      array (
        'code' => 'ZI',
        'name' => 'Zilinsky',
      ),
    ),
    'SL' => 
    array (
      1 => 
      array (
        'code' => 'E',
        'name' => 'Eastern',
      ),
      2 => 
      array (
        'code' => 'N',
        'name' => 'Northern',
      ),
      3 => 
      array (
        'code' => 'S',
        'name' => 'Southern',
      ),
      4 => 
      array (
        'code' => 'W',
        'name' => 'Western',
      ),
    ),
    'SM' => 
    array (
      1 => 
      array (
        'code' => 'AC',
        'name' => 'Acquaviva',
      ),
      2 => 
      array (
        'code' => 'BM',
        'name' => 'Borgo Maggiore',
      ),
      3 => 
      array (
        'code' => 'CH',
        'name' => 'Chiesanuova',
      ),
      4 => 
      array (
        'code' => 'DO',
        'name' => 'Domagnano',
      ),
      5 => 
      array (
        'code' => 'FA',
        'name' => 'Faetano',
      ),
      6 => 
      array (
        'code' => 'FI',
        'name' => 'Fiorentino',
      ),
      7 => 
      array (
        'code' => 'MO',
        'name' => 'Montegiardino',
      ),
      8 => 
      array (
        'code' => 'SM',
        'name' => 'Citta di San Marino',
      ),
      9 => 
      array (
        'code' => 'SE',
        'name' => 'Serravalle',
      ),
    ),
    'SN' => 
    array (
      1 => 
      array (
        'code' => 'DA',
        'name' => 'Dakar',
      ),
      2 => 
      array (
        'code' => 'DI',
        'name' => 'Diourbel',
      ),
      3 => 
      array (
        'code' => 'FA',
        'name' => 'Fatick',
      ),
      4 => 
      array (
        'code' => 'KA',
        'name' => 'Kaolack',
      ),
      5 => 
      array (
        'code' => 'KO',
        'name' => 'Kolda',
      ),
      6 => 
      array (
        'code' => 'LO',
        'name' => 'Louga',
      ),
      7 => 
      array (
        'code' => 'MA',
        'name' => 'Matam',
      ),
      8 => 
      array (
        'code' => 'SL',
        'name' => 'Saint-Louis',
      ),
      9 => 
      array (
        'code' => 'TA',
        'name' => 'Tambacounda',
      ),
      10 => 
      array (
        'code' => 'TH',
        'name' => 'Thies',
      ),
      11 => 
      array (
        'code' => 'ZI',
        'name' => 'Ziguinchor',
      ),
    ),
    'SO' => 
    array (
      1 => 
      array (
        'code' => 'AW',
        'name' => 'Awdal',
      ),
      2 => 
      array (
        'code' => 'BK',
        'name' => 'Bakool',
      ),
      3 => 
      array (
        'code' => 'BN',
        'name' => 'Banaadir',
      ),
      4 => 
      array (
        'code' => 'BR',
        'name' => 'Bari',
      ),
      5 => 
      array (
        'code' => 'BY',
        'name' => 'Bay',
      ),
      6 => 
      array (
        'code' => 'GA',
        'name' => 'Galguduud',
      ),
      7 => 
      array (
        'code' => 'GE',
        'name' => 'Gedo',
      ),
      8 => 
      array (
        'code' => 'HI',
        'name' => 'Hiiraan',
      ),
      9 => 
      array (
        'code' => 'JD',
        'name' => 'Jubbada Dhexe',
      ),
      10 => 
      array (
        'code' => 'JH',
        'name' => 'Jubbada Hoose',
      ),
      11 => 
      array (
        'code' => 'MU',
        'name' => 'Mudug',
      ),
      12 => 
      array (
        'code' => 'NU',
        'name' => 'Nugaal',
      ),
      13 => 
      array (
        'code' => 'SA',
        'name' => 'Sanaag',
      ),
      14 => 
      array (
        'code' => 'SD',
        'name' => 'Shabeellaha Dhexe',
      ),
      15 => 
      array (
        'code' => 'SH',
        'name' => 'Shabeellaha Hoose',
      ),
      16 => 
      array (
        'code' => 'SL',
        'name' => 'Sool',
      ),
      17 => 
      array (
        'code' => 'TO',
        'name' => 'Togdheer',
      ),
      18 => 
      array (
        'code' => 'WG',
        'name' => 'Woqooyi Galbeed',
      ),
    ),
    'SR' => 
    array (
      1 => 
      array (
        'code' => 'BR',
        'name' => 'Brokopondo',
      ),
      2 => 
      array (
        'code' => 'CM',
        'name' => 'Commewijne',
      ),
      3 => 
      array (
        'code' => 'CR',
        'name' => 'Coronie',
      ),
      4 => 
      array (
        'code' => 'MA',
        'name' => 'Marowijne',
      ),
      5 => 
      array (
        'code' => 'NI',
        'name' => 'Nickerie',
      ),
      6 => 
      array (
        'code' => 'PA',
        'name' => 'Para',
      ),
      7 => 
      array (
        'code' => 'PM',
        'name' => 'Paramaribo',
      ),
      9 => 
      array (
        'code' => 'SA',
        'name' => 'Saramacca',
      ),
      10 => 
      array (
        'code' => 'SI',
        'name' => 'Sipaliwini',
      ),
      11 => 
      array (
        'code' => 'WA',
        'name' => 'Wanica',
      ),
    ),
    'ST' => 
    array (
      1 => 
      array (
        'code' => 'S',
        'name' => 'Sao Tome',
      ),
      2 => 
      array (
        'code' => 'P',
        'name' => 'Principe',
      ),
    ),
    'SV' => 
    array (
      1 => 
      array (
        'code' => 'AH',
        'name' => 'Ahuachapan',
      ),
      2 => 
      array (
        'code' => 'CA',
        'name' => 'Cabanas',
      ),
      3 => 
      array (
        'code' => 'CH',
        'name' => 'Chalatenango',
      ),
      4 => 
      array (
        'code' => 'CU',
        'name' => 'Cuscatlan',
      ),
      5 => 
      array (
        'code' => 'LB',
        'name' => 'La Libertad',
      ),
      6 => 
      array (
        'code' => 'PZ',
        'name' => 'La Paz',
      ),
      7 => 
      array (
        'code' => 'UN',
        'name' => 'La Union',
      ),
      8 => 
      array (
        'code' => 'MO',
        'name' => 'Morazan',
      ),
      9 => 
      array (
        'code' => 'SM',
        'name' => 'San Miguel',
      ),
      10 => 
      array (
        'code' => 'SS',
        'name' => 'San Salvador',
      ),
      11 => 
      array (
        'code' => 'SV',
        'name' => 'San Vicente',
      ),
      12 => 
      array (
        'code' => 'SA',
        'name' => 'Santa Ana',
      ),
      13 => 
      array (
        'code' => 'SO',
        'name' => 'Sonsonate',
      ),
      14 => 
      array (
        'code' => 'US',
        'name' => 'Usulutan',
      ),
    ),
    'SY' => 
    array (
      1 => 
      array (
        'code' => 'HA',
        'name' => 'Al Hasakah',
      ),
      2 => 
      array (
        'code' => 'LA',
        'name' => 'Al Ladhiqiyah',
      ),
      3 => 
      array (
        'code' => 'QU',
        'name' => 'Al Qunaytirah',
      ),
      4 => 
      array (
        'code' => 'RQ',
        'name' => 'Ar Raqqah',
      ),
      5 => 
      array (
        'code' => 'SU',
        'name' => 'As Suwayda',
      ),
      6 => 
      array (
        'code' => 'DA',
        'name' => 'Dara',
      ),
      7 => 
      array (
        'code' => 'DZ',
        'name' => 'Dayr az Zawr',
      ),
      8 => 
      array (
        'code' => 'DI',
        'name' => 'Dimashq',
      ),
      9 => 
      array (
        'code' => 'HL',
        'name' => 'Halab',
      ),
      10 => 
      array (
        'code' => 'HM',
        'name' => 'Hamah',
      ),
      11 => 
      array (
        'code' => 'HI',
        'name' => 'Hims',
      ),
      12 => 
      array (
        'code' => 'ID',
        'name' => 'Idlib',
      ),
      13 => 
      array (
        'code' => 'RD',
        'name' => 'Rif Dimashq',
      ),
      14 => 
      array (
        'code' => 'TA',
        'name' => 'Tartus',
      ),
    ),
    'SZ' => 
    array (
      1 => 
      array (
        'code' => 'H',
        'name' => 'Hhohho',
      ),
      2 => 
      array (
        'code' => 'L',
        'name' => 'Lubombo',
      ),
      3 => 
      array (
        'code' => 'M',
        'name' => 'Manzini',
      ),
      4 => 
      array (
        'code' => 'S',
        'name' => 'Shishelweni',
      ),
    ),
    'TC' => 
    array (
      1 => 
      array (
        'code' => 'AC',
        'name' => 'Ambergris Cays',
      ),
      2 => 
      array (
        'code' => 'DC',
        'name' => 'Dellis Cay',
      ),
      3 => 
      array (
        'code' => 'FC',
        'name' => 'French Cay',
      ),
      4 => 
      array (
        'code' => 'LW',
        'name' => 'Little Water Cay',
      ),
      5 => 
      array (
        'code' => 'RC',
        'name' => 'Parrot Cay',
      ),
      6 => 
      array (
        'code' => 'PN',
        'name' => 'Pine Cay',
      ),
      7 => 
      array (
        'code' => 'SL',
        'name' => 'Salt Cay',
      ),
      8 => 
      array (
        'code' => 'GT',
        'name' => 'Grand Turk',
      ),
      9 => 
      array (
        'code' => 'SC',
        'name' => 'South Caicos',
      ),
      10 => 
      array (
        'code' => 'EC',
        'name' => 'East Caicos',
      ),
      11 => 
      array (
        'code' => 'MC',
        'name' => 'Middle Caicos',
      ),
      12 => 
      array (
        'code' => 'NC',
        'name' => 'North Caicos',
      ),
      13 => 
      array (
        'code' => 'PR',
        'name' => 'Providenciales',
      ),
      14 => 
      array (
        'code' => 'WC',
        'name' => 'West Caicos',
      ),
    ),
    'TD' => 
    array (
      1 => 
      array (
        'code' => 'BA',
        'name' => 'Batha',
      ),
      2 => 
      array (
        'code' => 'BI',
        'name' => 'Biltine',
      ),
      3 => 
      array (
        'code' => 'BE',
        'name' => 'Borkou-Ennedi-Tibesti',
      ),
      4 => 
      array (
        'code' => 'CB',
        'name' => 'Chari-Baguirmi',
      ),
      5 => 
      array (
        'code' => 'GU',
        'name' => 'Guera',
      ),
      6 => 
      array (
        'code' => 'KA',
        'name' => 'Kanem',
      ),
      7 => 
      array (
        'code' => 'LA',
        'name' => 'Lac',
      ),
      8 => 
      array (
        'code' => 'LC',
        'name' => 'Logone Occidental',
      ),
      9 => 
      array (
        'code' => 'LR',
        'name' => 'Logone Oriental',
      ),
      10 => 
      array (
        'code' => 'MK',
        'name' => 'Mayo-Kebbi',
      ),
      11 => 
      array (
        'code' => 'MC',
        'name' => 'Moyen-Chari',
      ),
      12 => 
      array (
        'code' => 'OU',
        'name' => 'Ouaddai',
      ),
      13 => 
      array (
        'code' => 'SA',
        'name' => 'Salamat',
      ),
      14 => 
      array (
        'code' => 'TA',
        'name' => 'Tandjile',
      ),
    ),
    'TF' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => 'Iles Crozet',
      ),
      2 => 
      array (
        'code' => 'K',
        'name' => 'Iles Kerguelen',
      ),
      3 => 
      array (
        'code' => 'A',
        'name' => 'Ile Amsterdam',
      ),
      4 => 
      array (
        'code' => 'P',
        'name' => 'Ile Saint-Paul',
      ),
      5 => 
      array (
        'code' => 'D',
        'name' => 'Adelie Land',
      ),
    ),
    'TG' => 
    array (
      1 => 
      array (
        'code' => 'K',
        'name' => 'Kara',
      ),
      2 => 
      array (
        'code' => 'P',
        'name' => 'Plateaux',
      ),
      3 => 
      array (
        'code' => 'S',
        'name' => 'Savanes',
      ),
      4 => 
      array (
        'code' => 'C',
        'name' => 'Centrale',
      ),
      5 => 
      array (
        'code' => 'M',
        'name' => 'Maritime',
      ),
    ),
    'TH' => 
    array (
      1 => 
      array (
        'code' => 'Amnat Charoen',
        'name' => 'Amnat Charoen',
      ),
      2 => 
      array (
        'code' => 'Ang Thong',
        'name' => 'Ang Thong',
      ),
      3 => 
      array (
        'code' => 'Ayutthaya',
        'name' => 'Ayutthaya',
      ),
      4 => 
      array (
        'code' => 'Bangkok',
        'name' => 'Bangkok',
      ),
      5 => 
      array (
        'code' => 'Buriram',
        'name' => 'Buriram',
      ),
      6 => 
      array (
        'code' => 'Chachoengsao',
        'name' => 'Chachoengsao',
      ),
      7 => 
      array (
        'code' => 'Chai Nat',
        'name' => 'Chai Nat',
      ),
      8 => 
      array (
        'code' => 'Chaiyaphum',
        'name' => 'Chaiyaphum',
      ),
      9 => 
      array (
        'code' => 'Chanthaburi',
        'name' => 'Chanthaburi',
      ),
      10 => 
      array (
        'code' => 'Chiang Mai',
        'name' => 'Chiang Mai',
      ),
      11 => 
      array (
        'code' => 'Chiang Rai',
        'name' => 'Chiang Rai',
      ),
      12 => 
      array (
        'code' => 'Chon Buri',
        'name' => 'Chon Buri',
      ),
      13 => 
      array (
        'code' => 'Chumphon',
        'name' => 'Chumphon',
      ),
      14 => 
      array (
        'code' => 'Kalasin',
        'name' => 'Kalasin',
      ),
      15 => 
      array (
        'code' => 'Kamphaeng Phet',
        'name' => 'Kamphaeng Phet',
      ),
      16 => 
      array (
        'code' => 'Kanchanaburi',
        'name' => 'Kanchanaburi',
      ),
      17 => 
      array (
        'code' => 'Khon Kaen',
        'name' => 'Khon Kaen',
      ),
      18 => 
      array (
        'code' => 'Krabi',
        'name' => 'Krabi',
      ),
      19 => 
      array (
        'code' => 'Lampang',
        'name' => 'Lampang',
      ),
      20 => 
      array (
        'code' => 'Lamphun',
        'name' => 'Lamphun',
      ),
      21 => 
      array (
        'code' => 'Loei',
        'name' => 'Loei',
      ),
      22 => 
      array (
        'code' => 'Lop Buri',
        'name' => 'Lop Buri',
      ),
      23 => 
      array (
        'code' => 'Mae Hong Son',
        'name' => 'Mae Hong Son',
      ),
      24 => 
      array (
        'code' => 'Maha Sarakham',
        'name' => 'Maha Sarakham',
      ),
      25 => 
      array (
        'code' => 'Mukdahan',
        'name' => 'Mukdahan',
      ),
      26 => 
      array (
        'code' => 'Nakhon Nayok',
        'name' => 'Nakhon Nayok',
      ),
      27 => 
      array (
        'code' => 'Nakhon Pathom',
        'name' => 'Nakhon Pathom',
      ),
      28 => 
      array (
        'code' => 'Nakhon Phanom',
        'name' => 'Nakhon Phanom',
      ),
      29 => 
      array (
        'code' => 'Nakhon Ratchasima',
        'name' => 'Nakhon Ratchasima',
      ),
      30 => 
      array (
        'code' => 'Nakhon Sawan',
        'name' => 'Nakhon Sawan',
      ),
      31 => 
      array (
        'code' => 'Nakhon Si Thammarat',
        'name' => 'Nakhon Si Thammarat',
      ),
      32 => 
      array (
        'code' => 'Nan',
        'name' => 'Nan',
      ),
      33 => 
      array (
        'code' => 'Narathiwat',
        'name' => 'Narathiwat',
      ),
      34 => 
      array (
        'code' => 'Nong Bua Lamphu',
        'name' => 'Nong Bua Lamphu',
      ),
      35 => 
      array (
        'code' => 'Nong Khai',
        'name' => 'Nong Khai',
      ),
      36 => 
      array (
        'code' => 'Nonthaburi',
        'name' => 'Nonthaburi',
      ),
      37 => 
      array (
        'code' => 'Pathum Thani',
        'name' => 'Pathum Thani',
      ),
      38 => 
      array (
        'code' => 'Pattani',
        'name' => 'Pattani',
      ),
      39 => 
      array (
        'code' => 'Phangnga',
        'name' => 'Phangnga',
      ),
      40 => 
      array (
        'code' => 'Phatthalung',
        'name' => 'Phatthalung',
      ),
      41 => 
      array (
        'code' => 'Phayao',
        'name' => 'Phayao',
      ),
      42 => 
      array (
        'code' => 'Phetchabun',
        'name' => 'Phetchabun',
      ),
      43 => 
      array (
        'code' => 'Phetchaburi',
        'name' => 'Phetchaburi',
      ),
      44 => 
      array (
        'code' => 'Phichit',
        'name' => 'Phichit',
      ),
      45 => 
      array (
        'code' => 'Phitsanulok',
        'name' => 'Phitsanulok',
      ),
      46 => 
      array (
        'code' => 'Phrae',
        'name' => 'Phrae',
      ),
      47 => 
      array (
        'code' => 'Phuket',
        'name' => 'Phuket',
      ),
      48 => 
      array (
        'code' => 'Prachin Buri',
        'name' => 'Prachin Buri',
      ),
      49 => 
      array (
        'code' => 'Prachuap Khiri Khan',
        'name' => 'Prachuap Khiri Khan',
      ),
      50 => 
      array (
        'code' => 'Ranong',
        'name' => 'Ranong',
      ),
      51 => 
      array (
        'code' => 'Ratchaburi',
        'name' => 'Ratchaburi',
      ),
      52 => 
      array (
        'code' => 'Rayong',
        'name' => 'Rayong',
      ),
      53 => 
      array (
        'code' => 'Roi Et',
        'name' => 'Roi Et',
      ),
      54 => 
      array (
        'code' => 'Sa Kaeo',
        'name' => 'Sa Kaeo',
      ),
      55 => 
      array (
        'code' => 'Sakon Nakhon',
        'name' => 'Sakon Nakhon',
      ),
      56 => 
      array (
        'code' => 'Samut Prakan',
        'name' => 'Samut Prakan',
      ),
      57 => 
      array (
        'code' => 'Samut Sakhon',
        'name' => 'Samut Sakhon',
      ),
      58 => 
      array (
        'code' => 'Samut Songkhram',
        'name' => 'Samut Songkhram',
      ),
      59 => 
      array (
        'code' => 'Sara Buri',
        'name' => 'Sara Buri',
      ),
      60 => 
      array (
        'code' => 'Satun',
        'name' => 'Satun',
      ),
      61 => 
      array (
        'code' => 'Sing Buri',
        'name' => 'Sing Buri',
      ),
      62 => 
      array (
        'code' => 'Sisaket',
        'name' => 'Sisaket',
      ),
      63 => 
      array (
        'code' => 'Songkhla',
        'name' => 'Songkhla',
      ),
      64 => 
      array (
        'code' => 'Sukhothai',
        'name' => 'Sukhothai',
      ),
      65 => 
      array (
        'code' => 'Suphan Buri',
        'name' => 'Suphan Buri',
      ),
      66 => 
      array (
        'code' => 'Surat Thani',
        'name' => 'Surat Thani',
      ),
      67 => 
      array (
        'code' => 'Surin',
        'name' => 'Surin',
      ),
      68 => 
      array (
        'code' => 'Tak',
        'name' => 'Tak',
      ),
      69 => 
      array (
        'code' => 'Trang',
        'name' => 'Trang',
      ),
      70 => 
      array (
        'code' => 'Trat',
        'name' => 'Trat',
      ),
      71 => 
      array (
        'code' => 'Ubon Ratchathani',
        'name' => 'Ubon Ratchathani',
      ),
      72 => 
      array (
        'code' => 'Udon Thani',
        'name' => 'Udon Thani',
      ),
      73 => 
      array (
        'code' => 'Uthai Thani',
        'name' => 'Uthai Thani',
      ),
      74 => 
      array (
        'code' => 'Uttaradit',
        'name' => 'Uttaradit',
      ),
      75 => 
      array (
        'code' => 'Yala',
        'name' => 'Yala',
      ),
      76 => 
      array (
        'code' => 'Yasothon',
        'name' => 'Yasothon',
      ),
    ),
    'TJ' => 
    array (
      1 => 
      array (
        'code' => 'GB',
        'name' => 'Gorno-Badakhstan',
      ),
      2 => 
      array (
        'code' => 'KT',
        'name' => 'Khatlon',
      ),
      3 => 
      array (
        'code' => 'SU',
        'name' => 'Sughd',
      ),
    ),
    'TK' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Atafu',
      ),
      2 => 
      array (
        'code' => 'F',
        'name' => 'Fakaofo',
      ),
      3 => 
      array (
        'code' => 'N',
        'name' => 'Nukunonu',
      ),
    ),
    'TM' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Ahal Welayaty',
      ),
      2 => 
      array (
        'code' => 'B',
        'name' => 'Balkan Welayaty',
      ),
      3 => 
      array (
        'code' => 'D',
        'name' => 'Dashhowuz Welayaty',
      ),
      4 => 
      array (
        'code' => 'L',
        'name' => 'Lebap Welayaty',
      ),
      5 => 
      array (
        'code' => 'M',
        'name' => 'Mary Welayaty',
      ),
    ),
    'TN' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => 'Ariana',
      ),
      2 => 
      array (
        'code' => 'BJ',
        'name' => 'Beja',
      ),
      3 => 
      array (
        'code' => 'BA',
        'name' => 'Ben Arous',
      ),
      4 => 
      array (
        'code' => 'BI',
        'name' => 'Bizerte',
      ),
      5 => 
      array (
        'code' => 'GB',
        'name' => 'Gabes',
      ),
      6 => 
      array (
        'code' => 'GF',
        'name' => 'Gafsa',
      ),
      7 => 
      array (
        'code' => 'JE',
        'name' => 'Jendouba',
      ),
      8 => 
      array (
        'code' => 'KR',
        'name' => 'Kairouan',
      ),
      9 => 
      array (
        'code' => 'KS',
        'name' => 'Kasserine',
      ),
      10 => 
      array (
        'code' => 'KB',
        'name' => 'Kebili',
      ),
      11 => 
      array (
        'code' => 'KF',
        'name' => 'Kef',
      ),
      12 => 
      array (
        'code' => 'MH',
        'name' => 'Mahdia',
      ),
      13 => 
      array (
        'code' => 'MN',
        'name' => 'Manouba',
      ),
      14 => 
      array (
        'code' => 'ME',
        'name' => 'Medenine',
      ),
      15 => 
      array (
        'code' => 'MO',
        'name' => 'Monastir',
      ),
      16 => 
      array (
        'code' => 'NA',
        'name' => 'Nabeul',
      ),
      17 => 
      array (
        'code' => 'SF',
        'name' => 'Sfax',
      ),
      18 => 
      array (
        'code' => 'SD',
        'name' => 'Sidi',
      ),
      19 => 
      array (
        'code' => 'SL',
        'name' => 'Siliana',
      ),
      20 => 
      array (
        'code' => 'SO',
        'name' => 'Sousse',
      ),
      21 => 
      array (
        'code' => 'TA',
        'name' => 'Tataouine',
      ),
      22 => 
      array (
        'code' => 'TO',
        'name' => 'Tozeur',
      ),
      23 => 
      array (
        'code' => 'TU',
        'name' => 'Tunis',
      ),
      24 => 
      array (
        'code' => 'ZA',
        'name' => 'Zaghouan',
      ),
    ),
    'TO' => 
    array (
      1 => 
      array (
        'code' => 'H',
        'name' => 'Ha&#39;apai',
      ),
      2 => 
      array (
        'code' => 'T',
        'name' => 'Tongatapu',
      ),
      3 => 
      array (
        'code' => 'V',
        'name' => 'Vava&#39;u',
      ),
    ),
    'TP' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Aileu',
      ),
      2 => 
      array (
        'code' => 'AN',
        'name' => 'Ainaro',
      ),
      3 => 
      array (
        'code' => 'BA',
        'name' => 'Baucau',
      ),
      4 => 
      array (
        'code' => 'BO',
        'name' => 'Bobonaro',
      ),
      5 => 
      array (
        'code' => 'CO',
        'name' => 'Cova Lima',
      ),
      6 => 
      array (
        'code' => 'DI',
        'name' => 'Dili',
      ),
      7 => 
      array (
        'code' => 'ER',
        'name' => 'Ermera',
      ),
      8 => 
      array (
        'code' => 'LA',
        'name' => 'Lautem',
      ),
      9 => 
      array (
        'code' => 'LI',
        'name' => 'Liquica',
      ),
      10 => 
      array (
        'code' => 'MT',
        'name' => 'Manatuto',
      ),
      11 => 
      array (
        'code' => 'MF',
        'name' => 'Manufahi',
      ),
      12 => 
      array (
        'code' => 'OE',
        'name' => 'Oecussi',
      ),
      13 => 
      array (
        'code' => 'VI',
        'name' => 'Viqueque',
      ),
    ),
    'TR' => 
    array (
      1 => 
      array (
        'code' => 'ADA',
        'name' => 'Adana',
      ),
      2 => 
      array (
        'code' => 'ADI',
        'name' => 'Adiyaman',
      ),
      3 => 
      array (
        'code' => 'AFY',
        'name' => 'Afyonkarahisar',
      ),
      4 => 
      array (
        'code' => 'AGR',
        'name' => 'Agri',
      ),
      5 => 
      array (
        'code' => 'AKS',
        'name' => 'Aksaray',
      ),
      6 => 
      array (
        'code' => 'AMA',
        'name' => 'Amasya',
      ),
      7 => 
      array (
        'code' => 'ANK',
        'name' => 'Ankara',
      ),
      8 => 
      array (
        'code' => 'ANT',
        'name' => 'Antalya',
      ),
      9 => 
      array (
        'code' => 'ARD',
        'name' => 'Ardahan',
      ),
      10 => 
      array (
        'code' => 'ART',
        'name' => 'Artvin',
      ),
      11 => 
      array (
        'code' => 'AYI',
        'name' => 'Aydin',
      ),
      12 => 
      array (
        'code' => 'BAL',
        'name' => 'Balikesir',
      ),
      13 => 
      array (
        'code' => 'BAR',
        'name' => 'Bartin',
      ),
      14 => 
      array (
        'code' => 'BAT',
        'name' => 'Batman',
      ),
      15 => 
      array (
        'code' => 'BAY',
        'name' => 'Bayburt',
      ),
      16 => 
      array (
        'code' => 'BIL',
        'name' => 'Bilecik',
      ),
      17 => 
      array (
        'code' => 'BIN',
        'name' => 'Bingol',
      ),
      18 => 
      array (
        'code' => 'BIT',
        'name' => 'Bitlis',
      ),
      19 => 
      array (
        'code' => 'BOL',
        'name' => 'Bolu',
      ),
      20 => 
      array (
        'code' => 'BRD',
        'name' => 'Burdur',
      ),
      21 => 
      array (
        'code' => 'BRS',
        'name' => 'Bursa',
      ),
      22 => 
      array (
        'code' => 'CKL',
        'name' => 'Canakkale',
      ),
      23 => 
      array (
        'code' => 'CKR',
        'name' => 'Cankiri',
      ),
      24 => 
      array (
        'code' => 'COR',
        'name' => 'Corum',
      ),
      25 => 
      array (
        'code' => 'DEN',
        'name' => 'Denizli',
      ),
      26 => 
      array (
        'code' => 'DIY',
        'name' => 'Diyarbakir',
      ),
      27 => 
      array (
        'code' => 'DUZ',
        'name' => 'Duzce',
      ),
      28 => 
      array (
        'code' => 'EDI',
        'name' => 'Edirne',
      ),
      29 => 
      array (
        'code' => 'ELA',
        'name' => 'Elazig',
      ),
      30 => 
      array (
        'code' => 'EZC',
        'name' => 'Erzincan',
      ),
      31 => 
      array (
        'code' => 'EZR',
        'name' => 'Erzurum',
      ),
      32 => 
      array (
        'code' => 'ESK',
        'name' => 'Eskisehir',
      ),
      33 => 
      array (
        'code' => 'GAZ',
        'name' => 'Gaziantep',
      ),
      34 => 
      array (
        'code' => 'GIR',
        'name' => 'Giresun',
      ),
      35 => 
      array (
        'code' => 'GMS',
        'name' => 'Gumushane',
      ),
      36 => 
      array (
        'code' => 'HKR',
        'name' => 'Hakkari',
      ),
      37 => 
      array (
        'code' => 'HTY',
        'name' => 'Hatay',
      ),
      38 => 
      array (
        'code' => 'IGD',
        'name' => 'Igdir',
      ),
      39 => 
      array (
        'code' => 'ISP',
        'name' => 'Isparta',
      ),
      40 => 
      array (
        'code' => 'IST',
        'name' => 'Istanbul',
      ),
      41 => 
      array (
        'code' => 'IZM',
        'name' => 'Izmir',
      ),
      42 => 
      array (
        'code' => 'KAH',
        'name' => 'Kahramanmaras',
      ),
      43 => 
      array (
        'code' => 'KRB',
        'name' => 'Karabuk',
      ),
      44 => 
      array (
        'code' => 'KRM',
        'name' => 'Karaman',
      ),
      45 => 
      array (
        'code' => 'KRS',
        'name' => 'Kars',
      ),
      46 => 
      array (
        'code' => 'KAS',
        'name' => 'Kastamonu',
      ),
      47 => 
      array (
        'code' => 'KAY',
        'name' => 'Kayseri',
      ),
      48 => 
      array (
        'code' => 'KLS',
        'name' => 'Kilis',
      ),
      49 => 
      array (
        'code' => 'KRK',
        'name' => 'Kirikkale',
      ),
      50 => 
      array (
        'code' => 'KLR',
        'name' => 'Kirklareli',
      ),
      51 => 
      array (
        'code' => 'KRH',
        'name' => 'Kirsehir',
      ),
      52 => 
      array (
        'code' => 'KOC',
        'name' => 'Kocaeli',
      ),
      53 => 
      array (
        'code' => 'KON',
        'name' => 'Konya',
      ),
      54 => 
      array (
        'code' => 'KUT',
        'name' => 'Kutahya',
      ),
      55 => 
      array (
        'code' => 'MAL',
        'name' => 'Malatya',
      ),
      56 => 
      array (
        'code' => 'MAN',
        'name' => 'Manisa',
      ),
      57 => 
      array (
        'code' => 'MAR',
        'name' => 'Mardin',
      ),
      58 => 
      array (
        'code' => 'MER',
        'name' => 'Mersin',
      ),
      59 => 
      array (
        'code' => 'MUG',
        'name' => 'Mugla',
      ),
      60 => 
      array (
        'code' => 'MUS',
        'name' => 'Mus',
      ),
      61 => 
      array (
        'code' => 'NEV',
        'name' => 'Nevsehir',
      ),
      62 => 
      array (
        'code' => 'NIG',
        'name' => 'Nigde',
      ),
      63 => 
      array (
        'code' => 'ORD',
        'name' => 'Ordu',
      ),
      64 => 
      array (
        'code' => 'OSM',
        'name' => 'Osmaniye',
      ),
      65 => 
      array (
        'code' => 'RIZ',
        'name' => 'Rize',
      ),
      66 => 
      array (
        'code' => 'SAK',
        'name' => 'Sakarya',
      ),
      67 => 
      array (
        'code' => 'SAM',
        'name' => 'Samsun',
      ),
      68 => 
      array (
        'code' => 'SAN',
        'name' => 'Sanliurfa',
      ),
      69 => 
      array (
        'code' => 'SII',
        'name' => 'Siirt',
      ),
      70 => 
      array (
        'code' => 'SIN',
        'name' => 'Sinop',
      ),
      71 => 
      array (
        'code' => 'SIR',
        'name' => 'Sirnak',
      ),
      72 => 
      array (
        'code' => 'SIV',
        'name' => 'Sivas',
      ),
      73 => 
      array (
        'code' => 'TEL',
        'name' => 'Tekirdag',
      ),
      74 => 
      array (
        'code' => 'TOK',
        'name' => 'Tokat',
      ),
      75 => 
      array (
        'code' => 'TRA',
        'name' => 'Trabzon',
      ),
      76 => 
      array (
        'code' => 'TUN',
        'name' => 'Tunceli',
      ),
      77 => 
      array (
        'code' => 'USK',
        'name' => 'Usak',
      ),
      78 => 
      array (
        'code' => 'VAN',
        'name' => 'Van',
      ),
      79 => 
      array (
        'code' => 'YAL',
        'name' => 'Yalova',
      ),
      80 => 
      array (
        'code' => 'YOZ',
        'name' => 'Yozgat',
      ),
      81 => 
      array (
        'code' => 'ZON',
        'name' => 'Zonguldak',
      ),
    ),
    'TT' => 
    array (
      1 => 
      array (
        'code' => 'CT',
        'name' => 'Couva/Tabaquite/Talparo',
      ),
      2 => 
      array (
        'code' => 'DM',
        'name' => 'Diego Martin',
      ),
      3 => 
      array (
        'code' => 'MR',
        'name' => 'Mayaro/Rio Claro',
      ),
      4 => 
      array (
        'code' => 'PD',
        'name' => 'Penal/Debe',
      ),
      5 => 
      array (
        'code' => 'PT',
        'name' => 'Princes Town',
      ),
      6 => 
      array (
        'code' => 'SG',
        'name' => 'Sangre Grande',
      ),
      7 => 
      array (
        'code' => 'SL',
        'name' => 'San Juan/Laventille',
      ),
      8 => 
      array (
        'code' => 'SI',
        'name' => 'Siparia',
      ),
      9 => 
      array (
        'code' => 'TP',
        'name' => 'Tunapuna/Piarco',
      ),
      10 => 
      array (
        'code' => 'PS',
        'name' => 'Port of Spain',
      ),
      11 => 
      array (
        'code' => 'SF',
        'name' => 'San Fernando',
      ),
      12 => 
      array (
        'code' => 'AR',
        'name' => 'Arima',
      ),
      13 => 
      array (
        'code' => 'PF',
        'name' => 'Point Fortin',
      ),
      14 => 
      array (
        'code' => 'CH',
        'name' => 'Chaguanas',
      ),
      15 => 
      array (
        'code' => 'TO',
        'name' => 'Tobago',
      ),
    ),
    'TV' => 
    array (
      1 => 
      array (
        'code' => 'NMG',
        'name' => 'Nanumanga',
      ),
      2 => 
      array (
        'code' => 'NLK',
        'name' => 'Niulakita',
      ),
      3 => 
      array (
        'code' => 'NTO',
        'name' => 'Niutao',
      ),
      4 => 
      array (
        'code' => 'FUN',
        'name' => 'Funafuti',
      ),
      5 => 
      array (
        'code' => 'NME',
        'name' => 'Nanumea',
      ),
      6 => 
      array (
        'code' => 'NUI',
        'name' => 'Nui',
      ),
      7 => 
      array (
        'code' => 'NFT',
        'name' => 'Nukufetau',
      ),
      8 => 
      array (
        'code' => 'NLL',
        'name' => 'Nukulaelae',
      ),
      9 => 
      array (
        'code' => 'VAI',
        'name' => 'Vaitupu',
      ),
    ),
    'TW' => 
    array (
      1 => 
      array (
        'code' => 'CH',
        'name' => 'Chang-hua',
      ),
      2 => 
      array (
        'code' => 'CI',
        'name' => 'Chia-i',
      ),
      3 => 
      array (
        'code' => 'HS',
        'name' => 'Hsin-chu',
      ),
      4 => 
      array (
        'code' => 'HL',
        'name' => 'Hua-lien',
      ),
      5 => 
      array (
        'code' => 'IL',
        'name' => 'I-lan',
      ),
      6 => 
      array (
        'code' => 'KH',
        'name' => 'Kao-hsiung county',
      ),
      7 => 
      array (
        'code' => 'KM',
        'name' => 'Kin-men',
      ),
      8 => 
      array (
        'code' => 'LC',
        'name' => 'Lien-chiang',
      ),
      9 => 
      array (
        'code' => 'ML',
        'name' => 'Miao-li',
      ),
      10 => 
      array (
        'code' => 'NT',
        'name' => 'Nan-t&#39;ou',
      ),
      11 => 
      array (
        'code' => 'PH',
        'name' => 'P&#39;eng-hu',
      ),
      12 => 
      array (
        'code' => 'PT',
        'name' => 'P&#39;ing-tung',
      ),
      13 => 
      array (
        'code' => 'TG',
        'name' => 'T&#39;ai-chung',
      ),
      14 => 
      array (
        'code' => 'TA',
        'name' => 'T&#39;ai-nan',
      ),
      15 => 
      array (
        'code' => 'TP',
        'name' => 'T&#39;ai-pei county',
      ),
      16 => 
      array (
        'code' => 'TT',
        'name' => 'T&#39;ai-tung',
      ),
      17 => 
      array (
        'code' => 'TY',
        'name' => 'T&#39;ao-yuan',
      ),
      18 => 
      array (
        'code' => 'YL',
        'name' => 'Yun-lin',
      ),
      19 => 
      array (
        'code' => 'CC',
        'name' => 'Chia-i city',
      ),
      20 => 
      array (
        'code' => 'CL',
        'name' => 'Chi-lung',
      ),
      21 => 
      array (
        'code' => 'HC',
        'name' => 'Hsin-chu',
      ),
      22 => 
      array (
        'code' => 'TH',
        'name' => 'T&#39;ai-chung',
      ),
      23 => 
      array (
        'code' => 'TN',
        'name' => 'T&#39;ai-nan',
      ),
      24 => 
      array (
        'code' => 'KC',
        'name' => 'Kao-hsiung city',
      ),
      25 => 
      array (
        'code' => 'TC',
        'name' => 'T&#39;ai-pei city',
      ),
    ),
    'TZ' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => 'Arusha',
      ),
      2 => 
      array (
        'code' => 'DS',
        'name' => 'Dar es Salaam',
      ),
      3 => 
      array (
        'code' => 'DO',
        'name' => 'Dodoma',
      ),
      4 => 
      array (
        'code' => 'IR',
        'name' => 'Iringa',
      ),
      5 => 
      array (
        'code' => 'KA',
        'name' => 'Kagera',
      ),
      6 => 
      array (
        'code' => 'KI',
        'name' => 'Kigoma',
      ),
      7 => 
      array (
        'code' => 'KJ',
        'name' => 'Kilimanjaro',
      ),
      8 => 
      array (
        'code' => 'LN',
        'name' => 'Lindi',
      ),
      9 => 
      array (
        'code' => 'MY',
        'name' => 'Manyara',
      ),
      10 => 
      array (
        'code' => 'MR',
        'name' => 'Mara',
      ),
      11 => 
      array (
        'code' => 'MB',
        'name' => 'Mbeya',
      ),
      12 => 
      array (
        'code' => 'MO',
        'name' => 'Morogoro',
      ),
      13 => 
      array (
        'code' => 'MT',
        'name' => 'Mtwara',
      ),
      14 => 
      array (
        'code' => 'MW',
        'name' => 'Mwanza',
      ),
      15 => 
      array (
        'code' => 'PN',
        'name' => 'Pemba North',
      ),
      16 => 
      array (
        'code' => 'PS',
        'name' => 'Pemba South',
      ),
      17 => 
      array (
        'code' => 'PW',
        'name' => 'Pwani',
      ),
      18 => 
      array (
        'code' => 'RK',
        'name' => 'Rukwa',
      ),
      19 => 
      array (
        'code' => 'RV',
        'name' => 'Ruvuma',
      ),
      20 => 
      array (
        'code' => 'SH',
        'name' => 'Shinyanga',
      ),
      21 => 
      array (
        'code' => 'SI',
        'name' => 'Singida',
      ),
      22 => 
      array (
        'code' => 'TB',
        'name' => 'Tabora',
      ),
      23 => 
      array (
        'code' => 'TN',
        'name' => 'Tanga',
      ),
      24 => 
      array (
        'code' => 'ZC',
        'name' => 'Zanzibar Central/South',
      ),
      25 => 
      array (
        'code' => 'ZN',
        'name' => 'Zanzibar North',
      ),
      26 => 
      array (
        'code' => 'ZU',
        'name' => 'Zanzibar Urban/West',
      ),
    ),
    'UA' => 
    array (
      1 => 
      array (
        'code' => 'CK',
        'name' => 'Cherkasy',
      ),
      2 => 
      array (
        'code' => 'CH',
        'name' => 'Chernihiv',
      ),
      3 => 
      array (
        'code' => 'CV',
        'name' => 'Chernivtsi',
      ),
      4 => 
      array (
        'code' => 'CR',
        'name' => 'Crimea',
      ),
      5 => 
      array (
        'code' => 'DN',
        'name' => 'Dnipropetrovs&#39;k',
      ),
      6 => 
      array (
        'code' => 'DO',
        'name' => 'Donets&#39;k',
      ),
      7 => 
      array (
        'code' => 'IV',
        'name' => 'Ivano-Frankivs&#39;k',
      ),
      8 => 
      array (
        'code' => 'KL',
        'name' => 'Kharkiv Kherson',
      ),
      9 => 
      array (
        'code' => 'KM',
        'name' => 'Khmel&#39;nyts&#39;kyy',
      ),
      10 => 
      array (
        'code' => 'KR',
        'name' => 'Kirovohrad',
      ),
      11 => 
      array (
        'code' => 'KV',
        'name' => 'Kiev',
      ),
      12 => 
      array (
        'code' => 'KY',
        'name' => 'Kyyiv',
      ),
      13 => 
      array (
        'code' => 'LU',
        'name' => 'Luhans&#39;k',
      ),
      14 => 
      array (
        'code' => 'LV',
        'name' => 'L&#39;viv',
      ),
      15 => 
      array (
        'code' => 'MY',
        'name' => 'Mykolayiv',
      ),
      16 => 
      array (
        'code' => 'OD',
        'name' => 'Odesa',
      ),
      17 => 
      array (
        'code' => 'PO',
        'name' => 'Poltava',
      ),
      18 => 
      array (
        'code' => 'RI',
        'name' => 'Rivne',
      ),
      19 => 
      array (
        'code' => 'SE',
        'name' => 'Sevastopol',
      ),
      20 => 
      array (
        'code' => 'SU',
        'name' => 'Sumy',
      ),
      21 => 
      array (
        'code' => 'TE',
        'name' => 'Ternopil&#39;',
      ),
      22 => 
      array (
        'code' => 'VI',
        'name' => 'Vinnytsya',
      ),
      23 => 
      array (
        'code' => 'VO',
        'name' => 'Volyn&#39;',
      ),
      24 => 
      array (
        'code' => 'ZK',
        'name' => 'Zakarpattya',
      ),
      25 => 
      array (
        'code' => 'ZA',
        'name' => 'Zaporizhzhya',
      ),
      26 => 
      array (
        'code' => 'ZH',
        'name' => 'Zhytomyr',
      ),
    ),
    'UG' => 
    array (
      1 => 
      array (
        'code' => 'KAL',
        'name' => 'Kalangala',
      ),
      2 => 
      array (
        'code' => 'KMP',
        'name' => 'Kampala',
      ),
      3 => 
      array (
        'code' => 'KAY',
        'name' => 'Kayunga',
      ),
      4 => 
      array (
        'code' => 'KIB',
        'name' => 'Kiboga',
      ),
      5 => 
      array (
        'code' => 'LUW',
        'name' => 'Luwero',
      ),
      6 => 
      array (
        'code' => 'MAS',
        'name' => 'Masaka',
      ),
      7 => 
      array (
        'code' => 'MPI',
        'name' => 'Mpigi',
      ),
      8 => 
      array (
        'code' => 'MUB',
        'name' => 'Mubende',
      ),
      9 => 
      array (
        'code' => 'MUK',
        'name' => 'Mukono',
      ),
      10 => 
      array (
        'code' => 'NKS',
        'name' => 'Nakasongola',
      ),
      11 => 
      array (
        'code' => 'RAK',
        'name' => 'Rakai',
      ),
      12 => 
      array (
        'code' => 'SEM',
        'name' => 'Sembabule',
      ),
      13 => 
      array (
        'code' => 'WAK',
        'name' => 'Wakiso',
      ),
      14 => 
      array (
        'code' => 'BUG',
        'name' => 'Bugiri',
      ),
      15 => 
      array (
        'code' => 'BUS',
        'name' => 'Busia',
      ),
      16 => 
      array (
        'code' => 'IGA',
        'name' => 'Iganga',
      ),
      17 => 
      array (
        'code' => 'JIN',
        'name' => 'Jinja',
      ),
      18 => 
      array (
        'code' => 'KAB',
        'name' => 'Kaberamaido',
      ),
      19 => 
      array (
        'code' => 'KML',
        'name' => 'Kamuli',
      ),
      20 => 
      array (
        'code' => 'KPC',
        'name' => 'Kapchorwa',
      ),
      21 => 
      array (
        'code' => 'KTK',
        'name' => 'Katakwi',
      ),
      22 => 
      array (
        'code' => 'KUM',
        'name' => 'Kumi',
      ),
      23 => 
      array (
        'code' => 'MAY',
        'name' => 'Mayuge',
      ),
      24 => 
      array (
        'code' => 'MBA',
        'name' => 'Mbale',
      ),
      25 => 
      array (
        'code' => 'PAL',
        'name' => 'Pallisa',
      ),
      26 => 
      array (
        'code' => 'SIR',
        'name' => 'Sironko',
      ),
      27 => 
      array (
        'code' => 'SOR',
        'name' => 'Soroti',
      ),
      28 => 
      array (
        'code' => 'TOR',
        'name' => 'Tororo',
      ),
      29 => 
      array (
        'code' => 'ADJ',
        'name' => 'Adjumani',
      ),
      30 => 
      array (
        'code' => 'APC',
        'name' => 'Apac',
      ),
      31 => 
      array (
        'code' => 'ARU',
        'name' => 'Arua',
      ),
      32 => 
      array (
        'code' => 'GUL',
        'name' => 'Gulu',
      ),
      33 => 
      array (
        'code' => 'KIT',
        'name' => 'Kitgum',
      ),
      34 => 
      array (
        'code' => 'KOT',
        'name' => 'Kotido',
      ),
      35 => 
      array (
        'code' => 'LIR',
        'name' => 'Lira',
      ),
      36 => 
      array (
        'code' => 'MRT',
        'name' => 'Moroto',
      ),
      37 => 
      array (
        'code' => 'MOY',
        'name' => 'Moyo',
      ),
      38 => 
      array (
        'code' => 'NAK',
        'name' => 'Nakapiripirit',
      ),
      39 => 
      array (
        'code' => 'NEB',
        'name' => 'Nebbi',
      ),
      40 => 
      array (
        'code' => 'PAD',
        'name' => 'Pader',
      ),
      41 => 
      array (
        'code' => 'YUM',
        'name' => 'Yumbe',
      ),
      42 => 
      array (
        'code' => 'BUN',
        'name' => 'Bundibugyo',
      ),
      43 => 
      array (
        'code' => 'BSH',
        'name' => 'Bushenyi',
      ),
      44 => 
      array (
        'code' => 'HOI',
        'name' => 'Hoima',
      ),
      45 => 
      array (
        'code' => 'KBL',
        'name' => 'Kabale',
      ),
      46 => 
      array (
        'code' => 'KAR',
        'name' => 'Kabarole',
      ),
      47 => 
      array (
        'code' => 'KAM',
        'name' => 'Kamwenge',
      ),
      48 => 
      array (
        'code' => 'KAN',
        'name' => 'Kanungu',
      ),
      49 => 
      array (
        'code' => 'KAS',
        'name' => 'Kasese',
      ),
      50 => 
      array (
        'code' => 'KBA',
        'name' => 'Kibaale',
      ),
      51 => 
      array (
        'code' => 'KIS',
        'name' => 'Kisoro',
      ),
      52 => 
      array (
        'code' => 'KYE',
        'name' => 'Kyenjojo',
      ),
      53 => 
      array (
        'code' => 'MSN',
        'name' => 'Masindi',
      ),
      54 => 
      array (
        'code' => 'MBR',
        'name' => 'Mbarara',
      ),
      55 => 
      array (
        'code' => 'NTU',
        'name' => 'Ntungamo',
      ),
      56 => 
      array (
        'code' => 'RUK',
        'name' => 'Rukungiri',
      ),
    ),
    'UM' => 
    array (
      1 => 
      array (
        'code' => 'BI',
        'name' => 'Baker Island',
      ),
      2 => 
      array (
        'code' => 'HI',
        'name' => 'Howland Island',
      ),
      3 => 
      array (
        'code' => 'JI',
        'name' => 'Jarvis Island',
      ),
      4 => 
      array (
        'code' => 'JA',
        'name' => 'Johnston Atoll',
      ),
      5 => 
      array (
        'code' => 'KR',
        'name' => 'Kingman Reef',
      ),
      6 => 
      array (
        'code' => 'MA',
        'name' => 'Midway Atoll',
      ),
      7 => 
      array (
        'code' => 'NI',
        'name' => 'Navassa Island',
      ),
      8 => 
      array (
        'code' => 'PA',
        'name' => 'Palmyra Atoll',
      ),
      9 => 
      array (
        'code' => 'WI',
        'name' => 'Wake Island',
      ),
    ),
    'US' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Alabama',
      ),
      2 => 
      array (
        'code' => 'AK',
        'name' => 'Alaska',
      ),
      3 => 
      array (
        'code' => 'AS',
        'name' => 'American Samoa',
      ),
      4 => 
      array (
        'code' => 'AZ',
        'name' => 'Arizona',
      ),
      5 => 
      array (
        'code' => 'AR',
        'name' => 'Arkansas',
      ),
      6 => 
      array (
        'code' => 'AF',
        'name' => 'Armed Forces Africa',
      ),
      7 => 
      array (
        'code' => 'AA',
        'name' => 'Armed Forces Americas',
      ),
      8 => 
      array (
        'code' => 'AC',
        'name' => 'Armed Forces Canada',
      ),
      9 => 
      array (
        'code' => 'AE',
        'name' => 'Armed Forces Europe',
      ),
      10 => 
      array (
        'code' => 'AM',
        'name' => 'Armed Forces Middle East',
      ),
      11 => 
      array (
        'code' => 'AP',
        'name' => 'Armed Forces Pacific',
      ),
      12 => 
      array (
        'code' => 'CA',
        'name' => 'California',
      ),
      13 => 
      array (
        'code' => 'CO',
        'name' => 'Colorado',
      ),
      14 => 
      array (
        'code' => 'CT',
        'name' => 'Connecticut',
      ),
      15 => 
      array (
        'code' => 'DE',
        'name' => 'Delaware',
      ),
      16 => 
      array (
        'code' => 'DC',
        'name' => 'District of Columbia',
      ),
      17 => 
      array (
        'code' => 'FM',
        'name' => 'Federated States Of Micronesia',
      ),
      18 => 
      array (
        'code' => 'FL',
        'name' => 'Florida',
      ),
      19 => 
      array (
        'code' => 'GA',
        'name' => 'Georgia',
      ),
      20 => 
      array (
        'code' => 'GU',
        'name' => 'Guam',
      ),
      21 => 
      array (
        'code' => 'HI',
        'name' => 'Hawaii',
      ),
      22 => 
      array (
        'code' => 'ID',
        'name' => 'Idaho',
      ),
      23 => 
      array (
        'code' => 'IL',
        'name' => 'Illinois',
      ),
      24 => 
      array (
        'code' => 'IN',
        'name' => 'Indiana',
      ),
      25 => 
      array (
        'code' => 'IA',
        'name' => 'Iowa',
      ),
      26 => 
      array (
        'code' => 'KS',
        'name' => 'Kansas',
      ),
      27 => 
      array (
        'code' => 'KY',
        'name' => 'Kentucky',
      ),
      28 => 
      array (
        'code' => 'LA',
        'name' => 'Louisiana',
      ),
      29 => 
      array (
        'code' => 'ME',
        'name' => 'Maine',
      ),
      30 => 
      array (
        'code' => 'MH',
        'name' => 'Marshall Islands',
      ),
      31 => 
      array (
        'code' => 'MD',
        'name' => 'Maryland',
      ),
      32 => 
      array (
        'code' => 'MA',
        'name' => 'Massachusetts',
      ),
      33 => 
      array (
        'code' => 'MI',
        'name' => 'Michigan',
      ),
      34 => 
      array (
        'code' => 'MN',
        'name' => 'Minnesota',
      ),
      35 => 
      array (
        'code' => 'MS',
        'name' => 'Mississippi',
      ),
      36 => 
      array (
        'code' => 'MO',
        'name' => 'Missouri',
      ),
      37 => 
      array (
        'code' => 'MT',
        'name' => 'Montana',
      ),
      38 => 
      array (
        'code' => 'NE',
        'name' => 'Nebraska',
      ),
      39 => 
      array (
        'code' => 'NV',
        'name' => 'Nevada',
      ),
      40 => 
      array (
        'code' => 'NH',
        'name' => 'New Hampshire',
      ),
      41 => 
      array (
        'code' => 'NJ',
        'name' => 'New Jersey',
      ),
      42 => 
      array (
        'code' => 'NM',
        'name' => 'New Mexico',
      ),
      43 => 
      array (
        'code' => 'NY',
        'name' => 'New York',
      ),
      44 => 
      array (
        'code' => 'NC',
        'name' => 'North Carolina',
      ),
      45 => 
      array (
        'code' => 'ND',
        'name' => 'North Dakota',
      ),
      46 => 
      array (
        'code' => 'MP',
        'name' => 'Northern Mariana Islands',
      ),
      47 => 
      array (
        'code' => 'OH',
        'name' => 'Ohio',
      ),
      48 => 
      array (
        'code' => 'OK',
        'name' => 'Oklahoma',
      ),
      49 => 
      array (
        'code' => 'OR',
        'name' => 'Oregon',
      ),
      50 => 
      array (
        'code' => 'PW',
        'name' => 'Palau',
      ),
      51 => 
      array (
        'code' => 'PA',
        'name' => 'Pennsylvania',
      ),
      52 => 
      array (
        'code' => 'PR',
        'name' => 'Puerto Rico',
      ),
      53 => 
      array (
        'code' => 'RI',
        'name' => 'Rhode Island',
      ),
      54 => 
      array (
        'code' => 'SC',
        'name' => 'South Carolina',
      ),
      55 => 
      array (
        'code' => 'SD',
        'name' => 'South Dakota',
      ),
      56 => 
      array (
        'code' => 'TN',
        'name' => 'Tennessee',
      ),
      57 => 
      array (
        'code' => 'TX',
        'name' => 'Texas',
      ),
      58 => 
      array (
        'code' => 'UT',
        'name' => 'Utah',
      ),
      59 => 
      array (
        'code' => 'VT',
        'name' => 'Vermont',
      ),
      60 => 
      array (
        'code' => 'VI',
        'name' => 'Virgin Islands',
      ),
      61 => 
      array (
        'code' => 'VA',
        'name' => 'Virginia',
      ),
      62 => 
      array (
        'code' => 'WA',
        'name' => 'Washington',
      ),
      63 => 
      array (
        'code' => 'WV',
        'name' => 'West Virginia',
      ),
      64 => 
      array (
        'code' => 'WI',
        'name' => 'Wisconsin',
      ),
      65 => 
      array (
        'code' => 'WY',
        'name' => 'Wyoming',
      ),
    ),
    'UY' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => 'Artigas',
      ),
      2 => 
      array (
        'code' => 'CA',
        'name' => 'Canelones',
      ),
      3 => 
      array (
        'code' => 'CL',
        'name' => 'Cerro Largo',
      ),
      4 => 
      array (
        'code' => 'CO',
        'name' => 'Colonia',
      ),
      5 => 
      array (
        'code' => 'DU',
        'name' => 'Durazno',
      ),
      6 => 
      array (
        'code' => 'FS',
        'name' => 'Flores',
      ),
      7 => 
      array (
        'code' => 'FA',
        'name' => 'Florida',
      ),
      8 => 
      array (
        'code' => 'LA',
        'name' => 'Lavalleja',
      ),
      9 => 
      array (
        'code' => 'MA',
        'name' => 'Maldonado',
      ),
      10 => 
      array (
        'code' => 'MO',
        'name' => 'Montevideo',
      ),
      11 => 
      array (
        'code' => 'PA',
        'name' => 'Paysandu',
      ),
      12 => 
      array (
        'code' => 'RN',
        'name' => 'Rio Negro',
      ),
      13 => 
      array (
        'code' => 'RV',
        'name' => 'Rivera',
      ),
      14 => 
      array (
        'code' => 'RO',
        'name' => 'Rocha',
      ),
      15 => 
      array (
        'code' => 'SL',
        'name' => 'Salto',
      ),
      16 => 
      array (
        'code' => 'SJ',
        'name' => 'San Jose',
      ),
      17 => 
      array (
        'code' => 'SO',
        'name' => 'Soriano',
      ),
      18 => 
      array (
        'code' => 'TA',
        'name' => 'Tacuarembo',
      ),
      19 => 
      array (
        'code' => 'TT',
        'name' => 'Treinta y Tres',
      ),
    ),
    'UZ' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Andijon',
      ),
      2 => 
      array (
        'code' => 'BU',
        'name' => 'Buxoro',
      ),
      3 => 
      array (
        'code' => 'FA',
        'name' => 'Farg&#39;ona',
      ),
      4 => 
      array (
        'code' => 'JI',
        'name' => 'Jizzax',
      ),
      5 => 
      array (
        'code' => 'NG',
        'name' => 'Namangan',
      ),
      6 => 
      array (
        'code' => 'NW',
        'name' => 'Navoiy',
      ),
      7 => 
      array (
        'code' => 'QA',
        'name' => 'Qashqadaryo',
      ),
      8 => 
      array (
        'code' => 'QR',
        'name' => 'Qoraqalpog&#39;iston Republikasi',
      ),
      9 => 
      array (
        'code' => 'SA',
        'name' => 'Samarqand',
      ),
      10 => 
      array (
        'code' => 'SI',
        'name' => 'Sirdaryo',
      ),
      11 => 
      array (
        'code' => 'SU',
        'name' => 'Surxondaryo',
      ),
      12 => 
      array (
        'code' => 'TK',
        'name' => 'Toshkent City',
      ),
      13 => 
      array (
        'code' => 'TO',
        'name' => 'Toshkent Region',
      ),
      14 => 
      array (
        'code' => 'XO',
        'name' => 'Xorazm',
      ),
    ),
    'VC' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => 'Charlotte',
      ),
      2 => 
      array (
        'code' => 'R',
        'name' => 'Grenadines',
      ),
      3 => 
      array (
        'code' => 'A',
        'name' => 'Saint Andrew',
      ),
      4 => 
      array (
        'code' => 'D',
        'name' => 'Saint David',
      ),
      5 => 
      array (
        'code' => 'G',
        'name' => 'Saint George',
      ),
      6 => 
      array (
        'code' => 'P',
        'name' => 'Saint Patrick',
      ),
    ),
    'VE' => 
    array (
      1 => 
      array (
        'code' => 'AM',
        'name' => 'Amazonas',
      ),
      2 => 
      array (
        'code' => 'AN',
        'name' => 'Anzoategui',
      ),
      3 => 
      array (
        'code' => 'AP',
        'name' => 'Apure',
      ),
      4 => 
      array (
        'code' => 'AR',
        'name' => 'Aragua',
      ),
      5 => 
      array (
        'code' => 'BA',
        'name' => 'Barinas',
      ),
      6 => 
      array (
        'code' => 'BO',
        'name' => 'Bolivar',
      ),
      7 => 
      array (
        'code' => 'CA',
        'name' => 'Carabobo',
      ),
      8 => 
      array (
        'code' => 'CO',
        'name' => 'Cojedes',
      ),
      9 => 
      array (
        'code' => 'DA',
        'name' => 'Delta Amacuro',
      ),
      10 => 
      array (
        'code' => 'DF',
        'name' => 'Dependencias Federales',
      ),
      11 => 
      array (
        'code' => 'DI',
        'name' => 'Distrito Federal',
      ),
      12 => 
      array (
        'code' => 'FA',
        'name' => 'Falcon',
      ),
      13 => 
      array (
        'code' => 'GU',
        'name' => 'Guarico',
      ),
      14 => 
      array (
        'code' => 'LA',
        'name' => 'Lara',
      ),
      15 => 
      array (
        'code' => 'ME',
        'name' => 'Merida',
      ),
      16 => 
      array (
        'code' => 'MI',
        'name' => 'Miranda',
      ),
      17 => 
      array (
        'code' => 'MO',
        'name' => 'Monagas',
      ),
      18 => 
      array (
        'code' => 'NE',
        'name' => 'Nueva Esparta',
      ),
      19 => 
      array (
        'code' => 'PO',
        'name' => 'Portuguesa',
      ),
      20 => 
      array (
        'code' => 'SU',
        'name' => 'Sucre',
      ),
      21 => 
      array (
        'code' => 'TA',
        'name' => 'Tachira',
      ),
      22 => 
      array (
        'code' => 'TR',
        'name' => 'Trujillo',
      ),
      23 => 
      array (
        'code' => 'VA',
        'name' => 'Vargas',
      ),
      24 => 
      array (
        'code' => 'YA',
        'name' => 'Yaracuy',
      ),
      25 => 
      array (
        'code' => 'ZU',
        'name' => 'Zulia',
      ),
    ),
    'VI' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => 'Saint Croix',
      ),
      2 => 
      array (
        'code' => 'J',
        'name' => 'Saint John',
      ),
      3 => 
      array (
        'code' => 'T',
        'name' => 'Saint Thomas',
      ),
    ),
    'VN' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => 'An Giang',
      ),
      2 => 
      array (
        'code' => 'BG',
        'name' => 'Bac Giang',
      ),
      3 => 
      array (
        'code' => 'BK',
        'name' => 'Bac Kan',
      ),
      4 => 
      array (
        'code' => 'BL',
        'name' => 'Bac Lieu',
      ),
      5 => 
      array (
        'code' => 'BC',
        'name' => 'Bac Ninh',
      ),
      6 => 
      array (
        'code' => 'BR',
        'name' => 'Ba Ria-Vung Tau',
      ),
      7 => 
      array (
        'code' => 'BN',
        'name' => 'Ben Tre',
      ),
      8 => 
      array (
        'code' => 'BH',
        'name' => 'Binh Dinh',
      ),
      9 => 
      array (
        'code' => 'BU',
        'name' => 'Binh Duong',
      ),
      10 => 
      array (
        'code' => 'BP',
        'name' => 'Binh Phuoc',
      ),
      11 => 
      array (
        'code' => 'BT',
        'name' => 'Binh Thuan',
      ),
      12 => 
      array (
        'code' => 'CM',
        'name' => 'Ca Mau',
      ),
      13 => 
      array (
        'code' => 'CT',
        'name' => 'Can Tho',
      ),
      14 => 
      array (
        'code' => 'CB',
        'name' => 'Cao Bang',
      ),
      15 => 
      array (
        'code' => 'DL',
        'name' => 'Dak Lak',
      ),
      16 => 
      array (
        'code' => 'DG',
        'name' => 'Dak Nong',
      ),
      17 => 
      array (
        'code' => 'DN',
        'name' => 'Da Nang',
      ),
      18 => 
      array (
        'code' => 'DB',
        'name' => 'Dien Bien',
      ),
      19 => 
      array (
        'code' => 'DI',
        'name' => 'Dong Nai',
      ),
      20 => 
      array (
        'code' => 'DT',
        'name' => 'Dong Thap',
      ),
      21 => 
      array (
        'code' => 'GL',
        'name' => 'Gia Lai',
      ),
      22 => 
      array (
        'code' => 'HG',
        'name' => 'Ha Giang',
      ),
      23 => 
      array (
        'code' => 'HD',
        'name' => 'Hai Duong',
      ),
      24 => 
      array (
        'code' => 'HP',
        'name' => 'Hai Phong',
      ),
      25 => 
      array (
        'code' => 'HM',
        'name' => 'Ha Nam',
      ),
      26 => 
      array (
        'code' => 'HI',
        'name' => 'Ha Noi',
      ),
      27 => 
      array (
        'code' => 'HT',
        'name' => 'Ha Tay',
      ),
      28 => 
      array (
        'code' => 'HH',
        'name' => 'Ha Tinh',
      ),
      29 => 
      array (
        'code' => 'HB',
        'name' => 'Hoa Binh',
      ),
      30 => 
      array (
        'code' => 'HC',
        'name' => 'Ho Chin Minh',
      ),
      31 => 
      array (
        'code' => 'HU',
        'name' => 'Hau Giang',
      ),
      32 => 
      array (
        'code' => 'HY',
        'name' => 'Hung Yen',
      ),
    ),
    'VU' => 
    array (
      1 => 
      array (
        'code' => 'MA',
        'name' => 'Malampa',
      ),
      2 => 
      array (
        'code' => 'PE',
        'name' => 'Penama',
      ),
      3 => 
      array (
        'code' => 'SA',
        'name' => 'Sanma',
      ),
      4 => 
      array (
        'code' => 'SH',
        'name' => 'Shefa',
      ),
      5 => 
      array (
        'code' => 'TA',
        'name' => 'Tafea',
      ),
      6 => 
      array (
        'code' => 'TO',
        'name' => 'Torba',
      ),
    ),
    'WF' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Alo',
      ),
      2 => 
      array (
        'code' => 'S',
        'name' => 'Sigave',
      ),
      3 => 
      array (
        'code' => 'W',
        'name' => 'Wallis',
      ),
    ),
    'WS' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'A&#39;ana',
      ),
      2 => 
      array (
        'code' => 'AI',
        'name' => 'Aiga-i-le-Tai',
      ),
      3 => 
      array (
        'code' => 'AT',
        'name' => 'Atua',
      ),
      4 => 
      array (
        'code' => 'FA',
        'name' => 'Fa&#39;asaleleaga',
      ),
      5 => 
      array (
        'code' => 'GE',
        'name' => 'Gaga&#39;emauga',
      ),
      6 => 
      array (
        'code' => 'GF',
        'name' => 'Gagaifomauga',
      ),
      7 => 
      array (
        'code' => 'PA',
        'name' => 'Palauli',
      ),
      8 => 
      array (
        'code' => 'SA',
        'name' => 'Satupa&#39;itea',
      ),
      9 => 
      array (
        'code' => 'TU',
        'name' => 'Tuamasaga',
      ),
      10 => 
      array (
        'code' => 'VF',
        'name' => 'Va&#39;a-o-Fonoti',
      ),
      11 => 
      array (
        'code' => 'VS',
        'name' => 'Vaisigano',
      ),
    ),
    'YE' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => 'Abyan',
      ),
      2 => 
      array (
        'code' => 'AD',
        'name' => 'Adan',
      ),
      3 => 
      array (
        'code' => 'AM',
        'name' => 'Amran',
      ),
      4 => 
      array (
        'code' => 'BA',
        'name' => 'Al Bayda',
      ),
      5 => 
      array (
        'code' => 'DA',
        'name' => 'Ad Dali',
      ),
      6 => 
      array (
        'code' => 'DH',
        'name' => 'Dhamar',
      ),
      7 => 
      array (
        'code' => 'HD',
        'name' => 'Hadramawt',
      ),
      8 => 
      array (
        'code' => 'HJ',
        'name' => 'Hajjah',
      ),
      9 => 
      array (
        'code' => 'HU',
        'name' => 'Al Hudaydah',
      ),
      10 => 
      array (
        'code' => 'IB',
        'name' => 'Ibb',
      ),
      11 => 
      array (
        'code' => 'JA',
        'name' => 'Al Jawf',
      ),
      12 => 
      array (
        'code' => 'LA',
        'name' => 'Lahij',
      ),
      13 => 
      array (
        'code' => 'MA',
        'name' => 'Ma&#39;rib',
      ),
      14 => 
      array (
        'code' => 'MR',
        'name' => 'Al Mahrah',
      ),
      15 => 
      array (
        'code' => 'MW',
        'name' => 'Al Mahwit',
      ),
      16 => 
      array (
        'code' => 'SD',
        'name' => 'Sa&#39;dah',
      ),
      17 => 
      array (
        'code' => 'SN',
        'name' => 'San&#39;a',
      ),
      18 => 
      array (
        'code' => 'SH',
        'name' => 'Shabwah',
      ),
      19 => 
      array (
        'code' => 'TA',
        'name' => 'Ta&#39;izz',
      ),
    ),
    'YT' => 
    array (
      1 => 
      array (
        'code' => 'DZA',
        'name' => 'Dzaoudzi',
      ),
      2 => 
      array (
        'code' => 'PAM',
        'name' => 'Pamandzi',
      ),
      3 => 
      array (
        'code' => 'MAM',
        'name' => 'Mamoudzou',
      ),
      4 => 
      array (
        'code' => 'DEM',
        'name' => 'Dembeni',
      ),
      5 => 
      array (
        'code' => 'BAN',
        'name' => 'Bandrele',
      ),
      6 => 
      array (
        'code' => 'KAN',
        'name' => 'Kani-Kéli',
      ),
      7 => 
      array (
        'code' => 'BOU',
        'name' => 'Bouéni',
      ),
      8 => 
      array (
        'code' => 'CHI',
        'name' => 'Chirongui',
      ),
      9 => 
      array (
        'code' => 'SAD',
        'name' => 'Sada',
      ),
      10 => 
      array (
        'code' => 'OUA',
        'name' => 'Ouangani',
      ),
      11 => 
      array (
        'code' => 'CHI',
        'name' => 'Chiconi',
      ),
      12 => 
      array (
        'code' => 'TSI',
        'name' => 'Tsingoni',
      ),
      13 => 
      array (
        'code' => 'MTS',
        'name' => 'M&#39;Tsangamouji',
      ),
      14 => 
      array (
        'code' => 'ACO',
        'name' => 'Acoua',
      ),
      15 => 
      array (
        'code' => 'MTS',
        'name' => 'Mtsamboro',
      ),
      16 => 
      array (
        'code' => 'BAN',
        'name' => 'Bandraboua',
      ),
      17 => 
      array (
        'code' => 'KOU',
        'name' => 'Koungou',
      ),
    ),
    'YU' => 
    array (
      1 => 
      array (
        'code' => 'KOS',
        'name' => 'Kosovo',
      ),
      2 => 
      array (
        'code' => 'MON',
        'name' => 'Montenegro',
      ),
      3 => 
      array (
        'code' => 'SER',
        'name' => 'Serbia',
      ),
      4 => 
      array (
        'code' => 'VOJ',
        'name' => 'Vojvodina',
      ),
    ),
    'ZA' => 
    array (
      1 => 
      array (
        'code' => 'EC',
        'name' => 'Eastern Cape',
      ),
      2 => 
      array (
        'code' => 'FS',
        'name' => 'Free State',
      ),
      3 => 
      array (
        'code' => 'GT',
        'name' => 'Gauteng',
      ),
      4 => 
      array (
        'code' => 'KN',
        'name' => 'KwaZulu-Natal',
      ),
      5 => 
      array (
        'code' => 'LP',
        'name' => 'Limpopo',
      ),
      6 => 
      array (
        'code' => 'MP',
        'name' => 'Mpumalanga',
      ),
      7 => 
      array (
        'code' => 'NW',
        'name' => 'North West',
      ),
      8 => 
      array (
        'code' => 'NC',
        'name' => 'Northern Cape',
      ),
      9 => 
      array (
        'code' => 'WC',
        'name' => 'Western Cape',
      ),
    ),
    'ZM' => 
    array (
      1 => 
      array (
        'code' => 'CE',
        'name' => 'Central',
      ),
      2 => 
      array (
        'code' => 'CB',
        'name' => 'Copperbelt',
      ),
      3 => 
      array (
        'code' => 'EA',
        'name' => 'Eastern',
      ),
      4 => 
      array (
        'code' => 'LP',
        'name' => 'Luapula',
      ),
      5 => 
      array (
        'code' => 'LK',
        'name' => 'Lusaka',
      ),
      6 => 
      array (
        'code' => 'NO',
        'name' => 'Northern',
      ),
      7 => 
      array (
        'code' => 'NW',
        'name' => 'North-Western',
      ),
      8 => 
      array (
        'code' => 'SO',
        'name' => 'Southern',
      ),
      9 => 
      array (
        'code' => 'WE',
        'name' => 'Western',
      ),
    ),
    'ZR' => 
    array (
      1 => 
      array (
        'code' => 'BC',
        'name' => 'Bas-Congo',
      ),
      2 => 
      array (
        'code' => 'BN',
        'name' => 'Bandundu',
      ),
      3 => 
      array (
        'code' => 'EQ',
        'name' => 'Equateur',
      ),
      4 => 
      array (
        'code' => 'KA',
        'name' => 'Katanga',
      ),
      5 => 
      array (
        'code' => 'KE',
        'name' => 'Kasai-Oriental',
      ),
      6 => 
      array (
        'code' => 'KN',
        'name' => 'Kinshasa',
      ),
      7 => 
      array (
        'code' => 'KW',
        'name' => 'Kasai-Occidental',
      ),
      8 => 
      array (
        'code' => 'MA',
        'name' => 'Maniema',
      ),
      9 => 
      array (
        'code' => 'NK',
        'name' => 'Nord-Kivu',
      ),
      10 => 
      array (
        'code' => 'OR',
        'name' => 'Orientale',
      ),
      11 => 
      array (
        'code' => 'SK',
        'name' => 'Sud-Kivu',
      ),
    ),
    'ZW' => 
    array (
      1 => 
      array (
        'code' => 'BU',
        'name' => 'Bulawayo',
      ),
      2 => 
      array (
        'code' => 'HA',
        'name' => 'Harare',
      ),
      3 => 
      array (
        'code' => 'ML',
        'name' => 'Manicaland',
      ),
      4 => 
      array (
        'code' => 'MC',
        'name' => 'Mashonaland Central',
      ),
      5 => 
      array (
        'code' => 'ME',
        'name' => 'Mashonaland East',
      ),
      6 => 
      array (
        'code' => 'MW',
        'name' => 'Mashonaland West',
      ),
      7 => 
      array (
        'code' => 'MV',
        'name' => 'Masvingo',
      ),
      8 => 
      array (
        'code' => 'MN',
        'name' => 'Matabeleland North',
      ),
      9 => 
      array (
        'code' => 'MS',
        'name' => 'Matabeleland South',
      ),
      10 => 
      array (
        'code' => 'MD',
        'name' => 'Midlands',
      ),
    ),
    86 => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Saint Andrew',
      ),
      2 => 
      array (
        'code' => 'D',
        'name' => 'Saint David',
      ),
      3 => 
      array (
        'code' => 'G',
        'name' => 'Saint George',
      ),
      4 => 
      array (
        'code' => 'J',
        'name' => 'Saint John',
      ),
      5 => 
      array (
        'code' => 'M',
        'name' => 'Saint Mark',
      ),
      6 => 
      array (
        'code' => 'P',
        'name' => 'Saint Patrick',
      ),
      7 => 
      array (
        'code' => 'C',
        'name' => 'Carriacou',
      ),
      8 => 
      array (
        'code' => 'Q',
        'name' => 'Petit Martinique',
      ),
    ),
  ),
  'dnb_job_codes' => 
  array (
    '' => '-κενό-',
    'A045' => 'Ιδρυτής Εταιρείας',
    'A046' => 'Κοινοπραξίας',
    'A047' => 'Μέτοχος',
    'A0A1' => 'Ιδιοκτήτης',
    'A0A2' => 'Συνεργάτης',
    'A0A3' => 'Διευθύνων Εταίρος',
    'A0AA' => 'Εταίρος Εταιρείας',
    'A0AB' => 'Γενικός Εταίρος',
    'A0AC' => 'Ανώτερος Γενικός Συνεργάτης',
    'A0AD' => 'Ανώτερος Συνεργάτης',
    'A0AE' => 'Γενικός Εταίρος',
    'A0AF' => 'Γενικός Ετερόρρυθμος Εταίρος',
    'A0AG' => 'Ετερόρρυθμου Εταίρου',
    'A0AH' => 'Ατομικός Γενικός Εταίρος',
    'A0AI' => 'Ατομικός Εταίρος',
    'A0AJ' => 'Υπεύθυνος/Εταίρος',
    'A0AL' => 'Διευθύνων Γενικός Εταίρος',
    'A0AM' => 'Διαχείριση Ετερρόρυθμου Εταίρου',
    'A0AQ' => 'Ιδιοκτήτης Εταιρείας',
    'A0AS' => 'Εκτελεστής Εταιρείας',
    'A0AT' => 'Διαχειριστής Εταιρείας',
    'A0AV' => 'Συν-Κοινοπραξίας',
    'A0AY' => 'Διευθύνων Διαχειριστής',
    'A0AZ' => 'Δέκτης',
    'A0GX' => 'Τυχοδιώκτης',
    'A0R0' => 'Εκτελεστής',
    'A0R3' => 'Τυχοδιώκτης Εταιρείας',
    'A117' => 'Ανώτερο Στέλεχος Μάρκετινγκ',
    'A154' => 'Ανώτερο Στέλεχος Επενδύσεων',
    'A189' => 'Γ&#39;-Επίπεδο Υποστήριξης',
    'A199' => 'Αξιωματικός',
    'A1A4' => 'Πρόεδρος του Διοικητικού Συμβουλίου',
    'A1A5' => 'Αναπληρωτής',
    'A1A6' => 'Πρόεδρος',
    'A1A7' => 'Επικεφαλής Διευθύνων Σύμβουλος',
    'A1A8' => 'Ανώτερο Στέλεχος Λειτουργιών',
    'A1A9' => 'Ανώτατο Διευθυντικό Στέλεχος Οικονομικών',
    'A1B0' => 'Ταμίας',
    'A1B2' => 'Γραμματέας',
    'A1B3' => 'Πρόεδρος Θυγατρικής',
    'A1B4' => 'Πρόεδρος Τμήματος',
    'A1B5' => 'Ανώτερος Εταιρικός Αξιωματικός',
    'A1BA' => 'Πρόεδρος',
    'A1BB' => 'Πρόεδρος Εταιρείας',
    'A1BD' => 'Πρόεδρος του Διοικητικού Συμβουλίου Εταιρείας',
    'A1BE' => 'Αναπληρωτής Πρόεδρος Διοικητικού Συμβουλίου',
    'A1BF' => 'Εκτελεστικός Πρόεδρος Διοικητικού Συμβουλίου',
    'A1BH' => 'Γενικός Πρόεδρος του Διοικητικού Συμβουλίου',
    'A1BI' => 'Ανώτερος Πρόεδρος του Διοικητικού Συμβουλίου',
    'A1BJ' => 'Αναπληρωτής Πρόεδρος του Διοικητικού Συμβουλίου',
    'A1BO' => 'Συμβουλευτική Πρόεδρος του Διοικητικού Συμβουλίου',
    'A1BP' => 'Πρόεδρος Συμβουλευτικής Επιτροπής',
    'A1BU' => 'Επίτιμος Πρόεδρος',
    'A1BV' => 'Πρόεδρος Εκτελεστικής Επιτροπής',
    'A1BX' => 'Πρόεδρος Επιτροπής Οικονομικών',
    'A1BY' => 'Πρόεδρος Επιτροπής Εμπιστοσύνης',
    'A1BZ' => 'Εκτελεστικός Πρόεδρος της Επιτροπής',
    'A1CA' => 'Ανώτερος Αντιπρόεδρος του Διοικητικού Συμβουλίου',
    'A1CB' => 'Αναπληρωτής του Διοικητικού Συμβουλίου',
    'A1CG' => 'Πρόεδρος Εταιρείας',
    'A1CH' => 'Αναπληρωτής Πρόεδρος',
    'A1CJ' => 'Πρόεδρος-Επιχειρήσεων',
    'A1CK' => 'Πρόεδρος Διοίκησης',
    'A1CL' => 'Επίτιμος Πρόεδρος',
    'A1CN' => 'Αναπληρωτής Διευθύνων Σύμβουλος',
    'A1CO' => 'Επικεφαλής Διαχειριστής',
    'A1CP' => 'Διευθύνων Σύμβουλος Εταιρείας',
    'A1CQ' => 'Αρχιλογιστής Εταιρείας',
    'A1CR' => 'Διευθυντής Λειτουργίας Εταιρείας',
    'A1CS' => 'Εκτελεστικό Μέλος Διοικητικού Συμβουλίου',
    'A1CT' => 'Στέλεχος Διευθύνων Σύμβουλος',
    'A1CU' => 'Υποδιευθυντής',
    'A1CW' => 'Ιδρυτής',
    'A1CX' => 'Στέλεχος Πιστωτικού',
    'A1CY' => 'Αναπληρωτής Ανώτατο Διευθυντικό Στέλεχος Οικονομικών',
    'A1G7' => 'Διοικητικού Συμβουλίου',
    'A1R1' => 'Επίτροπος',
    'A2AP' => 'Γενικός Εταίρος Εμπιστοσύνης',
    'A2D1' => 'Διοικητικό Στέλεχος Υπηρεσιών',
    'A2D2' => 'Ανώτερο Διοικητικό Στέλεχος',
    'A2IU' => 'Διευθυντής Εξουσίας',
    'A2IV' => 'Ανώτερος Λειτουργός Επενδύσεων',
    'A2IW' => 'Ανώτερος Αξιωματικός Εμπιστοσύνης',
    'A2IX' => 'Σύμβουλος Επενδύσεων Εμπιστοσύνης',
    'A2IY' => 'Σύμβουλος Εμπιστοσύνης',
    'A2IZ' => 'Σύμβουλος Προσωπικού Εμπιστοσύνης',
    'A589' => 'VP - Επίπεδο Υποστήριξης',
    'A598' => 'Αντιπρόεδρος Διαχείρισης',
    'A599' => 'Διοικητικό Στέλεχος',
    'A5D3' => 'Αναπληρωτής Πρόεδρος Τμήματος',
    'A5D4' => 'Εκτελεστικός Αντιπρόεδρος',
    'A5D6' => 'Γκρουπ Αντιπροέδρος',
    'A5D7' => 'Ανώτερος Αντιπρόεδρος',
    'A5D8' => 'Αντιπρόεδρος',
    'A5DL' => 'Ομότιμος Εκτελεστικός Αντιπρόεδρος',
    'A5DM' => 'Γενικός Εκτελεστικός Αντιπρόεδρος',
    'A5DN' => 'Γκρουπ Εκτελεστικό',
    'A5DO' => 'Αναπληρωτής Αντιπρόεδρος',
    'A5DP' => 'Περιφερειακός Αντιπρόεδρος',
    'A5DQ' => 'Ανώτερος Εκτελεστικός Αντιπρόεδρος',
    'A5DR' => 'Ανώτερος Ομότιμος Αντιπρόεδρος',
    'A5DS' => 'Διαιρεμένη/Περιφερειακή Αντιπρόεδρος',
    'A5DT' => 'Αντιπρόεδρος Τμήμα Χονδρκής',
    'A5I5' => 'Αντιπρόεδρος Επιχειρηματικής Ανάπτυξης',
    'A5I9' => 'Αντιπρόεδρος της Επιχείρησης',
    'A615' => 'Διευθυντής Διαχείρισης Υποθέσων',
    'A626' => 'Διευθυντής Εργαστηρίου',
    'A627' => 'Αναπληρωτής Διευθυντής',
    'A636' => 'Διευθυντής Κοινωνικών Μέσων Ενημέρωσης',
    'A644' => 'Διευθυντής του Προγραμματισμού και Εταιρική Ανάπτυξης',
    'A645' => 'Διευθυντής Δημιουργικού',
    'A646' => 'Διευθυντής Επικοινωνιών',
    'A647' => 'Διευθυντής Ακτινολογίας',
    'A655' => 'Διευθυντής Υπηρεσιών Φαρμακείου',
    'A65A' => 'Διευθυντής Φαρμακείου',
    'A663' => 'Διευθυντής Περιβαλλοντικών Ύπηρεσιών',
    'A689' => 'Διευθυντής-Τεχνικής Υποστήριξης',
    'A6A1' => 'Ανώτερος Διευθυντής',
    'A6A2' => 'Διευθυντής Τηλεπικοινωνιών',
    'A6AA' => 'Διευθυντής Χειρουργείου',
    'A6BA' => 'Διευθυντής Περίθαλψης Ασθενών/Νοσηλευτική',
    'A6BZ' => 'Διευθυντής Ελέγχου Λοιμώξεων',
    'A6C7' => 'Διευθυντής Διαχείρισης Κινδύνων',
    'A6DU' => 'Διαίρεση/Θυγατρική',
    'A746' => 'Υπεύθυνη Επικοινωνίας',
    'A789' => 'Υπεύθυνος-Επίπεδο Υποστήριξης',
    'A7DU' => 'Διευθύνων Σύμβουλος',
    'A8DV' => 'Βοηθός του Προέδρου',
    'A957' => 'Συμβουλευτικό Μέλος Διοικητικού Συμβουλίου',
    'A998' => 'Προσωπικό',
    'A9CD' => 'Επίτιμος Πρόεδρος του Διοικητικού Συμβουλίου',
    'A9DW' => 'Ιδρυτής Εταιρείας',
    'A9DX' => 'Εξερεύνηση',
    'A9DY' => 'Επίτιμος Διαχειριστής',
    'A9DZ' => 'Προσωρινός Πρόεδρος',
    'A9EA' => 'Ανενεργός Πρόεδρος',
    'AB47' => 'Επικεφαλής της Ακτινολογίας',
    'ABA1' => 'Επικεφαλής της Καρδιολογίας',
    'ABA2' => 'Διευθυντής ICU/Στεφανιαία Μονάδα Φροντίδας',
    'ABA3' => 'Επικεφαλής της Χειρουργικής',
    'ABA4' => 'Επικεφαλής της Ιατρικής',
    'ABA5' => 'Επικεφαλής της Αναισθησιολογίας',
    'ABA6' => 'Επικεφαλής του Δωματίου Έκτακτης Ανάγκης',
    'ABA7' => 'Διευθυντής Χειρουργικής',
    'ABAB' => 'Επικεφαλής της Παθολογίας',
    'ABBA' => 'Επικεφαλής της Μαιευτικής/Γυναικολογίας',
    'ADA4' => 'Διευθυντής Εγγραφών',
    'ADZ9' => 'Διευθυντής του Εθελοντή',
    'B0A1' => 'Επικεφαλής Διοικητικός Υπάλληλος',
    'B1EB' => 'Περιφερειακή Πρόεδρος',
    'B1R2' => 'Πρωταρχικός',
    'B1R3' => 'Υποδιευθυντής',
    'B5D0' => 'Αντιπρόεδρος Διοίκησης',
    'B5E2' => 'Αντιπρόεδρος Εταιρικής Ανάπτυξης',
    'B5E6' => 'Αντιπρόεδρος Σχέσεων Κυβέρνησης',
    'B5F4' => 'Αντιπρόεδρος Συγχώνευσης',
    'B618' => 'Διευθυντής Ασφαλείας',
    'B635' => 'Διευθυντής Λογιστήριου Ασθενών',
    'B699' => 'Διευθυντής Διοίκησης',
    'B6EC' => 'Διοικητικός Διευθυντής',
    'B6ED' => 'Σύμβουλος Διαχείρισης Εταιρείας',
    'B6EE' => 'Διευθυντής Εξυπηρέτησης Μετόχων',
    'B6EF' => 'Περιφερειακός Διευθυντής',
    'B6EH' => 'Ανώτερος Διοικητικός Διευθυντής',
    'B6H2' => 'Εκτελεστικός Διευθυντής',
    'B6H8' => 'Διευθύνων Σύμβουλος',
    'B6J3' => 'Διευθυντής Καταστήματος',
    'B7AB' => 'Υπεύθυνος Πρακτικής',
    'B7EI' => 'Υπεύθυνος Διοίκησης',
    'B7EJ' => 'Υπεύθυνος Προγράμματος',
    'B7EK' => 'Περιφερειακός Υπεύθυνος',
    'B7EL' => 'Χρηματιστής',
    'B7J0' => 'Υπεύθυνος Περιοχής',
    'B7J1' => 'Επόπτης Περιοχής',
    'B7J8' => 'Υπεύθυνος Διοίκησης',
    'B7K0' => 'Υπεύθυνος Τμήματος',
    'B7K3' => 'Υπεύθυνος Υποκαταστήματος',
    'B7L3' => 'Διευθυντής της Περιοχής',
    'B7L4' => 'Διευθύντρια Τμήματος',
    'B7M1' => 'Γενικός Υπεύθυνος',
    'B7M2' => 'Υπεύθυνος Σχέσεων Κυβέρνησης',
    'B7N2' => 'Γραφείο Υπευθύνου',
    'B7N6' => 'Υπεύθυνος Σχεδιασμού',
    'B7P5' => 'Υπεύθυνος Καταστήματος',
    'B7XA' => 'Διευθύντρια Νοσοκόμα',
    'B801' => 'Βοηθός Διοικητικού Στελέχους',
    'B806' => 'Διοικητική Γραμματέας',
    'B830' => 'Βοηθός Διαχειριστής',
    'B899' => 'Βοηθός Διευθυντού',
    'B8B8' => 'Γραφείο Διαχειριστή',
    'B914' => 'Πρόεδρος Τμήματος',
    'B927' => 'Γραφείο Επόπτη',
    'B928' => 'Σχεδιασμό Συναντήσεων',
    'B9EM' => 'Διαχειριστής',
    'B9EN' => 'Δημοτικός Υπεύθυνος',
    'B9EO' => 'Προσωρινός Υπεύθυνος',
    'B9EP' => 'Διαχείριση',
    'B9EQ' => 'Προσωπικό Σχεδιασμού',
    'B9ME' => 'Σχέσεις Κυβέρνησης',
    'BB47' => 'Επικεφαλής Τμήματος Νοσηλευτικής',
    'C1AC' => 'Διοικητικό Στέλεχος Τηλεπικοινωνιών',
    'C1C1' => 'Στέλεχος Πληροφορικής',
    'C1D9' => 'Ανώτερος Μηχανικός Δικτύου',
    'C1DC' => 'Μηχανολόγος Μηχανικός',
    'C2A1' => 'Ανώτερος Υπάλληλος Πληροφοριών',
    'C2A2' => 'Επικεφαλής Τεχνολογίας',
    'C2C1' => 'Εκτελεστικός Επεξεργασίας Δεδομένων',
    'C2P3' => 'Ανώτερο Στέλεχος Ασφάλειας Πληροφοριών',
    'C599' => 'Αντιπρόεδρος Συστημάτων',
    'C5E8' => 'Αντιπρόεδρος Υπηρεσιών Πληροφόρησης',
    'C601' => 'Διευθυντής Βελτίωσης της Ποιότητας',
    'C624' => 'Διευθυντής Πληροφορικής',
    'C699' => 'Διευθυντής Συστημάτων',
    'C6G8' => 'Διευθυντής Επεξεργασίας Δεδομένων',
    'C6I3' => 'Διευθυντής του MIS/IS',
    'C6J1' => 'Υπεύθυνος Εργαστηρίου Η/Υ',
    'C6P9' => 'Διευθυντής Διασφάλισης Ποιότητας',
    'C724' => 'Υπεύθυνος Η/Υ',
    'C799' => 'Υπεύθυνος Συστημάτων',
    'C7BB' => 'Διαχειριστής Συστημάτων',
    'C7BC' => 'Υπεύθυνος Τηλεπικοινωνιών',
    'C7C7' => 'Υπεύθυνος Πληροφοριακών Συστημάτων',
    'C7E8' => 'Υπεύθυνος Υπηρεσιών των Πληροφοριών',
    'C7H1' => 'Web Project Manager',
    'C7J1' => 'Υπεύθυνος Δικτύου',
    'C7K9' => 'Υπεύθυνος Επεξεργασίας Δεδομένων',
    'C7L5' => 'Υπεύθυνος Λειτουργίας Επεξεργασίας Δεδομένων',
    'C7N1' => 'Υπεύθυνος Διαχείρισης Πληροφοριακών Συστημάτων',
    'C7P7' => 'Συστήματα/Υπεύθυνος Προγραμματισμού',
    'C7P8' => 'Υπεύθυνος Υποστήριξης Συστημάτων',
    'C7P9' => 'Υπεύθυνος Διασφάλισης Ποιότητας',
    'C7X9' => 'Υπεύθυνος Πληροφοριών',
    'C7XZ' => 'Τεχνικός Υπεύθυνος',
    'C899' => 'Βοηθός Συστημάτων',
    'C8B9' => 'Τεχνολογία/Συντονιστής Υπολογιστή',
    'C8C8' => 'Υπεύθυνος Έργων Πληροφοριακών Συστημάτων',
    'C8CC' => 'Web Developer',
    'C8CD' => 'Προγραμματιστής Λογισμικού',
    'C8DC' => 'Μηχανικός Λογισμικού',
    'C8DD' => 'Μηχανικός Συστημάτων',
    'C8X1' => 'Μηχανικός Δικτύου',
    'C912' => 'Επόπτης Επεξεργασίας Δεδομένων',
    'C918' => 'Προσωπικό Τηλεπικοινωνιών',
    'C939' => 'Ανώτερος Αναλυτής Συστημάτων',
    'C940' => 'Αναλυτής Συστημάτων',
    'C941' => 'Αναλυτής Δικτύου',
    'C999' => 'Προσωπικό Συστημάτων',
    'C9A1' => 'Επιστήμονας Η/Υ',
    'C9A2' => 'Ειδικός Η/Υ',
    'C9A3' => 'Τεχνικός Η/Υ',
    'C9A4' => 'Υπολογιστές',
    'C9A5' => 'Πληροφοριακά Συστήματα',
    'C9A6' => 'Προσωπικό Διαχείρισης Συστημάτων Πληροφοριών',
    'C9A7' => 'Προγραμματιστής',
    'C9A8' => 'Προγραμματιστής Αναλυτής',
    'C9A9' => 'Ανάδοχος Έργου',
    'C9B1' => 'Σύμβουλος Δεδομένων',
    'C9B2' => 'Webmaster',
    'C9B3' => 'Διαχειριστής Βάσης Δεδομένων',
    'C9B4' => 'Σύμβουλος Εφαρμογών',
    'C9B5' => 'Αναλυτής Επιχειρήσεων',
    'C9B6' => 'Διαχείρισης Δεδομένων',
    'C9B7' => 'Τεχνικός Συστημάτων',
    'C9B8' => 'Πληροφορίες Τεχνολογίας/Απομακρυσμένη Υποστήριξη',
    'C9B9' => 'Τεχνικός',
    'C9CX' => 'Αρχιτέκτων Τεχνολογίας',
    'C9ER' => 'Προσωπικό Επεξεργασίας Δεδομένων',
    'C9F8' => 'Τεχνικός Εργοδότης',
    'C9P3' => 'Ασφάλεια IT',
    'C9X1' => 'Τεχνικός Δικτύου',
    'C9XZ' => 'Ειδικός Πληροφορικής',
    'D2C2' => 'Διοικητικό Στέλεχος Μηχανικός',
    'D599' => 'Αντιπρόεδρος Μηχανολογίας-Έρευνας και Ανάπτυξης',
    'D5E4' => 'Αντιπρόεδρος Μηχανολογίας',
    'D5E5' => 'Αντιπρόεδρος Ανάπτυξης',
    'D5G1' => 'Αντιπρόεδρος Έρευνας και Τεχνολογίας',
    'D699' => 'Διευθυντής Μηχανολογίας',
    'D6ET' => 'Τεχνικός Διευθυντής',
    'D6EZ' => 'Διευθυντής Ανάπτυξης',
    'D6O0' => 'Διευθυντής Ανάπτυξης Ερευνών',
    'D799' => 'Μηχανικής-Έρευνας και Υπεύθυνος Ανάπτυξης',
    'D7EU' => 'Επικεφαλής Μηχανικός Έργου',
    'D7EV' => 'Διαχειριστής Έργου',
    'D7EW' => 'Συντονιστής Έργου',
    'D7EX' => 'Διευθυντής Έργου',
    'D7EY' => 'Εκτελεστής Έργου',
    'D7EZ' => 'Υπεύθυνος Ανάπτυξης',
    'D7L1' => 'Υπεύθυνος Μηχανικός Σχεδιασμού',
    'D7L7' => 'Υπεύθυνος Μηχανικού',
    'D7M5' => 'Υπεύθυνος Βιομηχανικής Μηχανικής',
    'D7O0' => 'Υπέυθυνος Ανάπτυξης Ερευνών',
    'D7O1' => 'Υπεύθυνος Μηχανικού Παραγωγής',
    'D7O4' => 'Υπεύθυνος Έργου',
    'D899' => 'Μηχανικής-Έρευνας και Βοηθός Ανάπτυξης',
    'D901' => 'Ηλεκτρολόγος Μηχανικός',
    'D915' => 'Συντάκτης/Σχεδιαστής',
    'D916' => 'Μηχανικός',
    'D917' => 'Επικεφαλής Μηχανικός',
    'D918' => 'Ανώτερος Μηχανικός',
    'D963' => 'Τεχνικός Συντήρησης',
    'D999' => 'Μηχανικής-Έρευνας και Ανάπτυξης',
    'D9EZ' => 'Ανάπτυξη',
    'D9FA' => 'Προσωπικό Μηχανολογίας',
    'D9FB' => 'Βιομηχανική',
    'D9FC' => 'Έρευνα',
    'D9FD' => 'Τεχνολογία',
    'D9FE' => 'Τεχνικό Προσωπικό',
    'D9IU' => 'Προσωπικό Ανάπτυξης Ερευνών',
    'D9X1' => 'Γραφίστας',
    'D9X9' => 'Μηχανικός Έργου',
    'DZ25' => 'Μηχανικός Σχεδιασμού',
    'E1FF' => 'Σύμβουλος Επενδύσεων',
    'E2C4' => 'Χρηματοοικονομικό Στέλεχος',
    'E5D9' => 'Αντιπρόεδρος Λογιστικής',
    'E5E5' => 'Αντιπρόεδρος Οικονομικών',
    'E6D9' => 'Αρχιλογιστής',
    'E6FG' => 'Οικονομική Διευθύντρια',
    'E6FH' => 'Οικονομικός Διευθυντής',
    'E6FI' => 'Ανώτερος Υπάλληλος Δανείου',
    'E6G4' => 'Διευθυντής Λογιστηρίου',
    'E7FE' => 'Χρηματοοικονομικός Σύμβουλος',
    'E7FF' => 'Υπεύθυνος Επενδύσεων',
    'E7FJ' => 'Υπεύθυνος Εμπιστοσύνης',
    'E7G2' => 'Υπεύθυνος Χαρτοφυλακίου',
    'E7J7' => 'Υπεύθυνος Λογιστηρίου',
    'E7K1' => 'Διευθυντής Ελέγχου',
    'E7K4' => 'Υπεύθυνος Επιχείρησης',
    'E7K7' => 'Υπεύθυνος Πιστωτικού',
    'E7K9' => 'Υπεύθυνος Συμβάσεων',
    'E7L9' => 'Υπεύθυνος Οικονομικών',
    'E7P9' => 'Υπεύθυνος Φόρων',
    'E7S9' => 'Χρηματιστής',
    'E899' => 'Βοηθός Οικονομικών',
    'E8Q6' => 'Βοηθός Ελεγκτής',
    'E8Q9' => 'Βοηθός Ταμίας',
    'E901' => 'Λογιστής',
    'E902' => 'Ορκωτός Λογιστής Ελεγκτής',
    'E903' => 'Παρασκευαστής Φόρου',
    'E906' => 'Ελεγκτής',
    'E908' => 'Ελεγκτής',
    'E909' => 'Ελεγκτής',
    'E917' => 'Επόπτης Οικονομικών',
    'E920' => 'Μεσίτης',
    'E944' => 'Λογιστής',
    'E999' => 'Οικονομικών-Άλλα',
    'E9E6' => 'Γραμματέας Οικονομικών',
    'E9E7' => 'Ανώτερος Οικονομικός Αναλυτής',
    'E9E9' => 'Οικονομικός Αναλυτής',
    'E9FK' => 'Προσωπικό Λογιστηρίου',
    'E9FL' => 'Προσωπικό Πιστωτικών',
    'E9FM' => 'Οικονομικών',
    'E9FN' => 'Δόση',
    'E9FO' => 'Δάνειο',
    'E9FP' => 'Υποθήκη',
    'E9FQ' => 'Εμπιστοσύνη',
    'E9FR' => 'Χρεόγραφα',
    'E9FS' => 'Αναπληρωτής Ελεγκτή',
    'E9FZ' => 'Αναλυτής',
    'EZ20' => 'Συνεργαζόμενος Μεσίτης',
    'F2A9' => 'Γ&#39;-Επίπεδο Ανθρωπίνων Πόρων',
    'F2C9' => 'Εκτελεστικό Προσωπικό',
    'F599' => 'Αντιπρόεδρος Προσωπικού',
    'F5E7' => 'Αντιπρόεδρος Ανθρώπινου Δυναμικού',
    'F6FV' => 'Πρόσληψη Διευθυντή',
    'F6G0' => 'Διευθυντής Σχέσεων Εργαζομένων',
    'F6H4' => 'Διευθυντής Ανθρωπίνου Δυναμικού',
    'F6H5' => 'Διευθυντής Σχέσεων Βιομηχανικής',
    'F6I6' => 'Διευθυντής Προσωπικού',
    'F6J5' => 'Εκπαίδευση και Διευθυντής Ανάπτυξης',
    'F6J6' => 'Διευθυντής Εκπαίδευσης',
    'F7B1' => 'Συντονιστής Ανθρωπίνου Δυναμικού',
    'F7FF' => 'Υπεύθυνος Μισθοδοσίας',
    'F7FR' => 'Διευθυντής Προνομίων Εργαζομένων',
    'F7FS' => 'Διαχειριστής Ταμείου',
    'F7FT' => 'Διευθυντής Σχεδίου Συντάξεων',
    'F7FU' => 'Υπεύθυνος Σχεδίου Κερδών',
    'F7FV' => 'Πρόσληψη Υπευθύνου',
    'F7K2' => 'δΔιευθυντής Οφελειών',
    'F7K5' => 'Υπεύθυνος Αποζημίωσης',
    'F7L6' => 'Υπεύθυνος Σχέσεων Εργαζομένων',
    'F7M4' => 'Υπεύθυνος Ανθρωπίνου Δυναμικού',
    'F7M6' => 'Υπεύθυνος Σχέσεων Βιομηχανικής',
    'F7N5' => 'Υπεύθυνος Προσωπικού',
    'F7Q2' => 'Εκπαίδευση και Υπεύθυνος Ανάπτυξης',
    'F7Q3' => 'Επόπτης Εκπαίδευσης',
    'F898' => 'Ανθρώπινο Δυναμικό',
    'F899' => 'Βοηθός Προσωπικού',
    'F8C9' => 'Αναλυτής Πληροφοριών Διαχείρισης Ανθρωπίνου Δυναμικού',
    'F8Z8' => 'Σύμβουλος Ανθρωπίνου Δυναμικού',
    'F8Z9' => 'Αναλυτής Ανθρωπίνου Δυναμικού',
    'F8ZZ' => 'Προσωπικό Μισθοδοσίας',
    'F9B1' => 'Διαχειριστής Ανθρωπίνου Δυναμικού',
    'F9FV' => 'Στρατολογών',
    'F9FW' => 'Προσωπικό',
    'F9Q2' => 'Ειδικευμένος Εκπαίδευσης',
    'G299' => 'Σύμβουλος Αγορών',
    'G599' => 'Αντιπρόεδρος Αγοράς',
    'G5F0' => 'Αντιπρόεδρος Αγορών/Προμηθειών',
    'G629' => 'Διευθυντής Επιχειρήσεων/Οικονομικών/Αγορών',
    'G698' => 'Διευθυντής Προμηθειών',
    'G699' => 'Διευθυντής Αγορών',
    'G6I9' => 'Επικεφαλής Τμήματος Αγοράς',
    'G798' => 'Υπεύθυνος Προμηθειών',
    'G7O6' => 'Υπεύθυνος Αγορών',
    'G899' => 'Βοηθός Αγορών',
    'G906' => 'Ανώτερος Αγοραστής',
    'G907' => 'Αγοραστής',
    'G933' => 'Πράκτορας Αγορών',
    'G989' => 'Προσωπικό Προμηθειών',
    'G9FX' => 'Αγορά',
    'H2C8' => 'Κατασκευή/Παραγωγή/Διοικητικό Στέλεχος Διανομής',
    'H599' => 'Αντιπρόεδρος Επιχειρήσεων/Παραγωγής/Κατασκευής',
    'H5F1' => 'Αντιπρόεδρος Παραγωγής',
    'H5F5' => 'Αντιπρόεδρος Επιχειρήσεων',
    'H5F8' => 'Αντιπρόεδρος Παραγωγής',
    'H699' => 'Διευθυντής Επιχειρήσεων-Παραγωγής/Κατασκευής',
    'H6FY' => 'Διευθυντής Επιχειρήσεων',
    'H6H9' => 'Διευθυντής Κατασκευής',
    'H6I0' => 'Διευθυντής Ασφάλειας',
    'H6I1' => 'Διευθυντής Υλικών',
    'H6I7' => 'Διευθυντής Παραγωγής',
    'H6J4' => 'Διευθυντής Μεταφορών',
    'H6O7' => 'Διευθυντής Ελέγχου Ποιότητας',
    'H799' => 'Επιχειρήσεις-Παραγωγής/Κατασκευής',
    'H7A0' => 'Υπεύθυνος Υλικών',
    'H7B7' => 'Εργοταξιάρχης',
    'H7D5' => 'Υπεύθυνος Ελαιοτριβείου',
    'H7FZ' => 'Υπεύθυνος Ορυχείου',
    'H7GA' => 'Υπεύθυνος Εξαγωγών',
    'H7H7' => 'Πράξεις Επόπτη',
    'H7H9' => 'Υπεύθυνος Στόλου',
    'H7I0' => 'Υπεύθυνος Ασφάλειας',
    'H7L0' => 'Διαχειριστής',
    'H7L2' => 'Διευθυντής Διανομής/Ναυτιλίας/Μεταφορών',
    'H7M0' => 'Υπεύθυνος Κατασκευής',
    'H7M7' => 'Διαχείριση Ελέγχου Αποθεμάτων',
    'H7N3' => 'Υπεύθυνος Λειτουργίας',
    'H7N4' => 'Μηχανικός Διευθυντής Συσκευασίας',
    'H7N8' => 'Υπεύθυνος Μηχανικός Εργοστασίου',
    'H7N9' => 'Υπεύθυνος Εργοστασίου',
    'H7O3' => 'Υπεύθυνος Παραγωγής',
    'H7O7' => 'Υπεύθυνος Ελέγχου Ποιότητας',
    'H7P3' => 'Υπεύθυνος Ασφαλείας',
    'H7Q1' => 'Υπεύθυνος Μεταφορών',
    'H918' => 'Επιστάτη/Επόπτης',
    'H920' => 'Βιομηχανικός Μηχανικός',
    'H924' => 'Επόπτης Κατασκευής',
    'H928' => 'Μηχανικός Εγκαταστάσεων',
    'H929' => 'Επιστάτης Εγκαταστασίου',
    'H930' => 'Επιθεωρητής Παραγωγής',
    'H9E7' => 'Αναλυτής Λειτουργίας',
    'H9GA' => 'Προσωπικό Στόλου',
    'H9GB' => 'Προσωπικό Κατασκευής',
    'H9GC' => 'Προσωπικό Λειτουργίας',
    'H9GD' => 'Προσωπικό Λειτουργιών',
    'H9GE' => 'Λειτουργίας',
    'H9GF' => 'Παραγωγή',
    'H9GG' => 'Παραγωγός',
    'H9P3' => 'Προσωπικό Ασφαλείας',
    'I199' => 'Διευθυντής Διαχείρισης Πληροφοριών',
    'I1A7' => 'Διευθυντής Τηλεφωνικού Κέντρου',
    'I1A8' => 'Διοικητικό Στέλεχος Αγοράς',
    'I1A9' => 'Στέλεχος Πωλήσεων',
    'I1X7' => 'Εθνικός Διευθυντής Πωλήσεων',
    'I2A1' => 'Γ&#39;-Επίπεδο Μάρκετινγκ',
    'I2A3' => 'Αξιωματικός Ψηφιακών και Κοινωνικών Μέσων',
    'I2B9' => 'Σύμβουλος Δημοσίων Σχέσεων',
    'I2C0' => 'Διοικητικό Στέλεχος Πωλήσεων και Μάρκετινγκ',
    'I2I1' => 'Στρατηγική Κοινωνικών Μέσων Ενημέρωσης',
    'I599' => 'Αντιπρόεδρος Πωλήσεων και Μάρκετινγκ',
    'I5A1' => 'Εκτελεστικός Αντιπρόεδρος Μάρκετινγκ',
    'I5A2' => 'Εκτελεστικός Αντιπρόεδρος Πωλήσεων',
    'I5E1' => 'Αντιπρόεδρος Διαφήμισης',
    'I5F2' => 'Αντιπρόεδρος Μάρκετινγκ',
    'I5F3' => 'Αντιπρόεδρος Προώθησης Προϊόντων',
    'I5F7' => 'Αντιπρόεδρος Ανάπτυξης Προϊόντων',
    'I5G2' => 'Αντιπρόεδρος Πωλήσεων',
    'I5H1' => 'Αντιπρόεδρος Εταιρικής Επικοινωνίας',
    'I5I1' => 'Αντιπρόεδρος Δημοσίων Σχέσεων',
    'I699' => 'Διευθυντής Πωλήσεων και Μάρκετινγκ',
    'I6A1' => 'Διευθυντής Ηλεκτρονικής Επιχείρησης',
    'I6A2' => 'Διευθυντής Ηλεκτρονικού Εμπορίου',
    'I6A3' => 'Διευθυντής Ψηφιακών και Κοινωνικών Μέσων',
    'I6G6' => 'Διευθυντής Διαφήμισης',
    'I6H0' => 'Διευθυντής Μάρκετινγκ',
    'I6H1' => 'Διευθυντής Εταιρικής Επικοινωνίας',
    'I6I1' => 'Διευθυντής Δημοσίων Σχέσεων',
    'I6J2' => 'Διευθυντής Πωλήσεων',
    'I6K2' => 'Διευθυντής Επιχειρηματικής Ανάπτυξης',
    'I6K8' => 'Διευθυντής Εξυπηρέτησης Πελατών',
    'I799' => 'Υπεύθυνος Πωλήσεων και Μάρκετινγκ',
    'I7A1' => 'Υπεύθυνος Ηλεκτρονικής Επιχείρησης',
    'I7A2' => 'Υπεύθυνος Ηλεκτρονικού Εμπορίου',
    'I7A3' => 'Υπεύθυνος Κοινωνικών Μέσων Ενημέρωσης',
    'I7A4' => 'Διευθυντής Κοινότητας',
    'I7B1' => 'Υπεύθυνος Εμπορευμάτων',
    'I7H1' => 'Υπεύθυνος Εταιρικής Επικοινωνίας',
    'I7I1' => 'Υπεύθυνος Δημοσίων Σχέσεων',
    'I7J9' => 'Υπεύθυνος Διαφήμισης',
    'I7K2' => 'Υπεύθυνος Επιχειρηματικής Ανάπτυξης',
    'I7K8' => 'Υπεύθυνος Εξυπηρέτησης Πελατών',
    'I7M9' => 'Υπεύθυνος Μάρκετινγκ',
    'I7N0' => 'Υπεύθυνος Ανάπτυξης Προϊόντων',
    'I7O2' => 'Υπεύθυνος Προϊόντων',
    'I7O9' => 'Περιφερειακός Υπεύθυνος Πωλήσεων',
    'I7P1' => 'Υπεύθυνος Πωλήσεων',
    'I7P2' => 'Υπεύθυνος Προώθησης Πωλήσεων',
    'I889' => 'Προσωπικό Έρευνας Αγοράς',
    'I898' => 'Συνεταίρος Πωλήσεων',
    'I899' => 'Βοηθός Πωλήσεων και Μάρκετινγκ',
    'I998' => 'Ειδικός Ψηφιακών και Κοινωνικών Μέσων',
    'I999' => 'Προσωπικό Πωλήσεων και Μάρκετινγκ',
    'I9A1' => 'Ηλεκτρονικό Εμπόριο',
    'I9A2' => 'Ηλεκτρονική Επιχείρηση',
    'I9A3' => 'Αναλυτής Κοινωνικών Μέσων Ενημέρωσης',
    'I9A4' => 'Έμπορος Κοινωνικών Μέσων Ενημέρωσης',
    'I9D8' => 'Μηχανικός Πωλήσεων',
    'I9GH' => 'Προσωπικό Διαφήμισης',
    'I9GI' => 'Εμπόρευμα',
    'I9GJ' => 'Προώθηση Προϊόντων',
    'I9GK' => 'Προσωπικό Μάρκετινγκ',
    'I9GL' => 'Προϊόντα',
    'I9GM' => 'Προσωπικό Πωλήσεων',
    'I9GN' => 'Μάρκετινγκ Βάσης Δεδομένων',
    'I9H1' => 'Προσωπικό Εταιρικής Επικοινωνίας',
    'I9I1' => 'Προσωπικό Δημοσίων Σχέσεων',
    'I9I2' => 'Δημοσιεύσεις',
    'I9I3' => 'Εκπρόσωπος',
    'I9I8' => 'Συντονιστής Πωλήσεων',
    'I9I9' => 'Συντονιστής του Μάρκετινγκ',
    'I9K8' => 'Προσωπικό Εξυπηρέτησης Πελατών',
    'I9Z9' => 'Προσωπικό Τηλεφωνικού Κέντρου',
    'I9ZX' => 'Εκπρόσωπος Τηλεφωνικού Κέντρου',
    'J599' => 'Αντιπρόεδρος Εγκαταστάσεων',
    'J699' => 'Διευθυντής Εγκαταστάσεων',
    'J6E2' => 'Διευθυντής Εργοστασίου Φυσικής',
    'J6H7' => 'Διευθυντής Συντήρησης',
    'J7GN' => 'Υπεύθυνος Πάρκου',
    'J7L8' => 'Υπεύθυνος Εγκαταστάσεων',
    'J7M3' => 'Διαχείριση Hub',
    'J7M8' => 'Διευθυντής Συντήρησης',
    'J7N7' => 'Υπεύθυνος Εργοστασίων και Εγκαταστάσεων',
    'J7P0' => 'Υπεύθυνος Τερματικού',
    'J7Q3' => 'Warehouse Manager',
    'J7ZZ' => 'Υπεύθυνος  Ιδιοκτησίας',
    'J899' => 'Βοηθός Εγκαταστάσεων',
    'J923' => 'Επόπτης Συντήρησης',
    'J999' => 'Εγκαταστάσεων',
    'J9GO' => 'Προσωπικό Συντήρησης',
    'J9GP' => 'Υπεύθυνος Κέντρου',
    'K209' => 'Πρέσβης',
    'K601' => 'Ομοσπονδιακός Διευθυντής Προγράμματος',
    'K602' => 'Επιθεωρητής Προγράμματος',
    'K656' => 'Αναπληρωτής Διευθυντής',
    'K661' => 'Δικαστής',
    'K670' => 'Προϊστάμενος Αστυνομίας',
    'K948' => 'Δημοτικός Σύμβουλος',
    'K949' => 'Βοηθός Επικεφαλής',
    'K950' => 'Επικεφαλής',
    'K951' => 'Δημοτικό Συμβούλιο',
    'K952' => 'Επίτροπος',
    'K953' => 'Ανδρικό Μέλος Επιτροπής',
    'K955' => 'Μέλος του Συμβουλίου',
    'K960' => 'Επίτροπος County',
    'K961' => 'Δικαστής County',
    'K962' => 'Γέρων',
    'K963' => 'Επικεφαλής Φωτιάς',
    'K964' => 'Κυβερνήτης',
    'K965' => 'Δήμαρχος',
    'K966' => 'Δημοτικός Σύμβουλος',
    'K967' => 'Σερίφης',
    'K968' => 'Αντιδήμαρχος',
    'K969' => 'Αρχιφύλακας',
    'K989' => 'Προσωπικό Δικαστικού',
    'K999' => 'Κυβέρνηση',
    'K9D7' => 'Σωφρονιστικός Υπάλληλος',
    'L6A6' => 'Διευθυντής Ποιμαντικής',
    'L935' => 'Θρησκευτικός Ηγέτης',
    'L970' => 'Αναπληρωτής Πάστορας',
    'L971' => 'Υπουργός',
    'L972' => 'Βοηθός Πάστορας',
    'L973' => 'Επίσκοπος',
    'L974' => 'Διάκονος',
    'L975' => 'Καρδινάλιος',
    'L976' => 'Πάστορας',
    'L977' => 'Ηγουμένη',
    'L978' => 'Ραββίνος',
    'L979' => 'Πρύτανης',
    'L980' => 'Αιδεσιμότατος',
    'L981' => 'Ιερέας',
    'L982' => 'Ανώτερος Πάστορας',
    'M1B1' => 'Σχολικός Επιθεωρητής',
    'M1B2' => 'Σχολικός Πρόεδρος',
    'M622' => 'Διευθυντής Βιβλιοθήκης',
    'M6E6' => 'Οικονομικός Διευθυντής Ενίσχυσης',
    'M6F6' => 'Διευθυντής Προσωπικού Δασκάλων',
    'M6I6' => 'Εκπαιδευτικός Διευθυντής Υπηρεσιών Μέσων Ενημέρωσης',
    'M7M6' => 'Ακαδημαϊκός Σύμβουλος',
    'M7M9' => 'Καθηγητής',
    'M7MZ' => 'Δάσκαλος',
    'M8I6' => 'Ειδικός Μέσων Ενημέρωσης',
    'M8I7' => 'Ειδικός Ανάγνωσης',
    'M901' => 'Εκπαίδευση',
    'M922' => 'Βιβλιοθηκονόμος',
    'M983' => 'Καγκελάριος',
    'M984' => 'Πρεσβύτερος',
    'M985' => 'Διευθυντής',
    'M986' => 'Επικεφαλής Αξιωματικός Ομολογιών',
    'M987' => 'Ακαδημαϊκός Διευθυντής',
    'M988' => 'Αθλητικός Διευθυντής',
    'M989' => 'Διευθυντής Υπηρεσίας Τροφίμων',
    'M990' => 'Αντικαγκελάριος',
    'M999' => 'Επίκουρος Εκπαίδευσης',
    'M9M9' => 'Εκπαιδευτής',
    'M9R3' => 'Αναπληρωτής Καθηγητής',
    'M9R4' => 'Επίκουρος Καθηγητής',
    'M9R5' => 'Επίκουρος Καθηγητής',
    'N985' => 'Λοχίας',
    'N986' => 'Επίκουρος',
    'N987' => 'Διοικητής',
    'N988' => 'Αρχιπλοίαρχος',
    'N989' => 'Βασιλικός Χάρακας',
    'N990' => 'Μέγας Ιππότης',
    'N991' => 'Ιππότης',
    'N992' => 'Ειδικός',
    'N993' => 'Διοικητής Θέση',
    'N994' => 'Εφοδιαστής',
    'N995' => 'Πίσω Commodore',
    'N996' => 'Όργανο Καταγραφής',
    'N997' => 'Αναπληρωτής Διοικητής',
    'N998' => 'Αναπληρωτής Αρχιπλοίαρχος',
    'N999' => 'Καπετάνιος',
    'X1Z8' => 'Ανώτερος Συνεργάτης',
    'X626' => 'Επιστήμονας',
    'X656' => 'Διευθυντής Καλλιτεχνικών',
    'X6Z9' => 'Διευθυντής Προγράμματος',
    'X746' => 'Αναπληρωτής Συντάκτης',
    'X799' => 'Καταστηματάρχης/Τεχνίτης',
    'X7DZ' => 'Ανώτερος Διευθυντής Έργου',
    'X7X7' => 'Ανώτερος Διευθυντής',
    'X8X9' => 'Ανώτερος Σύμβουλος',
    'X901' => 'Δημιουργός',
    'X906' => 'Φορολογία',
    'X930' => 'Αρχιτέκτονας',
    'X931' => 'Σχεδιαστής',
    'X956' => 'Υπεύθυνος Πελατών',
    'X957' => 'Υπεύθυνος Πελατών',
    'X9CD' => 'Αναλυτής Ερευνών',
    'XA01' => 'Ειδικός Εντατικολογίας',
    'XA02' => 'Γενικός Αγγειοχειρουργός',
    'XA99' => 'Ιατρός',
    'XAA1' => 'Κτηνίατρος',
    'XAA2' => 'Οικογενειακού Ιατρού',
    'XAB5' => 'Σύμβουλος Κατάχρησης Ουσιών',
    'XABX' => 'Ψυχολόγος',
    'XAP0' => 'Ψυχαναλυτής',
    'XAP1' => 'Ωτορινολαρυγγολόγος',
    'XAP2' => 'Λοιμώδη Νοσήματα',
    'XAP3' => 'Οφθαλμίατρος',
    'XAP4' => 'Ορθοπεδικός',
    'XAP5' => 'Παθολόγος',
    'XAP6' => 'Πρωκτολόγος',
    'XAP7' => 'Αθλητική Ιατρική',
    'XAP8' => 'Θωρακική Γιατρός',
    'XAP9' => 'Χειρουργός',
    'XAQ1' => 'Ειδικός Επαγγελματικής Βιομηχανίας',
    'XAQ2' => 'Γηριατρική',
    'XAQ3' => 'Γυναικολόγος',
    'XAQ4' => 'Ωτορινολαρυγγολόγος',
    'XAS0' => 'Αλλεργίας και Ανοσολογίας',
    'XAS1' => 'Αναισθησιολογίας',
    'XAS2' => 'Αρθρίτιδα και Ρευματολογία',
    'XAS3' => 'Καρδιολογία',
    'XAS4' => 'Δερματολογία',
    'XAS5' => 'Ενδοκρινολογία',
    'XAS6' => 'Γενική Ιατρική Πρακτική',
    'XAS7' => 'Γαστρεντερολογίας',
    'XAS8' => 'Αιματολογίας',
    'XAS9' => 'Εσωτερική παθολογία',
    'XAT0' => 'Νεφρολογίας',
    'XAT1' => 'Νευρολογία',
    'XAT2' => 'Πυρηνική Ιατρική',
    'XAT3' => 'Γυναικολογία/Μαιευτική',
    'XAT4' => 'Ογκολογία',
    'XAT5' => 'Οφθαλμολογίας',
    'XAT6' => 'Παιδιατρικής',
    'XAT7' => 'Φυσικής Ιατρικής',
    'XAT8' => 'Ψυχιατρική',
    'XAT9' => 'Παιδοψυχολογία',
    'XAU0' => 'Πνευμονοπάθειες',
    'XAU1' => 'Ακτινολογία',
    'XAU2' => 'Χειροπράκτης',
    'XAU3' => 'Οστεοπαθητική',
    'XAU4' => 'Χειρουργική Ορθοπεδική',
    'XAU5' => 'Χειρουργική Πλαστική',
    'XAU6' => 'Χειρουργική Θώρακος',
    'XAU7' => 'Ουρολογία',
    'XAU8' => 'Προληπτική Ιατρική',
    'XAU9' => 'Υπογονιμότητα',
    'XAV0' => 'Διαβήτης',
    'XAV1' => 'Ωτορινολαρυγγολογία',
    'XAV2' => 'Βελονισμός',
    'XAV3' => 'Πλαστικός Χειρουργός',
    'XAV4' => 'Ρευματολογίας',
    'XAV5' => 'Καρδιαγγειακών',
    'XAV6' => 'Νευροχειρουργικής',
    'XAV7' => 'Χειρουργική Επέμβαση Παχέος Εντέρου και του Ορθού',
    'XAV8' => 'Αγγειοχειρουργική',
    'XAXA' => 'Θωρακοχειρουργός',
    'XAY5' => 'Ανοσολόγος',
    'XAY6' => 'Υπνωτιστής',
    'XAY7' => 'Διατροφολόγος',
    'XAY9' => 'Αεροδιαστημικής Ιατρικής',
    'XAZ1' => 'Ποδίατρος',
    'XAZ2' => 'Εξειδικευμένος Ιατρός',
    'XAZ8' => 'Βοηθός Ιατρού',
    'XAZ9' => 'Χειρουργική',
    'XB37' => 'Ακτινολόγος Διαγνωστικών',
    'XB47' => 'Επαγγελματίας Συμμαχικών Υγείας',
    'XB67' => 'Διαχειριστής Υγείας',
    'XB6M' => 'Διευθυντής ΠληροφοριώνΥγείας',
    'XB98' => 'Διασώστης Άμεσης Επέμβασης',
    'XB99' => 'Διευθυντής Υγειονομικού',
    'XBA7' => 'Διευθυντής Δωματίου Έκτακτης Ανάγκης',
    'XBB2' => 'Ειδικός Φακών Επαφής',
    'XBB3' => 'Ειδικός Φροντίδας Μαστού',
    'XBBB' => 'Επαγγελματίας Νοσοκόμα',
    'XBC1' => 'Νοσοκόμα',
    'XBC2' => 'Διευθύντρια Νοσηλευτικής',
    'XBC3' => 'Θεραπεία Λόγου',
    'XBC4' => 'Διαχειριστής Νοσηλευτικής',
    'XBC9' => 'Επιβλέπων Νοσηλευτικής',
    'XBD1' => 'Φαρμακοποιός',
    'XBD2' => 'Ορκωτός Βοηθός Φαρμακείου',
    'XBE1' => 'Διευθυντής Αναπνευστικής Θεραπείας',
    'XBE2' => 'Διευθυντής Φυσιοθεραπείας',
    'XBE3' => 'Διευθυντής Εργοθεραπείας',
    'XBE4' => 'Φυσιοθεραπευτής',
    'XBE5' => 'Φυσιοθεραπευτής',
    'XBF1' => 'Διευθυντής Διαχείρισης Περίθαλψης',
    'XBF2' => 'Διευθυντής Αρχικής Φροντίδας Υγείας',
    'XBF9' => 'Διευθυντής Ιατρός',
    'XBFB' => 'Στρατολογών Νοσοκόμα',
    'XBFC' => 'Γιατρός Στρατολογών',
    'XBU1' => 'Ειδικός Γναθοπροσωπικής',
    'XBV4' => 'Οδοντίατρος',
    'XBV9' => 'Προσθετική',
    'XBW0' => 'Οδοντιατρική Υγιεινολόγος',
    'XBW3' => 'Γκρουπ και Εταιρική Πράξη',
    'XBXA' => 'Νοσηλεύτρια',
    'XBXB' => 'Αδειούχος Νοσοκόμα Πρακτικής',
    'XBXC' => 'Νοσοκόμα Φυσικής Αποκατάστασης',
    'XBZ8' => 'Θεραπευτής Ποδιών',
    'XBZ9' => 'Ιατρός Ορθωτικών Συσκευών',
    'XBZZ' => 'Ιατρικής Φυσικής Αποκατάστασης',
    'XD15' => 'Δικηγόρος Επιχειρήσεων/Νομική',
    'XD26' => 'Δικηγόρος',
    'XD51' => 'Αντιπρόεδρος Νομικών',
    'XD97' => 'Νομική Σύμβουλος',
    'XD98' => 'Προσωπικό Νομικής',
    'XD99' => 'Συμβουλή',
    'XDA2' => 'Λειτουργός Συμμόρφωσης',
    'XDA6' => 'Διευθυντής Συμμόρφωσης',
    'XDA7' => 'Υπεύθυνος Συμμόρφωσης',
    'XDW4' => 'Δίκαιο Ευρεσιτεχνίας',
    'XDW5' => 'Συμβάσεις Δικαίου',
    'XDW6' => 'White Collar Crime',
    'XDW7' => 'Πιέσεις',
    'XDW9' => 'Έρευνα Δίκαιο',
    'XDX0' => 'Ποινικό Δίκαιο',
    'XDX1' => 'Γενικός Σύμβουλος',
    'XDX2' => 'Πολιτικής Πρακτικής Δοκιμής',
    'XDX3' => 'Μεσιτικό Γρφαείο/Διαθήκες/Σχεδιασμός Κτημάτων',
    'XDX4' => 'Δίκαιο Προσωπικών Τραυματισμών',
    'XDX5' => 'Εφαρμοστέο Δίκαιο',
    'XDX6' => 'Εταιρικό και Επιχειρηματικό Δίκαιο',
    'XDX7' => 'Γενική Νομική Πρακτική',
    'XDX8' => 'Αντιδικία Αμίαντος',
    'XDX9' => 'Περιβαλλοντολογικό Δίκαιο',
    'XDY0' => 'Οικογενεικό Δίκαιο',
    'XDY1' => 'Πτωχευτικό Δίκαιο',
    'XDY2' => 'Δικαστική Αγωγή',
    'XDY3' => 'Αδικοπραξίες',
    'XDY4' => 'Ιατρική Αμέλεια',
    'XDY5' => 'Επαγγελματικής Ευθύνης',
    'XDY6' => 'Εμπορικό Δίκαιο',
    'XDZ9' => 'Προσωπικό Συμμόρφωσης',
    'XZ9L' => 'Κοινωνικός Λειτουργός',
    'XZA1' => 'Μέλος',
    'XZY8' => 'Διαιτολόγος',
    'Z1X1' => 'Διευθύνων Μέλος',
    'Z2B7' => 'Διοικητικό Στέλεχος Διοίκησης',
    'Z2B8' => 'Γενικός Διευθυντής Αερομεταφορών',
    'Z2B9' => 'Διοικητικό Στέλεχος Τραπέζης',
    'Z2C3' => 'Εκτελεστικός Γραμματέας',
    'Z2C5' => 'Φιλοξενία',
    'Z2C6' => 'Διεθνής Εκτελεστική',
    'Z5E9' => 'Αντιπρόεδρος Διεθνούς',
    'Z642' => 'Βοηθός Διευθυντής',
    'Z698' => 'Διευθυντής Μεταφορών',
    'Z699' => 'Διευθυντής',
    'Z6GQ' => 'Αναπληρωτής Διευθυντής',
    'Z6H6' => 'Διευθυντής Διεθνούς',
    'Z6H7' => 'Διευθυντής Εταιρείας',
    'Z715' => 'Υπεύθυνος Υποθέσεων',
    'Z741' => 'Υπεύθυνος Εταιρείας',
    'Z799' => 'Υπεύθυνος',
    'Z7F7' => 'Ασφάλιση/Επόπτης Χρέωσης',
    'Z7GQ' => 'Αναπληρωτής Διαχείρισης',
    'Z7GR' => 'Διευθυντής Συγκροτήματος',
    'Z7P4' => 'Υπεύθυνος Υπηρεσιών',
    'Z823' => 'Δημοσιογράφος',
    'Z856' => 'Βοηθός Διευθυντής Γραφείου',
    'Z888' => 'Ρεσεψιονίστ',
    'Z889' => 'Γραμματέας Υποδοχής',
    'Z899' => 'Βοηθός',
    'Z8A8' => 'Βοηθός Ιατρού',
    'Z8B9' => 'Τεχνικός Οφθαλμού',
    'Z8GT' => 'Βοηθός Γραμματειακού Λειτουργού',
    'Z8GU' => 'ΒοηθόςΠεριφερειακός Διευθυντής',
    'Z8Q0' => 'Βοηθός Αντιπρόεδρος',
    'Z8Q7' => 'Βοηθός Υπεύθυνος',
    'Z8Q8' => 'Βοηθός Γραμματέας',
    'Z900' => 'Διοικητικό Στέλεχος Πωλήσεων',
    'Z903' => 'υπότροφος',
    'Z910' => 'Συντονιστής',
    'Z917' => 'Αντιπρόσωπος Εξυπηρέτησης Πελατών',
    'Z921' => 'Ασφαλιστικός Πράκτορας',
    'Z923' => 'Ναυλωμένα Ιδιοκτησίας και Καθημερινός Ανάδοχος',
    'Z924' => 'Ασφαλιστής Ναυλωμένων Ζωής',
    'Z925' => 'Ασφαλίστρια',
    'Z926' => 'Ασφαλιστής Ομολόγων',
    'Z932' => 'Εκδότης',
    'Z934' => 'Πράκτορας Μεσιτικού Γραφείου',
    'Z936' => 'Επιθεωρητής Καταστήματος',
    'Z937' => 'Επιθεωρητής',
    'Z938' => 'Επόπτης',
    'Z939' => 'Υπάλληλος',
    'Z940' => 'Συνέταιρος',
    'Z941' => 'Βοηθός Ταμίας',
    'Z943' => 'Βοηθός Έφορος',
    'Z998' => 'Υπεύθυνος Ανταλλακτικών',
    'Z9GU' => 'Διευθυντής Λογαριασμού',
    'Z9GV' => 'Ασφαλιστής',
    'Z9GW' => 'Διεθύντρια',
    'Z9GX' => 'Σύμβουλος',
    'Z9GY' => 'Πράκτορας',
    'Z9GZ' => 'Εισαγγελέας στην Πραγματικότητα',
    'Z9HA' => 'Σύμβουλος',
    'Z9HB' => 'Ανάδοχος',
    'Z9HC' => 'Εμπορική',
    'Z9HD' => 'Μέλος Επιτροπής',
    'Z9HG' => 'Εταιρικός Εκπρόσωπος',
    'Z9HH' => 'Ανταποκριτής',
    'Z9HI' => 'Ταμίας',
    'Z9HJ' => 'Πράκτορας Διασποράς',
    'Z9HK' => 'Εγχώρια',
    'Z9HL' => 'Συντάκτης',
    'Z9HM' => 'Ξένων',
    'Z9HN' => 'Γενικός',
    'Z9HQ' => 'Γκρουπ',
    'Z9HR' => 'Διεθνές',
    'Z9HT' => 'Εκκαθάριση Πράκτορα',
    'Z9HX' => 'Καπετάνιος Εγκαταστάσεων',
    'Z9HY' => 'Διευθυντής Εγκαταστάσεων',
    'Z9HZ' => 'Διευθυντής Θέση',
    'Z9IA' => 'Δημοσίευση',
    'Z9IB' => 'Αφεντικό Θέση',
    'Z9IC' => 'Εκτυπωτης Δημοσιεύσεων',
    'Z9IF' => 'Μεσιτικό Γραφείο',
    'Z9IG' => 'Περιοχή',
    'Z9IH' => 'Περιθάλπων',
    'Z9II' => 'Εκπρόσωπος',
    'Z9IJ' => 'Λιανικής Πώλησης',
    'Z9IK' => 'Λιανοπωλητές',
    'Z9IL' => 'Περιφερειακός',
    'Z9IM' => 'Σχέσεων',
    'Z9IO' => 'Ανώτερος Συντάκτης',
    'Z9IQ' => 'Υπηρεσίες',
    'Z9IR' => 'Εξοικονόμηση',
    'Z9IS' => 'Μεταφορές',
    'Z9IT' => 'Χονδρική πώληση',
    'ZA48' => 'Στοματική και Γναθοπροσωπική Χειρουργική',
    'ZAA0' => 'Εξειδικευμένη Οδοντιατρική',
    'ZAA1' => 'Οδοντίατρος Παιδικής',
    'ZAA2' => 'Ενδοδοντία',
    'ZAA3' => 'Οικογένεια και Γενική Οδοντιατρική',
    'ZAA4' => 'Ορθοδοντική',
    'ZAA5' => 'Παιδιατρικής Οδοντιατρικής',
    'ZAA6' => 'Περιοδοντολογία',
    'ZAA7' => 'Προφορική Παθολόγος',
    'ZAAB' => 'Χειρουργός Οδοντίατρος',
    'ZAV6' => 'Οπτομετρών',
    'ZAV7' => 'Γηριατρική Ειδικός Οπτομετρίας',
    'ZBXA' => 'Διαχείριση Πόνου',
    'ZBXB' => 'Τράπεζα Αίματος',
    'ZBZZ' => 'Μαία Νοσοκόμα',
  ),
);

