({
    extendsFrom: 'CreateView',
    initialize: function (options) {
        this._super('initialize', [options]);
        this.on('render', this.ocultaCampos, this);
        this.model.on('change:tct_preg_v_ddw', this.muestraCampos, this);
        this.model.on('change:tct_preg_w_ddw', this.muestraCampos, this);
    },
    
    ocultaCampos : function()
    {    
	if(this.model.get('tct_preg_v_ddw') === "No")
	{
  	$('[data-name="tct_cargo_publico_txf"]').hide();
    $('[data-name="tct_dependencia_txf"]').hide();
    $('[data-name="tct_periodo_txf"]').hide();
    $('[data-name="tct_fecha_inicio_dat"]').hide();
    $('[data-name="tct_fecha_termino_dat"]').hide();
    $('[data-name="tct_nombre_socio_txf"]').hide();
    }
	if(this.model.get('tct_preg_w_ddw') === "No")
	{
		$('[data-name="tct_especificar_parentsco_txf"]').hide();
    $('[data-name="tct_nombre_persona_puesto_txf"]').hide();
    $('[data-name="tct_nombre_accionista_rel_txf"]').hide();
    $('[data-name="tct_cargo_publico_fam_txf"]').hide();
    $('[data-name="tct_dependencia_fam_txf"]').hide();
    $('[data-name="tct_periodo_fam_txf"]').hide();
    $('[data-name="tct_fecha_inicio_fam_dat"]').hide();
    $('[data-name="tct_fecha_termino_fam_dat"]').hide();
    }
    },

    muestraCampos : function()
    {    
	if(this.model.get('tct_preg_v_ddw') === "Si")
	{
		$('[data-name="tct_cargo_publico_txf"]').show();
    $('[data-name="tct_dependencia_txf"]').show();
    $('[data-name="tct_periodo_txf"]').show();
    $('[data-name="tct_fecha_inicio_dat"]').show();
    $('[data-name="tct_fecha_termino_dat"]').show();
    $('[data-name="tct_nombre_socio_txf"]').show();
    }
  else
  {
  	$('[data-name="tct_cargo_publico_txf"]').hide();
    $('[data-name="tct_dependencia_txf"]').hide();
    $('[data-name="tct_periodo_txf"]').hide();
    $('[data-name="tct_fecha_inicio_dat"]').hide();
    $('[data-name="tct_fecha_termino_dat"]').hide();
    $('[data-name="tct_nombre_socio_txf"]').hide();
    }
	if(this.model.get('tct_preg_w_ddw') === "Si")
	{
		$('[data-name="tct_especificar_parentsco_txf"]').show();
    $('[data-name="tct_nombre_persona_puesto_txf"]').show();
    $('[data-name="tct_nombre_accionista_rel_txf"]').show();
    $('[data-name="tct_cargo_publico_fam_txf"]').show();
    $('[data-name="tct_dependencia_fam_txf"]').show();
    $('[data-name="tct_periodo_fam_txf"]').show();
    $('[data-name="tct_fecha_inicio_fam_dat"]').show();
    $('[data-name="tct_fecha_termino_fam_dat"]').show();
    }
  else
  {
		$('[data-name="tct_especificar_parentsco_txf"]').hide();
    $('[data-name="tct_nombre_persona_puesto_txf"]').hide();
    $('[data-name="tct_nombre_accionista_rel_txf"]').hide();
    $('[data-name="tct_cargo_publico_fam_txf"]').hide();
    $('[data-name="tct_dependencia_fam_txf"]').hide();
    $('[data-name="tct_periodo_fam_txf"]').hide();
    $('[data-name="tct_fecha_inicio_fam_dat"]').hide();
    $('[data-name="tct_fecha_termino_fam_dat"]').hide();
    }  
    }
})
