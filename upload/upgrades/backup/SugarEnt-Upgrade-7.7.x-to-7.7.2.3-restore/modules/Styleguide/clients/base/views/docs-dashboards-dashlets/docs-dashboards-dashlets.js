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
({className:'container-fluid',_renderHtml:function(){var self=this;this._super('_renderHtml');app.events.on('preview:close',function(){self.hideDashletPreview();});app.events.on('app:dashletPreview:close',function(){self.hideDashletPreview();});app.events.on('app:dashletPreview:open',function(){self.showDashletPreview();});app.events.trigger('app:dashletPreview:close');this.$('.dashlet-example').on('click.styleguide',function(){self.$('.dashlet-example').removeClass('active');$(this).addClass('active');app.events.trigger('app:dashletPreview:open');var dashlet=$(this).data('dashlet'),module=$(this).data('module')||'Styleguide',metadata=app.metadata.getView(module,dashlet).dashlets[0];metadata.type=dashlet;metadata.component=dashlet;self.previewDashlet(metadata);});},_dispose:function(){this.$('.dashlet-example').off('click.styleguide');app.events.trigger('app:dashletPreview:close');this._super('_dispose');},showDashletPreview:function(event){$('.main-pane').addClass('span8').removeClass('span12');$('.preview-pane').addClass('active');$('.side').css({visibility:'visible'});},hideDashletPreview:function(event){$('.dashlet-example').removeClass('active');$('.main-pane').addClass('span12').removeClass('span8');$('.side').css({visibility:'hidden'});},previewDashlet:function(metadata){var layout=this.layout,previewLayout;while(layout){if(layout.getComponent('preview-pane')){previewLayout=layout.getComponent('preview-pane').getComponent('dashlet-preview');break;}
layout=layout.layout;}
if(previewLayout){if(!metadata.preview){metadata.preview=metadata.config;}
var previousComponent=_.last(previewLayout._components);if(previousComponent.name!=='dashlet-preview'&&previousComponent.name!=='preview-header'){var index=previewLayout._components.length-1;previewLayout._components[index].dispose();previewLayout.removeComponent(index);}
var contextDef,component={label:app.lang.get(metadata.label,metadata.preview.module),type:metadata.type,preview:true};if(metadata.preview.module||metadata.preview.link){contextDef={skipFetch:false,forceNew:true,module:metadata.preview.module,link:metadata.preview.link};}else if(metadata.module){contextDef={module:metadata.module};}
component.view=_.extend({module:metadata.module},metadata.preview,component);if(contextDef){component.context=contextDef;}
previewLayout.initComponents([{layout:{type:'dashlet',label:app.lang.get(metadata.preview.label||metadata.label,metadata.preview.module),preview:true,components:[component]}}],this.context.parent);previewLayout.loadData();previewLayout.render();}}})