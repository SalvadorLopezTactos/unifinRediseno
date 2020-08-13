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
            //Prospecto
            if(this.model.get('etapa') == 1 && this.model.get('id') != undefined) {
              var newOptions = {
                  '1': 'Prospecto',
                  '2': 'Cotizando'
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
            //Presentación de Cotización al Cliente
            if(this.model.get('etapa') == 6) {
              var newOptions = {
                  '6': 'Presentación de Cotización al Cliente',
                  '7': 'Re-negociación',
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
            self.items = newOptions;
        }
        this._super('render');
    }
})