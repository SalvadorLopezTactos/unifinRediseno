({
    plugins: ['Dashlet'],

    initialize: function (options) {
        this._super("initialize", [options]);
        this.setRelacionesOtrosClientes();
    },

    _render: function () {
        this._super("_render");
    },

    setRelacionesOtrosClientes:function(){

        var id_cuenta=this.model.get('id');

        contextoRelaciones=this;
        App.alert.show('getRelacionesOtrosClientes', {
            level: 'process',
            title: 'Cargando',
        });
        app.api.call('GET', app.api.buildURL('Accounts/'+id_cuenta+'/link/accounts_rel_relaciones_1'), null, {
            success: function (data) {
                App.alert.dismiss('getRelacionesOtrosClientes');
                if(data.records.length>0){
                    contextoRelaciones.dataRelaciones=data.records;
                    for (let index = 0; index < data.records.length; index++) {
                        //Formateando fecha
                        var fecha=new Date(data.records[index].date_modified);
                        var dia=fecha.getDate();
                        var mes= ("0" + ( fecha.getMonth() + 1)).slice(-2);
                        var anio=fecha.getFullYear();

                        var hora=contextoRelaciones.formatAMPM(fecha);
                        
                        contextoRelaciones.dataRelaciones[index].date_modified = dia+"/"+mes+"/"+anio+" "+hora;
                    }
                    
                    contextoRelaciones.render();
                }
            },
            error: function (e) {
                throw e;
            }
        });
    },

    formatAMPM: function(fecha) {
        var hours = fecha.getHours();
        var minutes = fecha.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + '' + ampm;
        return strTime;
  }

    

})