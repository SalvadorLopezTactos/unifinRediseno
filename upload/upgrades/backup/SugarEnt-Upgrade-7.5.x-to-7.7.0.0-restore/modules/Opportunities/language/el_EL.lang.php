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
  'ERR_DELETE_RECORD' => 'Πρέπει να προσδιορίσετε αριθμό καρτέλας για να διαγράψετε αυτήν την ευκαιρία.',
  'LABEL_PANEL_ASSIGNMENT' => 'Ανάθεση',
  'LBL_ACCOUNT_ID' => 'Ταυτότητα Λογαριασμού',
  'LBL_ACCOUNT_NAME' => 'Όνομα Λογαριασμού:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Δραστηριότητες',
  'LBL_ASSIGNED_TO_ID' => 'Ανατεθειμένος Χειριστής:',
  'LBL_ASSIGNED_TO_NAME' => 'Ανατέθηκε σε',
  'LBL_CAMPAIGN' => 'Εκστρατεία:',
  'LBL_CAMPAIGN_LINK' => 'Σύνδεσμος Εκστρατείας',
  'LBL_CAMPAIGN_OPPORTUNITY' => 'Ευκαιρία Εκστρατείας',
  'LBL_CLOSED_RLIS' => '# της Γραμμής Ειδών Κλειστών Συνολικών Εσόδων',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'Κλειστές Κερδισμένες Ευκαιρίες',
  'LBL_COMMITTED' => 'Δεσμευμένη',
  'LBL_COMMIT_STAGE' => 'Στάδιο Δέσμευσης',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Επαφές',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Emails Σχετικών Επαφών',
  'LBL_CONTRACTS' => 'Συμβάσεις',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Συμβάσεις',
  'LBL_CREATED_ID' => 'Δημιουργήθηκε από Ταυτότητα',
  'LBL_CREATED_USER' => 'Δημιουργημένος Χειριστής',
  'LBL_CURRENCIES' => 'Νομίσματα',
  'LBL_CURRENCY' => 'Νόμισμα:',
  'LBL_CURRENCY_ID' => 'Ταυτότητα Νομίσματος',
  'LBL_CURRENCY_NAME' => 'Όνομα Νομίσματος',
  'LBL_CURRENCY_RATE' => 'Ισοτιμία Νομίσματος',
  'LBL_CURRENCY_SYMBOL' => 'Σύμβολο Νομίσματος',
  'LBL_DATE_CLOSED' => 'Αναμενόμενη Ημερομηνία Κλεισίματος:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Αναμενόμενη Ημερομηνία Κλεισίματος (Timestamp)',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Ευκαιρίες',
  'LBL_DESCRIPTION' => 'Περιγραφή:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Έγγραφα',
  'LBL_DUPLICATE' => 'Πιθανά Αντίγραφο Ευκαρίας',
  'LBL_EDITLAYOUT' => 'Επεξεργασία Διάταξης',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Ταυτότητα Ανατεθειμένου Χειριστή',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Ανατεθειμένο Όνομα Χειριστή',
  'LBL_EXPORT_CAMPAIGN_ID' => 'Ταυτότητα Εκστρατείας',
  'LBL_EXPORT_CREATED_BY' => 'Δημιουργήθηκε Από Ταυτότητα',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Τροποποιήθηκε Από Ταυτότητα',
  'LBL_EXPORT_NAME' => 'Όνομα',
  'LBL_FILENAME' => 'Επισύναψη',
  'LBL_FORECAST' => 'Συμπεριλαμβάνεται στην Πρόβλεψη',
  'LBL_HELP_CREATE' => 'Η {{plural_module_name}} ενότητα, σας επιτρέπει να παρακολουθείτε μεμονωμένες πωλήσεις και τα στοιχεία γραμμής που ανήκουν σε αυτές τις πωλήσεις από την αρχή μέχρι το τέλος. Κάθε εγγραφή{{module_name}}, αντιπροσωπεύει μια κεφαλίδα για ομάδα {{revenuelineitems_module}}  καθώς και σχετικά με άλλα σημαντικά αρχεία, όπως το  {{quotes_module}}, {{contacts_module}}, κ.λ.π.

Για να δημιουργήσετε μία {{module_name}}:
1. Παρέχετε τιμές για τα πεδία, όπως επιθυμείτε.
 - Τα Πεδία με σήμανση "Υποχρεωτικό", πρέπει να συμπληρωθούν πριν από την αποθήκευση..
 - Κάντε κλικ στην επιλογή "Εμφάνιση Περισσότερων" να εκθέσει πρόσθετα πεδία, εάν είναι απαραίτητο.
