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
  'ERROR_EMPTY_RECORD_ID' => 'エラー: レコードIDが指定されていないか空です。',
  'ERROR_EMPTY_SOURCE_ID' => 'エラー: ソースIDが指定されていないか空です。',
  'ERROR_EMPTY_WRAPPER' => 'エラー: ソース[{$source_id}]へのラッパーインスタンスを取得できません。',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'エラー: このレコードへの追加の詳細が見つかりません。',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'エラー: このモジュールへコネクタが関連付けられていません。',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'エラー: 結果に表示するモジュールフィールドが関連付けられていません。システム管理者に連絡してください。',
  'ERROR_NO_FIELDS_MAPPED' => 'エラー: モジュールのそれぞれのエントリのモジュールフィールドに少なくとも１つのコネクタフィールドを関連付けなければいけません。',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'このコネクタへモジュールが有効化されていません。コネクタを有効化ページでこのコネクタへのモジュールを選択してください。',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'エラー: 検索フィールドが定義されたコネクタが有効になっていません。',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'エラー: モジュールとコネクタに１つも検索フィールドが定義されていません。システム管理者に連絡してください。',
  'ERROR_NO_SOURCEDEFS_FILE' => 'エラー: sourcedefs.phpファイルが見つかりません。',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'エラー: どのデータを取得するかを指定したソースが見つかりません。',
  'ERROR_RECORD_NOT_SELECTED' => 'エラー: 実行前にリストからレコードを選択してください。',
  'LBL_ADDRCITY' => '市区町村',
  'LBL_ADDRCOUNTRY' => '国',
  'LBL_ADDRCOUNTRY_ID' => '国ID',
  'LBL_ADDRSTATEPROV' => '都道府県',
  'LBL_ADD_MODULE' => '追加',
  'LBL_ADMINISTRATION' => 'コネクタ管理者',
  'LBL_ADMINISTRATION_MAIN' => 'コネクタ設定',
  'LBL_AVAILABLE' => '利用可能',
  'LBL_BACK' => '< 戻る',
  'LBL_CLOSE' => '完了',
  'LBL_COMPANY_ID' => '会社ID',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'いくつかの必須フィールドが空白のままです。変更を保存しますか？',
  'LBL_CONNECTOR' => 'コネクタ',
  'LBL_CONNECTOR_FIELDS' => 'コネクタフィールド',
  'LBL_DATA' => '日付',
  'LBL_DEFAULT' => 'デフォルト',
  'LBL_DELETE_MAPPING_ENTRY' => '本当にこのエントリを削除してよいですか？',
  'LBL_DISABLED' => '無効',
  'LBL_DUNS' => 'DUNS(企業識別コード)',
  'LBL_EMPTY_BEANS' => '検索条件に適合するものはありません。',
  'LBL_ENABLED' => '有効',
  'LBL_EXTERNAL' => 'このコネクタ用の外部アカウントの作成をユーザに許可します。',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'このコネクタを利用するには、コネクタプロパティの設定でプロパティを設定する必要があります。',
  'LBL_FINSALES' => 'Finsales',
  'LBL_INFO_INLINE' => '情報',
  'LBL_MARKET_CAP' => '時価総額',
  'LBL_MERGE' => 'マージ',
  'LBL_MODIFY_DISPLAY_DESC' => 'それぞれのコネクタでどのモジュールを有効化するか選択してください。',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'コネクタ設定: コネクタを有効化',
  'LBL_MODIFY_DISPLAY_TITLE' => 'コネクタを有効化',
  'LBL_MODIFY_MAPPING_DESC' => 'どのコネクタのデータがモジュールのレコードに対して表示・マージされるかを決めるため、コネクタフィールドとモジュールフィールドを関連付けます。',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'コネクタ設定: コネクタフィールドの関連付け',
  'LBL_MODIFY_MAPPING_TITLE' => 'コネクタフィールドを関連付け',
  'LBL_MODIFY_PROPERTIES_DESC' => 'それぞれのコネクタのプロパティの設定 (URLやAPIキーを含む)',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'コネクタ設定: コネクタプロパティの設定',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'コネクタプロパティの設定',
  'LBL_MODIFY_SEARCH' => '検索',
  'LBL_MODIFY_SEARCH_DESC' => 'それぞれのモジュールのデータを検索する際に利用するコネクタフィールドを選択してください。',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'コネクタ設定: コネクタ検索の管理',
  'LBL_MODIFY_SEARCH_TITLE' => 'コネクタ検索の管理',
  'LBL_MODULE_FIELDS' => 'モジュールフィールド',
  'LBL_MODULE_NAME' => 'コネクタ',
  'LBL_MODULE_NAME_SINGULAR' => 'コネクタ',
  'LBL_NO_PROPERTIES' => 'このコネクタに設定できるプロパティはありません。',
  'LBL_PARENT_DUNS' => '親DUNS(企業識別コード)',
  'LBL_PREVIOUS' => '< 戻る',
  'LBL_QUOTE' => '見積',
  'LBL_RECNAME' => '会社名',
  'LBL_RESET_BUTTON_TITLE' => 'リセット [Alt+R]',
  'LBL_RESET_TO_DEFAULT' => 'デフォルトに戻す',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => '本当にデフォルト設定に戻してよいですか？',
  'LBL_RESULT_LIST' => 'データリスト',
  'LBL_RUN_WIZARD' => 'ウィザードの実行',
  'LBL_SAVE' => '保存',
  'LBL_SEARCHING_BUTTON_LABEL' => '検索中...',
  'LBL_SHOW_IN_LISTVIEW' => 'マージ一覧画面に表示',
  'LBL_SMART_COPY' => 'スマートコピー',
  'LBL_STEP1' => 'データの検索と閲覧',
  'LBL_STEP2' => 'レコードのマージ',
  'LBL_SUMMARY' => '概要',
  'LBL_TEST_SOURCE' => 'コネクタのテスト',
  'LBL_TEST_SOURCE_FAILED' => 'テスト失敗',
  'LBL_TEST_SOURCE_RUNNING' => 'テスト実行中...',
  'LBL_TEST_SOURCE_SUCCESS' => 'テスト成功',
  'LBL_TITLE' => 'データマージ',
  'LBL_ULTIMATE_PARENT_DUNS' => 'ルートDUNS(企業識別コード)',
  'dnb_countries_iso' => 
  array (
    'AD' => 'アンドラ',
    'AE' => 'アラブ首長国連邦',
    'AF' => 'アフガニスタン',
    'AG' => 'アンチグアバーブーダ',
    'AI' => 'アングィラ',
    'AL' => 'アルバニア',
    'AM' => 'アルメニア',
    'AN' => 'オランダ領アンティル',
    'AO' => 'アンゴラ',
    'AQ' => '南極',
    'AR' => 'アルゼンチン',
    'AS' => 'アメリカ領サモア',
    'AT' => 'オーストリア',
    'AU' => 'オーストラリア',
    'AW' => 'アルバ',
    'AZ' => 'アゼルバイジャン',
    'BA' => 'ボスニアヘルツェゴビナ',
    'BB' => 'バルバドス',
    'BD' => 'バングラデシュ',
    'BE' => 'ベルギー',
    'BF' => 'ブルキナファソ',
    'BG' => 'ブルガリア',
    'BH' => 'バーレーン',
    'BI' => 'ブルンジ',
    'BJ' => 'ベニン',
    'BM' => 'バミューダ',
    'BN' => 'ブルネイ',
    'BO' => 'ボリビア',
    'BR' => 'ブラジル',
    'BS' => 'バハマ',
    'BT' => 'ブータン',
    'BV' => 'ブーヴェ島',
    'BW' => 'ボツワナ',
    'BY' => 'ベラルーシ',
    'BZ' => 'ベリーズ',
    'CA' => 'カナダ',
    'CC' => 'ココス諸島',
    'CD' => 'コンゴ民主共和国',
    'CF' => '中央アフリカ共和国',
    'CG' => 'コンゴ',
    'CH' => 'スイス',
    'CI' => 'コートジボアール',
    'CK' => 'クック諸島',
    'CL' => 'チリ',
    'CM' => 'カメルーン',
    'CN' => '中国',
    'CO' => 'コロンビア',
    'CR' => 'コスタリカ',
    'CU' => 'キューバ',
    'CV' => 'カーボベルデ',
    'CX' => 'クリスマス島',
    'CY' => 'キプロス',
    'CZ' => 'チェコ共和国',
    'DE' => 'ドイツ',
    'DJ' => 'ジブチ',
    'DK' => 'デンマーク',
    'DM' => 'ドミニカ',
    'DO' => 'ドミニカ共和国',
    'DZ' => 'アルジェリア',
    'EC' => 'エクアドル',
    'EE' => 'エストニア',
    'EG' => 'エジプト',
    'EH' => '西サハラ',
    'ER' => 'エリトリア',
    'ES' => 'スペイン',
    'ET' => 'エチオピア',
    'FI' => 'フィンランド',
    'FJ' => 'フィジー',
    'FK' => 'フォークランド諸島',
    'FM' => 'ミクロネシア',
    'FO' => 'フェロー諸島',
    'FR' => 'フランス',
    'FX' => 'フランス・メトロポリテーヌ',
    'GA' => 'ガボン',
    'GB' => 'イギリス',
    'GD' => 'グラナダ',
    'GE' => 'グルジア',
    'GF' => 'フランス領ギニア',
    'GH' => 'ガーナ',
    'GI' => 'ジブラルタル',
    'GL' => 'グリーンランド',
    'GM' => 'ガンビア',
    'GN' => 'ギニア',
    'GP' => 'グアドループ',
    'GQ' => '赤道ギニア',
    'GR' => 'ギリシャ',
    'GS' => 'サウスジョージア・サウスサンドウィッチ諸島',
    'GT' => 'グアテマラ',
    'GU' => 'グアム',
    'GW' => 'ギニアビサウ',
    'GY' => 'ガイアナ',
    'HK' => '香港',
    'HM' => 'ハードおよびマクドナルド諸島',
    'HN' => 'ホンジュラス',
    'HR' => 'クロアチア',
    'HT' => '配置',
    'HU' => 'ハンガリー',
    'ID' => 'インドネシア',
    'IE' => 'アイルランド',
    'IL' => 'イスラエル',
    'IN' => 'インド',
    'IO' => 'イギリス領インド洋地域',
    'IQ' => 'イラク',
    'IR' => 'イラン',
    'IS' => 'アイスランド',
    'IT' => 'イタリア',
    'JM' => 'ジャマイカ',
    'JO' => 'ヨルダン',
    'JP' => '日本',
    'KE' => 'ケニア',
    'KG' => 'キルギスタン',
    'KH' => 'カンボジア',
    'KI' => 'キリバス',
    'KM' => 'コモロ諸島',
    'KN' => 'セントクリストファー・ネイビス',
    'KP' => '北朝鮮',
    'KR' => '韓国',
    'KW' => 'クウェート',
    'KY' => 'ケイマン諸島',
    'KZ' => 'カザフスタン',
    'LA' => 'ラオス',
    'LB' => 'レバノン',
    'LC' => 'セントルシア',
    'LI' => 'リヒテンシュタイン',
    'LK' => 'スリランカ',
    'LR' => 'リベリア',
    'LS' => 'レソト',
    'LT' => 'リトアニア',
    'LU' => 'ルクセンブルグ',
    'LV' => 'ラトビア',
    'LY' => 'リビア',
    'MA' => 'モロッコ',
    'MC' => 'モナコ',
    'MD' => 'モルドバ',
    'ME' => 'モンテネグロ',
    'MG' => 'マダガスカル',
    'MH' => 'マーシャル諸島',
    'MK' => 'マケドニア共和国旧ユーゴスラビア',
    'ML' => 'マリ',
    'MM' => 'ミャンマー',
    'MN' => 'モンゴル',
    'MO' => 'マカオ',
    'MP' => '北マリアナ諸島',
    'MQ' => 'マルティニーク',
    'MR' => 'モーリタニア',
    'MS' => 'モントセラト',
    'MT' => 'マルタ',
    'MU' => 'モーリシャス',
    'MV' => 'モルジブ',
    'MW' => 'マラウィ',
    'MX' => 'メキシコ',
    'MY' => 'マレーシア',
    'MZ' => 'モザンビーク',
    'NA' => 'ナミビア',
    'NC' => 'ニューカレドニア',
    'NE' => 'ニジェール',
    'NF' => 'ノーフォーク島',
    'NG' => 'ナイジェリア',
    'NI' => 'ニカラグア',
    'NL' => 'オランダ',
    'NO' => 'ノルウェー',
    'NP' => 'ネパール',
    'NR' => 'ナウル',
    'NU' => 'ニウエ',
    'NZ' => 'ニュージーランド',
    'OM' => 'オマーン',
    'PA' => 'パナマ',
    'PE' => 'ペルー',
    'PF' => 'フランス領ポリネシア',
    'PG' => 'パプアニューギニア',
    'PH' => 'フィリピン',
    'PK' => 'パキスタン',
    'PL' => 'ポーランド',
    'PM' => 'サンピエールとミクロン島',
    'PN' => 'ピトケアン諸島',
    'PR' => 'プエルトリコ',
    'PS' => 'パレスチナ',
    'PT' => 'ポルトガル',
    'PW' => 'パラオ',
    'PY' => 'パラグアイ',
    'QA' => 'カタール',
    'RE' => 'レユニオン',
    'RO' => 'ルーマニア',
    'RS' => 'セルビア',
    'RU' => 'ロシア',
    'RW' => 'ルワンダ',
    'SA' => 'サウジアラビア',
    'SB' => 'ソロモン諸島',
    'SC' => 'セーシェル',
    'SD' => 'スーダン',
    'SE' => 'スウェーデン',
    'SG' => 'シンガポール',
    'SH' => 'セントヘレナ',
    'SI' => 'スロベニア',
    'SJ' => 'スヴァールバル諸島およびヤンマイエン島',
    'SK' => 'スロバキア',
    'SL' => 'シエラレオネ',
    'SM' => 'サモア',
    'SN' => 'セネガル',
    'SO' => 'ソマリア',
    'SR' => 'スリナム',
    'ST' => 'サントメ・プリンシペ',
    'SV' => 'エルサルバドル',
    'SY' => 'シリア',
    'SZ' => 'スワジランド',
    'TC' => 'タークス・カイコス諸島',
    'TD' => 'チャド',
    'TF' => 'フランス領南方地域',
    'TG' => 'トーゴ',
    'TH' => 'タイ',
    'TJ' => 'タジキスタン',
    'TK' => 'トケラウ',
    'TM' => 'トルクメニスタン',
    'TN' => 'チュニジア',
    'TO' => 'トンガ',
    'TP' => '東ティモール',
    'TR' => 'トルコ',
    'TT' => 'トリニダード・トバゴ',
    'TV' => 'ツバル',
    'TW' => '台湾',
    'TZ' => 'タンザニア',
    'UA' => 'ウクライナ',
    'UG' => 'ウガンダ',
    'UM' => '合衆国領有小離島',
    'US' => 'アメリカ',
    'UY' => 'ウルグアイ',
    'UZ' => 'ウズベキスタン',
    'VA' => 'バチカン市国',
    'VC' => 'セントビンセント・グレナディーン',
    'VE' => 'ベネズエラ',
    'VG' => 'イギリス領バージン諸島',
    'VI' => 'アメリカ領バージン諸島',
    'VN' => 'ベトナム',
    'VU' => 'バヌアツ',
    'WF' => 'ウォリス・フツナ',
    'WS' => 'サモア',
    'YE' => 'イエメン',
    'YT' => 'Mayotte',
    'ZA' => '南アフリカ',
    'ZM' => 'ザンビア',
    'ZW' => 'ジンバブエ',
  ),
  'dnb_states_iso' => 
  array (
    'AD' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AF' => 
    array (
      1 => 
      array (
        'code' => 'BAL',
        'name' => 'バルフ',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => 'バーミアーン',
      ),
      3 => 
      array (
        'code' => 'BDG',
        'name' => 'バードギサート',
      ),
      4 => 
      array (
        'code' => 'BDS',
        'name' => 'バダフシャーン',
      ),
      5 => 
      array (
        'code' => 'BGL',
        'name' => 'バグラーン',
      ),
      6 => 
      array (
        'code' => 'FRA',
        'name' => 'ファラー',
      ),
      7 => 
      array (
        'code' => 'FYB',
        'name' => 'ファールヤーブ',
      ),
      8 => 
      array (
        'code' => 'GHA',
        'name' => 'ガズニー',
      ),
      9 => 
      array (
        'code' => 'GHO',
        'name' => 'Ghowr',
      ),
      10 => 
      array (
        'code' => 'HEL',
        'name' => 'ヘルマンド',
      ),
      11 => 
      array (
        'code' => 'HER',
        'name' => 'ヘラート',
      ),
      12 => 
      array (
        'code' => 'JOW',
        'name' => 'ジョージャン',
      ),
      13 => 
      array (
        'code' => 'KAB',
        'name' => 'カブール',
      ),
      14 => 
      array (
        'code' => 'KAN',
        'name' => 'カンダハール',
      ),
      15 => 
      array (
        'code' => 'KAP',
        'name' => 'カピサ',
      ),
      16 => 
      array (
        'code' => 'KDZ',
        'name' => 'コンドズ',
      ),
      17 => 
      array (
        'code' => 'KHO',
        'name' => 'コースト',
      ),
      18 => 
      array (
        'code' => 'KNR',
        'name' => 'コナル',
      ),
      19 => 
      array (
        'code' => 'LAG',
        'name' => 'ラグマーン',
      ),
      20 => 
      array (
        'code' => 'LOW',
        'name' => 'ローガー',
      ),
      21 => 
      array (
        'code' => 'NAN',
        'name' => 'ナンガルハール',
      ),
      22 => 
      array (
        'code' => 'NIM',
        'name' => 'ニームルーズ',
      ),
      23 => 
      array (
        'code' => 'NUR',
        'name' => 'ヌーリスターン',
      ),
      24 => 
      array (
        'code' => 'ORU',
        'name' => 'ウルーズガーン',
      ),
      25 => 
      array (
        'code' => 'PAR',
        'name' => 'パルヴァーン',
      ),
      26 => 
      array (
        'code' => 'PIA',
        'name' => 'パクティヤー',
      ),
      27 => 
      array (
        'code' => 'PKA',
        'name' => 'パクティーカー',
      ),
      28 => 
      array (
        'code' => 'SAM',
        'name' => 'サマンガーン',
      ),
      29 => 
      array (
        'code' => 'SAR',
        'name' => 'サーレポル',
      ),
      30 => 
      array (
        'code' => 'TAK',
        'name' => 'タハール',
      ),
      31 => 
      array (
        'code' => 'WAR',
        'name' => 'ヴァルダク',
      ),
      32 => 
      array (
        'code' => 'ZAB',
        'name' => 'ザボール',
      ),
    ),
    'AI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AL' => 
    array (
      1 => 
      array (
        'code' => 'BR',
        'name' => 'ベラト',
      ),
      2 => 
      array (
        'code' => 'BU',
        'name' => 'ブルチザ',
      ),
      3 => 
      array (
        'code' => 'DI',
        'name' => 'ディブラ',
      ),
      4 => 
      array (
        'code' => 'DL',
        'name' => 'デルヴィナ',
      ),
      5 => 
      array (
        'code' => 'DR',
        'name' => 'ドゥラス',
      ),
      6 => 
      array (
        'code' => 'DV',
        'name' => 'デヴォル',
      ),
      7 => 
      array (
        'code' => 'EL',
        'name' => 'エルバサン',
      ),
      8 => 
      array (
        'code' => 'ER',
        'name' => 'コロニー',
      ),
      9 => 
      array (
        'code' => 'FR',
        'name' => 'フィエル',
      ),
      10 => 
      array (
        'code' => 'GJ',
        'name' => 'ジロカストラ',
      ),
      11 => 
      array (
        'code' => 'GR',
        'name' => 'グラムシ',
      ),
      12 => 
      array (
        'code' => 'HA',
        'name' => 'ハス',
      ),
      13 => 
      array (
        'code' => 'KA',
        'name' => 'カバジェ',
      ),
      14 => 
      array (
        'code' => 'KB',
        'name' => 'クルビン',
      ),
      15 => 
      array (
        'code' => 'KC',
        'name' => 'クチョヴェ',
      ),
      16 => 
      array (
        'code' => 'KO',
        'name' => 'コルチェ',
      ),
      17 => 
      array (
        'code' => 'KR',
        'name' => 'クルエ',
      ),
      18 => 
      array (
        'code' => 'KU',
        'name' => 'クケス',
      ),
      19 => 
      array (
        'code' => 'LB',
        'name' => 'リブラジド',
      ),
      20 => 
      array (
        'code' => 'LE',
        'name' => 'レジャ',
      ),
      21 => 
      array (
        'code' => 'LU',
        'name' => 'ルシュニャ',
      ),
      22 => 
      array (
        'code' => 'MK',
        'name' => 'マラカスタル',
      ),
      23 => 
      array (
        'code' => 'MM',
        'name' => 'マレスィア・エ・マヅェ',
      ),
      24 => 
      array (
        'code' => 'MR',
        'name' => 'ミルディタ',
      ),
      25 => 
      array (
        'code' => 'MT',
        'name' => 'マト',
      ),
      26 => 
      array (
        'code' => 'PG',
        'name' => 'ポグラデツ',
      ),
      27 => 
      array (
        'code' => 'PQ',
        'name' => 'ペチン',
      ),
      28 => 
      array (
        'code' => 'PR',
        'name' => 'ペルメト',
      ),
      29 => 
      array (
        'code' => 'PU',
        'name' => 'プケ',
      ),
      30 => 
      array (
        'code' => 'SH',
        'name' => 'シュコドラ',
      ),
      31 => 
      array (
        'code' => 'SK',
        'name' => 'スクラパル',
      ),
      32 => 
      array (
        'code' => 'SR',
        'name' => 'サランダ',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AQ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BB' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BD' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BJ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CV' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'Country' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '合衆国',
      ),
    ),
    'DE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'DJ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'DK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'DM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'DO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'DZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => 'EBA',
        'name' => 'エル・バヤード',
      ),
      18 => 
      array (
        'code' => 'EOU',
        'name' => 'エル・ウェッド',
      ),
      19 => 
      array (
        'code' => 'ETA',
        'name' => 'エル・タルフ',
      ),
      20 => 
      array (
        'code' => 'GHA',
        'name' => 'ガルダイア',
      ),
      21 => 
      array (
        'code' => 'GUE',
        'name' => 'ゲルマ',
      ),
      22 => 
      array (
        'code' => 'ILL',
        'name' => 'イリジ',
      ),
      23 => 
      array (
        'code' => 'JIJ',
        'name' => 'ジジェル',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'EC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'EE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'EG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ER' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ES' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ET' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FJ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FX' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
      82 => 
      array (
        'code' => '',
        'name' => '',
      ),
      83 => 
      array (
        'code' => '',
        'name' => '',
      ),
      84 => 
      array (
        'code' => '',
        'name' => '',
      ),
      85 => 
      array (
        'code' => '',
        'name' => '',
      ),
      86 => 
      array (
        'code' => '',
        'name' => '',
      ),
      87 => 
      array (
        'code' => '',
        'name' => '',
      ),
      88 => 
      array (
        'code' => '',
        'name' => '',
      ),
      89 => 
      array (
        'code' => '',
        'name' => '',
      ),
      90 => 
      array (
        'code' => '',
        'name' => '',
      ),
      91 => 
      array (
        'code' => '',
        'name' => '',
      ),
      92 => 
      array (
        'code' => '',
        'name' => '',
      ),
      93 => 
      array (
        'code' => '',
        'name' => '',
      ),
      94 => 
      array (
        'code' => '',
        'name' => '',
      ),
      95 => 
      array (
        'code' => '',
        'name' => '',
      ),
      96 => 
      array (
        'code' => '',
        'name' => '',
      ),
      97 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GB' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => 'EDIN',
        'name' => 'エディンバラ',
      ),
      35 => 
      array (
        'code' => 'ESX',
        'name' => 'エセックス',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
      82 => 
      array (
        'code' => '',
        'name' => '',
      ),
      83 => 
      array (
        'code' => '',
        'name' => '',
      ),
      84 => 
      array (
        'code' => '',
        'name' => '',
      ),
      85 => 
      array (
        'code' => '',
        'name' => '',
      ),
      86 => 
      array (
        'code' => '',
        'name' => '',
      ),
      87 => 
      array (
        'code' => '',
        'name' => '',
      ),
      88 => 
      array (
        'code' => '',
        'name' => '',
      ),
      89 => 
      array (
        'code' => '',
        'name' => '',
      ),
      90 => 
      array (
        'code' => '',
        'name' => '',
      ),
      91 => 
      array (
        'code' => '',
        'name' => '',
      ),
      92 => 
      array (
        'code' => '',
        'name' => '',
      ),
      93 => 
      array (
        'code' => '',
        'name' => '',
      ),
      94 => 
      array (
        'code' => '',
        'name' => '',
      ),
      95 => 
      array (
        'code' => '',
        'name' => '',
      ),
      96 => 
      array (
        'code' => '',
        'name' => '',
      ),
      97 => 
      array (
        'code' => '',
        'name' => '',
      ),
      98 => 
      array (
        'code' => '',
        'name' => '',
      ),
      99 => 
      array (
        'code' => '',
        'name' => '',
      ),
      100 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GQ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ID' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IQ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
      82 => 
      array (
        'code' => '',
        'name' => '',
      ),
      83 => 
      array (
        'code' => '',
        'name' => '',
      ),
      84 => 
      array (
        'code' => '',
        'name' => '',
      ),
      85 => 
      array (
        'code' => '',
        'name' => '',
      ),
      86 => 
      array (
        'code' => '',
        'name' => '',
      ),
      87 => 
      array (
        'code' => '',
        'name' => '',
      ),
      88 => 
      array (
        'code' => '',
        'name' => '',
      ),
      89 => 
      array (
        'code' => '',
        'name' => '',
      ),
      90 => 
      array (
        'code' => '',
        'name' => '',
      ),
      91 => 
      array (
        'code' => '',
        'name' => '',
      ),
      92 => 
      array (
        'code' => '',
        'name' => '',
      ),
      93 => 
      array (
        'code' => '',
        'name' => '',
      ),
      94 => 
      array (
        'code' => '',
        'name' => '',
      ),
      95 => 
      array (
        'code' => '',
        'name' => '',
      ),
      96 => 
      array (
        'code' => '',
        'name' => '',
      ),
      97 => 
      array (
        'code' => '',
        'name' => '',
      ),
      98 => 
      array (
        'code' => '',
        'name' => '',
      ),
      99 => 
      array (
        'code' => '',
        'name' => '',
      ),
      100 => 
      array (
        'code' => '',
        'name' => '',
      ),
      101 => 
      array (
        'code' => '',
        'name' => '',
      ),
      102 => 
      array (
        'code' => '',
        'name' => '',
      ),
      103 => 
      array (
        'code' => '',
        'name' => '',
      ),
      104 => 
      array (
        'code' => '',
        'name' => '',
      ),
      105 => 
      array (
        'code' => '',
        'name' => '',
      ),
      106 => 
      array (
        'code' => '',
        'name' => '',
      ),
      107 => 
      array (
        'code' => '',
        'name' => '',
      ),
      108 => 
      array (
        'code' => '',
        'name' => '',
      ),
      109 => 
      array (
        'code' => '',
        'name' => '',
      ),
      110 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'JM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'JO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'JP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LB' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LV' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MD' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
      82 => 
      array (
        'code' => '',
        'name' => '',
      ),
      83 => 
      array (
        'code' => '',
        'name' => '',
      ),
      84 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ML' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MQ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MV' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MX' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'OM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'QA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'RO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'RU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
      82 => 
      array (
        'code' => '',
        'name' => '',
      ),
      83 => 
      array (
        'code' => '',
        'name' => '',
      ),
      84 => 
      array (
        'code' => '',
        'name' => '',
      ),
      85 => 
      array (
        'code' => '',
        'name' => '',
      ),
      86 => 
      array (
        'code' => '',
        'name' => '',
      ),
      87 => 
      array (
        'code' => '',
        'name' => '',
      ),
      88 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'RW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SB' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SD' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ST' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SV' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TD' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TJ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TV' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'UA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'UG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'UM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'US' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'UY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'UZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'VC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'VE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'VI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'VN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'VU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'WF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'WS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'YE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'YT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'YU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ZA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ZM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ZR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ZW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    86 => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
  ),
  'dnb_job_codes' => 
  array (
    '' => '',
    'A045' => '',
    'A046' => '',
    'A047' => '',
    'A0A1' => '',
    'A0A2' => '',
    'A0A3' => '',
    'A0AA' => '',
    'A0AB' => '',
    'A0AC' => '',
    'A0AD' => '',
    'A0AE' => '',
    'A0AF' => '',
    'A0AG' => '',
    'A0AH' => '',
    'A0AI' => '',
    'A0AJ' => '',
    'A0AL' => '',
    'A0AM' => '',
    'A0AQ' => '',
    'A0AS' => '',
    'A0AT' => '',
    'A0AV' => '',
    'A0AY' => '',
    'A0AZ' => '',
    'A0GX' => '',
    'A0R0' => '',
    'A0R3' => '',
    'A117' => '',
    'A154' => '',
    'A189' => '',
    'A199' => '',
    'A1A4' => '',
    'A1A5' => '',
    'A1A6' => '',
    'A1A7' => '',
    'A1A8' => '',
    'A1A9' => '',
    'A1B0' => '',
    'A1B2' => '',
    'A1B3' => '',
    'A1B4' => '',
    'A1B5' => '',
    'A1BA' => 'チェアマン',
    'A1BB' => '',
    'A1BD' => '',
    'A1BE' => '',
    'A1BF' => '',
    'A1BH' => '',
    'A1BI' => '',
    'A1BJ' => '',
    'A1BO' => '',
    'A1BP' => '',
    'A1BU' => '',
    'A1BV' => '',
    'A1BX' => '',
    'A1BY' => '',
    'A1BZ' => '',
    'A1CA' => '',
    'A1CB' => '',
    'A1CG' => '',
    'A1CH' => '',
    'A1CJ' => '',
    'A1CK' => '',
    'A1CL' => '',
    'A1CN' => '',
    'A1CO' => '',
    'A1CP' => '',
    'A1CQ' => '',
    'A1CR' => '',
    'A1CS' => '',
    'A1CT' => '',
    'A1CU' => '',
    'A1CW' => '',
    'A1CX' => '',
    'A1CY' => '',
    'A1G7' => '取締役会',
    'A1R1' => '',
    'A2AP' => '',
    'A2D1' => '',
    'A2D2' => '',
    'A2IU' => '',
    'A2IV' => '',
    'A2IW' => '',
    'A2IX' => '',
    'A2IY' => '',
    'A2IZ' => '',
    'A589' => '',
    'A598' => '',
    'A599' => '',
    'A5D3' => '',
    'A5D4' => '',
    'A5D6' => '',
    'A5D7' => '',
    'A5D8' => '',
    'A5DL' => '',
    'A5DM' => '',
    'A5DN' => '',
    'A5DO' => '',
    'A5DP' => '',
    'A5DQ' => '',
    'A5DR' => '',
    'A5DS' => '',
    'A5DT' => '',
    'A5I5' => '',
    'A5I9' => '',
    'A615' => '',
    'A626' => '',
    'A627' => '',
    'A636' => '',
    'A644' => '',
    'A645' => '',
    'A646' => '',
    'A647' => '',
    'A655' => '',
    'A65A' => '',
    'A663' => '',
    'A689' => '',
    'A6A1' => '',
    'A6A2' => '',
    'A6AA' => '',
    'A6BA' => '',
    'A6BZ' => '',
    'A6C7' => '',
    'A6DU' => '',
    'A746' => '',
    'A789' => '',
    'A7DU' => '',
    'A8DV' => '',
    'A957' => '',
    'A998' => '',
    'A9CD' => '',
    'A9DW' => '',
    'A9DX' => '',
    'A9DY' => '',
    'A9DZ' => '',
    'A9EA' => '',
    'AB47' => '',
    'ABA1' => '',
    'ABA2' => '',
    'ABA3' => '',
    'ABA4' => '',
    'ABA5' => '',
    'ABA6' => '',
    'ABA7' => '',
    'ABAB' => '',
    'ABBA' => '',
    'ADA4' => '',
    'ADZ9' => '',
    'B0A1' => '',
    'B1EB' => '',
    'B1R2' => '',
    'B1R3' => '',
    'B5D0' => '',
    'B5E2' => '',
    'B5E6' => '',
    'B5F4' => '',
    'B618' => '',
    'B635' => '',
    'B699' => '',
    'B6EC' => '',
    'B6ED' => '',
    'B6EE' => '',
    'B6EF' => '',
    'B6EH' => '',
    'B6H2' => '',
    'B6H8' => '',
    'B6J3' => '',
    'B7AB' => '',
    'B7EI' => '',
    'B7EJ' => '',
    'B7EK' => '',
    'B7EL' => '',
    'B7J0' => '',
    'B7J1' => '',
    'B7J8' => '',
    'B7K0' => '',
    'B7K3' => '支店長',
    'B7L3' => '',
    'B7L4' => '',
    'B7M1' => '',
    'B7M2' => '',
    'B7N2' => '',
    'B7N6' => '',
    'B7P5' => '',
    'B7XA' => '',
    'B801' => '',
    'B806' => '',
    'B830' => '',
    'B899' => '',
    'B8B8' => '',
    'B914' => '',
    'B927' => '',
    'B928' => '',
    'B9EM' => '',
    'B9EN' => '',
    'B9EO' => '',
    'B9EP' => '',
    'B9EQ' => '',
    'B9ME' => '',
    'BB47' => '',
    'C1AC' => '',
    'C1C1' => '',
    'C1D9' => '',
    'C1DC' => '',
    'C2A1' => '',
    'C2A2' => '',
    'C2C1' => '',
    'C2P3' => '',
    'C599' => '',
    'C5E8' => '',
    'C601' => '',
    'C624' => '',
    'C699' => '',
    'C6G8' => '',
    'C6I3' => '',
    'C6J1' => '',
    'C6P9' => '',
    'C724' => '',
    'C799' => '',
    'C7BB' => '',
    'C7BC' => '',
    'C7C7' => '',
    'C7E8' => '',
    'C7H1' => '',
    'C7J1' => '',
    'C7K9' => '',
    'C7L5' => '',
    'C7N1' => '',
    'C7P7' => '',
    'C7P8' => '',
    'C7P9' => '',
    'C7X9' => '',
    'C7XZ' => '',
    'C899' => '',
    'C8B9' => '',
    'C8C8' => '',
    'C8CC' => 'ウェブ開発者',
    'C8CD' => '',
    'C8DC' => '',
    'C8DD' => '',
    'C8X1' => '',
    'C912' => '',
    'C918' => '',
    'C939' => '',
    'C940' => '',
    'C941' => '',
    'C999' => '',
    'C9A1' => '',
    'C9A2' => '',
    'C9A3' => '',
    'C9A4' => '',
    'C9A5' => '',
    'C9A6' => '',
    'C9A7' => '',
    'C9A8' => '',
    'C9A9' => '',
    'C9B1' => '',
    'C9B2' => 'ウェブマスター',
    'C9B3' => '',
    'C9B4' => '',
    'C9B5' => 'ビジネスアナリスト',
    'C9B6' => '',
    'C9B7' => '',
    'C9B8' => '',
    'C9B9' => '',
    'C9CX' => '',
    'C9ER' => '',
    'C9F8' => '',
    'C9P3' => '',
    'C9X1' => '',
    'C9XZ' => '',
    'D2C2' => '',
    'D599' => '',
    'D5E4' => '',
    'D5E5' => '',
    'D5G1' => '',
    'D699' => '',
    'D6ET' => '',
    'D6EZ' => '',
    'D6O0' => '',
    'D799' => '',
    'D7EU' => '',
    'D7EV' => '',
    'D7EW' => '',
    'D7EX' => '',
    'D7EY' => '',
    'D7EZ' => '',
    'D7L1' => '',
    'D7L7' => '',
    'D7M5' => '',
    'D7O0' => '',
    'D7O1' => '',
    'D7O4' => '',
    'D899' => '',
    'D901' => '',
    'D915' => '',
    'D916' => '',
    'D917' => '',
    'D918' => '',
    'D963' => '',
    'D999' => '',
    'D9EZ' => '',
    'D9FA' => '',
    'D9FB' => '',
    'D9FC' => '',
    'D9FD' => '',
    'D9FE' => '',
    'D9IU' => '',
    'D9X1' => '',
    'D9X9' => '',
    'DZ25' => '',
    'E1FF' => '',
    'E2C4' => '',
    'E5D9' => '',
    'E5E5' => '',
    'E6D9' => '',
    'E6FG' => '',
    'E6FH' => '',
    'E6FI' => '',
    'E6G4' => '',
    'E7FE' => '',
    'E7FF' => '',
    'E7FJ' => '',
    'E7G2' => '',
    'E7J7' => '',
    'E7K1' => '',
    'E7K4' => 'ビジネスマネージャー',
    'E7K7' => '',
    'E7K9' => '',
    'E7L9' => '',
    'E7P9' => '',
    'E7S9' => '',
    'E899' => '',
    'E8Q6' => '',
    'E8Q9' => '',
    'E901' => '',
    'E902' => '',
    'E903' => '',
    'E906' => '',
    'E908' => '',
    'E909' => '',
    'E917' => '',
    'E920' => '',
    'E944' => '',
    'E999' => '',
    'E9E6' => '',
    'E9E7' => '',
    'E9E9' => '',
    'E9FK' => '',
    'E9FL' => '',
    'E9FM' => '',
    'E9FN' => '',
    'E9FO' => '',
    'E9FP' => '',
    'E9FQ' => '',
    'E9FR' => '',
    'E9FS' => '',
    'E9FZ' => '',
    'EZ20' => '',
    'F2A9' => '',
    'F2C9' => '',
    'F599' => '',
    'F5E7' => '',
    'F6FV' => '',
    'F6G0' => '',
    'F6H4' => '',
    'F6H5' => '',
    'F6I6' => '',
    'F6J5' => '',
    'F6J6' => '',
    'F7B1' => '',
    'F7FF' => '',
    'F7FR' => '',
    'F7FS' => '',
    'F7FT' => '',
    'F7FU' => '',
    'F7FV' => '',
    'F7K2' => '',
    'F7K5' => '',
    'F7L6' => '',
    'F7M4' => '',
    'F7M6' => '',
    'F7N5' => '',
    'F7Q2' => '',
    'F7Q3' => '',
    'F898' => '',
    'F899' => '',
    'F8C9' => '',
    'F8Z8' => '',
    'F8Z9' => '',
    'F8ZZ' => '',
    'F9B1' => '',
    'F9FV' => '',
    'F9FW' => '',
    'F9Q2' => '',
    'G299' => '',
    'G599' => '',
    'G5F0' => '',
    'G629' => '',
    'G698' => '',
    'G699' => '',
    'G6I9' => '',
    'G798' => '',
    'G7O6' => '',
    'G899' => '',
    'G906' => '',
    'G907' => 'バイヤー',
    'G933' => '',
    'G989' => '',
    'G9FX' => '',
    'H2C8' => '',
    'H599' => '',
    'H5F1' => '',
    'H5F5' => '',
    'H5F8' => '',
    'H699' => '',
    'H6FY' => '',
    'H6H9' => '',
    'H6I0' => '',
    'H6I1' => '',
    'H6I7' => '',
    'H6J4' => '',
    'H6O7' => '',
    'H799' => '',
    'H7A0' => '',
    'H7B7' => '',
    'H7D5' => '',
    'H7FZ' => '',
    'H7GA' => '',
    'H7H7' => '',
    'H7H9' => '',
    'H7I0' => '',
    'H7L0' => '',
    'H7L2' => '',
    'H7M0' => '',
    'H7M7' => '',
    'H7N3' => '',
    'H7N4' => '',
    'H7N8' => '',
    'H7N9' => '',
    'H7O3' => '',
    'H7O7' => '',
    'H7P3' => '',
    'H7Q1' => '',
    'H918' => '',
    'H920' => '',
    'H924' => '',
    'H928' => '',
    'H929' => '',
    'H930' => '',
    'H9E7' => '',
    'H9GA' => '',
    'H9GB' => '',
    'H9GC' => '',
    'H9GD' => '',
    'H9GE' => '',
    'H9GF' => '',
    'H9GG' => '',
    'H9P3' => '',
    'I199' => '',
    'I1A7' => 'コールセンターマネージャー',
    'I1A8' => '',
    'I1A9' => '',
    'I1X7' => '',
    'I2A1' => '',
    'I2A3' => '',
    'I2B9' => '',
    'I2C0' => '',
    'I2I1' => '',
    'I599' => '',
    'I5A1' => '',
    'I5A2' => '',
    'I5E1' => '',
    'I5F2' => '',
    'I5F3' => '',
    'I5F7' => '',
    'I5G2' => '',
    'I5H1' => '',
    'I5I1' => '',
    'I699' => '',
    'I6A1' => '',
    'I6A2' => '',
    'I6A3' => '',
    'I6G6' => '',
    'I6H0' => '',
    'I6H1' => '',
    'I6I1' => '',
    'I6J2' => '',
    'I6K2' => '',
    'I6K8' => '',
    'I799' => '',
    'I7A1' => '',
    'I7A2' => '',
    'I7A3' => '',
    'I7A4' => '',
    'I7B1' => '',
    'I7H1' => '',
    'I7I1' => '',
    'I7J9' => '',
    'I7K2' => '',
    'I7K8' => '',
    'I7M9' => '',
    'I7N0' => '',
    'I7O2' => '',
    'I7O9' => '',
    'I7P1' => '',
    'I7P2' => '',
    'I889' => '',
    'I898' => '',
    'I899' => '',
    'I998' => '',
    'I999' => '',
    'I9A1' => '',
    'I9A2' => '',
    'I9A3' => '',
    'I9A4' => '',
    'I9D8' => '',
    'I9GH' => '',
    'I9GI' => '',
    'I9GJ' => '',
    'I9GK' => '',
    'I9GL' => '',
    'I9GM' => '',
    'I9GN' => '',
    'I9H1' => '',
    'I9I1' => '',
    'I9I2' => '',
    'I9I3' => '',
    'I9I8' => '',
    'I9I9' => '',
    'I9K8' => '',
    'I9Z9' => 'コールセンタースタッフ',
    'I9ZX' => '',
    'J599' => '',
    'J699' => '',
    'J6E2' => '',
    'J6H7' => '',
    'J7GN' => '',
    'J7L8' => '',
    'J7M3' => '',
    'J7M8' => '',
    'J7N7' => '',
    'J7P0' => '',
    'J7Q3' => '',
    'J7ZZ' => '',
    'J899' => '',
    'J923' => '',
    'J999' => '',
    'J9GO' => '',
    'J9GP' => '',
    'K209' => '',
    'K601' => '',
    'K602' => '',
    'K656' => '',
    'K661' => '',
    'K670' => '',
    'K948' => '',
    'K949' => '',
    'K950' => '',
    'K951' => '',
    'K952' => '',
    'K953' => '',
    'K955' => '',
    'K960' => '',
    'K961' => '',
    'K962' => '',
    'K963' => '',
    'K964' => '',
    'K965' => '',
    'K966' => '',
    'K967' => '',
    'K968' => '',
    'K969' => '',
    'K989' => '',
    'K999' => '',
    'K9D7' => '',
    'L6A6' => '',
    'L935' => '',
    'L970' => '',
    'L971' => '',
    'L972' => '',
    'L973' => '',
    'L974' => '',
    'L975' => '',
    'L976' => '',
    'L977' => '',
    'L978' => '',
    'L979' => '',
    'L980' => '',
    'L981' => '',
    'L982' => '',
    'M1B1' => '',
    'M1B2' => '',
    'M622' => '',
    'M6E6' => '',
    'M6F6' => '',
    'M6I6' => '',
    'M7M6' => '',
    'M7M9' => '',
    'M7MZ' => '',
    'M8I6' => '',
    'M8I7' => '',
    'M901' => '',
    'M922' => '',
    'M983' => '',
    'M984' => '',
    'M985' => '',
    'M986' => '',
    'M987' => '',
    'M988' => '',
    'M989' => '',
    'M990' => '',
    'M999' => '',
    'M9M9' => '',
    'M9R3' => '',
    'M9R4' => '',
    'M9R5' => '',
    'N985' => '',
    'N986' => '',
    'N987' => '',
    'N988' => '',
    'N989' => '',
    'N990' => '',
    'N991' => '',
    'N992' => '',
    'N993' => '',
    'N994' => '',
    'N995' => '',
    'N996' => '',
    'N997' => '',
    'N998' => '',
    'N999' => 'キャプテン',
    'X1Z8' => '',
    'X626' => '',
    'X656' => '',
    'X6Z9' => '',
    'X746' => '',
    'X799' => '',
    'X7DZ' => '',
    'X7X7' => '',
    'X8X9' => '',
    'X901' => '',
    'X906' => '',
    'X930' => '',
    'X931' => '',
    'X956' => '',
    'X957' => '',
    'X9CD' => '',
    'XA01' => '',
    'XA02' => '',
    'XA99' => '',
    'XAA1' => '',
    'XAA2' => '',
    'XAB5' => '',
    'XABX' => '',
    'XAP0' => '',
    'XAP1' => '',
    'XAP2' => '',
    'XAP3' => '',
    'XAP4' => '',
    'XAP5' => '',
    'XAP6' => '',
    'XAP7' => '',
    'XAP8' => '',
    'XAP9' => '',
    'XAQ1' => '',
    'XAQ2' => '',
    'XAQ3' => '',
    'XAQ4' => '',
    'XAS0' => '',
    'XAS1' => '',
    'XAS2' => '',
    'XAS3' => '',
    'XAS4' => '',
    'XAS5' => '',
    'XAS6' => '',
    'XAS7' => '',
    'XAS8' => '',
    'XAS9' => '',
    'XAT0' => '',
    'XAT1' => '',
    'XAT2' => '',
    'XAT3' => '',
    'XAT4' => '',
    'XAT5' => '',
    'XAT6' => '',
    'XAT7' => '',
    'XAT8' => '',
    'XAT9' => '',
    'XAU0' => '',
    'XAU1' => '',
    'XAU2' => '',
    'XAU3' => '',
    'XAU4' => '',
    'XAU5' => '',
    'XAU6' => '',
    'XAU7' => '',
    'XAU8' => '',
    'XAU9' => '',
    'XAV0' => '',
    'XAV1' => '',
    'XAV2' => '',
    'XAV3' => '',
    'XAV4' => '',
    'XAV5' => '',
    'XAV6' => '',
    'XAV7' => '',
    'XAV8' => '',
    'XAXA' => '',
    'XAY5' => '',
    'XAY6' => '',
    'XAY7' => '',
    'XAY9' => '',
    'XAZ1' => '',
    'XAZ2' => '',
    'XAZ8' => '',
    'XAZ9' => '',
    'XB37' => '',
    'XB47' => '',
    'XB67' => '',
    'XB6M' => '',
    'XB98' => '',
    'XB99' => '',
    'XBA7' => '',
    'XBB2' => '',
    'XBB3' => '',
    'XBBB' => '',
    'XBC1' => '',
    'XBC2' => '',
    'XBC3' => '',
    'XBC4' => '',
    'XBC9' => '',
    'XBD1' => '',
    'XBD2' => '',
    'XBE1' => '',
    'XBE2' => '',
    'XBE3' => '',
    'XBE4' => '',
    'XBE5' => '',
    'XBF1' => '',
    'XBF2' => '',
    'XBF9' => '',
    'XBFB' => '',
    'XBFC' => '',
    'XBU1' => '',
    'XBV4' => '',
    'XBV9' => '',
    'XBW0' => '',
    'XBW3' => '',
    'XBXA' => '',
    'XBXB' => '',
    'XBXC' => '',
    'XBZ8' => '',
    'XBZ9' => '',
    'XBZZ' => '',
    'XD15' => '',
    'XD26' => '',
    'XD51' => '',
    'XD97' => '',
    'XD98' => '',
    'XD99' => '',
    'XDA2' => '',
    'XDA6' => '',
    'XDA7' => '',
    'XDW4' => '',
    'XDW5' => '',
    'XDW6' => '',
    'XDW7' => '',
    'XDW9' => '',
    'XDX0' => '',
    'XDX1' => '',
    'XDX2' => '',
    'XDX3' => '',
    'XDX4' => '',
    'XDX5' => '',
    'XDX6' => '',
    'XDX7' => '',
    'XDX8' => '',
    'XDX9' => '',
    'XDY0' => '',
    'XDY1' => '',
    'XDY2' => '',
    'XDY3' => '',
    'XDY4' => '',
    'XDY5' => '',
    'XDY6' => '',
    'XDZ9' => '',
    'XZ9L' => '',
    'XZA1' => '',
    'XZY8' => '',
    'Z1X1' => '',
    'Z2B7' => '',
    'Z2B8' => '',
    'Z2B9' => '',
    'Z2C3' => '',
    'Z2C5' => '',
    'Z2C6' => '',
    'Z5E9' => '',
    'Z642' => '',
    'Z698' => '',
    'Z699' => '',
    'Z6GQ' => '',
    'Z6H6' => '',
    'Z6H7' => '',
    'Z715' => '',
    'Z741' => '',
    'Z799' => '',
    'Z7F7' => '',
    'Z7GQ' => '',
    'Z7GR' => '',
    'Z7P4' => '',
    'Z823' => '',
    'Z856' => '',
    'Z888' => '',
    'Z889' => '',
    'Z899' => '',
    'Z8A8' => '',
    'Z8B9' => '',
    'Z8GT' => '',
    'Z8GU' => '',
    'Z8Q0' => '',
    'Z8Q7' => '',
    'Z8Q8' => '',
    'Z900' => '',
    'Z903' => '',
    'Z910' => '',
    'Z917' => '',
    'Z921' => '',
    'Z923' => '',
    'Z924' => '',
    'Z925' => '',
    'Z926' => '',
    'Z932' => '',
    'Z934' => '',
    'Z936' => '',
    'Z937' => '',
    'Z938' => '',
    'Z939' => '',
    'Z940' => '',
    'Z941' => '',
    'Z943' => '',
    'Z998' => '',
    'Z9GU' => '',
    'Z9GV' => '',
    'Z9GW' => '',
    'Z9GX' => '',
    'Z9GY' => '',
    'Z9GZ' => '',
    'Z9HA' => '',
    'Z9HB' => '',
    'Z9HC' => '',
    'Z9HD' => '',
    'Z9HG' => '',
    'Z9HH' => '',
    'Z9HI' => 'キャッシャー',
    'Z9HJ' => '',
    'Z9HK' => '',
    'Z9HL' => '',
    'Z9HM' => '',
    'Z9HN' => '',
    'Z9HQ' => '',
    'Z9HR' => '',
    'Z9HT' => '',
    'Z9HX' => '',
    'Z9HY' => '',
    'Z9HZ' => '',
    'Z9IA' => '',
    'Z9IB' => '',
    'Z9IC' => '',
    'Z9IF' => '',
    'Z9IG' => '',
    'Z9IH' => '',
    'Z9II' => '',
    'Z9IJ' => '',
    'Z9IK' => '',
    'Z9IL' => '',
    'Z9IM' => '',
    'Z9IO' => '',
    'Z9IQ' => '',
    'Z9IR' => '',
    'Z9IS' => '',
    'Z9IT' => '卸売',
    'ZA48' => '',
    'ZAA0' => '',
    'ZAA1' => '',
    'ZAA2' => '',
    'ZAA3' => '',
    'ZAA4' => '',
    'ZAA5' => '',
    'ZAA6' => '',
    'ZAA7' => '',
    'ZAAB' => '',
    'ZAV6' => '',
    'ZAV7' => '',
    'ZBXA' => '',
    'ZBXB' => '',
    'ZBZZ' => '',
  ),
);

