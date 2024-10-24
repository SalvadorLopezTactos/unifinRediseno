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
$object_name = strtolower($object_name);
$app_list_strings = [

    $object_name . '_type_dom' => [
        'Administration' => 'Yönetim',
        'Product' => 'Ürün',
        'User' => 'Kullanıcı',
    ],
    $object_name . '_status_dom' => [
        'New' => 'Yeni',
        'Assigned' => 'Atandı',
        'Closed' => 'Kapatıldı',
        'Pending Input' => 'Bekleyen Giriş',
        'Rejected' => 'Reddedildi',
        'Duplicate' => 'Aynı Kayıttan Oluştur',
    ],
    $object_name . '_priority_dom' => [
        'P1' => 'Yüksek',
        'P2' => 'Orta',
        'P3' => 'Düşük',
    ],
    $object_name . '_resolution_dom' => [
        '' => '',
        'Accepted' => 'Kabul edildi',
        'Duplicate' => 'Aynı Kayıttan Oluştur',
        'Closed' => 'Kapatıldı',
        'Out of Date' => 'Geçerliliğini Yitirmiş',
        'Invalid' => 'Geçersiz',
    ],
];
