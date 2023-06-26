({
        
    initialize: function(options) {
        this._super('initialize', [options]);

        this.model.on('sync', this.buildDataRegimenes, this);
        
    },
    
    buildDataRegimenes: function(){
        if( this.model.get("regimenes_fiscal_sat_c") != "" && this.model.get("regimenes_fiscal_sat_c") != null ){
            
            this.regimenes_list = JSON.parse( this.model.get("regimenes_fiscal_sat_c") );

            this.render();
        }
        
    },

    _render: function() {
        this._super('_render');
    
        if($('[data-fieldname="account_regimenes_fiscal"] > span').length >0){
            $('[data-fieldname="account_regimenes_fiscal"] > span').show();
        }
    },

})