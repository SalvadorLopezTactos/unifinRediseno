<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$connector_strings = array(
    'LBL_LICENSING_INFO' =>
'<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">
註冊新的應用程式，從 Citrix Online GoToMeeting 獲取 API 金鑰。<br>
&nbsp;<br>
註冊實例的步驟：<br>
&nbsp;<br>
<ol>
<li>登入 Citrix Online 開發者帳戶：<a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>按一下「申請開發者金鑰」</li>
<li>在「產品 API」中選取 GoToMeeting，然後在應用程式 URL 中輸入實例 URL</li>
<li>「您的應用程式」下方將顯示一個名為「API 金鑰」的欄位</li>
<li>複製下方的 API 金鑰。</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'API 金鑰',
);
