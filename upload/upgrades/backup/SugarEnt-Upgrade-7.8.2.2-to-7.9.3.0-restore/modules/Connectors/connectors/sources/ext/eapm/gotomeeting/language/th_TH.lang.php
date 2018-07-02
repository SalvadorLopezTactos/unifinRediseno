<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$connector_strings = array(
    'LBL_LICENSING_INFO' =>
'<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">
รับคีย์ API จาก Citrix Online GoToMeeting ด้วยการลงทะเบียนแอปพลิเคชันใหม่<br>
&nbsp;<br>
ขั้นตอนในการลงทะเบียนอินสแตนซ์ของคุณ:<br>
&nbsp;<br>
<ol>
<li>ล็อกอินเข้าสู่บัญชีนักพัฒนาของ Citrix Online: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>คลิกที่ Apply for Developer Key</li>
<li>ใน Product API ให้เลือก GoToMeeting และป้อน URL ของอินสแตนซ์ใน Application URL</li>
<li>คุณจะเห็นคอลัมน์ชื่อ API Key ในส่วน Your Applications</li>
<li>คัดลอกไว้ด้านล่าง</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'คีย์ API',
);
