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
  'ERR_DELETE_RECORD' => 'Müşteriyi silmek için bir kayıt numarası girmelisiniz.',
  'ERR_REMOVING_ATTACHMENT' => 'Eki silme başarısız oldu...',
  'LBL_ACCOUNT_ID' => 'Müşteri ID:',
  'LBL_ACTIVITIES_REPORTS' => 'Aktiviteler Raporu',
  'LBL_CASE_ID' => 'Talep ID:',
  'LBL_CLOSE' => 'Kapat:',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'Kontak ID:',
  'LBL_CONTACT_NAME' => 'Kontak:',
  'LBL_CREATED_BY' => 'Oluşturan',
  'LBL_DATE_ENTERED' => 'Oluşturulma Tarihi',
  'LBL_DATE_MODIFIED' => 'Değiştirilme Tarihi',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Notlar',
  'LBL_DELETED' => 'Silindi',
  'LBL_DESCRIPTION' => 'Not',
  'LBL_EDITLAYOUT' => 'Yerleşimi Değiştir',
  'LBL_EMAIL_ADDRESS' => 'E-Posta Adresi:',
  'LBL_EMAIL_ATTACHMENT' => 'E-Posta Eki',
  'LBL_EMBED_FLAG' => 'E-Posta içinde gömülü mü?',
  'LBL_EXPORT_PARENT_ID' => 'İlişkili Olduğu ID',
  'LBL_EXPORT_PARENT_TYPE' => 'İlişkili Olduğu Modül',
  'LBL_FILENAME' => 'Ek:',
  'LBL_FILE_MIME_TYPE' => 'Mime Tipi',
  'LBL_FILE_URL' => 'Dosya URL',
  'LBL_FIRST_NAME' => 'İsim',
  'LBL_HELP_CREATE' => '{{module_name}} oluşturmak için:<br />1. İstendiği şekilde alanlar için değerler giriniz.<br /> - "Zorunlu" olarak belirtilmiş alanların kaydetme öncesinde girilmesi gereklidir.<br /> - Gerek duyulursa "Daha Fazlasına" tıklayarak ek alanların görülmesi sağlanabilir.<br />2. "Kaydet" tuşuna basarak yeni kayıt oluşturma işlemini tamamlayınız ve öncesi sayfaya geçiniz.<br /> - "Kaydet ve görüntüle" tuşuna basarak yeni {{module_name}}  kaydını görüntü modunda açabilirsiniz.<br /> - "Kaydet ve yeni oluştur" tuşuna basarak hemen yeni bir {{module_name}} oluşturma ekranına geçebilirsiniz.',
  'LBL_HELP_RECORD' => '{{plural_module_name}} modülü, ilişkili kayıta ait metin veya ek dosya {{plural_module_name}} kayıtlarından oluşur.

