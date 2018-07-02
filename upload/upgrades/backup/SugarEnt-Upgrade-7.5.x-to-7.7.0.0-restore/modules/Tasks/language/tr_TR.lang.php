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
  'DATE_FORMAT' => '(yıl-ay-gün)',
  'ERR_DELETE_RECORD' => 'Kontak bilgisini silmek için bir kayıt no&#39;su belirtmelisiniz.',
  'ERR_INVALID_HOUR' => 'Lütfen 0-24 arası bir saat girin',
  'LBL_ACTIVITIES_REPORTS' => 'Aktiviteler Raporu',
  'LBL_ASSIGNED_TO_NAME' => 'Atanan Kişi:',
  'LBL_ASSIGNED_USER' => 'Atanan Kişi',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Kontak:',
  'LBL_CONTACT_FIRST_NAME' => 'Kontak İsmi',
  'LBL_CONTACT_ID' => 'Kontak ID:',
  'LBL_CONTACT_LAST_NAME' => 'Kontak Soyismi',
  'LBL_CONTACT_NAME' => 'Kontak İsmi',
  'LBL_CONTACT_PHONE' => 'Kontak Telefonu:',
  'LBL_DATE_DUE' => 'Son Bitirme Tarihi',
  'LBL_DATE_DUE_FLAG' => 'Bitirme Tarihi Yok',
  'LBL_DATE_START_FLAG' => 'Başlangıç Tarihi Yok',
  'LBL_DEFAULT_PRIORITY' => 'Orta',
  'LBL_DESCRIPTION' => 'Tanım:',
  'LBL_DESCRIPTION_INFORMATION' => 'Tanım Bilgisi',
  'LBL_DUE_DATE' => 'Son Bitirme Tarihi:',
  'LBL_DUE_DATE_AND_TIME' => 'Son Bitirme Tarihi & Saati:',
  'LBL_DUE_TIME' => 'Son Bitirme Saati:',
  'LBL_EDITLAYOUT' => 'Yerleşimi Değiştir',
  'LBL_EMAIL' => 'E-Posta Adresi:',
  'LBL_EMAIL_ADDRESS' => 'E-Posta Adresi:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Atanmış Kullanıcı ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Atanmış Kullanıcı İsmi',
  'LBL_EXPORT_CREATED_BY' => 'Oluşturan ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Değiştiren ID',
  'LBL_EXPORT_PARENT_ID' => 'İlişkili Olduğu ID',
  'LBL_EXPORT_PARENT_TYPE' => 'İlişkili Olduğu Modül',
  'LBL_HELP_CREATE' => '{{module_name}} modülü, hakkında biraz bilgi sahibi olduğunuz, henuz  {{leads_singular_module}} olarak seçmediğiniz bireylerden oluşur.

{{module_name}} kaydı oluşturmak için:
1. İstenen şekilde alanlara değer giriniz.
 - "Zorunlu" olarak işaretlenmiş alanların kayıt öncesinde girilmesi gerekmektedir.
- Gerektiğinde, "Daha Fazlası" seçeneği ile ek alanları gösteriniz.
2. "Kaydet" tuşuna basarak yeni kaydınızı tamamlayın ve önceki sayfaya dönün.
- Yeni {{module_name}} kaydını görüntüleme modunda açmak için Kaydet ve Görüntüle seçeneğini kullanın.
- "Kaydet ve yenisini oluştur" seçeneği ile, kayıt sonrasında, hemen yeni bir {{module_name}} kaydı oluşturun.',
  'LBL_HELP_RECORD' => '{{plural_module_name}} modülü, esnek aksiyonlar, yapılacak işler veya tamamlanması gereken diğer türdeki aktivitelerden oluşur.

