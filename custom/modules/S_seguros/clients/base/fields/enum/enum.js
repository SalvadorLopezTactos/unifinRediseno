({
    extendsFrom: 'EnumField',

    initialize: function(options){
        this._super('initialize',[options]);
    },

    render: function() {
        var self = this;
        if (self.name === 'etapa') {
            //Creación
            if(this.model.get('etapa') == 1 && this.model.get('id') == undefined) {
              var newOptions = {
                  '1': 'Prospecto'
              };
            }
            //Prospecto Empresarial
            if(this.model.get('etapa') == 1 && this.model.get('id') != undefined && this.model.get('tipo_registro_sf_c') == 2) {
              var newOptions = {
                  '1': 'Prospecto',
                  '2': 'Cotizando'
              };
            }
            //Prospecto Individual
            if(this.model.get('etapa') == 1 && this.model.get('id') != undefined && this.model.get('tipo_registro_sf_c') == 1) {
              var newOptions = {
                  '1': 'Prospecto',
                  '11': 'Solicitud de Cotización'
              };
            }
            //Cotizando
            if(this.model.get('etapa') == 2) {
              var newOptions = {
                  '2': 'Cotizando'
              };
            }
            //En Revisión
            if(this.model.get('etapa') == 3) {
              var newOptions = {
                  '3': 'En Revisión',
                  '2': 'Cotizando'
              };
            }
            //Cotizado
            if(this.model.get('etapa') == 4) {
              var newOptions = {
                  '4': 'Cotizado',
                  '6': 'Presentación de Cotización al Cliente'
              };
            }
            //No Cotizado
            if(this.model.get('etapa') == 5) {
              var newOptions = {
                  '5': 'No Cotizado',
                  '6': 'Presentación de Cotización al Cliente'
              };
            }
            //Presentación de Cotización al Cliente Empresarial
            if(this.model.get('etapa') == 6 && this.model.get('tipo_registro_sf_c') == 2) {
              var newOptions = {
                  '6': 'Presentación de Cotización al Cliente',
                  '7': 'Re-negociación',
                  '9': 'Ganada',
                  '10': 'No Ganada'
              };
            }
            //Presentación de Cotización al Cliente Individual
            if(this.model.get('etapa') == 6 && this.model.get('tipo_registro_sf_c') == 1) {
              var newOptions = {
                  '6': 'Presentación de Cotización al Cliente',
                  '9': 'Ganada',
                  '10': 'No Ganada'
              };
            }
            //Re-negociación
            if(this.model.get('etapa') == 7) {
              var newOptions = {
                  '7': 'Re-negociación',
                  '8': 'Reenvío de Cotización'
              };
            }
            //Reenvio de Cotización
            if(this.model.get('etapa') == 8) {
              var newOptions = {
                  '8': 'Reenvio de Cotización',
                  '6': 'Presentación de Cotización al Cliente'
              };
            }
            //Ganada
            if(this.model.get('etapa') == 9) {
              var newOptions = {
                  '9': 'Ganada'
              };
            }
            //No Ganada
            if(this.model.get('etapa') == 10) {
              var newOptions = {
                  '10': 'No Ganada'
              };
            }
            //Solicitud de Cotización
            if(this.model.get('etapa') == 11) {
              var newOptions = {
                  '11': 'Solicitud de Cotización',
                  '4': 'Cotizado',
                  '5': 'No Cotizado'
              };
            }
            self.items = newOptions;
        }
        //Aseguradoras de UNI2
        // LOS ID'S DE LA LISTA comp_seguros_list TIENEN QUE CONINCIDIR CON LOS ID'S DE LA LISTA aseguradoras_list QUE SON LOS ID'S DE LA LISTA DE SALESFORCE
        // LA LISTA comp_seguros2_list ES EXCLUSIVA PARA UNI2 Y NO SE RELACIONA CON SALESFORCE
        if ((self.name === 'compania' || self.name === 'aseguradora_c') && this.model.get('seguro_uni2_c')) {
            var new_options = app.lang.getAppListStrings('comp_seguros2_list');
            self.items = new_options;
        }
        this._super('render');
    }
})