2. Κάντε κλικ στην επιλογή "Αποθήκευση" να οριστικοποιήσει τη νέα εγγραφή και να επιστρέψετε στην προηγούμενη σελίδα.
 - Επιλέξτε "Αποθήκευση και προβολή" να προβάλει τη νέα εγγραφή {{module_name}}.
 - Επιλέξτε "Αποθήκευση και δημιουργία νέας" για να δημιουργήσει αμέσως μία νέα εγγραφή {{module_name}}.
3. Μετά την αποθήκευση, χρησιμοποιήστε τον υποπίνακα {{revenuelineitems_module}} για να προσθέσετε τα στοιχεία γραμμής στο {{module_name}}.',
  'LBL_HELP_RECORD' => 'Η {{plural_module_name}} ενότητα, σας επιτρέπει να παρακολουθείτε μεμονωμένες πωλήσεις και τα στοιχεία γραμμής που ανήκουν σε αυτές τις πωλήσεις από την αρχή μέχρι το τέλος. Κάθε εγγραφή{{module_name}}, αντιπροσωπεύει μια κεφαλίδα για ομάδα {{revenuelineitems_module}}  καθώς και σχετικά με άλλα σημαντικά αρχεία, όπως το  {{quotes_module}}, {{contacts_module}}, κ.λ.π.

