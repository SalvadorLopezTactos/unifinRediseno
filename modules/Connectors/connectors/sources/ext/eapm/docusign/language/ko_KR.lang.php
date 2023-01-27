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
    'LBL_LICENSING_INFO' => 'DocuSign 커넥터 사용 단계:
        <br> - 통합 키 생성
        <br> - DocuSign Connect for Envelopes 활성화
        (예: Sugar 엔트리포인트 구독을 위해 DocuSign에서 사용하는 웹훅)
        <br> - DocuSign에서 새 애플리케이션을 설정하고 리디렉션 URI를 삽입하고 비밀 키를 생성합니다.
        리디렉션 URI는 https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect 이어야 합니다.
        <br> Sugar 인스턴스에 IP 제한이 있으면 DocuSign의 IP 주소를 화이트리스트에 추가합니다.',
    'environment' => '환경',
    'integration_key' => '통합 키',
    'client_secret' => '클라이언트 시크릿',
];
