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

require_once 'modules/ModuleBuilder/Module/StudioModule.php';

class KBDocumentsStudioModule extends StudioModule
{
    /**
     * Gets appropriate search layouts for the module
     * 
     * @return array
     */
    public function getSearch()
    {
        // KBDocuments should not allow search in the base application
        return array();
    }
}
