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

/*********************************************************************************
* Description:
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
* Reserved. Contributor(s): contact@synolia.com - www.synolia.com
* *******************************************************************************/


$connector_strings = array (
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">ツイッターで あなたの Sugar インスタンスを新規アプリケーションとして登録することにより、コンシューマーキーとコンシューマーシークレットを取得します。<br/><br>あなたのインスタンスを登録する手順は次の通りです。<br/><br/><ol><li>ツイッターデベロッパーサイト ： <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a> へ移動します。</li><li>アプリケーションを登録したいツイッターアカウントを使用してサインインします。</li><li>登録フォーム内で、アプリケーションに関する名前を入力します。これはユーザーがそれぞれのツイッターアカウントを Sugar 内部から認証する時に確認することになる名前です。</li><li>備考を入力します。</li><li>アプリケーション Web サイトの URL を入力します。</li><li>コールバック  URL を入力します（Suger は認証時にこれをバイパスするため任意のものでかまいません。例：Sugar サイト URL など）。</li><li>ツイッターコンシューマーキー（API キー）の利用規約に同意します。</li><li>「使用するツイッターアプリケーションを作成」をクリックします。</li><li>そのアプリケーションページで、「コンシューマーキー」タブの下のコンシューマーキーとコンシューマーシークレットを見つけます。そのキーとシークレットを次に入力します。</li></ol></td></tr></table>',
    'LBL_NAME' => 'ツイッターユーザー名',
    'LBL_ID' => 'ツイッターユーザー名',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'コンシューマキー',
    'oauth_consumer_secret' => 'コンシューマシークレット',
);

?>
