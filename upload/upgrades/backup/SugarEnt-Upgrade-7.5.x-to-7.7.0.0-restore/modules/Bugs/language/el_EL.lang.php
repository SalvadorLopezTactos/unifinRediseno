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
  'ERR_DELETE_RECORD' => 'Πρέπει να προσδιορίσετε αριθμό εγγραφής για να διαγράψετε το σφάλμα.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Λογαριασμοί',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Δραστηριότητες',
  'LBL_ASSIGNED_TO_NAME' => 'Ανατέθηκε σε',
  'LBL_BUG' => 'Σφάλμα:',
  'LBL_BUG_INFORMATION' => 'Επισκόπηση',
  'LBL_BUG_NUMBER' => 'Αριθμός Σφάλματος:',
  'LBL_BUG_SUBJECT' => 'Θέμα Σφάλματος:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Υποθέσεις',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Επαφές',
  'LBL_CONTACT_BUG_TITLE' => 'Επαφή-Σφάλμα:',
  'LBL_CONTACT_NAME' => 'Όνομα Επαφής:',
  'LBL_CONTACT_ROLE' => 'Ρόλος:',
  'LBL_CREATED_BY' => 'Δημιουργήθηκε από',
  'LBL_DATE_CREATED' => 'Ημερομηνία Δημιουργίας:',
  'LBL_DATE_LAST_MODIFIED' => 'Ημερομηνία Τροποποίησης:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Σφάλμα Σημείου Εντοπισμού',
  'LBL_DESCRIPTION' => 'Περιγραφή:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Έγγραφα',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Ταυτότητα Ανατεθειμένου Χειριστή',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Ανατεθειμένο Όνομα Χειριστή',
  'LBL_EXPORT_CREATED_BY' => 'Δημιουργήθηκε Από Ταυτότητα',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Σταθερό στο Όνομα Αναβάθμισης',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Τροποποιήθηκε Από Ταυτότητα',
  'LBL_FIXED_IN_RELEASE' => 'Σταθερό στην Αναβάθμιση:',
  'LBL_FOUND_IN_RELEASE' => 'Βρέθηκε στην Αναβάθμιση:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Βρέθηκε στο Όνομα Αναβάθμισης',
  'LBL_HELP_CREATE' => 'Η {{plural_module_name}} ενότητα, χρησιμοποιείται για να παρακολουθείτε και να διαχειρίζεστε τα προϊόντα που σχετίζονται με προβλήματα, που συνήθως αναφέρονται ως {{plural_module_name}}  ελαττωματικά, είτε βρέθηκαν εσωτερικά είτε αναφέρθηκαν από τους πελάτες.

Για να δημιουργήσετε μία εγγραφή {{module_name}}:
1. Παρέχετε τιμές για τα πεδία, όπως επιθυμείτε.
- Τα "Υποχρεωτικά" πεδία πρέπει να ολοκληρωθούν πριν από την αποθήκευση.
- Κάντε κλικ στην επιλογή "Εμφάνιση Περισσότερων" να εκθέσει πρόσθετα πεδία, εάν είναι απαραίτητο.
2. Κάντε κλικ στην επιλογή "Αποθήκευση" να οριστικοποιήσει τη νέα εγγραφή και να επιστρέψετε στην προηγούμενη σελίδα.
- Επιλέξτε "Αποθήκευση και προβολή" για να ανοίξετε τη νέα εγγραφή {{module_name}} στην προβολή.
- Επιλέξτε "Αποθήκευση και δημιουργία νέας" για να δημιουργήσει αμέσως μία νέα εγγραφή {{module_name}}.',
  'LBL_HELP_RECORD' => 'Η {{plural_module_name}} ενότητα, χρησιμοποιείται για να παρακολουθείτε και να διαχειρίζεστε τα προϊόντα που σχετίζονται με προβλήματα, που συνήθως αναφέρονται ως {{plural_module_name}}  ελαττωματικά, είτε βρέθηκαν εσωτερικά είτε αναφέρθηκαν από τους πελάτες..

