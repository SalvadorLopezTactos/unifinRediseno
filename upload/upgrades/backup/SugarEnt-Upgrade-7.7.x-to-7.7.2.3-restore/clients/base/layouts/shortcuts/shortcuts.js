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
({plugins:['ShortcutSession'],shortcuts:['Shortcuts:Help:Close'],events:{'click [name=cancel_button]':'close'},shortcutsHelpTableTemplate:'',initialize:function(options){app.view.Layout.prototype.initialize.call(this,options);this.shortcutsHelpTableTemplate=app.template.getLayout(this.name+'.shortcuts-help-table');this.$('[data-display=global]').append(this.buildGlobalHelpTable().children());this.$('[data-display=contextual]').append(this.buildContextualHelpTable().children());app.shortcuts.register('Shortcuts:Help:Close',['esc','ctrl+alt+l'],function(){this.close();},this);},close:function(){app.drawer.close();},buildGlobalHelpTable:function(){var $html=$('<div></div>'),globalShortcuts=app.shortcuts.getRegisteredGlobalShortcuts(),help=this.prepareShorcutsHelpDataForDisplay(globalShortcuts);$html.append(this.shortcutsHelpTableTemplate(help));return $html;},buildContextualHelpTable:function(){var $html=$('<div></div>'),lastShortcutSession=app.shortcuts.getLastSavedSession(),contextualShortcuts,help;if(lastShortcutSession){contextualShortcuts=lastShortcutSession.getRegisteredShortcuts();if(contextualShortcuts){help=this.prepareShorcutsHelpDataForDisplay(contextualShortcuts);$html.append(this.shortcutsHelpTableTemplate(help));}}
return $html;},prepareShorcutsHelpDataForDisplay:function(shortcuts){var help=[];_.each(shortcuts,function(shortcut){help.push({keys:this.getKeyString(shortcut.keys),help:this.getHelpString(shortcut.id)});},this);return help;},getKeyString:function(keys){return keys.join(', ');},getHelpString:function(shortcutId){if(this.meta.help&&this.meta.help[shortcutId]){return app.lang.get(this.meta.help[shortcutId]);}else{return'';}},loadData:function(options){}})