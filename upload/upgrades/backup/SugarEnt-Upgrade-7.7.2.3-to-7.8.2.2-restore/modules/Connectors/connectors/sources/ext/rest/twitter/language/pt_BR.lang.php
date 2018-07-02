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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Obter uma Chave API e um Segredo do Twitter registrando sua instância do Sugar como um novo aplicativo.<br/><br>Etapas para registrar seu aplicativo:<br/><br/><ol><li>Vá pra o site do Twitter para desenvolvedores: <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Entre usando a conta do Twitter pela qual deseja registrar o aplicativo.</li><li>No formulário de registro, insira uma nome para o aplicativo. Esse é o nome que os usuários verão quando autenticarem suas contas no Twitter pelo Sugar.</li><li>Insira uma descrição.</li><li>Insira a URL do site do aplicativo.</li><li>Insira um URL de Callback (pode ser qualquer coisa, já que o Sugar ignora essa entrada na autenticação. Exemplo: Insira a URL de seu site Sugar).</li><li>Aceite os Termos de serviço da API do Twitter.</li><li>Clique em "Criar seu aplicativo Twitter".</li><li>Na página do aplicativo, encontre a Chave de API e o Segredo de API na guia "Chaves de API". Insira a Chave e o Segredo abaixo.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Nome de usuário do Twitter',
    'LBL_ID' => 'Nome de usuário do Twitter',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'Chave de API',
    'oauth_consumer_secret' => 'Segredo de API',
);

?>
