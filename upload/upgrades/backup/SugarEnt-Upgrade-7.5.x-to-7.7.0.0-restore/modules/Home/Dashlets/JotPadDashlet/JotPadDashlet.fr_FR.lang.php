<?php

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
















if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');




















$defaultText = 
<<<EOQ
<div style="padding-left:5px;">
Bienvenue dans <a href="http://www.sugarcrm.com">Sugar</a> 

Nouvelles fonctionnalités:<br /><br />
* Equipes dynamiques / Multi-équipes (PRO et ENT)<br />
* Amélioration de la gestion des mots de passe<br />
* Ajout de l'éditeur de Vue Mobile (PRO et ENT)<br />
* Amélioration de la gestion des emails<br />

Pour plus d'informations rendez vous sur <a href="http://www.sugarcrm.com/crm/university">Sugar University</a> (en anglais) <br />
</div>
EOQ
;


$dashletStrings['JotPadDashlet'] = array('LBL_TITLE'            => 'Bloc Note',
                                         'LBL_DESCRIPTION'      => 'Un dashlet pour conserver vos notes',
                                         'LBL_SAVING'           => 'Sauvegarde du Bloc Note ...',
                                         'LBL_SAVED'            => 'Sauvegarder',
                                         'LBL_CONFIGURE_TITLE'  => 'Titre',
                                         'LBL_CONFIGURE_HEIGHT' => 'Auteur (1 - 300)',
                                         'LBL_DBLCLICK_HELP'    => 'Double cliquez pour éditer.',
                                         'LBL_DEFAULT_TEXT'     => $defaultText,
);
?>
