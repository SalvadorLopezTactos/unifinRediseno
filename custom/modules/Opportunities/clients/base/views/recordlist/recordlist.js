/*
 * @author Carlos Zaragoza Ortiz
 * @date 04/12/15
 * @brief En la vista de lista de operaciones, disparar el menu Expediente
 *
 */
({
    //extendsFrom: 'FlexListView',
    extendsFrom: 'RecordlistView',
    contextEvents: {
        "list:expedienterow:fire": "expedienteClicked",
    },
    initialize: function (options) {
        this._super("initialize", [options]);
    },
    expedienteClicked: function (model, field) {
        var Oppid = model.get('id');
        window.open("#bwc/index.php?entryPoint=ExpedienteVaadinOportunidad&Oppid=" + Oppid);
    },

})