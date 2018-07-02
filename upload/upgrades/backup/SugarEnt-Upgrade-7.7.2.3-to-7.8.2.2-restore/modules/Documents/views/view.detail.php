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

class DocumentsViewDetail extends ViewDetail 
{

    public function display()
 	{
	//check to see if the file field is empty.  This should not occur and would only happen when an error has ocurred during upload, or from db manipulation of record.
         if(empty($this->bean->filename)){
	    //print error to screen
            $this->errors[] = $GLOBALS['mod_strings']['ERR_MISSING_FILE'];
            $this->displayErrors();
         }


        parent::display();
    }
    
}
