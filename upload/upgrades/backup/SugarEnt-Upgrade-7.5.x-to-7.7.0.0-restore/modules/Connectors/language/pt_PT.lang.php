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
  'ERROR_EMPTY_RECORD_ID' => 'Erro: Id do Registo não especificado ou vazio.',
  'ERROR_EMPTY_SOURCE_ID' => 'Erro: Id da Fonte não especificado ou vazio.',
  'ERROR_EMPTY_WRAPPER' => 'Erro: Incapaz de recuperar instância wrapper para a fonte [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Erro: Não foram encontrados detalhes adicionais para o registo.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Erro: Não existem conectores mapeados para este módulo.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Erro: Não existem campos de módulo que tenham sido mapeados para exibição nos resultados. Por favor contacte o administrador do sistema.',
  'ERROR_NO_FIELDS_MAPPED' => 'Erro: Deverá mapear pelo menos um campo de Conector a um campo de módulo para cada entrada de módulo.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Nenhuns módulos foram activados para este conector. Seleccione um módulo para este conector na página Activar Conectores.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Erro: Nenhum conector activo tem campos de pesquisa definidos.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Erro: Não existem campos de pesquisa definidos para o módulo e o conector. Por favor contacte o administrador do sistema.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Erro: Não foi encontrado o ficheiro sourcedefs.php.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Erro: Não foram especificadas as fontes para as quais se recuperam os dados.',
  'ERROR_RECORD_NOT_SELECTED' => 'Erro: Por favor seleccione um registo da lista antes de prosseguir.',
  'LBL_ADDRCITY' => 'Cidade',
  'LBL_ADDRCOUNTRY' => 'País',
  'LBL_ADDRCOUNTRY_ID' => 'Id País',
  'LBL_ADDRSTATEPROV' => 'Estado',
  'LBL_ADD_MODULE' => 'Adicionar',
  'LBL_ADMINISTRATION' => 'Administração do Conector',
  'LBL_ADMINISTRATION_MAIN' => 'Definições do Conector',
  'LBL_AVAILABLE' => 'Disponível',
  'LBL_BACK' => '< Voltar',
  'LBL_CLOSE' => 'Fechar',
  'LBL_COMPANY_ID' => 'Id Empresa',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Alguns campos obrigatórios foram deixados em branco. Prosseguir com a gravação das alterações?',
  'LBL_CONNECTOR' => 'Conector',
  'LBL_CONNECTOR_FIELDS' => 'Campos do Conector',
  'LBL_DATA' => 'Dados',
  'LBL_DEFAULT' => 'Padrão',
  'LBL_DELETE_MAPPING_ENTRY' => 'Tem a certeza que pretende eliminar esta entrada?',
  'LBL_DISABLED' => 'Desactivado',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Não foram encontrados resultados com os seus critérios de pesquisa.',
  'LBL_ENABLED' => 'Activado',
  'LBL_EXTERNAL' => 'Este conector permite aos utilizadores criar registos de uma conta externa. Para utilizar este conector, as suas propriedades deverão estar definidas na página &#39;Definir Propriedades do Conector&#39;.',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Para usar este conector, as propriedades também devem ser definidas na página de configurações Definir Propriedades do Conector.',
  'LBL_FINSALES' => 'Finsales',
  'LBL_INFO_INLINE' => 'Info',
  'LBL_MARKET_CAP' => 'Mercado de Capitalização',
  'LBL_MERGE' => 'Fusão',
  'LBL_MODIFY_DISPLAY_DESC' => 'Seleccionar os módulos que são activados para cada conector.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Definições do Conector: Activar Conectores',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Activar Conectores',
  'LBL_MODIFY_MAPPING_DESC' => 'Mapear campos de conector de modo a determinar que dados do conector possam ser visualizados e integrados nos registos do módulo.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Definições do Conector: Mapear Campos do Conector',
  'LBL_MODIFY_MAPPING_TITLE' => 'Mapear Campos do Conector',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Configurar as propriedades para cada conector, incluindo URLs e chaves API.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Definições do Conector: Definir Propriedades do Conector',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Definir Propriedades do Conector',
  'LBL_MODIFY_SEARCH' => 'Pesquisar',
  'LBL_MODIFY_SEARCH_DESC' => 'Seleccionar os campos do conector a utilizar na pesquisa por dados para cada módulo.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Definições do Conector: Gerir Pesquisa de Conector',
  'LBL_MODIFY_SEARCH_TITLE' => 'Gerir Pesquisa do Conector',
  'LBL_MODULE_FIELDS' => 'Campos do Módulo',
  'LBL_MODULE_NAME' => 'Conectores',
  'LBL_MODULE_NAME_SINGULAR' => 'Conector',
  'LBL_NO_PROPERTIES' => 'Não há propriedades configuráveis para este conector.',
  'LBL_PARENT_DUNS' => 'DUNS de Origem',
  'LBL_PREVIOUS' => '< Voltar',
  'LBL_QUOTE' => 'Cotação',
  'LBL_RECNAME' => 'Nome de Empresa',
  'LBL_RESET_BUTTON_TITLE' => 'Reiniciar [Alt+R]',
  'LBL_RESET_TO_DEFAULT' => 'Reiniciar para Padrão',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Tem a certeza que pretende reiniciar para a configuração padrão?',
  'LBL_RESULT_LIST' => 'Lista de Dados',
  'LBL_RUN_WIZARD' => 'Executar Assistente',
  'LBL_SAVE' => 'Gravar',
  'LBL_SEARCHING_BUTTON_LABEL' => 'A pesquisar...',
  'LBL_SHOW_IN_LISTVIEW' => 'Mostrar em Vista de Lista de Fusão',
  'LBL_SMART_COPY' => 'Cópia Inteligente',
  'LBL_STEP1' => 'Pesquisar e Visualizar Dados',
  'LBL_STEP2' => 'Fundir Registos com',
  'LBL_SUMMARY' => 'Resumo',
  'LBL_TEST_SOURCE' => 'Testar Conector',
  'LBL_TEST_SOURCE_FAILED' => 'Teste Falhou',
  'LBL_TEST_SOURCE_RUNNING' => 'A executar Teste...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Teste Bem Sucedido',
  'LBL_TITLE' => 'Fusão de Dados',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Ultimate Parent DUNS',
  'dnb_countries_iso' => 
  array (
    'AD' => 'Andorra',
    'AE' => 'Estados Unidos Árabes',
    'AF' => 'Afeganistão',
    'AG' => 'Antígua e Barbuda',
    'AI' => 'Anguilla',
    'AL' => 'Albânia',
    'AM' => 'Arménia',
    'AN' => 'Antilhas Holandesas',
    'AO' => 'Angola',
    'AQ' => 'Antártica',
    'AR' => 'Argentina',
    'AS' => 'Samoa Americana',
    'AT' => 'Áustria',
    'AU' => 'Austrália',
    'AW' => 'Aruba',
    'AZ' => 'Azerbaijão',
    'BA' => 'Bósnia e Herzegovina',
    'BB' => 'Barbados',
    'BD' => 'Bangladesh',
    'BE' => 'Bélgica',
    'BF' => 'Burkina Faso',
    'BG' => 'Bulgária',
    'BH' => 'Bahrein',
    'BI' => 'Burundi',
    'BJ' => 'Benim',
    'BM' => 'Bermudas',
    'BN' => 'Brunei',
    'BO' => 'Bolívia',
    'BR' => 'Brasil',
    'BS' => 'Bahamas',
    'BT' => 'Butão',
    'BV' => 'Ilha Bouvet',
    'BW' => 'Botswana',
    'BY' => 'Bielorrússia',
    'BZ' => 'Belize',
    'CA' => 'Canadá',
    'CC' => 'Ilhas Cocos (Keeling)',
    'CD' => 'República Democrática do Congo',
    'CF' => 'República Central Africana',
    'CG' => 'Congo',
    'CH' => 'Suíça',
    'CI' => 'Costa do Marfim',
    'CK' => 'Ilhas Cook',
    'CL' => 'Chile',
    'CM' => 'Camarões',
    'CN' => 'China',
    'CO' => 'Colômbia',
    'CR' => 'Costa Rica',
    'CU' => 'Cuba',
    'CV' => 'Cabo Verde',
    'CX' => 'Ilha do Natal',
    'CY' => 'Chipre',
    'CZ' => 'República Checa',
    'DE' => 'Alemanha',
    'DJ' => 'Jibuti',
    'DK' => 'Dinamarca',
    'DM' => 'Dominica',
    'DO' => 'República Dominicana',
    'DZ' => 'Argélia',
    'EC' => 'Equador',
    'EE' => 'Estónia',
    'EG' => 'Egipto',
    'EH' => 'Saara Ocidental',
    'ER' => 'Eritreia',
    'ES' => 'Espanha',
    'ET' => 'Etiópia',
    'FI' => 'Filândia',
    'FJ' => 'Fiji',
    'FK' => 'Ilhas Malvinas',
    'FM' => 'Micronésia',
    'FO' => 'Ilhas Faroé',
    'FR' => 'França',
    'FX' => 'França Metropolitana',
    'GA' => 'Gabão',
    'GB' => 'Reino Unido',
    'GD' => 'Granada',
    'GE' => 'Georgia',
    'GF' => 'Guiana Francesa',
    'GH' => 'Gana',
    'GI' => 'Gibraltar',
    'GL' => 'Gronelândia',
    'GM' => 'Gâmbia',
    'GN' => 'República da Guiné',
    'GP' => 'Guadalupe',
    'GQ' => 'Guiné Equatorial',
    'GR' => 'Grécia',
    'GS' => 'Ilhas Geórgia do Sul e Sandwich do Sul',
    'GT' => 'Guatemala',
    'GU' => 'Guame',
    'GW' => 'Guiné-Bissau',
    'GY' => 'República Cooperativa da Guiana',
    'HK' => 'Hong Kong',
    'HM' => 'Ilha Heard e McDonald',
    'HN' => 'Honduras',
    'HR' => 'Croácia',
    'HT' => 'Haiti',
    'HU' => 'Hungria',
    'ID' => 'Indonésia',
    'IE' => 'Irelanda',
    'IL' => 'Israel',
    'IN' => 'India',
    'IO' => 'Território Britânico do Oceano Índico',
    'IQ' => 'Iraque',
    'IR' => 'Irão',
    'IS' => 'Islândia',
    'IT' => 'Itália',
    'JM' => 'Jamaica',
    'JO' => 'Jordânia',
    'JP' => 'Japão',
    'KE' => 'Quénia',
    'KG' => 'Quirguistão',
    'KH' => 'Cambodja',
    'KI' => 'Quiribáti',
    'KM' => 'Comoros',
    'KN' => 'São Cristóvão e Nevis',
    'KP' => 'Coreia do Norte',
    'KR' => 'Coreia do Sul',
    'KW' => 'Kuwait',
    'KY' => 'Ilhas Caimão',
    'KZ' => 'Cazaquistão',
    'LA' => 'Laos',
    'LB' => 'Líbano',
    'LC' => 'Santa Lúcia',
    'LI' => 'Listenstaine',
    'LK' => 'Sri Lanka',
    'LR' => 'Libéria',
    'LS' => 'Lesoto',
    'LT' => 'Lituânia',
    'LU' => 'Luxemburgo',
    'LV' => 'Letónia',
    'LY' => 'Líbia',
    'MA' => 'Marrocos',
    'MC' => 'Mónaco',
    'MD' => 'Moldávia',
    'ME' => 'Montenegro',
    'MG' => 'Madagáscar',
    'MH' => 'Ilhas Marshall',
    'MK' => 'antiga República jugoslava da Macedónia',
    'ML' => 'Mali',
    'MM' => 'Birmânia',
    'MN' => 'Mongólia',
    'MO' => 'Macau',
    'MP' => 'Marianas Setentrionais',
    'MQ' => 'Martinica',
    'MR' => 'Mauritânia',
    'MS' => 'Monserrate',
    'MT' => 'Malta',
    'MU' => 'Maurícia',
    'MV' => 'Maldivas',
    'MW' => 'Maláui',
    'MX' => 'México',
    'MY' => 'Malásia',
    'MZ' => 'Moçambique',
    'NA' => 'Namíbia',
    'NC' => 'Nova Caledónia',
    'NE' => 'Níger',
    'NF' => 'Ilha Norfolk',
    'NG' => 'Nigéria',
    'NI' => 'Nicarágua',
    'NL' => 'Países Baixos',
    'NO' => 'Noruega',
    'NP' => 'Nepal',
    'NR' => 'Nauru',
    'NU' => 'Niuê',
    'NZ' => 'Nova Zelândia',
    'OM' => 'Oman',
    'PA' => 'Panamá',
    'PE' => 'Perú',
    'PF' => 'Polinésia Francesa',
    'PG' => 'Papua-Nova Guiné',
    'PH' => 'Filipinas',
    'PK' => 'Paquistão',
    'PL' => 'Polónia',
    'PM' => 'São Pedro e Miquelão',
    'PN' => 'Ilhas Pitcairn',
    'PR' => 'Porto Rico',
    'PS' => 'Palestina',
    'PT' => 'Portugal',
    'PW' => 'Palau',
    'PY' => 'Paraguai',
    'QA' => 'Catar',
    'RE' => 'Reunião',
    'RO' => 'Roménia',
    'RS' => 'Sérvia',
    'RU' => 'Rússia',
    'RW' => 'Ruanda',
    'SA' => 'Arábia Saudita',
    'SB' => 'Ilhas Salomão',
    'SC' => 'Seicheles',
    'SD' => 'Sudão',
    'SE' => 'Suécia',
    'SG' => 'Singapura',
    'SH' => 'Santa Helena',
    'SI' => 'Eslovénia',
    'SJ' => 'Ilhas Svalbard and Jan Mayen',
    'SK' => 'Eslováquia',
    'SL' => 'Serra Leoa',
    'SM' => 'San Marino',
    'SN' => 'Senegal',
    'SO' => 'Somália',
    'SR' => 'Suriname',
    'ST' => 'São Tomé and Príncipe',
    'SV' => 'El Salvador',
    'SY' => 'Síria',
    'SZ' => 'Suazilândia',
    'TC' => 'Ilhas Turcas e Caicos',
    'TD' => 'Chade',
    'TF' => 'Terras Austrais Francesas',
    'TG' => 'Togo',
    'TH' => 'Tailândia',
    'TJ' => 'Tajiquistão',
    'TK' => 'Toquelau',
    'TM' => 'Turquemenistão',
    'TN' => 'Tunísia',
    'TO' => 'Tonga',
    'TP' => 'Timor-Leste',
    'TR' => 'Turquia',
    'TT' => 'Trindade e Tobago',
    'TV' => 'Tuvalu',
    'TW' => 'República da China (Taiwan)',
    'TZ' => 'Tanzânia',
    'UA' => 'Ucrânia',
    'UG' => 'Uganda',
    'UM' => 'Ilhas Menores Distantes dos Estados Unidos',
    'US' => 'Estados Unidos',
    'UY' => 'Uruguai',
    'UZ' => 'Uzbequistão',
    'VA' => 'Cidade do Vaticano',
    'VC' => 'São Vicente e Granadinas',
    'VE' => 'Venezuela',
    'VG' => 'Ilhas Virgens Britânicas',
    'VI' => 'Ilhas Virgens Americanas',
    'VN' => 'Vietname',
    'VU' => 'Vanuatu',
    'WF' => 'Ilhas Wallis and Futuna',
    'WS' => 'Samoa',
    'YE' => 'Iémen',
    'YT' => 'Maiote',
    'ZA' => 'África do Sul',
    'ZM' => 'Zâmbia',
    'ZW' => 'Zimbábue',
  ),
  'dnb_states_iso' => 
  array (
    'AD' => 
    array (
      1 => 
      array (
        'code' => 'ALV',
        'name' => 'Andorra la Vella',
      ),
      2 => 
      array (
        'code' => 'CAN',
        'name' => 'Canillo',
      ),
      3 => 
      array (
        'code' => 'ENC',
        'name' => 'Encamp',
      ),
      4 => 
      array (
        'code' => 'ESE',
        'name' => 'Escaldes-Engordany',
      ),
      5 => 
      array (
        'code' => 'LMA',
        'name' => 'La Massana',
      ),
      6 => 
      array (
        'code' => 'ORD',
        'name' => 'Ordino',
      ),
      7 => 
      array (
        'code' => 'SJL',
        'name' => 'Sant Julià de Lòria',
      ),
    ),
    'AE' => 
    array (
      1 => 
      array (
        'code' => 'AZ',
        'name' => 'Abu Zaby',
      ),
      2 => 
      array (
        'code' => 'AJ',
        'name' => '',
      ),
      3 => 
      array (
        'code' => 'FU',
        'name' => 'Al Fujayrah',
      ),
      4 => 
      array (
        'code' => 'SH',
        'name' => 'Ash Shariqah',
      ),
      5 => 
      array (
        'code' => 'DU',
        'name' => 'Dubayy',
      ),
      6 => 
      array (
        'code' => 'RK',
        'name' => '',
      ),
      7 => 
      array (
        'code' => 'UQ',
        'name' => 'Umm al Qaywayn',
      ),
    ),
    'AF' => 
    array (
      1 => 
      array (
        'code' => 'BAL',
        'name' => 'Balkh',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => 'Bamian',
      ),
      3 => 
      array (
        'code' => 'BDG',
        'name' => 'Badghis',
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
        'name' => 'Farah',
      ),
      7 => 
      array (
        'code' => 'FYB',
        'name' => 'Faryab',
      ),
      8 => 
      array (
        'code' => 'GHA',
        'name' => 'Ghazni',
      ),
      9 => 
      array (
        'code' => 'GHO',
        'name' => 'Ghowr',
      ),
      10 => 
      array (
        'code' => 'HEL',
        'name' => 'Helmand',
      ),
      11 => 
      array (
        'code' => 'HER',
        'name' => 'Herat',
      ),
      12 => 
      array (
        'code' => 'JOW',
        'name' => 'Jowzjan',
      ),
      13 => 
      array (
        'code' => 'KAB',
        'name' => 'Kabul',
      ),
      14 => 
      array (
        'code' => 'KAN',
        'name' => 'Kandahar',
      ),
      15 => 
      array (
        'code' => 'KAP',
        'name' => 'Kapisa',
      ),
      16 => 
      array (
        'code' => 'KDZ',
        'name' => 'Kondoz',
      ),
      17 => 
      array (
        'code' => 'KHO',
        'name' => 'Khost',
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
        'name' => 'Nimruz',
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
        'name' => 'Parwan',
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
        'name' => 'Sar-e Pol',
      ),
      30 => 
      array (
        'code' => 'TAK',
        'name' => 'Takhar',
      ),
      31 => 
      array (
        'code' => 'WAR',
        'name' => 'Wardak',
      ),
      32 => 
      array (
        'code' => 'ZAB',
        'name' => 'Zabol',
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
        'name' => 'Anguila',
      ),
      3 => 
      array (
        'code' => 'DOG',
        'name' => 'Dog',
      ),
      4 => 
      array (
        'code' => 'LIT',
        'name' => 'Little Scrub',
      ),
      5 => 
      array (
        'code' => 'PRI',
        'name' => 'Prickly Pear',
      ),
      6 => 
      array (
        'code' => 'SAN',
        'name' => 'Sandy',
      ),
      7 => 
      array (
        'code' => 'SCR',
        'name' => 'Scrub',
      ),
      8 => 
      array (
        'code' => 'SEA',
        'name' => 'Seal',
      ),
      9 => 
      array (
        'code' => 'SOM',
        'name' => 'Sombrero',
      ),
    ),
    'AL' => 
    array (
      1 => 
      array (
        'code' => 'BR',
        'name' => 'Berat',
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
        'name' => 'Durres',
      ),
      6 => 
      array (
        'code' => 'DV',
        'name' => 'Devoll',
      ),
      7 => 
      array (
        'code' => 'EL',
        'name' => 'Elbasan',
      ),
      8 => 
      array (
        'code' => 'ER',
        'name' => 'Kolonje',
      ),
      9 => 
      array (
        'code' => 'FR',
        'name' => 'Fier',
      ),
      10 => 
      array (
        'code' => 'GJ',
        'name' => 'Gjirokaster',
      ),
      11 => 
      array (
        'code' => 'GR',
        'name' => 'Gramsh',
      ),
      12 => 
      array (
        'code' => 'HA',
        'name' => 'Has',
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
        'name' => 'Korce',
      ),
      17 => 
      array (
        'code' => 'KR',
        'name' => 'Kruje',
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
        'name' => 'Malesi e Madhe',
      ),
      24 => 
      array (
        'code' => 'MR',
        'name' => 'Mirdite',
      ),
      25 => 
      array (
        'code' => 'MT',
        'name' => 'Mat',
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
        'name' => 'Puke',
      ),
      30 => 
      array (
        'code' => 'SH',
        'name' => 'Shkoder',
      ),
      31 => 
      array (
        'code' => 'SK',
        'name' => 'Skrapar',
      ),
      32 => 
      array (
        'code' => 'SR',
        'name' => 'Sarande',
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
        'name' => 'Tirane',
      ),
      36 => 
      array (
        'code' => 'VL',
        'name' => 'Vlore',
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
        'name' => 'Ararat',
      ),
      3 => 
      array (
        'code' => 'ARM',
        'name' => 'Armavir',
      ),
      4 => 
      array (
        'code' => 'GEG',
        'name' => '',
      ),
      5 => 
      array (
        'code' => 'KOT',
        'name' => '',
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
        'name' => '',
      ),
      11 => 
      array (
        'code' => 'YER',
        'name' => 'Yerevan',
      ),
    ),
    'AN' => 
    array (
      1 => 
      array (
        'code' => 'BON',
        'name' => 'Bonaire',
      ),
      2 => 
      array (
        'code' => 'CUR',
        'name' => 'Curaçao',
      ),
      3 => 
      array (
        'code' => 'SAB',
        'name' => 'Saba',
      ),
      4 => 
      array (
        'code' => 'SEU',
        'name' => 'Sint Eustatius',
      ),
      5 => 
      array (
        'code' => 'SMA',
        'name' => 'Sint Maarten',
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
        'name' => 'Benguela',
      ),
      3 => 
      array (
        'code' => 'BIE',
        'name' => 'Bie',
      ),
      4 => 
      array (
        'code' => 'CAB',
        'name' => 'Cabinda',
      ),
      5 => 
      array (
        'code' => 'CCU',
        'name' => 'Cuando-Cubango',
      ),
      6 => 
      array (
        'code' => 'CNO',
        'name' => 'Cuanza Norte',
      ),
      7 => 
      array (
        'code' => 'CUS',
        'name' => 'Cuanza Sul',
      ),
      8 => 
      array (
        'code' => 'CNN',
        'name' => 'Cunene',
      ),
      9 => 
      array (
        'code' => 'HUA',
        'name' => 'Huambo',
      ),
      10 => 
      array (
        'code' => 'HUI',
        'name' => 'Huila',
      ),
      11 => 
      array (
        'code' => 'LUA',
        'name' => 'Luanda',
      ),
      12 => 
      array (
        'code' => 'LNO',
        'name' => 'Lunda Norte',
      ),
      13 => 
      array (
        'code' => 'LSU',
        'name' => 'Lunda Sul',
      ),
      14 => 
      array (
        'code' => 'MAL',
        'name' => 'Malange',
      ),
      15 => 
      array (
        'code' => 'MOX',
        'name' => 'Moxico',
      ),
      16 => 
      array (
        'code' => 'NAM',
        'name' => 'Namibe',
      ),
      17 => 
      array (
        'code' => 'UIG',
        'name' => 'Uige',
      ),
      18 => 
      array (
        'code' => 'ZAI',
        'name' => 'Zaire',
      ),
    ),
    'AQ' => 
    array (
      1 => 
      array (
        'code' => 'ASG',
        'name' => 'Saint George',
      ),
      2 => 
      array (
        'code' => 'ASH',
        'name' => 'Saint Philip',
      ),
      3 => 
      array (
        'code' => 'ASJ',
        'name' => 'Saint John',
      ),
      4 => 
      array (
        'code' => 'ASL',
        'name' => 'Saint Paul',
      ),
      5 => 
      array (
        'code' => 'ASM',
        'name' => 'Saint Mary',
      ),
      6 => 
      array (
        'code' => 'ASR',
        'name' => 'Saint Peter',
      ),
      7 => 
      array (
        'code' => 'BAR',
        'name' => 'Barbuda',
      ),
      8 => 
      array (
        'code' => 'RED',
        'name' => 'Redonda',
      ),
    ),
    'AR' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Antartida e Islas del Atlantico',
      ),
      2 => 
      array (
        'code' => 'BA',
        'name' => 'Buenos Aires',
      ),
      3 => 
      array (
        'code' => 'CA',
        'name' => 'Catamarca',
      ),
      4 => 
      array (
        'code' => 'CH',
        'name' => 'Chaco',
      ),
      5 => 
      array (
        'code' => 'CU',
        'name' => 'Chubut',
      ),
      6 => 
      array (
        'code' => 'CO',
        'name' => 'Cordoba',
      ),
      7 => 
      array (
        'code' => 'CR',
        'name' => 'Corrientes',
      ),
      8 => 
      array (
        'code' => 'CF',
        'name' => 'Capital Federal',
      ),
      9 => 
      array (
        'code' => 'ER',
        'name' => 'Entre Rios',
      ),
      10 => 
      array (
        'code' => 'FO',
        'name' => 'Formosa',
      ),
      11 => 
      array (
        'code' => 'JU',
        'name' => 'Jujuy',
      ),
      12 => 
      array (
        'code' => 'LP',
        'name' => 'La Pampa',
      ),
      13 => 
      array (
        'code' => 'LR',
        'name' => 'La Rioja',
      ),
      14 => 
      array (
        'code' => 'ME',
        'name' => 'Mendoza',
      ),
      15 => 
      array (
        'code' => 'MI',
        'name' => 'Misiones',
      ),
      16 => 
      array (
        'code' => 'NE',
        'name' => 'Neuquen',
      ),
      17 => 
      array (
        'code' => 'RN',
        'name' => 'Rio Negro',
      ),
      18 => 
      array (
        'code' => 'SA',
        'name' => 'Salta',
      ),
      19 => 
      array (
        'code' => 'SJ',
        'name' => 'San Juan',
      ),
      20 => 
      array (
        'code' => 'SL',
        'name' => 'San Luis',
      ),
      21 => 
      array (
        'code' => 'SC',
        'name' => 'Santa Cruz',
      ),
      22 => 
      array (
        'code' => 'SF',
        'name' => 'Santa Fe',
      ),
      23 => 
      array (
        'code' => 'SD',
        'name' => 'Santiago del Estero',
      ),
      24 => 
      array (
        'code' => 'TF',
        'name' => 'Tierra del Fuego',
      ),
      25 => 
      array (
        'code' => 'TU',
        'name' => 'Tucuman',
      ),
    ),
    'AS' => 
    array (
      1 => 
      array (
        'code' => 'E',
        'name' => 'Eastern',
      ),
      2 => 
      array (
        'code' => 'M',
        'name' => '',
      ),
      3 => 
      array (
        'code' => 'R',
        'name' => 'Rose Island',
      ),
      4 => 
      array (
        'code' => 'S',
        'name' => 'Swains Island',
      ),
      5 => 
      array (
        'code' => 'W',
        'name' => 'Western',
      ),
    ),
    'AT' => 
    array (
      1 => 
      array (
        'code' => 'BUR',
        'name' => 'Burgenland',
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
        'name' => 'Salzburg',
      ),
      6 => 
      array (
        'code' => 'STE',
        'name' => 'Steiermark',
      ),
      7 => 
      array (
        'code' => 'TIR',
        'name' => 'Tirol',
      ),
      8 => 
      array (
        'code' => 'VOR',
        'name' => 'Vorarlberg',
      ),
      9 => 
      array (
        'code' => 'WIE',
        'name' => 'Wien',
      ),
    ),
    'AU' => 
    array (
      1 => 
      array (
        'code' => 'ACT',
        'name' => 'Australian Capital Territory',
      ),
      2 => 
      array (
        'code' => 'NSW',
        'name' => 'New South Wales',
      ),
      3 => 
      array (
        'code' => 'NT',
        'name' => 'Northern Territory',
      ),
      4 => 
      array (
        'code' => 'QLD',
        'name' => 'Queensland',
      ),
      5 => 
      array (
        'code' => 'SA',
        'name' => 'South Australia',
      ),
      6 => 
      array (
        'code' => 'TAS',
        'name' => 'Tasmania',
      ),
      7 => 
      array (
        'code' => 'VIC',
        'name' => 'Victoria',
      ),
      8 => 
      array (
        'code' => 'WA',
        'name' => 'Western Australia',
      ),
    ),
    'AW' => 
    array (
      1 => 
      array (
        'code' => 'ARU',
        'name' => 'Aruba',
      ),
      2 => 
      array (
        'code' => 'DRU',
        'name' => 'Druif Beach',
      ),
      3 => 
      array (
        'code' => 'MAN',
        'name' => 'Manchebo Beach',
      ),
      4 => 
      array (
        'code' => 'NOO',
        'name' => 'Noord',
      ),
      5 => 
      array (
        'code' => 'ORA',
        'name' => 'Oranjestad',
      ),
      6 => 
      array (
        'code' => 'PAL',
        'name' => 'Palm Beach',
      ),
      7 => 
      array (
        'code' => 'ROO',
        'name' => 'Rooi Thomas',
      ),
      8 => 
      array (
        'code' => 'SIN',
        'name' => 'Sint Nicolaas',
      ),
      9 => 
      array (
        'code' => 'SIN',
        'name' => 'Sint Nicolas',
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
        'name' => 'Ali Bayramli',
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
        'name' => 'Astara',
      ),
      9 => 
      array (
        'code' => 'BA',
        'name' => 'Baki',
      ),
      10 => 
      array (
        'code' => 'BAB',
        'name' => 'BabAk',
      ),
      11 => 
      array (
        'code' => 'BAL',
        'name' => 'BalakAn',
      ),
      12 => 
      array (
        'code' => 'BAR',
        'name' => 'BArdA',
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
        'name' => 'Fuzuli',
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
        'name' => 'Lankaran',
      ),
      31 => 
      array (
        'code' => 'LAC',
        'name' => 'Lacin',
      ),
      32 => 
      array (
        'code' => 'LAN',
        'name' => 'Lankaran',
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
        'name' => 'Oguz',
      ),
      40 => 
      array (
        'code' => 'ORD',
        'name' => 'Ordubad',
      ),
      41 => 
      array (
        'code' => 'QAB',
        'name' => 'Qabala',
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
        'name' => 'Saki',
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
        'name' => 'Saki',
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
        'name' => 'Susa',
      ),
      62 => 
      array (
        'code' => 'SUS',
        'name' => 'Susa',
      ),
      63 => 
      array (
        'code' => 'TAR',
        'name' => 'Tartar',
      ),
      64 => 
      array (
        'code' => 'TOV',
        'name' => 'Tovuz',
      ),
      65 => 
      array (
        'code' => 'UCA',
        'name' => 'Ucar',
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
        'name' => 'Xizi',
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
        'name' => 'Brcko district',
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
        'name' => 'Kanton Sarajevo',
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
        'name' => 'Zapadnohercegovacka Zupanija',
      ),
      12 => 
      array (
        'code' => 'SBI',
        'name' => 'Bijeljina',
      ),
      13 => 
      array (
        'code' => 'SBL',
        'name' => 'Banja Luka',
      ),
      14 => 
      array (
        'code' => 'SDO',
        'name' => 'Doboj',
      ),
      15 => 
      array (
        'code' => 'SFO',
        'name' => 'Foca',
      ),
      16 => 
      array (
        'code' => 'SSR',
        'name' => 'Sarajevo-Romanija or Sokolac',
      ),
      17 => 
      array (
        'code' => 'STR',
        'name' => 'Trebinje',
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
        'name' => 'Christ Church',
      ),
      2 => 
      array (
        'code' => 'AND',
        'name' => 'Saint Andrew',
      ),
      3 => 
      array (
        'code' => 'GEO',
        'name' => 'Saint George',
      ),
      4 => 
      array (
        'code' => 'JAM',
        'name' => 'Saint James',
      ),
      5 => 
      array (
        'code' => 'JOH',
        'name' => 'Saint John',
      ),
      6 => 
      array (
        'code' => 'JOS',
        'name' => 'Saint Joseph',
      ),
      7 => 
      array (
        'code' => 'LUC',
        'name' => 'Saint Lucy',
      ),
      8 => 
      array (
        'code' => 'MIC',
        'name' => 'Saint Michael',
      ),
      9 => 
      array (
        'code' => 'PET',
        'name' => 'Saint Peter',
      ),
      10 => 
      array (
        'code' => 'PHI',
        'name' => 'Saint Philip',
      ),
      11 => 
      array (
        'code' => 'THO',
        'name' => 'Saint Thomas',
      ),
    ),
    'BD' => 
    array (
      1 => 
      array (
        'code' => 'BAR',
        'name' => 'Barisal',
      ),
      2 => 
      array (
        'code' => 'CHI',
        'name' => 'Chittagong',
      ),
      3 => 
      array (
        'code' => 'DHA',
        'name' => 'Dhaka',
      ),
      4 => 
      array (
        'code' => 'KHU',
        'name' => 'Khulna',
      ),
      5 => 
      array (
        'code' => 'RAJ',
        'name' => 'Rajshahi',
      ),
      6 => 
      array (
        'code' => 'SYL',
        'name' => 'Sylhet',
      ),
    ),
    'BE' => 
    array (
      1 => 
      array (
        'code' => 'VAN',
        'name' => 'Antwerpen',
      ),
      2 => 
      array (
        'code' => 'WBR',
        'name' => 'Brabant Wallon',
      ),
      3 => 
      array (
        'code' => 'WHT',
        'name' => 'Hainaut',
      ),
      4 => 
      array (
        'code' => 'WLG',
        'name' => 'Liege',
      ),
      5 => 
      array (
        'code' => 'VLI',
        'name' => 'Limburg',
      ),
      6 => 
      array (
        'code' => 'WLX',
        'name' => 'Luxembourg',
      ),
      7 => 
      array (
        'code' => 'WNA',
        'name' => 'Namur',
      ),
      8 => 
      array (
        'code' => 'VOV',
        'name' => 'Oost-Vlaanderen',
      ),
      9 => 
      array (
        'code' => 'VBR',
        'name' => 'Vlaams Brabant',
      ),
      10 => 
      array (
        'code' => 'VWV',
        'name' => 'West-Vlaanderen',
      ),
    ),
    'BF' => 
    array (
      1 => 
      array (
        'code' => 'BAL',
        'name' => 'Bale',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => 'Bam',
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
        'name' => 'Comoe',
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
        'name' => 'Gourma',
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
        'name' => 'Poni',
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
        'name' => 'Seno',
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
        'name' => 'Tapoa',
      ),
      40 => 
      array (
        'code' => 'TUY',
        'name' => 'Tuy',
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
        'name' => 'Blagoevgrad',
      ),
      2 => 
      array (
        'code' => 'BG-02',
        'name' => 'Burgas',
      ),
      3 => 
      array (
        'code' => 'BG-03',
        'name' => 'Dobrich',
      ),
      4 => 
      array (
        'code' => 'BG-04',
        'name' => 'Gabrovo',
      ),
      5 => 
      array (
        'code' => 'BG-05',
        'name' => 'Haskovo',
      ),
      6 => 
      array (
        'code' => 'BG-06',
        'name' => 'Kardjali',
      ),
      7 => 
      array (
        'code' => 'BG-07',
        'name' => 'Kyustendil',
      ),
      8 => 
      array (
        'code' => 'BG-08',
        'name' => 'Lovech',
      ),
      9 => 
      array (
        'code' => 'BG-09',
        'name' => 'Montana',
      ),
      10 => 
      array (
        'code' => 'BG-10',
        'name' => 'Pazardjik',
      ),
      11 => 
      array (
        'code' => 'BG-11',
        'name' => 'Pernik',
      ),
      12 => 
      array (
        'code' => 'BG-12',
        'name' => 'Pleven',
      ),
      13 => 
      array (
        'code' => 'BG-13',
        'name' => 'Plovdiv',
      ),
      14 => 
      array (
        'code' => 'BG-14',
        'name' => 'Razgrad',
      ),
      15 => 
      array (
        'code' => 'BG-15',
        'name' => 'Shumen',
      ),
      16 => 
      array (
        'code' => 'BG-16',
        'name' => 'Silistra',
      ),
      17 => 
      array (
        'code' => 'BG-17',
        'name' => 'Sliven',
      ),
      18 => 
      array (
        'code' => 'BG-18',
        'name' => 'Smolyan',
      ),
      19 => 
      array (
        'code' => 'BG-19',
        'name' => 'Sofia',
      ),
      20 => 
      array (
        'code' => 'BG-20',
        'name' => 'Sofia - town',
      ),
      21 => 
      array (
        'code' => 'BG-21',
        'name' => 'Stara Zagora',
      ),
      22 => 
      array (
        'code' => 'BG-22',
        'name' => 'Targovishte',
      ),
      23 => 
      array (
        'code' => 'BG-23',
        'name' => 'Varna',
      ),
      24 => 
      array (
        'code' => 'BG-24',
        'name' => 'Veliko Tarnovo',
      ),
      25 => 
      array (
        'code' => 'BG-25',
        'name' => 'Vidin',
      ),
      26 => 
      array (
        'code' => 'BG-26',
        'name' => 'Vratza',
      ),
      27 => 
      array (
        'code' => 'BG-27',
        'name' => 'Yambol',
      ),
    ),
    'BH' => 
    array (
      1 => 
      array (
        'code' => 'CAP',
        'name' => 'Capital',
      ),
      2 => 
      array (
        'code' => 'CEN',
        'name' => 'Central',
      ),
      3 => 
      array (
        'code' => 'MUH',
        'name' => 'Muharraq',
      ),
      4 => 
      array (
        'code' => 'NOR',
        'name' => 'Northern',
      ),
      5 => 
      array (
        'code' => 'SOU',
        'name' => 'Southern',
      ),
    ),
    'BI' => 
    array (
      1 => 
      array (
        'code' => 'BB',
        'name' => 'Bubanza',
      ),
      2 => 
      array (
        'code' => 'BJ',
        'name' => 'Bujumbura',
      ),
      3 => 
      array (
        'code' => 'BR',
        'name' => 'Bururi',
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
        'name' => 'Gitega',
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
        'name' => 'Makamba',
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
        'name' => 'Ngozi',
      ),
      15 => 
      array (
        'code' => 'RT',
        'name' => 'Rutana',
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
        'name' => 'Alibori',
      ),
      2 => 
      array (
        'code' => 'AK',
        'name' => 'Atakora',
      ),
      3 => 
      array (
        'code' => 'AQ',
        'name' => 'Atlantique',
      ),
      4 => 
      array (
        'code' => 'BO',
        'name' => 'Borgou',
      ),
      5 => 
      array (
        'code' => 'CO',
        'name' => 'Collines',
      ),
      6 => 
      array (
        'code' => 'DO',
        'name' => 'Donga',
      ),
      7 => 
      array (
        'code' => 'KO',
        'name' => 'Kouffo',
      ),
      8 => 
      array (
        'code' => 'LI',
        'name' => 'Littoral',
      ),
      9 => 
      array (
        'code' => 'MO',
        'name' => 'Mono',
      ),
      10 => 
      array (
        'code' => 'OU',
        'name' => 'Oueme',
      ),
      11 => 
      array (
        'code' => 'PL',
        'name' => 'Plateau',
      ),
      12 => 
      array (
        'code' => 'ZO',
        'name' => 'Zou',
      ),
    ),
    'BM' => 
    array (
      1 => 
      array (
        'code' => 'DS',
        'name' => 'Devonshire',
      ),
      2 => 
      array (
        'code' => 'HC',
        'name' => 'Hamilton City',
      ),
      3 => 
      array (
        'code' => 'HA',
        'name' => 'Hamilton',
      ),
      4 => 
      array (
        'code' => 'PG',
        'name' => 'Paget',
      ),
      5 => 
      array (
        'code' => 'PB',
        'name' => 'Pembroke',
      ),
      6 => 
      array (
        'code' => 'GC',
        'name' => 'Saint George City',
      ),
      7 => 
      array (
        'code' => 'SG',
        'name' => '',
      ),
      8 => 
      array (
        'code' => 'SA',
        'name' => 'Sandys',
      ),
      9 => 
      array (
        'code' => 'SM',
        'name' => '',
      ),
      10 => 
      array (
        'code' => 'SH',
        'name' => 'Southampton',
      ),
      11 => 
      array (
        'code' => 'WA',
        'name' => 'Warwick',
      ),
    ),
    'BN' => 
    array (
      1 => 
      array (
        'code' => 'BEL',
        'name' => 'Belait',
      ),
      2 => 
      array (
        'code' => 'BRM',
        'name' => 'Brunei and Muara',
      ),
      3 => 
      array (
        'code' => 'TEM',
        'name' => 'Temburong',
      ),
      4 => 
      array (
        'code' => 'TUT',
        'name' => 'Tutong',
      ),
    ),
    'BO' => 
    array (
      1 => 
      array (
        'code' => 'BEN',
        'name' => 'Beni',
      ),
      2 => 
      array (
        'code' => 'CHU',
        'name' => 'Chuquisaca',
      ),
      3 => 
      array (
        'code' => 'COC',
        'name' => 'Cochabamba',
      ),
      4 => 
      array (
        'code' => 'LPZ',
        'name' => 'La Paz',
      ),
      5 => 
      array (
        'code' => 'ORU',
        'name' => 'Oruro',
      ),
      6 => 
      array (
        'code' => 'PAN',
        'name' => 'Pando',
      ),
      7 => 
      array (
        'code' => 'POT',
        'name' => 'Potosi',
      ),
      8 => 
      array (
        'code' => 'SCZ',
        'name' => 'Santa Cruz',
      ),
      9 => 
      array (
        'code' => 'TAR',
        'name' => 'Tarija',
      ),
    ),
    'BR' => 
    array (
      1 => 
      array (
        'code' => 'AC',
        'name' => 'Acre',
      ),
      2 => 
      array (
        'code' => 'AL',
        'name' => 'Alagoas',
      ),
      3 => 
      array (
        'code' => 'AP',
        'name' => 'Amapa',
      ),
      4 => 
      array (
        'code' => 'AM',
        'name' => 'Amazonas',
      ),
      5 => 
      array (
        'code' => 'BA',
        'name' => 'Bahia',
      ),
      6 => 
      array (
        'code' => 'CE',
        'name' => 'Ceara',
      ),
      7 => 
      array (
        'code' => 'DF',
        'name' => 'Distrito Federal',
      ),
      8 => 
      array (
        'code' => 'ES',
        'name' => 'Espirito Santo',
      ),
      9 => 
      array (
        'code' => 'GO',
        'name' => 'Goias',
      ),
      10 => 
      array (
        'code' => 'MA',
        'name' => 'Maranhao',
      ),
      11 => 
      array (
        'code' => 'MT',
        'name' => 'Mato Grosso',
      ),
      12 => 
      array (
        'code' => 'MS',
        'name' => 'Mato Grosso do Sul',
      ),
      13 => 
      array (
        'code' => 'MG',
        'name' => 'Minas Gerais',
      ),
      14 => 
      array (
        'code' => 'PA',
        'name' => 'Para',
      ),
      15 => 
      array (
        'code' => 'PB',
        'name' => 'Paraiba',
      ),
      16 => 
      array (
        'code' => 'PR',
        'name' => 'Parana',
      ),
      17 => 
      array (
        'code' => 'PE',
        'name' => 'Pernambuco',
      ),
      18 => 
      array (
        'code' => 'PI',
        'name' => 'Piaui',
      ),
      19 => 
      array (
        'code' => 'RJ',
        'name' => 'Rio de Janeiro',
      ),
      20 => 
      array (
        'code' => 'RN',
        'name' => 'Rio Grande do Norte',
      ),
      21 => 
      array (
        'code' => 'RS',
        'name' => 'Rio Grande do Sul',
      ),
      22 => 
      array (
        'code' => 'RO',
        'name' => 'Rondonia',
      ),
      23 => 
      array (
        'code' => 'RR',
        'name' => 'Roraima',
      ),
      24 => 
      array (
        'code' => 'SC',
        'name' => 'Santa Catarina',
      ),
      25 => 
      array (
        'code' => 'SP',
        'name' => 'Sao Paulo',
      ),
      26 => 
      array (
        'code' => 'SE',
        'name' => 'Sergipe',
      ),
      27 => 
      array (
        'code' => 'TO',
        'name' => 'Tocantins',
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
        'name' => 'Berry Islands',
      ),
      3 => 
      array (
        'code' => 'BIM',
        'name' => 'Bimini',
      ),
      4 => 
      array (
        'code' => 'BLK',
        'name' => 'Black Point',
      ),
      5 => 
      array (
        'code' => 'CAT',
        'name' => 'Cat Island',
      ),
      6 => 
      array (
        'code' => 'CAB',
        'name' => 'Central Abaco',
      ),
      7 => 
      array (
        'code' => 'CAN',
        'name' => 'Central Andros',
      ),
      8 => 
      array (
        'code' => 'CEL',
        'name' => 'Central Eleuthera',
      ),
      9 => 
      array (
        'code' => 'FRE',
        'name' => 'City of Freeport',
      ),
      10 => 
      array (
        'code' => 'CRO',
        'name' => 'Crooked Island',
      ),
      11 => 
      array (
        'code' => 'EGB',
        'name' => 'East Grand Bahama',
      ),
      12 => 
      array (
        'code' => 'EXU',
        'name' => 'Exuma',
      ),
      13 => 
      array (
        'code' => 'GRD',
        'name' => 'Grand Cay',
      ),
      14 => 
      array (
        'code' => 'HAR',
        'name' => 'Harbour Island',
      ),
      15 => 
      array (
        'code' => 'HOP',
        'name' => 'Hope Town',
      ),
      16 => 
      array (
        'code' => 'INA',
        'name' => 'Inagua',
      ),
      17 => 
      array (
        'code' => 'LNG',
        'name' => 'Long Island',
      ),
      18 => 
      array (
        'code' => 'MAN',
        'name' => 'Mangrove Cay',
      ),
      19 => 
      array (
        'code' => 'MAY',
        'name' => 'Mayaguana',
      ),
      20 => 
      array (
        'code' => 'MOO',
        'name' => '',
      ),
      21 => 
      array (
        'code' => 'NAB',
        'name' => 'North Abaco',
      ),
      22 => 
      array (
        'code' => 'NAN',
        'name' => 'North Andros',
      ),
      23 => 
      array (
        'code' => 'NEL',
        'name' => 'North Eleuthera',
      ),
      24 => 
      array (
        'code' => 'RAG',
        'name' => 'Ragged Island',
      ),
      25 => 
      array (
        'code' => 'RUM',
        'name' => 'Rum Cay',
      ),
      26 => 
      array (
        'code' => 'SAL',
        'name' => 'San Salvador',
      ),
      27 => 
      array (
        'code' => 'SAB',
        'name' => 'South Abaco',
      ),
      28 => 
      array (
        'code' => 'SAN',
        'name' => 'South Andros',
      ),
      29 => 
      array (
        'code' => 'SEL',
        'name' => 'South Eleuthera',
      ),
      30 => 
      array (
        'code' => 'SWE',
        'name' => 'Spanish Wells',
      ),
      31 => 
      array (
        'code' => 'WGB',
        'name' => 'West Grand Bahama',
      ),
    ),
    'BT' => 
    array (
      1 => 
      array (
        'code' => 'BUM',
        'name' => 'Bumthang',
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
        'name' => 'Gasa',
      ),
      5 => 
      array (
        'code' => 'HAA',
        'name' => 'Haa',
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
        'name' => 'Paro',
      ),
      9 => 
      array (
        'code' => 'PEM',
        'name' => 'Pemagatshel',
      ),
      10 => 
      array (
        'code' => 'PUN',
        'name' => 'Punakha',
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
        'name' => 'Thimphu',
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
        'name' => 'Trongsa',
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
        'name' => 'Central',
      ),
      2 => 
      array (
        'code' => 'GH',
        'name' => 'Ghanzi',
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
        'name' => 'North East',
      ),
      8 => 
      array (
        'code' => 'NW',
        'name' => 'North West',
      ),
      9 => 
      array (
        'code' => 'SE',
        'name' => 'South East',
      ),
      10 => 
      array (
        'code' => 'SO',
        'name' => 'Southern',
      ),
    ),
    'BY' => 
    array (
      1 => 
      array (
        'code' => 'BR',
        'name' => 'Brestskaya (Brest)',
      ),
      2 => 
      array (
        'code' => 'HO',
        'name' => '',
      ),
      3 => 
      array (
        'code' => 'HM',
        'name' => 'Horad Minsk',
      ),
      4 => 
      array (
        'code' => 'HR',
        'name' => 'Hrodzyenskaya (Hrodna)',
      ),
      5 => 
      array (
        'code' => 'MA',
        'name' => 'Mahilyowskaya (Mahilyow)',
      ),
      6 => 
      array (
        'code' => 'MI',
        'name' => 'Minskaya',
      ),
      7 => 
      array (
        'code' => 'VI',
        'name' => 'Vitsyebskaya (Vitsyebsk)',
      ),
    ),
    'BZ' => 
    array (
      1 => 
      array (
        'code' => 'BZ',
        'name' => 'Belize',
      ),
      2 => 
      array (
        'code' => 'CY',
        'name' => 'Cayo',
      ),
      3 => 
      array (
        'code' => 'CR',
        'name' => 'Corozal',
      ),
      4 => 
      array (
        'code' => 'OW',
        'name' => 'Orange Walk',
      ),
      5 => 
      array (
        'code' => 'SC',
        'name' => 'Stann Creek',
      ),
      6 => 
      array (
        'code' => 'TO',
        'name' => 'Toledo',
      ),
    ),
    'CA' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => 'Alberta',
      ),
      2 => 
      array (
        'code' => 'BC',
        'name' => 'British Columbia',
      ),
      3 => 
      array (
        'code' => 'MB',
        'name' => 'Manitoba',
      ),
      4 => 
      array (
        'code' => 'NB',
        'name' => 'New Brunswick',
      ),
      5 => 
      array (
        'code' => 'NL',
        'name' => 'Newfoundland and Labrador',
      ),
      6 => 
      array (
        'code' => 'NT',
        'name' => 'Northwest Territories',
      ),
      7 => 
      array (
        'code' => 'NS',
        'name' => 'Nova Scotia',
      ),
      8 => 
      array (
        'code' => 'NU',
        'name' => 'Nunavut',
      ),
      9 => 
      array (
        'code' => 'ON',
        'name' => 'Ontario',
      ),
      10 => 
      array (
        'code' => 'PE',
        'name' => 'Prince Edward Island',
      ),
      11 => 
      array (
        'code' => 'QC',
        'name' => 'Québec',
      ),
      12 => 
      array (
        'code' => 'SK',
        'name' => 'Saskatchewan',
      ),
      13 => 
      array (
        'code' => 'YT',
        'name' => 'Yukon Territory',
      ),
    ),
    'CC' => 
    array (
      1 => 
      array (
        'code' => 'D',
        'name' => 'Direction Island',
      ),
      2 => 
      array (
        'code' => 'H',
        'name' => 'Home Island',
      ),
      3 => 
      array (
        'code' => 'O',
        'name' => 'Horsburgh Island',
      ),
      4 => 
      array (
        'code' => 'S',
        'name' => 'South Island',
      ),
      5 => 
      array (
        'code' => 'W',
        'name' => 'West Island',
      ),
    ),
    'CF' => 
    array (
      1 => 
      array (
        'code' => 'BAN',
        'name' => 'Bangui',
      ),
      2 => 
      array (
        'code' => 'BBA',
        'name' => 'Bamingui-Bangoran',
      ),
      3 => 
      array (
        'code' => 'BKO',
        'name' => 'Basse-Kotto',
      ),
      4 => 
      array (
        'code' => 'HKO',
        'name' => 'Haute-Kotto',
      ),
      5 => 
      array (
        'code' => 'HMB',
        'name' => 'Haut-Mbomou',
      ),
      6 => 
      array (
        'code' => 'KEM',
        'name' => 'Kemo',
      ),
      7 => 
      array (
        'code' => 'LOB',
        'name' => 'Lobaye',
      ),
      8 => 
      array (
        'code' => 'MBO',
        'name' => 'Mbomou',
      ),
      9 => 
      array (
        'code' => 'MKD',
        'name' => 'Mambéré-Kadéï',
      ),
      10 => 
      array (
        'code' => 'NGR',
        'name' => 'Nana-Grebizi',
      ),
      11 => 
      array (
        'code' => 'NMM',
        'name' => 'Nana-Mambere',
      ),
      12 => 
      array (
        'code' => 'OMP',
        'name' => '',
      ),
      13 => 
      array (
        'code' => 'OPE',
        'name' => 'Ouham-Pende',
      ),
      14 => 
      array (
        'code' => 'OUH',
        'name' => 'Ouham',
      ),
      15 => 
      array (
        'code' => 'OUK',
        'name' => 'Ouaka',
      ),
      16 => 
      array (
        'code' => 'SMB',
        'name' => 'Sangha-Mbaere',
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
        'name' => 'Brazzaville',
      ),
      3 => 
      array (
        'code' => 'CU',
        'name' => 'Cuvette',
      ),
      4 => 
      array (
        'code' => 'CO',
        'name' => 'Cuvette-Ouest',
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
        'name' => 'Likouala',
      ),
      8 => 
      array (
        'code' => 'NI',
        'name' => 'Niari',
      ),
      9 => 
      array (
        'code' => 'PL',
        'name' => 'Plateaux',
      ),
      10 => 
      array (
        'code' => 'PO',
        'name' => 'Pool',
      ),
      11 => 
      array (
        'code' => 'SA',
        'name' => 'Sangha',
      ),
    ),
    'CH' => 
    array (
      1 => 
      array (
        'code' => 'AG',
        'name' => 'Aargau',
      ),
      2 => 
      array (
        'code' => 'AR',
        'name' => 'Appenzell Ausserrhoden',
      ),
      3 => 
      array (
        'code' => 'AI',
        'name' => 'Appenzell Innerrhoden',
      ),
      4 => 
      array (
        'code' => 'BS',
        'name' => 'Basel-Stadt',
      ),
      5 => 
      array (
        'code' => 'BL',
        'name' => 'Basel-Landschaft',
      ),
      6 => 
      array (
        'code' => 'BE',
        'name' => 'Bern',
      ),
      7 => 
      array (
        'code' => 'FR',
        'name' => 'Fribourg',
      ),
      8 => 
      array (
        'code' => 'GE',
        'name' => 'Genève',
      ),
      9 => 
      array (
        'code' => 'GL',
        'name' => 'Glarus',
      ),
      10 => 
      array (
        'code' => 'GR',
        'name' => 'Graubünden',
      ),
      11 => 
      array (
        'code' => 'JU',
        'name' => 'Jura',
      ),
      12 => 
      array (
        'code' => 'LU',
        'name' => 'Lucerne',
      ),
      13 => 
      array (
        'code' => 'NE',
        'name' => 'Neuchâtel',
      ),
      14 => 
      array (
        'code' => 'NW',
        'name' => 'Nidwalden',
      ),
      15 => 
      array (
        'code' => 'OW',
        'name' => 'Obwalden',
      ),
      16 => 
      array (
        'code' => 'SG',
        'name' => 'St. Gallen',
      ),
      17 => 
      array (
        'code' => 'SH',
        'name' => 'Schaffhausen',
      ),
      18 => 
      array (
        'code' => 'SZ',
        'name' => 'Schwyz',
      ),
      19 => 
      array (
        'code' => 'SO',
        'name' => 'Solothurn',
      ),
      20 => 
      array (
        'code' => 'TG',
        'name' => 'Thurgau',
      ),
      21 => 
      array (
        'code' => 'TI',
        'name' => 'Ticino',
      ),
      22 => 
      array (
        'code' => 'UR',
        'name' => 'Uri',
      ),
      23 => 
      array (
        'code' => 'VS',
        'name' => 'Valais',
      ),
      24 => 
      array (
        'code' => 'VD',
        'name' => 'Vaud',
      ),
      25 => 
      array (
        'code' => 'ZG',
        'name' => 'Zug',
      ),
      26 => 
      array (
        'code' => 'ZH',
        'name' => 'Zürich',
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
        'name' => 'Abidjan',
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
        'name' => 'Bouake',
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
        'name' => 'Divo',
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
        'name' => 'Grand-Bassam',
      ),
      30 => 
      array (
        'code' => 'GLA',
        'name' => 'Grand-Lahou',
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
        'name' => 'Lakota',
      ),
      37 => 
      array (
        'code' => 'MAN',
        'name' => 'Man',
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
        'name' => 'Oume',
      ),
      42 => 
      array (
        'code' => 'SAK',
        'name' => 'Sakassou',
      ),
      43 => 
      array (
        'code' => 'SPE',
        'name' => 'San-Pedro',
      ),
      44 => 
      array (
        'code' => 'SAS',
        'name' => 'Sassandra',
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
        'name' => 'Tabou',
      ),
      49 => 
      array (
        'code' => 'TAN',
        'name' => 'Tanda',
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
        'name' => 'Touba',
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
        'name' => 'Yamoussoukro',
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
        'name' => 'Aitutaki',
      ),
      2 => 
      array (
        'code' => 'AT',
        'name' => 'Atiu',
      ),
      3 => 
      array (
        'code' => 'MA',
        'name' => 'Manuae',
      ),
      4 => 
      array (
        'code' => 'MG',
        'name' => 'Mangaia',
      ),
      5 => 
      array (
        'code' => 'MK',
        'name' => 'Manihiki',
      ),
      6 => 
      array (
        'code' => 'MT',
        'name' => 'Mitiaro',
      ),
      7 => 
      array (
        'code' => 'MU',
        'name' => 'Mauke',
      ),
      8 => 
      array (
        'code' => 'NI',
        'name' => 'Nassau Island',
      ),
      9 => 
      array (
        'code' => 'PA',
        'name' => 'Palmerston',
      ),
      10 => 
      array (
        'code' => 'PE',
        'name' => 'Penrhyn',
      ),
      11 => 
      array (
        'code' => 'PU',
        'name' => 'Pukapuka',
      ),
      12 => 
      array (
        'code' => 'RK',
        'name' => 'Rakahanga',
      ),
      13 => 
      array (
        'code' => 'RR',
        'name' => 'Rarotonga',
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
        'name' => 'Aisen del General Carlos Ibanez',
      ),
      2 => 
      array (
        'code' => 'AN',
        'name' => 'Antofagasta',
      ),
      3 => 
      array (
        'code' => 'AR',
        'name' => 'Araucania',
      ),
      4 => 
      array (
        'code' => 'AT',
        'name' => 'Atacama',
      ),
      5 => 
      array (
        'code' => 'BI',
        'name' => 'Bio-Bio',
      ),
      6 => 
      array (
        'code' => 'CO',
        'name' => 'Coquimbo',
      ),
      7 => 
      array (
        'code' => 'LI',
        'name' => '',
      ),
      8 => 
      array (
        'code' => 'LL',
        'name' => 'Los Lagos',
      ),
      9 => 
      array (
        'code' => 'MA',
        'name' => 'Magallanes y de la Antartica Chi',
      ),
      10 => 
      array (
        'code' => 'ML',
        'name' => 'Maule',
      ),
      11 => 
      array (
        'code' => 'RM',
        'name' => 'Region Metropolitana',
      ),
      12 => 
      array (
        'code' => 'TA',
        'name' => 'Tarapaca',
      ),
      13 => 
      array (
        'code' => 'VS',
        'name' => 'Valparaiso',
      ),
    ),
    'CM' => 
    array (
      1 => 
      array (
        'code' => 'ADA',
        'name' => 'Adamawa (Adamaoua)',
      ),
      2 => 
      array (
        'code' => 'CEN',
        'name' => 'Centre',
      ),
      3 => 
      array (
        'code' => 'EST',
        'name' => 'East (Est)',
      ),
      4 => 
      array (
        'code' => 'EXN',
        'name' => 'Extrême-Nord',
      ),
      5 => 
      array (
        'code' => 'LIT',
        'name' => 'Littoral',
      ),
      6 => 
      array (
        'code' => 'NOR',
        'name' => 'North (Nord)',
      ),
      7 => 
      array (
        'code' => 'NOT',
        'name' => 'Northwest (Nord-Ouest)',
      ),
      8 => 
      array (
        'code' => 'OUE',
        'name' => 'West (Ouest)',
      ),
      9 => 
      array (
        'code' => 'SUD',
        'name' => 'South (Sud)',
      ),
      10 => 
      array (
        'code' => 'SOU',
        'name' => 'Southwest (Sud-Ouest)',
      ),
    ),
    'CN' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Anhui',
      ),
      2 => 
      array (
        'code' => 'BE',
        'name' => 'Beijing',
      ),
      3 => 
      array (
        'code' => 'CH',
        'name' => 'Chongqing',
      ),
      4 => 
      array (
        'code' => 'FU',
        'name' => 'Fujian',
      ),
      5 => 
      array (
        'code' => 'GA',
        'name' => 'Gansu',
      ),
      6 => 
      array (
        'code' => 'GU',
        'name' => 'Guangdong',
      ),
      7 => 
      array (
        'code' => 'GX',
        'name' => 'Guangxi',
      ),
      8 => 
      array (
        'code' => 'GZ',
        'name' => 'Guizhou',
      ),
      9 => 
      array (
        'code' => 'HA',
        'name' => 'Hainan',
      ),
      10 => 
      array (
        'code' => 'HB',
        'name' => 'Hebei',
      ),
      11 => 
      array (
        'code' => 'HL',
        'name' => 'Heilongjiang',
      ),
      12 => 
      array (
        'code' => 'HE',
        'name' => 'Henan',
      ),
      13 => 
      array (
        'code' => 'HK',
        'name' => 'Hong Kong',
      ),
      14 => 
      array (
        'code' => 'HU',
        'name' => 'Hubei',
      ),
      15 => 
      array (
        'code' => 'HN',
        'name' => 'Hunan',
      ),
      16 => 
      array (
        'code' => 'IM',
        'name' => 'Inner Mongolia',
      ),
      17 => 
      array (
        'code' => 'JI',
        'name' => 'Jiangsu',
      ),
      18 => 
      array (
        'code' => 'JX',
        'name' => 'Jiangxi',
      ),
      19 => 
      array (
        'code' => 'JL',
        'name' => 'Jilin',
      ),
      20 => 
      array (
        'code' => 'LI',
        'name' => 'Liaoning',
      ),
      21 => 
      array (
        'code' => 'MA',
        'name' => 'Macau',
      ),
      22 => 
      array (
        'code' => 'NI',
        'name' => 'Ningxia',
      ),
      23 => 
      array (
        'code' => 'SH',
        'name' => 'Shaanxi',
      ),
      24 => 
      array (
        'code' => 'SA',
        'name' => 'Shandong',
      ),
      25 => 
      array (
        'code' => 'SG',
        'name' => 'Shanghai',
      ),
      26 => 
      array (
        'code' => 'SX',
        'name' => 'Shanxi',
      ),
      27 => 
      array (
        'code' => 'SI',
        'name' => 'Sichuan',
      ),
      28 => 
      array (
        'code' => 'TI',
        'name' => 'Tianjin',
      ),
      29 => 
      array (
        'code' => 'XI',
        'name' => 'Xinjiang',
      ),
      30 => 
      array (
        'code' => 'YU',
        'name' => 'Yunnan',
      ),
      31 => 
      array (
        'code' => 'ZH',
        'name' => 'Zhejiang',
      ),
    ),
    'CO' => 
    array (
      1 => 
      array (
        'code' => 'AMZ',
        'name' => 'Amazonas',
      ),
      2 => 
      array (
        'code' => 'ANT',
        'name' => 'Antioquia',
      ),
      3 => 
      array (
        'code' => 'ARA',
        'name' => 'Arauca',
      ),
      4 => 
      array (
        'code' => 'ATL',
        'name' => 'Atlantico',
      ),
      5 => 
      array (
        'code' => 'BDC',
        'name' => 'Bogota D.C.',
      ),
      6 => 
      array (
        'code' => 'BOL',
        'name' => 'Bolivar',
      ),
      7 => 
      array (
        'code' => 'BOY',
        'name' => 'Boyaca',
      ),
      8 => 
      array (
        'code' => 'CAL',
        'name' => 'Caldas',
      ),
      9 => 
      array (
        'code' => 'CAQ',
        'name' => 'Caqueta',
      ),
      10 => 
      array (
        'code' => 'CAS',
        'name' => 'Casanare',
      ),
      11 => 
      array (
        'code' => 'CAU',
        'name' => 'Cauca',
      ),
      12 => 
      array (
        'code' => 'CES',
        'name' => 'Cesar',
      ),
      13 => 
      array (
        'code' => 'CHO',
        'name' => 'Choco',
      ),
      14 => 
      array (
        'code' => 'COR',
        'name' => 'Cordoba',
      ),
      15 => 
      array (
        'code' => 'CAM',
        'name' => 'Cundinamarca',
      ),
      16 => 
      array (
        'code' => 'GNA',
        'name' => 'Guainia',
      ),
      17 => 
      array (
        'code' => 'GJR',
        'name' => 'Guajira',
      ),
      18 => 
      array (
        'code' => 'GVR',
        'name' => 'Guaviare',
      ),
      19 => 
      array (
        'code' => 'HUI',
        'name' => 'Huila',
      ),
      20 => 
      array (
        'code' => 'MAG',
        'name' => 'Magdalena',
      ),
      21 => 
      array (
        'code' => 'MET',
        'name' => 'Meta',
      ),
      22 => 
      array (
        'code' => 'NAR',
        'name' => 'Narino',
      ),
      23 => 
      array (
        'code' => 'NDS',
        'name' => 'Norte de Santander',
      ),
      24 => 
      array (
        'code' => 'PUT',
        'name' => 'Putumayo',
      ),
      25 => 
      array (
        'code' => 'QUI',
        'name' => 'Quindio',
      ),
      26 => 
      array (
        'code' => 'RIS',
        'name' => 'Risaralda',
      ),
      27 => 
      array (
        'code' => 'SAP',
        'name' => 'San Andres y Providencia',
      ),
      28 => 
      array (
        'code' => 'SAN',
        'name' => 'Santander',
      ),
      29 => 
      array (
        'code' => 'SUC',
        'name' => 'Sucre',
      ),
      30 => 
      array (
        'code' => 'TOL',
        'name' => 'Tolima',
      ),
      31 => 
      array (
        'code' => 'VDC',
        'name' => 'Valle del Cauca',
      ),
      32 => 
      array (
        'code' => 'VAU',
        'name' => 'Vaupes',
      ),
      33 => 
      array (
        'code' => 'VIC',
        'name' => 'Vichada',
      ),
    ),
    'CR' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Alajuela',
      ),
      2 => 
      array (
        'code' => 'CA',
        'name' => 'Cartago',
      ),
      3 => 
      array (
        'code' => 'GU',
        'name' => 'Guanacaste',
      ),
      4 => 
      array (
        'code' => 'HE',
        'name' => 'Heredia',
      ),
      5 => 
      array (
        'code' => 'LI',
        'name' => 'Limon',
      ),
      6 => 
      array (
        'code' => 'PU',
        'name' => 'Puntarenas',
      ),
      7 => 
      array (
        'code' => 'SJ',
        'name' => 'San Jose',
      ),
    ),
    'CU' => 
    array (
      1 => 
      array (
        'code' => 'CA',
        'name' => 'Camaguey',
      ),
      2 => 
      array (
        'code' => 'CD',
        'name' => 'Ciego de Avila',
      ),
      3 => 
      array (
        'code' => 'CI',
        'name' => 'Cienfuegos',
      ),
      4 => 
      array (
        'code' => 'CH',
        'name' => 'Ciudad de La Habana',
      ),
      5 => 
      array (
        'code' => 'GR',
        'name' => 'Granma',
      ),
      6 => 
      array (
        'code' => 'GU',
        'name' => 'Guantanamo',
      ),
      7 => 
      array (
        'code' => 'HO',
        'name' => 'Holguin',
      ),
      8 => 
      array (
        'code' => 'IJ',
        'name' => 'Isla de la Juventud',
      ),
      9 => 
      array (
        'code' => 'LH',
        'name' => 'La Habana',
      ),
      10 => 
      array (
        'code' => 'LT',
        'name' => 'Las Tunas',
      ),
      11 => 
      array (
        'code' => 'MA',
        'name' => 'Matanzas',
      ),
      12 => 
      array (
        'code' => 'PR',
        'name' => 'Pinar del Rio',
      ),
      13 => 
      array (
        'code' => 'SS',
        'name' => 'Sancti Spiritus',
      ),
      14 => 
      array (
        'code' => 'SC',
        'name' => 'Santiago de Cuba',
      ),
      15 => 
      array (
        'code' => 'VC',
        'name' => 'Villa Clara',
      ),
    ),
    'CV' => 
    array (
      1 => 
      array (
        'code' => 'BV',
        'name' => 'Boa Vista',
      ),
      2 => 
      array (
        'code' => 'BR',
        'name' => 'Brava',
      ),
      3 => 
      array (
        'code' => 'CS',
        'name' => 'Calheta de Sao Miguel',
      ),
      4 => 
      array (
        'code' => 'MA',
        'name' => 'Maio',
      ),
      5 => 
      array (
        'code' => 'MO',
        'name' => 'Mosteiros',
      ),
      6 => 
      array (
        'code' => 'PA',
        'name' => 'Paul',
      ),
      7 => 
      array (
        'code' => 'PN',
        'name' => 'Porto Novo',
      ),
      8 => 
      array (
        'code' => 'PR',
        'name' => 'Praia',
      ),
      9 => 
      array (
        'code' => 'RG',
        'name' => 'Ribeira Grande',
      ),
      10 => 
      array (
        'code' => 'SL',
        'name' => 'Sal',
      ),
      11 => 
      array (
        'code' => 'CA',
        'name' => 'Santa Catarina',
      ),
      12 => 
      array (
        'code' => 'CR',
        'name' => 'Santa Cruz',
      ),
      13 => 
      array (
        'code' => 'SD',
        'name' => 'Sao Domingos',
      ),
      14 => 
      array (
        'code' => 'SF',
        'name' => 'Sao Filipe',
      ),
      15 => 
      array (
        'code' => 'SN',
        'name' => 'Sao Nicolau',
      ),
      16 => 
      array (
        'code' => 'SV',
        'name' => 'Sao Vicente',
      ),
      17 => 
      array (
        'code' => 'TA',
        'name' => 'Tarrafal',
      ),
    ),
    'CY' => 
    array (
      1 => 
      array (
        'code' => 'F',
        'name' => 'Famagusta',
      ),
      2 => 
      array (
        'code' => 'K',
        'name' => 'Kyrenia',
      ),
      3 => 
      array (
        'code' => 'A',
        'name' => 'Larnaca',
      ),
      4 => 
      array (
        'code' => 'I',
        'name' => 'Limassol',
      ),
      5 => 
      array (
        'code' => 'N',
        'name' => 'Nicosia',
      ),
      6 => 
      array (
        'code' => 'P',
        'name' => 'Paphos',
      ),
    ),
    'CZ' => 
    array (
      1 => 
      array (
        'code' => 'A',
        'name' => 'Hlavní město Praha',
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
        'name' => 'Vysočina',
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
        'name' => 'Středočeský',
      ),
      12 => 
      array (
        'code' => 'T',
        'name' => 'Moravskoslezský',
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
        'code' => '',
        'name' => 'Estados',
      ),
    ),
    'DE' => 
    array (
      1 => 
      array (
        'code' => 'BAW',
        'name' => 'Baden-Württemberg',
      ),
      2 => 
      array (
        'code' => 'BAY',
        'name' => 'Bayern',
      ),
      3 => 
      array (
        'code' => 'BER',
        'name' => 'Berlin',
      ),
      4 => 
      array (
        'code' => 'BRG',
        'name' => 'Brandenburg',
      ),
      5 => 
      array (
        'code' => 'BRE',
        'name' => 'Bremen',
      ),
      6 => 
      array (
        'code' => 'HAM',
        'name' => 'Hamburg',
      ),
      7 => 
      array (
        'code' => 'HES',
        'name' => 'Hessen',
      ),
      8 => 
      array (
        'code' => 'MEC',
        'name' => 'Mecklenburg-Vorpommern',
      ),
      9 => 
      array (
        'code' => 'NDS',
        'name' => 'Niedersachsen',
      ),
      10 => 
      array (
        'code' => 'NRW',
        'name' => 'Nordrhein-Westfalen',
      ),
      11 => 
      array (
        'code' => 'RHE',
        'name' => 'Rheinland-Pfalz',
      ),
      12 => 
      array (
        'code' => 'SAR',
        'name' => 'Saarland',
      ),
      13 => 
      array (
        'code' => 'SAS',
        'name' => 'Sachsen',
      ),
      14 => 
      array (
        'code' => 'SAC',
        'name' => 'Sachsen-Anhalt',
      ),
      15 => 
      array (
        'code' => 'SCN',
        'name' => 'Schleswig-Holstein',
      ),
      16 => 
      array (
        'code' => 'THE',
        'name' => 'Thüringen',
      ),
    ),
    'DJ' => 
    array (
      1 => 
      array (
        'code' => 'S',
        'name' => '',
      ),
      2 => 
      array (
        'code' => 'K',
        'name' => 'Dikhil',
      ),
      3 => 
      array (
        'code' => 'J',
        'name' => 'Djibouti',
      ),
      4 => 
      array (
        'code' => 'O',
        'name' => 'Obock',
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
        'name' => 'Arhus',
      ),
      2 => 
      array (
        'code' => 'BH',
        'name' => 'Bornholm',
      ),
      3 => 
      array (
        'code' => 'CO',
        'name' => 'Copenhagen',
      ),
      4 => 
      array (
        'code' => 'FO',
        'name' => 'Faroe Islands',
      ),
      5 => 
      array (
        'code' => 'FR',
        'name' => 'Frederiksborg',
      ),
      6 => 
      array (
        'code' => 'FY',
        'name' => 'Fyn',
      ),
      7 => 
      array (
        'code' => 'KO',
        'name' => 'Kobenhavn',
      ),
      8 => 
      array (
        'code' => 'NO',
        'name' => 'Nordjylland',
      ),
      9 => 
      array (
        'code' => 'RI',
        'name' => 'Ribe',
      ),
      10 => 
      array (
        'code' => 'RK',
        'name' => 'Ringkobing',
      ),
      11 => 
      array (
        'code' => 'RO',
        'name' => 'Roskilde',
      ),
      12 => 
      array (
        'code' => 'SO',
        'name' => 'Sonderjylland',
      ),
      13 => 
      array (
        'code' => 'ST',
        'name' => 'Storstrom',
      ),
      14 => 
      array (
        'code' => 'VK',
        'name' => 'Vestjælland',
      ),
      15 => 
      array (
        'code' => 'VJ',
        'name' => 'Viborg',
      ),
      16 => 
      array (
        'code' => 'VB',
        'name' => '',
      ),
    ),
    'DM' => 
    array (
      1 => 
      array (
        'code' => 'AND',
        'name' => 'Saint Andrew Parish',
      ),
      2 => 
      array (
        'code' => 'DAV',
        'name' => 'Saint David Parish',
      ),
      3 => 
      array (
        'code' => 'GEO',
        'name' => 'Saint George Parish',
      ),
      4 => 
      array (
        'code' => 'JOH',
        'name' => 'Saint John Parish',
      ),
      5 => 
      array (
        'code' => 'JOS',
        'name' => 'Saint Joseph Parish',
      ),
      6 => 
      array (
        'code' => 'LUK',
        'name' => 'Saint Luke Parish',
      ),
      7 => 
      array (
        'code' => 'MAR',
        'name' => 'Saint Mark Parish',
      ),
      8 => 
      array (
        'code' => 'PAT',
        'name' => 'Saint Patrick Parish',
      ),
      9 => 
      array (
        'code' => 'PAU',
        'name' => 'Saint Paul Parish',
      ),
      10 => 
      array (
        'code' => 'PET',
        'name' => 'Saint Peter Parish',
      ),
    ),
    'DO' => 
    array (
      1 => 
      array (
        'code' => 'DN',
        'name' => 'Distrito Nacional',
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
        'name' => 'Barahona',
      ),
      5 => 
      array (
        'code' => 'DJ',
        'name' => 'Dajabon',
      ),
      6 => 
      array (
        'code' => 'DU',
        'name' => 'Duarte',
      ),
      7 => 
      array (
        'code' => 'EL',
        'name' => 'Elias Pina',
      ),
      8 => 
      array (
        'code' => 'SY',
        'name' => 'El Seybo',
      ),
      9 => 
      array (
        'code' => 'ET',
        'name' => 'Espaillat',
      ),
      10 => 
      array (
        'code' => 'HM',
        'name' => 'Hato Mayor',
      ),
      11 => 
      array (
        'code' => 'IN',
        'name' => 'Independencia',
      ),
      12 => 
      array (
        'code' => 'AL',
        'name' => 'La Altagracia',
      ),
      13 => 
      array (
        'code' => 'RO',
        'name' => 'La Romana',
      ),
      14 => 
      array (
        'code' => 'VE',
        'name' => 'La Vega',
      ),
      15 => 
      array (
        'code' => 'MT',
        'name' => 'Maria Trinidad Sanchez',
      ),
      16 => 
      array (
        'code' => 'MN',
        'name' => 'Monsenor Nouel',
      ),
      17 => 
      array (
        'code' => 'MC',
        'name' => 'Monte Cristi',
      ),
      18 => 
      array (
        'code' => 'MP',
        'name' => 'Monte Plata',
      ),
      19 => 
      array (
        'code' => 'PD',
        'name' => 'Pedernales',
      ),
      20 => 
      array (
        'code' => 'PR',
        'name' => 'Peravia (Bani)',
      ),
      21 => 
      array (
        'code' => 'PP',
        'name' => 'Puerto Plata',
      ),
      22 => 
      array (
        'code' => 'SL',
        'name' => 'Salcedo',
      ),
      23 => 
      array (
        'code' => 'SM',
        'name' => 'Samana',
      ),
      24 => 
      array (
        'code' => 'SH',
        'name' => 'Sanchez Ramirez',
      ),
      25 => 
      array (
        'code' => 'SC',
        'name' => 'San Cristobal',
      ),
      26 => 
      array (
        'code' => 'JO',
        'name' => 'San Jose de Ocoa',
      ),
      27 => 
      array (
        'code' => 'SJ',
        'name' => 'San Juan',
      ),
      28 => 
      array (
        'code' => 'PM',
        'name' => 'San Pedro de Macoris',
      ),
      29 => 
      array (
        'code' => 'SA',
        'name' => 'Santiago',
      ),
      30 => 
      array (
        'code' => 'ST',
        'name' => 'Santiago Rodriguez',
      ),
      31 => 
      array (
        'code' => 'SD',
        'name' => 'Santo Domingo',
      ),
      32 => 
      array (
        'code' => 'VA',
        'name' => 'Valverde',
      ),
    ),
    'DZ' => 
    array (
      1 => 
      array (
        'code' => 'ADE',
        'name' => 'Ain Defla',
      ),
      2 => 
      array (
        'code' => 'ADR',
        'name' => 'Adrar',
      ),
      3 => 
      array (
        'code' => 'ALG',
        'name' => 'Alger',
      ),
      4 => 
      array (
        'code' => 'ANN',
        'name' => 'Annaba',
      ),
      5 => 
      array (
        'code' => 'ATE',
        'name' => 'Ain Temouchent',
      ),
      6 => 
      array (
        'code' => 'BAT',
        'name' => 'Batna',
      ),
      7 => 
      array (
        'code' => 'BBA',
        'name' => 'Bordj Bou Arreridj',
      ),
      8 => 
      array (
        'code' => 'BEC',
        'name' => 'Bechar',
      ),
      9 => 
      array (
        'code' => 'BEJ',
        'name' => 'Bejaia',
      ),
      10 => 
      array (
        'code' => 'BIS',
        'name' => 'Biskra',
      ),
      11 => 
      array (
        'code' => 'BLI',
        'name' => 'Blida',
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
        'name' => 'Chlef',
      ),
      15 => 
      array (
        'code' => 'CON',
        'name' => 'Constantine',
      ),
      16 => 
      array (
        'code' => 'DJE',
        'name' => 'Djelfa',
      ),
      17 => 
      array (
        'code' => 'EBA',
        'name' => 'El Bayadh',
      ),
      18 => 
      array (
        'code' => 'EOU',
        'name' => 'El Oued',
      ),
      19 => 
      array (
        'code' => 'ETA',
        'name' => 'El Tarf',
      ),
      20 => 
      array (
        'code' => 'GHA',
        'name' => 'Ghardaia',
      ),
      21 => 
      array (
        'code' => 'GUE',
        'name' => 'Guelma',
      ),
      22 => 
      array (
        'code' => 'ILL',
        'name' => 'Illizi',
      ),
      23 => 
      array (
        'code' => 'JIJ',
        'name' => 'Jijel',
      ),
      24 => 
      array (
        'code' => 'KHE',
        'name' => 'Khenchela',
      ),
      25 => 
      array (
        'code' => 'LAG',
        'name' => 'Laghouat',
      ),
      26 => 
      array (
        'code' => 'MED',
        'name' => 'Medea',
      ),
      27 => 
      array (
        'code' => 'MIL',
        'name' => 'Mila',
      ),
      28 => 
      array (
        'code' => 'MOS',
        'name' => 'Mostaganem',
      ),
      29 => 
      array (
        'code' => 'MSI',
        'name' => '',
      ),
      30 => 
      array (
        'code' => 'MUA',
        'name' => 'Muaskar',
      ),
      31 => 
      array (
        'code' => 'NAA',
        'name' => 'Naama',
      ),
      32 => 
      array (
        'code' => 'OEB',
        'name' => 'Oum el-Bouaghi',
      ),
      33 => 
      array (
        'code' => 'ORA',
        'name' => 'Oran',
      ),
      34 => 
      array (
        'code' => 'OUA',
        'name' => 'Ouargla',
      ),
      35 => 
      array (
        'code' => 'REL',
        'name' => 'Relizane',
      ),
      36 => 
      array (
        'code' => 'SAH',
        'name' => 'Souk Ahras',
      ),
      37 => 
      array (
        'code' => 'SAI',
        'name' => 'Saida',
      ),
      38 => 
      array (
        'code' => 'SBA',
        'name' => 'Sidi Bel Abbes',
      ),
      39 => 
      array (
        'code' => 'SET',
        'name' => 'Setif',
      ),
      40 => 
      array (
        'code' => 'SKI',
        'name' => 'Skikda',
      ),
      41 => 
      array (
        'code' => 'TAM',
        'name' => 'Tamanghasset',
      ),
      42 => 
      array (
        'code' => 'TEB',
        'name' => 'Tebessa',
      ),
      43 => 
      array (
        'code' => 'TIA',
        'name' => 'Tiaret',
      ),
      44 => 
      array (
        'code' => 'TIN',
        'name' => 'Tindouf',
      ),
      45 => 
      array (
        'code' => 'TIP',
        'name' => 'Tipaza',
      ),
      46 => 
      array (
        'code' => 'TIS',
        'name' => 'Tissemsilt',
      ),
      47 => 
      array (
        'code' => 'TLE',
        'name' => 'Tlemcen',
      ),
      48 => 
      array (
        'code' => 'TOU',
        'name' => 'Tizi Ouzou',
      ),
    ),
    'EC' => 
    array (
      1 => 
      array (
        'code' => 'AZU',
        'name' => 'Azuay',
      ),
      2 => 
      array (
        'code' => 'BOL',
        'name' => 'Bolivar',
      ),
      3 => 
      array (
        'code' => 'CAN',
        'name' => 'Cañar',
      ),
      4 => 
      array (
        'code' => 'CAR',
        'name' => 'Carchi',
      ),
      5 => 
      array (
        'code' => 'CHI',
        'name' => 'Chimborazo',
      ),
      6 => 
      array (
        'code' => 'COT',
        'name' => 'Cotopaxi',
      ),
      7 => 
      array (
        'code' => 'EOR',
        'name' => 'El Oro',
      ),
      8 => 
      array (
        'code' => 'ESM',
        'name' => 'Esmeraldas',
      ),
      9 => 
      array (
        'code' => 'GPS',
        'name' => 'Galápagos',
      ),
      10 => 
      array (
        'code' => 'GUA',
        'name' => 'Guayas',
      ),
      11 => 
      array (
        'code' => 'IMB',
        'name' => 'Imbabura',
      ),
      12 => 
      array (
        'code' => 'LOJ',
        'name' => 'Loja',
      ),
      13 => 
      array (
        'code' => 'LRO',
        'name' => 'Los Ríos',
      ),
      14 => 
      array (
        'code' => 'MAN',
        'name' => 'Manabí',
      ),
      15 => 
      array (
        'code' => 'MSA',
        'name' => 'Morona Santiago',
      ),
      16 => 
      array (
        'code' => 'NAP',
        'name' => 'Napo',
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
        'name' => 'Pichincha',
      ),
      20 => 
      array (
        'code' => 'SUC',
        'name' => 'Sucumbíos',
      ),
      21 => 
      array (
        'code' => 'TUN',
        'name' => 'Tungurahua',
      ),
      22 => 
      array (
        'code' => 'ZCH',
        'name' => 'Zamora Chinchipe',
      ),
    ),
    'EE' => 
    array (
      1 => 
      array (
        'code' => 'HA',
        'name' => 'Harjumaa (Tallinn)',
      ),
      2 => 
      array (
        'code' => 'HI',
        'name' => 'Hiiumaa (Kardla)',
      ),
      3 => 
      array (
        'code' => 'IV',
        'name' => 'Ida-Virumaa (Johvi)',
      ),
      4 => 
      array (
        'code' => 'JA',
        'name' => 'Jarvamaa (Paide)',
      ),
      5 => 
      array (
        'code' => 'JO',
        'name' => 'Jogevamaa (Jogeva)',
      ),
      6 => 
      array (
        'code' => 'LV',
        'name' => 'Laane-Virumaa (Rakvere)',
      ),
      7 => 
      array (
        'code' => 'LA',
        'name' => 'Laanemaa (Haapsalu)',
      ),
      8 => 
      array (
        'code' => 'PA',
        'name' => 'Parnumaa (Parnu)',
      ),
      9 => 
      array (
        'code' => 'PO',
        'name' => 'Polvamaa (Polva)',
      ),
      10 => 
      array (
        'code' => 'RA',
        'name' => 'Raplamaa (Rapla)',
      ),
      11 => 
      array (
        'code' => 'SA',
        'name' => 'Saaremaa (Kuessaare)',
      ),
      12 => 
      array (
        'code' => 'TA',
        'name' => 'Tartumaa (Tartu)',
      ),
      13 => 
      array (
        'code' => 'VA',
        'name' => 'Valgamaa (Valga)',
      ),
      14 => 
      array (
        'code' => 'VI',
        'name' => 'Viljandimaa (Viljandi)',
      ),
      15 => 
      array (
        'code' => 'VO',
        'name' => 'Vorumaa (Voru)',
      ),
    ),
    'EG' => 
    array (
      1 => 
      array (
        'code' => 'DHY',
        'name' => 'Ad Daqahliyah',
      ),
      2 => 
      array (
        'code' => 'BAM',
        'name' => 'Al Bahr al Ahmar',
      ),
      3 => 
      array (
        'code' => 'BHY',
        'name' => 'Al Buhayrah',
      ),
      4 => 
      array (
        'code' => 'FYM',
        'name' => 'Al Fayyum',
      ),
      5 => 
      array (
        'code' => 'GBY',
        'name' => 'Al Gharbiyah',
      ),
      6 => 
      array (
        'code' => 'IDR',
        'name' => 'Al Iskandariyah',
      ),
      7 => 
      array (
        'code' => 'IML',
        'name' => '',
      ),
      8 => 
      array (
        'code' => 'JZH',
        'name' => 'Al Jizah',
      ),
      9 => 
      array (
        'code' => 'MFY',
        'name' => 'Al Minufiyah',
      ),
      10 => 
      array (
        'code' => 'MNY',
        'name' => 'Al Minya',
      ),
      11 => 
      array (
        'code' => 'QHR',
        'name' => 'Al Qahirah',
      ),
      12 => 
      array (
        'code' => 'QLY',
        'name' => 'Al Qalyubiyah',
      ),
      13 => 
      array (
        'code' => 'WJD',
        'name' => 'Al Wadi al Jadid',
      ),
      14 => 
      array (
        'code' => 'SHQ',
        'name' => 'Ash Sharqiyah',
      ),
      15 => 
      array (
        'code' => 'SWY',
        'name' => 'As Suways',
      ),
      16 => 
      array (
        'code' => 'ASW',
        'name' => 'Aswan',
      ),
      17 => 
      array (
        'code' => 'ASY',
        'name' => 'Asyut',
      ),
      18 => 
      array (
        'code' => 'BSW',
        'name' => 'Bani Suwayf',
      ),
      19 => 
      array (
        'code' => 'BSD',
        'name' => '',
      ),
      20 => 
      array (
        'code' => 'DMY',
        'name' => 'Dumyat',
      ),
      21 => 
      array (
        'code' => 'JNS',
        'name' => '',
      ),
      22 => 
      array (
        'code' => 'KSH',
        'name' => 'Kafr ash Shaykh',
      ),
      23 => 
      array (
        'code' => 'MAT',
        'name' => 'Matruh',
      ),
      24 => 
      array (
        'code' => 'QIN',
        'name' => 'Qina',
      ),
      25 => 
      array (
        'code' => 'SHS',
        'name' => '',
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
        'name' => 'Central (Maekel)',
      ),
      2 => 
      array (
        'code' => 'KE',
        'name' => 'Anseba (Keren)',
      ),
      3 => 
      array (
        'code' => 'DK',
        'name' => 'Southern Red Sea (Debub-Keih-Bah)',
      ),
      4 => 
      array (
        'code' => 'SK',
        'name' => 'Northern Red Sea (Semien-Keih-Ba)',
      ),
      5 => 
      array (
        'code' => 'DE',
        'name' => 'Southern (Debub)',
      ),
      6 => 
      array (
        'code' => 'BR',
        'name' => 'Gash-Barka (Barentu)',
      ),
    ),
    'ES' => 
    array (
      1 => 
      array (
        'code' => 'CA',
        'name' => 'La Coruña',
      ),
      2 => 
      array (
        'code' => 'AL',
        'name' => 'Álava',
      ),
      3 => 
      array (
        'code' => 'AB',
        'name' => 'Albacete',
      ),
      4 => 
      array (
        'code' => 'AC',
        'name' => 'Alicante',
      ),
      5 => 
      array (
        'code' => 'AM',
        'name' => 'Almeria',
      ),
      6 => 
      array (
        'code' => 'AS',
        'name' => 'Asturias',
      ),
      7 => 
      array (
        'code' => 'AV',
        'name' => 'Ávila',
      ),
      8 => 
      array (
        'code' => 'BJ',
        'name' => 'Badajoz',
      ),
      9 => 
      array (
        'code' => 'IB',
        'name' => 'Baleares',
      ),
      10 => 
      array (
        'code' => 'BA',
        'name' => 'Barcelona',
      ),
      11 => 
      array (
        'code' => 'BU',
        'name' => 'Burgos',
      ),
      12 => 
      array (
        'code' => 'CC',
        'name' => 'Cáceres',
      ),
      13 => 
      array (
        'code' => 'CZ',
        'name' => 'Cádiz',
      ),
      14 => 
      array (
        'code' => 'CT',
        'name' => 'Cantabria',
      ),
      15 => 
      array (
        'code' => 'CL',
        'name' => 'Castellón',
      ),
      16 => 
      array (
        'code' => 'CE',
        'name' => 'Ceuta',
      ),
      17 => 
      array (
        'code' => 'CR',
        'name' => 'Ciudad Real',
      ),
      18 => 
      array (
        'code' => 'CD',
        'name' => 'Córdoba',
      ),
      19 => 
      array (
        'code' => 'CU',
        'name' => 'Cuenca',
      ),
      20 => 
      array (
        'code' => 'GI',
        'name' => 'Gerona',
      ),
      21 => 
      array (
        'code' => 'GD',
        'name' => 'Granada',
      ),
      22 => 
      array (
        'code' => 'GJ',
        'name' => 'Guadalajara',
      ),
      23 => 
      array (
        'code' => 'GP',
        'name' => 'Guipúzcoa',
      ),
      24 => 
      array (
        'code' => 'HL',
        'name' => 'Huelva',
      ),
      25 => 
      array (
        'code' => 'HS',
        'name' => 'Huesca',
      ),
      26 => 
      array (
        'code' => 'JN',
        'name' => 'Jaén',
      ),
      27 => 
      array (
        'code' => 'RJ',
        'name' => 'La Rioja',
      ),
      28 => 
      array (
        'code' => 'PM',
        'name' => 'Las Palmas',
      ),
      29 => 
      array (
        'code' => 'LE',
        'name' => 'León',
      ),
      30 => 
      array (
        'code' => 'LL',
        'name' => 'Lérida',
      ),
      31 => 
      array (
        'code' => 'LG',
        'name' => 'Lugo',
      ),
      32 => 
      array (
        'code' => 'MD',
        'name' => 'Madrid',
      ),
      33 => 
      array (
        'code' => 'MA',
        'name' => 'Málaga',
      ),
      34 => 
      array (
        'code' => 'ML',
        'name' => 'Melilla',
      ),
      35 => 
      array (
        'code' => 'MU',
        'name' => 'Murcia',
      ),
      36 => 
      array (
        'code' => 'NV',
        'name' => 'Navarra',
      ),
      37 => 
      array (
        'code' => 'OU',
        'name' => 'Ourense',
      ),
      38 => 
      array (
        'code' => 'PL',
        'name' => 'Palencia',
      ),
      39 => 
      array (
        'code' => 'PO',
        'name' => 'Pontevedra',
      ),
      40 => 
      array (
        'code' => 'SL',
        'name' => 'Salamanca',
      ),
      41 => 
      array (
        'code' => 'SC',
        'name' => 'Santa Cruz de Tenerife',
      ),
      42 => 
      array (
        'code' => 'SG',
        'name' => 'Segovia',
      ),
      43 => 
      array (
        'code' => 'SV',
        'name' => 'Sevilla',
      ),
      44 => 
      array (
        'code' => 'SO',
        'name' => 'Soria',
      ),
      45 => 
      array (
        'code' => 'TA',
        'name' => 'Tarragona',
      ),
      46 => 
      array (
        'code' => 'TE',
        'name' => 'Teruel',
      ),
      47 => 
      array (
        'code' => 'TO',
        'name' => 'Toledo',
      ),
      48 => 
      array (
        'code' => 'VC',
        'name' => 'Valencia',
      ),
      49 => 
      array (
        'code' => 'VD',
        'name' => 'Valladolid',
      ),
      50 => 
      array (
        'code' => 'VZ',
        'name' => 'Vizcaya',
      ),
      51 => 
      array (
        'code' => 'ZM',
        'name' => 'Zamora',
      ),
      52 => 
      array (
        'code' => 'ZR',
        'name' => 'Zaragoza',
      ),
    ),
    'ET' => 
    array (
      1 => 
      array (
        'code' => 'AF',
        'name' => 'Afar',
      ),
      2 => 
      array (
        'code' => 'AH',
        'name' => 'Amhara',
      ),
      3 => 
      array (
        'code' => 'BG',
        'name' => 'Benishangul-Gumaz',
      ),
      4 => 
      array (
        'code' => 'GB',
        'name' => 'Gambela',
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
        'name' => 'Somali',
      ),
      8 => 
      array (
        'code' => 'SN',
        'name' => 'Southern Nations - Nationalities',
      ),
      9 => 
      array (
        'code' => 'TG',
        'name' => 'Tigray',
      ),
      10 => 
      array (
        'code' => 'AA',
        'name' => 'Addis Ababa',
      ),
      11 => 
      array (
        'code' => 'DD',
        'name' => 'Dire Dawa',
      ),
    ),
    'FI' => 
    array (
      1 => 
      array (
        'code' => 'AL',
        'name' => 'Ahvenanmaan Laani',
      ),
      2 => 
      array (
        'code' => 'ES',
        'name' => 'Etela-Suomen Laani',
      ),
      3 => 
      array (
        'code' => 'IS',
        'name' => 'Ita-Suomen Laani',
      ),
      4 => 
      array (
        'code' => 'LS',
        'name' => 'Lansi-Suomen Laani',
      ),
      5 => 
      array (
        'code' => 'LA',
        'name' => 'Lapin Lanani',
      ),
      6 => 
      array (
        'code' => 'OU',
        'name' => 'Oulun Laani',
      ),
    ),
    'FJ' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => 'Central Division',
      ),
      2 => 
      array (
        'code' => 'E',
        'name' => 'Eastern Division',
      ),
      3 => 
      array (
        'code' => 'N',
        'name' => 'Northern Division',
      ),
      4 => 
      array (
        'code' => 'R',
        'name' => 'Rotuma',
      ),
      5 => 
      array (
        'code' => 'W',
        'name' => 'Western Division',
      ),
    ),
    'FM' => 
    array (
      1 => 
      array (
        'code' => 'C',
        'name' => 'Chuuk',
      ),
      2 => 
      array (
        'code' => 'K',
        'name' => 'Kosrae',
      ),
      3 => 
      array (
        'code' => 'P',
        'name' => 'Pohnpei',
      ),
      4 => 
      array (
        'code' => 'Y',
        'name' => 'Yap',
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
        'name' => 'Klaksvík',
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
        'name' => 'Sunda Kommuna',
      ),
      7 => 
      array (
        'code' => 'VáG',
        'name' => 'Vágur',
      ),
      8 => 
      array (
        'code' => 'NES',
        'name' => 'Nes',
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
        'name' => 'Gøtu Kommuna',
      ),
      13 => 
      array (
        'code' => 'SJû',
        'name' => 'Sjûvar Kommuna',
      ),
      14 => 
      array (
        'code' => 'LEI',
        'name' => 'Leirvík',
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
        'name' => 'Sumba',
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
        'name' => 'HÚsavík',
      ),
      28 => 
      array (
        'code' => 'HOV',
        'name' => 'Hov',
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
        'name' => 'Alsace',
      ),
      2 => 
      array (
        'code' => 'AQ',
        'name' => 'Aquitaine',
      ),
      3 => 
      array (
        'code' => 'AU',
        'name' => 'Auvergne',
      ),
      4 => 
      array (
        'code' => 'BR',
        'name' => 'Brittany',
      ),
      5 => 
      array (
        'code' => 'BU',
        'name' => 'Burgundy',
      ),
      6 => 
      array (
        'code' => 'CE',
        'name' => 'Center Loire Valley',
      ),
      7 => 
      array (
        'code' => 'CH',
        'name' => 'Champagne',
      ),
      8 => 
      array (
        'code' => 'CO',
        'name' => 'Corse',
      ),
      9 => 
      array (
        'code' => 'FR',
        'name' => 'France Comte',
      ),
      10 => 
      array (
        'code' => 'LA',
        'name' => 'Languedoc Roussillon',
      ),
      11 => 
      array (
        'code' => 'LI',
        'name' => 'Limousin',
      ),
      12 => 
      array (
        'code' => 'LO',
        'name' => 'Lorraine',
      ),
      13 => 
      array (
        'code' => 'MI',
        'name' => 'Midi Pyrenees',
      ),
      14 => 
      array (
        'code' => 'NO',
        'name' => 'Nord Pas de Calais',
      ),
      15 => 
      array (
        'code' => 'NR',
        'name' => 'Normandy',
      ),
      16 => 
      array (
        'code' => 'PA',
        'name' => 'Paris / Ile de France',
      ),
      17 => 
      array (
        'code' => 'PI',
        'name' => 'Picardie',
      ),
      18 => 
      array (
        'code' => 'PO',
        'name' => 'Poitou Charente',
      ),
      19 => 
      array (
        'code' => 'PR',
        'name' => 'Provence',
      ),
      20 => 
      array (
        'code' => 'RH',
        'name' => 'Rhone Alps',
      ),
      21 => 
      array (
        'code' => 'RI',
        'name' => 'Riviera',
      ),
      22 => 
      array (
        'code' => 'WE',
        'name' => 'Western Loire Valley',
      ),
    ),
    'FX' => 
    array (
      1 => 
      array (
        'code' => 'Et',
        'name' => 'Etranger',
      ),
      2 => 
      array (
        'code' => '01',
        'name' => 'Ain',
      ),
      3 => 
      array (
        'code' => '02',
        'name' => 'Aisne',
      ),
      4 => 
      array (
        'code' => '03',
        'name' => 'Allier',
      ),
      5 => 
      array (
        'code' => '04',
        'name' => 'Alpes de Haute Provence',
      ),
      6 => 
      array (
        'code' => '05',
        'name' => 'Hautes-Alpes',
      ),
      7 => 
      array (
        'code' => '06',
        'name' => 'Alpes Maritimes',
      ),
      8 => 
      array (
        'code' => '07',
        'name' => 'Ardèche',
      ),
      9 => 
      array (
        'code' => '08',
        'name' => 'Ardennes',
      ),
      10 => 
      array (
        'code' => '09',
        'name' => 'Ariège',
      ),
      11 => 
      array (
        'code' => '10',
        'name' => 'Aube',
      ),
      12 => 
      array (
        'code' => '11',
        'name' => 'Aude',
      ),
      13 => 
      array (
        'code' => '12',
        'name' => 'Aveyron',
      ),
      14 => 
      array (
        'code' => '13',
        'name' => 'Bouches du Rhône',
      ),
      15 => 
      array (
        'code' => '14',
        'name' => 'Calvados',
      ),
      16 => 
      array (
        'code' => '15',
        'name' => 'Cantal',
      ),
      17 => 
      array (
        'code' => '16',
        'name' => 'Charente',
      ),
      18 => 
      array (
        'code' => '17',
        'name' => 'Charente Maritime',
      ),
      19 => 
      array (
        'code' => '18',
        'name' => 'Cher',
      ),
      20 => 
      array (
        'code' => '19',
        'name' => 'Corrèze',
      ),
      21 => 
      array (
        'code' => '2A',
        'name' => 'Corse du Sud',
      ),
      22 => 
      array (
        'code' => '2B',
        'name' => 'Haute Corse',
      ),
      23 => 
      array (
        'code' => '21',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '22',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '23',
        'name' => 'Creuse',
      ),
      26 => 
      array (
        'code' => '24',
        'name' => 'Dordogne',
      ),
      27 => 
      array (
        'code' => '25',
        'name' => 'Doubs',
      ),
      28 => 
      array (
        'code' => '26',
        'name' => 'Drôme',
      ),
      29 => 
      array (
        'code' => '27',
        'name' => 'Eure',
      ),
      30 => 
      array (
        'code' => '28',
        'name' => 'Eure et Loir',
      ),
      31 => 
      array (
        'code' => '29',
        'name' => 'Finistère',
      ),
      32 => 
      array (
        'code' => '30',
        'name' => 'Gard',
      ),
      33 => 
      array (
        'code' => '31',
        'name' => 'Haute Garonne',
      ),
      34 => 
      array (
        'code' => '32',
        'name' => 'Gers',
      ),
      35 => 
      array (
        'code' => '33',
        'name' => 'Gironde',
      ),
      36 => 
      array (
        'code' => '34',
        'name' => 'Hérault',
      ),
      37 => 
      array (
        'code' => '35',
        'name' => 'Ille et Vilaine',
      ),
      38 => 
      array (
        'code' => '36',
        'name' => 'Indre',
      ),
      39 => 
      array (
        'code' => '37',
        'name' => 'Indre et Loire',
      ),
      40 => 
      array (
        'code' => '38',
        'name' => 'Isére',
      ),
      41 => 
      array (
        'code' => '39',
        'name' => 'Jura',
      ),
      42 => 
      array (
        'code' => '40',
        'name' => 'Landes',
      ),
      43 => 
      array (
        'code' => '41',
        'name' => 'Loir et Cher',
      ),
      44 => 
      array (
        'code' => '42',
        'name' => 'Loire',
      ),
      45 => 
      array (
        'code' => '43',
        'name' => 'Haute Loire',
      ),
      46 => 
      array (
        'code' => '44',
        'name' => 'Loire Atlantique',
      ),
      47 => 
      array (
        'code' => '45',
        'name' => 'Loiret',
      ),
      48 => 
      array (
        'code' => '46',
        'name' => 'Lot',
      ),
      49 => 
      array (
        'code' => '47',
        'name' => 'Lot et Garonne',
      ),
      50 => 
      array (
        'code' => '48',
        'name' => 'Lozère',
      ),
      51 => 
      array (
        'code' => '49',
        'name' => 'Maine et Loire',
      ),
      52 => 
      array (
        'code' => '50',
        'name' => 'Manche',
      ),
      53 => 
      array (
        'code' => '51',
        'name' => 'Marne',
      ),
      54 => 
      array (
        'code' => '52',
        'name' => 'Haute Marne',
      ),
      55 => 
      array (
        'code' => '53',
        'name' => 'Mayenne',
      ),
      56 => 
      array (
        'code' => '54',
        'name' => 'Meurthe et Moselle',
      ),
      57 => 
      array (
        'code' => '55',
        'name' => 'Meuse',
      ),
      58 => 
      array (
        'code' => '56',
        'name' => 'Morbihan',
      ),
      59 => 
      array (
        'code' => '57',
        'name' => 'Moselle',
      ),
      60 => 
      array (
        'code' => '58',
        'name' => 'Nièvre',
      ),
      61 => 
      array (
        'code' => '59',
        'name' => 'Nord',
      ),
      62 => 
      array (
        'code' => '60',
        'name' => 'Oise',
      ),
      63 => 
      array (
        'code' => '61',
        'name' => 'Orne',
      ),
      64 => 
      array (
        'code' => '62',
        'name' => 'Pas de Calais',
      ),
      65 => 
      array (
        'code' => '63',
        'name' => 'Puy de Dôme',
      ),
      66 => 
      array (
        'code' => '64',
        'name' => 'Pyrenees Atlantique',
      ),
      67 => 
      array (
        'code' => '65',
        'name' => 'Hautes Pyrenees',
      ),
      68 => 
      array (
        'code' => '66',
        'name' => 'Pyrenees Orientale',
      ),
      69 => 
      array (
        'code' => '67',
        'name' => 'Bas Rhin',
      ),
      70 => 
      array (
        'code' => '68',
        'name' => 'Haut Rhin',
      ),
      71 => 
      array (
        'code' => '69',
        'name' => 'Rhône',
      ),
      72 => 
      array (
        'code' => '70',
        'name' => 'Haute Saône',
      ),
      73 => 
      array (
        'code' => '71',
        'name' => 'Saône et Loire',
      ),
      74 => 
      array (
        'code' => '72',
        'name' => 'Sarthe',
      ),
      75 => 
      array (
        'code' => '73',
        'name' => 'Savoie',
      ),
      76 => 
      array (
        'code' => '74',
        'name' => 'Haute Savoie',
      ),
      77 => 
      array (
        'code' => '75',
        'name' => 'Paris',
      ),
      78 => 
      array (
        'code' => '76',
        'name' => 'Seine Martitime',
      ),
      79 => 
      array (
        'code' => '77',
        'name' => 'Seine et Marne',
      ),
      80 => 
      array (
        'code' => '78',
        'name' => 'Yvelines',
      ),
      81 => 
      array (
        'code' => '79',
        'name' => 'Deux Sèvres',
      ),
      82 => 
      array (
        'code' => '80',
        'name' => 'Somme',
      ),
      83 => 
      array (
        'code' => '81',
        'name' => 'Tarn',
      ),
      84 => 
      array (
        'code' => '82',
        'name' => 'Tarn et Garonne',
      ),
      85 => 
      array (
        'code' => '83',
        'name' => 'Var',
      ),
      86 => 
      array (
        'code' => '84',
        'name' => 'Vaucluse',
      ),
      87 => 
      array (
        'code' => '85',
        'name' => 'Vendée',
      ),
      88 => 
      array (
        'code' => '86',
        'name' => 'Vienne',
      ),
      89 => 
      array (
        'code' => '87',
        'name' => 'Haute Vienne',
      ),
      90 => 
      array (
        'code' => '88',
        'name' => 'Vosges',
      ),
      91 => 
      array (
        'code' => '89',
        'name' => 'Yonne',
      ),
      92 => 
      array (
        'code' => '90',
        'name' => 'Territoire de Belfort',
      ),
      93 => 
      array (
        'code' => '91',
        'name' => 'Essonne',
      ),
      94 => 
      array (
        'code' => '92',
        'name' => 'Hauts de Seine',
      ),
      95 => 
      array (
        'code' => '93',
        'name' => 'Seine St-Denis',
      ),
      96 => 
      array (
        'code' => '94',
        'name' => 'Val de Marne',
      ),
      97 => 
      array (
        'code' => '95',
        'name' => '',
      ),
    ),
    'GA' => 
    array (
      1 => 
      array (
        'code' => 'ES',
        'name' => 'Estuaire',
      ),
      2 => 
      array (
        'code' => 'HO',
        'name' => 'Haut-Ogooue',
      ),
      3 => 
      array (
        'code' => 'MO',
        'name' => 'Moyen-Ogooue',
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
        'name' => 'Ogooue-Ivindo',
      ),
      7 => 
      array (
        'code' => 'OL',
        'name' => 'Ogooue-Lolo',
      ),
      8 => 
      array (
        'code' => 'OM',
        'name' => 'Ogooue-Maritime',
      ),
      9 => 
      array (
        'code' => 'WN',
        'name' => 'Woleu-Ntem',
      ),
    ),
    'GB' => 
    array (
      1 => 
      array (
        'code' => 'ABN',
        'name' => 'Aberdeen',
      ),
      2 => 
      array (
        'code' => 'ABNS',
        'name' => 'Aberdeenshire',
      ),
      3 => 
      array (
        'code' => 'ANG',
        'name' => 'Anglesey',
      ),
      4 => 
      array (
        'code' => 'AGS',
        'name' => 'Angus',
      ),
      5 => 
      array (
        'code' => 'ARY',
        'name' => 'Argyll and Bute',
      ),
      6 => 
      array (
        'code' => 'BEDS',
        'name' => 'Bedfordshire',
      ),
      7 => 
      array (
        'code' => 'BERKS',
        'name' => 'Berkshire',
      ),
      8 => 
      array (
        'code' => 'BLA',
        'name' => 'Blaenau Gwent',
      ),
      9 => 
      array (
        'code' => 'BRI',
        'name' => 'Bridgend',
      ),
      10 => 
      array (
        'code' => 'BSTL',
        'name' => 'Bristol',
      ),
      11 => 
      array (
        'code' => 'BUCKS',
        'name' => 'Buckinghamshire',
      ),
      12 => 
      array (
        'code' => 'CAE',
        'name' => 'Caerphilly',
      ),
      13 => 
      array (
        'code' => 'CAMBS',
        'name' => 'Cambridgeshire',
      ),
      14 => 
      array (
        'code' => 'CDF',
        'name' => 'Cardiff',
      ),
      15 => 
      array (
        'code' => 'CARM',
        'name' => 'Carmarthenshire',
      ),
      16 => 
      array (
        'code' => 'CDGN',
        'name' => 'Ceredigion',
      ),
      17 => 
      array (
        'code' => 'CHES',
        'name' => 'Cheshire',
      ),
      18 => 
      array (
        'code' => 'CLACK',
        'name' => 'Clackmannanshire',
      ),
      19 => 
      array (
        'code' => 'CON',
        'name' => 'Conwy',
      ),
      20 => 
      array (
        'code' => 'CORN',
        'name' => 'Cornwall',
      ),
      21 => 
      array (
        'code' => 'DNBG',
        'name' => 'Denbighshire',
      ),
      22 => 
      array (
        'code' => 'DERBY',
        'name' => 'Derbyshire',
      ),
      23 => 
      array (
        'code' => 'DVN',
        'name' => 'Devon',
      ),
      24 => 
      array (
        'code' => 'DOR',
        'name' => 'Dorset',
      ),
      25 => 
      array (
        'code' => 'DGL',
        'name' => 'Dumfries and Galloway',
      ),
      26 => 
      array (
        'code' => 'DUND',
        'name' => 'Dundee',
      ),
      27 => 
      array (
        'code' => 'DHM',
        'name' => 'Durham',
      ),
      28 => 
      array (
        'code' => 'ARYE',
        'name' => 'East Ayrshire',
      ),
      29 => 
      array (
        'code' => 'DUNBE',
        'name' => 'East Dunbartonshire',
      ),
      30 => 
      array (
        'code' => 'LOTE',
        'name' => 'East Lothian',
      ),
      31 => 
      array (
        'code' => 'RENE',
        'name' => 'East Renfrewshire',
      ),
      32 => 
      array (
        'code' => 'ERYS',
        'name' => 'East Riding of Yorkshire',
      ),
      33 => 
      array (
        'code' => 'SXE',
        'name' => 'East Sussex',
      ),
      34 => 
      array (
        'code' => 'EDIN',
        'name' => 'Edinburgh',
      ),
      35 => 
      array (
        'code' => 'ESX',
        'name' => 'Essex',
      ),
      36 => 
      array (
        'code' => 'FALK',
        'name' => 'Falkirk',
      ),
      37 => 
      array (
        'code' => 'FFE',
        'name' => 'Fife',
      ),
      38 => 
      array (
        'code' => 'FLINT',
        'name' => 'Flintshire',
      ),
      39 => 
      array (
        'code' => 'GLAS',
        'name' => 'Glasgow',
      ),
      40 => 
      array (
        'code' => 'GLOS',
        'name' => 'Gloucestershire',
      ),
      41 => 
      array (
        'code' => 'LDN',
        'name' => 'Greater London',
      ),
      42 => 
      array (
        'code' => 'MCH',
        'name' => 'Greater Manchester',
      ),
      43 => 
      array (
        'code' => 'GDD',
        'name' => 'Gwynedd',
      ),
      44 => 
      array (
        'code' => 'HANTS',
        'name' => 'Hampshire',
      ),
      45 => 
      array (
        'code' => 'HWR',
        'name' => 'Herefordshire',
      ),
      46 => 
      array (
        'code' => 'HERTS',
        'name' => 'Hertfordshire',
      ),
      47 => 
      array (
        'code' => 'HLD',
        'name' => 'Highlands',
      ),
      48 => 
      array (
        'code' => 'IVER',
        'name' => 'Inverclyde',
      ),
      49 => 
      array (
        'code' => 'IOW',
        'name' => 'Isle of Wight',
      ),
      50 => 
      array (
        'code' => 'KNT',
        'name' => 'Kent',
      ),
      51 => 
      array (
        'code' => 'LANCS',
        'name' => 'Lancashire',
      ),
      52 => 
      array (
        'code' => 'LEICS',
        'name' => 'Leicestershire',
      ),
      53 => 
      array (
        'code' => 'LINCS',
        'name' => 'Lincolnshire',
      ),
      54 => 
      array (
        'code' => 'MSY',
        'name' => 'Merseyside',
      ),
      55 => 
      array (
        'code' => 'MERT',
        'name' => 'Merthyr Tydfil',
      ),
      56 => 
      array (
        'code' => 'MLOT',
        'name' => 'Midlothian',
      ),
      57 => 
      array (
        'code' => 'MMOUTH',
        'name' => 'Monmouthshire',
      ),
      58 => 
      array (
        'code' => 'MORAY',
        'name' => 'Moray',
      ),
      59 => 
      array (
        'code' => 'NPRTAL',
        'name' => 'Neath Port Talbot',
      ),
      60 => 
      array (
        'code' => 'NEWPT',
        'name' => 'Newport',
      ),
      61 => 
      array (
        'code' => 'NOR',
        'name' => 'Norfolk',
      ),
      62 => 
      array (
        'code' => 'ARYN',
        'name' => 'North Ayrshire',
      ),
      63 => 
      array (
        'code' => 'LANN',
        'name' => 'North Lanarkshire',
      ),
      64 => 
      array (
        'code' => 'YSN',
        'name' => 'North Yorkshire',
      ),
      65 => 
      array (
        'code' => 'NHM',
        'name' => 'Northamptonshire',
      ),
      66 => 
      array (
        'code' => 'NLD',
        'name' => 'Northumberland',
      ),
      67 => 
      array (
        'code' => 'NOT',
        'name' => 'Nottinghamshire',
      ),
      68 => 
      array (
        'code' => 'ORK',
        'name' => 'Orkney Islands',
      ),
      69 => 
      array (
        'code' => 'OFE',
        'name' => 'Oxfordshire',
      ),
      70 => 
      array (
        'code' => 'PEM',
        'name' => 'Pembrokeshire',
      ),
      71 => 
      array (
        'code' => 'PERTH',
        'name' => 'Perth and Kinross',
      ),
      72 => 
      array (
        'code' => 'PWS',
        'name' => 'Powys',
      ),
      73 => 
      array (
        'code' => 'REN',
        'name' => 'Renfrewshire',
      ),
      74 => 
      array (
        'code' => 'RHON',
        'name' => 'Rhondda Cynon Taff',
      ),
      75 => 
      array (
        'code' => 'RUT',
        'name' => 'Rutland',
      ),
      76 => 
      array (
        'code' => 'BOR',
        'name' => 'Scottish Borders',
      ),
      77 => 
      array (
        'code' => 'SHET',
        'name' => 'Shetland Islands',
      ),
      78 => 
      array (
        'code' => 'SPE',
        'name' => 'Shropshire',
      ),
      79 => 
      array (
        'code' => 'SOM',
        'name' => 'Somerset',
      ),
      80 => 
      array (
        'code' => 'ARYS',
        'name' => 'South Ayrshire',
      ),
      81 => 
      array (
        'code' => 'LANS',
        'name' => 'South Lanarkshire',
      ),
      82 => 
      array (
        'code' => 'YSS',
        'name' => 'South Yorkshire',
      ),
      83 => 
      array (
        'code' => 'SFD',
        'name' => 'Staffordshire',
      ),
      84 => 
      array (
        'code' => 'STIR',
        'name' => 'Stirling',
      ),
      85 => 
      array (
        'code' => 'SFK',
        'name' => 'Suffolk',
      ),
      86 => 
      array (
        'code' => 'SRY',
        'name' => 'Surrey',
      ),
      87 => 
      array (
        'code' => 'SWAN',
        'name' => 'Swansea',
      ),
      88 => 
      array (
        'code' => 'TORF',
        'name' => 'Torfaen',
      ),
      89 => 
      array (
        'code' => 'TWR',
        'name' => 'Tyne and Wear',
      ),
      90 => 
      array (
        'code' => 'VGLAM',
        'name' => 'Vale of Glamorgan',
      ),
      91 => 
      array (
        'code' => 'WARKS',
        'name' => 'Warwickshire',
      ),
      92 => 
      array (
        'code' => 'WDUN',
        'name' => 'West Dunbartonshire',
      ),
      93 => 
      array (
        'code' => 'WLOT',
        'name' => 'West Lothian',
      ),
      94 => 
      array (
        'code' => 'WMD',
        'name' => 'West Midlands',
      ),
      95 => 
      array (
        'code' => 'SXW',
        'name' => 'West Sussex',
      ),
      96 => 
      array (
        'code' => 'YSW',
        'name' => 'West Yorkshire',
      ),
      97 => 
      array (
        'code' => 'WIL',
        'name' => 'Western Isles',
      ),
      98 => 
      array (
        'code' => 'WLT',
        'name' => 'Wiltshire',
      ),
      99 => 
      array (
        'code' => 'WORCS',
        'name' => 'Worcestershire',
      ),
      100 => 
      array (
        'code' => 'WRX',
        'name' => 'Wrexham',
      ),
    ),
    'GE' => 
    array (
      1 => 
      array (
        'code' => 'AB',
        'name' => 'Abkhazia',
      ),
      2 => 
      array (
        'code' => 'AJ',
        'name' => 'Ajaria',
      ),
      3 => 
      array (
        'code' => 'GU',
        'name' => 'Guria',
      ),
      4 => 
      array (
        'code' => 'IM',
        'name' => 'Imereti',
      ),
      5 => 
      array (
        'code' => 'KA',
        'name' => 'Kakheti',
      ),
      6 => 
      array (
        'code' => 'KK',
        'name' => 'Kvemo Kartli',
      ),
      7 => 
      array (
        'code' => 'MM',
        'name' => 'Mtskheta-Mtianeti',
      ),
      8 => 
      array (
        'code' => 'RL',
        'name' => 'Racha Lechkhumi and Kvemo Svanet',
      ),
      9 => 
      array (
        'code' => 'SJ',
        'name' => 'Samtskhe-Javakheti',
      ),
      10 => 
      array (
        'code' => 'SK',
        'name' => 'Shida Kartli',
      ),
      11 => 
      array (
        'code' => 'SZ',
        'name' => 'Samegrelo-Zemo Svaneti',
      ),
      12 => 
      array (
        'code' => 'TB',
        'name' => 'Tbilisi',
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
        'name' => 'Mana',
      ),
      3 => 
      array (
        'code' => 'SAI',
        'name' => 'Saint-Laurent-Du-Maroni',
      ),
      4 => 
      array (
        'code' => 'APA',
        'name' => 'Apatou',
      ),
      5 => 
      array (
        'code' => 'GRA',
        'name' => 'Grand-Santi',
      ),
      6 => 
      array (
        'code' => 'PAP',
        'name' => 'Papaïchton',
      ),
      7 => 
      array (
        'code' => 'SAÜ',
        'name' => 'SaÜl',
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
        'name' => 'Saint-Georges',
      ),
      11 => 
      array (
        'code' => 'OUA',
        'name' => 'Ouanary',
      ),
      12 => 
      array (
        'code' => 'RéG',
        'name' => 'Régina',
      ),
      13 => 
      array (
        'code' => 'ROU',
        'name' => 'Roura',
      ),
      14 => 
      array (
        'code' => 'SAI',
        'name' => 'Saint-élie',
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
        'name' => 'Kourou',
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
        'name' => 'Matoury',
      ),
      21 => 
      array (
        'code' => 'CAY',
        'name' => 'Cayenne',
      ),
      22 => 
      array (
        'code' => 'REM',
        'name' => 'Remire-Montjoly',
      ),
    ),
    'GH' => 
    array (
      1 => 
      array (
        'code' => 'AS',
        'name' => 'Ashanti Region',
      ),
      2 => 
      array (
        'code' => 'BA',
        'name' => 'Brong-Ahafo Region',
      ),
      3 => 
      array (
        'code' => 'CE',
        'name' => 'Central Region',
      ),
      4 => 
      array (
        'code' => 'EA',
        'name' => 'Eastern Region',
      ),
      5 => 
      array (
        'code' => 'GA',
        'name' => 'Greater Accra Region',
      ),
      6 => 
      array (
        'code' => 'NO',
        'name' => 'Northern Region',
      ),
      7 => 
      array (
        'code' => 'UE',
        'name' => 'Upper East Region',
      ),
      8 => 
      array (
        'code' => 'UW',
        'name' => 'Upper West Region',
      ),
      9 => 
      array (
        'code' => 'VO',
        'name' => 'Volta Region',
      ),
      10 => 
      array (
        'code' => 'WE',
        'name' => 'Western Region',
      ),
    ),
    'GI' => 
    array (
      1 => 
      array (
        'code' => 'EAS',
        'name' => 'East Side',
      ),
      2 => 
      array (
        'code' => 'NOR',
        'name' => 'North District',
      ),
      3 => 
      array (
        'code' => 'REC',
        'name' => 'Reclamation Areas',
      ),
      4 => 
      array (
        'code' => 'SAN',
        'name' => 'Sandpits Area',
      ),
      5 => 
      array (
        'code' => 'SOU',
        'name' => 'South District',
      ),
      6 => 
      array (
        'code' => 'TOW',
        'name' => 'Town Area',
      ),
      7 => 
      array (
        'code' => 'UPP',
        'name' => 'Upper Town',
      ),
      8 => 
      array (
        'code' => 'OTH',
        'name' => 'Other',
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
        'name' => 'Banjul',
      ),
      2 => 
      array (
        'code' => 'BS',
        'name' => 'Basse',
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
        'name' => 'Lower River',
      ),
      10 => 
      array (
        'code' => 'CR',
        'name' => 'Central River',
      ),
      11 => 
      array (
        'code' => 'NB',
        'name' => 'North Bank',
      ),
      12 => 
      array (
        'code' => 'UR',
        'name' => 'Upper River',
      ),
      13 => 
      array (
        'code' => 'WE',
        'name' => 'Western',
      ),
    ),
    'GN' => 
    array (
      1 => 
      array (
        'code' => 'CNK',
        'name' => 'Conakry',
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
        'name' => 'Boke',
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
        'name' => 'Fria',
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
        'name' => 'Kankan',
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
        'name' => 'Kissidougou',
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
        'name' => 'Labe',
      ),
      23 => 
      array (
        'code' => 'LLM',
        'name' => 'Lelouma',
      ),
      24 => 
      array (
        'code' => 'LOL',
        'name' => 'Lola',
      ),
      25 => 
      array (
        'code' => 'MCT',
        'name' => 'Macenta',
      ),
      26 => 
      array (
        'code' => 'MAL',
        'name' => 'Mali',
      ),
      27 => 
      array (
        'code' => 'MAM',
        'name' => 'Mamou',
      ),
      28 => 
      array (
        'code' => 'MAN',
        'name' => 'Mandiana',
      ),
      29 => 
      array (
        'code' => 'NZR',
        'name' => 'Nzerekore',
      ),
      30 => 
      array (
        'code' => 'PIT',
        'name' => 'Pita',
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
        'name' => 'Tougue',
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
        'name' => 'Arrondissements Of The Guadeloup',
      ),
      2 => 
      array (
        'code' => 'CAN',
        'name' => 'Cantons Of The Guadeloup Depart',
      ),
      3 => 
      array (
        'code' => 'COM',
        'name' => 'Communes Of The Guadeloup Depart',
      ),
    ),
    'GQ' => 
    array (
      1 => 
      array (
        'code' => 'AN',
        'name' => 'Provincia Annobon',
      ),
      2 => 
      array (
        'code' => 'BN',
        'name' => 'Provincia Bioko Norte',
      ),
      3 => 
      array (
        'code' => 'BS',
        'name' => 'Provincia Bioko Sur',
      ),
      4 => 
      array (
        'code' => 'CS',
        'name' => 'Provincia Centro Sur',
      ),
      5 => 
      array (
        'code' => 'KN',
        'name' => 'Provincia Kie-Ntem',
      ),
      6 => 
      array (
        'code' => 'LI',
        'name' => 'Provincia Litoral',
      ),
      7 => 
      array (
        'code' => 'WN',
        'name' => 'Provincia Wele-Nzas',
      ),
    ),
    'GR' => 
    array (
      1 => 
      array (
        'code' => 'AT',
        'name' => 'Attica',
      ),
      2 => 
      array (
        'code' => 'CN',
        'name' => 'Central Greece',
      ),
      3 => 
      array (
        'code' => 'CM',
        'name' => 'Central Macedonia',
      ),
      4 => 
      array (
        'code' => 'CR',
        'name' => 'Crete',
      ),
      5 => 
      array (
        'code' => 'EM',
        'name' => 'East Macedonia and Thrace',
      ),
      6 => 
      array (
        'code' => 'EP',
        'name' => 'Epirus',
      ),
      7 => 
      array (
        'code' => 'II',
        'name' => 'Ionian Islands',
      ),
      8 => 
      array (
        'code' => 'NA',
        'name' => 'North Aegean',
      ),
      9 => 
      array (
        'code' => 'PP',
        'name' => 'Peloponnesos',
      ),
      10 => 
      array (
        'code' => 'SA',
        'name' => 'South Aegean',
      ),
      11 => 
      array (
        'code' => 'TH',
        'name' => 'Thessaly',
      ),
      12 => 
      array (
        'code' => 'WG',
        'name' => 'West Greece',
      ),
      13 => 
      array (
        'code' => 'WM',
        'name' => 'West Macedonia',
      ),
    ),
    'GT' => 
    array (
      1 => 
      array (
        'code' => 'AV',
        'name' => 'Alta Verapaz',
      ),
      2 => 
      array (
        'code' => 'BV',
        'name' => 'Baja Verapaz',
      ),
      3 => 
      array (
        'code' => 'CM',
        'name' => 'Chimaltenango',
      ),
      4 => 
      array (
        'code' => 'CQ',
        'name' => 'Chiquimula',
      ),
      5 => 
      array (
        'code' => 'PE',
        'name' => 'El Peten',
      ),
      6 => 
      array (
        'code' => 'PR',
        'name' => 'El Progreso',
      ),
      7 => 
      array (
        'code' => 'QC',
        'name' => 'El Quiche',
      ),
      8 => 
      array (
        'code' => 'ES',
        'name' => 'Escuintla',
      ),
      9 => 
      array (
        'code' => 'GU',
        'name' => 'Guatemala',
      ),
      10 => 
      array (
        'code' => 'HU',
        'name' => 'Huehuetenango',
      ),
      11 => 
      array (
        'code' => 'IZ',
        'name' => 'Izabal',
      ),
      12 => 
      array (
        'code' => 'JA',
        'name' => 'Jalapa',
      ),
      13 => 
      array (
        'code' => 'JU',
        'name' => 'Jutiapa',
      ),
      14 => 
      array (
        'code' => 'QZ',
        'name' => 'Quetzaltenango',
      ),
      15 => 
      array (
        'code' => 'RE',
        'name' => 'Retalhuleu',
      ),
      16 => 
      array (
        'code' => 'ST',
        'name' => 'Sacatepequez',
      ),
      17 => 
      array (
        'code' => 'SM',
        'name' => 'San Marcos',
      ),
      18 => 
      array (
        'code' => 'SR',
        'name' => 'Santa Rosa',
      ),
      19 => 
      array (
        'code' => 'SO',
        'name' => 'Solola',
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
        'name' => 'Agana Heights',
      ),
      2 => 
      array (
        'code' => 'AGA',
        'name' => 'Agat',
      ),
      3 => 
      array (
        'code' => 'ASA',
        'name' => 'Asan Maina',
      ),
      4 => 
      array (
        'code' => 'BAR',
        'name' => 'Barrigada',
      ),
      5 => 
      array (
        'code' => 'CHA',
        'name' => 'Chalan Pago Ordot',
      ),
      6 => 
      array (
        'code' => 'DED',
        'name' => 'Dededo',
      ),
      7 => 
      array (
        'code' => 'HAG',
        'name' => 'HagÅtña',
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
        'name' => 'Mongmong Toto Maite',
      ),
      12 => 
      array (
        'code' => 'PIT',
        'name' => 'Piti',
      ),
      13 => 
      array (
        'code' => 'SAN',
        'name' => 'Santa Rita',
      ),
      14 => 
      array (
        'code' => 'SIN',
        'name' => 'Sinajana',
      ),
      15 => 
      array (
        'code' => 'TAL',
        'name' => 'Talofofo',
      ),
      16 => 
      array (
        'code' => 'TAM',
        'name' => 'Tamuning',
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
        'name' => 'Yona',
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
        'code' => 'DG',
        'name' => 'Diego Garcia',
      ),
      2 => 
      array (
        'code' => 'DI',
        'name' => 'Danger Island',
      ),
      3 => 
      array (
        'code' => 'EA',
        'name' => 'Eagle Islands',
      ),
      4 => 
      array (
        'code' => 'EG',
        'name' => 'Egmont Islands',
      ),
      5 => 
      array (
        'code' => 'NI',
        'name' => 'Nelsons Island',
      ),
      6 => 
      array (
        'code' => 'PB',
        'name' => 'Peros Banhos',
      ),
      7 => 
      array (
        'code' => 'SI',
        'name' => 'Salomon Islands',
      ),
      8 => 
      array (
        'code' => 'TB',
        'name' => 'Three Brothers',
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
        'code' => 'BA',
        'name' => 'Battambang',
      ),
      2 => 
      array (
        'code' => 'BM',
        'name' => 'Banteay Meanchey',
      ),
      3 => 
      array (
        'code' => 'KB',
        'name' => 'Keb',
      ),
      4 => 
      array (
        'code' => 'KK',
        'name' => 'Kaoh Kong',
      ),
      5 => 
      array (
        'code' => 'KL',
        'name' => 'Kandal',
      ),
      6 => 
      array (
        'code' => 'KM',
        'name' => 'Kampong Cham',
      ),
      7 => 
      array (
        'code' => 'KN',
        'name' => 'Kampong Chhnang',
      ),
      8 => 
      array (
        'code' => 'KO',
        'name' => 'Kampong Som',
      ),
      9 => 
      array (
        'code' => 'KP',
        'name' => 'Kampot',
      ),
      10 => 
      array (
        'code' => 'KR',
        'name' => 'Kratie',
      ),
      11 => 
      array (
        'code' => 'KT',
        'name' => 'Kampong Thom',
      ),
      12 => 
      array (
        'code' => 'KU',
        'name' => 'Kampong Speu',
      ),
      13 => 
      array (
        'code' => 'MK',
        'name' => 'Mondul Kiri',
      ),
      14 => 
      array (
        'code' => 'OM',
        'name' => 'Oddar Meancheay',
      ),
      15 => 
      array (
        'code' => 'PA',
        'name' => 'Pailin',
      ),
      16 => 
      array (
        'code' => 'PG',
        'name' => 'Prey Veng',
      ),
      17 => 
      array (
        'code' => 'PP',
        'name' => 'Phnom Penh',
      ),
      18 => 
      array (
        'code' => 'PR',
        'name' => 'Preah Vihear',
      ),
      19 => 
      array (
        'code' => 'PS',
        'name' => 'Preah Seihanu (Kompong Som or Si)',
      ),
      20 => 
      array (
        'code' => 'PU',
        'name' => 'Pursat',
      ),
      21 => 
      array (
        'code' => 'RK',
        'name' => 'Ratanak Kiri',
      ),
      22 => 
      array (
        'code' => 'SI',
        'name' => 'Siemreap',
      ),
      23 => 
      array (
        'code' => 'SR',
        'name' => 'Svay Rieng',
      ),
      24 => 
      array (
        'code' => 'ST',
        'name' => 'Stung Treng',
      ),
      25 => 
      array (
        'code' => 'TK',
        'name' => 'Takeo',
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
        'code' => 'G',
        'name' => 'Grande Comore',
      ),
      2 => 
      array (
        'code' => 'A',
        'name' => 'Anjouan',
      ),
      3 => 
      array (
        'code' => 'M',
        'name' => 'Moheli',
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
        'code' => 'CR',
        'name' => 'Creek',
      ),
      2 => 
      array (
        'code' => 'EA',
        'name' => 'Eastern',
      ),
      3 => 
      array (
        'code' => 'ML',
        'name' => 'Midland',
      ),
      4 => 
      array (
        'code' => 'ST',
        'name' => 'South Town',
      ),
      5 => 
      array (
        'code' => 'SP',
        'name' => 'Spot Bay',
      ),
      6 => 
      array (
        'code' => 'SK',
        'name' => 'Stake Bay',
      ),
      7 => 
      array (
        'code' => 'WD',
        'name' => 'West End',
      ),
      8 => 
      array (
        'code' => 'WN',
        'name' => 'Western',
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
        'code' => 'BA',
        'name' => 'Batha',
      ),
      2 => 
      array (
        'code' => 'BI',
        'name' => 'Biltine',
      ),
      3 => 
      array (
        'code' => 'BE',
        'name' => 'Borkou-Ennedi-Tibesti',
      ),
      4 => 
      array (
        'code' => 'CB',
        'name' => 'Chari-Baguirmi',
      ),
      5 => 
      array (
        'code' => 'GU',
        'name' => 'Guera',
      ),
      6 => 
      array (
        'code' => 'KA',
        'name' => 'Kanem',
      ),
      7 => 
      array (
        'code' => 'LA',
        'name' => 'Lac',
      ),
      8 => 
      array (
        'code' => 'LC',
        'name' => 'Logone Occidental',
      ),
      9 => 
      array (
        'code' => 'LR',
        'name' => 'Logone Oriental',
      ),
      10 => 
      array (
        'code' => 'MK',
        'name' => 'Mayo-Kebbi',
      ),
      11 => 
      array (
        'code' => 'MC',
        'name' => 'Moyen-Chari',
      ),
      12 => 
      array (
        'code' => 'OU',
        'name' => 'Ouaddai',
      ),
      13 => 
      array (
        'code' => 'SA',
        'name' => 'Salamat',
      ),
      14 => 
      array (
        'code' => 'TA',
        'name' => 'Tandjile',
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
    'A045' => 'Incorporator',
    'A046' => 'Joint Venturer',
    'A047' => 'Shareholder',
    'A0A1' => 'Owner',
    'A0A2' => 'Partner',
    'A0A3' => 'Managing Partner',
    'A0AA' => 'Co-Partner',
    'A0AB' => 'Corporate General Partner',
    'A0AC' => 'Senior General Partner',
    'A0AD' => 'Senior Partner',
    'A0AE' => 'General Partner',
    'A0AF' => 'General Limited Partner',
    'A0AG' => 'Limited Partner',
    'A0AH' => 'Individual General Partner',
    'A0AI' => 'Individual Partner',
    'A0AJ' => 'Manager/Partner',
    'A0AL' => 'Managing General Partner',
    'A0AM' => 'Managing Limited Partner',
    'A0AQ' => 'Co-Owner',
    'A0AS' => 'Co-Executor',
    'A0AT' => 'Co-Trustee',
    'A0AV' => 'Co-Venturer',
    'A0AY' => 'Managing Trustee',
    'A0AZ' => 'Receiver',
    'A0GX' => 'Adventurer',
    'A0R0' => 'Executor',
    'A0R3' => 'Co-Adventurer',
    'A117' => 'Chief Marketing Officer',
    'A154' => 'Chief Investment Officer',
    'A189' => 'C-Level Support',
    'A199' => 'Officer',
    'A1A4' => 'Chairman of the Board',
    'A1A5' => 'Vice-Chairman',
    'A1A6' => 'President',
    'A1A7' => 'Chief Executive Officer',
    'A1A8' => 'Chief Operating Officer',
    'A1A9' => 'Chief Financial Officer',
    'A1B0' => 'Treasurer',
    'A1B2' => 'Secretary',
    'A1B3' => 'Subsidiary President',
    'A1B4' => 'Division President',
    'A1B5' => 'Senior Corporate Officer',
    'A1BA' => 'Chairman',
    'A1BB' => 'Co-Chairman',
    'A1BD' => 'Co-Chairman of the Board',
    'A1BE' => 'Deputy Chairman of the Board',
    'A1BF' => 'Executive Chairman of the Board',
    'A1BH' => 'General Chairman of the Board',
    'A1BI' => 'Senior Chairman of the Board',
    'A1BJ' => 'Acting Chairman of the Board',
    'A1BO' => 'Advisory Chairman of the Board',
    'A1BP' => 'Chairman Advisory Committee',
    'A1BU' => 'Chairman Emeritus',
    'A1BV' => 'Chairman Executive Committee',
    'A1BX' => 'Chairman Finance Committee',
    'A1BY' => 'Chairman Trust Committee',
    'A1BZ' => 'Co-Chairman Executive Committee',
    'A1CA' => 'Senior Vice-Chairman of the Board',
    'A1CB' => 'Vice-Chairman of the Board',
    'A1CG' => 'Co-President',
    'A1CH' => 'Acting President',
    'A1CJ' => 'President-Operations',
    'A1CK' => 'President of Trustees',
    'A1CL' => 'President Emeritus',
    'A1CN' => 'Acting CEO',
    'A1CO' => 'Chief Administrator',
    'A1CP' => 'Co-Chief Executive Officer',
    'A1CQ' => 'Co-Chief Financial Officer',
    'A1CR' => 'Co-Chief Operating Officer',
    'A1CS' => 'Executive Board Member',
    'A1CT' => 'Executive Managing Director',
    'A1CU' => 'Executive Officer',
    'A1CW' => 'Founder',
    'A1CX' => 'Chief Credit Officer',
    'A1CY' => 'Acting Chief Financial Officer',
    'A1G7' => 'Board of Directors',
    'A1R1' => 'Trustee',
    'A2AP' => 'Trust General Partner',
    'A2D1' => 'Services Executive',
    'A2D2' => 'Top Executive',
    'A2IU' => 'Authority Director',
    'A2IV' => 'Senior Investment Officer',
    'A2IW' => 'Senior Trust Officer',
    'A2IX' => 'Trust Investment Officer',
    'A2IY' => 'Trust Officer',
    'A2IZ' => 'Trust Personnel Officer',
    'A589' => 'VP-Level Support',
    'A598' => 'Management Vice-President',
    'A599' => 'Executive',
    'A5D3' => 'Division Vice-President',
    'A5D4' => 'Executive Vice-President',
    'A5D6' => 'Group Vice-President',
    'A5D7' => 'Senior Vice-President',
    'A5D8' => 'Vice-President',
    'A5DL' => 'Executive Vice-President Emeritus',
    'A5DM' => 'General Executive Vice-President',
    'A5DN' => 'Group Executive',
    'A5DO' => 'Associate Vice-President',
    'A5DP' => 'Regional Vice-President',
    'A5DQ' => 'Senior Executive Vice-President',
    'A5DR' => 'Senior Vice-President Emeritus',
    'A5DS' => 'Divisional/Regional Vice-President',
    'A5DT' => 'Vice-President Wholesale Division',
    'A5I5' => 'Vice-President Business Development',
    'A5I9' => 'Vice-President of Business',
    'A615' => 'Director of Case Management',
    'A626' => 'Director of Laboratory',
    'A627' => 'Associate Director',
    'A636' => 'Social Director',
    'A644' => 'Director of Planning and Corporate Development',
    'A645' => 'Creative Director',
    'A646' => 'Director of Communications',
    'A647' => 'Director of Radiology',
    'A655' => 'Director of Pharmacy Services',
    'A65A' => 'Director of Pharmacy',
    'A663' => 'Director of Environmental Services',
    'A689' => 'Director-Level Support',
    'A6A1' => 'Senior Director',
    'A6A2' => 'Director of Telecommunications',
    'A6AA' => 'Director of Operating Room',
    'A6BA' => 'Director of Patient Care/Nursing',
    'A6BZ' => 'Director of Infection Control',
    'A6C7' => 'Director of Risk Management',
    'A6DU' => 'Division/Subsidiary Head',
    'A746' => 'Communications Manager',
    'A789' => 'Manager-Level Support',
    'A7DU' => 'Managing Officer',
    'A8DV' => 'Assistant to the President',
    'A957' => 'Advisory Board Member',
    'A998' => 'Staff',
    'A9CD' => 'Honorary Chairman of the Board',
    'A9DW' => 'Co-Founder',
    'A9DX' => 'Exploration',
    'A9DY' => 'Honorary Trustee',
    'A9DZ' => 'Interim President',
    'A9EA' => 'Inactive President',
    'AB47' => 'Chief of Radiology',
    'ABA1' => 'Chief of Cardiology',
    'ABA2' => 'Director ICU/Coronary Care Unit',
    'ABA3' => 'Chief of Surgery',
    'ABA4' => 'Chief of Medicine',
    'ABA5' => 'Chief of Anesthesiology',
    'ABA6' => 'Chief of Emergency Room',
    'ABA7' => 'Director of Surgery',
    'ABAB' => 'Chief of Pathology',
    'ABBA' => 'Chief of Obstetrics/Gynecology',
    'ADA4' => 'Director of Records',
    'ADZ9' => 'Director of Volunteer',
    'B0A1' => 'Chief Administrative Officer',
    'B1EB' => 'Regional President',
    'B1R2' => 'Principal',
    'B1R3' => 'Assistant Principal',
    'B5D0' => 'Vice-President Administration',
    'B5E2' => 'Vice-President Corporate Development',
    'B5E6' => 'Vice-President Government Relations',
    'B5F4' => 'Vice-President Merger Acquisition',
    'B618' => 'Director of Security',
    'B635' => 'Director of Patient Accounts',
    'B699' => 'Administration Director',
    'B6EC' => 'Administrative Director',
    'B6ED' => 'Co-Management Director',
    'B6EE' => 'Director Shareholder Services',
    'B6EF' => 'Regional Director',
    'B6EH' => 'Senior Managing Director',
    'B6H2' => 'Executive Director',
    'B6H8' => 'Managing Director',
    'B6J3' => 'Store Director',
    'B7AB' => 'Practice Manager',
    'B7EI' => 'Administrative Manager',
    'B7EJ' => 'Program Manager',
    'B7EK' => 'Regional Manager',
    'B7EL' => 'Station Manager',
    'B7J0' => 'Area Manager',
    'B7J1' => 'Area Supervisor',
    'B7J8' => 'Administration Manager',
    'B7K0' => 'Department Manager',
    'B7K3' => 'Branch Manager',
    'B7L3' => 'District Manager',
    'B7L4' => 'Division Manager',
    'B7M1' => 'General Manager',
    'B7M2' => 'Government Relations Manager',
    'B7N2' => 'Office Manager',
    'B7N6' => 'Planning Manager',
    'B7P5' => 'Store Manager',
    'B7XA' => 'Nurse Manager',
    'B801' => 'Executive Assistant',
    'B806' => 'Administrative Secretary',
    'B830' => 'Assistant Administrator',
    'B899' => 'Administrative Assistant',
    'B8B8' => 'Office Administrator',
    'B914' => 'Department Chairman',
    'B927' => 'Office Supervisor',
    'B928' => 'Meeting Planner',
    'B9EM' => 'Administrator',
    'B9EN' => 'City Manager',
    'B9EO' => 'Interim Manager',
    'B9EP' => 'Management',
    'B9EQ' => 'Planning Staff',
    'B9ME' => 'Government Relations',
    'BB47' => 'Chief Nursing Officer',
    'C1AC' => 'Telecommunications Executive',
    'C1C1' => 'Executive of Information Technology',
    'C1D9' => 'Senior Network Engineer',
    'C1DC' => 'Senior Software Engineer',
    'C2A1' => 'Chief Information Officer',
    'C2A2' => 'Chief Technology Officer',
    'C2C1' => 'Data Processing Executive',
    'C2P3' => 'Chief Information Security Officer',
    'C599' => 'Vice-President Systems',
    'C5E8' => 'Vice-President Information Services',
    'C601' => 'Director of Quality Improvement',
    'C624' => 'Director of Information Technology',
    'C699' => 'Systems Director',
    'C6G8' => 'Director of Data Processing',
    'C6I3' => 'Director of MIS/IS',
    'C6J1' => 'Computer Lab Director',
    'C6P9' => 'Quality Assurance Director',
    'C724' => 'Computer Manager',
    'C799' => 'Systems Manager',
    'C7BB' => 'Systems Administrator',
    'C7BC' => 'Telecommunications Manager',
    'C7C7' => 'Information Technology Manager',
    'C7E8' => 'Manager of Information Services',
    'C7H1' => 'Web Project Manager',
    'C7J1' => 'Network Manager',
    'C7K9' => 'Data Processing Manager',
    'C7L5' => 'Data Processing Operations Manager',
    'C7N1' => 'Manager of Management Information Systems',
    'C7P7' => 'Systems/Programming Manager',
    'C7P8' => 'Systems Support Manager',
    'C7P9' => 'Quality Assurance Manager',
    'C7X9' => 'Manager of Information',
    'C7XZ' => 'Technical Manager',
    'C899' => 'Systems Assistant',
    'C8B9' => 'Technology/Computer Coordinator',
    'C8C8' => 'Information Technology Project Manager',
    'C8CC' => 'Web Developer',
    'C8CD' => 'Software Developer',
    'C8DC' => 'Software Engineer',
    'C8DD' => 'Systems Engineer',
    'C8X1' => 'Network Engineer',
    'C912' => 'Data Processing Supervisor',
    'C918' => 'Telecommunications Staff',
    'C939' => 'Senior Systems Analyst',
    'C940' => 'Systems Analyst',
    'C941' => 'Network Analyst',
    'C999' => 'Systems Staff',
    'C9A1' => 'Computer Scientist',
    'C9A2' => 'Computer Specialist',
    'C9A3' => 'Computer Technician',
    'C9A4' => 'Computers',
    'C9A5' => 'Information Systems',
    'C9A6' => 'Management Information Systems Staff',
    'C9A7' => 'Programmer',
    'C9A8' => 'Programmer Analyst',
    'C9A9' => 'Project Leader',
    'C9B1' => 'Data Consultant',
    'C9B2' => 'Webmaster',
    'C9B3' => 'Database Administrator',
    'C9B4' => 'Application Consultant',
    'C9B5' => 'Business Analyst',
    'C9B6' => 'Data Administrator',
    'C9B7' => 'Systems Technician',
    'C9B8' => 'Information Technology/Internet Support',
    'C9B9' => 'Technician',
    'C9CX' => 'Technology Architect',
    'C9ER' => 'Data Processing Staff',
    'C9F8' => 'Technical Recruiter',
    'C9P3' => 'IT Security',
    'C9X1' => 'Network Technician',
    'C9XZ' => 'Information Technology Specialist',
    'D2C2' => 'Engineering Executive',
    'D599' => 'Vice-President Engineering-Research & Development',
    'D5E4' => 'Vice-President Engineering',
    'D5E5' => 'Vice-President Development',
    'D5G1' => 'Vice-President Research and Technology',
    'D699' => 'Director of Engineering',
    'D6ET' => 'Technical Director',
    'D6EZ' => 'Development Director',
    'D6O0' => 'Research Development Director',
    'D799' => 'Engineering-Research and Development Manager',
    'D7EU' => 'Chief Project Engineer',
    'D7EV' => 'Project Administrator',
    'D7EW' => 'Project Coordinator',
    'D7EX' => 'Project Director',
    'D7EY' => 'Project Executive',
    'D7EZ' => 'Development Manager',
    'D7L1' => 'Design Engineering Manager',
    'D7L7' => 'Engineering Manager',
    'D7M5' => 'Industrial Engineering Manager',
    'D7O0' => 'Research and Development Manager',
    'D7O1' => 'Product Engineering Manager',
    'D7O4' => 'Project Manager',
    'D899' => 'Engineering-Research and Development Assistant',
    'D901' => 'Electrical Engineer',
    'D915' => 'Draftsmen/Designer',
    'D916' => 'Engineer',
    'D917' => 'Chief Engineer',
    'D918' => 'Senior Engineer',
    'D963' => 'Conservation Technician',
    'D999' => 'Engineering-Research and Development',
    'D9EZ' => 'Development',
    'D9FA' => 'Engineering Staff',
    'D9FB' => 'Industrial',
    'D9FC' => 'Research',
    'D9FD' => 'Technology',
    'D9FE' => 'Technical Staff',
    'D9IU' => 'Research And Development Staff',
    'D9X1' => 'Graphic Designer',
    'D9X9' => 'Project Engineer',
    'DZ25' => 'Design Engineer',
    'E1FF' => 'Investment Officer',
    'E2C4' => 'Financial Executive',
    'E5D9' => 'Vice-President Accounting',
    'E5E5' => 'Vice-President Finance',
    'E6D9' => 'Chief Accountant',
    'E6FG' => 'Director of Finance',
    'E6FH' => 'Financial Officer',
    'E6FI' => 'Loan Officer',
    'E6G4' => 'Accounting Director',
    'E7FE' => 'Financial Advisor',
    'E7FF' => 'Investment Manager',
    'E7FJ' => 'Trust Manager',
    'E7G2' => 'Portfolio Manager',
    'E7J7' => 'Accounting Manager',
    'E7K1' => 'Auditing Manager',
    'E7K4' => 'Business Manager',
    'E7K7' => 'Credit Manager',
    'E7K9' => 'Contract Manager',
    'E7L9' => 'Finance Manager',
    'E7P9' => 'Taxes Manager',
    'E7S9' => 'Stockbroker',
    'E899' => 'Finance Assistant',
    'E8Q6' => 'Assistant Controller',
    'E8Q9' => 'Assistant Treasurer',
    'E901' => 'Accountant',
    'E902' => 'Certified Public Accountant',
    'E903' => 'Tax Preparer',
    'E906' => 'Auditor',
    'E908' => 'Comptroller',
    'E909' => 'Controller',
    'E917' => 'Finance Supervisor',
    'E920' => 'Broker',
    'E944' => 'Bookkeeper',
    'E999' => 'Finance-Other',
    'E9E6' => 'Finance Secretary',
    'E9E7' => 'Senior Financial Analyst',
    'E9E9' => 'Financial Analyst',
    'E9FK' => 'Accounting Staff',
    'E9FL' => 'Credit Staff',
    'E9FM' => 'Finance',
    'E9FN' => 'Installment',
    'E9FO' => 'Loan',
    'E9FP' => 'Mortgage',
    'E9FQ' => 'Trust',
    'E9FR' => 'Securities',
    'E9FS' => 'Acting Controller',
    'E9FZ' => 'Analyst',
    'EZ20' => 'Associate Broker',
    'F2A9' => 'C-Level Human Resources',
    'F2C9' => 'Personnel Executive',
    'F599' => 'Vice-President Personnel',
    'F5E7' => 'Vice-President Human Resources',
    'F6FV' => 'Recruiting Director',
    'F6G0' => 'Employee Relations Director',
    'F6H4' => 'Human Resources Director',
    'F6H5' => 'Industrial Relations Director',
    'F6I6' => 'Personnel Director',
    'F6J5' => 'Training and Development Director',
    'F6J6' => 'Training Director',
    'F7B1' => 'Human Resources Coordinator',
    'F7FF' => 'Payroll Manager',
    'F7FR' => 'Employee Benefits Manager',
    'F7FS' => 'Fund Manager',
    'F7FT' => 'Pension Plan Manager',
    'F7FU' => 'Profit Sharing Plan Manager',
    'F7FV' => 'Recruiting Manager',
    'F7K2' => 'Benefits Manager',
    'F7K5' => 'Compensation Manager',
    'F7L6' => 'Employee Relations Manager',
    'F7M4' => 'Human Resources Manager',
    'F7M6' => 'Industrial Relations Manager',
    'F7N5' => 'Personnel Manager',
    'F7Q2' => 'Training and Development Manager',
    'F7Q3' => 'Training Supervisor',
    'F898' => 'Human Resources',
    'F899' => 'Personnel Assistant',
    'F8C9' => 'Human Resources Information Management Analyst',
    'F8Z8' => 'Human Resources Consultant',
    'F8Z9' => 'Human Resources Analyst',
    'F8ZZ' => 'Payroll Staff',
    'F9B1' => 'Human Resources Administrator',
    'F9FV' => 'Recruiter',
    'F9FW' => 'Personnel',
    'F9Q2' => 'Training Specialist',
    'G299' => 'Purchasing Officer',
    'G599' => 'Purchasing Vice-President',
    'G5F0' => 'Vice-President Purchasing/Procurement',
    'G629' => 'Business/Finance/Purchasing Director',
    'G698' => 'Procurement Director',
    'G699' => 'Purchasing Director',
    'G6I9' => 'Chief Purchasing Officer',
    'G798' => 'Procurement Manager',
    'G7O6' => 'Purchasing Manager',
    'G899' => 'Purchasing Assistant',
    'G906' => 'Senior Buyer',
    'G907' => 'Buyer',
    'G933' => 'Purchasing Agent',
    'G989' => 'Procurement Staff',
    'G9FX' => 'Purchasing',
    'H2C8' => 'Manufacturing/Production/Distribution Executive',
    'H599' => 'Vice-President Operations/Production/Manufacturing',
    'H5F1' => 'Vice-President Manufacturing',
    'H5F5' => 'Vice-President Operations',
    'H5F8' => 'Vice-President Production',
    'H699' => 'Director of Operations-Production/Manufacturing',
    'H6FY' => 'Director of Operations',
    'H6H9' => 'Manufacturing Director',
    'H6I0' => 'Safety Director',
    'H6I1' => 'Materials Director',
    'H6I7' => 'Production Director',
    'H6J4' => 'Traffic Director',
    'H6O7' => 'Quality Control Director',
    'H799' => 'Operations-Production/Manufacturing',
    'H7A0' => 'Materials Manager',
    'H7B7' => 'Site Manager',
    'H7D5' => 'Mill Manager',
    'H7FZ' => 'Mine Manager',
    'H7GA' => 'Export Manager',
    'H7H7' => 'Operations Supervisor',
    'H7H9' => 'Fleet  Manager',
    'H7I0' => 'Safety Manager',
    'H7L0' => 'Front End Manager',
    'H7L2' => 'Distribution/Shipping/Transportation Manager',
    'H7M0' => 'Manufacturing Manager',
    'H7M7' => 'Inventory Control Manager',
    'H7N3' => 'Operations Manager',
    'H7N4' => 'Packing Engineer Manager',
    'H7N8' => 'Plant Engineering Manager',
    'H7N9' => 'Plant Manager',
    'H7O3' => 'Production Manager',
    'H7O7' => 'Quality Control Manager',
    'H7P3' => 'Security Manager',
    'H7Q1' => 'Traffic Manager',
    'H918' => 'Foreman/Supervisor',
    'H920' => 'Industrial Engineer',
    'H924' => 'Manufacturing Supervisor',
    'H928' => 'Plant Engineer',
    'H929' => 'Plant Superintendent',
    'H930' => 'Production Superintendent',
    'H9E7' => 'Operations Analyst',
    'H9GA' => 'Fleet Staff',
    'H9GB' => 'Manufacturing Staff',
    'H9GC' => 'Operation Staff',
    'H9GD' => 'Operations Staff',
    'H9GE' => 'Operating',
    'H9GF' => 'Production',
    'H9GG' => 'Producer',
    'H9P3' => 'Security Staff',
    'I199' => 'Management Information Director',
    'I1A7' => 'Call Center Manager',
    'I1A8' => 'Market Executive',
    'I1A9' => 'Executive of Sales',
    'I1X7' => 'National Sales Manager',
    'I2A1' => 'C-Level Marketing',
    'I2A3' => 'Digital & Social Media Officer',
    'I2B9' => 'Public Relations Executive',
    'I2C0' => 'Sales and Marketing Executive',
    'I2I1' => 'Social Media Strategist',
    'I599' => 'Vice-President Sales and Marketing',
    'I5A1' => 'Executive Vice-President Marketing',
    'I5A2' => 'Executive Vice-President Sales',
    'I5E1' => 'Vice-President Advertising',
    'I5F2' => 'Vice-President Marketing',
    'I5F3' => 'Vice-President Merchandising',
    'I5F7' => 'Vice-President Product Development',
    'I5G2' => 'Vice-President Sales',
    'I5H1' => 'Vice-President Corporate Communications',
    'I5I1' => 'Vice-President Public Relations',
    'I699' => 'Sales and Marketing Director',
    'I6A1' => 'E-Business Director',
    'I6A2' => 'E-Commerce Director',
    'I6A3' => 'Digital & Social Media Director',
    'I6G6' => 'Advertising Director',
    'I6H0' => 'Marketing Director',
    'I6H1' => 'Corporate Communications Director',
    'I6I1' => 'Public Relations Director',
    'I6J2' => 'Sales Director',
    'I6K2' => 'Business Development Director',
    'I6K8' => 'Customer Service Director',
    'I799' => 'Sales and Marketing Manager',
    'I7A1' => 'E-Business Manager',
    'I7A2' => 'E-Commerce Manager',
    'I7A3' => 'Social Media Manager',
    'I7A4' => 'Community Manager',
    'I7B1' => 'Merchandise Manager',
    'I7H1' => 'Corporate Communications Manager',
    'I7I1' => 'Public Relations Manager',
    'I7J9' => 'Advertising Manager',
    'I7K2' => 'Business Development Manager',
    'I7K8' => 'Customer Service Manager',
    'I7M9' => 'Marketing Manager',
    'I7N0' => 'Product Development Manager',
    'I7O2' => 'Product Manager',
    'I7O9' => 'Regional Sales Manager',
    'I7P1' => 'Sales Manager',
    'I7P2' => 'Sales Promotion Manager',
    'I889' => 'Market Research Staff',
    'I898' => 'Sales Associate',
    'I899' => 'Sales and Marketing Assistant',
    'I998' => 'Digital & Social Media Specialist',
    'I999' => 'Sales and Marketing Staff',
    'I9A1' => 'E-Commerce',
    'I9A2' => 'E-Business',
    'I9A3' => 'Social Media Analyst',
    'I9A4' => 'Social Media Marketer',
    'I9D8' => 'Engineer of Sales',
    'I9GH' => 'Advertising Staff',
    'I9GI' => 'Merchandise',
    'I9GJ' => 'Merchandising',
    'I9GK' => 'Marketing Staff',
    'I9GL' => 'Products',
    'I9GM' => 'Sales Staff',
    'I9GN' => 'Database Marketing',
    'I9H1' => 'Corporate Communications Staff',
    'I9I1' => 'Public Relations Staff',
    'I9I2' => 'Publications',
    'I9I3' => 'Spokesman',
    'I9I8' => 'Coordinator of Sales',
    'I9I9' => 'Coordinator of Marketing',
    'I9K8' => 'Customer Service Staff',
    'I9Z9' => 'Call Center Staff',
    'I9ZX' => 'Call Center Representative',
    'J599' => 'Facilities Vice-President',
    'J699' => 'Facilities Director',
    'J6E2' => 'Physical Plant Director',
    'J6H7' => 'Maintenance Director',
    'J7GN' => 'Park Manager',
    'J7L8' => 'Facilities Manager',
    'J7M3' => 'Hub Manager',
    'J7M8' => 'Maintenance Manager',
    'J7N7' => 'Plant and Facilities Manager',
    'J7P0' => 'Terminal Manager',
    'J7Q3' => 'Warehouse Manager',
    'J7ZZ' => 'Property Manager',
    'J899' => 'Facilities Assistant',
    'J923' => 'Maintenance Supervisor',
    'J999' => 'Facilities',
    'J9GO' => 'Maintenance Staff',
    'J9GP' => 'Plaza Manager',
    'K209' => 'Ambassador',
    'K601' => 'Federal Program Director',
    'K602' => 'Program Inspector',
    'K656' => 'Deputy Director',
    'K661' => 'Judge',
    'K670' => 'Police Chief',
    'K948' => 'Alderman',
    'K949' => 'Assistant Chief',
    'K950' => 'Chief',
    'K951' => 'City Council',
    'K952' => 'Commissioner',
    'K953' => 'Committeeman',
    'K955' => 'Council Member',
    'K960' => 'County Commissioner',
    'K961' => 'County Judge',
    'K962' => 'Elder',
    'K963' => 'Fire Chief',
    'K964' => 'Governor',
    'K965' => 'Mayor',
    'K966' => 'Selectman',
    'K967' => 'Sheriff',
    'K968' => 'Vice Mayor',
    'K969' => 'Warden',
    'K989' => 'Judicial Staff',
    'K999' => 'Government',
    'K9D7' => 'Corrections Officer',
    'L6A6' => 'Director of Pastoral Care',
    'L935' => 'Religious Leader',
    'L970' => 'Associate Pastor',
    'L971' => 'Minister',
    'L972' => 'Assistant Pastor',
    'L973' => 'Bishop',
    'L974' => 'Deacon',
    'L975' => 'Cardinal',
    'L976' => 'Pastor',
    'L977' => 'Mother Superior',
    'L978' => 'Rabbi',
    'L979' => 'Rector',
    'L980' => 'Reverend',
    'L981' => 'Priest',
    'L982' => 'Senior Pastor',
    'M1B1' => 'School Superintendent',
    'M1B2' => 'School Board President',
    'M622' => 'Library Director',
    'M6E6' => 'Financial Aid Director',
    'M6F6' => 'Director of Teacher Personnel',
    'M6I6' => 'Instructional Media Services Director',
    'M7M6' => 'Academic Advisor',
    'M7M9' => 'Professor',
    'M7MZ' => 'Teacher',
    'M8I6' => 'Media Specialist',
    'M8I7' => 'Reading Specialist',
    'M901' => 'Education',
    'M922' => 'Librarian',
    'M983' => 'Chancellor',
    'M984' => 'Dean',
    'M985' => 'Headmaster',
    'M986' => 'Chief Admissions Officer',
    'M987' => 'Chief Academic Officer',
    'M988' => 'Athletic Director',
    'M989' => 'Food Service Director',
    'M990' => 'Vice Chancellor',
    'M999' => 'Education Assistant',
    'M9M9' => 'Instructor',
    'M9R3' => 'Associate Professor',
    'M9R4' => 'Assistant Professor',
    'M9R5' => 'Adjunct Professor',
    'N985' => 'Sergeant',
    'N986' => 'Adjutant',
    'N987' => 'Commander',
    'N988' => 'Commodore',
    'N989' => 'Exalted Ruler',
    'N990' => 'Grand Knight',
    'N991' => 'Leading Knight',
    'N992' => 'Master',
    'N993' => 'Post Commander',
    'N994' => 'Quartermaster',
    'N995' => 'Rear Commodore',
    'N996' => 'Recorder',
    'N997' => 'Vice Commander',
    'N998' => 'Vice Commodore',
    'N999' => 'Captain',
    'X1Z8' => 'Senior Associate',
    'X626' => 'Scientist',
    'X656' => 'Art Director',
    'X6Z9' => 'Program Director',
    'X746' => 'Associate Editor',
    'X799' => 'Tradesman/Craftsman',
    'X7DZ' => 'Senior Project Manager',
    'X7X7' => 'Senior Manager',
    'X8X9' => 'Senior Consultant',
    'X901' => 'Author',
    'X906' => 'Taxation',
    'X930' => 'Architect',
    'X931' => 'Designer',
    'X956' => 'Client Manager',
    'X957' => 'Customer Manager',
    'X9CD' => 'Research Analyst',
    'XA01' => 'Emergency Medicine Specialist',
    'XA02' => 'General Vascular Surgeon',
    'XA99' => 'Medical Doctor',
    'XAA1' => 'Veterinarian',
    'XAA2' => 'Family Practitioner',
    'XAB5' => 'Substance Abuse Counselor',
    'XABX' => 'Psychologist',
    'XAP0' => 'Psychoanalyst',
    'XAP1' => 'Ear Nose and Throat Specialist',
    'XAP2' => 'Infectious Diseases',
    'XAP3' => 'Oculist',
    'XAP4' => 'Orthopedist',
    'XAP5' => 'Pathologist',
    'XAP6' => 'Proctologist',
    'XAP7' => 'Sports Medicine',
    'XAP8' => 'Thoracic Physician',
    'XAP9' => 'Surgeon',
    'XAQ1' => 'Occupational Industrial Specialist',
    'XAQ2' => 'Geriatrics',
    'XAQ3' => 'Obstetrician',
    'XAQ4' => 'Audiologist',
    'XAS0' => 'Allergy And Immunology',
    'XAS1' => 'Anesthesiology',
    'XAS2' => 'Arthritis and Rheumatology',
    'XAS3' => 'Cardiology',
    'XAS4' => 'Dermatology',
    'XAS5' => 'Endocrinology',
    'XAS6' => 'General Medical Practice',
    'XAS7' => 'Gastroenterology',
    'XAS8' => 'Hematology',
    'XAS9' => 'Internal Medicine',
    'XAT0' => 'Nephrology',
    'XAT1' => 'Neurology',
    'XAT2' => 'Nuclear Medicine',
    'XAT3' => 'Gynecology/Obstetrics',
    'XAT4' => 'Oncology',
    'XAT5' => 'Ophthalmology',
    'XAT6' => 'Pediatrics',
    'XAT7' => 'Physical Medicine',
    'XAT8' => 'Psychiatry',
    'XAT9' => 'Child Psychology',
    'XAU0' => 'Pulmonary Diseases',
    'XAU1' => 'Radiology',
    'XAU2' => 'Chiropractor',
    'XAU3' => 'Osteopathy',
    'XAU4' => 'Surgery-Orthopedic',
    'XAU5' => 'Surgery-Plastic',
    'XAU6' => 'Surgery-Thoracic',
    'XAU7' => 'Urology',
    'XAU8' => 'Preventive Medicine',
    'XAU9' => 'Infertility Specialist',
    'XAV0' => 'Diabetes',
    'XAV1' => 'Otolaryngology',
    'XAV2' => 'Acupuncture',
    'XAV3' => 'Plastic Surgeon',
    'XAV4' => 'Rheumatology Specialist',
    'XAV5' => 'Cardiovascular',
    'XAV6' => 'Neurological Surgery',
    'XAV7' => 'Colon and Rectal Surgery',
    'XAV8' => 'Vascular Surgery',
    'XAXA' => 'Thoracic Surgeon',
    'XAY5' => 'Immunologist',
    'XAY6' => 'Hypnotist',
    'XAY7' => 'Nutritionist',
    'XAY9' => 'Aerospace Medicine',
    'XAZ1' => 'Podiatrist',
    'XAZ2' => 'Medical Specialist',
    'XAZ8' => 'Physician Assistant',
    'XAZ9' => 'Surgery',
    'XB37' => 'Diagnostic Radiologist',
    'XB47' => 'Allied Health Professional',
    'XB67' => 'Health Administrator',
    'XB6M' => 'Director of Health Information',
    'XB98' => 'Paramedic First Responder',
    'XB99' => 'Health Care Director',
    'XBA7' => 'Director of Emergency Room',
    'XBB2' => 'Contact Lens Specialist',
    'XBB3' => 'Breast Care Specialist',
    'XBBB' => 'Nurse Practitioner',
    'XBC1' => 'Nurse',
    'XBC2' => 'Nursing Director',
    'XBC3' => 'Speech Therapist',
    'XBC4' => 'Nursing Administrator',
    'XBC9' => 'Nursing Supervisor',
    'XBD1' => 'Pharmacist',
    'XBD2' => 'Certified Pharmacy Technician',
    'XBE1' => 'Respiratory Therapy Director',
    'XBE2' => 'Physical Therapy Director',
    'XBE3' => 'Occupational Therapy Director',
    'XBE4' => 'Physical Therapist',
    'XBE5' => 'Physiotherapist',
    'XBF1' => 'Managed Care Director',
    'XBF2' => 'Home Health Care Director',
    'XBF9' => 'Medical Director',
    'XBFB' => 'Nurse Recruiter',
    'XBFC' => 'Physician Recruiter',
    'XBU1' => 'Maxillofacial Specialist',
    'XBV4' => 'Dentist',
    'XBV9' => 'Prosthodontics',
    'XBW0' => 'Dental Hygienist',
    'XBW3' => 'Group and Corporate Practice',
    'XBXA' => 'Registered Nurse',
    'XBXB' => 'Licensed Practical Nurse',
    'XBXC' => 'Physical Rehabilitation Nurse',
    'XBZ8' => 'Pedorthist',
    'XBZ9' => 'Orthotist',
    'XBZZ' => 'Physical Rehabilitation Medicine',
    'XD15' => 'Corporate Counsel/Legal',
    'XD26' => 'Attorney',
    'XD51' => 'Vice-President Legal',
    'XD97' => 'Legal Executive',
    'XD98' => 'Legal Staff',
    'XD99' => 'Counsel',
    'XDA2' => 'Compliance Officer',
    'XDA6' => 'Compliance Director',
    'XDA7' => 'Compliance Manager',
    'XDW4' => 'Patent Law',
    'XDW5' => 'Contract Law',
    'XDW6' => 'White Collar Crime',
    'XDW7' => 'Lobbying',
    'XDW9' => 'Research Law',
    'XDX0' => 'Criminal Law',
    'XDX1' => 'General Counsel',
    'XDX2' => 'Civil Trial Practice',
    'XDX3' => 'Real Estate/Wills/Estate Planning',
    'XDX4' => 'Personal Injury Law',
    'XDX5' => 'Divorce Law',
    'XDX6' => 'Corporate and Business Law',
    'XDX7' => 'General Legal Practice',
    'XDX8' => 'Asbestos Litigation',
    'XDX9' => 'Environmental Law',
    'XDY0' => 'Family Law',
    'XDY1' => 'Bankruptcy Law',
    'XDY2' => 'Litigation',
    'XDY3' => 'Torts',
    'XDY4' => 'Medical Malpractice',
    'XDY5' => 'Professional Liability',
    'XDY6' => 'Commercial Law',
    'XDZ9' => 'Compliance Staff',
    'XZ9L' => 'Social Worker',
    'XZA1' => 'Member',
    'XZY8' => 'Dietician',
    'Z1X1' => 'Managing Member',
    'Z2B7' => 'Administration Executive',
    'Z2B8' => 'Air Transportation Executive',
    'Z2B9' => 'Banking Executive',
    'Z2C3' => 'Executive Secretary',
    'Z2C5' => 'Hospitality Executive',
    'Z2C6' => 'International Executive',
    'Z5E9' => 'Vice-President International',
    'Z642' => 'Assistant Director',
    'Z698' => 'Transportation Director',
    'Z699' => 'Director',
    'Z6GQ' => 'Acting Director',
    'Z6H6' => 'International Director',
    'Z6H7' => 'Co-Director',
    'Z715' => 'Case Manager',
    'Z741' => 'Co-Manager',
    'Z799' => 'Manager',
    'Z7F7' => 'Insurance/Billing Supervisor',
    'Z7GQ' => 'Acting Manager',
    'Z7GR' => 'Complex Manager',
    'Z7P4' => 'Service Manager',
    'Z823' => 'Reporter',
    'Z856' => 'Assistant Office Manager',
    'Z888' => 'Receptionist',
    'Z889' => 'Receptionist Secretary',
    'Z899' => 'Assistant',
    'Z8A8' => 'Medical Assistant',
    'Z8B9' => 'Ophthalmic Technician',
    'Z8GT' => 'Assistant Clerk',
    'Z8GU' => 'Assistant Regional Director',
    'Z8Q0' => 'Assistant Vice-President',
    'Z8Q7' => 'Assistant Manager',
    'Z8Q8' => 'Assistant Secretary',
    'Z900' => 'Account Executive',
    'Z903' => 'Fellow',
    'Z910' => 'Coordinator',
    'Z917' => 'Customer Service Representative',
    'Z921' => 'Insurance Agent',
    'Z923' => 'Chartered Property and Casual Underwriter',
    'Z924' => 'Chartered Life Underwriter',
    'Z925' => 'Underwriter',
    'Z926' => 'Bond Underwriter',
    'Z932' => 'Publisher',
    'Z934' => 'Real Estate Agent',
    'Z936' => 'Store Superintendent',
    'Z937' => 'Superintendent',
    'Z938' => 'Supervisor',
    'Z939' => 'Clerk',
    'Z940' => 'Associate',
    'Z941' => 'Assistant Cashier',
    'Z943' => 'Assistant Superintendent',
    'Z998' => 'Parts Manager',
    'Z9GU' => 'Account Director',
    'Z9GV' => 'Account Manager',
    'Z9GW' => 'Administratrix',
    'Z9GX' => 'Advisor',
    'Z9GY' => 'Agent',
    'Z9GZ' => 'Attorney In Fact',
    'Z9HA' => 'Consultant',
    'Z9HB' => 'Contractor',
    'Z9HC' => 'Commercial',
    'Z9HD' => 'Committee Member',
    'Z9HG' => 'Corporate Representative',
    'Z9HH' => 'Correspondent',
    'Z9HI' => 'Cashier',
    'Z9HJ' => 'Dispersing Agent',
    'Z9HK' => 'Domestic',
    'Z9HL' => 'Editor',
    'Z9HM' => 'Foreign',
    'Z9HN' => 'General',
    'Z9HQ' => 'Group',
    'Z9HR' => 'International',
    'Z9HT' => 'Liquidating Agent',
    'Z9HX' => 'Port Captain',
    'Z9HY' => 'Port Director',
    'Z9HZ' => 'Port Manager',
    'Z9IA' => 'Publishing',
    'Z9IB' => 'Post Master',
    'Z9IC' => 'Publications Printer',
    'Z9IF' => 'Real Estate',
    'Z9IG' => 'Region',
    'Z9IH' => 'Rehabilitator',
    'Z9II' => 'Representative',
    'Z9IJ' => 'Retail',
    'Z9IK' => 'Retailers',
    'Z9IL' => 'Regional',
    'Z9IM' => 'Relations',
    'Z9IO' => 'Senior Editor',
    'Z9IQ' => 'Services',
    'Z9IR' => 'Savings',
    'Z9IS' => 'Transportation',
    'Z9IT' => 'Wholesale',
    'ZA48' => 'Oral and Maxillofacial Surgery',
    'ZAA0' => 'Specialized Dental',
    'ZAA1' => 'Pedodontist',
    'ZAA2' => 'Endodontics',
    'ZAA3' => 'Family And General Dentistry',
    'ZAA4' => 'Orthodontics',
    'ZAA5' => 'Pediatric Dentistry',
    'ZAA6' => 'Periodontics',
    'ZAA7' => 'Oral Pathologist',
    'ZAAB' => 'Dental Surgeon',
    'ZAV6' => 'Optometrists',
    'ZAV7' => 'Geriatric Specialist Optometry',
    'ZBXA' => 'Pain Management',
    'ZBXB' => 'Blood Banking',
    'ZBZZ' => 'Midwife Nurse',
  ),
);

