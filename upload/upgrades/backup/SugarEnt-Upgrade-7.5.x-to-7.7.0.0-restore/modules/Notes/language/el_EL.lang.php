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
  'ERR_DELETE_RECORD' => 'Πρέπει να προσδιορίσετε αριθμό εγγραφής για να διαγράψετε τον λογαριασμό.',
  'ERR_REMOVING_ATTACHMENT' => 'Αποτυχία στην αφαίρεση επισύναψης...',
  'LBL_ACCOUNT_ID' => 'Ταυτότητα Λογαριασμού:',
  'LBL_ACTIVITIES_REPORTS' => 'Αναφορές Δραστηριοτήτων',
  'LBL_CASE_ID' => 'Ταυτότητα Υπόθεσης:',
  'LBL_CLOSE' => 'Κλείσιμο:',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'Ταυτότητα Επαφής:',
  'LBL_CONTACT_NAME' => 'Επαφή:',
  'LBL_CREATED_BY' => 'Δημιουργήθηκε Από',
  'LBL_DATE_ENTERED' => 'Ημερομηνία Δημιουργίας',
  'LBL_DATE_MODIFIED' => 'Ημερομηνία Τροποποίησης',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Σημειώσεις',
  'LBL_DELETED' => 'Διαγράφηκε',
  'LBL_DESCRIPTION' => 'Σημείωση',
  'LBL_EDITLAYOUT' => 'Επεξεργασία Διάταξης',
  'LBL_EMAIL_ADDRESS' => 'Διεύθυνση Email:',
  'LBL_EMAIL_ATTACHMENT' => 'Επισύναψη Email',
  'LBL_EMBED_FLAG' => 'Ενσωμάτωση στο email;',
  'LBL_EXPORT_PARENT_ID' => 'Σχετίζεται Με Ταυτότητα',
  'LBL_EXPORT_PARENT_TYPE' => 'Σχετίζεται Με Ενότητα',
  'LBL_FILENAME' => 'Επισύναψη:',
  'LBL_FILE_MIME_TYPE' => 'Τύπος Mime',
  'LBL_FILE_URL' => 'Αρχείο URL',
  'LBL_FIRST_NAME' => 'Όνομα',
  'LBL_HELP_CREATE' => 'Για να δημιουργήσετε μία εγγραφή {{module_name}}:
1. Παρέχετε τιμές για τα πεδία, όπως επιθυμείτε.
 - Τα πεδία "Υποχρεωτικό", πρέπει να συμπληρωθούν πριν από την αποθήκευση.
 - Κάντε κλικ στην επιλογή "Εμφάνιση Περισσότερων" να εκθέσει πρόσθετα πεδία, εάν είναι απαραίτητο.
2. Κάντε κλικ στην επιλογή "Αποθήκευση" να οριστικοποιήσει τη νέα εγγραφή και να επιστρέψετε στην προηγούμενη σελίδα.
 - Επιλέξτε "Αποθήκευση και προβολή" για να ανοίξετε τη νέα εγγραφή {{module_name}} στην προβολή.
 - Επιλέξτε "Αποθήκευση και δημιουργία νέας" για να δημιουργήσει αμέσως μία νέα εγγραφή {{module_name}}.',
  'LBL_HELP_RECORD' => 'Η {{plural_module_name}} ενότητα αποτελείται από μεμονομένα άτομα {{plural_module_name}} που περιέχει κείμενο ή ένα συνημμένο αρχείο στην συναφή εγγραφή. 

