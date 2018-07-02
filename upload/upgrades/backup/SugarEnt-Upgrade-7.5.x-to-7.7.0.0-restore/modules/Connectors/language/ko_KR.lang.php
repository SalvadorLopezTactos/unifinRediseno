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
  'ERROR_EMPTY_RECORD_ID' => '오류:기록 ID가 명시되지 않았거나 비어있습니다.',
  'ERROR_EMPTY_SOURCE_ID' => '오류:출추ID가 명시되지 않았거나 비어있습니다.',
  'ERROR_EMPTY_WRAPPER' => '오류:출처로부터 예시 덮개를 복구할수 없습니다.',
  'ERROR_NO_ADDITIONAL_DETAIL' => '오류:기록을위한 추가 세부세항이 발견되지 않았습니다.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => '오류:이 모듈에 배치된 연결기가 없습니다.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => '오류:결과에 전시할 배치할 모듈 필드가 없습니다. 시스템 관리자에 문의하십시오.',
  'ERROR_NO_FIELDS_MAPPED' => '오류:최소 하나의 연결기 필드를 배치해야합니다.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => '이 연결기를 위해 작동하는 모듈이 없습니다. 연결기 작동 페이지의 연결기의 모듈을 선택하십시오,',
  'ERROR_NO_SEARCHDEFS_MAPPED' => '오류:정의된 검색필드의 작동되는 연결기가 없습니다.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => '오류:모듈과 연결기를 위해 정의된 검색 필드가 없습니다.',
  'ERROR_NO_SOURCEDEFS_FILE' => '오류:sourcedefs.php 파일이 발견되지 않았습니다.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => '오루:어느 복구 데이타에서 명시된 출처가 없습니다.',
  'ERROR_RECORD_NOT_SELECTED' => '오류:진행하기전 목록에서 기록을 선택하십시오,',
  'LBL_ADDRCITY' => '시:',
  'LBL_ADDRCOUNTRY' => '국가:',
  'LBL_ADDRCOUNTRY_ID' => '국가ID',
  'LBL_ADDRSTATEPROV' => '도:',
  'LBL_ADD_MODULE' => '추가하기',
  'LBL_ADMINISTRATION' => '관리자 연결기',
  'LBL_ADMINISTRATION_MAIN' => '설정 연결기',
  'LBL_AVAILABLE' => '사용가능',
  'LBL_BACK' => '뒤로',
  'LBL_CLOSE' => '닫기',
  'LBL_COMPANY_ID' => '회사ID',
  'LBL_CONFIRM_CONTINUE_SAVE' => '몇몇의 필수 입력필드가 비어있습니다. 변경사항을 저장하십겠습니까?',
  'LBL_CONNECTOR' => '연결기',
  'LBL_CONNECTOR_FIELDS' => '필드 연결',
  'LBL_DATA' => '데이타',
  'LBL_DEFAULT' => '초기 설정',
  'LBL_DELETE_MAPPING_ENTRY' => '이 항목을 삭제하시겠습니까?',
  'LBL_DISABLED' => '중지',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => '검색기준에 일치하는 결과가 없습니다.',
  'LBL_ENABLED' => '작동',
  'LBL_EXTERNAL' => '외부 계정기록을 이 연결기에 새로 만들기위한 사용자 목록 작동하기',
  'LBL_EXTERNAL_SET_PROPERTIES' => '이 연결기를 사용하려면 연결기소유권 설정 페이지에서 소유권이 따로 설정 되어야합니다.',
  'LBL_FINSALES' => 'Finsales',
  'LBL_INFO_INLINE' => '정보',
  'LBL_MARKET_CAP' => '시장 상한',
  'LBL_MERGE' => '병합하기',
  'LBL_MODIFY_DISPLAY_DESC' => '각각의 연결기를 위한 작동 모듈을 선택하십시오',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => '연결기 설정: 연결기 작동',
  'LBL_MODIFY_DISPLAY_TITLE' => '연결기 작동',
  'LBL_MODIFY_MAPPING_DESC' => '어떠한 연결 데이타가 보여지고 모듈기록으로 통합될지 결정하기위한 모듈필드의 연결 필드를 배치합니다.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => '연결기 설정:연결 필드 배치',
  'LBL_MODIFY_MAPPING_TITLE' => '지도 연결 필드',
  'LBL_MODIFY_PROPERTIES_DESC' => 'URLs 과 API키를 포함한 각각의 연결기의 소유권 만들기',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => '연결기 설정: 연결기 소유권 설정',
  'LBL_MODIFY_PROPERTIES_TITLE' => '연결기 소유권 설정',
  'LBL_MODIFY_SEARCH' => '검색',
  'LBL_MODIFY_SEARCH_DESC' => '각 모듈의 데이타 검색에 사용할 연결기 필드를 선택합니다.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => '연결기 설정:연결기 검색 관리',
  'LBL_MODIFY_SEARCH_TITLE' => '연결기 검색 관리',
  'LBL_MODULE_FIELDS' => '모듈 필드',
  'LBL_MODULE_NAME' => '연결기',
  'LBL_MODULE_NAME_SINGULAR' => '연결기',
  'LBL_NO_PROPERTIES' => '이 연결기에는 구성가능한 소유권이 없습니다.',
  'LBL_PARENT_DUNS' => '상위 DUNS',
  'LBL_PREVIOUS' => '뒤로',
  'LBL_QUOTE' => '견적',
  'LBL_RECNAME' => '회사명:',
  'LBL_RESET_BUTTON_TITLE' => '재설정',
  'LBL_RESET_TO_DEFAULT' => '초기설정으로 재설정',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => '초기설정 구성을 재설정 하시겠습니까?',
  'LBL_RESULT_LIST' => '데이타 목록',
  'LBL_RUN_WIZARD' => '마법사 실행',
  'LBL_SAVE' => '저장하기',
  'LBL_SEARCHING_BUTTON_LABEL' => '검색중입니다...',
  'LBL_SHOW_IN_LISTVIEW' => '통합 목록보기에 보여주기',
  'LBL_SMART_COPY' => 'Smart Copy',
  'LBL_STEP1' => '검색 및 데이타 보기',
  'LBL_STEP2' => '기록 통합',
  'LBL_SUMMARY' => '개요',
  'LBL_TEST_SOURCE' => '연결기 테스트',
  'LBL_TEST_SOURCE_FAILED' => '테스트 실패',
  'LBL_TEST_SOURCE_RUNNING' => '테스트 실행중입니다.',
  'LBL_TEST_SOURCE_SUCCESS' => '테스트가 성공하였습니다.',
  'LBL_TITLE' => '데이타 통합',
  'LBL_ULTIMATE_PARENT_DUNS' => '최고 상위 DUNS',
  'dnb_countries_iso' => 
  array (
    'AD' => '안도라',
    'AE' => '연합군의 유럽',
    'AF' => '아프가니스탄',
    'AG' => '앤티가 바부 다',
    'AI' => '앵 귈라',
    'AL' => '알바니아',
    'AM' => '아르메니아',
    'AN' => '네덜란드 령 앤 틸리 스',
    'AO' => '앙골라',
    'AQ' => '남극 대륙',
    'AR' => '아르헨티나',
    'AS' => '아메리칸 사모아',
    'AT' => '오스트리아',
    'AU' => '호주',
    'AW' => '아루바',
    'AZ' => '아제르바이잔',
    'BA' => '보스니아 헤르체고비나',
    'BB' => '바베이도스',
    'BD' => '방글라데시',
    'BE' => '벨기에',
    'BF' => '부르 키나 파소',
    'BG' => '불가리아',
    'BH' => '바레인',
    'BI' => '부룬디',
    'BJ' => '베냉',
    'BM' => '버뮤다',
    'BN' => '브루나이',
    'BO' => '볼리비아',
    'BR' => '브라질',
    'BS' => '바하마',
    'BT' => '부탄',
    'BV' => '부베 섬',
    'BW' => '보츠와나',
    'BY' => '벨라루스',
    'BZ' => '벨리즈',
    'CA' => '캐나다',
    'CC' => '코코스 섬',
    'CD' => '콩고 민주 공화국',
    'CF' => '중앙 아프리카 공화국',
    'CG' => '콩고',
    'CH' => 'Confederazione 헬 베티 카 (스위스)',
    'CI' => '코트 디부 아르 (아이보리 코스트)',
    'CK' => '쿡 제도',
    'CL' => '칠레',
    'CM' => '카메룬',
    'CN' => '중국',
    'CO' => '콜롬비아',
    'CR' => '코스타리카',
    'CU' => '쿠바',
    'CV' => '카보 베르데',
    'CX' => '크리스마스 섬',
    'CY' => '키프로스',
    'CZ' => '체코 공화국',
    'DE' => '독일',
    'DJ' => '지부티',
    'DK' => '덴마크',
    'DM' => '도미니카',
    'DO' => '도미니카 공화국',
    'DZ' => '알제리',
    'EC' => '에콰도르',
    'EE' => '에스토니아',
    'EG' => '이집트',
    'EH' => '서부 사하라',
    'ER' => '에리트레아',
    'ES' => '에스파냐 (스페인)',
    'ET' => '에티오피아',
    'FI' => '핀란드',
    'FJ' => '피지',
    'FK' => '포클랜드 제도',
    'FM' => '마이크로 네시아',
    'FO' => '페로 제도',
    'FR' => '프랑스',
    'FX' => '프랑스 수도권',
    'GA' => '가봉',
    'GB' => '영국',
    'GD' => '그레나다',
    'GE' => '조지아',
    'GF' => '프랑스 령 기아나',
    'GH' => '가나',
    'GI' => '지브롤터',
    'GL' => '그린란드',
    'GM' => '감비아',
    'GN' => '기니',
    'GP' => '과들루프',
    'GQ' => '적도 기니',
    'GR' => '그리스',
    'GS' => '사우스 조지아 및 사우스 샌드위치 군도',
    'GT' => '과테말라',
    'GU' => '괌',
    'GW' => '기니 비사우',
    'GY' => '가이아나',
    'HK' => '홍콩',
    'HM' => '소리 엠씨 도날드 섬',
    'HN' => '온두라스',
    'HR' => '크로아티아',
    'HT' => '아이티',
    'HU' => '헝가리',
    'ID' => '인도네시아',
    'IE' => '아일랜드',
    'IL' => '이스라엘',
    'IN' => '인도',
    'IO' => '영국령 인도양 지역',
    'IQ' => '이라크',
    'IR' => '이란',
    'IS' => '아이슬란드',
    'IT' => '이탈리아',
    'JM' => '자메이카',
    'JO' => '요르단',
    'JP' => '일본',
    'KE' => '케냐',
    'KG' => '키르기스스탄',
    'KH' => '캄보디아',
    'KI' => '키리바시',
    'KM' => '코모로',
    'KN' => '세인트 키츠 네비스',
    'KP' => '북한',
    'KR' => '대한민국',
    'KW' => '쿠웨이트',
    'KY' => '케이맨 제도',
    'KZ' => '카자흐스탄',
    'LA' => '라오스',
    'LB' => '레바논',
    'LC' => '세인트 루시아',
    'LI' => '리히텐슈타인',
    'LK' => '스리랑카',
    'LR' => '라이베리아',
    'LS' => '레소토',
    'LT' => '리투아니아',
    'LU' => '룩셈부르크',
    'LV' => '라트비아',
    'LY' => '리비아',
    'MA' => '아프리카 북서부의 회교 왕국',
    'MC' => '모나코',
    'MD' => '몰르 더바',
    'ME' => '몬테네그로',
    'MG' => '마다가스카르',
    'MH' => '마샬 군도',
    'MK' => '마케도니아 구 유고 슬라비아 공화',
    'ML' => '말리',
    'MM' => '미얀마',
    'MN' => '몽골리아',
    'MO' => '마카오',
    'MP' => '북 마리아나 제도',
    'MQ' => '마르티니크',
    'MR' => '모리타니',
    'MS' => '몬트 세 라트',
    'MT' => '몰타',
    'MU' => '모리셔스',
    'MV' => '몰디브',
    'MW' => '말라위',
    'MX' => '멕시코',
    'MY' => '말레이시아',
    'MZ' => '모잠비크',
    'NA' => '나미비아',
    'NC' => '뉴 칼레도니아',
    'NE' => '니제르',
    'NF' => '노퍽 섬',
    'NG' => '나이지리아',
    'NI' => '니카라과',
    'NL' => '네덜란드',
    'NO' => '노르웨이',
    'NP' => '네팔',
    'NR' => '나우루어',
    'NU' => '니우에',
    'NZ' => '뉴질랜드',
    'OM' => '오만',
    'PA' => '파나마',
    'PE' => '페루',
    'PF' => '프랑스 령 폴리네시아',
    'PG' => '파푸아 뉴기니',
    'PH' => '필리핀',
    'PK' => '파키스탄',
    'PL' => '폴란드',
    'PM' => '생 피에르 미 클롱',
    'PN' => '핏 케언 제도',
    'PR' => '푸에르 토리코',
    'PS' => '팔레스타인',
    'PT' => '포르투갈',
    'PW' => '팔라우',
    'PY' => '파라과이',
    'QA' => '카타르',
    'RE' => '레위니옹 섬',
    'RO' => '루마니아',
    'RS' => '스 르프 스카 공화국',
    'RU' => '러시아 연방',
    'RW' => '르완다',
    'SA' => '사우디 아라비아',
    'SB' => '솔로몬 제도',
    'SC' => '세이셸',
    'SD' => '의 수단에',
    'SE' => '스웨덴',
    'SG' => '싱가포르',
    'SH' => '세인트 헬레나',
    'SI' => '샌드위치 제도',
    'SJ' => '스발 바르 얀 마옌 제도',
    'SK' => '샌드위치 제도',
    'SL' => '시에라 리온',
    'SM' => '산 마리노',
    'SN' => '세네갈',
    'SO' => '소말리아',
    'SR' => '슬로바키아',
    'ST' => '세인트 메 프린시 페',
    'SV' => '엘살바도르',
    'SY' => '시리아',
    'SZ' => '스위스',
    'TC' => '터크 스 케이 커스 제도',
    'TD' => '차드',
    'TF' => '프랑스 남부 지방',
    'TG' => '토고',
    'TH' => '태국',
    'TJ' => '타지키스탄',
    'TK' => '토켈 라우',
    'TM' => '투르크 메니스탄',
    'TN' => '타이어 국가',
    'TO' => '통가',
    'TP' => '동 티모르',
    'TR' => '터키',
    'TT' => '트리니다드 토바고',
    'TV' => '투발루',
    'TW' => '대만',
    'TZ' => '탄자니아',
    'UA' => '우크라이나',
    'UG' => '우간다',
    'UM' => '미국의 군도',
    'US' => '미국',
    'UY' => '우루과이',
    'UZ' => '우즈베키스탄',
    'VA' => '교황청 (바티칸 시국)',
    'VC' => '세인트 빈센트 그레나딘',
    'VE' => '베네수엘라',
    'VG' => '영국령 버진 아일랜드',
    'VI' => '베트남',
    'VN' => '베트남',
    'VU' => '바누아투',
    'WF' => '월리스 푸 투나',
    'WS' => '사모아',
    'YE' => '예멘',
    'YT' => '마 요트',
    'ZA' => '위트 Afrika의 (남아프리카 공화국)',
    'ZM' => '잠비아',
    'ZW' => '짐바브웨',
  ),
  'dnb_states_iso' => 
  array (
    'AD' => 
    array (
      1 => 
      array (
        'code' => 'ALV',
        'name' => '안도라 라 베야',
      ),
      2 => 
      array (
        'code' => 'CAN',
        'name' => '카닐',
      ),
      3 => 
      array (
        'code' => 'ENC',
        'name' => '진을',
      ),
      4 => 
      array (
        'code' => 'ESE',
        'name' => '에스 칼 데스 - 엥 고르다 뉴',
      ),
      5 => 
      array (
        'code' => 'LMA',
        'name' => '라마',
      ),
      6 => 
      array (
        'code' => 'ORD',
        'name' => '오르 디노',
      ),
      7 => 
      array (
        'code' => 'SJL',
        'name' => '산트 줄리아 드 로리아',
      ),
    ),
    'AE' => 
    array (
      1 => 
      array (
        'code' => 'AZ',
        'name' => '아부 자비스',
      ),
      2 => 
      array (
        'code' => 'AJ',
        'name' => '아지',
      ),
      3 => 
      array (
        'code' => 'FU',
        'name' => '알 푸자이라',
      ),
      4 => 
      array (
        'code' => 'SH',
        'name' => '애쉬 Shariqah',
      ),
      5 => 
      array (
        'code' => 'DU',
        'name' => 'Dubayy',
      ),
      6 => 
      array (
        'code' => 'RK',
        'name' => 'R as 알 Khaymah',
      ),
      7 => 
      array (
        'code' => 'UQ',
        'name' => '움 알 Qaywayn',
      ),
    ),
    'AF' => 
    array (
      1 => 
      array (
        'code' => 'BAL',
        'name' => '발흐',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => '바 미안',
      ),
      3 => 
      array (
        'code' => 'BDG',
        'name' => '바드 기스',
      ),
      4 => 
      array (
        'code' => 'BDS',
        'name' => 'Badakhshan',
      ),
      5 => 
      array (
        'code' => 'BGL',
        'name' => 'Baghlan',
      ),
      6 => 
      array (
        'code' => 'FRA',
        'name' => '파라',
      ),
      7 => 
      array (
        'code' => 'FYB',
        'name' => 'Faryab',
      ),
      8 => 
      array (
        'code' => 'GHA',
        'name' => '가즈니',
      ),
      9 => 
      array (
        'code' => 'GHO',
        'name' => 'Ghowr',
      ),
      10 => 
      array (
        'code' => 'HEL',
        'name' => '헬 맨드',
      ),
      11 => 
      array (
        'code' => 'HER',
        'name' => '헤라트',
      ),
      12 => 
      array (
        'code' => 'JOW',
        'name' => 'Jowzjan',
      ),
      13 => 
      array (
        'code' => 'KAB',
        'name' => '카불',
      ),
      14 => 
      array (
        'code' => 'KAN',
        'name' => '칸다하르',
      ),
      15 => 
      array (
        'code' => 'KAP',
        'name' => '카피',
      ),
      16 => 
      array (
        'code' => 'KDZ',
        'name' => 'Kondoz',
      ),
      17 => 
      array (
        'code' => 'KHO',
        'name' => '인 코스트',
      ),
      18 => 
      array (
        'code' => 'KNR',
        'name' => 'Konar',
      ),
      19 => 
      array (
        'code' => 'LAG',
        'name' => 'Laghman',
      ),
      20 => 
      array (
        'code' => 'LOW',
        'name' => 'Lowgar',
      ),
      21 => 
      array (
        'code' => 'NAN',
        'name' => 'Nangrahar',
      ),
      22 => 
      array (
        'code' => 'NIM',
        'name' => '님 루즈',
      ),
      23 => 
      array (
        'code' => 'NUR',
        'name' => 'Nurestan',
      ),
      24 => 
      array (
        'code' => 'ORU',
        'name' => 'Oruzgan',
      ),
      25 => 
      array (
        'code' => 'PAR',
        'name' => '파르 완',
      ),
      26 => 
      array (
        'code' => 'PIA',
        'name' => 'Paktia',
      ),
      27 => 
      array (
        'code' => 'PKA',
        'name' => 'Paktika',
      ),
      28 => 
      array (
        'code' => 'SAM',
        'name' => 'Samangan',
      ),
      29 => 
      array (
        'code' => 'SAR',
        'name' => 'SAR-E 폴',
      ),
      30 => 
      array (
        'code' => 'TAK',
        'name' => '타 하르',
      ),
      31 => 
      array (
        'code' => 'WAR',
        'name' => '와르 다크',
      ),
      32 => 
      array (
        'code' => 'ZAB',
        'name' => '자볼',
      ),
    ),
    'AI' => 
    array (
      1 => 
      array (
        'code' => 'ANG',
        'name' => 'Anguillita',
      ),
      2 => 
      array (
        'code' => 'ANG',
        'name' => '앙 귈라',
      ),
      3 => 
      array (
        'code' => 'DOG',
        'name' => '개',
      ),
      4 => 
      array (
        'code' => 'LIT',
        'name' => '작은 스크럽',
      ),
      5 => 
      array (
        'code' => 'PRI',
        'name' => '의욕적 인 배',
      ),
      6 => 
      array (
        'code' => 'SAN',
        'name' => '샌디',
      ),
      7 => 
      array (
        'code' => 'SCR',
        'name' => '스크럽',
      ),
      8 => 
      array (
        'code' => 'SEA',
        'name' => '인감',
      ),
      9 => 
      array (
        'code' => 'SOM',
        'name' => '챙 넓은 모자',
      ),
    ),
    'AL' => 
    array (
      1 => 
      array (
        'code' => 'BR',
        'name' => '베라',
      ),
      2 => 
      array (
        'code' => 'BU',
        'name' => 'Bulqize',
      ),
      3 => 
      array (
        'code' => 'DI',
        'name' => 'Diber',
      ),
      4 => 
      array (
        'code' => 'DL',
        'name' => 'Delvine',
      ),
      5 => 
      array (
        'code' => 'DR',
        'name' => '러스',
      ),
      6 => 
      array (
        'code' => 'DV',
        'name' => 'Devoll',
      ),
      7 => 
      array (
        'code' => 'EL',
        'name' => '엘바',
      ),
      8 => 
      array (
        'code' => 'ER',
        'name' => 'Kolonje',
      ),
      9 => 
      array (
        'code' => 'FR',
        'name' => '경우 앰프',
      ),
      10 => 
      array (
        'code' => 'GJ',
        'name' => 'Gjirokaster의',
      ),
      11 => 
      array (
        'code' => 'GR',
        'name' => 'Gramsh',
      ),
      12 => 
      array (
        'code' => 'HA',
        'name' => '가',
      ),
      13 => 
      array (
        'code' => 'KA',
        'name' => 'Kavaje',
      ),
      14 => 
      array (
        'code' => 'KB',
        'name' => 'Kurbin',
      ),
      15 => 
      array (
        'code' => 'KC',
        'name' => 'Kucove',
      ),
      16 => 
      array (
        'code' => 'KO',
        'name' => 'Korce에',
      ),
      17 => 
      array (
        'code' => 'KR',
        'name' => 'Kruje에서',
      ),
      18 => 
      array (
        'code' => 'KU',
        'name' => 'Kukes',
      ),
      19 => 
      array (
        'code' => 'LB',
        'name' => 'Librazhd',
      ),
      20 => 
      array (
        'code' => 'LE',
        'name' => 'Lezhe',
      ),
      21 => 
      array (
        'code' => 'LU',
        'name' => 'Lushnje',
      ),
      22 => 
      array (
        'code' => 'MK',
        'name' => 'Mallakaster',
      ),
      23 => 
      array (
        'code' => 'MM',
        'name' => 'Malesi 전자 Madhe',
      ),
      24 => 
      array (
        'code' => 'MR',
        'name' => 'Mirdite',
      ),
      25 => 
      array (
        'code' => 'MT',
        'name' => '매트',
      ),
      26 => 
      array (
        'code' => 'PG',
        'name' => 'Pogradec',
      ),
      27 => 
      array (
        'code' => 'PQ',
        'name' => 'Peqin',
      ),
      28 => 
      array (
        'code' => 'PR',
        'name' => 'Permet',
      ),
      29 => 
      array (
        'code' => 'PU',
        'name' => '푸케',
      ),
      30 => 
      array (
        'code' => 'SH',
        'name' => 'Shkoder에',
      ),
      31 => 
      array (
        'code' => 'SK',
        'name' => 'Skrapar',
      ),
      32 => 
      array (
        'code' => 'SR',
        'name' => '란다',
      ),
      33 => 
      array (
        'code' => 'TE',
        'name' => 'Tepelene',
      ),
      34 => 
      array (
        'code' => 'TP',
        'name' => 'Tropoje',
      ),
      35 => 
      array (
        'code' => 'TR',
        'name' => '티라나',
      ),
      36 => 
      array (
        'code' => 'VL',
        'name' => 'Vlore의',
      ),
    ),
    'AM' => 
    array (
      1 => 
      array (
        'code' => 'AGT',
        'name' => 'Aragatsotn',
      ),
      2 => 
      array (
        'code' => 'ARR',
        'name' => '아라 라트',
      ),
      3 => 
      array (
        'code' => 'ARM',
        'name' => '아르마 비르',
      ),
      4 => 
      array (
        'code' => 'GEG',
        'name' => 'Geghark UNIK',
      ),
      5 => 
      array (
        'code' => 'KOT',
        'name' => 'Kotayk',
      ),
      6 => 
      array (
        'code' => 'LOR',
        'name' => 'Lorri',
      ),
      7 => 
      array (
        'code' => 'SHI',
        'name' => 'Shirak',
      ),
      8 => 
      array (
        'code' => 'SYU',
        'name' => 'Syunik',
      ),
      9 => 
      array (
        'code' => 'TAV',
        'name' => 'Tavush',
      ),
      10 => 
      array (
        'code' => 'VAY',
        'name' => 'Vayots Dzor',
      ),
      11 => 
      array (
        'code' => 'YER',
        'name' => '예 레반',
      ),
    ),
    'AN' => 
    array (
      1 => 
      array (
        'code' => 'BON',
        'name' => '보네르',
      ),
      2 => 
      array (
        'code' => 'CUR',
        'name' => '큐라',
      ),
      3 => 
      array (
        'code' => 'SAB',
        'name' => '사바',
      ),
      4 => 
      array (
        'code' => 'SEU',
        'name' => '신트 유스 타티 우스',
      ),
      5 => 
      array (
        'code' => 'SMA',
        'name' => '신트 마르텐',
      ),
    ),
    'AO' => 
    array (
      1 => 
      array (
        'code' => 'BGO',
        'name' => 'Bengo',
      ),
      2 => 
      array (
        'code' => 'BGU',
        'name' => '벵 겔라',
      ),
      3 => 
      array (
        'code' => 'BIE',
        'name' => 'BIE',
      ),
      4 => 
      array (
        'code' => 'CAB',
        'name' => '카 빈다',
      ),
      5 => 
      array (
        'code' => 'CCU',
        'name' => '만인-방고',
      ),
      6 => 
      array (
        'code' => 'CNO',
        'name' => '쿠 안자 노르 테',
      ),
      7 => 
      array (
        'code' => 'CUS',
        'name' => '쿠 안자 술',
      ),
      8 => 
      array (
        'code' => 'CNN',
        'name' => '쿠 네네',
      ),
      9 => 
      array (
        'code' => 'HUA',
        'name' => '암보',
      ),
      10 => 
      array (
        'code' => 'HUI',
        'name' => '일라',
      ),
      11 => 
      array (
        'code' => 'LUA',
        'name' => '루안다',
      ),
      12 => 
      array (
        'code' => 'LNO',
        'name' => '룬다 노르 테',
      ),
      13 => 
      array (
        'code' => 'LSU',
        'name' => '룬다 술',
      ),
      14 => 
      array (
        'code' => 'MAL',
        'name' => '말랑',
      ),
      15 => 
      array (
        'code' => 'MOX',
        'name' => '모시',
      ),
      16 => 
      array (
        'code' => 'NAM',
        'name' => '나미 브',
      ),
      17 => 
      array (
        'code' => 'UIG',
        'name' => '우이게',
      ),
      18 => 
      array (
        'code' => 'ZAI',
        'name' => '자이르',
      ),
    ),
    'AQ' => 
    array (
      1 => 
      array (
        'code' => 'ASG',
        'name' => '세인트 조지',
      ),
      2 => 
      array (
        'code' => 'ASH',
        'name' => '세인트 필립',
      ),
      3 => 
      array (
        'code' => 'ASJ',
        'name' => '세인트 존',
      ),
      4 => 
      array (
        'code' => 'ASL',
        'name' => '세인트 폴',
      ),
      5 => 
      array (
        'code' => 'ASM',
        'name' => '세인트 메리',
      ),
      6 => 
      array (
        'code' => 'ASR',
        'name' => '세인트 피터',
      ),
      7 => 
      array (
        'code' => 'BAR',
        'name' => '바부 다',
      ),
      8 => 
      array (
        'code' => 'RED',
        'name' => '레 돈다',
      ),
    ),
    'AR' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Antartida 전자 비나 델 아틀란 티코',
      ),
      2 => 
      array (
        'code' => 'BA',
        'name' => '부에노스 아이레스',
      ),
      3 => 
      array (
        'code' => 'CA',
        'name' => '카타 마르카',
      ),
      4 => 
      array (
        'code' => 'CH',
        'name' => '차코',
      ),
      5 => 
      array (
        'code' => 'CU',
        'name' => '추 부트',
      ),
      6 => 
      array (
        'code' => 'CO',
        'name' => '코르도바',
      ),
      7 => 
      array (
        'code' => 'CR',
        'name' => '코리 엔 테스',
      ),
      8 => 
      array (
        'code' => 'CF',
        'name' => '자본 연방',
      ),
      9 => 
      array (
        'code' => 'ER',
        'name' => '엔트 레 리오스',
      ),
      10 => 
      array (
        'code' => 'FO',
        'name' => '포모사',
      ),
      11 => 
      array (
        'code' => 'JU',
        'name' => '후후',
      ),
      12 => 
      array (
        'code' => 'LP',
        'name' => '라 팜파',
      ),
      13 => 
      array (
        'code' => 'LR',
        'name' => '라 리오하',
      ),
      14 => 
      array (
        'code' => 'ME',
        'name' => '멘도사',
      ),
      15 => 
      array (
        'code' => 'MI',
        'name' => '미시 오 네스',
      ),
      16 => 
      array (
        'code' => 'NE',
        'name' => '우퀜',
      ),
      17 => 
      array (
        'code' => 'RN',
        'name' => '리오 네그로',
      ),
      18 => 
      array (
        'code' => 'SA',
        'name' => '살타',
      ),
      19 => 
      array (
        'code' => 'SJ',
        'name' => '산후 안',
      ),
      20 => 
      array (
        'code' => 'SL',
        'name' => '산 루이스',
      ),
      21 => 
      array (
        'code' => 'SC',
        'name' => '산타 크루즈',
      ),
      22 => 
      array (
        'code' => 'SF',
        'name' => '산타페',
      ),
      23 => 
      array (
        'code' => 'SD',
        'name' => '산티아고 델 에스테로',
      ),
      24 => 
      array (
        'code' => 'TF',
        'name' => '티에라 델 푸 에고',
      ),
      25 => 
      array (
        'code' => 'TU',
        'name' => '투쿠 만',
      ),
    ),
    'AS' => 
    array (
      1 => 
      array (
        'code' => 'E',
        'name' => '동부',
      ),
      2 => 
      array (
        'code' => 'M',
        'name' => 'Manu a',
      ),
      3 => 
      array (
        'code' => 'R',
        'name' => '로즈 아일랜드',
      ),
      4 => 
      array (
        'code' => 'S',
        'name' => '스웨인 아일랜드',
      ),
      5 => 
      array (
        'code' => 'W',
        'name' => '서양',
      ),
    ),
    'AT' => 
    array (
      1 => 
      array (
        'code' => 'BUR',
        'name' => '부르 겐란 트',
      ),
      2 => 
      array (
        'code' => 'KAR',
        'name' => 'Krnten',
      ),
      3 => 
      array (
        'code' => 'NOS',
        'name' => 'Niederöesterreich',
      ),
      4 => 
      array (
        'code' => 'OOS',
        'name' => 'Oberöesterreich',
      ),
      5 => 
      array (
        'code' => 'SAL',
        'name' => '잘츠부르크',
      ),
      6 => 
      array (
        'code' => 'STE',
        'name' => '슈타이어 마르크',
      ),
      7 => 
      array (
        'code' => 'TIR',
        'name' => '티롤',
      ),
      8 => 
      array (
        'code' => 'VOR',
        'name' => '포어 아를 베르크',
      ),
      9 => 
      array (
        'code' => 'WIE',
        'name' => '빈',
      ),
    ),
    'AU' => 
    array (
      1 => 
      array (
        'code' => 'ACT',
        'name' => '오스트레일리아 수도 준주',
      ),
      2 => 
      array (
        'code' => 'NSW',
        'name' => '뉴 사우스 웨일즈',
      ),
      3 => 
      array (
        'code' => 'NT',
        'name' => '노던 테리토리',
      ),
      4 => 
      array (
        'code' => 'QLD',
        'name' => '퀸즐랜드',
      ),
      5 => 
      array (
        'code' => 'SA',
        'name' => '사우스 오스트레일리아',
      ),
      6 => 
      array (
        'code' => 'TAS',
        'name' => '태즈 메이 니아',
      ),
      7 => 
      array (
        'code' => 'VIC',
        'name' => '빅토리아',
      ),
      8 => 
      array (
        'code' => 'WA',
        'name' => '웨스턴 오스트레일리아',
      ),
    ),
    'AW' => 
    array (
      1 => 
      array (
        'code' => 'ARU',
        'name' => '아루바',
      ),
      2 => 
      array (
        'code' => 'DRU',
        'name' => '드루 이프 비치',
      ),
      3 => 
      array (
        'code' => 'MAN',
        'name' => '체보 비치',
      ),
      4 => 
      array (
        'code' => 'NOO',
        'name' => '노 르트',
      ),
      5 => 
      array (
        'code' => 'ORA',
        'name' => '오란',
      ),
      6 => 
      array (
        'code' => 'PAL',
        'name' => '팜 비치',
      ),
      7 => 
      array (
        'code' => 'ROO',
        'name' => 'Rooi 토마스',
      ),
      8 => 
      array (
        'code' => 'SIN',
        'name' => '신트 니콜라스',
      ),
      9 => 
      array (
        'code' => 'SIN',
        'name' => '신트 니콜라스',
      ),
      10 => 
      array (
        'code' => 'WAY',
        'name' => 'Wayaca',
      ),
    ),
    'AZ' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => '알리 Bayramli',
      ),
      2 => 
      array (
        'code' => 'ABS',
        'name' => 'Abseron',
      ),
      3 => 
      array (
        'code' => 'AGC',
        'name' => 'AgcabAdi',
      ),
      4 => 
      array (
        'code' => 'AGM',
        'name' => 'Agdam',
      ),
      5 => 
      array (
        'code' => 'AGS',
        'name' => 'Agdas',
      ),
      6 => 
      array (
        'code' => 'AGA',
        'name' => 'Agstafa',
      ),
      7 => 
      array (
        'code' => 'AGU',
        'name' => 'Agsu',
      ),
      8 => 
      array (
        'code' => 'AST',
        'name' => '아스 타라',
      ),
      9 => 
      array (
        'code' => 'BA',
        'name' => '바키',
      ),
      10 => 
      array (
        'code' => 'BAB',
        'name' => '바박',
      ),
      11 => 
      array (
        'code' => 'BAL',
        'name' => 'BalakAn',
      ),
      12 => 
      array (
        'code' => 'BAR',
        'name' => '바르다',
      ),
      13 => 
      array (
        'code' => 'BEY',
        'name' => 'Beylaqan',
      ),
      14 => 
      array (
        'code' => 'BIL',
        'name' => 'Bilasuvar',
      ),
      15 => 
      array (
        'code' => 'CAB',
        'name' => 'Cabrayil',
      ),
      16 => 
      array (
        'code' => 'CAL',
        'name' => 'Calilabab',
      ),
      17 => 
      array (
        'code' => 'CUL',
        'name' => 'Culfa',
      ),
      18 => 
      array (
        'code' => 'DAS',
        'name' => 'Daskasan',
      ),
      19 => 
      array (
        'code' => 'DAV',
        'name' => 'Davaci',
      ),
      20 => 
      array (
        'code' => 'FUZ',
        'name' => '푸 줄리',
      ),
      21 => 
      array (
        'code' => 'GA',
        'name' => 'Ganca',
      ),
      22 => 
      array (
        'code' => 'GAD',
        'name' => 'Gadabay',
      ),
      23 => 
      array (
        'code' => 'GOR',
        'name' => 'Goranboy',
      ),
      24 => 
      array (
        'code' => 'GOY',
        'name' => 'Goycay',
      ),
      25 => 
      array (
        'code' => 'HAC',
        'name' => 'Haciqabul',
      ),
      26 => 
      array (
        'code' => 'IMI',
        'name' => 'Imisli',
      ),
      27 => 
      array (
        'code' => 'ISM',
        'name' => 'Ismayilli',
      ),
      28 => 
      array (
        'code' => 'KAL',
        'name' => 'Kalbacar',
      ),
      29 => 
      array (
        'code' => 'KUR',
        'name' => 'Kurdamir',
      ),
      30 => 
      array (
        'code' => 'LA',
        'name' => '란 카란',
      ),
      31 => 
      array (
        'code' => 'LAC',
        'name' => 'Lacin',
      ),
      32 => 
      array (
        'code' => 'LAN',
        'name' => '란 카란',
      ),
      33 => 
      array (
        'code' => 'LER',
        'name' => 'Lerik',
      ),
      34 => 
      array (
        'code' => 'MAS',
        'name' => 'Masalli',
      ),
      35 => 
      array (
        'code' => 'MI',
        'name' => 'Mingacevir',
      ),
      36 => 
      array (
        'code' => 'NA',
        'name' => 'Naftalan',
      ),
      37 => 
      array (
        'code' => 'NX',
        'name' => 'Naxcivan',
      ),
      38 => 
      array (
        'code' => 'NEF',
        'name' => 'Neftcala',
      ),
      39 => 
      array (
        'code' => 'OGU',
        'name' => '오구 즈',
      ),
      40 => 
      array (
        'code' => 'ORD',
        'name' => 'Ordubad',
      ),
      41 => 
      array (
        'code' => 'QAB',
        'name' => '카발라',
      ),
      42 => 
      array (
        'code' => 'QAX',
        'name' => 'Qax',
      ),
      43 => 
      array (
        'code' => 'QAZ',
        'name' => 'Qazax',
      ),
      44 => 
      array (
        'code' => 'QOB',
        'name' => 'Qobustan',
      ),
      45 => 
      array (
        'code' => 'QBA',
        'name' => 'Quba',
      ),
      46 => 
      array (
        'code' => 'QBI',
        'name' => 'Qubadli',
      ),
      47 => 
      array (
        'code' => 'QUS',
        'name' => 'Qusar',
      ),
      48 => 
      array (
        'code' => 'SA',
        'name' => '사키',
      ),
      49 => 
      array (
        'code' => 'SAT',
        'name' => 'Saatli',
      ),
      50 => 
      array (
        'code' => 'SAB',
        'name' => 'Sabirabad',
      ),
      51 => 
      array (
        'code' => 'SAD',
        'name' => 'Sadarak',
      ),
      52 => 
      array (
        'code' => 'SAH',
        'name' => 'Sahbuz',
      ),
      53 => 
      array (
        'code' => 'SAK',
        'name' => '사키',
      ),
      54 => 
      array (
        'code' => 'SAL',
        'name' => 'Salyan',
      ),
      55 => 
      array (
        'code' => 'SM',
        'name' => 'Sumqayit',
      ),
      56 => 
      array (
        'code' => 'SMI',
        'name' => 'Samaxi',
      ),
      57 => 
      array (
        'code' => 'SKR',
        'name' => 'Samkir',
      ),
      58 => 
      array (
        'code' => 'SMX',
        'name' => 'Samux',
      ),
      59 => 
      array (
        'code' => 'SAR',
        'name' => 'Sarur',
      ),
      60 => 
      array (
        'code' => 'SIY',
        'name' => 'Siyazan',
      ),
      61 => 
      array (
        'code' => 'SS',
        'name' => '수사',
      ),
      62 => 
      array (
        'code' => 'SUS',
        'name' => '수사',
      ),
      63 => 
      array (
        'code' => 'TAR',
        'name' => '치석',
      ),
      64 => 
      array (
        'code' => 'TOV',
        'name' => 'Tovuz',
      ),
      65 => 
      array (
        'code' => 'UCA',
        'name' => 'UCAR',
      ),
      66 => 
      array (
        'code' => 'XA',
        'name' => 'Xankandi',
      ),
      67 => 
      array (
        'code' => 'XAC',
        'name' => 'Xacmaz',
      ),
      68 => 
      array (
        'code' => 'XAN',
        'name' => 'Xanlar',
      ),
      69 => 
      array (
        'code' => 'XIZ',
        'name' => '시쯔',
      ),
      70 => 
      array (
        'code' => 'XCI',
        'name' => 'Xocali',
      ),
      71 => 
      array (
        'code' => 'XVD',
        'name' => 'Xocavand',
      ),
      72 => 
      array (
        'code' => 'YAR',
        'name' => 'Yardimli',
      ),
      73 => 
      array (
        'code' => 'YEV',
        'name' => 'Yevlax',
      ),
      74 => 
      array (
        'code' => 'ZAN',
        'name' => 'Zangilan',
      ),
      75 => 
      array (
        'code' => 'ZAQ',
        'name' => 'Zaqatala',
      ),
      76 => 
      array (
        'code' => 'ZAR',
        'name' => 'Zardab',
      ),
    ),
    'BA' => 
    array (
      1 => 
      array (
        'code' => 'BRO',
        'name' => 'Brcko 지구',
      ),
      2 => 
      array (
        'code' => 'FBP',
        'name' => 'Bosanskopodrinjski Kanton',
      ),
      3 => 
      array (
        'code' => 'FHN',
        'name' => 'Hercegovacko-neretvanski Kanton',
      ),
      4 => 
      array (
        'code' => 'FPO',
        'name' => 'Posavski Kanton',
      ),
      5 => 
      array (
        'code' => 'FSA',
        'name' => 'Kanton 사라예보',
      ),
      6 => 
      array (
        'code' => 'FSB',
        'name' => 'Srednjebosanski Kanton',
      ),
      7 => 
      array (
        'code' => 'FTU',
        'name' => 'Tuzlanski Kanton',
      ),
      8 => 
      array (
        'code' => 'FUS',
        'name' => 'Unsko-Sanski Kanton',
      ),
      9 => 
      array (
        'code' => 'FZA',
        'name' => 'Zapadnobosanska',
      ),
      10 => 
      array (
        'code' => 'FZE',
        'name' => 'Zenicko-Dobojski Kanton',
      ),
      11 => 
      array (
        'code' => 'FZH',
        'name' => 'Zapadnohercegovacka 스카 주',
      ),
      12 => 
      array (
        'code' => 'SBI',
        'name' => 'Bijeljina에',
      ),
      13 => 
      array (
        'code' => 'SBL',
        'name' => '바냐 루카',
      ),
      14 => 
      array (
        'code' => 'SDO',
        'name' => 'Doboj',
      ),
      15 => 
      array (
        'code' => 'SFO',
        'name' => '포카',
      ),
      16 => 
      array (
        'code' => 'SSR',
        'name' => '사라예보 - Romanija 또는 Sokolac',
      ),
      17 => 
      array (
        'code' => 'STR',
        'name' => '트레비',
      ),
      18 => 
      array (
        'code' => 'SVL',
        'name' => 'Vlasenica',
      ),
    ),
    'BB' => 
    array (
      1 => 
      array (
        'code' => 'CC',
        'name' => '그리스도 교회',
      ),
      2 => 
      array (
        'code' => 'AND',
        'name' => '세인트 앤드류',
      ),
      3 => 
      array (
        'code' => 'GEO',
        'name' => '세인트 조지',
      ),
      4 => 
      array (
        'code' => 'JAM',
        'name' => '세인트 제임스',
      ),
      5 => 
      array (
        'code' => 'JOH',
        'name' => '세인트 존',
      ),
      6 => 
      array (
        'code' => 'JOS',
        'name' => '성 요셉',
      ),
      7 => 
      array (
        'code' => 'LUC',
        'name' => '세인트 루시',
      ),
      8 => 
      array (
        'code' => 'MIC',
        'name' => '세인트 마이클',
      ),
      9 => 
      array (
        'code' => 'PET',
        'name' => '세인트 피터',
      ),
      10 => 
      array (
        'code' => 'PHI',
        'name' => '세인트 필립',
      ),
      11 => 
      array (
        'code' => 'THO',
        'name' => '세인트 토마스',
      ),
    ),
    'BD' => 
    array (
      1 => 
      array (
        'code' => 'BAR',
        'name' => '바리 살',
      ),
      2 => 
      array (
        'code' => 'CHI',
        'name' => '치타 공',
      ),
      3 => 
      array (
        'code' => 'DHA',
        'name' => '다카',
      ),
      4 => 
      array (
        'code' => 'KHU',
        'name' => '쿨나',
      ),
      5 => 
      array (
        'code' => 'RAJ',
        'name' => '라지 샤히',
      ),
      6 => 
      array (
        'code' => 'SYL',
        'name' => '실렛',
      ),
    ),
    'BE' => 
    array (
      1 => 
      array (
        'code' => 'VAN',
        'name' => '안트 베르 펀',
      ),
      2 => 
      array (
        'code' => 'WBR',
        'name' => '플레 미시 브라 반트',
      ),
      3 => 
      array (
        'code' => 'WHT',
        'name' => '플랑드르',
      ),
      4 => 
      array (
        'code' => 'WLG',
        'name' => '리에 주',
      ),
      5 => 
      array (
        'code' => 'VLI',
        'name' => '림 부르크',
      ),
      6 => 
      array (
        'code' => 'WLX',
        'name' => '룩셈부르크',
      ),
      7 => 
      array (
        'code' => 'WNA',
        'name' => '나무 르',
      ),
      8 => 
      array (
        'code' => 'VOV',
        'name' => 'Oost의 플란 데런',
      ),
      9 => 
      array (
        'code' => 'VBR',
        'name' => 'Vlaams 브라 반트',
      ),
      10 => 
      array (
        'code' => 'VWV',
        'name' => '웨스트 - 데런',
      ),
    ),
    'BF' => 
    array (
      1 => 
      array (
        'code' => 'BAL',
        'name' => '베일',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => 'BAM',
      ),
      3 => 
      array (
        'code' => 'BAN',
        'name' => 'Banwa',
      ),
      4 => 
      array (
        'code' => 'BAZ',
        'name' => 'Bazega',
      ),
      5 => 
      array (
        'code' => 'BOR',
        'name' => 'Bougouriba',
      ),
      6 => 
      array (
        'code' => 'BLG',
        'name' => 'Boulgou',
      ),
      7 => 
      array (
        'code' => 'BOK',
        'name' => 'Boulkiemde',
      ),
      8 => 
      array (
        'code' => 'COM',
        'name' => '코모',
      ),
      9 => 
      array (
        'code' => 'GAN',
        'name' => 'Ganzourgou',
      ),
      10 => 
      array (
        'code' => 'GNA',
        'name' => 'Gnagna',
      ),
      11 => 
      array (
        'code' => 'GOU',
        'name' => '구르마',
      ),
      12 => 
      array (
        'code' => 'HOU',
        'name' => 'Houet',
      ),
      13 => 
      array (
        'code' => 'IOA',
        'name' => 'Ioba',
      ),
      14 => 
      array (
        'code' => 'KAD',
        'name' => 'Kadiogo',
      ),
      15 => 
      array (
        'code' => 'KEN',
        'name' => 'Kenedougou',
      ),
      16 => 
      array (
        'code' => 'KOD',
        'name' => 'Komondjari',
      ),
      17 => 
      array (
        'code' => 'KOP',
        'name' => 'Kompienga',
      ),
      18 => 
      array (
        'code' => 'KOS',
        'name' => 'Kossi',
      ),
      19 => 
      array (
        'code' => 'KOL',
        'name' => 'Koulpelogo',
      ),
      20 => 
      array (
        'code' => 'KOT',
        'name' => 'Kouritenga',
      ),
      21 => 
      array (
        'code' => 'KOW',
        'name' => 'Kourweogo',
      ),
      22 => 
      array (
        'code' => 'LER',
        'name' => 'Leraba',
      ),
      23 => 
      array (
        'code' => 'LOR',
        'name' => 'Loroum',
      ),
      24 => 
      array (
        'code' => 'MOU',
        'name' => 'Mouhoun',
      ),
      25 => 
      array (
        'code' => 'NAH',
        'name' => 'Nahouri',
      ),
      26 => 
      array (
        'code' => 'NAM',
        'name' => 'Namentenga',
      ),
      27 => 
      array (
        'code' => 'NAY',
        'name' => 'Nayala',
      ),
      28 => 
      array (
        'code' => 'NOU',
        'name' => 'Noumbiel',
      ),
      29 => 
      array (
        'code' => 'OUB',
        'name' => 'Oubritenga',
      ),
      30 => 
      array (
        'code' => 'OUD',
        'name' => 'Oudalan',
      ),
      31 => 
      array (
        'code' => 'PAS',
        'name' => 'Passore',
      ),
      32 => 
      array (
        'code' => 'PON',
        'name' => '포니',
      ),
      33 => 
      array (
        'code' => 'SAG',
        'name' => 'Sanguie',
      ),
      34 => 
      array (
        'code' => 'SAM',
        'name' => 'Sanmatenga',
      ),
      35 => 
      array (
        'code' => 'SEN',
        'name' => '세노',
      ),
      36 => 
      array (
        'code' => 'SIS',
        'name' => 'Sissili',
      ),
      37 => 
      array (
        'code' => 'SOM',
        'name' => 'Soum',
      ),
      38 => 
      array (
        'code' => 'SOR',
        'name' => 'Sourou',
      ),
      39 => 
      array (
        'code' => 'TAP',
        'name' => '타 포아',
      ),
      40 => 
      array (
        'code' => 'TUY',
        'name' => '투이',
      ),
      41 => 
      array (
        'code' => 'YAG',
        'name' => 'Yagha',
      ),
      42 => 
      array (
        'code' => 'YAT',
        'name' => 'Yatenga',
      ),
      43 => 
      array (
        'code' => 'ZIR',
        'name' => 'Ziro',
      ),
      44 => 
      array (
        'code' => 'ZOD',
        'name' => 'Zondoma',
      ),
      45 => 
      array (
        'code' => 'ZOW',
        'name' => 'Zoundweogo',
      ),
    ),
    'BG' => 
    array (
      1 => 
      array (
        'code' => 'BG-01',
        'name' => '블라고에 브 그라드',
      ),
      2 => 
      array (
        'code' => 'BG-02',
        'name' => '부르 가스',
      ),
      3 => 
      array (
        'code' => 'BG-03',
        'name' => '도브 리치',
      ),
      4 => 
      array (
        'code' => 'BG-04',
        'name' => '가브 로보',
      ),
      5 => 
      array (
        'code' => 'BG-05',
        'name' => '코보',
      ),
      6 => 
      array (
        'code' => 'BG-06',
        'name' => 'Kardjali',
      ),
      7 => 
      array (
        'code' => 'BG-07',
        'name' => '큐 스텐 딜',
      ),
      8 => 
      array (
        'code' => 'BG-08',
        'name' => '로베',
      ),
      9 => 
      array (
        'code' => 'BG-09',
        'name' => '몬태나',
      ),
      10 => 
      array (
        'code' => 'BG-10',
        'name' => 'Pazardjik',
      ),
      11 => 
      array (
        'code' => 'BG-11',
        'name' => '페르 니크',
      ),
      12 => 
      array (
        'code' => 'BG-12',
        'name' => '플레 벤',
      ),
      13 => 
      array (
        'code' => 'BG-13',
        'name' => '플 로브 디프',
      ),
      14 => 
      array (
        'code' => 'BG-14',
        'name' => '라즈 그라드',
      ),
      15 => 
      array (
        'code' => 'BG-15',
        'name' => '슈멘',
      ),
      16 => 
      array (
        'code' => 'BG-16',
        'name' => '실리 스트라',
      ),
      17 => 
      array (
        'code' => 'BG-17',
        'name' => '슬리 벤',
      ),
      18 => 
      array (
        'code' => 'BG-18',
        'name' => '스몰',
      ),
      19 => 
      array (
        'code' => 'BG-19',
        'name' => '소피아',
      ),
      20 => 
      array (
        'code' => 'BG-20',
        'name' => '소피아 - 마을',
      ),
      21 => 
      array (
        'code' => 'BG-21',
        'name' => '스타 라자 고라',
      ),
      22 => 
      array (
        'code' => 'BG-22',
        'name' => 'Targovishte',
      ),
      23 => 
      array (
        'code' => 'BG-23',
        'name' => '바르나',
      ),
      24 => 
      array (
        'code' => 'BG-24',
        'name' => '벨리 코 타르 노보',
      ),
      25 => 
      array (
        'code' => 'BG-25',
        'name' => '비딘',
      ),
      26 => 
      array (
        'code' => 'BG-26',
        'name' => 'Vratza',
      ),
      27 => 
      array (
        'code' => 'BG-27',
        'name' => '얌볼',
      ),
    ),
    'BH' => 
    array (
      1 => 
      array (
        'code' => 'CAP',
        'name' => '자본',
      ),
      2 => 
      array (
        'code' => 'CEN',
        'name' => '중앙',
      ),
      3 => 
      array (
        'code' => 'MUH',
        'name' => '무하 라크',
      ),
      4 => 
      array (
        'code' => 'NOR',
        'name' => '북',
      ),
      5 => 
      array (
        'code' => 'SOU',
        'name' => '남부',
      ),
    ),
    'BI' => 
    array (
      1 => 
      array (
        'code' => 'BB',
        'name' => '반자',
      ),
      2 => 
      array (
        'code' => 'BJ',
        'name' => '부줌 부라',
      ),
      3 => 
      array (
        'code' => 'BR',
        'name' => '루리',
      ),
      4 => 
      array (
        'code' => 'CA',
        'name' => 'Cankuzo',
      ),
      5 => 
      array (
        'code' => 'CI',
        'name' => 'Cibitoke',
      ),
      6 => 
      array (
        'code' => 'GI',
        'name' => '기테',
      ),
      7 => 
      array (
        'code' => 'KR',
        'name' => 'Karuzi',
      ),
      8 => 
      array (
        'code' => 'KY',
        'name' => 'Kayanza',
      ),
      9 => 
      array (
        'code' => 'KI',
        'name' => 'Kirundo',
      ),
      10 => 
      array (
        'code' => 'MA',
        'name' => '마 캄바',
      ),
      11 => 
      array (
        'code' => 'MU',
        'name' => 'Muramvya',
      ),
      12 => 
      array (
        'code' => 'MY',
        'name' => 'Muyinga',
      ),
      13 => 
      array (
        'code' => 'MW',
        'name' => 'Mwaro',
      ),
      14 => 
      array (
        'code' => 'NG',
        'name' => '엔고 지',
      ),
      15 => 
      array (
        'code' => 'RT',
        'name' => '루타',
      ),
      16 => 
      array (
        'code' => 'RY',
        'name' => 'Ruyigi',
      ),
    ),
    'BJ' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => '알리 보리',
      ),
      2 => 
      array (
        'code' => 'AK',
        'name' => '아타 코라',
      ),
      3 => 
      array (
        'code' => 'AQ',
        'name' => '아 틀랑',
      ),
      4 => 
      array (
        'code' => 'BO',
        'name' => '보르',
      ),
      5 => 
      array (
        'code' => 'CO',
        'name' => '콜린',
      ),
      6 => 
      array (
        'code' => 'DO',
        'name' => '동아',
      ),
      7 => 
      array (
        'code' => 'KO',
        'name' => '쿠포',
      ),
      8 => 
      array (
        'code' => 'LI',
        'name' => '연안',
      ),
      9 => 
      array (
        'code' => 'MO',
        'name' => '모노',
      ),
      10 => 
      array (
        'code' => 'OU',
        'name' => 'Oueme',
      ),
      11 => 
      array (
        'code' => 'PL',
        'name' => '고원',
      ),
      12 => 
      array (
        'code' => 'ZO',
        'name' => 'ZOU',
      ),
    ),
    'BM' => 
    array (
      1 => 
      array (
        'code' => 'DS',
        'name' => '데본 셔',
      ),
      2 => 
      array (
        'code' => 'HC',
        'name' => '해밀턴시',
      ),
      3 => 
      array (
        'code' => 'HA',
        'name' => '해밀턴',
      ),
      4 => 
      array (
        'code' => 'PG',
        'name' => '패짓',
      ),
      5 => 
      array (
        'code' => 'PB',
        'name' => '펨 브로크',
      ),
      6 => 
      array (
        'code' => 'GC',
        'name' => '세인트 조지시',
      ),
      7 => 
      array (
        'code' => 'SG',
        'name' => '세인트 조지',
      ),
      8 => 
      array (
        'code' => 'SA',
        'name' => 'Sandys에서',
      ),
      9 => 
      array (
        'code' => 'SM',
        'name' => '스미스의',
      ),
      10 => 
      array (
        'code' => 'SH',
        'name' => '사우 샘프 턴',
      ),
      11 => 
      array (
        'code' => 'WA',
        'name' => '워릭',
      ),
    ),
    'BN' => 
    array (
      1 => 
      array (
        'code' => 'BEL',
        'name' => '벨 라이트',
      ),
      2 => 
      array (
        'code' => 'BRM',
        'name' => '브루나이 Muara',
      ),
      3 => 
      array (
        'code' => 'TEM',
        'name' => 'Temburong',
      ),
      4 => 
      array (
        'code' => 'TUT',
        'name' => '투통',
      ),
    ),
    'BO' => 
    array (
      1 => 
      array (
        'code' => 'BEN',
        'name' => '베니',
      ),
      2 => 
      array (
        'code' => 'CHU',
        'name' => '추키 사카',
      ),
      3 => 
      array (
        'code' => 'COC',
        'name' => '코차밤바',
      ),
      4 => 
      array (
        'code' => 'LPZ',
        'name' => '라 파스',
      ),
      5 => 
      array (
        'code' => 'ORU',
        'name' => '오 루로',
      ),
      6 => 
      array (
        'code' => 'PAN',
        'name' => '판도',
      ),
      7 => 
      array (
        'code' => 'POT',
        'name' => '포토시',
      ),
      8 => 
      array (
        'code' => 'SCZ',
        'name' => '산타 크루즈',
      ),
      9 => 
      array (
        'code' => 'TAR',
        'name' => '타리',
      ),
    ),
    'BR' => 
    array (
      1 => 
      array (
        'code' => 'AC',
        'name' => '에이커',
      ),
      2 => 
      array (
        'code' => 'AL',
        'name' => '알라고 아스',
      ),
      3 => 
      array (
        'code' => 'AP',
        'name' => '아마 파',
      ),
      4 => 
      array (
        'code' => 'AM',
        'name' => '아마 조나스',
      ),
      5 => 
      array (
        'code' => 'BA',
        'name' => '바이아',
      ),
      6 => 
      array (
        'code' => 'CE',
        'name' => '세 아라',
      ),
      7 => 
      array (
        'code' => 'DF',
        'name' => '디스트 리토 페데 랄',
      ),
      8 => 
      array (
        'code' => 'ES',
        'name' => '이스 피리 투산 투 (주',
      ),
      9 => 
      array (
        'code' => 'GO',
        'name' => '고이 아스',
      ),
      10 => 
      array (
        'code' => 'MA',
        'name' => '마라 냥',
      ),
      11 => 
      array (
        'code' => 'MT',
        'name' => '마투 그로 수',
      ),
      12 => 
      array (
        'code' => 'MS',
        'name' => '마투 그로 수는 술을',
      ),
      13 => 
      array (
        'code' => 'MG',
        'name' => '미나스 제 라이스',
      ),
      14 => 
      array (
        'code' => 'PA',
        'name' => '파라',
      ),
      15 => 
      array (
        'code' => 'PB',
        'name' => '파라',
      ),
      16 => 
      array (
        'code' => 'PR',
        'name' => '파라나',
      ),
      17 => 
      array (
        'code' => 'PE',
        'name' => '페르 남부 쿠 (주',
      ),
      18 => 
      array (
        'code' => 'PI',
        'name' => '피아 우이',
      ),
      19 => 
      array (
        'code' => 'RJ',
        'name' => '리오 데 자네이로',
      ),
      20 => 
      array (
        'code' => 'RN',
        'name' => '리오 그란데는 노르 테',
      ),
      21 => 
      array (
        'code' => 'RS',
        'name' => '리오 그란데는 술을',
      ),
      22 => 
      array (
        'code' => 'RO',
        'name' => '론 도니아',
      ),
      23 => 
      array (
        'code' => 'RR',
        'name' => '로라 이마',
      ),
      24 => 
      array (
        'code' => 'SC',
        'name' => '산타 카타리나',
      ),
      25 => 
      array (
        'code' => 'SP',
        'name' => '상파울루',
      ),
      26 => 
      array (
        'code' => 'SE',
        'name' => '세르 지피 (주',
      ),
      27 => 
      array (
        'code' => 'TO',
        'name' => '토칸 틴스',
      ),
    ),
    'BS' => 
    array (
      1 => 
      array (
        'code' => 'ACK',
        'name' => 'Acklins',
      ),
      2 => 
      array (
        'code' => 'BER',
        'name' => '베리 제도',
      ),
      3 => 
      array (
        'code' => 'BIM',
        'name' => '비 미니',
      ),
      4 => 
      array (
        'code' => 'BLK',
        'name' => '블랙 포인트',
      ),
      5 => 
      array (
        'code' => 'CAT',
        'name' => '캣 아일랜드',
      ),
      6 => 
      array (
        'code' => 'CAB',
        'name' => '중앙 아바코',
      ),
      7 => 
      array (
        'code' => 'CAN',
        'name' => '중앙 앤드 로스',
      ),
      8 => 
      array (
        'code' => 'CEL',
        'name' => '중앙 엘레 우 테라',
      ),
      9 => 
      array (
        'code' => 'FRE',
        'name' => '프리 포트의시',
      ),
      10 => 
      array (
        'code' => 'CRO',
        'name' => '크룩 트 아일랜드',
      ),
      11 => 
      array (
        'code' => 'EGB',
        'name' => '이스트 그랜드 바하마',
      ),
      12 => 
      array (
        'code' => 'EXU',
        'name' => '조지 타운',
      ),
      13 => 
      array (
        'code' => 'GRD',
        'name' => '그랜드 케이',
      ),
      14 => 
      array (
        'code' => 'HAR',
        'name' => '하버 아일랜드',
      ),
      15 => 
      array (
        'code' => 'HOP',
        'name' => '타운을 희망',
      ),
      16 => 
      array (
        'code' => 'INA',
        'name' => 'Inagua',
      ),
      17 => 
      array (
        'code' => 'LNG',
        'name' => '롱 아일랜드',
      ),
      18 => 
      array (
        'code' => 'MAN',
        'name' => '케이 맹그로브',
      ),
      19 => 
      array (
        'code' => 'MAY',
        'name' => 'Mayaguana',
      ),
      20 => 
      array (
        'code' => 'MOO',
        'name' => '무어의 섬',
      ),
      21 => 
      array (
        'code' => 'NAB',
        'name' => '노스 아바코',
      ),
      22 => 
      array (
        'code' => 'NAN',
        'name' => '노스 앤드 로스',
      ),
      23 => 
      array (
        'code' => 'NEL',
        'name' => '노스 엘레 우 테라',
      ),
      24 => 
      array (
        'code' => 'RAG',
        'name' => '비정형 아일랜드',
      ),
      25 => 
      array (
        'code' => 'RUM',
        'name' => '럼 케이',
      ),
      26 => 
      array (
        'code' => 'SAL',
        'name' => '산 살바도르',
      ),
      27 => 
      array (
        'code' => 'SAB',
        'name' => '사우스 아바코',
      ),
      28 => 
      array (
        'code' => 'SAN',
        'name' => '사우스 앤드 로스',
      ),
      29 => 
      array (
        'code' => 'SEL',
        'name' => '사우스 엘레 우 테라',
      ),
      30 => 
      array (
        'code' => 'SWE',
        'name' => '스페인어 웰스',
      ),
      31 => 
      array (
        'code' => 'WGB',
        'name' => '웨스트 그랜드 바하마',
      ),
    ),
    'BT' => 
    array (
      1 => 
      array (
        'code' => 'BUM',
        'name' => 'Bumthang에',
      ),
      2 => 
      array (
        'code' => 'CHU',
        'name' => 'Chukha',
      ),
      3 => 
      array (
        'code' => 'DAG',
        'name' => 'Dagana',
      ),
      4 => 
      array (
        'code' => 'GAS',
        'name' => 'GASA',
      ),
      5 => 
      array (
        'code' => 'HAA',
        'name' => '랍스터',
      ),
      6 => 
      array (
        'code' => 'LHU',
        'name' => 'Lhuntse',
      ),
      7 => 
      array (
        'code' => 'MON',
        'name' => 'Mongar',
      ),
      8 => 
      array (
        'code' => 'PAR',
        'name' => '파로',
      ),
      9 => 
      array (
        'code' => 'PEM',
        'name' => 'Pemagatshel',
      ),
      10 => 
      array (
        'code' => 'PUN',
        'name' => 'Punakha에',
      ),
      11 => 
      array (
        'code' => 'SJO',
        'name' => 'Samdrup Jongkhar',
      ),
      12 => 
      array (
        'code' => 'SAT',
        'name' => 'Samtse',
      ),
      13 => 
      array (
        'code' => 'SAR',
        'name' => 'Sarpang',
      ),
      14 => 
      array (
        'code' => 'THI',
        'name' => '팀푸',
      ),
      15 => 
      array (
        'code' => 'TRG',
        'name' => 'Trashigang',
      ),
      16 => 
      array (
        'code' => 'TRY',
        'name' => 'Trashiyangste',
      ),
      17 => 
      array (
        'code' => 'TRO',
        'name' => 'Trongsa에',
      ),
      18 => 
      array (
        'code' => 'TSI',
        'name' => 'Tsirang',
      ),
      19 => 
      array (
        'code' => 'WPH',
        'name' => 'Wangdue Phodrang',
      ),
      20 => 
      array (
        'code' => 'ZHE',
        'name' => 'Zhemgang',
      ),
    ),
    'BW' => 
    array (
      1 => 
      array (
        'code' => 'CE',
        'name' => '중앙',
      ),
      2 => 
      array (
        'code' => 'GH',
        'name' => '간지',
      ),
      3 => 
      array (
        'code' => 'KD',
        'name' => 'Kgalagadi',
      ),
      4 => 
      array (
        'code' => 'KT',
        'name' => 'Kgatleng',
      ),
      5 => 
      array (
        'code' => 'KW',
        'name' => 'Kweneng',
      ),
      6 => 
      array (
        'code' => 'NG',
        'name' => 'Ngamiland',
      ),
      7 => 
      array (
        'code' => 'NE',
        'name' => '노스 이스트',
      ),
      8 => 
      array (
        'code' => 'NW',
        'name' => '노스 웨스트',
      ),
      9 => 
      array (
        'code' => 'SE',
        'name' => '동남',
      ),
      10 => 
      array (
        'code' => 'SO',
        'name' => '남부',
      ),
    ),
    'BY' => 
    array (
      1 => 
      array (
        'code' => 'BR',
        'name' => 'Brestskaya (브레스트',
      ),
      2 => 
      array (
        'code' => 'HO',
        'name' => 'Homyel skaya 고멜',
      ),
      3 => 
      array (
        'code' => 'HM',
        'name' => 'Horad 민스크',
      ),
      4 => 
      array (
        'code' => 'HR',
        'name' => 'Hrodzyenskaya (흐로 드나',
      ),
      5 => 
      array (
        'code' => 'MA',
        'name' => 'Mahilyowskaya (Mahilyow',
      ),
      6 => 
      array (
        'code' => 'MI',
        'name' => 'Minskaya',
      ),
      7 => 
      array (
        'code' => 'VI',
        'name' => 'Vitsyebskaya (Vitsyebsk',
      ),
    ),
    'BZ' => 
    array (
      1 => 
      array (
        'code' => 'BZ',
        'name' => '벨리즈',
      ),
      2 => 
      array (
        'code' => 'CY',
        'name' => '카요',
      ),
      3 => 
      array (
        'code' => 'CR',
        'name' => '코로',
      ),
      4 => 
      array (
        'code' => 'OW',
        'name' => '오렌지 워크',
      ),
      5 => 
      array (
        'code' => 'SC',
        'name' => '스탠 크리크',
      ),
      6 => 
      array (
        'code' => 'TO',
        'name' => '톨레도',
      ),
    ),
    'CA' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => '앨버타',
      ),
      2 => 
      array (
        'code' => 'BC',
        'name' => '브리티시 컬럼비아',
      ),
      3 => 
      array (
        'code' => 'MB',
        'name' => '매니토바',
      ),
      4 => 
      array (
        'code' => 'NB',
        'name' => '뉴 브런 즈윅',
      ),
      5 => 
      array (
        'code' => 'NL',
        'name' => '뉴 펀들 랜드',
      ),
      6 => 
      array (
        'code' => 'NT',
        'name' => '노스 웨스트 준주',
      ),
      7 => 
      array (
        'code' => 'NS',
        'name' => '노바 스코샤',
      ),
      8 => 
      array (
        'code' => 'NU',
        'name' => '누나 부트 준주',
      ),
      9 => 
      array (
        'code' => 'ON',
        'name' => '온타리오',
      ),
      10 => 
      array (
        'code' => 'PE',
        'name' => '프린스 에드워드 아일랜드',
      ),
      11 => 
      array (
        'code' => 'QC',
        'name' => '퀘벡',
      ),
      12 => 
      array (
        'code' => 'SK',
        'name' => '서스 캐처 원',
      ),
      13 => 
      array (
        'code' => 'YT',
        'name' => '유콘',
      ),
    ),
    'CC' => 
    array (
      1 => 
      array (
        'code' => 'D',
        'name' => '방향 아일랜드',
      ),
      2 => 
      array (
        'code' => 'H',
        'name' => '홈 아일랜드',
      ),
      3 => 
      array (
        'code' => 'O',
        'name' => 'Horsburgh 아일랜드',
      ),
      4 => 
      array (
        'code' => 'S',
        'name' => '사우스 아일랜드',
      ),
      5 => 
      array (
        'code' => 'W',
        'name' => '서쪽 섬',
      ),
    ),
    'CF' => 
    array (
      1 => 
      array (
        'code' => 'BAN',
        'name' => '방기',
      ),
      2 => 
      array (
        'code' => 'BBA',
        'name' => 'Bamingui-Bangoran',
      ),
      3 => 
      array (
        'code' => 'BKO',
        'name' => '바스 코토',
      ),
      4 => 
      array (
        'code' => 'HKO',
        'name' => '오트 코토',
      ),
      5 => 
      array (
        'code' => 'HMB',
        'name' => '오트 음보 무',
      ),
      6 => 
      array (
        'code' => 'KEM',
        'name' => 'KEMO',
      ),
      7 => 
      array (
        'code' => 'LOB',
        'name' => '로바',
      ),
      8 => 
      array (
        'code' => 'MBO',
        'name' => '음보 무',
      ),
      9 => 
      array (
        'code' => 'MKD',
        'name' => 'Mambéré-Kadéï',
      ),
      10 => 
      array (
        'code' => 'NGR',
        'name' => '나나 Grebizi',
      ),
      11 => 
      array (
        'code' => 'NMM',
        'name' => '나나 Mambere',
      ),
      12 => 
      array (
        'code' => 'OMP',
        'name' => 'Ombella-M Poko',
      ),
      13 => 
      array (
        'code' => 'OPE',
        'name' => '오우 햄 Pende',
      ),
      14 => 
      array (
        'code' => 'OUH',
        'name' => '오우 햄',
      ),
      15 => 
      array (
        'code' => 'OUK',
        'name' => 'Ouaka',
      ),
      16 => 
      array (
        'code' => 'SMB',
        'name' => '승가-Mbaere',
      ),
      17 => 
      array (
        'code' => 'VAK',
        'name' => 'Vakaga',
      ),
    ),
    'CG' => 
    array (
      1 => 
      array (
        'code' => 'BO',
        'name' => 'Bouenza',
      ),
      2 => 
      array (
        'code' => 'BR',
        'name' => '브라자빌',
      ),
      3 => 
      array (
        'code' => 'CU',
        'name' => '베트',
      ),
      4 => 
      array (
        'code' => 'CO',
        'name' => '베트 - 우에 스트',
      ),
      5 => 
      array (
        'code' => 'KO',
        'name' => 'Kouilou',
      ),
      6 => 
      array (
        'code' => 'LE',
        'name' => 'Lekoumou',
      ),
      7 => 
      array (
        'code' => 'LI',
        'name' => '리 쿠알라',
      ),
      8 => 
      array (
        'code' => 'NI',
        'name' => '니아 리',
      ),
      9 => 
      array (
        'code' => 'PL',
        'name' => '플래 토우',
      ),
      10 => 
      array (
        'code' => 'PO',
        'name' => '수영장',
      ),
      11 => 
      array (
        'code' => 'SA',
        'name' => '승가',
      ),
    ),
    'CH' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => '아르 가우',
      ),
      2 => 
      array (
        'code' => 'AR',
        'name' => '사실상 Ausserrhoden',
      ),
      3 => 
      array (
        'code' => 'AI',
        'name' => '아펜 첼 이너 로덴',
      ),
      4 => 
      array (
        'code' => 'BS',
        'name' => '바젤 슈타 트',
      ),
      5 => 
      array (
        'code' => 'BL',
        'name' => '바젤 Landschaft',
      ),
      6 => 
      array (
        'code' => 'BE',
        'name' => '베른',
      ),
      7 => 
      array (
        'code' => 'FR',
        'name' => '프리 부르',
      ),
      8 => 
      array (
        'code' => 'GE',
        'name' => 'Genève은',
      ),
      9 => 
      array (
        'code' => 'GL',
        'name' => '글 라루스',
      ),
      10 => 
      array (
        'code' => 'GR',
        'name' => '그 라우 뷘덴',
      ),
      11 => 
      array (
        'code' => 'JU',
        'name' => '쥐라',
      ),
      12 => 
      array (
        'code' => 'LU',
        'name' => '루체른',
      ),
      13 => 
      array (
        'code' => 'NE',
        'name' => '뉴 샤텔',
      ),
      14 => 
      array (
        'code' => 'NW',
        'name' => '발덴',
      ),
      15 => 
      array (
        'code' => 'OW',
        'name' => '옵 발덴',
      ),
      16 => 
      array (
        'code' => 'SG',
        'name' => '세인트 갈렌',
      ),
      17 => 
      array (
        'code' => 'SH',
        'name' => '샤프 하우젠',
      ),
      18 => 
      array (
        'code' => 'SZ',
        'name' => '슈비츠',
      ),
      19 => 
      array (
        'code' => 'SO',
        'name' => '졸로 투른',
      ),
      20 => 
      array (
        'code' => 'TG',
        'name' => '투르 가우',
      ),
      21 => 
      array (
        'code' => 'TI',
        'name' => '티치노',
      ),
      22 => 
      array (
        'code' => 'UR',
        'name' => '열린 우리당',
      ),
      23 => 
      array (
        'code' => 'VS',
        'name' => '발레',
      ),
      24 => 
      array (
        'code' => 'VD',
        'name' => 'Vaud의',
      ),
      25 => 
      array (
        'code' => 'ZG',
        'name' => '추크',
      ),
      26 => 
      array (
        'code' => 'ZH',
        'name' => '취리히',
      ),
    ),
    'CI' => 
    array (
      1 => 
      array (
        'code' => 'ABE',
        'name' => 'Abengourou',
      ),
      2 => 
      array (
        'code' => 'ABI',
        'name' => '코트 디부 아르',
      ),
      3 => 
      array (
        'code' => 'ABO',
        'name' => 'Aboisso',
      ),
      4 => 
      array (
        'code' => 'ADI',
        'name' => 'Adiake',
      ),
      5 => 
      array (
        'code' => 'ADZ',
        'name' => 'Adzope',
      ),
      6 => 
      array (
        'code' => 'AGB',
        'name' => 'Agboville',
      ),
      7 => 
      array (
        'code' => 'AGN',
        'name' => 'Agnibilekrou',
      ),
      8 => 
      array (
        'code' => 'ALE',
        'name' => 'Alepe',
      ),
      9 => 
      array (
        'code' => 'BOC',
        'name' => 'Bocanda',
      ),
      10 => 
      array (
        'code' => 'BAN',
        'name' => 'Bangolo',
      ),
      11 => 
      array (
        'code' => 'BEO',
        'name' => 'Beoumi',
      ),
      12 => 
      array (
        'code' => 'BIA',
        'name' => 'Biankouma',
      ),
      13 => 
      array (
        'code' => 'BDK',
        'name' => 'Bondoukou',
      ),
      14 => 
      array (
        'code' => 'BGN',
        'name' => 'Bongouanou',
      ),
      15 => 
      array (
        'code' => 'BFL',
        'name' => 'Bouafle',
      ),
      16 => 
      array (
        'code' => 'BKE',
        'name' => '부아 케',
      ),
      17 => 
      array (
        'code' => 'BNA',
        'name' => 'Bouna',
      ),
      18 => 
      array (
        'code' => 'BDL',
        'name' => 'Boundiali',
      ),
      19 => 
      array (
        'code' => 'DKL',
        'name' => 'Dabakala',
      ),
      20 => 
      array (
        'code' => 'DBU',
        'name' => 'Dabou',
      ),
      21 => 
      array (
        'code' => 'DAL',
        'name' => 'Daloa',
      ),
      22 => 
      array (
        'code' => 'DAN',
        'name' => 'Danane',
      ),
      23 => 
      array (
        'code' => 'DAO',
        'name' => 'Daoukro',
      ),
      24 => 
      array (
        'code' => 'DIM',
        'name' => 'Dimbokro',
      ),
      25 => 
      array (
        'code' => 'DIV',
        'name' => '디보',
      ),
      26 => 
      array (
        'code' => 'DUE',
        'name' => 'Duekoue',
      ),
      27 => 
      array (
        'code' => 'FER',
        'name' => 'Ferkessedougou',
      ),
      28 => 
      array (
        'code' => 'GAG',
        'name' => 'Gagnoa',
      ),
      29 => 
      array (
        'code' => 'GBA',
        'name' => '그랜드 Bassam의',
      ),
      30 => 
      array (
        'code' => 'GLA',
        'name' => '그랜드 Lahou',
      ),
      31 => 
      array (
        'code' => 'GUI',
        'name' => 'Guiglo',
      ),
      32 => 
      array (
        'code' => 'ISS',
        'name' => 'Issia',
      ),
      33 => 
      array (
        'code' => 'JAC',
        'name' => 'Jacqueville',
      ),
      34 => 
      array (
        'code' => 'KAT',
        'name' => 'Katiola',
      ),
      35 => 
      array (
        'code' => 'KOR',
        'name' => 'Korhogo',
      ),
      36 => 
      array (
        'code' => 'LAK',
        'name' => '라코타',
      ),
      37 => 
      array (
        'code' => 'MAN',
        'name' => '남자',
      ),
      38 => 
      array (
        'code' => 'MKN',
        'name' => 'Mankono',
      ),
      39 => 
      array (
        'code' => 'MBA',
        'name' => 'Mbahiakro',
      ),
      40 => 
      array (
        'code' => 'ODI',
        'name' => 'Odienne',
      ),
      41 => 
      array (
        'code' => 'OUM',
        'name' => '오메',
      ),
      42 => 
      array (
        'code' => 'SAK',
        'name' => 'Sakassou',
      ),
      43 => 
      array (
        'code' => 'SPE',
        'name' => '산 페드로',
      ),
      44 => 
      array (
        'code' => 'SAS',
        'name' => '산드라',
      ),
      45 => 
      array (
        'code' => 'SEG',
        'name' => 'Seguela',
      ),
      46 => 
      array (
        'code' => 'SIN',
        'name' => 'Sinfra',
      ),
      47 => 
      array (
        'code' => 'SOU',
        'name' => 'Soubre',
      ),
      48 => 
      array (
        'code' => 'TAB',
        'name' => 'Tabou의',
      ),
      49 => 
      array (
        'code' => 'TAN',
        'name' => '탄다',
      ),
      50 => 
      array (
        'code' => 'TIE',
        'name' => 'Tiebissou',
      ),
      51 => 
      array (
        'code' => 'TIN',
        'name' => 'Tingrela',
      ),
      52 => 
      array (
        'code' => 'TIA',
        'name' => 'Tiassale',
      ),
      53 => 
      array (
        'code' => 'TBA',
        'name' => '투바',
      ),
      54 => 
      array (
        'code' => 'TLP',
        'name' => 'Toulepleu',
      ),
      55 => 
      array (
        'code' => 'TMD',
        'name' => 'Toumodi',
      ),
      56 => 
      array (
        'code' => 'VAV',
        'name' => 'Vavoua',
      ),
      57 => 
      array (
        'code' => 'YAM',
        'name' => '야무 수크로',
      ),
      58 => 
      array (
        'code' => 'ZUE',
        'name' => 'Zuenoula',
      ),
    ),
    'CK' => 
    array (
      1 => 
      array (
        'code' => 'AI',
        'name' => '아이 투 타키',
      ),
      2 => 
      array (
        'code' => 'AT',
        'name' => '아티 우',
      ),
      3 => 
      array (
        'code' => 'MA',
        'name' => 'Manuae',
      ),
      4 => 
      array (
        'code' => 'MG',
        'name' => '망 가이아',
      ),
      5 => 
      array (
        'code' => 'MK',
        'name' => 'Manihiki',
      ),
      6 => 
      array (
        'code' => 'MT',
        'name' => '된 Mitiaro',
      ),
      7 => 
      array (
        'code' => 'MU',
        'name' => 'Mauke',
      ),
      8 => 
      array (
        'code' => 'NI',
        'name' => '나소 섬',
      ),
      9 => 
      array (
        'code' => 'PA',
        'name' => '파머 스톤',
      ),
      10 => 
      array (
        'code' => 'PE',
        'name' => '펜린',
      ),
      11 => 
      array (
        'code' => 'PU',
        'name' => '둥둥',
      ),
      12 => 
      array (
        'code' => 'RK',
        'name' => 'Rakahanga',
      ),
      13 => 
      array (
        'code' => 'RR',
        'name' => '라로 통가',
      ),
      14 => 
      array (
        'code' => 'SU',
        'name' => 'Surwarrow',
      ),
      15 => 
      array (
        'code' => 'TA',
        'name' => 'Takutea',
      ),
    ),
    'CL' => 
    array (
      1 => 
      array (
        'code' => 'AI',
        'name' => 'AISEN 델 일반 카를로스 바 네즈',
      ),
      2 => 
      array (
        'code' => 'AN',
        'name' => '안토 파가 스타',
      ),
      3 => 
      array (
        'code' => 'AR',
        'name' => '아라우 카 니아',
      ),
      4 => 
      array (
        'code' => 'AT',
        'name' => '아타 카마',
      ),
      5 => 
      array (
        'code' => 'BI',
        'name' => '바이오 바이오',
      ),
      6 => 
      array (
        'code' => 'CO',
        'name' => '코 킴보',
      ),
      7 => 
      array (
        'code' => 'LI',
        'name' => '리베르 타 도르 버나 O Hi',
      ),
      8 => 
      array (
        'code' => 'LL',
        'name' => '로스 라고스',
      ),
      9 => 
      array (
        'code' => 'MA',
        'name' => '마젤란 Y 드 라 남극 치',
      ),
      10 => 
      array (
        'code' => 'ML',
        'name' => '울레',
      ),
      11 => 
      array (
        'code' => 'RM',
        'name' => '지역 메트로',
      ),
      12 => 
      array (
        'code' => 'TA',
        'name' => '타라 파카',
      ),
      13 => 
      array (
        'code' => 'VS',
        'name' => '발파라이소',
      ),
    ),
    'CM' => 
    array (
      1 => 
      array (
        'code' => 'ADA',
        'name' => '아다마 (Adamaoua',
      ),
      2 => 
      array (
        'code' => 'CEN',
        'name' => '센터',
      ),
      3 => 
      array (
        'code' => 'EST',
        'name' => '동 (추정치',
      ),
      4 => 
      array (
        'code' => 'EXN',
        'name' => '극단적 인 노르',
      ),
      5 => 
      array (
        'code' => 'LIT',
        'name' => '연안',
      ),
      6 => 
      array (
        'code' => 'NOR',
        'name' => '노스 (노르',
      ),
      7 => 
      array (
        'code' => 'NOT',
        'name' => '노스 웨스트 (노르 우에 스트',
      ),
      8 => 
      array (
        'code' => 'OUE',
        'name' => '웨스트 (퀘스트',
      ),
      9 => 
      array (
        'code' => 'SUD',
        'name' => '남부 지역 (쉬',
      ),
      10 => 
      array (
        'code' => 'SOU',
        'name' => '사우스 웨스트 (쉬 - 우에 스트',
      ),
    ),
    'CN' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => '안후이',
      ),
      2 => 
      array (
        'code' => 'BE',
        'name' => '베이징',
      ),
      3 => 
      array (
        'code' => 'CH',
        'name' => '충칭',
      ),
      4 => 
      array (
        'code' => 'FU',
        'name' => '복건',
      ),
      5 => 
      array (
        'code' => 'GA',
        'name' => '간쑤',
      ),
      6 => 
      array (
        'code' => 'GU',
        'name' => '광동',
      ),
      7 => 
      array (
        'code' => 'GX',
        'name' => '광시',
      ),
      8 => 
      array (
        'code' => 'GZ',
        'name' => '구이 저우',
      ),
      9 => 
      array (
        'code' => 'HA',
        'name' => '하이난',
      ),
      10 => 
      array (
        'code' => 'HB',
        'name' => '허베이',
      ),
      11 => 
      array (
        'code' => 'HL',
        'name' => '헤이룽장',
      ),
      12 => 
      array (
        'code' => 'HE',
        'name' => '허난',
      ),
      13 => 
      array (
        'code' => 'HK',
        'name' => '홍콩',
      ),
      14 => 
      array (
        'code' => 'HU',
        'name' => '후베이',
      ),
      15 => 
      array (
        'code' => 'HN',
        'name' => '후난',
      ),
      16 => 
      array (
        'code' => 'IM',
        'name' => '내몽고',
      ),
      17 => 
      array (
        'code' => 'JI',
        'name' => '강소',
      ),
      18 => 
      array (
        'code' => 'JX',
        'name' => '장시',
      ),
      19 => 
      array (
        'code' => 'JL',
        'name' => '길림',
      ),
      20 => 
      array (
        'code' => 'LI',
        'name' => '랴오닝',
      ),
      21 => 
      array (
        'code' => 'MA',
        'name' => '마카오',
      ),
      22 => 
      array (
        'code' => 'NI',
        'name' => '닝샤 후이족 자치구',
      ),
      23 => 
      array (
        'code' => 'SH',
        'name' => '산시',
      ),
      24 => 
      array (
        'code' => 'SA',
        'name' => '산동',
      ),
      25 => 
      array (
        'code' => 'SG',
        'name' => '상하이',
      ),
      26 => 
      array (
        'code' => 'SX',
        'name' => '산서',
      ),
      27 => 
      array (
        'code' => 'SI',
        'name' => '사천',
      ),
      28 => 
      array (
        'code' => 'TI',
        'name' => '천진',
      ),
      29 => 
      array (
        'code' => 'XI',
        'name' => '신강',
      ),
      30 => 
      array (
        'code' => 'YU',
        'name' => '운남',
      ),
      31 => 
      array (
        'code' => 'ZH',
        'name' => '절강',
      ),
    ),
    'CO' => 
    array (
      1 => 
      array (
        'code' => 'AMZ',
        'name' => '아마 조나스',
      ),
      2 => 
      array (
        'code' => 'ANT',
        'name' => '안티오키아',
      ),
      3 => 
      array (
        'code' => 'ARA',
        'name' => '아라우 카',
      ),
      4 => 
      array (
        'code' => 'ATL',
        'name' => '아틀란 티코',
      ),
      5 => 
      array (
        'code' => 'BDC',
        'name' => '보고타 DC',
      ),
      6 => 
      array (
        'code' => 'BOL',
        'name' => '볼리바르',
      ),
      7 => 
      array (
        'code' => 'BOY',
        'name' => '야카',
      ),
      8 => 
      array (
        'code' => 'CAL',
        'name' => '칼 다스',
      ),
      9 => 
      array (
        'code' => 'CAQ',
        'name' => '카 케타',
      ),
      10 => 
      array (
        'code' => 'CAS',
        'name' => '카사 나레',
      ),
      11 => 
      array (
        'code' => 'CAU',
        'name' => '카우 카',
      ),
      12 => 
      array (
        'code' => 'CES',
        'name' => '세자르',
      ),
      13 => 
      array (
        'code' => 'CHO',
        'name' => '초코',
      ),
      14 => 
      array (
        'code' => 'COR',
        'name' => '코르도바',
      ),
      15 => 
      array (
        'code' => 'CAM',
        'name' => '쿤 디나 마르카',
      ),
      16 => 
      array (
        'code' => 'GNA',
        'name' => 'Guainia',
      ),
      17 => 
      array (
        'code' => 'GJR',
        'name' => '구아 지라',
      ),
      18 => 
      array (
        'code' => 'GVR',
        'name' => 'Guaviare 발',
      ),
      19 => 
      array (
        'code' => 'HUI',
        'name' => '일라',
      ),
      20 => 
      array (
        'code' => 'MAG',
        'name' => '마그 달 레나',
      ),
      21 => 
      array (
        'code' => 'MET',
        'name' => '메타',
      ),
      22 => 
      array (
        'code' => 'NAR',
        'name' => '나리 뇨',
      ),
      23 => 
      array (
        'code' => 'NDS',
        'name' => '노르 테 데 산탄데르',
      ),
      24 => 
      array (
        'code' => 'PUT',
        'name' => '푸투 마요',
      ),
      25 => 
      array (
        'code' => 'QUI',
        'name' => '있는 Quindio',
      ),
      26 => 
      array (
        'code' => 'RIS',
        'name' => '리사 랄다',
      ),
      27 => 
      array (
        'code' => 'SAP',
        'name' => '산 안드레스 Y 프로 비덴 시아',
      ),
      28 => 
      array (
        'code' => 'SAN',
        'name' => '산탄데르',
      ),
      29 => 
      array (
        'code' => 'SUC',
        'name' => '수크레',
      ),
      30 => 
      array (
        'code' => 'TOL',
        'name' => '톨 리마',
      ),
      31 => 
      array (
        'code' => 'VDC',
        'name' => '발레 델 카우 카',
      ),
      32 => 
      array (
        'code' => 'VAU',
        'name' => '바우 페즈',
      ),
      33 => 
      array (
        'code' => 'VIC',
        'name' => '차다',
      ),
    ),
    'CR' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => '알라 후 엘라',
      ),
      2 => 
      array (
        'code' => 'CA',
        'name' => '카르타고',
      ),
      3 => 
      array (
        'code' => 'GU',
        'name' => '과 나카 스테',
      ),
      4 => 
      array (
        'code' => 'HE',
        'name' => '에레디',
      ),
      5 => 
      array (
        'code' => 'LI',
        'name' => '리몬',
      ),
      6 => 
      array (
        'code' => 'PU',
        'name' => '푼타',
      ),
      7 => 
      array (
        'code' => 'SJ',
        'name' => '산호세',
      ),
    ),
    'CU' => 
    array (
      1 => 
      array (
        'code' => 'CA',
        'name' => '카 마구 에이',
      ),
      2 => 
      array (
        'code' => 'CD',
        'name' => '에고 드 아빌라',
      ),
      3 => 
      array (
        'code' => 'CI',
        'name' => '시엔 푸에 고스',
      ),
      4 => 
      array (
        'code' => 'CH',
        'name' => '시우다드 데 라 하바나',
      ),
      5 => 
      array (
        'code' => 'GR',
        'name' => '그 란마',
      ),
      6 => 
      array (
        'code' => 'GU',
        'name' => '관타나모',
      ),
      7 => 
      array (
        'code' => 'HO',
        'name' => '올긴',
      ),
      8 => 
      array (
        'code' => 'IJ',
        'name' => '이슬라 드 라 Juventud',
      ),
      9 => 
      array (
        'code' => 'LH',
        'name' => '라 하바나',
      ),
      10 => 
      array (
        'code' => 'LT',
        'name' => '라스 투나 스',
      ),
      11 => 
      array (
        'code' => 'MA',
        'name' => '마탄 자스',
      ),
      12 => 
      array (
        'code' => 'PR',
        'name' => '피 나르 델 리오',
      ),
      13 => 
      array (
        'code' => 'SS',
        'name' => '산티 Spiritus에',
      ),
      14 => 
      array (
        'code' => 'SC',
        'name' => '산티아고 데 쿠바',
      ),
      15 => 
      array (
        'code' => 'VC',
        'name' => '빌라 클라라',
      ),
    ),
    'CV' => 
    array (
      1 => 
      array (
        'code' => 'BV',
        'name' => '보아 비스타',
      ),
      2 => 
      array (
        'code' => 'BR',
        'name' => '브라바',
      ),
      3 => 
      array (
        'code' => 'CS',
        'name' => '칼 헤다 데 사오 미구엘',
      ),
      4 => 
      array (
        'code' => 'MA',
        'name' => 'Maio은',
      ),
      5 => 
      array (
        'code' => 'MO',
        'name' => 'Mosteiros',
      ),
      6 => 
      array (
        'code' => 'PA',
        'name' => '폴',
      ),
      7 => 
      array (
        'code' => 'PN',
        'name' => '포르토 노보',
      ),
      8 => 
      array (
        'code' => 'PR',
        'name' => '프라이 아',
      ),
      9 => 
      array (
        'code' => 'RG',
        'name' => '리베이라 그란데',
      ),
      10 => 
      array (
        'code' => 'SL',
        'name' => 'SAL',
      ),
      11 => 
      array (
        'code' => 'CA',
        'name' => '산타 카타리나',
      ),
      12 => 
      array (
        'code' => 'CR',
        'name' => '산타 크루즈',
      ),
      13 => 
      array (
        'code' => 'SD',
        'name' => '상 도밍고',
      ),
      14 => 
      array (
        'code' => 'SF',
        'name' => '상 Filipe',
      ),
      15 => 
      array (
        'code' => 'SN',
        'name' => '상 Nicolau',
      ),
      16 => 
      array (
        'code' => 'SV',
        'name' => '상 비센테',
      ),
      17 => 
      array (
        'code' => 'TA',
        'name' => '타라 팔',
      ),
    ),
    'CY' => 
    array (
      1 => 
      array (
        'code' => 'F',
        'name' => '파 마구 스타',
      ),
      2 => 
      array (
        'code' => 'K',
        'name' => '키레 니아',
      ),
      3 => 
      array (
        'code' => 'A',
        'name' => '라르 나카',
      ),
      4 => 
      array (
        'code' => 'I',
        'name' => '리마 솔',
      ),
      5 => 
      array (
        'code' => 'N',
        'name' => '니코 시아',
      ),
      6 => 
      array (
        'code' => 'P',
        'name' => '파 포스',
      ),
    ),
    'CZ' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Hlavni 나드 메스토 프라하',
      ),
      2 => 
      array (
        'code' => 'B',
        'name' => 'Jihomoravský',
      ),
      3 => 
      array (
        'code' => 'C',
        'name' => 'Jihočeský',
      ),
      4 => 
      array (
        'code' => 'E',
        'name' => 'Pardubický',
      ),
      5 => 
      array (
        'code' => 'H',
        'name' => 'Královéhradecký',
      ),
      6 => 
      array (
        'code' => 'J',
        'name' => '비소 치나',
      ),
      7 => 
      array (
        'code' => 'K',
        'name' => 'Karlovarský',
      ),
      8 => 
      array (
        'code' => 'L',
        'name' => 'Liberecký',
      ),
      9 => 
      array (
        'code' => 'M',
        'name' => 'Olomoucký',
      ),
      10 => 
      array (
        'code' => 'P',
        'name' => 'Plzeňský',
      ),
      11 => 
      array (
        'code' => 'S',
        'name' => '의 stredocesky',
      ),
      12 => 
      array (
        'code' => 'T',
        'name' => '모 라프 스코 슬레',
      ),
      13 => 
      array (
        'code' => 'U',
        'name' => 'Ústecký',
      ),
      14 => 
      array (
        'code' => 'Z',
        'name' => 'Zlínský',
      ),
    ),
    'Country' => 
    array (
      1 => 
      array (
        'code' => 'code',
        'name' => 'States',
      ),
    ),
    'DE' => 
    array (
      1 => 
      array (
        'code' => 'BAW',
        'name' => '바덴 뷔 르템 베르크 주',
      ),
      2 => 
      array (
        'code' => 'BAY',
        'name' => '바이에른',
      ),
      3 => 
      array (
        'code' => 'BER',
        'name' => '베를린',
      ),
      4 => 
      array (
        'code' => 'BRG',
        'name' => '브란덴부르크',
      ),
      5 => 
      array (
        'code' => 'BRE',
        'name' => '브레멘',
      ),
      6 => 
      array (
        'code' => 'HAM',
        'name' => '함부르크',
      ),
      7 => 
      array (
        'code' => 'HES',
        'name' => '헤센',
      ),
      8 => 
      array (
        'code' => 'MEC',
        'name' => '메 클렌 부르크 포어 포메 른',
      ),
      9 => 
      array (
        'code' => 'NDS',
        'name' => '니더 작센',
      ),
      10 => 
      array (
        'code' => 'NRW',
        'name' => '노르 트라 인베스트 팔렌',
      ),
      11 => 
      array (
        'code' => 'RHE',
        'name' => '브이 라인 란드 - 팔츠',
      ),
      12 => 
      array (
        'code' => 'SAR',
        'name' => '자를란 트',
      ),
      13 => 
      array (
        'code' => 'SAS',
        'name' => '작센',
      ),
      14 => 
      array (
        'code' => 'SAC',
        'name' => '작센 안할 트',
      ),
      15 => 
      array (
        'code' => 'SCN',
        'name' => '슐레스비히 - 홀슈타인',
      ),
      16 => 
      array (
        'code' => 'THE',
        'name' => '튀 링겐',
      ),
    ),
    'DJ' => 
    array (
      1 => 
      array (
        'code' => 'S',
        'name' => '알리 Sabih',
      ),
      2 => 
      array (
        'code' => 'K',
        'name' => 'Dikhil',
      ),
      3 => 
      array (
        'code' => 'J',
        'name' => '지부티',
      ),
      4 => 
      array (
        'code' => 'O',
        'name' => '오보 크',
      ),
      5 => 
      array (
        'code' => 'T',
        'name' => 'Tadjoura',
      ),
    ),
    'DK' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => '오르후스',
      ),
      2 => 
      array (
        'code' => 'BH',
        'name' => '홀름',
      ),
      3 => 
      array (
        'code' => 'CO',
        'name' => '코펜하겐',
      ),
      4 => 
      array (
        'code' => 'FO',
        'name' => '페로 제도',
      ),
      5 => 
      array (
        'code' => 'FR',
        'name' => '프레데릭 스 보르',
      ),
      6 => 
      array (
        'code' => 'FY',
        'name' => '퓐',
      ),
      7 => 
      array (
        'code' => 'KO',
        'name' => '코펜하겐',
      ),
      8 => 
      array (
        'code' => 'NO',
        'name' => '노르 윌란',
      ),
      9 => 
      array (
        'code' => 'RI',
        'name' => '리베',
      ),
      10 => 
      array (
        'code' => 'RK',
        'name' => '링 쾨빙',
      ),
      11 => 
      array (
        'code' => 'RO',
        'name' => '로스 킬레',
      ),
      12 => 
      array (
        'code' => 'SO',
        'name' => '쇠 네르 윌란',
      ),
      13 => 
      array (
        'code' => 'ST',
        'name' => '스 토르 스트 룀',
      ),
      14 => 
      array (
        'code' => 'VK',
        'name' => '바 일레',
      ),
      15 => 
      array (
        'code' => 'VJ',
        'name' => 'Vestjælland',
      ),
      16 => 
      array (
        'code' => 'VB',
        'name' => '비 보르',
      ),
    ),
    'DM' => 
    array (
      1 => 
      array (
        'code' => 'AND',
        'name' => '세인트 앤드류 교구',
      ),
      2 => 
      array (
        'code' => 'DAV',
        'name' => '세인트 데이비드 교구',
      ),
      3 => 
      array (
        'code' => 'GEO',
        'name' => '세인트 조지 교구',
      ),
      4 => 
      array (
        'code' => 'JOH',
        'name' => '세인트 존 교구',
      ),
      5 => 
      array (
        'code' => 'JOS',
        'name' => '세인트 조셉 교구',
      ),
      6 => 
      array (
        'code' => 'LUK',
        'name' => '세인트 루크 교구',
      ),
      7 => 
      array (
        'code' => 'MAR',
        'name' => '세인트 마크 교구',
      ),
      8 => 
      array (
        'code' => 'PAT',
        'name' => '세인트 패트릭 교구',
      ),
      9 => 
      array (
        'code' => 'PAU',
        'name' => '세인트 폴 교구',
      ),
      10 => 
      array (
        'code' => 'PET',
        'name' => '세인트 피터 교구',
      ),
    ),
    'DO' => 
    array (
      1 => 
      array (
        'code' => 'DN',
        'name' => '디스트 나시 오날',
      ),
      2 => 
      array (
        'code' => 'AZ',
        'name' => 'Azua',
      ),
      3 => 
      array (
        'code' => 'BC',
        'name' => 'Baoruco',
      ),
      4 => 
      array (
        'code' => 'BH',
        'name' => '바라오나',
      ),
      5 => 
      array (
        'code' => 'DJ',
        'name' => 'Dajabon',
      ),
      6 => 
      array (
        'code' => 'DU',
        'name' => '아르테',
      ),
      7 => 
      array (
        'code' => 'EL',
        'name' => '엘리아스 피나',
      ),
      8 => 
      array (
        'code' => 'SY',
        'name' => '엘 Seybo',
      ),
      9 => 
      array (
        'code' => 'ET',
        'name' => 'Espaillat',
      ),
      10 => 
      array (
        'code' => 'HM',
        'name' => '하토 시장',
      ),
      11 => 
      array (
        'code' => 'IN',
        'name' => '독립',
      ),
      12 => 
      array (
        'code' => 'AL',
        'name' => '라 푼타 카나',
      ),
      13 => 
      array (
        'code' => 'RO',
        'name' => '라 로마나',
      ),
      14 => 
      array (
        'code' => 'VE',
        'name' => '라 베가',
      ),
      15 => 
      array (
        'code' => 'MT',
        'name' => '마리아 트리니다드 산체스',
      ),
      16 => 
      array (
        'code' => 'MN',
        'name' => 'Monsenor Nouel',
      ),
      17 => 
      array (
        'code' => 'MC',
        'name' => '몬테 크리스티',
      ),
      18 => 
      array (
        'code' => 'MP',
        'name' => '몬테 플라 타',
      ),
      19 => 
      array (
        'code' => 'PD',
        'name' => '곤잘로 페 데르 날 레스',
      ),
      20 => 
      array (
        'code' => 'PR',
        'name' => 'Peravia (바니',
      ),
      21 => 
      array (
        'code' => 'PP',
        'name' => '푸에르토 플라 타',
      ),
      22 => 
      array (
        'code' => 'SL',
        'name' => '살 세도',
      ),
      23 => 
      array (
        'code' => 'SM',
        'name' => '사마',
      ),
      24 => 
      array (
        'code' => 'SH',
        'name' => '산체스 라미레즈',
      ),
      25 => 
      array (
        'code' => 'SC',
        'name' => '산 크리스토 발',
      ),
      26 => 
      array (
        'code' => 'JO',
        'name' => '산 호세 드 Ocoa',
      ),
      27 => 
      array (
        'code' => 'SJ',
        'name' => '산후 안',
      ),
      28 => 
      array (
        'code' => 'PM',
        'name' => '산 페드로 데 마코리스',
      ),
      29 => 
      array (
        'code' => 'SA',
        'name' => '산티아고',
      ),
      30 => 
      array (
        'code' => 'ST',
        'name' => '산티아고로드 리 게스',
      ),
      31 => 
      array (
        'code' => 'SD',
        'name' => '산토 도밍고',
      ),
      32 => 
      array (
        'code' => 'VA',
        'name' => '발 베르데',
      ),
    ),
    'DZ' => 
    array (
      1 => 
      array (
        'code' => 'ADE',
        'name' => '아인 Defla',
      ),
      2 => 
      array (
        'code' => 'ADR',
        'name' => '아 드라',
      ),
      3 => 
      array (
        'code' => 'ALG',
        'name' => 'ALGER',
      ),
      4 => 
      array (
        'code' => 'ANN',
        'name' => '안나',
      ),
      5 => 
      array (
        'code' => 'ATE',
        'name' => '아인 Temouchent',
      ),
      6 => 
      array (
        'code' => 'BAT',
        'name' => '바트 나',
      ),
      7 => 
      array (
        'code' => 'BBA',
        'name' => '드지 보우 Arreridj',
      ),
      8 => 
      array (
        'code' => 'BEC',
        'name' => '베타',
      ),
      9 => 
      array (
        'code' => 'BEJ',
        'name' => '하하',
      ),
      10 => 
      array (
        'code' => 'BIS',
        'name' => '비스 크라',
      ),
      11 => 
      array (
        'code' => 'BLI',
        'name' => '블리',
      ),
      12 => 
      array (
        'code' => 'BMD',
        'name' => 'Boumerdes',
      ),
      13 => 
      array (
        'code' => 'BOA',
        'name' => 'Bouira',
      ),
      14 => 
      array (
        'code' => 'CHL',
        'name' => '우메',
      ),
      15 => 
      array (
        'code' => 'CON',
        'name' => '콘스탄틴',
      ),
      16 => 
      array (
        'code' => 'DJE',
        'name' => 'Djelfa',
      ),
      17 => 
      array (
        'code' => 'EBA',
        'name' => '엘 Bayadh 행',
      ),
      18 => 
      array (
        'code' => 'EOU',
        'name' => '엘 Oued',
      ),
      19 => 
      array (
        'code' => 'ETA',
        'name' => '엘 Tarf',
      ),
      20 => 
      array (
        'code' => 'GHA',
        'name' => '가다이',
      ),
      21 => 
      array (
        'code' => 'GUE',
        'name' => '겔마',
      ),
      22 => 
      array (
        'code' => 'ILL',
        'name' => '일리지',
      ),
      23 => 
      array (
        'code' => 'JIJ',
        'name' => '지젤',
      ),
      24 => 
      array (
        'code' => 'KHE',
        'name' => 'Khenchela',
      ),
      25 => 
      array (
        'code' => 'LAG',
        'name' => '라구 아트',
      ),
      26 => 
      array (
        'code' => 'MED',
        'name' => '메데아',
      ),
      27 => 
      array (
        'code' => 'MIL',
        'name' => '밀라',
      ),
      28 => 
      array (
        'code' => 'MOS',
        'name' => '모 스타가 냄',
      ),
      29 => 
      array (
        'code' => 'MSI',
        'name' => 'M Sila',
      ),
      30 => 
      array (
        'code' => 'MUA',
        'name' => 'Muaskar',
      ),
      31 => 
      array (
        'code' => 'NAA',
        'name' => '아마',
      ),
      32 => 
      array (
        'code' => 'OEB',
        'name' => '오움 엘 Bouaghi',
      ),
      33 => 
      array (
        'code' => 'ORA',
        'name' => '오란',
      ),
      34 => 
      array (
        'code' => 'OUA',
        'name' => '우 아르 글라',
      ),
      35 => 
      array (
        'code' => 'REL',
        'name' => '랠리 제인',
      ),
      36 => 
      array (
        'code' => 'SAH',
        'name' => '수카하라',
      ),
      37 => 
      array (
        'code' => 'SAI',
        'name' => '사이다',
      ),
      38 => 
      array (
        'code' => 'SBA',
        'name' => '시디 벨아 베스',
      ),
      39 => 
      array (
        'code' => 'SET',
        'name' => '세티 프',
      ),
      40 => 
      array (
        'code' => 'SKI',
        'name' => '킥다',
      ),
      41 => 
      array (
        'code' => 'TAM',
        'name' => 'Tamanghasset',
      ),
      42 => 
      array (
        'code' => 'TEB',
        'name' => '테베',
      ),
      43 => 
      array (
        'code' => 'TIA',
        'name' => '티아 렛',
      ),
      44 => 
      array (
        'code' => 'TIN',
        'name' => '틴 두프',
      ),
      45 => 
      array (
        'code' => 'TIP',
        'name' => '티파',
      ),
      46 => 
      array (
        'code' => 'TIS',
        'name' => 'Tissemsilt',
      ),
      47 => 
      array (
        'code' => 'TLE',
        'name' => '틀 렘센',
      ),
      48 => 
      array (
        'code' => 'TOU',
        'name' => '티지 Ouzou',
      ),
    ),
    'EC' => 
    array (
      1 => 
      array (
        'code' => 'AZU',
        'name' => '아수',
      ),
      2 => 
      array (
        'code' => 'BOL',
        'name' => '볼리바르',
      ),
      3 => 
      array (
        'code' => 'CAN',
        'name' => '카나',
      ),
      4 => 
      array (
        'code' => 'CAR',
        'name' => 'Carchi',
      ),
      5 => 
      array (
        'code' => 'CHI',
        'name' => '침',
      ),
      6 => 
      array (
        'code' => 'COT',
        'name' => '코토 팍시',
      ),
      7 => 
      array (
        'code' => 'EOR',
        'name' => '엘 오로',
      ),
      8 => 
      array (
        'code' => 'ESM',
        'name' => '에스메랄다',
      ),
      9 => 
      array (
        'code' => 'GPS',
        'name' => '갈라파고스',
      ),
      10 => 
      array (
        'code' => 'GUA',
        'name' => 'Guayas',
      ),
      11 => 
      array (
        'code' => 'IMB',
        'name' => '오타 발로',
      ),
      12 => 
      array (
        'code' => 'LOJ',
        'name' => '로하',
      ),
      13 => 
      array (
        'code' => 'LRO',
        'name' => '로스 리오스',
      ),
      14 => 
      array (
        'code' => 'MAN',
        'name' => '마나비',
      ),
      15 => 
      array (
        'code' => 'MSA',
        'name' => 'Morona 산티아고',
      ),
      16 => 
      array (
        'code' => 'NAP',
        'name' => '나포',
      ),
      17 => 
      array (
        'code' => 'ORE',
        'name' => 'Orellana',
      ),
      18 => 
      array (
        'code' => 'PAS',
        'name' => 'Pastaza',
      ),
      19 => 
      array (
        'code' => 'PIC',
        'name' => '친차',
      ),
      20 => 
      array (
        'code' => 'SUC',
        'name' => 'Sucumbíos',
      ),
      21 => 
      array (
        'code' => 'TUN',
        'name' => '퉁 구라 우아',
      ),
      22 => 
      array (
        'code' => 'ZCH',
        'name' => '사모라 Chinchipe',
      ),
    ),
    'EE' => 
    array (
      1 => 
      array (
        'code' => 'HA',
        'name' => 'Harjumaa (탈린',
      ),
      2 => 
      array (
        'code' => 'HI',
        'name' => 'Hiiumaa (캐르 들라',
      ),
      3 => 
      array (
        'code' => 'IV',
        'name' => '아이다 루마 (Johvi',
      ),
      4 => 
      array (
        'code' => 'JA',
        'name' => 'Jarvamaa (파이드',
      ),
      5 => 
      array (
        'code' => 'JO',
        'name' => 'Jogevamaa (Jogeva',
      ),
      6 => 
      array (
        'code' => 'LV',
        'name' => 'Laane 루마 (베레',
      ),
      7 => 
      array (
        'code' => 'LA',
        'name' => 'Laanemaa (합',
      ),
      8 => 
      array (
        'code' => 'PA',
        'name' => 'Parnumaa (누',
      ),
      9 => 
      array (
        'code' => 'PO',
        'name' => 'Polvamaa (Polva',
      ),
      10 => 
      array (
        'code' => 'RA',
        'name' => 'Raplamaa (Rapla',
      ),
      11 => 
      array (
        'code' => 'SA',
        'name' => 'Saaremaa에 (Kuessaare',
      ),
      12 => 
      array (
        'code' => 'TA',
        'name' => 'Tartumaa (타르',
      ),
      13 => 
      array (
        'code' => 'VA',
        'name' => 'Valgamaa (발가',
      ),
      14 => 
      array (
        'code' => 'VI',
        'name' => 'Viljandimaa (빌 얀',
      ),
      15 => 
      array (
        'code' => 'VO',
        'name' => 'Vorumaa (보루',
      ),
    ),
    'EG' => 
    array (
      1 => 
      array (
        'code' => 'DHY',
        'name' => '광고 Daqahliyah',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => '알 바르 알 아마르',
      ),
      3 => 
      array (
        'code' => 'BHY',
        'name' => '알 Buhayrah',
      ),
      4 => 
      array (
        'code' => 'FYM',
        'name' => '알 Fayyum',
      ),
      5 => 
      array (
        'code' => 'GBY',
        'name' => '알 가르 비야',
      ),
      6 => 
      array (
        'code' => 'IDR',
        'name' => '알 이스 칸 다리',
      ),
      7 => 
      array (
        'code' => 'IML',
        'name' => '알 ISMA iliyah',
      ),
      8 => 
      array (
        'code' => 'JZH',
        'name' => '알 지자',
      ),
      9 => 
      array (
        'code' => 'MFY',
        'name' => '알 Minufiyah',
      ),
      10 => 
      array (
        'code' => 'MNY',
        'name' => '알 미냐',
      ),
      11 => 
      array (
        'code' => 'QHR',
        'name' => '알 카 히라',
      ),
      12 => 
      array (
        'code' => 'QLY',
        'name' => '알 Qalyubiyah',
      ),
      13 => 
      array (
        'code' => 'WJD',
        'name' => '알 와디 알 자 디드',
      ),
      14 => 
      array (
        'code' => 'SHQ',
        'name' => '애쉬 샤르 키야',
      ),
      15 => 
      array (
        'code' => 'SWY',
        'name' => '수에즈 운하',
      ),
      16 => 
      array (
        'code' => 'ASW',
        'name' => '아스완',
      ),
      17 => 
      array (
        'code' => 'ASY',
        'name' => '아시 우트',
      ),
      18 => 
      array (
        'code' => 'BSW',
        'name' => '바니 와이프',
      ),
      19 => 
      array (
        'code' => 'BSD',
        'name' => '부르 Sa id',
      ),
      20 => 
      array (
        'code' => 'DMY',
        'name' => 'Dumyat',
      ),
      21 => 
      array (
        'code' => 'JNS',
        'name' => '누브시나',
      ),
      22 => 
      array (
        'code' => 'KSH',
        'name' => '카 프르 재 Shaykh',
      ),
      23 => 
      array (
        'code' => 'MAT',
        'name' => '트루',
      ),
      24 => 
      array (
        'code' => 'QIN',
        'name' => 'Qina',
      ),
      25 => 
      array (
        'code' => 'SHS',
        'name' => '샤말시나',
      ),
      26 => 
      array (
        'code' => 'SUH',
        'name' => 'Suhaj',
      ),
    ),
    'ER' => 
    array (
      1 => 
      array (
        'code' => 'MA',
        'name' => '중앙 (Maekel',
      ),
      2 => 
      array (
        'code' => 'KE',
        'name' => 'Anseba (케렌',
      ),
      3 => 
      array (
        'code' => 'DK',
        'name' => '남부 홍해 (Debub-Keih-BAH',
      ),
      4 => 
      array (
        'code' => 'SK',
        'name' => '북부 홍해 (Semien-Keih-BA',
      ),
      5 => 
      array (
        'code' => 'DE',
        'name' => '남부 (Debub',
      ),
      6 => 
      array (
        'code' => 'BR',
        'name' => '깊은 상처 - 바르카 (Barentu',
      ),
    ),
    'ES' => 
    array (
      1 => 
      array (
        'code' => 'CA',
        'name' => '라 코 루나',
      ),
      2 => 
      array (
        'code' => 'AL',
        'name' => '알라 바',
      ),
      3 => 
      array (
        'code' => 'AB',
        'name' => '알바세테',
      ),
      4 => 
      array (
        'code' => 'AC',
        'name' => '알리 칸테',
      ),
      5 => 
      array (
        'code' => 'AM',
        'name' => '알 메리아',
      ),
      6 => 
      array (
        'code' => 'AS',
        'name' => '아스투리아스',
      ),
      7 => 
      array (
        'code' => 'AV',
        'name' => '아빌라',
      ),
      8 => 
      array (
        'code' => 'BJ',
        'name' => '바다 호스',
      ),
      9 => 
      array (
        'code' => 'IB',
        'name' => '발레 아레스',
      ),
      10 => 
      array (
        'code' => 'BA',
        'name' => '바르셀로나',
      ),
      11 => 
      array (
        'code' => 'BU',
        'name' => '부르고스',
      ),
      12 => 
      array (
        'code' => 'CC',
        'name' => '카세레스',
      ),
      13 => 
      array (
        'code' => 'CZ',
        'name' => '카디스',
      ),
      14 => 
      array (
        'code' => 'CT',
        'name' => '칸타 브리아',
      ),
      15 => 
      array (
        'code' => 'CL',
        'name' => '카스텔 론',
      ),
      16 => 
      array (
        'code' => 'CE',
        'name' => '세 우타',
      ),
      17 => 
      array (
        'code' => 'CR',
        'name' => '시우다드 레알',
      ),
      18 => 
      array (
        'code' => 'CD',
        'name' => '코르도바',
      ),
      19 => 
      array (
        'code' => 'CU',
        'name' => '쿠 엥카',
      ),
      20 => 
      array (
        'code' => 'GI',
        'name' => '헤로',
      ),
      21 => 
      array (
        'code' => 'GD',
        'name' => '그라나다',
      ),
      22 => 
      array (
        'code' => 'GJ',
        'name' => '과달라하라',
      ),
      23 => 
      array (
        'code' => 'GP',
        'name' => '기 푸스 코아',
      ),
      24 => 
      array (
        'code' => 'HL',
        'name' => '우 엘바',
      ),
      25 => 
      array (
        'code' => 'HS',
        'name' => '우 에스카',
      ),
      26 => 
      array (
        'code' => 'JN',
        'name' => '하엔',
      ),
      27 => 
      array (
        'code' => 'RJ',
        'name' => '라 리오하',
      ),
      28 => 
      array (
        'code' => 'PM',
        'name' => '라스 팔마스',
      ),
      29 => 
      array (
        'code' => 'LE',
        'name' => '레온',
      ),
      30 => 
      array (
        'code' => 'LL',
        'name' => '레리',
      ),
      31 => 
      array (
        'code' => 'LG',
        'name' => '루고',
      ),
      32 => 
      array (
        'code' => 'MD',
        'name' => '마드리드',
      ),
      33 => 
      array (
        'code' => 'MA',
        'name' => '말라가',
      ),
      34 => 
      array (
        'code' => 'ML',
        'name' => '멜리 야',
      ),
      35 => 
      array (
        'code' => 'MU',
        'name' => '무르시아',
      ),
      36 => 
      array (
        'code' => 'NV',
        'name' => '나바라',
      ),
      37 => 
      array (
        'code' => 'OU',
        'name' => '오렌 세',
      ),
      38 => 
      array (
        'code' => 'PL',
        'name' => '팔렌 시아',
      ),
      39 => 
      array (
        'code' => 'PO',
        'name' => '폰테 베드 라',
      ),
      40 => 
      array (
        'code' => 'SL',
        'name' => '살라망카',
      ),
      41 => 
      array (
        'code' => 'SC',
        'name' => '산타 크루즈 데 테 네리 페',
      ),
      42 => 
      array (
        'code' => 'SG',
        'name' => '세고비아',
      ),
      43 => 
      array (
        'code' => 'SV',
        'name' => '세비야',
      ),
      44 => 
      array (
        'code' => 'SO',
        'name' => '소리아',
      ),
      45 => 
      array (
        'code' => 'TA',
        'name' => '타라고 나',
      ),
      46 => 
      array (
        'code' => 'TE',
        'name' => '테루 엘',
      ),
      47 => 
      array (
        'code' => 'TO',
        'name' => '톨레도',
      ),
      48 => 
      array (
        'code' => 'VC',
        'name' => '발렌시아',
      ),
      49 => 
      array (
        'code' => 'VD',
        'name' => '바야돌리드',
      ),
      50 => 
      array (
        'code' => 'VZ',
        'name' => '비스 카야',
      ),
      51 => 
      array (
        'code' => 'ZM',
        'name' => '사모라',
      ),
      52 => 
      array (
        'code' => 'ZR',
        'name' => '사라고사',
      ),
    ),
    'ET' => 
    array (
      1 => 
      array (
        'code' => 'AF',
        'name' => '아파르어',
      ),
      2 => 
      array (
        'code' => 'AH',
        'name' => '암하라',
      ),
      3 => 
      array (
        'code' => 'BG',
        'name' => 'Benishangul-Gumaz',
      ),
      4 => 
      array (
        'code' => 'GB',
        'name' => '감 벨라',
      ),
      5 => 
      array (
        'code' => 'HR',
        'name' => 'Hariai',
      ),
      6 => 
      array (
        'code' => 'OR',
        'name' => 'Oromia',
      ),
      7 => 
      array (
        'code' => 'SM',
        'name' => '소말리어',
      ),
      8 => 
      array (
        'code' => 'SN',
        'name' => '남부 연합 - 민족',
      ),
      9 => 
      array (
        'code' => 'TG',
        'name' => '티그 라이 주',
      ),
      10 => 
      array (
        'code' => 'AA',
        'name' => '아디스 아바바',
      ),
      11 => 
      array (
        'code' => 'DD',
        'name' => '디레 다와',
      ),
    ),
    'FI' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Ahvenanmaan 라니',
      ),
      2 => 
      array (
        'code' => 'ES',
        'name' => 'Etela -의 Suomen 라니',
      ),
      3 => 
      array (
        'code' => 'IS',
        'name' => '이타의 Suomen 라니',
      ),
      4 => 
      array (
        'code' => 'LS',
        'name' => 'Lansi-의 Suomen 라니',
      ),
      5 => 
      array (
        'code' => 'LA',
        'name' => '라빤 Lanani',
      ),
      6 => 
      array (
        'code' => 'OU',
        'name' => 'Oulun 라니',
      ),
    ),
    'FJ' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => '중앙과',
      ),
      2 => 
      array (
        'code' => 'E',
        'name' => '동부 부문',
      ),
      3 => 
      array (
        'code' => 'N',
        'name' => '북과',
      ),
      4 => 
      array (
        'code' => 'R',
        'name' => 'Rotuma',
      ),
      5 => 
      array (
        'code' => 'W',
        'name' => '서양과',
      ),
    ),
    'FM' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => 'Chuuk의',
      ),
      2 => 
      array (
        'code' => 'K',
        'name' => '코스 라에',
      ),
      3 => 
      array (
        'code' => 'P',
        'name' => '폰 페이',
      ),
      4 => 
      array (
        'code' => 'Y',
        'name' => '개 짖는 소리',
      ),
    ),
    'FO' => 
    array (
      1 => 
      array (
        'code' => 'TÛR',
        'name' => 'Tûrshavnar Kommuna',
      ),
      2 => 
      array (
        'code' => 'KLA',
        'name' => 'Klaksvik에',
      ),
      3 => 
      array (
        'code' => 'RUN',
        'name' => 'Runavík',
      ),
      4 => 
      array (
        'code' => 'TVØ',
        'name' => 'Tvøroyri',
      ),
      5 => 
      array (
        'code' => 'FUG',
        'name' => 'Fuglafjørður',
      ),
      6 => 
      array (
        'code' => 'SUN',
        'name' => '순다 Kommuna',
      ),
      7 => 
      array (
        'code' => 'VáG',
        'name' => 'Vagur에',
      ),
      8 => 
      array (
        'code' => 'NES',
        'name' => '네스',
      ),
      9 => 
      array (
        'code' => 'VES',
        'name' => 'Vestmanna',
      ),
      10 => 
      array (
        'code' => 'MIð',
        'name' => 'Miðvágur',
      ),
      11 => 
      array (
        'code' => 'SØR',
        'name' => 'Sørvágur',
      ),
      12 => 
      array (
        'code' => 'GØT',
        'name' => '고투 Kommuna',
      ),
      13 => 
      array (
        'code' => 'SJû',
        'name' => 'Sjûvar Kommuna',
      ),
      14 => 
      array (
        'code' => 'LEI',
        'name' => 'Leirvik의',
      ),
      15 => 
      array (
        'code' => 'SAN',
        'name' => 'Sandavágur',
      ),
      16 => 
      array (
        'code' => 'HVA',
        'name' => 'Hvalba',
      ),
      17 => 
      array (
        'code' => 'EIð',
        'name' => 'Eiði',
      ),
      18 => 
      array (
        'code' => 'KVí',
        'name' => 'Kvívík',
      ),
      19 => 
      array (
        'code' => 'SAN',
        'name' => 'Sandur',
      ),
      20 => 
      array (
        'code' => 'SKO',
        'name' => 'Skopun',
      ),
      21 => 
      array (
        'code' => 'HVA',
        'name' => 'Hvannasund',
      ),
      22 => 
      array (
        'code' => 'SUM',
        'name' => '숨바',
      ),
      23 => 
      array (
        'code' => 'VIð',
        'name' => 'Viðareiði',
      ),
      24 => 
      array (
        'code' => 'POR',
        'name' => 'Porkeri',
      ),
      25 => 
      array (
        'code' => 'SKá',
        'name' => 'Skálavík',
      ),
      26 => 
      array (
        'code' => 'KUN',
        'name' => 'Kunoy',
      ),
      27 => 
      array (
        'code' => 'HÚS',
        'name' => '사비',
      ),
      28 => 
      array (
        'code' => 'HOV',
        'name' => 'HOV',
      ),
      29 => 
      array (
        'code' => 'FáM',
        'name' => 'Fámjin',
      ),
      30 => 
      array (
        'code' => 'FUN',
        'name' => 'Funningur',
      ),
      31 => 
      array (
        'code' => 'HÚS',
        'name' => 'HÚsar',
      ),
      32 => 
      array (
        'code' => 'SKÚ',
        'name' => 'SkÚvoy',
      ),
      33 => 
      array (
        'code' => 'SVí',
        'name' => 'Svínoy',
      ),
      34 => 
      array (
        'code' => 'FUG',
        'name' => 'Fugloy',
      ),
    ),
    'FR' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => '알자스',
      ),
      2 => 
      array (
        'code' => 'AQ',
        'name' => '아키텐',
      ),
      3 => 
      array (
        'code' => 'AU',
        'name' => '오베르 뉴',
      ),
      4 => 
      array (
        'code' => 'BR',
        'name' => '브리트니',
      ),
      5 => 
      array (
        'code' => 'BU',
        'name' => '부르고뉴',
      ),
      6 => 
      array (
        'code' => 'CE',
        'name' => '센터 루 아르 계곡',
      ),
      7 => 
      array (
        'code' => 'CH',
        'name' => '샴페인',
      ),
      8 => 
      array (
        'code' => 'CO',
        'name' => '코르',
      ),
      9 => 
      array (
        'code' => 'FR',
        'name' => '프랑스 콩트',
      ),
      10 => 
      array (
        'code' => 'LA',
        'name' => '랑그 독 루시 옹',
      ),
      11 => 
      array (
        'code' => 'LI',
        'name' => '리무 쟁',
      ),
      12 => 
      array (
        'code' => 'LO',
        'name' => '로렌',
      ),
      13 => 
      array (
        'code' => 'MI',
        'name' => '미디 피레네 산맥',
      ),
      14 => 
      array (
        'code' => 'NO',
        'name' => '노르 파 드 칼레',
      ),
      15 => 
      array (
        'code' => 'NR',
        'name' => '노르망디',
      ),
      16 => 
      array (
        'code' => 'PA',
        'name' => '파리 / 일 드 프랑스',
      ),
      17 => 
      array (
        'code' => 'PI',
        'name' => '피카르 디',
      ),
      18 => 
      array (
        'code' => 'PO',
        'name' => '푸 아투 샤 랑트',
      ),
      19 => 
      array (
        'code' => 'PR',
        'name' => '프로방스',
      ),
      20 => 
      array (
        'code' => 'RH',
        'name' => '론 알프스',
      ),
      21 => 
      array (
        'code' => 'RI',
        'name' => '리비에라',
      ),
      22 => 
      array (
        'code' => 'WE',
        'name' => '서부 루 아르 계곡',
      ),
    ),
    'FX' => 
    array (
      1 => 
      array (
        'code' => 'Et',
        'name' => '에토',
      ),
      2 => 
      array (
        'code' => '01',
        'name' => '아인',
      ),
      3 => 
      array (
        'code' => '02',
        'name' => 'Aisne의',
      ),
      4 => 
      array (
        'code' => '03',
        'name' => '알리',
      ),
      5 => 
      array (
        'code' => '04',
        'name' => '알프 드 오트 프로방스',
      ),
      6 => 
      array (
        'code' => '05',
        'name' => 'Hautes-Alpes에',
      ),
      7 => 
      array (
        'code' => '06',
        'name' => '알프 마리 팀',
      ),
      8 => 
      array (
        'code' => '07',
        'name' => '아르 데슈',
      ),
      9 => 
      array (
        'code' => '08',
        'name' => '아',
      ),
      10 => 
      array (
        'code' => '09',
        'name' => '아리',
      ),
      11 => 
      array (
        'code' => '10',
        'name' => '오브',
      ),
      12 => 
      array (
        'code' => '11',
        'name' => '오드',
      ),
      13 => 
      array (
        'code' => '12',
        'name' => '아베 롱',
      ),
      14 => 
      array (
        'code' => '13',
        'name' => '부슈 뒤 론',
      ),
      15 => 
      array (
        'code' => '14',
        'name' => '칼바도스',
      ),
      16 => 
      array (
        'code' => '15',
        'name' => '캉탈',
      ),
      17 => 
      array (
        'code' => '16',
        'name' => '샤 랑트',
      ),
      18 => 
      array (
        'code' => '17',
        'name' => '샤 랑트 마리 팀',
      ),
      19 => 
      array (
        'code' => '18',
        'name' => '쉐어',
      ),
      20 => 
      array (
        'code' => '19',
        'name' => '코 레즈',
      ),
      21 => 
      array (
        'code' => '2A',
        'name' => '코르 뒤 수드',
      ),
      22 => 
      array (
        'code' => '2B',
        'name' => '오트 코르',
      ),
      23 => 
      array (
        'code' => '21',
        'name' => '코트 디부 이상',
      ),
      24 => 
      array (
        'code' => '22',
        'name' => '코트 다르 갑옷',
      ),
      25 => 
      array (
        'code' => '23',
        'name' => '뢰즈',
      ),
      26 => 
      array (
        'code' => '24',
        'name' => '도르도 뉴',
      ),
      27 => 
      array (
        'code' => '25',
        'name' => '프랑 슈 콩테',
      ),
      28 => 
      array (
        'code' => '26',
        'name' => '드롬',
      ),
      29 => 
      array (
        'code' => '27',
        'name' => '외르',
      ),
      30 => 
      array (
        'code' => '28',
        'name' => '외르에 루 아르 등',
      ),
      31 => 
      array (
        'code' => '29',
        'name' => '피 니스 테레',
      ),
      32 => 
      array (
        'code' => '30',
        'name' => '가르',
      ),
      33 => 
      array (
        'code' => '31',
        'name' => '오트 가론',
      ),
      34 => 
      array (
        'code' => '32',
        'name' => '제르',
      ),
      35 => 
      array (
        'code' => '33',
        'name' => 'Gironde',
      ),
      36 => 
      array (
        'code' => '34',
        'name' => '에로',
      ),
      37 => 
      array (
        'code' => '35',
        'name' => 'ILLE 등 Vilaine의',
      ),
      38 => 
      array (
        'code' => '36',
        'name' => '앵 드르',
      ),
      39 => 
      array (
        'code' => '37',
        'name' => '앵 드르 등 루 아르',
      ),
      40 => 
      array (
        'code' => '38',
        'name' => '제르',
      ),
      41 => 
      array (
        'code' => '39',
        'name' => '쥐라',
      ),
      42 => 
      array (
        'code' => '40',
        'name' => '랜디스',
      ),
      43 => 
      array (
        'code' => '41',
        'name' => '루 아르에 셰르 등',
      ),
      44 => 
      array (
        'code' => '42',
        'name' => '루 아르',
      ),
      45 => 
      array (
        'code' => '43',
        'name' => '오트 루 아르',
      ),
      46 => 
      array (
        'code' => '44',
        'name' => '루 아르 아 틀랑',
      ),
      47 => 
      array (
        'code' => '45',
        'name' => '루아',
      ),
      48 => 
      array (
        'code' => '46',
        'name' => '로트',
      ),
      49 => 
      array (
        'code' => '47',
        'name' => '부지 등 가론',
      ),
      50 => 
      array (
        'code' => '48',
        'name' => '로제르',
      ),
      51 => 
      array (
        'code' => '49',
        'name' => '메인 등 루 아르',
      ),
      52 => 
      array (
        'code' => '50',
        'name' => '망슈',
      ),
      53 => 
      array (
        'code' => '51',
        'name' => '마른',
      ),
      54 => 
      array (
        'code' => '52',
        'name' => '오트 마른',
      ),
      55 => 
      array (
        'code' => '53',
        'name' => '마옌',
      ),
      56 => 
      array (
        'code' => '54',
        'name' => '뫼 르트에 모젤 등',
      ),
      57 => 
      array (
        'code' => '55',
        'name' => '뫼즈',
      ),
      58 => 
      array (
        'code' => '56',
        'name' => '모르 비앙',
      ),
      59 => 
      array (
        'code' => '57',
        'name' => '모젤',
      ),
      60 => 
      array (
        'code' => '58',
        'name' => '니에 브르',
      ),
      61 => 
      array (
        'code' => '59',
        'name' => '노르',
      ),
      62 => 
      array (
        'code' => '60',
        'name' => '우아즈',
      ),
      63 => 
      array (
        'code' => '61',
        'name' => '오른 느',
      ),
      64 => 
      array (
        'code' => '62',
        'name' => '파 드 칼레',
      ),
      65 => 
      array (
        'code' => '63',
        'name' => '퓌 드돔',
      ),
      66 => 
      array (
        'code' => '64',
        'name' => '피레네 틀랑',
      ),
      67 => 
      array (
        'code' => '65',
        'name' => '오트 피레네',
      ),
      68 => 
      array (
        'code' => '66',
        'name' => '피레네 오리엔탈',
      ),
      69 => 
      array (
        'code' => '67',
        'name' => 'BAS Rhin의',
      ),
      70 => 
      array (
        'code' => '68',
        'name' => '오 Rhin의',
      ),
      71 => 
      array (
        'code' => '69',
        'name' => '론',
      ),
      72 => 
      array (
        'code' => '70',
        'name' => '오트 쏜',
      ),
      73 => 
      array (
        'code' => '71',
        'name' => '쏜 루 아르 등',
      ),
      74 => 
      array (
        'code' => '72',
        'name' => '사 르트',
      ),
      75 => 
      array (
        'code' => '73',
        'name' => '사부',
      ),
      76 => 
      array (
        'code' => '74',
        'name' => '오트 사부 아',
      ),
      77 => 
      array (
        'code' => '75',
        'name' => '파리',
      ),
      78 => 
      array (
        'code' => '76',
        'name' => '센 Martitime',
      ),
      79 => 
      array (
        'code' => '77',
        'name' => '센에 마른 등',
      ),
      80 => 
      array (
        'code' => '78',
        'name' => '이블린',
      ),
      81 => 
      array (
        'code' => '79',
        'name' => '듀스 세브 르',
      ),
      82 => 
      array (
        'code' => '80',
        'name' => '솜',
      ),
      83 => 
      array (
        'code' => '81',
        'name' => '제비 갈매기',
      ),
      84 => 
      array (
        'code' => '82',
        'name' => '제비 갈매기 등 가론',
      ),
      85 => 
      array (
        'code' => '83',
        'name' => 'VAR',
      ),
      86 => 
      array (
        'code' => '84',
        'name' => 'Provence에',
      ),
      87 => 
      array (
        'code' => '85',
        'name' => '방데',
      ),
      88 => 
      array (
        'code' => '86',
        'name' => '비엔',
      ),
      89 => 
      array (
        'code' => '87',
        'name' => '오트 비엔',
      ),
      90 => 
      array (
        'code' => '88',
        'name' => '보주',
      ),
      91 => 
      array (
        'code' => '89',
        'name' => '욘',
      ),
      92 => 
      array (
        'code' => '90',
        'name' => '테리 투 드 벨 포르',
      ),
      93 => 
      array (
        'code' => '91',
        'name' => '에손',
      ),
      94 => 
      array (
        'code' => '92',
        'name' => '오 드 센느',
      ),
      95 => 
      array (
        'code' => '93',
        'name' => '센 생 드니',
      ),
      96 => 
      array (
        'code' => '94',
        'name' => '발 드 마른',
      ),
      97 => 
      array (
        'code' => '95',
        'name' => '발 디부 우아즈',
      ),
    ),
    'GA' => 
    array (
      1 => 
      array (
        'code' => 'ES',
        'name' => 'Estuaire의',
      ),
      2 => 
      array (
        'code' => 'HO',
        'name' => '오 -오고 우에',
      ),
      3 => 
      array (
        'code' => 'MO',
        'name' => '모옌오고 우에',
      ),
      4 => 
      array (
        'code' => 'NG',
        'name' => 'Ngounie',
      ),
      5 => 
      array (
        'code' => 'NY',
        'name' => 'Nyanga',
      ),
      6 => 
      array (
        'code' => 'OI',
        'name' => '오고 우에 Ivindo',
      ),
      7 => 
      array (
        'code' => 'OL',
        'name' => '오고 우에 롤로',
      ),
      8 => 
      array (
        'code' => 'OM',
        'name' => '오고 우에 해양',
      ),
      9 => 
      array (
        'code' => 'WN',
        'name' => '우 엘로 네템',
      ),
    ),
    'GB' => 
    array (
      1 => 
      array (
        'code' => 'ABN',
        'name' => '에버 딘',
      ),
      2 => 
      array (
        'code' => 'ABNS',
        'name' => '애버딘 셔 (주',
      ),
      3 => 
      array (
        'code' => 'ANG',
        'name' => '앵글',
      ),
      4 => 
      array (
        'code' => 'AGS',
        'name' => '앵거스',
      ),
      5 => 
      array (
        'code' => 'ARY',
        'name' => '아가일 뷰트',
      ),
      6 => 
      array (
        'code' => 'BEDS',
        'name' => '베드 퍼스 셔 (주',
      ),
      7 => 
      array (
        'code' => 'BERKS',
        'name' => '버크셔',
      ),
      8 => 
      array (
        'code' => 'BLA',
        'name' => 'Blaenau 그웬',
      ),
      9 => 
      array (
        'code' => 'BRI',
        'name' => '브리 젠드',
      ),
      10 => 
      array (
        'code' => 'BSTL',
        'name' => '브리스톨',
      ),
      11 => 
      array (
        'code' => 'BUCKS',
        'name' => '버킹엄',
      ),
      12 => 
      array (
        'code' => 'CAE',
        'name' => '필리',
      ),
      13 => 
      array (
        'code' => 'CAMBS',
        'name' => '캐임 브리지 셔 (주',
      ),
      14 => 
      array (
        'code' => 'CDF',
        'name' => '카디프',
      ),
      15 => 
      array (
        'code' => 'CARM',
        'name' => '카마 던',
      ),
      16 => 
      array (
        'code' => 'CDGN',
        'name' => 'Ceredigion에',
      ),
      17 => 
      array (
        'code' => 'CHES',
        'name' => '체셔',
      ),
      18 => 
      array (
        'code' => 'CLACK',
        'name' => '클랙',
      ),
      19 => 
      array (
        'code' => 'CON',
        'name' => '콘위',
      ),
      20 => 
      array (
        'code' => 'CORN',
        'name' => '콘월',
      ),
      21 => 
      array (
        'code' => 'DNBG',
        'name' => 'Denbighshire에',
      ),
      22 => 
      array (
        'code' => 'DERBY',
        'name' => '더비셔 (주',
      ),
      23 => 
      array (
        'code' => 'DVN',
        'name' => '데본',
      ),
      24 => 
      array (
        'code' => 'DOR',
        'name' => '도싯',
      ),
      25 => 
      array (
        'code' => 'DGL',
        'name' => '덤프리스 및 갤러웨이',
      ),
      26 => 
      array (
        'code' => 'DUND',
        'name' => '던디',
      ),
      27 => 
      array (
        'code' => 'DHM',
        'name' => '더럼',
      ),
      28 => 
      array (
        'code' => 'ARYE',
        'name' => '이스트 에어 셔',
      ),
      29 => 
      array (
        'code' => 'DUNBE',
        'name' => '이스트 몬드',
      ),
      30 => 
      array (
        'code' => 'LOTE',
        'name' => '이스트 로디 언',
      ),
      31 => 
      array (
        'code' => 'RENE',
        'name' => '이스트 렌프 류셔',
      ),
      32 => 
      array (
        'code' => 'ERYS',
        'name' => '이스트 라이딩 오브 요크셔 (주)',
      ),
      33 => 
      array (
        'code' => 'SXE',
        'name' => '동 서식 스 (주)',
      ),
      34 => 
      array (
        'code' => 'EDIN',
        'name' => '에딘버러',
      ),
      35 => 
      array (
        'code' => 'ESX',
        'name' => '식스',
      ),
      36 => 
      array (
        'code' => 'FALK',
        'name' => '폴 커크',
      ),
      37 => 
      array (
        'code' => 'FFE',
        'name' => '파이프',
      ),
      38 => 
      array (
        'code' => 'FLINT',
        'name' => '체셔',
      ),
      39 => 
      array (
        'code' => 'GLAS',
        'name' => '글래스고',
      ),
      40 => 
      array (
        'code' => 'GLOS',
        'name' => '글로스터',
      ),
      41 => 
      array (
        'code' => 'LDN',
        'name' => '그레이터 런던',
      ),
      42 => 
      array (
        'code' => 'MCH',
        'name' => '그레이트 맨체스터 (주)',
      ),
      43 => 
      array (
        'code' => 'GDD',
        'name' => 'Gwynedd의',
      ),
      44 => 
      array (
        'code' => 'HANTS',
        'name' => '햄프셔',
      ),
      45 => 
      array (
        'code' => 'HWR',
        'name' => '헤 리퍼 드셔 (주)',
      ),
      46 => 
      array (
        'code' => 'HERTS',
        'name' => '하트 퍼 드셔 (주)',
      ),
      47 => 
      array (
        'code' => 'HLD',
        'name' => '고원',
      ),
      48 => 
      array (
        'code' => 'IVER',
        'name' => '인 버클 라이드',
      ),
      49 => 
      array (
        'code' => 'IOW',
        'name' => '와이트 섬 (주)',
      ),
      50 => 
      array (
        'code' => 'KNT',
        'name' => '켄트',
      ),
      51 => 
      array (
        'code' => 'LANCS',
        'name' => '랭커 셔 (주)',
      ),
      52 => 
      array (
        'code' => 'LEICS',
        'name' => '레스터 셔 (주)',
      ),
      53 => 
      array (
        'code' => 'LINCS',
        'name' => '링컨',
      ),
      54 => 
      array (
        'code' => 'MSY',
        'name' => '머지 사이드',
      ),
      55 => 
      array (
        'code' => 'MERT',
        'name' => '머 티르 티드 필',
      ),
      56 => 
      array (
        'code' => 'MLOT',
        'name' => '미들 로디 언',
      ),
      57 => 
      array (
        'code' => 'MMOUTH',
        'name' => '남부에',
      ),
      58 => 
      array (
        'code' => 'MORAY',
        'name' => '모레',
      ),
      59 => 
      array (
        'code' => 'NPRTAL',
        'name' => '니스 포트 탤벗',
      ),
      60 => 
      array (
        'code' => 'NEWPT',
        'name' => '뉴 포트',
      ),
      61 => 
      array (
        'code' => 'NOR',
        'name' => '노퍽',
      ),
      62 => 
      array (
        'code' => 'ARYN',
        'name' => '노스 에어 셔',
      ),
      63 => 
      array (
        'code' => 'LANN',
        'name' => '노스라나 크셔',
      ),
      64 => 
      array (
        'code' => 'YSN',
        'name' => '노스 요크셔',
      ),
      65 => 
      array (
        'code' => 'NHM',
        'name' => '노 샘프 턴',
      ),
      66 => 
      array (
        'code' => 'NLD',
        'name' => '노섬벌 랜드 (주)',
      ),
      67 => 
      array (
        'code' => 'NOT',
        'name' => '노팅엄',
      ),
      68 => 
      array (
        'code' => 'ORK',
        'name' => '오크 니 제도',
      ),
      69 => 
      array (
        'code' => 'OFE',
        'name' => '옥스퍼드 셔 (주)',
      ),
      70 => 
      array (
        'code' => 'PEM',
        'name' => '펨 브룩 셔 연안 국립 공원',
      ),
      71 => 
      array (
        'code' => 'PERTH',
        'name' => '퍼스 및 킨 로스',
      ),
      72 => 
      array (
        'code' => 'PWS',
        'name' => 'Powys의',
      ),
      73 => 
      array (
        'code' => 'REN',
        'name' => '렌프 류셔',
      ),
      74 => 
      array (
        'code' => 'RHON',
        'name' => '론다 Cynon 타프',
      ),
      75 => 
      array (
        'code' => 'RUT',
        'name' => '러틀 랜드',
      ),
      76 => 
      array (
        'code' => 'BOR',
        'name' => '스코틀랜드 국경',
      ),
      77 => 
      array (
        'code' => 'SHET',
        'name' => '셰틀 랜드 제도',
      ),
      78 => 
      array (
        'code' => 'SPE',
        'name' => '슈 롭셔 (주)',
      ),
      79 => 
      array (
        'code' => 'SOM',
        'name' => '서머셋',
      ),
      80 => 
      array (
        'code' => 'ARYS',
        'name' => '에어 셔',
      ),
      81 => 
      array (
        'code' => 'LANS',
        'name' => '사우스라나 크셔',
      ),
      82 => 
      array (
        'code' => 'YSS',
        'name' => '사우스 요크셔 (주)',
      ),
      83 => 
      array (
        'code' => 'SFD',
        'name' => '스 태퍼 드셔 (주)',
      ),
      84 => 
      array (
        'code' => 'STIR',
        'name' => '스털링',
      ),
      85 => 
      array (
        'code' => 'SFK',
        'name' => '서퍽',
      ),
      86 => 
      array (
        'code' => 'SRY',
        'name' => '서리',
      ),
      87 => 
      array (
        'code' => 'SWAN',
        'name' => '스완 지',
      ),
      88 => 
      array (
        'code' => 'TORF',
        'name' => 'Torfaen의',
      ),
      89 => 
      array (
        'code' => 'TWR',
        'name' => '타인 위어 (주)',
      ),
      90 => 
      array (
        'code' => 'VGLAM',
        'name' => '글러 모건의 베일',
      ),
      91 => 
      array (
        'code' => 'WARKS',
        'name' => '워릭 셔 (주)',
      ),
      92 => 
      array (
        'code' => 'WDUN',
        'name' => '몬드',
      ),
      93 => 
      array (
        'code' => 'WLOT',
        'name' => '웨스트 로디 언',
      ),
      94 => 
      array (
        'code' => 'WMD',
        'name' => '웨스트 미들 랜즈 (주)',
      ),
      95 => 
      array (
        'code' => 'SXW',
        'name' => '웨스트 서식 스',
      ),
      96 => 
      array (
        'code' => 'YSW',
        'name' => '웨스트 요크셔 (주)',
      ),
      97 => 
      array (
        'code' => 'WIL',
        'name' => '서쪽 섬',
      ),
      98 => 
      array (
        'code' => 'WLT',
        'name' => '윌트 셔',
      ),
      99 => 
      array (
        'code' => 'WORCS',
        'name' => '우스터 셔 (주)',
      ),
      100 => 
      array (
        'code' => 'WRX',
        'name' => '렉섬',
      ),
    ),
    'GE' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => '압하 지아',
      ),
      2 => 
      array (
        'code' => 'AJ',
        'name' => 'Ajaria',
      ),
      3 => 
      array (
        'code' => 'GU',
        'name' => '구리 아',
      ),
      4 => 
      array (
        'code' => 'IM',
        'name' => '이메 레티',
      ),
      5 => 
      array (
        'code' => 'KA',
        'name' => '카 케티',
      ),
      6 => 
      array (
        'code' => 'KK',
        'name' => 'Kvemo 카르 틀리',
      ),
      7 => 
      array (
        'code' => 'MM',
        'name' => '헤타-Mtianeti',
      ),
      8 => 
      array (
        'code' => 'RL',
        'name' => '라차 ​​Lechkhumi 및 Kvemo Svanet',
      ),
      9 => 
      array (
        'code' => 'SJ',
        'name' => 'Samtskhe-Javakheti',
      ),
      10 => 
      array (
        'code' => 'SK',
        'name' => '시다 카르 틀리',
      ),
      11 => 
      array (
        'code' => 'SZ',
        'name' => '사 메그 렐 - 제모 Svaneti의',
      ),
      12 => 
      array (
        'code' => 'TB',
        'name' => '트빌리시',
      ),
    ),
    'GF' => 
    array (
      1 => 
      array (
        'code' => 'AWA',
        'name' => 'Awala-Yalimapo',
      ),
      2 => 
      array (
        'code' => 'MAN',
        'name' => '마나',
      ),
      3 => 
      array (
        'code' => 'SAI',
        'name' => '생 로랑 뒤 마로 니',
      ),
      4 => 
      array (
        'code' => 'APA',
        'name' => 'Apatou',
      ),
      5 => 
      array (
        'code' => 'GRA',
        'name' => '그랜드 산티',
      ),
      6 => 
      array (
        'code' => 'PAP',
        'name' => 'Papaïchton',
      ),
      7 => 
      array (
        'code' => 'SAÜ',
        'name' => '사울',
      ),
      8 => 
      array (
        'code' => 'MAR',
        'name' => 'Maripasoula',
      ),
      9 => 
      array (
        'code' => 'CAM',
        'name' => 'Camopi',
      ),
      10 => 
      array (
        'code' => 'SAI',
        'name' => '세인트 조지',
      ),
      11 => 
      array (
        'code' => 'OUA',
        'name' => 'Ouanary',
      ),
      12 => 
      array (
        'code' => 'RéG',
        'name' => '레지나',
      ),
      13 => 
      array (
        'code' => 'ROU',
        'name' => 'Roura',
      ),
      14 => 
      array (
        'code' => 'SAI',
        'name' => '생 엘리',
      ),
      15 => 
      array (
        'code' => 'IRA',
        'name' => 'Iracoubo',
      ),
      16 => 
      array (
        'code' => 'SIN',
        'name' => 'Sinnamary',
      ),
      17 => 
      array (
        'code' => 'KOU',
        'name' => '쿠루',
      ),
      18 => 
      array (
        'code' => 'MAC',
        'name' => 'Macouria',
      ),
      19 => 
      array (
        'code' => 'MON',
        'name' => 'Montsinéry-Tonnegrande',
      ),
      20 => 
      array (
        'code' => 'MAT',
        'name' => 'Matoury에서',
      ),
      21 => 
      array (
        'code' => 'CAY',
        'name' => '카이엔',
      ),
      22 => 
      array (
        'code' => 'REM',
        'name' => '레 미르 - 몽 졸리',
      ),
    ),
    'GH' => 
    array (
      1 => 
      array (
        'code' => 'AS',
        'name' => '아샨티 지역',
      ),
      2 => 
      array (
        'code' => 'BA',
        'name' => '브롱 아하 포 지역',
      ),
      3 => 
      array (
        'code' => 'CE',
        'name' => '중부',
      ),
      4 => 
      array (
        'code' => 'EA',
        'name' => '동부 지역',
      ),
      5 => 
      array (
        'code' => 'GA',
        'name' => '그레이터 아크라 지역',
      ),
      6 => 
      array (
        'code' => 'NO',
        'name' => '북부 지역',
      ),
      7 => 
      array (
        'code' => 'UE',
        'name' => '어퍼 이스트 지역',
      ),
      8 => 
      array (
        'code' => 'UW',
        'name' => '어퍼 웨스트 지역',
      ),
      9 => 
      array (
        'code' => 'VO',
        'name' => '볼타 지역',
      ),
      10 => 
      array (
        'code' => 'WE',
        'name' => '서부 지역',
      ),
    ),
    'GI' => 
    array (
      1 => 
      array (
        'code' => 'EAS',
        'name' => '이스트 사이드',
      ),
      2 => 
      array (
        'code' => 'NOR',
        'name' => '북쪽 지구',
      ),
      3 => 
      array (
        'code' => 'REC',
        'name' => '교정 분야',
      ),
      4 => 
      array (
        'code' => 'SAN',
        'name' => 'Sandpits 지역',
      ),
      5 => 
      array (
        'code' => 'SOU',
        'name' => '남부 지구',
      ),
      6 => 
      array (
        'code' => 'TOW',
        'name' => '타운 지역',
      ),
      7 => 
      array (
        'code' => 'UPP',
        'name' => '어퍼 타운',
      ),
      8 => 
      array (
        'code' => 'OTH',
        'name' => '기타',
      ),
    ),
    'GL' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Avannaa',
      ),
      2 => 
      array (
        'code' => 'T',
        'name' => 'Tunu',
      ),
      3 => 
      array (
        'code' => 'K',
        'name' => 'Kitaa',
      ),
    ),
    'GM' => 
    array (
      1 => 
      array (
        'code' => 'BJ',
        'name' => '반줄',
      ),
      2 => 
      array (
        'code' => 'BS',
        'name' => '바스',
      ),
      3 => 
      array (
        'code' => 'BR',
        'name' => 'Brikama',
      ),
      4 => 
      array (
        'code' => 'JA',
        'name' => 'Janjangbure',
      ),
      5 => 
      array (
        'code' => 'KA',
        'name' => 'Kanifeng',
      ),
      6 => 
      array (
        'code' => 'KE',
        'name' => 'Kerewan',
      ),
      7 => 
      array (
        'code' => 'KU',
        'name' => 'Kuntaur',
      ),
      8 => 
      array (
        'code' => 'MA',
        'name' => 'Mansakonko',
      ),
      9 => 
      array (
        'code' => 'LR',
        'name' => '낮은 강',
      ),
      10 => 
      array (
        'code' => 'CR',
        'name' => '중앙 강',
      ),
      11 => 
      array (
        'code' => 'NB',
        'name' => '북쪽 은행',
      ),
      12 => 
      array (
        'code' => 'UR',
        'name' => '어퍼 강',
      ),
      13 => 
      array (
        'code' => 'WE',
        'name' => '서양',
      ),
    ),
    'GN' => 
    array (
      1 => 
      array (
        'code' => 'CNK',
        'name' => '코나 크리',
      ),
      2 => 
      array (
        'code' => 'BYL',
        'name' => 'Beyla',
      ),
      3 => 
      array (
        'code' => 'BFA',
        'name' => 'Boffa',
      ),
      4 => 
      array (
        'code' => 'BOK',
        'name' => '보케',
      ),
      5 => 
      array (
        'code' => 'COY',
        'name' => 'Coyah',
      ),
      6 => 
      array (
        'code' => 'DBL',
        'name' => 'Dabola',
      ),
      7 => 
      array (
        'code' => 'DLB',
        'name' => 'Dalaba',
      ),
      8 => 
      array (
        'code' => 'DGR',
        'name' => 'Dinguiraye',
      ),
      9 => 
      array (
        'code' => 'DBR',
        'name' => 'Dubreka',
      ),
      10 => 
      array (
        'code' => 'FRN',
        'name' => 'Faranah',
      ),
      11 => 
      array (
        'code' => 'FRC',
        'name' => 'Forecariah',
      ),
      12 => 
      array (
        'code' => 'FRI',
        'name' => '프리아',
      ),
      13 => 
      array (
        'code' => 'GAO',
        'name' => 'Gaoual',
      ),
      14 => 
      array (
        'code' => 'GCD',
        'name' => 'Gueckedou',
      ),
      15 => 
      array (
        'code' => 'KNK',
        'name' => '캉캉',
      ),
      16 => 
      array (
        'code' => 'KRN',
        'name' => 'Kerouane',
      ),
      17 => 
      array (
        'code' => 'KND',
        'name' => 'Kindia',
      ),
      18 => 
      array (
        'code' => 'KSD',
        'name' => '키시 두구',
      ),
      19 => 
      array (
        'code' => 'KBA',
        'name' => 'Koubia',
      ),
      20 => 
      array (
        'code' => 'KDA',
        'name' => 'Koundara',
      ),
      21 => 
      array (
        'code' => 'KRA',
        'name' => 'Kouroussa',
      ),
      22 => 
      array (
        'code' => 'LAB',
        'name' => '라베',
      ),
      23 => 
      array (
        'code' => 'LLM',
        'name' => 'Lelouma',
      ),
      24 => 
      array (
        'code' => 'LOL',
        'name' => '롤라',
      ),
      25 => 
      array (
        'code' => 'MCT',
        'name' => 'Macenta',
      ),
      26 => 
      array (
        'code' => 'MAL',
        'name' => '말리',
      ),
      27 => 
      array (
        'code' => 'MAM',
        'name' => 'Mamou에서',
      ),
      28 => 
      array (
        'code' => 'MAN',
        'name' => 'Mandiana',
      ),
      29 => 
      array (
        'code' => 'NZR',
        'name' => 'Nzerekore 발',
      ),
      30 => 
      array (
        'code' => 'PIT',
        'name' => '피타',
      ),
      31 => 
      array (
        'code' => 'SIG',
        'name' => 'Siguiri',
      ),
      32 => 
      array (
        'code' => 'TLM',
        'name' => 'Telimele',
      ),
      33 => 
      array (
        'code' => 'TOG',
        'name' => '의 tougue',
      ),
      34 => 
      array (
        'code' => 'YOM',
        'name' => 'Yomou',
      ),
    ),
    'GP' => 
    array (
      1 => 
      array (
        'code' => 'ARR',
        'name' => 'guadeloup 팀의 Arrondissements',
      ),
      2 => 
      array (
        'code' => 'CAN',
        'name' => 'guadeloup의 출발의 캔톤',
      ),
      3 => 
      array (
        'code' => 'COM',
        'name' => 'guadeloup의 출발의 코뮌',
      ),
    ),
    'GQ' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => '프로 방 Annobon',
      ),
      2 => 
      array (
        'code' => 'BN',
        'name' => '프로 방 오코 노르 테',
      ),
      3 => 
      array (
        'code' => 'BS',
        'name' => '프로 방 오코 서',
      ),
      4 => 
      array (
        'code' => 'CS',
        'name' => '프로 방 센트로 서',
      ),
      5 => 
      array (
        'code' => 'KN',
        'name' => '프로 방 KIE 네템',
      ),
      6 => 
      array (
        'code' => 'LI',
        'name' => '프로 방 리토 랄',
      ),
      7 => 
      array (
        'code' => 'WN',
        'name' => '프로 방 Wele-Nzas',
      ),
    ),
    'GR' => 
    array (
      1 => 
      array (
        'code' => 'AT',
        'name' => '아티',
      ),
      2 => 
      array (
        'code' => 'CN',
        'name' => '센트럴 그리스',
      ),
      3 => 
      array (
        'code' => 'CM',
        'name' => '중부 마케도니아',
      ),
      4 => 
      array (
        'code' => 'CR',
        'name' => '크레타',
      ),
      5 => 
      array (
        'code' => 'EM',
        'name' => '동부 마케도니아와 트라',
      ),
      6 => 
      array (
        'code' => 'EP',
        'name' => '이피',
      ),
      7 => 
      array (
        'code' => 'II',
        'name' => '이오니아 제도',
      ),
      8 => 
      array (
        'code' => 'NA',
        'name' => '노스 해',
      ),
      9 => 
      array (
        'code' => 'PP',
        'name' => 'Peloponnesos',
      ),
      10 => 
      array (
        'code' => 'SA',
        'name' => '사우스 해',
      ),
      11 => 
      array (
        'code' => 'TH',
        'name' => '테살',
      ),
      12 => 
      array (
        'code' => 'WG',
        'name' => '웨스트 그리스',
      ),
      13 => 
      array (
        'code' => 'WM',
        'name' => '웨스트 마케도니아',
      ),
    ),
    'GT' => 
    array (
      1 => 
      array (
        'code' => 'AV',
        'name' => '알타 베라 파스',
      ),
      2 => 
      array (
        'code' => 'BV',
        'name' => '바하 베라 파스',
      ),
      3 => 
      array (
        'code' => 'CM',
        'name' => 'Chimaltenango',
      ),
      4 => 
      array (
        'code' => 'CQ',
        'name' => '치키 물라',
      ),
      5 => 
      array (
        'code' => 'PE',
        'name' => '엘 페텐',
      ),
      6 => 
      array (
        'code' => 'PR',
        'name' => '엘 프로 그레',
      ),
      7 => 
      array (
        'code' => 'QC',
        'name' => '엘 파이',
      ),
      8 => 
      array (
        'code' => 'ES',
        'name' => '에스 쿠 인 틀라',
      ),
      9 => 
      array (
        'code' => 'GU',
        'name' => '과테말라',
      ),
      10 => 
      array (
        'code' => 'HU',
        'name' => '우에 우에 테 낭고',
      ),
      11 => 
      array (
        'code' => 'IZ',
        'name' => 'Izabal에서',
      ),
      12 => 
      array (
        'code' => 'JA',
        'name' => '파',
      ),
      13 => 
      array (
        'code' => 'JU',
        'name' => 'Jutiapa',
      ),
      14 => 
      array (
        'code' => 'QZ',
        'name' => 'Quetzaltenango에서',
      ),
      15 => 
      array (
        'code' => 'RE',
        'name' => 'Retalhuleu의',
      ),
      16 => 
      array (
        'code' => 'ST',
        'name' => 'Sacatepequez',
      ),
      17 => 
      array (
        'code' => 'SM',
        'name' => '산 마르코스',
      ),
      18 => 
      array (
        'code' => 'SR',
        'name' => '산타 로사',
      ),
      19 => 
      array (
        'code' => 'SO',
        'name' => 'Solola의',
      ),
      20 => 
      array (
        'code' => 'SU',
        'name' => 'Suchitepequez',
      ),
      21 => 
      array (
        'code' => 'TO',
        'name' => 'Totonicapan',
      ),
      22 => 
      array (
        'code' => 'ZA',
        'name' => 'Zacapa',
      ),
    ),
    'GU' => 
    array (
      1 => 
      array (
        'code' => 'AGA',
        'name' => '아가나 하이츠',
      ),
      2 => 
      array (
        'code' => 'AGA',
        'name' => '아가트',
      ),
      3 => 
      array (
        'code' => 'ASA',
        'name' => '아산 Maina',
      ),
      4 => 
      array (
        'code' => 'BAR',
        'name' => '바리 가다',
      ),
      5 => 
      array (
        'code' => 'CHA',
        'name' => '찰란 파고 Ordot',
      ),
      6 => 
      array (
        'code' => 'DED',
        'name' => '데데',
      ),
      7 => 
      array (
        'code' => 'HAG',
        'name' => '하갓냐',
      ),
      8 => 
      array (
        'code' => 'INA',
        'name' => 'Inarajan',
      ),
      9 => 
      array (
        'code' => 'MAN',
        'name' => 'Mangilao',
      ),
      10 => 
      array (
        'code' => 'MER',
        'name' => 'Merizo',
      ),
      11 => 
      array (
        'code' => 'MON',
        'name' => 'Mongmong 토토 MAITE',
      ),
      12 => 
      array (
        'code' => 'PIT',
        'name' => '피티',
      ),
      13 => 
      array (
        'code' => 'SAN',
        'name' => '산타 리타',
      ),
      14 => 
      array (
        'code' => 'SIN',
        'name' => 'Sinajana',
      ),
      15 => 
      array (
        'code' => 'TAL',
        'name' => 'Talofofo의',
      ),
      16 => 
      array (
        'code' => 'TAM',
        'name' => '타무 닝',
      ),
      17 => 
      array (
        'code' => 'UMA',
        'name' => 'Umatac',
      ),
      18 => 
      array (
        'code' => 'YIG',
        'name' => 'Yigo',
      ),
      19 => 
      array (
        'code' => 'YON',
        'name' => '요나',
      ),
    ),
    'GW' => 
    array (
      1 => 
      array (
        'code' => 'BF',
        'name' => 'Bafata 지역',
      ),
      2 => 
      array (
        'code' => 'BB',
        'name' => 'Biombo 지역',
      ),
      3 => 
      array (
        'code' => 'BS',
        'name' => '비사우 지역',
      ),
      4 => 
      array (
        'code' => 'BL',
        'name' => 'Bolama 지역',
      ),
      5 => 
      array (
        'code' => 'CA',
        'name' => '체우 지역',
      ),
      6 => 
      array (
        'code' => 'GA',
        'name' => 'Gabu 지역',
      ),
      7 => 
      array (
        'code' => 'OI',
        'name' => 'OIO 지역',
      ),
      8 => 
      array (
        'code' => 'QU',
        'name' => 'Quinara 지역',
      ),
      9 => 
      array (
        'code' => 'TO',
        'name' => 'Tombali 지역',
      ),
    ),
    'GY' => 
    array (
      1 => 
      array (
        'code' => 'BW',
        'name' => '바리 마와 이니-',
      ),
      2 => 
      array (
        'code' => 'CM',
        'name' => 'Cuyuni-Mazaruni',
      ),
      3 => 
      array (
        'code' => 'DM',
        'name' => '데메 라라 - 하이카',
      ),
      4 => 
      array (
        'code' => 'EC',
        'name' => '동 Berbice-Corentyne',
      ),
      5 => 
      array (
        'code' => 'EW',
        'name' => 'Essequibo 제도 - 웨스트 데메 라라',
      ),
      6 => 
      array (
        'code' => 'MB',
        'name' => '하이카-Berbice',
      ),
      7 => 
      array (
        'code' => 'PM',
        'name' => 'Pomeroon-Supenaam',
      ),
      8 => 
      array (
        'code' => 'PI',
        'name' => 'Potaro-Siparuni',
      ),
      9 => 
      array (
        'code' => 'UD',
        'name' => '어퍼 데메 라라 - Berbice',
      ),
      10 => 
      array (
        'code' => 'UT',
        'name' => '어퍼 Takutu - 어퍼 Essequibo',
      ),
    ),
    'HK' => 
    array (
      1 => 
      array (
        'code' => 'HCW',
        'name' => '중앙 및 서부 홍콩이다',
      ),
      2 => 
      array (
        'code' => 'HEA',
        'name' => '동부 홍콩 섬',
      ),
      3 => 
      array (
        'code' => 'HSO',
        'name' => '남부 홍콩 섬',
      ),
      4 => 
      array (
        'code' => 'HWC',
        'name' => '완차이 홍콩 섬',
      ),
      5 => 
      array (
        'code' => 'KKC',
        'name' => '구룡시 구룡',
      ),
      6 => 
      array (
        'code' => 'KKT',
        'name' => 'Kwun의 통 구룡',
      ),
      7 => 
      array (
        'code' => 'KSS',
        'name' => '삼수 포 구룡',
      ),
      8 => 
      array (
        'code' => 'KWT',
        'name' => '웡 타이 신 구룡',
      ),
      9 => 
      array (
        'code' => 'KYT',
        'name' => '침몽 구룡',
      ),
      10 => 
      array (
        'code' => 'NIS',
        'name' => '제도 신계',
      ),
      11 => 
      array (
        'code' => 'NKT',
        'name' => '콰이 칭 신계',
      ),
      12 => 
      array (
        'code' => 'NNO',
        'name' => '북한 신계',
      ),
      13 => 
      array (
        'code' => 'NSK',
        'name' => '사이 쿵 신계',
      ),
      14 => 
      array (
        'code' => 'NST',
        'name' => '샤틴 신계',
      ),
      15 => 
      array (
        'code' => 'NTP',
        'name' => '타이포 신계',
      ),
      16 => 
      array (
        'code' => 'NTW',
        'name' => '추엔 완 신계',
      ),
      17 => 
      array (
        'code' => 'NTM',
        'name' => '투엔 문 신계',
      ),
      18 => 
      array (
        'code' => 'NYL',
        'name' => '유엔 롱 신계',
      ),
    ),
    'HM' => 
    array (
      1 => 
      array (
        'code' => 'F',
        'name' => '플랫 섬',
      ),
      2 => 
      array (
        'code' => 'M',
        'name' => '맥도날드 섬',
      ),
      3 => 
      array (
        'code' => 'S',
        'name' => '아일랜드 그거는',
      ),
      4 => 
      array (
        'code' => 'H',
        'name' => '허드',
      ),
    ),
    'HN' => 
    array (
      1 => 
      array (
        'code' => 'AT',
        'name' => '아틀란',
      ),
      2 => 
      array (
        'code' => 'CH',
        'name' => 'Choluteca',
      ),
      3 => 
      array (
        'code' => 'CL',
        'name' => '콜론',
      ),
      4 => 
      array (
        'code' => 'CM',
        'name' => '코 마야과',
      ),
      5 => 
      array (
        'code' => 'CP',
        'name' => '코판',
      ),
      6 => 
      array (
        'code' => 'CR',
        'name' => '코르테스',
      ),
      7 => 
      array (
        'code' => 'PA',
        'name' => '엘 파라 이소',
      ),
      8 => 
      array (
        'code' => 'FM',
        'name' => '시스코 모라 잔',
      ),
      9 => 
      array (
        'code' => 'GD',
        'name' => '그라시아 디오스',
      ),
      10 => 
      array (
        'code' => 'IN',
        'name' => 'Intibuca',
      ),
      11 => 
      array (
        'code' => 'IB',
        'name' => '이슬 라스 데 라 바이아 (베이 제도',
      ),
      12 => 
      array (
        'code' => 'PZ',
        'name' => '라 파스',
      ),
      13 => 
      array (
        'code' => 'LE',
        'name' => '렘 피라',
      ),
      14 => 
      array (
        'code' => 'OC',
        'name' => 'Ocotepeque',
      ),
      15 => 
      array (
        'code' => 'OL',
        'name' => 'Olancho',
      ),
      16 => 
      array (
        'code' => 'SB',
        'name' => '산타 바바라',
      ),
      17 => 
      array (
        'code' => 'VA',
        'name' => '발레',
      ),
      18 => 
      array (
        'code' => 'YO',
        'name' => '요로',
      ),
    ),
    'HR' => 
    array (
      1 => 
      array (
        'code' => 'BB',
        'name' => 'Bjelovar에서-Bilogora',
      ),
      2 => 
      array (
        'code' => 'CZ',
        'name' => '자그레브의 도시',
      ),
      3 => 
      array (
        'code' => 'DN',
        'name' => '두브 로브 니크 - 네 레트 바',
      ),
      4 => 
      array (
        'code' => 'IS',
        'name' => '이스트 라',
      ),
      5 => 
      array (
        'code' => 'KA',
        'name' => '카를로',
      ),
      6 => 
      array (
        'code' => 'KK',
        'name' => '브니-Krizevci',
      ),
      7 => 
      array (
        'code' => 'KZ',
        'name' => 'Krapina-Zagorje',
      ),
      8 => 
      array (
        'code' => 'LS',
        'name' => '리카 - 세니',
      ),
      9 => 
      array (
        'code' => 'ME',
        'name' => 'Medimurje',
      ),
      10 => 
      array (
        'code' => 'OB',
        'name' => '오시 예크-Baranja',
      ),
      11 => 
      array (
        'code' => 'PS',
        'name' => '포제 - 슬라 보니아',
      ),
      12 => 
      array (
        'code' => 'PG',
        'name' => 'Primorje-Gorski Kotar',
      ),
      13 => 
      array (
        'code' => 'SI',
        'name' => '시 베니 크',
      ),
      14 => 
      array (
        'code' => 'SM',
        'name' => '시사 - Moslavina',
      ),
      15 => 
      array (
        'code' => 'SB',
        'name' => '슬라 본 스키 브로드 - 사비나',
      ),
      16 => 
      array (
        'code' => 'SD',
        'name' => '스플릿 - 달마 티아',
      ),
      17 => 
      array (
        'code' => 'VA',
        'name' => 'Varazdin에서',
      ),
      18 => 
      array (
        'code' => 'VP',
        'name' => 'Virovitica-Podravina',
      ),
      19 => 
      array (
        'code' => 'VS',
        'name' => '부카 보르 - Srijem',
      ),
      20 => 
      array (
        'code' => 'ZK',
        'name' => '자 다르 - 크닌',
      ),
      21 => 
      array (
        'code' => 'ZA',
        'name' => '자그레브',
      ),
    ),
    'HT' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => 'Artibonite',
      ),
      2 => 
      array (
        'code' => 'CE',
        'name' => '센터',
      ),
      3 => 
      array (
        'code' => 'GA',
        'name' => 'Grand Anse',
      ),
      4 => 
      array (
        'code' => 'ND',
        'name' => '노르',
      ),
      5 => 
      array (
        'code' => 'NE',
        'name' => '노르 추정치',
      ),
      6 => 
      array (
        'code' => 'NO',
        'name' => '노르 우에 스트',
      ),
      7 => 
      array (
        'code' => 'OU',
        'name' => '우에 스트',
      ),
      8 => 
      array (
        'code' => 'SD',
        'name' => '쉬',
      ),
      9 => 
      array (
        'code' => 'SE',
        'name' => '쉬 - 동부 표준시',
      ),
    ),
    'HU' => 
    array (
      1 => 
      array (
        'code' => 'BK',
        'name' => '바치 키슈 쿤',
      ),
      2 => 
      array (
        'code' => 'BA',
        'name' => '버러 녀',
      ),
      3 => 
      array (
        'code' => 'BE',
        'name' => 'Bekes',
      ),
      4 => 
      array (
        'code' => 'BS',
        'name' => '베 케슈 처버',
      ),
      5 => 
      array (
        'code' => 'BZ',
        'name' => 'Borsod-Abauj-Zemplen',
      ),
      6 => 
      array (
        'code' => 'BU',
        'name' => '부다페스트',
      ),
      7 => 
      array (
        'code' => 'CS',
        'name' => '촌 그라드',
      ),
      8 => 
      array (
        'code' => 'DE',
        'name' => '데브 레첸',
      ),
      9 => 
      array (
        'code' => 'DU',
        'name' => 'Dunaujvaros',
      ),
      10 => 
      array (
        'code' => 'EG',
        'name' => '르',
      ),
      11 => 
      array (
        'code' => 'FE',
        'name' => '페 예르',
      ),
      12 => 
      array (
        'code' => 'GY',
        'name' => '기 오르',
      ),
      13 => 
      array (
        'code' => 'GM',
        'name' => '기 오르 - Moson - 소프론',
      ),
      14 => 
      array (
        'code' => 'HB',
        'name' => 'Hajdu - 비하르',
      ),
      15 => 
      array (
        'code' => 'HE',
        'name' => '헤베',
      ),
      16 => 
      array (
        'code' => 'HO',
        'name' => '호드 메죄 바샤 르 헤이',
      ),
      17 => 
      array (
        'code' => 'JN',
        'name' => 'Jasz - 쿤 - 솔 노크',
      ),
      18 => 
      array (
        'code' => 'KA',
        'name' => 'Kaposvar에서',
      ),
      19 => 
      array (
        'code' => 'KE',
        'name' => '케 치케 메트',
      ),
      20 => 
      array (
        'code' => 'KO',
        'name' => '코마 롬 - 에스테르 곰',
      ),
      21 => 
      array (
        'code' => 'MI',
        'name' => '미슈 콜츠',
      ),
      22 => 
      array (
        'code' => 'NA',
        'name' => '나지 카니 자',
      ),
      23 => 
      array (
        'code' => 'NO',
        'name' => '노 그라드',
      ),
      24 => 
      array (
        'code' => 'NY',
        'name' => '니 레기하자',
      ),
      25 => 
      array (
        'code' => 'PE',
        'name' => '펙스',
      ),
      26 => 
      array (
        'code' => 'PS',
        'name' => '해충',
      ),
      27 => 
      array (
        'code' => 'SO',
        'name' => '소 모기',
      ),
      28 => 
      array (
        'code' => 'SP',
        'name' => '쇼 프론',
      ),
      29 => 
      array (
        'code' => 'SS',
        'name' => '의 Szabolcs-Szatmar-Bereg에서',
      ),
      30 => 
      array (
        'code' => 'SZ',
        'name' => '세게 드',
      ),
      31 => 
      array (
        'code' => 'SE',
        'name' => '세케 슈페 헤르 바르',
      ),
      32 => 
      array (
        'code' => 'SL',
        'name' => '솔 노크',
      ),
      33 => 
      array (
        'code' => 'SM',
        'name' => '솜 버트 헤이',
      ),
      34 => 
      array (
        'code' => 'TA',
        'name' => '타타 반야',
      ),
      35 => 
      array (
        'code' => 'TO',
        'name' => '톨너',
      ),
      36 => 
      array (
        'code' => 'VA',
        'name' => 'VAS',
      ),
      37 => 
      array (
        'code' => 'VE',
        'name' => '베스 프렘',
      ),
      38 => 
      array (
        'code' => 'ZA',
        'name' => '더 잘라',
      ),
      39 => 
      array (
        'code' => 'ZZ',
        'name' => '절러에게 르세',
      ),
    ),
    'ID' => 
    array (
      1 => 
      array (
        'code' => 'DA',
        'name' => 'Daista 아체',
      ),
      2 => 
      array (
        'code' => 'SU',
        'name' => '수마트라 우 타라',
      ),
      3 => 
      array (
        'code' => 'SB',
        'name' => '수마트라 바랏',
      ),
      4 => 
      array (
        'code' => 'SI',
        'name' => '리아 우',
      ),
      5 => 
      array (
        'code' => 'JA',
        'name' => '잠비',
      ),
      6 => 
      array (
        'code' => 'SS',
        'name' => '수마트라 슬라 탄',
      ),
      7 => 
      array (
        'code' => 'BE',
        'name' => '벵 쿨루',
      ),
      8 => 
      array (
        'code' => 'LA',
        'name' => '람풍',
      ),
      9 => 
      array (
        'code' => 'JK',
        'name' => 'DKI 자카르타',
      ),
      10 => 
      array (
        'code' => 'JB',
        'name' => '자와 바라트',
      ),
      11 => 
      array (
        'code' => 'JT',
        'name' => '자와 텡가',
      ),
      12 => 
      array (
        'code' => 'DY',
        'name' => 'Daista 족 자카르타',
      ),
      13 => 
      array (
        'code' => 'JT',
        'name' => '자와 티무르',
      ),
      14 => 
      array (
        'code' => 'KB',
        'name' => '칼리만탄 바라트',
      ),
      15 => 
      array (
        'code' => 'KT',
        'name' => '칼리만탄 텡가',
      ),
      16 => 
      array (
        'code' => 'KI',
        'name' => '칼리만탄 티무르',
      ),
      17 => 
      array (
        'code' => 'KS',
        'name' => '칼리만탄 슬라 탄',
      ),
      18 => 
      array (
        'code' => 'BA',
        'name' => '발리',
      ),
      19 => 
      array (
        'code' => 'NB',
        'name' => '누사 텡 가라 바라트',
      ),
      20 => 
      array (
        'code' => 'NT',
        'name' => '누사 텡 가라 티무르',
      ),
      21 => 
      array (
        'code' => 'SN',
        'name' => '술라웨시 슬라 탄',
      ),
      22 => 
      array (
        'code' => 'ST',
        'name' => '술라웨시 텡가',
      ),
      23 => 
      array (
        'code' => 'SA',
        'name' => '술라웨시 우 타라',
      ),
      24 => 
      array (
        'code' => 'SG',
        'name' => '술라웨시 틍 가라',
      ),
      25 => 
      array (
        'code' => 'MA',
        'name' => '말루 쿠',
      ),
      26 => 
      array (
        'code' => 'MU',
        'name' => '말루 쿠 우 타라',
      ),
      27 => 
      array (
        'code' => 'IJ',
        'name' => '이리 안 자야 티무르',
      ),
      28 => 
      array (
        'code' => 'IT',
        'name' => '이리 안 자야 텡가',
      ),
      29 => 
      array (
        'code' => 'IB',
        'name' => '이리 안 자와 바라트',
      ),
      30 => 
      array (
        'code' => 'BT',
        'name' => '반텐',
      ),
      31 => 
      array (
        'code' => 'BB',
        'name' => '방카 Belitung',
      ),
      32 => 
      array (
        'code' => 'GO',
        'name' => '고론 탈로',
      ),
    ),
    'IE' => 
    array (
      1 => 
      array (
        'code' => 'CA',
        'name' => '칼로',
      ),
      2 => 
      array (
        'code' => 'CV',
        'name' => '캐번',
      ),
      3 => 
      array (
        'code' => 'CL',
        'name' => '클레어',
      ),
      4 => 
      array (
        'code' => 'CO',
        'name' => '코르크',
      ),
      5 => 
      array (
        'code' => 'DO',
        'name' => '도니 골',
      ),
      6 => 
      array (
        'code' => 'DU',
        'name' => '더블린',
      ),
      7 => 
      array (
        'code' => 'GA',
        'name' => '골웨이',
      ),
      8 => 
      array (
        'code' => 'KE',
        'name' => '케리',
      ),
      9 => 
      array (
        'code' => 'KI',
        'name' => '킬 데어',
      ),
      10 => 
      array (
        'code' => 'KL',
        'name' => '킬 케니',
      ),
      11 => 
      array (
        'code' => 'LA',
        'name' => '라오 이스',
      ),
      12 => 
      array (
        'code' => 'LE',
        'name' => '트림',
      ),
      13 => 
      array (
        'code' => 'LI',
        'name' => '리머 릭',
      ),
      14 => 
      array (
        'code' => 'LO',
        'name' => '롱 포드',
      ),
      15 => 
      array (
        'code' => 'LU',
        'name' => '라우스',
      ),
      16 => 
      array (
        'code' => 'MA',
        'name' => '마요네즈',
      ),
      17 => 
      array (
        'code' => 'ME',
        'name' => '미스',
      ),
      18 => 
      array (
        'code' => 'MO',
        'name' => '모니 건',
      ),
      19 => 
      array (
        'code' => 'OF',
        'name' => '팔리',
      ),
      20 => 
      array (
        'code' => 'RO',
        'name' => '로스코 먼',
      ),
      21 => 
      array (
        'code' => 'SL',
        'name' => '슬리',
      ),
      22 => 
      array (
        'code' => 'TI',
        'name' => '코크',
      ),
      23 => 
      array (
        'code' => 'WA',
        'name' => '워터',
      ),
      24 => 
      array (
        'code' => 'WE',
        'name' => '웨스트 미스',
      ),
      25 => 
      array (
        'code' => 'WX',
        'name' => '웩스 퍼드',
      ),
      26 => 
      array (
        'code' => 'WI',
        'name' => '클로',
      ),
    ),
    'IL' => 
    array (
      1 => 
      array (
        'code' => 'BS',
        'name' => '브엘 쉐바',
      ),
      2 => 
      array (
        'code' => 'BH',
        'name' => 'Bika at Hayarden에',
      ),
      3 => 
      array (
        'code' => 'EA',
        'name' => '에일 라트 라바',
      ),
      4 => 
      array (
        'code' => 'GA',
        'name' => '갈릴',
      ),
      5 => 
      array (
        'code' => 'HA',
        'name' => '하이파',
      ),
      6 => 
      array (
        'code' => 'JM',
        'name' => 'Jehuda 산',
      ),
      7 => 
      array (
        'code' => 'JE',
        'name' => '예루살렘',
      ),
      8 => 
      array (
        'code' => 'NE',
        'name' => '네게 브',
      ),
      10 => 
      array (
        'code' => 'SE',
        'name' => 'Semaria',
      ),
      11 => 
      array (
        'code' => 'SH',
        'name' => '샤론',
      ),
      12 => 
      array (
        'code' => 'TA',
        'name' => '텔 아비브 (아이쿠 단',
      ),
    ),
    'IN' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => '안다만 니코 바르 제도',
      ),
      2 => 
      array (
        'code' => 'AP',
        'name' => '안드라 프라데시',
      ),
      3 => 
      array (
        'code' => 'AR',
        'name' => '아루나 찰 프라데시 주',
      ),
      4 => 
      array (
        'code' => 'AS',
        'name' => '아삼',
      ),
      5 => 
      array (
        'code' => 'BI',
        'name' => '비하르',
      ),
      6 => 
      array (
        'code' => 'CH',
        'name' => '찬디 가르',
      ),
      7 => 
      array (
        'code' => 'DA',
        'name' => '다 드라 나가르 하 벨리',
      ),
      8 => 
      array (
        'code' => 'DM',
        'name' => '다만 디우',
      ),
      9 => 
      array (
        'code' => 'DE',
        'name' => '델리',
      ),
      10 => 
      array (
        'code' => 'GO',
        'name' => '고아',
      ),
      11 => 
      array (
        'code' => 'GU',
        'name' => '구자라트',
      ),
      12 => 
      array (
        'code' => 'HA',
        'name' => '하리 아나',
      ),
      13 => 
      array (
        'code' => 'HP',
        'name' => '히 마찰 프라데시',
      ),
      14 => 
      array (
        'code' => 'JA',
        'name' => '잠무 카슈미르',
      ),
      15 => 
      array (
        'code' => 'KA',
        'name' => '카르 나 타카',
      ),
      16 => 
      array (
        'code' => 'KE',
        'name' => '케 랄라',
      ),
      17 => 
      array (
        'code' => 'LI',
        'name' => '락 샤드 위프 제도',
      ),
      18 => 
      array (
        'code' => 'MP',
        'name' => '마디 아 프라데시',
      ),
      19 => 
      array (
        'code' => 'MA',
        'name' => '마하라 슈트라',
      ),
      20 => 
      array (
        'code' => 'MN',
        'name' => '마니 푸르',
      ),
      21 => 
      array (
        'code' => 'ME',
        'name' => '메갈 라야',
      ),
      22 => 
      array (
        'code' => 'MI',
        'name' => '미조람',
      ),
      23 => 
      array (
        'code' => 'NA',
        'name' => '나갈 랜드',
      ),
      24 => 
      array (
        'code' => 'OR',
        'name' => '오리사',
      ),
      25 => 
      array (
        'code' => 'PO',
        'name' => '폰디 체리',
      ),
      26 => 
      array (
        'code' => 'PU',
        'name' => '펀 자브',
      ),
      27 => 
      array (
        'code' => 'RA',
        'name' => '라자스탄',
      ),
      28 => 
      array (
        'code' => 'SI',
        'name' => '시킴',
      ),
      29 => 
      array (
        'code' => 'TN',
        'name' => '타밀 나두',
      ),
      30 => 
      array (
        'code' => 'TR',
        'name' => '트리 푸라',
      ),
      31 => 
      array (
        'code' => 'UP',
        'name' => '우타르 프라데시 주',
      ),
      32 => 
      array (
        'code' => 'WB',
        'name' => '서 벵골',
      ),
    ),
    'IO' => 
    array (
      1 => 
      array (
        'code' => 'DG',
        'name' => '디에고 가르시아',
      ),
      2 => 
      array (
        'code' => 'DI',
        'name' => '위험 아일랜드',
      ),
      3 => 
      array (
        'code' => 'EA',
        'name' => '이글 제도',
      ),
      4 => 
      array (
        'code' => 'EG',
        'name' => '에그몬트 제도',
      ),
      5 => 
      array (
        'code' => 'NI',
        'name' => '위 Nelsons 아일랜드',
      ),
      6 => 
      array (
        'code' => 'PB',
        'name' => 'Peros Banhos',
      ),
      7 => 
      array (
        'code' => 'SI',
        'name' => '솔로몬 제도',
      ),
      8 => 
      array (
        'code' => 'TB',
        'name' => '세 형제',
      ),
    ),
    'IQ' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => '알 안바르',
      ),
      2 => 
      array (
        'code' => 'AL',
        'name' => '아르빌',
      ),
      3 => 
      array (
        'code' => 'BA',
        'name' => '바스라',
      ),
      4 => 
      array (
        'code' => 'BB',
        'name' => '바빌',
      ),
      5 => 
      array (
        'code' => 'BD',
        'name' => '바그다드',
      ),
      6 => 
      array (
        'code' => 'DH',
        'name' => '다 후크',
      ),
      7 => 
      array (
        'code' => 'DQ',
        'name' => '두산 중공업 QAR',
      ),
      8 => 
      array (
        'code' => 'DY',
        'name' => '디 얄라',
      ),
      9 => 
      array (
        'code' => 'KB',
        'name' => '알 카르발라',
      ),
      10 => 
      array (
        'code' => 'MU',
        'name' => '알 Muthanna',
      ),
      11 => 
      array (
        'code' => 'MY',
        'name' => 'Maysan',
      ),
      12 => 
      array (
        'code' => 'NJ',
        'name' => '나자프',
      ),
      13 => 
      array (
        'code' => 'NN',
        'name' => 'Ninawa',
      ),
      14 => 
      array (
        'code' => 'QA',
        'name' => '알 Qadisyah',
      ),
      15 => 
      array (
        'code' => 'SD',
        'name' => '살라 광고 딘',
      ),
      16 => 
      array (
        'code' => 'SL',
        'name' => '술라 이마 니야 등',
      ),
      17 => 
      array (
        'code' => 'TM',
        'name' => 'Ta mim에서',
      ),
      18 => 
      array (
        'code' => 'WS',
        'name' => '와싯',
      ),
    ),
    'IR' => 
    array (
      1 => 
      array (
        'code' => 'ARD',
        'name' => '아르 다빌',
      ),
      2 => 
      array (
        'code' => 'BSH',
        'name' => '부 쉐르',
      ),
      3 => 
      array (
        'code' => 'CMB',
        'name' => '하르 Mahaal 및 바크 티 아리',
      ),
      4 => 
      array (
        'code' => 'EAZ',
        'name' => '동 Azarbaijan',
      ),
      5 => 
      array (
        'code' => 'EFH',
        'name' => '이스파한',
      ),
      6 => 
      array (
        'code' => 'FAR',
        'name' => '파르',
      ),
      7 => 
      array (
        'code' => 'GIL',
        'name' => '길란',
      ),
      8 => 
      array (
        'code' => 'GLS',
        'name' => 'Golestan',
      ),
      9 => 
      array (
        'code' => 'HMD',
        'name' => '하마',
      ),
      10 => 
      array (
        'code' => 'HRM',
        'name' => 'Hormozgan',
      ),
      11 => 
      array (
        'code' => 'ILM',
        'name' => 'Ilam',
      ),
      12 => 
      array (
        'code' => 'KBA',
        'name' => 'Kohkiluyeh 및 구매자 아마드',
      ),
      13 => 
      array (
        'code' => 'KRB',
        'name' => '케르',
      ),
      14 => 
      array (
        'code' => 'KRD',
        'name' => '쿠르드',
      ),
      15 => 
      array (
        'code' => 'KRM',
        'name' => '케르 만 샤',
      ),
      16 => 
      array (
        'code' => 'KZT',
        'name' => '후제 스탄',
      ),
      17 => 
      array (
        'code' => 'LRS',
        'name' => '라리 스탄',
      ),
      18 => 
      array (
        'code' => 'MKZ',
        'name' => 'Markazi',
      ),
      19 => 
      array (
        'code' => 'MZD',
        'name' => '마 잔다',
      ),
      20 => 
      array (
        'code' => 'NKH',
        'name' => '노스 라산',
      ),
      21 => 
      array (
        'code' => 'QAZ',
        'name' => '카즈 빈',
      ),
      22 => 
      array (
        'code' => 'QOM',
        'name' => '콤',
      ),
      23 => 
      array (
        'code' => 'RKH',
        'name' => 'Razavi 라산',
      ),
      24 => 
      array (
        'code' => 'SBL',
        'name' => '시스 탄과 발 루치 스탄',
      ),
      25 => 
      array (
        'code' => 'SKH',
        'name' => '사우스 라산',
      ),
      26 => 
      array (
        'code' => 'SMN',
        'name' => '셈난',
      ),
      27 => 
      array (
        'code' => 'TEH',
        'name' => '테헤란',
      ),
      28 => 
      array (
        'code' => 'WEZ',
        'name' => '웨스트 Azarbaijan',
      ),
      29 => 
      array (
        'code' => 'YZD',
        'name' => '야 즈드',
      ),
      30 => 
      array (
        'code' => 'ZAN',
        'name' => '잔잔',
      ),
    ),
    'IS' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Austurland',
      ),
      2 => 
      array (
        'code' => 'HF',
        'name' => 'Hofuoborgarsvaeoi',
      ),
      3 => 
      array (
        'code' => 'NE',
        'name' => 'Norourland eystra',
      ),
      4 => 
      array (
        'code' => 'NV',
        'name' => 'Norourland vestra',
      ),
      5 => 
      array (
        'code' => 'SL',
        'name' => 'Suourland',
      ),
      6 => 
      array (
        'code' => 'SN',
        'name' => 'Suournes',
      ),
      7 => 
      array (
        'code' => 'VF',
        'name' => 'Vestfiroir',
      ),
      8 => 
      array (
        'code' => 'VL',
        'name' => 'Vesturland',
      ),
    ),
    'IT' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => '아그 리젠 토',
      ),
      2 => 
      array (
        'code' => 'AL',
        'name' => '알레 산 드리아',
      ),
      3 => 
      array (
        'code' => 'AN',
        'name' => '안코나',
      ),
      4 => 
      array (
        'code' => 'AO',
        'name' => '아오 스타',
      ),
      5 => 
      array (
        'code' => 'AR',
        'name' => '아레 초',
      ),
      6 => 
      array (
        'code' => 'AP',
        'name' => '아스 콜리 피체 노',
      ),
      7 => 
      array (
        'code' => 'AT',
        'name' => '아 스티',
      ),
      8 => 
      array (
        'code' => 'AV',
        'name' => '아벨 리노',
      ),
      9 => 
      array (
        'code' => 'BA',
        'name' => '바리',
      ),
      10 => 
      array (
        'code' => 'BL',
        'name' => '벨 루노',
      ),
      11 => 
      array (
        'code' => 'BN',
        'name' => '베네 벤토',
      ),
      12 => 
      array (
        'code' => 'BG',
        'name' => '베르가 모',
      ),
      13 => 
      array (
        'code' => 'BI',
        'name' => '비 엘라',
      ),
      14 => 
      array (
        'code' => 'BO',
        'name' => '볼로냐',
      ),
      15 => 
      array (
        'code' => 'BZ',
        'name' => '볼 차노',
      ),
      16 => 
      array (
        'code' => 'BS',
        'name' => '브레시아',
      ),
      17 => 
      array (
        'code' => 'BR',
        'name' => '브린 디시',
      ),
      18 => 
      array (
        'code' => 'CA',
        'name' => '칼리아리',
      ),
      19 => 
      array (
        'code' => 'CL',
        'name' => '칼 타니 세타',
      ),
      20 => 
      array (
        'code' => 'CB',
        'name' => '캄포 바소',
      ),
      21 => 
      array (
        'code' => 'CE',
        'name' => '카 세르 타',
      ),
      22 => 
      array (
        'code' => 'CT',
        'name' => '카타니아',
      ),
      23 => 
      array (
        'code' => 'CZ',
        'name' => '카탄 차로',
      ),
      24 => 
      array (
        'code' => 'CH',
        'name' => '키에 티',
      ),
      25 => 
      array (
        'code' => 'CO',
        'name' => '코모',
      ),
      26 => 
      array (
        'code' => 'CS',
        'name' => '코센 차',
      ),
      27 => 
      array (
        'code' => 'CR',
        'name' => '크레모나',
      ),
      28 => 
      array (
        'code' => 'KR',
        'name' => '크로 토네',
      ),
      29 => 
      array (
        'code' => 'CN',
        'name' => '쿠 네오',
      ),
      30 => 
      array (
        'code' => 'EN',
        'name' => '엔나',
      ),
      31 => 
      array (
        'code' => 'FE',
        'name' => '페라라',
      ),
      32 => 
      array (
        'code' => 'FI',
        'name' => '피렌체',
      ),
      33 => 
      array (
        'code' => 'FG',
        'name' => '포자',
      ),
      34 => 
      array (
        'code' => 'FO',
        'name' => '포를 리',
      ),
      35 => 
      array (
        'code' => 'FR',
        'name' => '프로시 노네',
      ),
      36 => 
      array (
        'code' => 'GE',
        'name' => '제노바',
      ),
      37 => 
      array (
        'code' => 'GO',
        'name' => '고리 치아',
      ),
      38 => 
      array (
        'code' => 'GR',
        'name' => '그로 세토',
      ),
      39 => 
      array (
        'code' => 'IM',
        'name' => '임 페리아',
      ),
      40 => 
      array (
        'code' => 'IS',
        'name' => '이 세르 니아',
      ),
      41 => 
      array (
        'code' => 'AQ',
        'name' => '독수리',
      ),
      42 => 
      array (
        'code' => 'SP',
        'name' => '라 스페 치아',
      ),
      43 => 
      array (
        'code' => 'LT',
        'name' => '라티',
      ),
      44 => 
      array (
        'code' => 'LE',
        'name' => '레체',
      ),
      45 => 
      array (
        'code' => 'LC',
        'name' => '레코',
      ),
      46 => 
      array (
        'code' => 'LI',
        'name' => '리보르노',
      ),
      47 => 
      array (
        'code' => 'LO',
        'name' => '로디',
      ),
      48 => 
      array (
        'code' => 'LU',
        'name' => '루카',
      ),
      49 => 
      array (
        'code' => 'MC',
        'name' => '마 체라 타',
      ),
      50 => 
      array (
        'code' => 'MN',
        'name' => '만토바',
      ),
      51 => 
      array (
        'code' => 'MS',
        'name' => '마사 카라라',
      ),
      52 => 
      array (
        'code' => 'MT',
        'name' => '마 테라',
      ),
      53 => 
      array (
        'code' => 'ME',
        'name' => '메시나',
      ),
      54 => 
      array (
        'code' => 'MI',
        'name' => '밀라노',
      ),
      55 => 
      array (
        'code' => 'MO',
        'name' => '모데나',
      ),
      56 => 
      array (
        'code' => 'NA',
        'name' => '나폴리',
      ),
      57 => 
      array (
        'code' => 'NO',
        'name' => '노바라',
      ),
      58 => 
      array (
        'code' => 'NU',
        'name' => '누 오로',
      ),
      59 => 
      array (
        'code' => 'OR',
        'name' => '오리 스타 노',
      ),
      60 => 
      array (
        'code' => 'PD',
        'name' => '파도바',
      ),
      61 => 
      array (
        'code' => 'PA',
        'name' => '팔레르모',
      ),
      62 => 
      array (
        'code' => 'PR',
        'name' => '파르마',
      ),
      63 => 
      array (
        'code' => 'PG',
        'name' => '페루자',
      ),
      64 => 
      array (
        'code' => 'PV',
        'name' => '파비아',
      ),
      65 => 
      array (
        'code' => 'PU',
        'name' => '페사로 우르비노',
      ),
      66 => 
      array (
        'code' => 'PE',
        'name' => '페스 카라',
      ),
      67 => 
      array (
        'code' => 'PC',
        'name' => '피아 첸차',
      ),
      68 => 
      array (
        'code' => 'PI',
        'name' => '피사',
      ),
      69 => 
      array (
        'code' => 'PT',
        'name' => '피스 토이 아',
      ),
      70 => 
      array (
        'code' => 'PN',
        'name' => '포르 데 노네',
      ),
      71 => 
      array (
        'code' => 'PZ',
        'name' => '포 텐자',
      ),
      72 => 
      array (
        'code' => 'PO',
        'name' => '프라 토',
      ),
      73 => 
      array (
        'code' => 'RG',
        'name' => '라 구사',
      ),
      74 => 
      array (
        'code' => 'RA',
        'name' => '라벤나',
      ),
      75 => 
      array (
        'code' => 'RC',
        'name' => '레지오 칼라브리아',
      ),
      76 => 
      array (
        'code' => 'RE',
        'name' => '레지오 에밀리아',
      ),
      77 => 
      array (
        'code' => 'RI',
        'name' => '리에티',
      ),
      78 => 
      array (
        'code' => 'RN',
        'name' => '리미니',
      ),
      79 => 
      array (
        'code' => 'RM',
        'name' => '로마',
      ),
      80 => 
      array (
        'code' => 'RO',
        'name' => '로비',
      ),
      81 => 
      array (
        'code' => 'SA',
        'name' => '살레르노',
      ),
      82 => 
      array (
        'code' => 'SS',
        'name' => '사 사리',
      ),
      83 => 
      array (
        'code' => 'SV',
        'name' => '사 보나',
      ),
      84 => 
      array (
        'code' => 'SI',
        'name' => '시에나',
      ),
      85 => 
      array (
        'code' => 'SR',
        'name' => '시라쿠사',
      ),
      86 => 
      array (
        'code' => 'SO',
        'name' => '손 드리오',
      ),
      87 => 
      array (
        'code' => 'TA',
        'name' => '타란 토',
      ),
      88 => 
      array (
        'code' => 'TE',
        'name' => '테라 모',
      ),
      89 => 
      array (
        'code' => 'TR',
        'name' => '테르 니',
      ),
      90 => 
      array (
        'code' => 'TO',
        'name' => '토리노',
      ),
      91 => 
      array (
        'code' => 'TP',
        'name' => '트라 파니',
      ),
      92 => 
      array (
        'code' => 'TN',
        'name' => '트 렌토',
      ),
      93 => 
      array (
        'code' => 'TV',
        'name' => '트레비 소',
      ),
      94 => 
      array (
        'code' => 'TS',
        'name' => '트리 에스테',
      ),
      95 => 
      array (
        'code' => 'UD',
        'name' => '우디 네',
      ),
      96 => 
      array (
        'code' => 'VA',
        'name' => '바레 세',
      ),
      97 => 
      array (
        'code' => 'VE',
        'name' => '베네치아',
      ),
      98 => 
      array (
        'code' => 'VB',
        'name' => '베르 바니아',
      ),
      99 => 
      array (
        'code' => 'VC',
        'name' => '베르 첼리',
      ),
      100 => 
      array (
        'code' => 'VR',
        'name' => '베로나',
      ),
      101 => 
      array (
        'code' => 'VV',
        'name' => '비보 발렌티 아',
      ),
      102 => 
      array (
        'code' => 'VI',
        'name' => '비 첸차',
      ),
      103 => 
      array (
        'code' => 'VT',
        'name' => '비테 르보',
      ),
      104 => 
      array (
        'code' => 'CI',
        'name' => '카르보니 - 이글레시아스',
      ),
      105 => 
      array (
        'code' => 'VS',
        'name' => '메디 Campidano',
      ),
      106 => 
      array (
        'code' => 'OG',
        'name' => 'Ogliastra',
      ),
      107 => 
      array (
        'code' => 'OT',
        'name' => '올 비아 템 피오',
      ),
      108 => 
      array (
        'code' => 'MB',
        'name' => '몬차 전자 안자',
      ),
      109 => 
      array (
        'code' => 'FM',
        'name' => '페르 모',
      ),
      110 => 
      array (
        'code' => 'BT',
        'name' => '바를 레타 - 안드리 아 - 트 라니',
      ),
    ),
    'JM' => 
    array (
      1 => 
      array (
        'code' => 'CLA',
        'name' => '클래 런던 교구',
      ),
      2 => 
      array (
        'code' => 'HAN',
        'name' => '하노버',
      ),
      3 => 
      array (
        'code' => 'KIN',
        'name' => '킹스턴 교구',
      ),
      4 => 
      array (
        'code' => 'MAN',
        'name' => '맨체스터 교구',
      ),
      5 => 
      array (
        'code' => 'POR',
        'name' => '포틀랜드 교구',
      ),
      6 => 
      array (
        'code' => 'AND',
        'name' => '세인트 앤드류 교구',
      ),
      7 => 
      array (
        'code' => 'ANN',
        'name' => '세인트 앤 교구',
      ),
      8 => 
      array (
        'code' => 'CAT',
        'name' => '세인트 캐서린 교구',
      ),
      9 => 
      array (
        'code' => 'ELI',
        'name' => '세인트 엘리자베스 교구',
      ),
      10 => 
      array (
        'code' => 'JAM',
        'name' => '세인트 제임스 교구',
      ),
      11 => 
      array (
        'code' => 'MAR',
        'name' => '세인트 메리 교구',
      ),
      12 => 
      array (
        'code' => 'THO',
        'name' => '세인트 토마스 교구',
      ),
      13 => 
      array (
        'code' => 'TRL',
        'name' => 'Trelawny 교구',
      ),
      14 => 
      array (
        'code' => 'WML',
        'name' => '웨스트 모어 랜드 교구',
      ),
    ),
    'JO' => 
    array (
      1 => 
      array (
        'code' => 'AM',
        'name' => '암만',
      ),
      2 => 
      array (
        'code' => 'AJ',
        'name' => '아즐 룬',
      ),
      3 => 
      array (
        'code' => 'AA',
        'name' => 'AlAqabah',
      ),
      4 => 
      array (
        'code' => 'AB',
        'name' => '알 Balqa',
      ),
      5 => 
      array (
        'code' => 'AK',
        'name' => '알 가락',
      ),
      6 => 
      array (
        'code' => 'AL',
        'name' => '알 마프 라크',
      ),
      7 => 
      array (
        'code' => 'AT',
        'name' => 'Tafilah에서',
      ),
      8 => 
      array (
        'code' => 'AZ',
        'name' => '아즈 Zarqa',
      ),
      9 => 
      array (
        'code' => 'IR',
        'name' => '이르 비드',
      ),
      10 => 
      array (
        'code' => 'JA',
        'name' => 'Jarash',
      ),
      11 => 
      array (
        'code' => 'MA',
        'name' => '마안',
      ),
      12 => 
      array (
        'code' => 'MD',
        'name' => '마다 바',
      ),
    ),
    'JP' => 
    array (
      1 => 
      array (
        'code' => 'AI',
        'name' => '아이 치현',
      ),
      2 => 
      array (
        'code' => 'AK',
        'name' => '아키타',
      ),
      3 => 
      array (
        'code' => 'AO',
        'name' => '아오모리 현',
      ),
      4 => 
      array (
        'code' => 'CH',
        'name' => '치바',
      ),
      5 => 
      array (
        'code' => 'EH',
        'name' => '에히메',
      ),
      6 => 
      array (
        'code' => 'FK',
        'name' => '후쿠이',
      ),
      7 => 
      array (
        'code' => 'FU',
        'name' => '후쿠오카 현',
      ),
      8 => 
      array (
        'code' => 'FS',
        'name' => '후쿠시마',
      ),
      9 => 
      array (
        'code' => 'GI',
        'name' => '기후',
      ),
      10 => 
      array (
        'code' => 'GU',
        'name' => '군마',
      ),
      11 => 
      array (
        'code' => 'HI',
        'name' => '히로시마',
      ),
      12 => 
      array (
        'code' => 'HO',
        'name' => '홋카이도',
      ),
      13 => 
      array (
        'code' => 'HY',
        'name' => '효고현',
      ),
      14 => 
      array (
        'code' => 'IB',
        'name' => '이바라키',
      ),
      15 => 
      array (
        'code' => 'IS',
        'name' => '이시카와',
      ),
      16 => 
      array (
        'code' => 'IW',
        'name' => '이와테 현',
      ),
      17 => 
      array (
        'code' => 'KA',
        'name' => '가가와',
      ),
      18 => 
      array (
        'code' => 'KG',
        'name' => '가고시마',
      ),
      19 => 
      array (
        'code' => 'KN',
        'name' => '가나가와 현',
      ),
      20 => 
      array (
        'code' => 'KO',
        'name' => '고치',
      ),
      21 => 
      array (
        'code' => 'KU',
        'name' => '구마모토',
      ),
      22 => 
      array (
        'code' => 'KY',
        'name' => '교토',
      ),
      23 => 
      array (
        'code' => 'MI',
        'name' => '미에',
      ),
      24 => 
      array (
        'code' => 'MY',
        'name' => '미야기 현',
      ),
      25 => 
      array (
        'code' => 'MZ',
        'name' => '미야자키',
      ),
      26 => 
      array (
        'code' => 'NA',
        'name' => '나가노',
      ),
      27 => 
      array (
        'code' => 'NG',
        'name' => '나가사키',
      ),
      28 => 
      array (
        'code' => 'NR',
        'name' => '나라',
      ),
      29 => 
      array (
        'code' => 'NI',
        'name' => '니가타',
      ),
      30 => 
      array (
        'code' => 'OI',
        'name' => '오이타',
      ),
      31 => 
      array (
        'code' => 'OK',
        'name' => '오카야마',
      ),
      32 => 
      array (
        'code' => 'ON',
        'name' => '오키나와',
      ),
      33 => 
      array (
        'code' => 'OS',
        'name' => '오사카',
      ),
      34 => 
      array (
        'code' => 'SA',
        'name' => '사가',
      ),
      35 => 
      array (
        'code' => 'SI',
        'name' => '사이타마',
      ),
      36 => 
      array (
        'code' => 'SH',
        'name' => '시가',
      ),
      37 => 
      array (
        'code' => 'SM',
        'name' => '시마네',
      ),
      38 => 
      array (
        'code' => 'SZ',
        'name' => '시즈오카 현',
      ),
      39 => 
      array (
        'code' => 'TO',
        'name' => '토',
      ),
      40 => 
      array (
        'code' => 'TS',
        'name' => '도쿠시마',
      ),
      41 => 
      array (
        'code' => 'TK',
        'name' => '도쿄',
      ),
      42 => 
      array (
        'code' => 'TT',
        'name' => '돗토리',
      ),
      43 => 
      array (
        'code' => 'TY',
        'name' => '도야마',
      ),
      44 => 
      array (
        'code' => 'WA',
        'name' => '와카야마',
      ),
      45 => 
      array (
        'code' => 'YA',
        'name' => '야마가타',
      ),
      46 => 
      array (
        'code' => 'YM',
        'name' => '야마구치',
      ),
      47 => 
      array (
        'code' => 'YN',
        'name' => '야마나시 현',
      ),
    ),
    'KE' => 
    array (
      1 => 
      array (
        'code' => 'CE',
        'name' => '중앙',
      ),
      2 => 
      array (
        'code' => 'CO',
        'name' => '코스트',
      ),
      3 => 
      array (
        'code' => 'EA',
        'name' => '동부',
      ),
      4 => 
      array (
        'code' => 'NA',
        'name' => '나이로비 지역',
      ),
      5 => 
      array (
        'code' => 'NE',
        'name' => '노스 이스턴',
      ),
      6 => 
      array (
        'code' => 'NY',
        'name' => '냔자',
      ),
      7 => 
      array (
        'code' => 'RV',
        'name' => '리프트 밸리',
      ),
      8 => 
      array (
        'code' => 'WE',
        'name' => '서양',
      ),
    ),
    'KG' => 
    array (
      1 => 
      array (
        'code' => 'GB',
        'name' => '비슈 케크',
      ),
      2 => 
      array (
        'code' => 'B',
        'name' => 'Batken',
      ),
      3 => 
      array (
        'code' => 'C',
        'name' => '추',
      ),
      4 => 
      array (
        'code' => 'J',
        'name' => '잘랄 아 바드',
      ),
      5 => 
      array (
        'code' => 'N',
        'name' => '나린',
      ),
      6 => 
      array (
        'code' => 'O',
        'name' => '오시',
      ),
      7 => 
      array (
        'code' => 'T',
        'name' => '탈라스',
      ),
      8 => 
      array (
        'code' => 'Y',
        'name' => 'Ysyk-Kol의',
      ),
    ),
    'KH' => 
    array (
      1 => 
      array (
        'code' => 'BA',
        'name' => '바 탐방',
      ),
      2 => 
      array (
        'code' => 'BM',
        'name' => '반 테이 메안 체이',
      ),
      3 => 
      array (
        'code' => 'KB',
        'name' => '외환 은행',
      ),
      4 => 
      array (
        'code' => 'KK',
        'name' => 'Kaoh 홍콩',
      ),
      5 => 
      array (
        'code' => 'KL',
        'name' => '칸달',
      ),
      6 => 
      array (
        'code' => 'KM',
        'name' => '캄 퐁참',
      ),
      7 => 
      array (
        'code' => 'KN',
        'name' => '캄퐁 치낭',
      ),
      8 => 
      array (
        'code' => 'KO',
        'name' => '캄퐁 솜',
      ),
      9 => 
      array (
        'code' => 'KP',
        'name' => '캄폿',
      ),
      10 => 
      array (
        'code' => 'KR',
        'name' => '크라 체',
      ),
      11 => 
      array (
        'code' => 'KT',
        'name' => '캄퐁 톰',
      ),
      12 => 
      array (
        'code' => 'KU',
        'name' => '캄퐁 스페 우',
      ),
      13 => 
      array (
        'code' => 'MK',
        'name' => 'Mondul 리',
      ),
      14 => 
      array (
        'code' => 'OM',
        'name' => 'Oddar Meancheay',
      ),
      15 => 
      array (
        'code' => 'PA',
        'name' => '린',
      ),
      16 => 
      array (
        'code' => 'PG',
        'name' => '먹이 벵',
      ),
      17 => 
      array (
        'code' => 'PP',
        'name' => '프놈펜',
      ),
      18 => 
      array (
        'code' => 'PR',
        'name' => '프레아 비헤 아르',
      ),
      19 => 
      array (
        'code' => 'PS',
        'name' => '프레아 Seihanu (캄퐁 솜 또는 Si',
      ),
      20 => 
      array (
        'code' => 'PU',
        'name' => '데브라',
      ),
      21 => 
      array (
        'code' => 'RK',
        'name' => 'Ratanak 리',
      ),
      22 => 
      array (
        'code' => 'SI',
        'name' => '시엠립',
      ),
      23 => 
      array (
        'code' => 'SR',
        'name' => 'Svay 엥',
      ),
      24 => 
      array (
        'code' => 'ST',
        'name' => '스텅 트렝',
      ),
      25 => 
      array (
        'code' => 'TK',
        'name' => '타케',
      ),
    ),
    'KI' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => 'Abaiang',
      ),
      2 => 
      array (
        'code' => 'AM',
        'name' => 'Abemama',
      ),
      3 => 
      array (
        'code' => 'AK',
        'name' => 'Aranuka',
      ),
      4 => 
      array (
        'code' => 'AO',
        'name' => 'Arorae',
      ),
      5 => 
      array (
        'code' => 'BA',
        'name' => '바나바',
      ),
      6 => 
      array (
        'code' => 'BE',
        'name' => '베루',
      ),
      7 => 
      array (
        'code' => 'bT',
        'name' => 'Butaritari',
      ),
      8 => 
      array (
        'code' => 'KA',
        'name' => 'Kanton',
      ),
      9 => 
      array (
        'code' => 'KR',
        'name' => '키리 티 마티',
      ),
      10 => 
      array (
        'code' => 'KU',
        'name' => 'Kuria',
      ),
      11 => 
      array (
        'code' => 'MI',
        'name' => 'Maiana',
      ),
      12 => 
      array (
        'code' => 'MN',
        'name' => '가는데',
      ),
      13 => 
      array (
        'code' => 'ME',
        'name' => 'Marakei',
      ),
      14 => 
      array (
        'code' => 'NI',
        'name' => 'Nikunau',
      ),
      15 => 
      array (
        'code' => 'NO',
        'name' => 'Nonouti',
      ),
      16 => 
      array (
        'code' => 'ON',
        'name' => 'Onotoa',
      ),
      17 => 
      array (
        'code' => 'TT',
        'name' => 'Tabiteuea',
      ),
      18 => 
      array (
        'code' => 'TR',
        'name' => 'Tabuaeran',
      ),
      19 => 
      array (
        'code' => 'TM',
        'name' => '타마',
      ),
      20 => 
      array (
        'code' => 'TW',
        'name' => '타라',
      ),
      21 => 
      array (
        'code' => 'TE',
        'name' => 'Teraina',
      ),
    ),
    'KM' => 
    array (
      1 => 
      array (
        'code' => 'G',
        'name' => '그랜드 Comore에',
      ),
      2 => 
      array (
        'code' => 'A',
        'name' => '앙 주앙',
      ),
      3 => 
      array (
        'code' => 'M',
        'name' => 'Moheli에',
      ),
    ),
    'KN' => 
    array (
      1 => 
      array (
        'code' => 'CCN',
        'name' => '그리스도 교회 니콜라 타운',
      ),
      2 => 
      array (
        'code' => 'SAS',
        'name' => '세인트 앤 샌디 포인트',
      ),
      3 => 
      array (
        'code' => 'SGB',
        'name' => '세인트 조지 바스 테르',
      ),
      4 => 
      array (
        'code' => 'SGG',
        'name' => '세인트 조지 Gingerland',
      ),
      5 => 
      array (
        'code' => 'SJW',
        'name' => '세인트 제임스 윈드 워드',
      ),
      6 => 
      array (
        'code' => 'SJC',
        'name' => '세인트 존 Capesterre의',
      ),
      7 => 
      array (
        'code' => 'SJF',
        'name' => '세인트 존 피그 트리',
      ),
      8 => 
      array (
        'code' => 'SMC',
        'name' => '세인트 메리 Cayon',
      ),
      9 => 
      array (
        'code' => 'CAP',
        'name' => '세인트 폴 Capesterre의',
      ),
      10 => 
      array (
        'code' => 'CHA',
        'name' => '세인트 폴 찰스',
      ),
      11 => 
      array (
        'code' => 'SPB',
        'name' => '세인트 피터 바스 테르',
      ),
      12 => 
      array (
        'code' => 'STL',
        'name' => '세인트 토마스 저지대',
      ),
      13 => 
      array (
        'code' => 'STM',
        'name' => '세인트 토마스 중동 섬',
      ),
      14 => 
      array (
        'code' => 'TPP',
        'name' => '삼위 일체 팔메 토 포인트',
      ),
    ),
    'KP' => 
    array (
      1 => 
      array (
        'code' => 'CHA',
        'name' => '자강도-DO',
      ),
      2 => 
      array (
        'code' => 'HAB',
        'name' => '함경북도 광역시',
      ),
      3 => 
      array (
        'code' => 'HAN',
        'name' => '함경북도-남도',
      ),
      4 => 
      array (
        'code' => 'HWB',
        'name' => '황해도 광역시',
      ),
      5 => 
      array (
        'code' => 'HWN',
        'name' => '황해도 경남',
      ),
      6 => 
      array (
        'code' => 'KAN',
        'name' => '강원도',
      ),
      7 => 
      array (
        'code' => 'PYB',
        'name' => 'P 영안 광역시',
      ),
      8 => 
      array (
        'code' => 'PYN',
        'name' => 'P 영안 - 경남',
      ),
      9 => 
      array (
        'code' => 'YAN',
        'name' => '양강도-DO (양강도-DO',
      ),
      10 => 
      array (
        'code' => 'NAJ',
        'name' => '라선 직접 경세시',
      ),
      11 => 
      array (
        'code' => 'PYO',
        'name' => '평양 특별시',
      ),
    ),
    'KR' => 
    array (
      1 => 
      array (
        'code' => 'CO',
        'name' => '충청북도',
      ),
      2 => 
      array (
        'code' => 'CH',
        'name' => 'Ch ungch ong-남도',
      ),
      3 => 
      array (
        'code' => 'CD',
        'name' => '제주도',
      ),
      4 => 
      array (
        'code' => 'CB',
        'name' => '전라북도',
      ),
      5 => 
      array (
        'code' => 'CN',
        'name' => '전라남도',
      ),
      6 => 
      array (
        'code' => 'IG',
        'name' => '인천 광역시',
      ),
      7 => 
      array (
        'code' => 'KA',
        'name' => '강원도',
      ),
      8 => 
      array (
        'code' => 'KG',
        'name' => '광주 광역시',
      ),
      9 => 
      array (
        'code' => 'KD',
        'name' => '경기도',
      ),
      10 => 
      array (
        'code' => 'KB',
        'name' => '- 경상북도',
      ),
      11 => 
      array (
        'code' => 'KN',
        'name' => '경상남도',
      ),
      12 => 
      array (
        'code' => 'PG',
        'name' => '부산 광역시',
      ),
      13 => 
      array (
        'code' => 'SO',
        'name' => '서울 특별시',
      ),
      14 => 
      array (
        'code' => 'TA',
        'name' => '대구 광역시',
      ),
      15 => 
      array (
        'code' => 'TG',
        'name' => '대전 광역시',
      ),
    ),
    'KW' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Al Asimah',
      ),
      2 => 
      array (
        'code' => 'AA',
        'name' => '알 마디',
      ),
      3 => 
      array (
        'code' => 'AF',
        'name' => '알 Farwaniyah',
      ),
      4 => 
      array (
        'code' => 'AJ',
        'name' => '알 자 흐라',
      ),
      5 => 
      array (
        'code' => 'HA',
        'name' => 'Hawalli에',
      ),
    ),
    'KY' => 
    array (
      1 => 
      array (
        'code' => 'CR',
        'name' => '크릭',
      ),
      2 => 
      array (
        'code' => 'EA',
        'name' => '동부',
      ),
      3 => 
      array (
        'code' => 'ML',
        'name' => '미들랜드',
      ),
      4 => 
      array (
        'code' => 'ST',
        'name' => '사우스 타운',
      ),
      5 => 
      array (
        'code' => 'SP',
        'name' => '자리 만',
      ),
      6 => 
      array (
        'code' => 'SK',
        'name' => '스테이크 베이',
      ),
      7 => 
      array (
        'code' => 'WD',
        'name' => '웨스트 엔드 (West End',
      ),
      8 => 
      array (
        'code' => 'WN',
        'name' => '서양',
      ),
    ),
    'KZ' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => '알마티',
      ),
      2 => 
      array (
        'code' => 'AC',
        'name' => '알마티시',
      ),
      3 => 
      array (
        'code' => 'AM',
        'name' => '아크 몰라',
      ),
      4 => 
      array (
        'code' => 'AQ',
        'name' => '악 토브',
      ),
      5 => 
      array (
        'code' => 'AS',
        'name' => '아스타나시',
      ),
      6 => 
      array (
        'code' => 'AT',
        'name' => '아티 라우',
      ),
      7 => 
      array (
        'code' => 'BA',
        'name' => 'Batys Qazaqstan',
      ),
      8 => 
      array (
        'code' => 'BY',
        'name' => 'Bayqongyr시',
      ),
      9 => 
      array (
        'code' => 'MA',
        'name' => 'Mangghystau',
      ),
      10 => 
      array (
        'code' => 'ON',
        'name' => 'Ongtustik Qazaqstan',
      ),
      11 => 
      array (
        'code' => 'PA',
        'name' => '파블로 다르',
      ),
      12 => 
      array (
        'code' => 'QA',
        'name' => 'Qaraghandy',
      ),
      13 => 
      array (
        'code' => 'QO',
        'name' => 'Qostanay',
      ),
      14 => 
      array (
        'code' => 'QY',
        'name' => 'Qyzylorda',
      ),
      15 => 
      array (
        'code' => 'SH',
        'name' => 'Shyghys Qazaqstan',
      ),
      16 => 
      array (
        'code' => 'SO',
        'name' => 'Soltustik Qazaqstan',
      ),
      17 => 
      array (
        'code' => 'ZH',
        'name' => '잠빌',
      ),
    ),
    'LA' => 
    array (
      1 => 
      array (
        'code' => 'VT',
        'name' => '비엔티안',
      ),
      2 => 
      array (
        'code' => 'AT',
        'name' => 'Attapu',
      ),
      3 => 
      array (
        'code' => 'BK',
        'name' => '보케',
      ),
      4 => 
      array (
        'code' => 'BL',
        'name' => 'Bolikhamxai',
      ),
      5 => 
      array (
        'code' => 'CH',
        'name' => '파삭',
      ),
      6 => 
      array (
        'code' => 'HO',
        'name' => 'Houaphan',
      ),
      7 => 
      array (
        'code' => 'KH',
        'name' => '캄 모우',
      ),
      8 => 
      array (
        'code' => 'LM',
        'name' => 'Louang 남타',
      ),
      9 => 
      array (
        'code' => 'LP',
        'name' => 'Louangphabang',
      ),
      10 => 
      array (
        'code' => 'OU',
        'name' => 'Oudomxai',
      ),
      11 => 
      array (
        'code' => 'PH',
        'name' => '퐁 살리',
      ),
      12 => 
      array (
        'code' => 'SL',
        'name' => 'Salavan',
      ),
      13 => 
      array (
        'code' => 'SV',
        'name' => '사바나 켓',
      ),
      14 => 
      array (
        'code' => 'VI',
        'name' => '비엔티안',
      ),
      15 => 
      array (
        'code' => 'XA',
        'name' => 'Xaignabouli',
      ),
      16 => 
      array (
        'code' => 'XE',
        'name' => 'Xekong',
      ),
      17 => 
      array (
        'code' => 'XI',
        'name' => 'Xiangkhoang',
      ),
      18 => 
      array (
        'code' => 'XN',
        'name' => 'Xaisomboun',
      ),
    ),
    'LB' => 
    array (
      1 => 
      array (
        'code' => 'BIN',
        'name' => '빈트 즈 바일',
      ),
      2 => 
      array (
        'code' => 'HAS',
        'name' => 'Hasbaya',
      ),
      3 => 
      array (
        'code' => 'MAR',
        'name' => 'Marjeyoun',
      ),
      4 => 
      array (
        'code' => 'NAB',
        'name' => 'Nabatieh',
      ),
      5 => 
      array (
        'code' => 'BAA',
        'name' => '바알 베크',
      ),
      6 => 
      array (
        'code' => 'HER',
        'name' => 'Hermel',
      ),
      7 => 
      array (
        'code' => 'RAS',
        'name' => 'Rashaya',
      ),
      8 => 
      array (
        'code' => 'WES',
        'name' => '서부 베카',
      ),
      9 => 
      array (
        'code' => 'ZAH',
        'name' => '잘레',
      ),
      10 => 
      array (
        'code' => 'AKK',
        'name' => 'Akkar',
      ),
      11 => 
      array (
        'code' => 'BAT',
        'name' => 'Batroun',
      ),
      12 => 
      array (
        'code' => 'BSH',
        'name' => '브 샤리',
      ),
      13 => 
      array (
        'code' => 'KOU',
        'name' => 'Koura',
      ),
      14 => 
      array (
        'code' => 'MIN',
        'name' => 'Miniyeh-Danniyeh',
      ),
      15 => 
      array (
        'code' => 'TRI',
        'name' => '트리폴리',
      ),
      16 => 
      array (
        'code' => 'ZGH',
        'name' => 'Zgharta',
      ),
      17 => 
      array (
        'code' => 'ALE',
        'name' => '알레이',
      ),
      18 => 
      array (
        'code' => 'BAA',
        'name' => 'Baabda',
      ),
      19 => 
      array (
        'code' => 'BYB',
        'name' => '비블로스',
      ),
      20 => 
      array (
        'code' => 'CHO',
        'name' => 'Chouf',
      ),
      21 => 
      array (
        'code' => 'KES',
        'name' => 'Kesrwan',
      ),
      22 => 
      array (
        'code' => 'MAT',
        'name' => 'Matn',
      ),
      23 => 
      array (
        'code' => 'JEZ',
        'name' => 'Jezzine',
      ),
      24 => 
      array (
        'code' => 'SID',
        'name' => '시돈',
      ),
      25 => 
      array (
        'code' => 'TYR',
        'name' => '타이어',
      ),
    ),
    'LC' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => '안세 라 Raye의',
      ),
      2 => 
      array (
        'code' => 'CA',
        'name' => '캐스트리스',
      ),
      3 => 
      array (
        'code' => 'CH',
        'name' => '조아 젤',
      ),
      4 => 
      array (
        'code' => 'DA',
        'name' => '황태자',
      ),
      5 => 
      array (
        'code' => 'DE',
        'name' => 'Dennery',
      ),
      6 => 
      array (
        'code' => 'GI',
        'name' => '그로스 - 베이',
      ),
      7 => 
      array (
        'code' => 'LA',
        'name' => 'LABORIE',
      ),
      8 => 
      array (
        'code' => 'MI',
        'name' => '미쿠',
      ),
      9 => 
      array (
        'code' => 'PR',
        'name' => '프랄린',
      ),
      10 => 
      array (
        'code' => 'SO',
        'name' => '수 프리 에르',
      ),
      11 => 
      array (
        'code' => 'VF',
        'name' => '비유 - 포트',
      ),
    ),
    'LI' => 
    array (
      1 => 
      array (
        'code' => 'V',
        'name' => '파두 츠',
      ),
      2 => 
      array (
        'code' => 'A',
        'name' => '샨',
      ),
      3 => 
      array (
        'code' => 'B',
        'name' => '발저',
      ),
      4 => 
      array (
        'code' => 'N',
        'name' => '트리 젠',
      ),
      5 => 
      array (
        'code' => 'E',
        'name' => 'Eschen에서',
      ),
      6 => 
      array (
        'code' => 'M',
        'name' => '마우 렌',
      ),
      7 => 
      array (
        'code' => 'T',
        'name' => '트리 젠 베르크',
      ),
      8 => 
      array (
        'code' => 'R',
        'name' => 'Ruggell',
      ),
      9 => 
      array (
        'code' => 'G',
        'name' => 'Gamprin',
      ),
      10 => 
      array (
        'code' => 'L',
        'name' => 'Schellenberg',
      ),
      11 => 
      array (
        'code' => 'P',
        'name' => 'Planken',
      ),
    ),
    'LK' => 
    array (
      1 => 
      array (
        'code' => 'CE',
        'name' => '중앙',
      ),
      2 => 
      array (
        'code' => 'EA',
        'name' => '동부',
      ),
      3 => 
      array (
        'code' => 'NC',
        'name' => '노스 센트럴',
      ),
      4 => 
      array (
        'code' => 'NO',
        'name' => '북',
      ),
      5 => 
      array (
        'code' => 'NW',
        'name' => '노스 웨스턴',
      ),
      6 => 
      array (
        'code' => 'SA',
        'name' => 'Sabaragamuwa',
      ),
      7 => 
      array (
        'code' => 'SO',
        'name' => '남부',
      ),
      8 => 
      array (
        'code' => 'UV',
        'name' => 'UVA',
      ),
      9 => 
      array (
        'code' => 'WE',
        'name' => '서양',
      ),
    ),
    'LR' => 
    array (
      1 => 
      array (
        'code' => 'BI',
        'name' => '보미',
      ),
      2 => 
      array (
        'code' => 'BG',
        'name' => '봉',
      ),
      3 => 
      array (
        'code' => 'GB',
        'name' => '그랜드 바사',
      ),
      4 => 
      array (
        'code' => 'CM',
        'name' => '그랜드 케이프 마운트',
      ),
      5 => 
      array (
        'code' => 'GG',
        'name' => '그랜드 게데',
      ),
      6 => 
      array (
        'code' => 'GK',
        'name' => '그랜드 크루',
      ),
      7 => 
      array (
        'code' => 'LO',
        'name' => '로파',
      ),
      8 => 
      array (
        'code' => 'MG',
        'name' => 'Margibi',
      ),
      9 => 
      array (
        'code' => 'ML',
        'name' => '메릴랜드',
      ),
      10 => 
      array (
        'code' => 'MS',
        'name' => 'Montserrado',
      ),
      11 => 
      array (
        'code' => 'NB',
        'name' => '님바',
      ),
      12 => 
      array (
        'code' => 'RC',
        'name' => '강 CESS',
      ),
      13 => 
      array (
        'code' => 'SN',
        'name' => 'Sinoe',
      ),
    ),
    'LS' => 
    array (
      1 => 
      array (
        'code' => 'BE',
        'name' => '버리 아',
      ),
      2 => 
      array (
        'code' => 'BB',
        'name' => '부타 - 부테',
      ),
      3 => 
      array (
        'code' => 'LE',
        'name' => 'Leribe',
      ),
      4 => 
      array (
        'code' => 'MF',
        'name' => 'Mafeteng',
      ),
      5 => 
      array (
        'code' => 'MS',
        'name' => '마세 루',
      ),
      6 => 
      array (
        'code' => 'MH',
        'name' => 'Mohale의 후크',
      ),
      7 => 
      array (
        'code' => 'MK',
        'name' => 'Mokhotlong',
      ),
      8 => 
      array (
        'code' => 'QN',
        'name' => 'Qacha의 NEK',
      ),
      9 => 
      array (
        'code' => 'QT',
        'name' => 'Quthing',
      ),
      10 => 
      array (
        'code' => 'TT',
        'name' => '위 Thaba-Tseka',
      ),
    ),
    'LT' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Alytus의',
      ),
      2 => 
      array (
        'code' => 'KA',
        'name' => '카우 나스',
      ),
      3 => 
      array (
        'code' => 'KL',
        'name' => '클라이 페다',
      ),
      4 => 
      array (
        'code' => 'MA',
        'name' => '마리 얌 폴레',
      ),
      5 => 
      array (
        'code' => 'PA',
        'name' => '파네 베지 스',
      ),
      6 => 
      array (
        'code' => 'SI',
        'name' => 'Siauliai에서',
      ),
      7 => 
      array (
        'code' => 'TA',
        'name' => 'Taurage',
      ),
      8 => 
      array (
        'code' => 'TE',
        'name' => 'Telsiai',
      ),
      9 => 
      array (
        'code' => 'UT',
        'name' => '우테나',
      ),
      10 => 
      array (
        'code' => 'VI',
        'name' => '빌 뉴스',
      ),
    ),
    'LU' => 
    array (
      1 => 
      array (
        'code' => 'DD',
        'name' => 'Diekirch에',
      ),
      2 => 
      array (
        'code' => 'DC',
        'name' => '클레르 보',
      ),
      3 => 
      array (
        'code' => 'DR',
        'name' => 'Redange',
      ),
      4 => 
      array (
        'code' => 'DV',
        'name' => '비안 덴',
      ),
      5 => 
      array (
        'code' => 'DW',
        'name' => '빌츠',
      ),
      6 => 
      array (
        'code' => 'GG',
        'name' => '그레 벤 마허',
      ),
      7 => 
      array (
        'code' => 'GE',
        'name' => '에 히터 나흐',
      ),
      8 => 
      array (
        'code' => 'GR',
        'name' => '레미',
      ),
      9 => 
      array (
        'code' => 'LL',
        'name' => '룩셈부르크',
      ),
      10 => 
      array (
        'code' => 'LC',
        'name' => 'Capellen',
      ),
      11 => 
      array (
        'code' => 'LE',
        'name' => '에슈 쉬르 알 제트',
      ),
      12 => 
      array (
        'code' => 'LM',
        'name' => '메르 쉬',
      ),
    ),
    'LV' => 
    array (
      1 => 
      array (
        'code' => 'AIZ',
        'name' => 'Aizkraukles Rajons',
      ),
      2 => 
      array (
        'code' => 'ALU',
        'name' => 'Aluksnes Rajons',
      ),
      3 => 
      array (
        'code' => 'BAL',
        'name' => 'Balvu Rajons',
      ),
      4 => 
      array (
        'code' => 'BAU',
        'name' => 'Bauskas Rajons',
      ),
      5 => 
      array (
        'code' => 'CES',
        'name' => 'CESU Rajons',
      ),
      6 => 
      array (
        'code' => 'DGR',
        'name' => '다우 가프 필스 Rajons',
      ),
      7 => 
      array (
        'code' => 'DOB',
        'name' => 'Dobeles Rajons',
      ),
      8 => 
      array (
        'code' => 'GUL',
        'name' => 'Gulbenes Rajons',
      ),
      9 => 
      array (
        'code' => 'JEK',
        'name' => 'Jekabpils Rajons',
      ),
      10 => 
      array (
        'code' => 'JGR',
        'name' => 'Jelgavas Rajons',
      ),
      11 => 
      array (
        'code' => 'KRA',
        'name' => 'Kraslavas Rajons',
      ),
      12 => 
      array (
        'code' => 'KUL',
        'name' => '쿨디 Rajons',
      ),
      13 => 
      array (
        'code' => 'LPR',
        'name' => 'LIEPAJAS Rajons',
      ),
      14 => 
      array (
        'code' => 'LIM',
        'name' => 'Limbazu Rajons',
      ),
      15 => 
      array (
        'code' => 'LUD',
        'name' => 'Ludzas Rajons',
      ),
      16 => 
      array (
        'code' => 'MAD',
        'name' => 'Madonas Rajons',
      ),
      17 => 
      array (
        'code' => 'OGR',
        'name' => '오우거 Rajons',
      ),
      18 => 
      array (
        'code' => 'PRE',
        'name' => 'Preilu Rajons',
      ),
      19 => 
      array (
        'code' => 'RZR',
        'name' => 'Rezeknes Rajons',
      ),
      20 => 
      array (
        'code' => 'RGR',
        'name' => '리 가스 Rajons',
      ),
      21 => 
      array (
        'code' => 'SAL',
        'name' => 'Saldus Rajons',
      ),
      22 => 
      array (
        'code' => 'TAL',
        'name' => 'Talsu Rajons',
      ),
      23 => 
      array (
        'code' => 'TUK',
        'name' => 'Tukuma Rajons',
      ),
      24 => 
      array (
        'code' => 'VLK',
        'name' => 'Valkas Rajons',
      ),
      25 => 
      array (
        'code' => 'VLM',
        'name' => 'Valmieras Rajons',
      ),
      26 => 
      array (
        'code' => 'VSR',
        'name' => '벤츠 필스 Rajons',
      ),
      27 => 
      array (
        'code' => 'DGV',
        'name' => '다우 가프 필스',
      ),
      28 => 
      array (
        'code' => 'JGV',
        'name' => '옐 가바',
      ),
      29 => 
      array (
        'code' => 'JUR',
        'name' => '유르 말라',
      ),
      30 => 
      array (
        'code' => 'LPK',
        'name' => '리예 파야',
      ),
      31 => 
      array (
        'code' => 'RZK',
        'name' => '레제',
      ),
      32 => 
      array (
        'code' => 'RGA',
        'name' => '리가',
      ),
      33 => 
      array (
        'code' => 'VSL',
        'name' => '벤츠 필스',
      ),
    ),
    'LY' => 
    array (
      1 => 
      array (
        'code' => 'AJ',
        'name' => '아즈 다비아',
      ),
      2 => 
      array (
        'code' => 'AZ',
        'name' => '알 Aziziyah',
      ),
      3 => 
      array (
        'code' => 'FA',
        'name' => '알의 Fatih',
      ),
      4 => 
      array (
        'code' => 'JA',
        'name' => '알 자발 알 Akhdar',
      ),
      5 => 
      array (
        'code' => 'JU',
        'name' => '알 Jufrah',
      ),
      6 => 
      array (
        'code' => 'KH',
        'name' => '알 Khums',
      ),
      7 => 
      array (
        'code' => 'KU',
        'name' => '알 Kufrah 발',
      ),
      8 => 
      array (
        'code' => 'NK',
        'name' => 'Nuqat 알 Khams',
      ),
      9 => 
      array (
        'code' => 'AS',
        'name' => '애쉬 SHATI',
      ),
      10 => 
      array (
        'code' => 'AW',
        'name' => 'Awbari',
      ),
      11 => 
      array (
        'code' => 'ZA',
        'name' => '아즈 Zawiyah',
      ),
      12 => 
      array (
        'code' => 'BA',
        'name' => '방 가지',
      ),
      13 => 
      array (
        'code' => 'DA',
        'name' => 'Darnah',
      ),
      14 => 
      array (
        'code' => 'GD',
        'name' => 'Ghadamis',
      ),
      15 => 
      array (
        'code' => 'GY',
        'name' => 'Gharyan',
      ),
      16 => 
      array (
        'code' => 'MI',
        'name' => '미스 라타',
      ),
      17 => 
      array (
        'code' => 'MZ',
        'name' => 'Murzuq',
      ),
      18 => 
      array (
        'code' => 'SB',
        'name' => '사바',
      ),
      19 => 
      array (
        'code' => 'SW',
        'name' => 'Sawfajjin',
      ),
      20 => 
      array (
        'code' => 'SU',
        'name' => 'Surt',
      ),
      21 => 
      array (
        'code' => 'TL',
        'name' => '타라 불루스 (트리폴리',
      ),
      22 => 
      array (
        'code' => 'TH',
        'name' => 'Tarhunah',
      ),
      23 => 
      array (
        'code' => 'TU',
        'name' => 'Tubruq',
      ),
      24 => 
      array (
        'code' => 'YA',
        'name' => 'Yafran',
      ),
      25 => 
      array (
        'code' => 'ZL',
        'name' => 'Zlitan',
      ),
    ),
    'MA' => 
    array (
      1 => 
      array (
        'code' => 'AGD',
        'name' => '아가 디르',
      ),
      2 => 
      array (
        'code' => 'HOC',
        'name' => '알 호세 이마',
      ),
      3 => 
      array (
        'code' => 'AZI',
        'name' => '아질 랄',
      ),
      4 => 
      array (
        'code' => 'BME',
        'name' => '베니 메랄',
      ),
      5 => 
      array (
        'code' => 'BSL',
        'name' => '벤 스리',
      ),
      6 => 
      array (
        'code' => 'BLM',
        'name' => '보울 레마',
      ),
      7 => 
      array (
        'code' => 'CBL',
        'name' => '카사 블랑카',
      ),
      8 => 
      array (
        'code' => 'CHA',
        'name' => 'Chaouen',
      ),
      9 => 
      array (
        'code' => 'EJA',
        'name' => '엘 자 디다',
      ),
      10 => 
      array (
        'code' => 'EKS',
        'name' => '엘 Kelaa 데 Sraghna',
      ),
      11 => 
      array (
        'code' => 'ERA',
        'name' => '어 Rachidia',
      ),
      12 => 
      array (
        'code' => 'ESS',
        'name' => '에사우이라',
      ),
      13 => 
      array (
        'code' => 'FES',
        'name' => '페스',
      ),
      14 => 
      array (
        'code' => 'FIG',
        'name' => 'Figuig',
      ),
      15 => 
      array (
        'code' => 'GLM',
        'name' => '구엘 밈',
      ),
      16 => 
      array (
        'code' => 'IFR',
        'name' => '이프 란',
      ),
      17 => 
      array (
        'code' => 'KEN',
        'name' => '케니 트라',
      ),
      18 => 
      array (
        'code' => 'KHM',
        'name' => 'Khemisset',
      ),
      19 => 
      array (
        'code' => 'KHN',
        'name' => '케니 프라',
      ),
      20 => 
      array (
        'code' => 'KHO',
        'name' => '쿠 리브가',
      ),
      21 => 
      array (
        'code' => 'LYN',
        'name' => 'Laayoune 발',
      ),
      22 => 
      array (
        'code' => 'LAR',
        'name' => 'Larache',
      ),
      23 => 
      array (
        'code' => 'MRK',
        'name' => '마라케시',
      ),
      24 => 
      array (
        'code' => 'MKN',
        'name' => '메크 네스',
      ),
      25 => 
      array (
        'code' => 'NAD',
        'name' => '나도 르',
      ),
      26 => 
      array (
        'code' => 'ORZ',
        'name' => '우 아르 자자 트',
      ),
      27 => 
      array (
        'code' => 'OUJ',
        'name' => '우즈',
      ),
      28 => 
      array (
        'code' => 'RSA',
        'name' => '라바트 - 살레',
      ),
      29 => 
      array (
        'code' => 'SAF',
        'name' => '사피',
      ),
      30 => 
      array (
        'code' => 'SET',
        'name' => 'Settat',
      ),
      31 => 
      array (
        'code' => 'SKA',
        'name' => '시디 Kacem',
      ),
      32 => 
      array (
        'code' => 'TGR',
        'name' => '탕헤르',
      ),
      33 => 
      array (
        'code' => 'TAN',
        'name' => '탄 - 탄',
      ),
      34 => 
      array (
        'code' => 'TAO',
        'name' => 'Taounate',
      ),
      35 => 
      array (
        'code' => 'TRD',
        'name' => '타루 단트',
      ),
      36 => 
      array (
        'code' => 'TAT',
        'name' => '타타',
      ),
      37 => 
      array (
        'code' => 'TAZ',
        'name' => 'Taza의',
      ),
      38 => 
      array (
        'code' => 'TET',
        'name' => '테 투안',
      ),
      39 => 
      array (
        'code' => 'TIZ',
        'name' => '티즈 니트',
      ),
      40 => 
      array (
        'code' => 'ADK',
        'name' => '광고 흘라',
      ),
      41 => 
      array (
        'code' => 'BJD',
        'name' => 'Boujdour',
      ),
      42 => 
      array (
        'code' => 'ESM',
        'name' => '에스 Smara',
      ),
    ),
    'MC' => 
    array (
      1 => 
      array (
        'code' => 'FV',
        'name' => '퐁비에 이유',
      ),
      2 => 
      array (
        'code' => 'LC',
        'name' => '라 콩 다민',
      ),
      3 => 
      array (
        'code' => 'MV',
        'name' => '모나코 빌',
      ),
      4 => 
      array (
        'code' => 'MC',
        'name' => '몬테카를로',
      ),
    ),
    'MD' => 
    array (
      1 => 
      array (
        'code' => 'GA',
        'name' => '가가 우 지아',
      ),
      2 => 
      array (
        'code' => 'CU',
        'name' => '키시 나우',
      ),
      3 => 
      array (
        'code' => 'BA',
        'name' => '볼티',
      ),
      4 => 
      array (
        'code' => 'CA',
        'name' => 'Cahul',
      ),
      5 => 
      array (
        'code' => 'ED',
        'name' => 'EDINET',
      ),
      6 => 
      array (
        'code' => 'LA',
        'name' => 'Lapusna',
      ),
      7 => 
      array (
        'code' => 'OR',
        'name' => 'Orhei',
      ),
      8 => 
      array (
        'code' => 'SO',
        'name' => 'Soroca',
      ),
      9 => 
      array (
        'code' => 'TI',
        'name' => 'Tighina',
      ),
      10 => 
      array (
        'code' => 'UN',
        'name' => 'Ungheni',
      ),
      11 => 
      array (
        'code' => 'SN',
        'name' => '스탄가 Nistrului',
      ),
    ),
    'MG' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => '안타나나리보',
      ),
      2 => 
      array (
        'code' => 'AS',
        'name' => 'Antsiranana 발',
      ),
      3 => 
      array (
        'code' => 'FN',
        'name' => 'Fianarantsoa에',
      ),
      4 => 
      array (
        'code' => 'MJ',
        'name' => 'Mahajanga에',
      ),
      5 => 
      array (
        'code' => 'TM',
        'name' => '토아 마시나',
      ),
      6 => 
      array (
        'code' => 'TL',
        'name' => 'Toliara의',
      ),
    ),
    'MH' => 
    array (
      1 => 
      array (
        'code' => 'ALG',
        'name' => 'Ailinginae',
      ),
      2 => 
      array (
        'code' => 'ALL',
        'name' => 'Ailinglaplap',
      ),
      3 => 
      array (
        'code' => 'ALK',
        'name' => 'Ailuk',
      ),
      4 => 
      array (
        'code' => 'ARN',
        'name' => '아르노',
      ),
      5 => 
      array (
        'code' => 'AUR',
        'name' => 'AUR',
      ),
      6 => 
      array (
        'code' => 'BKR',
        'name' => 'BIKAR',
      ),
      7 => 
      array (
        'code' => 'BKN',
        'name' => '비키니',
      ),
      8 => 
      array (
        'code' => 'BKK',
        'name' => 'Bokak',
      ),
      9 => 
      array (
        'code' => 'EBN',
        'name' => '칠흑',
      ),
      10 => 
      array (
        'code' => 'ENT',
        'name' => 'Enewetak',
      ),
      11 => 
      array (
        'code' => 'EKB',
        'name' => 'Erikub',
      ),
      12 => 
      array (
        'code' => 'JBT',
        'name' => 'Jabat',
      ),
      13 => 
      array (
        'code' => 'JLT',
        'name' => 'Jaluit',
      ),
      14 => 
      array (
        'code' => 'JEM',
        'name' => 'Jemo',
      ),
      15 => 
      array (
        'code' => 'KIL',
        'name' => 'Kili',
      ),
      16 => 
      array (
        'code' => 'KWJ',
        'name' => '콰 잘렌',
      ),
      17 => 
      array (
        'code' => 'LAE',
        'name' => '라이',
      ),
      18 => 
      array (
        'code' => 'LIB',
        'name' => '리브',
      ),
      19 => 
      array (
        'code' => 'LKP',
        'name' => 'Likiep',
      ),
      20 => 
      array (
        'code' => 'MJR',
        'name' => '마주',
      ),
      21 => 
      array (
        'code' => 'MLP',
        'name' => 'Maloelap',
      ),
      22 => 
      array (
        'code' => 'MJT',
        'name' => 'Mejit',
      ),
      23 => 
      array (
        'code' => 'MIL',
        'name' => 'MILI',
      ),
      24 => 
      array (
        'code' => 'NMK',
        'name' => 'Namorik',
      ),
      25 => 
      array (
        'code' => 'NAM',
        'name' => 'NAMU',
      ),
      26 => 
      array (
        'code' => 'RGL',
        'name' => '론지 랩',
      ),
      27 => 
      array (
        'code' => 'RGK',
        'name' => 'Rongrik',
      ),
      28 => 
      array (
        'code' => 'TOK',
        'name' => '모금',
      ),
      29 => 
      array (
        'code' => 'UJA',
        'name' => 'Ujae',
      ),
      30 => 
      array (
        'code' => 'UJL',
        'name' => 'Ujelang',
      ),
      31 => 
      array (
        'code' => 'UTK',
        'name' => 'Utirik',
      ),
      32 => 
      array (
        'code' => 'WTH',
        'name' => 'Wotho',
      ),
      33 => 
      array (
        'code' => 'WTJ',
        'name' => 'Wotje',
      ),
    ),
    'MK' => 
    array (
      1 => 
      array (
        'code' => 'AER',
        'name' => 'Aerodrom',
      ),
      2 => 
      array (
        'code' => 'ARA',
        'name' => 'Aračinovo',
      ),
      3 => 
      array (
        'code' => 'BER',
        'name' => 'Berovo',
      ),
      4 => 
      array (
        'code' => 'BIT',
        'name' => '비 톨라',
      ),
      5 => 
      array (
        'code' => 'BOG',
        'name' => 'Bogdanci',
      ),
      6 => 
      array (
        'code' => 'BOG',
        'name' => 'Bogovinje',
      ),
      7 => 
      array (
        'code' => 'BOS',
        'name' => 'Bosilovo',
      ),
      8 => 
      array (
        'code' => 'BRV',
        'name' => 'Brvenica',
      ),
      9 => 
      array (
        'code' => 'BUT',
        'name' => 'Butel',
      ),
      10 => 
      array (
        'code' => 'ČAI',
        'name' => 'CAIR',
      ),
      11 => 
      array (
        'code' => 'ČAš',
        'name' => 'Čaška',
      ),
      12 => 
      array (
        'code' => 'CEN',
        'name' => 'CENTAR',
      ),
      13 => 
      array (
        'code' => 'CEN',
        'name' => 'CENTAR 주파',
      ),
      14 => 
      array (
        'code' => 'Češ',
        'name' => 'Češinovo-Obleš',
      ),
      15 => 
      array (
        'code' => 'ČUČ',
        'name' => 'Čučer-Sandevo',
      ),
      16 => 
      array (
        'code' => 'DEB',
        'name' => '제외하다',
      ),
      17 => 
      array (
        'code' => 'DEB',
        'name' => 'Debarca',
      ),
      18 => 
      array (
        'code' => 'DEL',
        'name' => 'Delčevo',
      ),
      19 => 
      array (
        'code' => 'DEM',
        'name' => '미르 히 사르',
      ),
      20 => 
      array (
        'code' => 'DEM',
        'name' => '미르 Kapija',
      ),
      21 => 
      array (
        'code' => 'DOL',
        'name' => 'Dolneni',
      ),
      22 => 
      array (
        'code' => 'DRU',
        'name' => 'Drugovo',
      ),
      23 => 
      array (
        'code' => 'GAZ',
        'name' => 'Gazi의 바바',
      ),
      24 => 
      array (
        'code' => 'GEV',
        'name' => '제브 젤리아',
      ),
      25 => 
      array (
        'code' => 'GJO',
        'name' => 'Gjorče 페트로프',
      ),
      26 => 
      array (
        'code' => 'GOS',
        'name' => '고 스티',
      ),
      27 => 
      array (
        'code' => 'GRA',
        'name' => 'Gradsko',
      ),
      28 => 
      array (
        'code' => 'ILI',
        'name' => 'Ilinden',
      ),
      29 => 
      array (
        'code' => 'JEG',
        'name' => 'Jegunovce',
      ),
      30 => 
      array (
        'code' => 'KAR',
        'name' => 'Karbinci',
      ),
      31 => 
      array (
        'code' => 'KAR',
        'name' => '정보 Karpos',
      ),
      32 => 
      array (
        'code' => 'KAV',
        'name' => 'Kavadarci',
      ),
      33 => 
      array (
        'code' => 'KIČ',
        'name' => 'Kičevo',
      ),
      34 => 
      array (
        'code' => 'KIS',
        'name' => 'Kisela Voda에서',
      ),
      35 => 
      array (
        'code' => 'KOč',
        'name' => 'Kocani의',
      ),
      36 => 
      array (
        'code' => 'KON',
        'name' => 'Konče',
      ),
      37 => 
      array (
        'code' => 'KRA',
        'name' => 'Kratovo',
      ),
      38 => 
      array (
        'code' => 'KRI',
        'name' => '크리 바 팔랑',
      ),
      39 => 
      array (
        'code' => 'KRI',
        'name' => 'Krivogaštani',
      ),
      40 => 
      array (
        'code' => 'KRU',
        'name' => 'Kruševo',
      ),
      41 => 
      array (
        'code' => 'KUM',
        'name' => '쿠마 노보',
      ),
      42 => 
      array (
        'code' => 'LIP',
        'name' => 'Lipkovo',
      ),
      43 => 
      array (
        'code' => 'LOZ',
        'name' => 'Lozovo',
      ),
      44 => 
      array (
        'code' => 'MAK',
        'name' => 'Makedonska Kamenica',
      ),
      45 => 
      array (
        'code' => 'MAK',
        'name' => 'Makedonski 브로드',
      ),
      46 => 
      array (
        'code' => 'MAV',
        'name' => 'Mavrovo에와 Rostuša',
      ),
      47 => 
      array (
        'code' => 'MOG',
        'name' => 'Mogila',
      ),
      48 => 
      array (
        'code' => 'NEG',
        'name' => 'Negotino',
      ),
      49 => 
      array (
        'code' => 'NOV',
        'name' => 'Novaci',
      ),
      50 => 
      array (
        'code' => 'NOV',
        'name' => '노보 가량',
      ),
      51 => 
      array (
        'code' => 'OHR',
        'name' => '오흐 리드',
      ),
      52 => 
      array (
        'code' => 'OSL',
        'name' => 'Oslomej',
      ),
      53 => 
      array (
        'code' => 'PEH',
        'name' => 'Pehčevo',
      ),
      54 => 
      array (
        'code' => 'PET',
        'name' => 'Petrovec',
      ),
      55 => 
      array (
        'code' => 'PLA',
        'name' => 'Plasnica',
      ),
      56 => 
      array (
        'code' => 'PRI',
        'name' => '프릴 레프',
      ),
      57 => 
      array (
        'code' => 'PRO',
        'name' => 'Probištip',
      ),
      58 => 
      array (
        'code' => 'RAD',
        'name' => 'Radoviš',
      ),
      59 => 
      array (
        'code' => 'RAN',
        'name' => 'Rankovce',
      ),
      60 => 
      array (
        'code' => 'RES',
        'name' => '레센',
      ),
      61 => 
      array (
        'code' => 'ROS',
        'name' => 'Rosoman',
      ),
      62 => 
      array (
        'code' => 'SAR',
        'name' => 'Saraj',
      ),
      63 => 
      array (
        'code' => 'SOP',
        'name' => 'Sopište',
      ),
      64 => 
      array (
        'code' => 'STA',
        'name' => 'Dojran 스타',
      ),
      65 => 
      array (
        'code' => 'STA',
        'name' => 'Staro Nagoričane',
      ),
      66 => 
      array (
        'code' => 'ŠTI',
        'name' => 'STIP',
      ),
      67 => 
      array (
        'code' => 'STR',
        'name' => '스트 루가',
      ),
      68 => 
      array (
        'code' => 'STR',
        'name' => '스트 루미',
      ),
      69 => 
      array (
        'code' => 'STU',
        'name' => 'Studeničani',
      ),
      70 => 
      array (
        'code' => 'ŠUT',
        'name' => '수토 Orizari',
      ),
      71 => 
      array (
        'code' => 'SVE',
        'name' => '베티 니콜',
      ),
      72 => 
      array (
        'code' => 'TEA',
        'name' => 'Tearce',
      ),
      73 => 
      array (
        'code' => 'TET',
        'name' => '테 토보',
      ),
      74 => 
      array (
        'code' => 'VAL',
        'name' => 'Valandovo',
      ),
      75 => 
      array (
        'code' => 'VAS',
        'name' => 'Vasilevo',
      ),
      76 => 
      array (
        'code' => 'VEL',
        'name' => '벨 레스',
      ),
      77 => 
      array (
        'code' => 'VEV',
        'name' => 'Vevčani',
      ),
      78 => 
      array (
        'code' => 'VIN',
        'name' => 'Vinica',
      ),
      79 => 
      array (
        'code' => 'VRA',
        'name' => 'Vraneštica',
      ),
      80 => 
      array (
        'code' => 'VRA',
        'name' => 'Vrapčište',
      ),
      81 => 
      array (
        'code' => 'ZAJ',
        'name' => 'Zajas',
      ),
      82 => 
      array (
        'code' => 'ZEL',
        'name' => 'Zelenikovo',
      ),
      83 => 
      array (
        'code' => 'ŽEL',
        'name' => 'Želino',
      ),
      84 => 
      array (
        'code' => 'ZRN',
        'name' => 'Zrnovci',
      ),
    ),
    'ML' => 
    array (
      1 => 
      array (
        'code' => 'GA',
        'name' => '가오',
      ),
      2 => 
      array (
        'code' => 'KY',
        'name' => '카이스',
      ),
      3 => 
      array (
        'code' => 'KD',
        'name' => 'Kidal',
      ),
      4 => 
      array (
        'code' => 'KL',
        'name' => 'Koulikoro',
      ),
      5 => 
      array (
        'code' => 'MP',
        'name' => '몹티',
      ),
      6 => 
      array (
        'code' => 'SG',
        'name' => '세그',
      ),
      7 => 
      array (
        'code' => 'SK',
        'name' => '시카 소',
      ),
      8 => 
      array (
        'code' => 'TB',
        'name' => '톰 부토',
      ),
      9 => 
      array (
        'code' => 'CD',
        'name' => '바마코 자본 지구',
      ),
    ),
    'MM' => 
    array (
      1 => 
      array (
        'code' => 'AY',
        'name' => '와디',
      ),
      2 => 
      array (
        'code' => 'BG',
        'name' => '바고',
      ),
      3 => 
      array (
        'code' => 'MG',
        'name' => 'Magway',
      ),
      4 => 
      array (
        'code' => 'MD',
        'name' => '만달레이',
      ),
      5 => 
      array (
        'code' => 'SG',
        'name' => '사가 잉',
      ),
      6 => 
      array (
        'code' => 'TN',
        'name' => 'Tanintharyi',
      ),
      7 => 
      array (
        'code' => 'YG',
        'name' => '양곤',
      ),
      8 => 
      array (
        'code' => 'CH',
        'name' => '친 주',
      ),
      9 => 
      array (
        'code' => 'KC',
        'name' => '카친 주',
      ),
      10 => 
      array (
        'code' => 'KH',
        'name' => '카야 주',
      ),
      11 => 
      array (
        'code' => 'KN',
        'name' => 'Kayin 주',
      ),
      12 => 
      array (
        'code' => 'MN',
        'name' => '월 주',
      ),
      13 => 
      array (
        'code' => 'RK',
        'name' => '라카 인 주',
      ),
      14 => 
      array (
        'code' => 'SH',
        'name' => '샨 주',
      ),
    ),
    'MN' => 
    array (
      1 => 
      array (
        'code' => '1',
        'name' => 'Ulanbaatar',
      ),
      2 => 
      array (
        'code' => '035',
        'name' => 'Orhon',
      ),
      3 => 
      array (
        'code' => '037',
        'name' => 'Darhan UUL',
      ),
      4 => 
      array (
        'code' => '039',
        'name' => 'Hentiy',
      ),
      5 => 
      array (
        'code' => '041',
        'name' => 'Hovsgol',
      ),
      6 => 
      array (
        'code' => '043',
        'name' => '호브 드',
      ),
      7 => 
      array (
        'code' => '046',
        'name' => 'UVS',
      ),
      8 => 
      array (
        'code' => '047',
        'name' => '토브',
      ),
      9 => 
      array (
        'code' => '049',
        'name' => 'Selenge',
      ),
      10 => 
      array (
        'code' => '051',
        'name' => 'Suhbaatar',
      ),
      11 => 
      array (
        'code' => '053',
        'name' => 'Omnogovi',
      ),
      12 => 
      array (
        'code' => '055',
        'name' => 'Ovorhangay',
      ),
      13 => 
      array (
        'code' => '057',
        'name' => 'Dzavhan',
      ),
      14 => 
      array (
        'code' => '059',
        'name' => 'DundgovL',
      ),
      15 => 
      array (
        'code' => '061',
        'name' => 'Dornod',
      ),
      16 => 
      array (
        'code' => '063',
        'name' => 'Dornogov',
      ),
      17 => 
      array (
        'code' => '064',
        'name' => '고비 Sumber',
      ),
      18 => 
      array (
        'code' => '065',
        'name' => '고비 알타이',
      ),
      19 => 
      array (
        'code' => '067',
        'name' => 'Bulgan',
      ),
      20 => 
      array (
        'code' => '069',
        'name' => 'Bayanhongor',
      ),
      21 => 
      array (
        'code' => '071',
        'name' => '얀 - Olgiy',
      ),
      22 => 
      array (
        'code' => '073',
        'name' => 'Arhangay',
      ),
    ),
    'MO' => 
    array (
      1 => 
      array (
        'code' => 'OLF',
        'name' => '파티마 성모 마리아 교구',
      ),
      2 => 
      array (
        'code' => 'ANT',
        'name' => '세인트 안토니 교구',
      ),
      3 => 
      array (
        'code' => 'LAZ',
        'name' => '세인트 나사로 교구',
      ),
      4 => 
      array (
        'code' => 'CAT',
        'name' => '성당 교구',
      ),
      5 => 
      array (
        'code' => 'LAW',
        'name' => '세인트 로렌스 교구',
      ),
    ),
    'MP' => 
    array (
      1 => 
      array (
        'code' => 'N',
        'name' => '북 아일랜드',
      ),
      2 => 
      array (
        'code' => 'R',
        'name' => '로타',
      ),
      3 => 
      array (
        'code' => 'S',
        'name' => '사이판',
      ),
      4 => 
      array (
        'code' => 'T',
        'name' => '티니안',
      ),
    ),
    'MQ' => 
    array (
      1 => 
      array (
        'code' => 'LAJ',
        'name' => 'L 리버에 - 부용',
      ),
      2 => 
      array (
        'code' => 'LES',
        'name' => '레 Anses-dArlet',
      ),
      3 => 
      array (
        'code' => 'BAS',
        'name' => '바스 포인트',
      ),
      4 => 
      array (
        'code' => 'BEL',
        'name' => '벨 파운 튼',
      ),
      5 => 
      array (
        'code' => 'LE',
        'name' => '르 까르 베',
      ),
      6 => 
      array (
        'code' => 'CAS',
        'name' => '케이스 PILOTE',
      ),
      7 => 
      array (
        'code' => 'LE',
        'name' => '라 디아 망',
      ),
      8 => 
      array (
        'code' => 'DUC',
        'name' => 'Ducos',
      ),
      9 => 
      array (
        'code' => 'FON',
        'name' => '드퐁 - 생 드니',
      ),
      10 => 
      array (
        'code' => 'FOR',
        'name' => '포르 드 프랑스',
      ),
      11 => 
      array (
        'code' => 'LE',
        'name' => '르 프랑소아',
      ),
      12 => 
      array (
        'code' => 'GRA',
        'name' => 'Grand Rivière',
      ),
      13 => 
      array (
        'code' => 'GRO',
        'name' => '그로스 - 몬',
      ),
      14 => 
      array (
        'code' => 'LE',
        'name' => '르 Lamentin',
      ),
      15 => 
      array (
        'code' => 'LE',
        'name' => '르 Lorrain',
      ),
      16 => 
      array (
        'code' => 'MAC',
        'name' => 'Macouba',
      ),
      17 => 
      array (
        'code' => 'LE',
        'name' => '르 마리',
      ),
      18 => 
      array (
        'code' => 'LE',
        'name' => '르 마린',
      ),
      19 => 
      array (
        'code' => 'LE',
        'name' => '르 몬 루즈',
      ),
      20 => 
      array (
        'code' => 'LE',
        'name' => '르 몬 - 수직',
      ),
      21 => 
      array (
        'code' => 'LE',
        'name' => '르 Prêcheur',
      ),
      22 => 
      array (
        'code' => 'RIV',
        'name' => '리비에르 PILOTE',
      ),
      23 => 
      array (
        'code' => 'RIV',
        'name' => '리비에르 Salée',
      ),
      24 => 
      array (
        'code' => 'LE',
        'name' => '르 로버트',
      ),
      25 => 
      array (
        'code' => 'SAI',
        'name' => '상테',
      ),
      26 => 
      array (
        'code' => 'SAI',
        'name' => '생 뤼스',
      ),
      27 => 
      array (
        'code' => 'SAI',
        'name' => '생트 마리',
      ),
      28 => 
      array (
        'code' => 'SAI',
        'name' => '생 에스프리',
      ),
      29 => 
      array (
        'code' => 'SAI',
        'name' => '세인트 조셉',
      ),
      30 => 
      array (
        'code' => 'SAI',
        'name' => '생 피에르',
      ),
      31 => 
      array (
        'code' => 'SCH',
        'name' => '쇨 세르',
      ),
      32 => 
      array (
        'code' => 'LA',
        'name' => '라 트리니티',
      ),
      33 => 
      array (
        'code' => 'LES',
        'name' => '레 트 왈레',
      ),
      34 => 
      array (
        'code' => 'LE',
        'name' => '르 Vauclin',
      ),
    ),
    'MR' => 
    array (
      1 => 
      array (
        'code' => 'AD',
        'name' => '아 드라',
      ),
      2 => 
      array (
        'code' => 'AS',
        'name' => 'Assaba',
      ),
      3 => 
      array (
        'code' => 'BR',
        'name' => 'Brakna',
      ),
      4 => 
      array (
        'code' => 'DN',
        'name' => '누 아디를 Dakhlet',
      ),
      5 => 
      array (
        'code' => 'GO',
        'name' => 'Gorgol',
      ),
      6 => 
      array (
        'code' => 'GM',
        'name' => 'Guidimaka',
      ),
      7 => 
      array (
        'code' => 'HC',
        'name' => 'Hodh ECH Chargui',
      ),
      8 => 
      array (
        'code' => 'HG',
        'name' => 'Hodh 엘 Gharbi',
      ),
      9 => 
      array (
        'code' => 'IN',
        'name' => 'Inchiri',
      ),
      10 => 
      array (
        'code' => 'TA',
        'name' => 'Tagant',
      ),
      11 => 
      array (
        'code' => 'TZ',
        'name' => 'Tiris 무르',
      ),
      12 => 
      array (
        'code' => 'TR',
        'name' => '트라 르자',
      ),
      13 => 
      array (
        'code' => 'NO',
        'name' => '누악 쇼트',
      ),
    ),
    'MS' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => '세인트 안토니',
      ),
      2 => 
      array (
        'code' => 'G',
        'name' => '세인트 조지',
      ),
      3 => 
      array (
        'code' => 'P',
        'name' => '세인트 피터',
      ),
    ),
    'MT' => 
    array (
      1 => 
      array (
        'code' => 'ATT',
        'name' => '타드',
      ),
      2 => 
      array (
        'code' => 'BAL',
        'name' => '발잔',
      ),
      3 => 
      array (
        'code' => 'BGU',
        'name' => 'Birgu',
      ),
      4 => 
      array (
        'code' => 'BKK',
        'name' => '비르 키르 카라',
      ),
      5 => 
      array (
        'code' => 'BRZ',
        'name' => 'Birzebbuga',
      ),
      6 => 
      array (
        'code' => 'BOR',
        'name' => 'Bormla',
      ),
      7 => 
      array (
        'code' => 'DIN',
        'name' => 'DINGLI',
      ),
      8 => 
      array (
        'code' => 'FGU',
        'name' => 'Fgura',
      ),
      9 => 
      array (
        'code' => 'FLO',
        'name' => '플로리 아나',
      ),
      10 => 
      array (
        'code' => 'GDJ',
        'name' => 'Gudja',
      ),
      11 => 
      array (
        'code' => 'GZR',
        'name' => '지라',
      ),
      12 => 
      array (
        'code' => 'GRG',
        'name' => 'Gargur',
      ),
      13 => 
      array (
        'code' => 'GXQ',
        'name' => 'Gaxaq',
      ),
      14 => 
      array (
        'code' => 'HMR',
        'name' => 'Hamrun',
      ),
      15 => 
      array (
        'code' => 'IKL',
        'name' => 'Iklin',
      ),
      16 => 
      array (
        'code' => 'ISL',
        'name' => '이슬라',
      ),
      17 => 
      array (
        'code' => 'KLK',
        'name' => 'Kalkara에',
      ),
      18 => 
      array (
        'code' => 'KRK',
        'name' => 'Kirkop',
      ),
      19 => 
      array (
        'code' => 'LIJ',
        'name' => 'LIJA',
      ),
      20 => 
      array (
        'code' => 'LUQ',
        'name' => '루카',
      ),
      21 => 
      array (
        'code' => 'MRS',
        'name' => '마르 사',
      ),
      22 => 
      array (
        'code' => 'MKL',
        'name' => 'Marsaskala',
      ),
      23 => 
      array (
        'code' => 'MXL',
        'name' => 'Marsaxlokk',
      ),
      24 => 
      array (
        'code' => 'MDN',
        'name' => '엠디',
      ),
      25 => 
      array (
        'code' => 'MEL',
        'name' => 'Melliea',
      ),
      26 => 
      array (
        'code' => 'MGR',
        'name' => '임좌',
      ),
      27 => 
      array (
        'code' => 'MST',
        'name' => '에서 Mosta',
      ),
      28 => 
      array (
        'code' => 'MQA',
        'name' => 'Mqabba',
      ),
      29 => 
      array (
        'code' => 'MSI',
        'name' => '엠시다',
      ),
      30 => 
      array (
        'code' => 'MTF',
        'name' => 'Mtarfa',
      ),
      31 => 
      array (
        'code' => 'NAX',
        'name' => 'Naxxar의',
      ),
      32 => 
      array (
        'code' => 'PAO',
        'name' => '파올라',
      ),
      33 => 
      array (
        'code' => 'PEM',
        'name' => '펨 브로크',
      ),
      34 => 
      array (
        'code' => 'PIE',
        'name' => '피에타',
      ),
      35 => 
      array (
        'code' => 'QOR',
        'name' => '에서 Qormi',
      ),
      36 => 
      array (
        'code' => 'QRE',
        'name' => 'Qrendi',
      ),
      37 => 
      array (
        'code' => 'RAB',
        'name' => '라바트',
      ),
      38 => 
      array (
        'code' => 'SAF',
        'name' => '사피',
      ),
      39 => 
      array (
        'code' => 'SGI',
        'name' => '산 Giljan',
      ),
      40 => 
      array (
        'code' => 'SLU',
        'name' => '산타 루치아',
      ),
      41 => 
      array (
        'code' => 'SPB',
        'name' => '산 파울 IL-바하',
      ),
      42 => 
      array (
        'code' => 'SGW',
        'name' => '산 Gwann',
      ),
      43 => 
      array (
        'code' => 'SVE',
        'name' => '산타 베네',
      ),
      44 => 
      array (
        'code' => 'SIG',
        'name' => 'Siggiewi의',
      ),
      45 => 
      array (
        'code' => 'SLM',
        'name' => '슬리에 마',
      ),
      46 => 
      array (
        'code' => 'SWQ',
        'name' => 'Swieqi',
      ),
      47 => 
      array (
        'code' => 'TXB',
        'name' => '따 Xbiex',
      ),
      48 => 
      array (
        'code' => 'TRX',
        'name' => '타르',
      ),
      49 => 
      array (
        'code' => 'VLT',
        'name' => '발레타',
      ),
      50 => 
      array (
        'code' => 'XGJ',
        'name' => 'Xgajra',
      ),
      51 => 
      array (
        'code' => 'ZBR',
        'name' => 'Zabbar',
      ),
      52 => 
      array (
        'code' => 'ZBG',
        'name' => 'Zebbug',
      ),
      53 => 
      array (
        'code' => 'ZJT',
        'name' => '에서 Zejtun',
      ),
      54 => 
      array (
        'code' => 'ZRQ',
        'name' => '에서 Zurrieq',
      ),
      55 => 
      array (
        'code' => 'FNT',
        'name' => '폰타나',
      ),
      56 => 
      array (
        'code' => 'GHJ',
        'name' => '가인 살렘',
      ),
      57 => 
      array (
        'code' => 'GHR',
        'name' => 'Gharb에',
      ),
      58 => 
      array (
        'code' => 'GHS',
        'name' => 'Ghasri의',
      ),
      59 => 
      array (
        'code' => 'KRC',
        'name' => 'Kercem',
      ),
      60 => 
      array (
        'code' => 'MUN',
        'name' => 'Munxar',
      ),
      61 => 
      array (
        'code' => 'NAD',
        'name' => 'Nadur에',
      ),
      62 => 
      array (
        'code' => 'QAL',
        'name' => 'Qala에',
      ),
      63 => 
      array (
        'code' => 'VIC',
        'name' => '빅토리아',
      ),
      64 => 
      array (
        'code' => 'SLA',
        'name' => '산 로렌츠',
      ),
      65 => 
      array (
        'code' => 'SNT',
        'name' => 'Sannat의',
      ),
      66 => 
      array (
        'code' => 'ZAG',
        'name' => 'Xagra',
      ),
      67 => 
      array (
        'code' => 'XEW',
        'name' => '키아',
      ),
      68 => 
      array (
        'code' => 'ZEB',
        'name' => 'Zebbug',
      ),
    ),
    'MU' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => 'Agalega 제도',
      ),
      2 => 
      array (
        'code' => 'BL',
        'name' => '블랙 리버',
      ),
      3 => 
      array (
        'code' => 'BR',
        'name' => '보 바신 - 로즈 힐',
      ),
      4 => 
      array (
        'code' => 'CC',
        'name' => 'Cargados Carajos 숄 (세인트 B',
      ),
      5 => 
      array (
        'code' => 'CU',
        'name' => '크레 피페',
      ),
      6 => 
      array (
        'code' => 'FL',
        'name' => '플 락크',
      ),
      7 => 
      array (
        'code' => 'GP',
        'name' => '그랜드 포트',
      ),
      8 => 
      array (
        'code' => 'MO',
        'name' => '모카',
      ),
      9 => 
      array (
        'code' => 'PA',
        'name' => '팜 플러 무스',
      ),
      10 => 
      array (
        'code' => 'PL',
        'name' => '포트 루이스',
      ),
      11 => 
      array (
        'code' => 'PU',
        'name' => '포트 루이스',
      ),
      12 => 
      array (
        'code' => 'PW',
        'name' => '플레인 Wilhems',
      ),
      13 => 
      array (
        'code' => 'QB',
        'name' => '쿠아 Bornes에',
      ),
      14 => 
      array (
        'code' => 'RO',
        'name' => '로드리게스',
      ),
      15 => 
      array (
        'code' => 'RR',
        'name' => '리비에르 뒤 Rempart에서',
      ),
      16 => 
      array (
        'code' => 'SA',
        'name' => 'Savanne',
      ),
      17 => 
      array (
        'code' => 'VP',
        'name' => 'Vacoas-피닉스',
      ),
    ),
    'MV' => 
    array (
      1 => 
      array (
        'code' => 'AAD',
        'name' => '아리아 톨 Dheknu',
      ),
      2 => 
      array (
        'code' => 'AAU',
        'name' => '아리아 톨 Uthuru',
      ),
      3 => 
      array (
        'code' => 'ADD',
        'name' => '아두',
      ),
      4 => 
      array (
        'code' => 'FAA',
        'name' => 'Faadhippolhu',
      ),
      5 => 
      array (
        'code' => 'FEA',
        'name' => 'Felidhe 아톨',
      ),
      6 => 
      array (
        'code' => 'FMU',
        'name' => 'FUA 물 라쿠',
      ),
      7 => 
      array (
        'code' => 'HAD',
        'name' => 'Huvadhu 아톨 Dhekunu',
      ),
      8 => 
      array (
        'code' => 'HAU',
        'name' => 'Huvadhu 아톨 Uthuru',
      ),
      9 => 
      array (
        'code' => 'HDH',
        'name' => 'Hadhdhunmathi',
      ),
      10 => 
      array (
        'code' => 'KLH',
        'name' => 'Kolhumadulu',
      ),
      11 => 
      array (
        'code' => 'MAA',
        'name' => '말레 아톨',
      ),
      12 => 
      array (
        'code' => 'MAD',
        'name' => 'Maalhosmadulu Dhekunu',
      ),
      13 => 
      array (
        'code' => 'MAU',
        'name' => 'Maalhosmadulu Uthuru',
      ),
      14 => 
      array (
        'code' => 'MLD',
        'name' => 'Miladhunmadulu Dhekunu',
      ),
      15 => 
      array (
        'code' => 'MLU',
        'name' => 'Miladhunmadulu Uthuru',
      ),
      16 => 
      array (
        'code' => 'MUA',
        'name' => '물 라쿠 아톨',
      ),
      17 => 
      array (
        'code' => 'NAD',
        'name' => 'Nilandhe 아톨 Dhekunu',
      ),
      18 => 
      array (
        'code' => 'NAU',
        'name' => 'Nilandhe 아톨 Uthuru',
      ),
      19 => 
      array (
        'code' => 'THD',
        'name' => 'Thiladhunmathi Dhekunu',
      ),
      20 => 
      array (
        'code' => 'THU',
        'name' => 'Thiladhunmathi Uthuru',
      ),
    ),
    'MW' => 
    array (
      1 => 
      array (
        'code' => 'BLK',
        'name' => '발라 카',
      ),
      2 => 
      array (
        'code' => 'BLT',
        'name' => '블랜 타이어',
      ),
      3 => 
      array (
        'code' => 'CKW',
        'name' => 'Chikwawa',
      ),
      4 => 
      array (
        'code' => 'CRD',
        'name' => 'Chiradzulu',
      ),
      5 => 
      array (
        'code' => 'CTP',
        'name' => 'Chitipa',
      ),
      6 => 
      array (
        'code' => 'DDZ',
        'name' => 'Dedza',
      ),
      7 => 
      array (
        'code' => 'DWA',
        'name' => '동화',
      ),
      8 => 
      array (
        'code' => 'KRG',
        'name' => 'Karonga 발',
      ),
      9 => 
      array (
        'code' => 'KSG',
        'name' => 'Kasungu',
      ),
      10 => 
      array (
        'code' => 'LKM',
        'name' => 'Likoma',
      ),
      11 => 
      array (
        'code' => 'LLG',
        'name' => '릴 롱궤',
      ),
      12 => 
      array (
        'code' => 'MCG',
        'name' => 'Machinga',
      ),
      13 => 
      array (
        'code' => 'MGC',
        'name' => '망고',
      ),
      14 => 
      array (
        'code' => 'MCH',
        'name' => 'Mchinji',
      ),
      15 => 
      array (
        'code' => 'MLJ',
        'name' => '물란',
      ),
      16 => 
      array (
        'code' => 'MWZ',
        'name' => '므 완자',
      ),
      17 => 
      array (
        'code' => 'MZM',
        'name' => 'Mzimba',
      ),
      18 => 
      array (
        'code' => 'NTU',
        'name' => 'Ntcheu',
      ),
      19 => 
      array (
        'code' => 'NKB',
        'name' => '건의 Nkhata 베이',
      ),
      20 => 
      array (
        'code' => 'NKH',
        'name' => '코타 코타',
      ),
      21 => 
      array (
        'code' => 'NSJ',
        'name' => 'Nsanje',
      ),
      22 => 
      array (
        'code' => 'NTI',
        'name' => '치시',
      ),
      23 => 
      array (
        'code' => 'PHL',
        'name' => 'Phalombe',
      ),
      24 => 
      array (
        'code' => 'RMP',
        'name' => 'Rumphi',
      ),
      25 => 
      array (
        'code' => 'SLM',
        'name' => '살 리마',
      ),
      26 => 
      array (
        'code' => 'THY',
        'name' => '티올',
      ),
      27 => 
      array (
        'code' => 'ZBA',
        'name' => '좀바',
      ),
    ),
    'MX' => 
    array (
      1 => 
      array (
        'code' => 'AGU',
        'name' => '아과 스 칼리 엔 테스',
      ),
      2 => 
      array (
        'code' => 'BCN',
        'name' => '바하 칼리 포르 니아 노르 테',
      ),
      3 => 
      array (
        'code' => 'BCS',
        'name' => '바하 칼리 포르 니아 수르',
      ),
      4 => 
      array (
        'code' => 'CAM',
        'name' => '캄 페체',
      ),
      5 => 
      array (
        'code' => 'CHP',
        'name' => '치아파스',
      ),
      6 => 
      array (
        'code' => 'CHH',
        'name' => '치와와',
      ),
      7 => 
      array (
        'code' => 'COA',
        'name' => '코아 우일 라 드 사라고사',
      ),
      8 => 
      array (
        'code' => 'COL',
        'name' => '콜리 마',
      ),
      9 => 
      array (
        'code' => 'DIF',
        'name' => '디스트 리토 페데 랄',
      ),
      10 => 
      array (
        'code' => 'DUR',
        'name' => '두 랑고',
      ),
      11 => 
      array (
        'code' => 'GUA',
        'name' => '과 나후 아토',
      ),
      12 => 
      array (
        'code' => 'GRO',
        'name' => '게레로',
      ),
      13 => 
      array (
        'code' => 'HID',
        'name' => '이달고',
      ),
      14 => 
      array (
        'code' => 'JAL',
        'name' => '할리 스코',
      ),
      15 => 
      array (
        'code' => 'MEX',
        'name' => '멕시코',
      ),
      16 => 
      array (
        'code' => 'MIC',
        'name' => '미초 아칸 데 오캄포',
      ),
      17 => 
      array (
        'code' => 'MOR',
        'name' => '모렐 로스',
      ),
      18 => 
      array (
        'code' => 'NAY',
        'name' => '나야 리트',
      ),
      19 => 
      array (
        'code' => 'NLE',
        'name' => '누에 보 레온',
      ),
      20 => 
      array (
        'code' => 'OAX',
        'name' => '오악 사카',
      ),
      21 => 
      array (
        'code' => 'PUE',
        'name' => '푸에블라',
      ),
      22 => 
      array (
        'code' => 'QUE',
        'name' => '케 레타 드 아르테 아가',
      ),
      23 => 
      array (
        'code' => 'ROO',
        'name' => '킨 타나로 오',
      ),
      24 => 
      array (
        'code' => 'SLP',
        'name' => '산 루이스 포토시',
      ),
      25 => 
      array (
        'code' => 'SIN',
        'name' => '시날로아',
      ),
      26 => 
      array (
        'code' => 'SON',
        'name' => '소 노라',
      ),
      27 => 
      array (
        'code' => 'TAB',
        'name' => '타바스코',
      ),
      28 => 
      array (
        'code' => 'TAM',
        'name' => '타마 울리 파스',
      ),
      29 => 
      array (
        'code' => 'TLA',
        'name' => '틀 락스 칼라',
      ),
      30 => 
      array (
        'code' => 'VER',
        'name' => '베라 크루즈 - Llave',
      ),
      31 => 
      array (
        'code' => 'YUC',
        'name' => '유카탄',
      ),
      32 => 
      array (
        'code' => 'ZAC',
        'name' => '사 카테 카스',
      ),
    ),
    'MY' => 
    array (
      1 => 
      array (
        'code' => 'Johor',
        'name' => '조 호르',
      ),
      2 => 
      array (
        'code' => 'Kedah',
        'name' => '케다',
      ),
      3 => 
      array (
        'code' => 'Kelantan',
        'name' => '켈 란탄',
      ),
      4 => 
      array (
        'code' => 'Labuan',
        'name' => '라부안',
      ),
      5 => 
      array (
        'code' => 'Melaka',
        'name' => '멜라 카',
      ),
      6 => 
      array (
        'code' => 'Negeri Sembilan',
        'name' => '네게 리 셈 빌란',
      ),
      7 => 
      array (
        'code' => 'Pahang',
        'name' => '파항',
      ),
      8 => 
      array (
        'code' => 'Perak',
        'name' => '페락',
      ),
      9 => 
      array (
        'code' => 'Perlis',
        'name' => '펄리스',
      ),
      10 => 
      array (
        'code' => 'Pulau Pinang',
        'name' => '라우 피낭',
      ),
      11 => 
      array (
        'code' => 'Sabah',
        'name' => '사바',
      ),
      12 => 
      array (
        'code' => 'Sarawak',
        'name' => '사라왁',
      ),
      13 => 
      array (
        'code' => 'Selangor',
        'name' => '셀랑 고르',
      ),
      14 => 
      array (
        'code' => 'Terengganu',
        'name' => '테 렝가 누',
      ),
      15 => 
      array (
        'code' => 'Kuala Lumpur',
        'name' => '쿠알라 룸푸르',
      ),
    ),
    'MZ' => 
    array (
      1 => 
      array (
        'code' => 'CD',
        'name' => '카보 델가도',
      ),
      2 => 
      array (
        'code' => 'GZ',
        'name' => '가자 지구',
      ),
      3 => 
      array (
        'code' => 'IN',
        'name' => '인함',
      ),
      4 => 
      array (
        'code' => 'MN',
        'name' => '마니 카',
      ),
      5 => 
      array (
        'code' => 'MC',
        'name' => '마푸토 (도시',
      ),
      6 => 
      array (
        'code' => 'MP',
        'name' => '마푸토',
      ),
      7 => 
      array (
        'code' => 'NA',
        'name' => '남',
      ),
      8 => 
      array (
        'code' => 'NI',
        'name' => '니아',
      ),
      9 => 
      array (
        'code' => 'SO',
        'name' => '소 팔라',
      ),
      10 => 
      array (
        'code' => 'TE',
        'name' => '테테',
      ),
      11 => 
      array (
        'code' => 'ZA',
        'name' => '잠베 지아',
      ),
    ),
    'NA' => 
    array (
      1 => 
      array (
        'code' => 'CA',
        'name' => '카프리',
      ),
      2 => 
      array (
        'code' => 'ER',
        'name' => 'Erongo',
      ),
      3 => 
      array (
        'code' => 'HA',
        'name' => 'Hardap',
      ),
      4 => 
      array (
        'code' => 'KR',
        'name' => '카라스',
      ),
      5 => 
      array (
        'code' => 'KV',
        'name' => '카 방고',
      ),
      6 => 
      array (
        'code' => 'KH',
        'name' => 'Khomas',
      ),
      7 => 
      array (
        'code' => 'KU',
        'name' => '쿠 네네',
      ),
      8 => 
      array (
        'code' => 'OW',
        'name' => 'Ohangwena',
      ),
      9 => 
      array (
        'code' => 'OK',
        'name' => '마헤 케',
      ),
      10 => 
      array (
        'code' => 'OT',
        'name' => '오무 사티',
      ),
      11 => 
      array (
        'code' => 'ON',
        'name' => 'Oshana',
      ),
      12 => 
      array (
        'code' => 'OO',
        'name' => 'Oshikoto',
      ),
      13 => 
      array (
        'code' => 'OJ',
        'name' => 'Otjozondjupa',
      ),
    ),
    'NC' => 
    array (
      1 => 
      array (
        'code' => 'L',
        'name' => '레스 Loyaute',
      ),
      2 => 
      array (
        'code' => 'N',
        'name' => '노르',
      ),
      3 => 
      array (
        'code' => 'S',
        'name' => '쉬',
      ),
    ),
    'NE' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => '아가 데즈',
      ),
      2 => 
      array (
        'code' => 'DF',
        'name' => 'Diffa',
      ),
      3 => 
      array (
        'code' => 'DS',
        'name' => '도소',
      ),
      4 => 
      array (
        'code' => 'MA',
        'name' => '마라 디',
      ),
      5 => 
      array (
        'code' => 'NM',
        'name' => '니아',
      ),
      6 => 
      array (
        'code' => 'TH',
        'name' => '타 우아',
      ),
      7 => 
      array (
        'code' => 'TL',
        'name' => 'Tillaberi',
      ),
      8 => 
      array (
        'code' => 'ZD',
        'name' => 'Zinder 발',
      ),
    ),
    'NF' => 
    array (
      1 => 
      array (
        'code' => 'NOR',
        'name' => '노퍽 섬',
      ),
    ),
    'NG' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => '아 비아',
      ),
      2 => 
      array (
        'code' => 'CT',
        'name' => '부자 연방 수도 특별구',
      ),
      3 => 
      array (
        'code' => 'AD',
        'name' => '아다마',
      ),
      4 => 
      array (
        'code' => 'AK',
        'name' => '아콰 IBOM',
      ),
      5 => 
      array (
        'code' => 'AN',
        'name' => '아남 브라',
      ),
      6 => 
      array (
        'code' => 'BC',
        'name' => '바우',
      ),
      7 => 
      array (
        'code' => 'BY',
        'name' => 'Bayelsa',
      ),
      8 => 
      array (
        'code' => 'BN',
        'name' => '베누',
      ),
      9 => 
      array (
        'code' => 'BO',
        'name' => '르노',
      ),
      10 => 
      array (
        'code' => 'CR',
        'name' => '크로스 리버',
      ),
      11 => 
      array (
        'code' => 'DE',
        'name' => '델타',
      ),
      12 => 
      array (
        'code' => 'EB',
        'name' => '에보니',
      ),
      13 => 
      array (
        'code' => 'ED',
        'name' => '에도',
      ),
      14 => 
      array (
        'code' => 'EK',
        'name' => 'Ekiti',
      ),
      15 => 
      array (
        'code' => 'EN',
        'name' => '누구',
      ),
      16 => 
      array (
        'code' => 'GO',
        'name' => '곰베',
      ),
      17 => 
      array (
        'code' => 'IM',
        'name' => 'IMO',
      ),
      18 => 
      array (
        'code' => 'JI',
        'name' => '지가',
      ),
      19 => 
      array (
        'code' => 'KD',
        'name' => '카 두나',
      ),
      20 => 
      array (
        'code' => 'KN',
        'name' => '카노',
      ),
      21 => 
      array (
        'code' => 'KT',
        'name' => '카 치나',
      ),
      22 => 
      array (
        'code' => 'KE',
        'name' => '케비',
      ),
      23 => 
      array (
        'code' => 'KO',
        'name' => '코기',
      ),
      24 => 
      array (
        'code' => 'KW',
        'name' => 'Kwara',
      ),
      25 => 
      array (
        'code' => 'LA',
        'name' => '라고스',
      ),
      26 => 
      array (
        'code' => 'NA',
        'name' => 'Nassarawa',
      ),
      27 => 
      array (
        'code' => 'NI',
        'name' => '니제르',
      ),
      28 => 
      array (
        'code' => 'OG',
        'name' => '오군',
      ),
      29 => 
      array (
        'code' => 'ONG',
        'name' => '선창',
      ),
      30 => 
      array (
        'code' => 'OS',
        'name' => '오순',
      ),
      31 => 
      array (
        'code' => 'OY',
        'name' => '오요',
      ),
      32 => 
      array (
        'code' => 'PL',
        'name' => '고원',
      ),
      33 => 
      array (
        'code' => 'RI',
        'name' => '강',
      ),
      34 => 
      array (
        'code' => 'SO',
        'name' => '소 코토',
      ),
      35 => 
      array (
        'code' => 'TA',
        'name' => '타라',
      ),
      36 => 
      array (
        'code' => 'YO',
        'name' => '요베',
      ),
      37 => 
      array (
        'code' => 'ZA',
        'name' => '잠 파라',
      ),
    ),
    'NI' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => '아틀란 노르 테',
      ),
      2 => 
      array (
        'code' => 'AS',
        'name' => '아틀란 티코 수르',
      ),
      3 => 
      array (
        'code' => 'BO',
        'name' => 'Boaco',
      ),
      4 => 
      array (
        'code' => 'CA',
        'name' => 'Carazo',
      ),
      5 => 
      array (
        'code' => 'CI',
        'name' => '난데',
      ),
      6 => 
      array (
        'code' => 'CO',
        'name' => 'Chontales',
      ),
      7 => 
      array (
        'code' => 'ES',
        'name' => 'Esteli에',
      ),
      8 => 
      array (
        'code' => 'GR',
        'name' => '그라나다',
      ),
      9 => 
      array (
        'code' => 'JI',
        'name' => 'Jinotega',
      ),
      10 => 
      array (
        'code' => 'LE',
        'name' => '레온',
      ),
      11 => 
      array (
        'code' => 'MD',
        'name' => 'Madriz',
      ),
      12 => 
      array (
        'code' => 'MN',
        'name' => '마나과',
      ),
      13 => 
      array (
        'code' => 'MS',
        'name' => '마사야',
      ),
      14 => 
      array (
        'code' => 'MT',
        'name' => 'Matagalpa에',
      ),
      15 => 
      array (
        'code' => 'NS',
        'name' => '누에 세고비아',
      ),
      16 => 
      array (
        'code' => 'RS',
        'name' => '리오 산후 안',
      ),
      17 => 
      array (
        'code' => 'RI',
        'name' => '리 바스',
      ),
    ),
    'NL' => 
    array (
      1 => 
      array (
        'code' => 'DR',
        'name' => '드렌테',
      ),
      2 => 
      array (
        'code' => 'FL',
        'name' => '플레 볼란 트',
      ),
      3 => 
      array (
        'code' => 'FR',
        'name' => '프리 슬란 트',
      ),
      4 => 
      array (
        'code' => 'GE',
        'name' => '젤더',
      ),
      5 => 
      array (
        'code' => 'GR',
        'name' => '흐로 닝언',
      ),
      6 => 
      array (
        'code' => 'LI',
        'name' => '림 부르크',
      ),
      7 => 
      array (
        'code' => 'NB',
        'name' => '노 르트 브라 반트 (주)',
      ),
      8 => 
      array (
        'code' => 'NH',
        'name' => '노 르트 네덜란드',
      ),
      9 => 
      array (
        'code' => 'OV',
        'name' => '오베 레이 셀',
      ),
      10 => 
      array (
        'code' => 'UT',
        'name' => '위트레흐트',
      ),
      11 => 
      array (
        'code' => 'ZE',
        'name' => '젤란 트',
      ),
      12 => 
      array (
        'code' => 'ZH',
        'name' => '위트 홀란 트',
      ),
    ),
    'NO' => 
    array (
      1 => 
      array (
        'code' => 'AK',
        'name' => '아 케르 스 후스',
      ),
      2 => 
      array (
        'code' => 'AA',
        'name' => '에우 스트 아그 데르',
      ),
      3 => 
      array (
        'code' => 'BU',
        'name' => '스케 루',
      ),
      4 => 
      array (
        'code' => 'FM',
        'name' => '핀 마르크',
      ),
      5 => 
      array (
        'code' => 'HM',
        'name' => '헤드 마르크',
      ),
      6 => 
      array (
        'code' => 'HL',
        'name' => '호르 달란',
      ),
      7 => 
      array (
        'code' => 'MR',
        'name' => '더 OG Romsdal의',
      ),
      8 => 
      array (
        'code' => 'NL',
        'name' => '노를 란드',
      ),
      9 => 
      array (
        'code' => 'NT',
        'name' => '노르 드 - 트론 데라',
      ),
      10 => 
      array (
        'code' => 'OP',
        'name' => '오플란',
      ),
      11 => 
      array (
        'code' => 'OL',
        'name' => '오슬로',
      ),
      12 => 
      array (
        'code' => 'RL',
        'name' => '갈란',
      ),
      13 => 
      array (
        'code' => 'SJ',
        'name' => '송노 피오 라네 (주)',
      ),
      14 => 
      array (
        'code' => 'ST',
        'name' => '소르 - 트론 데라',
      ),
      15 => 
      array (
        'code' => 'SV',
        'name' => '스발 바르',
      ),
      16 => 
      array (
        'code' => 'TM',
        'name' => '텔레',
      ),
      17 => 
      array (
        'code' => 'TR',
        'name' => '트롬',
      ),
      18 => 
      array (
        'code' => 'VA',
        'name' => '베스트 아그 데르',
      ),
      19 => 
      array (
        'code' => 'VF',
        'name' => '베스트 폴',
      ),
      20 => 
      array (
        'code' => 'OF',
        'name' => '외 스트 폴',
      ),
    ),
    'NP' => 
    array (
      1 => 
      array (
        'code' => 'BA',
        'name' => '바그 마티',
      ),
      2 => 
      array (
        'code' => 'BH',
        'name' => '브 헤리',
      ),
      3 => 
      array (
        'code' => 'DH',
        'name' => 'Dhawalagiri',
      ),
      4 => 
      array (
        'code' => 'GA',
        'name' => '간다 키',
      ),
      5 => 
      array (
        'code' => 'JA',
        'name' => '자낙 푸르',
      ),
      6 => 
      array (
        'code' => 'KA',
        'name' => '날리',
      ),
      7 => 
      array (
        'code' => 'KO',
        'name' => '코시',
      ),
      8 => 
      array (
        'code' => 'LU',
        'name' => '룸비니',
      ),
      9 => 
      array (
        'code' => 'MA',
        'name' => '마하 칼리',
      ),
      10 => 
      array (
        'code' => 'ME',
        'name' => 'Mechi',
      ),
      11 => 
      array (
        'code' => 'NA',
        'name' => '나라 야니',
      ),
      12 => 
      array (
        'code' => 'RA',
        'name' => 'Rapti',
      ),
      13 => 
      array (
        'code' => 'SA',
        'name' => '사가르 마타',
      ),
      14 => 
      array (
        'code' => 'SE',
        'name' => '세티',
      ),
    ),
    'NR' => 
    array (
      1 => 
      array (
        'code' => 'AO',
        'name' => '아이 워',
      ),
      2 => 
      array (
        'code' => 'AA',
        'name' => '아나 바르',
      ),
      3 => 
      array (
        'code' => 'AT',
        'name' => '네탄',
      ),
      4 => 
      array (
        'code' => 'AI',
        'name' => 'Anibare',
      ),
      5 => 
      array (
        'code' => 'BA',
        'name' => '이티',
      ),
      6 => 
      array (
        'code' => 'BO',
        'name' => '보',
      ),
      7 => 
      array (
        'code' => 'BU',
        'name' => 'Buada',
      ),
      8 => 
      array (
        'code' => 'DE',
        'name' => 'Denigomodu',
      ),
      9 => 
      array (
        'code' => 'EW',
        'name' => '에바',
      ),
      10 => 
      array (
        'code' => 'IJ',
        'name' => 'Ijuw',
      ),
      11 => 
      array (
        'code' => 'ME',
        'name' => 'Meneng',
      ),
      12 => 
      array (
        'code' => 'NI',
        'name' => '니복',
      ),
      13 => 
      array (
        'code' => 'UA',
        'name' => '우아 보',
      ),
      14 => 
      array (
        'code' => 'YA',
        'name' => '야렌',
      ),
    ),
    'NU' => 
    array (
      1 => 
      array (
        'code' => 'MAK',
        'name' => 'Makefu',
      ),
      2 => 
      array (
        'code' => 'TUA',
        'name' => 'Tuapa',
      ),
      3 => 
      array (
        'code' => 'NAM',
        'name' => 'Namukulu',
      ),
      4 => 
      array (
        'code' => 'HIK',
        'name' => 'Hikutavake',
      ),
      5 => 
      array (
        'code' => 'TOI',
        'name' => '토이',
      ),
      6 => 
      array (
        'code' => 'MUT',
        'name' => 'Mutalau',
      ),
      7 => 
      array (
        'code' => 'LAK',
        'name' => 'Lakepa',
      ),
      8 => 
      array (
        'code' => 'LIK',
        'name' => 'Liku',
      ),
      9 => 
      array (
        'code' => 'HAK',
        'name' => 'Hakupu',
      ),
      10 => 
      array (
        'code' => 'VAI',
        'name' => 'Vaiea',
      ),
      11 => 
      array (
        'code' => 'AVA',
        'name' => 'Avatele',
      ),
      12 => 
      array (
        'code' => 'TAM',
        'name' => 'Tamakautoga',
      ),
      13 => 
      array (
        'code' => 'ALO',
        'name' => '알로 사우스',
      ),
      14 => 
      array (
        'code' => 'ALO',
        'name' => '알로 노스',
      ),
    ),
    'NZ' => 
    array (
      1 => 
      array (
        'code' => 'AUK',
        'name' => '오클랜드',
      ),
      2 => 
      array (
        'code' => 'BOP',
        'name' => '베이 오브 플랜 티',
      ),
      3 => 
      array (
        'code' => 'CAN',
        'name' => '캔터베리',
      ),
      4 => 
      array (
        'code' => 'COR',
        'name' => '코로만 델',
      ),
      5 => 
      array (
        'code' => 'GIS',
        'name' => '기즈 번',
      ),
      6 => 
      array (
        'code' => 'FIO',
        'name' => '피오르드 랜드',
      ),
      7 => 
      array (
        'code' => 'HKB',
        'name' => '혹스 베이',
      ),
      8 => 
      array (
        'code' => 'MBH',
        'name' => '말보로',
      ),
      9 => 
      array (
        'code' => 'MWT',
        'name' => '마나와 투 - 왕가 누이',
      ),
      10 => 
      array (
        'code' => 'MCM',
        'name' => '마운트 쿡 - 맥켄지',
      ),
      11 => 
      array (
        'code' => 'NSN',
        'name' => '넬슨',
      ),
      12 => 
      array (
        'code' => 'NTL',
        'name' => '노스 랜드',
      ),
      13 => 
      array (
        'code' => 'OTA',
        'name' => '오 타고',
      ),
      14 => 
      array (
        'code' => 'STL',
        'name' => '사우스 랜드',
      ),
      15 => 
      array (
        'code' => 'TKI',
        'name' => '타라 나키',
      ),
      16 => 
      array (
        'code' => 'WGN',
        'name' => '웰링턴',
      ),
      17 => 
      array (
        'code' => 'WKO',
        'name' => '와이 카토',
      ),
      18 => 
      array (
        'code' => 'WAI',
        'name' => 'Wairprarapa',
      ),
      19 => 
      array (
        'code' => 'WTC',
        'name' => '서부 해안',
      ),
    ),
    'OM' => 
    array (
      1 => 
      array (
        'code' => 'DA',
        'name' => '광고 Dakhiliyah',
      ),
      2 => 
      array (
        'code' => 'BA',
        'name' => '알 바티',
      ),
      3 => 
      array (
        'code' => 'WU',
        'name' => '알 Wusta',
      ),
      4 => 
      array (
        'code' => 'SH',
        'name' => '애쉬 샤르 키야',
      ),
      5 => 
      array (
        'code' => 'ZA',
        'name' => '아즈 Zahirah',
      ),
      6 => 
      array (
        'code' => 'MA',
        'name' => '마스 카트',
      ),
      7 => 
      array (
        'code' => 'MU',
        'name' => '무산 담',
      ),
      8 => 
      array (
        'code' => 'ZU',
        'name' => 'Zufar',
      ),
    ),
    'PA' => 
    array (
      1 => 
      array (
        'code' => 'BT',
        'name' => '보 카스 델토',
      ),
      2 => 
      array (
        'code' => 'CH',
        'name' => '치리 키',
      ),
      3 => 
      array (
        'code' => 'CC',
        'name' => 'Cocle',
      ),
      4 => 
      array (
        'code' => 'CL',
        'name' => '콜론',
      ),
      5 => 
      array (
        'code' => 'DA',
        'name' => '다리 엔',
      ),
      6 => 
      array (
        'code' => 'HE',
        'name' => '헤레라',
      ),
      7 => 
      array (
        'code' => 'LS',
        'name' => '로스 산토스',
      ),
      8 => 
      array (
        'code' => 'PA',
        'name' => '파나마',
      ),
      9 => 
      array (
        'code' => 'SB',
        'name' => '산 블라스',
      ),
      10 => 
      array (
        'code' => 'VG',
        'name' => 'Veraguas에',
      ),
    ),
    'PE' => 
    array (
      1 => 
      array (
        'code' => 'AM',
        'name' => '아마 조나스',
      ),
      2 => 
      array (
        'code' => 'AN',
        'name' => '앙카',
      ),
      3 => 
      array (
        'code' => 'AP',
        'name' => 'Apurimac',
      ),
      4 => 
      array (
        'code' => 'AR',
        'name' => '아레 키파',
      ),
      5 => 
      array (
        'code' => 'AY',
        'name' => '아야 쿠초',
      ),
      6 => 
      array (
        'code' => 'CJ',
        'name' => '카하 마르카',
      ),
      7 => 
      array (
        'code' => 'CL',
        'name' => '카야 오',
      ),
      8 => 
      array (
        'code' => 'CU',
        'name' => '쿠스코',
      ),
      9 => 
      array (
        'code' => 'HV',
        'name' => '우앙 카 벨리',
      ),
      10 => 
      array (
        'code' => 'HO',
        'name' => '우아 누코',
      ),
      11 => 
      array (
        'code' => 'IC',
        'name' => '이카',
      ),
      12 => 
      array (
        'code' => 'JU',
        'name' => '후닌',
      ),
      13 => 
      array (
        'code' => 'LD',
        'name' => '라 리베르 타드',
      ),
      14 => 
      array (
        'code' => 'LY',
        'name' => '람바 예케',
      ),
      15 => 
      array (
        'code' => 'LI',
        'name' => '리마',
      ),
      16 => 
      array (
        'code' => 'LO',
        'name' => '로 레토',
      ),
      17 => 
      array (
        'code' => 'MD',
        'name' => '마드레 데 디오스',
      ),
      18 => 
      array (
        'code' => 'MO',
        'name' => 'Moquegua',
      ),
      19 => 
      array (
        'code' => 'PA',
        'name' => '파스코',
      ),
      20 => 
      array (
        'code' => 'PI',
        'name' => '피우 라',
      ),
      21 => 
      array (
        'code' => 'PU',
        'name' => '푸노',
      ),
      22 => 
      array (
        'code' => 'SM',
        'name' => '산 마르틴',
      ),
      23 => 
      array (
        'code' => 'TA',
        'name' => '타크',
      ),
      24 => 
      array (
        'code' => 'TU',
        'name' => '툼 베스',
      ),
      25 => 
      array (
        'code' => 'UC',
        'name' => '우카 얄리',
      ),
    ),
    'PF' => 
    array (
      1 => 
      array (
        'code' => 'M',
        'name' => '펠 데 차양',
      ),
      2 => 
      array (
        'code' => 'T',
        'name' => '펠 데 투아',
      ),
      3 => 
      array (
        'code' => 'I',
        'name' => '펠 데 투부 아이',
      ),
      4 => 
      array (
        'code' => 'V',
        'name' => '레스 뒤 환풍',
      ),
      5 => 
      array (
        'code' => 'S',
        'name' => '레스 부조리 르 환풍',
      ),
    ),
    'PG' => 
    array (
      1 => 
      array (
        'code' => 'BV',
        'name' => '부건',
      ),
      2 => 
      array (
        'code' => 'CE',
        'name' => '중앙',
      ),
      3 => 
      array (
        'code' => 'CH',
        'name' => 'Chimbu',
      ),
      4 => 
      array (
        'code' => 'EH',
        'name' => '동부 고원',
      ),
      5 => 
      array (
        'code' => 'EB',
        'name' => '이스트 뉴 브리튼',
      ),
      6 => 
      array (
        'code' => 'ES',
        'name' => '동 Sepik',
      ),
      7 => 
      array (
        'code' => 'EN',
        'name' => '날 속이려고',
      ),
      8 => 
      array (
        'code' => 'GU',
        'name' => '걸프',
      ),
      9 => 
      array (
        'code' => 'MD',
        'name' => '마당',
      ),
      10 => 
      array (
        'code' => 'MN',
        'name' => '마누스',
      ),
      11 => 
      array (
        'code' => 'MB',
        'name' => '밀른 베이',
      ),
      12 => 
      array (
        'code' => 'MR',
        'name' => '모로 베',
      ),
      13 => 
      array (
        'code' => 'NC',
        'name' => '국가 자본',
      ),
      14 => 
      array (
        'code' => 'NI',
        'name' => '뉴 아일랜드',
      ),
      15 => 
      array (
        'code' => 'NO',
        'name' => '북',
      ),
      16 => 
      array (
        'code' => 'SA',
        'name' => 'Sandaun',
      ),
      17 => 
      array (
        'code' => 'SH',
        'name' => '서던 하일 랜즈',
      ),
      18 => 
      array (
        'code' => 'WE',
        'name' => '서양',
      ),
      19 => 
      array (
        'code' => 'WH',
        'name' => '서부 고원',
      ),
      20 => 
      array (
        'code' => 'WB',
        'name' => '웨스트 뉴 브리튼',
      ),
    ),
    'PH' => 
    array (
      1 => 
      array (
        'code' => 'ABR',
        'name' => '아브라',
      ),
      2 => 
      array (
        'code' => 'ANO',
        'name' => '아 구산 델 노르 테',
      ),
      3 => 
      array (
        'code' => 'ASU',
        'name' => '아 구산 델 수르',
      ),
      4 => 
      array (
        'code' => 'AKL',
        'name' => '아 클란',
      ),
      5 => 
      array (
        'code' => 'ALB',
        'name' => '알 베이',
      ),
      6 => 
      array (
        'code' => 'ANT',
        'name' => '골동품',
      ),
      7 => 
      array (
        'code' => 'APY',
        'name' => 'Apayao',
      ),
      8 => 
      array (
        'code' => 'AUR',
        'name' => '오로라',
      ),
      9 => 
      array (
        'code' => 'BAS',
        'name' => '바실란',
      ),
      10 => 
      array (
        'code' => 'BTA',
        'name' => '바탄',
      ),
      11 => 
      array (
        'code' => 'BTE',
        'name' => '바타 네스',
      ),
      12 => 
      array (
        'code' => 'BTG',
        'name' => '바탕 가스',
      ),
      13 => 
      array (
        'code' => 'BLR',
        'name' => '빌리 란',
      ),
      14 => 
      array (
        'code' => 'BEN',
        'name' => '벵겟',
      ),
      15 => 
      array (
        'code' => 'BOL',
        'name' => '보홀',
      ),
      16 => 
      array (
        'code' => 'BUK',
        'name' => '키드 논',
      ),
      17 => 
      array (
        'code' => 'BUL',
        'name' => '라칸',
      ),
      18 => 
      array (
        'code' => 'CAG',
        'name' => '카가 얀',
      ),
      19 => 
      array (
        'code' => 'CNO',
        'name' => '카 마린 노르 테',
      ),
      20 => 
      array (
        'code' => 'CSU',
        'name' => '카 마린 수르',
      ),
      21 => 
      array (
        'code' => 'CAM',
        'name' => '민다나오',
      ),
      22 => 
      array (
        'code' => 'CAP',
        'name' => '카피스',
      ),
      23 => 
      array (
        'code' => 'CAT',
        'name' => '카탄 두 아네스',
      ),
      24 => 
      array (
        'code' => 'CAV',
        'name' => '카 비테',
      ),
      25 => 
      array (
        'code' => 'CEB',
        'name' => '세부',
      ),
      26 => 
      array (
        'code' => 'CMP',
        'name' => '콤포 스텔라',
      ),
      27 => 
      array (
        'code' => 'DNO',
        'name' => '다바오 델 노르 테',
      ),
      28 => 
      array (
        'code' => 'DSU',
        'name' => '다바오 델 수르',
      ),
      29 => 
      array (
        'code' => 'DOR',
        'name' => '다바오 오리엔탈',
      ),
      30 => 
      array (
        'code' => 'ESA',
        'name' => '동부 사마르',
      ),
      31 => 
      array (
        'code' => 'GUI',
        'name' => '기마 라스',
      ),
      32 => 
      array (
        'code' => 'IFU',
        'name' => '이 푸가 오',
      ),
      33 => 
      array (
        'code' => 'INO',
        'name' => '일로 코스 노르 테',
      ),
      34 => 
      array (
        'code' => 'ISU',
        'name' => '일로 코스 수르',
      ),
      35 => 
      array (
        'code' => 'ILO',
        'name' => '일로 일로',
      ),
      36 => 
      array (
        'code' => 'ISA',
        'name' => '이사벨라',
      ),
      37 => 
      array (
        'code' => 'KAL',
        'name' => '칼링가',
      ),
      38 => 
      array (
        'code' => 'LAG',
        'name' => '라구나',
      ),
      39 => 
      array (
        'code' => 'LNO',
        'name' => '라 나오 델 노르 테',
      ),
      40 => 
      array (
        'code' => 'LSU',
        'name' => '라 나오 델 수르',
      ),
      41 => 
      array (
        'code' => 'UNI',
        'name' => '라 유니언',
      ),
      42 => 
      array (
        'code' => 'LEY',
        'name' => '레이 테',
      ),
      43 => 
      array (
        'code' => 'MAG',
        'name' => '마 귄다 나오',
      ),
      44 => 
      array (
        'code' => 'MRN',
        'name' => 'Marinduque에',
      ),
      45 => 
      array (
        'code' => 'MSB',
        'name' => '마스 바트',
      ),
      46 => 
      array (
        'code' => 'MIC',
        'name' => '민도로 옥시 덴탈',
      ),
      47 => 
      array (
        'code' => 'MIR',
        'name' => '민도로 오리엔탈',
      ),
      48 => 
      array (
        'code' => 'MSC',
        'name' => '미사 미스 옥시 덴탈',
      ),
      49 => 
      array (
        'code' => 'MOR',
        'name' => '미사 미스 오리엔탈',
      ),
      50 => 
      array (
        'code' => 'MOP',
        'name' => '산',
      ),
      51 => 
      array (
        'code' => 'NOC',
        'name' => '네 그로스 옥시 덴탈',
      ),
      52 => 
      array (
        'code' => 'NOR',
        'name' => '그로스 오리엔탈',
      ),
      53 => 
      array (
        'code' => 'NCT',
        'name' => '노스 코타 바토',
      ),
      54 => 
      array (
        'code' => 'NSM',
        'name' => '북 사마르',
      ),
      55 => 
      array (
        'code' => 'NEC',
        'name' => '누에바 에시',
      ),
      56 => 
      array (
        'code' => 'NVZ',
        'name' => '누에바 비스 카야',
      ),
      57 => 
      array (
        'code' => 'PLW',
        'name' => '팔라완',
      ),
      58 => 
      array (
        'code' => 'PMP',
        'name' => '팜 팡가',
      ),
      59 => 
      array (
        'code' => 'PNG',
        'name' => '팡 가시',
      ),
      60 => 
      array (
        'code' => 'QZN',
        'name' => '케손',
      ),
      61 => 
      array (
        'code' => 'QRN',
        'name' => '퀴리',
      ),
      62 => 
      array (
        'code' => 'RIZ',
        'name' => '리잘',
      ),
      63 => 
      array (
        'code' => 'ROM',
        'name' => '롬 블론',
      ),
      64 => 
      array (
        'code' => 'SMR',
        'name' => '사마르',
      ),
      65 => 
      array (
        'code' => 'SRG',
        'name' => '사랑 가니',
      ),
      66 => 
      array (
        'code' => 'SQJ',
        'name' => 'Siquijor에',
      ),
      67 => 
      array (
        'code' => 'SRS',
        'name' => '소르 소곤',
      ),
      68 => 
      array (
        'code' => 'SCO',
        'name' => '사우스 코타 바토',
      ),
      69 => 
      array (
        'code' => 'SLE',
        'name' => '루이지애나 남부',
      ),
      70 => 
      array (
        'code' => 'SKU',
        'name' => '술탄 쿠다 라트',
      ),
      71 => 
      array (
        'code' => 'SLU',
        'name' => '술루',
      ),
      72 => 
      array (
        'code' => 'SNO',
        'name' => '수리 가오 델 노르 테',
      ),
      73 => 
      array (
        'code' => 'SSU',
        'name' => '수리 가오 델 수르',
      ),
      74 => 
      array (
        'code' => 'TAR',
        'name' => '딸락',
      ),
      75 => 
      array (
        'code' => 'TAW',
        'name' => '타위 - 타위',
      ),
      76 => 
      array (
        'code' => 'ZBL',
        'name' => '잠 발레 스',
      ),
      77 => 
      array (
        'code' => 'ZNO',
        'name' => '잠보 앙가 델 노르 테',
      ),
      78 => 
      array (
        'code' => 'ZSU',
        'name' => '잠보 앙가 델 수르',
      ),
      79 => 
      array (
        'code' => 'ZSI',
        'name' => '잠보 앙가 Sibugay',
      ),
    ),
    'PK' => 
    array (
      1 => 
      array (
        'code' => 'B',
        'name' => '발 루치 스탄',
      ),
      2 => 
      array (
        'code' => 'T',
        'name' => '연방 관할 부족 AR',
      ),
      3 => 
      array (
        'code' => 'I',
        'name' => '이슬라마바드 수도권 지역',
      ),
      4 => 
      array (
        'code' => 'N',
        'name' => '노스 웨스트 프론티어',
      ),
      5 => 
      array (
        'code' => 'P',
        'name' => '펀 자브',
      ),
      6 => 
      array (
        'code' => 'S',
        'name' => '신드',
      ),
    ),
    'PL' => 
    array (
      1 => 
      array (
        'code' => 'DO',
        'name' => '돌 노실 롱 스키에',
      ),
      2 => 
      array (
        'code' => 'KP',
        'name' => 'Kujawsko - 포 모르 스키',
      ),
      3 => 
      array (
        'code' => 'LL',
        'name' => '루벨 스키',
      ),
      4 => 
      array (
        'code' => 'LU',
        'name' => '루부 스키',
      ),
      5 => 
      array (
        'code' => 'LO',
        'name' => '로드 즈키',
      ),
      6 => 
      array (
        'code' => 'ML',
        'name' => '말로 폴 스키',
      ),
      7 => 
      array (
        'code' => 'MZ',
        'name' => '마 조비 에츠 키',
      ),
      8 => 
      array (
        'code' => 'OP',
        'name' => '오폴 스키',
      ),
      9 => 
      array (
        'code' => 'PP',
        'name' => '포드 카르 파츠 키',
      ),
      10 => 
      array (
        'code' => 'PL',
        'name' => '포 들라 스키에',
      ),
      11 => 
      array (
        'code' => 'PM',
        'name' => '포 모르 스키',
      ),
      12 => 
      array (
        'code' => 'SL',
        'name' => '실롱 스키에',
      ),
      13 => 
      array (
        'code' => 'SW',
        'name' => '시비 엥 토크시 스키',
      ),
      14 => 
      array (
        'code' => 'WM',
        'name' => 'Warmińsko-Mazurskie',
      ),
      15 => 
      array (
        'code' => 'WP',
        'name' => '비엘 코폴 스키',
      ),
      16 => 
      array (
        'code' => 'ZA',
        'name' => 'Zachodniopomorskie',
      ),
    ),
    'PM' => 
    array (
      1 => 
      array (
        'code' => 'P',
        'name' => '생 피에르',
      ),
      2 => 
      array (
        'code' => 'M',
        'name' => '미 클롱',
      ),
    ),
    'PN' => 
    array (
      1 => 
      array (
        'code' => 'PIT',
        'name' => '핏 케언 섬',
      ),
    ),
    'PR' => 
    array (
      1 => 
      array (
        'code' => 'A-A',
        'name' => '아나 스코',
      ),
      2 => 
      array (
        'code' => 'ADJ',
        'name' => '아드',
      ),
      3 => 
      array (
        'code' => 'AGU',
        'name' => '아구아',
      ),
      4 => 
      array (
        'code' => 'AGU',
        'name' => '아과',
      ),
      5 => 
      array (
        'code' => 'AGU',
        'name' => '아구 아스 안녕히',
      ),
      6 => 
      array (
        'code' => 'AIB',
        'name' => 'AIBONITO',
      ),
      7 => 
      array (
        'code' => 'ARE',
        'name' => '아레 시보',
      ),
      8 => 
      array (
        'code' => 'ARR',
        'name' => '아로요',
      ),
      9 => 
      array (
        'code' => 'BAR',
        'name' => '바르 셀로 네타',
      ),
      10 => 
      array (
        'code' => 'BAR',
        'name' => 'Barranquitas에',
      ),
      11 => 
      array (
        'code' => 'BAY',
        'name' => '도라',
      ),
      12 => 
      array (
        'code' => 'CAB',
        'name' => '카보 조로',
      ),
      13 => 
      array (
        'code' => 'CAG',
        'name' => '카과',
      ),
      14 => 
      array (
        'code' => 'CAM',
        'name' => '카무이',
      ),
      15 => 
      array (
        'code' => 'CAN',
        'name' => 'Canóvanas',
      ),
      16 => 
      array (
        'code' => 'CAR',
        'name' => '캐롤라이나',
      ),
      17 => 
      array (
        'code' => 'CAT',
        'name' => 'Cataño',
      ),
      18 => 
      array (
        'code' => 'CAY',
        'name' => 'Cayey에서',
      ),
      19 => 
      array (
        'code' => 'CEI',
        'name' => '세이 바',
      ),
      20 => 
      array (
        'code' => 'CIA',
        'name' => 'Ciales',
      ),
      21 => 
      array (
        'code' => 'CID',
        'name' => '시드 라',
      ),
      22 => 
      array (
        'code' => 'COA',
        'name' => 'Coamo',
      ),
      23 => 
      array (
        'code' => 'COM',
        'name' => '코메 리오',
      ),
      24 => 
      array (
        'code' => 'COR',
        'name' => '코로',
      ),
      25 => 
      array (
        'code' => 'CUL',
        'name' => '쿨 레브라',
      ),
      26 => 
      array (
        'code' => 'DOR',
        'name' => '도라',
      ),
      27 => 
      array (
        'code' => 'FAJ',
        'name' => '파 하르도',
      ),
      28 => 
      array (
        'code' => 'FLO',
        'name' => '플로리다',
      ),
      29 => 
      array (
        'code' => 'GUA',
        'name' => 'GUAYAMA',
      ),
      30 => 
      array (
        'code' => 'GUA',
        'name' => '과야',
      ),
      31 => 
      array (
        'code' => 'GUA',
        'name' => 'Guaynabo에서',
      ),
      32 => 
      array (
        'code' => 'GUR',
        'name' => 'Gurabo',
      ),
      33 => 
      array (
        'code' => 'GU¡',
        'name' => '아니카',
      ),
      34 => 
      array (
        'code' => 'HAT',
        'name' => '아띠',
      ),
      35 => 
      array (
        'code' => 'HOR',
        'name' => 'Hormigueros',
      ),
      36 => 
      array (
        'code' => 'HUM',
        'name' => '우 마카오',
      ),
      37 => 
      array (
        'code' => 'ISA',
        'name' => '이사벨라',
      ),
      38 => 
      array (
        'code' => 'JAY',
        'name' => '유야',
      ),
      39 => 
      array (
        'code' => 'JUA',
        'name' => '준희 디아즈',
      ),
      40 => 
      array (
        'code' => 'JUN',
        'name' => 'Juncos',
      ),
      41 => 
      array (
        'code' => 'LAJ',
        'name' => '하스',
      ),
      42 => 
      array (
        'code' => 'LAR',
        'name' => '레스',
      ),
      43 => 
      array (
        'code' => 'LAS',
        'name' => 'Las Marias에서',
      ),
      44 => 
      array (
        'code' => 'LAS',
        'name' => '라스 피 에드 라스',
      ),
      45 => 
      array (
        'code' => 'LOÕ',
        'name' => 'Loiza에서',
      ),
      46 => 
      array (
        'code' => 'LUQ',
        'name' => '루키 요',
      ),
      47 => 
      array (
        'code' => 'MAN',
        'name' => '마나 티',
      ),
      48 => 
      array (
        'code' => 'MAR',
        'name' => 'Maricao',
      ),
      49 => 
      array (
        'code' => 'MAU',
        'name' => '마우나',
      ),
      50 => 
      array (
        'code' => 'MAY',
        'name' => '마야',
      ),
      51 => 
      array (
        'code' => 'MOC',
        'name' => 'MOCA',
      ),
      52 => 
      array (
        'code' => 'MOR',
        'name' => 'Morovis의',
      ),
      53 => 
      array (
        'code' => 'NAG',
        'name' => 'Naguabo의',
      ),
      54 => 
      array (
        'code' => 'NAR',
        'name' => 'Naranjito',
      ),
      55 => 
      array (
        'code' => 'ORO',
        'name' => '거리 Orocovis',
      ),
      56 => 
      array (
        'code' => 'PAT',
        'name' => '파틸',
      ),
      57 => 
      array (
        'code' => 'PE-',
        'name' => 'Peñuelas',
      ),
      58 => 
      array (
        'code' => 'PON',
        'name' => '폰세',
      ),
      59 => 
      array (
        'code' => 'QUE',
        'name' => '케브라 디 야스',
      ),
      60 => 
      array (
        'code' => 'RIN',
        'name' => '링콘',
      ),
      61 => 
      array (
        'code' => 'RIO',
        'name' => '리오 그란데',
      ),
      62 => 
      array (
        'code' => 'SAB',
        'name' => '사바나 그란데',
      ),
      63 => 
      array (
        'code' => 'SAL',
        'name' => '설리',
      ),
      64 => 
      array (
        'code' => 'SAN',
        'name' => '산 헤르만',
      ),
      65 => 
      array (
        'code' => 'SAN',
        'name' => '산후 안',
      ),
      66 => 
      array (
        'code' => 'SAN',
        'name' => '산 로렌조',
      ),
      67 => 
      array (
        'code' => 'SAN',
        'name' => '산 세바스티안',
      ),
      68 => 
      array (
        'code' => 'SAN',
        'name' => '산타 이사벨',
      ),
      69 => 
      array (
        'code' => 'TOA',
        'name' => '토아 알타',
      ),
      70 => 
      array (
        'code' => 'TOA',
        'name' => '토아 바하',
      ),
      71 => 
      array (
        'code' => 'TRU',
        'name' => '트루 히요 알토',
      ),
      72 => 
      array (
        'code' => 'UTU',
        'name' => 'Utuado에서',
      ),
      73 => 
      array (
        'code' => 'VEG',
        'name' => '베가 알타',
      ),
      74 => 
      array (
        'code' => 'VEG',
        'name' => '베가 바하',
      ),
      75 => 
      array (
        'code' => 'VIE',
        'name' => '비에 케스',
      ),
      76 => 
      array (
        'code' => 'VIL',
        'name' => '알바',
      ),
      77 => 
      array (
        'code' => 'YAB',
        'name' => '야부 코아',
      ),
      78 => 
      array (
        'code' => 'YAU',
        'name' => 'Yauco',
      ),
    ),
    'PT' => 
    array (
      1 => 
      array (
        'code' => 'AC',
        'name' => 'Açores',
      ),
      2 => 
      array (
        'code' => 'AV',
        'name' => '아베 이루',
      ),
      3 => 
      array (
        'code' => 'BE',
        'name' => '베자',
      ),
      4 => 
      array (
        'code' => 'BR',
        'name' => '브라가',
      ),
      5 => 
      array (
        'code' => 'BA',
        'name' => '브라 간카',
      ),
      6 => 
      array (
        'code' => 'CB',
        'name' => '카스텔로 브랑 쿠',
      ),
      7 => 
      array (
        'code' => 'CO',
        'name' => '쿠임 브라',
      ),
      8 => 
      array (
        'code' => 'EV',
        'name' => '유물',
      ),
      9 => 
      array (
        'code' => 'FA',
        'name' => '놀이',
      ),
      10 => 
      array (
        'code' => 'GU',
        'name' => '과 르다',
      ),
      12 => 
      array (
        'code' => 'LE',
        'name' => '레이리아',
      ),
      13 => 
      array (
        'code' => 'LI',
        'name' => '리스본',
      ),
      14 => 
      array (
        'code' => 'ME',
        'name' => '마데이라',
      ),
      15 => 
      array (
        'code' => 'PO',
        'name' => '포르 탈레',
      ),
      16 => 
      array (
        'code' => 'PR',
        'name' => '포르투',
      ),
      17 => 
      array (
        'code' => 'SA',
        'name' => '산타 렘',
      ),
      18 => 
      array (
        'code' => 'SE',
        'name' => '세 투발',
      ),
      19 => 
      array (
        'code' => 'VC',
        'name' => '비아나는 카스텔로',
      ),
      20 => 
      array (
        'code' => 'VR',
        'name' => '빌라 레알',
      ),
      21 => 
      array (
        'code' => 'VI',
        'name' => '비 세우',
      ),
    ),
    'PW' => 
    array (
      1 => 
      array (
        'code' => 'AM',
        'name' => 'Aimeliik',
      ),
      2 => 
      array (
        'code' => 'AR',
        'name' => '아이 라이',
      ),
      3 => 
      array (
        'code' => 'AN',
        'name' => '앙가 우르',
      ),
      4 => 
      array (
        'code' => 'HA',
        'name' => 'Hatohobei',
      ),
      5 => 
      array (
        'code' => 'KA',
        'name' => 'Kayangel',
      ),
      6 => 
      array (
        'code' => 'KO',
        'name' => '코 로르',
      ),
      7 => 
      array (
        'code' => 'ME',
        'name' => '멜레 케옥',
      ),
      8 => 
      array (
        'code' => 'NA',
        'name' => 'Ngaraard',
      ),
      9 => 
      array (
        'code' => 'NG',
        'name' => 'Ngarchelong',
      ),
      10 => 
      array (
        'code' => 'ND',
        'name' => 'Ngardmau',
      ),
      11 => 
      array (
        'code' => 'NT',
        'name' => 'Ngatpang',
      ),
      12 => 
      array (
        'code' => 'NC',
        'name' => 'Ngchesar',
      ),
      13 => 
      array (
        'code' => 'NR',
        'name' => 'Ngeremlengui',
      ),
      14 => 
      array (
        'code' => 'NW',
        'name' => 'Ngiwal',
      ),
      15 => 
      array (
        'code' => 'PE',
        'name' => 'Peleliu',
      ),
      16 => 
      array (
        'code' => 'SO',
        'name' => 'Sonsorol',
      ),
    ),
    'PY' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => '알토 파라과이',
      ),
      2 => 
      array (
        'code' => 'AN',
        'name' => '알토 파라나',
      ),
      3 => 
      array (
        'code' => 'AM',
        'name' => 'Amambay',
      ),
      4 => 
      array (
        'code' => 'AS',
        'name' => '아순시온',
      ),
      5 => 
      array (
        'code' => 'BO',
        'name' => '케론',
      ),
      6 => 
      array (
        'code' => 'CG',
        'name' => 'Caaguazu',
      ),
      7 => 
      array (
        'code' => 'CZ',
        'name' => 'Caazapa',
      ),
      8 => 
      array (
        'code' => 'CN',
        'name' => 'Canindeyu',
      ),
      9 => 
      array (
        'code' => 'CE',
        'name' => '중앙',
      ),
      10 => 
      array (
        'code' => 'CC',
        'name' => '콘셉 시온',
      ),
      11 => 
      array (
        'code' => 'CD',
        'name' => '코르 딜레 라',
      ),
      12 => 
      array (
        'code' => 'GU',
        'name' => '과이라',
      ),
      13 => 
      array (
        'code' => 'IT',
        'name' => '이타 푸아',
      ),
      14 => 
      array (
        'code' => 'MI',
        'name' => '미시 오 네스',
      ),
      15 => 
      array (
        'code' => 'NE',
        'name' => 'Neembucu',
      ),
      16 => 
      array (
        'code' => 'PA',
        'name' => 'Paraguari',
      ),
      17 => 
      array (
        'code' => 'PH',
        'name' => '프레지던트 헤이즈',
      ),
      18 => 
      array (
        'code' => 'SP',
        'name' => '산 페드로',
      ),
    ),
    'QA' => 
    array (
      1 => 
      array (
        'code' => 'DW',
        'name' => '광고 Dawhah',
      ),
      2 => 
      array (
        'code' => 'GW',
        'name' => '알 Ghuwayriyah',
      ),
      3 => 
      array (
        'code' => 'JM',
        'name' => '알 Jumayliyah',
      ),
      4 => 
      array (
        'code' => 'KR',
        'name' => '알 카 우르',
      ),
      5 => 
      array (
        'code' => 'WK',
        'name' => '알와 크라',
      ),
      6 => 
      array (
        'code' => 'RN',
        'name' => 'AR 라이 얀',
      ),
      7 => 
      array (
        'code' => 'JB',
        'name' => 'Jarayan 알 바티',
      ),
      8 => 
      array (
        'code' => 'MS',
        'name' => '마디 나트 재 샤말',
      ),
      9 => 
      array (
        'code' => 'UD',
        'name' => '음 Sa id',
      ),
      10 => 
      array (
        'code' => 'UL',
        'name' => '움 살랄',
      ),
    ),
    'RO' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => '알바',
      ),
      2 => 
      array (
        'code' => 'AR',
        'name' => '아라드',
      ),
      3 => 
      array (
        'code' => 'AG',
        'name' => 'ARGES',
      ),
      4 => 
      array (
        'code' => 'BC',
        'name' => '바코',
      ),
      5 => 
      array (
        'code' => 'BH',
        'name' => '비 호르',
      ),
      6 => 
      array (
        'code' => 'BN',
        'name' => '비스트 리차 너서 우드',
      ),
      7 => 
      array (
        'code' => 'BT',
        'name' => '보토 샤니',
      ),
      8 => 
      array (
        'code' => 'BV',
        'name' => '브라쇼브',
      ),
      9 => 
      array (
        'code' => 'BR',
        'name' => '브러 일라',
      ),
      10 => 
      array (
        'code' => 'B',
        'name' => '부쿠레슈티',
      ),
      11 => 
      array (
        'code' => 'BZ',
        'name' => '부자 우',
      ),
      12 => 
      array (
        'code' => 'CS',
        'name' => '카라스 - 세브린',
      ),
      13 => 
      array (
        'code' => 'CL',
        'name' => 'Calarasi에서',
      ),
      14 => 
      array (
        'code' => 'CJ',
        'name' => '클루지나',
      ),
      15 => 
      array (
        'code' => 'CT',
        'name' => '콘 스탄',
      ),
      16 => 
      array (
        'code' => 'CV',
        'name' => '코바 스나',
      ),
      17 => 
      array (
        'code' => 'DB',
        'name' => 'Dimbovita',
      ),
      18 => 
      array (
        'code' => 'DJ',
        'name' => '돌지',
      ),
      19 => 
      array (
        'code' => 'GL',
        'name' => '갈라 치',
      ),
      20 => 
      array (
        'code' => 'GR',
        'name' => '지 우르 지우',
      ),
      21 => 
      array (
        'code' => 'GJ',
        'name' => '고르지',
      ),
      22 => 
      array (
        'code' => 'HR',
        'name' => '하르',
      ),
      23 => 
      array (
        'code' => 'HD',
        'name' => '네도 아라',
      ),
      24 => 
      array (
        'code' => 'IL',
        'name' => '이알 로미 차',
      ),
      25 => 
      array (
        'code' => 'IS',
        'name' => '이아시',
      ),
      26 => 
      array (
        'code' => 'IF',
        'name' => '포브',
      ),
      27 => 
      array (
        'code' => 'MM',
        'name' => '의 Maramures',
      ),
      28 => 
      array (
        'code' => 'MH',
        'name' => '메 헤딘 치',
      ),
      29 => 
      array (
        'code' => 'MS',
        'name' => '레스',
      ),
      30 => 
      array (
        'code' => 'NT',
        'name' => '암츠',
      ),
      31 => 
      array (
        'code' => 'OT',
        'name' => 'OLT',
      ),
      32 => 
      array (
        'code' => 'PH',
        'name' => '프라 호바',
      ),
      33 => 
      array (
        'code' => 'SM',
        'name' => '사투 - 마레',
      ),
      34 => 
      array (
        'code' => 'SJ',
        'name' => '설 라지',
      ),
      35 => 
      array (
        'code' => 'SB',
        'name' => '시비 우',
      ),
      36 => 
      array (
        'code' => 'SV',
        'name' => '수체 아바',
      ),
      37 => 
      array (
        'code' => 'TR',
        'name' => '텔레 오르',
      ),
      38 => 
      array (
        'code' => 'TM',
        'name' => 'Timis',
      ),
      39 => 
      array (
        'code' => 'TL',
        'name' => '툴 체아',
      ),
      40 => 
      array (
        'code' => 'VS',
        'name' => '바슬 루이',
      ),
      41 => 
      array (
        'code' => 'VL',
        'name' => '체아',
      ),
      42 => 
      array (
        'code' => 'VN',
        'name' => '브란 세아',
      ),
    ),
    'RU' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => '아바 칸',
      ),
      2 => 
      array (
        'code' => 'AG',
        'name' => 'Aginskoye',
      ),
      3 => 
      array (
        'code' => 'AN',
        'name' => '아나 디르',
      ),
      4 => 
      array (
        'code' => 'AR',
        'name' => 'Arkahangelsk',
      ),
      5 => 
      array (
        'code' => 'AS',
        'name' => '아스트라한',
      ),
      6 => 
      array (
        'code' => 'BA',
        'name' => '바르나 울',
      ),
      7 => 
      array (
        'code' => 'BE',
        'name' => '벨고로드',
      ),
      8 => 
      array (
        'code' => 'BI',
        'name' => 'Birobidzhan',
      ),
      9 => 
      array (
        'code' => 'BL',
        'name' => 'Blagoveshchensk',
      ),
      10 => 
      array (
        'code' => 'BR',
        'name' => '브랸 스크',
      ),
      11 => 
      array (
        'code' => 'CH',
        'name' => '체 복사 리',
      ),
      12 => 
      array (
        'code' => 'CL',
        'name' => '첼 랴빈 스크',
      ),
      13 => 
      array (
        'code' => 'CR',
        'name' => '체 르케 스크',
      ),
      14 => 
      array (
        'code' => 'CI',
        'name' => '치타',
      ),
      15 => 
      array (
        'code' => 'DU',
        'name' => '딘카',
      ),
      16 => 
      array (
        'code' => 'EL',
        'name' => '옐리 스타',
      ),
      17 => 
      array (
        'code' => 'GO',
        'name' => '고모-Altaysk',
      ),
      18 => 
      array (
        'code' => 'GA',
        'name' => '르노 Altaysk',
      ),
      19 => 
      array (
        'code' => 'GR',
        'name' => 'Groznyy',
      ),
      20 => 
      array (
        'code' => 'IR',
        'name' => '이르쿠츠크',
      ),
      21 => 
      array (
        'code' => 'IV',
        'name' => '이바노 보',
      ),
      22 => 
      array (
        'code' => 'IZ',
        'name' => '이제 프 스크',
      ),
      23 => 
      array (
        'code' => 'KA',
        'name' => '칼리닌그라드',
      ),
      24 => 
      array (
        'code' => 'KL',
        'name' => '칼루',
      ),
      25 => 
      array (
        'code' => 'KS',
        'name' => 'Kasnodar',
      ),
      26 => 
      array (
        'code' => 'KZ',
        'name' => '카잔',
      ),
      27 => 
      array (
        'code' => 'KE',
        'name' => '케메 로보',
      ),
      28 => 
      array (
        'code' => 'KH',
        'name' => '하바 로브 스크',
      ),
      29 => 
      array (
        'code' => 'KM',
        'name' => '한티 만시 스크',
      ),
      30 => 
      array (
        'code' => 'KO',
        'name' => '코스트 로마',
      ),
      31 => 
      array (
        'code' => 'KR',
        'name' => '크라 스노 다르',
      ),
      32 => 
      array (
        'code' => 'KN',
        'name' => '크라스 노야 르 스크',
      ),
      33 => 
      array (
        'code' => 'KU',
        'name' => 'Kudymkar',
      ),
      34 => 
      array (
        'code' => 'KG',
        'name' => '쿠 르간',
      ),
      35 => 
      array (
        'code' => 'KK',
        'name' => '쿠르스크',
      ),
      36 => 
      array (
        'code' => 'KY',
        'name' => '키질',
      ),
      37 => 
      array (
        'code' => 'LI',
        'name' => '리페 츠크',
      ),
      38 => 
      array (
        'code' => 'MA',
        'name' => '마가 단',
      ),
      39 => 
      array (
        'code' => 'MK',
        'name' => '마하 치 칼라',
      ),
      40 => 
      array (
        'code' => 'MY',
        'name' => '마이 코프',
      ),
      41 => 
      array (
        'code' => 'MO',
        'name' => '모스크바',
      ),
      42 => 
      array (
        'code' => 'MU',
        'name' => '무르만스크',
      ),
      43 => 
      array (
        'code' => 'NA',
        'name' => '날 치크',
      ),
      44 => 
      array (
        'code' => 'NR',
        'name' => '나리 얀 마르',
      ),
      45 => 
      array (
        'code' => 'NZ',
        'name' => 'Nazran',
      ),
      46 => 
      array (
        'code' => 'NI',
        'name' => '니즈니 노브 고로드',
      ),
      47 => 
      array (
        'code' => 'NO',
        'name' => '노브 고로드',
      ),
      48 => 
      array (
        'code' => 'NV',
        'name' => '노보시비르스크',
      ),
      49 => 
      array (
        'code' => 'OM',
        'name' => '옴 스크',
      ),
      50 => 
      array (
        'code' => 'OR',
        'name' => '오렐',
      ),
      51 => 
      array (
        'code' => 'OE',
        'name' => '오렌 부르크',
      ),
      52 => 
      array (
        'code' => 'PA',
        'name' => 'Palana',
      ),
      53 => 
      array (
        'code' => 'PE',
        'name' => '펜자',
      ),
      54 => 
      array (
        'code' => 'PR',
        'name' => '파마',
      ),
      55 => 
      array (
        'code' => 'PK',
        'name' => '페트로 파블로프 스크 - 캄차 츠키',
      ),
      56 => 
      array (
        'code' => 'PT',
        'name' => '페트로 자봇 스크',
      ),
      57 => 
      array (
        'code' => 'PS',
        'name' => '프 스코프',
      ),
      58 => 
      array (
        'code' => 'RO',
        'name' => '로스토프 - 나 - Donu',
      ),
      59 => 
      array (
        'code' => 'RY',
        'name' => '랴잔',
      ),
      60 => 
      array (
        'code' => 'SL',
        'name' => '살레 하르트',
      ),
      61 => 
      array (
        'code' => 'SA',
        'name' => '사마라',
      ),
      62 => 
      array (
        'code' => 'SR',
        'name' => '사란 스크',
      ),
      63 => 
      array (
        'code' => 'SV',
        'name' => '사라 토프',
      ),
      64 => 
      array (
        'code' => 'SM',
        'name' => '스몰 렌 스크',
      ),
      65 => 
      array (
        'code' => 'SP',
        'name' => '세인트 피터스 버그',
      ),
      66 => 
      array (
        'code' => 'ST',
        'name' => '스타 브로 폴',
      ),
      67 => 
      array (
        'code' => 'SY',
        'name' => '티프',
      ),
      68 => 
      array (
        'code' => 'TA',
        'name' => '탐 보프',
      ),
      69 => 
      array (
        'code' => 'TO',
        'name' => '톰 스크',
      ),
      70 => 
      array (
        'code' => 'TU',
        'name' => '툴라',
      ),
      71 => 
      array (
        'code' => 'TR',
        'name' => '투라',
      ),
      72 => 
      array (
        'code' => 'TV',
        'name' => '트 베리',
      ),
      73 => 
      array (
        'code' => 'TY',
        'name' => '튜멘',
      ),
      74 => 
      array (
        'code' => 'UF',
        'name' => '우파',
      ),
      75 => 
      array (
        'code' => 'UL',
        'name' => 'Ul yanovsk',
      ),
      76 => 
      array (
        'code' => 'UU',
        'name' => '울란 우데',
      ),
      77 => 
      array (
        'code' => 'US',
        'name' => 'Ust-Ordynskiy',
      ),
      78 => 
      array (
        'code' => 'VL',
        'name' => '블라디 캅 카스',
      ),
      79 => 
      array (
        'code' => 'VA',
        'name' => '블라디미르',
      ),
      80 => 
      array (
        'code' => 'VV',
        'name' => '블라디보스토크',
      ),
      81 => 
      array (
        'code' => 'VG',
        'name' => '볼고그라드',
      ),
      82 => 
      array (
        'code' => 'VD',
        'name' => '볼 로그 다',
      ),
      83 => 
      array (
        'code' => 'VO',
        'name' => '보 로네시',
      ),
      84 => 
      array (
        'code' => 'VY',
        'name' => 'VYATKA',
      ),
      85 => 
      array (
        'code' => 'YA',
        'name' => '야쿠 츠크',
      ),
      86 => 
      array (
        'code' => 'YR',
        'name' => '야로 슬라 블',
      ),
      87 => 
      array (
        'code' => 'YE',
        'name' => '예 카테 린 부르크',
      ),
      88 => 
      array (
        'code' => 'YO',
        'name' => '요시 카르 올라',
      ),
    ),
    'RW' => 
    array (
      1 => 
      array (
        'code' => 'BU',
        'name' => '타레',
      ),
      2 => 
      array (
        'code' => 'BY',
        'name' => 'Byumba',
      ),
      3 => 
      array (
        'code' => 'CY',
        'name' => '씨앙 구구',
      ),
      4 => 
      array (
        'code' => 'GK',
        'name' => 'Gikongoro',
      ),
      5 => 
      array (
        'code' => 'GS',
        'name' => '기센',
      ),
      6 => 
      array (
        'code' => 'GT',
        'name' => 'Gitarama',
      ),
      7 => 
      array (
        'code' => 'KG',
        'name' => 'Kibungo',
      ),
      8 => 
      array (
        'code' => 'KY',
        'name' => 'Kibuye에',
      ),
      9 => 
      array (
        'code' => 'KR',
        'name' => '키 갈리 Rurale',
      ),
      10 => 
      array (
        'code' => 'KV',
        'name' => '키 갈리 - 빌',
      ),
      11 => 
      array (
        'code' => 'RU',
        'name' => 'Ruhengeri에',
      ),
      12 => 
      array (
        'code' => 'UM',
        'name' => 'Umutara',
      ),
    ),
    'SA' => 
    array (
      1 => 
      array (
        'code' => 'BH',
        'name' => '알 바야',
      ),
      2 => 
      array (
        'code' => 'HS',
        'name' => '알 Hudud 재 Shamaliyah',
      ),
      3 => 
      array (
        'code' => 'JF',
        'name' => '알 자 우프',
      ),
      4 => 
      array (
        'code' => 'MD',
        'name' => '알 마디나',
      ),
      5 => 
      array (
        'code' => 'QS',
        'name' => '알 카심',
      ),
      6 => 
      array (
        'code' => 'RD',
        'name' => '아칸소 리야드',
      ),
      7 => 
      array (
        'code' => 'AQ',
        'name' => '애쉬 샤르 키야 (동부)',
      ),
      8 => 
      array (
        'code' => 'AS',
        'name' => '아시르',
      ),
      9 => 
      array (
        'code' => 'HL',
        'name' => '하일',
      ),
      10 => 
      array (
        'code' => 'JZ',
        'name' => '지잔',
      ),
      11 => 
      array (
        'code' => 'ML',
        'name' => '메카',
      ),
      12 => 
      array (
        'code' => 'NR',
        'name' => '나지 란',
      ),
      13 => 
      array (
        'code' => 'TB',
        'name' => '타북',
      ),
    ),
    'SB' => 
    array (
      1 => 
      array (
        'code' => 'CE',
        'name' => '중앙',
      ),
      2 => 
      array (
        'code' => 'CH',
        'name' => '조아 젤',
      ),
      3 => 
      array (
        'code' => 'GC',
        'name' => '과달카날',
      ),
      4 => 
      array (
        'code' => 'HO',
        'name' => '호 니아 라',
      ),
      5 => 
      array (
        'code' => 'IS',
        'name' => '이사벨',
      ),
      6 => 
      array (
        'code' => 'MK',
        'name' => 'Makira',
      ),
      7 => 
      array (
        'code' => 'ML',
        'name' => '말 라이타',
      ),
      8 => 
      array (
        'code' => 'RB',
        'name' => 'Rennell 및 벨로',
      ),
      9 => 
      array (
        'code' => 'TM',
        'name' => '테 모투',
      ),
      10 => 
      array (
        'code' => 'WE',
        'name' => '서양',
      ),
    ),
    'SC' => 
    array (
      1 => 
      array (
        'code' => 'AP',
        'name' => '안세 보조 핀',
      ),
      2 => 
      array (
        'code' => 'AB',
        'name' => '안세 알로',
      ),
      3 => 
      array (
        'code' => 'AE',
        'name' => '안세 에투',
      ),
      4 => 
      array (
        'code' => 'AL',
        'name' => '안세 루이',
      ),
      5 => 
      array (
        'code' => 'AR',
        'name' => '안세 로열',
      ),
      6 => 
      array (
        'code' => 'BL',
        'name' => '바이에 라자 레',
      ),
      7 => 
      array (
        'code' => 'BS',
        'name' => '배생 앤',
      ),
      8 => 
      array (
        'code' => 'BV',
        'name' => '보 발론',
      ),
      9 => 
      array (
        'code' => 'BA',
        'name' => '벨 에어',
      ),
      10 => 
      array (
        'code' => 'BO',
        'name' => '벨 옴 브레',
      ),
      11 => 
      array (
        'code' => 'CA',
        'name' => '캐스케이드',
      ),
      12 => 
      array (
        'code' => 'GL',
        'name' => '세이셸에',
      ),
      13 => 
      array (
        'code' => 'GM',
        'name' => '그랜드 안세 (마헤시',
      ),
      14 => 
      array (
        'code' => 'GP',
        'name' => '그랜드 안세 (프라 슬린에',
      ),
      15 => 
      array (
        'code' => 'DG',
        'name' => '라 줘',
      ),
      16 => 
      array (
        'code' => 'RA',
        'name' => '라 리비에르 한국말',
      ),
      17 => 
      array (
        'code' => 'MB',
        'name' => '몽 벅스',
      ),
      18 => 
      array (
        'code' => 'MF',
        'name' => '몽 플레',
      ),
      19 => 
      array (
        'code' => 'PL',
        'name' => '플레 장스',
      ),
      20 => 
      array (
        'code' => 'PR',
        'name' => '포인트 라 뤼',
      ),
      21 => 
      array (
        'code' => 'PG',
        'name' => '포트 Glaud',
      ),
      22 => 
      array (
        'code' => 'SL',
        'name' => '세인트 루이스',
      ),
      23 => 
      array (
        'code' => 'TA',
        'name' => '타카',
      ),
    ),
    'SD' => 
    array (
      1 => 
      array (
        'code' => 'ANL',
        'name' => 'A ali 무기 호',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => '알 바르 알 아마르',
      ),
      3 => 
      array (
        'code' => 'BRT',
        'name' => '알 Buhayrat',
      ),
      4 => 
      array (
        'code' => 'JZR',
        'name' => '알 자지라',
      ),
      5 => 
      array (
        'code' => 'KRT',
        'name' => '알 카르 툼',
      ),
      6 => 
      array (
        'code' => 'QDR',
        'name' => '알 Qadarif',
      ),
      7 => 
      array (
        'code' => 'WDH',
        'name' => '알 Wahdah',
      ),
      8 => 
      array (
        'code' => 'ANB',
        'name' => '무기 호 알 Abyad',
      ),
      9 => 
      array (
        'code' => 'ANZ',
        'name' => '전무 알 Azraq에서',
      ),
      10 => 
      array (
        'code' => 'ASH',
        'name' => '애쉬 Shamaliyah',
      ),
      11 => 
      array (
        'code' => 'BJA',
        'name' => '바르 알 자발',
      ),
      12 => 
      array (
        'code' => 'GIS',
        'name' => 'Gharb에 알 Istiwa iyah',
      ),
      13 => 
      array (
        'code' => 'GBG',
        'name' => 'Gharb에 바르 알 가잘',
      ),
      14 => 
      array (
        'code' => 'GDA',
        'name' => 'Gharb의 다르 푸르',
      ),
      15 => 
      array (
        'code' => 'GKU',
        'name' => 'Gharb에 쿠르 두판',
      ),
      16 => 
      array (
        'code' => 'JDA',
        'name' => '누브 다르 푸르',
      ),
      17 => 
      array (
        'code' => 'JKU',
        'name' => '누브 쿠르 두판',
      ),
      18 => 
      array (
        'code' => 'JQL',
        'name' => 'Junqali',
      ),
      19 => 
      array (
        'code' => 'KSL',
        'name' => '카 살라',
      ),
      20 => 
      array (
        'code' => 'NNL',
        'name' => '흐르 무기 호',
      ),
      21 => 
      array (
        'code' => 'SBG',
        'name' => '샤말 바르 알 가잘',
      ),
      22 => 
      array (
        'code' => 'SDA',
        'name' => '샤말 다르 푸르',
      ),
      23 => 
      array (
        'code' => 'SKU',
        'name' => '샤말 쿠르 두판',
      ),
      24 => 
      array (
        'code' => 'SIS',
        'name' => '샤 르크 알 Istiwa iyah',
      ),
      25 => 
      array (
        'code' => 'SNR',
        'name' => 'Sinnar',
      ),
      26 => 
      array (
        'code' => 'WRB',
        'name' => 'Warab',
      ),
    ),
    'SE' => 
    array (
      1 => 
      array (
        'code' => 'K',
        'name' => '블레 킹',
      ),
      2 => 
      array (
        'code' => 'W',
        'name' => 'Dalama',
      ),
      3 => 
      array (
        'code' => 'I',
        'name' => '고틀란드',
      ),
      4 => 
      array (
        'code' => 'X',
        'name' => '예 블레 보리',
      ),
      5 => 
      array (
        'code' => 'N',
        'name' => '할란드',
      ),
      6 => 
      array (
        'code' => 'Z',
        'name' => 'Jämtland에',
      ),
      7 => 
      array (
        'code' => 'F',
        'name' => '욘',
      ),
      8 => 
      array (
        'code' => 'H',
        'name' => '칼 마르',
      ),
      9 => 
      array (
        'code' => 'G',
        'name' => '크로노 베리',
      ),
      10 => 
      array (
        'code' => 'BD',
        'name' => '노르 보텐 (주',
      ),
      11 => 
      array (
        'code' => 'M',
        'name' => '스코 네 (Skane',
      ),
      12 => 
      array (
        'code' => 'AB',
        'name' => '스톡홀름',
      ),
      13 => 
      array (
        'code' => 'D',
        'name' => 'Södermanland에',
      ),
      14 => 
      array (
        'code' => 'C',
        'name' => '웁살라',
      ),
      15 => 
      array (
        'code' => 'S',
        'name' => '베름 란드',
      ),
      16 => 
      array (
        'code' => 'AC',
        'name' => 'Västerbotten에',
      ),
      17 => 
      array (
        'code' => 'Y',
        'name' => '베스',
      ),
      18 => 
      array (
        'code' => 'U',
        'name' => 'Västmanland의',
      ),
      19 => 
      array (
        'code' => 'O',
        'name' => 'Västra Götaland',
      ),
      20 => 
      array (
        'code' => 'T',
        'name' => '외 레브로',
      ),
      21 => 
      array (
        'code' => 'E',
        'name' => '외스 테르 예틀 란드',
      ),
    ),
    'SH' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => '상승',
      ),
      2 => 
      array (
        'code' => 'S',
        'name' => '세인트 헬레나',
      ),
      3 => 
      array (
        'code' => 'T',
        'name' => '트리스탄 다 쿠냐',
      ),
    ),
    'SI' => 
    array (
      1 => 
      array (
        'code' => '4',
        'name' => 'Štajerska',
      ),
      2 => 
      array (
        'code' => '2A',
        'name' => 'Gorenjska',
      ),
      3 => 
      array (
        'code' => '5',
        'name' => 'Prekmurje',
      ),
      4 => 
      array (
        'code' => '3',
        'name' => 'Koroška',
      ),
      5 => 
      array (
        'code' => '2B',
        'name' => 'Notranjska',
      ),
      6 => 
      array (
        'code' => '1',
        'name' => 'Primorska',
      ),
      7 => 
      array (
        'code' => '2C',
        'name' => 'Dolenjska',
      ),
      8 => 
      array (
        'code' => '2C',
        'name' => '벨라 쿠라이나',
      ),
    ),
    'SK' => 
    array (
      1 => 
      array (
        'code' => 'BA',
        'name' => 'Banskobystricky',
      ),
      2 => 
      array (
        'code' => 'BR',
        'name' => 'Bratislavsky',
      ),
      3 => 
      array (
        'code' => 'KO',
        'name' => 'Kosicky',
      ),
      4 => 
      array (
        'code' => 'NI',
        'name' => 'Nitriansky',
      ),
      5 => 
      array (
        'code' => 'PR',
        'name' => 'Presovsky',
      ),
      6 => 
      array (
        'code' => 'TC',
        'name' => 'Trenciansky',
      ),
      7 => 
      array (
        'code' => 'TV',
        'name' => 'Trnavsky',
      ),
      8 => 
      array (
        'code' => 'ZI',
        'name' => 'Zilinsky',
      ),
    ),
    'SL' => 
    array (
      1 => 
      array (
        'code' => 'E',
        'name' => '동부',
      ),
      2 => 
      array (
        'code' => 'N',
        'name' => '북',
      ),
      3 => 
      array (
        'code' => 'S',
        'name' => '남부',
      ),
      4 => 
      array (
        'code' => 'W',
        'name' => '서양',
      ),
    ),
    'SM' => 
    array (
      1 => 
      array (
        'code' => 'AC',
        'name' => '아쿠아 비바',
      ),
      2 => 
      array (
        'code' => 'BM',
        'name' => '보르고 마 죠레',
      ),
      3 => 
      array (
        'code' => 'CH',
        'name' => 'Chiesanuova',
      ),
      4 => 
      array (
        'code' => 'DO',
        'name' => '도마 그 나노',
      ),
      5 => 
      array (
        'code' => 'FA',
        'name' => '타노',
      ),
      6 => 
      array (
        'code' => 'FI',
        'name' => '피 오렌 티노',
      ),
      7 => 
      array (
        'code' => 'MO',
        'name' => '몬테',
      ),
      8 => 
      array (
        'code' => 'SM',
        'name' => '치타 디 산 마리노',
      ),
      9 => 
      array (
        'code' => 'SE',
        'name' => '세라',
      ),
    ),
    'SN' => 
    array (
      1 => 
      array (
        'code' => 'DA',
        'name' => '다카르',
      ),
      2 => 
      array (
        'code' => 'DI',
        'name' => 'Diourbel',
      ),
      3 => 
      array (
        'code' => 'FA',
        'name' => 'Fatick',
      ),
      4 => 
      array (
        'code' => 'KA',
        'name' => 'Kaolack',
      ),
      5 => 
      array (
        'code' => 'KO',
        'name' => '콜다',
      ),
      6 => 
      array (
        'code' => 'LO',
        'name' => 'Louga',
      ),
      7 => 
      array (
        'code' => 'MA',
        'name' => '마탐',
      ),
      8 => 
      array (
        'code' => 'SL',
        'name' => '생 루이',
      ),
      9 => 
      array (
        'code' => 'TA',
        'name' => 'Tambacounda',
      ),
      10 => 
      array (
        'code' => 'TH',
        'name' => '티에스',
      ),
      11 => 
      array (
        'code' => 'ZI',
        'name' => '겐쇼',
      ),
    ),
    'SO' => 
    array (
      1 => 
      array (
        'code' => 'AW',
        'name' => 'Awdal',
      ),
      2 => 
      array (
        'code' => 'BK',
        'name' => '바쿨',
      ),
      3 => 
      array (
        'code' => 'BN',
        'name' => '바나 디르',
      ),
      4 => 
      array (
        'code' => 'BR',
        'name' => '바리',
      ),
      5 => 
      array (
        'code' => 'BY',
        'name' => '베이',
      ),
      6 => 
      array (
        'code' => 'GA',
        'name' => 'Galguduud',
      ),
      7 => 
      array (
        'code' => 'GE',
        'name' => '제드',
      ),
      8 => 
      array (
        'code' => 'HI',
        'name' => 'Hiiraan',
      ),
      9 => 
      array (
        'code' => 'JD',
        'name' => 'Jubbada Dhexe',
      ),
      10 => 
      array (
        'code' => 'JH',
        'name' => 'Jubbada의 hoose',
      ),
      11 => 
      array (
        'code' => 'MU',
        'name' => 'Mudug',
      ),
      12 => 
      array (
        'code' => 'NU',
        'name' => 'Nugaal',
      ),
      13 => 
      array (
        'code' => 'SA',
        'name' => 'Sanaag',
      ),
      14 => 
      array (
        'code' => 'SD',
        'name' => 'Shabeellaha Dhexe',
      ),
      15 => 
      array (
        'code' => 'SH',
        'name' => 'Shabeellaha의 hoose',
      ),
      16 => 
      array (
        'code' => 'SL',
        'name' => 'Sool',
      ),
      17 => 
      array (
        'code' => 'TO',
        'name' => 'Togdheer',
      ),
      18 => 
      array (
        'code' => 'WG',
        'name' => 'Woqooyi Galbeed',
      ),
    ),
    'SR' => 
    array (
      1 => 
      array (
        'code' => 'BR',
        'name' => 'Brokopondo',
      ),
      2 => 
      array (
        'code' => 'CM',
        'name' => 'Commewijne',
      ),
      3 => 
      array (
        'code' => 'CR',
        'name' => 'Coronie',
      ),
      4 => 
      array (
        'code' => 'MA',
        'name' => 'Marowijne',
      ),
      5 => 
      array (
        'code' => 'NI',
        'name' => 'Nickerie',
      ),
      6 => 
      array (
        'code' => 'PA',
        'name' => '파라',
      ),
      7 => 
      array (
        'code' => 'PM',
        'name' => '파라 마리 보',
      ),
      9 => 
      array (
        'code' => 'SA',
        'name' => 'Saramacca',
      ),
      10 => 
      array (
        'code' => 'SI',
        'name' => 'Sipaliwini',
      ),
      11 => 
      array (
        'code' => 'WA',
        'name' => 'Wanica',
      ),
    ),
    'ST' => 
    array (
      1 => 
      array (
        'code' => 'S',
        'name' => '상투 메',
      ),
      2 => 
      array (
        'code' => 'P',
        'name' => '프린시 페',
      ),
    ),
    'SV' => 
    array (
      1 => 
      array (
        'code' => 'AH',
        'name' => 'Ahuachapan',
      ),
      2 => 
      array (
        'code' => 'CA',
        'name' => '카바나',
      ),
      3 => 
      array (
        'code' => 'CH',
        'name' => 'Chalatenango',
      ),
      4 => 
      array (
        'code' => 'CU',
        'name' => '민주주의의',
      ),
      5 => 
      array (
        'code' => 'LB',
        'name' => '라 리베르 타드',
      ),
      6 => 
      array (
        'code' => 'PZ',
        'name' => '라 파스',
      ),
      7 => 
      array (
        'code' => 'UN',
        'name' => '라 유니언',
      ),
      8 => 
      array (
        'code' => 'MO',
        'name' => '모라 잔',
      ),
      9 => 
      array (
        'code' => 'SM',
        'name' => '산 미겔',
      ),
      10 => 
      array (
        'code' => 'SS',
        'name' => '산 살바도르',
      ),
      11 => 
      array (
        'code' => 'SV',
        'name' => '산 비센테',
      ),
      12 => 
      array (
        'code' => 'SA',
        'name' => '산타 아나',
      ),
      13 => 
      array (
        'code' => 'SO',
        'name' => 'Sonsonate의',
      ),
      14 => 
      array (
        'code' => 'US',
        'name' => '우 술루 탄',
      ),
    ),
    'SY' => 
    array (
      1 => 
      array (
        'code' => 'HA',
        'name' => '알 Hasakah',
      ),
      2 => 
      array (
        'code' => 'LA',
        'name' => '알 Ladhiqiyah',
      ),
      3 => 
      array (
        'code' => 'QU',
        'name' => '알 Qunaytirah',
      ),
      4 => 
      array (
        'code' => 'RQ',
        'name' => '아르 Raqqah',
      ),
      5 => 
      array (
        'code' => 'SU',
        'name' => 'Suwayda 등',
      ),
      6 => 
      array (
        'code' => 'DA',
        'name' => '다라',
      ),
      7 => 
      array (
        'code' => 'DZ',
        'name' => '다 이르 아주르',
      ),
      8 => 
      array (
        'code' => 'DI',
        'name' => '디마 슈크',
      ),
      9 => 
      array (
        'code' => 'HL',
        'name' => 'Halab',
      ),
      10 => 
      array (
        'code' => 'HM',
        'name' => 'Hamah의',
      ),
      11 => 
      array (
        'code' => 'HI',
        'name' => '힘스',
      ),
      12 => 
      array (
        'code' => 'ID',
        'name' => '이들 리브',
      ),
      13 => 
      array (
        'code' => 'RD',
        'name' => '리프 디마 슈크',
      ),
      14 => 
      array (
        'code' => 'TA',
        'name' => 'Tartus',
      ),
    ),
    'SZ' => 
    array (
      1 => 
      array (
        'code' => 'H',
        'name' => 'Hhohho',
      ),
      2 => 
      array (
        'code' => 'L',
        'name' => 'Lubombo',
      ),
      3 => 
      array (
        'code' => 'M',
        'name' => '만지니',
      ),
      4 => 
      array (
        'code' => 'S',
        'name' => 'Shishelweni',
      ),
    ),
    'TC' => 
    array (
      1 => 
      array (
        'code' => 'AC',
        'name' => '암 베르 그리스 케이',
      ),
      2 => 
      array (
        'code' => 'DC',
        'name' => '델리 스 케이',
      ),
      3 => 
      array (
        'code' => 'FC',
        'name' => '프랑스어 케이',
      ),
      4 => 
      array (
        'code' => 'LW',
        'name' => '약간의 물 케이',
      ),
      5 => 
      array (
        'code' => 'RC',
        'name' => '앵무새 케이',
      ),
      6 => 
      array (
        'code' => 'PN',
        'name' => '파인 케이',
      ),
      7 => 
      array (
        'code' => 'SL',
        'name' => '솔트 케이',
      ),
      8 => 
      array (
        'code' => 'GT',
        'name' => '그랜드 터크',
      ),
      9 => 
      array (
        'code' => 'SC',
        'name' => '사우스 카이',
      ),
      10 => 
      array (
        'code' => 'EC',
        'name' => '동 커스',
      ),
      11 => 
      array (
        'code' => 'MC',
        'name' => '중동 케이 커스',
      ),
      12 => 
      array (
        'code' => 'NC',
        'name' => '노스 카이 코스',
      ),
      13 => 
      array (
        'code' => 'PR',
        'name' => '프로 비덴시 알레스',
      ),
      14 => 
      array (
        'code' => 'WC',
        'name' => '웨스트 케이 커스 제도',
      ),
    ),
    'TD' => 
    array (
      1 => 
      array (
        'code' => 'BA',
        'name' => '바트',
      ),
      2 => 
      array (
        'code' => 'BI',
        'name' => 'Biltine',
      ),
      3 => 
      array (
        'code' => 'BE',
        'name' => 'Borkou-Ennedi - 티 베스티',
      ),
      4 => 
      array (
        'code' => 'CB',
        'name' => '샤리 - 리바 귀 르미',
      ),
      5 => 
      array (
        'code' => 'GU',
        'name' => '구 에라',
      ),
      6 => 
      array (
        'code' => 'KA',
        'name' => '카넴',
      ),
      7 => 
      array (
        'code' => 'LA',
        'name' => '락',
      ),
      8 => 
      array (
        'code' => 'LC',
        'name' => 'Logone 옥시 덴탈',
      ),
      9 => 
      array (
        'code' => 'LR',
        'name' => 'Logone 동양',
      ),
      10 => 
      array (
        'code' => 'MK',
        'name' => '마요 케비',
      ),
      11 => 
      array (
        'code' => 'MC',
        'name' => '모옌 샤리',
      ),
      12 => 
      array (
        'code' => 'OU',
        'name' => 'Ouaddai',
      ),
      13 => 
      array (
        'code' => 'SA',
        'name' => '살라',
      ),
      14 => 
      array (
        'code' => 'TA',
        'name' => '탄 질레',
      ),
    ),
    'TF' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => '레스 크로 젯',
      ),
      2 => 
      array (
        'code' => 'K',
        'name' => '레스 케르 켈렌',
      ),
      3 => 
      array (
        'code' => 'A',
        'name' => '일 암스테르담',
      ),
      4 => 
      array (
        'code' => 'P',
        'name' => '일 세인트 폴',
      ),
      5 => 
      array (
        'code' => 'D',
        'name' => '아 델리 랜드',
      ),
    ),
    'TG' => 
    array (
      1 => 
      array (
        'code' => 'K',
        'name' => '카라',
      ),
      2 => 
      array (
        'code' => 'P',
        'name' => '플래 토우',
      ),
      3 => 
      array (
        'code' => 'S',
        'name' => 'Savanes',
      ),
      4 => 
      array (
        'code' => 'C',
        'name' => '센트 랄',
      ),
      5 => 
      array (
        'code' => 'M',
        'name' => '해양',
      ),
    ),
    'TH' => 
    array (
      1 => 
      array (
        'code' => 'Amnat Charoen',
        'name' => '암낫 차로 엔',
      ),
      2 => 
      array (
        'code' => 'Ang Thong',
        'name' => '중앙 통',
      ),
      3 => 
      array (
        'code' => 'Ayutthaya',
        'name' => '아유타야',
      ),
      4 => 
      array (
        'code' => 'Bangkok',
        'name' => '방콕',
      ),
      5 => 
      array (
        'code' => 'Buriram',
        'name' => '부리 람',
      ),
      6 => 
      array (
        'code' => 'Chachoengsao',
        'name' => '사오',
      ),
      7 => 
      array (
        'code' => 'Chai Nat',
        'name' => '차이 NAT',
      ),
      8 => 
      array (
        'code' => 'Chaiyaphum',
        'name' => 'Chaiyaphum에',
      ),
      9 => 
      array (
        'code' => 'Chanthaburi',
        'name' => '찬타 부리',
      ),
      10 => 
      array (
        'code' => 'Chiang Mai',
        'name' => '치앙마이',
      ),
      11 => 
      array (
        'code' => 'Chiang Rai',
        'name' => '치앙 라이',
      ),
      12 => 
      array (
        'code' => 'Chon Buri',
        'name' => '촌부리',
      ),
      13 => 
      array (
        'code' => 'Chumphon',
        'name' => '춤폰',
      ),
      14 => 
      array (
        'code' => 'Kalasin',
        'name' => '칼라 신',
      ),
      15 => 
      array (
        'code' => 'Kamphaeng Phet',
        'name' => '깜 팽 펫',
      ),
      16 => 
      array (
        'code' => 'Kanchanaburi',
        'name' => '칸차나 부리',
      ),
      17 => 
      array (
        'code' => 'Khon Kaen',
        'name' => '콘캔',
      ),
      18 => 
      array (
        'code' => 'Krabi',
        'name' => '크라비',
      ),
      19 => 
      array (
        'code' => 'Lampang',
        'name' => '람팡',
      ),
      20 => 
      array (
        'code' => 'Lamphun',
        'name' => '람푼',
      ),
      21 => 
      array (
        'code' => 'Loei',
        'name' => '로이',
      ),
      22 => 
      array (
        'code' => 'Lop Buri',
        'name' => '부리를 버렸어',
      ),
      23 => 
      array (
        'code' => 'Mae Hong Son',
        'name' => '매 홍손',
      ),
      24 => 
      array (
        'code' => 'Maha Sarakham',
        'name' => '마하 Sarakham',
      ),
      25 => 
      array (
        'code' => 'Mukdahan',
        'name' => '묵다',
      ),
      26 => 
      array (
        'code' => 'Nakhon Nayok',
        'name' => '나콘 나 욕',
      ),
      27 => 
      array (
        'code' => 'Nakhon Pathom',
        'name' => '나콘 파톰',
      ),
      28 => 
      array (
        'code' => 'Nakhon Phanom',
        'name' => '나콘 파놈',
      ),
      29 => 
      array (
        'code' => 'Nakhon Ratchasima',
        'name' => '나콘 라차 시마',
      ),
      30 => 
      array (
        'code' => 'Nakhon Sawan',
        'name' => '나콘 사 완',
      ),
      31 => 
      array (
        'code' => 'Nakhon Si Thammarat',
        'name' => '나콘시 타마 랏',
      ),
      32 => 
      array (
        'code' => 'Nan',
        'name' => '난',
      ),
      33 => 
      array (
        'code' => 'Narathiwat',
        'name' => '나라 티왓',
      ),
      34 => 
      array (
        'code' => 'Nong Bua Lamphu',
        'name' => '농 아야 람푸',
      ),
      35 => 
      array (
        'code' => 'Nong Khai',
        'name' => '농 카이',
      ),
      36 => 
      array (
        'code' => 'Nonthaburi',
        'name' => '논타 부리',
      ),
      37 => 
      array (
        'code' => 'Pathum Thani',
        'name' => '빠툼 타니',
      ),
      38 => 
      array (
        'code' => 'Pattani',
        'name' => '파 타니',
      ),
      39 => 
      array (
        'code' => 'Phangnga',
        'name' => '팡아',
      ),
      40 => 
      array (
        'code' => 'Phatthalung',
        'name' => '파탈 룽',
      ),
      41 => 
      array (
        'code' => 'Phayao',
        'name' => '파야 오',
      ),
      42 => 
      array (
        'code' => 'Phetchabun',
        'name' => '차분',
      ),
      43 => 
      array (
        'code' => 'Phetchaburi',
        'name' => '펫차 부리',
      ),
      44 => 
      array (
        'code' => 'Phichit',
        'name' => 'Phichit',
      ),
      45 => 
      array (
        'code' => 'Phitsanulok',
        'name' => '피차 눌 로크',
      ),
      46 => 
      array (
        'code' => 'Phrae',
        'name' => '프',
      ),
      47 => 
      array (
        'code' => 'Phuket',
        'name' => '푸켓',
      ),
      48 => 
      array (
        'code' => 'Prachin Buri',
        'name' => 'Prachin 부리',
      ),
      49 => 
      array (
        'code' => 'Prachuap Khiri Khan',
        'name' => '프라 추압 키리 칸',
      ),
      50 => 
      array (
        'code' => 'Ranong',
        'name' => '라농',
      ),
      51 => 
      array (
        'code' => 'Ratchaburi',
        'name' => '라차​​ 부리',
      ),
      52 => 
      array (
        'code' => 'Rayong',
        'name' => '라용',
      ),
      53 => 
      array (
        'code' => 'Roi Et',
        'name' => '투자 수익 잇',
      ),
      54 => 
      array (
        'code' => 'Sa Kaeo',
        'name' => '사 깨',
      ),
      55 => 
      array (
        'code' => 'Sakon Nakhon',
        'name' => '사콘 나콘',
      ),
      56 => 
      array (
        'code' => 'Samut Prakan',
        'name' => '사무 트 프라 칸',
      ),
      57 => 
      array (
        'code' => 'Samut Sakhon',
        'name' => '사뭇 사 콘',
      ),
      58 => 
      array (
        'code' => 'Samut Songkhram',
        'name' => '사뭇 송 크람',
      ),
      59 => 
      array (
        'code' => 'Sara Buri',
        'name' => '사라 부리',
      ),
      60 => 
      array (
        'code' => 'Satun',
        'name' => '사툰',
      ),
      61 => 
      array (
        'code' => 'Sing Buri',
        'name' => '노래 부리',
      ),
      62 => 
      array (
        'code' => 'Sisaket',
        'name' => 'Sisaket',
      ),
      63 => 
      array (
        'code' => 'Songkhla',
        'name' => '송클라',
      ),
      64 => 
      array (
        'code' => 'Sukhothai',
        'name' => '수코타이',
      ),
      65 => 
      array (
        'code' => 'Suphan Buri',
        'name' => '판 부리',
      ),
      66 => 
      array (
        'code' => 'Surat Thani',
        'name' => '수랏 타니',
      ),
      67 => 
      array (
        'code' => 'Surin',
        'name' => '수린',
      ),
      68 => 
      array (
        'code' => 'Tak',
        'name' => '탁',
      ),
      69 => 
      array (
        'code' => 'Trang',
        'name' => '트랑',
      ),
      70 => 
      array (
        'code' => 'Trat',
        'name' => '뜨랏',
      ),
      71 => 
      array (
        'code' => 'Ubon Ratchathani',
        'name' => '우본 라차 타니',
      ),
      72 => 
      array (
        'code' => 'Udon Thani',
        'name' => '우돈 타니',
      ),
      73 => 
      array (
        'code' => 'Uthai Thani',
        'name' => '우타이 타니',
      ),
      74 => 
      array (
        'code' => 'Uttaradit',
        'name' => '딧',
      ),
      75 => 
      array (
        'code' => 'Yala',
        'name' => '얄라',
      ),
      76 => 
      array (
        'code' => 'Yasothon',
        'name' => '야소 톤',
      ),
    ),
    'TJ' => 
    array (
      1 => 
      array (
        'code' => 'GB',
        'name' => '르노 Badakhstan',
      ),
      2 => 
      array (
        'code' => 'KT',
        'name' => '틀론',
      ),
      3 => 
      array (
        'code' => 'SU',
        'name' => 'Sughd',
      ),
    ),
    'TK' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Atafu에',
      ),
      2 => 
      array (
        'code' => 'F',
        'name' => '파카 오푸',
      ),
      3 => 
      array (
        'code' => 'N',
        'name' => 'Nukunonu에',
      ),
    ),
    'TM' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => '아할 Welayaty',
      ),
      2 => 
      array (
        'code' => 'B',
        'name' => '발칸 Welayaty',
      ),
      3 => 
      array (
        'code' => 'D',
        'name' => 'Dashhowuz Welayaty',
      ),
      4 => 
      array (
        'code' => 'L',
        'name' => 'Lebap Welayaty',
      ),
      5 => 
      array (
        'code' => 'M',
        'name' => '메리 Welayaty',
      ),
    ),
    'TN' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => '아리아나',
      ),
      2 => 
      array (
        'code' => 'BJ',
        'name' => '베자',
      ),
      3 => 
      array (
        'code' => 'BA',
        'name' => '벤 Arous',
      ),
      4 => 
      array (
        'code' => 'BI',
        'name' => '비 제르 테',
      ),
      5 => 
      array (
        'code' => 'GB',
        'name' => '가베스',
      ),
      6 => 
      array (
        'code' => 'GF',
        'name' => '가프',
      ),
      7 => 
      array (
        'code' => 'JE',
        'name' => 'Jendouba',
      ),
      8 => 
      array (
        'code' => 'KR',
        'name' => '케 루앙',
      ),
      9 => 
      array (
        'code' => 'KS',
        'name' => '쎄린',
      ),
      10 => 
      array (
        'code' => 'KB',
        'name' => '케 빌리',
      ),
      11 => 
      array (
        'code' => 'KF',
        'name' => 'KEF',
      ),
      12 => 
      array (
        'code' => 'MH',
        'name' => '마흐디 아',
      ),
      13 => 
      array (
        'code' => 'MN',
        'name' => 'Manouba',
      ),
      14 => 
      array (
        'code' => 'ME',
        'name' => '제르',
      ),
      15 => 
      array (
        'code' => 'MO',
        'name' => '모나스 티르',
      ),
      16 => 
      array (
        'code' => 'NA',
        'name' => '나블',
      ),
      17 => 
      array (
        'code' => 'SF',
        'name' => '스팍스',
      ),
      18 => 
      array (
        'code' => 'SD',
        'name' => '시디',
      ),
      19 => 
      array (
        'code' => 'SL',
        'name' => '실리아',
      ),
      20 => 
      array (
        'code' => 'SO',
        'name' => '수스',
      ),
      21 => 
      array (
        'code' => 'TA',
        'name' => '타타',
      ),
      22 => 
      array (
        'code' => 'TO',
        'name' => '토 주르',
      ),
      23 => 
      array (
        'code' => 'TU',
        'name' => '튀니스',
      ),
      24 => 
      array (
        'code' => 'ZA',
        'name' => 'Zaghouan',
      ),
    ),
    'TO' => 
    array (
      1 => 
      array (
        'code' => 'H',
        'name' => '하 파이',
      ),
      2 => 
      array (
        'code' => 'T',
        'name' => '통가 타푸',
      ),
      3 => 
      array (
        'code' => 'V',
        'name' => 'Vava u의',
      ),
    ),
    'TP' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Aileu',
      ),
      2 => 
      array (
        'code' => 'AN',
        'name' => 'Ainaro',
      ),
      3 => 
      array (
        'code' => 'BA',
        'name' => 'Baucau',
      ),
      4 => 
      array (
        'code' => 'BO',
        'name' => 'Bobonaro',
      ),
      5 => 
      array (
        'code' => 'CO',
        'name' => '코바 리마',
      ),
      6 => 
      array (
        'code' => 'DI',
        'name' => '딜리',
      ),
      7 => 
      array (
        'code' => 'ER',
        'name' => 'Ermera',
      ),
      8 => 
      array (
        'code' => 'LA',
        'name' => 'Lautem',
      ),
      9 => 
      array (
        'code' => 'LI',
        'name' => 'Liquica',
      ),
      10 => 
      array (
        'code' => 'MT',
        'name' => 'Manatuto',
      ),
      11 => 
      array (
        'code' => 'MF',
        'name' => 'Manufahi',
      ),
      12 => 
      array (
        'code' => 'OE',
        'name' => '오쿠시',
      ),
      13 => 
      array (
        'code' => 'VI',
        'name' => 'Viqueque',
      ),
    ),
    'TR' => 
    array (
      1 => 
      array (
        'code' => 'ADA',
        'name' => '아다 나',
      ),
      2 => 
      array (
        'code' => 'ADI',
        'name' => '아드야만',
      ),
      3 => 
      array (
        'code' => 'AFY',
        'name' => '피온',
      ),
      4 => 
      array (
        'code' => 'AGR',
        'name' => '농업',
      ),
      5 => 
      array (
        'code' => 'AKS',
        'name' => '악사',
      ),
      6 => 
      array (
        'code' => 'AMA',
        'name' => '아마스',
      ),
      7 => 
      array (
        'code' => 'ANK',
        'name' => '앙카라',
      ),
      8 => 
      array (
        'code' => 'ANT',
        'name' => '안탈리아',
      ),
      9 => 
      array (
        'code' => 'ARD',
        'name' => '아르 다한',
      ),
      10 => 
      array (
        'code' => 'ART',
        'name' => '아르 트빈',
      ),
      11 => 
      array (
        'code' => 'AYI',
        'name' => '아이 딘',
      ),
      12 => 
      array (
        'code' => 'BAL',
        'name' => '발리 케시 르',
      ),
      13 => 
      array (
        'code' => 'BAR',
        'name' => '바르틴',
      ),
      14 => 
      array (
        'code' => 'BAT',
        'name' => '배트맨',
      ),
      15 => 
      array (
        'code' => 'BAY',
        'name' => '바이 부르 트',
      ),
      16 => 
      array (
        'code' => 'BIL',
        'name' => '빌레 직',
      ),
      17 => 
      array (
        'code' => 'BIN',
        'name' => '빙괼',
      ),
      18 => 
      array (
        'code' => 'BIT',
        'name' => '비틀리스',
      ),
      19 => 
      array (
        'code' => 'BOL',
        'name' => '볼루',
      ),
      20 => 
      array (
        'code' => 'BRD',
        'name' => '부르 두르',
      ),
      21 => 
      array (
        'code' => 'BRS',
        'name' => '부르사',
      ),
      22 => 
      array (
        'code' => 'CKL',
        'name' => '차나 칼레',
      ),
      23 => 
      array (
        'code' => 'CKR',
        'name' => '칸 키리',
      ),
      24 => 
      array (
        'code' => 'COR',
        'name' => '코룸',
      ),
      25 => 
      array (
        'code' => 'DEN',
        'name' => '데니 즐리',
      ),
      26 => 
      array (
        'code' => 'DIY',
        'name' => '디야 르바 키르',
      ),
      27 => 
      array (
        'code' => 'DUZ',
        'name' => '듀 즈제',
      ),
      28 => 
      array (
        'code' => 'EDI',
        'name' => '에디 르네',
      ),
      29 => 
      array (
        'code' => 'ELA',
        'name' => '엘라 지크',
      ),
      30 => 
      array (
        'code' => 'EZC',
        'name' => '에르 진잔',
      ),
      31 => 
      array (
        'code' => 'EZR',
        'name' => '에르 주룸',
      ),
      32 => 
      array (
        'code' => 'ESK',
        'name' => '에스 키 세히 르',
      ),
      33 => 
      array (
        'code' => 'GAZ',
        'name' => '가지 안 테프',
      ),
      34 => 
      array (
        'code' => 'GIR',
        'name' => '레순',
      ),
      35 => 
      array (
        'code' => 'GMS',
        'name' => 'Gumushane',
      ),
      36 => 
      array (
        'code' => 'HKR',
        'name' => '카리',
      ),
      37 => 
      array (
        'code' => 'HTY',
        'name' => '하타이',
      ),
      38 => 
      array (
        'code' => 'IGD',
        'name' => 'Igdir의',
      ),
      39 => 
      array (
        'code' => 'ISP',
        'name' => '스파르타',
      ),
      40 => 
      array (
        'code' => 'IST',
        'name' => '이스탄불',
      ),
      41 => 
      array (
        'code' => 'IZM',
        'name' => '이즈미르',
      ),
      42 => 
      array (
        'code' => 'KAH',
        'name' => '카라 만 마라 슈',
      ),
      43 => 
      array (
        'code' => 'KRB',
        'name' => 'Karabuk',
      ),
      44 => 
      array (
        'code' => 'KRM',
        'name' => '카라 만',
      ),
      45 => 
      array (
        'code' => 'KRS',
        'name' => '카르 스',
      ),
      46 => 
      array (
        'code' => 'KAS',
        'name' => '카스타 모누',
      ),
      47 => 
      array (
        'code' => 'KAY',
        'name' => '카이 세리',
      ),
      48 => 
      array (
        'code' => 'KLS',
        'name' => '킬리스',
      ),
      49 => 
      array (
        'code' => 'KRK',
        'name' => '키리 칼레',
      ),
      50 => 
      array (
        'code' => 'KLR',
        'name' => '키르 클라 렐리',
      ),
      51 => 
      array (
        'code' => 'KRH',
        'name' => '키르 쉐 히르',
      ),
      52 => 
      array (
        'code' => 'KOC',
        'name' => '코카 엘리',
      ),
      53 => 
      array (
        'code' => 'KON',
        'name' => '콘야',
      ),
      54 => 
      array (
        'code' => 'KUT',
        'name' => '퀴타',
      ),
      55 => 
      array (
        'code' => 'MAL',
        'name' => '말라 티아',
      ),
      56 => 
      array (
        'code' => 'MAN',
        'name' => '마니',
      ),
      57 => 
      array (
        'code' => 'MAR',
        'name' => '마르 딘',
      ),
      58 => 
      array (
        'code' => 'MER',
        'name' => '메르 신',
      ),
      59 => 
      array (
        'code' => 'MUG',
        'name' => '물라',
      ),
      60 => 
      array (
        'code' => 'MUS',
        'name' => '뮤스',
      ),
      61 => 
      array (
        'code' => 'NEV',
        'name' => '네 브셰 히르',
      ),
      62 => 
      array (
        'code' => 'NIG',
        'name' => '니데',
      ),
      63 => 
      array (
        'code' => 'ORD',
        'name' => '오르',
      ),
      64 => 
      array (
        'code' => 'OSM',
        'name' => '오스 마니',
      ),
      65 => 
      array (
        'code' => 'RIZ',
        'name' => '리제',
      ),
      66 => 
      array (
        'code' => 'SAK',
        'name' => '사카 리아',
      ),
      67 => 
      array (
        'code' => 'SAM',
        'name' => '삼순',
      ),
      68 => 
      array (
        'code' => 'SAN',
        'name' => '산리 우르 파',
      ),
      69 => 
      array (
        'code' => 'SII',
        'name' => '시르 트',
      ),
      70 => 
      array (
        'code' => 'SIN',
        'name' => '시놉',
      ),
      71 => 
      array (
        'code' => 'SIR',
        'name' => '시르 나크',
      ),
      72 => 
      array (
        'code' => 'SIV',
        'name' => '시바스',
      ),
      73 => 
      array (
        'code' => 'TEL',
        'name' => '테 키르 다그',
      ),
      74 => 
      array (
        'code' => 'TOK',
        'name' => '토 카트',
      ),
      75 => 
      array (
        'code' => 'TRA',
        'name' => '트라 브존',
      ),
      76 => 
      array (
        'code' => 'TUN',
        'name' => '툰 셀리',
      ),
      77 => 
      array (
        'code' => 'USK',
        'name' => '우 샤크',
      ),
      78 => 
      array (
        'code' => 'VAN',
        'name' => '반',
      ),
      79 => 
      array (
        'code' => 'YAL',
        'name' => '얄 로바',
      ),
      80 => 
      array (
        'code' => 'YOZ',
        'name' => '요즈 가트',
      ),
      81 => 
      array (
        'code' => 'ZON',
        'name' => '종굴 다크',
      ),
    ),
    'TT' => 
    array (
      1 => 
      array (
        'code' => 'CT',
        'name' => '코우 / Tabaquite / Talparo',
      ),
      2 => 
      array (
        'code' => 'DM',
        'name' => '디에고 마틴',
      ),
      3 => 
      array (
        'code' => 'MR',
        'name' => 'Mayaro / 리오 클라로',
      ),
      4 => 
      array (
        'code' => 'PD',
        'name' => '형사 / 그럼 여기',
      ),
      5 => 
      array (
        'code' => 'PT',
        'name' => '프린스 타운',
      ),
      6 => 
      array (
        'code' => 'SG',
        'name' => 'Sangre에 그란데',
      ),
      7 => 
      array (
        'code' => 'SL',
        'name' => '산 후안 / Laventille',
      ),
      8 => 
      array (
        'code' => 'SI',
        'name' => 'Siparia',
      ),
      9 => 
      array (
        'code' => 'TP',
        'name' => 'Tunapuna / 피아',
      ),
      10 => 
      array (
        'code' => 'PS',
        'name' => '포트 오브 스페인',
      ),
      11 => 
      array (
        'code' => 'SF',
        'name' => '산 페르난도',
      ),
      12 => 
      array (
        'code' => 'AR',
        'name' => '아리마',
      ),
      13 => 
      array (
        'code' => 'PF',
        'name' => '포인트 포르 틴',
      ),
      14 => 
      array (
        'code' => 'CH',
        'name' => 'Chaguanas',
      ),
      15 => 
      array (
        'code' => 'TO',
        'name' => '토바고',
      ),
    ),
    'TV' => 
    array (
      1 => 
      array (
        'code' => 'NMG',
        'name' => 'Nanumanga',
      ),
      2 => 
      array (
        'code' => 'NLK',
        'name' => 'Niulakita',
      ),
      3 => 
      array (
        'code' => 'NTO',
        'name' => 'Niutao',
      ),
      4 => 
      array (
        'code' => 'FUN',
        'name' => '푸나 푸티',
      ),
      5 => 
      array (
        'code' => 'NME',
        'name' => '누메아',
      ),
      6 => 
      array (
        'code' => 'NUI',
        'name' => '누이',
      ),
      7 => 
      array (
        'code' => 'NFT',
        'name' => 'Nukufetau까지',
      ),
      8 => 
      array (
        'code' => 'NLL',
        'name' => 'Nukulaelae',
      ),
      9 => 
      array (
        'code' => 'VAI',
        'name' => 'Vaitupu',
      ),
    ),
    'TW' => 
    array (
      1 => 
      array (
        'code' => 'CH',
        'name' => '장 - 후아힌',
      ),
      2 => 
      array (
        'code' => 'CI',
        'name' => '치아-I',
      ),
      3 => 
      array (
        'code' => 'HS',
        'name' => '신주',
      ),
      4 => 
      array (
        'code' => 'HL',
        'name' => '후아 - 담보권',
      ),
      5 => 
      array (
        'code' => 'IL',
        'name' => 'I-LAN',
      ),
      6 => 
      array (
        'code' => 'KH',
        'name' => '카오-hsiung 카운티',
      ),
      7 => 
      array (
        'code' => 'KM',
        'name' => '킨 - 남자',
      ),
      8 => 
      array (
        'code' => 'LC',
        'name' => '국민당 - 치앙마이',
      ),
      9 => 
      array (
        'code' => 'ML',
        'name' => '미아오 - 리',
      ),
      10 => 
      array (
        'code' => 'NT',
        'name' => '난-t ou',
      ),
      11 => 
      array (
        'code' => 'PH',
        'name' => 'P eng-HU',
      ),
      12 => 
      array (
        'code' => 'PT',
        'name' => 'P ing - 퉁',
      ),
      13 => 
      array (
        'code' => 'TG',
        'name' => 'T ai - 정',
      ),
      14 => 
      array (
        'code' => 'TA',
        'name' => 'T ai-할머니',
      ),
      15 => 
      array (
        'code' => 'TP',
        'name' => 'T ai-페이 주',
      ),
      16 => 
      array (
        'code' => 'TT',
        'name' => 'T ai-오동 나무',
      ),
      17 => 
      array (
        'code' => 'TY',
        'name' => 'T ao - 위안',
      ),
      18 => 
      array (
        'code' => 'YL',
        'name' => '윤 - 린',
      ),
      19 => 
      array (
        'code' => 'CC',
        'name' => '치아 - 나는 도시',
      ),
      20 => 
      array (
        'code' => 'CL',
        'name' => '카이 폐',
      ),
      21 => 
      array (
        'code' => 'HC',
        'name' => '신주',
      ),
      22 => 
      array (
        'code' => 'TH',
        'name' => 'T ai - 정',
      ),
      23 => 
      array (
        'code' => 'TN',
        'name' => 'T ai-할머니',
      ),
      24 => 
      array (
        'code' => 'KC',
        'name' => '카오-hsiung시',
      ),
      25 => 
      array (
        'code' => 'TC',
        'name' => 'T ai - 페이시',
      ),
    ),
    'TZ' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => '아루샤',
      ),
      2 => 
      array (
        'code' => 'DS',
        'name' => '다르는 살람 말이지',
      ),
      3 => 
      array (
        'code' => 'DO',
        'name' => '도도 마',
      ),
      4 => 
      array (
        'code' => 'IR',
        'name' => '링가',
      ),
      5 => 
      array (
        'code' => 'KA',
        'name' => 'Kagera',
      ),
      6 => 
      array (
        'code' => 'KI',
        'name' => '키 고마',
      ),
      7 => 
      array (
        'code' => 'KJ',
        'name' => '킬리만자로',
      ),
      8 => 
      array (
        'code' => 'LN',
        'name' => 'Lindi',
      ),
      9 => 
      array (
        'code' => 'MY',
        'name' => '야라',
      ),
      10 => 
      array (
        'code' => 'MR',
        'name' => '마라',
      ),
      11 => 
      array (
        'code' => 'MB',
        'name' => '음 베야',
      ),
      12 => 
      array (
        'code' => 'MO',
        'name' => '모 로고로',
      ),
      13 => 
      array (
        'code' => 'MT',
        'name' => '므 타라',
      ),
      14 => 
      array (
        'code' => 'MW',
        'name' => '므 완자',
      ),
      15 => 
      array (
        'code' => 'PN',
        'name' => '펨바 노스',
      ),
      16 => 
      array (
        'code' => 'PS',
        'name' => '펨바 남부',
      ),
      17 => 
      array (
        'code' => 'PW',
        'name' => '프 와니',
      ),
      18 => 
      array (
        'code' => 'RK',
        'name' => 'Rukwa',
      ),
      19 => 
      array (
        'code' => 'RV',
        'name' => 'Ruvuma',
      ),
      20 => 
      array (
        'code' => 'SH',
        'name' => '신양',
      ),
      21 => 
      array (
        'code' => 'SI',
        'name' => '싱 기다',
      ),
      22 => 
      array (
        'code' => 'TB',
        'name' => '타 보라',
      ),
      23 => 
      array (
        'code' => 'TN',
        'name' => '탄가',
      ),
      24 => 
      array (
        'code' => 'ZC',
        'name' => '잔지바르 중부 / 남부',
      ),
      25 => 
      array (
        'code' => 'ZN',
        'name' => '잔지바르 노스',
      ),
      26 => 
      array (
        'code' => 'ZU',
        'name' => '잔지바르 도시 / 웨스트',
      ),
    ),
    'UA' => 
    array (
      1 => 
      array (
        'code' => 'CK',
        'name' => '체르',
      ),
      2 => 
      array (
        'code' => 'CH',
        'name' => '체르니',
      ),
      3 => 
      array (
        'code' => 'CV',
        'name' => '체르니',
      ),
      4 => 
      array (
        'code' => 'CR',
        'name' => '크림',
      ),
      5 => 
      array (
        'code' => 'DN',
        'name' => 'Dnipropetrovs k',
      ),
      6 => 
      array (
        'code' => 'DO',
        'name' => '도네츠크',
      ),
      7 => 
      array (
        'code' => 'IV',
        'name' => '이바노프 Frankivs k',
      ),
      8 => 
      array (
        'code' => 'KL',
        'name' => '카르 키프 헤르',
      ),
      9 => 
      array (
        'code' => 'KM',
        'name' => 'Khmel nyts kyy',
      ),
      10 => 
      array (
        'code' => 'KR',
        'name' => '키로 보라',
      ),
      11 => 
      array (
        'code' => 'KV',
        'name' => '키예프',
      ),
      12 => 
      array (
        'code' => 'KY',
        'name' => 'Kyyiv',
      ),
      13 => 
      array (
        'code' => 'LU',
        'name' => '루간 스크',
      ),
      14 => 
      array (
        'code' => 'LV',
        'name' => 'L 의 비비안',
      ),
      15 => 
      array (
        'code' => 'MY',
        'name' => 'Mykolayiv에',
      ),
      16 => 
      array (
        'code' => 'OD',
        'name' => '렛츠',
      ),
      17 => 
      array (
        'code' => 'PO',
        'name' => '폴 타바',
      ),
      18 => 
      array (
        'code' => 'RI',
        'name' => '리브 네',
      ),
      19 => 
      array (
        'code' => 'SE',
        'name' => '세 바스 토폴',
      ),
      20 => 
      array (
        'code' => 'SU',
        'name' => '수미',
      ),
      21 => 
      array (
        'code' => 'TE',
        'name' => '테르 노필',
      ),
      22 => 
      array (
        'code' => 'VI',
        'name' => 'Vinnytsya',
      ),
      23 => 
      array (
        'code' => 'VO',
        'name' => 'Volyn에',
      ),
      24 => 
      array (
        'code' => 'ZK',
        'name' => 'Zakarpattya',
      ),
      25 => 
      array (
        'code' => 'ZA',
        'name' => 'Zaporizhzhya에',
      ),
      26 => 
      array (
        'code' => 'ZH',
        'name' => '지토 미르',
      ),
    ),
    'UG' => 
    array (
      1 => 
      array (
        'code' => 'KAL',
        'name' => 'Kalangala',
      ),
      2 => 
      array (
        'code' => 'KMP',
        'name' => '캄팔라',
      ),
      3 => 
      array (
        'code' => 'KAY',
        'name' => 'Kayunga',
      ),
      4 => 
      array (
        'code' => 'KIB',
        'name' => 'Kiboga',
      ),
      5 => 
      array (
        'code' => 'LUW',
        'name' => 'Luwero',
      ),
      6 => 
      array (
        'code' => 'MAS',
        'name' => '마사',
      ),
      7 => 
      array (
        'code' => 'MPI',
        'name' => 'Mpigi',
      ),
      8 => 
      array (
        'code' => 'MUB',
        'name' => 'Mubende',
      ),
      9 => 
      array (
        'code' => 'MUK',
        'name' => '무 코노',
      ),
      10 => 
      array (
        'code' => 'NKS',
        'name' => 'Nakasongola',
      ),
      11 => 
      array (
        'code' => 'RAK',
        'name' => '라카이',
      ),
      12 => 
      array (
        'code' => 'SEM',
        'name' => 'Sembabule',
      ),
      13 => 
      array (
        'code' => 'WAK',
        'name' => '와키 소',
      ),
      14 => 
      array (
        'code' => 'BUG',
        'name' => '부기리',
      ),
      15 => 
      array (
        'code' => 'BUS',
        'name' => 'Busia',
      ),
      16 => 
      array (
        'code' => 'IGA',
        'name' => 'Iganga',
      ),
      17 => 
      array (
        'code' => 'JIN',
        'name' => '신사',
      ),
      18 => 
      array (
        'code' => 'KAB',
        'name' => 'Kaberamaido',
      ),
      19 => 
      array (
        'code' => 'KML',
        'name' => 'Kamuli',
      ),
      20 => 
      array (
        'code' => 'KPC',
        'name' => 'Kapchorwa',
      ),
      21 => 
      array (
        'code' => 'KTK',
        'name' => 'Katakwi',
      ),
      22 => 
      array (
        'code' => 'KUM',
        'name' => '구미',
      ),
      23 => 
      array (
        'code' => 'MAY',
        'name' => 'Mayuge',
      ),
      24 => 
      array (
        'code' => 'MBA',
        'name' => 'Mbale',
      ),
      25 => 
      array (
        'code' => 'PAL',
        'name' => 'Pallisa',
      ),
      26 => 
      array (
        'code' => 'SIR',
        'name' => 'Sironko',
      ),
      27 => 
      array (
        'code' => 'SOR',
        'name' => '소로 티',
      ),
      28 => 
      array (
        'code' => 'TOR',
        'name' => '토로로',
      ),
      29 => 
      array (
        'code' => 'ADJ',
        'name' => 'Adjumani',
      ),
      30 => 
      array (
        'code' => 'APC',
        'name' => 'APAC',
      ),
      31 => 
      array (
        'code' => 'ARU',
        'name' => '아루 아',
      ),
      32 => 
      array (
        'code' => 'GUL',
        'name' => 'Gulu의',
      ),
      33 => 
      array (
        'code' => 'KIT',
        'name' => 'Kitgum',
      ),
      34 => 
      array (
        'code' => 'KOT',
        'name' => 'Kotido',
      ),
      35 => 
      array (
        'code' => 'LIR',
        'name' => '리라',
      ),
      36 => 
      array (
        'code' => 'MRT',
        'name' => '모로 토',
      ),
      37 => 
      array (
        'code' => 'MOY',
        'name' => '모요',
      ),
      38 => 
      array (
        'code' => 'NAK',
        'name' => 'Nakapiripirit',
      ),
      39 => 
      array (
        'code' => 'NEB',
        'name' => 'Nebbi',
      ),
      40 => 
      array (
        'code' => 'PAD',
        'name' => 'Pader',
      ),
      41 => 
      array (
        'code' => 'YUM',
        'name' => 'Yumbe',
      ),
      42 => 
      array (
        'code' => 'BUN',
        'name' => 'Bundibugyo',
      ),
      43 => 
      array (
        'code' => 'BSH',
        'name' => 'Bushenyi',
      ),
      44 => 
      array (
        'code' => 'HOI',
        'name' => 'Hoima에',
      ),
      45 => 
      array (
        'code' => 'KBL',
        'name' => 'Kabale에서',
      ),
      46 => 
      array (
        'code' => 'KAR',
        'name' => 'Kabarole',
      ),
      47 => 
      array (
        'code' => 'KAM',
        'name' => 'Kamwenge',
      ),
      48 => 
      array (
        'code' => 'KAN',
        'name' => 'Kanungu',
      ),
      49 => 
      array (
        'code' => 'KAS',
        'name' => '카세',
      ),
      50 => 
      array (
        'code' => 'KBA',
        'name' => 'Kibaale',
      ),
      51 => 
      array (
        'code' => 'KIS',
        'name' => 'Kisoro에',
      ),
      52 => 
      array (
        'code' => 'KYE',
        'name' => 'Kyenjojo',
      ),
      53 => 
      array (
        'code' => 'MSN',
        'name' => '마신 디',
      ),
      54 => 
      array (
        'code' => 'MBR',
        'name' => '음 바라 라',
      ),
      55 => 
      array (
        'code' => 'NTU',
        'name' => 'Ntungamo',
      ),
      56 => 
      array (
        'code' => 'RUK',
        'name' => 'Rukungiri',
      ),
    ),
    'UM' => 
    array (
      1 => 
      array (
        'code' => 'BI',
        'name' => '베이커 섬',
      ),
      2 => 
      array (
        'code' => 'HI',
        'name' => '하울 랜드 섬',
      ),
      3 => 
      array (
        'code' => 'JI',
        'name' => '자비스 섬',
      ),
      4 => 
      array (
        'code' => 'JA',
        'name' => '존스턴 섬',
      ),
      5 => 
      array (
        'code' => 'KR',
        'name' => '킹맨 섬',
      ),
      6 => 
      array (
        'code' => 'MA',
        'name' => '미드웨이 환초',
      ),
      7 => 
      array (
        'code' => 'NI',
        'name' => '바사 섬',
      ),
      8 => 
      array (
        'code' => 'PA',
        'name' => '팔미라 섬',
      ),
      9 => 
      array (
        'code' => 'WI',
        'name' => '웨이크 섬',
      ),
    ),
    'US' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => '앨라배마',
      ),
      2 => 
      array (
        'code' => 'AK',
        'name' => '알래스카',
      ),
      3 => 
      array (
        'code' => 'AS',
        'name' => '아메리칸 사모아',
      ),
      4 => 
      array (
        'code' => 'AZ',
        'name' => '애리조나',
      ),
      5 => 
      array (
        'code' => 'AR',
        'name' => '아칸소',
      ),
      6 => 
      array (
        'code' => 'AF',
        'name' => '국군 아프리카',
      ),
      7 => 
      array (
        'code' => 'AA',
        'name' => '국군 아메리카',
      ),
      8 => 
      array (
        'code' => 'AC',
        'name' => '국군 캐나다',
      ),
      9 => 
      array (
        'code' => 'AE',
        'name' => '국군 유럽',
      ),
      10 => 
      array (
        'code' => 'AM',
        'name' => '국군 중동',
      ),
      11 => 
      array (
        'code' => 'AP',
        'name' => '국군 태평양',
      ),
      12 => 
      array (
        'code' => 'CA',
        'name' => '캘리포니아',
      ),
      13 => 
      array (
        'code' => 'CO',
        'name' => '콜로라도',
      ),
      14 => 
      array (
        'code' => 'CT',
        'name' => '코네티컷',
      ),
      15 => 
      array (
        'code' => 'DE',
        'name' => '델라웨어',
      ),
      16 => 
      array (
        'code' => 'DC',
        'name' => '컬럼비아 특별구',
      ),
      17 => 
      array (
        'code' => 'FM',
        'name' => '미크로네시아 연방',
      ),
      18 => 
      array (
        'code' => 'FL',
        'name' => '플로리다',
      ),
      19 => 
      array (
        'code' => 'GA',
        'name' => '조지아',
      ),
      20 => 
      array (
        'code' => 'GU',
        'name' => '괌',
      ),
      21 => 
      array (
        'code' => 'HI',
        'name' => '하와이',
      ),
      22 => 
      array (
        'code' => 'ID',
        'name' => '아이다 호',
      ),
      23 => 
      array (
        'code' => 'IL',
        'name' => '일리노이',
      ),
      24 => 
      array (
        'code' => 'IN',
        'name' => '인디애나',
      ),
      25 => 
      array (
        'code' => 'IA',
        'name' => '아이오와',
      ),
      26 => 
      array (
        'code' => 'KS',
        'name' => '캔자스',
      ),
      27 => 
      array (
        'code' => 'KY',
        'name' => '켄터키',
      ),
      28 => 
      array (
        'code' => 'LA',
        'name' => '루이지애나',
      ),
      29 => 
      array (
        'code' => 'ME',
        'name' => '메인',
      ),
      30 => 
      array (
        'code' => 'MH',
        'name' => '마샬 군도',
      ),
      31 => 
      array (
        'code' => 'MD',
        'name' => '메릴랜드',
      ),
      32 => 
      array (
        'code' => 'MA',
        'name' => '매사 추세 츠',
      ),
      33 => 
      array (
        'code' => 'MI',
        'name' => '미시간',
      ),
      34 => 
      array (
        'code' => 'MN',
        'name' => '미네소타',
      ),
      35 => 
      array (
        'code' => 'MS',
        'name' => '미시시피',
      ),
      36 => 
      array (
        'code' => 'MO',
        'name' => '미주리',
      ),
      37 => 
      array (
        'code' => 'MT',
        'name' => '몬태나',
      ),
      38 => 
      array (
        'code' => 'NE',
        'name' => '네브라스카',
      ),
      39 => 
      array (
        'code' => 'NV',
        'name' => '네바다',
      ),
      40 => 
      array (
        'code' => 'NH',
        'name' => '뉴 햄프셔',
      ),
      41 => 
      array (
        'code' => 'NJ',
        'name' => '뉴저지',
      ),
      42 => 
      array (
        'code' => 'NM',
        'name' => '뉴 멕시코',
      ),
      43 => 
      array (
        'code' => 'NY',
        'name' => '뉴욕',
      ),
      44 => 
      array (
        'code' => 'NC',
        'name' => '노스 캐롤라이나',
      ),
      45 => 
      array (
        'code' => 'ND',
        'name' => '노스 다코타',
      ),
      46 => 
      array (
        'code' => 'MP',
        'name' => '북 마리아나 제도',
      ),
      47 => 
      array (
        'code' => 'OH',
        'name' => '오하이오',
      ),
      48 => 
      array (
        'code' => 'OK',
        'name' => '오클라호마',
      ),
      49 => 
      array (
        'code' => 'OR',
        'name' => '오레곤',
      ),
      50 => 
      array (
        'code' => 'PW',
        'name' => '팔라우',
      ),
      51 => 
      array (
        'code' => 'PA',
        'name' => '펜실베니아',
      ),
      52 => 
      array (
        'code' => 'PR',
        'name' => '푸에르토 리코',
      ),
      53 => 
      array (
        'code' => 'RI',
        'name' => '로드 아일랜드',
      ),
      54 => 
      array (
        'code' => 'SC',
        'name' => '사우스 캐롤라이나',
      ),
      55 => 
      array (
        'code' => 'SD',
        'name' => '사우스 다코타',
      ),
      56 => 
      array (
        'code' => 'TN',
        'name' => '테네시',
      ),
      57 => 
      array (
        'code' => 'TX',
        'name' => '텍사스',
      ),
      58 => 
      array (
        'code' => 'UT',
        'name' => '유타',
      ),
      59 => 
      array (
        'code' => 'VT',
        'name' => '버몬트',
      ),
      60 => 
      array (
        'code' => 'VI',
        'name' => '버진 아일랜드',
      ),
      61 => 
      array (
        'code' => 'VA',
        'name' => '버지니아',
      ),
      62 => 
      array (
        'code' => 'WA',
        'name' => '워싱턴',
      ),
      63 => 
      array (
        'code' => 'WV',
        'name' => '웨스트 버지니아',
      ),
      64 => 
      array (
        'code' => 'WI',
        'name' => '위스콘신',
      ),
      65 => 
      array (
        'code' => 'WY',
        'name' => '와이오밍',
      ),
    ),
    'UY' => 
    array (
      1 => 
      array (
        'code' => 'AR',
        'name' => '아르 티 가스',
      ),
      2 => 
      array (
        'code' => 'CA',
        'name' => '넬로 ​​네스',
      ),
      3 => 
      array (
        'code' => 'CL',
        'name' => '세로 라르고',
      ),
      4 => 
      array (
        'code' => 'CO',
        'name' => '콜로니',
      ),
      5 => 
      array (
        'code' => 'DU',
        'name' => 'Durazno',
      ),
      6 => 
      array (
        'code' => 'FS',
        'name' => '플로레스',
      ),
      7 => 
      array (
        'code' => 'FA',
        'name' => '플로리다',
      ),
      8 => 
      array (
        'code' => 'LA',
        'name' => 'Lavalleja',
      ),
      9 => 
      array (
        'code' => 'MA',
        'name' => '말도 나도',
      ),
      10 => 
      array (
        'code' => 'MO',
        'name' => '몬테비데오',
      ),
      11 => 
      array (
        'code' => 'PA',
        'name' => '파이 산두',
      ),
      12 => 
      array (
        'code' => 'RN',
        'name' => '리오 네그로',
      ),
      13 => 
      array (
        'code' => 'RV',
        'name' => '리베라',
      ),
      14 => 
      array (
        'code' => 'RO',
        'name' => '호샤',
      ),
      15 => 
      array (
        'code' => 'SL',
        'name' => '살토',
      ),
      16 => 
      array (
        'code' => 'SJ',
        'name' => '산호세',
      ),
      17 => 
      array (
        'code' => 'SO',
        'name' => '소리아노',
      ),
      18 => 
      array (
        'code' => 'TA',
        'name' => '타쿠 아 렘보',
      ),
      19 => 
      array (
        'code' => 'TT',
        'name' => 'Treinta Y 트레스',
      ),
    ),
    'UZ' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Andijon',
      ),
      2 => 
      array (
        'code' => 'BU',
        'name' => 'Buxoro',
      ),
      3 => 
      array (
        'code' => 'FA',
        'name' => 'Farg ona',
      ),
      4 => 
      array (
        'code' => 'JI',
        'name' => 'Jizzax',
      ),
      5 => 
      array (
        'code' => 'NG',
        'name' => '망간',
      ),
      6 => 
      array (
        'code' => 'NW',
        'name' => '보이',
      ),
      7 => 
      array (
        'code' => 'QA',
        'name' => 'Qashqadaryo',
      ),
      8 => 
      array (
        'code' => 'QR',
        'name' => 'Qoraqalpog iston Republikasi',
      ),
      9 => 
      array (
        'code' => 'SA',
        'name' => '사마르 칸트',
      ),
      10 => 
      array (
        'code' => 'SI',
        'name' => 'Sirdaryo',
      ),
      11 => 
      array (
        'code' => 'SU',
        'name' => '수르 한다리 야',
      ),
      12 => 
      array (
        'code' => 'TK',
        'name' => '타슈켄트시',
      ),
      13 => 
      array (
        'code' => 'TO',
        'name' => '타슈켄트 지역',
      ),
      14 => 
      array (
        'code' => 'XO',
        'name' => 'Xorazm',
      ),
    ),
    'VC' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => '샬롯',
      ),
      2 => 
      array (
        'code' => 'R',
        'name' => '그레나딘',
      ),
      3 => 
      array (
        'code' => 'A',
        'name' => '세인트 앤드류',
      ),
      4 => 
      array (
        'code' => 'D',
        'name' => '세인트 데이비드',
      ),
      5 => 
      array (
        'code' => 'G',
        'name' => '세인트 조지',
      ),
      6 => 
      array (
        'code' => 'P',
        'name' => '세인트 패트릭',
      ),
    ),
    'VE' => 
    array (
      1 => 
      array (
        'code' => 'AM',
        'name' => '아마 조나스',
      ),
      2 => 
      array (
        'code' => 'AN',
        'name' => '안소 아테 기',
      ),
      3 => 
      array (
        'code' => 'AP',
        'name' => '아푸 레',
      ),
      4 => 
      array (
        'code' => 'AR',
        'name' => '아라 구아',
      ),
      5 => 
      array (
        'code' => 'BA',
        'name' => '바 레나스',
      ),
      6 => 
      array (
        'code' => 'BO',
        'name' => '볼리바르',
      ),
      7 => 
      array (
        'code' => 'CA',
        'name' => '카라 보보',
      ),
      8 => 
      array (
        'code' => 'CO',
        'name' => 'Cojedes',
      ),
      9 => 
      array (
        'code' => 'DA',
        'name' => '델타 Amacuro',
      ),
      10 => 
      array (
        'code' => 'DF',
        'name' => 'Dependencias 정부군',
      ),
      11 => 
      array (
        'code' => 'DI',
        'name' => '디스트 리토 페데 랄',
      ),
      12 => 
      array (
        'code' => 'FA',
        'name' => '팔콘',
      ),
      13 => 
      array (
        'code' => 'GU',
        'name' => 'Guarico',
      ),
      14 => 
      array (
        'code' => 'LA',
        'name' => '라라',
      ),
      15 => 
      array (
        'code' => 'ME',
        'name' => '메리다',
      ),
      16 => 
      array (
        'code' => 'MI',
        'name' => '미란다',
      ),
      17 => 
      array (
        'code' => 'MO',
        'name' => '모나 가스',
      ),
      18 => 
      array (
        'code' => 'NE',
        'name' => '누에바에 스파르타',
      ),
      19 => 
      array (
        'code' => 'PO',
        'name' => '포르투 게사',
      ),
      20 => 
      array (
        'code' => 'SU',
        'name' => '수크레',
      ),
      21 => 
      array (
        'code' => 'TA',
        'name' => 'Tachira',
      ),
      22 => 
      array (
        'code' => 'TR',
        'name' => '트루 히요',
      ),
      23 => 
      array (
        'code' => 'VA',
        'name' => '바 가스',
      ),
      24 => 
      array (
        'code' => 'YA',
        'name' => '라쿠이',
      ),
      25 => 
      array (
        'code' => 'ZU',
        'name' => '줄리아',
      ),
    ),
    'VI' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => '세인트 크루 아',
      ),
      2 => 
      array (
        'code' => 'J',
        'name' => '세인트 존',
      ),
      3 => 
      array (
        'code' => 'T',
        'name' => '세인트 토마스',
      ),
    ),
    'VN' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => '안장',
      ),
      2 => 
      array (
        'code' => 'BG',
        'name' => '혈중 알코올 농도가 안장',
      ),
      3 => 
      array (
        'code' => 'BK',
        'name' => '혈중 알코올 농도가 칸',
      ),
      4 => 
      array (
        'code' => 'BL',
        'name' => '혈중 알코올 농도가 반장님',
      ),
      5 => 
      array (
        'code' => 'BC',
        'name' => '박닌',
      ),
      6 => 
      array (
        'code' => 'BR',
        'name' => '바리 아 붕타우',
      ),
      7 => 
      array (
        'code' => 'BN',
        'name' => '벤 트레',
      ),
      8 => 
      array (
        'code' => 'BH',
        'name' => '빈 딘',
      ),
      9 => 
      array (
        'code' => 'BU',
        'name' => '빈 Duong',
      ),
      10 => 
      array (
        'code' => 'BP',
        'name' => '빈 푸옥',
      ),
      11 => 
      array (
        'code' => 'BT',
        'name' => '빈 투안 (Binh Thuan',
      ),
      12 => 
      array (
        'code' => 'CM',
        'name' => '카마 우',
      ),
      13 => 
      array (
        'code' => 'CT',
        'name' => '칸토',
      ),
      14 => 
      array (
        'code' => 'CB',
        'name' => '까오 방',
      ),
      15 => 
      array (
        'code' => 'DL',
        'name' => 'DAK LAK',
      ),
      16 => 
      array (
        'code' => 'DG',
        'name' => 'DAK 농',
      ),
      17 => 
      array (
        'code' => 'DN',
        'name' => '다낭',
      ),
      18 => 
      array (
        'code' => 'DB',
        'name' => '디엔 비엔',
      ),
      19 => 
      array (
        'code' => 'DI',
        'name' => '동 나이 (Dong Nai',
      ),
      20 => 
      array (
        'code' => 'DT',
        'name' => '동탑',
      ),
      21 => 
      array (
        'code' => 'GL',
        'name' => '지아 라이',
      ),
      22 => 
      array (
        'code' => 'HG',
        'name' => '하 흐엉',
      ),
      23 => 
      array (
        'code' => 'HD',
        'name' => '하이 두옹',
      ),
      24 => 
      array (
        'code' => 'HP',
        'name' => '하이퐁',
      ),
      25 => 
      array (
        'code' => 'HM',
        'name' => '하 남',
      ),
      26 => 
      array (
        'code' => 'HI',
        'name' => '하노이',
      ),
      27 => 
      array (
        'code' => 'HT',
        'name' => '하 테이',
      ),
      28 => 
      array (
        'code' => 'HH',
        'name' => '하띤',
      ),
      29 => 
      array (
        'code' => 'HB',
        'name' => '호아 빈',
      ),
      30 => 
      array (
        'code' => 'HC',
        'name' => '호 친 호치민',
      ),
      31 => 
      array (
        'code' => 'HU',
        'name' => '하우 지앙',
      ),
      32 => 
      array (
        'code' => 'HY',
        'name' => '웅 엔',
      ),
    ),
    'VU' => 
    array (
      1 => 
      array (
        'code' => 'MA',
        'name' => 'Malampa',
      ),
      2 => 
      array (
        'code' => 'PE',
        'name' => 'Penama',
      ),
      3 => 
      array (
        'code' => 'SA',
        'name' => '꽁치',
      ),
      4 => 
      array (
        'code' => 'SH',
        'name' => '믿었다',
      ),
      5 => 
      array (
        'code' => 'TA',
        'name' => 'Tafea',
      ),
      6 => 
      array (
        'code' => 'TO',
        'name' => '토르 바',
      ),
    ),
    'WF' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => '무조건',
      ),
      2 => 
      array (
        'code' => 'S',
        'name' => 'Sigave',
      ),
      3 => 
      array (
        'code' => 'W',
        'name' => '월리스',
      ),
    ),
    'WS' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'A ana',
      ),
      2 => 
      array (
        'code' => 'AI',
        'name' => 'AIGA-I 르 타이',
      ),
      3 => 
      array (
        'code' => 'AT',
        'name' => 'Atua',
      ),
      4 => 
      array (
        'code' => 'FA',
        'name' => 'Fa asaleleaga',
      ),
      5 => 
      array (
        'code' => 'GE',
        'name' => 'Gaga emauga',
      ),
      6 => 
      array (
        'code' => 'GF',
        'name' => 'Gagaifomauga',
      ),
      7 => 
      array (
        'code' => 'PA',
        'name' => 'Palauli',
      ),
      8 => 
      array (
        'code' => 'SA',
        'name' => 'Satupa itea',
      ),
      9 => 
      array (
        'code' => 'TU',
        'name' => 'Tuamasaga',
      ),
      10 => 
      array (
        'code' => 'VF',
        'name' => 'Va a-O-Fonoti',
      ),
      11 => 
      array (
        'code' => 'VS',
        'name' => 'Vaisigano',
      ),
    ),
    'YE' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => 'Abyan',
      ),
      2 => 
      array (
        'code' => 'AD',
        'name' => '아단',
      ),
      3 => 
      array (
        'code' => 'AM',
        'name' => 'Amran',
      ),
      4 => 
      array (
        'code' => 'BA',
        'name' => '알 바이다',
      ),
      5 => 
      array (
        'code' => 'DA',
        'name' => '광고 대리',
      ),
      6 => 
      array (
        'code' => 'DH',
        'name' => 'Dhamar',
      ),
      7 => 
      array (
        'code' => 'HD',
        'name' => 'Hadramawt',
      ),
      8 => 
      array (
        'code' => 'HJ',
        'name' => 'Hajjah',
      ),
      9 => 
      array (
        'code' => 'HU',
        'name' => '알 Hudaydah',
      ),
      10 => 
      array (
        'code' => 'IB',
        'name' => 'IBB',
      ),
      11 => 
      array (
        'code' => 'JA',
        'name' => '알 자 우프',
      ),
      12 => 
      array (
        'code' => 'LA',
        'name' => 'Lahij',
      ),
      13 => 
      array (
        'code' => 'MA',
        'name' => '마리 브',
      ),
      14 => 
      array (
        'code' => 'MR',
        'name' => '알 Mahrah',
      ),
      15 => 
      array (
        'code' => 'MW',
        'name' => '알 Mahwit',
      ),
      16 => 
      array (
        'code' => 'SD',
        'name' => 'Sa dah',
      ),
      17 => 
      array (
        'code' => 'SN',
        'name' => '사나',
      ),
      18 => 
      array (
        'code' => 'SH',
        'name' => 'Shabwah',
      ),
      19 => 
      array (
        'code' => 'TA',
        'name' => '타이즈',
      ),
    ),
    'YT' => 
    array (
      1 => 
      array (
        'code' => 'DZA',
        'name' => 'Dzaoudzi으로',
      ),
      2 => 
      array (
        'code' => 'PAM',
        'name' => 'Pamandzi',
      ),
      3 => 
      array (
        'code' => 'MAM',
        'name' => '무주',
      ),
      4 => 
      array (
        'code' => 'DEM',
        'name' => 'Dembeni',
      ),
      5 => 
      array (
        'code' => 'BAN',
        'name' => 'Bandrele',
      ),
      6 => 
      array (
        'code' => 'KAN',
        'name' => '카니 KELI',
      ),
      7 => 
      array (
        'code' => 'BOU',
        'name' => 'Bouéni',
      ),
      8 => 
      array (
        'code' => 'CHI',
        'name' => 'Chirongui',
      ),
      9 => 
      array (
        'code' => 'SAD',
        'name' => '사다',
      ),
      10 => 
      array (
        'code' => 'OUA',
        'name' => 'Ouangani',
      ),
      11 => 
      array (
        'code' => 'CHI',
        'name' => 'Chiconi',
      ),
      12 => 
      array (
        'code' => 'TSI',
        'name' => 'Tsingoni',
      ),
      13 => 
      array (
        'code' => 'MTS',
        'name' => 'M Tsangamouji',
      ),
      14 => 
      array (
        'code' => 'ACO',
        'name' => 'Acoua',
      ),
      15 => 
      array (
        'code' => 'MTS',
        'name' => 'Mtsamboro',
      ),
      16 => 
      array (
        'code' => 'BAN',
        'name' => 'Bandraboua',
      ),
      17 => 
      array (
        'code' => 'KOU',
        'name' => 'Koungou',
      ),
    ),
    'YU' => 
    array (
      1 => 
      array (
        'code' => 'KOS',
        'name' => '코소보',
      ),
      2 => 
      array (
        'code' => 'MON',
        'name' => '몬테네그로',
      ),
      3 => 
      array (
        'code' => 'SER',
        'name' => '세르비아',
      ),
      4 => 
      array (
        'code' => 'VOJ',
        'name' => '보이 보디 나',
      ),
    ),
    'ZA' => 
    array (
      1 => 
      array (
        'code' => 'EC',
        'name' => '이스턴 케이프',
      ),
      2 => 
      array (
        'code' => 'FS',
        'name' => '프리 스테이트',
      ),
      3 => 
      array (
        'code' => 'GT',
        'name' => '하우텡 주',
      ),
      4 => 
      array (
        'code' => 'KN',
        'name' => '크와 줄루 나탈 (주',
      ),
      5 => 
      array (
        'code' => 'LP',
        'name' => '림 포포',
      ),
      6 => 
      array (
        'code' => 'MP',
        'name' => '음푸 말랑가 - 노던 프로 빈스',
      ),
      7 => 
      array (
        'code' => 'NW',
        'name' => '노스 웨스트',
      ),
      8 => 
      array (
        'code' => 'NC',
        'name' => '노던 케이프 주',
      ),
      9 => 
      array (
        'code' => 'WC',
        'name' => '웨스턴 케이프',
      ),
    ),
    'ZM' => 
    array (
      1 => 
      array (
        'code' => 'CE',
        'name' => '중앙',
      ),
      2 => 
      array (
        'code' => 'CB',
        'name' => '코퍼',
      ),
      3 => 
      array (
        'code' => 'EA',
        'name' => '동부',
      ),
      4 => 
      array (
        'code' => 'LP',
        'name' => '루아 풀라',
      ),
      5 => 
      array (
        'code' => 'LK',
        'name' => '루사카',
      ),
      6 => 
      array (
        'code' => 'NO',
        'name' => '북',
      ),
      7 => 
      array (
        'code' => 'NW',
        'name' => '노스 웨스턴',
      ),
      8 => 
      array (
        'code' => 'SO',
        'name' => '남부',
      ),
      9 => 
      array (
        'code' => 'WE',
        'name' => '서양',
      ),
    ),
    'ZR' => 
    array (
      1 => 
      array (
        'code' => 'BC',
        'name' => '바스 콩고',
      ),
      2 => 
      array (
        'code' => 'BN',
        'name' => '둔두',
      ),
      3 => 
      array (
        'code' => 'EQ',
        'name' => 'EQUATEUR',
      ),
      4 => 
      array (
        'code' => 'KA',
        'name' => '카 탕가',
      ),
      5 => 
      array (
        'code' => 'KE',
        'name' => '카사이 동양',
      ),
      6 => 
      array (
        'code' => 'KN',
        'name' => '킨 샤사',
      ),
      7 => 
      array (
        'code' => 'KW',
        'name' => '카사이 옥시 덴탈',
      ),
      8 => 
      array (
        'code' => 'MA',
        'name' => '마니에 마',
      ),
      9 => 
      array (
        'code' => 'NK',
        'name' => '노르 키부',
      ),
      10 => 
      array (
        'code' => 'OR',
        'name' => '오리엔탈',
      ),
      11 => 
      array (
        'code' => 'SK',
        'name' => '수드 - 키부',
      ),
    ),
    'ZW' => 
    array (
      1 => 
      array (
        'code' => 'BU',
        'name' => '불라 와요',
      ),
      2 => 
      array (
        'code' => 'HA',
        'name' => '하라레',
      ),
      3 => 
      array (
        'code' => 'ML',
        'name' => 'Manicaland',
      ),
      4 => 
      array (
        'code' => 'MC',
        'name' => 'Mashonaland 중앙',
      ),
      5 => 
      array (
        'code' => 'ME',
        'name' => 'Mashonaland 동부',
      ),
      6 => 
      array (
        'code' => 'MW',
        'name' => 'Mashonaland 서부',
      ),
      7 => 
      array (
        'code' => 'MV',
        'name' => '마스 빙고',
      ),
      8 => 
      array (
        'code' => 'MN',
        'name' => '마타 벨렐 란드 노스',
      ),
      9 => 
      array (
        'code' => 'MS',
        'name' => '마타 벨렐 란드 남부',
      ),
      10 => 
      array (
        'code' => 'MD',
        'name' => '미들랜드',
      ),
    ),
    86 => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => '세인트 앤드류',
      ),
      2 => 
      array (
        'code' => 'D',
        'name' => '세인트 데이비드',
      ),
      3 => 
      array (
        'code' => 'G',
        'name' => '세인트 조지',
      ),
      4 => 
      array (
        'code' => 'J',
        'name' => '세인트 존',
      ),
      5 => 
      array (
        'code' => 'M',
        'name' => '세인트 마크',
      ),
      6 => 
      array (
        'code' => 'P',
        'name' => '세인트 패트릭',
      ),
      7 => 
      array (
        'code' => 'C',
        'name' => 'Carriacou에',
      ),
      8 => 
      array (
        'code' => 'Q',
        'name' => '쁘띠 마르티니크',
      ),
    ),
  ),
  'dnb_job_codes' => 
  array (
    '' => '',
    'A045' => '법인 설립자',
    'A046' => '공동 투자자',
    'A047' => '주주',
    'A0A1' => '소유자',
    'A0A2' => '협력자',
    'A0A3' => '관리 파트너',
    'A0AA' => '공동 협력',
    'A0AB' => '회사 무한 책임 사원',
    'A0AC' => '수석 무한 책임 사원',
    'A0AD' => '수석파트너',
    'A0AE' => '무한 책임 사원',
    'A0AF' => '일반 유한책임 사원',
    'A0AG' => '유한 책임 사원',
    'A0AH' => '개별 무한 책임 사원',
    'A0AI' => '개별 협력',
    'A0AJ' => '관리자/제휴업체',
    'A0AL' => '관리 무한 책임 사원',
    'A0AM' => '관리 유한책임 사원',
    'A0AQ' => '공동 소유자',
    'A0AS' => '공동 집행자',
    'A0AT' => '공동 관리위원회',
    'A0AV' => '공동 참여자',
    'A0AY' => '관리 이사',
    'A0AZ' => '관리인',
    'A0GX' => '모험가',
    'A0R0' => '집행자',
    'A0R3' => '공동 모험가',
    'A117' => '최고 마케팅 책임자',
    'A154' => '최고 투자 책임자',
    'A189' => 'C-레벨 지원',
    'A199' => '임원',
    'A1A4' => '이사회 의장',
    'A1A5' => '부위원장',
    'A1A6' => '회장',
    'A1A7' => '최고 경영자',
    'A1A8' => '최고 운영 책임자',
    'A1A9' => '최고 재무 책임자',
    'A1B0' => '출납계',
    'A1B2' => '비서',
    'A1B3' => '자회사 회장',
    'A1B4' => '사업부 사장',
    'A1B5' => '수석 기업 임원',
    'A1BA' => '위원장',
    'A1BB' => '공동 위원장',
    'A1BD' => '위원회의 공동 위원장',
    'A1BE' => '이사회 부의장',
    'A1BF' => '이사회의 대표 위원장',
    'A1BH' => '위원회의 일반 위원장',
    'A1BI' => '이사회 수석 회장',
    'A1BJ' => '이사회 회장 대행',
    'A1BO' => '위원회의 자문 회장',
    'A1BP' => '회장 자문위원회',
    'A1BU' => '명예 이사장',
    'A1BV' => '회장 집행위원회',
    'A1BX' => '회장 재정위원회',
    'A1BY' => '회장 신탁위원회',
    'A1BZ' => '공동 회장 집행위원회',
    'A1CA' => '이사회의 수석 부의장',
    'A1CB' => '이사회의 부위원장',
    'A1CG' => '공동 회장',
    'A1CH' => '회장 대행',
    'A1CJ' => '회장-운영',
    'A1CK' => '위원회 회장',
    'A1CL' => '명예회장',
    'A1CN' => 'CEO 대행',
    'A1CO' => '최고 관리자',
    'A1CP' => '공동 최고 경영자',
    'A1CQ' => '공동 최고 재무 책임자',
    'A1CR' => '공동 최고 운영 책임자',
    'A1CS' => '행정위원회 회원',
    'A1CT' => '대표 전무',
    'A1CU' => '대표 임원',
    'A1CW' => '창설자',
    'A1CX' => '최고 신용 책임자',
    'A1CY' => '최고 재무 책임자 대행',
    'A1G7' => '이사회',
    'A1R1' => '피신탁인',
    'A2AP' => '신탁 무한 책임 사원',
    'A2D1' => '서비스 임원',
    'A2D2' => '최고 경영진',
    'A2IU' => '기관 감독',
    'A2IV' => '수석 투자 책임자',
    'A2IW' => '수석 트러스트 책임자',
    'A2IX' => '신탁 투자 책임자',
    'A2IY' => '신탁 책임자',
    'A2IZ' => '신탁 인사 책임자',
    'A589' => '부사장급 지원',
    'A598' => '경영 부회장',
    'A599' => '행정',
    'A5D3' => '사업부 부사장',
    'A5D4' => '대표 부회장',
    'A5D6' => '그룹 부회장',
    'A5D7' => '수석 부원장',
    'A5D8' => '부원장',
    'A5DL' => '대표 부회장 명예 교수',
    'A5DM' => '일반 수석 부회장',
    'A5DN' => '그룹 대표',
    'A5DO' => '준 부회장',
    'A5DP' => '지역 부회장',
    'A5DQ' => '수석 임원 부원장',
    'A5DR' => '수석 명예 부원장',
    'A5DS' => '분할 / 지역 부사장',
    'A5DT' => '도매 사업부 부원장',
    'A5I5' => '사업 개발 부원장',
    'A5I9' => '경영 부원장',
    'A615' => '사례 관리 감독',
    'A626' => '연구소 감독',
    'A627' => '부소장',
    'A636' => '소셜 임원',
    'A644' => '기획 이사 및 기업 개발',
    'A645' => '신용 감독',
    'A646' => '통신 감독',
    'A647' => '방사선 감독',
    'A655' => '약학 서비스 감독',
    'A65A' => '약국 감독',
    'A663' => '환경 서비스 감독',
    'A689' => '감독 수준 지원',
    'A6A1' => '수석 이사',
    'A6A2' => '텔레커뮤니케이션 감독',
    'A6AA' => '수술실 감독',
    'A6BA' => '환자 치료 / 간호 감독',
    'A6BZ' => '감염 관리 감독',
    'A6C7' => '리스크 관리 감독',
    'A6DU' => '사업부/자회사 수석',
    'A746' => '커뮤니케이션 담당자',
    'A789' => '관리자-수준 지원',
    'A7DU' => '관리 임원',
    'A8DV' => '회장 보좌관',
    'A957' => '자문 위원',
    'A998' => '직원',
    'A9CD' => '이사회 명예 회장',
    'A9DW' => '공동 창립자',
    'A9DX' => '탐사',
    'A9DY' => '명예 이사',
    'A9DZ' => '임시 회장',
    'A9EA' => '명예 회장',
    'AB47' => '방사선 최고 과장',
    'ABA1' => '심장 최고 과장',
    'ABA2' => 'ICU / 관상 동맥 집중 치료실 감독',
    'ABA3' => '외과 최고 과장',
    'ABA4' => '의학 최고 과장',
    'ABA5' => '마취 최고 과장',
    'ABA6' => '응급실 최고 과장',
    'ABA7' => '수술 감독',
    'ABAB' => '병리학 최고 과장',
    'ABBA' => '산부인과 / 부인과 최고 과장',
    'ADA4' => '기록 감독',
    'ADZ9' => '자원 봉사 감독',
    'B0A1' => '최고 관리 책임자',
    'B1EB' => '지역 회장',
    'B1R2' => '학장',
    'B1R3' => '교감',
    'B5D0' => '행정 부원장',
    'B5E2' => '기업 개발 부원장',
    'B5E6' => '대정부 관계 부원장',
    'B5F4' => '인수 합병 부원장',
    'B618' => '안전 감독',
    'B635' => '환자 계정 감독',
    'B699' => '행정 감독',
    'B6EC' => '행정 이사',
    'B6ED' => '공동 관리 감독',
    'B6EE' => '이사회 주주 서비스',
    'B6EF' => '지역 이사',
    'B6EH' => '수석 전문 이사',
    'B6H2' => '대표 이사',
    'B6H8' => '경영 책임자',
    'B6J3' => '매장 감독',
    'B7AB' => '실습 담당자',
    'B7EI' => '행정 담당자',
    'B7EJ' => '프로그램 담당자',
    'B7EK' => '지역 담당자',
    'B7EL' => '스테이션 담당자',
    'B7J0' => '지역 책임자',
    'B7J1' => '지역 감독자',
    'B7J8' => '행정 관리자',
    'B7K0' => '부장',
    'B7K3' => '지점장',
    'B7L3' => '지구 관리자',
    'B7L4' => '사업부 관리자',
    'B7M1' => '일반 관리자',
    'B7M2' => '정부 관계 관리자',
    'B7N2' => '사무담당자',
    'B7N6' => '기획 담당자',
    'B7P5' => '매장 담당자',
    'B7XA' => '간호 담당자',
    'B801' => '행정 지원',
    'B806' => '행정 비서',
    'B830' => '보조 관계자',
    'B899' => '행정 보조',
    'B8B8' => '사무관리자',
    'B914' => '학과 회장',
    'B927' => '사무감독자',
    'B928' => '미팅 계획',
    'B9EM' => '행정관',
    'B9EN' => '도시 관리자',
    'B9EO' => '중간 매니저',
    'B9EP' => '경영',
    'B9EQ' => '기획 직원',
    'B9ME' => '정부 관계',
    'BB47' => '최고 선임 간호사',
    'C1AC' => '전화통신 이사',
    'C1C1' => '정보 기술 대표',
    'C1D9' => '수석 네트워크 엔지니어',
    'C1DC' => '수석 소프트웨어 엔지니어',
    'C2A1' => '최고 정보 책임자',
    'C2A2' => '최고 기술 책임자',
    'C2C1' => '데이터 처리 행정',
    'C2P3' => '최고 정보 보안 책임자',
    'C599' => '시스템 부원장',
    'C5E8' => '정보 서비스 부원장',
    'C601' => '품질 개선 감독',
    'C624' => '정보 기술 감독',
    'C699' => '시스템 이사',
    'C6G8' => '데이터 처리 감독',
    'C6I3' => 'MIS/IS 감독',
    'C6J1' => '컴퓨터실 감독',
    'C6P9' => '품질 보증 책임자',
    'C724' => '컴퓨터 담당자',
    'C799' => '시스템 담당자',
    'C7BB' => '시스템 관리자',
    'C7BC' => '전화통신 담당자',
    'C7C7' => '정보 통신 기술 담당자',
    'C7E8' => '정보 서비스 관리자',
    'C7H1' => '웹 프로젝트 담당자',
    'C7J1' => '네트워트 담당자',
    'C7K9' => '데이터 처리 담당자',
    'C7L5' => '데이터 처리 작업 관리자',
    'C7N1' => '경영 정보 시스템 관리자',
    'C7P7' => '시스템/프로그래밍 담당자',
    'C7P8' => '시스템 지원 담당자',
    'C7P9' => '품질 보증 담당자',
    'C7X9' => '정보 담당자',
    'C7XZ' => '기술 담당자',
    'C899' => '시스템 도우미',
    'C8B9' => '기술/컴퓨터 코디네이터',
    'C8C8' => '정보 통신 기술 프로젝트 담당자',
    'C8CC' => '웹 개발자',
    'C8CD' => '소프트웨어 개발자',
    'C8DC' => '소프트웨어 엔지니어',
    'C8DD' => '시스템 엔지니어',
    'C8X1' => '네트워트 엔지니어',
    'C912' => '데이터 처리 관리자',
    'C918' => '전화통신 스태프',
    'C939' => '수석 시스템 분석가',
    'C940' => '시스템 분석가',
    'C941' => '네트워크 분석가',
    'C999' => '시스템 스태프',
    'C9A1' => '컴퓨터 과학자',
    'C9A2' => '컴퓨터 전문가',
    'C9A3' => '컴퓨터 기술자',
    'C9A4' => '컴퓨터',
    'C9A5' => '정보 시스템',
    'C9A6' => '경영 정보 시스템 직원',
    'C9A7' => '프로그래머',
    'C9A8' => '프로그래머 분석가',
    'C9A9' => '프로젝트 리더',
    'C9B1' => '데이터 컨설턴트',
    'C9B2' => '웹마스터',
    'C9B3' => '데이터베이스 관리자',
    'C9B4' => '응용 프로그램 컨설턴트',
    'C9B5' => '비즈니스 분석',
    'C9B6' => '데이터 관리자',
    'C9B7' => '시스템 기술자',
    'C9B8' => '정보 통신 기술/인터넷 지원',
    'C9B9' => '기술자',
    'C9CX' => '기술 건축가',
    'C9ER' => '데이터 처리 직원',
    'C9F8' => '기술 모집자',
    'C9P3' => 'IT 보안',
    'C9X1' => '네트워트 기술자',
    'C9XZ' => '정보 기술 전문가',
    'D2C2' => '엔지니어링 경영진',
    'D599' => '엔지니어링-연구 & 개발 부원장',
    'D5E4' => '엔지니어링 부원장',
    'D5E5' => '개발 부원장',
    'D5G1' => '연구 기술 부원장',
    'D699' => '엔지니어링 감독',
    'D6ET' => '기술 감독',
    'D6EZ' => '개발 감독',
    'D6O0' => '연구 개발 이사',
    'D799' => '공학 - 연구 및 개발 매니저',
    'D7EU' => '수석 프로젝트 엔지니어',
    'D7EV' => '프로젝트 관리자',
    'D7EW' => '프로젝트 조종자',
    'D7EX' => '프로젝트 책임자',
    'D7EY' => '프로젝트 임원',
    'D7EZ' => '개발 담당자',
    'D7L1' => '디자인 엔지니어링 담당자',
    'D7L7' => '엔지니어링 매니저',
    'D7M5' => '산업 엔지니어링 담당자',
    'D7O0' => '연구 및 개발 담당자',
    'D7O1' => '제품 엔지니어링 담당자',
    'D7O4' => '프로젝트 담당자',
    'D899' => '공학 - 연구 개발 지원',
    'D901' => '전기 엔지니어',
    'D915' => '도안 / 디자이너',
    'D916' => '엔지니어',
    'D917' => '기관장',
    'D918' => '수석 엔지니어',
    'D963' => '자원 보존 전문가',
    'D999' => '공학 - 연구 개발',
    'D9EZ' => '개발',
    'D9FA' => '엔지니어링 직원',
    'D9FB' => '산업',
    'D9FC' => '연구',
    'D9FD' => '기술',
    'D9FE' => '기술 스태프',
    'D9IU' => '연구 및 개발 스태프',
    'D9X1' => '그래픽 디자이너',
    'D9X9' => '프로젝트 엔지니어',
    'DZ25' => '디자인 엔지니어',
    'E1FF' => '투자 책임자',
    'E2C4' => '재정 이사',
    'E5D9' => '회계 부원장',
    'E5E5' => '재무 부원장',
    'E6D9' => '수석 회계사',
    'E6FG' => '금융 감독',
    'E6FH' => '재무 책임자',
    'E6FI' => '대출 담당 직원',
    'E6G4' => '회계 이사',
    'E7FE' => '금융 자문인',
    'E7FF' => '투자 담당자',
    'E7FJ' => '신탁 담당자',
    'E7G2' => '포트폴리오 관리자',
    'E7J7' => '회계 담당자',
    'E7K1' => '감사 관리자',
    'E7K4' => '비즈니스 관리자',
    'E7K7' => '신용 담당자',
    'E7K9' => '계약 담당자',
    'E7L9' => '재무 관리자',
    'E7P9' => '세무 담당자',
    'E7S9' => '증권 중개인',
    'E899' => '금융 지원',
    'E8Q6' => '보조 관리자',
    'E8Q9' => '회계담당 보조',
    'E901' => '회계사',
    'E902' => '공인 회계사',
    'E903' => '세무 대리인',
    'E906' => '감사',
    'E908' => '감사관',
    'E909' => '관리자',
    'E917' => '금융 감독자',
    'E920' => '브로커',
    'E944' => '경리',
    'E999' => '금융 - 기타',
    'E9E6' => '재무 장관',
    'E9E7' => '수석 금융 전문가',
    'E9E9' => '재무 분석가',
    'E9FK' => '회계 직원',
    'E9FL' => '신용 직원',
    'E9FM' => '금융',
    'E9FN' => '할부금',
    'E9FO' => '대출',
    'E9FP' => '주택 담보 대출',
    'E9FQ' => '신탁',
    'E9FR' => '유가 증권',
    'E9FS' => '관리자 대행',
    'E9FZ' => '분석가',
    'EZ20' => '준 브로커',
    'F2A9' => 'C-레벨 인적 자원',
    'F2C9' => '인사 행정',
    'F599' => '인사 부회장',
    'F5E7' => '인사 부원장',
    'F6FV' => '감독 모집',
    'F6G0' => '직원 관계 감독',
    'F6H4' => '인적 자원 담당자',
    'F6H5' => '노사 관계 책임자',
    'F6I6' => '인사 책임자',
    'F6J5' => '교육 및 개발 관리자',
    'F6J6' => '교육 관리자',
    'F7B1' => '인적 자원 조정자',
    'F7FF' => '급여 담당자',
    'F7FR' => '직원 급여 관리자',
    'F7FS' => '펀드 매니저',
    'F7FT' => '연금제도 담당자',
    'F7FU' => '이익 분배 계획 담당자',
    'F7FV' => '담당자 모집',
    'F7K2' => '인사 관리자',
    'F7K5' => '보상 관리자',
    'F7L6' => '직원 관계 관리자',
    'F7M4' => '인적 자원 매니저',
    'F7M6' => '노사 관계 담당자',
    'F7N5' => '인사 담당자',
    'F7Q2' => '교육 및 개발 담당자',
    'F7Q3' => '교육 감독자',
    'F898' => '인적 자원',
    'F899' => '인사 지원',
    'F8C9' => '인적 자원 정보 관리 분석가',
    'F8Z8' => '인적 자원 컨설턴트',
    'F8Z9' => '인적 자원 분석가',
    'F8ZZ' => '급여 직원',
    'F9B1' => '인적 자원 관리자',
    'F9FV' => '스카우터',
    'F9FW' => '인사',
    'F9Q2' => '교육 전문가',
    'G299' => '구매 담당관',
    'G599' => '구매 부회장',
    'G5F0' => '구매/조달 부원장',
    'G629' => '비즈니스 / 금융 / 구매 팀장',
    'G698' => '조달 책임자',
    'G699' => '구매 책임자',
    'G6I9' => '최고 구매 책임자',
    'G798' => '조달 담당자',
    'G7O6' => '구매 담당자',
    'G899' => '구매 보조원',
    'G906' => '수석 구매자',
    'G907' => '구매자',
    'G933' => '구매 대리인',
    'G989' => '조달 직원',
    'G9FX' => '구매',
    'H2C8' => '제조/생산/유통 임원',
    'H599' => '운영/생산/제조 부원장',
    'H5F1' => '제조 부원장',
    'H5F5' => '운영 부원장',
    'H5F8' => '생산 부원장',
    'H699' => '운영 - 생산 / 제조 감독',
    'H6FY' => '작업 감독',
    'H6H9' => '생산 책임자',
    'H6I0' => '안전 이사',
    'H6I1' => '재료 책임자',
    'H6I7' => '생산 감독',
    'H6J4' => '트래픽 관리자',
    'H6O7' => '품질 관리 책임자',
    'H799' => '운영-생산/제조',
    'H7A0' => '재료 담당자',
    'H7B7' => '사이트 관리자',
    'H7D5' => '제분 담당자',
    'H7FZ' => '광산 담당자',
    'H7GA' => '수출 담당자',
    'H7H7' => '영업활동 감독자',
    'H7H9' => '함대 관리자',
    'H7I0' => '안전 담당자',
    'H7L0' => '프런트 엔드 관리자',
    'H7L2' => '유통 / 배송 / 운송 관리자',
    'H7M0' => '생산 담당자',
    'H7M7' => '재고 관리 담당자',
    'H7N3' => '운영 담당자',
    'H7N4' => '포장 엔지니어 담당자',
    'H7N8' => '플렌트 엔지니어링 담당자',
    'H7N9' => '플렌트 담당자',
    'H7O3' => '생산 관리자',
    'H7O7' => '품질 관리 담당자',
    'H7P3' => '보안 담당자',
    'H7Q1' => '트래픽 담당자',
    'H918' => '감독 / 관리자',
    'H920' => '산업 엔지니어',
    'H924' => '생산감독관',
    'H928' => '플랜트 엔지니어',
    'H929' => '플렌트 감독관',
    'H930' => '생산 감독관',
    'H9E7' => '운영 분석가',
    'H9GA' => '함대 직원',
    'H9GB' => '생산 직원',
    'H9GC' => '운영 요원',
    'H9GD' => '영업활동 직원',
    'H9GE' => '운영',
    'H9GF' => '생산',
    'H9GG' => '제작자',
    'H9P3' => '보안 직원',
    'I199' => '경영 정보 책임자',
    'I1A7' => '콜 센터 관리자',
    'I1A8' => '시장 대표',
    'I1A9' => '영업 대표',
    'I1X7' => '전국 판매 부장',
    'I2A1' => 'C-레벨 마케팅',
    'I2A3' => '디지털 및 소셜 미디어 책임자',
    'I2B9' => '홍보 이사',
    'I2C0' => '판매 및 마케팅 임원',
    'I2I1' => '소셜 미디어 전략가',
    'I599' => '영업 마케팅 부원장',
    'I5A1' => '대표 부회장 마케팅',
    'I5A2' => '대표 부회장 판매',
    'I5E1' => '광고 부원장',
    'I5F2' => '마케팅 부원장',
    'I5F3' => '판매 부원장',
    'I5F7' => '제품 개발 부원장',
    'I5G2' => '영업 부원장',
    'I5H1' => '기업 홍보 부원장',
    'I5I1' => '홍보 부원장',
    'I699' => '판매 및 마케팅 감독',
    'I6A1' => '전자-비즈니스 감독',
    'I6A2' => '전자 상거래 감독',
    'I6A3' => '디지털 및 소셜 미디어 감독',
    'I6G6' => '광고 이사',
    'I6H0' => '시장 책임자',
    'I6H1' => '기업 커뮤니케이션 감독',
    'I6I1' => '홍보 책임자',
    'I6J2' => '영업 이사',
    'I6K2' => '비즈니스 개발 이사',
    'I6K8' => '고객 서비스 감독',
    'I799' => '판매 및 마케팅 담당자',
    'I7A1' => '전자-비즈니스 관리자',
    'I7A2' => '전자 상거래 관리자',
    'I7A3' => '소셜 미디어 담당자',
    'I7A4' => '커뮤니티 관리자',
    'I7B1' => '상품 담당자',
    'I7H1' => '기업 커뮤니케이션 담당자',
    'I7I1' => '홍보 담당자',
    'I7J9' => '광고 담당자',
    'I7K2' => '사업 개발 매니저',
    'I7K8' => '고객 서비스 담당자',
    'I7M9' => '시장 담당자',
    'I7N0' => '제품 개발 관리자',
    'I7O2' => '제품 담당 책임자',
    'I7O9' => '지역 판매 담당자',
    'I7P1' => '판매 담당자',
    'I7P2' => '판매 프로모션 담당자',
    'I889' => '시장 조사 직원',
    'I898' => '판매 사원',
    'I899' => '판매 및 마케팅 도우미',
    'I998' => '디지털 및 소셜 미디어 전문가',
    'I999' => '판매 및 마케팅 스태프',
    'I9A1' => '전자 상거래',
    'I9A2' => '전자-비즈니스',
    'I9A3' => '소셜 미디어 분석가',
    'I9A4' => '소셜 미디어 마케팅 담당자',
    'I9D8' => '영업 엔지니어',
    'I9GH' => '광고 직원',
    'I9GI' => '상품',
    'I9GJ' => '판매',
    'I9GK' => '시장 직원',
    'I9GL' => '생산품',
    'I9GM' => '판매 스태프',
    'I9GN' => '데이터베이스 마케팅',
    'I9H1' => '기업 커뮤니케이션 직원',
    'I9I1' => '홍보 직원',
    'I9I2' => '출판물',
    'I9I3' => '대변인',
    'I9I8' => '판매 조정자',
    'I9I9' => '마케팅 조정자',
    'I9K8' => '고객 서비스 직원',
    'I9Z9' => '콜 센터 직원',
    'I9ZX' => '콜 센터 대표',
    'J599' => '시설 부회장',
    'J699' => '시설 감독',
    'J6E2' => '시설 관리실 책임자',
    'J6H7' => '관리 책임자',
    'J7GN' => '공원 담당자',
    'J7L8' => '시설 관리자',
    'J7M3' => '허브 담당자',
    'J7M8' => '관리 담당자',
    'J7N7' => '설비 및 시설 담당자',
    'J7P0' => '터미널 담당자',
    'J7Q3' => '창고 담당자',
    'J7ZZ' => '부동산 자산관리사',
    'J899' => '시설 지원',
    'J923' => '관리 감독관',
    'J999' => '시설',
    'J9GO' => '관리 직원',
    'J9GP' => '플라자 담당자',
    'K209' => '대사',
    'K601' => '연방 프로그램 감독',
    'K602' => '프로그램 검사자',
    'K656' => '차장',
    'K661' => '판사',
    'K670' => '경찰서장',
    'K948' => '시의회 의원',
    'K949' => '과장',
    'K950' => '최고 책임자',
    'K951' => '시의회',
    'K952' => '감독관',
    'K953' => '위원회의 일원',
    'K955' => '자문위원',
    'K960' => '카운티 감독관',
    'K961' => '카운티 판사',
    'K962' => '연장자',
    'K963' => '소방 대장',
    'K964' => '주지사',
    'K965' => '시장',
    'K966' => '행정 위원',
    'K967' => '민선 치안 담당관',
    'K968' => '부시장',
    'K969' => '감시자',
    'K989' => '사법 직원',
    'K999' => '정부',
    'K9D7' => '조정 책임자',
    'L6A6' => '목회활동 감독',
    'L935' => '종교 지도자',
    'L970' => '부목사',
    'L971' => '장관',
    'L972' => '부 교역자',
    'L973' => '주교',
    'L974' => '집사',
    'L975' => '추기경',
    'L976' => '목사',
    'L977' => '수녀 원장',
    'L978' => '랍비',
    'L979' => '총장',
    'L980' => '성직자',
    'L981' => '사제',
    'L982' => '담임 목사',
    'M1B1' => '교육감',
    'M1B2' => '학교 이사회 회장',
    'M622' => '도서관장',
    'M6E6' => '재정 보조 감독',
    'M6F6' => '교사 인사 감독',
    'M6I6' => '교육용 미디어 서비스 책임자',
    'M7M6' => '지도 교수',
    'M7M9' => '교수',
    'M7MZ' => '교사',
    'M8I6' => '미디어 전문가',
    'M8I7' => '독서 교육 전문가',
    'M901' => '교육',
    'M922' => '사서',
    'M983' => '수상',
    'M984' => '주임 사제',
    'M985' => '교장',
    'M986' => '수석 입학 책임자',
    'M987' => '최고 학술 책임자',
    'M988' => '체육 감독',
    'M989' => '식품 서비스 감독',
    'M990' => '부총장',
    'M999' => '교육 지원',
    'M9M9' => '강사',
    'M9R3' => '준 교수',
    'M9R4' => '조교수',
    'M9R5' => '겸임 교수',
    'N985' => '상사',
    'N986' => '조수',
    'N987' => '지휘관',
    'N988' => '제독',
    'N989' => '최고 통치자',
    'N990' => '그랜드 나이트',
    'N991' => '최고 기사',
    'N992' => '숙련가',
    'N993' => '주둔부대 사령관',
    'N994' => '병참 장교',
    'N995' => '요트 클럽의 부제독 후속 임원',
    'N996' => '기록자',
    'N997' => '부사령관',
    'N998' => '부제독',
    'N999' => '선장',
    'X1Z8' => '수석 사원',
    'X626' => '과학자',
    'X656' => '미술 감독',
    'X6Z9' => '프로그램 편성자',
    'X746' => '부 편집장',
    'X799' => '상업/기술직',
    'X7DZ' => '수석 프로젝트 관리자',
    'X7X7' => '수석 담당자',
    'X8X9' => '수석 컨설턴트',
    'X901' => '저자',
    'X906' => '조세',
    'X930' => '건축가',
    'X931' => '디자이너',
    'X956' => '고객 관리자',
    'X957' => '고객 담당자',
    'X9CD' => '연구 분석',
    'XA01' => '응급 의학 전문의',
    'XA02' => '일반 혈관 외과 의사',
    'XA99' => '의학 박사',
    'XAA1' => '수의사',
    'XAA2' => '가족 치료사',
    'XAB5' => '약물 남용 상담가',
    'XABX' => '심리학자',
    'XAP0' => '정신 분석학자',
    'XAP1' => '이비인후과 전문의',
    'XAP2' => '전염병',
    'XAP3' => '안과 의사',
    'XAP4' => '정형외과 의사',
    'XAP5' => '병리학자',
    'XAP6' => '항문과 의사',
    'XAP7' => '스포츠 의학',
    'XAP8' => '흉부 의사',
    'XAP9' => '외과 의사',
    'XAQ1' => '작업 산업 전문가',
    'XAQ2' => '노인 의학',
    'XAQ3' => '산부인과 의사',
    'XAQ4' => '청각학자',
    'XAS0' => '알레르기 및 면역학',
    'XAS1' => '마취학',
    'XAS2' => '관절염 및 류머티즘',
    'XAS3' => '심장학',
    'XAS4' => '피부과',
    'XAS5' => '내분비학',
    'XAS6' => '일반 의료 행위',
    'XAS7' => '위장병학',
    'XAS8' => '혈액학',
    'XAS9' => '내과학',
    'XAT0' => '신장(병)학',
    'XAT1' => '신경학',
    'XAT2' => '핵의학',
    'XAT3' => '부인과/산부인과',
    'XAT4' => '종양학',
    'XAT5' => '안과학',
    'XAT6' => '소아과',
    'XAT7' => '재활의학과',
    'XAT8' => '정신 의학',
    'XAT9' => '아동 심리학',
    'XAU0' => '폐질환',
    'XAU1' => '방사선학',
    'XAU2' => '척추 지압 요법사',
    'XAU3' => '정골 요법',
    'XAU4' => '외과-정형',
    'XAU5' => '수술-성형',
    'XAU6' => '수술-흉부',
    'XAU7' => '비뇨기과',
    'XAU8' => '예방 의학',
    'XAU9' => '불임 전문가',
    'XAV0' => '당뇨병',
    'XAV1' => '이비인후과학',
    'XAV2' => '침 요법',
    'XAV3' => '성형외과 의사',
    'XAV4' => '류머티스 전문의',
    'XAV5' => '심장 혈관',
    'XAV6' => '신경외과',
    'XAV7' => '대장 및 직장 외과',
    'XAV8' => '혈관 수술',
    'XAXA' => '흉부 외과 의사',
    'XAY5' => '면역학자',
    'XAY6' => '최면술사',
    'XAY7' => '영양학자',
    'XAY9' => '항공 우주 의학',
    'XAZ1' => '발병 전문가',
    'XAZ2' => '전문의',
    'XAZ8' => '의료 보조자',
    'XAZ9' => '수술',
    'XB37' => '진단 방사선 학자',
    'XB47' => '연합 보건 전문가',
    'XB67' => '보건 관리자',
    'XB6M' => '건강 정보 감독',
    'XB98' => '응급 최초 대처자',
    'XB99' => '의료 보건 책임자',
    'XBA7' => '응급실 감독',
    'XBB2' => '콘택트 렌즈 전문가',
    'XBB3' => '유방 관리 전문가',
    'XBBB' => '임상 간호사',
    'XBC1' => '간호사',
    'XBC2' => '간호 책임자',
    'XBC3' => '언어 치료사',
    'XBC4' => '육아 행정관',
    'XBC9' => '간호 감독관',
    'XBD1' => '약사',
    'XBD2' => '공인 약학 전문가',
    'XBE1' => '호흡기 치료 이사',
    'XBE2' => '물리 치료 책임자',
    'XBE3' => '작업 요법 책임자',
    'XBE4' => '물리 치료사',
    'XBE5' => '물리 요법사',
    'XBF1' => '관리 의료 책임자',
    'XBF2' => '가정 건강 관리 책임자',
    'XBF9' => '병원장',
    'XBFB' => '간호사 스카우터',
    'XBFC' => '의사 스카우터',
    'XBU1' => '악안면 전문의',
    'XBV4' => '치과의',
    'XBV9' => '치과 보철학',
    'XBW0' => '치과 위생사',
    'XBW3' => '그룹 및 기업 실습',
    'XBXA' => '국가 공인 간호사',
    'XBXB' => '간호 조무사',
    'XBXC' => '재활 간호사',
    'XBZ8' => '발교정 전문의',
    'XBZ9' => '교정술사',
    'XBZZ' => '재활 의학과',
    'XD15' => '기업 변호사 / 법률',
    'XD26' => '변호사',
    'XD51' => '법률 부원장',
    'XD97' => '사무 변호사',
    'XD98' => '법무사',
    'XD99' => '법률 고문',
    'XDA2' => '특별 감사 책임자',
    'XDA6' => '특별 감사 감독',
    'XDA7' => '특별 감사 담당자',
    'XDW4' => '특허법',
    'XDW5' => '계약법',
    'XDW6' => '화이트칼라의 범죄',
    'XDW7' => '로비 활동',
    'XDW9' => '연구 법률',
    'XDX0' => '형법',
    'XDX1' => '일반 고문',
    'XDX2' => '민사재판실무',
    'XDX3' => '부동산/감정/부동산 계획',
    'XDX4' => '개인 상해법',
    'XDX5' => '이혼 법',
    'XDX6' => '기업 및 비즈니스 법률',
    'XDX7' => '일반 법률 연습',
    'XDX8' => '석면 소송',
    'XDX9' => '환경법',
    'XDY0' => '가정법',
    'XDY1' => '파산법',
    'XDY2' => '소송',
    'XDY3' => '불법 행위',
    'XDY4' => '의료 과실',
    'XDY5' => '전문적 책임',
    'XDY6' => '상법',
    'XDZ9' => '특별 감사 직원',
    'XZ9L' => '사회 복지사',
    'XZA1' => '회원',
    'XZY8' => '영양사',
    'Z1X1' => '관리 회원',
    'Z2B7' => '행정 책임자',
    'Z2B8' => '항공 운송 책임자',
    'Z2B9' => '은행 이사',
    'Z2C3' => '사무총장',
    'Z2C5' => '접대 임원',
    'Z2C6' => '국제 임원',
    'Z5E9' => '국제 부원장',
    'Z642' => '보조 이사',
    'Z698' => '교통 관리자',
    'Z699' => '감독',
    'Z6GQ' => '이사 대행',
    'Z6H6' => '국제 이사장',
    'Z6H7' => '공동 감독',
    'Z715' => '사례 관리자',
    'Z741' => '공동 관리자',
    'Z799' => '담당자',
    'Z7F7' => '보험/결제 감독자',
    'Z7GQ' => '담당자 대행',
    'Z7GR' => '건물단지 관리자',
    'Z7P4' => '서비스 관리자',
    'Z823' => '리포터',
    'Z856' => '보조 사무실 담당자',
    'Z888' => '접수 담당자',
    'Z889' => '접수 담당자 비서',
    'Z899' => '보조자',
    'Z8A8' => '의사 보조',
    'Z8B9' => '안과 기술자',
    'Z8GT' => '보조 사무원',
    'Z8GU' => '보조 지역 책임자',
    'Z8Q0' => '부회장 보좌관',
    'Z8Q7' => '보조 담당자',
    'Z8Q8' => '차관보',
    'Z900' => '계정 책임자',
    'Z903' => '연구원',
    'Z910' => '조정자',
    'Z917' => '고객 서비스 대표',
    'Z921' => '보험 대리점',
    'Z923' => '공인 손해보험언더라이터',
    'Z924' => '공인 생명 보험사',
    'Z925' => '보험업자',
    'Z926' => '채권 보험사',
    'Z932' => '출판인',
    'Z934' => '부동산 중개인',
    'Z936' => '매장 현장 감독자',
    'Z937' => '현장 감독자',
    'Z938' => '감독자',
    'Z939' => '사무원',
    'Z940' => '준/부/조',
    'Z941' => '보조 계산원',
    'Z943' => '부교육감',
    'Z998' => '부품 담당자',
    'Z9GU' => '관리자 계정',
    'Z9GV' => '계정 관리',
    'Z9GW' => '여성 관리자',
    'Z9GX' => '고문',
    'Z9GY' => '에이전트',
    'Z9GZ' => '사실 변호사',
    'Z9HA' => '컨설턴트',
    'Z9HB' => '계약자',
    'Z9HC' => '상업',
    'Z9HD' => '위원',
    'Z9HG' => '기업 대표',
    'Z9HH' => '특파원',
    'Z9HI' => '계산원',
    'Z9HJ' => '분산제',
    'Z9HK' => '국내',
    'Z9HL' => '편집자',
    'Z9HM' => '외국',
    'Z9HN' => '일반',
    'Z9HQ' => '그룹',
    'Z9HR' => '국제',
    'Z9HT' => '매각 대리인',
    'Z9HX' => '항구 감독관',
    'Z9HY' => '항구 책임자',
    'Z9HZ' => '항구 담당자',
    'Z9IA' => '출판',
    'Z9IB' => '우체국장',
    'Z9IC' => '출판물 인쇄업자',
    'Z9IF' => '부동산',
    'Z9IG' => '지역',
    'Z9IH' => '복직자',
    'Z9II' => '대표',
    'Z9IJ' => '소매',
    'Z9IK' => '소매업자',
    'Z9IL' => '지방',
    'Z9IM' => '관계',
    'Z9IO' => '수석 편집자',
    'Z9IQ' => '서비스',
    'Z9IR' => '저축',
    'Z9IS' => '교통',
    'Z9IT' => '도매',
    'ZA48' => '구강 악안면 외과',
    'ZAA0' => '전문 치과',
    'ZAA1' => '소아치과의사',
    'ZAA2' => '치내 치료약',
    'ZAA3' => '가족 및 일반 치과',
    'ZAA4' => '치과 교정학',
    'ZAA5' => '소아치과학',
    'ZAA6' => '치주병학',
    'ZAA7' => '구강 병리학',
    'ZAAB' => '치과 외과의',
    'ZAV6' => '검안사',
    'ZAV7' => '노인 전문 시력 측정',
    'ZBXA' => '통증관리',
    'ZBXB' => '혈액 은행',
    'ZBZZ' => '조산사',
  ),
);

