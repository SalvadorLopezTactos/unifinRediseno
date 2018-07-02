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
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Obter a Chave e o Segredo da  IBM SmartCloud&copy; registando a sua instância Sugar como uma nova aplicação.<br><br />&nbsp;<br><br />Passos para registar a sua instância:<br><br />&nbsp;<br><br /><ol><br /><li>Autenticar-se na sua conta IBM SmartCloud (terá que ser um administrador)</li><br /><li>Ir a Administration -> Manage Organization</li><br /><li>Ir ao link "Integrated Third-Party Apps" na barra lateral e disponibilizar o SugarCRM para todos os utilizadores.</li><br /><li>Ir a "Internal Apps" na barra lateral e "Register App"</li><br /><li>Dê o nome desta aplicação como quiser (por exemplo "SugarCRM – Produção"), e tenha a certeza de NÃO escolher a opção de OAuth 2.x no fim da janela.</li><br /><li>Depois da aplicação estar criada, carregar no pequeno triângulo à direita do nome da aplicação e seleccione "Show Credentials" do menu de selecção.</li><br /><li>Copiar as credenciais abaixo.</li><br /></ol><br /></td></tr></table>',
  'oauth_consumer_key' => 'Chave do Consumidor OAuth',
  'oauth_consumer_secret' => 'Segredo do Consumidor OAuth',
);

