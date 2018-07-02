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
注册一个新的应用程序，从 Citrix Online GoToMeeting 获取 API 密钥。<br>
&nbsp;<br>
注册实例的步骤：<br>
&nbsp;<br>
<ol>
<li>登录您的 Citrix Online 开发者账户：<a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>单击“申请开发者密钥”</li>
<li>在“产品 API”中选择“GoToMeeting”，然后在应用程序 URL 中输入您的实例 URL</li>
<li>“您的应用程序”下将显示一个被称为“API 密钥”的数列</li>
<li>复制下方的 API 密钥。</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'API 密钥',
);
