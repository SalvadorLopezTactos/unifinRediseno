({
        
    initialize: function(options) {
        this._super('initialize', [options]);

        this.model.on('sync', this.buildDataRegimenes, this);
        
    },
    
    buildDataRegimenes: function(){
        if( this.model.get("regimenes_fiscal_sat_c") != "" && this.model.get("regimenes_fiscal_sat_c") != null ){
            
            this.regimenes_list = JSON.parse( this.model.get("regimenes_fiscal_sat_c") );
            if( this.regimenes_list.length > 0 ){
                for (let index = 0; index < this.regimenes_list.length; index++) {
                    var fechaInicio = this.regimenes_list[index]['startDate'];
                    fechaInicioFormat = this.formatDate( fechaInicio );
                    this.regimenes_list[index]['startDate'] = fechaInicioFormat;

                    var fechaFin = this.regimenes_list[index]['endDate'];
                    fechaFinFormat = this.formatDate( fechaFin );
                    this.regimenes_list[index]['endDate'] = fechaFinFormat; 
                }

            }

            this.render();
        }
        
    },

    formatDate: function( fecha ){

        var fecha_formateada = "";

        if( fecha !== null ){
            var fecha_parts = fecha.split('T');
            var fecha_unformat = fecha_parts[0].split('-');

            fecha_formateada = fecha_unformat[2] + "/" + fecha_unformat[1] + "/" + fecha_unformat[0];
        }

        return fecha_formateada;
        
    },

    _render: function() {
        this._super('_render');
    
        if($('[data-fieldname="account_regimenes_fiscal"] > span').length >0){
            $('[data-fieldname="account_regimenes_fiscal"] > span').show();
        }
    },

})