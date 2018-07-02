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
  'DATE_FORMAT' => '(εεεε-μμ-ηη)',
  'ERR_DELETE_RECORD' => 'Πρέπει να προσδιορίσετε αριθμό εγγραφής για να διαγράψετε την επαφή.',
  'ERR_INVALID_HOUR' => 'Παρακαλώ εισάγετε μία ώρα απο 0 έως 24',
  'LBL_ACTIVITIES_REPORTS' => 'Αναφορές Δραστηριοτήτων',
  'LBL_ASSIGNED_TO_NAME' => 'Ανατέθηκε σε:',
  'LBL_ASSIGNED_USER' => 'Ανατέθηκε σε',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Επαφή:',
  'LBL_CONTACT_FIRST_NAME' => 'Όνομα Επαφής',
  'LBL_CONTACT_ID' => 'Ταυτότητα Επαφής:',
  'LBL_CONTACT_LAST_NAME' => 'Επώνυμο Επαφής',
  'LBL_CONTACT_NAME' => 'Όνομα Επαφής:',
  'LBL_CONTACT_PHONE' => 'Τηλέφωνο Επαφής:',
  'LBL_DATE_DUE' => 'Έως Ημερομηνία',
  'LBL_DATE_DUE_FLAG' => 'Προθεσμία',
  'LBL_DATE_START_FLAG' => 'Ημερομηνία Έναρξης',
  'LBL_DEFAULT_PRIORITY' => 'Μεσαία',
  'LBL_DESCRIPTION' => 'Περιγραφή:',
  'LBL_DESCRIPTION_INFORMATION' => 'Πληροφορία Περιγραφής',
  'LBL_DUE_DATE' => 'Έως Ημερομηνία:',
  'LBL_DUE_DATE_AND_TIME' => 'Έως Ημερομηνία και Ώρα:',
  'LBL_DUE_TIME' => 'Έως Ώρα:',
  'LBL_EDITLAYOUT' => 'Επεξεργασία Διάταξης',
  'LBL_EMAIL' => 'Διεύθυνση Email:',
  'LBL_EMAIL_ADDRESS' => 'Διεύθυνση Email:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Ταυτότητα Ανατεθειμένου Χειριστή',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Όνομα Ανατεθειμένου Χειριστή',
  'LBL_EXPORT_CREATED_BY' => 'Δημιουργήθηκε Από Ταυτότητα',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Τροποποιήθηκε Από Ταυτότητα',
  'LBL_EXPORT_PARENT_ID' => 'Σχετίζεται Με Ταυτότητα',
  'LBL_EXPORT_PARENT_TYPE' => 'Σχετίζεται Με Ενότητα',
  'LBL_HELP_CREATE' => 'Η {{plural_module_name}} ενότητα, αποτελείται από ευέλικτες δράσεις, εκκρεμή στοιχεία, ή άλλου είδους δραστηριότητες οι οποίες απαιτούν την ολοκλήρωση.

Για να δημιουργήσετε μία εγγραφή {{module_name}}:
1.Παρέχετε τιμές για τα πεδία, όπως επιθυμείτε.
 - Τα "Υποχρεωτικά" πεδία πρέπει να συμπληρωθούν πριν από την αποθήκευση..
 - Κάντε κλικ στην επιλογή "Εμφάνιση Περισσότερων" να εκθέσει πρόσθετα πεδία, εάν είναι απαραίτητο.
2. Κάντε κλικ στην επιλογή "Αποθήκευση" να οριστικοποιήσει τη νέα εγγραφή και να επιστρέψετε στην προηγούμενη σελίδα.
 - Επιλέξτε "Αποθήκευση και προβολή" για να ανοίξετε τη νέα εγγραφή {{module_name}} στην προβολή.
 - Επιλέξτε "Αποθήκευση και δημιουργία νέας" για να δημιουργήσει αμέσως μία νέα {{module_name}}.',
  'LBL_HELP_RECORD' => 'Η {{plural_module_name}} ενότητα, αποτελείται από ευέλικτες δράσεις, εκκρεμή στοιχεία, ή άλλου είδους δραστηριότητες η οποίες απαιτούν την ολοκλήρωση.

