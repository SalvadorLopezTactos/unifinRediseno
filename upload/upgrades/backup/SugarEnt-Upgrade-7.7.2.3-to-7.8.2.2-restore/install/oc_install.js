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
// $Id: oc_install.js 13195 2006-05-12 03:44:54Z roger $

function toggleOfflineClientInstallation(){
   var theForm = document.forms[0];

   if(!theForm.oc_install.checked ){
      theForm.oc_server_url.disabled = "disabled";
      theForm.oc_username.disabled = "disabled";
      theForm.oc_password.disabled = "disabled";
   }
   else {
      theForm.oc_server_url.disabled = '';
      theForm.oc_username.disabled = '';
      theForm.oc_password.disabled = '';
   }
}
