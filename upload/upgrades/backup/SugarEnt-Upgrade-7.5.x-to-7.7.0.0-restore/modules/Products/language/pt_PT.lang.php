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
  'ERR_DELETE_RECORD' => 'Um número de registo tem de ser especificado para eliminar este produto.',
  'LBL_ACCOUNT_ID' => 'Id da Entidade',
  'LBL_ACCOUNT_NAME' => 'Nome da Entidade',
  'LBL_ASSET_NUMBER' => 'Número de Imobilizado:',
  'LBL_ASSIGNED_TO_NAME' => 'Atribuído a:',
  'LBL_ASSIGNED_USER_ID' => 'ID de Utilizador Atribuído',
  'LBL_ASSOCIATED_QUOTE' => 'Assunto da Cotação:',
  'LBL_BOOK_VALUE' => 'Valor Contabilístico:',
  'LBL_BOOK_VALUE_DATE' => 'Data do Valor Contabilístico:',
  'LBL_BOOK_VALUE_USDOLLAR' => 'Valor contabilístico (USD)',
  'LBL_CALCULATED_LINE_ITEM_AMOUNT' => 'Quantidade Calculada da Cotação do Item de Linha',
  'LBL_CAMPAIGN_PRODUCT' => 'Produto da Campanha',
  'LBL_CATEGORY' => 'Categoria:',
  'LBL_CATEGORY_NAME' => 'Nome da Categoria:',
  'LBL_COMMIT_STAGE' => 'Etapa de Commit',
  'LBL_COMMIT_STAGE_FORECAST' => 'Previsão',
  'LBL_CONTACT' => 'Contacto',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_CONTACT_ID' => 'Id do Contacto',
  'LBL_CONTACT_NAME' => 'Nome do Contacto:',
  'LBL_CONTRACTS' => 'Contratos',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Contratos',
  'LBL_CONVERT_TO_QUOTE_ERROR' => 'Erro:',
  'LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE' => 'Ocorreu um erro ao converter este Item de Linha de Cotação para uma Cotação',
  'LBL_COST_PRICE' => 'Custo:',
  'LBL_COST_USDOLLAR' => 'Custo (em US Dollars)',
  'LBL_CREATED_USER' => 'Utilizador Criado',
  'LBL_CURRENCY' => 'Moeda:',
  'LBL_CURRENCY_ID' => 'ID da Moeda',
  'LBL_CURRENCY_RATE' => 'Taxa da Moeda',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Nome do Símbolo da Moeda',
  'LBL_DATE_CLOSED' => 'Data de Fecho Esperada',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Carimbo da Data de Fecho Expectável',
  'LBL_DATE_PURCHASED' => 'Comprado:',
  'LBL_DATE_SUPPORT_EXPIRES' => 'O Suporte expira em:',
  'LBL_DATE_SUPPORT_STARTS' => 'O Suporte expira em:',
  'LBL_DEAL_TOT' => 'Desconto:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Produtos',
  'LBL_DESCRIPTION' => 'Descrição:',
  'LBL_DISCOUNT_AMOUNT' => 'Valor do Desconto',
  'LBL_DISCOUNT_AS_PERCENT' => 'Desconto em %',
  'LBL_DISCOUNT_PRICE' => 'Preço unitário',
  'LBL_DISCOUNT_PRICE_DATE' => 'Data do Desconto:',
  'LBL_DISCOUNT_RATE' => 'Taxa de Desconto',
  'LBL_DISCOUNT_RATE_USDOLLAR' => 'Taxa de Desconto (US Dollar)',
  'LBL_DISCOUNT_TOTAL' => 'Desconto Total',
  'LBL_DISCOUNT_TOTAL_USDOLLAR' => 'Desconto (US Dollar)',
  'LBL_DISCOUNT_USDOLLAR' => 'Desconto (em US Dollars)',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
  'LBL_EDITLAYOUT' => 'Editar Layout',
  'LBL_EXPERT_ID' => 'Especialista de Produto',
  'LBL_EXPORT_CURRENCY_ID' => 'ID da Moeda',
  'LBL_EXT_PRICE' => 'Preço Externo',
  'LBL_FORECAST' => 'Incluir na Previsão',
  'LBL_HELP_CREATE' => 'O módulo de {{plural_module_name}} consiste em todos os produtos que foram vendidos ou que estão em processo de venda a clientes.

