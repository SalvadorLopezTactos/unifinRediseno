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
var translate=function(label,module,replace){var string,language,arr;if(!module){if(!window.CURRENT_MODULE){module='pmse_Project';}else{module=window.CURRENT_MODULE;}}
if(App){string=App.lang.get(label,module);}else{language=SUGAR.language.languages;arr=language[module];string=(arr&&arr[label])?arr[label]:label;}
if(!replace){return string;}else{return string.toString().replace(/\%s/,replace);}};var evvv=$([]);function validateForm(formID){var form=$(document.getElementById(formID)),valid=true,req=[],msg='<div>',v;evvv.removeClass('required');form.find(':input').each(function(){if(this.required){req.push(this);v=this.value.trim();if(v===null||v===false||v===""){$(this).addClass('required');msg+=this.title+'<br>';valid=false;}}});msg+='</div>';evvv=$(req);return{valid:valid,message:valid?'':translate('LBL_PMSE_LABEL_ERROR_FIELDS_TO_FILL')+msg};}