({
    extendsFrom: 'RecordView',
    initialize: function(options) {
        this._super('initialize', [options]);
        this.context.on('button:add_iws:click', this._openIWSInteractionModal, this);
        this.on('render', this._checkIWSToolbar, this);
    },

    _checkIWSToolbar: function() {
        console.log("_checkIWSToolbar called");
        if (!window.isToolBarLoaded) {
            $("a[name|='add_iws']").hide();
            console.warn("cti-connector-sugar-core package not loaded !!!");
        }

        var userAcl = SUGAR.App.user.getAcls()["Soft_WDEScript"];
        if (!userAcl || (userAcl["access"] && userAcl["access"] == "no") || (userAcl["view"] && userAcl["view"] == "no")) {
            console.warn("User doesnt'have the WDE Script persmissions to load WDE Personalization.");
            $("a[name|='add_iws']").hide();
        }
    },

    /**Function to open the note create pop-up*/
    _openIWSInteractionModal: function() {

        console.log("called _openIWSInteractionModal");

        /**add class content-overflow-visible if client has touch feature*/
        if (Modernizr.touch) {
            app.$contentEl.addClass('content-overflow-visible');
        }

        var quickCreateView = this.layout.getComponent('viewinteraction');
        if (!quickCreateView) {
            console.log("called _openIWSInteractionModal quickCreateView");
            var context = null;
            if (!this.context) {
                console.log("_openIWSInteractionModal context undefined");
                var context = this.context.getChildContext({
                    forceNew: true,
                    create: true
                });
                context.prepare();
            } else {
                console.log("_openIWSInteractionModal context found");
                context = this.context;
            }

            quickCreateView = app.view.createView({
                context: context,
                name: 'viewinteraction',
                layout: this.layout,
                module: context.module
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);
        }
        this.layout.trigger("app:view:viewinteraction");
    },
})