- Kaydın alanlarını, herhangi bir alana veya "Değiştir" tuşuna tıklayarak değiştirin.
- Alt solda yer alan paneli "Kayıt Görünümü" olarak değiştirerek, diğer kayıtlar ile olan bağlantıları görün veya değiştirin.
- Kaydın isminin sağındaki ikonlara tıklayarak kaydı izleyiniz veya favori olarak işaretleyiniz.
- Alt solda yer alan paneli "Aktivite Akışı" olarak değiştirerek, kullanıcı yorumları görün, oluşturun ve  {{activitystream_singular_module}}  kayıtındaki değişiklik tarihçesini görün.
- Daha fazla aksiyon, Değiştir tuşunun sağındaki Aksiyonlar seçimli menüde yer almaktadır.',
  'LBL_HELP_RECORDS' => '{{plural_module_name}} modülü, ilişkili kayıta ait metin veya döküman barındıran {{plural_module_name}} kayıtlarından oluşur. {{module_name}} kayıtları, pek çok modülde, esnek ilişki alanları ile ilişkilendirilmiştir, ayrıca tek bir {{contacts_singular_module}} ile ilişki tanımlanması da mümkündür. {{plural_module_name}} bir kayıt hakkında genel bilgi veya ek içerebilir. {{plural_module_name}} kayıdı oluşturmak için Sugar içinde farklı yöntemler bulunmaktadır, örneğin {{plural_module_name}} modülü ile, dışarıdan {{plural_module_name}} içeri yükleyerek, veya Tarihçe altpaneli üzerinden, vb. {{module_name}} kaydı oluşturulduğunda, {{module_name}} modülündeki eksik bilgileri {{plural_module_name}} kayıt izleme ekranından görebilir ve düzeltebilirsiniz. Her {{module_name}} kaydı, {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, ve diğer Sugar kayıtları ile ilişkilendirilebilir.',
  'LBL_LAST_NAME' => 'Soyisim',
  'LBL_LEAD_ID' => 'Talep ID :',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Atanan Kullanıcı',
  'LBL_LIST_CONTACT' => 'Kontak',
  'LBL_LIST_CONTACT_NAME' => 'Kontak',
  'LBL_LIST_DATE_MODIFIED' => 'Değiştirilme Tarihi',
  'LBL_LIST_EDIT_BUTTON' => 'Değiştir',
  'LBL_LIST_FILENAME' => 'Ek',
  'LBL_LIST_FORM_TITLE' => 'Not Listesi',
  'LBL_LIST_RELATED_TO' => 'İlişkili',
  'LBL_LIST_STATUS' => 'Durum',
  'LBL_LIST_SUBJECT' => 'Konu',
  'LBL_MEMBER_OF' => 'Üyesi:',
  'LBL_MODIFIED_BY' => 'Değiştiren',
  'LBL_MODULE_NAME' => 'Notlar',
  'LBL_MODULE_NAME_SINGULAR' => 'Not',
  'LBL_MODULE_TITLE' => 'Notlar: Ana Sayfa',
  'LBL_MY_NOTES_DASHLETNAME' => 'Notlarım',
  'LBL_NEW_FORM_BTN' => 'Not Ekle',
  'LBL_NEW_FORM_TITLE' => 'Not veya Ek Oluştur',
  'LBL_NOTE' => 'Not:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Ekler',
  'LBL_NOTE_INFORMATION' => 'Genel Bilgi',
  'LBL_NOTE_STATUS' => 'Not',
  'LBL_NOTE_SUBJECT' => 'Konusu:',
  'LBL_OC_FILE_NOTICE' => 'Lütfen dosyayı görmek için sunucuya giriş yapınız',
  'LBL_OPPORTUNITY_ID' => 'Fırsat ID:',
  'LBL_PANEL_DETAILS' => 'Detaylar',
  'LBL_PARENT_ID' => 'Üst Kayıt ID:',
  'LBL_PARENT_TYPE' => 'Üst Kayıt Tipi',
  'LBL_PHONE' => 'Telefon:',
  'LBL_PORTAL_FLAG' => 'Portal&#39;da Görünsün mü?',
  'LBL_PRODUCT_ID' => 'Ürün ID:',
  'LBL_QUOTE_ID' => 'Teklif ID:',
  'LBL_RELATED_TO' => 'İlişkili:',
  'LBL_REMOVING_ATTACHMENT' => 'Eki Siliyor...',
  'LBL_REVENUELINEITEMS' => 'Gelir Satır Öğeleri',
  'LBL_SEARCH_FORM_TITLE' => 'Not Arama',
  'LBL_SEND_ANYWAYS' => 'Bu E-Postanı konu bölümü boş. Yine de gönderilsin/kaydedilsin mi?',
  'LBL_STATUS' => 'Durum',
  'LBL_SUBJECT' => 'Konusu:',
  'LNK_IMPORT_NOTES' => 'Not Verilerini Yükle',
  'LNK_NEW_NOTE' => 'Not veya Ek Oluştur',
  'LNK_NOTE_LIST' => 'Notları Görüntüle',
);

