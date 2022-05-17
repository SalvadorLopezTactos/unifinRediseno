({
    extendsFrom: 'SubpanelsLayout',

    _hiddenSubpanels: [],

    initialize: function(options) {
        this._super('initialize', [options]);
        this.registerModelEvents();
    },

    registerModelEvents: function() {
        this.model.on('change:subtipo_registro_c',function(model) {
            if (model.get('subtipo_registro_c') == "4") {
                this.hideSubpanel('tasks');
				this.unhideSubpanel('tasks_leads_1');
            }else{
				this.hideSubpanel('tasks_leads_1');
                this.unhideSubpanel('tasks');
            }
            if (model.get('subtipo_registro_c') == "4") {
                this.hideSubpanel('notes');
				this.unhideSubpanel('notes_leads_1');
            }else{
				this.hideSubpanel('notes_leads_1');
                this.unhideSubpanel('notes');
            }
        },this);
    },

    showSubpanel: function(linkName) {
        this._super('showSubpanel',[linkName]);
        _.each(this._hiddenSubpanels, function(link) {
            this.hideSubpanel(link);
        },this);
    },

    getSubpanelByLink: function(link) {
        return this._components.find(function(component) {
           return component.context.get('link') === link;
        });
    },

    hideSubpanel: function(link) {
        this._hiddenSubpanels.push(link);
        var component = this.getSubpanelByLink(link);
        if (!_.isUndefined(component)) component.hide();
        this._hiddenSubpanels = _.unique(this._hiddenSubpanels);
    },

    unhideSubpanel: function(link) {
        var index = this._hiddenSubpanels.findIndex(function(l){
            return l == link;
        });
        if (_.isUndefined(index)) delete this._hiddenSubpanels[index];
        var component = this.getSubpanelByLink(link);
        if (!_.isUndefined(component)) component.show();
    }
})