/**
 * Created by Jorge on 8/28/2015.
 */
({
    extendsFrom: "CreateActionsView",

    events: {
        'click #cancelarDrawer': 'cancelarDrawer',
    },

    cancelarDrawer: function(){
        app.drawer.close();
    },

    bindDataChange: function () {
        this._super("bindDataChange");

        this.camposFaltantes = this.context.get("RequeridosFaltantes");
        this.relatedAcct = this.context.get("relatedAcct");
        this.relaciones_activas = this.context.get("relaciones_activas");
        this.relatedAcctName = this.context.get("relatedAcctName");
    },
})
