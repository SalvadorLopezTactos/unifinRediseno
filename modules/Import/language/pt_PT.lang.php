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
/*********************************************************************************
 * Description:    Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/
global $timedate;

$mod_strings = [
    'LBL_GOOD_FILE' => 'Importação de Ficheiro de Leitura com Sucesso',
    'LBL_RECORD_CONTAIN_LOCK_FIELD' => 'O registo importado está a participar num processo e não pode ser editado porque alguns campos estão bloqueados para edição pelo processo.',
    'LBL_RECORDS_SKIPPED_DUE_TO_ERROR' => 'Registos ignorados devido a erro',
    'LBL_UPDATE_SUCCESSFULLY' => 'registos criados ou atualizados com sucesso',
    'LBL_SUCCESSFULLY_IMPORTED' => 'Registos criados com sucesso',
    'LBL_STEP_4_TITLE' => 'Passo {0}: Importar Ficheiro',
    'LBL_STEP_5_TITLE' => 'Passo {0}: Ver Resultados de Importação',
    'LBL_CUSTOM_ENCLOSURE' => 'Campos Qualificados Por:',
    'LBL_ERROR_UNABLE_TO_PUBLISH' => 'Incapaz de publicar. Existe outro mapa de Importação publicado com o mesmo nome.',
    'LBL_ERROR_UNABLE_TO_UNPUBLISH' => 'Incapaz de remover a publicação de um mapa pertencente a outro utilizador. Você possui um mapa de Importação com o mesmo nome.',
    'LBL_ERROR_IMPORTS_NOT_SET_UP' => 'Importações não estão configuradas para este tipo de módulo',
    'LBL_IMPORT_TYPE' => 'O que pretende fazer com os dados importados?',
    'LBL_IDM_IMPORT_TYPE_CREATE' => 'Create New Records',
    'LBL_IDM_IMPORT_TYPE_UPDATE' => 'Update Existing Records',
    'LBL_IMPORT_BUTTON' => 'Criar Registos',
    'LBL_UPDATE_BUTTON' => 'Criar e Atualizar Registos',
    'LBL_CREATE_BUTTON_HELP' => 'Use esta opção para criar novos registos. Nota: As linhas no ficheiro de importação que correspondam aos IDs de registos existentes não serão importados se os valores estiverem mapeados no campo de ID.',
    'LBL_UPDATE_BUTTON_HELP' => 'Use esta opção para atualizar registos existentes. Os dados do ficheiro de importação serão comparados com os registos existentes com base no ID de registo presente no ficheiro de importação.',
    'LBL_NO_ID' => 'ID Necessário',
    'LBL_PRE_CHECK_SKIPPED' => 'Pré-Verificação ignorada',
    'LBL_NOLOCALE_NEEDED' => 'Não é necessária conversão local',
    'LBL_FIELD_NAME' => 'Nome de Campo',
    'LBL_VALUE' => 'Valor',
    'LBL_ROW_NUMBER' => 'Número de Linha',
    'LBL_NONE' => 'Nenhum',
    'LBL_REQUIRED_VALUE' => 'Falta valor necessário',
    'LBL_ERROR_SYNC_USERS' => 'Valor inválido para sincronizar para o Outlook:',
    'LBL_ID_EXISTS_ALREADY' => 'ID já existe nesta tabela',
    'LBL_SYNC_KEY_EXISTS_ALREADY' => 'SYNC_KEY já existe nesta tabela',
    'LBL_ASSIGNED_USER' => 'se o utilizador não existir use o utilizador actual',
    'LBL_SHOW_HIDDEN' => 'Mostrar campos que não são normalmente importáveis',
    'LBL_UPDATE_RECORDS' => 'Actualizar registos existentes em vez de importá-los (Sem Desfazer)',
    'LBL_TEST' => 'Teste de Importação (não grave ou modifique dados)',
    'LBL_TRUNCATE_TABLE' => 'Esvaziar tabela antes de importar (eliminar todos os registos)',
    'LBL_RELATED_ACCOUNTS' => 'Não criar contas relacionadas',
    'LBL_NO_DATECHECK' => 'Ignorar verificação da data (mais rápida mas irá falhar se alguma data estiver errada)',
    'LBL_NO_WORKFLOW' => 'Não executar o workflow durante esta importação',
    'LBL_NO_EMAILS' => 'Não enviar notificações de E-mail durante esta importação',
    'LBL_NO_PRECHECK' => 'Modo Formato Nativo',
    'LBL_STRICT_CHECKS' => 'Utilizar strict ruleset (Verificar igualmente endereços de E-mail e números de telefone)',
    'LBL_ERROR_SELECTING_RECORD' => 'Erro ao selecionar registo:',
    'LBL_ERROR_DELETING_RECORD' => 'Erro ao eliminar registo:',
    'LBL_NOT_SET_UP' => 'Importação não está configurada para este tipo de módulo',
    'LBL_ARE_YOU_SURE' => 'Tem a certeza? Isto irá apagar todos os dados neste módulo.',
    'LBL_NO_RECORD' => 'Nenhum registo com este ID para actualização',
    'LBL_NOT_SET_UP_FOR_IMPORTS' => 'Importação não está configurada para este tipo de módulo',
    'LBL_DEBUG_MODE' => 'Ativar modo de depuração',
    'LBL_ERROR_INVALID_ID' => 'ID fornecido é muito extenso para caber no campo (a extensão máxima é de 36 caracteres)',
    'LBL_ERROR_INVALID_PHONE' => 'Número de telefone inválido',
    'LBL_ERROR_INVALID_NAME' => 'String muito extensa para caber no campo',
    'LBL_ERROR_INVALID_VARCHAR' => 'String muito extensa para caber no campo',
    'LBL_ERROR_INVALID_DATETIME' => 'Data e hora inválidas',
    'LBL_ERROR_INVALID_DATETIMECOMBO' => 'Data e hora inválidas',
    'LBL_ERROR_INVALID_INT' => 'Valor inteiro inválido',
    'LBL_ERROR_INVALID_NUM' => 'Valor numérico inválido',
    'LBL_ERROR_INVALID_TIME' => 'Hora inválida',
    'LBL_ERROR_INVALID_EMAIL' => 'Endereço de E-mail inválido',
    'LBL_ERROR_INVALID_BOOL' => 'valor inválido (deve ser 1 ou 0)',
    'LBL_ERROR_INVALID_DATE' => 'Data inválida',
    'LBL_ERROR_INVALID_USER' => 'Nome do utilizador ou ID inválido',
    'LBL_ERROR_INVALID_TEAM' => 'Nome de equipa ou ID inválido',
    'LBL_ERROR_INVALID_ACCOUNT' => 'Nome de conta ou ID inválido',
    'LBL_ERROR_INVALID_RELATE' => 'Campo relacional inválido',
    'LBL_ERROR_INVALID_CURRENCY' => 'Valor de moeda inválido',
    'LBL_ERROR_INVALID_FLOAT' => 'Número de ponto flutuante inválido',
    'LBL_ERROR_NOT_IN_ENUM' => 'Valor não está na lista dropDown. Valores permitidos são:',
    'LBL_ERROR_ENUM_EMPTY' => 'Value not in dropDown list. dropDown list is empty',
    'LBL_NOT_MULTIENUM' => 'Não é um MultiEnum',
    'LBL_IMPORT_MODULE_NO_TYPE' => 'Importação não está configurada para este tipo de módulo',
    'LBL_IMPORT_MODULE_NO_USERS' => 'AVISO: Não tem utilizadores definidos no seu sistema. Se importar sem adicionar utilizadores primeiro, todos os registos irão pertencer ao Administrador.',
    'LBL_IMPORT_MODULE_MAP_ERROR' => 'Incapaz de publicar. Existe outro Mapa de Importação publicado com o mesmo nome.',
    'LBL_IMPORT_MODULE_MAP_ERROR2' => 'Incapaz de remover a publicação de um mapa pertencente a outro utilizador. Você possui um Mapa de Importação com o mesmo nome.',
    'LBL_IMPORT_MODULE_NO_DIRECTORY' => 'O diretório ',
    'LBL_IMPORT_MODULE_NO_DIRECTORY_END' => 'não existe ou não tem permissões de escrita',
    'LBL_IMPORT_MODULE_ERROR_NO_UPLOAD' => 'O ficheiro não foi carregado com sucesso. É possível que a definição &#39;upload_max_filesize&#39; do seu ficheiro php.ini esteja definida como um número pequeno',
    'LBL_IMPORT_MODULE_ERROR_LARGE_FILE' => 'O ficheiro é muito grande. Max:',
    'LBL_IMPORT_MODULE_ERROR_LARGE_FILE_END' => 'Bytes. Alterar $sugar_config[&#39;upload_maxsize&#39;] em config.php',
    'LBL_MODULE_NAME' => 'Importar',
    'LBL_MODULE_NAME_SINGULAR' => 'Importar',
    'LBL_TRY_AGAIN' => 'Tente novamente',
    'LBL_START_OVER' => 'Começar de novo',
    'LBL_ERROR' => 'Erro:',
    'LBL_IMPORT_ERROR_MAX_REC_LIMIT_REACHED' => 'O ficheiro de importação contém {0} linhas. O número ideal de linhas é {1}. Mais linhas poderão abrandar o processo de importação. Carregar em OK para continuar a importação. Carregar em Cancel para rever e recarregar o ficheiro de importação.',
    'ERR_IMPORT_SYSTEM_ADMININSTRATOR' => 'Não pode importar um utilizador administrador do sistema',
    'ERR_REPORT_LOOP' => 'O sistema detectou um erro. Um Utilizador não pode reportar a si mesmo e nenhum dos seus superiores podem reportar a ele.',
    'ERR_MULTIPLE' => 'Múltiplas colunas foram definidas com o mesmo nome de campo.',
    'ERR_MISSING_REQUIRED_FIELDS' => 'Campos obrigatórios em falta:',
    'ERR_MISSING_MAP_NAME' => 'Falta nome de mapeamento personalizado',
    'ERR_USERS_IMPORT_DISABLED_TO_IDM_MODE' => 'A importação de utilizadores está desativada para o modo IDM.',
    'ERR_SELECT_FULL_NAME' => 'Não pode selecionar o Nome Completo quando o Nome Próprio e o Apelido estão selecionados.',
    'ERR_SELECT_FILE' => 'Selecione um ficheiro para carregar.',
    'LBL_SELECT_FILE' => 'Selecione um ficheiro:',
    'LBL_CUSTOM' => 'Personalizar',
    'LBL_CUSTOM_CSV' => 'Ficheiro Personalizado Delimitado por Vírgulas',
    'LBL_CSV' => 'Ficheiro Delimitado por vírgula',
    'LBL_EXTERNAL_SOURCE' => 'uma aplicação externa ou serviço',
    'LBL_TAB' => 'Ficheiro delimitado por tabulação',
    'LBL_CUSTOM_DELIMITED' => 'Ficheiro com limites personalizados',
    'LBL_CUSTOM_DELIMITER' => 'Campos Delimitados Por:',
    'LBL_FILE_OPTIONS' => 'Opções de ficheiro',
    'LBL_CUSTOM_TAB' => 'Ficheiro personalizado delimitado por tabulação',
    'LBL_DONT_MAP' => '-- Não mapeie este campo --',
    'LBL_STEP_MODULE' => 'Para que módulo é que pretende importar dados?',
    'LBL_STEP_1_TITLE' => 'Passo 1: Selecionar a Origem dos Dados',
    'LBL_CONFIRM_TITLE' => 'Passo {0}: Confirmar Propriedades de Ficheiro de Importação',
    'LBL_CONFIRM_EXT_TITLE' => 'Passo {0}: Confirmar Propriedades da Origem Externa',
    'LBL_WHAT_IS' => 'Os meus dados estão em:',
    'LBL_MICROSOFT_OUTLOOK' => 'Microsoft Outlook',
    'LBL_MICROSOFT_OUTLOOK_HELP' => 'O mapeamento personalizado para o Microsoft Outlook depende que o ficheiro de importação seja um ficheiro separado por virgulas (.csv). Se o seu ficheiro de importação é um ficheiro separado por tabulações, o mapeamento poderá não ser aplicado como esperado.',
    'LBL_ACT' => 'Act!',
    'LBL_SALESFORCE' => 'Salesforce.com',
    'LBL_MY_SAVED' => 'Para utilizar as definições de importação gravadas, selecione abaixo:',
    'LBL_PUBLISH' => 'publicar',
    'LBL_DELETE' => 'excluir',
    'LBL_PUBLISHED_SOURCES' => 'Para utilizar definições de importação predefinidas, selecione abaixo:',
    'LBL_UNPUBLISH' => 'Anular publicação',
    'LBL_NEXT' => 'Próximo &gt;',
    'LBL_BACK' => '&lt; Voltar',
    'LBL_STEP_2_TITLE' => 'Passo {0}: Carregar Ficheiro Exportado',
    'LBL_HAS_HEADER' => 'Tem Cabeçalho:',
    'LBL_NUM_1' => '1.',
    'LBL_NUM_2' => '2.',
    'LBL_NUM_3' => '3.',
    'LBL_NUM_4' => '4.',
    'LBL_NUM_5' => '5.',
    'LBL_NUM_6' => '6.',
    'LBL_NUM_7' => '7.',
    'LBL_NUM_8' => '8.',
    'LBL_NUM_9' => '9.',
    'LBL_NUM_10' => '10.',
    'LBL_NUM_11' => '11.',
    'LBL_NUM_12' => '12.',
    'LBL_NOTES' => 'Notas:',
    'LBL_NOW_CHOOSE' => 'Agora escolha o ficheiro a importar:',
    'LBL_IMPORT_OUTLOOK_TITLE' => 'Microsoft Outlook 98 e 2000 podem exportar dados no formato de <b>Valores Separados por Vírgula</b> (CSV:Comma Separated Values) o qual pode ser usado para importar dados no sistema. Para exportar os seus dados do Outlook, siga os seguintes passos:',
    'LBL_OUTLOOK_NUM_1' => 'Iniciar o  <b>Outlook</b>',
    'LBL_OUTLOOK_NUM_2' => 'Selecione o menu <b>Ficheiro</b>, então a opção <b>Importar e Exportar ...</b>',
    'LBL_OUTLOOK_NUM_3' => 'Escolha <b>Exportar para um ficheiro</b> e clique em Seguinte',
    'LBL_OUTLOOK_NUM_4' => 'Escolha <b>Valores Separados por Vírgula (Windows)</b> e clique <b>Próximo </b>.<br>  Nota: Poderá ser solicitado a instalar o componente de exportação',
    'LBL_OUTLOOK_NUM_5' => 'Selecione a pasta <b>Contactos </b> e clique <b>Próximo </b>. Você pode selecionar diferentes pastas de contactos se os seus contactos estiverem armazenados em múltiplas pastas',
    'LBL_OUTLOOK_NUM_6' => 'Escolha um nome de ficheiro e clique <b>Próximo </b>',
    'LBL_OUTLOOK_NUM_7' => 'Clique <b>Finalizar </b>',
    'LBL_IMPORT_SF_TITLE' => 'O Salesforce.com pode exportar dados no formato <b>Valores Separados por Vírgula</b> que podem ser utilizados para importar no sistema. Para exportar dados a partir do Salesforce.com, siga os passos abaixo:',
    'LBL_SF_NUM_1' => 'Abra seu browser, aceda a http://www.salesforce.com e inicie sessão com o seu endereço de e-mail e palavra-passe',
    'LBL_SF_NUM_2' => 'Clique no tabulador <b>Relatórios</b> do menu',
    'LBL_SF_NUM_3' => '<b>Para exportar Contas:</b> Clique na ligação <b>Contas Ativas</b> <br><b>Para exportar Contactos:</b> Clique na ligação <b>Lista de Correio</b>',
    'LBL_SF_NUM_4' => 'No <b>Passo 1: Selecione o seu tipo de relatório</b>, selecione <b>Relatórios tabulares</b>clique <b>Próximo</b>',
    'LBL_SF_NUM_5' => 'No <b>Passo 2: Selecione colunas do relatório</b>, escolha as colunas que pretende exportar e clique em <b>Próximo</b>',
    'LBL_SF_NUM_6' => 'No <b>Passo 3: Selecione a informação a sumarizar</b>, apenas clique <b>Próximo</b>',
    'LBL_SF_NUM_7' => 'No <b>Passo 4: Ordene as colunas do relatório</b>, apenas clique <b>Próximo</b>',
    'LBL_SF_NUM_8' => 'No <b>Passo 5: Selecione os seus critérios do relatório</b>, em <b>Data de Início</b>, escolha uma data suficientemente antiga para incluir todas as suas Contas. Pode também exportar um subconjunto de Contas utilizando critérios mais avançados. Quando estiver pronto, clique em <b>Executar Relatório</b>',
    'LBL_SF_NUM_9' => 'O relatório será gerado, e a página deve apresentar <b>Estado da Geração de Relatório: Completo.</b> Agora clique <b>Exportar para Excel</b>',
    'LBL_SF_NUM_10' => 'Em <b>Exportar Relatório:</b>, para <b>Exportar Formato de Ficheiro:</b>, escolha <b>Delimitado por Vírgula .csv</b>. Clique <b>Exportar</b>.',
    'LBL_SF_NUM_11' => 'Um diálogo em pop-up irá pedir para gravar o ficheiro exportado para o computador.',
    'LBL_IMPORT_ACT_TITLE' => 'Act! pode exportar dados no formato <b>Valores Separados por Vírgula</b>, que pode ser utilizado para importar dados para o sistema. Para exportar os seus dados do Act!, siga os seguintes passos:',
    'LBL_ACT_NUM_1' => 'Lançar <b>ACT!</b>',
    'LBL_ACT_NUM_2' => 'Selecione o menu <b>Ficheiro</b>, a opção do menu <b>Trocar Dados</b>, e depois a opção do menu <b>Exportar...</b>',
    'LBL_ACT_NUM_3' => 'Selecione o tipo de ficheiro <b>Texto-Delimitado</b>',
    'LBL_ACT_NUM_4' => 'Escolha um nome de ficheiro e o local para os dados exportados e clique em <b>Próximo</b>',
    'LBL_ACT_NUM_5' => 'Selecione <b>Registos de contactos apenas</b>',
    'LBL_ACT_NUM_6' => 'Clique no botão <b>Opções...</b>',
    'LBL_ACT_NUM_7' => 'Selecione <b>Vírgula</b> como o carácter separador de campo',
    'LBL_ACT_NUM_8' => 'Verifique a checkbox <b>Sim, exportar nomes de campo</b> e clique em <b>OK</b>',
    'LBL_ACT_NUM_9' => 'Clique em <b>Próximo</b>',
    'LBL_ACT_NUM_10' => 'Selecione <b>Todos os Registos</b> e depois clique em <b>Concluir</b>',
    'LBL_IMPORT_CUSTOM_TITLE' => 'Muitas aplicações irão permitir você exportar dados em um <b>ficheiro de texto Delimitado por Vírgula (.csv)</b>. Geralmente a maioria das aplicações seguem o fluxo dos passos abaixo:',
    'LBL_CUSTOM_NUM_1' => 'Execute a aplicação e abra o ficheiro de dados',
    'LBL_CUSTOM_NUM_2' => 'Selecione a opção do menu <b>Gravar Como...</b> ou <b>Exportar...</b>',
    'LBL_CUSTOM_NUM_3' => 'Grave o ficheiro no formato <b>CSV</b> ou <b>Valores Separados por Vírgula</b>',
    'LBL_IMPORT_TAB_TITLE' => 'A maioria das aplicações irão permitir que exporte os dados em formato<b>ficheiro de texto Delimitado por Tabulação (.tsv or .tab)</b>. Geralmente a maioria das aplicações seguem o fluxo dos passos abaixo:',
    'LBL_TAB_NUM_1' => 'Execute a aplicação e abra o ficheiro de dados',
    'LBL_TAB_NUM_2' => 'Selecione a opção do menu <b>Gravar Como...</b> ou <b>Exportar...</b>',
    'LBL_TAB_NUM_3' => 'Grave o ficheiro no formato <b>TSV</b> ou <b>Valores Separados por Tabulador</b>',
    'LBL_STEP_3_TITLE' => 'Passo {0}: Confirmar Correspondência de Campos',
    'LBL_STEP_DUP_TITLE' => 'Passo {0}: Verificar por Possíveis Duplicados',
    'LBL_SELECT_FIELDS_TO_MAP' => 'Na lista abaixo, selecione os campos do seu ficheiro de importação que deverão ser importados em cada campo do sistema. Quando terminar, clique em <b>Seguinte</b>:',
    'LBL_DATABASE_FIELD' => 'Campo do Banco de Dados',
    'LBL_HEADER_ROW' => 'Linha do Cabeçalho',
    'LBL_HEADER_ROW_OPTION_HELP' => 'Selecionar se a linha de topo do ficheiro de importação é uma Linha de Cabeçalho contendo os rótulos dos campos.',
    'LBL_ROW' => 'Linha',
    'LBL_SAVE_AS_CUSTOM' => 'Gravar como Mapeamento Personalizado:',
    'LBL_SAVE_AS_CUSTOM_NAME' => 'Nome de Mapeamento Personalizado:',
    'LBL_CONTACTS_NOTE_1' => 'Sobrenome ou Nome Completo devem ser mapeados.',
    'LBL_CONTACTS_NOTE_2' => 'Se o Nome Completo estiver mapeado, então Nome Próprio e Apelido são ignorados.',
    'LBL_CONTACTS_NOTE_3' => 'Se Nome Completo estiver mapeado, então os dados deste campo serão separados em Nome Próprio e Apelido quando inserido na base de dados.',
    'LBL_CONTACTS_NOTE_4' => 'Campos do Endereço 2 e 3 serão concatenados com o campo Endereço (principal) quando inserido na base de dados.',
    'LBL_ACCOUNTS_NOTE_1' => 'Nome da Conta deve estar mapeado.',
    'LBL_REQUIRED_NOTE' => 'Campo(s) Obrigatório(s):',
    'LBL_IMPORT_NOW' => 'Importar Agora',
    'LBL_' => '',
    'LBL_CANNOT_OPEN' => 'Não é possível abrir o ficheiro importado para leitura',
    'LBL_NOT_SAME_NUMBER' => 'Não há o mesmo número de campos por linha no seu ficheiro',
    'LBL_NO_LINES' => 'Não há linhas (registos) no seu ficheiro de importação',
    'LBL_FILE_ALREADY_BEEN_OR' => 'O ficheiro de importação já foi processado ou não existe',
    'LBL_SUCCESS' => 'Sucesso:',
    'LBL_FAILURE' => 'Importação Falhou:',
    'LBL_SUCCESSFULLY' => 'Importados com Sucesso',
    'LBL_LAST_IMPORT_UNDONE' => 'A sua última importação foi desfeita',
    'LBL_NO_IMPORT_TO_UNDO' => 'Não há importação para desfazer.',
    'LBL_FAIL' => 'Falhou:',
    'LBL_RECORDS_SKIPPED' => 'registos perdidos',
    'LBL_IDS_EXISTED_OR_LONGER' => 'Saltou registos porque existem IDs ou não são maiores que 36 caracteres',
    'LBL_RESULTS' => 'Resultados',
    'LBL_CREATED_TAB' => 'Registos Criados.',
    'LBL_DUPLICATE_TAB' => 'Duplicados',
    'LBL_ERROR_TAB' => 'Erros',
    'LBL_IMPORT_MORE' => 'Importar Mais',
    'LBL_FINISHED' => 'Concluído',
    'LBL_UNDO_LAST_IMPORT' => 'Desfazer Última Importação',
    'LBL_LAST_IMPORTED' => 'Criada',
    'ERR_MULTIPLE_PARENTS' => 'Você pode ter somente um ID Membro definido',
    'LBL_DUPLICATES' => 'Duplicados Encontrados',
    'LNK_DUPLICATE_LIST' => 'Transferir lista de duplicados',
    'LNK_ERROR_LIST' => 'Transferir lista de erros',
    'LNK_RECORDS_SKIPPED_DUE_TO_ERROR' => 'Transferir lista de linhas que não foram importadas',
    'LBL_UNIQUE_INDEX' => 'Escolha Index para comparação de duplicados',
    'LBL_VERIFY_DUPS' => 'Para verificar registos existentes que correspondam aos dados do ficheiro de importação, selecione os campos a verificar.',
    'LBL_INDEX_USED' => 'Index(es) utilizados',
    'LBL_INDEX_NOT_USED' => 'Index(es) não utilizados',
    'LBL_IMPORT_MODULE_ERROR_NO_MOVE' => 'O ficheiro não foi carregado com sucesso. Verifique as permissões do ficheiro no seu diretório cache de instalação do Sugar.',
    'LBL_IMPORT_FIELDDEF_ID' => 'Número de ID Único',
    'LBL_IMPORT_FIELDDEF_RELATE' => 'Nome ou ID',
    'LBL_IMPORT_FIELDDEF_PHONE' => 'Número de Telefone',
    'LBL_IMPORT_FIELDDEF_TEAM_LIST' => 'Nome de Equipa ou ID',
    'LBL_IMPORT_FIELDDEF_NAME' => 'Qualquer Texto',
    'LBL_IMPORT_FIELDDEF_VARCHAR' => 'Qualquer Texto',
    'LBL_IMPORT_FIELDDEF_TEXT' => 'Qualquer Texto',
    'LBL_IMPORT_FIELDDEF_TIME' => 'Hora',
    'LBL_IMPORT_FIELDDEF_DATE' => 'Data',
    'LBL_IMPORT_FIELDDEF_DATETIME' => 'Data e Hora',
    'LBL_IMPORT_FIELDDEF_ASSIGNED_USER_NAME' => 'Nome de Utilizador ou ID',
    'LBL_IMPORT_FIELDDEF_BOOL' => '&#39;0&#39; ou &#39;1&#39;',
    'LBL_IMPORT_FIELDDEF_ENUM' => 'Lista',
    'LBL_IMPORT_FIELDDEF_EMAIL' => 'Endereço de E-mail',
    'LBL_IMPORT_FIELDDEF_INT' => 'Numérico (Não Decimal)',
    'LBL_IMPORT_FIELDDEF_DOUBLE' => 'Numérico (Não Decimal)',
    'LBL_IMPORT_FIELDDEF_NUM' => 'Numérico (Não Decimal)',
    'LBL_IMPORT_FIELDDEF_CURRENCY' => 'Numérico (Decimal Permitido)',
    'LBL_IMPORT_FIELDDEF_FLOAT' => 'Numérico (Decimal Permitido)',
    'LBL_DATE_FORMAT' => 'Formato da Data:',
    'LBL_TIME_FORMAT' => 'Formato da Hora:',
    'LBL_TIMEZONE' => 'Fuso Horário',
    'LBL_ADD_ROW' => 'Adicionar Campo',
    'LBL_REMOVE_ROW' => 'Remover Campo',
    'LBL_DEFAULT_VALUE' => 'Valor Padrão',
    'LBL_SHOW_ADVANCED_OPTIONS' => 'Ver Propriedades do Ficheiro de Importação',
    'LBL_HIDE_ADVANCED_OPTIONS' => 'Ocultar Propriedades do Ficheiro Importado',
    'LBL_SHOW_NOTES' => 'Ver Notas',
    'LBL_HIDE_NOTES' => 'Ocultar Notas',
    'LBL_SHOW_PREVIEW_COLUMNS' => 'Mostrar Previsão de Colunas',
    'LBL_HIDE_PREVIEW_COLUMNS' => 'Ocultar Previsão de Colunas',
    'LBL_DUPLICATE_CHECK_OPERATOR' => 'Verifique se há duplicados usando o operador:',
    'LBL_SAVE_MAPPING_AS' => 'Para gravar as definições de importação, forneça um nome para as definições gravadas:',
    'LBL_OPTION_ENCLOSURE_QUOTE' => 'Aspas Simples (&#39;)',
    'LBL_OPTION_ENCLOSURE_DOUBLEQUOTE' => 'Aspas Duplas (")',
    'LBL_OPTION_ENCLOSURE_NONE' => 'Nenhum',
    'LBL_OPTION_ENCLOSURE_OTHER' => 'Outro:',
    'LBL_IMPORT_COMPLETE' => 'Importação Completa',
    'LBL_IMPORT_COMPLETED' => 'Importação Completa',
    'LBL_IMPORT_ERROR' => 'Ocorreram Erros na Importação',
    'LBL_IMPORT_RECORDS' => 'Importando Registos',
    'LBL_IMPORT_RECORDS_OF' => 'de',
    'LBL_IMPORT_RECORDS_TO' => 'para',
    'LBL_CURRENCY' => 'Moeda',
    'LBL_SYSTEM_SIG_DIGITS' => 'Digitos Significativos do Sistema',
    'LBL_NUMBER_GROUPING_SEP' => 'Separador de milhares (1000):',
    'LBL_DECIMAL_SEP' => 'Símbolo decimal',
    'LBL_LOCALE_DEFAULT_NAME_FORMAT' => 'Formato de Exibição do Nome',
    'LBL_LOCALE_EXAMPLE_NAME_FORMAT' => 'Exemplo',
    'LBL_LOCALE_NAME_FORMAT_DESC' => '<i>"s" Saudação, "f" Nome Próprio, "l" Apelido</i>',
    'LBL_CHARSET' => 'Codificação do Nome',
    'LBL_MY_SAVED_HELP' => 'Utilize esta opção para aplicar as definições de importação predefinidas, incluindo as propriedades de importação, mapeamentos e quaisquer definições de verificação de duplicados, para esta importação.<br><br>Clique em <b>Eliminar</b> para eliminar um mapeamento para todos os utilizadores.',
    'LBL_MY_SAVED_ADMIN_HELP' => 'Utilize esta opção para aplicar as definições de importação predefinidas, incluindo as propriedades de importação, mapeamentos e quaisquer definições de verificação de duplicados, para esta importação.<br><br>Clique em <b>Publicar</b> para tornar o mapeamento disponível a outros utilizadores.<br>Clique em <b>Anular Publicação</b> para tornar o mapeamento indisponível a outros utilizadores.<br>Clique em <b>Eliminar</b> para eliminar um mapeamento para todos os utilizadores.',
    'LBL_MY_PUBLISHED_HELP' => 'Utilize esta opção para aplicar definições de importação predefinidas, incluindo propriedades de importação, mapeamentos e qualquer definição de verificação de duplicados, para esta importação.',
    'LBL_ENCLOSURE_HELP' => '<p>O <b>carácter qualificador</b> é utilizado para encerrar o conteúdo de campo destinado, incluindo quaisquer caracteres que são utilizados como delimitadores.<br><br>Exemplo: Se o delimitador é uma vírgula (,) e o qualificador é uma aspa ("),<br><b>"Cupertino, Califórnia"</b> é importado para um campo na aplicação e aparece como <b>Cupertino, Califórnia</b>.<br>Se não há caracteres qualificadores, ou se um carácter diferente é o qualificador,<br><b>"Cupertino, Califórnia"</b> é importado para dois campos adjacentes como <b>"Cupertino</b> e <b>Califórnia "</b>.<br><br>Nota: O ficheiro de importação pode não conter quaisquer caracteres qualificadores.<br> O carácter qualificador padrão para ficheiros delimitados por vírgula e tabulação criados no Excel é uma aspa.</p>',
    'LBL_DELIMITER_COMMA_HELP' => 'Utilize esta opção para selecionar e carregar um ficheiro de folha de cálculo com os dados que pretende importar. Exemplos: ficheiro .csv separado por vírgulas ou exporte o ficheiro a partir do Microsoft Outlook.',
    'LBL_DELIMITER_TAB_HELP' => 'Selecione esta opção se o carácter que separa os campos no ficheiro de importação é uma <b>TAB</b>, e a extensão do ficheiro é .txt.',
    'LBL_DELIMITER_CUSTOM_HELP' => 'Selecione esta opção se o carácter que separa os campos no ficheiro de importação não é uma vírgula ou uma TAB, e coloque o carácter que os separa.',
    'LBL_DATABASE_FIELD_HELP' => 'Esta coluna apresenta todos os campos do módulo. Selecione um campo para mapear para os dados das linhas do ficheiro de importação.',
    'LBL_HEADER_ROW_HELP' => 'Estes são os títulos de campo na linha de cabeçalho do ficheiro de importação.',
    'LBL_DEFAULT_VALUE_HELP' => 'Indicar um valor a utilizar para o campo no registo criado ou actualizado se o campo no ficheiro de importação não contiver dados.',
    'LBL_ROW_HELP' => 'Esta coluna apresenta os dados na primeira linha que não pertence ao cabeçalho do ficheiro de importação. Se os rótulos da linha do cabeçalho aparecerem nesta coluna, clique em Anterior para especificar a linha do cabeçalho nas Propriedades do Ficheiro de Importação.',
    'LBL_SAVE_MAPPING_HELP' => 'Introduza um nome para gravar as definições de importação, incluindo os mapeamentos de campos e índices utilizados para a verificação de duplicados. As definições de importação gravadas podem ser utilizadas para futuras importações.',
    'LBL_IMPORT_FILE_SETTINGS_HELP' => 'Durante o carregamento do ficheiro de importação, algumas propriedades de ficheiros poderão ter sido detetadas automaticamente. Visualize e efetue a gestão destas propriedades, conforme<br> necessário. Nota: As definições fornecidas aqui pertencem a esta importação<br> e não irão substituir as Definições de Utilizador globais.',
    'LBL_VERIFY_DUPLCATES_HELP' => 'Encontre registos existentes no sistema que sejam considerados duplicados de registos prestes a serem importados ao efetuar uma verificação de duplicados para dados correspondentes. Os campos arrastados para a coluna "Verificar Dados" serão utilizados para a verificação de duplicados. As linhas do ficheiro de importação com dados correspondentes serão listadas na página seguinte e poderá selecionar as linhas a importar',
    'LBL_IMPORT_STARTED' => 'Importação Iniciada:',
    'LBL_IMPORT_FILE_SETTINGS' => 'Importar Definições do Ficheiro',
    'LBL_IDM_RECORD_CANNOT_BE_CREATED' => 'Registo não adicionado. Os novos utilizadores devem ser adicionados em Definições de SugarCloud',
    'LBL_RECORD_CANNOT_BE_UPDATED' => 'O registo não pôde ser actualizado devido a um problema de permissões.',
    'LBL_DELETE_MAP_CONFIRMATION' => 'Tem a certeza que quer apagar este mapeamento?',
    'LBL_THIRD_PARTY_CSV_SOURCES' => 'Se os dados do ficheiro de importação tiverem sido exportados de algumas das seguintes origens, selecione qual foi.',
    'LBL_THIRD_PARTY_CSV_SOURCES_HELP' => 'Selecione a origem para aplicar automaticamente mapeamentos personalizados de maneira a simplificar o processo de mapeamento (próximo passo).',
    'LBL_EXTERNAL_SOURCE_HELP' => 'Use esta opção para importar dados directamente de uma aplicação ou serviço externo, como o Gmail.',
    'LBL_EXAMPLE_FILE' => 'Transferir Modelo de Ficheiro de Importação',
    'LBL_CONFIRM_IMPORT' => 'Selecionou atualizar registos durante o processo de importação. As atualizações efetuadas a registos existentes não podem ser desfeitas. No entanto, registos criados durante o processo de importação podem ser desfeitos (eliminados) se necessário. Clique em Cancelar para escolher apenas criar novos registos, ou clique em OK para continuar.',
    'LBL_IDM_CONFIRM_IMPORT' => 'Updates made to existing records during the import process cannot be undone. Click Cancel to create new records, or click OK to continue.',
    'LBL_CONFIRM_MAP_OVERRIDE' => 'Aviso: Já selecionou um mapeamento personalizado para esta importação, pretende continuar?',
    'LBL_EXTERNAL_FIELD' => 'Campo Externo',
    'LBL_SAMPLE_URL_HELP' => 'Transfira uma amostra de um ficheiro de importação contendo uma linha de cabeçalho de campos de um módulo. O ficheiro pode ser utilizado como modelo para criar um ficheiro de importação contendo os dados que se pretenda importar.',
    'LBL_AUTO_DETECT_ERROR' => 'O delimitador de campos e o quantificados do ficheiro de importação não foram encontrados. Por favor verifique as definições nas Propriedades do Ficheiro de Importação.',
    'LBL_MIME_TYPE_ERROR_1' => 'O ficheiro selecionado aparenta não conter uma lista delimitada. Por favor verificar o tipo de ficheiro. Recomendamos ficheiros delimitados por vírgulas (.csv).',
    'LBL_MIME_TYPE_ERROR_2' => 'Para proceder com a importação do ficheiro selecionado, clique em OK. Para carregar um novo ficheiro, clique em Tentar de Novo',
    'LBL_FIELD_DELIMETED_HELP' => 'O delimitador de campo especifica o carácter utilizado para separar as colunas dos campos.',
    'LBL_FILE_UPLOAD_WIDGET_HELP' => 'Selecione o ficheiro que contém os dados que estão separados por um delimitador, como um ficheiro delimitado por virgulas ou tabulações. Ficheiros do tipo .csv são recomendados.',
    'LBL_EXTERNAL_ERROR_NO_SOURCE' => 'Impossível recuperar o adaptador de origem, tente de novo mais tarde.',
    'LBL_EXTERNAL_ERROR_FEED_CORRUPTED' => 'Impossível de recuperar o feed externo, por favor tentar de novo mais tarde.',
    'LBL_ERROR_IMPORT_CACHE_NOT_WRITABLE' => 'O diretório de importação de cache não tem permissões de escrita.',
    'LBL_ADD_FIELD_HELP' => 'Utilize esta opção para adicionar um valor a um campo em todos os registos criados e/ou atualizados. Selecione o campo e introduza ou selecione o valor para esse campo na coluna Valor Predefinido.',
    'LBL_MISSING_HEADER_ROW' => 'Não Foi Encontrada a Linha de Cabeçalho',
    'LBL_CANCEL' => 'Cancelar',
    'LBL_SELECT_DS_INSTRUCTION' => 'Pronto para começar a importar? Selecione a origem dos dados a partir da qual gostaria de importar.',
    'LBL_SELECT_UPLOAD_INSTRUCTION' => 'Selecione um ficheiro no seu computador que contenha os dados que gostaria de importar, ou transfira o modelo para obter um avanço na criação do ficheiro de importação.',
    'LBL_SELECT_IDM_CREATE_INSTRUCTION' => 'Para criar novos registos, aceda a <a href="{0}" target="_blank">Definições de SugarCloud</a>.',
    'LBL_SELECT_IDM_UPLOAD_INSTRUCTION' => 'Para actualizar registos existentes, seleccione um ficheiro no seu computador que contenha os dados que deseja importar.',
    'LBL_SELECT_PROPERTY_INSTRUCTION' => 'Aqui está como aparecem as primeiras linhas do ficheiro de importação com as propriedades detetadas do ficheiro. Se for detetada uma linha de cabeçalho, é apresentada no topo das linhas da tabela. Veja as propriedades do ficheiro de importação para efetuar alterações às propriedades detetadas e para definir propriedades adicionais. Atualizar as definições irá atualizar os dados que aparecem na tabela.',
    'LBL_SELECT_MAPPING_INSTRUCTION' => 'A tabela abaixo contém todos os campos no módulo que podem ser mapeados para os dados do ficheiro de importação. Se o ficheiro contiver uma linha de cabeçalho, as colunas no ficheiro serão mapeadas para os campos correspondentes Se os dados de importação contiverem datas, o ano deve estar no formato AAAA. Verifique os mapeamentos para certificar-se de que são o que esperava e efetue alterações, conforme necessário. Para ajudá-lo a verificar os mapeamentos, a Linha 1 apresenta os dados no ficheiro. Certifique-se de que mapeia todos os campos necessários (indicados por um asterisco).',
    'LBL_IDM_SELECT_MAPPING_INSTRUCTION' => 'The table below contains all of the editable fields in the module that can be mapped to the data in the import file. If the file contains a header row, the columns in the file have been mapped to matching fields. If the import data contain dates, the year must be in YYYY format. Check the mappings to make sure that they are what you expect, and make changes, as necessary. To help you check the mappings, Row 1 displays the data in the file. Be sure to map to all of the required fields (noted by an asterisk).',
    'LBL_IDM_SELECT_MAPPING_FIELDS_INSTRUCTION' => '<a href="{0}" target="_blank">Fields</a> that are only editable in SugarIdentity via the SugarCloud Settings console will not be available to map.',
    'LBL_SELECT_DUPLICATE_INSTRUCTION' => 'Para evitar criar registos duplicados, selecione quais dos campos mapeados gostaria de usar para efetuar uma verificação de duplicados enquanto os dados estão a ser importados. Os valores dentro dos registos existentes nos campos selecionados serão verificados relativamente aos dados do ficheiro de importação. Se forem encontrados dados correspondentes, as linhas do ficheiro de importação que contenham estes dados serão mostradas juntamente com os resultados da importação (próxima página). Poderá então selecionar quais destas linhas continuam a ser importadas.',
    'LBL_EXT_SOURCE_SIGN_IN' => 'Entrar',
    'LBL_EXT_SOURCE_SIGN_OUT' => 'Encerrar sessão',
    'LBL_DUP_HELP' => 'Aqui estão as linhas do ficheiro de importação que não foram importadas uma vez que contêm dados que correspondem a valores já existentes em registos, utilizando a verificação de duplicados. Os dados que correspondem estão destacados. Para importar novamente estas linhas, transfira a lista, efetue as alterações e clique em <b>Importar Novamente</b>.',
    'LBL_DESELECT' => 'anular a seleção',
    'LBL_SUMMARY' => 'Resumo',
    'LBL_OK' => 'OK',
    'LBL_ERROR_HELP' => 'Aqui estão as linhas do ficheiro de importação que não foram importadas devido a erros. Para voltar a importar estas linhas, transfira a lista, efectue as alterações e clique em <b>Importar Novamente</b>',
    'LBL_EXTERNAL_MAP_HELP' => 'A tabela abaixo contém os campos de uma origem externa e os campos de um módulo para o qual podem ser mapeados. Verifique os mapeamentos para garantir que estes são o que é esperado, e efectue as alterações se necessário. Confirme que mapeia todos os campos obrigatórios (indicados com um asterisco).',
    'LBL_EXTERNAL_MAP_NOTE' => 'A importação irá ser tentada para contactos dentro de todos os grupos Google Contacts.',
    'LBL_EXTERNAL_MAP_NOTE_SUB' => 'O Nome de Utilizador dos utilizadores recentemente criados serão por defeito o Nome Completo do Google Contact. Os Nomes de Utilizador podem ser alterados após os registos de utilizador terem sido criados.',
    'LBL_EXTERNAL_MAP_SUB_HELP' => 'Clique em <b>Importar Agora</b> para começar a importação. Os registos serão apenas criados para entradas que incluam apelidos. Os registos não serão criados para dados que sejam identificados como duplicados, baseando-se nos nomes e/ou endereços de email que correspondam a registos existentes.',
    'LBL_EXTERNAL_FIELD_TOOLTIP' => 'Esta coluna mostra os campos na origem externa que contêm dados que serão usados para criar novos registos.',
    'LBL_EXTERNAL_DEFAULT_TOOPLTIP' => 'Indique um valor para utilizar no campo do registo criado se o campo da origem externa não contiver dados.',
    'LBL_EXTERNAL_ASSIGNED_TOOLTIP' => 'Para atribuir os novos registos a um utilizador para além de si, use a coluna Valor por Defeito para selecionar um utilizador diferente.',
    'LBL_EXTERNAL_TEAM_TOOLTIP' => 'Para atribuir os novos registos a outras equipas para além da(s) sua(s) equipa(s) predefinida(s), utilize a coluna Valor Predefinido para selecionar equipas diferentes.',
    'LBL_SIGN_IN_HELP' => 'Para habilitar este serviço, por favor entrar no separador Contas Externas, presente na página de definições do utilizador.',
    'LBL_NO_EMAIL_DEFS_IN_MODULE' => "A tentar utilizar endereços de e-mail num Bean que não fornece suporte.",
];
