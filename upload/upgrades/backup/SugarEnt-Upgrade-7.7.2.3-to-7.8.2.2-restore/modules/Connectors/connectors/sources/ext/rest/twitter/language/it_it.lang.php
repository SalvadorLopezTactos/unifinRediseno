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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Ottieni una Consumer Key e un Consumer Secret da Twitter registrando la tua istanza Sugar come nuova applicazione. <br/><br>Step per registrare la tua istanza: <br/><br/><ol><li>Vai al sito Twitter Developers:<a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Registrati utilizzando l´account Twitter sotto il quale vorresti registrare l´applicazione.</li><li>Nel modulo di registrazione, inserisci un nome per l´applicazione. Questo è il nome che gli utenti vedranno quando autenticheranno i loro account da Sugar.</li><li>Inserisci una Descrizione</li><li>Inserisci un Application Website URL (qualsiasi cosa).</li><li>Inserisci un Callback URL (può essere qualsiasi cosa in quanto Sugar lo ignora l´autenticazione. Esempio: Inserisci il root URL del tuo Sugar)</li><li>Accetta i Termini di Servizio API Twitter.</li><li>Fai clic su "Crea la tua applicazione Twitter".</li><li>Dalla pagina applicazione, trova la chiave API e API Secret sotto alla scheda "Chiavi API". Inserisci la chiave Secret qui sotto.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Nome Utente Twitter',
    'LBL_ID' => 'Nome Utente Twitter',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'Chiave API',
    'oauth_consumer_secret' => 'API Secret',
);

?>
