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
(function(app){app.events.on('app:init',function(){app.plugins.register('Tinymce',['field'],{$embeddedInput:null,fileFieldName:null,onAttach:function(component){var self=this;this.fileFieldName=component.options.def.name+'_file';this.$embeddedInput=$('<input />',{name:this.fileFieldName,type:'file'}).hide();component.on('render',function(){component.$el.append(self.$embeddedInput);},this);},onDetach:function(component){this.$embeddedInput.remove();},tinyMCEFileBrowseCallback:function(fieldName,url,type,win){if(_.isUndefined(app.metadata.getModule('EmbeddedFiles'))){return;}
var attributes={fieldName:fieldName,type:type,win:win};this.$embeddedInput.unbind().change(_.bind(this._onEmbededFile,this,attributes));this.$embeddedInput.trigger('click');},_onEmbededFile:function(attributes,event){var $target=$(event.target),fileObj=$target[0].files[0];if(attributes.type==='image'&&fileObj.type.indexOf('image')===-1){this.clearFileInput($target);attributes.win.tinyMCEPopup.alert(app.lang.get('LBL_UPLOAD_ONLY_IMAGE','EmbeddedFiles'));return;}
var embeddedFile=app.data.createBean('EmbeddedFiles');embeddedFile.save({name:fileObj.name},{success:_.bind(this._saveEmbededFile,this,attributes)});},_saveEmbededFile:function(attributes,model){model.uploadFile(this.fileFieldName,this.$embeddedInput,{success:_.bind(function(rsp){var forceDownload=!(rsp[this.fileFieldName]['content-type'].indexOf('image')!==-1);var url=app.api.buildFileURL({module:'EmbeddedFiles',id:rsp.record.id,field:this.fileFieldName},{htmlJsonFormat:false,passOAuthToken:false,cleanCache:true,forceDownload:forceDownload});$(attributes.win.document).find('#'+attributes.fieldName).val(url);if(attributes.type==='image'){if(_.isFunction(attributes.win.ImageDialog.getImageData)){attributes.win.ImageDialog.getImageData();}
if(_.isFunction(attributes.win.ImageDialog.showPreviewImage)){attributes.win.ImageDialog.showPreviewImage(url);}}
this.clearFileInput(this.$embeddedInput);},this),error:_.bind(function(){app.alert.show('upload-error',{level:'error',messages:'ERROR_UPLOAD_FAILED'});this.clearFileInput(this.$embeddedInput);},this)});},clearFileInput:function($field){$field.val('');$field.replaceWith($field.clone(true));}});});})(SUGAR.App);