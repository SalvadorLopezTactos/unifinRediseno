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
({className:'preview-headerbar',events:{'click [data-direction]':'triggerPagination','click .preview-headerbar .closeSubdetail':'triggerClose'},initialize:function(options){this._super('initialize',[options]);this.checkACL(this.model);this._delegateEvents();},_delegateEvents:function(){if(this.layout){this.layout.on('preview:pagination:update',this.render,this);}
if(this.layout.previewEdit){_.extend(this.events,{'click [data-action=edit]':'triggerEdit'});this.layout.on('preview:edit:complete',this.toggleSaveAndCancel,this);}},triggerPagination:function(e){var direction=this.$(e.currentTarget).data();this.layout.trigger('preview:pagination:fire',direction);},triggerClose:function(){app.events.trigger('list:preview:decorate',null,this);app.events.trigger('preview:close');},triggerEdit:function(){this.toggleSaveAndCancel(true);this.layout.trigger('preview:edit');},toggleSaveAndCancel:function(edit){if(edit){this.getField('save_button').show();this.getField('cancel_button').show();this.$('[data-direction], [data-action=close]').hide();}else{this.getField('save_button').hide();this.getField('cancel_button').hide();this.$('[data-direction], [data-action=close]').show();}},_renderFields:function(){this._super('_renderFields');if(this.layout.previewEdit){this.getField('save_button').hide();this.getField('cancel_button').hide();}},_render:function(){this.layout.on('previewheader:ACLCheck',this.checkACL,this)
this._super('_render');},checkACL:function(model){if(app.config.previewEdit&&this.layout.meta.editable===true&&app.acl.hasAccessToModel('edit',model)){this.layout.previewEdit=true;}else{this.layout.previewEdit=false;}}})