- Επεξεργαστείτε αυτό το πεδίο εγγραφής κάνοντας κλικ στο μεμονωμένο πεδίο ή το κουμπί "Επεξεργασία".
- Προβάλετε ή τροποποιήστε συνδέσεις με άλλες εγγραφές στους υποπίνακες, συμπεριλαμβανομένου της ενότητας {{revenuelineitems_module}}, από την εναλλαγή του κάτω αριστερού παραθύρου σε "Προβολή Δεδομένων".
- Αλληλεπιδράστε με τα σχόλια των χρηστών και την προβολή του ιστορικού των αλλαγών των εγγραφών {{activitystream_singular_module}} από την εναλλαγή του κάτω αριστερού παραθύρου "Ροή Δραστηριοτήτων".
Ακολουθήστε ή κάντε Αγαπημένες εγγραφές χρησιμοποιώντας τα εικονίδια στα δεξιά του ονόματος της εγγραφής.
- Πρόσθετες ενέργειες είναι διαθέσιμες στο αναπτυσσόμενο μενού "Ενέργειες", δεξιά από το κουμπί "Επεξεργασία".',
  'LBL_HELP_RECORDS' => 'Η {{plural_module_name}} ενότητα, σας επιτρέπει να παρακολουθείτε μεμονωμένες πωλήσεις και τα στοιχεία γραμμής που ανήκουν σε αυτές τις πωλήσεις από την αρχή μέχρι το τέλος. Κάθε εγγραφή {{module_name}} αντιπροσωπεύει μια κεφαλίδα για ομάδα {{revenuelineitems_module}}, καθώς και σχετικά με άλλα σημαντικά τεκμήρια όπως {{quotes_module}}, {{contacts_module}}, κ.λ.π. Κάθε εγγραφή {{revenuelineitems_singular_module}} είναι η προοπτική πώλησης ενός συγκεκριμένου προϊόντος και περιλαμβάνει τα σχετικά στοιχεία προς πώληση. Κάθε εγγραφή {{revenuelineitems_singular_module}} θα προχωρήσει συνήθως από διάφορα Στάδια των Πωλήσεων, μέχρι να επισημανθεί είτε "Έκλεισε Κερδισμένη" είτε "Έκλεισε Χαμένη". Η εγγραφή {{module_name}}, αντανακλά το ποσό και την αναμενόμενη ημερομηνία κλεισίματός της {{revenuelineitems_module}}. {{plural_module_name}} και {{revenuelineitems_module}} μπορεί να ενισχυθεί ακόμη περισσότερο χρησιμοποιώντας την ενότητα του Sugar {{forecasts_singular_module}}ing, για να κατανοήσει και να προβλέψει τις τάσεις των πωλήσεων, καθώς και να επικεντρώσει το έργο για την επίτευξη των ποσοστώσεων πωλήσεων.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Ιστορικό',
  'LBL_INVITEE' => 'Επαφές',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Δυνητικοί Πελάτες',
  'LBL_LEAD_SOURCE' => 'Πηγή Προέλευσης:',
  'LBL_LIST_ACCOUNT_NAME' => 'Όνομα Λογαριασμού',
  'LBL_LIST_AMOUNT' => 'Πιθανή',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'Συνολικό Ποσό',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Ανατεθειμένος Χειριστής',
  'LBL_LIST_DATE_CLOSED' => 'Αναμενόμενη Ημερομηνία Κλεισίματος',
  'LBL_LIST_FORM_TITLE' => 'Λίστα Ευκαιριών',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Όνομα',
  'LBL_LIST_SALES_STAGE' => 'Στάδιο Πώλησης',
  'LBL_MKTO_ID' => 'Ταυτότητα Δυνητικού Marketo',
  'LBL_MKTO_SYNC' => 'Συγχρονισμός με Marketo®',
  'LBL_MODIFIED_ID' => 'Τροποποιήθηκε από Ταυτότητα',
  'LBL_MODIFIED_NAME' => 'Τροποποιήθηκε Από Όνομα Χειριστή',
  'LBL_MODIFIED_USER' => 'Τροποποιημένος Χειριστής',
  'LBL_MODULE_NAME' => 'Ευκαιρίες',
  'LBL_MODULE_NAME_SINGULAR' => 'Ευκαιρία',
  'LBL_MODULE_TITLE' => 'Ευκαιρίες: Αρχή',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'Κλειστές Ευκαιρίες Μου',
  'LBL_NAME' => 'Όνομα Ευκαιρίας',
  'LBL_NEW_FORM_TITLE' => 'Δημιουργία Ευκαιρίας',
  'LBL_NEXT_STEP' => 'Επόμενο Βήμα:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Σημειώσεις',
  'LBL_OPPORTUNITY' => 'Ευκαιρία:',
  'LBL_OPPORTUNITY_NAME' => 'Όνομα Ευκαιρίας:',
  'LBL_OPPORTUNITY_ROLE' => 'Ευκαιρία Ρόλου',
  'LBL_OPPORTUNITY_TYPE' => 'Τύπος Ευκαιρίας',
  'LBL_PIPELINE_TOTAL_IS' => 'Σύνολο Αγωγού είναι',
  'LBL_PRIMARY_QUOTE_ID' => 'Βασική Προσφορά',
  'LBL_PROBABILITY' => 'Πιθανότητα (%):',
  'LBL_PRODUCTS' => 'Γραμμή Εισηγμένων Ειδών',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Γραμμή Εισηγμένων Ειδών',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Έργα',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Έργα',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Προσφορές',
  'LBL_QUOTE_SUBPANEL_TITLE' => 'Προσφορές',
  'LBL_RAW_AMOUNT' => 'Ακαθάριστο Ποσό',
  'LBL_RLI' => 'Γραμμή Ειδών Εσόδου',
  'LBL_RLI_SUBPANEL_TITLE' => 'Γραμμή Ειδών Εσόδων',
  'LBL_SALES_STAGE' => 'Στάδιο Πώλησης:',
  'LBL_SALES_STATUS' => 'Κατάσταση',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Ευκαιριών',
  'LBL_TEAM_ID' => 'Ταυτότητα Ομάδας',
  'LBL_TIMEPERIODS' => 'Χρονικές Περίοδοι',
  'LBL_TIMEPERIOD_ID' => 'Ταυτότητα Χρονικής Περιόδου',
  'LBL_TOP_OPPORTUNITIES' => 'Καλύτερες Ευκαιρίες Μου',
  'LBL_TOTAL_OPPORTUNITIES' => 'Συνολικές Ευκαιρίες',
  'LBL_TOTAL_RLIS' => '# της Γραμμής Ειδών Συνολικών Εσόδων',
  'LBL_TYPE' => 'Τύπος:',
  'LBL_VIEW_FORM_TITLE' => 'Προβολή Ευκαιριών',
  'LBL_WORKSHEET' => 'Φύλλο Εργασίας',
  'LNK_CREATE' => 'Δημιουργία Συμφωνίας',
  'LNK_IMPORT_OPPORTUNITIES' => 'Εισαγωγή Ευκαιριών',
  'LNK_NEW_OPPORTUNITY' => 'Δημιουργία Ευκαιρίας',
  'LNK_OPPORTUNITY_LIST' => 'Προβολή Ευκαιριών',
  'LNK_OPPORTUNITY_REPORTS' => 'Προβολή Αναφορών Ευκαιριών',
  'MSG_DUPLICATE' => 'Με τη δημιουργία αυτής της ευκαιρίας πιθανά δημιουργείται αντίγραφη εγγραφή. Θα πρέπει να επιλεχθεί μία υπάρχουσα ευκαιρία από τον παρακάτω κατάλογο ή να επιλεγεί "Δημιουργία Νέας Ευκαιρίας".<br />Πατήστε το κουμπί "Αποθήκευση" για να συνεχίσετε αυτή τη νέα ευκαιρία, ή πατήστε το κουμπί "Ακύρωση" για να επιστρέψετε στην ενότητα χωρίς να δημιουργήσετε ευκαιρία.',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => 'Δεν μπορείτε να διαγράψετε Ευκαιρίες που περιέχουν Κλειστά Είδη Εσόδου',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Είστε βέβαιοι ότι θέλετε να αφαιρέσετε αυτή την Επαφή από την Ευκαιρία;',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'Είστε βέβαιοι ότι θέλετε να αφαιρέσετε αυτή την Ευκαιρία από το έργο;',
  'TPL_RLI_CREATE' => 'Μία Ευκαιρία πρέπει να έχει μία συσχετισμένη Γραμμή Στοιχείου Εσόδου. <a href="javascript:void(0);" id="createRLI">Δημιουργία Γραμμής Ειδών Εσόδων</a>.',
  'TPL_RLI_CREATE_LINK_TEXT' => 'Δημιουργία ενός Στοιχείου Εσόδου Γραμμής',
  'UPDATE' => 'Ευκαιρία - Ενημέρωση Νομίσματος',
  'UPDATE_BUGFOUND_COUNT' => 'Βρέθηκαν Σφάλματα:',
  'UPDATE_BUG_COUNT' => 'Βρέθηκαν Σφάλματα και έγινε Προσπάθεια να Διορθωθούν:',
  'UPDATE_COUNT' => 'Οι Εγγραφές Ενημερώθηκαν:',
  'UPDATE_CREATE_CURRENCY' => 'Δημιουργία Νέου Νομίσματος:',
  'UPDATE_DOLLARAMOUNTS' => 'Ενημέρωση των ποσών σε U.S. Δολλάρια',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Οι ενημέρωση των ποσών των ευκαιριών σε U.S. δολλάρια βασίζεται στις τρέχουσες επιλογές νομίσματος. Αυτή η τιμή χρησιμοποιείται για τον υπολογισμό των Γραφμημάτων στην Προβολή Λίστας Ποσών Νομισμάτων.',
  'UPDATE_DONE' => 'Έγινε',
  'UPDATE_FAIL' => 'Δεν έγινε ενημέρωση -',
  'UPDATE_FIX' => 'Καθορισμός Ποσών',
  'UPDATE_FIX_TXT' => 'Επιχειρεί να διορθώσει τα καθορισμένα ποσά, δημιουργώντας τις δεκαδικές τιμές από τα υπάρχοντα ποσά. Κάθε τροποποιημένο ποσό υποστηρίζει amount_backup στο πεδίο της βάσης δεδομένων.  Εάν εκτελέσετε αυτό και παρατηρήσετε σφάλματα, μην επιστρέψετε σε αυτό χωρίς επαναφορά από τα αντίγραφα ασφαλείας, καθώς μπορεί να αντικαταστήσει το αντίγραφο ασφαλείας με νέα μη έγκυρα δεδομένα.',
  'UPDATE_INCLUDE_CLOSE' => 'Συμπεριλαμβάνει τις Κλειστές Εγγραφές',
  'UPDATE_MERGE' => 'Συγχώνευση Νομισμάτων',
  'UPDATE_MERGE_TXT' => 'Συγχώνευση πολλαπλών νομισμάτων σε ένα νόμισμα. Εάν υπάρχουν πολλαπλές εγγραφές νομισμάτων, να επιλεγεί η συγχώνευσή τους. Αυτό θα συγχωνεύσει τα νομίσματα που υπάρχουν στις άλλες ενότητες της εφαρμογής.',
  'UPDATE_NULL_VALUE' => 'Το Ποσό είναι Μηδενικό, δίνοντας την τιμή 0 -',
  'UPDATE_RESTORE' => 'Επαναφορά Ποσών',
  'UPDATE_RESTORE_COUNT' => 'Οι Τιμές στις Εγγραφές που Αποκαταστάθηκαν είναι:',
  'UPDATE_RESTORE_TXT' => 'Επαναφέρει τις αριθμητικές τιμές από τα αντίγραφα ασφαλείας που δημιουργήθηκαν κατά την διαδικασία επιδιόρθωσης.',
  'UPDATE_VERIFY' => 'Επιβεβαίωση Ποσών',
  'UPDATE_VERIFY_CURAMOUNT' => 'Τρέχον Ποσό:',
  'UPDATE_VERIFY_FAIL' => 'Απέτυχε η Επιβεβαίωση της Εγγραφής:',
  'UPDATE_VERIFY_FIX' => 'Εκτελώντας τον καθορισμό θα δώσει',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Νέο Ποσό:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Νέο Νόμισμα:',
  'UPDATE_VERIFY_TXT' => 'Επιβεβαιώνει ότι τα ποσά είναι σε αριθμητικές τιμές (0-9) και με σωστά τα δεκαδικά ψηφία',
  'WARNING_NO_DELETE_CLOSED_SELECTED' => 'Μία ή περισσότερες από τις επιλεγμένες εγγραφές, περιέχουν Κλειστά Είδη Εσόδου, δεν μπορεί να διαγραφεί.',
);