- Kaydın alanlarını, herhangi bir alana veya "Değiştir" tuşuna tıklayarak değiştirin.
- Alt solda yer alan paneli "Kayıt Görünümü" olarak değiştirerek, diğer kayıtlar ile olan bağlantıları görün veya değiştirin.
- Kaydın isminin sağındaki ikonlara tıklayarak kaydı izleyiniz veya favori olarak işaretleyiniz.
- Alt solda yer alan paneli "Aktivite Akışı" olarak değiştirerek, kullanıcı yorumları görün, oluşturun ve  {{activitystream_singular_module}}  kayıtındaki değişiklik tarihçesini görün.
- Daha fazla aksiyon, Değiştir tuşunun sağındaki Aksiyonlar seçimli menüde yer almaktadır.',
  'LBL_HELP_RECORDS' => '{{plural_module_name}} modülü, tamamlanması gereken esnek aksiyonlar, yapılacak işler, veya diğer türlü aktivitelerden oluşur. {{module_name}} kayıtları pek çok modül ile, esnek ilişki alanları ile bağlantılı olup, tek bir {{contacts_singular_module}} kayıtı ile ilişkili olabilir. {{plural_module_name}} kayıdı oluşturmak için Sugar içinde farklı yöntemler bulunmaktadır, örneğin {{plural_module_name}} modülü ile, aynı kayıttan oluşturarak, dışarıdan {{plural_module_name}} içeri yükleyerek, vb. {{module_name}} kaydı oluşturulduğunda, {{module_name}} modülündeki eksik bilgileri {{plural_module_name}} kayıt izleme ekranından görebilir ve düzeltebilirsiniz. {{module_name}} üzerindeki detaylara göre, {{module_name}} bilgisini Takvim modülünde görebilir ve değiştirebilirsiniz. Her {{module_name}} kaydı diğer {{accounts_module}}, {{contacts_module}}, {{opportunities_module}} ve benzeri Sugar kayıtları ile ilişkilendirilebilir.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Notlar',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Atanan Kullanıcı',
  'LBL_LIST_CLOSE' => 'Kapat',
  'LBL_LIST_COMPLETE' => 'Tamamlandı:',
  'LBL_LIST_CONTACT' => 'Kontak',
  'LBL_LIST_DATE_MODIFIED' => 'Değiştirilme Tarihi',
  'LBL_LIST_DUE_DATE' => 'Son Bitirme Tarihi',
  'LBL_LIST_DUE_TIME' => 'Son Bitirme Saati',
  'LBL_LIST_FORM_TITLE' => 'Görev Listesi',
  'LBL_LIST_MY_TASKS' => 'Açık Görevlerim',
  'LBL_LIST_PRIORITY' => 'Öncelik',
  'LBL_LIST_RELATED_TO' => 'İlişkili',
  'LBL_LIST_START_DATE' => 'Başlangıç Tarihi',
  'LBL_LIST_START_TIME' => 'Başlangıç Saati',
  'LBL_LIST_STATUS' => 'Durum',
  'LBL_LIST_SUBJECT' => 'Konu',
  'LBL_MODULE_NAME' => 'Görevler',
  'LBL_MODULE_NAME_SINGULAR' => 'Görev',
  'LBL_MODULE_TITLE' => 'Görevler: Ana Sayfa',
  'LBL_NAME' => 'İsim:',
  'LBL_NEW_FORM_DUE_DATE' => 'Son Bitirme Tarihi:',
  'LBL_NEW_FORM_DUE_TIME' => 'Son Bitirme Saati:',
  'LBL_NEW_FORM_SUBJECT' => 'Konusu:',
  'LBL_NEW_FORM_TITLE' => 'Görev Oluştur',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Yok',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notlar',
  'LBL_PARENT_ID' => 'Üst Kayıt ID:',
  'LBL_PARENT_NAME' => 'Üst Tipi:',
  'LBL_PHONE' => 'Telefon:',
  'LBL_PRIORITY' => 'Öncelik:',
  'LBL_REVENUELINEITEMS' => 'Gelir Kalemleri',
  'LBL_SEARCH_FORM_TITLE' => 'Görev Arama',
  'LBL_START_DATE' => 'Başlangıç Tarihi:',
  'LBL_START_DATE_AND_TIME' => 'Başlangıç Tarih & Saati:',
  'LBL_START_TIME' => 'Başlangıç Saati:',
  'LBL_STATUS' => 'Durum:',
  'LBL_SUBJECT' => 'Konusu:',
  'LBL_TASK' => 'Görevler:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Görev başarıyla kapatıldı.',
  'LBL_TASK_INFORMATION' => 'Genel Bilgi',
  'LNK_IMPORT_TASKS' => 'Görev Verilerini Yükle',
  'LNK_NEW_TASK' => 'Görev Oluştur',
  'LNK_TASK_LIST' => 'Görevleri Görüntüle',
);

