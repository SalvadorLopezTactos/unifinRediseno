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
function EAPMChange(){var apiName='';var passwordPlaceholder='::PASSWORD::';if(EAPMFormName=='EditView'){apiName=document.getElementById('application').value;}else{apiName=document.getElementById('application_raw').value;}
if(SUGAR.eapm[apiName]){var apiOpts=SUGAR.eapm[apiName];var urlObj=new SUGAR.forms.SetVisibilityAction('url',(apiOpts.needsUrl?'true':'false'),EAPMFormName);urlObj.setContext(new SUGAR.forms.FormExpressionContext(this.form));if(EAPMFormName=='EditView'){EAPMSetFieldRequired('url',(apiOpts.needsUrl==true));}
var userObj=new SUGAR.forms.SetVisibilityAction('name',((apiOpts.authMethod=='password')?'true':'false'),EAPMFormName);userObj.setContext(new SUGAR.forms.FormExpressionContext(this.form));if(EAPMFormName=='EditView'){EAPMSetFieldRequired('name',(apiOpts.authMethod=='password'));}
var passObj=new SUGAR.forms.SetVisibilityAction('password',((apiOpts.authMethod=='password')?'true':'false'),EAPMFormName);passObj.setContext(new SUGAR.forms.FormExpressionContext(this.form));if(EAPMFormName=='EditView'){EAPMSetFieldRequired('password',(apiOpts.authMethod=='password'));clickToEditPassword('#password',passwordPlaceholder);}
var context=SUGAR.forms.AssignmentHandler;urlObj.exec(context);userObj.exec(context);passObj.exec(context);var messageDiv=document.getElementById('eapm_notice_div');if(typeof messageDiv!='undefined'&&messageDiv!=null){if(apiOpts.authMethod){if(apiOpts.authMethod=="oauth"){messageDiv.innerHTML=EAPMOAuthNotice;}else{messageDiv.innerHTML=EAPMBAsicAuthNotice;}}else{messageDiv.innerHTML=EAPMBAsicAuthNotice;}}}}
function EAPMSetFieldRequired(fieldName,isRequired){var formname='EditView';for(var i=0;i<validate[formname].length;i++){if(validate[formname][i][0]==fieldName){validate[formname][i][2]=isRequired;}}}
function EAPMEditStart(userIsAdmin){var apiElem=document.getElementById('application');EAPM_url_validate=null;EAPM_name_validate=null;EAPM_password_validate=null;apiElem.onchange=EAPMChange;setTimeout(EAPMChange,100);if(!userIsAdmin){document.getElementById('assigned_user_name').parentNode.innerHTML=document.getElementById('assigned_user_name').value;}
if(apiElem.form.record.value!=''){apiElem.disabled=true;}}
var EAPMPopupCheckCount=0;function EAPMPopupCheck(newWin,popup_url,redirect_url,popup_warning_message){if(newWin==false||newWin==null||typeof newWin.close!='function'||EAPMPopupCheckCount>35){alert(popup_warning_message);document.location=redirect_url;return;}
if(typeof(newWin.innerHeight)!='undefined'&&newWin.innerHeight!=0){document.location=redirect_url;return;}
EAPMPopupCheckCount++;setTimeout(function(){EAPMPopupCheck(newWin,popup_url,redirect_url,popup_warning_message);},100);}
function EAPMPopupAndRedirect(popup_url,redirect_url,popup_warning_message){var newWin=false;try{newWin=window.open(popup_url+'&closeWhenDone=1&refreshParentWindow=1','_blank');}catch(e){newWin=false;}
EAPMPopupCheck(newWin,popup_url,redirect_url,popup_warning_message);}