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

$connector_strings = [
    'LBL_LICENSING_INFO' => 'DocuSignコネクタの使用手順:
        <br> - 統合キーを生成します
        <br> - エンベロープのDocuSign接続を有効にします
        (すなわち、DocuSignがSugarのエントリポイントを購読するために使用するWebhook)
        <br> - DocuSignで新しいアプリケーションを設定し、リダイレクトURIを挿入して秘密鍵を生成します。
        リダイレクトURIはhttps://SUGAR_URL/oauth-handler/DocuSignOauth2Redirectである必要があります
        <br> SugarインスタンスにIP制限がある場合、DocuSignのIPアドレスをホワイトリストに登録します',
    'environment' => '環境',
    'integration_key' => 'インテグレーションキー',
    'client_secret' => 'クライアントシークレット',
];
