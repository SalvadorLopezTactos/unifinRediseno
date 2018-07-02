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
 * Description:  Defines the Catalan language pack for the base application. 

 * Source: SugarCRM 5.2.0
 * Contributor(s): Ramón Feliu (ramon@slay.es).
 ********************************************************************************/

$defaultText = 
<<<EOQ
Benvingut a Sugar 5.2<br /><br />

Les noves característiques inclouen:<br />

Faci clic a <b>El Meu Compte</b> per establir les seves preferencies.<br />
Faci clic a l´icono amb un <b>Interrogant</b> per accedir a la pàgina d´Ajuda de cada mòdul.<br /><br />

Per a més informació sobre com introduir-se a Sugar, si us plau, visiti Sugar University.
EOQ
;

$dashletStrings['JotPadDashlet'] = array('LBL_TITLE'            => 'JotPad',
                                         'LBL_DESCRIPTION'      => 'Un dashlet per guardar les seves notes',
                                         'LBL_SAVING'           => 'Guardant JotPad ...',
                                         'LBL_SAVED'            => 'Guardat',
                                         'LBL_CONFIGURE_TITLE'  => 'Títol',
                                         'LBL_CONFIGURE_HEIGHT' => 'Altura (1 - 300)',
                                         'LBL_DBLCLICK_HELP'    => 'Faci doble clic abaix per Editar.',
                                         'LBL_DEFAULT_TEXT'     => $defaultText, 
);
 
