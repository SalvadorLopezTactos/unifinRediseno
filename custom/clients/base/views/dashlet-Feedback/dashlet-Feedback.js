/**
 * @author F. Javier G. Solar.
 * 25/07/2018
 */

({
    plugins: ['Dashlet'],

    events: {
        'click .showComment': 'showDivComment',
        'click .btn-Cancelar': 'hideDivComment',
        'change .equipoList': 'getUserList',
        'change .usrList': 'getNotificationUsr',
        'click .btn-Guardar': 'setNotificationUsr',
    },

    list_equipos_all: null,
    listadoUsers: [],
    list_filter_usr: null,
    notificaciones_usr: [],
    banderaUsr: null,

    initialize: function (options) {
        this._super("initialize", [options]);
        self = this;
        this.getUserAll();

        /*
        * Se obtiene el Listado de los equipos disponibles
        * **/
        var list_equipos_option = "";
        var value_eq_list = app.lang.getAppListStrings('equipo_list');
        var key_eq_list = app.lang.getAppListKeys('equipo_list');
        var list_equipos_option = '<option value=""></option>';
        for (key_eq_list in value_eq_list) {
            list_equipos_option += '<option value="' + key_eq_list + '">' + value_eq_list[key_eq_list] + '</option>';
        }
        this.list_equipos_all = list_equipos_option;
        this.showDivComment();
        this.showElementByPuesto();
    },

    _render: function () {
        this._super("_render");

        this.$('div[data-name=div-Comment]').hide();


    },

    showElementByPuesto: function () {

        var id_usr_activo = app.user.attributes.id;

        this.$('div[data-name=div-Comment]').hide();
        var puesto = app.user.attributes.puestousuario_c;

        if (puesto == '28' || puesto == '29' || puesto == '30') {

            this.banderaUsr = 'OK';
        }
        else {
            app.api.call('GET', app.api.buildURL('GetNotifications/' + id_usr_activo + '/5'), null, {
                success: _.bind(function (data) {

                    if (data != "") {
                        this.notificaciones_usr = data.records;
                        //console.log(data);
                    }
                    this.render();
                }, self),
            });
        }
    },

    getNotificationUsr: function () {
        self = this;

        var tempUsr = $("#states2").val();
        var tempEqp = $("#states3").val();

        app.api.call('GET', app.api.buildURL('GetNotifications/' + tempUsr + '/-1'), null, {
            success: _.bind(function (data) {

                if (data != "") {

                    this.notificaciones_usr = data.records;

                }
                this.render();
                $('#states3').select2('val', tempEqp);
                $('#states2').select2('val', tempUsr);
            }, self),
        });


    },

    getUserAll: function () {

        app.api.call("GET", app.api.buildURL("Users/?fields=id,full_name,equipo_c&max_num=-1", null, null, {}), null, {
            success: _.bind(function (data) {
                this.listadoUsers = data.records;

            }, this)
        });
    },

    getUserList: function () {
        self = this;
        $("#states2").val = "";

        var tempEquipo = $("#states3").val();
        var objUsers = this.listadoUsers;
        var arrayUsr = [];

        if (!_.isEmpty(objUsers)) {
            arrayUsr.push(
                {
                    'id': '',
                    'full_name': ''
                }
            );
            for (var i = 0; i < objUsers.length; i++) {
                if (objUsers[i]['equipo_c'] == tempEquipo) {

                    arrayUsr.push(
                        {
                            'id': objUsers[i]['id'],
                            'full_name': objUsers[i]['full_name']
                        }
                    );
                    //console.log(objUsers[i]['full_name'] + "id " + objUsers[i]['id'] + " equipo " + objUsers[i]['equipo_c']);
                    //filterUsr += '<option value="' + objUsers[i]['id'] + '">' + objUsers[i]['full_name'] + '</option>';
                }
            }
            this.list_filter_usr = arrayUsr;
            this.render();
            this.selectOption(tempEquipo);

        }

    },

    setNotificationUsr: function () {

        var tempUsr = $("#states2").val();
        var comentario = this.$('.txtComent').val();
        var notification = app.data.createBean('Notifications');

        notification.set("description", comentario);
        notification.set("assigned_user_id", tempUsr);
        notification.set("name", 'FeedBack');
        notification.save();
        this.hideDivComment();
        this.getNotificationUsr();

    },

    selectOption: function (selectEquipo) {
        $('#states3').select2('val', selectEquipo);
        //$("#states3").val(selectEquipo);
        // this.render();
    },

    showDivComment: function () {
        var tempUsr = $("#states2").val();
        if (tempUsr == "" || tempUsr == null) {
        } else {
            this.$('div[data-name=div-Comment]').show();
        }
    },

    hideDivComment: function () {
        this.$('.txtComent').val("");
        this.$('div[data-name=div-Comment]').hide();
    },

    loadData: function (options) {
        if (_.isUndefined(this.model)) {
            return;
        }

        this.render();
    }


})