- Επεξεργαστείτε αυτό το πεδίο εγγραφής κάνοντας κλικ στο μεμονωμένο πεδίο ή το κουμπί "Επεξεργασία".
- Προβάλετε ή τροποποιήστε συνδέσεις με άλλες εγγραφές στους υποπίνακες, από την εναλλαγή του κάτω αριστερού παραθύρου σε "Προβολή Δεδομένων".
- Αλληλεπιδράστε με τα σχόλια των χρηστών και την προβολή του ιστορικού των αλλαγών των εγγραφών {{activitystream_singular_module}}, από την εναλλαγή του κάτω αριστερού παραθύρου "Ροή Δραστηριοτήτων".
- Ακολουθήστε ή κάντε Αγαπημένες εγγραφές χρησιμοποιώντας τα εικονίδια στα δεξιά του ονόματος της εγγραφής.
- Πρόσθετες ενέργειες είναι διαθέσιμες στο αναπτυσσόμενο μενού "Ενέργειες", δεξιά από το κουμπί "Επεξεργασία".',
  'LBL_HELP_RECORDS' => 'Η {{plural_module_name}} ενότητα, χρησιμοποιείται για να παρακολουθείτε και να διαχειρίζεστε τα προϊόντα που σχετίζονται με προβλήματα, που συνήθως αναφέρονται ως {{plural_module_name}}  ελαττωματικά, είτε βρέθηκαν εσωτερικά είτε αναφέρθηκαν από τους πελάτες. Η {{plural_module_name}} ενότητα μπορεί να ανιχνευθεί περαιτέρω και να επισκευστεί στην αναβάθμιση. Η {{plural_module_name}} ενότητα, δίνει στους χειριστές ένα τρόπο για γρήγορη αναθεώρηση των λεπτομερειών {{module_name}} και τη διαδικασία που χρησιμοποιείται για να το διορθώσει. Μόλις δημιουργηθεί μία {{module_name}} ή υποβληθεί, μπορείτε να προβάλετε και να επεξεργαστείτε τις πληροφορίες που την αφορούν {{module_name}} μέσω της {{module_name}} προβολής εγγραφής {{module_name}}. Κάθε εγγραφή {{module_name}} μπορεί στη συνέχεια να συσχετιστεί με άλλες εγγραφές στο Sugar όπως {{calls_module}}, {{contacts_module}}, {{cases_module}}, και πολλές άλλες.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Ιστορικό',
  'LBL_INVITEE' => 'Επαφές',
  'LBL_LIST_ACCOUNT_NAME' => 'Όνομα Λογαριασμού',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Ανατεθειμένος Χειριστής',
  'LBL_LIST_CONTACT_NAME' => 'Όνομα Επαφής',
  'LBL_LIST_EMAIL_ADDRESS' => 'Διεύθυνση Email',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Σταθερό στην Αναβάθμιση',
  'LBL_LIST_FORM_TITLE' => 'Λίστα Σφαλμάτων',
  'LBL_LIST_LAST_MODIFIED' => 'Τελευταία Τροποποίηση',
  'LBL_LIST_MY_BUGS' => 'Ανατεθειμένα Μου Σφάλματα',
  'LBL_LIST_NUMBER' => 'Αριθ.',
  'LBL_LIST_PHONE' => 'Τηλέφωνο',
  'LBL_LIST_PRIORITY' => 'Προτεραιότητα',
  'LBL_LIST_RELEASE' => 'Αναβάθμιση',
  'LBL_LIST_RESOLUTION' => 'Ανάλυση',
  'LBL_LIST_STATUS' => 'Κατάσταση',
  'LBL_LIST_SUBJECT' => 'Θέμα',
  'LBL_LIST_TYPE' => 'Τύπος',
  'LBL_MODIFIED_BY' => 'Τελευταία Τροποποίηση από:',
  'LBL_MODULE_ID' => 'Σφάλματα',
  'LBL_MODULE_NAME' => 'Σφάλματα',
  'LBL_MODULE_NAME_SINGULAR' => 'Σφάλμα',
  'LBL_MODULE_TITLE' => 'Σφάλμα Σημείου Εντοπισμού: Αρχή',
  'LBL_NEW_FORM_TITLE' => 'Νέο Σφάλμα',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Σημειώσεις',
  'LBL_NUMBER' => 'Αριθμός:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Αν έχετε βρει ένα νέο Σφάλμα που θα θέλατε να αναφέρετε, μπορείτε να κάνετε κλικ εδώ για να το αναφέρετε.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Μπορείτε να φιλτράρετε κάτω στη λίστα Σφαλμάτων, παρέχοντας έναν όρο αναζήτησης.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Για παράδειγμα, μπορείτε να χρησιμοποιήσετε αυτό για να βρείτε ένα σφάλμα που είχε αναφερθεί προηγουμένως.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'Η ενότητα "Σφάλματα", είναι για να προβάλει και να υποβάλει σφάλματα. Χρησιμοποιήστε τα βέλη παρακάτω, για να περάσουν από μια γρήγορη περιήγηση.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Αυτή η σελίδα εμφανίζει τη λίστα των υφιστάμενων δημοσιευμένων Σφαλμάτων.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Κάνοντας κλικ εδώ, θα σας επιστρέψει σε αυτήν την προβολή ανά πάσα στιγμή.',
  'LBL_PORTAL_VIEWABLE' => 'Ικανή Προβολή Portal',
  'LBL_PRIORITY' => 'Προτεραιότητα:',
  'LBL_PRODUCT_CATEGORY' => 'Κατηγορία:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Έργα',
  'LBL_RELEASE' => 'Αναβάθμιση:',
  'LBL_RESOLUTION' => 'Ανάλυση:',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Σφάλματος',
  'LBL_SHOW_IN_PORTAL' => 'Εμφάνιση στο Portal',
  'LBL_SHOW_MORE' => 'Εμφάνιση Περισσότερων Σφαλμάτων',
  'LBL_SOURCE' => 'Πηγή:',
  'LBL_STATUS' => 'Κατάσταση:',
  'LBL_SUBJECT' => 'Θέμα:',
  'LBL_SYSTEM_ID' => 'Ταυτότητα Συστήματος',
  'LBL_TYPE' => 'Τύπος:',
  'LBL_WORK_LOG' => 'Καταγραφή Εργασίας:',
  'LNK_BUG_LIST' => 'Προβολή Σφαλμάτων',
  'LNK_BUG_REPORTS' => 'Προβολή Αναφορών Σφαλμάτων',
  'LNK_CREATE' => 'Αναφορά Σφάλματος',
  'LNK_CREATE_WHEN_EMPTY' => 'Αναφέρετε ένα Σφάλμα τώρα.',
  'LNK_IMPORT_BUGS' => 'Εισαγωγή Σφαλμάτων',
  'LNK_NEW_BUG' => 'Αναφορά Σφάλματος',
  'NTC_DELETE_CONFIRMATION' => 'Είστε βέβαιοι ότι θέλετε να αφαιρέσετε αυτή την επαφή από αυτό το σφάλμα;',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Είστε βέβαιοι ότι θέλετε να αφαιρέσετε αυτό το σφάλμα από αυτόν τον λογαριασμό;',
  'NTC_REMOVE_INVITEE' => 'Είστε βέβαιοι ότι θέλετε να αφαιρέσετε αυτή την επαφή από το σφάλμα;',
);

