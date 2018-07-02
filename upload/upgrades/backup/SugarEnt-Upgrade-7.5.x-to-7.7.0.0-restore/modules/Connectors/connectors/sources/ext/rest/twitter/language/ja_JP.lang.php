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
	

$connector_strings = array (
  'company_url' => 'URL',
  'oauth_consumer_key' => 'コンシューマキー',
  'oauth_consumer_secret' => 'コンシューマシークレット',
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Twitter&#169でSugarインスタンスを新規アプリケーションとして登録することで、コンシューマキーとコンシューマシークレットを取得してください。<br/><br>登録方法は以下の通りです<br/><br/><ol><li>Twitter&#169;ディベロッパーサイト（<a href="http://dev.twitter.com/apps/new" target="_blank">http://dev.twitter.com/apps/new</a>）にアクセスします。</li><li>アプリケーションを登録するツイッターアカウントでサインインします。</li><li>登録フォームにアプリケーション名を入力します。これは、Sugar内部からツイッターを認証する際にユーザが識別する名前になります。</li><li>備考を入力します。</li><li>アプリケーションのURLを入力します。</li><li>アプリケーションタイプとして「ブラウザ」を選択します。</li><li>コールバックURLを入力します（Sugarは認証の際にここをバイパスするので、何でも構いません。例: SugarのルートURL）。</li><li>セキュリティワードを入力します。</li><li>「アプリケーションの登録」をクリックします。</li><li>ツイッターAPIの利用規約に同意します。</li><li>アプリケーションページでコンシューマキーとコンシューマシークレットを確認し、以下に入力します。</li></ol></td></tr></table>',
  'LBL_NAME' => 'ツイッターユーザ名',
  'LBL_ID' => 'ツイッターユーザ名',
);

