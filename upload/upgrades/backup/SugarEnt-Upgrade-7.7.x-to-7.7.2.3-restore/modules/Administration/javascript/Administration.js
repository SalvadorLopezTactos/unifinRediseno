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
if(typeof(SUGAR)=='undefined'){var SUGAR={};}
SUGAR.Administration={Async:{},RepairXSS:{toRepair:new Object,currentRepairObject:"",currentRepairIds:new Array(),repairedCount:0,numberToFix:25,refreshEstimate:function(select){this.toRepair=new Object();this.repairedCount=0;var button=document.getElementById('repairXssButton');var selected=select.value;var totalDisplay=document.getElementById('repairXssDisplay');var counter=document.getElementById('repairXssCount');var repaired=document.getElementById('repairXssResults');var repairedCounter=document.getElementById('repairXssResultCount');if(selected!="0"){button.style.display='inline';repairedCounter.value=0;AjaxObject.startRequest(callbackRepairXssRefreshEstimate,"&adminAction=refreshEstimate&bean="+selected+'&csrf_token='+SUGAR.csrf.form_token);}else{button.style.display='none';totalDisplay.style.display='none';repaired.style.display='none';counter.value=0;repaired.value=0;}},executeRepair:function(){if(this.toRepair){if(this.currentRepairIds.length<1){if(!this.loadRepairQueue()){alert(done);return;}}
var beanIds=new Array();for(var i=0;i<this.numberToFix;i++){if(this.currentRepairIds.length>0){beanIds.push(this.currentRepairIds.pop());}}
var beanId=YAHOO.lang.JSON.stringify(beanIds);AjaxObject.startRequest(callbackRepairXssExecute,"&adminAction=repairXssExecute&bean="+this.currentRepairObject+"&id="+beanId+'&csrf_token='+SUGAR.csrf.form_token);}},loadRepairQueue:function(){var loaded=false;this.currentRepairObject='';this.currentRepairIds=new Array();for(var bean in this.toRepair){if(this.toRepair[bean].length>0){this.currentRepairObject=bean;this.currentRepairIds=this.toRepair[bean];loaded=true;}}
this.toRepair[this.currentRepairObject]=new Array();return loaded;}}}