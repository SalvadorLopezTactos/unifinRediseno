({
    plugins: ['Dashlet'],

    initialize: function (options) {
        this._super("initialize", [options]);
        self=this;
        //this.idAsesor="16ff1b17-a063-6fff-970f-5628f6e851a4";
        this.idAsesor=App.user.id;
        this.urlDisposiciones=App.config.url_micro_disposiciones;
        this.urlDisposicionesEquipoRegion=App.config.url_micro_disposiciones_equipo_region;

        var posicion_operativa=App.user.attributes.posicion_operativa_c;

        this.urlReporte=this.urlDisposiciones+'?IdAsesor='+this.idAsesor;    

        if(posicion_operativa.includes(1)){ //Director Equipo
            var equipo=App.user.attributes.equipo_c;
            this.urlReporte=this.urlDisposicionesEquipoRegion+'/MesActual_Equipo.html?IdEquipo='+equipo;
        } 
        if(posicion_operativa.includes(2)){ //Director Regional
            var region=App.user.attributes.region_c;
            this.urlReporte=this.urlDisposicionesEquipoRegion+'/MesActual_Region.html?IdRegion='+region;
        }

        
    },

    _render: function () {
        this._super("_render");
    }
})