Para criar um {{module_name}}:
1. Fornecer valores para os campos como desejado.
 - Campos marcados como "Obrigatórios" deverão ser preenchidos antes de gravar.
 - Carregar "Mostrar mais" para mostrar campos adicionais se necessário.

2. Carregar em "Gravar" para finalizar o novo registo e retornar à página anterior.
 - Escolher "Gravar e ver" para abrir o novo {{module_name}} na visualização do registo.
 - Escolher "Gravar e criar novo" para criar imediatamente outro novo {{module_name}}.',
  'LBL_HELP_RECORD' => 'O módulo de {{plural_module_name}} consiste em todos os produtos que foram vendidos ou que estão em processo de venda a clientes.

-Edite os campos deste registo carregando em um campo individualmente ou no botão Editar.
- Visualize ou modifique ligações para outros registos nos sub-paineis alterando o painel esquerdo do fundo para "Visualização de Dados".
- Crie e visualize comentários de utilizador e grande alterações do histórico no {{activitystream_singular_module}}  alterando o painel esquerdo do fundo para "Fluxo de Actividade".
- Siga ou torne favorito este registo utilizando os ícones à direita do nome do registo.
- Acções adicionais estão disponíveis no menu de selecção Acções à direita do botão Editar.',
  'LBL_HELP_RECORDS' => 'O módulo de {{plural_module_name}} consiste em todos os produtos que foram vendidos ou que estão em processo de venda a clientes. A lista de produtos vendidos pela sua organização está alojado em Admin > Catalogo de Produtos e os administradores têm a possibilidade de adicionar produtos conforme necessário. Quando se criam {{plural_module_name}}, tem a opção de selecionar produtos a partir do catalogo ou criar novos produtos via o módulo de {{plural_module_name}}. Existem várias maneiras de criar {{plural_module_name}} no Sugar, como via o módulo de {{plural_module_name}}, o módulo de {{quotes_module}}, duplicação, importação de {{plural_module_name}}, etc. Assim que o {{module_name}} é criado, poderá visualizar e editar a informação pertencente ao {{module_name}} via a visualização de registos de {{plural_module_name}}.',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Leads',
  'LBL_LEAD_SOURCE' => 'Origem da Lead',
  'LBL_LIST_ACCOUNT_NAME' => 'Nome da Entidade',
  'LBL_LIST_CONTACT_NAME' => 'Nome do Contacto',
  'LBL_LIST_COST_PRICE' => 'Custo',
  'LBL_LIST_DATE_PURCHASED' => 'Comprado',
  'LBL_LIST_DISCOUNT_PRICE' => 'Preço',
  'LBL_LIST_FORM_TITLE' => 'Lista de Produtos',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Número do Fabricante',
  'LBL_LIST_LIST_PRICE' => 'Lista',
  'LBL_LIST_MANUFACTURER' => 'Fabricante',
  'LBL_LIST_NAME' => 'Item de Linha Cotados',
  'LBL_LIST_PRICE' => 'Preço:',
  'LBL_LIST_QUANTITY' => 'Quantidade',
  'LBL_LIST_QUOTE_NAME' => 'Nome da Cotação',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LIST_SUPPORT_EXPIRES' => 'Expira',
  'LBL_LIST_USDOLLAR' => 'Preço (em US Dollars)',
  'LBL_MANUFACTURER' => 'Fabricante:',
  'LBL_MANUFACTURERS' => 'Fornecedores',
  'LBL_MANUFACTURER_NAME' => 'Nome do Fabricante:',
  'LBL_MEMBER_OF' => 'Membro de:',
  'LBL_MFT_PART_NUM' => 'Número do Fabricante',
  'LBL_MODIFIED_USER' => 'Utilizador Modificado',
  'LBL_MODULE_NAME' => 'Itens de Linha Cotados',
  'LBL_MODULE_NAME_SINGULAR' => 'Item de Linha Cotados',
  'LBL_MODULE_TITLE' => 'Itens de Linha Cotados: Início',
  'LBL_NAME' => 'Nome',
  'LBL_NEW_FORM_TITLE' => 'Novo Produto',
  'LBL_NEXT_STEP' => 'Próximo Passo:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notas ou Anexos',
  'LBL_OPPORTUNITY' => 'Oportunidade',
  'LBL_OPPORTUNITY_ID' => 'ID da Oportunidade',
  'LBL_PRICING_FACTOR' => 'Factor Preço',
  'LBL_PRICING_FORMULA' => 'Fórmula do Preço',
  'LBL_PROBABILITY' => 'Probabilidade (%)',
  'LBL_PRODUCT' => 'Item de Linha Cotados:',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Itens de Linha Cotados',
  'LBL_PRODUCT_CATEGORIES' => 'Categorias de Produto',
  'LBL_PRODUCT_TEMPLATE' => 'Modelo do Produto:',
  'LBL_PRODUCT_TEMPLATE_ID' => 'ID Modelo do Produto',
  'LBL_PRODUCT_TYPES' => 'Tipos de Produto',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projectos',
  'LBL_QUANTITY' => 'Quantidade:',
  'LBL_QUOTE' => 'Cotação',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Cotações',
  'LBL_QUOTE_ID' => 'ID Cotação',
  'LBL_QUOTE_NAME' => 'Nome da Cotação:',
  'LBL_RELATED_PRODUCTS' => 'Itens de Linha Cotados Relacionados',
  'LBL_RELATED_PRODUCTS_TITLE' => 'Itens de Linha Cotados',
  'LBL_REVENUELINEITEM' => 'Item de Linha de Receita',
  'LBL_REVENUELINEITEMS' => 'Itens de Linha de Receita',
  'LBL_REVENUELINEITEM_ID' => 'ID do Item de Linha de Receita',
  'LBL_REVENUELINEITEM_NAME' => 'Nome do Item de Linha de Receita:',
  'LBL_SALES_STAGE' => 'Fase de Vendas',
  'LBL_SALES_STATUS' => 'Estado da Linha de Receita',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisar Produtos',
  'LBL_SELECT_DISCOUNT' => 'Desconto em %',
  'LBL_SERIAL_NUMBER' => 'Número de Série:',
  'LBL_STATUS' => 'Estado:',
  'LBL_SUPPORT_CONTACT' => 'Contacto do Suporte',
  'LBL_SUPPORT_DESCRIPTION' => 'Descrição do Suporte',
  'LBL_SUPPORT_NAME' => 'Título do Suporte',
  'LBL_SUPPORT_TERM' => 'Equipa de Suporte',
  'LBL_TAX_CLASS' => 'Classificação Fiscal:',
  'LBL_TYPE' => 'Tipo:',
  'LBL_URL' => 'URL do Produto:',
  'LBL_VENDOR_PART_NUM' => 'Número do Fornecedor',
  'LBL_WEBSITE' => 'Site de Internet',
  'LBL_WEIGHT' => 'Peso:',
  'LNK_IMPORT_PRODUCTS' => 'Importar Produtos',
  'LNK_NEW_PRODUCT' => 'Novo Produto',
  'LNK_PRODUCT_LIST' => 'Produtos',
  'NTC_DELETE_CONFIRMATION' => 'Tem a certeza que pretende eliminar este registo?',
  'NTC_REMOVE_CONFIRMATION' => 'Tem a certeza que pretende eliminar a relação com este produto?',
);

