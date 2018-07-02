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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Sugar 인스턴스를 새 어플리케이션으로 등록하여 Twitter 에서 Key 및 Secret를 얻으십시오.<br/><br>인스턴스 등록 단계는 다음과 같습니다:<br/><br/><ol><li>Twitter 개발자 사이트인 <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>로 이동합니다.</li><li>등록할 어플리케이션의 Twitter계정을 사용하여 로그인합니다.</li><li>등록 양식에 어플리케이션 이름을 입력합니다. 이 이름은 사용자가 Sugar 내 Twitter계정 인증시 사용하는 이름입니다. </li><li>설명을 입력합니다.</li><li>어플리케이션 웹사이트 URL을 입력합니다. </li><li>콜백 URL(Sugar에서 인증시 이를 무시하므로 아무 거나 입력해도 됩니다. 예: 귀하의 Sugar 사이트 URL)을 입력합니다.</li><li>Twitter API 약관에 동의합니다.</li><li>"귀하의 Twitter어플리케이션 만들기"을 클릭합니다.</li><li>어플리케이션 페이지의 "API 키" 탭에서 API Key 및 API Secret을 찾습니다. Key 및 Secret을 아래에 입력합니다. </li></ol></td></tr></table>',
    'LBL_NAME' => 'Twitter 사용자 이름',
    'LBL_ID' => 'Twitter 사용자 이름',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'API 키',
    'oauth_consumer_secret' => 'API 비밀',
);

?>
