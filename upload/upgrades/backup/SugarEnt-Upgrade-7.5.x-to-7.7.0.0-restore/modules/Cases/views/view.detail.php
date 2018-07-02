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

require_once('include/MVC/View/views/view.detail.php');

class CasesViewDetail extends ViewDetail {

    public function preDisplay()
    {
        parent::preDisplay();
        if(ACLController::checkAccess('KBDocuments', 'edit', true))
        {
            array_push($this->dv->defs['templateMeta']['form']['buttons'], array(
                    'customCode'=>'<input title="{$MOD.LBL_CREATE_KB_DOCUMENT}" accessKey="M" class="button" onclick="this.form.return_module.value=\'Cases\'; this.form.return_action.value=\'DetailView\';this.form.action.value=\'EditView\';this.form.module.value=\'KBDocuments\';" type="submit" name="button" value="{$MOD.LBL_CREATE_KB_DOCUMENT}">',
                    'sugar_html' => array(
                        'type' => 'submit',
                        'value' => '{$MOD.LBL_CREATE_KB_DOCUMENT}',
                        'htmlOptions' => array(
                            'title' => '{$MOD.LBL_CREATE_KB_DOCUMENT}',
                            'accessKey' => 'M',
                            'class' => 'button',
                            'onclick' => 'this.form.return_module.value=\'Cases\'; this.form.return_action.value=\'DetailView\';this.form.action.value=\'EditView\';this.form.module.value=\'KBDocuments\';',
                            'name' => 'button',
                        ),
                    ),
                )
            );
        }
        $this->dv->th->deleteTemplate($this->dv->module, $this->dv->view);
    }
}

?>