- Επεξεργαστείτε αυτό το πεδίο εγγραφής κάνοντας κλικ στο μεμονωμένο πεδίο ή το κουμπί "Επεξεργασία".
- Προβάλετε ή τροποποιήστε συνδέσεις με άλλες εγγραφές στους υποπίνακες, από την εναλλαγή του κάτω αριστερού παραθύρου σε "Προβολή Δεδομένων".
- Αλληλεπιδράστε με τα σχόλια των χρηστών και την προβολή του ιστορικού των αλλαγών των εγγραφών {{activitystream_singular_module}}, από την εναλλαγή του κάτω αριστερού παραθύρου "Ροή Δραστηριοτήτων".
- Ακολουθήστε ή κάντε Αγαπημένες εγγραφές χρησιμοποιώντας τα εικονίδια στα δεξιά του ονόματος της εγγραφής.
- Πρόσθετες ενέργειες είναι διαθέσιμες στο αναπτυσσόμενο μενού "Ενέργειες", δεξιά από το κουμπί "Επεξεργασία".',
  'LBL_HELP_RECORDS' => 'Η {{plural_module_name}} ενότητα αποτελείται από μεμονομένα άτομα {{plural_module_name}} που περιέχει κείμενο ή ένα συνημμένο αρχείο στην συναφή εγγραφή. Οι {{module_name}}εγγραφές μπορούν να σχετίζονται με μία εγγραφή στις περισσότερες ενότητες, μέσω των ελαστικών συσχετιζόμενων πεδιών και μπορεί επίσης να συσχετίζονται με μια ενιαία εγγραφή {{contacts_singular_module}}. {{plural_module_name}} μπορεί να κρατήσει το γενικό κείμενο για μια εγγραφή ή ακόμη και ένα συνημμένο που σχετίζεται με την εγγραφή. Υπάρχουν πολλοί τρόποι στο Sugar που μπορείτε να δημιουργήσετε εγγραφές {{plural_module_name}} μέσω της ενότητας  {{plural_module_name}}, να εισαγάγετε δεδομένα {{plural_module_name}}, μέσω του Ιστορικού υποπινάκων, κ.λ.π. Αφού δημιουργήσετε την εγγραφή {{module_name}}, μπορείτε να προβάλετε και να επεξεργαστείτε τις πληροφορίες που την αφορούν {{module_name}} μέσω της ενότητας {{plural_module_name}}προβολή εγγραφής. Κάθε εγγραφή {{module_name}},  μπορεί στη συνέχεια να συσχετιστεί με άλλες εγγραφές στο Sugar όπως,{{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, και πολλές άλλλες.',
  'LBL_LAST_NAME' => 'Επώνυμο',
  'LBL_LEAD_ID' => 'Ταυτότητα Δυνητικού Πελάτη:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Ανατεθειμένος Χειριστής',
  'LBL_LIST_CONTACT' => 'Επαφή',
  'LBL_LIST_CONTACT_NAME' => 'Επαφή',
  'LBL_LIST_DATE_MODIFIED' => 'Τελευταία Τροποποίηση',
  'LBL_LIST_EDIT_BUTTON' => 'Επεξεργασία',
  'LBL_LIST_FILENAME' => 'Επισύναψη',
  'LBL_LIST_FORM_TITLE' => 'Λίστα Σημειώσεων',
  'LBL_LIST_RELATED_TO' => 'Σχετιίζεται Με',
  'LBL_LIST_STATUS' => 'Κατάσταση',
  'LBL_LIST_SUBJECT' => 'Θέμα',
  'LBL_MEMBER_OF' => 'Μέλος του:',
  'LBL_MODIFIED_BY' => 'Τροποποιήθηκε Από',
  'LBL_MODULE_NAME' => 'Σημειώσεις',
  'LBL_MODULE_NAME_SINGULAR' => 'Σημείωση',
  'LBL_MODULE_TITLE' => 'Σημειώσεις: Αρχή',
  'LBL_MY_NOTES_DASHLETNAME' => 'Σημειώσεις Μου',
  'LBL_NEW_FORM_BTN' => 'Προσθήκη μιας Σημείωσης',
  'LBL_NEW_FORM_TITLE' => 'Δημιουργία Σημείωσης ή Προσθήκη Επισύναψης',
  'LBL_NOTE' => 'Σημείωση:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Σημειώσεις & Επισυνάψεις',
  'LBL_NOTE_INFORMATION' => 'Επισκόπηση',
  'LBL_NOTE_STATUS' => 'Σημείωση',
  'LBL_NOTE_SUBJECT' => 'Θέμα:',
  'LBL_OC_FILE_NOTICE' => 'Παρακαλώ συνδεθείτε στον διακομιστή για να δείτε το αρχείο',
  'LBL_OPPORTUNITY_ID' => 'Ταυτότητα Ευκαιρίας:',
  'LBL_PANEL_DETAILS' => 'Λεπτομέρειες',
  'LBL_PARENT_ID' => 'Γονική Ταυτότητα:',
  'LBL_PARENT_TYPE' => 'Γονική Ταυτότητα',
  'LBL_PHONE' => 'Τηλέφωνο:',
  'LBL_PORTAL_FLAG' => 'Εμφάνιση στο Portal;',
  'LBL_PRODUCT_ID' => 'Ταυτότητα Προϊόντος:',
  'LBL_QUOTE_ID' => 'Ταυτότητα Προσφοράς:',
  'LBL_RELATED_TO' => 'Σχετίζεται Με:',
  'LBL_REMOVING_ATTACHMENT' => 'Αφαίρεση επισύναψης...',
  'LBL_REVENUELINEITEMS' => 'Γραμμή Στοιχείου Εσόδων',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Σημειώσεων',
  'LBL_SEND_ANYWAYS' => 'Το email δεν έχει θέμα. Αποστολή/αποθήκευση σε κάθε περίπτωση;',
  'LBL_STATUS' => 'Κατάσταση',
  'LBL_SUBJECT' => 'Θέμα:',
  'LNK_IMPORT_NOTES' => 'Εισαγωγή Σημειώσεων',
  'LNK_NEW_NOTE' => 'Δημιουργία Σημείωσης ή Επισύναψης',
  'LNK_NOTE_LIST' => 'Προβολή Σημειώσεων',
);