- Επεξεργαστείτε αυτό το πεδίο εγγραφής κάνοντας κλικ στο μεμονωμένο πεδίο ή το κουμπί "Επεξεργασία".
- Προβάλετε ή τροποποιήστε συνδέσεις με άλλες εγγραφές στους υποπίνακες, από την εναλλαγή του κάτω αριστερού παραθύρου σε "Προβολή Δεδομένων".
- Αλληλεπιδράστε με τα σχόλια των χρηστών και την προβολή του ιστορικού των αλλαγών των εγγραφών, {{activitystream_singular_module}} από την εναλλαγή του κάτω αριστερού παραθύρου "Ροή Δραστηριοτήτων".
- Ακολουθήστε ή κάντε Αγαπημένες εγγραφές χρησιμοποιώντας τα εικονίδια στα δεξιά του ονόματος της εγγραφής.
- Πρόσθετες ενέργειες είναι διαθέσιμες στο αναπτυσσόμενο μενού "Ενέργειες", δεξιά από το κουμπί "Επεξεργασία".',
  'LBL_HELP_RECORDS' => 'Η {{plural_module_name}} ενότητα, αποτελείται από ευέλικτες δράσεις, εκκρεμή στοιχεία, ή άλλου είδους δραστηριότητες οι οποίες απαιτούν την ολοκλήρωση. {{module_name}} οι εγγραφές μπορούν να σχετίζονται με μία εγγραφή στις περισσότερες ενότητες, μέσω των ελαστικών συσχετιζόμενων πεδιών και μπορεί επίσης να συσχετίζονται με μια ενιαία {{contacts_singular_module}}. Υπάρχουν διάφοροι τρόποι που μπορείτε να δημιουργήσετε εγγραφές στο Sugar {{plural_module_name}} όπως μέσω της ενότητας {{plural_module_name}}, αντίγραφα, να εισαγάγετε δεδομένα {{plural_module_name}}, κ.λ.π. Αφού δημιουργηθεί η εγγραφή {{module_name}}, μπορείτε να προβάλετε και να επεξεργαστείτε τις πληροφορίες που την αφορούν {{module_name}} μέσω της προβολής εγγραφής {{plural_module_name}}. Ανάλογα με τις λεπτομέρειες που σχετίζονται με την εγγραφή {{module_name}}, επίσης μπορετεί να προβάλετε και να επεξεργαστείτε τις πληροφορίες {{module_name}} μέσω της ενότητας Ημερολόγιο. Κάθε εγγραφή {{module_name}} μπορεί στη συνέχεια να συσχετιστεί με άλλες καρτέλες στο Sugar όπως {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, και πολλά άλλα..',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Σημειώσεις',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Ανατεθειμένος Χειριστής',
  'LBL_LIST_CLOSE' => 'Κλείσιμο',
  'LBL_LIST_COMPLETE' => 'Ολοκληρωμένη:',
  'LBL_LIST_CONTACT' => 'Επαφή',
  'LBL_LIST_DATE_MODIFIED' => 'Ημερομηνία Τροποποίησης',
  'LBL_LIST_DUE_DATE' => 'Έως Ημερομηνία',
  'LBL_LIST_DUE_TIME' => 'Έως Ώρα',
  'LBL_LIST_FORM_TITLE' => 'Λίστα Εργασιών',
  'LBL_LIST_MY_TASKS' => 'Ανοικτές Εργασίες Μου',
  'LBL_LIST_PRIORITY' => 'Προτεραιότητα',
  'LBL_LIST_RELATED_TO' => 'Σχετίζεται με',
  'LBL_LIST_START_DATE' => 'Ημερομηνία Έναρξης',
  'LBL_LIST_START_TIME' => 'Ώρα Έναρξης',
  'LBL_LIST_STATUS' => 'Κατάσταση',
  'LBL_LIST_SUBJECT' => 'Θέμα',
  'LBL_MODULE_NAME' => 'Εργασίες',
  'LBL_MODULE_NAME_SINGULAR' => 'Εργασία',
  'LBL_MODULE_TITLE' => 'Εργασίες: Αρχή',
  'LBL_NAME' => 'Όνομα:',
  'LBL_NEW_FORM_DUE_DATE' => 'Έως Ημερομηνία:',
  'LBL_NEW_FORM_DUE_TIME' => 'Έως Ώρα:',
  'LBL_NEW_FORM_SUBJECT' => 'Θέμα:',
  'LBL_NEW_FORM_TITLE' => 'Δημιουργία Εργασίας',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'κανένα',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Σημειώσεις',
  'LBL_PARENT_ID' => 'Γονική Ταυτότητα:',
  'LBL_PARENT_NAME' => 'Γονικός Τύπος:',
  'LBL_PHONE' => 'Τηλέφωνο:',
  'LBL_PRIORITY' => 'Προτεραιότητα:',
  'LBL_REVENUELINEITEMS' => 'Γραμμή Εσόδων',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Εργασίας',
  'LBL_START_DATE' => 'Ημερομηνία Έναρξης:',
  'LBL_START_DATE_AND_TIME' => 'Ημερομηνία και Ώρα Έναρξης:',
  'LBL_START_TIME' => 'Ώρα Έναρξης:',
  'LBL_STATUS' => 'Κατάσταση:',
  'LBL_SUBJECT' => 'Θέμα:',
  'LBL_TASK' => 'Εργασίες:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Η εργασία έκλεισε με επιτυχία:',
  'LBL_TASK_INFORMATION' => 'Επισκόπηση',
  'LNK_IMPORT_TASKS' => 'Εισαγωγή Εργασιών',
  'LNK_NEW_TASK' => 'Δημιουργία Εργασίας',
  'LNK_TASK_LIST' => 'Προβολή Εργασιών',
);

